<?php
class Sanggar_model extends CI_Model{ // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 
/*
SELECT ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (
ar_invoice.amount - ar_invoice.received_amount
) AS tagihan, dm_tahunpelajaran.tahun, sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id
FROM ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas
WHERE sis_siswa.id = ar_invoice.id_student
AND sis_siswa.dm_kelas_id = dm_kelas.id
AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id
and ar_invoice.status='0' AND dm_tahunpelajaran.tahun = '2010-2011' and due_date>='2012-01-02' and due_date<='2012-01-05';
*/ 	
	function get_all($filter=array()){
	$this->load->model("Sanggar_model");
	$status=$this->get_status("open");	
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS tagihan, dm_tahunpelajaran.tahun, sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."' and ar_invoice.id_rate='12'");	
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas");
		return $query;
	}
	
	/*
	SELECT SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total
FROM ar_invoice, dm_tahunpelajaran, sis_siswa.dm_jenjang_id
WHERE sis_siswa.id = ar_invoice.id_student
AND sis_siswa.dm_kelas_id = dm_kelas.id
AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id
AND ar_invoice.status = '0'
AND dm_tahunpelajaran.tahun = '2010-2011'
AND due_date >= '2012-01-02'	
	*/
	function get_total($filter=array()){
	$this->load->model("Sanggar_model");
	$status=$this->get_status("open");	
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date,dm_tahunpelajaran.tahun, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."' and ar_invoice.id_rate='12'");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas");
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