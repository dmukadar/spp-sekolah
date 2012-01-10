<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_Tarif_khusus extends Alazka_Controller {
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Method untuk menampilkan daftar tarif. Ini adalah hasil modifikasi agar
	 * sesuai dengan konvensi, mulai model dan viewnya.
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return void
	 */
	public function index($id_siswa=0) {
		$this->load->model('Rate_model');
		$this->load->model('Custom_Rate_model');
		
		// helper untuk melakukan repopulate checkbox, radio atau select
		$this->load->helper('mr_form');
		
		// Page title untuk HTML
		$this->data['page_title'] = 'Data Tarif Khusus';
		
		// URL untuk Ajax
		$this->data['ajax_siswa_url'] = site_url('tarif_khusus/get_ajax_siswa/10/');
		
		// digunakan pada form action
		// membiarkan form action kosong bukanlah ide yang baik, dan itu
		// tergantung masing-masing browser implementasinya
		$this->data['action_url'] = site_url('data_tarif_khusus/index');

		if ($id_siswa != 0) {
			$this->load->model('Kelas_model');
			$this->load->model('Siswa_model');
			try {
				$where = array('sis_siswa.id' => $id_siswa);
				$siswa = $this->Siswa_model->get_single_siswa($where);
				
				$sess = new stdClass();
				$sess->id = $id_siswa;
				$sess->nama_siswa = $siswa->get_namalengkap();
				$sess->no_induk = $siswa->get_noinduk();
				$sess->kelas_jenjang = sprintf('%s (%s)', $siswa->kelas->get_kelas(), $siswa->kelas->get_jenjang());
				$this->data['sess'] = $sess;
				
				$where = array('ar_custom_rate.id_student' => $siswa->get_id());
				$this->data['list_tarif_khusus'] = $this->Custom_Rate_model->get_all_custom_rate($where);
			} catch (SiswaNotFoundException $e) {
				$this->set_flash_message('Siswa dengan ID yang dicari tidak ditemukan.', 'warning msg');
				$this->data['sess'] = new stdClass();
			} catch (Custom_RateNotFoundException $e) {
				$this->set_flash_message('Belum ada tagihan khusus untuk siswa ini.', 'warning msg');
				$this->data['list_tarif_khusus'] = array();
			}
		} else {
			$this->data['list_tarif_khusus'] = array();
		}
		
		$this->load->view('site/header_view');
		$this->load->view('site/data_tarif_khusus_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	/**
	 * Method untuk menghapus tarf khusus.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param int $id - ID dari tarif khusus yang akan dihapus
	 * @param string $hash - MD5 hash dari $id, ini untuk mencegah kesalahan pengetikan pada URL
	 * @return void
	 */
	public function delete($id_tarif=0, $hash='') {
		$id = (int)$id_tarif;
		$this->load->model('Rate_model');
		$this->load->model('Custom_Rate_model');
		
		// cari terlebih dulu tarif yang akan dihapus ada atau tidak
		try {
			$where = array('ar_custom_rate.id' => $id);
			$custrate = $this->Custom_Rate_model->get_single_custom_rate($where);
			
			// ID ditemukan cocokkan hashnya
			if (md5($id) !== $hash) {
				throw new Exception ('Hash yang dimasukkan tidak cocok.');
			}
			
			// semua masih ok2 saja, jadi lakukan penghapusan sekarang
			$this->Custom_Rate_model->delete($custrate);
			
			$this->set_flash_message('Data tarif khusus berhasil dihapus.');
			
			$this->index($custrate->get_id_student());
			
			return FALSE;
		} catch (Custom_RateNotFoundException $e) {
			$this->set_flash_message('Maaf, tagihan khusus yang hendak anda hapus tidak ditemukan.', 'error msg');
		} catch (Exception $e) {
			$this->set_flash_message($e->getMessage(), 'error msg');
		}
		
		$this->index();
	}

	/**
	 * Method untuk menampilkan link edit sesuai dengan ID dari tarif khusus. Method
	 * biasanya digunakan pada view.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param Rate $tarif - Instance dari object Custom_Rate
	 * @return string
	 */
	public function get_edit_link($tarif) {
		return site_url('tarif_khusus/edit/' . $tarif->get_id());
	}
	
	/**
	 * Method untuk menampilkan link edit sesuai dengan ID dari tarif khusus. Method
	 * biasanya digunakan pada view.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param Rate $tarif - Instance dari object Custom_Rate
	 * @return string
	 */
	public function get_delete_link($tarif) {
		return site_url('data_tarif_khusus/delete/' . $tarif->get_id()) . '/' . md5($tarif->get_id());
	}
	
	/**
	 * Method untuk menambahkan CSS baru pada HEAD
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return void
	 */
	public function add_more_css() {
	}

	/**
	 * Method untuk menambahkan javascript baru pada HEAD
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return void
	 */
	public function add_more_javascript() {
		$script = '<!-- Autocomplete diambil dari http://tomcoote.co.uk/javascript/jquery-json-suggestsearch-box-v2/ -->
		<script type="text/javascript" src="%s"></script>';
		printf($script, base_url() . 'js/json.suggest.js');
	}
 
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
