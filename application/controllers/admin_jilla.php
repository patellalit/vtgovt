<?php
class Admin_jilla extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jilla_model');        
		$this->load->model('common_model');
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
        $config['base_url'] = base_url().'jilla/page?'.http_build_query($_GET);
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

		$data['count_jilla']= $this->jilla_model->count_jilla($search);
		$data['jilla'] = $this->jilla_model->get_jilla($search, '', $order_type, $config['per_page'],$limit_end);        
		$config['total_rows'] = $data['count_jilla'];
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/jilla/list';
        $this->load->view('includes/template', $data);  

    }//index
	public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
		    //form validation
            $this->form_validation->set_rules('jilla_name', 'jilla_name', 'required');
			$this->form_validation->set_rules('jilla_name_guj', 'jilla_name_guj', 'required');
			
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                if(!$this->jilla_model->is_jillo_exists($this->input->post('jilla_name_guj')))
                {
                    $data_to_store = array(
                        'name' => $this->input->post('jilla_name'),
                        'name_guj' => $this->input->post('jilla_name_guj'),
                        'is_active' => '1',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $jilla_id=$this->jilla_model->store_jilla($data_to_store);
                }
                else
                    $jilla_id=0;
                //if the insert has returned true then we show the flash message
                if($jilla_id){
					$data_to_send = "id=".$jilla_id."&guj_district_name=".$this->input->post('jilla_name_guj')."&district_name=".$this->input->post('jilla_name')."&status=1";
					$this->common_model->save_curl_data($data_to_send,'adddistrict.json');
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
		//load the view
        $data['main_content'] = 'admin/jilla/add';
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
            $this->form_validation->set_rules('jilla_name', 'jilla_name', 'required');
			$this->form_validation->set_rules('jilla_name_guj', 'jilla_name_guj', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
                    'name' => $this->input->post('jilla_name'),
					'name_guj' => $this->input->post('jilla_name_guj'),
                );
                //if the insert has returned true then we show the flash message
                if($this->jilla_model->update_jilla($id, $data_to_store) == TRUE){
					$data_to_send = "id=".$id."&guj_district_name=".$this->input->post('jilla_name_guj')."&district_name=".$this->input->post('jilla_name')."&status=1";
					$this->common_model->save_curl_data($data_to_send,'editdistrict.json');
					
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('jilla/update/'.$id.'');

            }//validation run

        }
        //aanganvadi data 
        $data['jilla'] = $this->jilla_model->get_jilla_by_id($id);
        //load the view
        $data['main_content'] = 'admin/jilla/edit';
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
        $this->jilla_model->delete_jilla($id);
		$data_to_send = "id=".$id;
		$this->common_model->save_curl_data($data_to_send,'deletedistrict.json');
        redirect('jilla');
    }//edit

}