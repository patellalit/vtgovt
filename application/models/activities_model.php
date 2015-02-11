<?php
class activities_model extends CI_Model {
    protected $table_name = "tbl_activities";
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
    public function get_activities_by_id($id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch activities data from the database
    * possibility to mix search, filter and order
    * @param string $agegroup_id
	* @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_activities($agegroup_id=null,$search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select($this->table_name.'.*');
		$this->db->select('tbl_agegroup.name as agegroup_name');
		$this->db->from($this->table_name);
		if($agegroup_id != null && $agegroup_id != 0){
			$this->db->where('agegroup_id', $agegroup_id);
		}
		
		$this->db->join('tbl_agegroup', $this->table_name.'.agegroup_id = tbl_agegroup.id', 'left');

		$this->db->group_by($this->table_name.'.id');
		
		if($search_string){
			$this->db->where($this->table_name.".`name` like '".$search_string."'");
		}
		$this->db->group_by('id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
//		echo "<pre>";
//		print_r($this->db->last_query());
//		echo "</pre>";
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_activities($agegroup_id=null,$search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		if($search_string){
			$this->db->where($this->table_name.".`name` like '".$search_string."'");
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
//		echo "<pre>";
//		print_r($this->db->last_query());
//		echo "</pre>";
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_activities($data)
    {
		$insert = $this->db->insert($this->table_name, $data);
	    return $insert;
	}

    /**
    * Update activities
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_activities($id, $data)
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
	function delete_activities($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table_name); 
	}
 
}
?>	
