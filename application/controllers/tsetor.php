<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tsetor extends Alazka_Controller {

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
			 //echo "uang masuk";
			 $this->uang_masuk();
		}
		else if($pilihan==1){
			 //echo "SPP";
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
		
        $this->load->model('Santarjemput_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
		
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Santarjemput_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Santarjemput_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Santarjemput_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Santarjemput_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Santarjemput_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Santarjemput_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Santarjemput_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Santarjemput_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		
		$html = $this->load->view('site/santarjemput_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_antjmput.pdf", 'I');       
    }
	

	
	
	function alat()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Salat_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Salat_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Salat_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Salat_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Salat_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Salat_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Salat_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Salat_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Salat_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/v_salat', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetoran_alat.pdf", 'I');          
    }
	
	
	
	function seragam()
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
		
        $this->load->model('Sseragam_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Sseragam_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Sseragam_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Sseragam_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Sseragam_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Sseragam_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sseragam_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Sseragam_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sseragam_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/v_sseragam', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetoran_sseragam.pdf", 'I');          
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
		
        $this->load->model('Ssanggar_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Ssanggar_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Ssanggar_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Ssanggar_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Ssanggar_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Ssanggar_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Ssanggar_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Ssanggar_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Ssanggar_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/v_ssanggar', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetoran_sanggar.pdf", 'I');       
    }
	
	
	function uang_buku()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Sbuku_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Sbuku_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Sbuku_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Sbuku_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Sbuku_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Sbuku_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sbuku_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Sbuku_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sbuku_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/v_sbuku', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetoran_buku.pdf", 'I');        
    }
	
	
	function uang_kegiatan()
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
		
        $this->load->model('Skegiatan_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Skegiatan_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Skegiatan_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Skegiatan_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Skegiatan_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Skegiatan_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Skegiatan_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Skegiatan_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Skegiatan_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/v_skegiatan', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetoran_kegiatan.pdf", 'I');         
    }
	
	
	
	function uang_masuk()
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
		
        $this->load->model('Sdftulang_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Sdftulang_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Sdftulang_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Sdftulang_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Sdftulang_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->Sdftulang_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sdftulang_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->Sdftulang_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sdftulang_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/v_sdftulang', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetoran_dftulang.pdf", 'I');        
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
		
        $this->load->model('Ssp_model');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Ssp_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Ssp_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Ssp_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Ssp_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Ssp_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Ssp_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->Ssp_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Ssp_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/v_sspp', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetoran_spp.pdf", 'I');   
    }
}  


 
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
