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
//		  $this->output->clear_all_cache();
		  echo '<div class="main_container_width">';
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="jilla_id" class="control-label form_label_css">કુટુંબનો ક્રમ નંબરો</label>';
				//echo '<div class="controls">';
				  echo '<input type="text" id="kutumb_krm_no" name="kutumb_krm_no" value="'.$familydata[0]['family_rank'].'" style="width:223px" >';
	
				//echo '</div>';
			  echo '</div>';
          ?>
          
          <?php
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="taluka_id" class="control-label form_label_css">જાતિ</label>';
				//echo '<div class="controls">';
				echo form_dropdown('jati', $options_castArray, $familydata[0]['jati_id'], 'class="span2 width230" id="jati"');
				/*
				  echo '<select class="span2 width230" id="jati" name="jati">';
				  	echo '<option value="0">--પસંદ કરો--</option>';
					for($i=1;$i<count($jati);$i++){
						$selected='';
						if($familydata[0]['jati_id'] == $i)
							$selected='selected="selected"';
						echo '<option '.$selected.' value="'.$i.'">'.$jati[$i].'</option>';
					}					
				echo '</select>';
	*/
				//echo '</div>';
			  echo '</div>';
          ?>
          
          <?php
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="gaam_id" class="control-label form_label_css">ધર્મ</label>';
				//echo '<div class="controls">';
				echo form_dropdown('dharm', $options_religionArray,$familydata[0]['dharm_id'], 'class="span2 width230" id="dharm"');
				/*
				  echo '<select class="span2 width230" id="dharm" name="dharm">';
				  	echo '<option value="0">--પસંદ કરો--</option>';
					for($i=1;$i<count($dhrm);$i++){
						$selected='';
						if($familydata[0]['dharm_id'] == $i)
							$selected='selected="selected"';
						echo '<option '.$selected.' value="'.$i.'">'.$dhrm[$i].'</option>';
					}					
				echo '</select>';
	*/
				//echo '</div>';
			  echo '</div>';
		  	echo '<div class="classclear"></div>';
		  echo '</div>';
          ?>
          
          <div  class="main_container_width">
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css" >સ્થળ</label>
				<div class="controls marginleft0">
				<?php echo form_dropdown('sthal', $options_placeArray , $familydata[0]['sthal_id'], 'class="span2 width230" id="sthal"');
				/*
				
				  <select class="span width223" id="sthal" name="sthal">
				  	<option value="0">--પસંદ કરો--</option>
					<?php
					for($i=1;$i<count($sthl);$i++){
						$selected='';
						if($familydata[0]['sthal_id'] == $i)
							$selected='selected="selected"';
						echo '<option '.$selected.' value="'.$i.'">'.$sthl[$i].'</option>';
					}	
					?>
				</select>
				*/
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
				<label for="inputError" class="control-label form_label_css">રાજ્યમાં લઘુમતી છે.</label>
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
						<th class="red header">&nbsp;</th>
					</tr>
				</thead>

			<?php
			/*echo "<pre>";
			print_r($familydata[0]['persondata']);
			echo "</pre>";*/
			?>
			<script>
			var arrayindex=0;
			</script>
			<?php
				for($i =0;$i<count($familydata[0]['persondata']) ; $i++)
				{
					if($familydata[0]['persondata'][$i]['birth_date'] != '0000-00-00 00:00:00')
						$familydata[0]['persondata'][$i]['birth_date'] = date('d/m/Y',strtotime($familydata[0]['persondata'][$i]['birth_date']));
					else 
						$familydata[0]['persondata'][$i]['birth_date'] = '';
						
					
					if($familydata[0]['persondata'][$i]['gam_shift_date'] != '0000-00-00 00:00:00')
						$familydata[0]['persondata'][$i]['gam_shift_date'] = date('d/m/Y',strtotime($familydata[0]['persondata'][$i]['gam_shift_date']));
					else 
						$familydata[0]['persondata'][$i]['gam_shift_date'] = '';
						
					if($familydata[0]['persondata'][$i]['gam_out_shift_date'] != '0000-00-00 00:00:00')
						$familydata[0]['persondata'][$i]['gam_out_shift_date'] = date('d/m/Y',strtotime($familydata[0]['persondata'][$i]['gam_out_shift_date']));
					else 
						$familydata[0]['persondata'][$i]['gam_out_shift_date'] = '';
						
					if($familydata[0]['persondata'][$i]['die_date'] != '0000-00-00 00:00:00')
						$familydata[0]['persondata'][$i]['die_date'] = date('d/m/Y',strtotime($familydata[0]['persondata'][$i]['die_date']));
					else 
						$familydata[0]['persondata'][$i]['die_date'] = '';
						
					
					echo '<tr><td class="red header">'.$familydata[0]['persondata'][$i]['person_rank'].'</td>';
					echo '<td class="red header">'.$familydata[0]['persondata'][$i]['first_name'].' '.$familydata[0]['persondata'][$i]['middle_name'].' '.$familydata[0]['persondata'][$i]['last_name'].'</td>';
					echo '<td class="red header">'.$familydata[0]['persondata'][$i]['uid_aadharnumber'].'</td>';
					echo '<td class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('.$i.');">Edit</a></td></tr>';

					?>
					<script>
					
					allMemberArray[arrayindex] = {};	
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
					allMemberArray[arrayindex]['txtOutSthadantrarDate'] = '<?php echo $familydata[0]['persondata'][$i]['gam_out_shift_date'] ?>';
					allMemberArray[arrayindex]['txtDeathDate'] = '<?php echo $familydata[0]['persondata'][$i]['die_date'] ?>';		
					allMemberArray[arrayindex]['chkpurakAahar'] = '<?php echo $familydata[0]['persondata'][$i]['purak_aahar'] ?>';
					allMemberArray[arrayindex]['chkPrathmikEducation'] = '<?php echo $familydata[0]['persondata'][$i]['purv_prathmik_shikshan'] ?>';
					allMemberArray[arrayindex]['rdoRehvasi'] = '<?php echo $familydata[0]['persondata'][$i]['anganwadi_kendra_vistar_rehvasi'] ?>';
					
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
		  <a  class="fancybox btn btn-primary" href="#addkutumbSabhyaDiv" onclick="cleardata();">કુટુંબ વ્યક્તિ ઉમેરો</a><a class="fancybox" id="openfancy" href="#addkutumbSabhyaDiv"></a>
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
								<!--
								<select class="popuptxt" id="drpRelation" name="drpRelation" >
									<option value="0">--પસંદ કરો--</option>
									<option value="1">પોતે</option>
									<option value="2">પત્નિ</option>
									<option value="3">પતિ</option>
									<option value="4">પુત્ર</option>
									<option value="5">પુત્રી</option>
									<option value="6">પુત્રવધૂ</option>
									<option value="7">પૌત્ર</option>
									<option value="8">પૌત્રવધુ</option>
									<option value="9">પ્રપૌત્ર</option>
									<option value="10">પ્રપૌત્રવધુ</option>
									<option value="11">પ્રપૌત્રી</option>
									<option value="12">જમાઈ</option>
									<option value="13">ભાણેજ</option>
									<option value="14">ભાણજી</option>
									<option value="15">દોહિત્ર</option>
									<option value="16">દોહિત્રી</option>
									<option value="17">દતક પુત્ર</option>
									<option value="18">દતક પુત્રી</option>
									<option value="19">અનાથ</option>									
									<option value="20">પૌત્રી</option>
									<option value="21">ભાઈ</option>
									<option value="22">ભાભી</option>
									<option value="23">બહેન</option>
									<option value="24">ભત્રીજી</option>
									<option value="25">ભત્રીજા</option>
								</select>
								-->
				            </td>
				        </tr>
				        <tr>
				            <td>
				                જાતિ (પુરૂષ/સ્ત્રી)<br>
								<?php echo form_dropdown('drpGender', $options_genderArray, '1', 'class="popuptxt" id="drpGender"'); ?>
								<!--
                				<select class="popuptxt" id="drpGender" name="drpGender">
									<option value="0">--પસંદ કરો--</option>
									<option value="1">પુરૂષ</option>
									<option value="2">સ્ત્રી</option>
									<option value="3">ટ્રાન્સજેન્ડર</option>
								</select>
								-->
				            </td>
				            <td>
				                હાલનો વૈવાહિક દરજ્જો<br>
								<?php echo form_dropdown('drpdarjo', $options_maritalStatusArray, '1', 'class="popuptxt" id="drpdarjo"'); ?>
								<!--
                				<select class="popuptxt" id="drpdarjo" name="drpdarjo">
									<option value="0">--પસંદ કરો--</option>
									<option value="1">પરિણીત</option>
									<option value="2">અપરિણીત</option>
									<option value="3">વિધુર</option>
									<option value="3">વિધવા</option>
									<option value="3">ત્યકતા</option>
								</select>
								-->
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
                				<input type="text" class="popuptxt" id="txtmothername" name="txtmothername">
				            </td>
				            <td style="width: 20%;">
				                લક્ષ્યાંક કોડ<br>
								<?php echo form_dropdown('drplakshyank', $options_targetCodeArray, '1', 'class="popuptxt" id="drplakshyank"'); ?>
								<!--
                				<select class="popuptxt" id="drplakshyank" name="drplakshyank">
									<option value="0">લાગુ નથી</option>
									<option value="P">P- સગર્ભા</option>
									<option value="L">L- ધાત્રી</option>
									<option value="C">C- બાળક</option>
									<option value="A">A- કિશોરી</option>
								</select>
								-->
				            </td>
				            <td style="width: 20%;">
				                ખોડખાંપણ નો પ્રકાર જો હોય તો<br>
								<?php echo form_dropdown('drpKhodkhapan', $options_malformationTypeArray, '1', 'class="popuptxt" id="drpKhodkhapan"'); ?>
								<!--
                				<select class="popuptxt" id="drpKhodkhapan" name="drpKhodkhapan">
									<option value="0">કોઈ ખોડખાંપણ નથી</option>
									<option value="1">હલનચલન</option>
									<option value="2">માનસિક</option>
									<option value="3">અંધાપો</option>
									<option value="4">બહેરાશ</option>
									<option value="5">મૂંગાપણું</option>
								</select>
								-->
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
	 	if(mode == "add")
		{
			allMemberArray[currentindex] = {};	
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
			
			var $= jQuery.noConflict();
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
			//alert(Object.keys(allMemberArray).length);
			//alert(JSON.stringify(allMemberArray));
			/*html='<div><div class="popupdatadiv">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</div><div class="popupdatadiv">કુટુંબના સભ્યોના નામ</div><div class="popupdatadiv"> યુ.આઈ.ડી. / આધાર નંબર</div><div style="clear:both"></div></div><div>';
			for(var i =0;i<Object.keys(allMemberArray).length ; i++)
			{
				html += '<div class="popupdatadiv">'+allMemberArray[i]['txtPersonNumber']+'</div>';
				html += '<div class="popupdatadiv">'+allMemberArray[i]['txtfname']+'</div>';
				html += '<div class="popupdatadiv">'+allMemberArray[i]['txtaadhar']+'</div>';
				html += '<div class="popupdatadiv"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+');">Edit</a></div>';
				html += '<div style="clear:both"></div>';
			}
			html += '</div>';*/
			
			html='<table class="table table-striped table-bordered table-condensed"><thead><tr><th class="red header">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</th><th class="red header">કુટુંબના સભ્યોના નામ</th><th class="red header">યુ.આઈ.ડી. / આધાર નંબર</th></tr></thead>';
			for(var i =0;i<Object.keys(allMemberArray).length ; i++)
			{
				html += '<tr><td class="red header">'+allMemberArray[i]['txtPersonNumber']+'</td>';
				html += '<th class="red header">'+allMemberArray[i]['txtfname']+' '+allMemberArray[i]['txtmname']+' '+allMemberArray[i]['txtlname']+'</td>';
				html += '<th class="red header">'+allMemberArray[i]['txtaadhar']+'</td>';
				html += '<th class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+');">Edit</a></td></tr>';
				
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
			
			document.getElementById('familypersoninfo').value = JSON.stringify(allMemberArray);
			

			$.fancybox.close();
		}
		else
		{
//		alert('edit');
			allMemberArray[currenteditindex] = {};	
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
			
			var $= jQuery.noConflict();
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
			//alert(Object.keys(allMemberArray).length);
//			alert(JSON.stringify(allMemberArray));
/*
			html='<div><div class="popupdatadiv">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</div><div class="popupdatadiv">કુટુંબના સભ્યોના નામ</div><div class="popupdatadiv"> યુ.આઈ.ડી. / આધાર નંબર</div><div style="clear:both"></div></div><div>';
			for(var i =0;i<Object.keys(allMemberArray).length ; i++)
			{
				html += '<div class="popupdatadiv">'+allMemberArray[i]['txtPersonNumber']+'</div>';
				html += '<div class="popupdatadiv">'+allMemberArray[i]['txtfname']+'</div>';
				html += '<div class="popupdatadiv">'+allMemberArray[i]['txtaadhar']+'</div>';

				html += '<div class="popupdatadiv"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+');">Edit</a></div>';
				html += '<div style="clear:both"></div>';
			}
			html += '</div>';*/
			
			html='<table class="table table-striped table-bordered table-condensed"><thead><tr><th class="red header">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</th><th class="red header">કુટુંબના સભ્યોના નામ</th><th class="red header">યુ.આઈ.ડી. / આધાર નંબર</th></tr></thead>';
			for(var i =0;i<Object.keys(allMemberArray).length ; i++)
			{
				html += '<tr><td class="red header">'+allMemberArray[i]['txtPersonNumber']+'</td>';
				html += '<th class="red header">'+allMemberArray[i]['txtfname']+' '+allMemberArray[i]['txtmname']+' '+allMemberArray[i]['txtlname']+'</td>';
				html += '<th class="red header">'+allMemberArray[i]['txtaadhar']+'</td>';
				html += '<th class="red header"><a href="javascript:void(0)" onclick="mode=\'edit\'; filldata('+i+');">Edit</a></td></tr>';
				
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
			
			document.getElementById('familypersoninfo').value = JSON.stringify(allMemberArray);
			
			mode='add';
			$.fancybox.close();
			
		}
	 }
	 function filldata(i)
	 {
		 currenteditindex = i;
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
		
		var $= jQuery.noConflict();
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