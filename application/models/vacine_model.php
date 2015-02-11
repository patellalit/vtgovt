<?php
class vacine_model extends CI_Model {
    protected $table_name = "vaccine";
	protected $person_table_name = "tbl_vacine_member_detail";
	protected $kutumb_table_name = "tbl_family";
	protected $member_table_name = "tbl_family_person";
	protected $mamta_divas_table_name = "tbl_mamtadivas";
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
	public function get_all_vacine_name()
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		return $query->result_array(); 
    }
    public function get_vacine_by_id($id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }
	public function get_vaccine_detail($member_id,$vaccine_id)
    {
		$this->db->select('*');
		$this->db->from($this->person_table_name);
		$this->db->where('member_id', $member_id);
		$this->db->where('vaccine_id', $vaccine_id);
		$query = $this->db->get();
		
		return $query->result_array(); 
    } 
	public function get_vacine_id_by_name($id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('vaccine_name', $id);
		$query = $this->db->get();
		/*echo "<pre>";
		print_r($this->db->last_query());
		echo "</pre>";*/
		return $query->result_array(); 
    }
	public function get_all_vacine_group_by_person($user_id=null)
    {
		$this->db->select('*');
		$this->db->select($this->table_name.'.vaccine_name as vaccineName');
		$this->db->select($this->member_table_name.'.first_name as firstName');
		$this->db->select($this->member_table_name.'.middle_name as middleName');
		$this->db->select($this->member_table_name.'.last_name as lastName');
		$this->db->select($this->member_table_name.'.gender as gender');
		$this->db->from($this->person_table_name);
		
		$this->db->where('given_status', '0');
		$this->db->where('due_date <=', date("Y-m-d"));
		if($user_id)
			$this->db->where($this->kutumb_table_name.'.anganwadi_id',$user_id);
		$this->db->join($this->table_name,$this->person_table_name.'.vaccine_id ='.$this->table_name.'.id','inner');
		$this->db->join($this->member_table_name,$this->person_table_name.'.member_id ='.$this->member_table_name.'.family_person_id','inner');
		$this->db->join($this->kutumb_table_name,$this->kutumb_table_name.'.family_id ='.$this->member_table_name.'.family_id','inner');
		
		$this->db->order_by($this->person_table_name.'.due_date','Asc');
		$this->db->group_by($this->person_table_name.'.member_id');
		$query = $this->db->get();
		/*echo "<pre>";
		print_r($this->db->last_query());
		echo "</pre>";*/
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
    public function get_vaccine($aanganvadi_id=null,$vaccine_id=null,$search_string=null,$vaccine_type=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {	    
		$this->db->select($this->person_table_name.'.*');
		$this->db->select('(select family_rank from tbl_family where family_id='.$this->member_table_name.'.family_id) as family_rank');
		$this->db->select($this->table_name.'.vaccine_name as vaccine_name');
		$this->db->select($this->member_table_name.'.first_name as first_name');
		$this->db->select($this->member_table_name.'.middle_name as middle_name');
		$this->db->select($this->member_table_name.'.last_name as last_name');
		$this->db->select($this->member_table_name.'.gender as gender');
		$this->db->select($this->member_table_name.'.person_rank');
		$this->db->select($this->member_table_name.'.uid_aadharnumber as uid_aadharnumber');
		$this->db->select($this->member_table_name.'.birth_date as birth_date');
		$this->db->select($this->member_table_name.'.khodkhapan_type');
		$this->db->select($this->member_table_name.'.lakshyank_code as lakshyank_code');
		$this->db->select($this->member_table_name.'.purak_aahar as purak_aahar');
		$this->db->select($this->member_table_name.'.purv_prathmik_shikshan as purv_prathmik_shikshan');
		
		
		$this->db->from($this->person_table_name);
        if($vaccine_type != null && $vaccine_type != 0)
            $this->db->where('given_status',$vaccine_type);
        else
            $this->db->where('given_status','1');
		if($vaccine_id != null && $vaccine_id != '0'){
			$this->db->where('vaccine_id', $vaccine_id);
		}
		
		$this->db->join($this->table_name, $this->person_table_name.'.vaccine_id = '.$this->table_name.'.id', 'left');
		$this->db->join($this->member_table_name, $this->person_table_name.'.member_id = '.$this->member_table_name.'.family_person_id', 'left');
		$this->db->join('tbl_family', $this->member_table_name.'.family_id = tbl_family.family_id', 'left');
        if($aanganvadi_id!=null && $aanganvadi_id != 0)
        {
            $this->db->where('tbl_family.anganwadi_id',$aanganvadi_id);
            //$this->db->join('tbl_family','tbl_family.family_id = '.$this->member_table_name.'.family_id', 'inner');
        }
		$this->db->group_by($this->person_table_name.'.id');
		
		if($search_string){
			if(DateTime::createFromFormat('Y-m-d', $search_string) !== FALSE)
			{
				$this->db->where('DATE_FORMAT('.$this->person_table_name.'.given_date,"%Y-%m-%d") <= "'.$search_string.'"');
			}
			else
			{
				$this->db->where("(first_name='".$search_string."' or middle_name='".$search_string."' or last_name='".$search_string."' or CONCAT_WS(' ',first_name,middle_name,last_name)='".$search_string."' or person_rank='".$search_string."' or family_rank='".$search_string."')");
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
		/*echo "<pre>";
		print_r($this->db->last_query());
		echo "</pre>";*/
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_vaccine($aanganvadi_id=null,$vaccine_id=null,$search_string=null,$vaccine_type=null, $order=null)
    {
		$this->db->select($this->person_table_name.'.*');
		$this->db->from($this->person_table_name);
        if($vaccine_type != null && $vaccine_type != 0)
            $this->db->where('given_status',$vaccine_type);
        else
            $this->db->where('given_status','1');
		if($vaccine_id != null && $vaccine_id != '0'){
			$this->db->where('vaccine_id', $vaccine_id);
		}
        
		if($search_string){
			if(DateTime::createFromFormat('Y-m-d', $search_string) !== FALSE)
			{
				$this->db->where('DATE_FORMAT('.$this->person_table_name.'.given_date,"%Y-%m-%d") like "'.$search_string.'"');
			}
			else
			{
				$this->db->where("(first_name='".$search_string."' or middle_name='".$search_string."' or last_name='".$search_string."' or CONCAT_WS(' ',first_name,middle_name,last_name)='".$search_string."' or person_rank='".$search_string."')");
			}
		}
        
		$this->db->join($this->table_name, $this->person_table_name.'.vaccine_id = '.$this->table_name.'.id', 'left');
		$this->db->join($this->member_table_name, $this->person_table_name.'.member_id = '.$this->member_table_name.'.family_person_id', 'left');
        if($aanganvadi_id!=null && $aanganvadi_id != 0)
        {
            $this->db->where('tbl_family.anganwadi_id',$aanganvadi_id);
            $this->db->join('tbl_family','tbl_family.family_id = '.$this->member_table_name.'.family_id', 'inner');
        }
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		/*echo "<pre>";
		print_r($this->db->last_query());
		echo "</pre>";*/
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_vacine($data)
    {
		$insert = $this->db->insert($this->person_table_name, $data);
	    return $insert;
	}
	
	/**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_mamtadivas($data)
    {
		$insert = $this->db->insert($this->mamta_divas_table_name, $data);
	    return $this->db->insert_id();
	}

    /**
    * Update activities
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_vaccine($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update($this->person_table_name, $data);
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
