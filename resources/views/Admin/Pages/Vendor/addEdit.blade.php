@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Add/Edit </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Vendor</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="nav-tabs-custom">
                    <p style="color:red;text-align: center" class="VsMerchantError"></p>
                   
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">

                            <div class="row"> 
                                <div class="col-md-12 "> 
                                    {{ Form::model($vendor, ['route' => ['admin.vendors.saveUpdate', $vendor->id], 'class'=>'form-horizontal vendorGeneral','id'=>'vendorGeneral','method'=>'post','files'=>true]) }}
                                    {{ Form::hidden('id',(Input::get('id')?Input::get('id'):''), array('id' => 'id')) }}                                    
                                    {{ Form::hidden('existing_mid',null,['id'=>'existingMid', 'class'=>'exist-merch']) }}
                                    <div class="box-body"> 
                                      <div class="col-md-6">                                       
                                        <div class="form-group">
                                            {{ Form::label('First Name', 'First Name *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('firstname',  null, ['class'=>'form-control exist-merch','required'=>'true']) }}
                                            </div>
                                        </div>
                                    </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('Phone', 'Mobile *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">                                                
                                                {{Form::text('phone', null , ['class'=>'form-control exist-merch telephone','required'=>'true']) }}
                                            </div>
                                        </div> 
                                        </div>     
                                          <div class="col-md-6">                                  
                                        <div class="form-group">
                                            {{ Form::label('Email ID', 'Email *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::email('email',  null, ['class'=>'form-control exist-merch email' ,'required'=>'true']) }}
                                            </div>
                                        </div>
                                        </div>  
                                          <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('Currency', 'Currency ', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                <select class="form-control exist-merch" name="currency" required="true">
                                                    @foreach($curr as $cur)                                                    
                                                    <option value="{{$cur->id}}" {{ ($cur->id == @$vendor->currency) ? "selected='selected'" : ""  }} >{{ $cur->iso_code." -".ucwords(strtolower($cur->name)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('Password', 'Password *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                <?php
                                                    $data_pwd =[];
                                                    $data_pwd['class'] = 'form-control exist-merch password';
                                                    if(Input::get('id') == '')
                                                        $data_pwd['required'] = true;
                                                ?>
                                                {{Form::password('password',  $data_pwd ) }}
                                            </div>
                                        </div>
                                    </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('Confirm Password', 'Confirm Password *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                <?php
                                                    $data_cpwd = [];
                                                    $data_cpwd['class'] = 'form-control exist-merch password';
                                                    if(Input::get('id') == '')
                                                        $data_cpwd['required'] = true;
                                                ?>
                                                {{Form::password('cpassword', $data_cpwd  ) }}
                                            </div>
                                        </div>   
                                   </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('Choose your Industries', 'Choose Your Industries *', ['class' => 'col-sm-3 control-label']) }}
                                            
                                            
                                            <div class="col-sm-9">
                                                <select class="selectpicker form-control exist-merch" multiple required="true" name="already_selling[]">
                                                    @foreach($cat as $cat)
                                                    <option value="{{$cat->id}}" {{ (in_array($cat->id,@$already_selling) ? "selected='selected'" : "") }}  >{{$cat->category}}</option>
                                                   
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                     </div>        
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        {{Form::button('Save & Exit', ['class'=>'btn btn-info pull-right saveExitVendorGeneral']) }} &nbsp; &nbsp; 
                                     
                                    </div>
                                    <!-- /.box-footer -->
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                      
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
</div>
</section>
<!-- /.content -->
@stop
@section('myscripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


<script>
 jQuery.validator.addMethod("phone", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 4 &&
                phone_number.match(/^[\d\-\+\s/\,]+$/);
    }, "Please specify a valid phone number");

    var checkANew = $("input[name='id']").val();
    if (checkANew == '') {
        //alert(checkANew);
        $("a[href='#doc_2']").removeAttr("data-toggle");
    }


    $("#vendorGeneral").validate({
        rules: {
            firstname: {
                required: true
            }, phone: {
                required: true,
                phone: true,
                 
            },
            email: {
                email: true,
               
            },           
            cpassword: {
                equalTo: ".password"
            }, business_type: {
                required: true
            }, 'already_selling[]': {
                required: true
            }
        },
        messages: {            
            firstname: {
                required: "First name is required."
            },
            phone: {
                required: "Mobile is required.",
                remote:"Mobile already in use."

            }, password: {
                required: "Password is required."
            },
            email: {
                required: "Email is required.",
                email:"Email should be valid.",
                remote: "Email already in use."
            },
            cpassword: {
                required: "Confirm password is required."
            }, business_type: {
                required: "Industry is required."
            }, 'already_selling[]': {
                required: "Industry is required."
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });

   


    $(".saveExitVendorGeneral").click(function () {
        if ($("#vendorGeneral").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.vendors.saveUpdate') }}",
                data: $("#vendorGeneral").serialize(),
                cache: false,
                success: function (data) {
                    if(data != 'VsMerchantError'){
                    window.location.href = "{{ route('admin.vendors.view') }}";
                }
                else{
                     //window.location.href = "{{ route('admin.merchants.addEdit') }}";
                     $(".VsMerchantError").text("Existing merchnat can not be add for Veesw");
                 }
             }
         });
        }
    });
    
    
</script>
@stop