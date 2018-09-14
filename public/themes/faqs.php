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
        <h1>FAQs</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">FAQs</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi quidem minus id omnis, nam expedita, ea fuga commodi voluptas iusto, hic autem deleniti dolores explicabo labore enim repellat earum perspiciatis.</p>
          <div class="accordion accordion-bg clearfix">
            <div class="acctitle acctitlec lh30"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit?</div>
            <div class="acc_content text-justify clearfix" style="display: block;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi quidem minus id omnis, nam expedita, ea fuga commodi voluptas iusto, hic autem deleniti dolores explicabo labore enim repellat earum perspiciatis.</div>
            <div class="acctitle acctitlec lh30"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit?</div>
            <div class="acc_content text-justify clearfix" style="display: block;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi quidem minus id omnis, nam expedita, ea fuga commodi voluptas iusto, hic autem deleniti dolores explicabo labore enim repellat earum perspiciatis.</div>
            <div class="acctitle acctitlec lh30"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit?</div>
            <div class="acc_content text-justify clearfix" style="display: block;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi quidem minus id omnis, nam expedita, ea fuga commodi voluptas iusto, hic autem deleniti dolores explicabo labore enim repellat earum perspiciatis.</div>
            <div class="acctitle acctitlec lh30"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit?</div>
            <div class="acc_content text-justify clearfix" style="display: block;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi quidem minus id omnis, nam expedita, ea fuga commodi voluptas iusto, hic autem deleniti dolores explicabo labore enim repellat earum perspiciatis.</div>
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