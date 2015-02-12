<?php
class Admin_holidays extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('holidays_model');
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
			if(DateTime::createFromFormat('Y/m/d', $search) !== FALSE)
			{
				$search = date('Y-m-d',strtotime($search));
			}	
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
        $config['base_url'] = base_url().'holidays/page?'.http_build_query($_GET);
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

		//pre selected options
		$data['search_string_selected'] = '';
		$data['order'] = 'id';

		$data['count_holidays']= $this->holidays_model->count_holidays($search);
		$data['holidays'] = $this->holidays_model->get_holidays($search, '', $order_type, $config['per_page'],$limit_end);        
		$config['total_rows'] = $data['count_holidays'];
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/holidays/list';
        $this->load->view('includes/template', $data);  

    }//index
	public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
		    //form validation
            $this->form_validation->set_rules('holiday_name', 'holidays_name', 'required');
			$this->form_validation->set_rules('holiday_date', 'holidays_date', 'required');
			
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
			
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				$isholiday = $this->holidays_model->if_holiday_exists($this->input->get('holiday_name'),date('Y-m-d',strtotime($this->input->post('holiday_date'))),0);
				if(empty($isholiday))
				{
					$data_to_store = array(
						'holiday_name' => $this->input->post('holiday_name'),
						'holiday_date' => $this->input->post('holiday_date'),
					);
					$holidays_id=$this->holidays_model->store_holidays($data_to_store);
					//if the insert has returned true then we show the flash message
					if($holidays_id){
						$data['flash_message'] = TRUE; 
					}else{
						$data['flash_message'] = FALSE; 
					}
				}
				else
				{
					$data['flash_message'] = FALSE; 
				}
            }

        }
		//load the view
        $data['main_content'] = 'admin/holidays/add';
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
            $this->form_validation->set_rules('holiday_name', 'holiday_name', 'required');
			$this->form_validation->set_rules('holiday_date', 'holiday_date', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    			$isholiday = $this->holidays_model->if_holiday_exists($this->input->post('holiday_name'),date('Y-m-d',strtotime($this->input->post('holiday_date'))),$id);
				if(empty($isholiday))
				{
					$data_to_store = array(
						'holiday_name' => $this->input->post('holiday_name'),
						'holiday_date' => $this->input->post('holiday_date'),
					);
					//if the insert has returned true then we show the flash message
					if($this->holidays_model->update_holidays($id, $data_to_store) == TRUE){
						$this->session->set_flashdata('flash_message', 'updated');

					}else{
						$this->session->set_flashdata('flash_message', 'not_updated');

					}
				}
				else
				{
					$this->session->set_flashdata('flash_message', 'not_updated');
				}
				
                redirect('holidays/update/'.$id.'');

            }//validation run

        }
        //aanganvadi data 
        $data['holidays'] = $this->holidays_model->get_holidays_by_id($id);
        //load the view
        $data['main_content'] = 'admin/holidays/edit';
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
        $this->holidays_model->delete_holidays($id);
        redirect('holidays');
    }//edit

}