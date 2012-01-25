<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_Outbox extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function index() {
		$this->load->model('Siswa_model');
		$this->load->model('Orang_Tua_model');
		$this->load->model('Rate_model');
		$this->load->model('Invoice_model');
		$this->load->model('Outbox_model');
		$this->load->model('Invoice_Outbox_model');
		
		try {
			// dapatkan semua invoice yang melewati batas waktu pembayaran
			$list_due_invoices = $this->Invoice_model->get_all_due_date_invoice();
			
			// loop setiap invoice untuk dimasukkan ke outbox
			foreach ($list_due_invoices as $invoice) {
				$outbox = new Outbox();
				
				$msg_id = sprintf('%d.%d.%s',
									$invoice->get_id(),
									$invoice->rate->get_id(),
									$invoice->get_due_date()
						);
				$outbox->set_msgid($msg_id);
				$outbox->set_tanggal(date('Y-m-d H:i:s'));
				$outbox->set_tujuan($invoice->orang_tua->get_nosms());
				
				$pesan = sprintf('Siswa %s belum membayar %s senilai Rp%s',
								$invoice->siswa->get_namalengkap(),
								strtoupper($invoice->get_description()),
								number_format($invoice->sisa_bayar)
						);
				$outbox->set_isipesan($pesan);
				
				echo sprintf("Memasukkan Invoice ID %d ke outbox...", $invoice->get_id());
				try {
					$this->Outbox_model->insert($outbox);
					
					// insert ke ar_invoice_outbox agar invoicei ini tidak dikirim
					// ulang dimasa yang akan datang
					try {
						$invoice_out = new Invoice_Outbox();
						$invoice_out->set_invoice_id($invoice->get_id());
						$invoice_out->set_sent_date($outbox->get_tanggal());
						
						$this->Invoice_Outbox_model->insert($invoice_out);
					} catch (Exception $e) { }
					
					echo ("SUKSES <br/>\n");
				} catch (Exception $e) {
					echo ("GAGAL <br/>\n");
				}
			}
		} catch (InvoiceNotFoundException $e) {
			echo ('Tidak ada invoice yang melewati batas pembayaran.');
		}
	}
}
