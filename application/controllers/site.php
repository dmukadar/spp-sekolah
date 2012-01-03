<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('site/header_lite_view');
		$this->load->view('site/login_view');
		$this->load->view('site/footer_lite_view');
	}
	
	public function login() {
		//mestinya otentikasi
		//otorisasi user level
		//baru dibuang ke dashboard
		$this->load->view('site/dashboard');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
