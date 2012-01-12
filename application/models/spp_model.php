<?php
class Spp_model extends Alazka_Controller { // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 
/*
   select ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=1 then (
ar_invoice.amount - ar_invoice.received_amount
)  else 0 end) as SPP, sum( case when ar_invoice.id_rate=14 then(
ar_invoice.amount - ar_invoice.received_amount
)   else 0 end) as BPPS,dm_kelas.kelas,sis_siswa.namalengkap,dm_tahunpelajaran.tahun
 from ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id join dm_tahunpelajaran
where sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '0' 
group by ar_invoice.id_student 
*/ 	
	function get_all($filter=array()){
	$this->load->model("Spp_model");
	$status=$this->get_status("open");	
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=1 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_spp,sum( case when ar_invoice.id_rate=14 then(ar_invoice.amount - ar_invoice.received_amount) else 0 end) as uang_bpps,sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap");	
		  $this->db->where ("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '".$status."' and ar_invoice.id_rate='1' or ar_invoice.id_rate='14'");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get(" ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		

		return $query;
	}
	
	
	function get_total($filter=array()){
	$this->load->model("Spp_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."'");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_spp($filter=array()){
	$this->load->model("Spp_model");
	$status=$this->get_status("open");	
			$this->db->select("sum( case when ar_invoice.id_rate=1 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."'");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_bpps($filter=array()){
	$this->load->model("Spp_model");
	$status=$this->get_status("open");	
			$this->db->select("sum( case when ar_invoice.id_rate=14 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."'");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_status($status){
		$status_return=0;
		switch($status){
			case "open":
				$status_return=0;
				break;
			case "payed":
				$status_return=1;
				break;
			case "closed":
				$status_return=2;
				break;	
			case "cancel":
				$status_return=3;
				break;				
		}		
		return $status_return;
	}
}
?>