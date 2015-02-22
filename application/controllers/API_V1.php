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
		$this->load->model('activities_model');
		$this->load->model('common_model');
		$this->load->model('aanganwadi_activities_model');
		$this->lang->load('messages','gujarati');
		$this->load->model('vacine_model');
		$this->load->model('item_model');
        $this->load->model('holidays_model');
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
				$returnArray = array("status"=>1,"user_id"=>$result[0]["id"],"aanganvadi_name"=>$result[0]["aanganvadi_name"]);
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
		
		$response_6_3 = $this->kutumb_model->get_all_kutumb_details("6to3",$user_id);
		
		
		$result = $response_6_3["data"];
		$return_data_6_3 = array();
		foreach($result as $kutumb){
			$cast = $castArray = $this->common_model->get_selected_data('tbl_caste',$kutumb["jati_id"]);
			$handicap = $this->common_model->get_selected_data('tbl_malformationtype',$kutumb["khodkhapan_type"]);
			$gender = $this->common_model->get_selected_data('tbl_gender',$kutumb["gender"]);
			$return_data_6_3[] = array("childServerId"=>$kutumb["family_person_id"],"name"=>$kutumb["first_name"]." ".$kutumb["middle_name"]." ".$kutumb["last_name"],
									"surveyNo"=>$kutumb["family_id"],"age"=>$kutumb["ageIn_year"],
									"gender"=>$gender["name_guj"],"dateOfBirth"=>date("d-m-Y",strtotime($kutumb["birth_date"])),"cast"=>$cast["name_guj"],
									"handicap"=>$handicap["name_guj"],"ageGroup"=>"1");
		}
		
		$response_3_6 = $this->kutumb_model->get_all_kutumb_details("3to6",$user_id);
		$result = $response_3_6["data"];
		$return_data_3_6= array();
		foreach($result as $kutumb){
			$cast = $castArray = $this->common_model->get_selected_data('tbl_caste',$kutumb["jati_id"]);
			$handicap = $this->common_model->get_selected_data('tbl_malformationtype',$kutumb["khodkhapan_type"]);
			$gender = $this->common_model->get_selected_data('tbl_gender',$kutumb["gender"]);
			$return_data_3_6[] = array("childServerId"=>$kutumb["family_person_id"],"name"=>$kutumb["first_name"]." ".$kutumb["middle_name"]." ".$kutumb["last_name"],
									"surveyNo"=>$kutumb["family_id"],"age"=>$kutumb["ageIn_year"],
									"gender"=>$gender["name_guj"],"dateOfBirth"=>date("d-m-Y",strtotime($kutumb["birth_date"])),"cast"=>$cast["name_guj"],
									"handicap"=>$handicap["name_guj"],"ageGroup"=>"2");
		}
			$childInfo = array("FormType"=>1,"childInfo"=>array_merge($return_data_6_3,$return_data_3_6));
		
		$castArray = $this->common_model->get_all_data('tbl_caste');
		$religionArray = $this->common_model->get_all_data('tbl_religion');
		$placeArray = $this->common_model->get_all_data('tbl_place');
		$relationArray = $this->common_model->get_all_data('tbl_relation');
		$genderArray = $this->common_model->get_all_data('tbl_gender');
		$maritalStatusArray = $this->common_model->get_all_data('tbl_maritalstatus');
		$targetCodeArray = $this->common_model->get_all_data('tbl_targetcode');
		$malformationTypeArray = $this->common_model->get_all_data('tbl_malformationtype');
		$agegroups = $this->common_model->get_all_data('tbl_agegroup');
		$activities = $this->activities_model->get_activities('tbl_activities');
		$agegroupArray = array();
		foreach($agegroups as $agegroup){
			$agegroupArray[] = array("ageGroupServerId"=>$agegroup["id"],"ageGroupName"=>$agegroup["name"]);
		}
		$activitiesArray = array();
		foreach($activities as $activity){
			$activitiesArray[] = array("ageGroupServerId"=>$activity["agegroup_id"],"activityServerId"=>$activity["id"],"activityName"=>$activity["name"]);
		}
		
		$commonDropDowns = array("FormType"=>6,"caste"=>$castArray,"religion"=>$religionArray,"place"=>$placeArray,"relationWithFamilyHead"=>$relationArray,"gender"=>$genderArray,"maritalStatus"=>$maritalStatusArray,"targetCode"=>$targetCodeArray,"malformationType"=>$malformationTypeArray,"anganwadiServices"=>anganwadiServicesArray());
		$formtype3 = array("FormType"=>2,"ageGroup"=>$agegroupArray,"activities"=>$activitiesArray);
		
		$vaccines = $this->vacine_model->get_all_vacine_group_by_person($user_id);
		$vaccinearray=array();
		foreach($vaccines as $vaccine){
			if($vaccine['vaccine_type']==0)
				$vaccinetype=2;
			else
				$vaccinetype=1;
				
			if($vaccine['gender']==2)
				$gender='Male';
			else if($vaccine['gender']==3)
				$gender='Female';
            else if($vaccine['gender']==3)
                $gender='Transgender';
			else
				$gender='-';
			if($vaccine['due_date'] && $vaccine['firstName'] != ""){
				if(strtotime($vaccine['due_date']) >= strtotime("2014-11-01")){
					$vaccine['due_date'] = date('d-m-Y',strtotime($vaccine['due_date']));
				}else
					continue;
			}else
					continue;
				
			$vaccinearray[] = array("personType"=>$vaccinetype,"vaccinationServerId"=>$vaccine['member_id'],"vaccinationId"=>$vaccine['vaccine_id'],"firstName"=>$vaccine['firstName'],"middleName"=>$vaccine['middleName'],"lastName"=>$vaccine['lastName'],"gender"=>$gender,"vaccineName"=>$vaccine['vaccineName'],"dueDate"=>$vaccine['due_date']);
		}
		//print_r($vaccinearray);
		$formtype4 = array("FormType"=>4,"vaccinationChildPregnantWomenList"=>$vaccinearray);
        
        $getAllStockItems=$this->item_model->getAllStockItems($user_id);
        $getAllChildren=$this->kutumb_model->getAllChildWithDifferentCategory($user_id);
        $getAllHolidays = $this->holidays_model->getAllholidays();
        $Array=array();
        $Array['FormType']=5;
        $Array['comodity']=$getAllStockItems;
        $Array['vitaranChildInfo']=$getAllChildren;
        $Array['holidayList']=$getAllHolidays;
        
		$returnArray= array("status"=>1,"message"=>$this->lang->line('success_data_downloaded'),"data"=>array($childInfo,$commonDropDowns,$formtype3,$formtype4,$Array));
		$this->out($returnArray);
		//$this->out(array("FormType"=>4,"vaccinationChildPregnantWomenList"=>$vaccinearray));
		
		//$returnArray =eturnArray);
	}
	
	
	
	public function searchfamily()
	{
		$search = $_REQUEST['search'];
		$userid = $_REQUEST['user_id'];
		$error = '';
		if($search == '')
			$error .= 'Please enter search criteria.';
			
		if($userid == '')
			$error .= 'Please enter user id.';
			
		if($error!='')
		{
			$returnArray=array();
			$returnArray['status']=0;
			$returnArray['message']=$error;
			$this->out($returnArray);
		}
		else
		{
			$familydata = $this->kutumb_model->search_kutumb($search,$userid);
			if($familydata)
				$returnArray = array("status"=>1,"message"=>"","data"=>$familydata);
			else
				$returnArray = array("status"=>0,"message"=>"No record found");
			$this->out($returnArray);
		}
		
	}
	public function saveVaccineDetail(){

		$jsondata =json_decode($_REQUEST['data'],TRUE);//$input['data'];

		$error = '';	
		$vaccinationDetails = $jsondata['vaccinationDetails'];
		$mamtaDivasDetail = $jsondata['mamtaDivashDetails'];
		$saveMamtaDivas = array('mamtaDivashPlannedDate'=>date('Y-m-d',strtotime($mamtaDivasDetail['mamtaDivashPlannedDate'])),								'anganwadiKaryakarIsPresent'=>$mamtaDivasDetail['anganwadiKaryakarIsPresent'],'ICDSsupervisorPresent'=>$mamtaDivasDetail['ICDSsupervisorPresent'],								'aashaWorkerPresent'=>$mamtaDivasDetail['aashaWorkerPresent'],'nurseMultipurPoseWorkerPresent'=>$mamtaDivasDetail['nurseMultipurPoseWorkerPresent'],'nurseMultipurposeWorkerName'=>$mamtaDivasDetail['nurseMultipurposeWorkerName'],'samuhCharcha'=>$mamtaDivasDetail['samuhCharcha'],'pregnentWomen'=>$mamtaDivasDetail['pregnentWomen'],'ghatriMata'=>$mamtaDivasDetail['ghatriMata'],'childMother6To12Year'=>$mamtaDivasDetail['childMother6To12Year'],'childMotherAbove1Year'=>$mamtaDivasDetail['childMotherAbove1Year'],'father'=>$mamtaDivasDetail['father'],'grandMother'=>$mamtaDivasDetail['grandMother'],'talkTopicForPosan'=>$mamtaDivasDetail['talkTopicForPosan'],'rubaruPrayog'=>$mamtaDivasDetail['rubaruPrayog'],'talkTopicForRubaruPrayog'=>$mamtaDivasDetail['talkTopicForRubaruPrayog'],'purakAharThrVitaran'=>$mamtaDivasDetail['purakAharThrVitaran'],'childrenVaccinationGiven'=>$mamtaDivasDetail['childrenVaccinationGiven'],'vitaminADoze'=>$mamtaDivasDetail['vitaminADoze'],'pregnantWomenCheckup'=>$mamtaDivasDetail['pregnantWomenCheckup'],'childWeight'=>$mamtaDivasDetail['childWeight'],'vaccination'=>$mamtaDivasDetail['vaccination'],'vitaminA'=>$mamtaDivasDetail['vitaminA'],'pregnantWomanHealthCheckup'=>$mamtaDivasDetail['pregnantWomanHealthCheckup'],'VHSNCName'=>$mamtaDivasDetail['VHSNCName'],'arogyaPosanDate'=>$mamtaDivasDetail['arogyaPosanDate'],'vaccinationNext'=>$mamtaDivasDetail['vaccinationNext'],'vitaminANext'=>$mamtaDivasDetail['vitaminANext'],'pregnantWomanHealthCheckupNext'=>$mamtaDivasDetail['pregnantWomanHealthCheckupNext']);
		$mamtadivas=$this->vacine_model->store_mamtadivas($saveMamtaDivas);
		$polioArray=array(7,9,11);
		$pentavalentArray=array(8,10,12);
		$vitaminArray=array(14,18,19,20,21,22,23,24,25);
		$jsondata['givenDate'] = date('Y-m-d',strtotime($jsondata['givenDate']));
		for($i=0;$i<count($vaccinationDetails);$i++)
		{
			$vaccinedetail = $this->vacine_model->get_vaccine_detail($vaccinationDetails[$i]['vaccinationServerId'],$vaccinationDetails[$i]['vaccinationId']);

			$changedate=$jsondata['givenDate'];
			$updatedata=array('due_date'=>$changedate,"given_date"=>$changedate,"given_status"=>"1","mamta_divas_id"=>$mamtadivas);
			if(($vaccinationDetails[$i]['vaccinationId'] == 15 || $vaccinationDetails[$i]['vaccinationId'] == 16) && strtotime($jsondata['givenDate']) > strtotime($vaccinedetail[0]['due_date']))
			{
				$updatedata=array('due_date'=>$changedate,"given_date"=>$changedate,"given_status"=>"2");
			}
			$this->vacine_model->update_vaccine($vaccinedetail[0]['id'],$updatedata);
			if(in_array($vaccinationDetails[$i]['vaccinationId'],$polioArray) && strtotime($jsondata['givenDate']) > strtotime($vaccinedetail[0]['due_date']))
			{
				$index = array_search ($vaccinationDetails[$i]['vaccinationId'], $polioArray);
				
				for($k=$index+1;$k<count($polioArray);$k++)
				{
					$Nextvaccinedetail = $this->vacine_model->get_vaccine_detail($vaccinationDetails[$i]['vaccinationServerId'],$polioArray[$k]);
					$changedate = date('Y-m-d',strtotime($changedate.' +28 days')); 
					$updatedata=array('due_date'=>$changedate,"given_date"=>$changedate);
					$this->vacine_model->update_vaccine($Nextvaccinedetail[0]['id'],$updatedata);
					//print_r($Nextvaccinedetail);
				}
				//print_r($vaccinedetail);
			}

			if(in_array($vaccinationDetails[$i]['vaccinationId'],$pentavalentArray) && strtotime($jsondata['givenDate']) > strtotime($vaccinedetail[0]['due_date']))
			{
				$index = array_search ($vaccinationDetails[$i]['vaccinationId'], $pentavalentArray);
				
				for($k=$index+1;$k<count($pentavalentArray);$k++)
				{
					$Nextvaccinedetail = $this->vacine_model->get_vaccine_detail($vaccinationDetails[$i]['vaccinationServerId'],$pentavalentArray[$k]);
					$changedate = date('Y-m-d',strtotime($changedate.' +28 days')); 
					$updatedata=array('due_date'=>$changedate,"given_date"=>$changedate);
					$this->vacine_model->update_vaccine($Nextvaccinedetail[0]['id'],$updatedata);
					//print_r($Nextvaccinedetail);
				}
				//print_r($vaccinedetail);
			}
			if(in_array($vaccinationDetails[$i]['vaccinationId'],$vitaminArray) && strtotime($jsondata['givenDate']) > strtotime($vaccinedetail[0]['due_date']))
			{
				if($vaccinationDetails[$i]['vaccinationId'] == 14)
				{
					$Nextvaccinedetail = $this->vacine_model->get_vaccine_detail($vaccinationDetails[$i]['vaccinationServerId'],18);
					$memberdetail = $this->kutumb_model->get_kutumb_person_by_id($vaccinationDetails[$i]['vaccinationServerId']);
					$nonthanidate = $memberdetail[0]['nondhani_date'];
					$nondhani_date_15_month = date('Y-m-d',strtotime($nonthanidate.' +15 month'));
					$vitabmiA_after_4_month = date('Y-m-d',strtotime($jsondata['givenDate'].' +4 month')); 
					if(strtotime($vitabmiA_after_4_month) > strtotime($nondhani_date_15_month))
						$date=$vitabmiA_after_4_month;
					else
						$date=$nondhani_date_15_month;
						
					$updatedata=array('due_date'=>$date,"given_date"=>$date);
					$this->vacine_model->update_vaccine($Nextvaccinedetail[0]['id'],$updatedata);
					$index = 1;
					
					$changedate = $date;
				}
				else
				{
					$index = array_search ($vaccinationDetails[$i]['vaccinationId'], $vitaminArray);
				}
				
				for($k=$index+1;$k<count($vitaminArray);$k++)
				{

					$year = date('Y',strtotime($changedate));
					$month = date('m',strtotime($changedate));
					$day = date('d',strtotime($changedate));
					if($month<2)
					{
						$changedate = $year.'-02-01';
					}
					else if($month < 8)
					{
						$changedate = $year.'-08-01';
					}
					else
					{
						$year++;
						$changedate = $year.'-02-01';
					}
					
					$Nextvaccinedetail = $this->vacine_model->get_vaccine_detail($vaccinationDetails[$i]['vaccinationServerId'],$vitaminArray[$k]);
					
					$updatedata=array('due_date'=>$changedate,"given_date"=>$changedate);
					$this->vacine_model->update_vaccine($Nextvaccinedetail[0]['id'],$updatedata);
					//print_r($Nextvaccinedetail);
				}
				//print_r($vaccinedetail);
			}
			
		}
		$returnArray = array("status"=>1,"message"=>"Data saved successfully.");
			$this->out($returnArray);
		/*echo "<pre>";
		print_r($vaccinationDetails);
		echo "</pre>";*/
	}
	/**
    * Add Familly Data
    * @return void
    */
	public function add_member_api(){
		//check basic data

		$familypersondata =json_decode($_REQUEST['data'],TRUE);//$input['data'];

		$error = '';	

		 //$kutumb_data['userId'] =  $kutumb_data['user_id'];
		if(isset($familypersondata['miscarage_date']) && $familypersondata['miscarage_date'] != '' && isset($familypersondata['lmp_date']) && $familypersondata['lmp_date'] == '')
			$error .= 'LMP date is required.';

		if(isset($familypersondata['nondhani_date']) && $familypersondata['nondhani_date'] == '')
			$error .= 'Nondhani date id is required.';
		
		if(isset($familypersondata['lmp_date']) && $familypersondata['lmp_date'] != '' && strtotime(date('Y-m-d',strtotime($familypersondata['lmp_date']))) > strtotime(date('Y-m-d')))
		{
			$error .= 'LMP date should not greater than today\'s date.';
		}
		if(isset($familypersondata['nondhani_date']) && $familypersondata['nondhani_date'] != '' && strtotime(date('Y-m-d',strtotime($familypersondata['nondhani_date']))) > strtotime(date('Y-m-d')))
		{
			$error .= 'nondhani date should not greater than today\'s date.';
		}
			
		if(isset($familypersondata['miscarage_date']) && $familypersondata['miscarage_date'] != '' && strtotime(date('Y-m-d',strtotime($familypersondata['miscarage_date']))) > strtotime(date('Y-m-d')))
			$error .= 'miscarage date should not greater than today\'s date.';
			
		if(isset($familypersondata['lmp_date']) && $familypersondata['lmp_date'] != '' && $familypersondata['aprilAgeYear'] ==0 && $familypersondata['aprilAgMonth'] < 6)
		{
			$error .= 'Age should not be less than 6 months.';
		}
		if(isset($familypersondata['janm_samay']) && $familypersondata['janm_samay'] != '' && $familypersondata['aprilAgeYear'] ==0 && $familypersondata['aprilAgMonth'] > 6)
		{
			$error .= 'Please add entry as member.';
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
		

			$this->member_add($familypersondata,$familypersondata['kutumb_id'],'add');					
						
     	}
		$returnArray['status']=1;
		$returnArray['message']='Member added successfully.';		
	    $this->out($returnArray);
  	}
	
	/**
    * Add Familly Data
    * @return void
    */
	public function add_sargbha_member_api(){
		//check basic data

		$familypersondata =json_decode($_REQUEST['data'],TRUE);//$input['data'];

		$error = '';	

		 //$kutumb_data['userId'] =  $kutumb_data['user_id'];
		 if(isset($familypersondata['family_id']) && $familypersondata['family_id'] == '')
		 	$error .= 'Family id is required.';
			
		if(isset($familypersondata['family_person_id']) && $familypersondata['family_person_id'] == '')
		 	$error .= 'Family person id is required.';
		 
		if(isset($familypersondata['miscarage_date']) && $familypersondata['miscarage_date'] != '' && isset($familypersondata['lmp_date']) && $familypersondata['lmp_date'] == '')
			$error .= 'LMP date is required.';

		if(isset($familypersondata['nondhani_date']) && $familypersondata['nondhani_date'] == '')
			$error .= 'Nondhani date id is required.';
		
		if(isset($familypersondata['lmp_date']) && $familypersondata['lmp_date'] != '' && strtotime(date('Y-m-d',strtotime($familypersondata['lmp_date']))) > strtotime(date('Y-m-d')))
		{
			$error .= 'LMP date should not greater than today\'s date.';
		}
		if(isset($familypersondata['nondhani_date']) && $familypersondata['nondhani_date'] != '' && strtotime(date('Y-m-d',strtotime($familypersondata['nondhani_date']))) > strtotime(date('Y-m-d')))
		{
			$error .= 'nondhani date should not greater than today\'s date.';
		}
			
		if(isset($familypersondata['miscarage_date']) && $familypersondata['miscarage_date'] != '' && strtotime(date('Y-m-d',strtotime($familypersondata['miscarage_date']))) > strtotime(date('Y-m-d')))
			$error .= 'miscarage date should not greater than today\'s date.';
			
		if(isset($familypersondata['lmp_date']) && $familypersondata['lmp_date'] != '' && $familypersondata['aprilAgeYear'] ==0 && $familypersondata['aprilAgMonth'] < 6)
		{
			$error .= 'Age should not be less than 6 months.';
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
			$this->member_add($familypersondata,$familypersondata['kutumb_id'],'add');											
     	}
		$returnArray['status']=1;
		$returnArray['message']='Member added successfully.';		
	    $this->out($returnArray);
  	}
	
	public function member_add($familypersondata,$kutumbid,$mode='add')
	{
		if($familypersondata['anganwadiServices'] == "1")
		{
			$familypersondata['purak_aahar']="1";
			$familypersondata['purv_prathmik_shikshan']="0";
		} 
		else if($familypersondata['anganwadiServices'] == "2")
		{
			$familypersondata['purak_aahar']="0";
			$familypersondata['purv_prathmik_shikshan']="1";
		} 
		else if($familypersondata['anganwadiServices'] == "1,2")
		{
			$familypersondata['purak_aahar']="1";
			$familypersondata['purv_prathmik_shikshan']="1";
		} else{
			$familypersondata['purak_aahar']="0";
			$familypersondata['purv_prathmik_shikshan']="0";
		}
		
		if($familypersondata['migrationOutVillageDate'] != '')
			$familypersondata['migrationOutVillageDate'] = date('Y-m-d',strtotime($familypersondata['migrationOutVillageDate']));
		else
			$familypersondata['migrationOutVillageDate']=null;

		if($familypersondata['villageMigrationDate'] != '')
			$familypersondata['villageMigrationDate'] = date('Y-m-d',strtotime($familypersondata['villageMigrationDate']));
		else
			$familypersondata['villageMigrationDate']=null;

		if($familypersondata['DOB'] != '')
			$familypersondata['DOB'] = date('Y-m-d',strtotime($familypersondata['DOB']));
		else
			$familypersondata['DOB']=null;

		if($familypersondata['centerAreaResident'] == 'હા')
		{
			$familypersondata['centerAreaResident']='1';
		}
		else
		{
			$familypersondata['centerAreaResident'] = '0';
		}
		
		if($familypersondata['lmp_date'] != '')
			$familypersondata['lmp_date'] = date('Y-m-d',strtotime($familypersondata['lmp_date']));
		else
			$familypersondata['lmp_date']=null;
			
		
		if($familypersondata['miscarage_date'] != '')
			$familypersondata['miscarage_date'] = date('Y-m-d',strtotime($familypersondata['miscarage_date']));
		else
			$familypersondata['miscarage_date']=null;
			
		if($familypersondata['nondhani_date'] != '')
			$familypersondata['nondhani_date'] = date('Y-m-d',strtotime($familypersondata['nondhani_date']));
		else
			$familypersondata['nondhani_date']=null;
		
		if($familypersondata['DOD'] != '')
			$familypersondata['DOD'] = date('Y-m-d',strtotime($familypersondata['DOD']));
		else
			$familypersondata['DOD']=null;
			
		$familypersondata['last_updated_date'] = date('Y-m-d H:i:s');
        
        
        $childcategory=0;
        
        $birthday = new DateTime($familypersondata['DOB']);
        $diff = $birthday->diff(new DateTime());
        $month = $diff->format('%m') + 12 * $diff->format('%y');
        
        if($month <= 72)
        {
            if($familypersondata['malformationType'] == 1 || $familypersondata['malformationType'] == 2)
            {
                $childcategory = '1';
            }
            else
            {
                $childcategory = '2';
            }
        }
        if($familypersondata['lmp_date']!= "" && $familypersondata['lmp_date']!= "0000-00-00" )
        {
            $childcategory = '4';
        }
        if($familypersondata['targetCode'] == 6)
            $childcategory = '6';
        if($familypersondata['targetCode'] == 4)
            $childcategory = '5';
		
			
		$data_to_store = array(
			'family_id' => $kutumbid,
			'person_rank' => $familypersondata['familyPersonNo'],
			'uid_aadharnumber' => $familypersondata['UIDNo'],
			'first_name' => $familypersondata['firstName'],
			'middle_name' => $familypersondata['middleName'],
			'last_name' => $familypersondata['surName'],
			'relation_with_main_person' =>  $familypersondata['relationWithFamilyHead'],
			'gender' => $familypersondata['gender'],
			'merridial_status' => $familypersondata['maritalStatus'],
			'birth_date' => $familypersondata['DOB'],
			'ageIn_year' => $familypersondata['aprilAgeYear'],
			'ageIn_month' => $familypersondata['aprilAgeMonth'],
			'mother_name' => $familypersondata['motherName'],
			'lakshyank_code' => $familypersondata['targetCode'],
			'khodkhapan_type' => $familypersondata['malformationType'],
			'anganwadi_kendra_vistar_rehvasi' => $familypersondata['centerAreaResident'],
			'gam_shift_date' => $familypersondata['villageMigrationDate'],
			'gam_out_shift_date' => $familypersondata['migrationOutVillageDate'],
			'die_date' =>$familypersondata['DOD'],
			'purak_aahar' => $familypersondata['purak_aahar'],
			'purv_prathmik_shikshan' => $familypersondata['purv_prathmik_shikshan'],
			'lmp_date' => $familypersondata['lmp_date'],
			'miscarage_date' => $familypersondata['miscarage_date'],
			'nondhani_date' => $familypersondata['nondhani_date'],
			'last_updated_date' => $familypersondata['last_updated_date'],
			'janm_samay' => $familypersondata['janm_samay'],
			'janm_sthal' => $familypersondata['janm_sthal'],
			'janm_samaye_thayel_vajan_kilogram' => $familypersondata['janm_samaye_thayel_vajan_kilogram'],
			'janm_amaye_thayel_vajan_grams' => $familypersondata['janm_amaye_thayel_vajan_grams'],
			'dilevery_type' => $familypersondata['dilevery_type'],
            'childCategory' => $childcategory,
		);
		if($mode=='add')
		{
			$kutumb_person_id = $this->kutumb_model->store_kutumb_person($data_to_store);
			$kutumbdata = $this->kutumb_model->get_kutumb_by_id($kutumbid);
			
			$from = new DateTime($familypersondata['DOB']);
			$to   = new DateTime('today');
			if($from->diff($to)->y <6)
			{
				$gender='';
				if($familypersondata['gender']==2)
					$gender='M';
				if($familypersondata['gender']==3)
					$gender='F';
				if($familypersondata['gender']==4)
					$gender='T';
	
				$data_to_send = "id=".$kutumb_person_id."&anganwadies_id=".$kutumbdata[0]['anganwadi_id']."&guj_first_name=".$familypersondata['firstName']."&first_name=".$familypersondata['firstName']."&guj_middle_name=".$familypersondata['middleName']."&middle_name=".$familypersondata['middleName']."&guj_last_name=".$familypersondata['surName']."&last_name=".$familypersondata['surName']."&sex=".$gender."&date_of_birth=".$familypersondata['DOB']."&parent_mobile=0&vaccinated=&vaccinated_date=&photo=&status=1";
				$this->common_model->save_curl_data($data_to_send,'addchildren.json');
			}
			if($familypersondata['aprilAgeYear'] == 0 && $familypersondata['aprilAgeMonth'] < 6 && $familypersondata['janm_samay'] != '')
			{
				$this->savechildvaccine($familypersondata,$kutumb_person_id);
			}
			if($familypersondata['lmp_date'] != '')
			{
				$this->savevacine($familypersondata,$kutumb_person_id);
				$data_to_store = array(
					'family_id' => $kutumbid,
					'family_person_id' => $kutumb_person_id,
					'lmp_date' => $familypersondata['lmp_date'],
					'miscarage_date' => $familypersondata['miscarage_date'],
					'nondhani_date' => $familypersondata['nondhani_date'],
					'last_updated_date' => $familypersondata['last_updated_date'],					
				);
				$kutumb_sagrbha_person_id = $this->kutumb_model->store_sagrbha_kutumb_person($data_to_store);					
			}
		}
		else
		{
			$kutumbdata = $this->kutumb_model->get_kutumb_by_id($kutumbid);
			$familyMemberInfo = $this->kutumb_model->get_kutumb_person_by_id($familypersondata['person_id']);
			$lastLMPdate = $familyMemberInfo[0]['lmp_date'];
//			print_r($familyMemberInfo);exit;
			$kutumb_person_id = $this->kutumb_model->update_kutumb_member($familypersondata['person_id'],$data_to_store);
			$from = new DateTime($familypersondata['DOB']);
			$to   = new DateTime('today');
			if($from->diff($to)->y <6)
			{
			
				$gender='';
				if($familypersondata['gender']==2)
					$gender='M';
				if($familypersondata['gender']==3)
					$gender='F';
				if($familypersondata['gender']==4)
					$gender='T';
	
				$data_to_send = "id=".$familypersondata['person_id']."&anganwadies_id=".$kutumbdata[0]['anganwadi_id']."&guj_first_name=".$familypersondata['firstName']."&first_name=".$familypersondata['firstName']."&guj_middle_name=".$familypersondata['middleName']."&middle_name=".$familypersondata['middleName']."&guj_last_name=".$familypersondata['surName']."&last_name=".$familypersondata['surName']."&sex=".$gender."&date_of_birth=".$familypersondata['DOB']."&parent_mobile=0&vaccinated=&vaccinated_date=&photo=&status=1";
				$this->common_model->save_curl_data($data_to_send,'editchildren.json');
			}
			if($lastLMPdate != $familypersondata['lmp_date'] && $familypersondata['lmp_date'] != '')
			{
				$this->savevacine($familypersondata,$familypersondata['person_id']);
				$data_to_store = array(
					'family_id' => $kutumbid,
					'family_person_id' => $familypersondata['person_id'],
					'lmp_date' => $familypersondata['lmp_date'],
					'miscarage_date' => $familypersondata['miscarage_date'],
					'nondhani_date' => $familypersondata['nondhani_date'],
					'last_updated_date' => $familypersondata['last_updated_date'],					
				);
				$kutumb_sagrbha_person_id = $this->kutumb_model->store_sagrbha_kutumb_person($data_to_store);
			}
		}
	}
	public function kutumb_edit(){
	$this->kutumb_add('edit');
	}
	/**
    * Add Familly Data
    * @return void
    */
	public function kutumb_add($mode='add'){
		//check basic data
//echo $_REQUEST['data'];
		$kutumb_data =json_decode($_REQUEST['data'],TRUE);//$input['data'];
	//			print_r($kutumb_data);exit;
		//echo "<pre>";print_r($kutumb_data);
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
			
		if(isset($kutumb_data['family']['nondhani_date']) && $kutumb_data['family']['nondhani_date'] == '')
			$error .= 'nondhani date id is required.';
			
		if(isset($kutumb_data['family']['nondhani_date']) && $kutumb_data['family']['nondhani_date'] != '' && strtotime(date('Y-m-d',strtotime($kutumb_data['family']['nondhani_date']))) > strtotime(date('Y-m-d')))
			$error .= 'nondhani date should not greater than today\'s date.';

		if(isset($kutumb_data['family']['familyNo']) && $kutumb_data['family']['familyNo'] != '')
		{
			if($mode=='add')
				$count=$this->kutumb_model->checkiffamilyrankexists($kutumb_data['family']['familyNo'], $kutumb_data['userId'],'');
			else
				$count=$this->kutumb_model->checkiffamilyrankexists($kutumb_data['family']['familyNo'], $kutumb_data['userId'],$kutumb_data['kutumb_id']);
				
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
			if($kutumb_data['family']['minority'] == 'હા')
			{
				$kutumb_data['family']['minority']='1';
			}
			else
			{
				$kutumb_data['family']['minority'] = '2';
			}
			//echo trim($this->input->post("data"));exit;
			$data_to_store = array(
				'anganwadi_id' => $kutumb_data['userId'],
				'family_rank' => $kutumb_data['family']['familyNo'],
				'jati_id' => $kutumb_data['family']['caste'],
				'dharm_id' => $kutumb_data['family']['religion'],
				'sthal_id' => $kutumb_data['family']['place'],
				'sthal_value' => $kutumb_data['family']['placeDetail'],
				'laghumati' => $kutumb_data['family']['minority'],
				'nondhani_date' => date('Y-m-d',strtotime($kutumb_data['family']['nondhani_date'])),
				'last_updated_date' => date('Y-m-d H:i:s'),
			);
            //if the insert has returned true then we show the flash message
			if($mode=='add')
				$kutumbid = $this->kutumb_model->store_kutumb($data_to_store);
			else
			{
				$this->kutumb_model->update_kutumb($kutumb_data['kutumb_id'], $data_to_store);
				$kutumbid = $kutumb_data['kutumb_id'];
			}
			if($kutumbid!=0)
			{
				for($i=0;$i<count((array)$familypersondata);$i++)
				{
					if(!isset($familypersondata[$i]['type']) || (isset($familypersondata[$i]['type']) && $familypersondata[$i]['type']==1))					
						$this->member_add($familypersondata[$i],$kutumbid,'add');					
					else if(isset($familypersondata[$i]['type']) && $familypersondata[$i]['type']==2)					
						$this->member_add($familypersondata[$i],$kutumbid,'edit');					
				}
			}
     	}
		$returnArray['status']=1;
		if($mode=="add")
			$returnArray['message']='Kutumb added successfully.';		
		else
			$returnArray['message']='Kutumb updated successfully.';		
	    $this->out($returnArray);
  	}
	public function savechildvaccine($memberdata,$kutumb_person_id)
	{
		$nondhani_date = $memberdata['nondhani_date'];
		$nondhani_date_round1 = date('Y-m-d',strtotime($nondhani_date.' +45 days')); // for polio 1, pentavalent 1
		$nondhani_date_round2 = date('Y-m-d',strtotime($nondhani_date_round1.' +28 days')); // for polio 2,Pentavalent - 2
		$nondhani_date_round3 = date('Y-m-d',strtotime($nondhani_date_round2.' +28 days')); // for polio 3,Pentavalent - 3
		$nondhani_date_270_days = date('Y-m-d',strtotime($nondhani_date.' +270 days')); // for Ori - First Dose,Vitamin A - First Dose
		$nondhani_date_15_month = date('Y-m-d',strtotime($nondhani_date.' +15 month')); // for Ori -Second Dose,Triguni Booster,Polio Booster
		$vitabmiA_after_4_month = date('Y-m-d',strtotime($nondhani_date_270_days.' +4 month')); 
		$nondhani_date_5_year = date('Y-m-d',strtotime($nondhani_date.' +5 year')); // for Triguni Bijo Booster
		//BCG
		$bcgVacine = $this->vacine_model->get_vacine_id_by_name('B.C.G.');	
		$bcgvacine_data = array('vaccine_id' => $bcgVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date,'given_date' => $nondhani_date,'given_status' => '1','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($bcgvacine_data);
		
		//Hep B - 0
		$hepbVacine = $this->vacine_model->get_vacine_id_by_name('Hep B - 0');
		$hepvacine_data = array('vaccine_id' => $hepbVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date,'given_date' => $nondhani_date,'given_status' => '1','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($hepvacine_data);
		
		//Polio - 0
		$polio0bVacine = $this->vacine_model->get_vacine_id_by_name('Polio - 0');
		$polio0vacine_data = array('vaccine_id' => $polio0bVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date,'given_date' => $nondhani_date,'given_status' => '1','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($polio0vacine_data);
		
		//Polio - 1
		$polio1bVacine = $this->vacine_model->get_vacine_id_by_name('Polio - 1');
		$polio1vacine_data = array('vaccine_id' => $polio1bVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round1,'given_date' => $nondhani_date_round1,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($polio1vacine_data);
		
		//Pentavalent - 1
		$pentavalent1bVacine = $this->vacine_model->get_vacine_id_by_name('Pentavalent - 1');
		$pentavalent1vacine_data = array('vaccine_id' => $pentavalent1bVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round1,'given_date' => $nondhani_date_round1,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($pentavalent1vacine_data);
		
		//Polio - 2
		$polio2Vacine = $this->vacine_model->get_vacine_id_by_name('Polio - 2');
		$polio2vacine_data = array('vaccine_id' => $polio2Vacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round2,'given_date' => $nondhani_date_round2,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($polio2vacine_data);
		
		//Pentavalent - 2
		$pentavalent2Vacine = $this->vacine_model->get_vacine_id_by_name('Pentavalent - 2');
		$pentavalent2vacine_data = array('vaccine_id' => $pentavalent2Vacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round2,'given_date' => $nondhani_date_round2,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($pentavalent2vacine_data);
		
		//Polio - 3
		$polio3Vacine = $this->vacine_model->get_vacine_id_by_name('Polio - 3');
		$polio3vacine_data = array('vaccine_id' => $polio3Vacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round3,'given_date' => $nondhani_date_round3,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($polio3vacine_data);
		
		//Pentavalent - 3
		$pentavalent3Vacine = $this->vacine_model->get_vacine_id_by_name('Pentavalent - 3');
		$pentavalent3vacine_data = array('vaccine_id' => $pentavalent3Vacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round3,'given_date' => $nondhani_date_round3,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($pentavalent3vacine_data);
		
		//Ori - First Dose
		$oriFirstVacine = $this->vacine_model->get_vacine_id_by_name('Ori - First Dose');
		$oriFirstvacine_data = array('vaccine_id' => $oriFirstVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_270_days,'given_date' => $nondhani_date_270_days,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($oriFirstvacine_data);
		
		//Vitamin A - First Dose
		$vitaminAFirstVacine = $this->vacine_model->get_vacine_id_by_name('Vitamin A - First Dose');
		$vitaminAFirstvacine_data = array('vaccine_id' => $vitaminAFirstVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_270_days,'given_date' => $nondhani_date_270_days,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($vitaminAFirstvacine_data);
		
		//Ori -Second Dose
		$oriSecondVacine = $this->vacine_model->get_vacine_id_by_name('Ori -Second Dose');
		$oriSecondvacine_data = array('vaccine_id' => $oriSecondVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_15_month,'given_date' => $nondhani_date_15_month,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($oriSecondvacine_data);
		
		//Triguni Booster
		$triguniboosterVacine = $this->vacine_model->get_vacine_id_by_name('Triguni Booster');
		$triguniboosterVacine_data = array('vaccine_id' => $triguniboosterVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_15_month,'given_date' => $nondhani_date_15_month,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($triguniboosterVacine_data);
		
		//Polio Booster
		$polioboosterVacine = $this->vacine_model->get_vacine_id_by_name('Polio Booster');
		$polioboosterVacine_data = array('vaccine_id' => $polioboosterVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_15_month,'given_date' => $nondhani_date_15_month,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($polioboosterVacine_data);
		
		//Vitamin A - Second Dose
		$polioboosterVacine = $this->vacine_model->get_vacine_id_by_name('Vitamin A - Second Dose');
		if(strtotime($vitabmiA_after_4_month) > strtotime($nondhani_date_15_month))
			$date=$vitabmiA_after_4_month;
		else
			$date=$nondhani_date_15_month;
			
		$polioboosterVacine_data = array('vaccine_id' => $polioboosterVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $date,'given_date' => $date,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($polioboosterVacine_data);
		
		$vacinearray=array(19,20,21,22,23,24,25);
		$vitabmiA_2_after_4_month = date('Y-m-d',strtotime($date.' +4 month')); 
		$after4month = $vitabmiA_2_after_4_month;
		for($i=0;$i<count($vacinearray);$i++)
		{
		//echo $after4month."<br>";
			//Vitamin A - Dose
			$year = date('Y',strtotime($after4month));
			$month = date('m',strtotime($after4month));
			$day = date('d',strtotime($after4month));
			if($month<2)
			{
				$after4month = $year.'-02-01';
			}
			else if($month < 8)
			{
				$after4month = $year.'-08-01';
			}
			else
			{
				$year++;
				$after4month = $year.'-02-01';
			}
						
			$vacine_data = array('vaccine_id' => $vacinearray[$i],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $after4month,'given_date' => $after4month,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
			$this->vacine_model->store_vacine($vacine_data);
		}
		
		//Triguni Bijo Booster
		$triguniBijoBoosterVacine = $this->vacine_model->get_vacine_id_by_name('Triguni Bijo Booster');
		$triguniBijoBoosterVacine_data = array('vaccine_id' => $triguniBijoBoosterVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_5_year,'given_date' => $nondhani_date_5_year,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
		$this->vacine_model->store_vacine($triguniBijoBoosterVacine_data);
		
	}
	public function savevacine($memberdata,$kutumb_person_id)
	{
		//check if lmp date before start
		$total_user_entry = $this->kutumb_model->count_sagrbha_entry($kutumb_person_id);
		if($total_user_entry == 0)
		{
			$get_vacine_data = $this->vacine_model->get_vacine_id_by_name('Dhanur Ni Rasi-1');
			//print_r($get_vacine_data);
			$vacine_data = array(
							'vaccine_id' => $get_vacine_data[0]['id'],
							'member_id' => $kutumb_person_id,
							'vaccine_type' => '0',
							'due_date' => $memberdata['nondhani_date'],
							'given_date' => $memberdata['nondhani_date'],
							'given_status' => '1',					
							'created_at' => date('Y-m-d H:i:s'),					
						);
			$this->vacine_model->store_vacine($vacine_data);
			
			$get_vacine_data = $this->vacine_model->get_vacine_id_by_name('Dhanur Ni Rasi-2');
			$vacine_data = array(
							'vaccine_id' => $get_vacine_data[0]['id'],
							'member_id' => $kutumb_person_id,
							'vaccine_type' => '0',
							'due_date' => date('Y-m-d H:i:s',strtotime($memberdata['nondhani_date'].'+28 days')),
							'given_date' => date('Y-m-d H:i:s',strtotime($memberdata['nondhani_date'].'+28 days')),
							'given_status' => '0',					
							'created_at' => date('Y-m-d H:i:s'),					
						);
			$this->vacine_model->store_vacine($vacine_data);
		}
		else
		{
			$get_vacine_data = $this->vacine_model->get_vacine_id_by_name('Dhanur Ni Rasi-Booster (in lieu of 1 &2)');
			$vacine_data = array(
							'vaccine_id' => $get_vacine_data[0]['id'],
							'member_id' => $kutumb_person_id,
							'vaccine_type' => '0',
							'due_date' => $memberdata['nondhani_date'],
							'given_date' => $memberdata['nondhani_date'],
							'given_status' => '1',					
							'created_at' => date('Y-m-d H:i:s'),					
						);
			$this->vacine_model->store_vacine($vacine_data);
		}
		//check if lmp date before end
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
                if((int)trim($presents[$i]) == 1)
                {
                    $memberDetail = $this->kutumb_model->get_kutumb_person_by_id($children_id);
                    $todaysday = date('w');
                    
                    $year1 = date('Y');
                    $year2 = date('Y', strtotime($memberDetail[0]['birth_date']));
                    
                    $month1 = date('m');
                    $month2 = date('m', strtotime($memberDetail[0]['birth_date']));
                    //echo (($year2 - $year1) * 12);
                    $diff = (abs($year2 - $year1) * 12) + abs($month2 - $month1);
                    if($diff >= 6 && $diff < 36)
                    {
                        //wheat for breakfast
                        $itemdetail=$this->item_model->get_item_by_name('Wheat');
                        //print_r($itemdetail);
                        $stock = 10;
                        if($this->item_model->checkIfItemExists($itemdetail[0]['id'],$user_id,$stock))
                        {
                            $data_to_store = array('item_id' => $itemdetail[0]['id'],'aanganwadi_id' => $user_id,'stock' => $stock,'type' => '1','member_id' => $children_id,'created_date' => date('Y-m-d H:i:s'),'particulars_id'=>1);
                            $id=$this->item_model->store_item_stock_detail($data_to_store);
                            $this->saveTotalStock($itemdetail[0]['id'],$user_id);
                        }
                    }
                    else if($diff >= 36 && $diff < 72)
                    {
                        $WheetItemdetail=$this->item_model->get_item_by_name('Wheat');
                        $RiceItemdetail=$this->item_model->get_item_by_name('Rice');
                        $OilItemdetail=$this->item_model->get_item_by_name('Oil');
                        
                        if(in_array($todaysday,array(1,2,3,4,6)))
                        {
                            //wheat for breakfast
                            $stock = 30;
                            if($this->item_model->checkIfItemExists($WheetItemdetail[0]['id'],$user_id,$stock))
                            {
                                $data_to_store = array('item_id' => $WheetItemdetail[0]['id'],'aanganwadi_id' => $user_id,'stock' => $stock,'type' => '1','member_id' => $children_id,'created_date' => date('Y-m-d H:i:s'),'particulars_id'=>1);
                                $id=$this->item_model->store_item_stock_detail($data_to_store);
                                $this->saveTotalStock($WheetItemdetail[0]['id'],$user_id);
                            }
                        }
                        if(in_array($todaysday,array(5)))
                        {
                            //Rice for breakfast
                            $stock = 30;
                            if($this->item_model->checkIfItemExists($RiceItemdetail[0]['id'],$user_id,$stock))
                            {
                                $data_to_store = array('item_id' => $RiceItemdetail[0]['id'],'aanganwadi_id' => $user_id,'stock' => $stock,'type' => '1','member_id' => $children_id,'created_date' => date('Y-m-d H:i:s'),'particulars_id'=>2);
                                $id=$this->item_model->store_item_stock_detail($data_to_store);
                                $this->saveTotalStock($RiceItemdetail[0]['id'],$user_id);
                            }
                        }
                        if(in_array($todaysday,array(1,4,5)))
                        {
                            //Wheat for lunch
                            $stock = 50;
                            if($this->item_model->checkIfItemExists($WheetItemdetail[0]['id'],$user_id,$stock))
                            {
                                $data_to_store = array('item_id' => $WheetItemdetail[0]['id'],'aanganwadi_id' => $user_id,'stock' => $stock,'type' => '1','member_id' => $children_id,'created_date' => date('Y-m-d H:i:s'),'particulars_id'=>3);
                                $id=$this->item_model->store_item_stock_detail($data_to_store);
                                $this->saveTotalStock($WheetItemdetail[0]['id'],$user_id);
                            }
                        }
                        if(in_array($todaysday,array(3,4,6)))
                        {
                            //Rice for lunch
                            $stock = 50;
                            if($this->item_model->checkIfItemExists($RiceItemdetail[0]['id'],$user_id,$stock))
                            {
                                $data_to_store = array('item_id' => $RiceItemdetail[0]['id'],'aanganwadi_id' => $user_id,'stock' => $stock,'type' => '1','member_id' => $children_id,'created_date' => date('Y-m-d H:i:s'),'particulars_id'=>3);
                                $id=$this->item_model->store_item_stock_detail($data_to_store);
                                $this->saveTotalStock($RiceItemdetail[0]['id'],$user_id);
                            }
                        }
                        if(!in_array($todaysday,array(0)))
                        {
                            //Oil for lunch
                            $stock = 8;
                            if($this->item_model->checkIfItemExists($OilItemdetail[0]['id'],$user_id,$stock))
                            {
                                $data_to_store = array('item_id' => $OilItemdetail[0]['id'],'aanganwadi_id' => $user_id,'stock' => $stock,'type' => '1','member_id' => $children_id,'created_date' => date('Y-m-d H:i:s'),'particulars_id'=>3);
                                $id=$this->item_model->store_item_stock_detail($data_to_store);
                                $this->saveTotalStock($OilItemdetail[0]['id'],$user_id);
                            }
                        }
                    }
                    
                    
                }
            
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
		$attedanceid = $this->attendance_model->store_attendance($data_to_store);
		for($i=0;$i<count($attendance);$i++)
		{
			$checkIfMemberId=$this->kutumb_model->get_kutumb_person_by_id($attendance[$i]['user_id']);
			if(!empty($checkIfMemberId))
			{
				$datatostore=array('attendance_id' => $attedanceid, 'aanganwadi_id' => $user_id, 'member_id' => $attendance[$i]['user_id'], 'is_present' => $attendance[$i]['present'], 'attendance_date' => $date);
				
				$this->common_model->store_data($datatostore,'attendance_detail');
			}
		}
		$returnArray['status']=1;
		$returnArray['message']=$this->lang->line('success_attendance_added');
		$this->out($returnArray);
	}
    public function saveTotalStock($item_id,$user_id)
    {
        $get_total_stock = $this->item_model->get_total_stock($item_id,$user_id);
        $isEntryExists = $this->item_model->isStockEntryExists($item_id,$user_id);
        
        if(!$isEntryExists)
        {
            $data_to_store = array('item_id' => $item_id,'aanganwadi_id' => $user_id,'total_stock' => $get_total_stock,'updated_date' => date('Y-m-d H:i:s'));
            $item_id=$this->item_model->store_item_stock($data_to_store);
        }
        else
        {
            $data_to_store = array('total_stock' => $get_total_stock,'updated_date' => date('Y-m-d H:i:s'));
            $item_id=$this->item_model->update_item_stock($isEntryExists,$data_to_store);
        }
    }
    
	public function saveAanganwadiServices()
	{
		$user_id = $_REQUEST['userId'];
		$activities_id = $_REQUEST['selectedActivities'];
		$agegroup_id = $_REQUEST['ageGroup'];
		$date = $_REQUEST['date'];
		
		$error = '';
		if($user_id == '')
			$error .= 'Aanganwadi id is required.';
			
		if($activities_id == '')
			$error .= 'Activity id is required';
			
		if($date == '')
			$error .= 'Date id is required';
			
		if($error!='')
		{
			$returnArray=array();
			$returnArray['status']=0;
			$returnArray['message']=$error;
			$this->out($returnArray);
		}
		else
		{
			$date=date('Y-m-d',strtotime($date));
			//check if aanganwadi entry exists
			$aanganwadi_activities = $this->aanganwadi_activities_model->get_activities_by_aanganwadi_id($user_id,$agegroup_id);
			
			if(empty($aanganwadi_activities))
			{
				$data_to_store = array(
							"aanganvadi_id"=>$user_id,
							"activity_id"=>$activities_id,
							"agegroup_id"=>$agegroup_id,
							"date"=>$date,
							"updated_at"=>date('Y-m-d H:i:s')
							);
				$this->aanganwadi_activities_model->store_aanganwadi_activities($data_to_store);
			}
			else
			{
				$data_to_store = array(
							"activity_id"=>$activities_id,
							"date"=>$date,
							"updated_at"=>date('Y-m-d H:i:s')
							);
				$this->aanganwadi_activities_model->update_aanganwadi_activities($aanganwadi_activities[0]['id'],$data_to_store);
				//print_r($aanganwadi_activities);
				
			}
			$returnArray=array();
			$returnArray['status']=1;
			$returnArray['message']='Aanganwadi services saved successfully.';
			$this->out($returnArray);
			
		}
	}
	public function getCurrentStockOfAanganwadi()
	{
		$user_id=$_REQUEST['user_id'];
		$getAllStockItems=$this->item_model->getAllStockItems($user_id);
        $getAllChildren=$this->kutumb_model->getAllChildWithDifferentCategory($user_id);
        $getAllHolidays = $this->holidays_model->getAllholidays();
		$returnArray=array();
		
		$returnArray['comodity']=$getAllStockItems;
        $returnArray['vitaranChildInfo']=$getAllChildren;
        $returnArray['holidayList']=$getAllHolidays;
        $returnArray['status']=1;
		$returnArray['message']='success';
		echo $this->out($returnArray);
	}
	public function SaveNewStock()
	{
		$user_id=$_REQUEST['user_id'];
		$item_id=$_REQUEST['item_id'];
		$kg=$_REQUEST['kg'];
		$gm=$_REQUEST['gm'];
		$stock = ($kg*1000)+$gm;
		$data_to_store = array(
			'item_id' => $item_id,
			'aanganwadi_id' => $user_id,
			'stock' => $stock,
			'type' => '0',
			'created_date' => date('Y-m-d H:i:s')
		);
		$id=$this->item_model->store_item_stock_detail($data_to_store);
		$get_total_stock = $this->item_model->get_total_stock($item_id,$user_id);
				
		$isEntryExists = $this->item_model->isStockEntryExists($item_id,$user_id);
				//print_r($isEntryExists);
		if(!$isEntryExists)
		{
			$data_to_store = array(
				'item_id' => $item_id,
				'aanganwadi_id' => $user_id,
				'total_stock' => $get_total_stock,
				'updated_date' => date('Y-m-d H:i:s')
			);
			$item_id=$this->item_model->store_item_stock($data_to_store);
		}
		else
		{
			$data_to_store = array(
				'total_stock' => $get_total_stock,
				'updated_date' => date('Y-m-d H:i:s')
			);
			$item_id=$this->item_model->update_item_stock($isEntryExists,$data_to_store);
		}
		$returnArray=array();
		$returnArray['status']=1;
		$returnArray['message']='success';
		echo $this->out($returnArray);
	}
	public function manageStock()
	{
		$jsondata =json_decode($_REQUEST['data'],TRUE);
		//print_r($jsondata);exit;
        $user_id = $jsondata['user_id'];
        if(array_key_exists('NewStockCommodityDetail',$jsondata['NewStockDetails']))
        {
            if(count($jsondata['NewStockDetails']['NewStockCommodityDetail']) > 0)
            {
                
                $refNo = $jsondata['NewStockDetails']['NewStockRefNumber'];
                $date = date('Y-m-d',strtotime($jsondata['NewStockDetails']['NewStockAddDate']));
                
                for($i=0;$i<count($jsondata['NewStockDetails']['NewStockCommodityDetail']);$i++)
                {
                    
                    $item_id = $jsondata['NewStockDetails']['NewStockCommodityDetail'][$i]['NewStockCommodityId'];
                    $kg = $jsondata['NewStockDetails']['NewStockCommodityDetail'][$i]['NewStockCommodityKG'];
                    $gm = $jsondata['NewStockDetails']['NewStockCommodityDetail'][$i]['NewStockCommodityGram'];
                    
                    $stock = ($kg*1000)+$gm;
                    $data_to_store = array(
                                           'item_id' => $item_id,
                                           'aanganwadi_id' => $user_id,
                                           'stock' => $stock,
                                           'type' => '0',
                                           'ref_no' => $refNo,
                                           'created_date' => date('Y-m-d H:i:s')
                                           );
                    $id=$this->item_model->store_item_stock_detail($data_to_store);
                    $get_total_stock = $this->item_model->get_total_stock($item_id,$user_id);
                    
                    $isEntryExists = $this->item_model->isStockEntryExists($item_id,$user_id);
                    //print_r($isEntryExists);
                    if(!$isEntryExists)
                    {
                        $data_to_store = array(
                                               'item_id' => $item_id,
                                               'aanganwadi_id' => $user_id,
                                               'total_stock' => $get_total_stock,
                                               'updated_date' => date('Y-m-d H:i:s')
                                               );
                        $item_id=$this->item_model->store_item_stock($data_to_store);
                    }
                    else
                    {
                        $data_to_store = array(
                                               'total_stock' => $get_total_stock,
                                               'updated_date' => date('Y-m-d H:i:s')
                                               );
                        $item_id=$this->item_model->update_item_stock($isEntryExists,$data_to_store);
                    }
                }
            }
        }
        //deduct stock start
        if(count($jsondata['VitaranDetails']) > 0)
        {
            for($i=0;$i<count($jsondata['VitaranDetails']);$i++)
            {
                $AllMembersArray = explode(',',$jsondata['VitaranDetails'][$i]['VitaranChildServerIds']);
                $givenArray = explode(',',$jsondata['VitaranDetails'][$i]['VitaranIsGivens']);
                $date = date('Y-m-d',strtotime($jsondata['VitaranDetails'][$i]['VitaranAddDate']));
                for($j=0;$j<count($AllMembersArray);$j++)
                {
                    if($givenArray[$j] == 1)
                    {
                        for($k=0;$k<count($jsondata['VitaranDetails'][$i]['VitaranCommodityDetail']);$k++)
                        {
                            $item_id = $jsondata['VitaranDetails'][$i]['VitaranCommodityDetail'][$k]['VitaranCommodityServerId'];
                            $kg = $jsondata['VitaranDetails'][$i]['VitaranCommodityDetail'][$k]['VitaranCommodityKG'];
                            $gm = $jsondata['VitaranDetails'][$i]['VitaranCommodityDetail'][$k]['VitaranCommodityGram'];
                            $days=1;
                            $member_id=$AllMembersArray[$j];
                            
                            $stock = (($kg*1000)+$gm)*$days;
                            $data_to_store = array(
                                                   'item_id' => $item_id,
                                                   'aanganwadi_id' => $user_id,
                                                   'stock' => $stock,
                                                   'type' => '1',
                                                   'member_id' => $member_id,
                                                   'created_date' => $date
                                                   );
                            $id=$this->item_model->store_item_stock_detail($data_to_store);
                            $get_total_stock = $this->item_model->get_total_stock($item_id,$user_id);
                            $isEntryExists = $this->item_model->isStockEntryExists($item_id,$user_id);
                            
                            if(!$isEntryExists)
                            {
                                $data_to_store = array(
                                                       'item_id' => $item_id,
                                                       'aanganwadi_id' => $user_id,
                                                       'total_stock' => $get_total_stock,
                                                       'updated_date' => date('Y-m-d H:i:s')
                                                       );
                                $item_id=$this->item_model->store_item_stock($data_to_store);
                            }
                            else
                            {
                                $data_to_store = array(
                                                       'total_stock' => $get_total_stock,
                                                       'updated_date' => date('Y-m-d H:i:s')
                                                       );
                                $item_id=$this->item_model->update_item_stock($isEntryExists,$data_to_store);
                            }
                        }
                    }
                }
            }
        }
        $getAllStockItems=$this->item_model->getAllStockItems($user_id);
        $getAllChildren=$this->kutumb_model->getAllChildWithDifferentCategory($user_id);
        $getAllHolidays = $this->holidays_model->getAllholidays();
        
        //deduct stock end
        
		/*$user_id=$jsondata['user_id'];
		$data=$jsondata['stockdata'];
		for($i=0;$i<count($data);$i++)
		{
			$item_id=$data[$i]['item_id'];
			$kg=$data[$i]['kg'];
			$gm=$data[$i]['gm'];
			$days=$data[$i]['daysToMultiply'];
			$member_id=$data[$i]['serverId'];
			
			$stock = (($kg*1000)+$gm)*$days;
			$data_to_store = array(
				'item_id' => $item_id,
				'aanganwadi_id' => $user_id,
				'stock' => $stock,
				'type' => '1',
				'member_id' => $member_id,
				'created_date' => date('Y-m-d H:i:s')
			);
			$id=$this->item_model->store_item_stock_detail($data_to_store);
			$get_total_stock = $this->item_model->get_total_stock($item_id,$user_id);
			$isEntryExists = $this->item_model->isStockEntryExists($item_id,$user_id);
			
			if(!$isEntryExists)
			{
				$data_to_store = array(
					'item_id' => $item_id,
					'aanganwadi_id' => $user_id,
					'total_stock' => $get_total_stock,
					'updated_date' => date('Y-m-d H:i:s')
				);
				$item_id=$this->item_model->store_item_stock($data_to_store);
			}
			else
			{
				$data_to_store = array(
					'total_stock' => $get_total_stock,
					'updated_date' => date('Y-m-d H:i:s')
				);
				$item_id=$this->item_model->update_item_stock($isEntryExists,$data_to_store);
			}
		}
		*/
		$returnArray=array();
        $returnArray=array();
        
        $returnArray['comodity']=$getAllStockItems;
        $returnArray['vitaranChildInfo']=$getAllChildren;
        $returnArray['holidayList']=$getAllHolidays;
		$returnArray['status']=1;
		$returnArray['message']='success';
		echo $this->out($returnArray);
	}
    
    public function childrenweight()
    {
        $jsondata =json_decode($_REQUEST['data'],TRUE);
        print_r($jsondata);
        
        
            if(count($jsondata['ChildrenWeightDetail']) > 0)
            {
                for($i=0;$i<count($jsondata['ChildrenWeightDetail']);$i++)
                {
                    
                    $children_id = $jsondata['ChildrenWeightDetail'][$i]['children_id'];
                    $weight_kg = $jsondata['ChildrenWeightDetail'][$i]['weight_kg'];
                    $weight_gm = $jsondata['ChildrenWeightDetail'][$i]['weight_gm'];
                    $weight=(float)($weight_kg.'.'.$weight_gm);
                    $weight_date = date('Y-m-d',strtotime($jsondata['ChildrenWeightDetail'][$i]['weight_date']));
                    $children_month = $jsondata['ChildrenWeightDetail'][$i]['children_month'];
                    $children_height = $jsondata['ChildrenWeightDetail'][$i]['children_height'];
                    $muac = $jsondata['ChildrenWeightDetail'][$i]['MUAC'];
                    $status = $jsondata['ChildrenWeightDetail'][$i]['status'];
                    
                    $data_to_store = array(
                                           'family_person_id' => $children_id,
                                           'children_weight_kg' => $weight_kg,
                                           'children_weight_gm' => $weight_gm,
                                           'children_weight' => $weight,
                                           'weight_date' => $weight_date,
                                           'children_month'=>$children_month,
                                           'children_height'=>$children_height,
                                           'MUAC'=>$muac,
                                           'status'=>$status,
                                           'added_date' => date('Y-m-d H:i:s')
                                           );
print_r($data_to_store);
                    $id=$this->kutumb_model->store_weight($data_to_store);
                    
                }
            }
        
    
        $returnArray=array();
    
        $returnArray['status']=1;
        $returnArray['message']='success';
        echo $this->out($returnArray);
    }
    
}
