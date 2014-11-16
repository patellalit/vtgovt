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

		$this->load->model('attendance_model');

		$this->load->model('common_model');

		$this->lang->load('messages','gujarati');

    }

    /**

    * Load the main view with all the current model model's data.

    * @return void

    */

    public function index()

    {

        echo "hello";die;

    }//index

	protected function checkBasicInfo($method){

		if ($method === 'POST' && $this->input->server('REQUEST_METHOD') !== 'POST'){

			$returnArray = array("status"=>0,"message"=>$this->lang->line('error_method_invalid'));

			$this->out($returnArray);

		}

		$user_id = $this->input->get("user_id");

		if($user_id == "")

			$user_id = $this->input->post("user_id");

		$token = $this->input->get("token");

		if($token == "")

			$token = $this->input->post("token");			

		//if($token != ""){

			if($user_id != ""){

				return true;

			}else{

				$returnArray = array("status"=>0,"message"=>$this->lang->line('error_login_id_missing'));		

			}

		//}else{

			//$returnArray = array("status"=>0,"message"=>$this->lang->line('error_token_missing'));	

		//}

		$this->out($returnArray);

	}

    protected function out($returnArray){

    	//header("Content-type: application/json");

		echo trim(json_encode($returnArray));

		exit;

	}

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



				$returnArray = array("status"=>0,"message"=>$this->lang->line($response["status"]));



			}



		}else{



			$returnArray = array("status"=>0,"message"=>$this->lang->line('error_fields_missing'));	



		}



		$this->out($returnArray);



	} //login



	



	/**



    * Get FamillyData



    * @return void



    */



	public function user_data(){



		//check basic data



		$this->checkBasicInfo("GET");







		$user_id = trim($this->input->get("user_id"));



		



		//all children with less than 5 years



		$response = $this->kutumb_model->get_all_kutumb_details();



		if($response["status"] == "success"){



			$result = $response["data"];



			$return_data = array();



			foreach($result as $kutumb){



				



				$cast = $castArray = $this->common_model->get_selected_data('tbl_caste',$kutumb["jati_id"]);



				$handicap = $this->common_model->get_selected_data('tbl_handicap',$kutumb["khodkhapan_type"]);



				$gender = $this->common_model->get_selected_data('tbl_gender',$kutumb["gender"]);



				$return_data[] = array("childServerId"=>$kutumb["family_person_id"],"name"=>$kutumb["first_name"]." ".$kutumb["middle_name"]." ".$kutumb["last_name"],



										"surveyNo"=>$kutumb["family_id"],"age"=>$kutumb["ageIn_year"],



										"gender"=>$gender["name_guj"],"dateOfBirth"=>date("d-m-Y",strtotime($kutumb["birth_date"])),"cast"=>$cast["name_guj"],



										"handicap"=>$handicap["name_guj"]);



			}



			$childInfo = array("FormType"=>1,"childInfo"=>$return_data);



		}else{



			$childInfo = array("FormType"=>1,"childInfo"=>null);



		}



		

		$castArray = $this->common_model->get_all_data('tbl_caste');

		$religionArray = $this->common_model->get_all_data('tbl_religion');

		$placeArray = $this->common_model->get_all_data('tbl_place');

		$relationArray = $this->common_model->get_all_data('tbl_relation');

		$genderArray = $this->common_model->get_all_data('tbl_gender');

		$maritalStatusArray = $this->common_model->get_all_data('tbl_maritalstatus');

		$targetCodeArray = $this->common_model->get_all_data('tbl_targetcode');

		$malformationTypeArray = $this->common_model->get_all_data('tbl_malformationtype');



		

		

		$commonDropDowns = array("FormType"=>6,"caste"=>$castArray,"religion"=>$religionArray,"place"=>$placeArray,"relationWithFamilyHead"=>$relationArray,"gender"=>$genderArray,"maritalStatus"=>$maritalStatusArray,"targetCode"=>$targetCodeArray,"malformationType"=>$malformationTypeArray,"anganwadiServices"=>anganwadiServicesArray());



		



		$returnArray = array("status"=>1,"message"=>$this->lang->line('success_data_downloaded'),"data"=>array($childInfo,$commonDropDowns));



		$this->out($returnArray);



	}







	/**



    * Add Familly Data



    * @return void



    */



	public function kutumb_add(){

		//check basic data

		$kutumb_data =json_decode($_REQUEST['data'],TRUE);//$input['data'];

		$error = '';

		

		$familypersondata = $kutumb_data['members'];

		

 $kutumb_data['userId'] =  $kutumb_data['user_id'];

		if(isset($kutumb_data['userId']) && $kutumb_data['userId'] == '')

			$error .= 'User id is required.';

		if(isset($kutumb_data['family']['familyNo']) && $kutumb_data['family']['familyNo'] == '')

			$error .= 'family no id is required.';
		
		if (!is_numeric($kutumb_data['family']['familyNo']))
        	$error .= 'Please enter valid family no.';				
    	
		if(isset($kutumb_data['family']['caste']) && $kutumb_data['family']['caste'] == '')

			$error .= 'Caste id is required.';

		if(isset($kutumb_data['family']['religion']) && $kutumb_data['family']['religion'] == '')

			$error .= 'Religion id is required.';

		if(isset($kutumb_data['family']['place']) && $kutumb_data['family']['place'] == '')

			$error .= 'Place id is required.';

		if(isset($kutumb_data['family']['placeDetail']) && $kutumb_data['family']['placeDetail'] == '')

			$error .= 'Place detail id is required.';

		if(isset($kutumb_data['family']['minority']) && $kutumb_data['family']['minority'] == '')

			$error .= 'Minority id is required.';

		if(isset($kutumb_data['family']['familyNo']) && $kutumb_data['family']['familyNo'] != '')

		{

			$count=$this->kutumb_model->checkiffamilyrankexists($kutumb_data['family']['familyNo'], $kutumb_data['userId'],'');

			if($count!=0)

			{

				$error.='Family rank '.$kutumb_data['family']['familyNo'].' is already in used.';

			}

			$str='';

			$newarray=array();

			for($i=0;$i<count((array)$familypersondata);$i++)

			{

				$newarray[] = $familypersondata[$i]['familyPersonNo'];

			}

			if(count(array_unique($newarray)) < count($newarray))

			{

				$error.='Family person rank must be unique.';

			}

		}

		if($error!='')

		{

			$returnArray=array();

			$returnArray['status']=0;

			$returnArray['message']=$error;

			$this->out($returnArray);

		}

		else

		{

			//echo trim($this->input->post("data"));exit;

			$data_to_store = array(

				'anganwadi_id' => $kutumb_data['userId'],

				'family_rank' => $kutumb_data['family']['familyNo'],

				'jati_id' => $kutumb_data['family']['caste'],

				'dharm_id' => $kutumb_data['family']['religion'],

				'sthal_id' => $kutumb_data['family']['place'],

				'sthal_value' => $kutumb_data['family']['placeDetail'],

				'laghumati' => $kutumb_data['family']['minority'],

			);

		

            //if the insert has returned true then we show the flash message

			$kutumbid = $this->kutumb_model->store_kutumb($data_to_store);

			if($kutumbid!=0)

			{

				for($i=0;$i<count((array)$familypersondata);$i++)

				{					

					if($familypersondata[$i]['anganwadiServices'] == "1")

					{



						$familypersondata[$i]['purak_aahar']="1";



						$familypersondata[$i]['purv_prathmik_shikshan']="0";



					} 



					else if($familypersondata[$i]['anganwadiServices'] == "2")



					{



						$familypersondata[$i]['purak_aahar']="0";



						$familypersondata[$i]['purv_prathmik_shikshan']="1";



					} 



					else if($familypersondata[$i]['anganwadiServices'] == "1,2")



					{



						$familypersondata[$i]['purak_aahar']="1";



						$familypersondata[$i]['purv_prathmik_shikshan']="1";



					} else{

						$familypersondata[$i]['purak_aahar']="0";



						$familypersondata[$i]['purv_prathmik_shikshan']="0";

					}

					if($familypersondata[$i]['DOD'] != '')

						$familypersondata[$i]['DOD'] = date('Y-m-d',strtotime($familypersondata[$i]['DOD']));

					else

						$familypersondata[$i]['DOD']='';



					if($familypersondata[$i]['migrationOutVillageDate'] != '')

						$familypersondata[$i]['migrationOutVillageDate'] = date('Y-m-d',strtotime($familypersondata[$i]['migrationOutVillageDate']));

					else

						$familypersondata[$i]['migrationOutVillageDate']='';



					if($familypersondata[$i]['villageMigrationDate'] != '')

						$familypersondata[$i]['villageMigrationDate'] = date('Y-m-d',strtotime($familypersondata[$i]['villageMigrationDate']));

					else

						$familypersondata[$i]['villageMigrationDate']='';



					if($familypersondata[$i]['DOB'] != '')

						$familypersondata[$i]['DOB'] = date('Y-m-d',strtotime($familypersondata[$i]['DOB']));

					else

						$familypersondata[$i]['DOB']='';



				



				



					$data_to_store = array(



						'family_id' => $kutumbid,



						'person_rank' => $familypersondata[$i]['familyPersonNo'],



						'uid_aadharnumber' => $familypersondata[$i]['UIDNo'],



						'first_name' => $familypersondata[$i]['firstName'],



						'middle_name' => $familypersondata[$i]['middleName'],



						'last_name' => $familypersondata[$i]['surName'],



						'relation_with_main_person' =>  $familypersondata[$i]['relationWithFamilyHead'],



						'gender' => $familypersondata[$i]['gender'],



						'merridial_status' => $familypersondata[$i]['maritalStatus'],



						'birth_date' => $familypersondata[$i]['DOB'],



						'ageIn_year' => $familypersondata[$i]['aprilAgeYear'],



						'ageIn_month' => $familypersondata[$i]['aprilAgeMonth'],



						'mother_name' => $familypersondata[$i]['motherName'],



						'lakshyank_code' => $familypersondata[$i]['targetCode'],



						'khodkhapan_type' => $familypersondata[$i]['malformationType'],



						'anganwadi_kendra_vistar_rehvasi' => $familypersondata[$i]['centerAreaResident'],



						'gam_shift_date' => $familypersondata[$i]['villageMigrationDate'],



						'gam_out_shift_date' => $familypersondata[$i]['migrationOutVillageDate'],



						'die_date' =>$familypersondata[$i]['DOD'],



						'purak_aahar' => $familypersondata[$i]['purak_aahar'],



						'purv_prathmik_shikshan' => $familypersondata[$i]['purv_prathmik_shikshan']



					);



					$kutumb_person_id = $this->kutumb_model->store_kutumb_person($data_to_store);



				}



                



				



			}



        }



		$returnArray['status']=1;



		$returnArray['message']='Kutumb added successfully.';



		/*



		foreach($kutumb_data as $kutumb){



			$data_to_store = array(



                'anganwadi_id' => $kutumb->aanganvadiid,



				'family_rank' => $kutumb->kutumb_krm_no,



				'jati_id' => $kutumb->jati,



				'dharm_id' => $kutumb->dharm,



                'sthal_id' => $kutumb->sthal,



                'sthal_value' => $kutumb->sthallocation,



                'laghumati' => $kutumb->isLagumati,



            );



		}



*/



		$this->out($returnArray);



    }



	



	/**



    * take attendance



    * @return void



    */



	public function take_attendance(){



		



		//check basic data



		$this->checkBasicInfo("POST");







		$user_id = trim($this->input->post("user_id"));



		$date = trim($this->input->post("date"));



		$childIds = trim($this->input->post("childIds"));



		$presents = trim($this->input->post("isPresents"));



		



		$returnArray = array("status"=>0);



		if($date == ""){



			$returnArray['message']=$this->lang->line('error_date_missing');



		}else if($childIds == ""){



			$returnArray['message']=$this->lang->line('error_child_ids_missing');



		}else if($presents == ""){



			$returnArray['message']=$this->lang->line('error_presents_missing');



		}else if((!isset($_FILES['firstPhoto']) and !isset($_FILES['secondPhoto']))){



			$returnArray['message']=$this->lang->line('error_first_and_second_photo_missing');



		}







		if(isset($returnArray['message'])){



			$this->out($returnArray);



		}



		



		$date = date("Y-m-d",strtotime($date));



		$first_photo = (isset($_FILES['firstPhoto']))?$_FILES['firstPhoto']:"";



		$second_photo = (isset($_FILES['secondPhoto']))?$_FILES['secondPhoto']:"";;







		//check childid is registered



		$childIds = explode(",",$childIds);



		$presents = explode(",",$presents);



		$attendance = array();



		for($i=0;$i<count($childIds);$i++){



			$children_id = (int)trim($childIds[$i]);



			if($children_id > 0){



				$attendance[] = array("user_id"=>$children_id,"present"=>(int)trim($presents[$i]));



			}



		}



		



		$first_photo_name = "";$second_photo_name="";



		//upload images



		if(isset($_FILES['firstPhoto']) && $first_photo["size"] > 0 && $first_photo["error"] == 0){



			$f_file_name = time()."_".$first_photo["name"];



			if(move_uploaded_file($first_photo['tmp_name'],"assets/uploads/".$f_file_name)){



				$first_photo_name = $f_file_name;



			}



		}



		if(isset($_FILES['secondPhoto']) && $second_photo["size"] > 0 && $second_photo["error"] == 0){



			$s_file_name = time()."_".$second_photo["name"];



			if(move_uploaded_file($second_photo['tmp_name'],"assets/uploads/".$s_file_name)){



				$second_photo_name = $s_file_name;



			}



		}



		//save in database



		$attendance_json = json_encode($attendance); 



		$data_to_store = array(



							"attendance"=>$attendance_json,



							"attendance_date"=>$date,



							"aanganvadi_id"=>$user_id,



							"first_photo"=>$first_photo_name,



							"second_photo"=>$second_photo_name,



						);



		$this->attendance_model->store_attendance($data_to_store);



		



		$returnArray['status']=1;



		$returnArray['message']=$this->lang->line('success_attendance_added');



		$this->out($returnArray);



	}	



}



