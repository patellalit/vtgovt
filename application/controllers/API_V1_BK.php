<?php
class API_V1 extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('aanganvadi_model');
		$this->load->model('kutumb_model');
    }
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {
        echo "hello";die;
    }//index
	
	/**
    * check login
    * @return void
    */
	public function login(){
		$username = trim($this->input->post("username"));
		$password = trim($this->input->post("password"));
		
		if($username != "" or $password != ""){
			$response = $this->aanganvadi_model->doLogin($username,$password);
			if($response["status"] == "success"){
				$result = $response["data"];
				$returnArray = array("status"=>1,"user_id"=>$result[0]["id"]);
			}else{
				$returnArray = array("status"=>0,"message"=>$response["status"]);
			}
		}else{
			$returnArray = array("status"=>0,"message"=>"Please enter required fields.");	
		}
		echo json_encode($returnArray);
	} //login
	
	/**
    * Get FamillyData
    * @return void
    */
	public function get_kutumb_data(){
		$user_id = trim($this->input->get("user_id"));
		$token = trim($this->input->get("token"));
		if($token != ""){
			if($user_id != ""){
				$response = $this->kutumb_model->get_kutumb_details($user_id);
				if($response["status"] == "success"){
					$result = $response["data"];
					$returnArray = array("status"=>1,"data"=>$result[0]);
				}else{
					$returnArray = array("status"=>0,"message"=>$response["status"]);
				}
			}else{
				$returnArray = array("status"=>0,"message"=>"Please enter kutumb id.");		
			}
		}else{
			$returnArray = array("status"=>0,"message"=>"Token is not valid. Please try again.");	
		}
		echo json_encode($returnArray);
	}
	
}