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
		$this->load->model('Siswa_model');
		$this->load->model('Kelas_model');
		
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
		
		// dapatkan semua tarif
		try {
			$this->db->order_by('ar_custom_rate.created', 'desc');
			$this->data['list_dispensasi'] = $this->Custom_Rate_model->get_all_custom_rate();
		} catch (Exception $e) {
			$this->data['list_dispensasi'] = array();
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
		$this->load->model('Siswa_model');
		$this->load->model('Kelas_model');
		
		// lakukan form validasi
		$this->load->library('form_validation');
		
		// agar form validation mendeteksi kosong pada jumlah_mask, karena
		// default adalah 0 (tidak empty)
		if ($_POST['jumlah_mask'] == 0) {
			unset($_POST['jumlah_mask']);
		}
		
		$this->form_validation->set_rules('tagihan', 'Tagihan', 'required|numeric');
		$this->form_validation->set_rules('siswa', 'Siswa', 'required');
		$this->form_validation->set_rules('jumlah_mask', 'Jumlah', 'required|numeric');
		
		$sess = new stdClass();
		$sess->id = $this->input->post('siswa_id');
		$sess->tagihan = $this->input->post('tagihan');
		$sess->nama_siswa = $this->input->post('siswa');
		$sess->jumlah = $this->input->post('jumlah_mask');
		$sess->no_induk = $this->input->post('rep-siswa-induk');
		$sess->kelas_jenjang = $this->input->post('rep-siswa-kelas');
		$this->data['sess'] = $sess;
		
		// jalankan pengecekan
		if ($this->form_validation->run() == FALSE) {
			// oops, sepertinya salah satu field tidak memenuhi kriteria
			// tampilkan pesannya ke user
			$this->set_flash_message(validation_errors('<span>', '</span><br/>'), 'error msg');
			
			// kembalikan ke index()
			// $this->index();
			
			$this->print_flash_message();
			
			// karena ada sesuatu yang salah, tidak perlu melanjutkan ke 
			// proses penyimpanan
			return FALSE;
		}
		
		// apakah ini proses edit?
		$id_custom_rate = $this->input->post('custom-rate-id');
		if ($id_custom_rate > 0) {
			$this->proses_edit();
			return FALSE;
		}
		
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
			
			$mesg = sprintf('Siswa <strong>%s</strong> berhasil dimasukkan ke data dispensasi.', $siswa->get_namalengkap());
			$this->set_flash_message($mesg, 'information msg');
			
			// clear repopulate form session
			$this->data['sess'] = new stdClass();
		} catch (SiswaNotFoundException $e) {
			$this->set_flash_message('Mohon maaf, siswa tersebut tidak ditemukan di database, coba lagi.', 'error msg');
		} catch (Exception $e) {
			$this->set_flash_message('Mohon maaf, terjadi error saat penyimpan, coba lagi.', 'error msg');
		}
		
		// $this->index();
		$this->print_flash_message();
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
		$this->form_validation->set_rules('jumlah_mask', 'Jumlah', 'required|numeric');
		
		$sess = new stdClass();
		$sess->custom_rate_id = $this->input->post('custom-rate-id');
		$sess->id = $this->input->post('siswa_id');
		$sess->tagihan = $this->input->post('tagihan');
		$sess->nama_siswa = $this->input->post('siswa');
		$sess->jumlah = $this->input->post('jumlah_mask');
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
			$exclude = array('rate', 'siswa', 'kelas');	
			
			// update custom_rate
			$this->Custom_Rate_model->update($custrate, $exclude);
			
			$mesg = sprintf('Data dispensasi untuk siswa %s berhasil disimpan.', $sess->nama_siswa);
			$this->set_flash_message($mesg, 'information msg');
		} catch (Custom_RateNotFoundException $e) {
			$this->set_flash_message('FATAL ERROR: Data dispensasi yang akan disimpan tidak ditemukan.', 'error msg');
		} catch (Exception $e) {
			$this->set_flash_message('Mohon maaf, terjadi error saat penyimpan, coba lagi.', 'error msg');
		}
		
		$this->print_flash_message();
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
	
	public function delete() {
		if ($this->input->post('id') === FALSE) {
			redirect('/tarif_khusus');
		}
		
		$this->load->model('Rate_model');
		$this->load->model('Custom_Rate_model');
		$this->load->model('Siswa_model');
		$this->load->model('Kelas_model');
		
		// apakah data id yang akan dihapus exists
		try {
			$where = array('ar_custom_rate.id' => (int)$this->input->post('id'));
			$tarif = $this->Custom_Rate_model->get_single_custom_rate($where);
			
			$this->Custom_Rate_model->delete($tarif);
			
			$this->set_flash_message(sprintf('Data dispensasi untuk siswa %s berhasil dihapus.', $tarif->siswa->get_namalengkap()), 'information msg');
		} catch (Custom_RateNotFoundException $e) {
			$this->set_flash_message('Data yang akan dihapus tidak ditemukan.', 'error msg');
		} catch (Exception $e) {
			$this->set_flash_message('Gagal menghapus data. ' . $e->getMessage(), 'error msg');
		}
		
		$this->print_flash_message();
	}
	
	public function info() {
		if ($this->input->post('id') === FALSE) {
			return FALSE;
		}
		header('Content-type: application/json');
		
		$this->load->model('Rate_model');
		$this->load->model('Custom_Rate_model');
		$this->load->model('Siswa_model');
		$this->load->model('Kelas_model');
		try {
			$where = array('ar_custom_rate.id' => (int)$this->input->post('id'));
			$tarif = $this->Custom_Rate_model->get_single_custom_rate($where);
			
			$json = array();
			$json['sucess'] = TRUE;
			$json['custom_rate'] = $tarif->export('object', array('siswa', 'rate', 'kelas'));
			$json['siswa'] = $tarif->siswa->export('object');
			$json['kelas'] = $tarif->kelas->export('object');
			
			echo json_encode($json);
		} catch (Custom_RateNotFoundException $e) {
			$this->set_flash_message('Error: Data yang akan diubah tidak ditemukan.', 'error msg');
			$json['sucess'] = FALSE;
			$json['message'] = $this->print_flash_message(TRUE);
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
		<script type="text/javascript" src="%s"></script>
		<script type="text/javascript" src="%s"></script>';
		printf($script, 
				base_url() . 'js/json.suggest.js',
				base_url() . 'js/autoNumeric-1.7.4.js'
		);
	}
 
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
