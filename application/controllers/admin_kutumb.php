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
		$this->lang->load('messages','gujarati');
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
        $jilla_id = $this->input->post('jilla_id');
		$taluka_id = $this->input->post('taluka_id');
		$gaam_id = $this->input->post('gaam_id');
		$aanganwadiid_id = $this->input->post('aanganvadi_id');
		$searchtxt = $this->input->post('searchtxt');
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
        $config['per_page'] = 20;
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

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        } 

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
				
			if($aanganwadiid_id != '' || $aanganwadiid_id != 0)
				$data['aanganwadiid_selected'] = $aanganwadiid_id;
			else
				$data['aanganwadiid_selected'] = 0;
				
			
	            $data['order'] = 'family_rank';
			
            $data['count_kutumb']= $this->kutumb_model->count_kutumb('','','',$aanganwadiid_id,$searchtxt,'','','','');
			
            $data['kutumb'] = $this->kutumb_model->get_kutumb('','','',$aanganwadiid_id, $searchtxt, '', $order_type, $config['per_page'],$limit_end);        
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
			/*for($i=1;$i<count($idsarray);$i++)
			{
				$count=$this->kutumb_model->checkiffamilymemberrankexists($idsarray[$i],$_REQUEST['aanganwadi_id'],$familyid);
				if($count!=0)
				{
					if($str=='')
						$str.=$idsarray[$i];
					else
						$str.=','.$idsarray[$i];						
				}				
			}*/
			//if($str!='')
				//$error.='Family person rank '.$str.' is already in used.';
				
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
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
$_REQUEST['id'] = $this->input->post('aanganvadiid');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				
                $data_to_store = array(
                    'anganwadi_id' => $this->input->post('aanganvadiid'),
					'family_rank' => $this->input->post('kutumb_krm_no'),
					'jati_id' => $this->input->post('jati'),
					'dharm_id' => $this->input->post('dharm'),
                    'sthal_id' => $this->input->post('sthal'),
                    'sthal_value' => $this->input->post('sthallocation'),
                    'laghumati' => $this->input->post('isLagumati'),
                );
				
                //if the insert has returned true then we show the flash message
				$kutumbid = $this->kutumb_model->store_kutumb($data_to_store);
                $_REQUEST['familypersondata'] = json_decode($_REQUEST['familypersoninfo']);
				
				//echo "<pre>";
				//print_r($_REQUEST['familypersondata']);
				if($kutumbid!=0)
				{//echo "count--".count($_REQUEST['familypersondata']);
					for($i=0;$i<count((array)$_REQUEST['familypersondata']);$i++)
					{
					
						if($_REQUEST['familypersondata']->$i->txtDeathDate != '')
							$_REQUEST['familypersondata']->$i->txtDeathDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtDeathDate));
						
						if($_REQUEST['familypersondata']->$i->txtOutSthadantrarDate != '')
							$_REQUEST['familypersondata']->$i->txtOutSthadantrarDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtOutSthadantrarDate));
						
						if($_REQUEST['familypersondata']->$i->txtsthantarDate != '')
							$_REQUEST['familypersondata']->$i->txtsthantarDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtsthantarDate));
						
						if($_REQUEST['familypersondata']->$i->txtBirthDate != '')
							$_REQUEST['familypersondata']->$i->txtBirthDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtBirthDate));
				
				
				
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
							'purv_prathmik_shikshan' => $_REQUEST['familypersondata']->$i->chkPrathmikEducation
						);
						//print_r($data_to_store);
						//if the insert has returned true then we show the flash message
						$kutumb_person_id = $this->kutumb_model->store_kutumb_person($data_to_store);
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
           //form validation
            $this->form_validation->set_rules('aanganvadiid', 'aanganvadiid', 'required');
			$this->form_validation->set_rules('kutumb_krm_no', 'kutumb_krm_no', 'required');
			$this->form_validation->set_rules('jati', 'jati', 'required');
			$this->form_validation->set_rules('dharm', 'dharm', 'required');
            $this->form_validation->set_rules('sthal', 'sthal', 'required|numeric');
            $this->form_validation->set_rules('sthallocation', 'sthallocation', 'required');
            $this->form_validation->set_rules('isLagumati', 'isLagumati', 'required');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                 $data_to_store = array(
                    'anganwadi_id' => $this->input->post('aanganvadiid'),
					'family_rank' => $this->input->post('kutumb_krm_no'),
					'jati_id' => $this->input->post('jati'),
					'dharm_id' => $this->input->post('dharm'),
                    'sthal_id' => $this->input->post('sthal'),
                    'sthal_value' => $this->input->post('sthallocation'),
                    'laghumati' => $this->input->post('isLagumati'),
                );
				
                //if the insert has returned true then we show the flash message
                if($this->kutumb_model->update_kutumb($id, $data_to_store) == TRUE){
				
					$this->kutumb_model->delete_kutumb_person($id);
					$_REQUEST['familypersondata'] = json_decode($_REQUEST['familypersoninfo']);
					
					for($i=0;$i<count((array)$_REQUEST['familypersondata']);$i++)
					{					
						if($_REQUEST['familypersondata']->$i->txtDeathDate != '')
							$_REQUEST['familypersondata']->$i->txtDeathDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtDeathDate));
						
						if($_REQUEST['familypersondata']->$i->txtOutSthadantrarDate != '')
							$_REQUEST['familypersondata']->$i->txtOutSthadantrarDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtOutSthadantrarDate));
						
						if($_REQUEST['familypersondata']->$i->txtsthantarDate != '')
							$_REQUEST['familypersondata']->$i->txtsthantarDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtsthantarDate));
						
						if($_REQUEST['familypersondata']->$i->txtBirthDate != '')
							$_REQUEST['familypersondata']->$i->txtBirthDate = date('Y-m-d',strtotime($_REQUEST['familypersondata']->$i->txtBirthDate));
				
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
							'purv_prathmik_shikshan' => $_REQUEST['familypersondata']->$i->chkPrathmikEducation
						);
						//print_r($data_to_store);
						//if the insert has returned true then we show the flash message
						$kutumb_person_id = $this->kutumb_model->store_kutumb_person($data_to_store);
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

}