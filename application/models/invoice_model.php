<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('INVOICE_TABLE', 'ar_invoice');

class Invoice {
	private $id = NULL;
	private $code = NULL;
	private $created_date = NULL;
	private $due_date = NULL;
	private $description = NULL;
	private $id_employee = NULL;
	private $id_student = NULL;
	private $id_rate = NULL;
	private $amount = NULL;
	private $status = NULL;
	private $notes = NULL;
	private $last_installment = NULL;
	private $received_amount = NULL;
	private $created = NULL;
	private $modified = NULL;
	private $modified_by = NULL;

	public function __construct() {
	}

	public function set_id($id) {
		$this->id = (double)$id;
	}

	public function get_id() {
		return $this->id;
	}

	//code atau invoice number bisa berupa string atau array. input array digunakan untuk generate inv. number harus berisi 
	//param: bulan, cawu, semester dan tahun
	public function set_code($code) {
		if (empty($code)) throw new Exception('Nomor tagihan tidak boleh kosong');

		if ($code instanceof TahunAkademik) {
			$this->code = $this->generate_code($code);
		} else {
			$this->code = $code;
		}
	}

	public function get_code() {
		return $this->code;
	}

	public function set_created_date($created_date) {
		$this->created_date = $created_date;
	}

	public function get_created_date() {
		return $this->created_date;
	}

	public function set_due_date($due_date) {
		$this->due_date = $due_date;
	}

	public function get_due_date() {
		return $this->due_date;
	}

	public function set_description($description) {
		$this->description = $description;
	}

	public function get_description() {
		return $this->description;
	}

	public function set_id_employee($id_employee) {
		$this->id_employee = (int)$id_employee;
	}

	public function get_id_employee() {
		return $this->id_employee;
	}

	public function set_id_student($id_student) {
		$this->id_student = (int)$id_student;
	}

	public function get_id_student() {
		return $this->id_student;
	}

	public function set_id_rate($id_rate) {
		$this->id_rate = (int)$id_rate;
	}

	public function get_id_rate() {
		return $this->id_rate;
	}

	public function set_amount($amount) {
		$this->amount = (double)$amount;
	}

	public function get_amount($format=FALSE) {
		if ($format === TRUE) {
			return number_format($this->amount);
		}
		return $this->amount;
	}

	public function set_status($status) {
		$this->status = (int)$status;
	}

	public function get_status() {
		/* sorry hardcode dulu, kejar waktu */
		switch ($this->status) {
			case 1: $result = 'open'; break;
			case 2: $result = 'paid'; break;
			case 3: $result = 'closed'; break;
			case 4: $result = 'cancel'; break;
			default: $result = $this->status;
		}
		return $result;
	}

	public function set_notes($notes) {
		$this->notes = $notes;
	}

	public function get_notes() {
		return $this->notes;
	}

	public function set_last_installment($last_installment) {
		$this->last_installment = $last_installment;
	}

	public function get_last_installment() {
		return $this->last_installment;
	}

	public function set_received_amount($received_amount) {
		$this->received_amount = (double)$received_amount;
	}

