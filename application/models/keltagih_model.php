<?php
class Keltagih_model extends CI_Model{ // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 

	function check_siswa($id_siswa){
	$this->load->model("Keltagih_model");	
		$this->db->select("noinduk");	
		$this->db->where("noinduk", $id_siswa);
		$query = $this->db->get("sis_siswa");
		return $query->num_rows();
	}
	/*function check_siswa($id_siswa){
	$this->load->model("Keltagih_model");	
		$this->db->select("dm_kelas.kelas, sis_siswa.noinduk");	
		$this->db->where("sis_siswa.dm_kelas_id = dm_kelas.id and sis_siswa.noinduk", $id_siswa);
		$query = $this->db->get("sis_siswa,dm_kelas");
		return $query->num_rows();*/
	
	function check_group($id_siswa){
	$this->load->model("Keltagih_model");	
		$this->db->select("id_student");	
		$this->db->where("id_student", $id_siswa);
		$query = $this->db->get("ar_group_student");
		return $query->num_rows();
	}
	
	function jenjang($id_siswa){
	$this->load->model("Keltagih_model");	
		$this->db->select("dm_kelas.jenjang");	
		$this->db->where("sis_siswa.noinduk", $id_siswa);
		$query = $this->db->get("sis_siswa,dm_kelas");
		return $query;
	}
	
	function kelas($filter=array(),$id_siswa){
	$this->load->model("Keltagih_model");	
		$this->db->select("dm_kelas.kelas");	
		$this->db->where("sis_siswa.dm_kelas_id = dm_kelas.id and sis_siswa.noinduk = '".$id_siswa."'");
		$this->db->where($filter);
		$query = $this->db->get("sis_siswa,dm_kelas");
		return $query;
	}
	
	 function insert($data=array()){
	    $this->load->model("Keltagih_model");
		return $this->db->insert('ar_group_student',$data);		
	}
}
?>
