<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
  <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' ||  $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3')
     include( 'includes/header_style1.php');

     if($_GET['theme'] == 'fs2' ||  $_GET['theme'] == 'ac2')
     include( 'includes/header_style2.php');
     
     
     ?>
    <section id="page-title">
      <div class="container clearfix">
        <h1>Login | Register</h1>
        <ol class="breadcrumb">
      
          <li><a href="<?php echo $_GET['theme']; ?>_home.php?theme=<?php echo $_GET['theme']; ?>">Home</a>
          </li>
          <li class="active">Login | Register</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
        <div class="tabs divcenter tabs-justify nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">
            <div class='alert alert-danger login-error' style="display:none;"></div>
            <ul class="tab-nav tab-nav2 loginTab center clearfix">
              <li class="inline-block" aria-selected="true" aria-expanded="true"><a href="#tab-login">Login</a>
              </li>
              <li class="inline-block "><a href="#tab-register">Register</a>
              </li>
            </ul>
            <div class="tab-container">
              <div class="tab-content clearfix" id="tab-login">
                <div class="panel panel-default nobottommargin">
                  <div class="panel-body pad40">
                    <form id="login-form" name="" class="nobottommargin" action="#" method="post">
                      <div class="col_full">
                        <input type="email" name="" value="" class="sm-form-control" placeholder="Email" /> </div>
                      <div class="col_full">
                        <input type="password" class="sm-form-control" placeholder="Password" /> </div>
                      <div class="col_full nobottommargin text-center">
                        <button class="button button-black nomargin" type="submit" value="login">Login</button>
                      </div>
                      <div class="col_full nobottommargin for-pass text-center topmargin-sm"> <a href="forgot-password.php" class="">Forgot Password?</a> </div>
                      <div class="col-md-12 topmargin-sm orDivider-box clearfix">
                        <div class="orDivider">or</div>
                    </div>
                    <div class="clearfix"></div>
                      
                    </form>
                    <div class="social_media text-center topmargin-sm">
                    <a id="fbLink" class="col-sm-6 col-xs-12 fb_login_btn"   style="margin-bottom:11px;"> <img src="images/fb_login.jpg" class="fb_login_btn"> </a>
                        <a href="#" class="col-md-6 col-sm-6 col-xs-12"> <img src="images/g_login.jpg" class="g_login_btn"> </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-content clearfix" id="tab-register">
                <div class="panel panel-default nobottommargin">
                  <div class="panel-body">
                    <form class="nobottommargin" method="post" id="register-form" action="#">
                      <div class="col_full">
                        <input type="text" required="true" value="" class="sm-form-control" placeholder="First Name *" /> </div>
                      <div class="col_full">
                        <input type="text" value="" class="sm-form-control" placeholder="Last Name" /> </div>
                      <div class="col_full">
                        <input type="email" required="true" value="" class="sm-form-control" placeholder="Email *" /> </div>
                      <div class="col_full">
                        <input type="password" name="" required="true" class="sm-form-control" placeholder="Password *" /> </div>
                      <div class="col_full">
                        <input type="password" name="" required="true" class="sm-form-control" placeholder="Confirm Password *" /> </div>
                      <div class="col_full">
                        <input type="text" name="" required="true" class="sm-form-control" placeholder="Mobile *" /> </div>
                      <div class="clearfix"></div>
                      <div class="col_full nobottommargin text-center">
                        <button class="button button-black nomargin w100 registerButton" value="register">Register Now<i class="icon-spinner icon-spin regLoader" style="display:none"></i>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
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