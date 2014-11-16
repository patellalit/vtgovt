    <div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/anganvadi.js"></script>
      <ul class="breadcrumb">
        <li class="active">
          આંગણવાડી નોંધણી
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          આંગણવાડી
		  <?php
		  	if($this->session->userdata('is_admin')==true)
			{
		  ?>
          		<a  href="<?php echo site_url("").$this->uri->segment(1); ?>/add" class="btn btn-success">Add a new</a>
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
            //save the columns names in a array that we will use as filter         
            $options_aanganvadi = array();    
            foreach ($aanganvadi as $array) {
              foreach ($array as $key => $value) {
                $options_aanganvadi[$key] = $key;
              }
              break;
            }

            echo form_open('aanganvadi', $attributes);
     
              //echo form_label('Search:', 'search_string');
              //echo form_input('search_string', $search_string_selected, 'style="width: 170px;height: 26px;"');

              echo form_label('જીલ્લો:', 'jilla_id');
              echo form_dropdown('jilla_id', $options_jilla, $jilla_selected, 'class="span2" onchange="fetchTaluko(this.value,\''.base_url().'aanganvadi/fetchTaluko\')"');
			  
			  echo form_label('તાલુકો:', 'taluka_id');
              echo form_dropdown('taluka_id', $options_taluka, $taluka_selected, 'class="span2" onchange="fetchGaam(this.value,\''.base_url().'aanganvadi/fetchGaam\')" id="taluka_id"');
			  
			  echo form_label('ગામ:', 'gaam_id');
              echo form_dropdown('gaam_id', $options_gaam, $gaam_selected, 'class="span2"  id="gaam_id"');

             // echo form_label('Order by:', 'order');
              //echo form_dropdown('order', $options_aanganvadi, $order, 'class="span2"');
echo '&nbsp;';
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'શોધ કરવી');

              //$options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              //echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              echo form_submit($data_submit);

            echo form_close();
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">ક્રમ નંબર</th>
                <th class="yellow header headerSortDown">આંગણવાડી નામ</th>
                <th class="green header">આંગણવાડી નંબર</th>
                <th class="red header">આંગણવાડી સ્થળ</th>
                <th class="red header">સરનામું</th>
                <th class="red header">કાર્યકર નામ</th>
                <th class="red header">કાર્યકર મોબાઇલ</th>
                <th class="red header">તેડાગર નામ</th>
                <th class="red header">તેડાગર મોબાઇલ</th>
                <th class="red header">જીલ્લો</th>
                <th class="red header">તાલુકો</th>
                <th class="red header">ગામ</th>
                <th class="red header">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($aanganvadi as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['id'].'</td>';
                echo '<td>'.$row['aanganvadi_name'].'</td>';
                echo '<td>'.$row['aanganvadi_number'].'</td>';
                echo '<td>'.$row['place'].'</td>';
                echo '<td>'.$row['address'].'</td>';
                echo '<td>'.$row['karyakar_name'].'</td>';
				echo '<td>'.$row['karyakar_number'].'</td>';
				echo '<td>'.$row['tedagara_name'].'</td>';
				echo '<td>'.$row['tedagara_number'].'</td>';
				echo '<td>'.$row['jilla_name'].'</td>';
				echo '<td>'.$row['taluka_name'].'</td>';
				echo '<td>'.$row['gaam_name'].'</td>';
                echo '<td class="crud-actions">';
                echo '<a href="'.site_url("").'aanganvadi/update/'.$row['id'].'" class="btn btn-info">view & edit</a>'; 
				if($this->session->userdata('is_admin')==true)
				{ 
                	echo '<a href="javascript:void(0)" onclick="if(confirm(\'Are you sure you want to delete this aanganwadi?\')){document.location.href=\''.site_url("").'aanganvadi/delete/'.$row['id'].'\'}" class="btn btn-danger">delete</a>';
				}
                echo '</td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>
			
          <?php echo '<div class="pagination"><div class="pagingLeft"><select style="width:100px" id="rowsperpage" name="rowsperpage" onchange="changePaging()"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select></div><div class="pagingCenter"><input type"text" id="gotopage" name="gotopage" value="'.$currentpage.'" style="width:100px" onKeyPress="return changePage(event,this);" /></div><div class="pagingRight">'.$this->pagination->create_links().'</div><div style="clear:both"></div></div>'; ?>

      </div>
    </div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#rowsperpage').val('<?php $perpage ?>');
		}
		);
		function changePage(e,textbox)
		{
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13 && document.getElementById('gotopage').value!='') { //Enter keycode
			 	document.location.href='<?php echo base_url('aanganvadi/page') ?>/'+document.getElementById('gotopage').value+'/'+document.getElementById('rowsperpage').value;
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
			document.location.href='<?php echo base_url('aanganvadi/page/'.$currentpage) ?>/'+document.getElementById('rowsperpage').value;			
		}
		
	</script>