	public function get_received_amount($format=FALSE) {
		if ($format === TRUE) {
			return number_format($this->received_amount);
		}
		return $this->received_amount;
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
	 * Method untuk melakukan mapping dari standard object ke invoice.
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
			$tmp = new Invoice();
			$tmp->set_id($result->id);
			if (isset($result->code)) {
				$tmp->set_code($result->code);
			}
			$tmp->set_created_date($result->created_date);
			$tmp->set_due_date($result->due_date);
			$tmp->set_description($result->description);
			$tmp->set_id_employee($result->id_employee);
			$tmp->set_id_student($result->id_student);
			$tmp->set_id_rate($result->id_rate);
			$tmp->set_amount($result->amount);
			$tmp->set_status($result->status);
			$tmp->set_notes($result->notes);
			$tmp->set_last_installment($result->last_installment);
			$tmp->set_received_amount($result->received_amount);
			$tmp->set_created($result->created);
			$tmp->set_modified($result->modified);
			$tmp->set_modified_by($result->modified_by);
			$tmp->sisa_bayar = $result->sisa_bayar;
			
			// inject siswa
			if (isset($result->siswa_id)) {
				$siswa = new Siswa();
				$siswa->set_id($result->siswa_id);
				$siswa->set_namalengkap($result->namalengkap);
				$tmp->siswa = clone $siswa;
				$siswa = NULL;
			}
			
			// inject orang tua
			if (isset($result->orang_tua_id)) {
				$ortu = new Orang_Tua();
				$ortu->set_id($result->orang_tua_id);
				$ortu->set_nosms($result->nosms);
				$tmp->orang_tua = clone $ortu;
				$ortu = NULL;
			}
			
			// inject object rate
			$rate = new Rate();
			$rate->set_id($result->rate_id);
			$rate->set_name($result->rate_name);
			$rate->set_recurrence($result->rate_recurrence);
			$rate->set_installment($result->rate_installment);
			$tmp->rate = clone $rate;
			
			$rate = NULL;
			
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
			'sisa_bayar',
			'rate',
			'orang_tua',
			'siswa'
		);
		$exclude = array_merge($def_exclude, $param_exclude);
		
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Invoice::export tidak benar.');
	}

	public function generate_code($tahunAkademik) {
		$noinduk = $this->siswa->get_noinduk();
		$id_rate = $this->rate->get_id();
		$kategori = strtoupper($this->rate->get_category());
		$kategori = str_replace(array('UANG ', ' '), '', $kategori);
		$kategori = substr($kategori, 0, 6);
		$frekuensi = $this->rate->get_recurrence();

		$result = sprintf('%s/%s.%d/%s', $noinduk, $kategori, $id_rate, $tahunAkademik->get_stamp($frekuensi));

		return $result;
	}
}

	
// --- CI Model ---
class Invoice_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_invoice($where=array(), $limit=-1, $offset=0, $order='') {
		// join dengan rate untuk mendapatkan jumlah installment atau recurrence
		$this->db->select('ar_invoice.*, (ar_invoice.amount - ar_invoice.received_amount) sisa_bayar');
		$this->db->select('ar_rate.id rate_id, ar_rate.name rate_name, ar_rate.recurrence rate_recurrence, ar_rate.installment rate_installment');
		$this->db->join('ar_rate', 'ar_rate.id=ar_invoice.id_rate', 'left');
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		if (!empty($order)) {
			$this->db->order_by($order);
		}
		$query = $this->db->get(INVOICE_TABLE);
		if ($query->num_rows == 0) {
			throw new InvoiceNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Invoice::import_from_array($result);
	}
	
	public function get_all_open_invoice($where=array(), $limit=-1, $offset=0) {
		// invoice yang masih belum lunas -> Open atau Paid
		$where_open = sprintf("(ar_invoice.status='%s' OR ar_invoice.status='%s')",
						self::get_status_by_name('open'),
						self::get_status_by_name('paid')
				);
		$this->db->where($where_open);
		
		return $this->get_all_invoice($where, $limit, $offset);
	}
	
	public function get_all_closed_invoice($where=array(), $limit=-1, $offset=0) {
		$this->db->where(array('ar_invoice.status' => self::get_status_by_name('closed')));
		$this->db->where($where);
		
		return $this->get_all_invoice($where, $limit, $offsett);
	}
	
	public function get_all_canceled_invoice($where=array(), $limit=-1, $offset=0) {
		$this->db->where(array('ar_invoice.status' => self::get_status_by_name('cancel')));
		$this->db->where($where);
		
		return $this->get_all_invoice($where, $limit, $offsett);
	}
	
