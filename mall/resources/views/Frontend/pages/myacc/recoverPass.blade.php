@extends('Frontend.layouts.default')

@section('content')
<div class="page-heading bc-type-3">
  <div class="bc-type-login bg-pos-crumb">
    <div class="container">
      <div class="row">
        <div class="col-md-12 a-center">
          <h1 class="title">Login</h1>
          <nav class="woocommerce-breadcrumb" itemprop="breadcrumb">
            <a href="{{ route('home') }}">Home</a> <span class="delimeter">/</span>   
            <a href="#"> Recover Password </a> 
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<div itemscope itemtype="#" class="container">
  <div class="page-content">
    <div class="page-content sidebar-position-left">
      <div class="row">
        <div class="col-sm-12">
            <p style="text-align: center;color: red;">{{ Session::get('recError') }}</p>
            
          <form method="post" action="{{ route('updateRecoverPass') }}" class=" recoverPassForm form-reg-log-align">
          
          
            <p class="form-row form-row-wide">
              <label for="password">Password <span class="required">*</span></label>
              <input class="input-text" name="password" id="password" type="password"  required="true">
           <div id="password_login_validate" class="newerror"></div>
           
             <p class="form-row form-row-wide">
              <label for="password">Password <span class="required">*</span></label>
              <input class="input-text" name="password" id="password" type="password"  required="true">
           <div id="password_login_validate" class="newerror"></div>
            </p>
            <button type="submit" class="btn btn-black big pull-left" name="login" value="Login">Login</button> OR                                
                                               

          
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('myscripts')
<script>
    $(document).ready(function() {

            $(".userLoginForm").validate({
              
                rules: {
                    username: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                                //  minlength: 5
                    }
                },
                // Specify the validation error messages
                messages: {
                    username: {
                        required: "Please provide email id",
                        email: "Please enter valid email id"
                    },
                    password: {
                        required: "Please provide a password"
                                //  minlength: "Your password must be at least 5 characters long"
                    }
                },
                errorPlacement: function(error, element) {
                    var name = $(element).attr("name");
                    error.appendTo($("#" + name + "_login_validate"));
                }
            });

        });
       



</script>
@stop
