<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('RATE_TABLE', 'ar_rate');

class Rate {
	private $id = NULL;
	private $category = NULL;
	private $name = NULL;
	private $description = NULL;
	private $fare = NULL;
	private $created = NULL;
	private $modified = NULL;
	private $modified_by = NULL;

	public function __construct() {
	}

	public function set_id($id) {
		$this->id = $id;
	}

	public function get_id() {
		return $this->id;
	}

	public function set_category($category) {
		$this->category = $category;
	}

	public function get_category() {
		return $this->category;
	}

	public function set_name($name) {
		$this->name = $name;
	}

	public function get_name() {
		return $this->name;
	}

	public function set_description($description) {
		$this->description = $description;
	}

	public function get_description() {
		return $this->description;
	}

	public function set_fare($fare) {
		$this->fare = $fare;
	}

	public function get_fare($format=FALSE) {
		if ($format === TRUE) {
			return number_format($this->fare);
		}
		return $this->fare;
	}

	public function set_created($created) {
		$this->created = $created;
	}

	public function get_created() {
		return $this->created;
	}

	public function set_modified($modified) {
		$this->modified = $modified;
	}

	public function get_modified() {
		return $this->modified;
	}

	public function set_modified_by($modified_by) {
		$this->modified_by = $modified_by;
	}

	public function get_modified_by() {
		return $this->modified_by;
	}

	/**
	 * Method untuk melakukan mapping dari standard object ke rate.
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
			$tmp = new Rate();
			$tmp->set_id($result->id);
			$tmp->set_category($result->category);
			$tmp->set_name($result->name);
			$tmp->set_description($result->description);
			$tmp->set_fare($result->fare);
			$tmp->set_created($result->created);
			$tmp->set_modified($result->modified);
			$tmp->set_modified_by($result->modified_by);
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Rate::export tidak benar.');
	}
}

	
// --- CI Model ---
class Rate_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_rate($where=array(), $limit=-1, $offset=0) {
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(RATE_TABLE);
		if ($query->num_rows == 0) {
			throw new Exception ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Rate::import_from_array($result);
	}
	
	public function get_single_rate($where=array()) {
		try {
			$record = $this->get_all_rate($where, 1, 0);
			
			return $record[0];
		} catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}
	
	public function get_all_category() {
		$this->db->group_by('ar_rate.category');
		$this->db->order_by('ar_rate.category', 'ASC');
		return $this->get_all_rate();
	}
	
	public function insert($rate) {
		if (FALSE === ($rate instanceof Rate)) {
			throw new Exception('Argumen yang diberikan untuk method Rate_model::insert harus berupa instance dari object Rate.');
		}
		
		$data = $rate->export();
		$this->db->insert(RATE_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data rate.'));
		}
	}
	
	public function update($rate, $exclude=array()) {
		if (FALSE === ($rate instanceof Rate)) {
			throw new Exception('Argumen yang diberikan untuk method Rate_model::update harus berupa instance dari object Rate.');
		}
		
		$data = $rate->export('array', $exclude);
		$where = array('id' => $rate->get_id());
		$this->db->where($where);
		$this->db->update(RATE_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(RATE_TABLE, $data);
	}
	
	public function delete($rate) {
		if (FALSE === ($rate instanceof Rate)) {
			throw new Exception('Argumen yang diberikan untuk method rate_model::insert harus berupa instance dari object Rate.');
		}
		
		$where = array('id' => $rate->get_id());
		$this->db->delete(RATE_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(RATE_TABLE, $where);
	}
}
