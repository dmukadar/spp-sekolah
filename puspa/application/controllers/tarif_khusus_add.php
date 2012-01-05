<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarif_khusus_add extends CI_Controller {
/**/
	public function index()
	{
	$this->load->model('Tarif_khusus_model');
		$data['data_mas02_sis']=$this->Tarif_khusus_model->get_all_sis();
		$data['data_mas02_tarif']=$this->Tarif_khusus_model->get_all_tarif();		
		//----	
		
		//----    		
		$data['page']='index';
		$this->load->view('v_tarif_khusus_add',$data);
	}
		 
	function insert_data(){
	    $this->load->model('Tarif_khusus_model');
		$data['page']='v_tarif_khusus_add';
		$this->load->view('v_tarif_khusus_add',$data);
	}
	
	public function act_insert_data(){
	$this->load->model('Tarif_khusus_model');
		$data=array(
			'id_rate' =>$this->input->post('tx_id_rate'), 
			'id_student'=>$this->input->post('tx_id_siswa'), 
			'fare'=>$this->input->post('tx_jml'), 
			'modified_by'=>$this->input->post('tx_modif'),
		);
		//print_r($data);
		$status=$this->Tarif_khusus_model->insert($data);
		redirect("tarif_khusus_add");
	}
	
	
	function ajax_get_siswa(){
		$this->load->model('Tarif_khusus_model');
		$get_data=$this->input->get("text");		
		
		$data_mas02=$this->Tarif_khusus_model->get_siswa($get_data);
		
		$data=array();
		$index=0;
		foreach($data_mas02->result() as $row){		
			echo $row->namalengkap."|".$row->id."|".$row->namakelas."|".$row->noinduk."\n";
		}
		echo "yes";
		
	}
			
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
