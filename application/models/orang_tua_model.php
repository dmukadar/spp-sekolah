<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ORANG_TUA_TABLE', 'sis_orangtua');

class Orang_Tua {
	private $id = NULL;
	private $namaayah = NULL;
	private $tempatlahirayah = NULL;
	private $tgllahirayah = NULL;
	private $agamaayah = NULL;
	private $warganegaraayah = NULL;
	private $pendidikanayah = NULL;
	private $pekerjaanayah = NULL;
	private $instansiayah = NULL;
	private $penghasilanayah = NULL;
	private $alamatayah = NULL;
	private $notelpayah = NULL;
	private $nohpayah = NULL;
	private $emailayah = NULL;
	private $nosms = NULL;
	private $namaibu = NULL;
	private $tempatlahiribu = NULL;
	private $tgllahiribu = NULL;
	private $agamaibu = NULL;
	private $warganegaraibu = NULL;
	private $pendidikanibu = NULL;
	private $pekerjaanibu = NULL;
	private $instansiibu = NULL;
	private $penghasilanibu = NULL;
	private $alamatibu = NULL;
	private $notelpibu = NULL;
	private $nohpibu = NULL;
	private $emailibu = NULL;

	public function __construct() {
	}

	public function set_id($id) {
		$this->id = $id;
	}

	public function get_id() {
		return $this->id;
	}

	public function set_namaayah($namaayah) {
		$this->namaayah = $namaayah;
	}

	public function get_namaayah() {
		return $this->namaayah;
	}

	public function set_tempatlahirayah($tempatlahirayah) {
		$this->tempatlahirayah = $tempatlahirayah;
	}

	public function get_tempatlahirayah() {
		return $this->tempatlahirayah;
	}

	public function set_tgllahirayah($tgllahirayah) {
		$this->tgllahirayah = $tgllahirayah;
	}

	public function get_tgllahirayah() {
		return $this->tgllahirayah;
	}

	public function set_agamaayah($agamaayah) {
		$this->agamaayah = $agamaayah;
	}

	public function get_agamaayah() {
		return $this->agamaayah;
	}

	public function set_warganegaraayah($warganegaraayah) {
		$this->warganegaraayah = $warganegaraayah;
	}

	public function get_warganegaraayah() {
		return $this->warganegaraayah;
	}

	public function set_pendidikanayah($pendidikanayah) {
		$this->pendidikanayah = $pendidikanayah;
	}

	public function get_pendidikanayah() {
		return $this->pendidikanayah;
	}

	public function set_pekerjaanayah($pekerjaanayah) {
		$this->pekerjaanayah = $pekerjaanayah;
	}

	public function get_pekerjaanayah() {
		return $this->pekerjaanayah;
	}

	public function set_instansiayah($instansiayah) {
		$this->instansiayah = $instansiayah;
	}

	public function get_instansiayah() {
		return $this->instansiayah;
	}

	public function set_penghasilanayah($penghasilanayah) {
		$this->penghasilanayah = $penghasilanayah;
	}

	public function get_penghasilanayah() {
		return $this->penghasilanayah;
	}

	public function set_alamatayah($alamatayah) {
		$this->alamatayah = $alamatayah;
	}

	public function get_alamatayah() {
		return $this->alamatayah;
	}

	public function set_notelpayah($notelpayah) {
		$this->notelpayah = $notelpayah;
	}

	public function get_notelpayah() {
		return $this->notelpayah;
	}

	public function set_nohpayah($nohpayah) {
		$this->nohpayah = $nohpayah;
	}

	public function get_nohpayah() {
		return $this->nohpayah;
	}

	public function set_emailayah($emailayah) {
		$this->emailayah = $emailayah;
	}

	public function get_emailayah() {
		return $this->emailayah;
	}

	public function set_nosms($nosms) {
		$this->nosms = $nosms;
	}

	public function get_nosms() {
		return $this->nosms;
	}

	public function set_namaibu($namaibu) {
		$this->namaibu = $namaibu;
	}

	public function get_namaibu() {
		return $this->namaibu;
	}

	public function set_tempatlahiribu($tempatlahiribu) {
		$this->tempatlahiribu = $tempatlahiribu;
	}

	public function get_tempatlahiribu() {
		return $this->tempatlahiribu;
	}

	public function set_tgllahiribu($tgllahiribu) {
		$this->tgllahiribu = $tgllahiribu;
	}

	public function get_tgllahiribu() {
		return $this->tgllahiribu;
	}

	public function set_agamaibu($agamaibu) {
		$this->agamaibu = $agamaibu;
	}

	public function get_agamaibu() {
		return $this->agamaibu;
	}

	public function set_warganegaraibu($warganegaraibu) {
		$this->warganegaraibu = $warganegaraibu;
	}

	public function get_warganegaraibu() {
		return $this->warganegaraibu;
	}

	public function set_pendidikanibu($pendidikanibu) {
		$this->pendidikanibu = $pendidikanibu;
	}

