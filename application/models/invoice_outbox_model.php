<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('INVOICE_OUTBOX_TABLE', 'ar_invoice_outbox');

class Invoice_Outbox {
	private $invoice_id = NULL;
	private $sent_date = NULL;

	public function __construct() {
	}

	public function set_invoice_id($invoice_id) {
		$this->invoice_id = $invoice_id;
	}

	public function get_invoice_id() {
		return $this->invoice_id;
	}

	public function set_sent_date($sent_date) {
		$this->sent_date = $sent_date;
	}

	public function get_sent_date() {
		return $this->sent_date;
	}

	/**
	 * Method untuk melakukan mapping dari standard object ke invoice_outbox.
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
			$tmp = new Invoice_Outbox();
			$tmp->set_invoice_id($result->invoice_id);
			$tmp->set_sent_date($result->sent_date);
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Invoice_Outbox::export tidak benar.');
	}
}

	
// --- CI Model ---
class Invoice_Outbox_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_invoice_outbox($where=array(), $limit=-1, $offset=0) {
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(INVOICE_OUTBOX_TABLE);
		if ($query->num_rows == 0) {
			throw new Invoice_OutboxNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Invoice_Outbox::import_from_array($result);
	}
	
	public function get_single_invoice_outbox($where=array()) {
		$record = $this->get_all_invoice_outbox($where, 1, 0);
			
		return $record[0];
	}
	
	public function insert($invoice_outbox) {
		if (FALSE === ($invoice_outbox instanceof Invoice_Outbox)) {
			throw new Exception('Argumen yang diberikan untuk method Invoice_Outbox_model::insert harus berupa instance dari object Invoice_Outbox.');
		}
		
		$data = $invoice_outbox->export();
		$this->db->insert(INVOICE_OUTBOX_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data invoice_outbox.'));
		}
	}
	
	public function update($invoice_outbox, $exclude=array()) {
		if (FALSE === ($invoice_outbox instanceof Invoice_Outbox)) {
			throw new Exception('Argumen yang diberikan untuk method Invoice_Outbox_model::update harus berupa instance dari object Invoice_Outbox.');
		}
		
		$data = $invoice_outbox->export('array', $exclude);
		$where = array('invoice_id' => $invoice_outbox->get_invoice_id());
		$this->db->where($where);
		$this->db->update(INVOICE_OUTBOX_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(INVOICE_OUTBOX_TABLE, $data);
	}
	
	public function delete($invoice_outbox) {
		if (FALSE === ($invoice_outbox instanceof Invoice_Outbox)) {
			throw new Exception('Argumen yang diberikan untuk method invoice_outbox_model::insert harus berupa instance dari object Invoice_Outbox.');
		}
		
		$where = array('invoice_id' => $invoice_outbox->get_invoice_id());
		$this->db->delete(INVOICE_OUTBOX_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(INVOICE_OUTBOX_TABLE, $where);
	}
}


class Invoice_OutboxNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
