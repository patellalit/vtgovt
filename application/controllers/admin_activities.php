<?php
class Admin_activities extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('activities_model');        
		$this->load->model('agegroup_model');
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
		$agegroup_id = $this->input->get('agegroup_id');
        $perpagePost = $this->input->get('perpage');
		if($perpagePost != '')
		{
			$perPage = $perpagePost;
		}
		$data['perpage'] = $perPage;
		$currentpagePost = $this->input->get('currentpage');
		
        $search = $this->input->get('search');
		if($search != '')
		{			
			$data['search']=$search;
		}
		else
		{
			$data['search']='';
		}
		
		       
        $order = $this->input->get('order'); 
		if($order == '')
			$order="id";
        $order_type = $this->input->get('order_type'); 

        //pagination settings
        $config['per_page'] = $perPage;
        $config['base_url'] = base_url().'activities/page?'.http_build_query($_GET);
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
		
		if($agegroup_id !== false){ 
            if($agegroup_id !== 0){
                $filter_session_data['agegroup_selected'] = $agegroup_id;
            }else{
                $agegroup_id = $this->session->userdata('agegroup_selected');
            }
            $data['agegroup_selected'] = $agegroup_id;
			
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
			
			$data['count_activities']= $this->activities_model->count_activities($agegroup_id,$search);
			$data['activities'] = $this->activities_model->get_activities($agegroup_id,$search, '', $order_type, $config['per_page'],$limit_end);  
		}
		else
		{
			$data['agegroup_selected'] = $agegroup_id;
			//pre selected options
			$data['search_string_selected'] = '';
			$data['order'] = 'id';
			
			$data['count_activities']= $this->activities_model->count_activities('',$search);
			$data['activities'] = $this->activities_model->get_activities('',$search, '', $order_type, $config['per_page'],$limit_end);  
		}
		      
		$config['total_rows'] = $data['count_activities'];
		//fetch manufacturers data into arrays
        $data['agegroup'] = $this->agegroup_model->get_agegroup();
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/activities/list';
        $this->load->view('includes/template', $data);  

    }//index
	public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
		    //form validation
			$this->form_validation->set_rules('agegroup_id', 'agegroup_id', 'required');
            $this->form_validation->set_rules('activities_name', 'activities_name', 'required');

			
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
					'agegroup_id' => $this->input->post('agegroup_id'),
                    'name' => $this->input->post('activities_name'),
					'status' => '1',
					'created_at' => date('Y-m-d H:i:s')
                );
                //if the insert has returned true then we show the flash message
                if($this->activities_model->store_activities($data_to_store)){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
		//fetch agegroup data to populate the select field
        $data['agegroup'] = $this->agegroup_model->get_agegroup();
		//load the view
        $data['main_content'] = 'admin/activities/add';
        $this->load->view('includes/template', $data);  //echo "lsdfhads";exit;
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
			$this->form_validation->set_rules('agegroup_id', 'agegroup_id', 'required');
            $this->form_validation->set_rules('activities_name', 'activities_name', 'required');

			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
					'agegroup_id' => $this->input->post('agegroup_id'),
                    'name' => $this->input->post('activities_name'),

                );
                //if the insert has returned true then we show the flash message
                if($this->activities_model->update_activities($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('activities/update/'.$id.'');

            }//validation run

        }
		//fetch agegroup data to populate the select field
        $data['agegroup'] = $this->agegroup_model->get_agegroup();
        //aanganvadi data 
        $data['activities'] = $this->activities_model->get_activities_by_id($id);
        //load the view
        $data['main_content'] = 'admin/activities/edit';
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
        $this->activities_model->delete_activities($id);
        redirect('activities');
    }//edit

}