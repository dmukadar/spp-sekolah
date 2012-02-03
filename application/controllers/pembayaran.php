<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembayaran extends Alazka_Controller {
	public function __construct() {
		parent::__construct();
		// $this->output->enable_profiler(FALSE);
	}
	
	public function index() {
		$this->load->model('Rate_model');
		$this->load->model('Invoice_model');
		
		// helper untuk melakukan repopulate checkbox, radio atau select
		$this->load->helper('mr_form');
		
		// Page title untuk HTML
		$this->data['page_title'] = 'Pembayaran Tagihan';
		
		// digunakan pada form action
		// membiarkan form action kosong bukanlah ide yang baik, dan itu
		// tergantung masing-masing browser implementasinya
		$this->data['action_url'] = site_url('pembayaran/index');
		
		// untuk repopulate combo box filter
		$sess = new stdClass();
		
		// apakah ini proses form post
		if ($this->input->post('showbtn')) {
			$sess->id_siswa = $this->input->post('siswa_id');
			$sess->nama_siswa = $this->input->post('siswa');
			$sess->no_induk = $this->input->post('rep-siswa-induk');
			$sess->kelas_jenjang = $this->input->post('rep-siswa-kelas');
		}
		
		// URL untuk Ajax auto complete
		$this->data['ajax_siswa_url'] = site_url('ajax/get_siswa/10/');
		
		if ($this->proses_bayar($sess) === TRUE) {
			// diarahkan ke data pembayaran jadi jangan diteruskan
			return TRUE;
		}
		$this->show_invoices($sess);
		
		$this->data['sess'] = $sess;
		
		$this->load->view('site/header_view');
		$this->load->view('site/pembayaran_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	private function show_invoices(&$sess) {
		$this->data['list_tagihan'] = array();
		
		if ($this->input->post('siswa_id') === FALSE) {
			if ($this->input->post('siswa_id-2') === FALSE) {
				return FALSE;
			}
		}
		
		try {
			$where = array(
					'ar_invoice.id_student' => (int)$sess->id_siswa,
			);
			$this->data['list_tagihan'] = $this->Invoice_model->get_all_open_invoice($where);
		} catch (InvoiceNotFoundException $e) {
			$this->set_flash_message('Tidak ada tagihan yang harus dibayar untuk siswa ini.');
			$this->data['list_tagihan'] = array();
		}
	}
	
	private function proses_bayar(&$sess) {
		if ($this->input->post('paybtn') === FALSE) {
			return FALSE;
		}
		$this->load->helper('mr_string');
		
		$sess->tagihan = $this->input->post('tagihan');	// tagihan yang dicentang
		$bayar = $this->input->post('bayar');
		$sess->bayar = $bayar;
		
		$sess->id_siswa = $this->input->post('siswa_id-2');
		$sess->nama_siswa = $this->input->post('siswa-2');
		$sess->no_induk = $this->input->post('rep-siswa-induk-2');
		$sess->kelas_jenjang = $this->input->post('rep-siswa-kelas-2');
		
		if ($sess->tagihan === FALSE) {
			$this->set_flash_message('Tidak ada tagihan yang dipilih.', 'warning msg');
			return FALSE;
		}
	
		$errors = array();
		
		$this->load->model('Payment_model');
		$this->load->model('Payment_Detail_model');
		
		$total = 0.0;
		// untuk rollback, yeah I know it sucks... we have todo manual rollback
		// since we're using MyISAM not InnoDB
		$old_tagihan = array();
		
		// daftar tagihan yang siap untuk dimasukkan payment
		// (tagihan tersebut berhasil diupdate)
		$tagihan_ok = array();
		
		// daftar payment_details object
		$payment_details = array();
		
		// loop untuk setiap tagihan untuk diupdate
		foreach ($sess->tagihan as $i=>$tagihan_id) {
			// query dalam looping buruk? yeah... tapi untuk jumlah data
			// sedikit it's ok
			// let's get the job done first...
			try {
				$where = array('ar_invoice.id' => $tagihan_id);
				$tagihan = $this->Invoice_model->get_single_invoice($where);
				
				// untuk rollback
				$old_tagihan[$i] = clone $tagihan;
				
				$jml_bayar = (double)mr_only_numeric($bayar[$tagihan_id]);
				
				// tidak ada pembayaran bernilai negatif, jadi ubah ke absolut
				$jml_bayar = abs($jml_bayar);
				
				// jangan proses jika yang jumlah pembayaran yang dikirim adalah NOL
				if ($jml_bayar == 0) {
					continue;
				}
				
				// apakah sisa bayar dikurangi dengan data bayar yg dipost
				// sama dengan NOL jika iya maka pembayaran tersebut lunas
				// set statusnya menjadi closed
				$status = Invoice_model::get_status_by_name('paid');
				$sisa_bayar = (double)$tagihan->sisa_bayar - $jml_bayar;
				if ($sisa_bayar <= 0) {
					$status = Invoice_model::get_status_by_name('closed');
				}
				$tagihan->set_status($status);
				
				// tambahkan jumlah yang sudah dibayar
				$terbayar = $tagihan->get_received_amount() + $jml_bayar;
				$tagihan->set_received_amount($terbayar);
								
				// increment cicilan
				$cicilan = $tagihan->get_last_installment() + 1;
				$tagihan->set_last_installment($cicilan);
				
				// ok folks, saatnya update!
				$this->Invoice_model->update($tagihan);
				
				// masukkan daftar tagihan_ok
				$tagihan_ok[$i] = $tagihan;
				
				// update nilai total (digunakan untuk tabel ar_payment)
				$total += $jml_bayar;
				
				// karena tidak menggunakan InnoDB maka database tidak dapat
				// digaransi ACID complaints dan integritas data masih dipertanyakan
				// maka upayakan dengan cara manual sebisa mungkin
				try {
					/*
					$payment = new Payment();
					$payment->set_id_employee($this->current_user->get_user_id());
					$payment->set_received_date(date('Y-m-d H:i:s'));
					$payment->set_amount($jml_bayar);
					$payment->set_status($tagihan->get_status());
					
					// simpan
					$this->Payment_model->insert($payment);
					*/
					$paymentdetail = new Payment_Detail();
					// payment_id kita set nanti
					$paymentdetail->set_id_payment(0);
					$paymentdetail->set_id_invoice($tagihan->get_id());
					$paymentdetail->set_amount($jml_bayar);
					
					// sisa yang harus dibayar untuk pembayaran saat ini adalah
					// sisa = (Biaya Tarif - Biaya Diterima) - Jml dibayar
					
					// Misal
					// =====
					// Post01 => 5.000
					
					// INV01 
					//   JML => 20.000
					//   RECV => iRECV + Post01 => 5.000

					// PAY01
					//   JML => 5.000
					//   REM => (iJML - iRECV) => 15.000
					
					// Post02 => 3.000
					
					// INV01
					//   JML => 20.000
					//   RECV => iRECV + Post02 => 8.000

					// PAY02
					//   JML =>  3.000
					//   REM => (iJML - iRECV) => 12.000
					
					$sisa = $tagihan->get_amount() - $tagihan->get_received_amount();
					$paymentdetail->set_remaining_amount($sisa);
					$paymentdetail->set_installment($tagihan->get_last_installment());
					$paymentdetail->set_status($tagihan->get_status());
					
					// simpan
					$this->Payment_Detail_model->insert($paymentdetail);
					
					$payment_details[$i] = clone $paymentdetail;
				} catch (Exception $e) {
					// ada kesalahan penyimpanan, rollback tagihan
					$errors[] = $e->getMessage();
				}
			} catch (InvoiceNotFoundException $e) {
				// something bad...
				$errors[] = $e->getMessage();
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		} // foreach
		
		// Manual Rollback
		$payment_lunas = TRUE;
		if (count($errors) > 0) {
			$this->rollback($old_tagihan, $payment_details, $payment_lunas);
			$this->set_flas_message(implode('<br/>', $errors), 'error msg');
			return FALSE;
		}
		
		// Saatnya memasukkan data pembayaran ke ar_payment
		// 1 kali pembayaran (multiple invoices) adalah 1 record di ar_payment
		// oleh karena itu kita letakkan rutin kode untuk memasukkan
		// record ke ar_payment diluar foreach loop seperti diatas.
		try {
			$payment = new Payment();
			$payment->set_id_employee($this->current_user->get_user_id());
			$payment->set_received_date(date('Y-m-d H:i:s'));
			$payment->set_amount($total);
			if ($payment_lunas === FALSE) {
				$payment->set_status(Invoice_model::get_status_by_name('paid'));
			} else {
				$payment->set_status(Invoice_model::get_status_by_name('closed'));
			}
			
			// insert
			$this->Payment_model->insert($payment);
			
			// update payment detail
			foreach ($payment_details as $pd) {
				$pd->set_id_payment($payment->get_id());
				$this->Payment_Detail_model->update($pd);
			}
		} catch (Exception $e) {
			$errors[] = $e->getMessage();
		}
		
		if (count($errors) > 0) {
			// rollback
			if ($payment->get_id() > 0) {
				$this->Payment_model->delete($payment);
			}
			
			$this->rollback($old_tagihan, $payment_details);
			$this->set_flas_message(implode('<br/>', $errors), 'error msg');
			return FALSE;
		}
		
		$message = sprintf('Pembayaran tagihan berhasil. <a href="%s">Cetak Sekarang</a>', site_url() . '/pembayaran/cetak/' . $payment->get_id());;
		$this->set_flash_message($message);
		
		// Factory POST - sesuai dengan apa yang diminta data_pembayaran untuk
		// simulasi form submit
		$_POST['showbtn'] = 'Tampil';
		$_POST['siswa_id'] = $sess->id_siswa;
		$_POST['siswa'] = $sess->nama_siswa;
		$_POST['rep-siswa-induk'] = $sess->no_induk;
		$_POST['rep-siswa-kelas'] = $sess->kelas_jenjang;

		$this->data_pembayaran();
		
		return TRUE;
	}
	
	private function rollback(&$old_tagihan, &$payment_details, &$payment_lunas=TRUE) {
		// update invoice ke semula
		foreach ($old_tagihan as $ot) {
			$this->Invoice_model->update($ot);
		}
		
		// delete payment detail
		foreach ($payment_details as $pd) {
			if ($payment_lunas === TRUE) {
				if ($pd->get_status() != Invoice_model::get_status_by_name('closed')) {
					// ada yang belum lunas, jadi nantinya payment statusnya bukan closed
					// tetapi 'open' atau 'paid'
					$payment_lunas = FALSE;
				}
			}
			$this->Payment_Detail_model->delete($pd);
		}
		return FALSE;
	}
	
	/**
	 * Method untuk menampilkan daftar pembayaran yang telah dilakukan.
	 *
	 * @author Rio Astamal
	 *
	 * @return void
	 */
	public function data_pembayaran() {
		$this->load->model('Payment_Detail_model');
		$this->load->model('Payment_model');
		
		// helper untuk melakukan repopulate checkbox, radio atau select
		$this->load->helper('mr_form');
		
		// Page title untuk HTML
		$this->data['page_title'] = 'Data Pembayaran';
		
		// digunakan pada form action
		// membiarkan form action kosong bukanlah ide yang baik, dan itu
		// tergantung masing-masing browser implementasinya
		$this->data['action_url'] = site_url('pembayaran/data_pembayaran');
		
		// untuk repopulate combo box filter
		$sess = new stdClass();
		
		// apakah ini proses form post
		if ($this->input->post('showbtn')) {
			$sess->id_siswa = $this->input->post('siswa_id');
			$sess->nama_siswa = $this->input->post('siswa');
			$sess->no_induk = $this->input->post('rep-siswa-induk');
			$sess->kelas_jenjang = $this->input->post('rep-siswa-kelas');
		}
		
		// URL untuk Ajax auto complete
		$this->data['ajax_siswa_url'] = site_url('ajax/get_siswa/10/');
		
		$this->data['ajax_payment_detail_url'] = site_url('pembayaran/ajax_payment_detail');
		
		$this->show_payments($sess);
		
		$this->data['sess'] = $sess;
		
		$this->load->view('site/header_view');
		$this->load->view('site/data_pembayaran_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	/**
	 * Private method untuk membuat daftar pembayaran yang akan ditampilkan
	 * Pada view.
	 *
	 * @author Rio Astamal
	 * 
	 * return void
	 */
	private function show_payments($sess) {
		$this->data['list_payments'] = array();
		$this->load->helper('mr_string');
		
		if ($this->input->post('siswa_id') === FALSE) {
			// repopulate untuk hidden form
			if ($this->input->post('siswa_id-2') === FALSE) {
				return FALSE;
			}
		}
		
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		try {
			$where = array(
					'ar_invoice.id_student' => (int)$sess->id_siswa,
			);
			$this->db->order_by('ar_payment.id', 'desc');
			$this->data['list_payments'] = $this->Payment_model->get_all_payment($where);
		} catch (PaymentNotFoundException $e) {
			$this->set_flash_message('Tidak ada pembayaran untuk siswa ini.');
			$this->data['list_payments'] = array();
		}
	}
	
	public function payment_detail_link($payment) {
		$link = '<a href="%s" onclick="return ajax_payment_detail(%d);" class="reply">%s</a> <a href="%s" class="reply">%s</a>';
		printf($link, 
				site_url() . '/pembayaran/detail/'  . $payment->get_id(),
				$payment->get_id(),
				'Detail',
				site_url() . '/pembayaran/cetak/' . $payment->get_id(),
				'Cetak'
		);
	}
	
	public function cetak($payment_id) {
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		$this->load->model('Invoice_model');
		$this->load->model('Payment_model');
		$this->load->model('Payment_Detail_model');
		$this->load->helper('mr_string');
		
		try {
			$payment_id = (int)$payment_id;
			$where = array('ar_payment.id' => $payment_id);
			$payment = $this->Payment_model->get_single_payment($where);
			$this->data['pembayaran'] = $payment;
			
			$where = array('ar_payment_details.id_payment' => $payment->get_id());
			$this->data['list_pembayaran'] = $this->Payment_Detail_model->get_all_payment_detail($where);
			
			$this->data['total_bayar'] = 0;
			
			$html = $this->load->view('site/cetak_pembayaran_view', $this->data, TRUE);
			// echo $html;
			
			$siswa_name = strtolower(preg_replace('/[^a-z\.\s]/i', '', $payment->siswa->get_namalengkap()));
			$siswa_name = str_replace(' ', '_', $siswa_name);
			$filename = $siswa_name . '_' . pad_zero($payment->get_id()) . '.pdf';
			$this->print_pdf($html, $filename);
		} catch (PaymentNotFoundException $e) {
			$this->set_flash_message('Error: Tidak ada pembayaran dengan ID tersebut.', 'error msg');
			$this->data_pembayaran();
			return FALSE;
		} catch (Payment_DetailNotFoundException $e) {
			$this->set_flash_message('Error: Tidak ada pembayaran dengan ID tersebut.', 'error msg');
			$this->data_pembayaran();
			return FALSE;
		}
	}
	
	public static function lunas_belumlunas($payment_details) {
		if ($payment_details->get_remaining_amount() == 0) {
			return '<strong>LUNAS</strong>';
		}
		
		return '<strong>BELUM LUNAS</strong>';
	}
	
	public function ajax_payment_detail($payment_id) {
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		$this->load->model('Invoice_model');
		$this->load->model('Payment_model');
		$this->load->model('Payment_Detail_model');
		$this->load->helper('mr_string');
		
		try {
			$payment_id = (int)$payment_id;
			$where = array('ar_payment.id' => $payment_id);
			$payment = $this->Payment_model->get_single_payment($where);
			$this->data['pembayaran'] = $payment;
			
			$where = array('ar_payment_details.id_payment' => $payment->get_id());
			$this->data['list_pembayaran'] = $this->Payment_Detail_model->get_all_payment_detail($where);
			
			$this->data['total_bayar'] = 0;
			
			$this->load->view('site/ajax_pembayaran_view', $this->data);
		} catch (PaymentNotFoundException $e) {
			$this->set_flash_message('Error: Tidak ada pembayaran dengan ID tersebut.', 'error msg');
			$this->data_pembayaran();
			return FALSE;
		} catch (Payment_DetailNotFoundException $e) {
			$this->set_flash_message('Error: Tidak ada pembayaran dengan ID tersebut.', 'error msg');
			$this->data_pembayaran();
			return FALSE;
		}
	}
	
	public static function indo_date($payment) {
		return date('d/m/Y', strtotime($payment->get_received_date()));
	}
	
	private function print_pdf($content, $filename) {
		$this->load->library('pdf');
		$this->pdf->setPageFormat('A5', 'L');
		$this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
		$this->pdf->SetKeywords('TCPDF, PDF');      
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
		$this->pdf->SetFont('times', '', 10);   
		$this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->pdf->AddPage(); 

		$this->pdf->writeHTML($content, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output($filename, 'I');  
	}
	
	/**
	 * Method untuk mencetak HTML attribut 'readonly="readonly"' jika
	 * jumlah last_installment + 1 sama dengan installment dari Rate
	 *
	 * @author Rio Astamal
	 *
	 * @param Invoice $tagihan - Instance dari object Invoice
	 * @return string
	 */
	public function installment_read_only($tagihan) {
		if (($tagihan->get_last_installment() + 1) == $tagihan->rate->get_installment()) {
			print 'readonly="readonly"';
		}
	}
	
	public function print_cicilan($tagihan) {
		if (($tagihan->get_last_installment() + 1) == $tagihan->rate->get_installment()) {
			print 'el="langsunglunas"';
		} else {
			print 'el="cicil"';
		}
	}
	
	/**
	 * Method untuk mereset status dari invoice ber-id 1 dan dua
	 *
	 * WARNING: HANYA UNTUK TESTING!
	 */
	public function dev_reset212() {
		$this->load->model('Invoice_model');
		$status_open = Invoice_model::get_status_by_name('open');
		$query = "UPDATE ar_invoice SET last_installment=0, received_amount=0, status='%s' ";
		$query = sprintf($query, $status_open);
		$this->db->query($query);
		$this->db->query("TRUNCATE TABLE ar_payment");
		$this->db->query("TRUNCATE TABLE ar_payment_details");
		$html = "<pre>Menjalankan Query: \n%s\nTRUNCATE TABLE ar_payment\nTRUNCATE TABLE ar_payment_details</pre><br/><p>Gunakan Nama siswa dibawah ini untuk test pembayaran.</p><a href=\"%s\">Kembali</a>.";
		printf($html, $query, site_url() . '/pembayaran/index');
		$query = "SELECT namalengkap FROM sis_siswa
					WHERE id IN (
					SELECT DISTINCT(id_student) FROM ar_invoice
				)";
		$result = $this->db->query($query)->result_array();
		print('<pre>');
		print_r($result);
		print('</pre>');
	}
	
	/**
	 * Method untuk menambahkan javascript baru pada HEAD
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return void
	 */
	public function add_more_javascript() {
		$script = '
		<script type="text/javascript" src="%s"></script>
		<script type="text/javascript" src="%s"></script>
		<script type="text/javascript" src="%s"></script>
		';
		printf($script, 
				base_url() . 'js/json.suggest.js', 
				base_url() . 'js/jquery.simplemodal.1.4.2.min.js',
				base_url() . 'js/autoNumeric-1.7.4.js'
		);
	}
	
	public function add_more_css() {
		$css = '<link rel="stylesheet" type="text/css" href="%s" />';
		printf($css, base_url() . 'css/simplemodal_basic.css');
	}
}
