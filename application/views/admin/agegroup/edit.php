    <div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/agegroup.js"></script>      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
          વય જૂથ
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">વય જૂથ નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          વય જૂથ નોંધણી
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'વય જૂથ થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'વય જૂથ થઇ નથી. ફરીથી પ્રયત્ન કરો.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => 'frm');
      //form validation
      echo validation_errors();

      echo form_open('agegroup/update/'.$this->uri->segment(3).'', $attributes);
      ?>
	  	<fieldset>        
          <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >વય જૂથ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="agegroup_name" name="agegroup_name" value="<?php echo $agegroup[0]['name']; ?>" class="width463" >
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
     