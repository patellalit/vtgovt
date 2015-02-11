<?php

class Aanganvadi_model extends CI_Model {

    protected $table_name = "aanganvadi";

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

    public function get_aanganvadi_by_id($id)

    {

		$this->db->select('*');

		$this->db->from($this->table_name);

		$this->db->where('id', $id);

		$query = $this->db->get();

		return $query->result_array(); 

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

    public function get_aanganvadi($jilla_id=null,$taluka_id=null,$gaam_id=null,$search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)

    {

	    $order=null;

		$this->db->select($this->table_name.'.*');

		$this->db->select('jilla.name_guj as jilla_name');

		$this->db->select('taluka.name_guj as taluka_name');

		$this->db->select('gaam.name_guj as gaam_name');

		$this->db->from($this->table_name);

		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where($this->table_name.'.id', $this->session->userdata('user_id'));
		}

		//jilla

		if($jilla_id != null && $jilla_id != 0){

			$this->db->where($this->table_name.'.jilla_id', $jilla_id);

		}

		$this->db->join('jilla', $this->table_name.'.jilla_id = jilla.id', 'left');

		

		//taluka

		if($taluka_id != null && $taluka_id != 0){

			$this->db->where($this->table_name.'.taluka_id', $taluka_id);

		}

		$this->db->join('taluka', $this->table_name.'.taluka_id = taluka.id', 'left');

		

		//gaam

		if($gaam_id != null && $gaam_id != 0){

			$this->db->where($this->table_name.'.gaam_id', $gaam_id);

		}

		$this->db->join('gaam', $this->table_name.'.gaam_id = gaam.id', 'left');



		$this->db->group_by($this->table_name.'.id');

		

		if($search_string){
			$this->db->where('aanganvadi_name like "'.$search_string.'" or aanganvadi_name like "'.$search_string.'" or karyakar_name like "'.$search_string.'" or tedagara_name like "'.$search_string.'"');
			//$this->db->like('aanganvadi_name', $search_string);

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

		

		return $query->result_array(); 	

    }



    /**

    * Count the number of rows

    * @param int $search_string

    * @param int $order

    * @return int

    */

    function count_aanganvadi($search_string=null, $order=null)

    {

		$order=null;

		$this->db->select('*');

		$this->db->from($this->table_name);

		if($search_string){
			$this->db->where('aanganvadi_name like "'.$search_string.'" or aanganvadi_name like "'.$search_string.'" or karyakar_name like "'.$search_string.'" or tedagara_name like "'.$search_string.'"');
			//$this->db->like('aanganvadi_name', $search_string);

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

    function store_aanganvadi($data)

    {

		$insert = $this->db->insert($this->table_name, $data);

	    return $this->db->insert_id();

	}



    /**

    * Update aanganvadi

    * @param array $data - associative array with data to store

    * @return boolean

    */

    function update_aanganvadi($id, $data)

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

    * Delete aanganvadi

    * @param int $id - aanganvadi id

    * @return boolean

    */

	function delete_aanganvadi($id){

		$this->db->where('id', $id);

		$this->db->delete($this->table_name); 

	}

	

	function doLogin($username,$password){

		$this->db->select('*');

		$this->db->from($this->table_name);

		$this->db->where('aanganvadi_number', $username)->where('password', $password);

		$query = $this->db->get();

		$result = $query->result_array();

		if(count($result) > 0){

			return array("status"=>"success","data"=>$result);

		}else{

			return array("status"=>"error_login_fail");

		}

		return $query->result_array(); 

	} 

}

?>	

