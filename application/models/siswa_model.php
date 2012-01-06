<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('SISWA_TABLE', 'sis_siswa');

class Siswa {
	private $id = NULL;
	private $noinduk = NULL;
	private $nisn = NULL;
	private $nodaftar = NULL;
	private $tgldaftar = NULL;
	private $dm_jenjang_id = NULL;
	private $dm_kelas_id = NULL;
	private $namalengkap = NULL;
	private $namapanggilan = NULL;
	private $jeniskelamin = NULL;
	private $jmlsaudara = NULL;
	private $anakke = NULL;
	private $tempatlahir = NULL;
	private $tgllahir = NULL;
	private $alamat = NULL;
	private $telp = NULL;
	private $dm_agama_id = NULL;
	private $bahasaibu = NULL;
	private $bahasalisan = NULL;
	private $tinggaldengan = NULL;
	private $sekolahasal = NULL;
	private $alamatsekolah = NULL;
	private $tahunsekolah = NULL;
	private $iq = NULL;
	private $gayabelajar = NULL;
	private $kecerdasanmajemuk = NULL;
	private $kesulitanbelajar = NULL;
	private $sis_orangtua_id = NULL;
	private $sis_wali_id = NULL;
	private $dm_statussiswa_id = NULL;
	private $idstatussiswa = NULL;

	public function __construct() {
	}

	public function set_id($id) {
		$this->id = $id;
	}

	public function get_id() {
		return $this->id;
	}

	public function set_noinduk($noinduk) {
		$this->noinduk = $noinduk;
	}

	public function get_noinduk() {
		return $this->noinduk;
	}

	public function set_nisn($nisn) {
		$this->nisn = $nisn;
	}

	public function get_nisn() {
		return $this->nisn;
	}

	public function set_nodaftar($nodaftar) {
		$this->nodaftar = $nodaftar;
	}

	public function get_nodaftar() {
		return $this->nodaftar;
	}

	public function set_tgldaftar($tgldaftar) {
		$this->tgldaftar = $tgldaftar;
	}

	public function get_tgldaftar() {
		return $this->tgldaftar;
	}

	public function set_dm_jenjang_id($dm_jenjang_id) {
		$this->dm_jenjang_id = $dm_jenjang_id;
	}

	public function get_dm_jenjang_id() {
		return $this->dm_jenjang_id;
	}

	public function set_dm_kelas_id($dm_kelas_id) {
		$this->dm_kelas_id = $dm_kelas_id;
	}

	public function get_dm_kelas_id() {
		return $this->dm_kelas_id;
	}

	public function set_namalengkap($namalengkap) {
		$this->namalengkap = $namalengkap;
	}

	public function get_namalengkap() {
		return $this->namalengkap;
	}

	public function set_namapanggilan($namapanggilan) {
		$this->namapanggilan = $namapanggilan;
	}

	public function get_namapanggilan() {
		return $this->namapanggilan;
	}

	public function set_jeniskelamin($jeniskelamin) {
		$this->jeniskelamin = $jeniskelamin;
	}

	public function get_jeniskelamin() {
		return $this->jeniskelamin;
	}

	public function set_jmlsaudara($jmlsaudara) {
		$this->jmlsaudara = $jmlsaudara;
	}

	public function get_jmlsaudara() {
		return $this->jmlsaudara;
	}

	public function set_anakke($anakke) {
		$this->anakke = $anakke;
	}

	public function get_anakke() {
		return $this->anakke;
	}

	public function set_tempatlahir($tempatlahir) {
		$this->tempatlahir = $tempatlahir;
	}

	public function get_tempatlahir() {
		return $this->tempatlahir;
	}

	public function set_tgllahir($tgllahir) {
		$this->tgllahir = $tgllahir;
	}

	public function get_tgllahir() {
		return $this->tgllahir;
	}

	public function set_alamat($alamat) {
		$this->alamat = $alamat;
	}

	public function get_alamat() {
		return $this->alamat;
	}

	public function set_telp($telp) {
		$this->telp = $telp;
	}

	public function get_telp() {
		return $this->telp;
	}

	public function set_dm_agama_id($dm_agama_id) {
		$this->dm_agama_id = $dm_agama_id;
	}

	public function get_dm_agama_id() {
		return $this->dm_agama_id;
	}

	public function set_bahasaibu($bahasaibu) {
		$this->bahasaibu = $bahasaibu;
	}

	public function get_bahasaibu() {
		return $this->bahasaibu;
	}

	public function set_bahasalisan($bahasalisan) {
		$this->bahasalisan = $bahasalisan;
	}

