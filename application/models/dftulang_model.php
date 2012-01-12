<?php
class Dftulang_model extends Alazka_Controller { // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 
/*
select ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_muka,sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 or  ar_invoice.id_rate=22 or ar_invoice.id_rate=23 or ar_invoice.id_rate=24 or ar_invoice.id_rate=25 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap from ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id where ar_invoice.status = '0' group by ar_invoice.id_student 
*/ 	
	function get_all($filter=array()){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_muka,sum( case when ar_invoice.id_rate=22 or ar_invoice.id_rate=23 or ar_invoice.id_rate=24 or ar_invoice.id_rate=25 then(ar_invoice.amount - ar_invoice.received_amount) else 0 end) as uang_daftar,sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 or  ar_invoice.id_rate=22 or ar_invoice.id_rate=23 or ar_invoice.id_rate=24 or ar_invoice.id_rate=25 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap");	
	    $this->db->where ("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '".$status."' and ar_invoice.id_rate='2' or ar_invoice.id_rate='20' or ar_invoice.id_rate='3' or ar_invoice.id_rate='21' or ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25'");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get(" ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		

		return $query;
	}
	
/*
select sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_muka from ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id where ar_invoice.status = '0' 
*/	
	function get_total($filter=array()){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 or ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25' then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_um($filter=array()){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_ud($filter=array()){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25' then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
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