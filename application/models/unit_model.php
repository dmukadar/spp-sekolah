<?php
class Unit_model extends CI_Model{ // Buat class 
function __construct()
    {
        parent::__construct();
    }


function get_all_unit($filter=array()){
	    $this->load->model("Unit_model");
		$this->db->select("*");		
		$this->db->where("id > 1");
		$this->db->where($filter);
		$this->db->order_by("id");
		$query = $this->db->get("dm_jenjang");			
	    return $query;
	}
	
}
?>
