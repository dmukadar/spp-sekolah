<?php
class M_vtarif_khusus extends CI_Model{ // Buat class 
function __construct()
    {
        parent::__construct();
    }
	
  	
	function get_all($filter=array()){
	$this->load->model("M_vtarif_khusus");
		$this->db->select("sis_siswa.namalengkap, sis_siswa.noinduk, sis_kelasaktif.dm_kelas_id,sis_kelasaktif.namakelas, ar_rate.id, ar_rate.name, ar_rate.description, ar_custom_rate.fare, ar_custom_rate.id, ar_custom_rate.id_student");				
		$this->db->where('ar_rate.id = ar_custom_rate.id AND sis_siswa.id = ar_custom_rate.id_student and sis_kelasaktif.dm_kelas_id=sis_siswa.dm_kelas_id');
		$this->db->where($filter);
		//SELECT sis_siswa.namalengkap, sis_siswa.noinduk, sis_kelasaktif.dm_kelas_id,sis_kelasaktif.namakelas, ar_rate.id, ar_rate.name, ar_rate.description, ar_custom_rate.fare, ar_custom_rate.id, ar_custom_rate.id_student FROM ar_custom_rate, ar_rate, sis_siswa,sis_kelasaktif WHERE ar_rate.id = ar_custom_rate.id AND sis_siswa.id = ar_custom_rate.id_student and sis_kelasaktif.dm_kelas_id=sis_siswa.dm_kelas_id LIMIT 0 , 30
		$this->db->order_by("ar_rate.id");
		$query = $this->db->get("ar_custom_rate, ar_rate, sis_siswa,sis_kelasaktif");
		return $query;
	}
	
	function update($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('ar_custom_rate',$data);
	}
	
	function check_unit_exist($filter=""){
	$this->load->model("M_vtarif_khusus");
		$this->db->select("ar_rate.id,ar_rate.name,ar_rate.description,ar_custom_rate.fare, ar_custom_rate.id_student");		
		$this->db->where(array("id" => $filter));
		$query = $this->db->get("ar_rate,ar_custom_rate");
		$num=$query->num_rows();
		if($num == 0){
			$this->db->insert('ar_custom_rate',array("id" => $filter));
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
