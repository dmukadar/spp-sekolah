<?php
class Buku_model extends Alazka_Controller { // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 
/*
select ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_paket,sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_nonpaket,sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_lks,sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap from ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id where ar_invoice.status = '0' and ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 group by ar_invoice.id_student 
*/ 	
	function get_all($filter=array()){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_paket,sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_nonpaket,sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_lks,sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap ");	
	    $this->db->where ("ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36)");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		

		return $query;
	}
	
function get_total($filter=array()){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_paket($filter=array()){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_nonpaket($filter=array()){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_total_lks($filter=array()){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");	
		$this->db->where("ar_invoice.status = '".$status."' ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	function get_allnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_paket,sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_nonpaket,sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_lks,sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap ");	
	    $this->db->where ("ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36) AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		

		return $query;
	}
	
	
	function get_totalnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");	
		$this->db->where("ar_invoice.status = '".$status."'  AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	
	function get_total_paketnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");	
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	
	function get_total_lksnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");	
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	
	
	function get_total_nonpaketnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("Buku_model");
	$status=$this->get_status("open");	
		$this->db->select("sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");	
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' ) ");	
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