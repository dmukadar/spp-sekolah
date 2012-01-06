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
		$this->data['page_title'] = 'Daftar Tarif Khusus';
		
		
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
		$sess->tagihan = $this->input->post('tagihan');
		$sess->nama_siswa = $this->input->post('siswa');
		$sess->jumlah = $this->input->post('jumlah');
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
		
		$this->set_flash_message('OK BRO...', 'information msg');
		
		$this->index();
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
		
		try {
			$daftar_siswa = $this->Siswa_model->get_all_siswa_ajax('achmad', $limit);
			$json = array();
			foreach ($daftar_siswa as $siswa) {
				$sis = new stdClass();
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
/*
	public function index()
	{
		$this->load->model('Vtarif_khusus_model');
		$data['view']='form';
		$no_induk=$this->input->post('tx_induk');
		if(!empty($no_induk)){
			$data['view']='data';
			$data['data_mas03']=$this->Vtarif_khusus_model->get_all(array('sis_siswa.noinduk' => $no_induk));
		}
		
		$data['page']='index';
		$this->load->view('site/header_view');
		$this->load->view('site/tarif_khusus_view',$data);
		$this->load->view('site/footer_view');
	}
*/ 
	
	function ajax_get_siswa(){
		$this->load->model('Vtarif_khusus_model');
		$get_data=$this->input->get("text");		
		
		$data_mas03=$this->Vtarif_khusus_model->get_siswa($get_data);
		
		$data=array();
		$index=0;
		foreach($data_mas03->result() as $row){		
			echo $row->namalengkap."|".$row->id."|".$row->namakelas."|".$row->noinduk."\n";
		}
		
	}
	
	function update_data($id=0){
	$this->load->model('Vtarif_khusus_model');
		$data['data_mas03']=$this->Vtarif_khusus_model->get_all(array('id'=>$id));
		 $data['page']='tarif_khusus_view';
		$this->load->view('site/tarif_khusus_view',$data);		
	}
	
	 
	public function act_update_data($id=0){
	$this->load->model('Vtarif_khusus_model');
		$data=array(			
			'category'=>$this->input->post('tx_kategori'), 
			'name'=>$this->input->post('tx_tagihan'), 
			'fare'=>$this->input->post('tx_jumlah'), 
			'description'=>$this->input->post('tx_ket'), 		
		);
		$status=$this->M_mas01->update($id,$data);
		redirect("data_tarif");
	}
	
	/**
	 * Method untuk menambahkan CSS baru pada HEAD
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return void
	 */
	public function add_more_css() {
		$script = '<link rel="stylesheet" type="text/css" href="%s" />';
		printf($script, base_url() . 'css/jquery.autocomplete.css');
	}

	/**
	 * Method untuk menambahkan javascript baru pada HEAD
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return void
	 */
	public function add_more_javascript() {
		$script = '<script type="text/javascript" src="%s"></script>';
		printf($script, base_url() . 'js/jquery.autocomplete.js');
	}
 
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
