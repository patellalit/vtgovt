<?php
class Admin_aanganvadi extends CI_Controller {
 
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
        $jilla_id = $this->input->get('jilla_id');
		$taluka_id = $this->input->get('taluka_id');
		$gaam_id = $this->input->get('gaam_id');
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
        $config['base_url'] = base_url().'aanganvadi/page?'.http_build_query($_GET);
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
$order='id';
        //filtered && || paginated
//        if($jilla_id !== false && $taluka_id !== false && $gaam_id !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
        if($jilla_id !== false && $taluka_id !== false && $gaam_id !== false){ 
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */

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
			
			if($gaam_id !== 0){
                $filter_session_data['gaam_selected'] = $gaam_id;
            }else{
                $gaam_id = $this->session->userdata('gaam_selected');
            }
            $data['gaam_selected'] = $gaam_id;

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

            //save session data into the session
            $this->session->set_userdata($filter_session_data);

            //fetch manufacturers data into arrays
            $data['jilla'] = $this->jilla_model->get_jilla();
			
			//fetch manufacturers data into arrays
            $data['taluka'] = $this->taluka_model->get_taluka($jilla_id);;

			//fetch manufacturers data into arrays
            $data['gaam'] = $this->gaam_model->get_gaam($taluka_id);

            $data['count_aanganvadi']= $this->aanganvadi_model->count_aanganvadi($jilla_id,$taluka_id,$gaam_id, '', '');
            $config['total_rows'] = $data['count_aanganvadi'];

            //fetch sql data into arrays
            if($search){
                if($order){
                    $data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi($jilla_id,$taluka_id,$gaam_id, $search, '', $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi($jilla_id,$taluka_id,$gaam_id,  $search, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi($jilla_id,$taluka_id,$gaam_id, '', '', $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi($jilla_id,$taluka_id,$gaam_id, '', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

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
            $data['jilla_selected'] = 0;
			$data['taluka_selected'] = 0;
			$data['gaam_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['jilla'] = $this->jilla_model->get_jilla();
			$data['taluka'] = array();//$this->taluka_model->get_taluka();
			$data['gaam'] = array();//$this->gaam_model->get_gaam();
			
            $data['count_aanganvadi']= $this->aanganvadi_model->count_aanganvadi($search);
            $data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi('','','',$search, '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_aanganvadi'];

        }//!isset($manufacture_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/aanganvadi/list';
        $this->load->view('includes/template', $data);  

    }//index
	public function fetchTaluko()
	{
		//echo $_REQUEST['jilloid'];exit;
		if($_REQUEST['jilloid'] != "")
			$data = $this->taluka_model->get_taluka($_REQUEST['jilloid']);
		else
			$data = array();
		
		$html='<option selected="selected" value="">Select</option>';
		for($i=0;$i<count($data);$i++)
		{
			$html .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name_guj'].'</option>';
		}
		echo $html;exit;
		//print_r($data);exit;
	}
	public function fetchGaam()
	{
		//echo $_REQUEST['jilloid'];exit;
		if($_REQUEST['gaam_id'] != "")
			$data = $this->gaam_model->get_gaam($_REQUEST['gaam_id']);
		else
			$data = array();
		
		$html='<option selected="selected" value="">Select</option>';
		for($i=0;$i<count($data);$i++)
		{
			$html .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name_guj'].'</option>';
		}
		echo $html;exit;
		//print_r($data);exit;
	}
	public function fetchAanganvadi()
	{
		//echo $_REQUEST['jilloid'];exit;
		if($_REQUEST['aanganvadi_id'] != "")
			$data = $this->aanganvadi_model->get_aanganvadi('','',$_REQUEST['aanganvadi_id'],'','','Asc','','');
		else
			$data = array();
		
		$html='<option selected="selected" value="">Select</option>';
		for($i=0;$i<count($data);$i++)
		{
			$html .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['aanganvadi_name'].'</option>';
		}
		echo $html;exit;
		//print_r($data);exit;
	}
    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('jilla_id', 'jilla_id', 'required');
			$this->form_validation->set_rules('taluka_id', 'taluka_id', 'required');
			$this->form_validation->set_rules('gaam_id', 'gaam_id', 'required');
			$this->form_validation->set_rules('aanganvadi_name', 'aanganvadi_name', 'required');
            $this->form_validation->set_rules('aanganvadi_number', 'aanganvadi_number', 'required');
            $this->form_validation->set_rules('place', 'place', 'required');
            $this->form_validation->set_rules('address', 'address', 'required');
            $this->form_validation->set_rules('karyakar_name', 'karyakar_name', 'required');
			$this->form_validation->set_rules('karyakar_number', 'karyakar_number', 'required');
			$this->form_validation->set_rules('tedagara_name', 'tedagara_name', 'required');
			$this->form_validation->set_rules('tedagara_number', 'tedagara_number', 'required');
			$this->form_validation->set_rules('password', 'password', 'required');
			
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'jilla_id' => $this->input->post('jilla_id'),
					'taluka_id' => $this->input->post('taluka_id'),
					'gaam_id' => $this->input->post('gaam_id'),
					'aanganvadi_name' => $this->input->post('aanganvadi_name'),
                    'aanganvadi_number' => $this->input->post('aanganvadi_number'),
                    'place' => $this->input->post('place'),
                    'address' => $this->input->post('address'),          
                    'karyakar_name' => $this->input->post('karyakar_name'),
					'karyakar_number' => $this->input->post('karyakar_number'),          
					'tedagara_name' => $this->input->post('tedagara_name'),          
					'tedagara_number' => $this->input->post('tedagara_number'),
					'password' => $this->input->post('password')       
                );
				$aanganwadiid=$this->aanganvadi_model->store_aanganvadi($data_to_store);
                //if the insert has returned true then we show the flash message
                if($aanganwadiid){
					$data_to_send = "id=".$aanganwadiid."&villages_id=".$this->input->post('gaam_id')."&guj_anganwadi_name=".$this->input->post('aanganvadi_name')."&anganwadi_name=".$this->input->post('aanganvadi_name')."&anganwadi_code=".$this->input->post('aanganvadi_number')."&guj_worker_name=".$this->input->post('karyakar_name')."&worker_name=".$this->input->post('karyakar_name')."&worker_mobile=".$this->input->post('karyakar_number')."&guj_helper_name=".$this->input->post('tedagara_name')."&helper_name=".$this->input->post('tedagara_name')."&helper_mobile=".$this->input->post('tedagara_number')."&status=1";
					$this->common_model->save_curl_data($data_to_send,'addanganwadi.json');
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
		
		
        //fetch jilla data to populate the select field
        $data['jilla'] = $this->jilla_model->get_jilla();
		//fetch taluka data to populate the select field
        $data['taluka'] = array();//$this->taluka_model->get_taluka();
		//fetch gaam data to populate the select field
        $data['gaam'] = array();//$this->gaam_model->get_gaam();

        //load the view
        $data['main_content'] = 'admin/aanganvadi/add';
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
			$this->form_validation->set_rules('taluka_id', 'taluka_id', 'required');
			$this->form_validation->set_rules('gaam_id', 'gaam_id', 'required');
			$this->form_validation->set_rules('aanganvadi_name', 'aanganvadi_name', 'required');
            $this->form_validation->set_rules('aanganvadi_number', 'aanganvadi_number', 'required');
            $this->form_validation->set_rules('place', 'place', 'required');
            $this->form_validation->set_rules('address', 'address', 'required');
            $this->form_validation->set_rules('karyakar_name', 'karyakar_name', 'required');
			$this->form_validation->set_rules('karyakar_number', 'karyakar_number', 'required');
			$this->form_validation->set_rules('tedagara_name', 'tedagara_name', 'required');
			$this->form_validation->set_rules('tedagara_number', 'tedagara_number', 'required');
			$this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
                    'jilla_id' => $this->input->post('jilla_id'),
					'taluka_id' => $this->input->post('taluka_id'),
					'gaam_id' => $this->input->post('gaam_id'),
					'aanganvadi_name' => $this->input->post('aanganvadi_name'),
                    'aanganvadi_number' => $this->input->post('aanganvadi_number'),
                    'place' => $this->input->post('place'),
                    'address' => $this->input->post('address'),          
                    'karyakar_name' => $this->input->post('karyakar_name'),
					'karyakar_number' => $this->input->post('karyakar_number'),          
					'tedagara_name' => $this->input->post('tedagara_name'),          
					'tedagara_number' => $this->input->post('tedagara_number'),
					'password' => $this->input->post('password')          
                );
                //if the insert has returned true then we show the flash message
                if($this->aanganvadi_model->update_aanganvadi($id, $data_to_store) == TRUE){
					$data_to_send = "id=".$id."&villages_id=".$this->input->post('gaam_id')."&guj_anganwadi_name=".$this->input->post('aanganvadi_name')."&anganwadi_name=".$this->input->post('aanganvadi_name')."&anganwadi_code=".$this->input->post('aanganvadi_number')."&guj_worker_name=".$this->input->post('karyakar_name')."&worker_name=".$this->input->post('karyakar_name')."&worker_mobile=".$this->input->post('karyakar_number')."&guj_helper_name=".$this->input->post('tedagara_name')."&helper_name=".$this->input->post('tedagara_name')."&helper_mobile=".$this->input->post('tedagara_number')."&status=1";
					$this->common_model->save_curl_data($data_to_send,'editanganwadi.json');
					
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('aanganvadi/update/'.$id.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //aanganvadi data 
        $data['aanganvadi'] = $this->aanganvadi_model->get_aanganvadi_by_id($id);
         //fetch jilla data to populate the select field
        $data['jilla'] = $this->jilla_model->get_jilla();
		//fetch taluka data to populate the select field
        $data['taluka'] = $this->taluka_model->get_taluka();
		//fetch gaam data to populate the select field
        $data['gaam'] = $this->gaam_model->get_gaam();
        //load the view
        $data['main_content'] = 'admin/aanganvadi/edit';
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
        $this->aanganvadi_model->delete_aanganvadi($id);
		$data_to_send = "id=".$id;
		$this->common_model->save_curl_data($data_to_send,'deleteanganwadi.json');
					
        redirect('aanganvadi');
    }//edit

}