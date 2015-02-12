    <style type="text/css">
		.popuptxt{width:150px;}
		.popupdatadiv{float:left;width:200px}
		.radioclass{float:left}
		.radiolbl{float:left}
	</style>
	
	  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	var $2 = jQuery.noConflict();
	$2(function() {
		$2( "#txtDeathDate" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'dd/mm/yy',});
		$2( "#txtOutSthadantrarDate" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'dd/mm/yy',});
		$2( "#txtsthantarDate" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'dd/mm/yy',});
		
		$2( "#nondhani_date" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'dd/mm/yy',});
		$2( "#k_nondhani_date" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'dd/mm/yy',});
		$2( "#lmp_date" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'dd/mm/yy',});
		$2( "#miscarage_date" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'dd/mm/yy',});
		
		$2('#txtBirthDate').datepicker( {
		changeMonth: true,
		changeYear: true,
		maxDate: '0',
		yearRange: "-100:+0",
		dateFormat: 'dd/mm/yy',
		onSelect: function(dateText, inst) {
			var date = $2(this).datepicker('getDate');
			var d = new Date();
			var month = d.getMonth();
			var aprilDate;
			

			if(month > 3)
			{			
				aprilDate = new Date(d.getFullYear(),3,date.getDate());				
			}
			else if(month < 3)
			{
				aprilDate = new Date(d.getFullYear()-1,3,date.getDate());				
			}
			else
			{
				if(d.getDate() < date.getDate())
				{
					aprilDate = new Date(d.getFullYear()-1,3,date.getDate());				
				}
				else
				{
					aprilDate = new Date(d.getFullYear(),3,date.getDate());				
				}
			}
			//alert(aprilDate);
			var allMonths= aprilDate.getMonth() - date.getMonth() + (12 * (aprilDate.getFullYear() - date.getFullYear()));
			var allYears= aprilDate.getFullYear() - date.getFullYear();
			var partialMonths = aprilDate.getMonth() - date.getMonth();
			if (partialMonths < 0 && allYears ==0) {
				partialMonths=0;
			}
			if (partialMonths < 0) {
				allYears--;
				partialMonths = partialMonths + 12;
			}
			$2('#txtYear').val(allYears);
			$2('#txtMonth').val(partialMonths);
			if((parseInt(allYears) < 6) || (parseInt(allYears) == 6 || parseInt(partialMonths) == 0))
			{
				
				html ='<select id="txtmothername" class="popuptxt" name="txtmothername" ><option value=""></option>';
				for(var i =0;i<Object.keys(allMemberArray).length ; i++)
				{
					//alert(parseInt(allMemberArray[i]['txtYear'])+' '+allMemberArray[i]['drpGender']);
					if(parseInt(allMemberArray[i]['txtYear']) >= 14 && allMemberArray[i]['drpGender'] == '3')
					{
						//alert("hihello");
						html += '<option value="'+allMemberArray[i]['txtfname']+' '+allMemberArray[i]['txtmname']+' '+allMemberArray[i]['txtlname']+'">'+allMemberArray[i]['txtfname']+' '+allMemberArray[i]['txtmname']+' '+allMemberArray[i]['txtlname']+'</option>';					
					}
				}
				html += '</select>';
				document.getElementById('mothernamediv').innerHTML = html;
			}
			else
			{
				html ='<select id="txtmothername" class="popuptxt" name="txtmothername" ><option value=""></option>';
				html += '</select>';
				document.getElementById('mothernamediv').innerHTML = html;
			}
			//alert(partialMonths+' months and -- '+allYears);
//			alert(JSON.stringify(inst));
		}		
	});
		
		
	});

</script>

	<script>
	var allMemberArray = {};
	var currentindex=<?php echo count($familydata[0]['persondata']) ?>;
	var currenteditindex=0;
	var mode='add';
	
	
	</script>
	<div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/anganvadi.js"></script>
	  <!-- Add jQuery library -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib/jquery-1.10.1.min.js"></script>

	  <!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js//source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
	
	<script type="text/javascript">

	$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */
var $= jQuery.noConflict();
			$('.fancybox').fancybox();
	});
