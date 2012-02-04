<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tlain2 extends Alazka_Controller {
    function __construct()
    {
        parent::__construct();
    }   	
	/*fungsi buat pilih sub-jenis report dari tunggakan* */
	 
    function pilih_report_tunggakan(){
		$pilihan=$this->input->post('bt_laporan');
		if($pilihan==8){
			$this->alat();
		}
		else if($pilihan==7){		
			$this->seragam();
		}
		else if($pilihan==6){			
			$this->antarjemput();
		}
		else if($pilihan==5){
			 $this->sanggar();
		}
		else if($pilihan==4){
			$this->uang_buku();
		}
		else if($pilihan==3){
			$this->uang_kegiatan();
		}
		else if($pilihan==2){
			$this->uang_masuk();
		}
		else if($pilihan==1){
			 $this->spp();
		}
	}

    function head(){
    $this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');
        $this->pdf->SetFont('times', '', 12);
	$this->pdf->setHeaderFont(Array('times', '', '14'));
	$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
	$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage();      
    }

    function foot(){
      $this->load->library('pdf');    
      $this->pdf->lastPage();
      $this->pdf->Output("rekap_tunggakan.pdf", 'I');
    }
    
function antarjemput()
    {   
	$this->head();
        $tanggal_mulai=$this->input->post('tx_mulai');
	$tanggal_akhir=$this->input->post('tx_akhir');
	$ajaran=$this->input->post('tx_ajaran');
	$jenjang=$this->input->post('tx_unit');
        $this->load->model('lap_tunggakan_model');		
	        $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->lap_tunggakan_model->get_all_ant(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		$data['data_total']=$this->lap_tunggakan_model->get_total_ant(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->lap_tunggakan_model->get_all_ant(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));
		$data['data_total']=$this->lap_tunggakan_model->get_total_ant(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));
		}		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->lap_tunggakan_model->get_all_ant(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_ant(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->lap_tunggakan_model->get_all_ant(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_ant(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 		
		$data['page']='index';		
		$html = $this->load->view('site/antarjemput_view', $data, true);
                $this->pdf->writeHTML($html, true, true, true, true, '');
		$this->foot();		
    }


function alat()
    {       
       $this->head();
       $this->load->model('lap_tunggakan_model');
		$tanggal_mulai=$this->input->post('tx_mulai');
		$tanggal_akhir=$this->input->post('tx_akhir');
		$ajaran=$this->input->post('tx_ajaran');
		$jenjang=$this->input->post('tx_unit');
	        $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_alat']=$this->lap_tunggakan_model->get_all_alat(array('due_date >='=>$tanggal_mulai ));
		$data['data_total']=$this->lap_tunggakan_model->get_total_alat(array('due_date >='=>$tanggal_mulai ));
		$data['data_total_alat']=$this->lap_tunggakan_model->get_totalall_alat(array('due_date >='=>$tanggal_mulai ));
		$data['data_total_bukulain']=$this->lap_tunggakan_model->get_total_bukulain_alat(array('due_date >='=>$tanggal_mulai ));
		}
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_alat']=$this->lap_tunggakan_model->get_all_alat(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_total_alat(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total_alat']=$this->lap_tunggakan_model->get_totalall_alat(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total_bukulain']=$this->lap_tunggakan_model->get_total_bukulain_alat(array(),$tanggal_mulai,$tanggal_akhir);
		}
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_alat']=$this->lap_tunggakan_model->get_all_alat(array('due_date >='=>$tanggal_mulai , 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_alat(array('due_date >='=>$tanggal_mulai , 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total_alat']=$this->lap_tunggakan_model->get_totalall_alat(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang ));
		$data['data_total_bukulain']=$this->lap_tunggakan_model->get_total_bukulain_alat(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang ));
		}
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_alat']=$this->lap_tunggakan_model->get_all_alat(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_total_alat(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total_alat']=$this->lap_tunggakan_model->get_totalall_alat(array('sis_siswa.dm_jenjang_id'=>$jenjang ),$tanggal_mulai,$tanggal_akhir);
		$data['data_total_bukulain']=$this->lap_tunggakan_model->get_total_bukulain_alat(array('sis_siswa.dm_jenjang_id'=>$jenjang ),$tanggal_mulai,$tanggal_akhir);
		}
		$data['page']='index';
		$html = $this->load->view('site/alat_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');
		$this->foot();
    }
	
		
