<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setoran extends Alazka_Controller {

function __construct()
    {
        parent::__construct();
    }
 
	
	public function index()
	{
	    $this->load->model('Unit_model');		
		$data['data_unit']=$this->Unit_model->get_all_unit();			
		$data['page']='index';
		$this->load->view('site/header_view');
		$this->load->view('site/setor_view',$data);
		 $this->load->view('site/footer_view');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
