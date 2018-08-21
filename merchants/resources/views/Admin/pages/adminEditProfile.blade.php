@extends('Admin.layouts.default')

@section('content')
<section class="content-header">
    <h1>
        Edit Profile
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Edit Profile</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @if(!empty(Session::get('invaliOldPass')))
            <div class="alert alert-danger">{{ Session::get('invaliOldPass') }}</div>

            @endif
            <div class="box">
                <form role="form" action="{{$action}}" method="POST" enctype="multipart/form-data" class="form-horizontal" id="Edit-form">
                    <div class="box-body">
                        <input type="hidden" name="id" value="{{$user->id}}" >
                        <div class="form-group">

                            <label for="firstnam" class="col-sm-4 control-label">First Name</label><span class="red-astrik"> *</span>
                            <div class="col-sm-8">

                                <input type="text" class="form-control validate[required]" name="firstname"  value="{{$user->firstname}}" >

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lastname" class="col-sm-4 control-label">Last Name</label>
                            <div class="col-sm-8">

                                <input type="text" class="form-control" name="lastname"  value="{{$user->lastname}}" >

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email</label><span class="red-astrik"> *</span>
                            <div class="col-sm-8">

                                <input type="email" class="form-control" name="email_id" value="{{$user->email}}"  readonly>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telephone" class="col-sm-4 control-label">Mobile</label><span class="red-astrik"> *</span>
                            <div class="col-sm-8">

                                <input type="text" class="form-control  validate[required,custom[phone]]" name="telephone"  value="{{$user->telephone}}">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="profile" class="col-sm-4 control-label">Upload Photo</label>
                            <div class="col-sm-8">
                                <input type="file" name="profile" onchange="readURL(this);">
                            </div>
                            <!-- <p class="help-block">Example block-level help text here.</p> -->
                            <img id="select_image" src="#" alt="Selected Image" style="display: none;" />
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1" class="col-sm-4 control-label">
                                Current Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control oldPassInput" name="old_password"  placeholder="Current Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-4 control-label">
                                New Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password"  id="password" class="form-control"  placeholder="New Password">
                                <div id="password_login_validate" style="color:red;"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirmpwd" class="col-sm-4 control-label">
                                Confirm New Password</label>
                            <div class="col-sm-8">
                                <input type="password"  name="confirmpwd" class="form-control" placeholder="Confirm New Password">
                                <div id="confirmpwd_login_validate" style="color:red;"></div>
                            </div>
                        </div>

                        <div class="col-sm-8 col-sm-offset-4 noAllpadding">
                            <input  type="submit" class="btn btn-primary " value="Submit">
                            <button type="button" class="btn btn-default">Cancel</button>
                        </div>	
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop
@section('myscripts')
<script>
    $(document).ready(function(){
        
             $("#Edit-form").validate({
    // Specify the validation rules
    rules: {
    password: {
   
            minlength: 5
    },
            old_password:{
           minlength: 5
            },
            confirmpwd: {
            
                    minlength: 5,
                    equalTo: "#password"
            }
    },
            // Specify the validation error messages
            messages: {
            password: {
            required: "Please provide new password",
                    minlength: "Your password must be at least 5 characters long"
            }, old_password:{
            required: "Please enter current password."
            },
                    confirmpwd: {
                    required: "Please confirm your new password",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Please enter the same password as above"
                    }
            },
            errorPlacement: function (error, element) {
            var name = $(element).attr("name");
                    error.appendTo($("#" + name + "_login_validate"));
            }
    });

    $(".oldPassInput").on("keyup", function(){
    thispass = $(this).val();
            thisele = $(this);
            $(".oldPErr").remove();
            $(".submitProf").prop('disabled', false);
            if(thispass.length > 0){
            $.post("{{ route('adminCheckCurPassowrd') }}", {thispass: thispass}, function (resp) {
            $(".oldPErr").remove();
                    $(".submitProf").prop('disabled', false);
                    if (resp == 1) {

            thisele.after("<p class='oldPErr' style='color:red;'>Invalid Current Password. </p>");
                    $(".submitProf").prop('disabled', true);
            } else{
            $(".oldPErr").remove();
                    $(".submitProf").prop('disabled', false);
            }
           });
           }
    });
            $(".submitProf").on("click", function(){

    checkpass = $("input[name='password']").val();
    $(".conFErr").remove();
            if (checkpass.length > 0){
                
 if($("input[name='password']").val() == $("input[name='confirmpwd']").val()){
     if($("input[name='old_password']").val().length > 0){
          $("#Edit-form").submit();
     }
 }else{
     $("input[name='confirmpwd']").after("<p class='conFErr' style='color:red;'>Password and Confirm Password should be match.</p>");
 }

    } else{
    $("#Edit-form").submit();
    }
    });
            function readURL(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
                    reader.onload = function (e) {
                    $('#select_image')
                            .attr('src', e.target.result)
                            .width(150)
                            .height(200);
                    };
                    reader.readAsDataURL(input.files[0]);
                    $("#select_image").show();
            }
            }

    @php
            if ($user -> profile){
    @endphp
            $('#select_image')
            .attr('src', "{{ asset($public_path.$user->profile) }}")
            .width(150)
            .height(200);
            $("#select_image").show();
            @php
    }
    @endphp





    });
</script>
@stop