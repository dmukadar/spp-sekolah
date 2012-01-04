<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap extends CI_Controller {

function __construct()
    {
        parent::__construct();
    }
 
	
	public function index()
	{
	    $this->load->model('M_unit');		
		$data['data_unit']=$this->M_unit->get_all_unit();			
		$data['page']='index';
		$this->load->view('v_rekap',$data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
