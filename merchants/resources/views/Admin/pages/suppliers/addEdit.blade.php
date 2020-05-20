@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
    Vendors
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""> <a href="{{route('admin.systemusers.view')}} " >Vendors </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">


                    <div class="panel-body">
                        <p style="color:red;text-align: center;">{{ Session::get('usenameError') }}</p>
                        <p style="color:red;text-align: center;">{{ Session::get('usenameSuccess') }}</p>

                        {!! Form::model($user, ['method' => 'post', 'route' => $action ,'id'=>'supplierForm']) !!}
                        <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            {!!Form::label('Name','First Name ') !!}<span class="red-astrik"> *</span>
                            {!! Form::hidden('id',null) !!}
                            {!! Form::text('firstname',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'First Name']) !!}
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            {!!Form::label('Last Name','Last Name') !!}
                            {!! Form::text('lastname',null, ["class"=>'form-control' ,"placeholder"=>'Last Name']) !!}
                          </div>
                        </div>
                               <div class="col-md-6">
                            <div class="form-group">
                                <?php //$attr_Sets = $attrs->attributesets->toArray(); ?>
                                {!! Form::label('Country Code', 'Country Code ') !!}<span class="red-astrik">*</span>
                                {!! Form::select('country_code',["+91"=>"(+91) India","+880"=>"(+880) Bangladesh"],null, ["class"=>'form-control',"placeholder"=>'Select Country code',"required"] ) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {!!Form::label('Mobile','Mobile') !!}<span class="red-astrik"> *</span>
                            {!! Form::text('telephone',null, ["class"=>'form-control  validate[required,custom[phone]', "placeholder"=>'Mobile', ($user->telephone)? "readonly": '']) !!}
                            <span class='phone_error' style='color:red'></span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {!!Form::label('Email','Email Id') !!}
                            {!! Form::text('email',null, ["class"=>'form-control checkEmail', "autocomplete"=>"off","placeholder"=>'Email Id',($user->email)? "readonly": '']) !!}
                           <span id='email_error' style='color:red'></span>
                          </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Password','Password ') !!}<span class="red-astrik"> *</span>
                            <input type="password" name="password" value="{{$user->password_crpt}}" class="form-control pass validate[required]"  placeholder="Password" autocomplete="off">

                            </div>
                        </div>
                           <!--   {!! Form::hidden('password') !!} -->
                        <div class="col-md-6">
                        <div class="form-group">
                        @if($settingStatus['acl'] == 1)
                            {!!Form::label('Role','Role ') !!}<span class="red-astrik"> *</span>
                                {!! Form::select('roles',$roles_name,!empty($user->roles()->first()->id)?$user->roles()->first()->id:null,["class"=>'form-control m-b validate[required]' , ]) !!}
                                @else
                                {!! Form::hidden('roles',1) !!}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {!!Form::label('Status','Status ') !!}<span class="red-astrik"> *</span>
                            {!! Form::select('status',[''=>'Status','0'=>'Disabled','1'=>'Enabled'],null,["class"=>'form-control m-b validate[required]']) !!}
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::submit('Submit',["class" => "noLeftMargin btn btn-primary SustemUserSubmit pull-right"]) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop


@section("myscripts")
<script>
//    function beforeCall(form, options){
//			if (console)
//			console.log("Right before the AJAX form validation call");
//			return true;
//		}
//
//		// Called once the server replies to the ajax form validation request
//		function ajaxValidationCallback(status, form, json, options){
//			if (console)
//			console.log(status);
//
//			if (status === true) {
//				alert("the form is valid!");
//				// uncomment these lines to submit the form to form.action
//				// form.validationEngine('detach');
//				// form.submit();
//				// or you may use AJAX again to submit the data
//			}
//		}
//    	jQuery(document).ready(function(){
//            jQuery("#systemUserForm").validationEngine({
//            ajaxFormValidation: true,
//            onAjaxFormComplete: ajaxValidationCallback,
//            onBeforeAjaxFormValidation: beforeCall
//            });
//        });
    $(document).ready(function() {
      $("#showpass").click(function(){
          if($("#showpass").is(':checked')){
              $('.pass').prop({type:"text"});
          }else {
                $('.pass').prop({type:"password"});
          }

      //  alert("pass");
      });

     $('.checkEmail').blur(function () {

        var email = $(this).val();
        $.ajax({
            type: 'POST',
            url: "{{route('checkExistingUser')}}",
            data: {email: email},
            success: function (response) {
                console.log(response);
                if (response.status == 'success' ) {
                    $('#email_error').html('');
                } else if (response.status == 'fail') {
                    $('.checkEmail').val('');
                    $('#email_error').html('Email already registered');
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    });



        $(".checkPhone").blur(function(){
             $('.phone_error').empty();
            var phone = $(this).val();
         var phoneno = /^\d{10}$/;
             if((phone.match(phoneno)))
             {
                return true;
              }
             else
              {

              $('.phone_error').append('<p> Please enter 10 digit mobile number </p>');
              return false;
              }
       });

//
        $(".checkPhone").blur(function(){
          var phone = $(this).val();
        $.ajax({
            type: 'POST',
            url: "{{route('checkExistingMobileNo')}}",
            data: {telephone: phone},
            success: function (response) {
                console.log('@@@@'+response['status']);
                if (response['status'] == 'success') {
                    $('.checkPhone').removeClass('error');
                    $('.phone_error').html('');
                } else if (response['status'] == 'fail') {
                    $('.checkPhone').addClass('error');
                    $('.checkPhone').val('');
                    $('.phone_error').html('<label class="error">'+response['msg'] +'</label>');
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    });


    });

</script>


@stop
