<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('OUTBOX_TABLE', 'outbox');

class Outbox {
	private $id = NULL;
	private $msgid = NULL;
	private $tipe = NULL;
	private $tanggal = NULL;
	private $tujuan = NULL;
	private $isipesan = NULL;
	private $status = NULL;
	private $keterangan = NULL;

	public function __construct() {
	}

	public function set_id($id) {
		$this->id = $id;
	}

	public function get_id() {
		return $this->id;
	}

	public function set_msgid($msgid) {
		$this->msgid = $msgid;
	}

	public function get_msgid() {
		return $this->msgid;
	}

	public function set_tipe($tipe) {
		$this->tipe = $tipe;
	}

	public function get_tipe() {
		return $this->tipe;
	}

	public function set_tanggal($tanggal) {
		$this->tanggal = $tanggal;
	}

	public function get_tanggal() {
		return $this->tanggal;
	}

	public function set_tujuan($tujuan) {
		$this->tujuan = $tujuan;
	}

	public function get_tujuan() {
		return $this->tujuan;
	}

	public function set_isipesan($isipesan) {
		$this->isipesan = $isipesan;
	}

	public function get_isipesan() {
		return $this->isipesan;
	}

	public function set_status($status) {
		$this->status = $status;
	}

	public function get_status() {
		return $this->status;
	}

	public function set_keterangan($keterangan) {
		$this->keterangan = $keterangan;
	}

	public function get_keterangan() {
		return $this->keterangan;
	}

	/**
	 * Method untuk melakukan mapping dari standard object ke outbox.
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
			$tmp = new Outbox();
			$tmp->set_id($result->id);
			$tmp->set_msgid($result->msgid);
			$tmp->set_tipe($result->tipe);
			$tmp->set_tanggal($result->tanggal);
			$tmp->set_tujuan($result->tujuan);
			$tmp->set_isipesan($result->isipesan);
			$tmp->set_status($result->status);
			$tmp->set_keterangan($result->keterangan);
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Outbox::export tidak benar.');
	}
}

	
// --- CI Model ---
class Outbox_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_outbox($where=array(), $limit=-1, $offset=0) {
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(OUTBOX_TABLE);
		if ($query->num_rows == 0) {
			throw new OutboxNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Outbox::import_from_array($result);
	}
	
	public function get_single_outbox($where=array()) {
		$record = $this->get_all_outbox($where, 1, 0);
			
		return $record[0];
	}
	
	public function insert($outbox) {
		if (FALSE === ($outbox instanceof Outbox)) {
			throw new Exception('Argumen yang diberikan untuk method Outbox_model::insert harus berupa instance dari object Outbox.');
		}
		
		$data = $outbox->export();
		$this->db->insert(OUTBOX_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data outbox.'));
		}
	}
	
	public function update($outbox, $exclude=array()) {
		if (FALSE === ($outbox instanceof Outbox)) {
			throw new Exception('Argumen yang diberikan untuk method Outbox_model::update harus berupa instance dari object Outbox.');
		}
		
		$data = $outbox->export('array', $exclude);
		$where = array('id' => $outbox->get_id());
		$this->db->where($where);
		$this->db->update(OUTBOX_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(OUTBOX_TABLE, $data);
	}
	
	public function delete($outbox) {
		if (FALSE === ($outbox instanceof Outbox)) {
			throw new Exception('Argumen yang diberikan untuk method outbox_model::insert harus berupa instance dari object Outbox.');
		}
		
		$where = array('id' => $outbox->get_id());
		$this->db->delete(OUTBOX_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(OUTBOX_TABLE, $where);
	}
}


class OutboxNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
