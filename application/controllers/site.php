<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends Alazka_Controller {
	
	public function __construct() {
		parent::__construct(FALSE);
	}
	
	public function index() {
		$this->load->view('site/header_lite_view');
		$this->load->view('site/login_view', $this->data);
		$this->load->view('site/footer_lite_view');
	}
	
	public function login() {
		$username = $this->input->post('username');
		$password = $this->input->post('adminpassword');
		
		// masukkan ke sess untuk repopulating form
		// (ketika user gagal, textbox username akan langsung terisi yang salah tsb.)
		$this->data['sess']->username = $username;
		
		try {
			// cocokkan username dan password
			// jika salah pasti otomatis akan dilempar ke exception
			$user = $this->User_model->login($username, $password);
			
			// jika sampai disini berarti kombinasinya benar
			
			// masukkan data username ke session
			$this->session->set_userdata('username', $user->get_username());
			
			// pesan ini kemungkinan tidak akan tampil karena proses reditect
			// sangat cepat, tapi tidak ada salahnya ditampilkan...
			$this->set_flash_message('Login OK, redirecting to dashboard...');
			
			redirect('/dashboard/index');
		} catch (Exception $e) {
			// tampilkan pesan error yang diperoleh dari exception
			// (dapat juga membuat pesan sendiri jika mau)
			$this->set_flash_message($e->getMessage(), 'error msg');
		}
		
		// tidak perlu melakukan redirect halaman hanya untuk 
		// menampilkan kembali form, karena pada method index()
		// sudah tersedia, jadi tinggal panggil saja method tsb.
		$this->index();
	}
	
	public function logout() {
		// cukup hilangkan item username pada session
		// maka otomatis user tidak akan dikenali (dianggap Guest)
		$this->session->unset_userdata('username');
		
		// redirect ke halaman login
		redirect($this->config->item('redirect_login'));
	}
}
