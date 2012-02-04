<?php
class lap_tunggakan_model extends CI_Model{ // Buat class
function __construct()
    {
        parent::__construct();
    }
//tunggakan-antarjemput--------------
	function get_all_ant($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS tagihan, dm_tahunpelajaran.tahun, sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."' and ar_invoice.id_rate='11'");	
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas");
		return $query;
	}
	
	function get_total_ant($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date,dm_tahunpelajaran.tahun, sis_siswa.dm_jenjang_id");	
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."' and ar_invoice.id_rate='11'");	
		$this->db->where($filter);		
		$query = $this->db->get("ar_invoice, dm_tahunpelajaran, sis_siswa, dm_kelas");
		return $query;
	}
//tunggakan-alat--------------
        function get_all_alat($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_alat, sum( case when ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_bukulain,sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap ");
	        $this->db->where ("ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37)");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		return $query;
	}
        function get_total_alat($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 or ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_totalall_alat($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=38 or ar_invoice.id_rate=39 or ar_invoice.id_rate=40 or ar_invoice.id_rate=41 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_bukulain_alat($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=7 or ar_invoice.id_rate=29 or ar_invoice.id_rate=33 or ar_invoice.id_rate=37 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
//--------tunggakan seragam
        function get_all_seragam($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS tagihan,  sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id,ar_rate.category");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '9' OR ar_rate.id = '10' OR ar_rate.id = '18' OR ar_rate.id = '19') ");
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
	function get_total_seragam($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date,sis_siswa.dm_jenjang_id");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '9' OR ar_rate.id = '10' OR ar_rate.id = '18' OR ar_rate.id = '19') ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
	function get_allnew_seragam($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS tagihan, sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id,ar_rate.category");

		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '9' OR ar_rate.id = '10' OR ar_rate.id = '18' OR ar_rate.id = '19') AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' ) ");
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
	function get_totalnew_seragam($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date, sis_siswa.dm_jenjang_id");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '9' OR ar_rate.id = '10' OR ar_rate.id = '18' OR ar_rate.id = '19') AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
//--------tunggakan sanggar
        function get_all_sanggar($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS tagihan,  sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."' and ar_invoice.id_rate='12'");
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas");
		return $query;
	}
	function get_total_sanggar($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date, sis_siswa.dm_jenjang_id");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."' and ar_invoice.id_rate='12'");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice,  sis_siswa, dm_kelas");
		return $query;
	}
	function get_allnew_sanggar($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS tagihan, sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."' and ar_invoice.id_rate='12' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas");
		return $query;
	}
	function get_totalnew_sanggar($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date, sis_siswa.dm_jenjang_id");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."' and ar_invoice.id_rate='12' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice,  sis_siswa, dm_kelas");
		return $query;
	}
//--------tunggakan buku
        function get_all_buku($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_paket,sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_nonpaket,sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_lks,sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap ");
                $this->db->where ("ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36)");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		return $query;
	}
        function get_total_buku($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_paket($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_nonpaket($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_lks($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_allnew_buku($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_paket,sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_nonpaket,sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_lks,sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap ");
                $this->db->where ("ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36) AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		return $query;
	}
	function get_totalnew_buku ($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=5 or ar_invoice.id_rate=6 or ar_invoice.id_rate=26 or  ar_invoice.id_rate=27 or ar_invoice.id_rate=28 or ar_invoice.id_rate=30 or ar_invoice.id_rate=31  or ar_invoice.id_rate=32 or ar_invoice.id_rate=34 or ar_invoice.id_rate=35 or ar_invoice.id_rate=36 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."'  AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_paketnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=4 or ar_invoice.id_rate=26 or ar_invoice.id_rate=30 or ar_invoice.id_rate=34 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_lksnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=6 or ar_invoice.id_rate=28 or ar_invoice.id_rate=32 or ar_invoice.id_rate=36  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_nonpaketnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=5 or ar_invoice.id_rate=27 or ar_invoice.id_rate=31 or ar_invoice.id_rate=35 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' ) ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
//-----tunggakan kegiatan
       function get_all_keg($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS total,  sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id,ar_rate.category");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '8' OR ar_rate.id = '15' OR ar_rate.id = '16' OR ar_rate.id = '17') ");
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
	function get_total_keg($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date, sis_siswa.dm_jenjang_id");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '8' OR ar_rate.id = '15' OR ar_rate.id = '16' OR ar_rate.id = '17') ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
	function get_allnew_keg($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id AS inv_id, ar_invoice.created_date, ar_invoice.due_date, ar_invoice.amount, ar_invoice.received_amount, (ar_invoice.amount - ar_invoice.received_amount) AS total, sis_siswa.id AS id_siswa, sis_siswa.namalengkap, dm_kelas.kelas, ar_invoice.description,MONTHNAME( ar_invoice.due_date ) AS bulan, sis_siswa.dm_jenjang_id,ar_rate.category,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '8' OR ar_rate.id = '15' OR ar_rate.id = '16' OR ar_rate.id = '17') and ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' ) ");
		$this->db->where($filter);
		$this->db->order_by("ar_invoice.id");
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
	function get_totalnew_keg($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("SUM( ar_invoice.amount - ar_invoice.received_amount ) AS total,ar_invoice.created_date, ar_invoice.due_date, sis_siswa.dm_jenjang_id,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id and ar_invoice.status='".$status."'  AND ar_invoice.id_rate = ar_rate.id AND ar_rate.category IN (SELECT ar_rate.category FROM ar_rate WHERE ar_rate.id = '8' OR ar_rate.id = '15' OR ar_rate.id = '16' OR ar_rate.id = '17') and ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' ) ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice, sis_siswa, dm_kelas,ar_rate");
		return $query;
	}
//--tunggakan daftar ulang
function get_all_du($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_muka,sum( case when ar_invoice.id_rate=22 or ar_invoice.id_rate=23 or ar_invoice.id_rate=24 or ar_invoice.id_rate=25 then(ar_invoice.amount - ar_invoice.received_amount) else 0 end) as uang_daftar,sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 or  ar_invoice.id_rate=22 or ar_invoice.id_rate=23 or ar_invoice.id_rate=24 or ar_invoice.id_rate=25 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap");
                $this->db->where ("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='2' or ar_invoice.id_rate='20' or ar_invoice.id_rate='3' or ar_invoice.id_rate='21' or ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25')");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get(" ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		return $query;
	}
	function get_total_du($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 or ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25' then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_um_du($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_ud($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25' then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."' ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_allnew_du($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21  then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_muka,sum( case when ar_invoice.id_rate=22 or ar_invoice.id_rate=23 or ar_invoice.id_rate=24 or ar_invoice.id_rate=25 then(ar_invoice.amount - ar_invoice.received_amount) else 0 end) as uang_daftar,sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 or  ar_invoice.id_rate=22 or ar_invoice.id_rate=23 or ar_invoice.id_rate=24 or ar_invoice.id_rate=25 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap");
	    $this->db->where ("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='2' or ar_invoice.id_rate='20' or ar_invoice.id_rate='3' or ar_invoice.id_rate='21' or ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25') AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student ");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get(" ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id ");
		return $query;
	}
	function get_totalnew_du($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 or ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25' then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' ) ");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_umnew_du($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=2 or ar_invoice.id_rate=20 or ar_invoice.id_rate=3 or ar_invoice.id_rate=21 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_udnew_du($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate='22' or ar_invoice.id_rate='23' or ar_invoice.id_rate='24' or ar_invoice.id_rate='25' then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
//------------tunggakan spp
function get_all_spp($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=1 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_spp,sum( case when ar_invoice.id_rate=14 then(ar_invoice.amount - ar_invoice.received_amount) else 0 end) as uang_bpps,sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap, sis_siswa.dm_jenjang_id");
		$this->db->where ("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='1' or ar_invoice.id_rate='14')");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get(" ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_spp($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."'");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_totalspp_spp($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=1 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."'");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_bpps($filter=array()){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=14 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total");
		$this->db->where("ar_invoice.status = '".$status."'");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_allnew_spp($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("ar_invoice.id_student, ar_invoice.created_date,ar_invoice.due_date, MONTHNAME( ar_invoice.due_date ) AS bulan,ar_invoice.description, sum( case when ar_invoice.id_rate=1 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as uang_spp,sum( case when ar_invoice.id_rate=14 then(ar_invoice.amount - ar_invoice.received_amount) else 0 end) as uang_bpps,sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then(ar_invoice.amount - ar_invoice.received_amount)   else 0 end) as total,dm_kelas.kelas,sis_siswa.namalengkap, sis_siswa.dm_jenjang_id ");
		$this->db->where ("sis_siswa.id = ar_invoice.id_student AND sis_siswa.dm_kelas_id = dm_kelas.id AND sis_siswa.dm_jenjang_id = dm_kelas.dm_jenjang_id AND ar_invoice.status = '".$status."' and ar_invoice.id_rate in (select ar_invoice.id_rate from ar_invoice where ar_invoice.id_rate='1' or ar_invoice.id_rate='14') AND ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$this->db->group_by("ar_invoice.id_student");
		$this->db->order_by("sis_siswa.namalengkap");
		$query = $this->db->get(" ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_totalnew_spp($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=1 or ar_invoice.id_rate=14 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' and ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_sppnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
		$this->db->select("sum( case when ar_invoice.id_rate=1 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' and ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}
	function get_total_bppsnew($filter=array(),$tanggal_mulai,$tanggal_akhir){
	$this->load->model("lap_tunggakan_model");
	$status=$this->get_status("open");
			$this->db->select("sum( case when ar_invoice.id_rate=14 then (ar_invoice.amount - ar_invoice.received_amount)  else 0 end) as total,ar_invoice.created_date,ar_invoice.due_date");
		$this->db->where("ar_invoice.status = '".$status."' and ar_invoice.due_date in (select ar_invoice.`due_date` from ar_invoice where ar_invoice.`due_date` >= '".$tanggal_mulai."'   or ar_invoice.`due_date` <= '".$tanggal_akhir."' )");
		$this->db->where($filter);
		$query = $this->db->get("ar_invoice join sis_siswa on ar_invoice.id_student=sis_siswa.id join dm_kelas on sis_siswa.dm_kelas_id = dm_kelas.id");
		return $query;
	}

//----set status
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