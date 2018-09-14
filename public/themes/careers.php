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
        <h1>Careers</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">Careers</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col_full nobottommargin">
            <div class="fancy-title title-dotted-border title-center">
              <h3>Senior Python Developer</h3> </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo, natus voluptatibus adipisci porro magni dolore eos eius ducimus corporis quos perspiciatis quis iste, vitae autem libero ullam omnis cupiditate quam.</p>
            <div class="accordion accordion-bg clearfix">
              <div class="acctitle mar-bot30 mar-top30"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Requirements</div>
              <div class="acc_content clearfix">
                <ul class="iconlist iconlist-color nobottommargin">
                  <li><i class="icon-ok"></i>B.Tech./ B.E / MCA degree in Computer Science, Engineering or a related stream.</li>
                  <li><i class="icon-ok"></i>3+ years of software development experience.</li>
                  <li><i class="icon-ok"></i>3+ years of Python / Java development projects experience.</li>
                  <li><i class="icon-ok"></i>Minimum of 4 live project roll outs.</li>
                  <li><i class="icon-ok"></i>Experience with third-party libraries and APIs.</li>
                  <li><i class="icon-ok"></i>In depth understanding and experience of either SDLC or PDLC.</li>
                  <li><i class="icon-ok"></i>Good Communication Skills</li>
                  <li><i class="icon-ok"></i>Team Player</li>
                </ul>
              </div>
              <div class="acctitle mar-bot30 mar-top30"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>What we Expect from you?</div>
              <div class="acc_content clearfix">
                <ul class="iconlist iconlist-color nobottommargin">
                  <li><i class="icon-plus-sign"></i>Design and build applications/ components using open source technology.</li>
                  <li><i class="icon-plus-sign"></i>Taking complete ownership of the deliveries assigned.</li>
                  <li><i class="icon-plus-sign"></i>Collaborate with cross-functional teams to define, design, and ship new features.</li>
                  <li><i class="icon-plus-sign"></i>Work with outside data sources and API's.</li>
                  <li><i class="icon-plus-sign"></i>Unit-test code for robustness, including edge cases, usability, and general reliability.</li>
                  <li><i class="icon-plus-sign"></i>Work on bug fixing and improving application performance.</li>
                </ul>
              </div>
              <div class="acctitle mar-bot30 mar-top30"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>What you've got?</div>
              <div class="acc_content clearfix">You'll be familiar with agile practices and have a highly technical background, comfortable discussing detailed technical aspects of system design and implementation, whilst remaining business driven. With 5+ years of systems analysis, technical analysis or business analysis experience, you'll have an expansive toolkit of communication techniques to enable shared, deep understanding of financial and technical concepts by diverse stakeholders with varying backgrounds and needs. In addition, you will have exposure to financial systems or accounting knowledge.</div>
            </div> <a href="#" data-toggle="modal" data-target="#contactFormModal" class="button button-3d button-black nomargin">Apply Now</a> </div>
        </div>
      </div>
    </section>
    <!-- #content end -->
    <div class="modal fade" id="contactFormModal" tabindex="-1" role="dialog" aria-labelledby="contactFormModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="contactFormModalLabel">Fill this Application Form</h4> <span>Tell us a little about yourself so that we can help you with your job aspirations.</span> </div>
          <div class="modal-body">
            <div class="contact-widget">
              <form action="#" method="post" role="form">
                <div class="form-process"></div>
                <div class="col_half">
                  <label>First Name <small>*</small>
                  </label>
                  <input type="text" value="" class="sm-form-control required" /> </div>
                <div class="col_half col_last">
                  <label>Last Name <small>*</small>
                  </label>
                  <input type="text" value="" class="sm-form-control required" /> </div>
                <div class="clear"></div>
                <div class="col_half">
                  <label>Email <small>*</small>
                  </label>
                  <input type="email" value="" class="required email sm-form-control" /> </div>
                <div class="col_half col_last">
                  <label>Mobile <small>*</small>
                  </label>
                  <input type="text" value="" size="22" tabindex="5" class="sm-form-control required" /> </div>
                <div class="clear"></div>
                <div class="col_full">
                  <label>Position <small>*</small>
                  </label>
                  <select tabindex="9" class="sm-form-control required">
                    <option value="">-- Select Position --</option>
                    <option value="Senior Python Developer">Senior Python Developer</option>
                    <option value="Design Analyst">Design Analyst</option>
                    <option value="Head of UX and Design">Head of UX and Design</option>
                    <option value="Web &amp; Visual Designer (Marketing)">Web &amp; Visual Designer (Marketing)</option>
                  </select>
                </div>
                <div class="col_full">
                  <label>Upload Your Resume</label>
                  <br>
                  <input type="file" multiple="" class=""> </div>
                <div class="col_full">
                  <label>Are you currently employed?</label>
                  <div class="clear"></div>
                  <div class="col-md-6">
                    <input class="radio-style" type="radio" checked="">
                    <label class="radio-style-2-label">Yes</label>
                  </div>
                  <div class="col-md-6">
                    <input class="radio-style" type="radio" checked="">
                    <label class="radio-style-2-label">No</label>
                  </div>
                </div>
                <div class="clear"></div>
                <div class="col_full">
                  <button class="button button-large btn-block nomargin" type="submit" value="apply">Send Application</button>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3')
     include( 'includes/footer_style1.php');

     if($_GET['theme'] == 'fs2')
     include( 'includes/footer_style2.php');
     
     
     ?> </div>
  <!-- #wrapper end -->
  <?php include( 'includes/foot.php'); ?> </body>

</html>