</script>
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
            કુટુંબ
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">કુટુંબ નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          કુટુંબ નોંધણી
        </h2>
      </div>
 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'કુટુંબ નોંધણી થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'કુટુંબ નોંધણી થઇ નથી. ફરીથી પ્રયત્ન કરો.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => 'frm');
      $options_castArray = array();
      foreach ($castArray as $row)
      {
        $options_castArray[$row['id']] = $row['name_guj'];
      }
	  $options_religionArray = array();
      foreach ($religionArray as $row)
      {
        $options_religionArray[$row['id']] = $row['name_guj'];
      }
	  $options_placeArray = array();
      foreach ($placeArray as $row)
      {
        $options_placeArray[$row['id']] = $row['name_guj'];
      }
	  $options_relationArray = array();
      foreach ($relationArray as $row)
      {
        $options_relationArray[$row['id']] = $row['name_guj'];
      }
	  $options_genderArray = array();
      foreach ($genderArray as $row)
      {
        $options_genderArray[$row['id']] = $row['name_guj'];
      }
	  $options_maritalStatusArray = array();
      foreach ($maritalStatusArray as $row)
      {
        $options_maritalStatusArray[$row['id']] = $row['name_guj'];
      }
	  $options_targetCodeArray = array();
      foreach ($targetCodeArray as $row)
      {
        $options_targetCodeArray[$row['id']] = $row['name_guj'];
      }
	  $options_malformationTypeArray = array();
      foreach ($malformationTypeArray as $row)
      {
        $options_malformationTypeArray[$row['id']] = $row['name_guj'];
      }
      //form validation
      echo validation_errors();
      
      echo form_open('kutumb/update/'.$this->uri->segment(3).'', $attributes);
      ?>
        <fieldset>
        <input type="hidden" id="familypersoninfo" name="familypersoninfo" value="" />
		<input type="hidden" id="aanganvadiid" name="aanganvadiid" value="<?php echo $aanganvadi_id ?>" />
		<input type="hidden" id="family_id" name="family_id" value="<?php echo $familydata[0]['family_id'] ?>" />
          <?php
		    $jati = array('-','અનુ.જાતિ','અનુ.જનજાતિ','સામાજીક અને શૈક્ષણિક રીતે પછાત','અન્ય');
			$dhrm = array('-','બુદ્ધ','ખ્રિસ્તી','હિંદુ','ઇસ્લામ','જૈન','શીખ','અન્ય');
			$sthl = array('-','શેરી','વાસ','ફળીયું','વોર્ડ');
			$laghu = array('-','હા','ના');

		  echo '<div class="main_container_width">';
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="jilla_id" class="control-label form_label_css">કુટુંબનો ક્રમ નંબરો <span style="color:#ff0000">*</span></label>';
				  echo '<input type="text" id="kutumb_krm_no" name="kutumb_krm_no" value="'.$familydata[0]['family_rank'].'" style="width:223px" >';
			  echo '</div>';
          ?>
          
          <?php
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="taluka_id" class="control-label form_label_css">જાતિ <span style="color:#ff0000">*</span></label>';
				echo form_dropdown('jati', $options_castArray, $familydata[0]['jati_id'], 'class="span2 width230" id="jati"');
			  echo '</div>';
          ?>
          
          <?php
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="gaam_id" class="control-label form_label_css">ધર્મ <span style="color:#ff0000">*</span></label>';
				echo form_dropdown('dharm', $options_religionArray,$familydata[0]['dharm_id'], 'class="span2 width230" id="dharm"');
			  echo '</div>';
		  	echo '<div class="classclear"></div>';
		  echo '</div>';
          ?>
          
          <div  class="main_container_width">
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css" >સ્થળ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				<?php echo form_dropdown('sthal', $options_placeArray , $familydata[0]['sthal_id'], 'class="span2 width230" id="sthal"');
				 ?>
				</div>
			  </div>
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">&nbsp;</label>
				<div class="controls marginleft0">
				  <input type="text" id="sthallocation" name="sthallocation" value="<?php echo $familydata[0]['sthal_value'] ?>" class="width223">
				</div>
			  </div>          
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">રાજ્યમાં લઘુમતી છે. <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <select class="span width223" id="isLagumati" name="isLagumati">
				  	<option value="0">--પસંદ કરો--</option>
					<?php
					for($i=1;$i<count($laghu);$i++){
						$selected='';
						if($familydata[0]['laghumati'] == $i)
							$selected='selected="selected"';
						echo '<option '.$selected.' value="'.$i.'">'.$laghu[$i].'</option>';
					}
					?>
				</select>
				</div>
			  </div>
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">નોંધણી <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" class="width223" id="k_nondhani_date" name="k_nondhani_date" value="<?php echo $familydata[0]['nondhani_date'] ?>"/>
				</div>
			  </div>
			  <div class="classclear"></div>
		  </div>
		  <div style="clear:both;padding-top:10px;">&nbsp;</div>  
		  <div id="showcontentDiv">
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th class="red header">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</th>
						<th class="red header">કુટુંબના સભ્યોના નામ</th>
						<th class="red header">યુ.આઈ.ડી. / આધાર નંબર</th>
						<th class="red header">જન્મ તારીખ</th>
						<th class="red header">જાતિ</th>
						<th class="red header">લક્ષ્યાંક કોડ</th>
						<th class="red header">ખોડખાંપણ</th>
						<th class="red header">આંગણવાડીની સેવાઓ</th>
						<th class="red header">&nbsp;</th>
					</tr>
				</thead>

			<?php
			?>
			<script>
			var arrayindex=0;
			</script>
			<?php
                //echo "<pre>";print_r($familydata[0]['persondata']);
				for($i =0;$i<count($familydata[0]['persondata']) ; $i++)
				{
					if($familydata[0]['persondata'][$i]['birth_date'] != '0000-00-00')
						$familydata[0]['persondata'][$i]['birth_date'] = date('d/m/Y',strtotime($familydata[0]['persondata'][$i]['birth_date']));
					else 
						$familydata[0]['persondata'][$i]['birth_date'] = '';
						
					
					if($familydata[0]['persondata'][$i]['gam_shift_date'] != '0000-00-00')
						$familydata[0]['persondata'][$i]['gam_shift_date'] = date('d/m/Y',strtotime($familydata[0]['persondata'][$i]['gam_shift_date']));
					else 
						$familydata[0]['persondata'][$i]['gam_shift_date'] = '';
						
					if($familydata[0]['persondata'][$i]['gam_out_shift_date'] != '0000-00-00')
						$familydata[0]['persondata'][$i]['gam_out_shift_date'] = date('d/m/Y',strtotime($familydata[0]['persondata'][$i]['gam_out_shift_date']));
					else 
						$familydata[0]['persondata'][$i]['gam_out_shift_date'] = '';
						
					if($familydata[0]['persondata'][$i]['die_date'] != '0000-00-00')
						$familydata[0]['persondata'][$i]['die_date'] = date('d/m/Y',strtotime($familydata[0]['persondata'][$i]['die_date']));
					else 
						$familydata[0]['persondata'][$i]['die_date'] = '';
						
					
					echo '<tr><td class="red header">'.$familydata[0]['persondata'][$i]['person_rank'].'</td>';
					echo '<td class="red header">'.$familydata[0]['persondata'][$i]['first_name'].' '.$familydata[0]['persondata'][$i]['middle_name'].' '.$familydata[0]['persondata'][$i]['last_name'].'</td>';
					echo '<td class="red header">'.$familydata[0]['persondata'][$i]['uid_aadharnumber'].'</td>';
					echo '<td class="red header">'.$familydata[0]['persondata'][$i]['birth_date'].'</td>';
					echo '<td class="red header">'.$options_genderArray[$familydata[0]['persondata'][$i]['gender']].'</td>';
					echo '<td class="red header">'.$options_targetCodeArray[$familydata[0]['persondata'][$i]['lakshyank_code']].'</td>';
					echo '<td class="red header">'.$options_malformationTypeArray[$familydata[0]['persondata'][$i]['khodkhapan_type']].'</td>';
					$str='';
					if($familydata[0]['persondata'][$i]['purak_aahar'] == '1')
						$str .= 'પૂરક આહાર';
					if($familydata[0]['persondata'][$i]['purv_prathmik_shikshan'] == '1')
					{
						if($str != '')
							$str .= ',';
						$str .= 'પૂર્વ પ્રાથમિક શિક્ષણ';
					}
					echo '<td class="red header">'.$str.'</td>';
					if($familydata[0]['persondata'][$i]['gender']==3 && (($familydata[0]['persondata'][$i]['ageIn_year'] ==0 &&  $familydata[0]['persondata'][$i]['ageIn_month'] > 6) || $familydata[0]['persondata'][$i]['ageIn_year'] > 0))
					{
						echo '<td class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('.$i.',0);">Edit</a> &nbsp; <a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('.$i.',1);">Edit sagrbha detail</a></td></tr>';
					}
					else
					{
						echo '<td class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('.$i.',0);">Edit</a></td></tr>';
					}

					?>
					<script>
					
					allMemberArray[arrayindex] = {};	
					allMemberArray[arrayindex]['family_person_id'] = '<?php echo $familydata[0]['persondata'][$i]['family_person_id'] ?>';
					allMemberArray[arrayindex]['edit_type'] = '0';
					allMemberArray[arrayindex]['txtaadhar'] = '<?php echo $familydata[0]['persondata'][$i]['uid_aadharnumber'] ?>';
					allMemberArray[arrayindex]['txtfname'] = '<?php echo $familydata[0]['persondata'][$i]['first_name'] ?>';
					allMemberArray[arrayindex]['txtPersonNumber'] = '<?php echo $familydata[0]['persondata'][$i]['person_rank'] ?>';
					allMemberArray[arrayindex]['txtmname'] = '<?php echo $familydata[0]['persondata'][$i]['middle_name'] ?>';
					allMemberArray[arrayindex]['txtlname'] = '<?php echo $familydata[0]['persondata'][$i]['last_name'] ?>';
					allMemberArray[arrayindex]['drpRelation'] = '<?php echo $familydata[0]['persondata'][$i]['relation_with_main_person'] ?>';
					allMemberArray[arrayindex]['drpGender'] = '<?php echo $familydata[0]['persondata'][$i]['gender'] ?>';
					allMemberArray[arrayindex]['drpdarjo'] = '<?php echo $familydata[0]['persondata'][$i]['merridial_status'] ?>';
					allMemberArray[arrayindex]['txtBirthDate'] = '<?php echo $familydata[0]['persondata'][$i]['birth_date'] ?>';
					allMemberArray[arrayindex]['txtYear'] = '<?php echo $familydata[0]['persondata'][$i]['ageIn_year'] ?>';
					allMemberArray[arrayindex]['txtMonth'] = '<?php echo $familydata[0]['persondata'][$i]['ageIn_month'] ?>';
					allMemberArray[arrayindex]['txtmothername'] = '<?php echo $familydata[0]['persondata'][$i]['mother_name'] ?>';
					allMemberArray[arrayindex]['drplakshyank'] = '<?php echo $familydata[0]['persondata'][$i]['lakshyank_code'] ?>';
					allMemberArray[arrayindex]['drpKhodkhapan'] = '<?php echo $familydata[0]['persondata'][$i]['khodkhapan_type'] ?>';
					allMemberArray[arrayindex]['txtsthantarDate'] = '<?php echo $familydata[0]['persondata'][$i]['gam_shift_date'] ?>';
console.log('allMemberArray '+allMemberArray[arrayindex]['family_person_id']+'-<?php echo $familydata[0]['persondata'][$i]['gam_shift_date'] ?> -'+allMemberArray[arrayindex]['txtsthantarDate']);
allMemberArray[arrayindex]['txtOutSthadantrarDate'] = '<?php echo $familydata[0]['persondata'][$i]['gam_out_shift_date'] ?>';
					allMemberArray[arrayindex]['txtDeathDate'] = '<?php echo $familydata[0]['persondata'][$i]['die_date'] ?>';		
					allMemberArray[arrayindex]['chkpurakAahar'] = '<?php echo $familydata[0]['persondata'][$i]['purak_aahar'] ?>';
					allMemberArray[arrayindex]['chkPrathmikEducation'] = '<?php echo $familydata[0]['persondata'][$i]['purv_prathmik_shikshan'] ?>';
					allMemberArray[arrayindex]['rdoRehvasi'] = '<?php echo $familydata[0]['persondata'][$i]['anganwadi_kendra_vistar_rehvasi'] ?>';
					
					allMemberArray[arrayindex]['drpGenderText'] = '<?php echo $options_genderArray[$familydata[0]['persondata'][$i]['gender']] ?>';
					allMemberArray[arrayindex]['drplakshyankText'] = '<?php echo $options_targetCodeArray[$familydata[0]['persondata'][$i]['lakshyank_code']] ?>';
					allMemberArray[arrayindex]['drpKhodkhapanText'] = '<?php echo $options_malformationTypeArray[$familydata[0]['persondata'][$i]['khodkhapan_type']] ?>';
					
					
					allMemberArray[arrayindex]['janm_samay'] = '<?php echo $familydata[0]['persondata'][$i]['janm_samay'] ?>';
					allMemberArray[arrayindex]['janm_sthal'] = '<?php echo $familydata[0]['persondata'][$i]['janm_sthal'] ?>';
					allMemberArray[arrayindex]['janm_samaye_thayel_vajan_kilogram'] = '<?php echo $familydata[0]['persondata'][$i]['janm_samaye_thayel_vajan_kilogram'] ?>';
					allMemberArray[arrayindex]['janm_amaye_thayel_vajan_grams'] = '<?php echo $familydata[0]['persondata'][$i]['janm_amaye_thayel_vajan_grams'] ?>';
					allMemberArray[arrayindex]['dilevery_type'] = '<?php echo $familydata[0]['persondata'][$i]['dilevery_type'] ?>';
					allMemberArray[arrayindex]['nondhani_date'] = '<?php echo $familydata[0]['persondata'][$i]['nondhani_date'] ?>';
					allMemberArray[arrayindex]['lmp_date'] = '<?php echo $familydata[0]['persondata'][$i]['lmp_date'] ?>';
					allMemberArray[arrayindex]['miscarage_date'] = '<?php echo $familydata[0]['persondata'][$i]['miscarage_date'] ?>';

					arrayindex++;
		</script>	
		
		<?php
				}
				
			?>
			<script>
			document.getElementById('familypersoninfo').value = JSON.stringify(allMemberArray);
			</script>
			</table>
		</div>
		  
          <div class="form-actions submitdiv">
		  <a  class="fancybox btn btn-primary" href="#addkutumbSabhyaDiv" onclick="cleardropdown();cleardata();addmember();">કુટુંબમા નવો સભ્ય ઉમેરો</a><a class="fancybox" id="openfancy" href="#addkutumbSabhyaDiv"></a>
		  <a class="fancybox btn btn-primary" href="#addkutumbSabhyaDiv" onclick="cleardropdown();cleardata();navjatshishu();">
