<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Custom controller yang digunakan oleh semua halaman yang memerlukan 
 * autentikasi user.
 *
 * @author Rio Astamal <me@rioastamal.net>
 */
class Alazka_Controller extends CI_Controller {
	protected $data = array();
	protected $current_user = array();
	
	private $flash_message = '';
	
	public static $ME = NULL;
	
	public function __construct($login_check=TRUE) {
		parent::__construct();
		
		// konek ke database
		$this->load->database();
		
		// initialize
		$this->init_session();
		$this->init_user();
		
		if ($login_check === TRUE) {
			$this->init_login();
		}
		
		// session untuk repopulatin form
		$this->data['sess'] = new stdClass();
		
		self::$ME =& $this;
	}
	
	/**
	 * Method untuk melakukan initialize object user yang akan digunakan
	 * untuk identifikasi siapa user yang aktif sekarang.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 */
	private function init_user() {
		$this->load->model('User_model');
		
		// cek apakah username sudah ada disession
		$username = $this->session->userdata('username');
		if ($username == FALSE) {
			// karena tidak ada maka isi dengan username guest
			$username = $this->config->item('anon_username');
		}
		
		// coba dapatkan user dari database
		try {
			// cari berdasarkan username
			$where = array('ar_user.username' => $username);
			$this->current_user = $this->User_model->get_single_user($where);
		} catch (Exception $e) {
			// user yang dicari tidak ada, kemungkinan yang terjadi adalah
			// INI BURUK!
			// agar user tetap bisa mengakses website maka user id
			// perlu diset ulang ke Guest dengan menghancurkan session lama.
			$this->session->sess_destroy();
			
			$err = 'Ooops..., something bad happens to our system, try to <a href="%s">reload</a> this page.';
			$err = sprintf($err, base_url());
			show_error($err);
		}
	}
	
	/**
	 * Method untuk mendapatkan object user yang sedang aktif.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return User Object
	 */
	public function get_current_user() {
		return $this->current_user;
	}
	
	/**
	 * Method untuk melakukan pengecekan apakah user sudah login atau belum.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return void
	 */
	private function init_login() {
		// -- REDIRECT JIKA BELUM LOGIN --
		// jika username sama dengan isi config anon_user maka user
		// tersebut belum login maka lakukan redirect
		if ($this->config->item('anon_username') == $this->current_user->get_username()) {
			// karena sama maka dapat dipastikan dia belum login
			redirect($this->config->item('redirect_login'));
		}
	}
	
	/**
	 * Method untuk inisialisasi session.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return void
	 */
	private function init_session() {
		// do nothing...
	}
	
	/**
	 * Method untuk mengubah isi dari flash_message.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param string $message - Pesan yang akan ditampilkan
	 * @param string $css_class - Nama class CSS yang digunakan
	 * @return void
	 */
	public function set_flash_message($message='', $css_class='information msg') {
		$this->flash_message = $message;
		$this->flash_class = $css_class;
	}
	
	/**
	 * Method untuk mencetak flash message.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return void
	 */
	public function print_flash_message($return=FALSE) {
		if (strlen($this->flash_message) > 0) {
			$div = '<div class="%s">%s</div>';
			if ($return === TRUE) {
				return sprintf($div, $this->flash_class, $this->flash_message);
			}
			printf($div, $this->flash_class, $this->flash_message);
		}
	}
	
	/**
	 * Method untuk mendapatkan nilai dari judul halaman yang sedang aktif.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return string
	 */
	public function get_page_title() {
		return @$this->data['page_title'];
	}
	
	/**
	 * Method untuk yang akan dipanggil pada HTML head dibawah css. Anda dapat
	 * memanggil method ini untuk menambahkan link rel CSS. Controller
	 * perlu mengoverwrite method ini menampilkan CSS yang dinginkan.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param array $css_list - Alamat URL CSS tambahan yang disimpan pada array.
	 * @return void
	 */
	public function add_more_css() {
		// load your css
	}
	
	/**
	 * Method untuk yang akan dipanggil pada HTML head dibawah javascript. 
	 * Hampir sama dengan method add_more_css hanya saja ini khusus untuk 
	 * javascript.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return void
	 */
	public function add_more_javascript() {
		// load your js
	}
	
	/**
	 * Method mencegah user mengakses suatu halaman jika privilege atau
	 * hak aksesnya sesuai yang dicari.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param string $group - Nama group/privilege
	 * @return void
	 */
	protected function deny_group($group) {
		if ($group === $this->current_user->get_user_privilege()) {
			show_error('<strong>ANDA TIDAK BERHAK MENGAKSES HALAMAN INI.</strong>');
		}
	}
}

/**
 * Fungsi untuk mengembalikan instance dari Alazka_Controller. Biasanya 
 * digunakan pada view.
 *
 * @author Rio Astamal
 * @return Alazka_Controller Object
 */
function &ME() {
	return Alazka_Controller::$ME;
}
