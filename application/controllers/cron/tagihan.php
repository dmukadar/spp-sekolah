<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//script ini akan membuat tagihan berdasarkan kelompok tagih (ar_group_student, ar_group_class)
//untuk dijalankan sebulan sekali, 
//skrip akan mendeteksi tagihan yg perlu dimasukkan (sekali, tahunan, semesteran, bulanan)
//skrip akan mencegah siswa dengan nomor induk yg sama ditagih lebih dari sepantasnya (spp hanya 1x tiap bulan, dll)
class Tagihan extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();

		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		$this->load->model('Rate_model');
		$this->load->model('Custom_Rate_model');
		$this->load->model('Invoice_model');
		$this->load->model('ClassGroup_model');
		$this->load->model('StudentGroup_model');
		$this->load->model('TahunAkademik_model');
	}
	
	public function index() {
		$errors = array();
		$success = array();

		//proses student group dulu
		try {
			$students = $this->StudentGroup_model->get_all_studentgroup(array(), -1, 0, 'id_rate');

			//tiap student yg ada
			foreach ($students as $s) {
				//buatkan tagihannya (validasi)
				list($valid, $tagihan) = $this->create($s->get_id_rate(), $s->get_id_student());

				//jika error laporkan
				if (! $valid) $errors = array_merge($errors, $tagihan);
				else {
					//jika tidak error simpan
					list($status, $message) = $this->simpan($tagihan);
					if ($status == true) {
						array_push($success, $message);
					} else {
						array_push($errors, $message);
					}
				}
			}
		} catch (StudentGroupNotFoundException $e) {
			array_push($errors, 'kelompok tagih siswa tidak ditemukan');
		}

		//selanjutkan proses class group
		try {
			//tarik semua kelas
			$classes = $this->ClassGroup_model->get_all_classgroup(array(), -1, 0, 'id_rate');

			//untuk tiap kelas, tarik data siswanya
			foreach ($classes as $c) {
				try {
					$students = $this->Siswa_model->get_all_siswa(array('sis_siswa.dm_kelas_id'=>$c->get_id_class(), 'sis_siswa.dm_statussiswa_id'=>1));

					//tiap data siswa proses
					foreach ($students as $s) {
						list($valid, $tagihan) = $this->create($c->get_id_rate(), $s->get_id());
						if (! $valid) {
							$errors = array_merge($errors, $tagihan);
						} else {
								list($status, $message) = $this->simpan($tagihan);
								if ($status == true) {
									array_push($success, $message);
								} else {
									array_push($errors, $message);
								}
						}
					}

				} catch (SiswaNotFoundException $e) {
					//do nothing, process next class
				}
			};

		} catch (ClassGroupNotFoundException $e) {
			array_push($errors, 'kelompok tagih kelas tidak ditemukan');
		}

		echo "automatic invoice script running @" . date('Y-m-d H:i:s') . "\n-----------Error status------------\n";
		if (!empty($errors)) echo implode("\n", $errors);
		echo "\n-----------------Success status ----------------\n";
		if (!empty($success)) echo implode("\n", $success);
	}
	private function simpan($invoice) {
		if ($id = $this->Invoice_model->insert($invoice)) return array(true, sprintf('id: %d, nomor invoice: %s', $id, $invoice->get_code()));
		else return array(false, sprintf('gagal menyimpan invoice %s', $invoice->get_code()));
	}
	private function create($id_rate, $id_student) {
				$errors = array();
				$siswa = $tarif = $tagihan = null;
				try {
					$tarif = $this->Rate_model->find_by_pk($id_rate);
				} catch (RateNotFoundException $e) {
					array_push($errors, sprintf('Tagihan id: %d tidak ditemukan', $id_rate));
					return array(false, $errors);
				}
				try {
					$siswa = $this->Siswa_model->get_single_siswa(array('sis_siswa.id'=>$id_student, 'sis_siswa.dm_statussiswa_id'=>1));
				}
				catch (SiswaNotFoundException $e) {
					array_push($errors, sprintf('Siswa id: %d tidak ditemukan', $id_student));
					return array(false, $errors);
				}
				try {
					$dispensasi = $this->Custom_Rate_model->get_single_custom_rate(array('id_rate'=>$id_rate, 'id_student'=>$id_student));

					$tarif->set_fare($dispensasi->get_fare());
				} catch (Custom_RateNotFoundException $e) {
					//do nothing
				}
				if (!empty($tarif)) {
					$tagihan = new Invoice;
					$tagihan->set_id_rate($id_rate);
					$tagihan->set_id_student($id_student);
					$tagihan->set_amount($tarif->get_fare());
					switch ($tarif->get_recurrence()) {
						case 'bulan': 
							$waktu = $this->TahunAkademik_model->berjalan->get_bulan('nama') . ' ' . $this->TahunAkademik_model->berjalan->get_tahun();
							break;
						case 'semester': 
							$waktu   = $this->TahunAkademik_model->berjalan->get_semester('label') . ' ' . $this->TahunAkademik_model->berjalan->get_tahun();
							break;
						default: $waktu  =  $this->TahunAkademik_model->berjalan->get_tahun();
					}
					$tagihan->set_description($tarif->get_name() . ' ' . $waktu);

					$tagihan->rate = $tarif;
					$tagihan->siswa = $siswa;

					$code = $tagihan->generate_code($this->TahunAkademik_model->berjalan);

					try {
						$prevInvoice = $this->Invoice_model->get_single_invoice(array('ar_invoice.code'=>$code));
						if (!empty($prevInvoice)) array_push($errors, $tarif->get_name() . ' sudah pernah ditagih dengan nomor invoice "' . $prevInvoice->get_code()  . '"');
					} catch (InvoiceNotFoundException $e) {
						//good to go
						$tagihan->set_code($code);
					}
				}
				if (empty($errors)) return array(true, $tagihan);
				else return array(false, $errors);
	}
}
