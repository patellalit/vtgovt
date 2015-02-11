    <div class="container top">
      <script src="<?php echo base_url(); ?>assets/js/gaam.js"></script>
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
           ગામ 
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">ગામ નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          ગામ નોંધણી
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'ગામ  નોંધણી થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'ગામ  નોંધણી થઇ નથી. ફરીથી પ્રયત્ન કરો.';
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
      //form validation
	  $options_taluka = array('' => "--પસંદ કરો--");
      foreach ($taluka as $row)
      {
        $options_taluka[$row['id']] = $row['name_guj'];
      }
      echo validation_errors();

      echo form_open('gaam/update/'.$this->uri->segment(3).'', $attributes);
      ?>
	  	<fieldset>        
			<div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >જીલ્લો નામ (English) <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0"> <?php //echo $gaam[0]['jilla_id'] 
				?>
				  <?php  echo form_dropdown('jilla_id', $options_jilla ,$gaam[0]['jilla_id'], 'class="span2 width230" id="jilla_id"  onchange="fetchTaluko(this.value,\''.base_url().'aanganvadi/fetchTaluko\')"'); ?>
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
		  <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >તાલુકો નામ (English) <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				   <?php  echo form_dropdown('taluka_id', $options_taluka,$gaam[0]['taluka_id'], 'class="span2 width230" id="taluka_id"'); ?>
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
          <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >ગામ નામ (English) <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="gaam_name" name="gaam_name" value="<?php echo $gaam[0]['name']; ?>" class="width463" >
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
		  <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >ગામ નામ (Gujarati) <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="gaam_name_guj" name="gaam_name_guj" value="<?php echo $gaam[0]['name_guj']; ?>" class="width463" >
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
     