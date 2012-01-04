<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_tarif extends Alazka_Controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->load->model('M_data_tarif');
		$this->load->model('Rate_model');
		
		// helper untuk melakukan repopulate checkbox, radio atau select
		$this->load->helper('mr_form');
		
		// Page title untuk HTML
		$this->data['page_title'] = 'Daftar Tarif';
		
		try {
			// selalu gunakan try akan setiap model akan melempar exception
			// jika record tidak ditemukan
			$this->data['list_category'] = $this->Rate_model->get_all_category();
		} catch (Exception $e) {
			$this->data['list_category'] = array();
		}
		
		// digunakan pada form action
		// membiarkan form action kosong bukanlah ide yang baik, dan itu
		// tergantung masing-masing browser implementasinya
		$this->data['action_url'] = site_url('data_tarif/index');
		
		// untuk repopulate combo box filter
		$sess = new stdClass();
		$sess->category = $this->input->post('mn_kategori');
		$this->data['sess'] = $sess;
		
		try {
			// cek apakah ini adalah proses filter (form post)
			if ($sess->category != FALSE) {
				$this->db->like('ar_rate.category', $sess->category);
			}
			$this->data['list_tarif'] = $this->Rate_model->get_all_rate();
		} catch (Exception $e) {
			$this->data['list_tarif'] = array();
		}
		
		$this->load->view('site/header_view');
		$this->load->view('site/data_tarif_view', $this->data);
		$this->load->view('site/footer_view');
	}
	
	
	function update_data($id=0){
	$this->load->model('M_data_tarif');
		$data['data_mas01']=$this->M_data_tarif->get_all(array('id'=>$id));
		 $data['page']='v_up_data_tarif';
		$this->load->view('v_up_data_tarif',$data);		
	}
	
	 
	public function act_update_data($id=0){
	$this->load->model('M_data_tarif');
		$data=array(			
			'category'=>$this->input->post('tx_kategori'), 
			'name'=>$this->input->post('tx_tagihan'), 
			'fare'=>$this->input->post('tx_jumlah'), 
			'description'=>$this->input->post('tx_ket'), 		
		);
		$status=$this->M_data_tarif->update($id,$data);
		redirect("Data_tarif");
	}
	
 
	
	public function ajax_get_unit(){
	$this->load->model('M_data_tarif');
		$get_data=$this->input->get("text");
		$data_mas01=$this->M_data_tarif->get_unit($get_data);
		$data=array();
		$index=0;
		foreach($data_mas01->result() as $row){
			
			echo $row->nama_unit."|".$row->id_unit."\n";
		}
		
	}
	
	public function ajax_get_data()
	{
		$this->load->model('M_data_tarif');
		$aColumns = array('category');
		$start_limit=0;
		$end_limit=0;
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
        	$start_limit=$_GET['iDisplayStart'];
			$end_limit=$_GET['iDisplayLength'];
		}
		
		$array_filter=array();
		
		$array_search=array();
		if ( $_GET['sSearch'] != "" )
        {
			for($i = 0; $i < count($aColumns); $i++) {
				$array_search[$aColumns[$i]]=mysql_real_escape_string($_GET['sSearch']);
			}
		}
		
		$sOrder = "";
		
		$data=$this->M_data_tarif->get_many($array_filter,$array_search,$sOrder,$start_limit,$end_limit);	
		
		$total=0;
		$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $total,
				"iTotalDisplayRecords" => $total,
				"aaData" => array()
        );
		
		foreach($data as $value){
			
			$edit_url='<a href='.site_url('data_tarif/update_data').'/'.$value->id.' class=button>Edit</a>';  
			          
			$rows[] = array(
								$value->category
								,$value->name
								,$value->fare
								,$edit_url
			);
            $output['aaData'] = $rows; 
			$total++;                   
        }
		$output['iTotalRecords'] = $total; 
		$output['iTotalDisplayRecords'] = $total; 
		echo json_encode($output);
	}
}

