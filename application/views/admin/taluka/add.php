
    <div class="container top">
		 <script src="<?php echo base_url(); ?>assets/js/taluka.js"></script>
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
           તાલુકો
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">તાલુકો નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          તાલુકો નોંધણી
        </h2>
      </div>
 
      <?php
      //flash messages
	  $attributes = array('class' => 'form-horizontal', 'id' => 'frm');
	  $options_jilla = array('' => "--પસંદ કરો--");
      foreach ($jilla as $row)
      {
        $options_jilla[$row['id']] = $row['name_guj'];
      }
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'તાલુકો નોંધણી થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'તાલુકો નોંધણી થઇ નથી. ફરીથી પ્રયત્ન કરો.';
          echo '</div>';          
        }
      }
      ?>      
      <?php
      //form validation
      echo validation_errors();
      echo form_open('taluka/add', $attributes);
      ?>
        <fieldset> 
			<div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >જીલ્લો <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <?php  echo form_dropdown('jilla_id', $options_jilla, set_value('jilla_id'), 'class="span2 width230" id="jilla_id"'); ?>
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>       
          <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >તાલુકો નામ (English) <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="taluka_name" name="taluka_name" value="<?php echo set_value('name'); ?>" class="width463" >
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
		  <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >તાલુકો નામ (Gujarati) <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="taluka_name_guj" name="taluka_name_guj" value="<?php echo set_value('guj_name'); ?>" class="width463" >
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
     