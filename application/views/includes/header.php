<!DOCTYPE html> 
<html lang="en-US">
<head>
  <title> 	District Innovation Fund </title>
  <meta charset="utf-8">
  <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
          <div class="left_logo"><img src="<?php echo base_url(); ?>/assets/img/admin/logo2.jpg"></div>
          <div class="middle_header">
            <div class="header_logo_name">
                <h3>District Innovation Fund</h3>
                <h4>Collector Office</h4>
                <h4>Sabarkantha</h4>
            </div>
              <ul class="nav">
                <li <?php if($this->uri->segment(2) == 'aanganvadi'){echo 'class="active"';}?>>
                  <a href="<?php echo base_url(); ?>aanganvadi">નોંધણી</a>
                </li>
                <li <?php if($this->uri->segment(2) == 'kutumb'){echo 'class="active"';}?>>
                  <a href="<?php echo base_url(); ?>kutumb">કુટુંબ</a>
                </li>
				<li <?php if($this->uri->segment(2) == 'attendance'){echo 'class="active"';}?>> 
				  <a href="<?php echo base_url(); ?>attendance">હાજરી</a>
				</li>
                <li <?php if($this->uri->segment(2) == 'logout'){echo 'class="active"';}?>>
                  <a href="<?php echo base_url(); ?>logout">લૉગઆઉટ</a>
                </li>
              </ul>
          </div>
          <div class="right_logo"><img src="<?php echo base_url(); ?>/assets/img/admin/logo3.jpg"></div>
          <div class="clear"></div>
	    </div>
	  </div>
	</div>	
