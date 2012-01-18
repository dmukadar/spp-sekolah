<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tsetor extends Alazka_Controller {

    function __construct()
    {
        parent::__construct();
    }
    
	
	/*fungsi buat pilih sub-jenis report dari Setoran* */
	 
	function pilih_report_setoran(){
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
        $this->pdf->SetSubject('Laporan Setoran Lain-lain');
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
		$this->pdf->Output("rekapsetor_antjmput.pdf", 'I');       
    }
	

	
	
	function alat()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran Lain-lain');
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
		$bulan=$this->input->post('tx_bulan');
		$jenjang=$this->input->post('tx_unit');
	    
		$data['ajaran']=$ajaran;
		$data['bulan']=$bulan;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;

		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_salat']=$this->Salat_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Salat_model->get_total(array('due_date >='=>$tanggal_mulai));
		$data['data_buku']=$this->Salat_model->get_total_buku(array('due_date >='=>$tanggal_mulai));
		$data['data_alat']=$this->Salat_model->get_total_alat(array('due_date >='=>$tanggal_mulai));
		//echo "1";
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_salat']=$this->Salat_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_total']=$this->Salat_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_buku']=$this->Salat_model->get_total_buku(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_alat']=$this->Salat_model->get_total_alat(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
	//	echo "2";
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_salat']=$this->Salat_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Salat_model->get_total(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_buku']=$this->Salat_model->get_total_buku(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_alat']=$this->Salat_model->get_total_alat(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		//echo "3";
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_salat']=$this->Salat_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Salat_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_buku']=$this->Salat_model->get_total_buku(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_alat']=$this->Salat_model->get_total_alat(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		//echo "4";
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/salat_view', $data, true);
  		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapst_alat.pdf", 'I');     
    }
	
	
	
	function seragam()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran Lain-lain');
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
		$data ['nm_jenjang']=$jenjang;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_seragam']=$this->Sseragam_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Sseragam_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_seragam']=$this->Sseragam_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Sseragam_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_seragam']=$this->Sseragam_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sseragam_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_seragam']=$this->Sseragam_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sseragam_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		
		$html = $this->load->view('site/sseragam_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapst_seragam.pdf", 'I');      
    }
	
	
	
	function sanggar()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran Lain-lain');
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
		$data ['nm_jenjang']=$jenjang;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_ssanggar']=$this->Ssanggar_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Ssanggar_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_ssanggar']=$this->Ssanggar_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Ssanggar_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_ssanggar']=$this->Ssanggar_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Ssanggar_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_ssanggar']=$this->Ssanggar_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Ssanggar_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		
		$html = $this->load->view('site/ssanggar_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetor_setor.pdf", 'I');       
    }
	
	
	function uang_buku()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran Lain-lain');
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
		$bulan=$this->input->post('tx_bulan');
		$jenjang=$this->input->post('tx_unit');
	    
		$data['ajaran']=$ajaran;
		$data['bulan']=$bulan;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;

		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_buku']=$this->Sbuku_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Sbuku_model->get_total(array('due_date >='=>$tanggal_mulai));
		$data['data_paket']=$this->Sbuku_model->get_total_paket(array('due_date >='=>$tanggal_mulai));
		$data['data_nonpaket']=$this->Sbuku_model->get_total_nonpaket(array('due_date >='=>$tanggal_mulai));
		//echo "1";
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_buku']=$this->Sbuku_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_total']=$this->Sbuku_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_paket']=$this->Sbuku_model->get_total_paket(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_nonpaket']=$this->Sbuku_model->get_total_nonpaket(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
	//	echo "2";
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_buku']=$this->Sbuku_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sbuku_model->get_total(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_paket']=$this->Sbuku_model->get_total_paket(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_nonpaket']=$this->Sbuku_model->get_total_nonpaket(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		//echo "3";
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_buku']=$this->Sbuku_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sbuku_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_paket']=$this->Sbuku_model->get_total_paket(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_nonpaket']=$this->Sbuku_model->get_total_nonpaket(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		//echo "4";
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/sbuku_view', $data, true);
  		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapst_buku.pdf", 'I');  
    }      
 
	
	
	function uang_kegiatan()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran Lain-lain');
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
		$data ['nm_jenjang']=$jenjang;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->Skegiatan_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->Skegiatan_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->Skegiatan_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->Skegiatan_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->Skegiatan_model->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Skegiatan_model->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_kegiatan']=$this->Skegiatan_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Skegiatan_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		
		$html = $this->load->view('site/skegiatan_view', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekaptg_kegiatan.pdf", 'I');  
    }
	
	
	
	function uang_masuk()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran Lain-lain');
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
		$bulan=$this->input->post('tx_bulan');
		$jenjang=$this->input->post('tx_unit');
	    
		$data['ajaran']=$ajaran;
		$data['bulan']=$bulan;
		$data ['per_tanggal']=$tanggal_mulai;
		$data ['nm_jenjang']=$jenjang;

		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_dfulang']=$this->Sdftulang_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Sdftulang_model->get_total(array('due_date >='=>$tanggal_mulai));
		$data['data_um']=$this->Sdftulang_model->get_total_um(array('due_date >='=>$tanggal_mulai));
		$data['data_du']=$this->Sdftulang_model->get_total_du(array('due_date >='=>$tanggal_mulai));
		//echo "1";
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_dfulang']=$this->Sdftulang_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_total']=$this->Sdftulang_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_um']=$this->Sdftulang_model->get_total_um(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_du']=$this->Sdftulang_model->get_total_du(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
	//	echo "2";
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_dfulang']=$this->Sdftulang_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sdftulang_model->get_total(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_um']=$this->Sdftulang_model->get_total_um(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_du']=$this->Sdftulang_model->get_total_du(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		//echo "3";
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_dfulang']=$this->Sdftulang_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sdftulang_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_um']=$this->Sdftulang_model->get_total_um(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_du']=$this->Sdftulang_model->get_total_du(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		//echo "4";
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/sdftulang_view', $data, true);
		
  		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetor_spp.pdf", 'I');  
    
    }
	
	function spp()
    {       
		$this->load->library('pdf');
        $this->pdf->SetSubject('Laporan Setoran Lain-lain');
        $this->pdf->SetKeywords('TCPDF, PDF');      
        $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->AddPage(); 
		
        $this->load->model('Sspp_model');
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
		$data['data_sppbpps']=$this->Sspp_model->get_all(array('due_date >='=>$tanggal_mulai));		
		$data['data_total']=$this->Sspp_model->get_total(array('due_date >='=>$tanggal_mulai));
		$data['data_spp']=$this->Sspp_model->get_total_spp(array('due_date >='=>$tanggal_mulai));
		$data['data_bpps']=$this->Sspp_model->get_total_bpps(array('due_date >='=>$tanggal_mulai));
		//echo "1";
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->Sspp_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_total']=$this->Sspp_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_spp']=$this->Sspp_model->get_total_spp(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
		$data['data_bpps']=$this->Sspp_model->get_total_bpps(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir));	
	//	echo "2";
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->Sspp_model->get_all(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sspp_model->get_total(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_spp']=$this->Sspp_model->get_total_spp(array('due_date >='=>$tanggal_mulai, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_bpps']=$this->Sspp_model->get_total_bpps(array('due_date >='=>$tanggal_mulai,'sis_siswa.dm_jenjang_id'=>$jenjang));
		//echo "3";
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_sppbpps']=$this->Sspp_model->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->Sspp_model->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		$data['data_spp']=$this->Sspp_model->get_total_spp(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_bpps']=$this->Sspp_model->get_total_bpps(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		//echo "4";
		} 
		
		$data['page']='index';
		$html = $this->load->view('site/sspp_view', $data, true);
  		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekapsetor_spp.pdf", 'I');  
    }
}  


 
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
