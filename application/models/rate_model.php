<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('RATE_TABLE', 'ar_rate');

class Rate {
	private $id = NULL;
	private $category = NULL;
	private $name = NULL;
	private $description = NULL;
	private $fare = NULL;
	private $id_kelas = NULL;
	private $due_after = NULL;
	private $recurrence = NULL;
	private $installment = NULL;
	private $notification = NULL;
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

	public function set_id_kelas($id_kelas) {
		$this->id_kelas = $id_kelas;
	}

	public function get_id_kelas() {
		return $this->id_kelas;
	}

	public function set_due_after($due_after) {
		$this->due_after = $due_after;
	}

	public function get_due_after() {
		//make sure it returns int, even if it 0
		return (int)($this->due_after);
	}

	public function set_recurrence($recurrence) {
		$this->recurrence = $recurrence;
	}

	public function get_recurrence($bahasa_format=FALSE) {
		// output ke dalam bentuk bahasa yang baku
		if ($bahasa_format === TRUE) {
			switch ($this->recurrence) {
				case 'sekali':
					return 'Satu Kali';
				break;
				case 'semester':
					return 'Per Semester';
				break;
				case 'tahun':
					return 'Per Tahun';
				break;
				case 'cawu':
					return 'Per Cawu';
				break;
				case 'bulan':
					return 'Per Bulan';
				break;
				default:
					return $this->recurrence;
				break;
			}
		}
		return $this->recurrence;
	}

	public function set_installment($installment) {
		$this->installment = $installment;
	}

	public function get_installment() {
		return $this->installment;
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

	public function set_notification($notification) {
		$this->notification = $notification;
	}

	public function get_notification() {
		return $this->notification;
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
			$tmp->set_id_kelas($result->id_kelas);
			$tmp->set_due_after($result->due_after);
			$tmp->set_recurrence($result->recurrence);
			$tmp->set_installment($result->installment);
			$tmp->set_notification($result->notification);
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
			throw new RateNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Rate::import_from_array($result);
	}
	
	public function get_single_rate($where=array()) {
		$record = $this->get_all_rate($where, 1, 0);
			
		return $record[0];
	}
	
	public function get_all_category() {
		$result = array('SPP', 'Uang Masuk', 'Uang Buku', 'Uang Kegiatan', 'Uang Seragam', 'Uang Alat', 'Uang Antar Jemput', 'Uang Sanggar', 'BPPS');
		return $result;
	}
	
	public function insert($rate) {
		if (FALSE === ($rate instanceof Rate)) {
			throw new Exception('Argumen yang diberikan untuk method Rate_model::insert harus berupa instance dari object Rate.');
		}
		
		$now = date('Y-m-d H:i:s');
		$rate->set_created($now);
		$rate->set_modified($now);

		$data = $rate->export();
		$this->db->insert(RATE_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data rate.'));
		}

		return $this->db->insert_id();
	}
	
	public function update($rate, $exclude=array()) {
		if (FALSE === ($rate instanceof Rate)) {
			throw new Exception('Argumen yang diberikan untuk method Rate_model::update harus berupa instance dari object Rate.');
		}
		
		$now = date('Y-m-d H:i:s');
		$rate->set_modified($now);

		$data = $rate->export('array', $exclude);
		$where = array('id' => $rate->get_id());
		$this->db->where($where);
		$this->db->update(RATE_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
		return $this->db->affected_rows();
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

	public function find_by_pk($id) {
		return $this->get_single_rate(array('ar_rate.id'=>$id));
	}

	public function get_all_recurrence() {
		return array('sekali', 'tahun', 'semester', 'cawu', 'bulan');
	}
}


class RateNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
