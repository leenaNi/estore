@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Add/Edit </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Distributor</a></li>
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
                                <div class="col-md-8 col-xs-12"> 
                                    {{ Form::model($distributor, ['route' => ['admin.distributors.saveUpdate', $distributor->id], 'class'=>'form-horizontal distributorGeneral','id'=>'distributorGeneral','method'=>'post','files'=>true]) }}
                                    {{ Form::hidden('id',(Input::get('id')?Input::get('id'):''), array('id' => 'id')) }}                                    
                                    {{ Form::hidden('existing_mid',null,['id'=>'existingMid', 'class'=>'exist-merch']) }}
                                    <div class="box-body">                                        
                                        <div class="form-group">
                                            {{ Form::label('First Name', 'First Name *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('firstname',  null, ['class'=>'form-control exist-merch','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Phone', 'Mobile *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">              
                                                {{Form::text('phone_no', null , ['class'=>'form-control exist-merch telephone','required'=>'true']) }}
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            {{ Form::label('Email ID', 'Email *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::email('email',  null, ['class'=>'form-control exist-merch email' ,'required'=>'true']) }}
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            {{ Form::label('store_name', 'Store Name *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('company_name', null, ['class'=>'form-control exist-merch' ,'required'=>'true']) }}
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            {{ Form::label('is_individual', 'Is Individual Store? *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                            <select class="form-control exist-merch" required="true" name="is_individual_store" disabled>
                                                <option value="1" {{ (@$is_individual_store == 1) ? "selected" : ""  }}>Yes</option>
                                                <option value="0" {{ (@$is_individual_store == 0) ? "selected" : ""  }} >No</option>
                                            </select>
                                            </div>
                                        </div>
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
                                        
                                        <div class="form-group">
                                            {{ Form::label('Choose your industry', 'Choose Your Industry *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                <select id="business_type"  name="business_type[]" class="selectpicker form-control exist-merch select-box-alsell" multiple required="true">
                                                    @foreach($cat as $catId=>$catName)
                                                        @if(isset($cat_selected) && in_array($catId, $cat_selected))
                                                            <option value="{{$catId}}" selected>{{$catName}}</option>
                                                        @else
                                                            <option value="{{$catId}}">{{$catName}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- 
                                            <div class="col-sm-9">
                                                {{ Form::select('business_type',$cat,@$cat_selected,['class'=>'form-control exist-merch','required'=>'true',"mulitple"=>"multiple"]) }}
                                            </div> --}}
                                        </div>
                                        
                                        <div class="form-group">
                                            {{ Form::label('Choose your features', 'Choose Your Features *', ['class' => 'col-sm-3 control-label']) }}
                                            
                                            
                                            <div class="col-sm-9">
                                                <select class="selectpicker form-control exist-merch" multiple required="true" name="already_selling[]">
                                                    <option value="Just checking out features" {{ (in_array("Just checking out features",@$already_selling) ? "selected='selected'" : "") }}  >Just checking out features</option>
                                                    <option value="Have retail store" {{ (in_array("Have retail store",@$already_selling) ? "selected='selected'" : "") }} >Have retail store</option>
                                                    <option value="Have online store" {{ (in_array("Have online store",@$already_selling) ? "selected='selected'" : "") }}>Have online store</option>
                                                    <option value="Selling on facebook" {{ (in_array("Selling on facebook",@$already_selling) ? "selected='selected'" : "") }}>Selling on facebook</option>
                                                </select>
                                            </div>
                                        </div>    
                                        
                                        <div class="form-group">
                                            {{ Form::label('Store version', 'Store version', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                <select class="form-control exist-merch" required="true" name="store_version">
                                                <option value="1" {{ (@$store_version == 1) ? "selected='selected'" : ""  }}>Starter Version - a simple online store with minimum features activated (FREE)</option>
                                                <option value="2" {{ (@$store_version == 2) ? "selected='selected'" : ""  }} >Advanced Version - a complex online store with highend features activated (FREE)</option>
                                            </select>
                                            </div>
                                        </div>
                                                                          
                                        
                                        <!-- <div class="form-group">
                                            {{ Form::label('Owners PAN #', 'Owner\'s PAN #', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('pan',  null, ['class'=>'form-control exist-merch']) }}
                                            </div>
                                        </div> -->
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        {{Form::button('Save & Exit', ['class'=>'btn btn-info pull-right saveExitDistributorGeneral']) }} &nbsp; &nbsp; 
                                        {{Form::button('Save & Next', ['class'=>'btn btn-info pull-right saveNextDistributorGeneral mr10']) }}
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


    $("#distributorGeneral").validate({
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
            $(".saveExitDistributorGeneral").attr('disabled', false);
            $(this).text('Save & Exit');
        }
    });

   


    $(".saveExitDistributorGeneral").click(function () {
        $(this).text('Submitting..');
        //$(this).attr('disabled', true);
        if ($("#distributorGeneral").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.distributors.saveUpdate') }}",
                data: $("#distributorGeneral").serialize(),
                cache: false,
                success: function (data) {                    
                    $(this).text('Save & Next');
                    //$(this).attr('disabled', true);
                    if (data.status) {
                        $("input[name='id']").val(data.data.id);
                        $('.nav-tabs a[href="#doc_2"]').tab('show');
                        addParamToCurrentURL('id', data.id);
                    } else {
                        if(typeof data.msg == 'object') {
                            res = JSON.parse(data.msg);
                            $.each(res, function (k, v) {
                              
                                var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                                var msg = $('<div style="color:red;" class="serverValid">' + v[0] + '</div>');
                                // console.log(msg);
                                $(".distributorGeneral " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                                $(".distributorGeneral " + eltype + "[name='" + k + "']").parent().append(msg);
                                 
                            });
                        } else {
                            alert(data.msg);
                        }
                    }
                }
            });
        }
    });
    
    
</script>
@stop
