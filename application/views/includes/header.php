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
              
          </div>
          <div class="right_logo"><img src="<?php echo base_url(); ?>/assets/img/admin/logo3.jpg"></div>
          <div class="clear"></div>
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
				<li <?php if($this->uri->segment(2) == 'jilla'){echo 'class="active"';}?>> 
				  <a href="<?php echo base_url(); ?>jilla">જીલ્લો</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'taluka'){echo 'class="active"';}?>> 
				  <a href="<?php echo base_url(); ?>taluka">તાલુકો</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'gaam'){echo 'class="active"';}?>> 
				  <a href="<?php echo base_url(); ?>gaam">ગામ</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'agegroup'){echo 'class="active"';}?>> 
				  <a href="<?php echo base_url(); ?>agegroup">વય જૂથ</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'activities'){echo 'class="active"';}?>> 
				  <a href="<?php echo base_url(); ?>activities">પ્રવૃત્તિઓ</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'vaccine'){echo 'class="active"';}?>>
					<a href="<?php echo base_url(); ?>vaccine">રસી</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'holidays'){echo 'class="active"';}?>>
					<a href="<?php echo base_url(); ?>holidays">રજાઓ</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'item'){echo 'class="active"';}?>>
					<a href="<?php echo base_url(); ?>item">વસ્તુ</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'item_stock'){echo 'class="active"';}?>>
					<a href="<?php echo base_url(); ?>item_stock">જથ્થો</a>
				</li>
				<li <?php if($this->uri->segment(2) == 'child_weight'){echo 'class="active"';}?>>
					<a href="<?php echo base_url(); ?>child_weight">માત્રા</a>
				</li>
                <li <?php if($this->uri->segment(2) == 'report'){echo 'class="active"';}?>>
                <a href="<?php echo base_url(); ?>reports">અહેવાલો</a>
                </li>
                <li <?php if($this->uri->segment(2) == 'logout'){echo 'class="active"';}?>>
                  <a href="<?php echo base_url(); ?>logout">લૉગઆઉટ</a>
                </li>				
              </ul>
	    </div>
	  </div>
	</div>	
