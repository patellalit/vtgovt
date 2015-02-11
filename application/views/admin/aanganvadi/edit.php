    <div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/anganvadi.js"></script>      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
            આંગણવાડી
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">આંગણવાડી નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          આંગણવાડી નોંધણી
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'આંગણવાડી નોંધણી થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'આંગણવાડી નોંધણી થઇ નથી. ફરીથી પ્રયત્ન કરો.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => 'frm');
      $options_jilla = array('' => "--પસંદ કરો--");
      foreach ($jilla as $row)
      {
        $options_jilla[$row['id']] = $row['name_guj'];
      }
	  $options_taluka = array('' => "--પસંદ કરો--");
      foreach ($taluka as $row)
      {
        $options_taluka[$row['id']] = $row['name_guj'];
      }
	  $options_gaam = array('' => "--પસંદ કરો--");
      foreach ($gaam as $row)
      {
        $options_gaam[$row['id']] = $row['name_guj'];
      }

      //form validation
      echo validation_errors();

      echo form_open('aanganvadi/update/'.$this->uri->segment(3).'', $attributes);
      ?>
        <fieldset>
          <?php
		  echo '<div class="main_container_width">';
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="jilla_id" class="control-label form_label_css">જીલ્લો <span style="color:#ff0000">*</span></label>';
				//echo '<div class="controls">';
				  echo form_dropdown('jilla_id', $options_jilla, $aanganvadi[0]['jilla_id'], 'class="span2 width230" onchange="fetchTaluko(this.value,\''.base_url().'aanganvadi/fetchTaluko\')" id="jilla_id"');
	
				//echo '</div>';
			  echo '</div>';
          ?>
          
          <?php
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="taluka_id" class="control-label form_label_css">તાલુકો <span style="color:#ff0000">*</span></label>';
				//echo '<div class="controls">';
				  echo form_dropdown('taluka_id', $options_taluka, $aanganvadi[0]['taluka_id'], 'class="span2 width230"  onchange="fetchGaam(this.value,\''.base_url().'aanganvadi/fetchGaam\')" id="taluka_id" ');
	
				//echo '</div>';
			  echo '</div>';
          ?>
          
          <?php
			  echo '<div class="control-group sub_parts_div">';
				echo '<label for="gaam_id" class="control-label form_label_css">ગામ <span style="color:#ff0000">*</span></label>';
				//echo '<div class="controls">';
				  echo form_dropdown('gaam_id', $options_gaam, $aanganvadi[0]['gaam_id'], 'class="span2 width230" id="gaam_id"');
	
				//echo '</div>';
			  echo '</div>';
			  $style='';
			  if($this->session->userdata('is_admin')==false)
			  {
			  	$style='style="display:none"';
			  }
			  echo '<div class="control-group sub_parts_div" '.$style.'>';
				echo '<label for="gaam_id" class="control-label form_label_css">પાસવર્ડ <span style="color:#ff0000">*</span></label>';
				//echo '<div class="controls">';
				  echo '<input type="password" id="password" name="password" value="'.$aanganvadi[0]['password'].'" />';
	
				//echo '</div>';
			  echo '</div>';
			  
		  echo '<div class="classclear"></div>';
		  echo '</div>';
          ?>
          
          <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css">આંગણવાડી નામ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="aanganvadi_name" name="aanganvadi_name" value="<?php echo $aanganvadi[0]['aanganvadi_name']; ?>"  class="width463" >
				</div>
			  </div>
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">આંગણવાડી નંબર <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="aanganvadi_number" name="aanganvadi_number" value="<?php echo $aanganvadi[0]['aanganvadi_number']; ?>" class="width223">
				</div>
			  </div>          
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">આંગણવાડી સ્થળ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="place" name="place" value="<?php echo $aanganvadi[0]['place']; ?>" class="width223">
				</div>
			  </div>
			  <div class="classclear"></div>
		  </div>
		  <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css">સરનામું <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  
				  <textarea id="address" name="address" class="addresstextarea" ><?php echo $aanganvadi[0]['address']; ?></textarea>
				</div>
			  </div>
			  <div class="double_part_div">
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">આંગણવાડી કાર્યકર નામ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" name="karyakar_name" id="karyakar_name" class="width223" value="<?php echo $aanganvadi[0]['karyakar_name']; ?>">
				</div>
			  </div>
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">મોબાઇલ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" name="karyakar_number" id="karyakar_number" class="width223" value="<?php echo $aanganvadi[0]['karyakar_number']; ?>">
				</div>
			  </div>
			  <div class="classclear"></div>
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">આંગણવાડી તેડાગર નામ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0"> 
				  <input type="text" name="tedagara_name" id="tedagara_name" class="width223" value="<?php echo $aanganvadi[0]['tedagara_name']; ?>">
				</div>
			  </div>
			  <div class="control-group sub_parts_div">
				<label for="inputError" class="control-label form_label_css">મોબાઇલ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" name="tedagara_number" class="width223" value="<?php echo $aanganvadi[0]['tedagara_number']; ?>">
				</div>
			  </div>
          </div>
			 <div class="classclear"></div>
          </div>
          <div class="form-actions submitdiv">
            <button class="btn btn-primary" onclick="checkvalidation();" type="button">નોંધણી કરો</button>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     