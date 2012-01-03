<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('USER_TABLE', 'ar_user');

class User {
	private $user_id = NULL;
	private $username = NULL;
	private $user_first_name = NULL;
	private $user_last_name = NULL;
	private $user_pass = NULL;
	private $user_salt = NULL;
	private $user_email = NULL;
	private $user_status = NULL;
	private $user_join_date = NULL;
	private $user_last_login = NULL;
	private $pegawai_id = NULL;

	public function __construct() {
	}

	public function set_user_id($user_id) {
		$this->user_id = (int)$user_id;
	}

	public function get_user_id() {
		return $this->user_id;
	}

	public function set_username($username) {
		$this->username = $username;
	}

	public function get_username() {
		return $this->username;
	}

	public function set_user_first_name($user_first_name) {
		$this->user_first_name = $user_first_name;
	}

	public function get_user_first_name() {
		return $this->user_first_name;
	}

	public function set_user_last_name($user_last_name) {
		$this->user_last_name = $user_last_name;
	}

	public function get_user_last_name() {
		return $this->user_last_name;
	}
	
	public function get_user_full_name() {
		return $this->user_first_name . ' ' . $this->user_last_name;
	}

	public function set_user_pass($user_pass) {
		$this->user_pass = $user_pass;
	}

	public function get_user_pass() {
		return $this->user_pass;
	}

	public function set_user_salt($user_salt) {
		$this->user_salt = $user_salt;
	}

	public function get_user_salt() {
		return $this->user_salt;
	}

	public function set_user_email($user_email) {
		$this->user_email = $user_email;
	}

	public function get_user_email() {
		return $this->user_email;
	}

	public function set_user_status($user_status) {
		$this->user_status = $user_status;
	}

	public function get_user_status() {
		return $this->user_status;
	}

	public function set_user_join_date($user_join_date) {
		$this->user_join_date = (int)$user_join_date;
	}

	public function get_user_join_date() {
		return $this->user_join_date;
	}

	public function set_user_last_login($user_last_login) {
		$this->user_last_login = (int)$user_last_login;
	}

	public function get_user_last_login() {
		return $this->user_last_login;
	}

	public function set_pegawai_id($pegawai_id) {
		$this->pegawai_id = (int)$pegawai_id;
	}

	public function get_pegawai_id() {
		return $this->pegawai_id;
	}

	/**
	 * Method untuk melakukan mapping dari standard object ke user.
	 * Cara yang lebih efektif sebenarnya adalah dengan memodifikasi 
	 * internal Database Driver nya CI.
	 *
	 * @author Rio Astamal 
	 *
	 * @param array $array_of_object - Array hasil query
	 * @return array - Array of $class
	 */
	public static function import_from_array($array_of_object) {
		$objects = array();
		foreach ($array_of_object as $i => $result) {
			$tmp = new User();
			$tmp->set_user_id($result->user_id);
			$tmp->set_username($result->username);
			$tmp->set_user_first_name($result->user_first_name);
			$tmp->set_user_last_name($result->user_last_name);
			$tmp->set_user_pass($result->user_pass);
			$tmp->set_user_salt($result->user_salt);
			$tmp->set_user_email($result->user_email);
			$tmp->set_user_status($result->user_status);
			$tmp->set_user_join_date($result->user_join_date);
			$tmp->set_user_last_login($result->user_last_login);
			$tmp->set_pegawai_id($result->pegawai_id);
			$objects[$i] = clone $tmp;
		}
		
		$tmp = NULL;
		
		return $objects;
	}
	
