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
					if(parseInt(allMemberArray[i]['txtYear']) >= 14 && allMemberArray[i]['drpGender'] == '3')
					{
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
	var currentindex=0;
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
      if(isset($flash_message)){
        if($flash_message == TRUE)
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
     
      echo form_open('kutumb/addkutumb', $attributes);
      ?>
        <fieldset>
        <input type="hidden" id="familypersoninfo" name="familypersoninfo" value="" />
		<input type="hidden" id="aanganvadiid" name="aanganvadiid" value="<?php echo $aanganvadi_id ?>" />
          <?php
		  echo '<div class="main_container_width">';
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="jilla_id" class="control-label form_label_css">કુટુંબનો ક્રમ નંબરો <span style="color:#ff0000">*</span></label>';
				  echo '<input type="text" id="kutumb_krm_no" name="kutumb_krm_no" value="'.set_value('kutumb_krm_no').'" style="width:223px" >';
                echo '</div>';
          ?>
          
          <?php
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="taluka_id" class="control-label form_label_css">જાતિ <span style="color:#ff0000">*</span></label>';
				  echo form_dropdown('jati', $options_castArray, '1', 'class="span2 width230" id="jati"');				  
			  echo '</div>';
          ?>          
          <?php
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="gaam_id" class="control-label form_label_css">ધર્મ <span style="color:#ff0000">*</span></label>';
			      echo form_dropdown('dharm', $options_religionArray, '1', 'class="span2 width230" id="dharm"');				  
			  echo '</div>';
		  	echo '<div class="classclear"></div>';
		  echo '</div>';
          ?>          
          <div  class="main_container_width">
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css" >સ્થળ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
					<?php echo form_dropdown('sthal', $options_placeArray , '1', 'class="span2 width230" id="sthal"'); ?>				  
				</div>
			  </div>
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">&nbsp;</label>
				<div class="controls marginleft0">
				  <input type="text" id="sthallocation" name="sthallocation" value="<?php echo set_value('sthallocation'); ?>" class="width223">
				</div>
			  </div>          
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">રાજ્યમાં લઘુમતી છે. <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <select class="span width223" id="isLagumati" name="isLagumati"><option value="0">--પસંદ કરો--</option><option value="1">હા</option><option value="2">ના</option></select>
				</div>
			  </div>
			  <div class="classclear"></div>
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">નોંધણી <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" class="width223" id="k_nondhani_date" name="k_nondhani_date" value=""/>
				</div>
			  </div>
			  <div class="classclear"></div>
		  </div>
		  <div style="clear:both;padding-top:10px;">&nbsp;</div>  
		<div id="showcontentDiv">
			
		</div>

          <div class="form-actions submitdiv">
		  	 <a class="fancybox btn btn-primary" href="#addkutumbSabhyaDiv" onclick="cleardropdown();cleardata();addmember();">કુટુંબમા નવો સભ્ય ઉમેરો</a> &nbsp;&nbsp;
			 <a class="fancybox btn btn-primary" href="#addkutumbSabhyaDiv" onclick="cleardropdown();cleardata();navjatshishu();">
નવજાત શિશુ ઉમેરો</a>
			<a class="fancybox btn btn-primary" href="#addkutumbSabhyaDiv" onclick="cleardropdown();cleardata();sagrbha();">
સગર્ભા સ્ત્રી ઉમેરો</a>
			 <br /><br />
            <button class="btn btn-primary" onclick="if(Object.keys(allMemberArray).length == 0){ alert('Please add at least one family member'); return; }; checkvalidation('<?php echo base_url().'kutumb/checkvalidation'; ?>');" type="button">સેવ કરો</button>&nbsp
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
								<?php 
									$options_relation = array('' => "Select");
									  foreach ($gaam as $row)
									  {
										$options_relation[$row['id']] = $row['name_guj'];
									  }
								?>								
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
								<option value="sigerian">sigerian</option>
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
		//alert(url+'?ids='+str+'&aanganwadi_id='+$('#aanganvadiid').val());
		$.ajax({
			   url : url+'?ids='+str+'&aanganwadi_id='+$('#aanganvadiid').val(),
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
	 function closepopup()
	 {
	 	cleardata();
	 	var $= jQuery.noConflict();
		$.fancybox.close();
	 }
	 function cleardropdown()
	{
		document.getElementById('mothernamediv').innerHTML = '<select id="txtmothername" class="popuptxt" name="txtmothername" ></select>';
	}
	 function cleardata()
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
		
		document.getElementById('janm_samay').value='';
		document.getElementById('janm_sthal').value='';
		document.getElementById('janm_samaye_thayel_vajan_kilogram').value='';
		document.getElementById('janm_amaye_thayel_vajan_grams').value='';
		document.getElementById('dilevery_type').value='';
		document.getElementById('nondhani_date').value='';
		
		document.getElementById('lmp_date').value='';
		document.getElementById('miscarage_date').value='';
		
		$('#chkpurakAahar').prop('checked',false);
		$('#chkPrathmikEducation').prop('checked',false);
		$('#rdoRehvasiYes').prop('checked',false);
		$('#rdoRehvasiNo').prop('checked',false);
		
	 }
	 function SetDataIntoArray()
	 {
		
 		var $= jQuery.noConflict();
	    allMemberArray[currentindex] = {};
		//alert($('#lmp_date').is(':visible'));
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
		html='<table class="table table-striped table-bordered table-condensed"><thead><tr><th class="red header">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર</th><th class="red header">કુટુંબના સભ્યોના નામ</th><th class="red header">યુ.આઈ.ડી. / આધાર નંબર</th><th class="red header">જન્મ તારીખ</th><th class="red header">જાતિ</th><th class="red header">લક્ષ્યાંક કોડ</th><th class="red header">ખોડખાંપણ</th><th class="red header">આંગણવાડીની સેવાઓ</th></tr></thead>';
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
				html += '</tr>';
				
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
		$('#chkpurakAahar').attr('checked','false');
		$('#chkPrathmikEducation').attr('checked','false');
		$('#rdoRehvasiYes').attr('checked','false');
		$('#rdoRehvasiNo').attr('checked','false');
		
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