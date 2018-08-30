@extends('Frontend.layouts.default')
@section('content')
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
              <h3>Get in touch with Us</h3> </div>
               <div id='contactMsg'></div>
            <div class="contact-widget">
              <form class="nobottommargin"  id="contactform" method="post" action="{{route('contact-sent')}}">
                <div class="col_full">
                  <input type="text" placeholder="Full Name*" name="firstname" value="" class="sm-form-control required" /> </div>
                <div class="col_full">
                  <input type="email" placeholder="Email*" name="useremail"  value="" class="required email sm-form-control" /> </div>
                <div class="col_full">
                  <input type="text" placeholder="Mobile*"  name="telephone" value="" class="sm-form-control" /> </div>
                <div class="col_full">
                    <textarea class="required sm-form-control" name="message" rows="6" cols="30" placeholder="Message *"></textarea>
                </div>
                <div class="col_full hidden">
                  <input type="text" value=""   class="sm-form-control" /> </div>
                <div class="col_full">
                  <button name="submit" type="submit"   id="msgsubmit"  value="Submit" class="button nomargin msgsubmit">Submit</button>
                </div>
              </form>
            </div>
          </div>
          <!-- Contact Form End -->
          <!-- Google Map
					============================================= -->
          
          <?php   ?>
          <div class="col_half col_last">
            <section class="gmap" style="height: 500px;">
              <iframe src="" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </section>
          </div>
          <!-- Google Map End -->
          <div class="clear"></div>
          <!-- Contact Info
					============================================= -->
          <div class="row">
            <div class="col-md-4 col-sm-6 mobMB15 clearfix">
              <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon"> <a href="#"><i class="icon-map-marker2"></i></a> </div>
                <h3>Reach Us<span class="subtitle">Vidyavihar west</span></h3> </div>
            </div>
            <div class="col-md-4 col-sm-6 mobMB15 clearfix">
              <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon"> <a href="#"><i class="icon-phone3"></i></a> </div>
                <h3>Call Us<span class="subtitle">0123456789</span></h3> </div>
            </div>
            <div class="col-md-4 col-sm-6 mobMB15 clearfix">
              <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon"> <a href="#"><i class="icon-mail"></i></a> </div>
                <h3>Mail Us<span class="subtitle">asdf@gmail.com</span></h3> </div>
            </div>
            <div class="clearfix"></div>
          </div>
          <!-- Contact Info End -->
        </div>
      </div>
    </section>
 @stop
 @section('myscripts')
 <script>


    $("#contactform").validate({
        // Specify the validation rules
        rules: {
            firstname: "required",
            useremail: {
                required: true,
                email: true,
                emailvalidate: true
            },
            telephone: {
                required: true,
                 phonevalidate: true
            },
            message: {
                required: true,
            }
        },
        // Specify the validation error messages
        messages: {
            firstname: "Please enter your full name",
            useremail: {
                required: "Please provide email id",
                email: "Please enter valid email id"
            },
            telephone: {
                required: "Please enter mobile number"

            },
            message: {
                required: "Please enter message"
            }

        },
        submitHandler: function (form) {
              //$('#msgsubmit').attr('disabled', true);
               $('#msgsubmit').attr('disabled', true).html('Sending...');
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                success: function (response) {
                    console.log(response);
                     
                   // alert('ndjfhsgdjhf');
                   // alert(response);
                    if (response == 1) {
                        $('#msgsubmit').attr('disabled', false).html('Submit');
                        $('#contactMsg').html('<div class="alert alert-success center">Message sent successfully</div>');
                    $(form)[0].reset();            
                    } else {
                        $('#contactMsg').html('<div class="alert alert-danger center">Oops something went wrong</div>');
                    }
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            });
            return false; // required to block normal submit since you used ajax
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name + "_re_validate"));
        }

    });




</script>
@stop