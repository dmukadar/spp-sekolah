<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userctl extends Alazka_Controller {
	public function __construct() {
		parent::__construct();
		$this->data['sess'] = new stdClass();
	}
	
	public function index() {
		$this->data['action_url'] = site_url() . '/userctl/update_my_profile';
		
		if ($this->input->post('updatebtn') == FALSE) {
			// karena bukan POST jadi tampilkan data dari user yang saat ini
			$this->data['sess']->namadepan = $this->current_user->get_user_first_name();
			$this->data['sess']->namabelakang = $this->current_user->get_user_last_name();
		}
		
		$this->load->view('site/header_view');
		$this->load->view('site/my_profile_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	public function update_my_profile() {
		if ($this->input->post('updatebtn') == FALSE) {
			$this->index();
		}
		
		$this->data['sess']->namadepan = trim($this->input->post('namadepan'));
		$this->data['sess']->namabelakang = trim($this->input->post('namabelakang'));
			
		$this->load->library('form_validation');
		$this->form_validation->set_rules('namadepan', 'Nama Depan', 'required');
		$this->form_validation->set_rules('namabelakang', 'Nama Belakang', 'required');
		
		if ($this->input->post('passwordbaru')) {
			$this->form_validation->set_rules('passwordbaru2', 'Ulangi Password', 'required|matches[passwordbaru]');
		}
		
		if ($this->input->post('passwordbaru2')) {
			$this->form_validation->set_rules('passwordbaru', 'Password Baru', 'required');
		}
		
		if ($this->form_validation->run() == FALSE) {
			$this->set_flash_message(validation_errors('<span>', '</span><br/>'), 'error msg');
			
			$this->index();
			return FALSE;
		}
		
		// clone object current user untuk berjaga-jaga
		$user = clone $this->current_user;
		
		$user->set_user_first_name($this->data['sess']->namadepan);
		$user->set_user_last_name($this->data['sess']->namabelakang);
		
		$flash = '';
		try {
			$this->User_model->update($user);
			
			$flash = 'Data profil berhasil diubah.';
		} catch (Exception $e) {
		}
		
		// apakah password diupdate?
		if ($this->input->post('passwordbaru')) {
			try {
				$password = $this->input->post('passwordbaru');
				$this->User_model->update_password($user, $password);
				
				$flash = 'Data profil dan password berhasil diubah.';
			} catch (Exception $e) {
			}
		}
		
		// semua OK jadi aman object user untuk diubah ke current_user
		$this->current_user = clone $user;
		$user = NULL;
			
		$this->set_flash_message($flash);
		$this->index();
	}
}
