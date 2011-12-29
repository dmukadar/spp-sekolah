<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_mas01 extends CI_Controller {
	
	public function index()
	{
		$this->load->model('M_mas01');
		$data['category']=$this->M_mas01->get_category();
		$data['page']='index';
		$this->load->view('v_mas01',$data);
	}
	
	 
	
	function update_data($id=0){
	$this->load->model('M_mas01');
		$data['data_mas01']=$this->M_mas01->get_all(array('id'=>$id));
		 $data['page']='v_mas04';
		$this->load->view('v_mas04',$data);		
	}
	
	 
	public function act_update_data($id=0){
	$this->load->model('M_mas01');
		$data=array(			
			'category'=>$this->input->post('tx_kategori'), 
			'name'=>$this->input->post('tx_tagihan'), 
			'fare'=>$this->input->post('tx_jumlah'), 
			'description'=>$this->input->post('tx_ket'), 		
		);
		$status=$this->M_mas01->update($id,$data);
		redirect("c_mas01");
	}
	
 
	
	public function ajax_get_unit(){
	$this->load->model('M_mas01');
		$get_data=$this->input->get("text");
		$data_mas01=$this->M_mas01->get_unit($get_data);
		$data=array();
		$index=0;
		foreach($data_mas01->result() as $row){
			
			echo $row->nama_unit."|".$row->id_unit."\n";
		}
		
	}
	
	public function ajax_get_data()
	{
		$this->load->model('M_mas01');
		$aColumns = array('category');
		$start_limit=0;
		$end_limit=0;
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
        	$start_limit=$_GET['iDisplayStart'];
			$end_limit=$_GET['iDisplayLength'];
		}
		/* filtering parameter
		 * read from parameter passed by jason 
		 * */
		$array_filter=array();
		
		/* searching parameter
		 * read from parameter passed by jason 
		 * */
		$array_search=array();
		if ( $_GET['sSearch'] != "" )
        {
			for($i = 0; $i < count($aColumns); $i++) {
				$array_search[$aColumns[$i]]=mysql_real_escape_string($_GET['sSearch']);
			}
		}
		
		/* Ordering parameter
		 * read from parameter passed by jason 
		 * */
		$sOrder = "";
		/*if ( isset( $_GET['iSortCol_0'] ) )
		{			
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
					".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );		
		}
		/*
		 * query from database model
		 * based on parameter
		 */
		/*if($this->session->userdata('group') != "admin"){				
			$array_filter = $array_filter + array('user_id' => $this->session->userdata('user_id'));
		}*/
		
		$data=$this->M_mas01->get_many($array_filter,$array_search,$sOrder,$start_limit,$end_limit);	
		
		$total=0;
		$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $total,
				"iTotalDisplayRecords" => $total,
				"aaData" => array()
        );
		/*
		 * read data from query result
		 * store on the array to be sent with json format
		 */
		foreach($data as $value){
			
			$edit_url='<a href='.site_url('c_mas01/update_data').'/'.$value->id.' class=button>Edit</a>';  
			          
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
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
