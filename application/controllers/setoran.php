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
		//support 3 jenis laporan 1 = detil penerimaan, 2 = rekap harian, 3 = history pembayaran
		$tipe = $this->input->post('tipe');
		$kategori = $this->input->post('kategori');
		$persiswa = $this->Rate_model->get_all_category();
		if (! in_array($kategori, $persiswa)) throw new Exception("invalid rate category");

		switch ($tipe) {
			case 1:
				$this->laporan_persiswa($kategori);
				break;
			case 2:
				$this->rekap_harian();
				break;
			default:
				throw new Exception("unknown report type");
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
		$content = $this->load->view('site/detil_pembayaran_per_siswa_view', $data, true);
		$ttd = $this->load->view('site/cetak_ttd_laporan_setor', $data, true);

		$this->load->library('pdf');
    $this->pdf->SetSubject('Detil Laporan Penerimaan');
    $this->pdf->SetKeywords('Laporan Penerimaan Kas Al Azhar Kelapa Gading Surabaya');      
		$this->pdf->SetHeaderData('alazka.jpg', 0, "                                        YAYASAN AL AZHAR KELAPA GADING", "                                             Jl. Taman Bhaskara Utara, Mulyorejo - Surabaya\n                                           Telp. (031) 5927420, 5927447, Fax. (031) 5938179 ");
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));

		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $this->pdf->SetFont('times', '', 10);   
    $this->pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 5, PDF_MARGIN_RIGHT);
    $this->pdf->AddPage(); 
  	$this->pdf->writeHTML($content, true, true, true, true, '');		

  	$this->pdf->writeHTML($ttd, true, true, true, true, '');		
		$this->pdf->lastPage();		
		$this->pdf->Output($filename, 'I');  
	}
	protected function rekap_harian() {
	  $start = $this->input->post('tgl-mulai');

		$jenjang = $this->input->post('tx_unit');
		$filename = 'rekap_penerimaan_' . $jenjang . $start . '.pdf';
		$result = array();
		$kategori = $this->Rate_model->get_all_category();
		foreach ($kategori as $r) $result[$r] = array('total'=>0);

		//construct the data structure we need
		$grandTotal = 0;
		$payment = $this->Report_model->getPaymentSummary($jenjang, $start);
		foreach ($payment as $r) {
			if (! isset($result[$r->category][$r->name])) {
				$result[$r->category][$r->name] = array();
				$result[$r->category][$r->name]['total'] = 0;
			}
			if (! isset($result[$r->category][$r->name][$r->kelas])) {
				$result[$r->category][$r->name][$r->kelas] = array();
			}

			$grandTotal += $r->received;
			$result[$r->category]['total'] += $r->received;
			$result[$r->category][$r->name]['total'] += $r->received;
			array_push($result[$r->category][$r->name][$r->kelas], $r);
		}
		if ($jenjang > -1) {
			$nm_jenjang=$this->Unit_model->get_all_unit(array('id'=>$jenjang));			
			$nm_jenjang=$nm_jenjang[0]->nama;
		} else {
			$nm_jenjang = array();
			foreach ($this->Unit_model->get_all_unit() as $j) { array_push($nm_jenjang, $j->nama); }

			$nm_jenjang = implode(', ', $nm_jenjang);
		}
		$data['grand_total'] = $grandTotal;
		$data['list_payment'] = $result;
		$data['ajaran'] = $this->TahunAkademik_model->berjalan->get_tahun();
		$data['start'] = $start;
		$data['nm_jenjang'] = $nm_jenjang;
		$data['page_title'] = sprintf('Ringkasan Penerimaan Kas');
		//$this->load->view('site/rekap_penerimaan_siswa_view', $data);
		/*
		$content = $this->load->view('site/rekap_pembayaran_view', $data);
		return false;
		*/
		$content = $this->load->view('site/rekap_pembayaran_view', $data, true);
		$ttd = $this->load->view('site/cetak_ttd_laporan_setor', $data, true);

		$this->load->library('pdf');
    $this->pdf->SetSubject('Rekap Penerimaan');
    $this->pdf->SetKeywords('Rekap Penerimaan Kas Al Azhar Kelapa Gading Surabaya');      
		$this->pdf->SetHeaderData('alazka.jpg', 0, "                                        YAYASAN AL AZHAR KELAPA GADING", "                                             Jl. Taman Bhaskara Utara, Mulyorejo - Surabaya\n                                           Telp. (031) 5927420, 5927447, Fax. (031) 5938179 ");
		$this->pdf->setHeaderFont(Array('times', '', '14'));
		$this->pdf->setFooterFont(Array('times', '', '12'));
    $this->pdf->SetFont('times', '', 10);   
    $this->pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);    
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 5, PDF_MARGIN_RIGHT);
    $this->pdf->AddPage(); 
  	$this->pdf->writeHTML($content, true, true, true, true, '');		

  	$this->pdf->writeHTML($ttd, true, true, true, true, '');		
/*
		$this->pdf->startTransaction();
		$curPage = $this->pdf->getPage();
  	$this->pdf->writeHTML($ttd, true, true, true, true, '');		
		if ($this->pdf->getPage() > $curPage) {
			$this->pdf->rollbackTransaction();
			$this->pdf->AddPage();
  		$this->pdf->writeHTML($ttd, true, true, true, true, '');		
		}
		$this->pdf->commitTransaction();
*/

		$this->pdf->lastPage();		
		$this->pdf->Output($filename, 'I');  
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
