<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('PAYMENT_DETAIL_TABLE', 'ar_payment_details');

class Payment_Detail {
	private $id = NULL;
	private $id_payment = NULL;
	private $id_invoice = NULL;
	private $amount = NULL;
	private $remaining_amount = NULL;
	private $installment = NULL;
	private $status = NULL;
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

	public function set_id_payment($id_payment) {
		$this->id_payment = $id_payment;
	}

	public function get_id_payment() {
		return $this->id_payment;
	}

	public function set_id_invoice($id_invoice) {
		$this->id_invoice = $id_invoice;
	}

	public function get_id_invoice() {
		return $this->id_invoice;
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
	
	public function set_remaining_amount($amount) {
		$this->remaining_amount = $amount;
	}

	public function get_remaining_amount($format=FALSE) {
		if ($format === TRUE) {
			return number_format($this->remaining_amount);
		}
		return $this->remaining_amount;
	}

	public function set_installment($installment) {
		$this->installment = $installment;
	}

	public function get_installment() {
		return $this->installment;
	}

	public function set_status($status) {
		$this->status = $status;
	}

	public function get_status() {
		return $this->status;
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
	 * Method untuk melakukan mapping dari standard object ke payment_detail.
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
			$tmp = new Payment_Detail();
			$tmp->set_id($result->id);
			$tmp->set_id_payment($result->id_payment);
			$tmp->set_id_invoice($result->id_invoice);
			$tmp->set_amount($result->amount);
			$tmp->set_remaining_amount($result->remaining_amount);
			$tmp->set_installment($result->installment);
			$tmp->set_status($result->status);
			$tmp->set_created($result->created);
			$tmp->set_modified($result->modified);
			$tmp->set_modified_by($result->modified_by);
			
			// inject object invoice on the fly
			$invoice = new Invoice();
			$invoice->set_id($result->id_invoice);
			$invoice->set_amount($result->amount_invoice);
			$invoice->set_received_amount($result->received_amount_invoice);
			$invoice->set_description($result->description_invoice);
			$invoice->set_status($result->status_invoice);
			
			$tmp->invoice = clone $invoice;
			$invoice = NULL;
			
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
			'invoice'
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Payment_Detail::export tidak benar.');
	}
}

	
// --- CI Model ---
class Payment_Detail_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_payment_detail($where=array(), $limit=-1, $offset=0) {
		$this->db->select('ar_payment_details.*, ar_invoice.amount amount_invoice, ar_invoice.received_amount received_amount_invoice, ar_invoice.status status_invoice, ar_invoice.description description_invoice');
		$this->db->join('ar_invoice', 'ar_invoice.id=ar_payment_details.id_invoice', 'left');
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(PAYMENT_DETAIL_TABLE);
		if ($query->num_rows == 0) {
			throw new Payment_DetailNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Payment_Detail::import_from_array($result);
	}
	
	public function get_single_payment_detail($where=array()) {
		$record = $this->get_all_payment_detail($where, 1, 0);
			
		return $record[0];
	}
	
	public function insert($payment_detail) {
		if (FALSE === ($payment_detail instanceof Payment_Detail)) {
			throw new Exception('Argumen yang diberikan untuk method Payment_Detail_model::insert harus berupa instance dari object Payment_Detail.');
		}
		
		$data = $payment_detail->export();
		$this->db->insert(PAYMENT_DETAIL_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data payment_detail.'));
		}
		
		$payment_detail->set_id($this->db->insert_id());
	}
	
	public function update($payment_detail, $exclude=array()) {
		if (FALSE === ($payment_detail instanceof Payment_Detail)) {
			throw new Exception('Argumen yang diberikan untuk method Payment_Detail_model::update harus berupa instance dari object Payment_Detail.');
		}
		
		$data = $payment_detail->export('array', $exclude);
		$where = array('id' => $payment_detail->get_id());
		$this->db->where($where);
		$this->db->update(PAYMENT_DETAIL_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(PAYMENT_DETAIL_TABLE, $data);
	}
	
	public function delete($payment_detail) {
		if (FALSE === ($payment_detail instanceof Payment_Detail)) {
			throw new Exception('Argumen yang diberikan untuk method payment_detail_model::insert harus berupa instance dari object Payment_Detail.');
		}
		
		$where = array('id' => $payment_detail->get_id());
		$this->db->delete(PAYMENT_DETAIL_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(PAYMENT_DETAIL_TABLE, $where);
	}
}


class Payment_DetailNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
