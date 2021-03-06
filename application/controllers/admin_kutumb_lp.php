<?php
class Admin_kutumb extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jilla_model');
        $this->load->model('taluka_model');
		$this->load->model('gaam_model');
		$this->load->model('aanganvadi_model');
		$this->load->model('kutumb_model');
		$this->load->model('common_model');
		$this->load->model('vacine_model');
		$this->lang->load('messages','gujarati');
        if(!$this->session->userdata('is_logged_in')){
            redirect(site_url());exit;
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {
        
		$perPage = 20;
		
		//all the posts sent by the view
        $jilla_id = $this->input->post('jilla_id');
		$taluka_id = $this->input->post('taluka_id');
		$gaam_id = $this->input->post('gaam_id');
		$aanganwadiid_id = $this->input->post('aanganvadi_id');
		$searchtxt = $this->input->post('searchtxt');
		$perpagePost = $this->input->post('perpage');
        $jati_id = $this->input->post('jati_id');
        $religion_id = $this->input->post('religion_id');
        $laghumati = $this->input->post('laghumati');
        if($perpagePost != '')
		{
			$perPage = $perpagePost;
		}
		$data['perpage'] = $perPage;
		$currentpagePost = $this->input->post('currentpage');
		$data['searchtxt']=$searchtxt;
		
		$data['jilla_selected'] = 0;
		$data['taluka_selected'] = 0;
		$data['gaam_selected'] = 0;
		$data['aanganvadi_selected'] = 0;
		//fetch sql data into arrays
        $data['jilla'] = $this->jilla_model->get_jilla();
		$data['taluka'] = $this->taluka_model->get_taluka();
		$data['gaam'] = $this->gaam_model->get_gaam();
			
		$data['count_kutumb']= 0;
        $data['kutumb'] = array();   
		
		$search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = $perPage;
        $config['base_url'] = base_url().'kutumb/page';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);
		if($currentpagePost != '')
		{
			$page = $currentpagePost;
		}
		if($data['searchtxt'] != '')
		{
			$page = 1;
		}
        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
			$page=1;
        } 
		
		$data['currentpage'] = $page;
        //if order type was changed
        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            //we have something stored in the session? 
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';    
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;        


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data

        //filtered && || paginated
            //clean filter data inside section
            $filter_session_data['jilla_selected'] = null;
			$filter_session_data['taluka_selected'] = null;
			$filter_session_data['gaam_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;

            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
			
			if($jilla_id != '' ||  $jilla_id != 0)
			{
	            $data['jilla_selected'] = $jilla_id;
				$data['taluka'] = $this->taluka_model->get_taluka($jilla_id);
			}
			else
			{
				$data['taluka'] = array();
				$data['jilla_selected'] = 0;
			}
				
				
			if($taluka_id != '' || $taluka_id != 0)
			{
				$data['gaam'] = $this->gaam_model->get_gaam($taluka_id);
				$data['taluka_selected'] = $taluka_id;
			}
			else
			{
				$data['gaam'] = array();
				$data['taluka_selected'] = 0;
			}
			
				
			if($gaam_id != '' || $gaam_id != 0)
			{
				$data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi('','',$gaam_id,'','','Asc','','');
				$data['gaam_selected'] = $gaam_id;
			}
			else
			{
				$data['aanganvadi'] = array();
				$data['gaam_selected']=0;
			}
        
        if($jati_id != '' || $jati_id != 0)
        {
            $data['jati_selected'] = $jati_id;
        }
        else
        {
            
            $data['jati_selected']=0;
        }
        if($religion_id != '' || $religion_id != 0)
        {
            $data['religion_selected'] = $religion_id;
        }
        else
        {
            
            $data['religion_selected']=0;
        }
        
        if($laghumati != '' || $laghumati != 0)
            $data['laghumati_selected'] = $laghumati;
        else
            $data['laghumati_selected'] = $laghumati;
        
        
				
			if($aanganwadiid_id != '' || $aanganwadiid_id != 0)
				$data['aanganwadiid_selected'] = $aanganwadiid_id;
			else
				$data['aanganwadiid_selected'] = 0;
				
			
	            $data['order'] = 'family_rank';
			
            $data['count_kutumb']= $this->kutumb_model->count_kutumb('','','',$aanganwadiid_id,$searchtxt,$jati_id,$religion_id,$laghumati,'','','','');
			
            $data['kutumb'] = $this->kutumb_model->get_kutumb('','','',$aanganwadiid_id, $searchtxt,$jati_id,$religion_id,$laghumati, '', $order_type, $config['per_page'],$limit_end);
            $config['total_rows'] = $data['count_kutumb'];

        //!isset($manufacture_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config);   
     
		$castArray = $this->common_model->get_all_data('tbl_caste');
		$religionArray = $this->common_model->get_all_data('tbl_religion');
		$placeArray = $this->common_model->get_all_data('tbl_place');
		$relationArray = $this->common_model->get_all_data('tbl_relation');
		$genderArray = $this->common_model->get_all_data('tbl_gender');
		$maritalStatusArray = $this->common_model->get_all_data('tbl_maritalstatus');
		$targetCodeArray = $this->common_model->get_all_data('tbl_targetcode');
		$malformationTypeArray = $this->common_model->get_all_data('tbl_malformationtype');
		
		$data['castArray']=$castArray;
		$data['religionArray']=$religionArray;
		$data['placeArray']=$placeArray;
		$data['relationArray']=$relationArray;
		$data['genderArray']=$genderArray;
		$data['maritalStatusArray']=$maritalStatusArray;
		$data['targetCodeArray']=$targetCodeArray;
		$data['malformationTypeArray']=$malformationTypeArray;
        
        //load the view
        $data['main_content'] = 'admin/kutumb/list';
        $this->load->view('includes/template', $data);  

    }//index
	public function checkvalidation()
	{
		$idsarray=explode('-',$_REQUEST['ids']);
		$error='';
		//if(!isset($_REQUEST['familyid']))
		{
			if(isset($_REQUEST['familyid']))
				$familyid = $_REQUEST['familyid'];
			else
				$familyid = '';
				
			if (!is_numeric($idsarray[0])) {
        		echo 'Please enter valid family rank.';exit;
				
    		}
			$count=$this->kutumb_model->checkiffamilyrankexists($idsarray[0],$_REQUEST['aanganwadi_id'],$familyid);
			if($count!=0)
			{
				$error.='Family rank '.$idsarray[0].' is already in used.';
			}
			$str='';
			$newarray=array();
			for($i=1;$i<count($idsarray);$i++)
			{
				$newarray[] = $idsarray[$i];
			}
			if(count(array_unique($newarray)) < count($newarray))
			{
				$error.='Family person rank must be unique.';
			}
			echo $error;
		}
	}
	public function addkutumb()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
            //form validation
            $this->form_validation->set_rules('aanganvadiid', 'aanganvadiid', 'required');
			$this->form_validation->set_rules('kutumb_krm_no', 'kutumb_krm_no', 'required');
			$this->form_validation->set_rules('jati', 'jati', 'required');
			$this->form_validation->set_rules('dharm', 'dharm', 'required');
            $this->form_validation->set_rules('sthal', 'sthal', 'required|numeric');
            $this->form_validation->set_rules('sthallocation', 'sthallocation', 'required');
            $this->form_validation->set_rules('isLagumati', 'isLagumati', 'required');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
