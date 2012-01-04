<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tlain2 extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
    
	
	/*fungsi buat pilih sub-jenis report dari tunggakan* */
	 
	function pilih_report_tunggakan(){
		$pilihan=$this->input->post('bt_laporan');
		if($pilihan==8){
			echo "alat";
			//$this->alat();
		}
		else if($pilihan==7){	
			echo "seragam";	
			//$this->seragam();
		}
		else if($pilihan==6){			
			$this->antarjemput();
		}
		else if($pilihan==5){
			 echo "sanggar";
			//$this->sanggar();
		}
		else if($pilihan==4){
			 echo "uang buku";
			//$this->uang_buku();
		}
		else if($pilihan==3){
			 echo "uang kegiatan";
			//$this->uang_kegiatan();
		}
		else if($pilihan==2){
			 echo "uang masuk";
			//$this->uang_masuk();
		}
		else if($pilihan==1){
			 echo "SPP";
			//$this->spp();
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
		
        $this->load->model('M_antarjemput');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->M_antarjemput->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->M_antarjemput->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->M_antarjemput->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->M_antarjemput->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->M_antarjemput->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->M_antarjemput->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && !empty($tanggal_akhir)){
		$data['data_antarjemput']=$this->M_antarjemput->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->M_antarjemput->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('v_antarjemput', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekap_tunggakan_ant_jemput.pdf", 'I');       
    }
	

	
	
	function alat()
    {       
		//8    
    }
	
	function seragam()
    {       
		//7    
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
		
        $this->load->model('M_sanggar');
		$tanggal_mulai=$this->input->post('tx_mulai'); 
		$tanggal_akhir=$this->input->post('tx_akhir'); 
		$ajaran=$this->input->post('tx_ajaran');	
		$jenjang=$this->input->post('tx_unit');
	    $data['ajaran']=$ajaran;
		$data ['per_tanggal']=$tanggal_mulai;
		
		if ($jenjang==0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->M_sanggar->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));		
		$data['data_total']=$this->M_sanggar->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran));
		}
		
		else if ($jenjang==0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->M_sanggar->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		$data['data_total']=$this->M_sanggar->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran));	
		}
		
		else if ($jenjang!=0 && $tanggal_akhir==0){
		$data['data_antarjemput']=$this->M_sanggar->get_all(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->M_sanggar->get_total(array('due_date >='=>$tanggal_mulai,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		}
		
		else if ($jenjang!=0 && $tanggal_akhir!=0){
		$data['data_antarjemput']=$this->M_sanggar->get_all(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));	
		$data['data_total']=$this->M_sanggar->get_total(array('due_date >='=>$tanggal_mulai,'due_date <='=>$tanggal_akhir,'tahun'=>$ajaran, 'sis_siswa.dm_jenjang_id'=>$jenjang));
		} 
		
		$data['page']='index';
		$html = $this->load->view('v_sanggar', $data, true);
		$this->pdf->writeHTML($html, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output("rekap_tunggakan_sanggar.pdf", 'I');       
    }
	
	function uang_buku()
    {       
		  //4  
    }
	function uang_kegiatan()
    {       
		//3   
    }
	
	function uang_masuk()
    {       
		//2   
    }
	
	function spp()
    {       
		//1    
    }
}  


 
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
