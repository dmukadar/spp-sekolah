<?php
class  Seragam_model extends CI_Model{ // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 
/*
SELECT ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS tagihan, dm_tahunpelajaran.tahun, sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id ,ar_rate.category from ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas,ar_rate where sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='0' AND ar_invoice.id_rate = ar_rate.id
AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '8' OR ar_rate.id = '15' )group by ar_invoice.id
*/
	function get_all($filter=array()){
	$this->load->model("Seragam_model");
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS tagihan, dm_tahunpelajaran.tahun, sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id,ar_rate.category");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='0'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '9' OR ar_rate.id = '10' OR ar_rate.id = '18' OR ar_rate.id = '19') ");	
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
	

	
	function get_total($filter=array()){
	$this->load->model("Seragam_model");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date,dm_tahunpelajaran.tahun, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='0'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '9' OR ar_rate.id = '10' OR ar_rate.id = '18' OR ar_rate.id = '19') ");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
}
?>