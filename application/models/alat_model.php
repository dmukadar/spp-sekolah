<?php
class Alat_model extends Alazka_Controller { // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 
/*
SELECT `ar_invoice`.`id_student`, `ar_invoice`.`created_date`, `ar_invoice`.`due_date`, MONTHNAME( ar_invoice.due_date ) AS bulan, `ar_invoice`.`description`, sum( case when ar_invoice.id_rate=1 then (ar_invoice.amount - ar_invoice.received_amount) else 0 end) as uang_spp, sum( case when ar_invoice.id_rate=14 then(ar_invoice.amount - ar_invoice.received_amount) else 0 end) as uang_bpps, sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then(ar_invoice.amount - ar_invoice.received_amount) else 0 end) as total, `dm_kelas`.`kelas`, `sis_siswa`.`namalengkap`, `sis_siswa`.`dm_jenjang_id` FROM (`ar_invoice` join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id) WHERE `sis_siswa`.`id` = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '0' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='1' or ar_invoice.id_rate='14') AND 
ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '2012-01-02'   or ar_invoice.`due_date` <= '2012-01-04' )

AND `dm_kelas`.`dm_jenjang_id` = '2' 
GROUP BY `ar_invoice`.`id_student` ORDER BY `sis_siswa`.`namalengkap`
*/ 	
	function get_all($filter=array()){
	$this->load->model("Alat_model");
	$status=$this->get_status("open");	
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_alat, sum( case when ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_bukulain,sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap ");	
	    $this->db->where ("ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37)");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		

		return $query;
	}
	
function get_total($filter=array()){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_alat($filter=array()){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_bukulain($filter=array()){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	///---
	
	function get_allnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Alat_model");
	$status=$this->get_status("open");	
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_alat, sum( case when ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_bukulain,sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap ");	
	    $this->db->where ("ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37) AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		

		return $query;
	}
	
function get_totalnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_alatnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_bukulainnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Dftulang_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");	
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