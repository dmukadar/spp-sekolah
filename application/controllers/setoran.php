<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setoran extends Alazka_Controller {

function __construct()
    {
        parent::__construct();
        $this->deny_group('ksr');

	    	$this->load->model('Unit_model');		
				$this->load->model('Rate_model');
				$this->load->model('Kelas_model');
				$this->load->model('Report_model');
				$this->load->model('TahunAkademik_model');
    }
 
	
	public function index()
	{
		$data['data_unit']=$this->Unit_model->get_all_unit();			
		$data['list_rate_category']=$this->Rate_model->get_all_category();			
		$data['page']='index';
		$this->load->view('site/header_view');
		$this->load->view('site/setor_view',$data);
		 $this->load->view('site/footer_view');
	}
	
	/**
	 * Method untuk menambahkan javascript datepicker pada HEAD
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @return void
	 */
	public function add_more_javascript() {
		//adminique template already has datepicker support, please read the doc
		//printf('<script type="text/javascript" src="%s"></script>', base_url() . 'datepicker/datetimepicker_css.js');
	}

	public function cetak() {
		$tipe = $this->input->post('tipe');
		$persiswa = $this->Rate_model->get_all_category();
		if (in_array($tipe, $persiswa)) {
			$this->laporan_persiswa($tipe);
		}
	}
	protected function laporan_persiswa($kategori) {
	  $start = $this->input->post('tgl-mulai');
	  $end = $this->input->post('tgl-selesai');

		$jenjang = $this->input->post('tx_unit');
		$filename = str_replace(array('Uang ', ' '), array('', '_'), 'terima_'.$kategori.$jenjang.$start) . '.pdf';
		$data['list_payment']=$this->Report_model->getAllPayments($kategori, $jenjang, $start, $end);
		if ($jenjang > -1) {
			$nm_jenjang=$this->Unit_model->get_all_unit(array('id'=>$jenjang));			
			$nm_jenjang=$nm_jenjang[0]->nama;
		} else {
			$nm_jenjang = array();
			foreach ($this->Unit_model->get_all_unit() as $j) { array_push($nm_jenjang, $j->nama); }

			$nm_jenjang = implode(', ', $nm_jenjang);
		}
		$data['kategori'] = $kategori;
		$data['ajaran'] = $this->TahunAkademik_model->berjalan->get_tahun();
		$data['start'] = $start;
		$data['end'] = $end;
		$data['nm_jenjang'] = $nm_jenjang;
		$data['page_title'] = sprintf('Laporan Penerimaan %s Siswa', $kategori);
		//$this->load->view('site/rekap_penerimaan_siswa_view', $data);
		$content = $this->load->view('site/rekap_penerimaan_siswa_view', $data, true);

		$this->load->library('pdf');
    $this->pdf->SetSubject('Laporan Setoran Lain-lain');
    $this->pdf->SetKeywords('TCPDF, PDF');      
    $this->pdf->SetFont('times', '', 12);   
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
    $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $this->pdf->AddPage(); 
  	$this->pdf->writeHTML($content, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output($filename, 'I');  
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
