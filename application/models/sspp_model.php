<?php
class Sspp_model extends Alazka_Controller { // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 
/*
select
 sis_siswa.id AS id_siswa, sis_siswa.namalengkap,
dm_kelas.kelas, MONTHNAME( ar_payment_details.created ) AS bulan,ar_payment_details.id AS detail_id,ar_payment_details.amount, 
 ar_payment_details.created,  ar_payment.notes,ar_invoice.description,ar_rate.name,
ar_payment_details.modified, ar_payment_details.installment, 
  sis_siswa.dm_jenjang_id,ar_payment_details.status,
  sum( case when ar_invoice.id_rate=1 then (ar_payment_details.amount )  else 0 end) as uang_spp,
 sum( case when ar_invoice.id_rate=14 then(ar_payment_details.amount) else 0 end) as uang_bpps,
 sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then(ar_payment_details.amount)   else 0 end) as total
 
from ar_payment_details 
join ar_invoice on ar_payment_details.id_invoice=ar_invoice.id
join sis_siswa on ar_invoice.id_student=sis_siswa.id
join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id
join ar_payment on ar_payment_details.id_payment=ar_payment.id
join ar_rate on ar_invoice.id_rate=ar_rate.id

where sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id 
AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id
AND ar_invoice.id_rate=ar_rate.id and ar_payment.id=ar_payment_details.id_payment 
and ar_payment_details.id_invoice=ar_invoice.id and ar_invoice.id_rate='1' or ar_invoice.id_rate='14' and
ar_payment_details.id_invoice=ar_invoice.id and
ar_payment_details.status IN (SELECT ar_payment_details.status FROM ar_rate WHERE ar_payment_details.status=1 or ar_payment_details.status=2)

group by ar_invoice.id_student 
*/ 	
	function get_all($filter=array()){
	$this->load->model("Santarjemput_model");
	$payed=$this->get_status("payed");
	$closed=$this->get_status("closed");
		$this->db->select("sis_siswa.id AS id_siswa, sis_siswa.namalengkap,dm_kelas.kelas, MONTHNAME( ar_payment_details.created ) AS bulan,ar_payment_details.id AS detail_id,ar_payment_details.amount, ar_payment_details.created,  ar_payment.notes,ar_invoice.description,ar_rate.name,ar_payment_details.modified, ar_payment_details.installment, sis_siswa.dm_jenjang_id,ar_payment_details.status,sum( case when ar_invoice.id_rate=1 then (ar_payment_details.amount )  else 0 end) as uang_spp,sum( case when ar_invoice.id_rate=14 then(ar_payment_details.amount) else 0 end) as uang_bpps,sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then(ar_payment_details.amount)   else 0 end) as total");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id  AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.id_rate=ar_rate.id and ar_payment.id=ar_payment_details.id_payment  and ar_payment_details.id_invoice=ar_invoice.id and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='1' or ar_invoice.id_rate='14') and ar_payment_details.id_invoice=ar_invoice.id  and ar_payment_details.status IN (SELECT ar_payment_details.status FROM ar_rate WHERE ar_payment_details.status='".$payed."' or ar_payment_details.status='".$closed."')");	
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student");
		$this->db->order_by("dm_kelas.kelas");
		$query = $this->db->get("ar_payment_details  join ar_invoice on ar_payment_details.id_invoice=ar_invoice.id join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id join ar_payment on ar_payment_details.id_payment=ar_payment.id join ar_rate on ar_invoice.id_rate=ar_rate.id");
		return $query;
	}
	
	function get_total($filter=array()){
	$this->load->model("Sspp_model");
	$payed=$this->get_status("payed");
	$closed=$this->get_status("closed");
		$this->db->select("sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then (ar_payment_details.amount)  else 0 end) as total");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id  AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.id_rate=ar_rate.id and ar_payment.id=ar_payment_details.id_payment  and ar_payment_details.id_invoice=ar_invoice.id and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='1' or ar_invoice.id_rate='14') and ar_payment_details.id_invoice=ar_invoice.id  and ar_payment_details.status IN (SELECT ar_payment_details.status FROM ar_rate WHERE ar_payment_details.status='".$payed."' or ar_payment_details.status='".$closed."')");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_payment_details  join ar_invoice on ar_payment_details.id_invoice=ar_invoice.id join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id join ar_payment on ar_payment_details.id_payment=ar_payment.id join ar_rate on ar_invoice.id_rate=ar_rate.id");
		return $query;
	}
	
	function get_total_spp($filter=array()){
	$this->load->model("Sspp_model");
    $payed=$this->get_status("payed");
	$closed=$this->get_status("closed");
			$this->db->select("sum( case when ar_invoice.id_rate=1 then (ar_payment_details.amount)  else 0 end) as total");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id  AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.id_rate=ar_rate.id and ar_payment.id=ar_payment_details.id_payment  and ar_payment_details.id_invoice=ar_invoice.id and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='1' or ar_invoice.id_rate='14') and ar_payment_details.id_invoice=ar_invoice.id  and ar_payment_details.status IN (SELECT ar_payment_details.status FROM ar_rate WHERE ar_payment_details.status='".$payed."' or ar_payment_details.status='".$closed."')");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_payment_details  join ar_invoice on ar_payment_details.id_invoice=ar_invoice.id join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id join ar_payment on ar_payment_details.id_payment=ar_payment.id join ar_rate on ar_invoice.id_rate=ar_rate.id");
		return $query;
	}
	
	function get_total_bpps($filter=array()){
	$this->load->model("Sspp_model");
	$payed=$this->get_status("payed");
	$closed=$this->get_status("closed");  
			$this->db->select("sum( case when ar_invoice.id_rate=14 then (ar_payment_details.amount)  else 0 end) as total");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id  AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.id_rate=ar_rate.id and ar_payment.id=ar_payment_details.id_payment  and ar_payment_details.id_invoice=ar_invoice.id and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='1' or ar_invoice.id_rate='14') and ar_payment_details.id_invoice=ar_invoice.id  and ar_payment_details.status IN (SELECT ar_payment_details.status FROM ar_rate WHERE ar_payment_details.status='".$payed."' or ar_payment_details.status='".$closed."')");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_payment_details  join ar_invoice on ar_payment_details.id_invoice=ar_invoice.id join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id join ar_payment on ar_payment_details.id_payment=ar_payment.id join ar_rate on ar_invoice.id_rate=ar_rate.id");
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