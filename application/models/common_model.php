<?php
class Common_model extends CI_Model {
	protected $base_url = "http://lanover.com/lan/icds/Webservice/";//"http://localhost/curltest/";//"http://lanover.com/lan/icds/Webservice/";
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
	function store_data($data,$table_name)
    {
		$insert = $this->db->insert($table_name, $data);
	    return $this->db->insert_id();
	}
	public function save_curl_data($data_string,$json_url)
    {
	//echo $data_string;
		//$data_string = "token=900150983cd24fb0d6963f7d28e17f72&email=kamal@gmail.com&comment=commentusingcurl&story_id=2";
		//$json_url='';
		$ch = curl_init($this->base_url.$json_url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));                                                                                                                                     
		$result = curl_exec($ch);
		//print_r($result);
		return $result;
    }    
}
?>	