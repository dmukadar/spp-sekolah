<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('TAHUN_TABLE', 'dm_tahunpelajaran');

class TahunAkademik {
	const SEMESTER_GENAP = 0;
	const SEMESTER_GASAL = 1;

	private $_id = NULL;
	private $_aktif = NULL;
	private $_tahun = NULL;
	private $_semester = NULL;
	private $_cawu = NULL;
	private $_bulan = NULL;

	public function __construct($id, $bulan=null, $tahun=null, $aktif=1) {

		$this->_id = $id;
		$this->_aktif = $aktif;
		$this->set_bulan($bulan);
		$this->set_tahun($tahun);
	}
	
	//param: yyyy, yyyy-yyyy atau null untuk default value
	//agar tahun yg diset valid, selalu set bulan terlebih dahulu (menentukan semester)
	public function set_tahun($tahun, $checkSemester = true) {
			if (preg_match('/\d{4}-\d{4}/', $tahun)) list($tahun) = explode('-', $tahun);
			else if (!preg_match('/\d{4}/', $tahun)) $tahun = date('Y');

			if (! $checkSemester) $this->_tahun = (int) $tahun;
			else {
				if ($this->semester_is_gasal()) $this->_tahun = (int) $tahun;
				else $this->_tahun = ((int) $tahun) - 1;
			}
	}

	public function set_id($id) {
		$this->_id = (int)$id;
	}

	public function get_id() {
		return $this->_id;
	}

	public function set_aktif($aktif) {
		$this->_aktif = (int)$aktif;
	}

	public function get_aktif() {
		return $this->_aktif;
	}

	public function set_bulan($bulan) {
		$bulanGenap = range(1, 6);
		$bulanGasal = range(7, 12);

		$this->_bulan = (int) $bulan;

	  if (! in_array($this->_bulan, range(1, 12))) $this->_bulan = (int)date('m');

		$this->_semester = in_array($this->_bulan, $bulanGenap) ? TahunAkademik::SEMESTER_GENAP : TahunAkademik::SEMESTER_GASAL;
	}

	public function semester_is_gasal() {
		return $this->_semester == TahunAkademik::SEMESTER_GASAL;
	}

	public function get_bulan($format='raw') {
		$result = null;

		switch ($format) {
			case 'nama':
				$bulan = array(1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
				$result = $bulan[$this->_bulan];
				break;
			case 'romawi':
				$bulan = array(1=>'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
				$result = $bulan[$this->_bulan];
				break;
			default: $result = $this->_bulan;
		}
		return $result;
	}

	public function get_semester($format = 'raw') {
		$result = null;

		switch ($format) {
			case 'label': $result = $this->semester_is_gasal() ? 'Gasal' : 'Genap'; break;
			default: $result = $this->_semester;
		}
			
		return $result;
	}

	public function get_tahun($format = 'full') {
		switch ($format) {
			case 'raw': $result = $this->_tahun; break;
			case 'short': $result = $this->_tahun % 2000; break; //baris ini perlu diupdate 88 tahun lagi
			default: $result = sprintf('%d-%d', $this->_tahun, $this->_tahun + 1);
		}
		return $result;
	}

	//macam2 format harus sama dengan ar_rate.recurrence
	public function get_stamp($format = 'tahun') {
		switch ($format) {
			case 'bulan': $result = sprintf('%02d%d%d', $this->get_bulan(), $this->get_semester(), $this->get_tahun('short')); break;
			case 'semester': $result = sprintf('%d%d', $this->get_semester(), $this->get_tahun('short')); break;
			default: $result = $this->get_tahun();
		}
		return $result;
	}

	public function set_by_date($tanggal) {
		$tanggal = strtotime($tanggal);
		if ($tanggal === -1) throw new Exception('invalid date format');
		else {
			$this->set_bulan(date('m', $tanggal));
			$this->set_tahun(date('Y', $tanggal));
		}
	}
}

	
// --- CI Model ---
class TahunAkademik_model extends CI_Model {
	public $berjalan = null;

	public function __construct() {
		parent::__construct();

		if (empty($this->berjalan)) {
			$this->berjalan = $this->getCurrent();
		}
	}

	private function getCurrent() {
		$tahun = null;

		try {
			$this->db->limit(1);
			$this->db->where(array('aktif'=>1));
			$query = $this->db->get(TAHUN_TABLE);
			//jika tidak ada, asumsikan tahun akademik adalah yg sedang berjalan
			if ($query->num_rows == 0) {
				$tahun = new TahunAkademik(0);
			} else {
				$record = $query->result();
				$tahun = new TahunAkademik($record[0]->id, date('m'));
				$tahun->set_tahun($record[0]->tahun, false);
			}
		} catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}

		return $tahun;
	}
}