$_REQUEST['id'] = $this->input->post('aanganvadiid');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				$k_nondhani_date = $this->input->post('k_nondhani_date');
				$k_nondhani_date = str_replace("/","-",$k_nondhani_date);
				
				if($k_nondhani_date != '')
					$k_nondhani_date = date('Y-m-d',strtotime($k_nondhani_date));
				else
					$k_nondhani_date='';
							
                $data_to_store = array(
                    'anganwadi_id' => $this->input->post('aanganvadiid'),
					'family_rank' => $this->input->post('kutumb_krm_no'),
					'jati_id' => $this->input->post('jati'),
					'dharm_id' => $this->input->post('dharm'),
                    'sthal_id' => $this->input->post('sthal'),
                    'sthal_value' => $this->input->post('sthallocation'),
                    'laghumati' => $this->input->post('isLagumati'),
					'nondhani_date' => $k_nondhani_date,
					'last_updated_date' => date('Y-m-d H:i:s'),
                );
				
                //if the insert has returned true then we show the flash message
				$kutumbid = $this->kutumb_model->store_kutumb($data_to_store);
                $_REQUEST['familypersondata'] = json_decode($_REQUEST['familypersoninfo']);
				
				if($kutumbid!=0)
				{
					for($i=0;$i<count((array)$_REQUEST['familypersondata']);$i++)
					{
						$_REQUEST['familypersondata']->$i->txtDeathDate = str_replace("/","-",$_REQUEST['familypersondata']->$i->txtDeathDate);
						$_REQUEST['familypersondata']->$i->txtOutSthadantrarDate = str_replace("/","-",$_REQUEST['familypersondata']->$i->txtOutSthadantrarDate);
						$_REQUEST['familypersondata']->$i->txtsthantarDate = str_replace("/","-",$_REQUEST['familypersondata']->$i->txtsthantarDate);
						$_REQUEST['familypersondata']->$i->txtBirthDate = str_replace("/","-",$_REQUEST['familypersondata']->$i->txtBirthDate);
						$_REQUEST['familypersondata']->$i->lmp_date = str_replace("/","-",$_REQUEST['familypersondata']->$i->lmp_date);
						$_REQUEST['familypersondata']->$i->miscarage_date = str_replace("/","-",$_REQUEST['familypersondata']->$i->miscarage_date);
						$_REQUEST['familypersondata']->$i->nondhani_date = str_replace("/","-",$_REQUEST['familypersondata']->$i->nondhani_date);
						
						if($_REQUEST['familypersondata']->$i->txtDeathDate != '')
							$_REQUEST['familypersondata']->$i->txtDeathDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtDeathDate));
						
						if($_REQUEST['familypersondata']->$i->txtOutSthadantrarDate != '')
							$_REQUEST['familypersondata']->$i->txtOutSthadantrarDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtOutSthadantrarDate));
						
						if($_REQUEST['familypersondata']->$i->txtsthantarDate != '')
							$_REQUEST['familypersondata']->$i->txtsthantarDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtsthantarDate));
						
						if($_REQUEST['familypersondata']->$i->txtBirthDate != '')
							$_REQUEST['familypersondata']->$i->txtBirthDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtBirthDate));
							
						if($_REQUEST['familypersondata']->$i->lmp_date != '')
							$_REQUEST['familypersondata']->$i->lmp_date = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->lmp_date));
						else
							$_REQUEST['familypersondata']->$i->lmp_date='';
			
		
						if($_REQUEST['familypersondata']->$i->miscarage_date != '')
							$_REQUEST['familypersondata']->$i->miscarage_date = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->miscarage_date));
						else
							$_REQUEST['familypersondata']->$i->miscarage_date='';
			
						if($_REQUEST['familypersondata']->$i->nondhani_date != '')
							$_REQUEST['familypersondata']->$i->nondhani_date = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->nondhani_date));
						else
							$_REQUEST['familypersondata']->$i->nondhani_date='';
			
						$last_updated_date = date('Y-m-d H:i:s');
				
				
				
						$data_to_store = array(
							'family_id' => $kutumbid,
							'person_rank' => $_REQUEST['familypersondata']->$i->txtPersonNumber,
							'uid_aadharnumber' => $_REQUEST['familypersondata']->$i->txtaadhar,
							'first_name' => $_REQUEST['familypersondata']->$i->txtfname,
							'middle_name' => $_REQUEST['familypersondata']->$i->txtmname,
							'last_name' => $_REQUEST['familypersondata']->$i->txtlname,
							'relation_with_main_person' => $_REQUEST['familypersondata']->$i->drpRelation,
							'gender' => $_REQUEST['familypersondata']->$i->drpGender,
							'merridial_status' => $_REQUEST['familypersondata']->$i->drpdarjo,
							'birth_date' => $_REQUEST['familypersondata']->$i->txtBirthDate,
							'ageIn_year' => $_REQUEST['familypersondata']->$i->txtYear,
							'ageIn_month' => $_REQUEST['familypersondata']->$i->txtMonth,
							'mother_name' => $_REQUEST['familypersondata']->$i->txtmothername,
							'lakshyank_code' => $_REQUEST['familypersondata']->$i->drplakshyank,
							'khodkhapan_type' => $_REQUEST['familypersondata']->$i->drpKhodkhapan,
							'anganwadi_kendra_vistar_rehvasi' => $_REQUEST['familypersondata']->$i->rdoRehvasi,
							'gam_shift_date' => $_REQUEST['familypersondata']->$i->txtsthantarDate,
							'gam_out_shift_date' => $_REQUEST['familypersondata']->$i->txtOutSthadantrarDate,
							'die_date' => $_REQUEST['familypersondata']->$i->txtDeathDate,
							'purak_aahar' => $_REQUEST['familypersondata']->$i->chkpurakAahar,
							'purv_prathmik_shikshan' => $_REQUEST['familypersondata']->$i->chkPrathmikEducation,
							'lmp_date' => $_REQUEST['familypersondata']->$i->lmp_date,
							'miscarage_date' => $_REQUEST['familypersondata']->$i->miscarage_date,
							'nondhani_date' => $_REQUEST['familypersondata']->$i->nondhani_date,
							'last_updated_date' => $last_updated_date,
							'janm_samay' => $_REQUEST['familypersondata']->$i->janm_samay,
							'janm_sthal' => $_REQUEST['familypersondata']->$i->janm_sthal,
							'janm_samaye_thayel_vajan_kilogram' => $_REQUEST['familypersondata']->$i->janm_samaye_thayel_vajan_kilogram,
							'janm_amaye_thayel_vajan_grams' => $_REQUEST['familypersondata']->$i->janm_amaye_thayel_vajan_grams,
							'dilevery_type' => $_REQUEST['familypersondata']->$i->dilevery_type,
						);
						//print_r($data_to_store);
						$from = new DateTime($_REQUEST['familypersondata']->$i->txtBirthDate);
						$to   = new DateTime('today');
						if($from->diff($to)->y <6)
						{
							$gender='';
							if($_REQUEST['familypersondata']->$i->drpGender==2)
								$gender='M';
							if($_REQUEST['familypersondata']->$i->drpGender==3)
								$gender='F';
							if($_REQUEST['familypersondata']->$i->drpGender==4)
								$gender='T';
							//if the insert has returned true then we show the flash message
							$kutumb_person_id = $this->kutumb_model->store_kutumb_person($data_to_store);
							$data_to_send = "id=".$kutumb_person_id."&anganwadies_id=".$this->input->post('aanganvadiid')."&guj_first_name=".$_REQUEST['familypersondata']->$i->txtfname."&first_name=".$_REQUEST['familypersondata']->$i->txtfname."&guj_middle_name=".$_REQUEST['familypersondata']->$i->txtmname."&middle_name=".$_REQUEST['familypersondata']->$i->txtmname."&guj_last_name=".$_REQUEST['familypersondata']->$i->txtlname."&last_name=".$_REQUEST['familypersondata']->$i->txtlname."&sex=".$gender."&date_of_birth=".$_REQUEST['familypersondata']->$i->txtBirthDate."&parent_mobile=0&vaccinated=&vaccinated_date=&photo=&status=1";
							$this->common_model->save_curl_data($data_to_send,'addchildren.json');
						}					
						if($_REQUEST['familypersondata']->$i->txtYear == 0 && $_REQUEST['familypersondata']->$i->txtMonth < 6 && $_REQUEST['familypersondata']->$i->janm_samay != '')
						{
							$this->savechildvaccine($_REQUEST['familypersondata']->$i,$kutumb_person_id);
						}
						if($_REQUEST['familypersondata']->$i->lmp_date != '')
						{
							$this->savevacine($_REQUEST['familypersondata']->$i,$kutumb_person_id);
							$data_to_store = array(
								'family_id' => $kutumbid,
								'family_person_id' => $kutumb_person_id,
								'lmp_date' => $_REQUEST['familypersondata']->$i->lmp_date,
								'miscarage_date' => $_REQUEST['familypersondata']->$i->miscarage_date,
								'nondhani_date' => $_REQUEST['familypersondata']->$i->nondhani_date,
								'last_updated_date' => $last_updated_date,					
							);
							$kutumb_sagrbha_person_id = $this->kutumb_model->store_sagrbha_kutumb_person($data_to_store);
						}
					}
                
				}
				
				if($kutumbid!=0){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
		$castArray = $this->common_model->get_all_data('tbl_caste');
		$religionArray = $this->common_model->get_all_data('tbl_religion');
		$placeArray = $this->common_model->get_all_data('tbl_place');
		$relationArray = $this->common_model->get_all_data('tbl_relation');
		$genderArray = $this->common_model->get_all_data('tbl_gender');
		$maritalStatusArray = $this->common_model->get_all_data('tbl_maritalstatus');
		$targetCodeArray = $this->common_model->get_all_data('tbl_targetcode');
		$malformationTypeArray = $this->common_model->get_all_data('tbl_malformationtype');
		
		$data['castArray']=$castArray;
		$data['religionArray']=$religionArray;
		$data['placeArray']=$placeArray;
		$data['relationArray']=$relationArray;
		$data['genderArray']=$genderArray;
		$data['maritalStatusArray']=$maritalStatusArray;
		$data['targetCodeArray']=$targetCodeArray;
		$data['malformationTypeArray']=$malformationTypeArray;
		
        //fetch jilla data to populate the select field
        $data['jilla'] = $this->jilla_model->get_jilla();
		//fetch taluka data to populate the select field
        $data['taluka'] = array();//$this->taluka_model->get_taluka();
		//fetch gaam data to populate the select field
        $data['gaam'] = array();//$this->gaam_model->get_gaam();
		$data['aanganvadi_id'] = $_REQUEST['id'];
		$data['relations'] = relationArray();
//		print_r($data['relations']);
        //load the view
        $data['main_content'] = 'admin/kutumb/add';
        $this->load->view('includes/template', $data);  
    }       

    /**
    * Update item by his id
    * @return void
    */
    public function update()
    {
        //aanganvadi id 
        $id = $this->uri->segment(3);
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
//		echo "<pre>";
//		print_r($_REQUEST);
//		print_r(json_decode($_REQUEST['familypersoninfo']));
//		echo "</pre>";exit;
           //form validation
            $this->form_validation->set_rules('aanganvadiid', 'aanganvadiid', 'required');
			$this->form_validation->set_rules('kutumb_krm_no', 'kutumb_krm_no', 'required');
			$this->form_validation->set_rules('jati', 'jati', 'required');
			$this->form_validation->set_rules('dharm', 'dharm', 'required');
            $this->form_validation->set_rules('sthal', 'sthal', 'required|numeric');
            $this->form_validation->set_rules('sthallocation', 'sthallocation', 'required');
            $this->form_validation->set_rules('isLagumati', 'isLagumati', 'required');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				$k_nondhani_date = $this->input->post('k_nondhani_date');
				$k_nondhani_date = str_replace("/","-",$k_nondhani_date);
				
				if($k_nondhani_date != '')
					$k_nondhani_date = date('Y-m-d',strtotime($k_nondhani_date));
				else
					$k_nondhani_date='';
					
    
                 $data_to_store = array(
                    'anganwadi_id' => $this->input->post('aanganvadiid'),
					'family_rank' => $this->input->post('kutumb_krm_no'),
					'jati_id' => $this->input->post('jati'),
					'dharm_id' => $this->input->post('dharm'),
                    'sthal_id' => $this->input->post('sthal'),
                    'sthal_value' => $this->input->post('sthallocation'),
                    'laghumati' => $this->input->post('isLagumati'),
					'nondhani_date' => $k_nondhani_date,
					'last_updated_date' => date('Y-m-d H:i:s'),
                );
				
                //if the insert has returned true then we show the flash message
                if($this->kutumb_model->update_kutumb($id, $data_to_store) == TRUE){
				
					//$this->kutumb_model->delete_kutumb_person($id);
					$_REQUEST['familypersondata'] = json_decode($_REQUEST['familypersoninfo']);
					
					for($i=0;$i<count((array)$_REQUEST['familypersondata']);$i++)
					{					
					
						$_REQUEST['familypersondata']->$i->txtDeathDate = str_replace("/","-",$_REQUEST['familypersondata']->$i->txtDeathDate);
						$_REQUEST['familypersondata']->$i->txtOutSthadantrarDate = str_replace("/","-",$_REQUEST['familypersondata']->$i->txtOutSthadantrarDate);
						$_REQUEST['familypersondata']->$i->txtsthantarDate = str_replace("/","-",$_REQUEST['familypersondata']->$i->txtsthantarDate);
						$_REQUEST['familypersondata']->$i->txtBirthDate = str_replace("/","-",$_REQUEST['familypersondata']->$i->txtBirthDate);
						$_REQUEST['familypersondata']->$i->lmp_date = str_replace("/","-",$_REQUEST['familypersondata']->$i->lmp_date);
						$_REQUEST['familypersondata']->$i->miscarage_date = str_replace("/","-",$_REQUEST['familypersondata']->$i->miscarage_date);
						$_REQUEST['familypersondata']->$i->nondhani_date = str_replace("/","-",$_REQUEST['familypersondata']->$i->nondhani_date);
						
						if($_REQUEST['familypersondata']->$i->txtDeathDate != '')
							$_REQUEST['familypersondata']->$i->txtDeathDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtDeathDate));
						
						if($_REQUEST['familypersondata']->$i->txtOutSthadantrarDate != '')
							$_REQUEST['familypersondata']->$i->txtOutSthadantrarDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtOutSthadantrarDate));
						
						if($_REQUEST['familypersondata']->$i->txtsthantarDate != '')
							$_REQUEST['familypersondata']->$i->txtsthantarDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtsthantarDate));
						
						if($_REQUEST['familypersondata']->$i->txtBirthDate != '')
							$_REQUEST['familypersondata']->$i->txtBirthDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtBirthDate));
							
						if($_REQUEST['familypersondata']->$i->lmp_date != '')
							$_REQUEST['familypersondata']->$i->lmp_date = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->lmp_date));
						else
							$_REQUEST['familypersondata']->$i->lmp_date='';
			
		
						if($_REQUEST['familypersondata']->$i->miscarage_date != '')
							$_REQUEST['familypersondata']->$i->miscarage_date = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->miscarage_date));
						else
							$_REQUEST['familypersondata']->$i->miscarage_date='';
			
						if($_REQUEST['familypersondata']->$i->nondhani_date != '')
							$_REQUEST['familypersondata']->$i->nondhani_date = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->nondhani_date));
						else
							$_REQUEST['familypersondata']->$i->nondhani_date='';
							
							$last_updated_date = date('Y-m-d H:i:s');
				
						$data_to_store = array(
							'family_id' => $id,
							'person_rank' => $_REQUEST['familypersondata']->$i->txtPersonNumber,
							'uid_aadharnumber' => $_REQUEST['familypersondata']->$i->txtaadhar,
							'first_name' => $_REQUEST['familypersondata']->$i->txtfname,
							'middle_name' => $_REQUEST['familypersondata']->$i->txtmname,
							'last_name' => $_REQUEST['familypersondata']->$i->txtlname,
							'relation_with_main_person' => $_REQUEST['familypersondata']->$i->drpRelation,
							'gender' => $_REQUEST['familypersondata']->$i->drpGender,
							'merridial_status' => $_REQUEST['familypersondata']->$i->drpdarjo,
							'birth_date' => $_REQUEST['familypersondata']->$i->txtBirthDate,
							'ageIn_year' => $_REQUEST['familypersondata']->$i->txtYear,
							'ageIn_month' => $_REQUEST['familypersondata']->$i->txtMonth,
							'mother_name' => $_REQUEST['familypersondata']->$i->txtmothername,
							'lakshyank_code' => $_REQUEST['familypersondata']->$i->drplakshyank,
							'khodkhapan_type' => $_REQUEST['familypersondata']->$i->drpKhodkhapan,
							'anganwadi_kendra_vistar_rehvasi' => $_REQUEST['familypersondata']->$i->rdoRehvasi,
							'gam_shift_date' => $_REQUEST['familypersondata']->$i->txtsthantarDate,
							'gam_out_shift_date' => $_REQUEST['familypersondata']->$i->txtOutSthadantrarDate,
							'die_date' => $_REQUEST['familypersondata']->$i->txtDeathDate,
							'purak_aahar' => $_REQUEST['familypersondata']->$i->chkpurakAahar,
							'purv_prathmik_shikshan' => $_REQUEST['familypersondata']->$i->chkPrathmikEducation,
							'lmp_date' => $_REQUEST['familypersondata']->$i->lmp_date,
							'miscarage_date' => $_REQUEST['familypersondata']->$i->miscarage_date,
							'nondhani_date' => $_REQUEST['familypersondata']->$i->nondhani_date,
							'last_updated_date' => $last_updated_date,
							'janm_samay' => $_REQUEST['familypersondata']->$i->janm_samay,
							'janm_sthal' => $_REQUEST['familypersondata']->$i->janm_sthal,
							'janm_samaye_thayel_vajan_kilogram' => $_REQUEST['familypersondata']->$i->janm_samaye_thayel_vajan_kilogram,
							'janm_amaye_thayel_vajan_grams' => $_REQUEST['familypersondata']->$i->janm_amaye_thayel_vajan_grams,
							'dilevery_type' => $_REQUEST['familypersondata']->$i->dilevery_type,
						);
						//print_r($data_to_store);
						//if the insert has returned true then we show the flash message
						if($_REQUEST['familypersondata']->$i->edit_type==1)
						{
							$kutumb_person_id = $this->kutumb_model->store_kutumb_person($data_to_store);
							$from = new DateTime($_REQUEST['familypersondata']->$i->txtBirthDate);
							$to   = new DateTime('today');
							if($from->diff($to)->y <6)
							{
							
								$gender='';
								if($_REQUEST['familypersondata']->$i->drpGender==2)
									$gender='M';
								if($_REQUEST['familypersondata']->$i->drpGender==3)
									$gender='F';
								if($_REQUEST['familypersondata']->$i->drpGender==4)
									$gender='T';
								//if the insert has returned true then we show the flash message
		
								$data_to_send = "id=".$kutumb_person_id."&anganwadies_id=".$this->input->post('aanganvadiid')."&guj_first_name=".$_REQUEST['familypersondata']->$i->txtfname."&first_name=".$_REQUEST['familypersondata']->$i->txtfname."&guj_middle_name=".$_REQUEST['familypersondata']->$i->txtmname."&middle_name=".$_REQUEST['familypersondata']->$i->txtmname."&guj_last_name=".$_REQUEST['familypersondata']->$i->txtlname."&last_name=".$_REQUEST['familypersondata']->$i->txtlname."&sex=".$gender."&date_of_birth=".$_REQUEST['familypersondata']->$i->txtBirthDate."&parent_mobile=0&vaccinated=&vaccinated_date=&photo=&status=1";
								$this->common_model->save_curl_data($data_to_send,'addchildren.json');
							}
							
						if($_REQUEST['familypersondata']->$i->txtYear == 0 && $_REQUEST['familypersondata']->$i->txtMonth < 6 && $_REQUEST['familypersondata']->$i->janm_samay != '')
						{
							$this->savechildvaccine($_REQUEST['familypersondata']->$i,$kutumb_person_id);
						}
							if($_REQUEST['familypersondata']->$i->lmp_date != '')
							{
								$this->savevacine($_REQUEST['familypersondata']->$i,$kutumb_person_id);
								$data_to_store = array(
									'family_id' => $id,
									'family_person_id' => $kutumb_person_id,
									'lmp_date' => $_REQUEST['familypersondata']->$i->lmp_date,
									'miscarage_date' => $_REQUEST['familypersondata']->$i->miscarage_date,
									'nondhani_date' => $_REQUEST['familypersondata']->$i->nondhani_date,
									'last_updated_date' => $last_updated_date,					
								);
								$kutumb_sagrbha_person_id = $this->kutumb_model->store_sagrbha_kutumb_person($data_to_store);
							}
						}
						else if($_REQUEST['familypersondata']->$i->edit_type==2)
						{
						//print_r($_REQUEST['familypersondata']);
						//echo $_REQUEST['familypersondata']->$i->family_person_id;
							$familyMemberInfo = $this->kutumb_model->get_kutumb_person_by_id($_REQUEST['familypersondata']->$i->family_person_id);
							$lastLMPdate = $familyMemberInfo[0]['lmp_date'];
							
							$kutumb_person_id = $this->kutumb_model->update_kutumb_member($_REQUEST['familypersondata']->$i->family_person_id,$data_to_store);
							$from = new DateTime($_REQUEST['familypersondata']->$i->txtBirthDate);
							$to   = new DateTime('today');
							if($from->diff($to)->y <6)
							{
								$gender='';
								if($_REQUEST['familypersondata']->$i->drpGender==2)
									$gender='M';
								if($_REQUEST['familypersondata']->$i->drpGender==3)
									$gender='F';
								if($_REQUEST['familypersondata']->$i->drpGender==4)
									$gender='T';
	
								$data_to_send = "id=".$_REQUEST['familypersondata']->$i->family_person_id."&anganwadies_id=".$this->input->post('aanganvadiid')."&guj_first_name=".$_REQUEST['familypersondata']->$i->txtfname."&first_name=".$_REQUEST['familypersondata']->$i->txtfname."&guj_middle_name=".$_REQUEST['familypersondata']->$i->txtmname."&middle_name=".$_REQUEST['familypersondata']->$i->txtmname."&guj_last_name=".$_REQUEST['familypersondata']->$i->txtlname."&last_name=".$_REQUEST['familypersondata']->$i->txtlname."&sex=".$gender."&date_of_birth=".$_REQUEST['familypersondata']->$i->txtBirthDate."&parent_mobile=0&vaccinated=&vaccinated_date=&photo=&status=1";
								$this->common_model->save_curl_data($data_to_send,'editchildren.json');
							}
						
							if($lastLMPdate != $_REQUEST['familypersondata']->$i->lmp_date && $_REQUEST['familypersondata']->$i->lmp_date != '')
							{
								$this->savevacine($_REQUEST['familypersondata']->$i,$_REQUEST['familypersondata']->$i->family_person_id);
								$data_to_store = array(
									'family_id' => $id,
									'family_person_id' => $_REQUEST['familypersondata']->$i->family_person_id,
									'lmp_date' => $_REQUEST['familypersondata']->$i->lmp_date,
									'miscarage_date' => $_REQUEST['familypersondata']->$i->miscarage_date,
									'nondhani_date' => $_REQUEST['familypersondata']->$i->nondhani_date,
									'last_updated_date' => $last_updated_date,					
								);
								$kutumb_sagrbha_person_id = $this->kutumb_model->store_sagrbha_kutumb_person($data_to_store);
							}
						}
					}
					
                    $this->session->set_flashdata('flash_message', TRUE);
                }else{
                    $this->session->set_flashdata('flash_message', FALSE);
                }
                redirect('kutumb/update/'.$id.'');

            }//validation run

        }
		$castArray = $this->common_model->get_all_data('tbl_caste');
		$religionArray = $this->common_model->get_all_data('tbl_religion');
		$placeArray = $this->common_model->get_all_data('tbl_place');
		$relationArray = $this->common_model->get_all_data('tbl_relation');
		$genderArray = $this->common_model->get_all_data('tbl_gender');
		$maritalStatusArray = $this->common_model->get_all_data('tbl_maritalstatus');
		$targetCodeArray = $this->common_model->get_all_data('tbl_targetcode');
		$malformationTypeArray = $this->common_model->get_all_data('tbl_malformationtype');
		
		$data['castArray']=$castArray;

		$data['religionArray']=$religionArray;
		$data['placeArray']=$placeArray;
		$data['relationArray']=$relationArray;
		$data['genderArray']=$genderArray;
		$data['maritalStatusArray']=$maritalStatusArray;
		$data['targetCodeArray']=$targetCodeArray;
		$data['malformationTypeArray']=$malformationTypeArray;
        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
		$data['familydata'] = $this->kutumb_model->get_kutumb_by_id($id);
