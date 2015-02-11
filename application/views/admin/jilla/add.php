
    <div class="container top">
		 <script src="<?php echo base_url(); ?>assets/js/jilla.js"></script>
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
            જીલ્લો
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">જીલ્લો નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          જીલ્લો નોંધણી
        </h2>
      </div>
 
      <?php
      //flash messages
	  $attributes = array('class' => 'form-horizontal', 'id' => 'frm');
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'જીલ્લો નોંધણી થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'જીલ્લો નોંધણી થઇ નથી. ફરીથી પ્રયત્ન કરો.';
          echo '</div>';          
        }
      }
      ?>      
      <?php
      //form validation
      echo validation_errors();
      echo form_open('jilla/add', $attributes);
      ?>
        <fieldset>        
          <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >જીલ્લો નામ (English) <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="jilla_name" name="jilla_name" value="<?php echo set_value('name'); ?>" class="width463" >
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
		  <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >જીલ્લો નામ (Gujarati) <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="jilla_name_guj" name="jilla_name_guj" value="<?php echo set_value('guj_name'); ?>" class="width463" >
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
     