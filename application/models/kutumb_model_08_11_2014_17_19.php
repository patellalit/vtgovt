<?php

class Kutumb_model extends CI_Model {

    protected $table_name = "tbl_family";

	protected $person_table_name = "tbl_family_person";

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

    public function get_kutumb_by_id($id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('family_id', $id);
		$query = $this->db->get();
		$rs = $query->result_array();
		
		$this->db->select('*');
		$this->db->from($this->person_table_name);
		$this->db->where('family_id', $id);
		$query = $this->db->get();
		$rs[0]['persondata'] = $query->result_array();
		
		return $rs; 
    }    
	 public function checkiffamilyrankexists($familyrank,$aanganwadiid,$id='')
    {
		$this->db->select('count(*) as count');
		$this->db->from($this->table_name);
		
		$this->db->where('family_rank', $familyrank);
		$this->db->where('anganwadi_id', $aanganwadiid);
		if($id!='')
			$this->db->where('family_id !=', $id);
			
		$query = $this->db->get();
//		echo $this->db->return_query();
		$rs = $query->row_array();
		
		return $rs['count']; 
    }   
	
	public function checkiffamilymemberrankexists($familyrank,$aanganwadiid,$id='')
    {
		$this->db->select('count(*) as count');
		$this->db->from($this->person_table_name);
		
		$this->db->where('person_rank', $familyrank);
		$this->db->where('anganwadi_id',$aanganwadiid);
		if($id!='')
			$this->db->where($this->person_table_name.'.family_id !=', $id);
			
		$this->db->join('tbl_family', $this->table_name.'.family_id = tbl_family.family_id ', 'left');
			
		$query = $this->db->get();
		$rs = $query->row_array();
		   // echo '<pre>';
//    print_r($this->db->last_query());
//    echo '</pre>';
		return $rs['count']; 
    }
    /**
    * Fetch aanganvadi data from the database
    * possibility to mix search, filter and order
    * @param string $jilla_id
	* @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */

    public function get_kutumb($jilla_id=null,$taluka_id=null,$gaam_id=null,$aanganwadiid_id=null,$search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)

    {
		$this->db->select($this->table_name.'.*');
		//$this->db->select('tbl_family_person.*');
		$this->db->select('aanganvadi.aanganvadi_name as aanganvadi_name');
		//$this->db->select('gaam.name_guj as gaam_name');
		$this->db->from($this->table_name);
		//aanganvadi
		if($aanganwadiid_id != null && $aanganwadiid_id != 0){
			$this->db->where('anganwadi_id', $aanganwadiid_id);
		}
		$this->db->join('aanganvadi', $this->table_name.'.anganwadi_id = aanganvadi.id', 'left');
		/*
		//taluka
		if($taluka_id != null && $taluka_id != 0){

			$this->db->where('taluka_id', $taluka_id);

		}

		$this->db->join('taluka', $this->table_name.'.taluka_id = taluka.id', 'left');

		

		//gaam

		if($gaam_id != null && $gaam_id != 0){

			$this->db->where('gaam_id', $gaam_id);

		}

		$this->db->join('gaam', $this->table_name.'.gaam_id = gaam.id', 'left');

		*/

		$this->db->group_by($this->table_name.'.family_id');

		/*

		if($search_string){

			$this->db->like('name', $search_string);

		}*/

		$this->db->group_by('family_id');



		if($order){

			$this->db->order_by($order, $order_type);

		}else{

		    $this->db->order_by('family_id', $order_type);

		}



        if($limit_start && $limit_end){

          $this->db->limit($limit_start, $limit_end);	

        }



        if($limit_start != null){

          $this->db->limit($limit_start, $limit_end);    

        }
		$query = $this->db->get();
		return $query->result_array(); 	

    }



    /**

    * Count the number of rows

    * @param int $search_string

    * @param int $order

    * @return int

    */

    function count_kutumb($search_string=null, $order=null)

    {

		$this->db->select('*');

		$this->db->from($this->table_name);

		/*

		if($search_string){

			$this->db->like('name', $search_string);

		}*/

		if($order){

			$this->db->order_by($order, 'Asc');

		}else{

		    $this->db->order_by('family_id', 'Asc');

		}

		$query = $this->db->get();

		return $query->num_rows();        

    }



    /**

    * Store the new item into the database

    * @param array $data - associative array with data to store

    * @return boolean 

    */

    function store_kutumb($data)

    {

		$insert = $this->db->insert($this->table_name, $data);

	    return $this->db->insert_id();

	}

	

	function store_kutumb_person($data)

    {

		$insert = $this->db->insert($this->person_table_name, $data);

	    return $insert;

	}



    /**

    * Update aanganvadi

    * @param array $data - associative array with data to store

    * @return boolean

    */

    function update_kutumb($id, $data)

    {

		$this->db->where('family_id', $id);

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

    * Delete aanganvadi

    * @param int $id - aanganvadi id

    * @return boolean

    */

	function delete_kutumb($id){
		$this->db->where('family_id', $id);
		$this->db->delete($this->table_name); 
	} 
	
	function delete_kutumb_person($id){
		$this->db->where('family_id', $id);
		$this->db->delete($this->person_table_name); 
	} 
	
	public function get_all_kutumb_details()
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->join($this->person_table_name,$this->table_name.'.family_id='.$this->person_table_name.'.family_id AND '.$this->person_table_name.'.ageIn_year <= 5','inner');
		$query = $this->db->get();
		$result = $query->result_array();
		if(count($result) > 0){
			return array("status"=>"success","data"=>$result);
		}else{
			return array("status"=>"Kutumb not found.");
		}
		return $query->result_array(); 
    }
}

?>	