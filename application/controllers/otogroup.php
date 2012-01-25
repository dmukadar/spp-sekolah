<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Otogroup extends Alazka_Controller {
	public function __construct() {
		parent::__construct();
		// $this->output->enable_profiler(FALSE);

		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		$this->load->model('Rate_model');
	}
	
	public function index() {
		$this->load->model('Kelas_model');
		$this->load->model('Siswa_model');
		$this->load->model('Rate_model');

		$this->data['sess'] = null;
		$this->data['action_url'] = site_url('tagihan/simpan');
		$this->data['info_url'] = site_url('tagihan/info');

		$this->data['ajax_siswa_url'] = site_url('tarif_khusus/get_ajax_siswa/10/');

		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}

		$this->load->view('site/header_view');
		$this->load->view('site/kelompok_tagihan_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	/**
	 * Method untuk menampilkan link edit sesuai dengan ID dari tagihan. Method
	 * biasanya digunakan pada view.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param Rate $tarif - Instance dari object Custom_Rate
	 * @return string
	 */
	public function get_edit_link($model) {
		return site_url('tagihan/edit/' . $model->get_id());
	}
	
	/**
	 * Method untuk menampilkan link edit sesuai dengan ID dari tagihan. Method
	 * biasanya digunakan pada view.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param Rate $tarif - Instance dari object Custom_Rate
	 * @return string
	 */
	public function get_delete_link($model) {
		$token = md5($model->get_id());
		return site_url('tagihan/delete/' . $model->get_id() . '/' . $token);
	}
	
	
	/**
	 * Method untuk menambahkan javascript baru pada HEAD
	 *
	 * @author Rio Astamal <me@rioastamal>
	 *
	 * @return void
	 */
	public function add_more_javascript() {
		$script = '
		<script type="text/javascript" src="%s"></script>
		<script type="text/javascript" src="%s"></script>
		';
		printf($script, base_url() . 'js/json.suggest.js', base_url() . 'js/jquery.chained.min.js');
	}

	public function form($loadId=null) {

		$this->load->helper('mr_form');

		$this->data['sess'] = null;
		$this->data['action_url'] = site_url('tagihan/simpan');
		$this->data['info_url'] = site_url('tagihan/info');

		$this->data['ajax_siswa_url'] = site_url('tarif_khusus/get_ajax_siswa/10/');

		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}

		if (! empty($loadId)) {
			$this->data['sess'] = $this->Siswa_model->find_by_pk($loadId);
		}

		$this->load->view('site/header_view');
		$this->load->view('site/form_kelompok_tagihan', $this->data);
		$this->load->view('site/footer_view');
	}

	public function import() {
		try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
			
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}

		$this->load->view('site/header_view');
		$this->load->view('site/impor_kelompok_tagihan_view', $this->data);
		$this->load->view('site/footer_view');
	}
//---by puz	
    function loadExcel()
	{	
		
			 $rate=$this->input->post('id_rate');	
			 $data['rate']=$rate;
		     $this->load->helper('excel_reader2');
		
			 $import = new Spreadsheet_Excel_Reader($_FILES['file_import']['tmp_name']);
             $baris = $import->rowcount($sheet_index=0);
             $counter=0;
             $error_msg="";
             $counter_index=0;
             $status=true;
			 
			for ($i=1; $i<=$baris; $i++)
		    {
				$id_siswa=$import->val($i, 'A');
				$nama=$import->val($i, 'B');
				$this->load->model('Keltagih_model');		
				$check_siswa=$this->Keltagih_model->check_siswa($id_siswa);		
				$check_group=$this->Keltagih_model->check_group($id_siswa);	
				
			if ($check_siswa > 0&& $check_group > 0)
			{
			  $data['status']="SUDAH";
			  $data['induk']=$id_siswa;
			  $data['nama']=$nama;
			  $data_siswa[$counter]['status']="SUDAH";
			  $data_siswa[$counter]['induk']=$id_siswa;
			  $data_siswa[$counter]['nama']=$nama;
			  
			   $data['kelas']="";		
			  $data_siswa[$counter]['kelas']=" ";
			  
			  $data['jenjang']="";		
			  $data_siswa[$counter]['jenjang']=" ";	
			  
			}
			else if($check_siswa > 0&& $check_group==0)
			{
			  $data['status']="OK";
			  $data['induk']=$id_siswa;
			  $data['nama']=$nama;
			  $data_siswa[$counter]['status']="OK";
			  $data_siswa[$counter]['induk']=$id_siswa;
			  $data_siswa[$counter]['nama']=$nama;	  	
			 /* $data['kelas']= $this->Keltagih_model->kelas(array(),$id_siswa);		
			   $data_siswa[$counter]['kelas']= $data['kelas'];*/
			 
			  $data['kelas']=" ";	
			  $data_siswa[$counter]['kelas']=" ";	
			  
			  $data['jenjang']="";		
			  $data_siswa[$counter]['jenjang']=" "; 
			}
			
			else if ($check_siswa==0 && $check_group==0)		
			{
			  $data['status']="GAGAL";
			  $data['induk']="  ";
			  $data['nama']=$nama;
			  $data_siswa[$counter]['status']="GAGAL";
			  $data_siswa[$counter]['induk']="  ";
			  $data_siswa[$counter]['nama']=$nama;
			  
			  $data['kelas']="";		
			  $data_siswa[$counter]['kelas']=" ";
			  
			  $data['jenjang']="";		
			  $data_siswa[$counter]['jenjang']=" ";	
			}
		$counter++;

		}
		
		$data['data_siswa']=$data_siswa;
		
		$this->load->view('site/header_view');		
		$this->load->view('site/tampil_tagihan_view',$data);
		$this->load->view('site/footer_view');
		try 
			{
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();		
     		} 
		
		catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}

		
	}
//---
	public function insert_data_from_excel(){
		
		$counter=$this->input->post('tx_counter');
		$this->load->model("Keltagih_model");
		for($i=1;$i<=$counter;$i++){
			$status=$this->input->post('tx_status_'.$i);
			//echo $status;
			if($status=="OK"){
				$data=array(
				'id_rate' =>$this->input->post('tx_rate'), 
				'id_student'=>$this->input->post('tx_induk_'.$i)
				);
				$status=$this->Keltagih_model->insert($data);
			}
		}
		
			try {
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
			
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}
		$this->load->view('site/header_view');
		$this->load->view('site/impor_kelompok_tagihan_view', $this->data);
		$this->load->view('site/footer_view');
	}

public function insert_data(){
		
		$data=array(
			'id_rate' =>$this->input->post('rate'), 
			'id_student'=>$this->input->post('tx_induk')
		);
		$status=$this->Keltagih_model->insert($data);
		$this->load->view('site/header_view');
		$this->load->view('site/form_kelompok_tagihan', $this->data);
		$this->load->view('site/footer_view');
	}
//--
}
