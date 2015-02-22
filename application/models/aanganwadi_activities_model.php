<?php
class aanganwadi_activities_model extends CI_Model {
    protected $table_name = "tbl_aanganvadi_activities";
	protected $activity_table_name = "tbl_activities";
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_activities_by_aanganwadi_id($id,$agegroup_id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('aanganvadi_id', $id);
		$this->db->where('agegroup_id', $agegroup_id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    
    /**
     * Get product by his is
     * @param int $product_id
     * @return array
     */
    public function get_all_activities_by_aanganwadi_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where('aanganvadi_id', $id);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_aanganwadi_activities($data)
    {
		$insert = $this->db->insert($this->table_name, $data);
	    return $insert;
	}

    /**
    * Update activities
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_aanganwadi_activities($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete activities
    * @param int $id - activities id
    * @return boolean
    */
	function delete_aanganwadi_activities($id){
		$this->db->where('aanganvadi_id', $id);
		$this->db->delete($this->table_name); 
	}
    public function get_avtivity_done_in_date($activityid,$aanganwadi_id,$startdate,$enddate)
    {
        $this->db->select('count(*) as cnt');
        $this->db->from($this->table_name);
        $this->db->where('aanganvadi_id', $aanganwadi_id);
        $this->db->where('FIND_IN_SET('.$activityid.',activity_id) !=0');
        $this->db->where('date between \''.$startdate.'\' and \''.$enddate.'\'');
        
        $query = $this->db->get();
        $rs = $query->result_array();
        //print_r($this->db->last_query());
        return $rs[0]['cnt'];
    }
 
}
?>	
