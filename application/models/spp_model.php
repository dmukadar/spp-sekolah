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
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME(ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=1 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as SPP, sum( case when ar_invoice.id_rate=14 then (ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as BPPS,dm_kelas.kelas,sis_siswa.namalengkap,sum( case when ar_invoice.id_rate=14 or ar_invoice.id_rate=1 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,sis_siswa.dm_jenjang_id,dm_tahunpelajaran.tahun");	
	//	$this->db->where(" sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '0'  ");	
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id join dm_tahunpelajaran");
		

		return $query;
	}
	
	
	function get_total($filter=array()){
	$this->load->model("Spp_model");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date,dm_tahunpelajaran.tahun, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '0' AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.category = 'SPP' OR ar_rate.category = 'BPPS')");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas, ar_rate");
		return $query;
	}
	
	function get_total_spp($filter=array()){
	$this->load->model("Spp_model");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date,dm_tahunpelajaran.tahun, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '0' AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.category = 'SPP')");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas, ar_rate");
		return $query;
	}
	
	function get_total_bpps($filter=array()){
	$this->load->model("Spp_model");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date,dm_tahunpelajaran.tahun, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '0' AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.category = 'BPPS')");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas, ar_rate");
		return $query;
	}
}
?>