<?php
class M_data_tarif extends CI_Model{ // Buat class 
function __construct()
    {
        parent::__construct();
    }
	
  	
	function get_all($filter=array()){
	$this->load->model("M_data_tarif");
		$this->db->select("*");		
		$this->db->where($filter);
		$this->db->order_by("id");
		$query = $this->db->get("ar_rate");
		return $query;
	}
	
	function get_many($params = array(),$search=array(),$order =  "",$start_limit=0,$end_limit=0){
		$this->db->select('*');		
		$this->db->where($params);
		$this->db->or_like($search);
		if($order!="")
		{
			$this->db->order_by($order);
		}
		if($start_limit !=0 && $end_limit != 0)
		{
			$this->db->limit($start_limit, $end_limit);
		}
		return $this->db->get('ar_rate')->result();
	}
	
	function update($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('ar_rate',$data);
	}
	
	function check_unit_exist($filter=""){
	$this->load->model("M_data_tarif");
		$this->db->select("*");		
		$this->db->where(array("id" => $filter));
		$query = $this->db->get("ar_rate");
		$num=$query->num_rows();
		if($num == 0){
			$this->db->insert('ar_rate',array("id" => $filter));
		}
	}
	
	function get_category(){
		$this->db->select('category');
		$this->db->distinct();
		return $this->db->get('ar_rate')->result();
	}
}
?>
