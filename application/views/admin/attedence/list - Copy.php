    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	var $2 = jQuery.noConflict();
	$2(function() {
		$2( "#date" ).datepicker({maxDate: '0',yearRange: "-100:+0",dateFormat: 'yy/mm/dd',});
		});
		</script>
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
	var $= jQuery.noConflict();
			$('.fancybox').fancybox();
	
	</script>
	<div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/anganvadi.js"></script>
      <ul class="breadcrumb">
        <li class="active">કુટુંબ</li>
      </ul>
	<div class="page-header users-header">
        <h2>
          હાજરી		  
        </h2>
      </div>
      <div class="row">
        <div class="span12 columns">
          <div class="well">           
            <?php           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');           
            $options_jilla = array(0 => "all");
            foreach ($jilla as $row)
            {
              $options_jilla[$row['id']] = $row['name_guj'];
            }
			
			$options_taluka = array(0 => "all");
            foreach ($taluka as $row)
            {
              $options_taluka[$row['id']] = $row['name_guj'];
            }
			
			$options_gaam = array(0 => "all");
            foreach ($gaam as $row)
            {
              $options_gaam[$row['id']] = $row['name_guj'];
            }
			
			$options_aanganvadi = array(0 => "all");
            foreach ($aanganvadi as $row)
            {
              $options_aanganvadi[$row['id']] = $row['aanganvadi_name'];
            }
			
			
            //save the columns names in a array that we will use as filter         
            $options_attendance = array(0 => "all");    
            foreach ($attedence as $array) {
              foreach ($array as $key => $value) {
                $options_attendance[$key] = $key;
              }
              break;
            }

            echo form_open('attendance', $attributes);
     
              //echo form_label('Search:', 'search_string');
              //echo form_input('search_string', $search_string_selected, 'style="width: 170px;height: 26px;"');

		  	if($this->session->userdata('is_admin')==true)
			{
		  
              echo form_label('જીલ્લો:', 'jilla_id');
              echo form_dropdown('jilla_id', $options_jilla, $jilla_selected, 'class="span2" onchange="fetchTaluko(this.value,\''.base_url().'aanganvadi/fetchTaluko\')"');
			  
			  echo form_label('તાલુકો:', 'taluka_id');
              echo form_dropdown('taluka_id', $options_taluka, $taluka_selected, 'class="span2" onchange="fetchGaam(this.value,\''.base_url().'aanganvadi/fetchGaam\')" id="taluka_id"');
			  
			  echo form_label('ગામ:', 'gaam_id');
              echo form_dropdown('gaam_id', $options_gaam, $gaam_selected, 'class="span2"  id="gaam_id" onchange="fetchAanganvadi(this.value,\''.base_url().'aanganvadi/fetchAanganvadi\')"');
			  
			  echo form_label('આંગણવાડી', 'aanganvadi_id');
              echo form_dropdown('aanganvadi_id', $options_aanganvadi, $aanganwadiid_selected, 'class="span2"  id="aanganvadi_id"');
			  ?>
			  &nbsp;&nbsp;<input type="text" id="date" name="date" value="<?php echo $date ?>" />
			  <input type="button" class="btn btn-primary" value="શોધ કરવી" name="mysubmit" onclick="this.form.submit();">
<?php
			}
			else
			
			{
			?> 
			&nbsp;&nbsp;<input type="text" id="date" name="date" value="<?php echo $date ?>" />
			  <input type="button" class="btn btn-primary" value="શોધ કરવી" name="mysubmit" onclick="this.form.submit();">
			<?php
			}
			?>
			<input type="hidden" id="perpage" name="perpage" value="<?php echo $perpage ?>" />
			  <input type="hidden" id="currentpage" name="currentpage" value="<?php echo $currentpage ?>" />
			<?php
            echo form_close();
            ?>
			<br />
			<table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">ક્રમ નંબર</th>
                <th class="yellow header headerSortDown">આંગણવાડી નામ</th>
				<th class="red header">આંગણવાડી સ્થળ</th>
                <th class="red header">સરનામું</th>
                <th class="red header">જીલ્લો</th>
                <th class="red header">તાલુકો</th>
                <th class="red header">ગામ</th>
                <th class="red header">તારીખ</th>
                <th class="red header">પ્રથમ ફોટો</th>
                <th class="red header">બીજા ફોટો</th>
                <th width="15%" class="red header">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($attedence as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['attendance_id'].'</td>';
                echo '<td>'.$row['aanganvadi_name'].'</td>';
				echo '<td>'.$row['place'].'</td>';
                echo '<td>'.$row['address'].'</td>';
                echo '<td>'.$row['jilla_name'].'</td>';
				echo '<td>'.$row['taluka_name'].'</td>';
				echo '<td>'.$row['gaam_name'].'</td>';
                echo '<td>'.date('d/m/Y',strtotime($row['attendance_date'])).'</td>';
				if($row['first_photo']=='')
	                echo '<td>-</td>';
				else
					echo '<td><a target="_blank" href="'.base_url().'assets/uploads/'.$row['first_photo'].'"><img src="'.base_url().'assets/uploads/'.$row['first_photo'].'" style="height:70px;width:70px" /></a></td>';
				if($row['second_photo']=='')
	                echo '<td>-</td>';
				else
					echo '<td><a target="_blank" href="'.base_url().'assets/uploads/'.$row['second_photo'].'"><img src="'.base_url().'assets/uploads/'.$row['second_photo'].'" style="height:70px;width:70px" /></a></td>';
					
                echo '<td><a href="javascript:void(0)" onclick="showattendencepopup(\''.base_url().'attendance/showattendence?id='.$row['attendance_id'].'\')" class="btn btn-info">View Attendance</a></td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>

          <?php echo '<div class="pagination"><div class="pagingLeft"><select style="width:100px" id="rowsperpage" name="rowsperpage" onchange="changePaging()"><option value="20">20</option><option value="50">50</option><option value="75">75</option><option value="100">100</option></select></div><div class="pagingCenter"><input type"text" id="gotopage" name="gotopage" value="'.$currentpage.'" style="width:100px" onKeyPress="return changePage(event,this);" /></div><div class="pagingRight">'.$this->pagination->create_links().'</div><div style="clear:both"></div></div>'; ?>

          </div>
      </div>
    </div>
	<a id="openfancyboxlink" class="fancybox" href="#showattendance"></a>
	<div style="display:none">
		<div id="showattendance">
		</div>
	</div>
	<script type="text/javascript">
	function showattendencepopup(url)
	{
	//alert(url);
		var $ = jQuery.noConflict();
		$.ajax({
           url : url,
           type: "POST",
           data : '',
           success:function(data, textStatus, jqXHR)
           {
		   	var $1 = jQuery.noConflict();

				$1('#showattendance').html('<table class="table table-striped table-bordered table-condensed"><thead><tr><th class="red header">કુટુંબમાં વ્યક્તિનો ક્રમ નંબર </th><th class="red header">કુટુંબના સભ્યોના નામ </th><th class="red header"> યુ.આઈ.ડી. / આધાર નંબર </th><th class="red header">હાજરી</th></tr></thead>'+data+'</table>');
				
				$1('#openfancyboxlink').click();
           },
           error: function(jqXHR, textStatus, errorThrown)
           {
           		alert("error"+textStatus);           
           }
    });
	}
	var $ = jQuery.noConflict();
		$(document).ready(function(){

			$('#rowsperpage').val('<?php echo $perpage ?>');
		}
		);
	function changePage(e,textbox)
		{
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13 && document.getElementById('gotopage').value!='') { //Enter keycode
				/*if(document.getElementById('aanganvadi_id').value != '0' || document.getElementById('searchtxt').value!='')
				{*/
					$('#perpage').val($('#rowsperpage').val());
					$('#currentpage').val($('#gotopage').val());
					$('#myform').submit();
				/*}
				else
				{
			 		document.location.href='<?php echo base_url('kutumb/page') ?>/'+document.getElementById('gotopage').value+'/'+document.getElementById('rowsperpage').value;
				}*/
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
					$('#myform').submit();
			//document.location.href='<?php echo base_url('kutumb/page/'.$currentpage) ?>/'+document.getElementById('rowsperpage').value;			
		}
	</script>