	public function get_all_due_date_invoice($where=array(), $limit=-1, $offset=0) {
		$this->db->select('sis_siswa.id siswa_id, sis_siswa.namalengkap, sis_orangtua.id orang_tua_id, sis_orangtua.nosms');
		$this->db->join('sis_siswa', 'sis_siswa.id=ar_invoice.id_student', 'left');
		$this->db->join('sis_orangtua', 'sis_orangtua.id=sis_siswa.sis_orangtua_id', 'left');
		$this->db->join('ar_invoice_outbox', 'ar_invoice_outbox.invoice_id=ar_invoice.id', 'left');
		
		$this->db->where(array('ar_rate.notification' => 1));
		$this->db->where('ar_invoice.due_date < CURRENT_DATE()', NULL, FALSE);
		$this->db->where('sis_orangtua.nosms IS NOT NULL', NULL, FALSE);
		$this->db->where('ar_invoice.due_date IS NOT NULL', NULL, FALSE);
		$this->db->where('ar_invoice_outbox.invoice_id IS NULL', NULL, FALSE);
		
		return $this->get_all_invoice($where, $limit, $offset);
	}
	
	public function get_single_invoice($where=array(), $order='') {
		$record = $this->get_all_invoice($where, 1, 0, $order);
			
		return $record[0];
	}
	
	public function insert($invoice) {
		if (FALSE === ($invoice instanceof Invoice)) {
			throw new Exception('Argumen yang diberikan untuk method Invoice_model::insert harus berupa instance dari object Invoice.');
		}

		//berikut ini adalah default value saat membuat tagihan baru
		$now = date('Y-m-d H:i:s');
		$invoice->set_created($now);
		$invoice->set_modified($now);
		$invoice->set_created_date($now);
		$invoice->set_status(1);
		$invoice->set_last_installment(0);
		$invoice->set_received_amount(0);
		
		$data = $invoice->export('array', array('siswa', 'rate', 'isNew'));
		$this->db->insert(INVOICE_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data invoice.'));
		}
		
		$invoice->set_id($this->db->insert_id());
	}
	
	public function update($invoice, $exclude=array()) {
		if (FALSE === ($invoice instanceof Invoice)) {
			throw new Exception('Argumen yang diberikan untuk method Invoice_model::update harus berupa instance dari object Invoice.');
		}

		$invoice->set_modified(date('Y-m-d H:i:s'));
		
		$data = $invoice->export('array', $exclude);
		$where = array('id' => $invoice->get_id());
		$this->db->where($where);
		$this->db->update(INVOICE_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}

		return $this->db->affected_rows();
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(INVOICE_TABLE, $data);
	}
	
	public function delete($invoice) {
		if (FALSE === ($invoice instanceof Invoice)) {
			throw new Exception('Argumen yang diberikan untuk method invoice_model::insert harus berupa instance dari object Invoice.');
		}
		
		$where = array('id' => $invoice->get_id());
		$this->db->delete(INVOICE_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(INVOICE_TABLE, $where);
	}
	
	/**
	 * Method untuk mendapatkan id dan nama status invoice
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return array
	 */
	public static function get_all_status() {
		return array(
			1 => 'open',
			2 => 'paid',
			3 => 'closed',
			4 => 'cancel'
		);
	}
	
	/**
	 * Method untuk mengembalikan nama dari status berdasarkan id
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param int $id_status - ID status yang dicari
	 * @return array
	 * @throw Exception
	 */
	public function get_status_by_id($id_status) {
		if (array_key_exists($id_status)) {
			$status = self::get_all_status();
			return $status[$id_status];
		}
		
		throw new Exception ('Argument status ID yang diberikan pada method Invoice_model::get_status_by_id tidak ada.');
	}
	
	/**
	 * Method untuk mengembalikan Id dari status berdasarkan nama
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param string $nama - Nama status yang dicari
	 * @return array
	 * @throw Exception
	 */
	public function get_status_by_name($nama) {
		$nama = trim(strtolower($nama));
		
		// jika nama 'canceled' maka ubah menjadi 'cancel' :)
		if ($nama === 'canceled') {
			$nama = 'cancel';
		}
		
		$status = self::get_all_status();
		$key = array_search($nama, $status);
		if ($key !== FALSE) {
			return $key;
		}
		
		throw new Exception ('Argument nama status yang diberikan pada method Invoice_model::get_status_by_name tidak ada.');
	}

	public function find_by_pk($id) {
		return $this->get_single_invoice(array('ar_invoice.id'=>$id));
	}
}


class InvoiceNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
