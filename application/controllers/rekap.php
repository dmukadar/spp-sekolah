<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap extends Alazka_Controller {

function __construct()
    {
        parent::__construct();
        $this->deny_group('ksr');
    }
 
	
	public function index()
	{
	    $this->load->model('Unit_model');		
		$data['data_unit']=$this->Unit_model->get_all_unit();			
		$data['page']='index';
		$this->load->view('site/header_view');
        $this->load->view('site/rekap_view',$data);
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
		printf('<script type="text/javascript" src="%s"></script>', base_url() . 'datepicker/datetimepicker_css.js');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
