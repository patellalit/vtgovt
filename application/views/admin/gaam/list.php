    <div class="container top">
		<script src="<?php echo base_url(); ?>assets/js/gaam.js"></script>
      <ul class="breadcrumb">
        <li class="active">
          ગામ નોંધણી
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          ગામ
		  <?php
		  	if($this->session->userdata('is_admin')==true)
			{
		  ?>
          		<a  href="<?php echo site_url("").$this->uri->segment(1); ?>/add" class="btn btn-success">નવી ગામ ઉમેરો</a>
			<?php
			}
			?>
        </h2>
      </div>
      
      <div class="row">
        <div class="span12 columns">
          <div class="well">
           
            <?php
           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform','method'=>'GET');
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
			
			
            echo form_open('gaam', $attributes);
			
			echo form_label('જીલ્લો:', 'jilla_id');
              echo form_dropdown('jilla_id', $options_jilla, $jilla_selected, 'class="span2" onchange="fetchTaluko(this.value,\''.base_url().'aanganvadi/fetchTaluko\')"');
              
			  echo form_label('તાલુકો:', 'taluka_id');
			  echo form_dropdown('taluka_id', $options_taluka, $taluka_selected, 'class="span2" id="taluka_id"');
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'શોધ કરવી');
		  ?>
			  &nbsp;&nbsp;<input type="text" id="search" name="search" value="<?php echo $search ?>" />
				<input type="hidden" id="perpage" name="perpage" value="<?php echo $perpage ?>" />
			  <input type="hidden" id="currentpage" name="currentpage" value="<?php echo $currentpage ?>" />
			  <?php
              echo form_submit($data_submit);
            echo form_close();
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">ક્રમ નંબર</th>
				<th class="yellow header headerSortDown">જીલ્લો નામ</th>
				<th class="yellow header headerSortDown">તાલુકો નામ</th>
                <th class="yellow header headerSortDown">ગામ નામ</th>
                <th class="red header">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($gaam as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['id'].'</td>';
                echo '<td>'.$row['jilla_name'].'</td>';
				echo '<td>'.$row['taluka_name'].'</td>';
				echo '<td>'.$row['name_guj'].'</td>';
                echo '<td class="crud-actions">';
                echo '<a href="'.site_url("").'gaam/update/'.$row['id'].'" class="btn btn-info">View & Edit</a>'; 
				if($this->session->userdata('is_admin')==true)
				{ 
                	echo '<a href="javascript:void(0)" onclick="if(confirm(\'Are you sure you want to delete this gaam?\')){document.location.href=\''.site_url("").'gaam/delete/'.$row['id'].'\'}" class="btn btn-danger">Delete</a>';
				}
                echo '</td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>
			
          <?php echo '<div class="pagination"><div class="pagingLeft"><select style="width:100px" id="rowsperpage" name="rowsperpage" onchange="changePaging()"><option value="20">20</option><option value="50">50</option><option value="75">75</option><option value="100">100</option></select></div><div class="pagingCenter"><input type"text" id="gotopage" name="gotopage" value="'.$currentpage.'" style="width:100px" onKeyPress="return changePage(event,this);" /></div><div class="pagingRight">'.$this->pagination->create_links().'</div><div style="clear:both"></div></div>'; ?>

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
			 	//document.location.href='<?php echo base_url('gaam/page') ?>/'+document.getElementById('gotopage').value+'/'+document.getElementById('rowsperpage').value;
				$('#perpage').val($('#rowsperpage').val());
				$('#currentpage').val($('#gotopage').val());
				$("#myform").attr("action", '<?php echo base_url('gaam/page') ?>/'+document.getElementById('gotopage').value);
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
			//document.location.href='<?php echo base_url('gaam/page/'.$currentpage) ?>/'+document.getElementById('rowsperpage').value;			
			$('#perpage').val($('#rowsperpage').val());
					$('#currentpage').val($('#gotopage').val());
					$("#myform").attr("action", '<?php echo base_url('gaam/page') ?>/'+document.getElementById('gotopage').value);
					$('#myform').submit();
		}
		
	</script>