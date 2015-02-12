<?php
class insertdata extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jilla_model');        
		$this->load->model('common_model');
		$this->load->model('taluka_model');        
		$this->load->model('gaam_model');  
		$this->load->model('aanganvadi_model');      
		$this->load->model('kutumb_model');
        $this->load->model('vacine_model');
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    
    public function vaccineServiceScript()
    {
        $allchildrens = $this->kutumb_model->get_all_children();
        //echo "<pre>";
        //print_r($allchildrens);
        for($i=0;$i<count($allchildrens);$i++)
        {
            $this->savechildvaccine($allchildrens[$i],$allchildrens[$i]['family_person_id']);
        }
    }
    public function childtype()
    {
        /*$allmembers = $this->kutumb_model->getallchildrenBelow6years();
        for($i=0;$i<count($allmembers);$i++)
        {
            if($allmembers[$i]['khodkhapan_type'] == 1 || $allmembers[$i]['khodkhapan_type'] == 2)
                $childCategory = '1';
            else
                $childCategory = '2';
            
            
            $data_to_store = array(
                                   'childCategory' => $childCategory
                                   
                                   );
            
            //if the insert has returned true then we show the flash message
            $this->kutumb_model->update_kutumb_member($allmembers[$i]['family_person_id'], $data_to_store);
            
            
            
        }
        echo "<pre>";
        print_r($allmembers);*/
        /*
        $allmembers = $this->kutumb_model->getallckishoriAndDhatri();
        for($i=0;$i<count($allmembers);$i++)
        {
            if($allmembers[$i]['lakshyank_code'] == 6)
                $childCategory = '6';
            else
                $childCategory = '5';
            
            
            $data_to_store = array(
                                   'childCategory' => $childCategory
                                   
                                   );
            
            //if the insert has returned true then we show the flash message
            $this->kutumb_model->update_kutumb_member($allmembers[$i]['family_person_id'], $data_to_store);
        }*/
        
        $allmembers = $this->kutumb_model->getallpragnent();
        for($i=0;$i<count($allmembers);$i++)
        {
            
                $childCategory = '4';
            
            
            $data_to_store = array(
                                   'childCategory' => $childCategory
                                   
                                   );
            
            //if the insert has returned true then we show the flash message
            $this->kutumb_model->update_kutumb_member($allmembers[$i]['family_person_id'], $data_to_store);
        }
    }
    public function savechildvaccine($memberdata,$kutumb_person_id)
    {
        if($memberdata['nondhani_date'] == '')
            $memberdata['nondhani_date'] = $memberdata['birth_date'];
        $nondhani_date = $memberdata['nondhani_date'];
        
        $nondhani_date_round1 = date('Y-m-d',strtotime($memberdata['nondhani_date'].' +45 days')); // for polio 1, pentavalent 1
        $nondhani_date_round2 = date('Y-m-d',strtotime($nondhani_date_round1.' +28 days')); // for polio 2,Pentavalent - 2
        $nondhani_date_round3 = date('Y-m-d',strtotime($nondhani_date_round2.' +28 days')); // for polio 3,Pentavalent - 3
        $nondhani_date_270_days = date('Y-m-d',strtotime($memberdata['nondhani_date'].' +270 days')); // for Ori - First Dose,Vitamin A - First Dose
        $nondhani_date_15_month = date('Y-m-d',strtotime($memberdata['nondhani_date'].' +15 month')); // for Ori -Second Dose,Triguni Booster,Polio Booster
        $vitabmiA_after_4_month = date('Y-m-d',strtotime($nondhani_date_270_days.' +4 month'));
        $nondhani_date_5_year = date('Y-m-d',strtotime($memberdata['nondhani_date'].' +5 year')); // for Triguni Bijo Booster
        //BCG
        $bcgVacine = $this->vacine_model->get_vacine_id_by_name('B.C.G.');
        if(!$this->kutumb_model->isvaccine($bcgVacine[0]['id'],$kutumb_person_id))
        {
            $bcgvacine_data = array('vaccine_id' => $bcgVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date,'given_date' => $nondhani_date,'given_status' => '1','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($bcgvacine_data);
        }
        
        
        //Hep B - 0
        $hepbVacine = $this->vacine_model->get_vacine_id_by_name('Hep B - 0');
        if(!$this->kutumb_model->isvaccine($hepbVacine[0]['id'],$kutumb_person_id))
        {
            $hepvacine_data = array('vaccine_id' => $hepbVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date,'given_date' => $nondhani_date,'given_status' => '1','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($hepvacine_data);
        }
        
        //Polio - 0
        $polio0bVacine = $this->vacine_model->get_vacine_id_by_name('Polio - 0');
        if(!$this->kutumb_model->isvaccine($polio0bVacine[0]['id'],$kutumb_person_id))
        {
            $polio0vacine_data = array('vaccine_id' => $polio0bVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date,'given_date' => $nondhani_date,'given_status' => '1','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($polio0vacine_data);
        }
        
        //Polio - 1
        $polio1bVacine = $this->vacine_model->get_vacine_id_by_name('Polio - 1');
        if(!$this->kutumb_model->isvaccine($polio1bVacine[0]['id'],$kutumb_person_id))
        {
            $polio1vacine_data = array('vaccine_id' => $polio1bVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round1,'given_date' => $nondhani_date_round1,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($polio1vacine_data);
        }
        
        //Pentavalent - 1
        $pentavalent1bVacine = $this->vacine_model->get_vacine_id_by_name('Pentavalent - 1');
        if(!$this->kutumb_model->isvaccine($pentavalent1bVacine[0]['id'],$kutumb_person_id))
        {
            $pentavalent1vacine_data = array('vaccine_id' => $pentavalent1bVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round1,'given_date' => $nondhani_date_round1,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($pentavalent1vacine_data);
        }
        
        //Polio - 2
        $polio2Vacine = $this->vacine_model->get_vacine_id_by_name('Polio - 2');
        if(!$this->kutumb_model->isvaccine($polio2Vacine[0]['id'],$kutumb_person_id))
        {
            $polio2vacine_data = array('vaccine_id' => $polio2Vacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round2,'given_date' => $nondhani_date_round2,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($polio2vacine_data);
        }
        
        //Pentavalent - 2
        $pentavalent2Vacine = $this->vacine_model->get_vacine_id_by_name('Pentavalent - 2');
        if(!$this->kutumb_model->isvaccine($pentavalent2Vacine[0]['id'],$kutumb_person_id))
        {
            $pentavalent2vacine_data = array('vaccine_id' => $pentavalent2Vacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round2,'given_date' => $nondhani_date_round2,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($pentavalent2vacine_data);
        }
        
        //Polio - 3
        $polio3Vacine = $this->vacine_model->get_vacine_id_by_name('Polio - 3');
        if(!$this->kutumb_model->isvaccine($polio3Vacine[0]['id'],$kutumb_person_id))
        {
            $polio3vacine_data = array('vaccine_id' => $polio3Vacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round3,'given_date' => $nondhani_date_round3,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($polio3vacine_data);
        }
        //Pentavalent - 3
        $pentavalent3Vacine = $this->vacine_model->get_vacine_id_by_name('Pentavalent - 3');
        if(!$this->kutumb_model->isvaccine($pentavalent3Vacine[0]['id'],$kutumb_person_id))
        {
            $pentavalent3vacine_data = array('vaccine_id' => $pentavalent3Vacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_round3,'given_date' => $nondhani_date_round3,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($pentavalent3vacine_data);
        }
        //Ori - First Dose
        $oriFirstVacine = $this->vacine_model->get_vacine_id_by_name('Ori - First Dose');
        if(!$this->kutumb_model->isvaccine($oriFirstVacine[0]['id'],$kutumb_person_id))
        {
            $oriFirstvacine_data = array('vaccine_id' => $oriFirstVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_270_days,'given_date' => $nondhani_date_270_days,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($oriFirstvacine_data);
        }
        
        //Vitamin A - First Dose
        $vitaminAFirstVacine = $this->vacine_model->get_vacine_id_by_name('Vitamin A - First Dose');
        if(!$this->kutumb_model->isvaccine($vitaminAFirstVacine[0]['id'],$kutumb_person_id))
        {
            $vitaminAFirstvacine_data = array('vaccine_id' => $vitaminAFirstVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_270_days,'given_date' => $nondhani_date_270_days,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($vitaminAFirstvacine_data);
        }
        //Ori -Second Dose
        $oriSecondVacine = $this->vacine_model->get_vacine_id_by_name('Ori -Second Dose');
        if(!$this->kutumb_model->isvaccine($oriSecondVacine[0]['id'],$kutumb_person_id))
        {
            $oriSecondvacine_data = array('vaccine_id' => $oriSecondVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_15_month,'given_date' => $nondhani_date_15_month,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($oriSecondvacine_data);
        }
        
        //Triguni Booster
        $triguniboosterVacine = $this->vacine_model->get_vacine_id_by_name('Triguni Booster');
        if(!$this->kutumb_model->isvaccine($triguniboosterVacine[0]['id'],$kutumb_person_id))
        {
            $triguniboosterVacine_data = array('vaccine_id' => $triguniboosterVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_15_month,'given_date' => $nondhani_date_15_month,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($triguniboosterVacine_data);
        }
        //Polio Booster
        $polioboosterVacine = $this->vacine_model->get_vacine_id_by_name('Polio Booster');
        if(!$this->kutumb_model->isvaccine($polioboosterVacine[0]['id'],$kutumb_person_id))
        {
            $polioboosterVacine_data = array('vaccine_id' => $polioboosterVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_15_month,'given_date' => $nondhani_date_15_month,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($polioboosterVacine_data);
        }
        //Vitamin A - Second Dose
        $polioboosterVacine = $this->vacine_model->get_vacine_id_by_name('Vitamin A - Second Dose');
        if(strtotime($vitabmiA_after_4_month) > strtotime($nondhani_date_15_month))
            $date=$vitabmiA_after_4_month;
        else
            $date=$nondhani_date_15_month;
        
        if(!$this->kutumb_model->isvaccine($polioboosterVacine[0]['id'],$kutumb_person_id))
        {
            $polioboosterVacine_data = array('vaccine_id' => $polioboosterVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $date,'given_date' => $date,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($polioboosterVacine_data);
        }
        
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
            if(!$this->kutumb_model->isvaccine($vacinearray[$i],$kutumb_person_id))
            {
                $vacine_data = array('vaccine_id' => $vacinearray[$i],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $after4month,'given_date' => $after4month,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
                $this->vacine_model->store_vacine($vacine_data);
            }
        }
        
        //Triguni Bijo Booster
        $triguniBijoBoosterVacine = $this->vacine_model->get_vacine_id_by_name('Triguni Bijo Booster');
        if(!$this->kutumb_model->isvaccine($triguniBijoBoosterVacine[0]['id'],$kutumb_person_id))
        {
            $triguniBijoBoosterVacine_data = array('vaccine_id' => $triguniBijoBoosterVacine[0]['id'],'member_id' => $kutumb_person_id,'vaccine_type' => '1','due_date' => $nondhani_date_5_year,'given_date' => $nondhani_date_5_year,'given_status' => '0','created_at' => date('Y-m-d H:i:s'));
            $this->vacine_model->store_vacine($triguniBijoBoosterVacine_data);
        }
        
    }
    public function index()
    {
     //   $getAllMember = $this->kutumb_model->set_all_pragnent_member();
		//start inserting jilla
		/*
		$jilla = $this->jilla_model->get_jilla();  
		for($i=0;$i<count($jilla);$i++)
		{
			$data_to_send = "id=".$jilla[$i]['id']."&guj_district_name=".$jilla[$i]['name_guj']."&district_name=".$jilla[$i]['name']."&status=1";
			
			$this->common_model->save_curl_data($data_to_send,'adddistrict.json');
		}
		//echo "<pre>";      
		//print_r($jilla);
		//echo "</pre>";
		//end inserting jilla
		
		//start inserting taluka
		$taluka = $this->taluka_model->get_taluka(); 
		echo "<pre>";      
		print_r($taluka);
		echo "</pre>"; 
		for($i=0;$i<count($taluka);$i++)
		{
			echo $data_to_send = "id=".$taluka[$i]['id']."&districts_id=".$taluka[$i]['jilla_id']."&guj_taluka_name=".$taluka[$i]['name_guj']."&taluka_name=".$taluka[$i]['name']."&status=1";
			echo "<br>";
			$this->common_model->save_curl_data($data_to_send,'addtaluka.json');
		}
		//end inserting taluka
		
		//start inserting gaam
		$gaam = $this->gaam_model->get_gaam();
		 
		for($i=1300;$i<count($gaam);$i++)
		{
			echo $data_to_send = "id=".$gaam[$i]['id']."&talukas_id=".$gaam[$i]['taluka_id']."&guj_village_name=".$gaam[$i]['name_guj']."&village_name=".$gaam[$i]['name']."&status=1";
			echo "<br><br>";
			$this->common_model->save_curl_data($data_to_send,'addvillage.json');
            echo "<br>";
		}
		//echo "<pre>";
		//print_r($gaam);
		//echo "</pre>";
		//end inserting gaam
         
		
		//start inserting aanganwadi
		$aanganwadi = $this->aanganvadi_model->get_aanganvadi(); 
		echo "<pre>";      
		print_r($aanganwadi);
		echo "</pre>"; 
		for($i=0;$i<count($aanganwadi);$i++)
		{
			echo $data_to_send = "id=".$aanganwadi[$i]['id']."&villages_id=".$aanganwadi[$i]['gaam_id']."&guj_anganwadi_name=".$aanganwadi[$i]['aanganvadi_name']."&anganwadi_name=".$aanganwadi[$i]['aanganvadi_name']."&anganwadi_code=".$aanganwadi[$i]['aanganvadi_number']."&guj_worker_name=".$aanganwadi[$i]['karyakar_name']."&worker_name=".$aanganwadi[$i]['karyakar_name']."&worker_mobile=".$aanganwadi[$i]['karyakar_number']."&guj_helper_name=".$aanganwadi[$i]['tedagara_name']."&helper_name=".$aanganwadi[$i]['tedagara_name']."&helper_mobile=".$aanganwadi[$i]['tedagara_number']."&status=1";
			echo "<br>";
			$this->common_model->save_curl_data($data_to_send,'addanganwadi.json');
		}
		//end inserting aanganwadi
         */
		
		//start inserting member
		$kutumb = $this->kutumb_model->get_kutumb();
        
		 
		for($i=100;$i<count($kutumb);$i++)
		{
			$members = $this->kutumb_model->get_all_person_by_kutumbid($kutumb[$i]['family_id']); 
			
			for($j=0;$j<count($members);$j++)
			{
				$gender='';
                $gender='';
                if($members[$j]['gender']==2)
                    $gender='M';
                if($members[$j]['gender']==3)
                    $gender='F';
                if($members[$j]['gender']==4)
                    $gender='T';
					
				$birthdate='';
				if($members[$j]['birth_date'] != '0000-00-00 00:00:00')
					$birthdate = $members[$j]['birth_date'];
                
                $from = new DateTime($members[$j]['birth_date']);
                $to   = new DateTime('today');
                if($from->diff($to)->y <6)
                {
                echo $data_to_send = "id=".$members[$j]['family_person_id']."&anganwadies_id=".$kutumb[$i]['anganwadi_id']."&guj_first_name=".$members[$j]['first_name']."&first_name=".$members[$j]['first_name']."&guj_middle_name=".$members[$j]['middle_name']."&middle_name=".$members[$j]['middle_name']."&guj_last_name=".$members[$j]['last_name']."&last_name=".$members[$j]['last_name']."&sex=".$gender."&date_of_birth=".$birthdate."&parent_mobile=0&vaccinated=&vaccinated_date=&photo=&status=1";
					echo "<br><br>";
				//echo $data_to_send = "id=".$members[$j]['family_person_id']."&anganwadies_id=".$kutumb[$i]['anganwadi_id']."&guj_first_name=".$members[$j]['first_name']."&first_name=".$members[$j]['first_name']."&guj_middle_name=".$members[$j]['middle_name']."&middle_name=".$members[$j]['middle_name']."&guj_last_name=".$members[$j]['last_name']."&last_name=".$members[$j]['last_name']."&sex=".$gender."&date_of_birth=".$birthdate."&parent_mobile=&vaccinated=&vaccinated_date=&photo=&status=1";
				$result = $this->common_model->save_curl_data($data_to_send,'addchildren.json');
                }
				//print_r($result);
				//exit;
			}
		}
		
		//end inserting member
		
	}
}
?>