<?php

class Common_model extends CI_Model {



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

    public function get_all_data($tablename)

    {

		$this->db->select('*');

		$this->db->from($tablename);

//		$this->db->where('id', $id);

		$query = $this->db->get();

		return $query->result_array(); 

    }  
	
	public function get_selected_data($tablename,$id)

    {

		$this->db->select('*');

		$this->db->from($tablename);

		$this->db->where('id', $id);

		$query = $this->db->get();
		$res= $query->result_array();
		if(count($res) > 0)
			return $res[0];
		else{
			$res = $this->get_all_data($tablename);
			return $res[0];
		}

    }    

}

?>	