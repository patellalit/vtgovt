<?php
class Admin_reports extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jilla_model');        
		$this->load->model('common_model');
        $this->load->model('activities_model');
        $this->load->model('aanganvadi_model');
        $this->load->model('aanganwadi_activities_model');
        $this->load->model('kutumb_model');
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
        $aanganwadi = $this->aanganvadi_model->get_aanganvadi();
        if(!isset($_REQUEST['reportid']))
        {
            $data['aanganwadiid_selected'] = 0;
            $data['reportarray'][0] = array('key'=>''.site_url().'reports?reportid=4','val'=>'Reg-4-Pre-School Education');
            /*$data['reportarray'][1] = array('key'=>'4','val'=>'Reg-4-Pre-School Education');
            $data['reportarray'][2] = array('key'=>'4','val'=>'Reg-4-Pre-School Education');
            $data['reportarray'][3] = array('key'=>'4','val'=>'Reg-4-Pre-School Education');
            $data['reportarray'][4] = array('key'=>'4','val'=>'Reg-4-Pre-School Education');*/
        }
        else
        {
            $data['aanganwadiid_selected'] = $_REQUEST['aanganvadi_id'];
            if($_REQUEST['reportid'] == 4)
            {
                //$data['reportarray'][0] = array('key'=>''.site_url().'reports/downloadreports?reportid=41','val'=>'વિભાગ ૧-a: પૂર્વ પ્રાથમિક શિક્ષણ ની વિગત 3 થી 4 વર્ષ ની બધી કન્યાઓ માટે ');
                $data['reportarray'][0] = array('key'=>''.site_url().'reports/downloadreports?reportid=44','val'=>'વિભાગ ૪, પૂર્વ પ્રાથમિક ગતિવિધિઓ નું પત્રક');
                
            }
        }
        //load the view
        $data['aanganvadi'] = $aanganwadi;
        
        $data['main_content'] = 'admin/reports/reportMainList';
        $this->load->view('includes/template', $data);  

    }//index
    public function downloadreports()
    {
        if($_REQUEST['reportid'] == 41)
        {
            $this->report41();
        }
        if($_REQUEST['reportid'] == 44)
        {
            $this->report44();
        }
    }
    public function report41()
    {
        $aanganwadi_id=$_REQUEST['aanganvadi_id'];
        
        
        $startdate = date('Y-m-01');
        $enddate = date('Y-m-t',strtotime(date('Y-m-d')));
        
        
        
        $datediff = strtotime($enddate) - strtotime($startdate);
        $numberofdays = floor($datediff/(60*60*24));
        
        
        for($i=0;$i<count($allactivities);$i++)
        {
            $count = $this->aanganwadi_activities_model->get_avtivity_done_in_date($allactivities[$i]['id'],$aanganwadi_id,$startdate,$enddate);
            $allactivities[$i]['cnt'] = $count;
        }
        //echo "<pre>";print_r($allactivities);
        $cnt=0;
        $moreThanFourActivityDays=0;
        $memberAttandence=array();
        for($j=0;$j<=$numberofdays;$j++)
        {
            if($j==0)
                $date = $startdate;
            else
                $date = date('Y-m-d',strtotime($startdate.' + '.$j.' days'));
            
            $getActivityOfAllDay[$j] = $this->aanganwadi_activities_model->get_all_activities_by_aanganwadi_id($aanganwadi_id,$date);
            if(!empty($getActivityOfAllDay[$j]))
            {
                $cnt++;
                $getActivityOfAllDay[$j] = $getActivityOfAllDay[$j][0];
                
                $activity_id = explode(',',$getActivityOfAllDay[$j]['activity_id']);
                if(count($activity_id)>4)
                    $moreThanFourActivityDays++;
                $getActivityOfAllDay[$j]['activity_id'] = $activity_id;
            }
            $memberAttandence[$j]['girls_3_4'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('3-4',$aanganwadi_id,$date,3,36,48);
            $memberAttandence[$j]['girls_4_5'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('4-5',$aanganwadi_id,$date,3,48,60);
            $memberAttandence[$j]['girls_5_6'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('5-6',$aanganwadi_id,$date,3,60,72);
            
            $memberAttandence[$j]['boys_3_4'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('3-4',$aanganwadi_id,$date,2,36,48);
            $memberAttandence[$j]['boys_4_5'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('4-5',$aanganwadi_id,$date,2,48,60);
            $memberAttandence[$j]['boys_5_6'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('5-6',$aanganwadi_id,$date,2,60,72);
            
            $memberAttandence[$j]['all_3_4'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('3-4',$aanganwadi_id,$date,0,36,48);
            $memberAttandence[$j]['all_4_5'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('4-5',$aanganwadi_id,$date,0,48,60);
            $memberAttandence[$j]['all_5_6'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('5-6',$aanganwadi_id,$date,0,60,72);
        }
        
        $data['activities']=$allactivities;
        $data['activitiesservices']=$getActivityOfAllDay;
        $data['totalActivityDays']=$cnt;
        $data['moreThanFourActivityDays'] = $moreThanFourActivityDays;
        $data['memberAttandence'] = $memberAttandence;
        //echo "<pre>";
        //print_r($data['activitiesservices']);
        $html = $this->load->view('admin/reports/41', $data,true);
        echo $html;exit;
    }
    public function report44()
    {
        $aanganwadi_id=$_REQUEST['aanganvadi_id'];
        $allactivities = $this->activities_model->get_activities();
        
        $startdate = date('Y-m-01');
        $enddate = date('Y-m-t',strtotime(date('Y-m-d')));
        
        
        
        $datediff = strtotime($enddate) - strtotime($startdate);
        $numberofdays = floor($datediff/(60*60*24));
        
        
        for($i=0;$i<count($allactivities);$i++)
        {
            $count = $this->aanganwadi_activities_model->get_avtivity_done_in_date($allactivities[$i]['id'],$aanganwadi_id,$startdate,$enddate);
            $allactivities[$i]['cnt'] = $count;
        }
        //echo "<pre>";print_r($allactivities);
        $cnt=0;
        $moreThanFourActivityDays=0;
        $memberAttandence=array();
        for($j=0;$j<=$numberofdays;$j++)
        {
            if($j==0)
                $date = $startdate;
            else
                $date = date('Y-m-d',strtotime($startdate.' + '.$j.' days'));
            
            $getActivityOfAllDay[$j] = $this->aanganwadi_activities_model->get_all_activities_by_aanganwadi_id($aanganwadi_id,$date);
            if(!empty($getActivityOfAllDay[$j]))
            {
                $cnt++;
                $getActivityOfAllDay[$j] = $getActivityOfAllDay[$j][0];
                
                $activity_id = explode(',',$getActivityOfAllDay[$j]['activity_id']);
                if(count($activity_id)>4)
                    $moreThanFourActivityDays++;
                $getActivityOfAllDay[$j]['activity_id'] = $activity_id;
            }
            $memberAttandence[$j]['girls_3_4'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('3-4',$aanganwadi_id,$date,3,36,48);
            $memberAttandence[$j]['girls_4_5'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('4-5',$aanganwadi_id,$date,3,48,60);
            $memberAttandence[$j]['girls_5_6'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('5-6',$aanganwadi_id,$date,3,60,72);
            
            $memberAttandence[$j]['boys_3_4'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('3-4',$aanganwadi_id,$date,2,36,48);
            $memberAttandence[$j]['boys_4_5'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('4-5',$aanganwadi_id,$date,2,48,60);
            $memberAttandence[$j]['boys_5_6'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('5-6',$aanganwadi_id,$date,2,60,72);
            
            $memberAttandence[$j]['all_3_4'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('3-4',$aanganwadi_id,$date,0,36,48);
            $memberAttandence[$j]['all_4_5'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('4-5',$aanganwadi_id,$date,0,48,60);
            $memberAttandence[$j]['all_5_6'] = $this->kutumb_model->getTotalAttandenceOfMemberForDate('5-6',$aanganwadi_id,$date,0,60,72);
        }
        
        $data['activities']=$allactivities;
        $data['activitiesservices']=$getActivityOfAllDay;
        $data['totalActivityDays']=$cnt;
        $data['moreThanFourActivityDays'] = $moreThanFourActivityDays;
        $data['memberAttandence'] = $memberAttandence;
        //echo "<pre>";
        //print_r($data['activitiesservices']);
        $html = $this->load->view('admin/reports/44', $data,true);
        echo $html;exit;
    }
}