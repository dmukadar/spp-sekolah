<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('PAYMENT_TABLE', 'ar_payment');

class Payment {
	private $id = NULL;
	private $id_employee = NULL;
	private $received_date = NULL;
	private $amount = NULL;
	private $status = NULL;
	private $notes = NULL;
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

	public function set_id_employee($id_employee) {
		$this->id_employee = $id_employee;
	}

	public function get_id_employee() {
		return $this->id_employee;
	}

	public function set_received_date($received_date) {
		$this->received_date = $received_date;
	}

	public function get_received_date() {
		return $this->received_date;
	}

	public function set_amount($amount) {
		$this->amount = $amount;
	}

	public function get_amount($format=FALSE) {
		if ($format === TRUE) {
			return number_format($this->amount);
		}
		return $this->amount;
	}

	public function set_status($status) {
		$this->status = $status;
	}

	public function get_status() {
		return $this->status;
	}

	public function set_notes($notes) {
		$this->notes = $notes;
	}

	public function get_notes() {
		return $this->notes;
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
	 * Method untuk melakukan mapping dari standard object ke payment.
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
			$tmp = new Payment();
			$tmp->set_id($result->id);
			$tmp->set_id_employee($result->id_employee);
			$tmp->set_received_date($result->received_date);
			$tmp->set_amount($result->amount);
			$tmp->set_status($result->status);
			$tmp->set_notes($result->notes);
			$tmp->set_created($result->created);
			$tmp->set_modified($result->modified);
			$tmp->set_modified_by($result->modified_by);
			
			// inject object siswa dan kelas on-the-fly
			$siswa = new Siswa();
			$siswa->set_id($result->id_student);
			$siswa->set_namalengkap($result->namalengkap);
			$siswa->set_noinduk($result->noinduk);
			
			$kelas = new Kelas();
			$kelas->set_id($result->kelas_id);
			$kelas->set_kelas($result->kelas);
			$kelas->set_jenjang($result->kelas_jenjang);
			$kelas->set_angka($result->kelas_angka);
			$kelas->kelas_lengkap = sprintf('%s (%s)', $result->kelas, $result->kelas_jenjang);
			
			$tmp->kelas = clone $kelas;
			$tmp->siswa = clone $siswa;
			
			$siswa = NULL;
			$kelas = NULL;
			
			// inject object user (petugas)
			if (property_exists($result, 'user_first_name')) {
				$user = new User();
				$user->set_user_id($result->id_employee);
				$user->set_user_first_name($result->user_first_name);
				$user->set_user_last_name($result->user_last_name);
				
				$tmp->petugas = clone $user;
				$user = NULL;
			}
			
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
			'siswa',
			'kelas'
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Payment::export tidak benar.');
	}
}

	
// --- CI Model ---
class Payment_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_payment($where=array(), $limit=-1, $offset=0) {
		$this->db->select('ar_payment.*, ar_invoice.id_student, sis_siswa.noinduk, sis_siswa.namalengkap, dm_kelas.id kelas_id, dm_kelas.kelas, dm_kelas.jenjang kelas_jenjang, dm_kelas.angka kelas_angka, ar_user.user_first_name, ar_user.user_last_name');
		$this->db->join('ar_payment_details', 'ar_payment_details.id_payment=ar_payment.id', 'left');
		$this->db->join('ar_invoice', 'ar_invoice.id=ar_payment_details.id_invoice', 'left');
		$this->db->join('sis_siswa', 'sis_siswa.id=ar_invoice.id_student', 'left');
		$this->db->join('dm_kelas', 'dm_kelas.id=sis_siswa.dm_kelas_id', 'left');
		$this->db->join('ar_user', 'ar_user.user_id=ar_payment.id_employee', 'left');
		$this->db->group_by('ar_payment.id');
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(PAYMENT_TABLE);
		if ($query->num_rows == 0) {
			throw new PaymentNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Payment::import_from_array($result);
	}
	
	public function get_single_payment($where=array()) {
		$record = $this->get_all_payment($where, 1, 0);
			
		return $record[0];
	}
	
	public function insert($payment) {
		if (FALSE === ($payment instanceof Payment)) {
			throw new Exception('Argumen yang diberikan untuk method Payment_model::insert harus berupa instance dari object Payment.');
		}
		
		$data = $payment->export();
		$this->db->insert(PAYMENT_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data payment.'));
		}
		
		$payment->set_id($this->db->insert_id());
	}
	
	public function update($payment, $exclude=array()) {
		if (FALSE === ($payment instanceof Payment)) {
			throw new Exception('Argumen yang diberikan untuk method Payment_model::update harus berupa instance dari object Payment.');
		}
		
		$data = $payment->export('array', $exclude);
		$where = array('id' => $payment->get_id());
		$this->db->where($where);
		$this->db->update(PAYMENT_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(PAYMENT_TABLE, $data);
	}
	
	public function delete($payment) {
		if (FALSE === ($payment instanceof Payment)) {
			throw new Exception('Argumen yang diberikan untuk method payment_model::insert harus berupa instance dari object Payment.');
		}
		
		$where = array('id' => $payment->get_id());
		$this->db->delete(PAYMENT_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(PAYMENT_TABLE, $where);
	}
}


class PaymentNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
