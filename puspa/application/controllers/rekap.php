<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap extends CI_Controller {

function __construct()
    {
        parent::__construct();
    }
 
	
	public function index()
	{
	    $this->load->model('Unit_model');		
		$data['data_unit']=$this->Unit_model->get_all_unit();			
		$data['page']='index';
		$this->load->view('sites/header_view');
        $this->load->view('rekap_view',$data);
        $this->load->view('sites/footer_view');

	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
