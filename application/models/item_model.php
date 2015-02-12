<?php
class Item_model extends CI_Model {
    protected $table_name = "items";
	protected $stock_table_name = "item_stock";
	protected $stock_detail_table_name = "item_stock_detail";
	protected $aanganvadi_table_name = "aanganvadi";
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_item_by_id($id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }
	public function get_item_by_name($name)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('item_name', $name);
		$query = $this->db->get();
		return $query->result_array(); 
    } 
	
	 public function if_item_exists($item_name,$id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('item_name', $item_name);
		if($id!=0)
		{
			$this->db->where('id != '.$id);
		}
		$query = $this->db->get();
		return $query->result_array(); 
    } 
	public function checkIfItemExists($item_id,$aanganwadi_id,$stock)
    {
        $this->db->select('*');
        $this->db->from($this->stock_table_name);
        $this->db->where('item_id', $item_id);
        $this->db->where('aanganwadi_id', $aanganwadi_id);
        $this->db->where('total_stock > '.$stock);
        
        $query = $this->db->get();
        $rs = $query->result_array();
        if(empty($rs))
            return 0;
        else
            return 1;
    }
	 public function isStockEntryExists($item_id,$aanganwadi_id)
    {
		$this->db->select('*');
		$this->db->from($this->stock_table_name);
		$this->db->where('item_id', $item_id);
		$this->db->where('aanganwadi_id', $aanganwadi_id);
		
		$query = $this->db->get();
		$rs= $query->result_array(); 
		//print_r($this->db->last_query());
		if(!empty($rs))
			return $rs[0]['id'];
		else
			return 0;
    } 
	
	public function get_total_stock($item_id,$aanganwadi_id)
    {
		$this->db->select('SUM(stock) as stockAdded');
		$this->db->from($this->stock_detail_table_name);
		$this->db->where('item_id', $item_id);
		$this->db->where('aanganwadi_id', $aanganwadi_id);
		$this->db->where('type','0');
		$query = $this->db->get();
		$rs= $query->result_array(); 
		
		$this->db->select('SUM(stock) as stockGiven');
		$this->db->from($this->stock_detail_table_name);
		$this->db->where('item_id', $item_id);
		$this->db->where('aanganwadi_id', $aanganwadi_id);
		$this->db->where('type','1');
		$query = $this->db->get();
		$rs1= $query->result_array();
		
		if(!empty($rs))
		{
			$total_stock = $rs[0]['stockAdded']-$rs1[0]['stockGiven'];
			return $total_stock;
		}
		else
		{
			return 0;
		}
    }    

	public function getAllStockItems($aanganwadi_id)
	{//total_stock
		$this->db->select($this->table_name.'.id as commodityServerId,FLOOR(total_stock/1000) as commodityKG,(total_stock - (FLOOR(total_stock/1000))*1000) as commodityGram');
		$this->db->select($this->table_name.'.item_name as commodityName');
		$this->db->from($this->table_name);
		$this->db->join($this->stock_table_name,$this->stock_table_name.'.item_id='.$this->table_name.'.id AND '.$this->stock_table_name.'.aanganwadi_id='.$aanganwadi_id,'left');

		//$this->db->where('aanganwadi_id',$aanganwadi_id);
		
		$query = $this->db->get();
		return $query->result_array();
	}
    /**
    * Fetch jilla data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_item($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {	    
		$this->db->select('*');
		$this->db->from($this->table_name);

		if($search_string){
			$this->db->where("`item_name` like '".$search_string."'");			
		}
		$this->db->group_by('id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		//print_r($this->db->last_query());
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_item($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		if($search_string){
			$this->db->where("`item_name` like '".$search_string."'");			
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

	public function get_item_stock($search_string=null,$month=0,$year=0, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {	    
		$this->db->select('*,'.$this->stock_table_name.'.id as autoid');
		$this->db->select($this->aanganvadi_table_name.'.aanganvadi_name as aanganvadi_name');
        
        $insidewhere = '';
        if($month!=0 && $year != 0)
        {
            if(strlen($month)==0)
                $month='0'.$month;
            
            $startdate = $year.'-'.$month.'-01';
            $enddate = date('Y-m-t',strtotime($startdate));
            
            $insidewhere = " and item_stock_detail.created_date < '".$enddate."' and item_stock_detail.created_date > '".$startdate."'";
        }
		$this->db->select('(select sum(stock) from '.$this->stock_detail_table_name.' where '.$this->table_name.'.id='.$this->stock_detail_table_name.'.item_id AND '.$this->stock_detail_table_name.'.aanganwadi_id = '.$this->aanganvadi_table_name.'.id AND '.$this->stock_detail_table_name.'.type = "0" '.$insidewhere.') as total_in');
		$this->db->select('(select sum(stock) from '.$this->stock_detail_table_name.' where '.$this->table_name.'.id='.$this->stock_detail_table_name.'.item_id AND '.$this->stock_detail_table_name.'.aanganwadi_id = '.$this->aanganvadi_table_name.'.id AND '.$this->stock_detail_table_name.'.type = "1" '.$insidewhere.') as total_out');
		$this->db->from($this->stock_table_name);
		
		if($search_string){
			$this->db->where("`item_name` like '".$search_string."' or aanganvadi_name like '".$search_string."'");			
		}
		$this->db->join($this->table_name,$this->table_name.'.id='.$this->stock_table_name.'.item_id','left');
		$this->db->join($this->aanganvadi_table_name,$this->stock_table_name.'.aanganwadi_id = '.$this->aanganvadi_table_name.'.id','left');
		$this->db->group_by($this->stock_table_name.'.id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by($this->stock_table_name.'.id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		//print_r($this->db->last_query());
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_item_stock($search_string=null,$month=0,$year=0, $order=null)
    {
		$this->db->select('*');
		$this->db->from($this->stock_table_name);
		
		if($search_string){
			$this->db->where("`item_name` like '".$search_string."' or aanganvadi_name like '".$search_string."'");			
		}
		$this->db->join($this->table_name,$this->table_name.'.id='.$this->stock_table_name.'.item_id','left');
		$this->db->join($this->aanganvadi_table_name,$this->stock_table_name.'.aanganwadi_id = '.$this->aanganvadi_table_name.'.id','left');
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by($this->stock_table_name.'.id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }


    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_item($data)
    {
		$insert = $this->db->insert($this->table_name, $data);
	    return $this->db->insert_id();
	}
	
	 /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_item_stock_detail($data)
    {
		$insert = $this->db->insert($this->stock_detail_table_name, $data);
	    return $this->db->insert_id();
	}
	
	 /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_item_stock($data)
    {
		$insert = $this->db->insert($this->stock_table_name, $data);
	    return $this->db->insert_id();
	}

    /**
    * Update jilla
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_item($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

	 /**
    * Update jilla
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_item_stock($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update($this->stock_table_name, $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete jilla
    * @param int $id - jilla id
    * @return boolean
    */
	function delete_item($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table_name); 
	}
 
}
?>	
