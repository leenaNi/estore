@extends('Frontend.layouts.default')

@section('content')
<div id="content" class="site-content single-product">
    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('myProfile') }}">Home</a></li>
                <li><span class="current">Feedback</span></li>
            </ul>
        </div><!-- .container -->
    </div><!-- .breadcrumb -->


    <div class="container">

        <div class="row">
            <div class="col-md-3">
                @include('Frontend.includes.myacc')
            </div>

            <main id="main" class="site-main col-md-9">
                <h3 class="widget-title">Feedback</h3>

                <p style="text-align: center;color: green;">{{ Session::get('msg') }}</p>
                
                
                <form action="{{ route('saveFeedbackMyacc') }}" method="post" enctype="multipart/form-data" id="feedbackForm">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label>Email *</label>
                                <input type="email" class="input-text"  required value="{{ Auth::user()->email }}" disabled="disabled">
                                
                               
                            </div><!-- .input-field -->
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label>Attachment</label>
                                <input type='file' name='image' multiple="true" class="form-control" >
                            </div><!-- .input-field -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-field">
                                <label>Subject</label>
                                <input name="subject" type="text" class="input-text" id="" required="" value="" required>
                                
                                 <div id="subject_feedback"></div>
                            </div><!-- .input-field -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-field">
                                <textarea name="message" placeholder="Your message *" cols="30" rows="8" required></textarea>
                                 <div id="message_feedback"></div>
                            </div><!-- .input-field -->
                        </div>
                    </div>

                    <div class="input-field">
                        <input type="submit" value="Send" class="button bold yellow">
                    </div>
                </form>


            </main><!-- .site-main -->





        </div><!-- .row -->

    </div><!-- .container -->
</div><!-- .site-content -->

@stop


@section("myscripts")
<script>
    
        $("#feedbackForm").validate({
            // Specify the validation rules
            rules: {
                 subject: "required",
                  message: "required"
            },
            // Specify the validation error messages
            messages: {
            
                subject: "Please enter subject",
                message: "Please enter message"
               
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_feedback"));
            }
        });
    </script>
@stop