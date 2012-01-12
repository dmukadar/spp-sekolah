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
		$this->data['ajax_siswa_url'] = site_url('tarif_khusus/get_ajax_siswa/10/');
		
		$this->proses_bayar($sess);
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
		
		// loop untuk setiap tagihan untuk diupdate
		foreach ($sess->tagihan as $tagihan_id) {
			// query dalam looping buruk? yeah... tapi untuk jumlah data
			// sedikit it's ok
			// let's get the job done first...
			try {
				$where = array('ar_invoice.id' => $tagihan_id);
				$tagihan = $this->Invoice_model->get_single_invoice($where);
				
				// untuk rollback
				$old_tagihan = clone $tagihan;
				
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
				
				// karena tidak menggunakan InnoDB maka database tidak dapat
				// digaransi ACID complaints dan integritas data masih dipertanyakan
				// maka upayakan dengan cara manual sebisa mungkin
				try {
					$payment = new Payment();
					$payment->set_id_employee($this->current_user->get_user_id());
					$payment->set_received_date(date('Y-m-d H:i:s'));
					$payment->set_amount($jml_bayar);
					// status?
					// @todo: set status berdasarkan ketentuan
					$payment->set_status(1);
					
					// simpan
					$this->Payment_model->insert($payment);
					
					$paymentdetail = new Payment_Detail();
					$paymentdetail->set_id_payment($payment->get_id());
					$paymentdetail->set_id_invoice($tagihan->get_id());
					$paymentdetail->set_amount($payment->get_amount());
					$paymentdetail->set_installment($tagihan->get_last_installment());
					$paymentdetail->set_status($payment->get_status());
					
					// simpan
					$this->Payment_Detail_model->insert($paymentdetail);
				} catch (Exception $e) {
					// ada kesalahan penyimpanan, rollback tagihan
					$this->Invoice_model->update($old_tagihan);
					$errors[] = $e->getMessage();
				}
			} catch (InvoiceNotFoundException $e) {
				// something bad...
				$errors[] = $e->getMessage();
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		} // foreach
		
		if (count($errors) > 0) {
			$errors = implode('<br/>', $errors);
			$this->set_flash_message($errors, 'error msg');
			return FALSE;
		}
		
		$this->set_flash_message('Pembayaran tagihan berhasil.');
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
	
	/**
	 * Method untuk mereset status dari invoice ber-id 1 dan dua
	 *
	 * WARNING: HANYA UNTUK TESTING!
	 */
	public function dev_reset() {
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
		';
		printf($script, base_url() . 'js/json.suggest.js', base_url() . 'js/jquery.chained.min.js');
	}
}
