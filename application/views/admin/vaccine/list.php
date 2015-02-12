    <div class="container top">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
      <script src="<?php echo base_url(); ?>assets/js/vaccine.js"></script>
	  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	var $2 = jQuery.noConflict();
	$2(function() {
		$2( "#searchtxt" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'yy/mm/dd',});
		});
		</script>

      <ul class="breadcrumb">
        <li class="active">રસી</li>
      </ul>
	<div class="page-header users-header">
        <h2>
          રસી
		</h2>
      </div>
      <div class="row">
        <div class="span12 columns">
          <div class="well">
           <?php
           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform','method'=>'GET');
           
            $options_allvaccine = array(0 => "all");
            foreach ($allvaccine as $row)
            {
              $options_allvaccine[$row['id']] = $row['vaccine_name'];
            }
               
               $options_aanganvadi = array(0 => "all");
               foreach ($aanganvadi as $row)
               {
                   $options_aanganvadi[$row['id']] = $row['aanganvadi_name'];
               }
			
            echo form_open('vaccine', $attributes);
     	  	if($this->session->userdata('is_admin')==true)
			{
		  
              echo form_label('રસી:', 'vaccine_id');
              echo form_dropdown('vaccine_id', $options_allvaccine, $vaccine_selected, 'class="span2" id="vaccine_id"');
                
                echo form_label('આંગણવાડી:', 'aanganvadi_id');
                echo form_dropdown('aanganvadi_id', $options_aanganvadi, $aanganvadi_selected, 'class="span2" id="aanganvadi_id"');
                ?>&nbsp;&nbsp;
<?php
                
                $options_type = array('0'=>'પસંદ કરો','2'=>'બાકી','1'=>'આપેલ');
                echo form_dropdown('vaccine_type',$options_type,$vaccine_type,'class="span2" id="vaccine_type"');
                
			  echo '&nbsp;&nbsp;<input type="text" id="searchtxt" name="searchtxt" value="'.$searchtxt.'" />';
			  ?>
			  <input type="hidden" id="perpage" name="perpage" value="<?php echo $perpage ?>" />
			  <input type="hidden" id="currentpage" name="currentpage" value="<?php echo $currentpage ?>" />
			  <input type="button" class="btn btn-primary" value="શોધ કરવી" name="mysubmit" onclick="if(document.getElementById('aanganvadi_id').value != '0' || document.getElementById('vaccine_id').value != '0' || document.getElementById('searchtxt').value!='' || document.getElementById('vaccine_type').value!='0'){this.form.submit();} else {alert('Please select vaccine or search text.');}"><br /><br />
			 
<?php
}
else
{
    
	echo '<input type="text" id="searchtxt" name="searchtxt" value="'.$searchtxt.'" />';	  
			  ?>
			  <input type="hidden" id="perpage" name="perpage" value="<?php echo $perpage ?>" />
			  <input type="hidden" id="currentpage" name="currentpage" value="<?php echo $currentpage ?>" />
			  <input type="button" class="btn btn-primary" value="શોધ કરવી" name="mysubmit" onclick="this.form.submit();"><br /><br />
			  <?php
}
            echo form_close();
           ?>
			
			<table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</th>
				<th class="header">કુટુંબનો ક્રમ નંબર</th>
				<th class="yellow header headerSortDown">રસી નામ</th>
				<th class="red header">નામ</th>
                <th class="red header">યુ.આઈ.ડી. / આધાર નંબર</th>
                <th class="red header">જન્મ તારીખ</th>
                <th class="red header">જાતિ</th>
                <th class="red header">લક્ષ્યાંક કોડ</th>		
				<th class="red header">ખોડખાંપણ</th>		
				<th class="red header">આંગણવાડીની સેવાઓ</th>
                <th class="red header">આપવામાં તારીખ</th>				
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($vaccine as $row)
              {
                echo '<tr>';
				echo '<td>'.$row['family_rank'].'</td>';
                echo '<td>'.$row['person_rank'].'</td>';
				echo '<td>'.$row['vaccine_name'].'</td>';
				echo '<td>'.$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'].'</td>';
				echo '<td>'.$row['uid_aadharnumber'].'</td>';
				if($row['birth_date']=='' || $row['birth_date']=='0000-00-00 00:00:00')
					echo '<td>-</td>';
				else
					echo '<td>'.date('d-m-Y',strtotime($row['birth_date'])).'</td>';
				$gender='';
				if($row['gender']=='2')
					$gender='પુરૂષ';
				if($row['gender']=='3')
					$gender='સ્ત્રી';
				if($row['gender']=='4')
					$gender='ટ્રાન્સજેન્ડર';
				echo '<td>'.$gender.'</td>';
				
				$lakshyank_code='';
				if($row['lakshyank_code']=='2')
					$lakshyank_code='લાગુ નથી';
				if($row['lakshyank_code']=='3')
					$lakshyank_code='P- સગર્ભા';
				if($row['lakshyank_code']=='4')
					$lakshyank_code='L- ધાત્રી';
				if($row['lakshyank_code']=='5')
					$lakshyank_code='C- બાળક';
				if($row['lakshyank_code']=='6')
					$lakshyank_code='A- કિશોરી';
				echo '<td>'.$lakshyank_code.'</td>';
				
				$khodkhapan_type='';
				if($row['khodkhapan_type']=='2')
					$khodkhapan_type='કોઈ ખોડખાંપણ નથી';
				if($row['khodkhapan_type']=='3')
					$khodkhapan_type='હલનચલન';
				if($row['khodkhapan_type']=='4')
					$khodkhapan_type='માનસિક';
				if($row['khodkhapan_type']=='5')
					$khodkhapan_type='અંધાપો';
				if($row['khodkhapan_type']=='6')
					$khodkhapan_type='બહેરાશ';
				if($row['khodkhapan_type']=='7')
					$khodkhapan_type='મૂંગાપણું';
				echo '<td>'.$khodkhapan_type.'</td>';
				
				$services='';
				if($row['purv_prathmik_shikshan']=='1')
					$services.='પૂર્વ પ્રાથમિક શિક્ષણ';
				if($services!='')
					$services.=',';
				if($row['purak_aahar']=='1')
					$services.='પૂરક આહાર';
				echo '<td>'.$services.'</td>';
				
				if($row['given_date']=='' || $row['given_date']=='0000-00-00 00:00:00')
					echo '<td>-</td>';
				else
					echo '<td>'.date('d-m-Y',strtotime($row['given_date'])).'</td>';
				
              }
              ?>      
            </tbody>
          </table>

          <?php echo '<div class="pagination"><div class="pagingLeft"><select style="width:100px" id="rowsperpage" name="rowsperpage" onchange="changePaging()"><option value="20">20</option><option value="50">50</option><option value="75">75</option><option value="100">100</option></select></div><div class="pagingCenter"><input type"text" id="gotopage" name="gotopage" value="'.$currentpage.'" style="width:100px" onKeyPress="return changePage(event,this);" /></div><div class="pagingRight">'.$this->pagination->create_links().'</div><div style="clear:both"></div></div>'; ?>

          </div>
      </div>
    </div>
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript">
		var $ = jQuery.noConflict();
		$(document).ready(function(){
			$('#rowsperpage').val('<?php echo $perpage ?>');
		}
		);
		function changePage(e,textbox)
		{
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13 && document.getElementById('gotopage').value!='') { //Enter keycode
				$('#perpage').val($('#rowsperpage').val());
				$('#currentpage').val($('#gotopage').val());
				$("#myform").attr("action", '<?php echo base_url('vaccine/page') ?>/'+document.getElementById('gotopage').value);
				$('#myform').submit();				
			}
			else
			{			
				if (code > 31 && (code < 48 || code > 57)) {
				
                    return false;
                }
                return true;
			}
		}
		function changePaging()
		{
			$('#perpage').val($('#rowsperpage').val());
			$('#currentpage').val($('#gotopage').val());
			$("#myform").attr("action", '<?php echo base_url('vaccine/page') ?>/'+document.getElementById('gotopage').value);
			$('#myform').submit();
		}
		
	</script>