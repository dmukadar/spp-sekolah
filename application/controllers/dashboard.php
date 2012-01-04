<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Alazka_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->data['page_title'] = 'User Dashboard';
		
		$this->load->view('site/header_view');
		$this->load->view('site/dashboard_view', $this->data);
		$this->load->view('site/footer_view');
	}
}
