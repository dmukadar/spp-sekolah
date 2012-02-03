<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Alazka_Controller {
	
	public function __construct() {
		parent::__construct();
		if ($this->current_user->get_user_privilege() == 'ksr') {
			redirect('/pembayaran');
		}
		$this->deny_group('ksr');
	}
	
	public function index() {
		$this->data['page_title'] = 'User Dashboard';
		
		$this->load->view('site/header_view');
		$this->load->view('site/dashboard_view', $this->data);
		$this->load->view('site/footer_view');
	}
}
