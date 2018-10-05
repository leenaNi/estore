<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">

   <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' || $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3' ||  $_GET['theme'] == 'bs1' ||  $_GET['theme'] == 'bs3' ||  $_GET['theme'] == 'el1' ||  $_GET['theme'] == 'el3' ||  $_GET['theme'] == 'fg1' ||  $_GET['theme'] == 'fg3' ||  $_GET['theme'] == 'ft1' ||  $_GET['theme'] == 'ft3' ||  $_GET['theme'] == 'hd1' ||  $_GET['theme'] == 'hd3' ||  $_GET['theme'] == 'jw1' ||  $_GET['theme'] == 'jw3' ||  $_GET['theme'] == 'kh1' ||  $_GET['theme'] == 'kh3' ||  $_GET['theme'] == 'os1' ||  $_GET['theme'] == 'os3' ||  $_GET['theme'] == 'rs1' ||  $_GET['theme'] == 'rs3' ||  $_GET['theme'] == 'ts1' ||  $_GET['theme'] == 'ts3')
    include( 'includes/header_style1.php');

    if($_GET['theme'] == 'fs2' || $_GET['theme'] == 'ac2' ||  $_GET['theme'] == 'bs2' ||  $_GET['theme'] == 'el2' ||  $_GET['theme'] == 'fg2' ||  $_GET['theme'] == 'ft2' ||  $_GET['theme'] == 'hd2' ||  $_GET['theme'] == 'jw2' ||  $_GET['theme'] == 'kh2' ||  $_GET['theme'] == 'os2' ||  $_GET['theme'] == 'rs2' ||  $_GET['theme'] == 'ts2')
     include( 'includes/header_style2.php');
     
     
     ?>
    <section id="page-title">
      <div class="container clearfix">
        <h1>Contact Us</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">Contact Us</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <!-- Contact Form
					============================================= -->
          <div class="col_half">
            <div class="fancy-title title-dotted-border">
              <h3>Connect with Us</h3> </div>
            <div class="contact-widget">
              <form class="nobottommargin" action="#" method="post">
                <div class="col_full">
                  <input type="text" placeholder="Full Name*" value="" class="sm-form-control required" /> </div>
                <div class="col_full">
                  <input type="email" placeholder="Email*" value="" class="required email sm-form-control" /> </div>
                <div class="col_full">
                  <input type="text" placeholder="Phone*" value="" class="sm-form-control" /> </div>
                <div class="col_full">
                  <textarea class="required sm-form-control" rows="6" cols="30">Message</textarea>
                </div>
                <div class="col_full hidden">
                  <input type="text" value="" class="sm-form-control" /> </div>
                <div class="col_full">
                  <button name="submit" type="submit" value="Submit" class="button nomargin">Submit</button>
                </div>
              </form>
            </div>
          </div>
          <!-- Contact Form End -->
          <!-- Google Map
					============================================= -->
          <div class="col_half col_last">
            <section class="gmap" style="height: 500px;">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.6811444007703!2d72.90397851490121!3d19.07775178708691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c62f40000039%3A0xe11790fc65fd4052!2sInfini+Systems+Pvt+Ltd!5e0!3m2!1sen!2sin!4v1503846275179" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </section>
          </div>
          <!-- Google Map End -->
          <div class="clear"></div>
          <!-- Contact Info
					============================================= -->
          <div class="row clear-bottommargin">
            <div class="col-md-4 col-sm-6 bottommargin clearfix">
              <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon"> <a href="#"><i class="icon-map-marker2"></i></a> </div>
                <h3>Office<span class="subtitle">Mumbai, India</span></h3> </div>
            </div>
            <div class="col-md-4 col-sm-6 bottommargin clearfix">
              <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon"> <a href="#"><i class="icon-mail"></i></a> </div>
                <h3>Email<span class="subtitle">jigar.shah@infiniteit.biz</span></h3> </div>
            </div>
            <div class="col-md-4 col-sm-6 bottommargin clearfix">
              <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon"> <a href="#"><i class="icon-phone3"></i></a> </div>
                <h3>Phone<span class="subtitle">(022) 6697 3260 </span></h3> </div>
            </div>
          </div>
          <!-- Contact Info End -->
        </div>
      </div>
    </section>
    <!-- #content end -->
    <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' || $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3' ||  $_GET['theme'] == 'bs1' ||  $_GET['theme'] == 'bs3' ||  $_GET['theme'] == 'el1' ||  $_GET['theme'] == 'el3' ||  $_GET['theme'] == 'ft1' ||  $_GET['theme'] == 'ft3' ||  $_GET['theme'] == 'hd1' ||  $_GET['theme'] == 'hd3' ||  $_GET['theme'] == 'jw1' ||  $_GET['theme'] == 'jw3' ||  $_GET['theme'] == 'kh1' ||  $_GET['theme'] == 'kh3' ||  $_GET['theme'] == 'fg1' ||  $_GET['theme'] == 'fg3' ||  $_GET['theme'] == 'rs1' ||  $_GET['theme'] == 'rs3' ||  $_GET['theme'] == 'os1' ||  $_GET['theme'] == 'os3' ||  $_GET['theme'] == 'ts1' ||  $_GET['theme'] == 'ts3')
    include( 'includes/footer_style1.php');

    if($_GET['theme'] == 'fs2' || $_GET['theme'] == 'ac2' ||  $_GET['theme'] == 'bs2' ||  $_GET['theme'] == 'el2' ||  $_GET['theme'] == 'ft2' ||  $_GET['theme'] == 'hd2' ||  $_GET['theme'] == 'jw2' ||  $_GET['theme'] == 'kh2' ||  $_GET['theme'] == 'fg2' ||  $_GET['theme'] == 'os2' ||  $_GET['theme'] == 'rs2' ||  $_GET['theme'] == 'ts2')
    include( 'includes/footer_style2.php');
     ?>
 </div>
  <!-- #wrapper end -->
  <?php include( 'includes/foot.php'); ?> </body>

</html>