    <div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/activities.js"></script>      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
          પ્રવૃત્તિ
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">પ્રવૃત્તિ નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
         પ્રવૃત્તિ નોંધણી
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'પ્રવૃત્તિ નોંધણી થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'પ્રવૃત્તિ નોંધણી થઇ નથી. ફરીથી પ્રયત્ન કરો.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => 'frm');
	  $options_agegroup = array('' => "--પસંદ કરો--");
      foreach ($agegroup as $row)
      {
        $options_agegroup[$row['id']] = $row['name'];
      }
      //form validation
      echo validation_errors();

      echo form_open('activities/update/'.$this->uri->segment(3).'', $attributes);
      ?>
	  	<fieldset>        
			<div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >વય જૂથ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <?php  echo form_dropdown('agegroup_id', $options_agegroup,  $activities[0]['agegroup_id'], 'class="span2 width230" id="agegroup_id"'); ?>
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
          <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >પ્રવૃત્તિ નામ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="activities_name" name="activities_name" value="<?php echo $activities[0]['name']; ?>" class="width463" >
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
     