	/**
	 * Method untuk mengexport isi dari object ke dalam type 
	 * associative array atau object.
	 *
	 * @author Rio Astamal 
	 *
	 * @param string $export_type - Tipe data yang akan diexport
	 * @param array $param_exclude - Daftar attribut yang akan diexclude (akan ditambahkan dengan $def_exclude)
	 * @return void
	 */
	public function export($export_type='array', $param_exclude=array()) {
		$result = NULL;
		
		// properti yang akan diexclude dalam hasil
		// sehingga tidak digunakan pada saat akan insert atau update
		$def_exclude = array(
		);
		$exclude = $def_exclude + $param_exclude;
		
		// export dengan tipe array
		if ($export_type === 'array') {
			$result = array();
			foreach ($this as $attr => $val) {
				if (!in_array($attr, $exclude)) {
					// properti tidak termasuk dalam daftar exclude jadi
					// masukkan ke hasil
					$result[$attr] = $val;
				}
			}
			return $result;
		}
		
		// export dengan tipe standard object
		if ($export_type === 'object') {
			$result = new stdClass();
			foreach ($this as $attr => $val) {
				if (!in_array($attr, $exclude)) {
					// properti tidak termasuk dalam daftar exclude jadi
					// masukkan ke hasil
					$result->$attr = $val;
				}
			}
			return $result;
		}
		
		// seharusnya tidak sampai disini jika parameter yang diberikan benar
		throw new Exception('Sepertinya argumen yang anda berikan pada method User::export tidak benar.');
	}
}

	
// --- CI Model ---
class User_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_user($where=array(), $limit=-1, $offset=0) {
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(USER_TABLE);
		if ($query->num_rows == 0) {
			throw new Exception ("User tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return User::import_from_array($result);
	}
	
	public function get_single_user($where=array()) {
		try {
			$record = $this->get_all_user($where, 1, 0);
			
			return $record[0];
		} catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}
	
	public function insert($user) {
		if (FALSE === ($user instanceof User)) {
			throw new Exception('Argumen yang diberikan untuk method User_model::insert harus berupa instance dari object User.');
		}
		
		$data = $user->export();
		$this->db->insert(USER_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data user.'));
		}
	}
	
	public function update($user, $exclude=array()) {
		if (FALSE === ($user instanceof User)) {
			throw new Exception('Argumen yang diberikan untuk method User_model::update harus berupa instance dari object User.');
		}
		
		$data = $user->export('array', $exclude);
		$where = array('user_id' => $user->get_user_id());
		$this->db->where($where);
		$this->db->update(USER_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(USER_TABLE, $data);
	}
	
	public function delete($user) {
		if (FALSE === ($user instanceof User)) {
			throw new Exception('Argumen yang diberikan untuk method user_model::insert harus berupa instance dari object User.');
		}
		
		$where = array('user_id' => $user->get_user_id());
		$this->db->delete(USER_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(USER_TABLE, $where);
	}
	
	/**
	 * Method untuk mencocokkan username dan password dari user/pengguna.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 * 
	 * @param string $username - Username dari pengguna
	 * @param string $password - Password dari pengguna
	 * @return void
	 * @throw Exception
	 */
	public function login($username, $password) {
		$where_username = array('ar_user.username' => $username);
		
		// klausa where untuk password
		$password = $this->db->escape($password);
		$this->db->where("MD5(CONCAT(ar_user.user_salt, $password))=ar_user.user_pass");
		try {
			$user = $this->get_single_user($where_username);
			
			// cek jika status dari user tidak sama dengan active maka 
			// lempar exception
			switch ($user->get_user_status()) {
				case self::get_status_by_label('deleted'):
					// fake, record ada namun sengaja tidak kita hapus :)
					throw new Exception(sprintf('User %s tidak ada pada database.', $user->get_username()));
				break;
				
				case self::get_status_by_label('blocked'):
					throw new Exception(sprintf('Maaf, account %s sedang diblok, jadi tidak dapat login.', $user->get_username()));
				break;
				
				case self::get_status_by_label('pending'):
					throw new Exception(sprintf('Status account %s belum aktif, silahkan lakukan aktivasi terlebih dahulu.', $user->get_username()));
				break;
				
				default:
					return $user;
				break;
			}
		} catch (Exception $e) {
			throw new Exception('Kombinasi username atau password salah!');
		}
	}
	
	/**
	 * Methdod untuk mendapatkan ID dari user status berdasarkan nama status.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param string $label - Nama dari status
	 * @return int - status ID
	 * @throw Exception - jika nama status tidak ada
	 */
	public static function get_status_by_label($label) {
		$label_orig = $label;
		$label = strtolower($label);
		
		switch ($label) {
			case 'deleted':
				return 0;
			break;
			
			case 'pending':
				return 1;
			break;
			
			case 'blocked':
				return 2;
			break;
			
			// user telah aktif namun belum mengupdate profile
			case 'profile empty':
				return 3;
			break;
			
			case 'active':
				return 4;
			break;
			
			default:
				throw new Exception (sprintf('Nama type status "%s" yang anda cari tidak ada, baca dokumentasi!.', $label));
			break;
		}
	}
	
	/**
	 * Methdod untuk mendapatkan label dari user status berdasarkan ID. ID
	 * dari method ini HARUS sama dengan didatabase, jadi perlu dilakukan
	 * pengubahan ulang jika terjadi perubahan di tabel.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param int $status_id - ID dari status
	 * @return status - Nama status
	 * @throw Exception - jika id dari status tidak ada
	 */
	public static function get_status_by_id($status_id) {
		switch ($status_id) {
			case 0:
				return 'Deleted';
			break;
			
			case 1:
				return 'Pending';
			break;
			
			case 2:
				return 'Blocked';
			break;
			
			case 3:
				return 'Profile Empty';
			break;
			
			case 4:
				return 'Active';
			break;
			
			default:
				throw new Exception (sprintf('ID status "%d" yang anda cari tidak ada, baca dokumentasi!.', $status_id));
			break;
		}
	}
}