	public function get_bahasalisan() {
		return $this->bahasalisan;
	}

	public function set_tinggaldengan($tinggaldengan) {
		$this->tinggaldengan = $tinggaldengan;
	}

	public function get_tinggaldengan() {
		return $this->tinggaldengan;
	}

	public function set_sekolahasal($sekolahasal) {
		$this->sekolahasal = $sekolahasal;
	}

	public function get_sekolahasal() {
		return $this->sekolahasal;
	}

	public function set_alamatsekolah($alamatsekolah) {
		$this->alamatsekolah = $alamatsekolah;
	}

	public function get_alamatsekolah() {
		return $this->alamatsekolah;
	}

	public function set_tahunsekolah($tahunsekolah) {
		$this->tahunsekolah = $tahunsekolah;
	}

	public function get_tahunsekolah() {
		return $this->tahunsekolah;
	}

	public function set_iq($iq) {
		$this->iq = $iq;
	}

	public function get_iq() {
		return $this->iq;
	}

	public function set_gayabelajar($gayabelajar) {
		$this->gayabelajar = $gayabelajar;
	}

	public function get_gayabelajar() {
		return $this->gayabelajar;
	}

	public function set_kecerdasanmajemuk($kecerdasanmajemuk) {
		$this->kecerdasanmajemuk = $kecerdasanmajemuk;
	}

	public function get_kecerdasanmajemuk() {
		return $this->kecerdasanmajemuk;
	}

	public function set_kesulitanbelajar($kesulitanbelajar) {
		$this->kesulitanbelajar = $kesulitanbelajar;
	}

	public function get_kesulitanbelajar() {
		return $this->kesulitanbelajar;
	}

	public function set_sis_orangtua_id($sis_orangtua_id) {
		$this->sis_orangtua_id = $sis_orangtua_id;
	}

	public function get_sis_orangtua_id() {
		return $this->sis_orangtua_id;
	}

	public function set_sis_wali_id($sis_wali_id) {
		$this->sis_wali_id = $sis_wali_id;
	}

	public function get_sis_wali_id() {
		return $this->sis_wali_id;
	}

	public function set_dm_statussiswa_id($dm_statussiswa_id) {
		$this->dm_statussiswa_id = $dm_statussiswa_id;
	}

	public function get_dm_statussiswa_id() {
		return $this->dm_statussiswa_id;
	}

	public function set_idstatussiswa($idstatussiswa) {
		$this->idstatussiswa = $idstatussiswa;
	}

	public function get_idstatussiswa() {
		return $this->idstatussiswa;
	}

