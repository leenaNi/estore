<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
  <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3')
     include( 'includes/header_style1.php');

     if($_GET['theme'] == 'fs2')
     include( 'includes/header_style2.php');
     
     
     ?>
    <section id="page-title">
      <div class="container clearfix">
        <h1>Forgot Password</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">Forgot Password</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col_full_fourth nobottommargin">
            <div class="ordersuccess-block center"> <span class="divcenter">You will soon recive an e-mail.</span>
              <br>
              <form class="nobottommargin forgot-password" action="#" method="post">
                <div class="col_full">
                  <input type="text" placeholder="Enter your registered Email" class="form-control"> </div>
                <div class="col_full nobottommargin">
                  <button class="button nomargin" id="login-form-submit" name="login-form-submit" value="login">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- #content end -->
    <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3')
     include( 'includes/footer_style1.php');

     if($_GET['theme'] == 'fs2')
     include( 'includes/footer_style2.php');
     
     
     ?>
      </div>
  <!-- #wrapper end -->
  <?php include( 'includes/foot.php'); ?> </body>

</html>