function seragam()
    {       
	 $this->head();
         $this->load->model('lap_tunggakan_model');
		$tanggal_mulai=$this->input->post('tx_mulai');
		$tanggal_akhir=$this->input->post('tx_akhir');
		$ajaran=$this->input->post('tx_ajaran');
		$jenjang=$this->input->post('tx_unit');
	        $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_seragam']=$this->lap_tunggakan_model->get_all_seragam(array('due_date >='=>$tanggal_mulai));
		$data['data_total']=$this->lap_tunggakan_model->get_total_seragam(array('due_date >='=>$tanggal_mulai));
		}
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_seragam']=$this->lap_tunggakan_model->get_allnew_seragam(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_seragam(array(),$tanggal_mulai,$tanggal_akhir);
		}
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_seragam']=$this->lap_tunggakan_model->get_all_seragam(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_seragam(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_seragam']=$this->lap_tunggakan_model->get_allnew_seragam(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_seragam(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		}
		$data['page']='index';
		$html = $this->load->view('site/seragam_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');
		$this->foot();
    }
	
	
function sanggar()
    {       
	$this->head();
        $this->load->model('lap_tunggakan_model');
		$tanggal_mulai=$this->input->post('tx_mulai');
		$tanggal_akhir=$this->input->post('tx_akhir');
		$ajaran=$this->input->post('tx_ajaran');
		$jenjang=$this->input->post('tx_unit');
	        $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_sanggar']=$this->lap_tunggakan_model->get_all_sanggar(array('due_date >='=>$tanggal_mulai));
		$data['data_total']=$this->lap_tunggakan_model->get_total_sanggar(array('due_date >='=>$tanggal_mulai));
		}
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_sanggar']=$this->lap_tunggakan_model->get_allnew_sanggar(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_sanggar(array(),$tanggal_mulai,$tanggal_akhir);
		}
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_sanggar']=$this->lap_tunggakan_model->get_all_sanggar(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_sanggar(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_sanggar']=$this->lap_tunggakan_model->get_allnew_sanggar(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_sanggar(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		}
		$data['page']='index';
		$html = $this->load->view('site/sanggar_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');
		$this->foot();
    }
	
		
function uang_buku()
    {       
	$this->head();
        $this->load->model('lap_tunggakan_model');
		$tanggal_mulai=$this->input->post('tx_mulai');
		$tanggal_akhir=$this->input->post('tx_akhir');
		$ajaran=$this->input->post('tx_ajaran');
		$jenjang=$this->input->post('tx_unit');
                $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_buku']=$this->lap_tunggakan_model->get_all_buku(array('due_date >='=>$tanggal_mulai));
		$data['data_total']=$this->lap_tunggakan_model->get_total_buku(array('due_date >='=>$tanggal_mulai ));
		$data['data_paket']=$this->lap_tunggakan_model->get_total_paket(array('due_date >='=>$tanggal_mulai));
		$data['data_nonpaket']=$this->lap_tunggakan_model->get_total_nonpaket(array('due_date >='=>$tanggal_mulai ));
		$data['data_lks']=$this->lap_tunggakan_model->get_total_lks(array('due_date >='=>$tanggal_mulai ));
		}
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_buku']=$this->lap_tunggakan_model->get_allnew_buku(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_buku(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_paket']=$this->lap_tunggakan_model->get_total_paketnew(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_nonpaket']=$this->lap_tunggakan_model->get_total_nonpaketnew(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_lks']=$this->lap_tunggakan_model->get_total_lksnew(array(),$tanggal_mulai,$tanggal_akhir);
		}
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_buku']=$this->lap_tunggakan_model->get_all_buku(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_buku(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_paket']=$this->lap_tunggakan_model->get_total_paket(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_nonpaket']=$this->lap_tunggakan_model->get_total_nonpaket(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang ));
		$data['data_lks']=$this->lap_tunggakan_model->get_total_lks(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang ));
		}
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_buku']=$this->lap_tunggakan_model->get_allnew_buku(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_buku(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_paket']=$this->lap_tunggakan_model->get_total_paketnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_nonpaket']=$this->lap_tunggakan_model->get_total_nonpaketnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_lks']=$this->lap_tunggakan_model->get_total_lksnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		}
		$data['page']='index';
		$html = $this->load->view('site/buku_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');
		$this->foot();
    }
	
	
