    <div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/anganvadi.js"></script>
      <ul class="breadcrumb">
        <li class="active">કુટુંબ</li>
      </ul>
	<div class="page-header users-header">
        <h2>
          કુટુંબ નોંધણી		  
		  <?php
		  	if($this->session->userdata('is_admin')==true)
			{
			
		  ?>
          <a  href="javascript:void(0)" class="btn btn-success" onclick="if(document.getElementById('aanganvadi_id').value != '' && document.getElementById('aanganvadi_id').value != '0'){document.location.href='<?php echo base_url() ?>kutumb/addkutumb?id='+document.getElementById('aanganvadi_id').value;} else {alert('Please select aanganvadi.');}">નવો કુટુંબ ઉમેરો</a>
		  <?php 
		  }
		  else
		  {
		  if(!empty($kutumb))
			  echo ' - '.$kutumb[0]['aanganvadi_name'];
		  ?>
		  <a  href="javascript:void(0)" class="btn btn-success" onclick="document.location.href='<?php echo base_url() ?>kutumb/addkutumb?id=<?php echo $this->session->userdata('user_id'); ?>';">નવો કુટુંબ ઉમેરો</a>
		  <?php
		  
		  }
		  ?>
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
                
                $options_jati = array();
                foreach ($castArray as $row)
                {
                    $options_jati[$row['id']] = $row['name_guj'];
                }
                $options_religion = array();
                foreach ($religionArray as $row)
                {
                    $options_religion[$row['id']] = $row['name_guj'];
                }
			
                $options_laghumati = array('0'=>'પસંદ કરો','1'=>'હા','2'=>'ના');
			
            //save the columns names in a array that we will use as filter         
            $options_kutumb = array(0 => "all");
            foreach ($kutumb as $array) {
              foreach ($array as $key => $value) {
                $options_kutumb[$key] = $key;
              }
              break;
            }

            echo form_open('kutumb', $attributes);
     
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
			  
			  echo '&nbsp;&nbsp;<input type="text" id="searchtxt" name="searchtxt" value="'.$searchtxt.'" />';
                
              
              echo form_label('જાતિ', 'jati_id');
              echo form_dropdown('jati_id', $options_jati, $jati_selected, 'class="span2"  id="jati_id"');
                
              echo form_label('ધર્મ', 'religion_id');
              echo form_dropdown('religion_id', $options_religion, $religion_selected, 'class="span2"  id="religion_id"');
                
                echo form_label('લઘુમતી', 'laghumati');
                echo form_dropdown('laghumati', $options_laghumati, $laghumati_selected, 'class="span2"  id="laghumati"');
              

             // echo form_label('Order by:', 'order');
              //echo form_dropdown('order', $options_aanganvadi, $order, 'class="span2"');

              //$data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Add kutumb','onclick'=>'document.location.href=\''.base_url().'\'kutumb/addkutumb');
			  
			  ?>
			  <input type="hidden" id="perpage" name="perpage" value="<?php echo $perpage ?>" />
			  <input type="hidden" id="currentpage" name="currentpage" value="<?php echo $currentpage ?>" />
			  <input type="button" class="btn btn-primary" value="શોધ કરવી" name="mysubmit" onclick="if(document.getElementById('jati_id').value != '0' || document.getElementById('aanganvadi_id').value != '0' || document.getElementById('searchtxt').value!=''){this.form.submit();} else {alert('Please select aanganvadi or search text.');}"><br /><br />
			 
<?php
}
else
{
    echo form_label('જાતિ', 'jati_id');
    echo form_dropdown('jati_id', $options_jati, $jati_selected, 'class="span2"  id="jati_id"');
	echo '<input type="text" id="searchtxt" name="searchtxt" value="'.$searchtxt.'" />';
    
    echo form_label('ધર્મ', 'religion_id');
    echo form_dropdown('religion_id', $options_religion, $religion_selected, 'class="span2"  id="religion_id"');
			  ?>
			  <input type="hidden" id="perpage" name="perpage" value="<?php echo $perpage ?>" />
			  <input type="hidden" id="currentpage" name="currentpage" value="<?php echo $currentpage ?>" />
			  <input type="button" class="btn btn-primary" value="શોધ કરવી" name="mysubmit" onclick="this.form.submit();"><br /><br />
			  <?php
}
              //$options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              //echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              //echo form_submit($data_submit);

            echo form_close();
			
			

			$laghu = array('-','હા','ના');
            ?>
			
			<table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">કુટુંબનો ક્રમ નંબરો</th>
				<?php
		  		if($this->session->userdata('is_admin')==true)
				{
		  		?>
                <th class="yellow header headerSortDown">આંગણવાડી નામ</th>
				<?php 
				}
				?>
				<th class="red header">નામ</th>
                <th class="red header">જાતિ</th>
                <th class="red header">ધર્મ</th>
                <th class="red header">સ્થળ</th>
                <th class="red header">રાજ્યમાં લઘુમતી છે.</th>
<th class="red header">ખોડખાંપણ</th>
<th class="red header">મરણ.</th>
<th class="red header">જન્મ</th>
                <th class="red header">&nbsp;</th>				
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($kutumb as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['family_rank'].'</td>';
				if($this->session->userdata('is_admin')==true)
				{
                	echo '<td>'.$row['aanganvadi_name'].'</td>';
				}
                
				echo '<td>'.$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'].'</td>';
				if($row['jati_id']==1)
	                echo '<td>-</td>';
				else
					echo '<td>'.$castArray[$row['jati_id']-1]['name_guj'].'</td>';
				if($row['dharm_id']==1)
	                echo '<td>-</td>';
				else
					echo '<td>'.$religionArray[$row['dharm_id']-1]['name_guj'].'</td>';
					
				if($row['sthal_id']==1)
	                echo '<td>-</td>';
				else
					echo '<td>'.$placeArray[$row['sthal_id']-1]['name_guj'].' - '.$row['sthal_value'].'</td>';
					
				echo '<td>'.$laghu[$row['laghumati']].'</td>';
                  
                  echo '<td>'.$row['total_khodkhapan'].'</td>';
                  echo '<td>'.$row['total_death'].'</td>';
                  echo '<td>'.$row['total_birth'].'</td>';
                  
		        echo '<td>';
				echo '<a href="'.site_url("").'kutumb/update/'.$row['family_id'].'" class="btn btn-info">View & Edit</a>';
				if($this->session->userdata('is_admin')==true)
				{
					  echo '<a href="javascript:void(0)" onclick="if(confirm(\'Are you sure you want to delete this kutumb?\')){document.location.href=\''.site_url("").'kutumb/delete/'.$row['family_id'].'\'}" class="btn btn-danger">Delete</a>';
				}
                  echo '<a target="_blank" class="btn btn-danger" href="'.site_url().'kutumb/printpdf/'.$row['family_id'].'">Print</a>';
				echo '</td>';
				
                echo '</tr>';
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
				$("#myform").attr("action", '<?php echo base_url('kutumb/page') ?>/'+document.getElementById('gotopage').value);
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
			$("#myform").attr("action", '<?php echo base_url('kutumb/page') ?>/'+document.getElementById('gotopage').value);
			$('#myform').submit();
		}
		
	</script>