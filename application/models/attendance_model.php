<?php

class Attendance_model extends CI_Model {

    protected $table_name = "attendance";
	protected $person_table_name = "tbl_family_person";
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
    /**
    * Get attendance by his is
    * @param int $attendance_id 
    * @return array
    */
    public function get_attendance_by_id($id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('attendance_id', $id);
		$query = $this->db->get();
		$rs = $query->result_array();
		
		return $rs; 
    }    	
    /**
    * Fetch attendance data from the database
    * possibility to mix search, filter and order
    * @param string $aanganvadi_id
	* @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
	public function validateDate($date)
{
    $d = DateTime::createFromFormat('Y/m/d', $date);
    return $d && $d->format('Y/m/d') == $date;
}
    /*public function get_attendance($aanganvadi_id=null,$search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null,$date=null)
    {
		$this->db->select($this->table_name.'.*');
		$this->db->select('aanganvadi.aanganvadi_name as aanganvadi_name');
		$this->db->select('aanganvadi.place as place');
		$this->db->select('aanganvadi.address as address');
		$this->db->select('(select name_guj from jilla where id=aanganvadi.jilla_id) as jilla_name');
		$this->db->select('(select name_guj from taluka where id=aanganvadi.taluka_id) as taluka_name');
		$this->db->select('(select name_guj from gaam where id=aanganvadi.gaam_id) as gaam_name');
		$this->db->from($this->table_name,'aanganvadi');
		//aanganvadi
		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where($this->table_name.'.aanganvadi_id', $this->session->userdata('user_id'));
		}
		else if($aanganvadi_id != null && $aanganvadi_id != 0)
		{
			$this->db->where($this->table_name.'.aanganvadi_id',$aanganvadi_id);
		}
		if($date != null)
		{
			
		    if(DateTime::createFromFormat('Y-m-d', $date) !== FALSE)
			{
				$this->db->where($this->table_name.'.attendance_date like "'.$date.'"');
			}
			else
			{
				$this->db->where('aanganvadi.aanganvadi_name like "'.$date.'"');
			}
			
			
			//$this->db->where($this->table_name.'.attendance_date',$date);
			//$this->db->where($this->table_name.'.attendance_date like "'.$date.'" or aanganvadi.aanganvadi_name like "'.$date.'"');
		}
		//jilla
		//$this->db->join('jilla', 'aanganvadi.jilla_id = jilla.id and '.$this->table_name.'.aanganvadi_id=aanganvadi.id', 'left');
		//taluka
		//$this->db->join('taluka', 'aanganvadi.taluka_id = taluka.id and '.$this->table_name.'.aanganvadi_id=aanganvadi.id', 'left');
		//gaam
		//$this->db->join('gaam', 'aanganvadi.gaam_id = gaam.id and '.$this->table_name.'.aanganvadi_id=aanganvadi.id', 'left');

		$this->db->join('aanganvadi', $this->table_name.'.aanganvadi_id = aanganvadi.id', 'left');
		$this->db->group_by($this->table_name.'.attendance_id');
		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by($this->table_name.'.attendance_id', $order_type);
		}
        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }
        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
		$query = $this->db->get();
// echo '<pre>';
// print_r($this->db->last_query());
// echo '</pre>';
		return $query->result_array(); 	
    }*/
	public function get_attendance($aanganvadi_id=null,$search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null,$date=null)
    {
		
		$startdate = date('Y-m-01');
		$enddate = date('Y-m-t',strtotime(date('Y-m-d')));

		if(DateTime::createFromFormat('F Y', $date) !== FALSE)
		{
			$startdate = date('Y-m-01',strtotime($date));;
			$enddate = date('Y-m-t',strtotime($startdate));

		}
		$datediff = strtotime($enddate) - strtotime($startdate);
     	$numberofdays = floor($datediff/(60*60*24));
		
		$this->db->select('DISTINCT(member_id)');
		$this->db->select('aanganvadi.aanganvadi_name as aanganvadi_name');
		$this->db->select('(select first_name from '.$this->person_table_name.' where family_person_id=attendance_detail.member_id) as first_name');
		$this->db->select('(select middle_name from '.$this->person_table_name.' where family_person_id=attendance_detail.member_id) as middle_name');
		$this->db->select('(select last_name from '.$this->person_table_name.' where family_person_id=attendance_detail.member_id) as last_name');
		$this->db->from('attendance_detail');
		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where('attendance_detail.aanganwadi_id', $this->session->userdata('user_id'));
		}
		else if($aanganvadi_id != null && $aanganvadi_id != 0)
		{
			$this->db->where('attendance_detail.aanganwadi_id',$aanganvadi_id);
		}
		$this->db->where('attendance_date >= \''.$startdate.'\' and attendance_date <=\''.$enddate.'\'');
		$this->db->join('aanganvadi', 'attendance_detail.aanganwadi_id = aanganvadi.id', 'left');
		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('attendance_id', $order_type);
		}
        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }
        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
		$query = $this->db->get();
		$rs = $query->result_array();
		//print_r($this->db->last_query());
		
	 
		for($i=0;$i<count($rs);$i++)
		{
			$array = array();
			for($j=0;$j<=$numberofdays;$j++)
			{
				if($j==0)
					$date = $startdate;
				else
					$date = date('Y-m-d',strtotime($startdate.' + '.$j.' days'));
					
				//CAL_GREGORIAN
				$this->db->select('is_present');
				$this->db->select('(select first_photo from attendance where attendance.attendance_id=attendance_detail.attendance_id) as first_photo');
                $this->db->select('(select second_photo from attendance where attendance.attendance_id=attendance_detail.attendance_id) as second_photo');
				$this->db->from('attendance_detail');
				$this->db->where('attendance_date = \''.$date.'\'');
				$this->db->where('member_id = \''.$rs[$i]['member_id'].'\'');
				
				$query = $this->db->get();
				$presentarray = $query->result_array();
				if(!empty($presentarray))
				{
					$array[$j]=$presentarray[0]['is_present'];
				}
				else
				{				
					$array[$j]='-';
				}
			}
			$rs[$i]['monthPresent'] = $array;
			
		}
		//
		//echo "<pre>";
		//print_r($rs);
		/*
		$this->db->select($this->table_name.'.*');
		$this->db->select('aanganvadi.aanganvadi_name as aanganvadi_name');
		$this->db->select('aanganvadi.place as place');
		$this->db->select('aanganvadi.address as address');
		$this->db->select('(select name_guj from jilla where id=aanganvadi.jilla_id) as jilla_name');
		$this->db->select('(select name_guj from taluka where id=aanganvadi.taluka_id) as taluka_name');
		$this->db->select('(select name_guj from gaam where id=aanganvadi.gaam_id) as gaam_name');
		$this->db->from($this->table_name,'aanganvadi');
		//aanganvadi
		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where($this->table_name.'.aanganvadi_id', $this->session->userdata('user_id'));
		}
		else if($aanganvadi_id != null && $aanganvadi_id != 0)
		{
			$this->db->where($this->table_name.'.aanganvadi_id',$aanganvadi_id);
		}
		if($date != null)
		{
			
		    if(DateTime::createFromFormat('Y-m-d', $date) !== FALSE)
			{
				$this->db->where($this->table_name.'.attendance_date like "'.$date.'"');
			}
			else
			{
				$this->db->where('aanganvadi.aanganvadi_name like "'.$date.'"');
			}
		}
		$this->db->join('aanganvadi', $this->table_name.'.aanganvadi_id = aanganvadi.id', 'left');
		$this->db->group_by($this->table_name.'.attendance_id');
		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by($this->table_name.'.attendance_id', $order_type);
		}
        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }
        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
		$query = $this->db->get();
		return $query->result_array(); 	*/
		return $rs;
    }
    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_attendance($aanganvadi_id=null,$search_string=null, $order=null,$date=null)
    {
	/*
		$this->db->select('*');
		$this->db->from($this->table_name);
		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where($this->table_name.'.aanganvadi_id', $this->session->userdata('user_id'));
		}
		else if($aanganvadi_id != null && $aanganvadi_id != 0)
		{
			$this->db->where($this->table_name.'.aanganvadi_id',$aanganvadi_id);
		}
		else
		{
		}
		if($date != null)
		{
			$d = DateTime::createFromFormat('Y-m-d', $date);
		    if($d && $d->format('Y-m-d') == $date)
			{
				$this->db->where($this->table_name.'.attendance_date like "'.$date.'"');
			}
			else
			{
				$this->db->where('aanganvadi.aanganvadi_name like "'.$date.'"');
			}
			//$this->db->where($this->table_name.'.attendance_date',$date);
		}
		$this->db->join('aanganvadi', $this->table_name.'.aanganvadi_id = aanganvadi.id', 'left');
		
		if($order){

			$this->db->order_by($order, 'Asc');

		}else{

		    $this->db->order_by('attendance_id', 'Asc');

		}

		$query = $this->db->get();

		return $query->num_rows();        
		*/
		$startdate = date('Y-m-01');
		$enddate = date('Y-m-t',strtotime(date('Y-m-d')));
		if(DateTime::createFromFormat('F Y', $date) !== FALSE)
		{
			$startdate = date('Y-m-01',strtotime($date));;
			$enddate = date('Y-m-t',strtotime($startdate));

		}
		$datediff = strtotime($enddate) - strtotime($startdate);
     	$numberofdays = floor($datediff/(60*60*24));
		
		$this->db->select('DISTINCT(member_id)');
		$this->db->select('aanganvadi.aanganvadi_name as aanganvadi_name');
		$this->db->select('(select first_name from '.$this->person_table_name.' where family_person_id=attendance_detail.member_id) as first_name');
		$this->db->select('(select middle_name from '.$this->person_table_name.' where family_person_id=attendance_detail.member_id) as middle_name');
		$this->db->select('(select last_name from '.$this->person_table_name.' where family_person_id=attendance_detail.member_id) as last_name');
		$this->db->from('attendance_detail');
		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where('attendance_detail.aanganwadi_id', $this->session->userdata('user_id'));
		}
		else if($aanganvadi_id != null && $aanganvadi_id != 0)
		{
			$this->db->where('attendance_detail.aanganwadi_id',$aanganvadi_id);
		}
		$this->db->where('attendance_date >= \''.$startdate.'\' and attendance_date <=\''.$enddate.'\'');
		$this->db->join('aanganvadi', 'attendance_detail.aanganwadi_id = aanganvadi.id', 'left');

		$query = $this->db->get();
		return $query->num_rows();

    }



    /**

    * Store the new item into the database

    * @param array $data - associative array with data to store

    * @return boolean 

    */

    function store_attendance($data)

    {

		$insert = $this->db->insert($this->table_name, $data);

	    return $this->db->insert_id();

	}

	
    /**

    * Update aanganvadi

    * @param array $data - associative array with data to store

    * @return boolean

    */

    function update_attendance($id, $data)

    {

		$this->db->where('attendance_id', $id);

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

    * Delete aanganvadi

    * @param int $id - aanganvadi id

    * @return boolean

    */

	function delete_attendance($id){
		$this->db->where('attendance_id', $id);
		$this->db->delete($this->table_name); 
	} 
	
	public function get_all_attendance_details()
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$result = $query->result_array();
		if(count($result) > 0){
			return array("status"=>"success","data"=>$result);
		}else{
			return array("status"=>"Attendance not found.");
		}
		return $query->result_array(); 
    }
	public function get_all_attendance()
    {
		$this->db->select($this->table_name.'.*');
		$this->db->from($this->table_name);
		$this->db->order_by($this->table_name.'.attendance_id','ASC');
		$query = $this->db->get();
		return $query->result_array(); 	
    }
}

?>	