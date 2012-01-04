<?php
class M_tarif_khusus extends CI_Model{ // Buat class 
function __construct()
    {
        parent::__construct();
    }

function get_all_sis($filter=array()){
	$this->load->model("M_tarif_khusus");
		$this->db->select("sis_siswa.id,sis_siswa.namalengkap, sis_siswa.noinduk, sis_kelasaktif.dm_kelas_id, sis_kelasaktif.namakelas");				
		$this->db->where('sis_kelasaktif.dm_kelas_id = sis_siswa.dm_kelas_id');
		$this->db->where($filter);
		//SELECT sis_siswa.id,sis_siswa.namalengkap, sis_siswa.noinduk, sis_kelasaktif.dm_kelas_id, sis_kelasaktif.namakelas FROM sis_siswa, sis_kelasaktif WHERE sis_kelasaktif.dm_kelas_id = sis_siswa.dm_kelas_id LIMIT 0 , 30
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("sis_siswa, sis_kelasaktif");
		return $query;
	}

function get_all_tarif($filter=array()){
	    $this->load->model("M_tarif_khusus");
		$this->db->select("*");		
		$this->db->where($filter);
		$this->db->order_by("id");
		$query = $this->db->get("ar_rate");			
	    return $query;
	}

function insert($data=array()){
	$this->load->model("M_tarif_khusus");
		return $this->db->insert('ar_custom_rate',$data);		
	}
	
	function get_kode_nama() {
	    $this->load->model("M_tarif_khusus");
		$this->db->select("id,name");		
		$this->db->order_by("name");
		$query = $this->db->get("ar_rate");
		return $query;
    }
	
	function check_unit_exist($filter=""){
	$this->load->model("M_tarif_khusus");
		$this->db->select("*");		
		$this->db->where(array("tx_id_siswa" => $filter));
		$query = $this->db->get("sis_siswa");
		$num=$query->num_rows();
		if($num == 0){
			$this->db->insert('sis_siswa',array("tx_id_siswa" => $filter));
		}
	}
	
	function get_siswa($get_data=""){
		$this->db->select("sis_siswa.id,sis_siswa.namalengkap, sis_siswa.noinduk, sis_kelasaktif.dm_kelas_id, sis_kelasaktif.namakelas");	
		$this->db->where('sis_kelasaktif.dm_kelas_id = sis_siswa.dm_kelas_id');
		//$this->db->where($filter);
		$this->db->like("sis_siswa.namalengkap",$get_data);
		$query = $this->db->get("sis_siswa, sis_kelasaktif");
		return $query;
	}
	
}
?>
