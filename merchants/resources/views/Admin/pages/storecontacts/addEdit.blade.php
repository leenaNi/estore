@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        All Contacts
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.customers.view') }}"><i class="fa fa-coffee"></i>All Contacts</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="panel-body">
                        @if(!empty(Session::get('usenameError')))
                            <p style="color:red;text-align: center;">{{ Session::get('usenameError') }}</p>
                        @endif
                        {{-- <p style="color:red;text-align: center;">{{ Session::get('usernameErr') }}</p> --}}
                        {{-- {{ dd(\Carbon\Carbon::parse($contacts->anniversary)->format('d/m/Y')) }} --}}
                        {!! Form::model($contacts, ['method' => 'post', 'route' => $action]) !!}
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            {!!Form::label('Name','Name ') !!}<span class="red-astrik"> *</span>
                                {!! Form::hidden('id',null) !!}
                                {!! Form::text('name',Input::get('name'), ["class"=>'form-control validate[required]' ,"placeholder"=>'Name']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Email','Email') !!}<span class="red-astrik">*</span>
                                {!! Form::text('email',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Email']) !!}
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('Anniversary', 'Anniversary Date') !!}
                                {!! Form::date('anniversary',isset($contacts->anniversary) ? date('Y-m-d',strtotime($contacts->anniversary)) : '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('BirthDate','BirthDate ') !!}
                            {!! Form::date('birthDate',isset($contacts->birthDate) ? \Carbon\Carbon::parse($contacts->birthDate)->format('Y-m-d') : '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('MobileNo','Mobile No') !!}<span class="red-astrik"> *</span>
                                {!! Form::text('mobileNo',null, ["class"=>'form-control validate[required]',"placeholder"=>'Mobile No']) !!}
                            </div>                           
                        </div>
                        
                        
                    <div class="col-md-12">
                        <div class="form-group">
                                {!! Form::submit('Submit',["class" => "btn btn-primary pull-right", "id" => " submit"]) !!}
                                {!! Form::close() !!}     
                            </div>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section("myscripts")
<script>
    $(document).ready(function() {
       $(".phone_no").blur(function(){
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
     
          $("#user-email").blur(function(){
           $('#user-email').parent().find('span.error').remove();
            var useremail = $(this).val();          
            $.ajax({
                type: "POST",
                url: "{{ route('admin.customers.chkExistingUseremail') }}",
                data: {useremail: useremail},
                cache:false,
                success:function(response){
                    console.log('@@@@'+response['status'])
                    if(response['status']== 'success') {
                        $('.email_error').remove();
                         $('#user-email').val('');
                        $('#user-email').parent().append('<span class="error email_error" style="color:red;">'+response['msg']+'</span>'); 
                    }
                    else $('#user-email').parent().find('span.error').remove();
                },error:function(e){
                    console.log(e.responseText);
                }
            }); 
    });
    });
</script>
@stop