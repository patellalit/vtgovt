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
          <a  href="javascript:void(0)" class="btn btn-success" onclick="if(document.getElementById('aanganvadi_id').value != '' && document.getElementById('aanganvadi_id').value != '0'){document.location.href='<?php echo base_url() ?>kutumb/addkutumb?id='+document.getElementById('aanganvadi_id').value;} else {alert('Please select aanganvadi.');}">Add a new</a>
		  <?php 
		  }
		  else
		  {
		  echo ' - '.$kutumb[0]['aanganvadi_name'];
		  ?>
		  <a  href="javascript:void(0)" class="btn btn-success" onclick="document.location.href='<?php echo base_url() ?>kutumb/addkutumb?id=<?php echo $this->session->userdata('user_id'); ?>';">Add a new</a>
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

             // echo form_label('Order by:', 'order');
              //echo form_dropdown('order', $options_aanganvadi, $order, 'class="span2"');

              //$data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Add kutumb','onclick'=>'document.location.href=\''.base_url().'\'kutumb/addkutumb');
			  
			  ?>
			  <input type="button" class="btn btn-primary" value="શોધ કરવી" name="mysubmit" onclick="if(document.getElementById('aanganvadi_id').value != '0' || document.getElementById('searchtxt').value!=''){this.form.submit();} else {alert('Please select aanganvadi or search text.');}"><br /><br />
			 
<?php
}
else
{
	echo '<input type="text" id="searchtxt" name="searchtxt" value="'.$searchtxt.'" />';	  
			  ?>
			  <input type="button" class="btn btn-primary" value="શોધ કરવી" name="mysubmit" onclick="this.form.submit();"><br /><br />
			  <?php
}
              //$options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              //echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              //echo form_submit($data_submit);

            echo form_close();
			
			$jati = array('-','અનુ.જાતિ','અનુ.જનજાતિ','સામાજીક અને શૈક્ષણિક રીતે પછાત','અન્ય');
			$dhrm = array('-','બુદ્ધ','ખ્રિસ્તી','હિંદુ','ઇસ્લામ','જૈન','શીખ','અન્ય');
			$sthl = array('-','શેરી','વાસ','ફળીયું','વોર્ડ');
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
		        echo '<td>';
				echo '<a href="'.site_url("").'kutumb/update/'.$row['family_id'].'" class="btn btn-info">view & edit</a>';
				if($this->session->userdata('is_admin')==true)
				{
					  echo '<a href="javascript:void(0)" onclick="if(confirm(\'Are you sure you want to delete this kutumb?\')){document.location.href=\''.site_url("").'kutumb/delete/'.$row['family_id'].'\'}" class="btn btn-danger">delete</a>';
				}
				echo '</td>';
				
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>

          <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

          </div>
      </div>
    </div>