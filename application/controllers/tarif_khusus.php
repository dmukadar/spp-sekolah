<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarif_khusus extends Alazka_Controller {
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
	public function index() {
		$this->load->model('Rate_model');
		$this->load->model('Custom_Rate_model');
		
		// helper untuk melakukan repopulate checkbox, radio atau select
		$this->load->helper('mr_form');
		
		// Page title untuk HTML
		$this->data['page_title'] = 'Data Dispensasi';
		
		// URL untuk Ajax
		$this->data['ajax_siswa_url'] = site_url('tarif_khusus/get_ajax_siswa/10/');
		
		// digunakan pada form action
		// membiarkan form action kosong bukanlah ide yang baik, dan itu
		// tergantung masing-masing browser implementasinya
		$this->data['action_url'] = site_url('tarif_khusus/tambah');
		
		if ($this->input->post('tagihan') === FALSE) {
			$sess = new stdClass();
			$sess->tagihan = 0;
			$this->data['sess'] = $sess;
		}
		
		// dapatkan semua tarif
		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}
		
		$this->load->view('site/header_view');
		$this->load->view('site/tarif_khusus_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	/**
	 * Method untuk memproses data tarif khusus yang di-post via form.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 * @todo: - Pesan error form validasi diganti bahasa indonesia.
	 *
	 * @return void
	 */
	public function tambah() {
		// lakukan form validasi
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('tagihan', 'Tagihan', 'required|numeric');
		$this->form_validation->set_rules('siswa', 'Siswa', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
		
		$sess = new stdClass();
		$sess->id = $this->input->post('siswa_id');
		$sess->tagihan = $this->input->post('tagihan');
		$sess->nama_siswa = $this->input->post('siswa');
		$sess->jumlah = $this->input->post('jumlah');
		$sess->no_induk = $this->input->post('rep-siswa-induk');
		$sess->kelas_jenjang = $this->input->post('rep-siswa-kelas');
		$this->data['sess'] = $sess;
		
		// jalankan pengecekan
		if ($this->form_validation->run() == FALSE) {
			// oops, sepertinya salah satu field tidak memenuhi kriteria
			// tampilkan pesannya ke user
			$this->set_flash_message(validation_errors('<span>', '</span><br/>'), 'error msg');
			
			// kembalikan ke index()
			$this->index();
			
			// karena ada sesuatu yang salah, tidak perlu melanjutkan ke 
			// proses penyimpanan
			return FALSE;
		}
		
		$this->load->model('Siswa_model');
		$this->load->model('Kelas_model');
		
		// apakah siswa yang ingin disimpan ada didatabase?
		try {
			$where = array('sis_siswa.id' => $sess->id);
			$siswa = $this->Siswa_model->get_single_siswa($where);
			
			// oke siswa ada dan aktif, waktunya menyimpan...
			$this->load->model('Custom_Rate_model');
			
			$custrate = new Custom_Rate();
			$custrate->set_id_rate($sess->tagihan);
			$custrate->set_id_student($sess->id);
			$custrate->set_fare($sess->jumlah);
			
			// insert ke tabel
			$this->Custom_Rate_model->insert($custrate);
			
			$mesg = sprintf('Siswa <strong>%s</strong> berhasil dimasukkan ke data tarif khusus.', $siswa->get_namalengkap());
			$this->set_flash_message($mesg, 'information msg');
			
			// clear repopulate form session
			$this->data['sess'] = new stdClass();
		} catch (SiswaNotFoundException $e) {
			$this->set_flash_message('Mohon maaf, siswa tersebut tidak ditemukan di database, coba lagi.', 'error msg');
		} catch (Exception $e) {
			$this->set_flash_message('Mohon maaf, terjadi error saat penyimpan, coba lagi.', 'error msg');
		}
		
		$this->index();
	}
	
	/**
	 * Method untuk menampilkan form edit pada data tarif khusus
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param int $id_tarif - ID dari tarif khusus yang akan diedit
	 * @return void
	 */
	public function edit($id_tarif) {
		$this->load->model('Rate_model');
		$this->load->model('Custom_Rate_model');
		
		// helper untuk melakukan repopulate checkbox, radio atau select
		$this->load->helper('mr_form');
		
		// Page title untuk HTML
		$this->data['page_title'] = 'Edit Data Dispensasi';
		
		// URL untuk Ajax
		$this->data['ajax_siswa_url'] = site_url('tarif_khusus/get_ajax_siswa/10/');
		
		// digunakan pada form action
		// membiarkan form action kosong bukanlah ide yang baik, dan itu
		// tergantung masing-masing browser implementasinya
		$this->data['action_url'] = site_url('tarif_khusus/proses_edit');
		
		if ($this->input->post('tagihan') === FALSE) {
			$sess = new stdClass();
			$sess->tagihan = 0;
			$this->data['sess'] = $sess;
		}
		
		try {
			$where = array('ar_custom_rate.id' => $id_tarif);
			$custrate = $this->Custom_Rate_model->get_single_custom_rate($where);
			
			$this->load->model('Kelas_model');
			$this->load->model('Siswa_model');
			
			$where = array('sis_siswa.id' => $custrate->get_id_student());
			$siswa = $this->Siswa_model->get_single_siswa($where);
		} catch (Custom_RateNotFoundException $e) {
			// data tarif tidak ditemukan, tampilkan form insert
			$this->set_flash_message('FATAL ERROR: Data dispensasi yang akan diedit tidak ditemukan.', 'error msg');
			
			$this->index();
			
			return FALSE;
		} catch (SiswaNotFoundException $e) {
			// data tarif tidak ditemukan, tampilkan form insert
			$this->set_flash_message('FATAL ERROR: Data siswa tidak ditemukan.', 'error msg');
			
			$this->index();
			
			return FALSE;
		}
		
		// repopulate old data
		$sess = new stdClass();
		$sess->custom_rate_id = $custrate->get_id();
		$sess->id = $siswa->get_id();
		$sess->tagihan = $custrate->get_id_rate();
		$sess->nama_siswa = $siswa->get_namalengkap();;
		$sess->jumlah = round($custrate->get_fare());
		$sess->no_induk = $siswa->get_noinduk();
		$sess->kelas_jenjang = sprintf('%s (%s)', $siswa->kelas->get_kelas(), $siswa->kelas->get_jenjang());
		$this->data['sess'] = $sess;
		
		// dapatkan semua tarif
		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}
		
		$this->load->view('site/header_view');
		$this->load->view('site/tarif_khusus_update_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	/**
	 * Method untuk memproses form edit tarif khusus
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return void
	 */
	public function proses_edit() {
		// lakukan form validasi
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('tagihan', 'Tagihan', 'required|numeric');
		$this->form_validation->set_rules('siswa', 'Siswa', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
		
		$sess = new stdClass();
		$sess->custom_rate_id = $this->input->post('custom-rate-id');
		$sess->id = $this->input->post('siswa_id');
		$sess->tagihan = $this->input->post('tagihan');
		$sess->nama_siswa = $this->input->post('siswa');
		$sess->jumlah = $this->input->post('jumlah');
		$sess->no_induk = $this->input->post('rep-siswa-induk');
		$sess->kelas_jenjang = $this->input->post('rep-siswa-kelas');
		$this->data['sess'] = $sess;
		
		// jalankan pengecekan
		if ($this->form_validation->run() == FALSE) {
			// oops, sepertinya salah satu field tidak memenuhi kriteria
			// tampilkan pesannya ke user
			$this->set_flash_message(validation_errors('<span>', '</span><br/>'), 'error msg');
			
			// kembalikan ke index()
			$this->edit($sess->custom_rate_id);
			
			// karena ada sesuatu yang salah, tidak perlu melanjutkan ke 
			// proses penyimpanan
			return FALSE;
		}
		
		try {
			$this->load->model('Rate_model');
			$this->load->model('Custom_Rate_model');
			
			// check 
			$where = array('ar_custom_rate.id' => $sess->custom_rate_id);
			$custrate = $this->Custom_Rate_model->get_single_custom_rate($where);
			
			$custrate->set_id_student($sess->id);
			$custrate->set_id_rate($sess->tagihan);
			$custrate->set_fare($sess->jumlah);
			
			// exlude property rate pada object karena tidak diperlukan saat update
			$exclude = array('rate');	
			
			// update custom_rate
			$this->Custom_Rate_model->update($custrate, $exclude);
			
			$mesg = sprintf('Data dispensasi untuk siswa %s berhasil disimpan.', $sess->nama_siswa);
			$this->set_flash_message($mesg, 'information msg');
		} catch (Custom_RateNotFoundException $e) {
			$this->set_flash_message('FATAL ERROR: Data dispensasi yang akan disimpan tidak ditemukan.', 'error msg');
		} catch (Exception $e) {
			$this->set_flash_message('Mohon maaf, terjadi error saat penyimpan, coba lagi.', 'error msg');
		}
		
		$this->edit($sess->custom_rate_id);
	}

	/**
	 * Method untuk menampilkan data yang digunakan pada autocomplete siswa.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return string - JSON
	 */
	public function get_ajax_siswa($limit=10) {
		$limit = (int)$limit;
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		
		// ?search=namasiswa yang dipanggil oleh AJAX
		$nama = $this->input->get('search');
		try {
			$daftar_siswa = $this->Siswa_model->get_all_siswa_ajax($nama, $limit);
			$json = array();
			foreach ($daftar_siswa as $siswa) {
				$sis = new stdClass();
				$sis->id = $siswa->get_id();
				$sis->text = sprintf('%s &raquo; %s (%s)', $siswa->get_namalengkap(), $siswa->kelas->get_kelas(), $siswa->kelas->get_jenjang());
				$sis->nama = $siswa->get_namalengkap();
				$sis->noinduk = $siswa->get_noinduk();
				$sis->kelas = $siswa->kelas->get_kelas();
				$sis->jenjang = $siswa->kelas->get_jenjang();
				$json[] = $sis;
			}
			$json = json_encode($json);
			print($json);
		} catch (SiswaNotFoundException $e) {
		}
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
