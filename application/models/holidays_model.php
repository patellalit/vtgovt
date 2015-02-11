<?php
class Holidays_model extends CI_Model {
    protected $table_name = "tbl_holidays";
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
    public function get_holidays_by_id($id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    } 
	
	 public function if_holiday_exists($holiday_name,$holiday_date,$id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('holiday_name', $holiday_name);
		$this->db->where('holiday_date', $holiday_date);
		if($id!=0)
		{
			$this->db->where('id != '.$id);
		}
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch jilla data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_holidays($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {	    
		$this->db->select('*');
		$this->db->from($this->table_name);

		if($search_string){
			if(DateTime::createFromFormat('Y-m-d', $search_string) !== FALSE)
			{
				$this->db->where("`holiday_date` = '".date('Y-m-d',strtotime($search_string))."'");
			}	
			else
			{
				$this->db->where("`holiday_name` like '".$search_string."'");
			}
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
		//print_r($this->db->last_query());
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_holidays($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		if($search_string){
			if(DateTime::createFromFormat('Y-m-d', $search_string) !== FALSE)
			{
				$this->db->where("`holiday_date` = '".date('Y-m-d',strtotime($search_string))."'");
			}	
			else
			{
				$this->db->where("`holiday_name` like '".$search_string."'");
			}
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_holidays($data)
    {
		$insert = $this->db->insert($this->table_name, $data);
	    return $this->db->insert_id();
	}

    /**
    * Update jilla
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_holidays($id, $data)
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
    * Delete jilla
    * @param int $id - jilla id
    * @return boolean
    */
	function delete_holidays($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table_name); 
	}
    public function getAllholidays()
    {
        $this->db->select('id as holidayServerId,DATE_FORMAT(holiday_date,"%d-%m-%Y") as holidayDate,holiday_name as holidayName',false);
        $this->db->from($this->table_name);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array(); 	
    }
}
?>	
