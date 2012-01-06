<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('KELAS_TABLE', 'dm_kelas');

class Kelas {
	private $id = NULL;
	private $kelas = NULL;
	private $dm_jenjang_id = NULL;
	private $jenjang = NULL;
	private $angka = NULL;

	public function __construct() {
	}

	public function set_id($id) {
		$this->id = $id;
	}

	public function get_id() {
		return $this->id;
	}

	public function set_kelas($kelas) {
		$this->kelas = $kelas;
	}

	public function get_kelas() {
		return $this->kelas;
	}

	public function set_dm_jenjang_id($dm_jenjang_id) {
		$this->dm_jenjang_id = $dm_jenjang_id;
	}

	public function get_dm_jenjang_id() {
		return $this->dm_jenjang_id;
	}

	public function set_jenjang($jenjang) {
		$this->jenjang = $jenjang;
	}

	public function get_jenjang() {
		return $this->jenjang;
	}

	public function set_angka($angka) {
		$this->angka = $angka;
	}

	public function get_angka() {
		return $this->angka;
	}

	/**
	 * Method untuk melakukan mapping dari standard object ke kelas.
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
			$tmp = new Kelas();
			$tmp->set_id($result->id);
			$tmp->set_kelas($result->kelas);
			$tmp->set_dm_jenjang_id($result->dm_jenjang_id);
			$tmp->set_jenjang($result->jenjang);
			$tmp->set_angka($result->angka);
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Kelas::export tidak benar.');
	}
}

	
// --- CI Model ---
class Kelas_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_kelas($where=array(), $limit=-1, $offset=0) {
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(KELAS_TABLE);
		if ($query->num_rows == 0) {
			throw new KelasNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Kelas::import_from_array($result);
	}
	
	public function get_single_kelas($where=array()) {
		$record = $this->get_all_kelas($where, 1, 0);
			
		return $record[0];
	}
	
	public function insert($kelas) {
		if (FALSE === ($kelas instanceof Kelas)) {
			throw new Exception('Argumen yang diberikan untuk method Kelas_model::insert harus berupa instance dari object Kelas.');
		}
		
		$data = $kelas->export();
		$this->db->insert(KELAS_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data kelas.'));
		}
	}
	
	public function update($kelas, $exclude=array()) {
		if (FALSE === ($kelas instanceof Kelas)) {
			throw new Exception('Argumen yang diberikan untuk method Kelas_model::update harus berupa instance dari object Kelas.');
		}
		
		$data = $kelas->export('array', $exclude);
		$where = array('id' => $kelas->get_id());
		$this->db->where($where);
		$this->db->update(KELAS_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(KELAS_TABLE, $data);
	}
	
	public function delete($kelas) {
		if (FALSE === ($kelas instanceof Kelas)) {
			throw new Exception('Argumen yang diberikan untuk method kelas_model::insert harus berupa instance dari object Kelas.');
		}
		
		$where = array('id' => $kelas->get_id());
		$this->db->delete(KELAS_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(KELAS_TABLE, $where);
	}
}


class KelasNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
