<?php
class Santarjemput_model extends CI_Model{ // Buat class 
function __construct()
    {
        parent::__construct();
    }
	 
/*
SELECT sis_siswa.id AS id_siswa, sis_siswa.namalengkap,dm_tahunpelajaran.tahun,  
dm_kelas.kelas, MONTHNAME( ar_payment_details.created ) AS bulan,ar_payment_details.id AS detail_id,ar_payment_details.amount, 
 ar_payment_details.created,  ar_payment.notes,ar_invoice.description,ar_rate.name,
ar_payment_details.modified, ar_payment_details.installment, 
  sis_siswa.dm_jenjang_id,ar_payment_details.status
FROM ar_payment_details, dm_tahunpelajaran, sis_siswa, dm_kelas,ar_payment,ar_invoice,ar_rate
WHERE sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id 
AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id  and ar_invoice.id_rate='11' 
AND dm_tahunpelajaran.tahun = '2010-2011' and ar_invoice.id_rate=ar_rate.id and ar_payment.id=ar_payment_details.id_payment 
and ar_payment_details.id_invoice=ar_invoice.id and
ar_payment_details.status IN (SELECT ar_payment_details.status
FROM ar_rateWHERE ar_payment_details.status=1 or ar_payment_details.status=2)
*/ 	
	function get_all($filter=array()){
	$this->load->model("Santarjemput_model");
	$payed=$this->get_status("payed");
	$closed=$this->get_status("closed");
		$this->db->select("sis_siswa.id AS id_siswa, sis_siswa.namalengkap,dm_tahunpelajaran.tahun,  dm_kelas.kelas, MONTHNAME( ar_payment_details.created ) AS bulan,ar_payment_details.id AS detail_id,ar_payment_details.amount, ar_payment_details.created, ar_payment_details.status, ar_payment.notes,ar_invoice.description,ar_rate.name, ar_payment_details.modified, ar_payment_details.installment, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.id_rate='11' and ar_invoice.id_rate=ar_rate.id and ar_payment.id=ar_payment_details.id_payment and ar_payment_details.id_invoice=ar_invoice.id and ar_payment_details.status IN (SELECT ar_payment_details.status FROM ar_rate WHERE ar_payment_details.status='".$payed."' or ar_payment_details.status='".$closed."')");	
		$this->db->where($filter);
		$this->db->order_by("dm_kelas.kelas");
		$query = $this->db->get("ar_payment_details, dm_tahunpelajaran, sis_siswa,dm_kelas,ar_payment,ar_invoice,ar_rate");
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
	$this->load->model("Santarjemput_model");
	$payed=$this->get_status("payed");
	$closed=$this->get_status("closed");
		$this->db->select("SUM( ar_payment_details.amount ) AS total,dm_tahunpelajaran.tahun, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.id_rate='11' and ar_invoice.id_rate=ar_rate.id and ar_payment.id=ar_payment_details.id_payment and ar_payment_details.id_invoice=ar_invoice.id and ar_payment_details.status IN (SELECT ar_payment_details.status FROM ar_rate WHERE ar_payment_details.status='".$payed."' or ar_payment_details.status='".$closed."')");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_payment_details, dm_tahunpelajaran, sis_siswa,dm_kelas,ar_payment,ar_invoice,ar_rate");
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