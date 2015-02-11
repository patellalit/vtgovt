<?php
class Admin_gaam extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('gaam_model');        
		$this->load->model('jilla_model');        
		$this->load->model('taluka_model'); 
		$this->load->model('common_model');
        if(!$this->session->userdata('is_logged_in')){
            redirect(site_url());exit;
        }
    }
	public function remaininggamm()
    {
		$ourvillages = $this->gaam_model->get_all_gam_id();
		$str='';
		for($i=0;$i<count($ourvillages);$i++)
		{
			if($str!='')
				$str.=',';
				
			$str.=$ourvillages[$i]['id'];
		}
		echo $str;
		//print_r($ourvillages);exit;
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
		$jilla_id = $this->input->get('jilla_id');
		$taluka_id = $this->input->get('taluka_id');
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
        $config['base_url'] = base_url().'gaam/page?'.http_build_query($_GET);
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
		
		if($jilla_id !== false && $taluka_id !== false){ 
            if($jilla_id !== 0){
                $filter_session_data['jilla_selected'] = $jilla_id;
            }else{
                $jilla_id = $this->session->userdata('jilla_selected');
            }
            $data['jilla_selected'] = $jilla_id;
			
			if($taluka_id !== 0){
                $filter_session_data['taluka_selected'] = $taluka_id;
            }else{
                $taluka_id = $this->session->userdata('taluka_selected');
            }
            $data['taluka_selected'] = $taluka_id;
			
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
			
			$data['count_gaam']= $this->gaam_model->count_gaam($taluka_id,$search);
			$data['gaam'] = $this->gaam_model->get_gaam($taluka_id,$search, '', $order_type, $config['per_page'],$limit_end);  
			
			//fetch manufacturers data into arrays
			$data['jilla'] = $this->jilla_model->get_jilla();
			
			//fetch manufacturers data into arrays
			$data['taluka'] = $this->taluka_model->get_taluka($jilla_id);
		}
		else
		{
			$data['jilla_selected'] = $jilla_id;
			$data['taluka_selected'] = $jilla_id;
			//pre selected options
			$data['search_string_selected'] = '';
			$data['order'] = 'id';
			
			$data['count_gaam']= $this->gaam_model->count_gaam('',$search);
			$data['gaam'] = $this->gaam_model->get_gaam('',$search, '', $order_type, $config['per_page'],$limit_end);  
			
			//fetch manufacturers data into arrays
			$data['jilla'] = $this->jilla_model->get_jilla();
			
			//fetch manufacturers data into arrays
			$data['taluka'] = array();
		}
		      
		$config['total_rows'] = $data['count_gaam'];
		
		
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/gaam/list';
        $this->load->view('includes/template', $data);  

    }//index
	public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
		    //form validation
			$this->form_validation->set_rules('jilla_id', 'jilla_id', 'required');
            $this->form_validation->set_rules('gaam_name', 'gaam_name', 'required');
			$this->form_validation->set_rules('gaam_name_guj', 'gaam_name_guj', 'required');
			
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                if(!$this->gaam_model->is_gaam_exists($this->input->post('gaam_name_guj'),$this->input->post('taluka_id'),0))
                {
                    $data_to_store = array(
                        'taluka_id' => $this->input->post('taluka_id'),
                        'name' => $this->input->post('gaam_name'),
                        'name_guj' => $this->input->post('gaam_name_guj'),
                        'is_active' => '0',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    //if the insert has returned true then we show the flash message
                    $gaamid = $this->gaam_model->store_gaam($data_to_store);
                }
                else
                    $gaamid=0;
                
                if($gaamid){
					$data_to_send = "id=".$gaamid."&talukas_id=".$this->input->post('taluka_id')."&guj_village_name=".$this->input->post('gaam_name_guj')."&village_name=".$this->input->post('gaam_name')."&status=1";
					$this->common_model->save_curl_data($data_to_send,'addvillage.json');
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
		//fetch jilla data to populate the select field
        $data['jilla'] = $this->jilla_model->get_jilla();
		
		$data['taluka'] = array();
		//load the view
        $data['main_content'] = 'admin/gaam/add';
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
			$this->form_validation->set_rules('jilla_id', 'jilla_id', 'required');
            $this->form_validation->set_rules('gaam_name', 'gaam_name', 'required');
			$this->form_validation->set_rules('gaam_name_guj', 'gaam_name_guj', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
					'taluka_id' => $this->input->post('taluka_id'),
                    'name' => $this->input->post('gaam_name'),
					'name_guj' => $this->input->post('gaam_name_guj'),
                );
                //if the insert has returned true then we show the flash message
                if($this->gaam_model->update_gaam($id, $data_to_store) == TRUE){
					$data_to_send = "id=".$id."&talukas_id=".$this->input->post('taluka_id')."&guj_village_name=".$this->input->post('gaam_name_guj')."&village_name=".$this->input->post('gaam_name')."&status=1";
					$this->common_model->save_curl_data($data_to_send,'editvillage.json');
					
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('gaam/update/'.$id.'');

            }//validation run

        }
		$data['gaam'] = $this->gaam_model->get_gaam_by_id($id);
		//fetch jilla data to populate the select field
        $data['jilla'] = $this->jilla_model->get_jilla();
		
//print_r($data['gaam']);
		$data['taluka'] =$this->taluka_model->get_taluka($data['gaam'][0]['jilla_id']);
        //aanganvadi data 
        
        //load the view
        $data['main_content'] = 'admin/gaam/edit';
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
        $this->gaam_model->delete_gaam($id);
		$data_to_send = "id=".$id;
		$this->common_model->save_curl_data($data_to_send,'deletevillage.json');
        redirect('gaam');
    }//edit

}