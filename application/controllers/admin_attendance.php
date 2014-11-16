<?php
class Admin_attendance extends CI_Controller {
 
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

        //all the posts sent by the view
        $jilla_id = $this->input->post('jilla_id');
		$taluka_id = $this->input->post('taluka_id');
		$gaam_id = $this->input->post('gaam_id');
		$aanganwadiid_id = $this->input->post('aanganvadi_id');
		$date = $this->input->post('date');
		if($date != '')
		{
			$date = date('Y-m-d',strtotime($date));
			$data['date']=$date;
		}
		else
		{
			$data['date']='';
		}
		
		
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
        $config['base_url'] = base_url().'attendance/page';
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
				
			
	            $data['order'] = 'id';
			
            $data['count_attedence']= $this->attendance_model->count_attendance($aanganwadiid_id, '', '',$date);
			
            $data['attedence'] = $this->attendance_model->get_attendance($aanganwadiid_id, '', '', $order_type, $config['per_page'],$limit_end,$date);        
            $config['total_rows'] = $data['count_attedence'];

        //!isset($manufacture_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config);   
        
        //load the view
        $data['main_content'] = 'admin/attedence/list';
        $this->load->view('includes/template', $data);  

    }//index
	public function showattendence()
	{
		$idsarray=$_REQUEST['id'];
		$error='';

		$allAttendence=$this->attendance_model->get_attendance_by_id($_REQUEST['id']);
		$html='';
		if(count($allAttendence) > 0)
		{
			$attendance = json_decode($allAttendence[0]['attendance']);
			
			for($i=0;$i<count($attendance);$i++)
			{
				$person = $this->kutumb_model->get_kutumb_person_by_id($attendance[$i]->user_id);
				//echo "<pre>";
				//print_r($person);
				//echo "</pre>";
				if(!empty($person))
				{
					$html .= '<tr><td class="red header">'.$person[0]['family_person_id'].'</td>';
					$html .= '<td class="red header">'.$person[0]['first_name'].' '.$person[0]['middle_name'].' '.$person[0]['last_name'].'</td>';
					$html .= '<td class="red header">'.$person[0]['uid_aadharnumber'].'</td>';
					$html .= '<td class="red header">'.$attendance[$i]->present.'</td></tr>';
				}
				//print_r($person);
			}
			
		}

		
		echo $html;exit;
		
	}	
}