@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Vendor
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Vendors </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($vendor, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
                    {!! Form::hidden('id',null) !!}
                    <div class="row" style="margin: 0px">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                {!!Form::label('vendorname','Vendor Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                    {!! Form::text('vendorname',null, ["class"=>'form-control',"placeholder"=>'Enter Vendor Name', "required"]) !!}

                                    @if ($errors->has('vendorname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('vendorname') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                    <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                        {!!Form::label('firstname','Spoc First Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('firstname',null, ["class"=>'form-control',"id"=>'link' ,"placeholder"=>'Enter Spoc First Name', "required"]) !!}

                            @if ($errors->has('firstname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                     <div class="col-md-6">
                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        {!!Form::label('lastname','Spoc Last Name ',['class'=>'control-label']) !!}<span class="red-astrik">*</span>
                            {!! Form::text('lastname',null, ["class"=>'form-control',"id"=>'link' ,"placeholder"=>'Enter Spoc Last Name', "required"]) !!}

                            @if ($errors->has('lastname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::label('email', 'Spoc Email ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('email',null, ["class"=>'form-control',"id"=>'page_name' ,"placeholder"=>'Enter Spoc Email', "required"]) !!}
                            <span id='error_msg'></span>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                   

                    <div class="col-md-6">
                    <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                        {!! Form::label('telephone', 'Spoc Phone Number',['class'=>' control-label']) !!}
                            {!! Form::text('telephone',null, ["class"=>'form-control',"id"=>'page_name' ,"placeholder"=>'Enter Spoc Phone']) !!}
                            <span id='error_msg'></span>

                            @if ($errors->has('telephone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telephone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row" style="margin: 0px">
                    @if($vendor->id == null)
                    <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Password','Password ') !!}<span class="red-astrik"> *</span>
                                {!! Form::password('password', ["class"=>'form-control' ,"placeholder"=>'Password']) !!}
                        </div>
                    </div> 
                    @else
                    <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Password','Password') !!}<span class="red-astrik"> *</span>
                                {!! Form::input('password','password','asdfdsasdddddddd', ["class"=>'form-control' ,"placeholder"=>'Password','readonly']) !!}
                        </div>
                    </div> 
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Select Status</label><span class="red-astrik"> *</span>
                                <select class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Disabled</option>
                                    <option value="3">Black Listed</option>
                                </select>
                        </div>
                    </div> 
                </div>
                    <div class="row" style="margin: 0px">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="control-label">Billing Address</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Enter Billing Address"></textarea>
                        </div>
                    </div>

        <div class="col-md-6">
            <div class="form-group">
            <label class="control-label">Bank Details</label>
            <textarea name="bank_data" class="form-control" rows="2" placeholder="Enter Bank Details"></textarea>
            </div>
        </div></div>
     
                    <div class="clearfix"></div><br>
                    <div class="col-md-12">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Submit',["class" => "btn btn-primary noLeftMargin"]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 
@stop 

@section('myscripts')
<script type="text/javascript">
     $(document).ready(function() {


      $(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });


      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });


    });


  $("#country").change(function(){
    var country_id = $("#country").val();
         $.ajax({
                method:"POST",
                data:{'id':country_id,"_token":"{{ csrf_token() }}"},
                url:"<?php echo route('admin.state.getState') ;?>",
                success: function(data){
                    $("#state").empty();
                    $.each(JSON.parse(data), function(i,v) {
                        $("#state").append('<option value="'+i+'">'+v+'</option>');
                    });
                }
            });
  });
</script>



@stop