	public function get_pendidikanibu() {
		return $this->pendidikanibu;
	}

	public function set_pekerjaanibu($pekerjaanibu) {
		$this->pekerjaanibu = $pekerjaanibu;
	}

	public function get_pekerjaanibu() {
		return $this->pekerjaanibu;
	}

	public function set_instansiibu($instansiibu) {
		$this->instansiibu = $instansiibu;
	}

	public function get_instansiibu() {
		return $this->instansiibu;
	}

	public function set_penghasilanibu($penghasilanibu) {
		$this->penghasilanibu = $penghasilanibu;
	}

	public function get_penghasilanibu() {
		return $this->penghasilanibu;
	}

	public function set_alamatibu($alamatibu) {
		$this->alamatibu = $alamatibu;
	}

	public function get_alamatibu() {
		return $this->alamatibu;
	}

	public function set_notelpibu($notelpibu) {
		$this->notelpibu = $notelpibu;
	}

	public function get_notelpibu() {
		return $this->notelpibu;
	}

	public function set_nohpibu($nohpibu) {
		$this->nohpibu = $nohpibu;
	}

	public function get_nohpibu() {
		return $this->nohpibu;
	}

	public function set_emailibu($emailibu) {
		$this->emailibu = $emailibu;
	}

	public function get_emailibu() {
		return $this->emailibu;
	}

	/**
	 * Method untuk melakukan mapping dari standard object ke orang_tua.
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
			$tmp = new Orang_Tua();
			$tmp->set_id($result->id);
			$tmp->set_namaayah($result->namaayah);
			$tmp->set_tempatlahirayah($result->tempatlahirayah);
			$tmp->set_tgllahirayah($result->tgllahirayah);
			$tmp->set_agamaayah($result->agamaayah);
			$tmp->set_warganegaraayah($result->warganegaraayah);
			$tmp->set_pendidikanayah($result->pendidikanayah);
			$tmp->set_pekerjaanayah($result->pekerjaanayah);
			$tmp->set_instansiayah($result->instansiayah);
			$tmp->set_penghasilanayah($result->penghasilanayah);
			$tmp->set_alamatayah($result->alamatayah);
			$tmp->set_notelpayah($result->notelpayah);
			$tmp->set_nohpayah($result->nohpayah);
			$tmp->set_emailayah($result->emailayah);
			$tmp->set_nosms($result->nosms);
			$tmp->set_namaibu($result->namaibu);
			$tmp->set_tempatlahiribu($result->tempatlahiribu);
			$tmp->set_tgllahiribu($result->tgllahiribu);
			$tmp->set_agamaibu($result->agamaibu);
			$tmp->set_warganegaraibu($result->warganegaraibu);
			$tmp->set_pendidikanibu($result->pendidikanibu);
			$tmp->set_pekerjaanibu($result->pekerjaanibu);
			$tmp->set_instansiibu($result->instansiibu);
			$tmp->set_penghasilanibu($result->penghasilanibu);
			$tmp->set_alamatibu($result->alamatibu);
			$tmp->set_notelpibu($result->notelpibu);
			$tmp->set_nohpibu($result->nohpibu);
			$tmp->set_emailibu($result->emailibu);
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Orang_Tua::export tidak benar.');
	}
}

	
// --- CI Model ---
class Orang_Tua_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_orang_tua($where=array(), $limit=-1, $offset=0) {
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(ORANG_TUA_TABLE);
		if ($query->num_rows == 0) {
			throw new Orang_TuaNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Orang_Tua::import_from_array($result);
	}
	
	public function get_single_orang_tua($where=array()) {
		$record = $this->get_all_orang_tua($where, 1, 0);
			
		return $record[0];
	}
	
	public function insert($orang_tua) {
		if (FALSE === ($orang_tua instanceof Orang_Tua)) {
			throw new Exception('Argumen yang diberikan untuk method Orang_Tua_model::insert harus berupa instance dari object Orang_Tua.');
		}
		
		$data = $orang_tua->export();
		$this->db->insert(ORANG_TUA_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data orang_tua.'));
		}
	}
	
	public function update($orang_tua, $exclude=array()) {
		if (FALSE === ($orang_tua instanceof Orang_Tua)) {
			throw new Exception('Argumen yang diberikan untuk method Orang_Tua_model::update harus berupa instance dari object Orang_Tua.');
		}
		
		$data = $orang_tua->export('array', $exclude);
		$where = array('id' => $orang_tua->get_id());
		$this->db->where($where);
		$this->db->update(ORANG_TUA_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(ORANG_TUA_TABLE, $data);
	}
	
	public function delete($orang_tua) {
		if (FALSE === ($orang_tua instanceof Orang_Tua)) {
			throw new Exception('Argumen yang diberikan untuk method orang_tua_model::insert harus berupa instance dari object Orang_Tua.');
		}
		
		$where = array('id' => $orang_tua->get_id());
		$this->db->delete(ORANG_TUA_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(ORANG_TUA_TABLE, $where);
	}
}


class Orang_TuaNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
