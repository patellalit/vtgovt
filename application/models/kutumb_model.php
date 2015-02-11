<?php



class Kutumb_model extends CI_Model {
    protected $table_name = "tbl_family";
	protected $person_table_name = "tbl_family_person";
	protected $sagrbha_person_table_name = "tbl_sagrbha_family_member";
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
    public function get_kutumb_by_id($id)
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('family_id', $id);
		$query = $this->db->get();
		$rs = $query->result_array();
		$this->db->select('*');
		$this->db->from($this->person_table_name);
		$this->db->where('family_id', $id);
		$query = $this->db->get();
		$rs[0]['persondata'] = $query->result_array();
		return $rs; 
    } 
	public function get_all_person_by_kutumbid($id)
    {
		$this->db->select('*');
		$this->db->from($this->person_table_name);
		$this->db->where('family_id', $id);
		$query = $this->db->get();
		$rs = $query->result_array();
		return $rs; 
    }
    public function get_all_children()
    {
        $this->db->select('*');
        $this->db->from($this->person_table_name);
        $this->db->where('ageIn_year = 0 and ageIn_month < 6');
        $query = $this->db->get();
        $rs = $query->result_array();
        return $rs;
    }
    public function isvaccine($vaccineid,$memberid)
    {
        $this->db->select('*');
        $this->db->from('tbl_vacine_member_detail');
        $this->db->where('vaccine_id',$vaccineid);
        $this->db->where('member_id',$memberid);
        
        $query = $this->db->get();
        $rs = $query->result_array();
        if(empty($rs))
            return false;
        else
            return true;
    }
	public function get_kutumb_person_by_id($id)
    {
		$this->db->select('*');
		$this->db->from($this->person_table_name);
		$this->db->where('family_person_id', $id);
		$query = $this->db->get();
		return $query->result_array();
    }    
	 public function checkiffamilyrankexists($familyrank,$aanganwadiid,$id='')
    {
		$this->db->select('count(*) as count');
		$this->db->from($this->table_name);
		$this->db->where('family_rank', $familyrank);
		$this->db->where('anganwadi_id', $aanganwadiid);
		if($id!='')
			$this->db->where('family_id !=', $id);		

		$query = $this->db->get();
//		echo $this->db->return_query();
		$rs = $query->row_array();
		return $rs['count']; 
    }   
	public function checkiffamilymemberrankexists($familyrank,$aanganwadiid,$id='')
    {
		$this->db->select('count(*) as count');
		$this->db->from($this->person_table_name);
		$this->db->where('person_rank', $familyrank);
		$this->db->where('anganwadi_id',$aanganwadiid);
		if($id!='')
			$this->db->where($this->person_table_name.'.family_id !=', $id);		

		$this->db->join('tbl_family', $this->table_name.'.family_id = tbl_family.family_id ', 'left');
		$query = $this->db->get();
		$rs = $query->row_array();
		   // echo '<pre>';
//    print_r($this->db->last_query());
//    echo '</pre>';
		return $rs['count']; 
    }
	
	public function search_kutumb($search_string=null,$aanganwadi_id=null)
    {
		$familyidarray=array();
		if($search_string!=null)
		{
			$this->db->select("DISTINCT(family_id)");
			$this->db->from($this->person_table_name);
			$stringarray=explode(' ',$search_string);
			$this->db->where("(first_name like '%".$search_string."%' or middle_name like '%".$search_string."%' or last_name like '%".$search_string."%' or CONCAT_WS(' ', first_name, middle_name, last_name) like '%".$search_string."%') and relation_with_main_person=2");
			$query = $this->db->get();
			//print_r($this->db->last_query());
			$resultarray = $query->result_array(); 	
			for($i=0;$i<count($resultarray);$i++)
			{
				$familyidarray[] = $resultarray[$i]['family_id'];
			}			
		}
		$this->db->select($this->table_name.'.*');
		$this->db->select('aanganvadi.aanganvadi_name as aanganvadi_name');
		$this->db->from($this->table_name);
		//aanganvadi
		if($search_string!=null)
		{
			if(!empty($familyidarray))
			{
				$this->db->where('('.$this->table_name.'.family_id in ('.implode(',',$familyidarray).') or family_rank=\''.$search_string.'\') and anganwadi_id='.$aanganwadi_id );
			}	
			else
			{
				$this->db->where('family_rank',$search_string);
				$this->db->where('anganwadi_id',$aanganwadi_id);
			}
		}
		$this->db->join('aanganvadi', $this->table_name.'.anganwadi_id = aanganvadi.id', 'left');
		
		$this->db->group_by($this->table_name.'.family_id');
		$this->db->order_by('family_rank','ASC');
		
		$query = $this->db->get();
		//print_r($this->db->last_query());
		
		$result = $query->result_array();
		$returnarray=array();
		for($i=0;$i<count($result);$i++)
		{
			$returnarray[$i]['religion']=$result[$i]['dharm_id'];
			$returnarray[$i]['kutumb_id']=$result[$i]['family_id'];
			$returnarray[$i]['userId']=$result[$i]['anganwadi_id'];
			$returnarray[$i]['familyNo']=$result[$i]['family_rank'];
			$returnarray[$i]['caste']=$result[$i]['jati_id'];
			$returnarray[$i]['place']=$result[$i]['sthal_id'];			
			$returnarray[$i]['placeDetail']=$result[$i]['sthal_value'];
			$returnarray[$i]['minority']=$result[$i]['laghumati'];
			if($result[$i]['nondhani_date'] != '' && $result[$i]['nondhani_date'] != '0000-00-00 00:00:00' && $result[$i]['nondhani_date'] != '0000-00-00')
				$returnarray[$i]['nondhani_date']=date('d-m-Y',strtotime($result[$i]['nondhani_date']));
			else
				$returnarray[$i]['nondhani_date']='';
				
			$returnarray[$i]['aanganvadi_name']=$result[$i]['aanganvadi_name'];
			
			$this->db->select('*');
			$this->db->from($this->person_table_name);
			$this->db->where('family_id',$result[$i]['family_id']);
			$query = $this->db->get();
			$members = $query->result_array();
			for($k=0;$k<count($members);$k++)
			{
				$returnarray[$i]['members'][$k]['person_id'] = $members[$k]['family_person_id'];
				$returnarray[$i]['members'][$k]['middleName'] = $members[$k]['middle_name'];
				$returnarray[$i]['members'][$k]['motherName'] = $members[$k]['mother_name'];
				$returnarray[$i]['members'][$k]['aprilAgeMonth'] = $members[$k]['ageIn_month'];
				if($members[$k]['birth_date'] != '' && $members[$k]['birth_date'] != '0000-00-00 00:00:00' && $members[$k]['birth_date'] != '0000-00-00')
					$returnarray[$i]['members'][$k]['DOB'] = date('d-m-Y',strtotime($members[$k]['birth_date']));
				else
					$returnarray[$i]['members'][$k]['DOB'] = '';
				$returnarray[$i]['members'][$k]['targetCode'] = $members[$k]['lakshyank_code'];
				$returnarray[$i]['members'][$k]['surName'] = $members[$k]['last_name'];
				if($members[$k]['die_date'] != '' && $members[$k]['die_date'] != '0000-00-00 00:00:00' && $members[$k]['die_date'] != '0000-00-00')
					$returnarray[$i]['members'][$k]['DOD'] = date('d-m-Y',strtotime($members[$k]['die_date']));
				else
					$returnarray[$i]['members'][$k]['DOD'] = '';
				$returnarray[$i]['members'][$k]['familyPersonNo'] = $members[$k]['person_rank'];
				$returnarray[$i]['members'][$k]['maritalStatus'] = $members[$k]['merridial_status'];
				if($members[$k]['gam_shift_date'] != '' && $members[$k]['gam_shift_date'] != '0000-00-00 00:00:00' && $members[$k]['gam_shift_date'] != '0000-00-00')
					$returnarray[$i]['members'][$k]['villageMigrationDate'] = date('d-m-Y',strtotime($members[$k]['gam_shift_date']));
				else
					$returnarray[$i]['members'][$k]['villageMigrationDate'] = '';
				$returnarray[$i]['members'][$k]['malformationType'] = $members[$k]['khodkhapan_type'];
				$returnarray[$i]['members'][$k]['centerAreaResident'] = $members[$k]['anganwadi_kendra_vistar_rehvasi'];
				$returnarray[$i]['members'][$k]['relationWithFamilyHead'] = $members[$k]['relation_with_main_person'];
				if($members[$k]['gam_out_shift_date'] != '' && $members[$k]['gam_out_shift_date'] != '0000-00-00 00:00:00' && $members[$k]['gam_out_shift_date'] != '0000-00-00')
					$returnarray[$i]['members'][$k]['migrationOutVillageDate'] = date('d-m-Y',strtotime($members[$k]['gam_out_shift_date']));				
				else
					$returnarray[$i]['members'][$k]['migrationOutVillageDate'] = '';				
				$returnarray[$i]['members'][$k]['aprilAgeYear'] = $members[$k]['ageIn_year'];
				$returnarray[$i]['members'][$k]['gender'] = $members[$k]['gender'];
				$returnarray[$i]['members'][$k]['firstName'] = $members[$k]['first_name'];
				$returnarray[$i]['members'][$k]['UIDNo'] = $members[$k]['uid_aadharnumber'];
				if($members[$k]['lmp_date'] != '' && $members[$k]['lmp_date'] != '0000-00-00 00:00:00' && $members[$k]['lmp_date'] != '0000-00-00')
					$returnarray[$i]['members'][$k]['lmp_date'] = date('d-m-Y',strtotime($members[$k]['lmp_date']));
				else
					$returnarray[$i]['members'][$k]['lmp_date'] = '';
				
				if($members[$k]['miscarage_date'] != '' && $members[$k]['miscarage_date'] != '0000-00-00 00:00:00' && $members[$k]['miscarage_date'] != '0000-00-00')
					$returnarray[$i]['members'][$k]['miscarage_date'] = date('d-m-Y',strtotime($members[$k]['miscarage_date']));
				else
					$returnarray[$i]['members'][$k]['miscarage_date'] = '';
				
				if($members[$k]['nondhani_date'] != '' && $members[$k]['nondhani_date'] != '0000-00-00 00:00:00' && $members[$k]['nondhani_date'] != '0000-00-00')
					$returnarray[$i]['members'][$k]['nondhani_date'] = date('d-m-Y',strtotime($members[$k]['nondhani_date']));				
				else
					$returnarray[$i]['members'][$k]['nondhani_date'] = '';				
				$returnarray[$i]['members'][$k]['janm_samay'] = $members[$k]['janm_samay'];
				$returnarray[$i]['members'][$k]['janm_sthal'] = $members[$k]['janm_sthal'];
				$returnarray[$i]['members'][$k]['janm_samaye_thayel_vajan_kilogram'] = $members[$k]['janm_samaye_thayel_vajan_kilogram'];
				$returnarray[$i]['members'][$k]['janm_amaye_thayel_vajan_grams'] = $members[$k]['janm_amaye_thayel_vajan_grams'];
				$returnarray[$i]['members'][$k]['dilevery_type'] = $members[$k]['dilevery_type'];
				//$returnarray[$i]['members'][$k]['purak_aahar'] = $members[$k]['purak_aahar'];
				//$returnarray[$i]['members'][$k]['purv_prathmik_shikshan'] = $members[$k]['purv_prathmik_shikshan'];
				
				if($members[$k]['purak_aahar'] == "1" && $members[$k]['purv_prathmik_shikshan'] == "0")
				{
					$returnarray[$i]['members'][$k]['anganwadiServices'] = '1';
				} 
				else if($members[$k]['purak_aahar'] == "0" && $members[$k]['purv_prathmik_shikshan'] == "1")
				{
					$returnarray[$i]['members'][$k]['anganwadiServices'] = '2';
				} 
				else if($members[$k]['purak_aahar'] == "1" && $members[$k]['purv_prathmik_shikshan'] == "1")
				{
					$returnarray[$i]['members'][$k]['anganwadiServices'] = '1,2';
				} else{
					$returnarray[$i]['members'][$k]['anganwadiServices'] = '';
				}
			}
			
		}
		return $returnarray;
    }
    /**
    * Fetch aanganvadi data from the database
    * possibility to mix search, filter and order
    * @param string $jilla_id
	* @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
	* @param int $limit_end
    * @return array
    */
    public function get_kutumb($jilla_id=null,$taluka_id=null,$gaam_id=null,$aanganwadiid_id=null,$search_string=null,$jati_id=null,$religion_id=null,$laghumati=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null,$count=false)
    {
		$familyidarray=array();
		if($search_string!=null)
		{
			$this->db->select("DISTINCT(family_id)");
			$this->db->from($this->person_table_name);
			$stringarray=explode(' ',$search_string);
			$this->db->where("(first_name like '%".$search_string."%' or middle_name like '%".$search_string."%' or last_name like '%".$search_string."%' or CONCAT_WS(' ', first_name, middle_name, last_name) like '%".$search_string."%')");
			$query = $this->db->get();
			$resultarray = $query->result_array(); 	
			for($i=0;$i<count($resultarray);$i++)
			{
				$familyidarray[] = $resultarray[$i]['family_id'];
			}			
		}

		if($count == "total"){
			$this->db->select('count(*) as count');
			$this->db->from($this->person_table_name);
			$this->db->join($this->table_name, $this->person_table_name.'.family_id = '.$this->table_name.'.family_id', 'left');
		}else if($count == "khodkhapan"){
			$this->db->select('count(*) as count');
			$this->db->from($this->person_table_name);
			$this->db->join($this->table_name, $this->person_table_name.'.family_id = '.$this->table_name.'.family_id', 'left');
		}else if($count == "death"){
			$this->db->select('count(*) as count');
			$this->db->from($this->person_table_name);
			$this->db->join($this->table_name, $this->person_table_name.'.family_id = '.$this->table_name.'.family_id', 'left');
		}else if($count == "birth"){
			$this->db->select('count(*) as count');

			$this->db->from($this->person_table_name);
			$this->db->join($this->table_name, $this->person_table_name.'.family_id = '.$this->table_name.'.family_id', 'left');
		}else{
			$this->db->select($this->table_name.'.*');
			$this->db->select('(select first_name from '.$this->person_table_name.' where family_id='.$this->table_name.'.family_id and relation_with_main_person=2 order by family_person_id asc limit 1) as first_name');
			$this->db->select('(select middle_name from '.$this->person_table_name.' where family_id='.$this->table_name.'.family_id and relation_with_main_person=2 order by family_person_id asc limit 1) as middle_name');
			$this->db->select('(select last_name from '.$this->person_table_name.' where family_id='.$this->table_name.'.family_id and relation_with_main_person=2 order by family_person_id asc limit 1) as last_name');
		    /*$this->db->select('(select count(*) as cnt from '.$this->person_table_name.' where family_id='.$this->table_name.'.family_id and khodkhapan_type!= 1 and khodkhapan_type!= 2) as total_khodkhapan');
		    $this->db->select('(select count(*) as cnt from '.$this->person_table_name.' where family_id='.$this->table_name.'.family_id and die_date != null and die_date != \'0000-00-00 00:00:00\') as total_death');
		    $this->db->select('(select count(*) as cnt from '.$this->person_table_name.' where family_id='.$this->table_name.'.family_id and (die_date = null or die_date = \'0000-00-00 00:00:00\')) as total_birth');*/
			$this->db->select('aanganvadi.aanganvadi_name as aanganvadi_name');
			$this->db->from($this->table_name);
		}
		

		if($count == "khodkhapan"){
			$where = "khodkhapan_type != '1' and khodkhapan_type != '2'";
			$this->db->where($where);
		}else if($count == "death"){
			$where = "die_date != null and die_date != '0000-00-00 00:00:00'";
			$this->db->where($where);
		}else if($count == "birth"){
			$where = "(die_date = null or die_date = '0000-00-00 00:00:00')";
			$this->db->where($where);
		}
		//aanganvadi
		if($aanganwadiid_id != null && $aanganwadiid_id != 0){
			$this->db->where('anganwadi_id', $aanganwadiid_id);
		}
        if($jati_id!=null && $jati_id != 1)
        {
            $this->db->where('jati_id', $jati_id);
        }
        if($religion_id!=null && $religion_id != 1)
        {
            $this->db->where('dharm_id', $religion_id);
        }
        if($laghumati!=null && $laghumati!=0)
        {
            $this->db->where('laghumati', $laghumati);
        }
		if($search_string!=null)
		{
			if(!empty($familyidarray))
			{
				$this->db->where($this->table_name.'.family_id in ('.implode(',',$familyidarray).') or family_rank=\''.$search_string.'\' or tbl_caste.name_guj like "'.$search_string.'" or tbl_religion.name_guj like "'.$search_string.'" or aanganvadi.aanganvadi_name like "'.$search_string.'" or tbl_place.name_guj like "'.$search_string.'" or sthal_value like "'.$search_string.'"' );
			}
			else
			{
				$this->db->where($this->table_name.'.family_rank = "'.$search_string.'" or tbl_caste.name_guj like "'.$search_string.'" or tbl_religion.name_guj like "'.$search_string.'" or aanganvadi.aanganvadi_name like "'.$search_string.'" or tbl_place.name_guj like "'.$search_string.'" or sthal_value like "'.$search_string.'"');
			}
			
		}
		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where($this->table_name.'.anganwadi_id', $this->session->userdata('user_id'));
		}
		
		$this->db->join('aanganvadi', $this->table_name.'.anganwadi_id = aanganvadi.id', 'left');
		
		if($search_string!=null)
		{
			$this->db->join('tbl_caste', $this->table_name.'.jati_id = tbl_caste.id', 'left');
			$this->db->join('tbl_religion', $this->table_name.'.dharm_id = tbl_religion.id', 'left');
			$this->db->join('tbl_place', $this->table_name.'.sthal_id = tbl_place.id', 'left');
		}

		if(!$count){
			$this->db->group_by($this->table_name.'.family_id');
		
			//$this->db->group_by('family_id');
			if($order){
				$this->db->order_by($order, $order_type);
			}else{
				$this->db->order_by('family_rank', $order_type);
			}
		    if($limit_start && $limit_end){
		      $this->db->limit($limit_start, $limit_end);	
		    }
		    if($limit_start != null){
		      $this->db->limit($limit_start, $limit_end);    
		    }
		}
		
		$query = $this->db->get();
		
		$result = $query->result_array();
        //print_r($this->db->last_query());
		
		if($count == "total"){
			if(isset($result[0]))
				return $result[0]["count"];
			else
				return 0;
		}else if($count == "khodkhapan"){
			if(isset($result[0]))
				return $result[0]["count"];
			else
				return 0;
		}else if($count == "death"){

			if(isset($result[0]))
				return $result[0]["count"];
			else
				return 0;

		}else if($count == "birth"){
			if(isset($result[0]))
				return $result[0]["count"];
			else
				return 0;
		}else{
			return $result;
		}
    }
	/**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_sagrbha_entry($person_id)
    {
		$this->db->select("*");
		$this->db->from($this->sagrbha_person_table_name);
		$this->db->where("family_person_id",$person_id);
		$query = $this->db->get();
		$resultarray = $query->result_array(); 
		return count($resultarray);	
	}
    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_kutumb($jilla_id=null,$taluka_id=null,$gaam_id=null,$aanganwadiid_id=null,$search_string=null,$jati_id=null,$religion_id=null,$laghumati=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
		$familyidarray=array();
		if($search_string!=null)
		{
			$this->db->select("DISTINCT(family_id)");
			$this->db->from($this->person_table_name);
			$this->db->where("(first_name like '%".$search_string."%' or middle_name like '%".$search_string."%' or last_name like '%".$search_string."%')");
			$query = $this->db->get();
			$resultarray = $query->result_array(); 	
			//print_r($resultarray);
			for($i=0;$i<count($resultarray);$i++)
			{
				$familyidarray[] = $resultarray[$i]['family_id'];
			}
			
		}
		$this->db->select('*');
		$this->db->from($this->table_name);
		/*
		if($search_string){
			$this->db->like('name', $search_string);
		}*/
        if($jati_id!=null && $jati_id != 1)
        {
            $this->db->where('jati_id', $jati_id);
        }
        if($religion_id!=null && $religion_id != 1)
        {
            $this->db->where('dharm_id', $religion_id);
        }
        if($laghumati!=null && $laghumati!=0)
        {
            $this->db->where('laghumati', $laghumati);
        }
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('family_id', 'Asc');
		}
		
		//aanganvadi
		if($aanganwadiid_id != null && $aanganwadiid_id != 0){
			$this->db->where('anganwadi_id', $aanganwadiid_id);
		}

		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where($this->table_name.'.anganwadi_id', $this->session->userdata('user_id'));
		}
		if($search_string!=null)
		{
			if(!empty($familyidarray))
			{
				$this->db->where($this->table_name.'.family_id in ('.implode(',',$familyidarray).') or family_rank=\''.$search_string.'\' or tbl_caste.name_guj like "'.$search_string.'" or tbl_religion.name_guj like "'.$search_string.'" or aanganvadi.aanganvadi_name like "'.$search_string.'" or tbl_place.name_guj like "'.$search_string.'" or sthal_value like "'.$search_string.'"' );
			}
			else
			{
				$this->db->where($this->table_name.'.family_rank = "'.$search_string.'" or tbl_caste.name_guj like "'.$search_string.'" or tbl_religion.name_guj like "'.$search_string.'" or aanganvadi.aanganvadi_name like "'.$search_string.'" or tbl_place.name_guj like "'.$search_string.'" or sthal_value like "'.$search_string.'"');
			}
			
		}
		if($this->session->userdata('is_admin')==false)
		{
			$this->db->where($this->table_name.'.anganwadi_id', $this->session->userdata('user_id'));
		}
		
		$this->db->join('aanganvadi', $this->table_name.'.anganwadi_id = aanganvadi.id', 'left');
		/*
        if($jilla_id!=null)
        {
            $this->db->where($this->table_name.'.anganwadi_id', $this->session->userdata('user_id'));
            $this->db->join('jilla', $this->table_name.'.family_id = jilla.id', 'left');
        }*/
		if($search_string!=null)
		{
			$this->db->join('tbl_caste', $this->table_name.'.jati_id = tbl_caste.id', 'left');
			$this->db->join('tbl_religion', $this->table_name.'.dharm_id = tbl_religion.id', 'left');
			$this->db->join('tbl_place', $this->table_name.'.sthal_id = tbl_place.id', 'left');
		}
		$query = $this->db->get();
		return $query->num_rows();
    }
    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_kutumb($data)
    {
		$insert = $this->db->insert($this->table_name, $data);
	    return $this->db->insert_id();
	}
	function store_kutumb_person($data)
    {
		$insert = $this->db->insert($this->person_table_name, $data);
	    return $this->db->insert_id();
	}
	function store_sagrbha_kutumb_person($data)
    {
		$insert = $this->db->insert($this->sagrbha_person_table_name, $data);
	    return $insert;
	}
    function store_weight($data)
    {
        $insert = $this->db->insert('tbl_children_weight', $data);
        return $this->db->insert_id();
    }
    /**
    * Update aanganvadi
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_kutumb($id, $data)
    {
		$this->db->where('family_id', $id);
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
    * Update kutumb member
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_kutumb_member($id, $data)
    {
		$this->db->where('family_person_id', $id);
		$this->db->update($this->person_table_name, $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
    public function set_all_pragnent_member()
    {
        $this->db->where("lmp_date !='' and lmp_date != '0000-00-00'");
        $this->db->update($this->person_table_name, array('childCategory'=>'4'));
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
	function delete_kutumb($id){
		$this->db->where('family_id', $id);
		$this->db->delete($this->table_name); 
	} 
	function delete_kutumb_person($id){
		$this->db->where('family_id', $id);
		$this->db->delete($this->person_table_name); 
	} 
	/*public function get_all_kutumb_details()
    {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->join($this->person_table_name,$this->table_name.'.family_id='.$this->person_table_name.'.family_id AND (('.$this->person_table_name.'.ageIn_year = 0 AND '.$this->person_table_name.'.ageIn_month >= 6) OR ('.$this->person_table_name.'.ageIn_year > 0 AND '.$this->person_table_name.'.ageIn_year <=6)) ','inner');
		$query = $this->db->get();
		$result = $query->result_array();
		if(count($result) > 0){
			return array("status"=>"success","data"=>$result);
		}else{
			return array("status"=>"Kutumb not found.");
		}
		return $query->result_array(); 
    }*/
    public function get_all_kutumb_details($type,$user_id=null)
    {
        $this->db->select('*');
        $this->db->from($this->table_name);
        if($type=="6to3")
        {
            $this->db->join($this->person_table_name,$this->table_name.'.family_id='.$this->person_table_name.'.family_id AND ((12 * (YEAR(now()) - YEAR(birth_date)) + (MONTH(now()) - MONTH(birth_date))) > 6 and (12 * (YEAR(now()) - YEAR(birth_date)) + (MONTH(now()) - MONTH(birth_date)) <= 36)) ','inner');
        }
        else
        {
            $this->db->join($this->person_table_name,$this->table_name.'.family_id='.$this->person_table_name.'.family_id AND ((12 * (YEAR(now()) - YEAR(birth_date)) + (MONTH(now()) - MONTH(birth_date))) > 36 and (12 * (YEAR(now()) - YEAR(birth_date)) + (MONTH(now()) - MONTH(birth_date)) <= 72)) ','inner');
        }
		
		if($user_id)
			$this->db->where($this->table_name.'.anganwadi_id',$user_id);
        $query = $this->db->get();
		//echo $this->db->last_query();;exit;
        $result = $query->result_array();
        if(count($result) > 0){
            return array("status"=>"success","data"=>$result);
        }else{
            return array("status"=>"Kutumb not found.","data"=>array());
        }
        return $query->result_array(); 
    }
    public function getAllChildWithDifferentCategory($user_id)
    {
        $this->db->select("family_person_id as childServerId,childCategory,CONCAT_WS(' ', first_name, middle_name, last_name) as name",false);
        $this->db->from($this->person_table_name);
        $this->db->where('childCategory != 0');
        $this->db->join($this->table_name,$this->table_name.'.family_id='.$this->person_table_name.'.family_id AND '.$this->table_name.'.anganwadi_id ='.$user_id,'inner');
        
        $query = $this->db->get();
        
        $result = $query->result_array();
        
        return $result;
    }
    public function getallchildrenBelow6years()
    {
        $this->db->select("*, TIMESTAMPDIFF( MONTH, birth_date, CURDATE( ) ) AS age",false);
        $this->db->from($this->person_table_name);
        $this->db->where('TIMESTAMPDIFF( MONTH, birth_date, CURDATE( ) ) <= 72');
        //$this->db->join($this->table_name,$this->table_name.'.family_id='.$this->person_table_name.'.family_id AND '.$this->table_name.'.anganwadi_id ='.$user_id,'inner');
        
        $query = $this->db->get();
        
        $result = $query->result_array();
        
        return $result;
    }
    public function getallckishoriAndDhatri()
    {
        $this->db->select("*",false);
        $this->db->from($this->person_table_name);
        $this->db->where('lakshyank_code = 6 or lakshyank_code = 4');
        //$this->db->join($this->table_name,$this->table_name.'.family_id='.$this->person_table_name.'.family_id AND '.$this->table_name.'.anganwadi_id ='.$user_id,'inner');
        
        $query = $this->db->get();
        
        $result = $query->result_array();
        
        return $result;
    }
    public function getallpragnent()
    {
        $this->db->select("*",false);
        $this->db->from($this->person_table_name);
        $this->db->where("lmp_date IS NOT NULL AND lmp_date != '0000-00-00'");
        //$this->db->join($this->table_name,$this->table_name.'.family_id='.$this->person_table_name.'.family_id AND '.$this->table_name.'.anganwadi_id ='.$user_id,'inner');
        
        $query = $this->db->get();
        
        $result = $query->result_array();
        
        return $result;
    }
    
    
}
?>	