	/**
	 * Method untuk melakukan mapping dari standard object ke siswa.
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
			$tmp = new Siswa();
			$tmp->set_id($result->id);
			$tmp->set_noinduk($result->noinduk);
			$tmp->set_nisn($result->nisn);
			$tmp->set_nodaftar($result->nodaftar);
			$tmp->set_tgldaftar($result->tgldaftar);
			$tmp->set_dm_jenjang_id($result->dm_jenjang_id);
			$tmp->set_dm_kelas_id($result->dm_kelas_id);
			$tmp->set_namalengkap($result->namalengkap);
			$tmp->set_namapanggilan($result->namapanggilan);
			$tmp->set_jeniskelamin($result->jeniskelamin);
			$tmp->set_jmlsaudara($result->jmlsaudara);
			$tmp->set_anakke($result->anakke);
			$tmp->set_tempatlahir($result->tempatlahir);
			$tmp->set_tgllahir($result->tgllahir);
			$tmp->set_alamat($result->alamat);
			$tmp->set_telp($result->telp);
			$tmp->set_dm_agama_id($result->dm_agama_id);
			$tmp->set_bahasaibu($result->bahasaibu);
			$tmp->set_bahasalisan($result->bahasalisan);
			$tmp->set_tinggaldengan($result->tinggaldengan);
			$tmp->set_sekolahasal($result->sekolahasal);
			$tmp->set_alamatsekolah($result->alamatsekolah);
			$tmp->set_tahunsekolah($result->tahunsekolah);
			$tmp->set_iq($result->iq);
			$tmp->set_gayabelajar($result->gayabelajar);
			$tmp->set_kecerdasanmajemuk($result->kecerdasanmajemuk);
			$tmp->set_kesulitanbelajar($result->kesulitanbelajar);
			$tmp->set_sis_orangtua_id($result->sis_orangtua_id);
			$tmp->set_sis_wali_id($result->sis_wali_id);
			$tmp->set_dm_statussiswa_id($result->dm_statussiswa_id);
			$tmp->set_idstatussiswa($result->idstatussiswa);
			
			// inject object kelas
			$kelas = new Kelas();
			$kelas->set_id($result->dm_kelas_id);
			$kelas->set_dm_jenjang_id($result->dm_jenjang_id);
			$kelas->set_kelas($result->kelas);
			$kelas->set_jenjang($result->kelas_jenjang);
			$kelas->set_angka($result->kelas_angka);
			$tmp->kelas = clone $kelas;
			$kelas = NULL;
			
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
		throw new Exception('Sepertinya argumen yang anda berikan pada method Siswa::export tidak benar.');
	}
}

	
// --- CI Model ---
class Siswa_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_siswa($where=array(), $limit=-1, $offset=0) {
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		
		// selalu joinkan dengan table dm_klass
		$this->db->select('sis_siswa.*, dm_kelas.kelas, dm_kelas.jenjang kelas_jenjang, dm_kelas.angka kelas_angka');
		$this->db->join('dm_kelas', 'dm_kelas.id=sis_siswa.dm_kelas_id', 'left');
		
		// kita hanya interest dengan siswa yang aktif
		$default_where = array('sis_siswa.dm_statussiswa_id' => self::get_status_siswa_by_label('siswa'));
		
		// kombinasikan, jika $where yang disupply programmer terdapat key 
		// maka sis_siswa.dm_statussiswa_id otomatis $default_where diatas akan 
		// di overwrite
		$where = $where + $default_where;
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get(SISWA_TABLE);
		if ($query->num_rows == 0) {
			throw new SiswaNotFoundException ("Record tidak ditemukan.");
		}
		
		$result = $query->result();
		
		return Siswa::import_from_array($result);
	}
	
	public function get_single_siswa($where=array()) {
		$record = $this->get_all_siswa($where, 1, 0);
			
		return $record[0];
	}
	
	public function get_all_siswa_ajax($nama_siswa, $limit=-1, $offset=0) {
		$this->db->like('sis_siswa.namalengkap', $nama_siswa, 'after');
		$this->db->order_by('sis_siswa.namalengkap', 'ASC');
		return $this->get_all_siswa(array(), $limit, $offset);
	}
	
	public function insert($siswa) {
		if (FALSE === ($siswa instanceof Siswa)) {
			throw new Exception('Argumen yang diberikan untuk method Siswa_model::insert harus berupa instance dari object Siswa.');
		}
		
		$data = $siswa->export();
		$this->db->insert(SISWA_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data siswa.'));
		}
	}
	
	public function update($siswa, $exclude=array()) {
		if (FALSE === ($siswa instanceof Siswa)) {
			throw new Exception('Argumen yang diberikan untuk method Siswa_model::update harus berupa instance dari object Siswa.');
		}
		
		$data = $siswa->export('array', $exclude);
		$where = array('id' => $siswa->get_id());
		$this->db->where($where);
		$this->db->update(SISWA_TABLE, $data);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update($where, $data) {
		$this->db->where($where);
		$this->db->update(SISWA_TABLE, $data);
	}
	
	public function delete($siswa) {
		if (FALSE === ($siswa instanceof Siswa)) {
			throw new Exception('Argumen yang diberikan untuk method siswa_model::insert harus berupa instance dari object Siswa.');
		}
		
		$where = array('id' => $siswa->get_id());
		$this->db->delete(SISWA_TABLE, $where);
		
		if ($this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete($where) {
		$this->db->delete(SISWA_TABLE, $where);
	}
	
	/**
	 * Method untuk mendapatkan mapping ID dari status siswa. Ini merupakan
	 * Static mapping dari tabel dm_statussiswa.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param string $label - Nama status/label yang ingin dicari ID-nya
	 * @return int
	 * @throw Exception
	 */
	public static function get_status_siswa_by_label($label) {
		$label = strtolower($label);
		switch ($label) {
			case 'siswa':
				return 1;
			break;
			
			case 'lulus':
				return 2;
			break;
			
			case 'keluar':
				return 3;
			break;
			
			default:
				// data label yang disupply tidak sesuai dengan yang 
				// kita sediakan, untuk menghindari kesalahan FATAL
				// sebaiknya beritahukan pemanggil method dengan
				// mengeluarkan exception
				throw new Exception (sprintf('Argumen status yang anda berikan pada method Siswa_model::get_status_siswa_by_label tidak ditemukan.'));
			break;
		}
	}
}


class SiswaNotFoundException extends Exception {
	public function __construct($mesg, $code=101) {
		parent::__construct($mesg, $code);
	}
}