નવજાત શિશુ ઉમેરો</a>
			<a class="fancybox btn btn-primary" href="#addkutumbSabhyaDiv" onclick="cleardropdown();cleardata();sagrbha();">
સગર્ભા સ્ત્રી ઉમેરો</a>
		  <br /><br />
            <button class="btn btn-primary" onclick="if(Object.keys(allMemberArray).length == 0){ alert('Please add at least one family member'); return; }; checkvalidation('<?php echo base_url().'kutumb/checkvalidation'; ?>');" type="button">સેવ કરો</button> 
          </div>
        </fieldset>
		
		
		<div style="display:none">
			<div id="addkutumbSabhyaDiv">
				<table cellspacing="10" cellpadding="0" width="100%">
        			<tbody>
						<tr>
            				<td>
                				કુટુંબમાં વ્યક્તિનો ક્રમ નંબર<br>
                				<input type="text" class="popuptxt" id="txtPersonNumber" name="txtPersonNumber">
            				</td>
            				<td>
                				યુ.આઈ.ડી. / આધાર નંબર<br>
                				<input type="text" class="popuptxt" id="txtaadhar" name="txtaadhar" >
            				</td>
            				<td colspan="2">
                				કુટુંબના સભ્યોના નામ (શરૂઆત કુટુંબના વડાથી કરવી)<br>
                				<table cellspacing="0" width="100%">
                    				<tbody>
										<tr>
                        					<td style="padding-right: 5px;">
                            					<input type="text" class="popuptxt" id="txtfname" name="txtfname">                            					
                        					</td>
					                        <td style="padding-right: 5px;">
                    					        <input type="text" class="popuptxt" id="txtmname" name="txtmname">
					                        </td>
                    					    <td>
					                            <input type="text" class="popuptxt" id="txtlname" name="txtlname">
                                            </td>
                    					</tr>
					                </tbody>
								</table>
				            </td>
            				<td>
				                કુટુંબના વડા સાથેનો સબંધ<br>
								<?php echo form_dropdown('drpRelation', $options_relationArray , '1', 'class="popuptxt" id="drpRelation"'); ?>
				            </td>
				        </tr>
				        <tr>
				            <td>
				                જાતિ (પુરૂષ/સ્ત્રી)<br>
								<?php echo form_dropdown('drpGender', $options_genderArray, '1', 'class="popuptxt" id="drpGender"'); ?>
				            </td>
				            <td>
				                હાલનો વૈવાહિક દરજ્જો<br>
								<?php echo form_dropdown('drpdarjo', $options_maritalStatusArray, '1', 'class="popuptxt" id="drpdarjo"'); ?>
				            </td>
				            <td>
				                જન્મ તારીખ<br>
                				<input type="text" class="popuptxt" id="txtBirthDate" name="txtBirthDate">
				            </td>
				            <td colspan="2">
                				&nbsp; એપ્રિલમાં થતી ઉમર (પુરા થયેલ વર્ષ અને મહિના)<br>
				                <table>
    	        			        <tbody>
										<tr>
					                        <td style="padding-right: 5px;">
                					            <input type="text" class="popuptxt" id="txtYear" name="txtYear" readonly="readonly" onkeypress="return onlyNos(event,this);">
				    	                    </td>
                    					    <td>
                            					<input type="text" class="popuptxt" id="txtMonth" name="txtMonth"  readonly="readonly" onkeypress="return onlyNos(event,this);">
					                        </td>
					                    </tr>
						            </tbody>
								</table>
				            </td>
				        </tr>
				        <tr>
				            <td style="width: 20%;">
				                માતાનું નામ (0-6 વર્ષના બાળકો માટે)<br>
                				<!-- <input type="text" class="popuptxt" id="txtmothername" name="txtmothername"> -->
								<div id="mothernamediv"><select id="txtmothername" class="popuptxt" name="txtmothername" ></select></div>
				            </td>
				            <td style="width: 20%;">
				                લક્ષ્યાંક કોડ<br>
								<?php echo form_dropdown('drplakshyank', $options_targetCodeArray, '1', 'class="popuptxt" id="drplakshyank"'); ?>
				            </td>
				            <td style="width: 20%;">
				                ખોડખાંપણ નો પ્રકાર જો હોય તો<br>
								<?php echo form_dropdown('drpKhodkhapan', $options_malformationTypeArray, '1', 'class="popuptxt" id="drpKhodkhapan"'); ?>
							</td>
							<td style="width: 20%;">
								આંગણવાડી કેન્દ્ર વિસ્તારના રહેવાસી છે?<br>
								<input type="radio" value="rdoRehvasiYes" name="a" class="radioclass" id="rdoRehvasiYes"><label class="radiolbl" for="rdoRehvasiYes">હા</label>
								<input type="radio" value="rdoRehvasiNo" name="a" class="radioclass" id="rdoRehvasiNo"><label class="radiolbl" for="rdoRehvasiNo">ના</label>
							</td>
							<td style="width: 20%;">
								ગામમાં સ્થળાંતર કરીને આવેલ તારીખ<br>
								<input type="text" class="popuptxt" id="txtsthantarDate" name="txtsthantarDate">
							</td>
						</tr>
						<tr>
						<td>
							ગામમાંથી બહાર સ્થળાંતર કરેલ તારીખ<br>
							<input type="text" class="popuptxt" id="txtOutSthadantrarDate" name="txtOutSthadantrarDate">
						</td>
						<td>
							મરણ તારીખ<br>
							<input type="text" class="popuptxt" id="txtDeathDate" name="txtDeathDate">
						</td>
						<td colspan="">
							આંગણવાડીની નીચેની સેવાઓ પ્રાપ્ત કરવાની ઈચ્છા ધરાવે છે?<div style="width:153px">
							<input type="checkbox" name="chkpurakAahar" style="" id="chkpurakAahar"><label style="width:100px;float:right" for="chkpurakAahar">પૂરક આહાર</label></div><div style="width:171px">
							&nbsp;&nbsp;<input type="checkbox" style="" name="chkPrathmikEducation" id="chkPrathmikEducation"><label style="width:110px;float:right" for="chkPrathmikEducation">પૂર્વ પ્રાથમિક શિક્ષણ</label></div>
						</td>
						<td>
						</td>
        			</tr>
					<tr id="navjatshishuTr1">
						<td>
							જન્મ સમય
							<input class="popuptxt" type="text" id="janm_samay" name="janm_samay" value="" />
						</td>
						<td>
							જન્મ સ્થળ
							<input class="popuptxt" type="text" id="janm_sthal" name="janm_sthal" value="" />
						</td>
						<td>
							ડિલીવરી પ્રકાર
							<select id="dilevery_type" name="dilevery_type">
								<option value="">પસંદ કરો</option>
								<option value="Kudarati">કુદરતી</option>
								<option value="Sigerian">sigerian</option>
							</select>
						</td>
					</tr>
					<tr id="navjatshishuTr2">
						<td>
							જન્મ સમયે કિલોગ્રામ વજન
							<input class="popuptxt" type="text" id="janm_samaye_thayel_vajan_kilogram" name="janm_samaye_thayel_vajan_kilogram" value="" />
						</td>
						<td>
							જન્મ સમયે ગ્રામ વજન
							<input class="popuptxt" type="text" id="janm_amaye_thayel_vajan_grams" name="janm_amaye_thayel_vajan_grams" value="" />
						</td>
						
					</tr>
					<tr id="sagrbhaTr1">
						<td>
							LMP તારીખ
							<input class="popuptxt" type="text" id="lmp_date" name="lmp_date" value="" />
						</td>
						<td>
							કસુવાવડ તારીખ
							<input class="popuptxt" type="text" id="miscarage_date" name="miscarage_date" value="" />
						</td>
						
					</tr>
					<tr>
						<td>
							નોંધણી તારીખ
							<input class="popuptxt" type="text" id="nondhani_date" name="nondhani_date" />
						</td>
					</tr>
        			<tr>
						<td colspan="2">
							<input type="button" class="butan" id="btnSubmit" onclick="return SetDataIntoArray();" value="સબમિટ" name="btnSubmit">
							&nbsp;<input type="button" class="butan" id="btnCancel" onclick="closepopup();" value="રદ કરવું" name="btnCancel">
						</td>
						<td colspan="2">&nbsp;
							
						</td>
						<td>&nbsp;
							
						</td>
			        </tr>
			    </tbody>
			</table>
		</div>
		</div>
      <?php echo form_close(); ?>

    </div>
     <script>
	 function navjatshishu()
	 {
	 	$ = jQuery.noConflict();
	 	$('#navjatshishuTr1').css('display','table-row');
		$('#navjatshishuTr2').css('display','table-row');
		$('#sagrbhaTr1').css('display','none');
		
		html ='<select id="txtmothername" class="popuptxt" name="txtmothername" ><option value=""></option>';
				for(var i =0;i<Object.keys(allMemberArray).length ; i++)
				{
					//alert(parseInt(allMemberArray[i]['txtYear'])+' '+allMemberArray[i]['drpGender']);
					if(parseInt(allMemberArray[i]['txtYear']) >= 14 && allMemberArray[i]['drpGender'] == '3')
					{
						//alert("hihello");
						html += '<option value="'+allMemberArray[i]['txtfname']+' '+allMemberArray[i]['txtmname']+' '+allMemberArray[i]['txtlname']+'">'+allMemberArray[i]['txtfname']+' '+allMemberArray[i]['txtmname']+' '+allMemberArray[i]['txtlname']+'</option>';					
					}
				}
				html += '</select>';
				document.getElementById('mothernamediv').innerHTML = html;
	 }
	 function sagrbha()
	 {
	 	$ = jQuery.noConflict();
	 	$('#navjatshishuTr1').css('display','none');
		$('#navjatshishuTr2').css('display','none');
		$('#sagrbhaTr1').css('display','table-row');
	 }
	  function addmember()
	 {	 
	 	$ = jQuery.noConflict();

	 	$('#navjatshishuTr1').css('display','none');
		$('#navjatshishuTr2').css('display','none');
		$('#sagrbhaTr1').css('display','none');
	 }
	 function checkvalidation(url){
	 	$ = jQuery.noConflict();
		var str='';
		str+=$('#kutumb_krm_no').val();
		for(var i =0;i<Object.keys(allMemberArray).length ; i++)
		{
			str += '-'+allMemberArray[i]['txtPersonNumber'];
		}	
		//alert(url+'?ids='+str+'&aanganwadi_id='+$('#aanganvadiid').val()+'&familyid='+$('#family_id').val());
		$.ajax({
			   url : url+'?ids='+str+'&aanganwadi_id='+$('#aanganvadiid').val()+'&familyid='+$('#family_id').val(),
			   type: "POST",
			   data : '',
			   success:function(data, textStatus, jqXHR)
			   {
					//alert(data);
					if(data.trim()=='')
					{
						document.getElementById('frm').submit();
					}
					else
					{
						alert(data);
						return false;
					}
			   },
			   error: function(jqXHR, textStatus, errorThrown)
			   {
					alert("error"+textStatus);           
			   }
		});
	}
	function cleardropdown()
	{
		document.getElementById('mothernamediv').innerHTML = '<select id="txtmothername" class="popuptxt" name="txtmothername" ></select>';
	}
	function cleardata()
	 {
	 	//if(mode=="add")
		{
	 	var $= jQuery.noConflict();
		document.getElementById('txtaadhar').value='';
		document.getElementById('txtfname').value='';
		document.getElementById('txtOutSthadantrarDate').value='';
		document.getElementById('txtPersonNumber').value='';
		document.getElementById('txtmname').value='';
		document.getElementById('txtlname').value='';
		document.getElementById('drpRelation').value='1';
		document.getElementById('drpGender').value='1';
		document.getElementById('drpdarjo').value='1';
		document.getElementById('txtBirthDate').value='';
		document.getElementById('txtYear').value='';
		document.getElementById('txtMonth').value='';
		document.getElementById('txtmothername').value='';
		document.getElementById('drplakshyank').value='1';
		document.getElementById('drpKhodkhapan').value='1';
		document.getElementById('txtsthantarDate').value='';
		document.getElementById('txtDeathDate').value='';
		$('#chkpurakAahar').prop('checked',false);
		$('#chkPrathmikEducation').prop('checked',false);
		$('#rdoRehvasiYes').prop('checked',false);
		$('#rdoRehvasiNo').prop('checked',false);
		
		document.getElementById('janm_samay').value='';
		document.getElementById('janm_sthal').value='';
		document.getElementById('janm_samaye_thayel_vajan_kilogram').value='';
		document.getElementById('janm_amaye_thayel_vajan_grams').value='';
		document.getElementById('dilevery_type').value='';
		document.getElementById('nondhani_date').value='';
		
		document.getElementById('lmp_date').value='';
		document.getElementById('miscarage_date').value='';
		}
	 }
	 function closepopup()
	 {
	 	cleardata();
	 	var $= jQuery.noConflict();
		
		$.fancybox.close();
	 }
	 function SetDataIntoArray()
	 {
	 	var $= jQuery.noConflict();
		if(document.getElementById('txtfname').value == '')
		{
			alert("Please enter first name");
			return;
		}
		if(document.getElementById('txtmname').value == '')
		{
			alert("Please enter middle name");
			return;
		}
		if(document.getElementById('txtlname').value == '')
		{
			alert("Please enter last name");
			return;
		}
		if(document.getElementById('drpGender').value == '')
		{
			alert("Please select gender");
			return;
		}
		if(document.getElementById('txtBirthDate').value == '')
		{
			alert("Please select birth date");
			return;
		}
	 	if(document.getElementById('nondhani_date').value == '')
		{
			alert("Please enter nondhani date");
			return;
		}
		if(document.getElementById('miscarage_date').value != '' && document.getElementById('lmp_date').value == '') 
		{
			alert("Please enter lmp date");
			return;
		}
		if(((parseInt(document.getElementById('txtMonth').value) > 6 && parseInt(document.getElementById('txtYear').value) == 0) || parseInt(document.getElementById('txtYear').value) > 1) && $('#navjatshishuTr1').is(':visible')) 
		{
			alert("Register it as member");
			return;
		}
		if(parseInt(document.getElementById('txtMonth').value) <= 6 && parseInt(document.getElementById('txtYear').value) == 0 && !$('#navjatshishuTr1').is(':visible')) 
		{
			alert("Register it as navjat shishu");
			return;
		}
		if($('#navjatshishuTr1').is(':visible') && document.getElementById('txtmothername').value == '')
		{
			alert("Please select mother name");
			return;
		}
		
		
	 	if(mode == "add")
		{
			var $= jQuery.noConflict();
			
			
			
			allMemberArray[currentindex] = {};	
			allMemberArray[currentindex]['family_person_id'] = '0';
			allMemberArray[currentindex]['edit_type'] = '1';
			allMemberArray[currentindex]['txtaadhar'] = document.getElementById('txtaadhar').value;
			allMemberArray[currentindex]['txtfname'] = document.getElementById('txtfname').value;
			allMemberArray[currentindex]['txtPersonNumber'] = document.getElementById('txtPersonNumber').value;
			allMemberArray[currentindex]['txtmname'] = document.getElementById('txtmname').value;
			allMemberArray[currentindex]['txtlname'] = document.getElementById('txtlname').value;
			allMemberArray[currentindex]['drpRelation'] = document.getElementById('drpRelation').value;
			allMemberArray[currentindex]['drpGender'] = document.getElementById('drpGender').value;
			allMemberArray[currentindex]['drpdarjo'] = document.getElementById('drpdarjo').value;
			allMemberArray[currentindex]['txtBirthDate'] = document.getElementById('txtBirthDate').value;
			allMemberArray[currentindex]['txtYear'] = document.getElementById('txtYear').value;
			allMemberArray[currentindex]['txtMonth'] = document.getElementById('txtMonth').value;
			allMemberArray[currentindex]['txtmothername'] = document.getElementById('txtmothername').value;
			allMemberArray[currentindex]['drplakshyank'] = document.getElementById('drplakshyank').value;
			allMemberArray[currentindex]['drpKhodkhapan'] = document.getElementById('drpKhodkhapan').value;
			allMemberArray[currentindex]['txtsthantarDate'] = document.getElementById('txtsthantarDate').value;
			allMemberArray[currentindex]['txtOutSthadantrarDate'] = document.getElementById('txtOutSthadantrarDate').value;
			allMemberArray[currentindex]['txtDeathDate'] = document.getElementById('txtDeathDate').value;		
			
			
			allMemberArray[currentindex]['drpGenderText'] = $("#drpGender option:selected").text();
			allMemberArray[currentindex]['drplakshyankText'] = $("#drplakshyank option:selected").text();
			allMemberArray[currentindex]['drpKhodkhapanText'] = $("#drpKhodkhapan option:selected").text();
			
			allMemberArray[currentindex]['janm_samay'] = document.getElementById('janm_samay').value;
			allMemberArray[currentindex]['janm_sthal'] = document.getElementById('janm_sthal').value;
			allMemberArray[currentindex]['janm_samaye_thayel_vajan_kilogram'] = document.getElementById('janm_samaye_thayel_vajan_kilogram').value;
			allMemberArray[currentindex]['janm_amaye_thayel_vajan_grams'] = document.getElementById('janm_amaye_thayel_vajan_grams').value;
			allMemberArray[currentindex]['dilevery_type'] = document.getElementById('dilevery_type').value;
			allMemberArray[currentindex]['nondhani_date'] = document.getElementById('nondhani_date').value;
			
			allMemberArray[currentindex]['lmp_date'] = document.getElementById('lmp_date').value;
			allMemberArray[currentindex]['miscarage_date'] = document.getElementById('miscarage_date').value;

			if($('#chkpurakAahar').is(':checked'))		
			{
				allMemberArray[currentindex]['chkpurakAahar'] = '1';
			}
			else
			{
				allMemberArray[currentindex]['chkpurakAahar'] = '0';
			}
			if($('#chkPrathmikEducation').is(':checked'))		
			{
				allMemberArray[currentindex]['chkPrathmikEducation'] = '1';
			}
			else
			{
				allMemberArray[currentindex]['chkPrathmikEducation'] = '0';
			}
			if($('#rdoRehvasiYes').is(':checked'))
			{
				allMemberArray[currentindex]['rdoRehvasi'] = '1';
			}
			else
			{
				allMemberArray[currentindex]['rdoRehvasi'] = '0';
			}
			
			currentindex++;		
						
			html='<table class="table table-striped table-bordered table-condensed"><thead><tr><th class="red header">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</th><th class="red header">કુટુંબના સભ્યોના નામ</th><th class="red header">યુ.આઈ.ડી. / આધાર નંબર</th><th class="red header">જન્મ તારીખ</th><th class="red header">જાતિ</th><th class="red header">લક્ષ્યાંક કોડ</th><th class="red header">ખોડખાંપણ</th><th class="red header">આંગણવાડીની સેવાઓ</th><th class="red header">&nbsp;</th></tr></thead>';
			for(var i =0;i<Object.keys(allMemberArray).length ; i++)
			{
				html += '<tr><td class="red header">'+allMemberArray[i]['txtPersonNumber']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['txtfname']+' '+allMemberArray[i]['txtmname']+' '+allMemberArray[i]['txtlname']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['txtaadhar']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['txtBirthDate']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['drpGenderText']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['drplakshyankText']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['drpKhodkhapanText']+'</td>';
				var str='';
				if(allMemberArray[i]['chkpurakAahar'] == '1')
					str += 'પૂરક આહાર';
				if(allMemberArray[i]['chkPrathmikEducation'] == '1')
				{
					if(str != '')
						str += ','
					str += 'પૂર્વ પ્રાથમિક શિક્ષણ';
				}
				html += '<td class="red header">'+str+'</td>';
				if(allMemberArray[i]['drpGender']==3 && ((parseInt(allMemberArray[i]['txtYear']) ==0 &&  parseInt(allMemberArray[i]['txtMonth']) > 6) || parseInt(allMemberArray[i]['txtYear']) > 0))
				{
					html += '<td class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+',0);">Edit</a>&nbsp;<a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+',1);">Edit sagrbha detail</a></td></tr>';
				}
				else
				{
					html += '<td class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+',0);">Edit</a></td></tr>';
				}
				
			}
			html += '</table>';
			
			
            
              
			  
			//alert(html);
			document.getElementById('showcontentDiv').innerHTML = html;
			
			document.getElementById('txtaadhar').value='';
			document.getElementById('txtfname').value='';
			document.getElementById('txtOutSthadantrarDate').value='';
			document.getElementById('txtPersonNumber').value='';
			document.getElementById('txtmname').value='';
			document.getElementById('txtlname').value='';
			document.getElementById('drpRelation').value='1';
			document.getElementById('drpGender').value='1';
			document.getElementById('drpdarjo').value='1';
			document.getElementById('txtBirthDate').value='';
			document.getElementById('txtYear').value='';
			document.getElementById('txtMonth').value='';
			document.getElementById('txtmothername').value='';
			document.getElementById('drplakshyank').value='1';
			document.getElementById('drpKhodkhapan').value='1';
			document.getElementById('txtsthantarDate').value='';
			document.getElementById('txtDeathDate').value='';
			$('#chkpurakAahar').prop('checked',false);
			$('#chkPrathmikEducation').prop('checked',false);
			$('#rdoRehvasiYes').prop('checked',false);
			$('#rdoRehvasiNo').prop('checked',false);
			
			document.getElementById('janm_samay').value='';
		document.getElementById('janm_sthal').value='';
		document.getElementById('janm_samaye_thayel_vajan_kilogram').value='';
		document.getElementById('janm_amaye_thayel_vajan_grams').value='';
		document.getElementById('dilevery_type').value='';
		document.getElementById('nondhani_date').value='';
		
		document.getElementById('lmp_date').value='';
		document.getElementById('miscarage_date').value='';
			
			document.getElementById('familypersoninfo').value = JSON.stringify(allMemberArray);
			

			$.fancybox.close();
		}
		else
		{
			var $= jQuery.noConflict();
			var family_person_id = allMemberArray[currenteditindex]['family_person_id'];
		//alert(JSON.stringify(allMemberArray[currenteditindex]));
			allMemberArray[currenteditindex] = {};	
			allMemberArray[currenteditindex]['family_person_id'] = family_person_id;
			allMemberArray[currenteditindex]['edit_type'] = '2';
			allMemberArray[currenteditindex]['txtaadhar'] = document.getElementById('txtaadhar').value;
			allMemberArray[currenteditindex]['txtfname'] = document.getElementById('txtfname').value;
			allMemberArray[currenteditindex]['txtPersonNumber'] = document.getElementById('txtPersonNumber').value;
			allMemberArray[currenteditindex]['txtmname'] = document.getElementById('txtmname').value;
			allMemberArray[currenteditindex]['txtlname'] = document.getElementById('txtlname').value;
			allMemberArray[currenteditindex]['drpRelation'] = document.getElementById('drpRelation').value;
			allMemberArray[currenteditindex]['drpGender'] = document.getElementById('drpGender').value;
			allMemberArray[currenteditindex]['drpdarjo'] = document.getElementById('drpdarjo').value;
			allMemberArray[currenteditindex]['txtBirthDate'] = document.getElementById('txtBirthDate').value;
			allMemberArray[currenteditindex]['txtYear'] = document.getElementById('txtYear').value;
			allMemberArray[currenteditindex]['txtMonth'] = document.getElementById('txtMonth').value;
			allMemberArray[currenteditindex]['txtmothername'] = document.getElementById('txtmothername').value;
			allMemberArray[currenteditindex]['drplakshyank'] = document.getElementById('drplakshyank').value;
			allMemberArray[currenteditindex]['drpKhodkhapan'] = document.getElementById('drpKhodkhapan').value;
			allMemberArray[currenteditindex]['txtsthantarDate'] = document.getElementById('txtsthantarDate').value;
			allMemberArray[currenteditindex]['txtOutSthadantrarDate'] = document.getElementById('txtOutSthadantrarDate').value;
			allMemberArray[currenteditindex]['txtDeathDate'] = document.getElementById('txtDeathDate').value;	
			
			allMemberArray[currenteditindex]['drpGenderText'] = $("#drpGender option:selected").text();
			allMemberArray[currenteditindex]['drplakshyankText'] = $("#drplakshyank option:selected").text();
			allMemberArray[currenteditindex]['drpKhodkhapanText'] = $("#drpKhodkhapan option:selected").text();
			
			allMemberArray[currenteditindex]['janm_samay'] = document.getElementById('janm_samay').value;
			allMemberArray[currenteditindex]['janm_sthal'] = document.getElementById('janm_sthal').value;
			allMemberArray[currenteditindex]['janm_samaye_thayel_vajan_kilogram'] = document.getElementById('janm_samaye_thayel_vajan_kilogram').value;
			allMemberArray[currenteditindex]['janm_amaye_thayel_vajan_grams'] = document.getElementById('janm_amaye_thayel_vajan_grams').value;
			allMemberArray[currenteditindex]['dilevery_type'] = document.getElementById('dilevery_type').value;
			allMemberArray[currenteditindex]['nondhani_date'] = document.getElementById('nondhani_date').value;
			
			allMemberArray[currenteditindex]['lmp_date'] = document.getElementById('lmp_date').value;
			allMemberArray[currenteditindex]['miscarage_date'] = document.getElementById('miscarage_date').value;
			
			
			if($('#chkpurakAahar').is(':checked'))		
			{
				allMemberArray[currenteditindex]['chkpurakAahar'] = '1';
			}
			else
			{
				allMemberArray[currenteditindex]['chkpurakAahar'] = '0';
			}
			if($('#chkPrathmikEducation').is(':checked'))		
			{
				allMemberArray[currenteditindex]['chkPrathmikEducation'] = '1';
			}
			else
			{
				allMemberArray[currenteditindex]['chkPrathmikEducation'] = '0';
			}
			if($('#rdoRehvasiYes').is(':checked'))
			{
				allMemberArray[currenteditindex]['rdoRehvasi'] = '1';
			}
			else
			{
				allMemberArray[currenteditindex]['rdoRehvasi'] = '0';
			}
				
			currenteditindex++;		
			html='<table class="table table-striped table-bordered table-condensed"><thead><tr><th class="red header">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</th><th class="red header">કુટુંબના સભ્યોના નામ</th><th class="red header">યુ.આઈ.ડી. / આધાર નંબર</th><th class="red header">જન્મ તારીખ</th><th class="red header">જાતિ</th><th class="red header">લક્ષ્યાંક કોડ</th><th class="red header">ખોડખાંપણ</th><th class="red header">આંગણવાડીની સેવાઓ</th><th>&nbsp;</th></tr></thead>';
			for(var i =0;i<Object.keys(allMemberArray).length ; i++)
			{
				html += '<tr><td class="red header">'+allMemberArray[i]['txtPersonNumber']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['txtfname']+' '+allMemberArray[i]['txtmname']+' '+allMemberArray[i]['txtlname']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['txtaadhar']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['txtBirthDate']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['drpGenderText']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['drplakshyankText']+'</td>';
				html += '<td class="red header">'+allMemberArray[i]['drpKhodkhapanText']+'</td>';
				
				var str='';
				if(allMemberArray[i]['chkpurakAahar'] == '1')
					str += 'પૂરક આહાર';
				if(allMemberArray[i]['chkPrathmikEducation'] == '1')
				{
					if(str != '')
						str += ','
					str += 'પૂર્વ પ્રાથમિક શિક્ષણ';
				}
				html += '<td class="red header">'+str+'</td>';
				
				if(allMemberArray[i]['drpGender']==3 && ((parseInt(allMemberArray[i]['txtYear']) ==0 &&  parseInt(allMemberArray[i]['txtMonth']) > 6) || parseInt(allMemberArray[i]['txtYear']) > 0))
				{
					html += '<td class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+',0);">Edit</a>&nbsp;<a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+',1);">Edit sagrbha detail</a></td></tr>';
				}
				else
				{
					html += '<td class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+',0);">Edit</a></td></tr>';
				}
				
			}
			html += '</table>';
			
			//alert(html);
			document.getElementById('showcontentDiv').innerHTML = html;
			
			document.getElementById('txtaadhar').value='';
			document.getElementById('txtfname').value='';
			document.getElementById('txtOutSthadantrarDate').value='';
			document.getElementById('txtPersonNumber').value='';
			document.getElementById('txtmname').value='';
			document.getElementById('txtlname').value='';
			document.getElementById('drpRelation').value='1';
			document.getElementById('drpGender').value='1';
			document.getElementById('drpdarjo').value='1';
			document.getElementById('txtBirthDate').value='';
			document.getElementById('txtYear').value='';
			document.getElementById('txtMonth').value='';
			document.getElementById('txtmothername').value='';
			document.getElementById('drplakshyank').value='1';
			document.getElementById('drpKhodkhapan').value='1';
			document.getElementById('txtsthantarDate').value='';
			document.getElementById('txtDeathDate').value='';
			$('#chkpurakAahar').prop('checked',false);
			$('#chkPrathmikEducation').prop('checked',false);
			$('#rdoRehvasiYes').prop('checked',false);
			$('#rdoRehvasiNo').prop('checked',false);
			
			document.getElementById('janm_samay').value='';
		document.getElementById('janm_sthal').value='';
		document.getElementById('janm_samaye_thayel_vajan_kilogram').value='';
		document.getElementById('janm_amaye_thayel_vajan_grams').value='';
		document.getElementById('dilevery_type').value='';
		document.getElementById('nondhani_date').value='';
		
		document.getElementById('lmp_date').value='';
		document.getElementById('miscarage_date').value='';
			
			document.getElementById('familypersoninfo').value = JSON.stringify(allMemberArray);
			
			mode='add';
			$.fancybox.close();
			
		}
	 }
	 function filldata(i,iseditsagrbha)
	 {
		 currenteditindex = i;
		 		var $= jQuery.noConflict();
		 if(parseInt(allMemberArray[i]['txtYear'])==0 && parseInt(allMemberArray[i]['txtMonth']) < 6)
		 {
		 	$('#navjatshishuTr1').css('display','table-row');
			$('#navjatshishuTr2').css('display','table-row');
			$('#sagrbhaTr1').css('display','none');
		 }
		 else if(iseditsagrbha || (allMemberArray[i]['lmp_date'] != '' && allMemberArray[i]['lmp_date'] != '0000-00-00'))
		 {
		 	$('#navjatshishuTr1').css('display','none');
			$('#navjatshishuTr2').css('display','none');
			$('#sagrbhaTr1').css('display','table-row');
		 }
		 else
		 {
		 	$('#navjatshishuTr1').css('display','none');
			$('#navjatshishuTr2').css('display','none');
			$('#sagrbhaTr1').css('display','none');
		 }
	 	document.getElementById('txtaadhar').value=allMemberArray[i]['txtaadhar'];
		document.getElementById('txtfname').value=allMemberArray[i]['txtfname'];
		document.getElementById('txtOutSthadantrarDate').value=allMemberArray[i]['txtOutSthadantrarDate'];
		document.getElementById('txtPersonNumber').value=allMemberArray[i]['txtPersonNumber'];
		document.getElementById('txtmname').value=allMemberArray[i]['txtmname'];
		document.getElementById('txtlname').value=allMemberArray[i]['txtlname'];
		document.getElementById('drpRelation').value=allMemberArray[i]['drpRelation'];
		document.getElementById('drpGender').value=allMemberArray[i]['drpGender'];
		document.getElementById('drpdarjo').value=allMemberArray[i]['drpdarjo'];
		document.getElementById('txtBirthDate').value=allMemberArray[i]['txtBirthDate'];
		document.getElementById('txtYear').value=allMemberArray[i]['txtYear'];
		document.getElementById('txtMonth').value=allMemberArray[i]['txtMonth'];
		document.getElementById('txtmothername').value=allMemberArray[i]['txtmothername'];
		document.getElementById('drplakshyank').value=allMemberArray[i]['drplakshyank'];
		document.getElementById('drpKhodkhapan').value=allMemberArray[i]['drpKhodkhapan'];
		document.getElementById('txtsthantarDate').value=allMemberArray[i]['txtsthantarDate'];
		document.getElementById('txtDeathDate').value=allMemberArray[i]['txtDeathDate'];
		
		document.getElementById('janm_samay').value=allMemberArray[i]['janm_samay'];
		document.getElementById('janm_sthal').value=allMemberArray[i]['janm_sthal'];
		document.getElementById('janm_samaye_thayel_vajan_kilogram').value=allMemberArray[i]['janm_samaye_thayel_vajan_kilogram'];
		document.getElementById('janm_amaye_thayel_vajan_grams').value=allMemberArray[i]['janm_amaye_thayel_vajan_grams'];
		document.getElementById('dilevery_type').value=allMemberArray[i]['dilevery_type'];
		document.getElementById('nondhani_date').value=allMemberArray[i]['nondhani_date'];
		
		if(allMemberArray[i]['lmp_date'] != '0000-00-00')
			document.getElementById('lmp_date').value=allMemberArray[i]['lmp_date'];
		
		if(allMemberArray[i]['miscarage_date'] != '0000-00-00')
			document.getElementById('miscarage_date').value=allMemberArray[i]['miscarage_date'];
			
		//	alert(allMemberArray[i]['dilevery_type'])
		
		if((parseInt(allMemberArray[i]['txtYear']) < 6) || (parseInt(allMemberArray[i]['txtYear']) == 6 || parseInt(allMemberArray[i]['txtMonth']) == 0))
		{
			html ='<select id="txtmothername" class="popuptxt" name="txtmothername" ><option value=""></option>';
			for(var j =0;j<Object.keys(allMemberArray).length ; j++)
			{
				if(parseInt(allMemberArray[j]['txtYear']) >= 14 && allMemberArray[j]['drpGender'] == '3')
				{
					var selected='';
					if(allMemberArray[i]['txtmothername'] == allMemberArray[j]['txtfname']+' '+allMemberArray[j]['txtmname']+' '+allMemberArray[j]['txtlname'])
					{
						selected = 'selected="selected"';
					}
					html += '<option '+selected+' value="'+allMemberArray[j]['txtfname']+' '+allMemberArray[j]['txtmname']+' '+allMemberArray[j]['txtlname']+'">'+allMemberArray[j]['txtfname']+' '+allMemberArray[j]['txtmname']+' '+allMemberArray[j]['txtlname']+'</option>';					
					
				}
			}
			html += '</select>';
			document.getElementById('mothernamediv').innerHTML = html;
		}
		else
		{
		}
			
		

		if(allMemberArray[i]['chkpurakAahar'] == '1')
		{
			$('#chkpurakAahar').prop('checked',true);
		}
		if(allMemberArray[i]['chkPrathmikEducation'] == '1')
		{
			$('#chkPrathmikEducation').prop('checked',true);
		}
		if(allMemberArray[i]['rdoRehvasi'] == '1')
		{
			$('#rdoRehvasiYes').prop('checked',true);
		}
		if(allMemberArray[i]['rdoRehvasi'] == '0')
		{
			$('#rdoRehvasiNo').prop('checked',true);
		}
		$('#openfancy').click();
		
	 }
	 function onlyNos(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
            catch (err) {
                alert(err.Description);
            }
        } 
	 </script>