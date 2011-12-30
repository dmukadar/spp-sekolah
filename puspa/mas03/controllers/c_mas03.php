<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_mas03 extends CI_Controller {
/**/
	public function index()
	{
		$this->load->model('M_mas03');
		$data['view']='form';
		$no_induk=$this->input->post('tx_induk');
		if(!empty($no_induk)){
			$data['view']='data';
			$data['data_mas03']=$this->M_mas03->get_all(array('sis_siswa.noinduk' => $no_induk));
		}
		
		$data['page']='index';
		$this->load->view('v_mas03',$data);
	}
	 
	
	function ajax_get_siswa(){
		$this->load->model('M_mas03');
		$get_data=$this->input->get("text");		
		
		$data_mas03=$this->M_mas03->get_siswa($get_data);
		
		$data=array();
		$index=0;
		foreach($data_mas03->result() as $row){		
			echo $row->namalengkap."|".$row->id."|".$row->namakelas."|".$row->noinduk."\n";
		}
		
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
