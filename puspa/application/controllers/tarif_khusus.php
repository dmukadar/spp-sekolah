<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarif_khusus extends CI_Controller {
/**/
	public function index()
	{
		$this->load->model('M_vtarif_khusus');
		$data['view']='form';
		$no_induk=$this->input->post('tx_induk');
		if(!empty($no_induk)){
			$data['view']='data';
			$data['data_mas03']=$this->M_vtarif_khusus->get_all(array('sis_siswa.noinduk' => $no_induk));
		}
		
		$data['page']='index';
		$this->load->view('v_tarif_khusus',$data);
	}
	 
	
	function ajax_get_siswa(){
		$this->load->model('M_vtarif_khusus');
		$get_data=$this->input->get("text");		
		
		$data_mas03=$this->M_vtarif_khusus->get_siswa($get_data);
		
		$data=array();
		$index=0;
		foreach($data_mas03->result() as $row){		
			echo $row->namalengkap."|".$row->id."|".$row->namakelas."|".$row->noinduk."\n";
		}
		
	}
	
	function update_data($id=0){
	$this->load->model('M_vtarif_khusus');
		$data['data_mas03']=$this->M_vtarif_khusus->get_all(array('id'=>$id));
		 $data['page']='v_tarif_khusus';
		$this->load->view('v_tarif_khusus',$data);		
	}
	
	 
	public function act_update_data($id=0){
	$this->load->model('M_vtarif_khusus');
		$data=array(			
			'category'=>$this->input->post('tx_kategori'), 
			'name'=>$this->input->post('tx_tagihan'), 
			'fare'=>$this->input->post('tx_jumlah'), 
			'description'=>$this->input->post('tx_ket'), 		
		);
		$status=$this->M_mas01->update($id,$data);
		redirect("data_tarif");
	}
	
 
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