//		echo "<pre>";
//		print_r($data['familydata']);exit;
		$data['aanganvadi_id'] = $data['familydata'][0]['anganwadi_id'];
		//print_r($data['familydata']);
        //aanganvadi data 
        $data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi_by_id($id);
         //fetch jilla data to populate the select field
        $data['jilla'] = $this->jilla_model->get_jilla();
		//fetch taluka data to populate the select field
        $data['taluka'] = $this->taluka_model->get_taluka();
		//fetch gaam data to populate the select field
        $data['gaam'] = $this->gaam_model->get_gaam();
        //load the view
        $data['main_content'] = 'admin/kutumb/update';
        $this->load->view('includes/template', $data);            

    }//update
	public function savechildvaccine($memberdata,$kutumb_person_id)
	{
		$nondhani_date = $memberdata->nondhani_date;
		$nondhani_date_round1 = date('Y-m-d',strtotime($memberdata->nondhani_date.' +45 days')); // for polio 1, pentavalent 1
		$nondhani_date_round2 = date('Y-m-d',strtotime($nondhani_date_round1.' +28 days')); // for polio 2,Pentavalent - 2
		$nondhani_date_round3 = date('Y-m-d',strtotime($nondhani_date_round2.' +28 days')); // for polio 3,Pentavalent - 3
		$nondhani_date_270_days = date('Y-m-d',strtotime($memberdata->nondhani_date.' +270 days')); // for Ori - First Dose,Vitamin A - First Dose
		$nondhani_date_15_month = date('Y-m-d',strtotime($memberdata->nondhani_date.' +15 month')); // for Ori -Second Dose,Triguni Booster,Polio Booster
		$vitabmiA_after_4_month = date('Y-m-d',strtotime($nondhani_date_270_days.' +4 month')); 
		$nondhani_date_5_year = date('Y-m-d',strtotime($memberdata->nondhani_date.' +5 year')); // for Triguni Bijo Booster
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
							'due_date' => $memberdata->nondhani_date,
							'given_date' => $memberdata->nondhani_date,
							'given_status' => '1',					
							'created_at' => date('Y-m-d H:i:s'),					
						);
			$this->vacine_model->store_vacine($vacine_data);
			
			$get_vacine_data = $this->vacine_model->get_vacine_id_by_name('Dhanur Ni Rasi-2');
			$vacine_data = array(
							'vaccine_id' => $get_vacine_data[0]['id'],
							'member_id' => $kutumb_person_id,
							'vaccine_type' => '0',
							'due_date' => date('Y-m-d H:i:s',strtotime($memberdata->nondhani_date.'+28 days')),
							'given_date' => date('Y-m-d H:i:s',strtotime($memberdata->nondhani_date.'+28 days')),
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
							'due_date' => $memberdata->nondhani_date,
							'given_date' => $memberdata->nondhani_date,
							'given_status' => '1',					
							'created_at' => date('Y-m-d H:i:s'),					
						);
			$this->vacine_model->store_vacine($vacine_data);
		}
		//check if lmp date before end
	}
    /**
    * Delete aanganvadi by his id
    * @return void
    */
    public function delete()
    {
        //aanganvadi id 
        $id = $this->uri->segment(3);
        $this->kutumb_model->delete_kutumb($id);
        redirect('kutumb');
    }//edit
    function printpdf()
    {
            $id = $this->uri->segment(3);
        
        $castArray = $this->common_model->get_all_data('tbl_caste');
        $religionArray = $this->common_model->get_all_data('tbl_religion');
        $placeArray = $this->common_model->get_all_data('tbl_place');
        $relationArray = $this->common_model->get_all_data('tbl_relation');
        $genderArray = $this->common_model->get_all_data('tbl_gender');
        $maritalStatusArray = $this->common_model->get_all_data('tbl_maritalstatus');
        $targetCodeArray = $this->common_model->get_all_data('tbl_targetcode');
        $malformationTypeArray = $this->common_model->get_all_data('tbl_malformationtype');
        
        $data['castArray']=$castArray;
        $data['religionArray']=$religionArray;
        $data['placeArray']=$placeArray;
        $data['relationArray']=$relationArray;
        $data['genderArray']=$genderArray;
        $data['maritalStatusArray']=$maritalStatusArray;
        $data['targetCodeArray']=$targetCodeArray;
        $data['malformationTypeArray']=$malformationTypeArray;
        
        $data['kutumbDetail'] = $this->kutumb_model->get_kutumb_by_id($id);
        
        //$this->load->helper('file');
        //$this->load->helper(array('dompdf', 'file'));
        // page info here, db calls, etc.
        
        
        
        $html = $this->load->view('admin/kutumb/kutumbReport', $data,true);;
        echo $html;exit;
        //pdf_create($html, 'filename');
        //or
        //$data = pdf_create($html, 'file', true);
        //echo getcwd();
        //write_file('file.pdf', $data) or die('cant create file');
        //if you want to write it to disk and/or send it as an attachment
    }

}