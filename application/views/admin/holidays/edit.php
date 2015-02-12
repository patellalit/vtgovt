    <div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/holidays.js"></script>  
	  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	var $2 = jQuery.noConflict();
	$2(function() {
		$2( "#holiday_date" ).datepicker({minDate: '0',yearRange: "-0:+100",dateFormat: 'yy/mm/dd',changeMonth: true,changeYear: true,yearRange: "-0:+100",});
		});
		</script>    
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
           રજાઓ
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">રજાઓ નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          રજાઓ નોંધણી
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'રજાઓ નોંધણી થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'રજાઓ નોંધણી થઇ નથી. ફરીથી પ્રયત્ન કરો.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => 'frm');
      //form validation
      echo validation_errors();

      echo form_open('holidays/update/'.$this->uri->segment(3).'', $attributes);
      ?>
	  	<fieldset>        
          <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >રજા નામ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="holiday_name" name="holiday_name" value="<?php echo $holidays[0]['holiday_name']; ?>" class="width463" >
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
		  <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >તારીખ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="holiday_date" name="holiday_date" value="<?php echo $holidays[0]['holiday_date']; ?>" class="width463" >
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
     