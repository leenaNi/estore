@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Add/Edit </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Merchant</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="nav-tabs-custom">
                    <p style="color:red;text-align: center" class="VsMerchantError"></p>
                    
                    <ul class="nav nav-tabs ">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">General Info</a></li>
                        <li class=""><a href="#doc_2" data-toggle="tab" aria-expanded="false">Documents</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">

                            <div class="row"> 
                                <div class="col-md-8 col-xs-12"> 
                                    {{ Form::model($merchant, ['route' => ['admin.merchants.saveUpdate', $merchant->id], 'class'=>'form-horizontal merchantGeneral','id'=>'merchantGeneral','method'=>'post','files'=>true]) }}
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
                                                {{Form::text('phone', null , ['class'=>'form-control exist-merch telephone','required'=>'true']) }}
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            {{ Form::label('Email ID', 'Email *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::email('email',  null, ['class'=>'form-control exist-merch email' ,'required'=>'true']) }}
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            {{ Form::label('Currency', 'Currency ', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                <select class="form-control exist-merch" name="currency" required="true">
                                                    @foreach($curr as $cur)                                                    
                                                    <option value="{{$cur->id}}" {{ ($cur->id == @$curr_selected) ? "selected='selected'" : ""  }} >{{ $cur->iso_code." -".ucwords(strtolower($cur->name)) }}</option>
                                                    @endforeach
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
                                                {{ Form::select('business_type',$cat,@$cat_selected,['class'=>'form-control exist-merch','required'=>'true']) }}
                                            </div>
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
                                        {{Form::button('Save & Exit', ['class'=>'btn btn-info pull-right saveExitMerchantGeneral']) }} &nbsp; &nbsp; 
                                        {{Form::button('Save & Next', ['class'=>'btn btn-info pull-right saveNextMerchantGeneral mr10']) }}
                                    </div>
                                    <!-- /.box-footer -->
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="doc_2">                            
                            <div class="box-body">
                                {!! Form::model($merchant, ['method' => 'post', 'files' => true, 'route' => 'admin.merchants.saveUpdateDocuments' ,'id'=>'MerchantDoc' ,'class' => 'form-horizontal','files'=>true ]) !!}
                                {!! Form::hidden('id',(Input::get('id'))?Input::get('id'):null) !!}
                                <?php
                                $merchantDocs = $merchant->documents()->get();
                                $totFile = 0;
                                ?>
                                <div class="row col-sm-8 form-group existingImg">
                                    <p><b>Upload Document *</b></p>
                                    @if(count($merchantDocs) > 0)
                                    @foreach($merchantDocs as $mKey => $merchantdoc)
                                    <div id="doc-{{$merchantdoc->id}}" class="documents">
                                        <div class="col-sm-2">
                                            <img src="{{asset('public/admin/uploads/merchantDocuments/')."/".$merchantdoc->filename}}" class="img-responsive thumbnail"   >
                                        </div>
                                        <div class="col-sm-4">
                                            <input name="docs[]" type="file" class="form-control filestyle" id="{{++$totFile}}" data-input="false" >
                                            <input name="is_doc[]" type="hidden" value="0" />
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::text('des[]',@$merchantdoc->des, ["class"=>'form-control' ,"placeholder"=>'Document Name','required'=>true]) !!}
                                        </div>
                                        <div class="col-sm-2">
                                            {!! Form::hidden('id_doc[]',@$merchantdoc->id) !!}
                                            <a href="javascript:void(0);"  data-value="{{$merchantdoc->id}}" class="label label-danger active deleteDocument DelDoc">Delete</a> 
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    @endforeach
                                    @else
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="docs[]" type="file" class="form-control filestyle" id="{{$totFile}}"  data-input="false"  required="true">
                                        <input name="is_doc[]" type="hidden" value="0" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! Form::text('des[]',null, ["class"=>'form-control' ,"placeholder"=>'Document Name','required'=>true]) !!}
                                    </div>
                                    {!! Form::hidden('id_doc[]',null) !!}
                                    <div class="clearfix"></div>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" class="label label-success active addMoreDoc" >Add More</a>
                                </div>
                                <div class='clearfix'></div>
                                <div class="box-footer">
                                    <a class="btn btn-info pull-right" href="{{route('admin.merchants.view')}}"> Close</a>
                                    {{Form::submit('Save & Exit', ['class'=>'btn btn-info pull-right saveExitMerchantDoc mr10']) }}
                                    <!--                                    {{Form::button('Save & Next', ['class'=>'btn btn-info pull-right saveNextMerchantDoc']) }}-->
                                </div>
                                {{ Form::close() }}
                            </div>
                            <div class="addNew" style="display: none;">
                                <div class="clearfix mt15 documents">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="docs[]" type="file" class="form-control filestyle" data-input="false" required="true">
                                        <input name="is_doc[]" type="hidden" value="0" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! Form::text('des[]',null, ["class"=>'form-control' ,"placeholder"=>'Document Name','required'=>true]) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::hidden('id_doc[]',null) !!}
                                        <a href="javascript:void(0);" class="label label-danger active deleteDocument">Delete</a> 
                                    </div>
                                </div> 
                            </div>
                        </div>
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


    var totFile = <?= $totFile; ?>;
    $('.existingImg').on('change', 'input[type="file"]', function (e) {
        //console.log(e.target.files[0]);
        if (e.target.files[0]) {
            if (e.target.id) {``
                //console.log("Id present");
                $('input#' + e.target.id).parent().find('input[name="is_doc[]"]').val('1');
            } else {
                //console.log("Not present");
                e.target.id = '<?= ++$totFile; ?>';
                $('input#<?= $totFile; ?>:first-child');
                $('input#<?= $totFile; ?>').parent().find('input[name="is_doc[]"]').val('1');
            }
        } else {
            if (e.target.id)
                $('input#' + e.target.id).parent().find('input[name="is_doc[]"]').val('0');
        }
    });
    $("#merchantGeneral").validate({
        rules: {
            firstname: {
                required: true
            }, phone: {
                required: true,
                phone: true,
                  remote: function () {
                    var id = $("#id").val();
                    console.log("phone-"+id);
                    if(id == '')
                    {
                        var tele = $('.telephone').val().replace(/\s/g, '');
                        var r = {
                            url: "{{route('checkExistingphone')}}",
                            type: "post",
                            cache: false,
                            data: {phone_no: tele},
                            dataFilter: function (response) {
                                if (response == 1)
                                    return false; //return true or false
                                else
                                    return true;
                            }
                        };
                        return r;
                    }
                }
            },
            email: {
                email: true,
                remote: function () {
                    var id = $("#id").val();
                    console.log("email-"+id);
                    if(id == '')
                    {
                        var emal = $('.email').val().replace(/\s/g, '');
                        var r = {
                            url: "{{route('checkExistingUser')}}",
                            type: "post",
                            cache: false,
                            data: {email: emal,id: $("#id").val()},
                            dataFilter: function (response) {
                                if (response == 1)
                                    return false; //return true or false
                                else
                                    return true;
                            }
                        };
                        return r;
                    }
                }
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
                required: "Feature is required."
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });

    $("#MerchantDoc").validate({
        rules: {
            "des[]": {
                required: true
            },
            "docs[]":{
                required:true
            }
        },
        messages: {
            "des[]": {
                required: "Please add description"
            },
            "docs[]": {
                required: "Please add document"
            }
        },
        errorPlacement: function (error, element) {
            var chkattr = $(element).attr("required");
            if (typeof chkattr !== typeof undefined && chkattr !== false) {
                $(element).css("border-color", "red");
            } else {
                $(element).rules("remove");
                $(element).removeClass("error");
                $(element).addClass("valid");
                $(element).css("border-color", "");
            }
        }
    });
    
    $(".addMoreDoc").click(function () {
        $(".existingImg").append($(".addNew").html());
    });
	
    $("body").on("click", ".deleteDocument", function () {
        $(this).parent().parent().remove();
    });
        $("body").on("click", ".DelDoc", function () {
        var docId = $(this).attr("data-value");
        var chk = confirm("Are you sure want to delete this document?");
        var delrow = $(this);
        if (chk == true) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.merchants.deleteDocument') }}",
                catch : false,
                data: {docId: docId},
                success: function (data) {
                    $('#doc-' + docId).remove();
                    //window.location.reload();
                }
            });
        }
    });



    $(".saveNextMerchantGeneral").on('click', function () {
        if ($("#merchantGeneral").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.merchants.saveUpdate') }}",
                data: $("#merchantGeneral").serialize(),
                cache: false,
                success: function (data) {
                    if (data.id) {
                        $("input[name='id']").val(data.id);
                        $('.nav-tabs a[href="#doc_2"]').tab('show');
                        addParamToCurrentURL('id', data.id);
                    } else {
                        res = JSON.parse(data);

                        $.each(res, function (k, v) {
                            // console.log(k);
                            // console.log(v[0]);
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v[0] + '</div>');
                            // console.log(msg);
                            $(".merchantGeneral " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $(".merchantGeneral " + eltype + "[name='" + k + "']").parent().append(msg);
                            // console.log($(".merchantGeneral" + eltype + "[name='" + k + "']").parent());    

                        });
                    }
                }
            });
        }
    });

    $(".saveExitMerchantGeneral").click(function () {
        if ($("#merchantGeneral").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.merchants.saveUpdate') }}",
                data: $("#merchantGeneral").serialize(),
                cache: false,
                success: function (data) {
                    if(data != 'VsMerchantError'){
                    window.location.href = "{{ route('admin.merchants.view') }}";
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