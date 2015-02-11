<?php
class Admin_item_stock extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_model');        
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
        $perpagePost = $this->input->get('perpage');
		if($perpagePost != '')
		{
			$perPage = $perpagePost;
		}
		$data['perpage'] = $perPage;
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $data['month']=$month;
        $data['year']=$year;
        
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
        $config['base_url'] = base_url().'item_stock/page?'.http_build_query($_GET);
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

		$data['count_item_stock']= $this->item_model->count_item_stock($search,$month,$year);
		$data['item'] = $this->item_model->get_item_stock($search,$month,$year, '', $order_type, $config['per_page'],$limit_end);
		$config['total_rows'] = $data['count_item_stock'];
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/item_stock/list';
        $this->load->view('includes/template', $data);  

    }//index
	public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
		    //form validation
			$this->form_validation->set_rules('item_id', 'item_id', 'required');
			$this->form_validation->set_rules('aanganwadi_id', 'aanganwadi_id', 'required');
            $this->form_validation->set_rules('stock', 'stock', 'required');
			
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
			
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {								
				$data_to_store = array(
					'item_id' => $this->input->post('item_id'),
					'aanganwadi_id' => $this->input->post('aanganwadi_id'),
					'stock' => $this->input->post('stock')*1000,
					'type' => '0',
					'created_date' => date('Y-m-d H:i:s')
				);
				$item_id=$this->item_model->store_item_stock_detail($data_to_store);
				
				$get_total_stock = $this->item_model->get_total_stock($this->input->post('item_id'),$this->input->post('aanganwadi_id'));
				
				$isEntryExists = $this->item_model->isStockEntryExists($this->input->post('item_id'),$this->input->post('aanganwadi_id'));
				
				if(!$isEntryExists)
				{
					$data_to_store = array(
						'item_id' => $this->input->post('item_id'),
						'aanganwadi_id' => $this->input->post('aanganwadi_id'),
						'total_stock' => $get_total_stock,
						'updated_date' => date('Y-m-d H:i:s')
					);
					$item_id=$this->item_model->store_item_stock($data_to_store);
				}
				else
				{
					$data_to_store = array(
						'total_stock' => $get_total_stock,
						'updated_date' => date('Y-m-d H:i:s')
					);
					$item_id=$this->item_model->update_item_stock($isEntryExists,$data_to_store);
				}
				//if the insert has returned true then we show the flash message
				if($item_id){
					$data['flash_message'] = TRUE; 
				}else{
					$data['flash_message'] = FALSE; 
				}				
            }
			

        }

			$data['aanganwadi'] = $this->aanganvadi_model->get_aanganvadi();
			$data['item'] = $this->item_model->get_item();
		//load the view
        $data['main_content'] = 'admin/item_stock/add';
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
            $this->form_validation->set_rules('item_name', 'item_name', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    			$isitem = $this->item_model->if_item_exists($this->input->post('item_name'),$id);
				if(empty($isitem))
				{
					$data_to_store = array(
						'item_name' => $this->input->post('item_name'),
					);
					//if the insert has returned true then we show the flash message
					if($this->item_model->update_item($id, $data_to_store) == TRUE){
						$this->session->set_flashdata('flash_message', 'updated');

					}else{
						$this->session->set_flashdata('flash_message', 'not_updated');
					}
				}
				else
				{
					$this->session->set_flashdata('flash_message', 'not_updated');
				}
				
                redirect('item/update/'.$id.'');

            }//validation run

        }
        //aanganvadi data 
        $data['item'] = $this->item_model->get_item_by_id($id);
        //load the view
        $data['main_content'] = 'admin/item/edit';
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
        $this->item_model->delete_item($id);
        redirect('item');
    }//edit

}