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
			$this->data['sess']->privilege = $this->current_user->get_user_privilege(TRUE);
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
		$this->data['sess']->privilege = $this->current_user->get_user_privilege(TRUE);
			
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
	
	public function pengguna() {
		$this->data['action_url'] = site_url() . '/userctl/simpan';
		$this->data['list_status'] = User_model::get_status_list();
		$this->data['list_privilege'] = User_model::get_user_privilege_list();
		try {
			// exclude guest user
			$where = array('ar_user.username !=' => 'guest');
			$this->db->order_by('ar_user.user_first_name');
			$this->data['list_user'] = $this->User_model->get_all_user($where);
		} catch (Exception $e) {
			$this->data['list_user'] = array();
		}
		
		$this->load->view('site/header_view');
		$this->load->view('site/data_user_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	public function simpan() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[password2]');
		$this->form_validation->set_rules('password2', 'Ulangi Password', 'required');
		$this->form_validation->set_rules('namadepan', 'Nama Depan', 'required');
		$this->form_validation->set_rules('namabelakang', 'Nama Belakang', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('privilege', 'Hak Akses', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->set_flash_message(validation_errors('<span>', '</span><br/>'), 'error msg');
			$this->print_flash_message();
			return FALSE;
		}
		
		try {
			$this->load->helper('mr_string');
			$usermod = new User_model();
			$salt = mr_random_string(8);
			$password = User_model::generate_password($salt, $this->input->post('password'));

			$user = new User();
			$user->set_username(trim($this->input->post('username')));
			$user->set_user_pass($this->input->post('password'));
			$user->set_user_salt($salt);
			$user->set_user_first_name($this->input->post('namadepan'));
			$user->set_user_last_name($this->input->post('namabelakang'));
			$user->set_user_status($this->input->post('status'));
			$user->set_user_privilege($this->input->post('privilege'));
			$user->set_user_join_date(time());
			
			$this->User_model->insert($user);
			
			$this->set_flash_message(sprintf('User "%s" berhasil disimpan!', $user->get_username()), 'information msg');
		} catch (Exception $e) {
			$this->set_flash_message($e->getMessage(), 'error msg');
		}
		
		$this->print_flash_message();
	}
}
