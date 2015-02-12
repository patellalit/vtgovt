<?php
class Admin_vaccine extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vacine_model');        
		$this->load->model('kutumb_model');
        $this->load->model('aanganvadi_model');
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
		$data['perpage'] = $perPage;
        //all the posts sent by the view
		$vaccine_id = $this->input->get('vaccine_id');
		$perpagePost = $this->input->get('perpage');
        $aanganvadi_id = $this->input->get('aanganvadi_id');
        $vaccine_type = $this->input->get('vaccine_type');
        $data['vaccine_type'] = $vaccine_type;
        
		if($perpagePost != '')
		{
			$perPage = $perpagePost;
		}
		$data['perpage'] = $perPage;
		$currentpagePost = $this->input->get('currentpage');
		
        $search = $this->input->get('searchtxt');
		if($search != '')
		{		
			if(DateTime::createFromFormat('Y/m/d', $search) !== FALSE)
			{
				$search = date('Y-m-d',strtotime($search));
			}	
			$data['searchtxt']=$search;
		}
		else
		{
			$data['searchtxt']='';
		}
		
		       
        $order = $this->input->get('order'); 
		if($order == '')
			$order="id";
        $order_type = $this->input->get('order_type'); 

        //pagination settings
        $config['per_page'] = $perPage;
        $config['base_url'] = base_url().'vaccine/page?'.http_build_query($_GET);
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
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
		$order='id';
        
		$filter_session_data['order'] = null;
		$filter_session_data['order_type'] = null;
		$this->session->set_userdata($filter_session_data);
		if($aanganvadi_id!='')
        {
            $data['aanganvadi_selected'] = $aanganvadi_id;
            
        }
        else
            $data['aanganvadi_selected'] = 0;
        
        
		if($vaccine_id !== false){
            if($vaccine_id !== 0){
                $filter_session_data['vaccine_selected'] = $vaccine_id;
            }else{
                $vaccine_id = $this->session->userdata('vaccine_selected');
            }
            $data['vaccine_selected'] = $vaccine_id;
			
			if($search){
                $filter_session_data['search_string_selected'] = $search;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;
			
			$data['count_vaccine']= $this->vacine_model->count_vaccine($aanganvadi_id,$vaccine_id,$search,$vaccine_type);
			$data['vaccine'] = $this->vacine_model->get_vaccine($aanganvadi_id,$vaccine_id,$search,$vaccine_type, '', $order_type, $config['per_page'],$limit_end);
			
		}
		else
		{
			$data['vaccine_selected'] = $vaccine_id;
			//pre selected options
			$data['search_string_selected'] = '';
			$data['order'] = 'id';
			
			$data['count_vaccine']= $this->vacine_model->count_vaccine($aanganvadi_id,'',$search,$vaccine_type);
			$data['vaccine'] = $this->vacine_model->get_vaccine($aanganvadi_id,'',$search,$vaccine_type, '', $order_type, $config['per_page'],$limit_end);
		}
        
        $data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi('','','','','','Asc','','');
        //print_r($data['aanganvadi']);exit;
		$data['allvaccine'] = $this->vacine_model->get_all_vacine_name();  			
		$config['total_rows'] = $data['count_vaccine'];
        //initializate the panination helper 
        $this->pagination->initialize($config);   
        //load the view
        $data['main_content'] = 'admin/vaccine/list';
        $this->load->view('includes/template', $data);  

    }//index
}