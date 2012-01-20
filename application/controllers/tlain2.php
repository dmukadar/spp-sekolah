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
			//echo "alat";
			$this->alat();
		}
		else if($pilihan==7){	
			//echo "seragam";	
			$this->seragam();
		}
		else if($pilihan==6){			
			$this->antarjemput();
		}
		else if($pilihan==5){
			 //echo "sanggar";
			 $this->sanggar();
		}
		else if($pilihan==4){
			// echo "uang buku";
			$this->uang_buku();
		}
		else if($pilihan==3){
			// echo "uang kegiatan";
			$this->uang_kegiatan();
		}
		else if($pilihan==2){
			// echo "uang masuk";
			$this->uang_masuk();
		}
		else if($pilihan==1){
			// echo "SPP";
			 $this->spp();
		}
	}
	
	
    function antarjemput()
    {      
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Antarjemput_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
		
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Antarjemput_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Antarjemput_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Antarjemput_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Antarjemput_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Antarjemput_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Antarjemput_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Antarjemput_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Antarjemput_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		
		$html = $this->load->view('site/antarjemput_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_antjmput.pdf", 'I');       
    }
	

	
	
	function alat()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Alat');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Alat_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_alat']=$this->Alat_model->get_all(array('due_date >='=>$tanggal_mulai ));		
		$data['data_total']=$this->Alat_model->get_total(array('due_date >='=>$tanggal_mulai ));
		$data['data_total_alat']=$this->Alat_model->get_total_alat(array('due_date >='=>$tanggal_mulai ));		
		$data['data_total_bukulain']=$this->Alat_model->get_total_bukulain(array('due_date >='=>$tanggal_mulai ));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_alat']=$this->Alat_model->get_all(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Alat_model->get_total(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total_alat']=$this->Alat_model->get_total_alat(array(),$tanggal_mulai,$tanggal_akhir);		
		$data['data_total_bukulain']=$this->Alat_model->get_total_bukulain(array(),$tanggal_mulai,$tanggal_akhir);
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_alat']=$this->Alat_model->get_all(array('due_date >='=>$tanggal_mulai , 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Alat_model->get_total(array('due_date >='=>$tanggal_mulai , 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_total_alat']=$this->Alat_model->get_total_alat(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang ));		
		$data['data_total_bukulain']=$this->Alat_model->get_total_bukulain(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang ));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_alat']=$this->Alat_model->get_all(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Alat_model->get_total(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total_alat']=$this->Alat_model->get_total_alat(array('sis_siswa.dm_jenjang_id'=>$jenjang ),$tanggal_mulai,$tanggal_akhir);		
		$data['data_total_bukulain']=$this->Alat_model->get_total_bukulain(array('sis_siswa.dm_jenjang_id'=>$jenjang ),$tanggal_mulai,$tanggal_akhir);
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/alat_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_alat.pdf", 'I');          
    }
	
	
	
	function seragam()
    {       
	$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Seragam_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_seragam']=$this->Seragam_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Seragam_model->get_total(array('due_date >='=>$tanggal_mulai));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_seragam']=$this->Seragam_model->get_allnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Seragam_model->get_totalnew(array(),$tanggal_mulai,$tanggal_akhir);	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_seragam']=$this->Seragam_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Seragam_model->get_total(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_seragam']=$this->Seragam_model->get_allnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Seragam_model->get_totalnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/seragam_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_seragam.pdf", 'I');         
    }
	
	
	function sanggar()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain Unit Sanggar');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Sanggar_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_sanggar']=$this->Sanggar_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Sanggar_model->get_total(array('due_date >='=>$tanggal_mulai));
		}
		
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_sanggar']=$this->Sanggar_model->get_allnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Sanggar_model->get_totalnew(array(),$tanggal_mulai,$tanggal_akhir);	
		}
		
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_sanggar']=$this->Sanggar_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sanggar_model->get_total(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_sanggar']=$this->Sanggar_model->get_allnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Sanggar_model->get_totalnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/sanggar_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_sanggar.pdf", 'I');       
    }
	
	
	
	function uang_buku()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Buku_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		
		if ($jenjang==0 && empty($tanggal_akhir)){		
		$data['data_buku']=$this->Buku_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Buku_model->get_total(array('due_date >='=>$tanggal_mulai ));
		$data['data_paket']=$this->Buku_model->get_total_paket(array('due_date >='=>$tanggal_mulai));		
		$data['data_nonpaket']=$this->Buku_model->get_total_nonpaket(array('due_date >='=>$tanggal_mulai ));
		$data['data_lks']=$this->Buku_model->get_total_lks(array('due_date >='=>$tanggal_mulai ));
		
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_buku']=$this->Buku_model->get_allnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Buku_model->get_totalnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_paket']=$this->Buku_model->get_total_paketnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_nonpaket']=$this->Buku_model->get_total_nonpaketnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_lks']=$this->Buku_model->get_total_lksnew(array(),$tanggal_mulai,$tanggal_akhir);	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_buku']=$this->Buku_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Buku_model->get_total(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_paket']=$this->Buku_model->get_total_paket(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));		
		$data['data_nonpaket']=$this->Buku_model->get_total_nonpaket(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang ));
		$data['data_lks']=$this->Buku_model->get_total_lks(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang ));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_buku']=$this->Buku_model->get_allnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_total']=$this->Buku_model->get_totalnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_paket']=$this->Buku_model->get_total_paketnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);		
		$data['data_nonpaket']=$this->Buku_model->get_total_nonpaketnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_lks']=$this->Buku_model->get_total_lksnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/buku_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_buku.pdf", 'I');     
    }
	
	
	function uang_kegiatan()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Kegiatan');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Kegiatan_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->Kegiatan_model->get_all(array('due_date >='=>$tanggal_mulai));	
			
		$data['data_total']=$this->Kegiatan_model->get_total(array('due_date >='=>$tanggal_mulai));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->Kegiatan_model->get_allnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Kegiatan_model->get_totalnew(array(),$tanggal_mulai,$tanggal_akhir);	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->Kegiatan_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Kegiatan_model->get_total(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->Kegiatan_model->get_allnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Kegiatan_model->get_totalnew(array('sis_siswa.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);	
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/kegiatan_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_kegiatan.pdf", 'I');        
    }
	
	
	
	function uang_masuk()
    {       
	$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Dftulang_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_um']=$this->Dftulang_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Dftulang_model->get_total(array('due_date >='=>$tanggal_mulai));
		$data['data_um_total']=$this->Dftulang_model->get_total_um(array('due_date >='=>$tanggal_mulai));		
		$data['data_ud']=$this->Dftulang_model->get_total_ud(array('due_date >='=>$tanggal_mulai));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_um']=$this->Dftulang_model->get_allnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Dftulang_model->get_totalnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_um_total']=$this->Dftulang_model->get_total_umnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_ud']=$this->Dftulang_model->get_total_udnew(array(),$tanggal_mulai,$tanggal_akhir);	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_um']=$this->Dftulang_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Dftulang_model->get_total(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_um_total']=$this->Dftulang_model->get_total_um(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_ud']=$this->Dftulang_model->get_total_ud(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_um']=$this->Dftulang_model->get_allnew(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);		
		$data['data_total']=$this->Dftulang_model->get_totalnew(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);		
		$data['data_um_total']=$this->Dftulang_model->get_total_umnew(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);		
		$data['data_ud']=$this->Dftulang_model->get_total_udnew(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);		
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/dftulang_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_dftulang.pdf", 'I');         
    }
	
	
	
	function spp()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Tunggakan Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Spp_model');
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
		$data['data_sppbpps']=$this->Spp_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Spp_model->get_total(array('due_date >='=>$tanggal_mulai));
		$data['data_spp']=$this->Spp_model->get_total_spp(array('due_date >='=>$tanggal_mulai));
		$data['data_bpps']=$this->Spp_model->get_total_bpps(array('due_date >='=>$tanggal_mulai));
		//echo "1";
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->Spp_model->get_allnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Spp_model->get_total_new(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_spp']=$this->Spp_model->get_total_sppnew(array(),$tanggal_mulai,$tanggal_akhir);	
		$data['data_bpps']=$this->Spp_model->get_total_bppsnew(array(),$tanggal_mulai,$tanggal_akhir);	
	//	echo "2";
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->Spp_model->get_all(array('due_date >='=>$tanggal_mulai, 'dm_kelas.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Spp_model->get_total(array('due_date >='=>$tanggal_mulai,'dm_kelas.dm_jenjang_id'=>$jenjang));
		$data['data_spp']=$this->Spp_model->get_total_spp(array('due_date >='=>$tanggal_mulai, 'dm_kelas.dm_jenjang_id'=>$jenjang));	
		$data['data_bpps']=$this->Spp_model->get_total_bpps(array('due_date >='=>$tanggal_mulai,'dm_kelas.dm_jenjang_id'=>$jenjang));
		//echo "3";
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		
		$data['data_sppbpps']=$this->Spp_model->get_allnew(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);	
		$data['data_total']=$this->Spp_model->get_total(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		$data['data_spp']=$this->Spp_model->get_total_spp(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);	
		$data['data_bpps']=$this->Spp_model->get_total_bpps(array('dm_kelas.dm_jenjang_id'=>$jenjang),$tanggal_mulai,$tanggal_akhir);
		//echo "4";
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/spp_view', $data, true);
  		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_spp.pdf", 'I');  
    }
}  


 
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
