<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_mas02 extends CI_Controller {
/**/
	public function index()
	{
	$this->load->model('M_mas02');
		$data['data_mas02_sis']=$this->M_mas02->get_all_sis();
		$data['data_mas02_tarif']=$this->M_mas02->get_all_tarif();		
		//----	
		
		//----    		
		$data['page']='index';
		$this->load->view('v_mas02',$data);
	}
		 
	function insert_data(){
	    $this->load->model('M_mas02');
		$data['page']='v_mas02';
		$this->load->view('v_mas02',$data);
	}
	
	public function act_insert_data(){
	$this->load->model('M_mas02');
		$data=array(
			'id_rate' =>$this->input->post('tx_id_rate'), 
			'id_student'=>$this->input->post('tx_id_siswa'), 
			'fare'=>$this->input->post('tx_jml'), 
			'modified_by'=>$this->input->post('tx_modif'),
		);
		//print_r($data);
		$status=$this->M_mas02->insert($data);
		redirect("c_mas02");
	}
	
	
	function ajax_get_siswa(){
		$this->load->model('M_mas02');
		$get_data=$this->input->get("text");		
		
		$data_mas02=$this->M_mas02->get_siswa($get_data);
		
		$data=array();
		$index=0;
		foreach($data_mas02->result() as $row){		
			echo $row->namalengkap."|".$row->id."|".$row->namakelas."|".$row->noinduk."\n";
		}
		echo "ye";
		
	}
			
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
