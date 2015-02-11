<!DOCTYPE html> 
<html lang="en-US">
  <head>
    <title> 	District Innovation Fund </title>
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container login">
      <?php 
      $attributes = array('class' => 'form-signin');
      echo form_open('login/validate_credentials', $attributes);
      ?>
      <div class="login-left">
      <img src="<?php echo base_url(); ?>/assets/img/admin/sabarkantha.png">
      </div>
      <div class="login-right">
      <img src="<?php echo base_url(); ?>/assets/img/admin/logo3.jpg">
      <?php
      echo form_input('user_name', '', 'placeholder="યુસર નામ"');
      echo form_password('password', '', 'placeholder="પાસવર્ડ"');
      if(isset($message_error) && $message_error){
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> Change a few things up and try submitting again.';
          echo '</div>';             
      }
      echo "<br />";
      //echo anchor('admin/signup', 'Signup!');
	  ?>
      
      
      <?php
      echo form_submit('submit', 'Login', 'class="btn btn-large btn-primary"');
	  ?>
      </div>
      <div class="clear"></div>
	  <?php
      echo form_close();
      ?>      
    </div><!--container-->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>    
    