function uang_kegiatan()
    {       
	$this->head();
        $this->load->model('lap_tunggakan_model');
		$tanggal_mulai=$this->input->post('tx_mulai');
		$tanggal_akhir=$this->input->post('tx_akhir');
		$ajaran=$this->input->post('tx_ajaran');
		$jenjang=$this->input->post('tx_unit');
                $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->lap_tunggakan_model->get_all_keg(array('due_date >='=>$tanggal_mulai));
		$data['data_total']=$this->lap_tunggakan_model->get_total_keg(array('due_date >='=>$tanggal_mulai));
		}
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->lap_tunggakan_model->get_allnew_keg(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_keg(array(),$tanggal_mulai,$tanggal_akhir);
		}
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->lap_tunggakan_model->get_all_keg(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_keg(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->lap_tunggakan_model->get_allnew_keg(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_keg(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		}
		$data['page']='index';
		$html = $this->load->view('site/kegiatan_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');
		$this->foot();
    }
	
	
function uang_masuk()
    {       
	$this->head();
        $this->load->model('lap_tunggakan_model');
		$tanggal_mulai=$this->input->post('tx_mulai');
		$tanggal_akhir=$this->input->post('tx_akhir');
		$ajaran=$this->input->post('tx_ajaran');
		$jenjang=$this->input->post('tx_unit');
                $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_um']=$this->lap_tunggakan_model->get_all_du(array('due_date >='=>$tanggal_mulai));
		$data['data_total']=$this->lap_tunggakan_model->get_total_du(array('due_date >='=>$tanggal_mulai));
		$data['data_um_total']=$this->lap_tunggakan_model->get_total_um_du(array('due_date >='=>$tanggal_mulai));
		$data['data_ud']=$this->lap_tunggakan_model->get_total_ud(array('due_date >='=>$tanggal_mulai));
		}
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_um']=$this->lap_tunggakan_model->get_allnew_du(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_du(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_um_total']=$this->lap_tunggakan_model->get_total_umnew_du(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_ud']=$this->lap_tunggakan_model->get_total_udnew_du(array(),$tanggal_mulai,$tanggal_akhir);
		}
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_um']=$this->lap_tunggakan_model->get_all_du(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_du(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_um_total']=$this->lap_tunggakan_model->get_total_um_du(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_ud']=$this->lap_tunggakan_model->get_total_ud(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_um']=$this->lap_tunggakan_model->get_allnew_du(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_du(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_um_total']=$this->lap_tunggakan_model->get_total_umnew_du(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_ud']=$this->lap_tunggakan_model->get_total_udnew_du(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		}
		$data['page']='index';
		$html = $this->load->view('site/dftulang_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');
		$this->foot();
    }
	
		
function spp()
    {       
	$this->head();
        $this->load->model('lap_tunggakan_model');
		$tanggal_mulai=$this->input->post('tx_mulai');
		$tanggal_akhir=$this->input->post('tx_akhir');
		$ajaran=$this->input->post('tx_ajaran');
		$bulan=$this->input->post('tx_bulan');
		$jenjang=$this->input->post('tx_unit');
		$data['ajaran']=$ajaran;
		$data['bulan']=$bulan;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->lap_tunggakan_model->get_all_spp(array('due_date >='=>$tanggal_mulai));
		$data['data_total']=$this->lap_tunggakan_model->get_total_spp(array('due_date >='=>$tanggal_mulai));
		$data['data_spp']=$this->lap_tunggakan_model->get_totalspp_spp(array('due_date >='=>$tanggal_mulai));
		$data['data_bpps']=$this->lap_tunggakan_model->get_total_bpps(array('due_date >='=>$tanggal_mulai));
		}
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->lap_tunggakan_model->get_allnew_spp(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_totalnew_spp(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_spp']=$this->lap_tunggakan_model->get_total_sppnew(array(),$tanggal_mulai,$tanggal_akhir);
		$data['data_bpps']=$this->lap_tunggakan_model->get_total_bppsnew(array(),$tanggal_mulai,$tanggal_akhir);
		}
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->lap_tunggakan_model->get_all_spp(array('due_date >='=>$tanggal_mulai, 'dm_kelas.dm_jenjang_id'=>$jenjang));
		$data['data_total']=$this->lap_tunggakan_model->get_total_spp(array('due_date >='=>$tanggal_mulai,'dm_kelas.dm_jenjang_id'=>$jenjang));
		$data['data_spp']=$this->lap_tunggakan_model->get_totalspp_spp(array('due_date >='=>$tanggal_mulai, 'dm_kelas.dm_jenjang_id'=>$jenjang));
		$data['data_bpps']=$this->lap_tunggakan_model->get_total_bpps(array('due_date >='=>$tanggal_mulai,'dm_kelas.dm_jenjang_id'=>$jenjang));
		}
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->lap_tunggakan_model->get_allnew_spp(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->lap_tunggakan_model->get_total_spp(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_spp']=$this->lap_tunggakan_model->get_totalspp_spp(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_bpps']=$this->lap_tunggakan_model->get_total_bpps(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		}
		$data['page']='index';
		$html = $this->load->view('site/spp_view', $data, true);
  		$this->pdf->writeHTML($html, true, true, true, true, '');
		$this->foot();	
    }
}  