@extends('Frontend.layouts.default')
@section('content')
<!-- Document Wrapper
      ============================================= -->
<!-- Page Title
               ============================================= -->
<section id="page-title" class="page-title-pattern page-title-center">
    <div class="container clearfix">
        <h1>Contact</h1>
    </div>
</section><!-- #page-title end -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <!-- Postcontent
                            ============================================= -->
            <div class=" nobottommargin">
                <h3>Get in Touch with Us</h3>
                 <div id='contactMsg'></div>
                <div class="">
                    <form class="" action="{{route('contactSend')}}" method="POST" id='contactform'>
                        <div class="col_one_third">
                            <input type="text" name='firstname' placeholder="Name *" class="sm-form-control required" />
                        </div>
                        <div class="col_one_third">
                            <input type="email" name='useremail' placeholder="Email *" class="required email sm-form-control" />
                        </div>
                        <div class="col_one_third col_last">
                            <input type="text" name="telephone" placeholder="Mobile *" class="sm-form-control" />
                        </div>
                        <div class="clear"></div>
                        <div class="col_full">
                            <textarea class="required sm-form-control" name='message' placeholder="Your Message" rows="6" cols="30"></textarea>
                        </div>
                        <div class="col_full">
                            <button class="button button-3d nomargin" type="submit" id="msgsubmit"  value="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div><!-- .postcontent end -->
            <!-- Sidebar
            ============================================= -->
            <div class="sidebar col_last nobottommargin">
                <address>
                    <strong>Dhaka</strong><br>
                    AZ Consultant Ltd.<br/>
House# 373 (2nd Floor), Road# 28,
Mohakhali DOHS, Dhaka-1212, Bangladesh.
                    <!-- 8th Floor, Haque Tower, IA - 28/8 – D, Mohakhali, C/A Dhaka 1212<br> -->
                </address>
                <address>
                    <strong>Mumbai</strong><br>
                    C/504, Neelkanth Business Park, Near Vidyavihar Station, 
                    Vidyavihar West, Mumbai 400086.<br>
                </address>
                <abbr><strong>Email:</strong></abbr> info@infiniteit.biz 
                <div class="widget noborder notoppadding">
                    <a href="https://www.facebook.com/VeestoresGlobal/" target="_blank" class="social-icon si-small si-dark si-facebook">
                        <i class="icon-facebook"></i>
                        <i class="icon-facebook"></i>
                    </a>
                </div>
            </div><!-- .sidebar end -->
            <div class="clearfix"></div>
        </div>
    </div>
</section>
@stop

@section("myscripts")

 <script>


    $("#contactform").validate({
        // Specify the validation rules
        rules: {
            firstname: "required",
            useremail: {
                required: true,
                email: true,
                //emailvalidate: true
            },
            telephone: {
                required: true,
               //  phonevalidate: true
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