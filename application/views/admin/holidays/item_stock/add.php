
    <div class="container top">
		 <script src="<?php echo base_url(); ?>assets/js/item.js"></script>
		 
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("").$this->uri->segment(1); ?>">
            જથ્થો
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">જથ્થો નોંધણી કરવી</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          જથ્થો નોંધણી
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
            echo 'જથ્થો નોંધણી થઇ ગયેલ છે.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo 'જથ્થો  નોંધણી થઇ નથી. ફરીથી પ્રયત્ન કરો.';
          echo '</div>';          
        }
      }
	  $options_aanganvadi = array('' => "select");
	  foreach ($aanganwadi as $row)
	  {
	    $options_aanganvadi[$row['id']] = $row['aanganvadi_name'];
	  }
	  
	  $options_item = array('' => "select");
	  foreach ($item as $row)
	  {
	    $options_item[$row['id']] = $row['item_name'];
	  }
      ?>      
      <?php
      //form validation
      echo validation_errors();
      echo form_open('item_stock/add', $attributes);
      ?>
        <fieldset>        
          <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >આંગણવાડી <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <?php echo form_dropdown('aanganwadi_id',$options_aanganvadi,'','class="span2" id="aanganwadi_id"'); ?>
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
		  <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >વસ્તુ <span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <?php echo form_dropdown('item_id',$options_item,'','class="span2" id="item_id"'); ?>
				</div>
			  </div>			  
			  <div class="classclear"></div>
		  </div>
		  <div  class="main_container_width">
			  <div class="control-group double_part_div">
				<label for="inputError" class="control-label form_label_css" >જથ્થો (in KG)<span style="color:#ff0000">*</span></label>
				<div class="controls marginleft0">
				  <input type="text" id="stock" name="stock" value="" class="span2"/>
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
     