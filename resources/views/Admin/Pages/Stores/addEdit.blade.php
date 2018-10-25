@extends('Admin.Layouts.default')

@section('contents')
<style>
    .margin-Left-store{
        margin:0 5px 0 0;
    }
    
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Add/Edit </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Store</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#storeGeneral" data-toggle="tab" aria-expanded="true">General</a></li>
                        <li class=""><a href="#storeContact" data-toggle="tab" aria-expanded="false">Contact Details</a></li>
                        <li class=""><a href="#storeBusiness" data-toggle="tab" aria-expanded="false">Business Info</a></li>
                        <li class=""><a href="#storeBank" data-toggle="tab" aria-expanded="false">Bank Info</a></li>
                        <li class=""><a href="#storeDocs" data-toggle="tab" aria-expanded="false">Documents</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="storeGeneral">
                            <div class="row"> 
                                <div class="col-md-8 col-xs-12"> 
                                    {{ Form::model($store,['class'=>'form-horizontal','method'=>'post','id'=>'storeGeneralForm','files'=>true]) }}
                                    {{ Form::hidden('id',null) }}
                                    <div class="box-body mt15">
                                        <div class="form-group">
                                            {{ Form::label('Merchant Name', 'Merchant Name *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::select('merchant_id',$selMerchatns ,(Input::get('mid'))?Input::get('mid'):null, ['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Category', 'Store Category *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::select('category_id',$selCats ,null, ['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Store Name', 'Store Name *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('store_name',null ,['class'=>'form-control checkStore','required'=>'true']) }}
                                                <p class="error storeErr" style="color:red;"> </p>
                                            </div>
                                        </div>
                                        <div>
                                            <?php
                                            if (!empty($store->logo)) {
                                                $slogo = asset('public/admin/uploads/logos/') . "/" . @$store->logo;
                                            } else {
                                                $slogo = asset('public/admin/uploads/logos/') . "/default-store.jpg";
                                            }
                                            ?>

                                            <img src="{{ $slogo }}" class="storeLogo" height="20%" width="20%"></img>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Logo', 'Store Logo', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::file('logo', ['class'=>'form-control storeFUp']) }}
                                            </div>


                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Store URL Key *', 'Store URL Key *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('url_key',null, ['class'=>'form-control',!empty(Input::get('id'))?'readonly':'','required'=>true]) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Status', 'Status *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::select('status',[''=>'Please select','1'=>'Enabled','0'=>'Disabled'] ,1, ['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            {{ Form::label('Language', 'Language *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::select('language_id',$languagesSel ,null, ['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            {{ Form::label('Template', 'Template *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::select('template_id',$templates ,null, ['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3">
                                            &nbsp;  {{Form::button('Save & Next', ['class'=>'btn btn-info saveNextStoreGeneral']) }}
                                            {{Form::button('Save & Exit', ['class'=>'btn btn-info saveExitStoreGeneral']) }}
                                        </div>
                                    </div>
                                    <!-- /.box-footer -->
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="storeContact">
                            <div class="row"> 
                                <div class="col-md-8 col-xs-12"> 
                                    {{ Form::model($store,['class'=>'form-horizontal','method'=>'post','id'=>'storeContactForm']) }}
                                    {{ Form::hidden('id',null) }}
                                    <div class="box-body mt15">
                                        <div class="form-group">
                                            {{ Form::label('Country', 'Country *', ['class' => 'col-sm-3  control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::select('country_id',$selCountries ,null, ['class'=>'form-control country','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('State', 'State *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::select('zone_id',$selZones ,null, ['class'=>'form-control zone' ,'required'=>'true','id'=>'zoneId']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('City', 'City', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('city',null ,['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Pin', 'Pin *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('pin',null ,['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Address', 'Address *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('address',null ,['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('First Name', 'First Name *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('contact_firstname',null ,['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Last Name', 'Last Name', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('contact_lastname',null ,['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Email Id', 'Email ID *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('contact_email',null ,['class'=>'form-control','required'=>'true']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Mobile', 'Mobile *', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('contact_phone',null ,['class'=>'form-control ','required'=>'true']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3">
                                            &nbsp;  {{Form::button('Save & Next', ['class'=>'btn btn-info saveNextStoreContact']) }}
                                            {{Form::button('Save & Exit', ['class'=>'btn btn-info saveExitStoreContact']) }}
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>                                
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="storeBusiness">
                            <div class="row"> 
                                <div class="col-md-8 col-xs-12"> 
                                    {{ Form::model($store,['class'=>'form-horizontal','id'=>'storeBusinessForm','method'=>'post']) }}
                                    {{ Form::hidden('id',null) }}
                                    <div class="box-body mt15">
                                        <div class="form-group">
                                            {{ Form::label('Commision', 'Commision', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('precent_to_charge', null ,['class'=>'form-control mt15']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('TIN Number', 'TIN Number ', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('tin',null ,['class'=>'form-control mt15']) }}
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            {{ Form::label('PAN', 'PAN ', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('pan',null ,['class'=>'form-control mt15']) }}
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            {{ Form::label('Key Person Aadhaar', 'Key Person Aadhaar', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('aadhar',null ,['class'=>'form-control mt15']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('Sales Tax ', 'Sales Tax ', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('service_tax',null ,['class'=>'form-control mt15']) }}
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            {{ Form::label('Service Tax/VAT', 'Service Tax/VAT ', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{Form::text('service_tax_vat',null ,['class'=>'form-control mt15']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3">
                                            &nbsp;  {{Form::button('Save & Next', ['class'=>'btn btn-info saveNextStoreBusiness']) }}
                                            {{Form::button('Save & Exit', ['class'=>'btn btn-info saveExitStoreBusiness']) }}
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="storeBank">
                            {{ Form::model($store,['class'=>'form-horizontal','id'=>'storeBankForm','method'=>'post']) }}
                            {{ Form::hidden('id',null) }}
                            <div class="box-body mt15">
                                <div class="form-group">
                                    {{ Form::label('Name as per Bank', 'Name as per Bank *', ['class' => 'col-sm-2 mt15 control-label']) }}
                                    <div class="col-sm-10">
                                        {{Form::text('ac_holder_name',null ,['class'=>'form-control mt15','required'=>'true']) }}
                                    </div>
                                </div> 
                                <div class="form-group">
                                    {{ Form::label('Bank Name', 'Bank Name *', ['class' => 'col-sm-2 mt15 control-label']) }}
                                    <div class="col-sm-10">
                                        {{Form::text('bank_name',null ,['class'=>'form-control mt15','required'=>'true']) }}
                                    </div>
                                </div> 
                                <div class="form-group">
                                    {{ Form::label('Branch Name', 'Branch Name *', ['class' => 'col-sm-2 mt15 control-label']) }}
                                    <div class="col-sm-10">
                                        {{Form::text('branch_name',null ,['class'=>'form-control mt15','required'=>'true']) }}
                                    </div>
                                </div> 
                                <div class="form-group">
                                    {{ Form::label('Account Number', 'Account Number *', ['class' => 'col-sm-2 mt15 control-label']) }}
                                    <div class="col-sm-10">
                                        {{Form::text('ac_no',null ,['class'=>'form-control mt15','required'=>'true']) }}
                                    </div>
                                </div>  
                                <div class="form-group">
                                    {{ Form::label('IFSC Code', 'IFSC Code *', ['class' => 'col-sm-2 mt15 control-label']) }}
                                    <div class="col-sm-10">
                                        {{Form::text('ifsc_code',null ,['class'=>'form-control mt15','required'=>'true']) }}
                                    </div>
                                </div>  
                            </div>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    &nbsp;  {{Form::button('Save & Next', ['class'=>'btn btn-info saveNextStoreBank']) }}
                                    {{Form::button('Save & Exit', ['class'=>'btn btn-info saveExitStoreBank']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.tab-content -->
                        <div class="tab-pane" id="storeDocs">
                            {{ Form::model($store,['class'=>'form-horizontal','id'=>'storeDocForm','method'=>'post','route'=>'admin.stores.saveUpdateStoreDoc','files'=>true]) }}
                            {!! Form::hidden('id',null) !!}
                            <?php
                            $storeDocs = $store->getdocuments()->get();
                            $totFile = 0;
                            ?>
                            <div class="row col-sm-8 form-group existingImg">
                                <p><b>Upload Document *</b></p>
                                @if(count($storeDocs) > 0)
                                @foreach($storeDocs as $mKey => $storedoc)
                                <div id="doc-{{$storedoc->id}}" class="documents">
                                    <div class="col-sm-2">
                                        <img src="{{asset('public/admin/uploads/storeDocuments/')."/".$storedoc->filename}}" class="img-responsive thumbnail"   >
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="docs[]" type="file" class="form-control filestyle" id="{{++$totFile}}" data-input="false" >
                                        <input name="is_doc[]" type="hidden" value="0" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! Form::text('des[]',@$storedoc->des, ["class"=>'form-control' ,"placeholder"=>'Document Name', "required"=>"true"]) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::hidden('id_doc[]',@$storedoc->id) !!}
                                        <a href="javascript:void(0);"  data-value="{{$storedoc->id}}" class="label label-danger active deleteDocument DelDoc">Delete</a> 
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                @endforeach
                                @else
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-4">
                                    <input  name="docs[]" type="file" class="form-control filestyle" id="{{$totFile}}" data-input="false"  required="true">
                                    <input name="is_doc[]" type="hidden" value="0" />
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('des[]',null, ["class"=>'form-control' ,"placeholder"=>'Document Name', "required"=>"true"]) !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::hidden('id_doc[]',null) !!}
                                </div>
                                <div class="clearfix"></div>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:void(0);" class="label label-success active addMoreDoc" >Add More</a> 
                            </div>
                            <div class='clearfix'></div>
                            <div class="box-footer">

                                {{Form::submit('Save & Exit', ['class'=>'btn btn-info pull-right']) }}
                                {{Form::button('Close', ['class'=>'btn btn-info pull-right docClose margin-Left-store']) }}   
                                {{ Form::close() }}
                            </div>
                            <div class="addNew" style="display: none;">
                                <div class="clearfix mt15 documents">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-4">
                                        <input  name="docs[]" type="file" class="form-control filestyle" data-input="false"  required="true">
                                        <input name="is_doc[]" type="hidden" value="0" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! Form::text('des[]',null, ["class"=>'form-control' ,"placeholder"=>'Description', "required"=>"true"]) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::hidden('id_doc[]',null) !!}
                                        <a href="javascript:void(0);" class="label label-danger active deleteImg">Delete</a> 
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- /.content -->
@stop
@section('myscripts')
<script>

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            console.log(reader);
            reader.onload = function (e) {
                $('.storeLogo').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $('.storeLogo').attr('src', "{{$slogo}}");
        }
    }


    $(".storeFUp").change(function () {
        readURL(this);
    });

    var checkANew = $("input[name='id']").val();
    if (checkANew == '') {
        //alert(checkANew);
        $("a[href='#storeContact']").removeAttr("data-toggle");
        $("a[href='#storeBusiness']").removeAttr("data-toggle");
        $("a[href='#storeBank']").removeAttr("data-toggle");
        $("a[href='#storeDocs']").removeAttr("data-toggle");
    }

    var totFile = <?= $totFile; ?>;
    $('.existingImg').on('change', 'input[type="file"]', function (e) {
        //console.log(e.target.files[0]);
        if (e.target.files[0]) {
            if (e.target.id) {
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
//for general


//  jQuery.validator.addMethod("noSpace", function(value, element) { 
//  return value.indexOf(" ") < 0 && value != ""; 
//}, "No space please and don't leave it empty");

     $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-]+$/i.test(value);
    }, "Url key must contain only letters, numbers, or dashes.");

    $("#storeGeneralForm").validate({
        rules: {
            merchant_id: {
                required: true
            },
            category_id: {
                required: true
            },
            url_key: {
                loginRegex:true,
                required: true
                
            },
            status: {
                required: true
            }
            //language_id: {
              //  required: true
            //}
        },
        messages: {
            merchant_id: {
                required: "Merchant is required"
            },
            category_id: {
                required: "Category is required"
            },
            url_key: {
                required: "URL key is required"
            },
            status: {
                required: "Status is required"
            }
           // language_id: {
                //required: "Language is required"
            //}
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });

    $(".saveExitStoreGeneral").click(function () {
        if ($("#storeGeneralForm").valid()) {
            var formDataGeneralS = new FormData($("#storeGeneralForm")[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.stores.saveUpdateGeneral') }}",
                data: formDataGeneralS,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.id) {
                        window.location.href = "{{ route('admin.stores.view') }}";
                    } else {
                        res = JSON.parse(data);
                        //console.log(res);
                        $.each(res, function (k, v) {
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v + '</div>');
                            $("#storeGeneralForm " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $("#storeGeneralForm " + eltype + "[name='" + k + "']").parent().append(msg);
                        });
                    }
                }
            });
        }
    });

    $(".saveNextStoreGeneral").click(function () {
        if ($("#storeGeneralForm").valid()) {
            var formDataGeneralS = new FormData($("#storeGeneralForm")[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.stores.saveUpdateGeneral') }}",
                data: formDataGeneralS,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.id) {
                        $("input[name='id']").val(data.id);
                        $('.nav-tabs a[href="#storeContact"]').tab('show');
                        addParamToCurrentURL('id', data.id);
                    } else {
                        res = JSON.parse(data);
                        console.log(res);
                        $.each(res, function (k, v) {
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v + '</div>');
                            $("#storeGeneralForm " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $("#storeGeneralForm " + eltype + "[name='" + k + "']").parent().append(msg);
                        });
                    }
                }
            });
        }
    });
//for contact
    $("#storeContactForm").validate({
        rules: {
            country_id: {
                required: true
            },
            zone_id: {
                required: true
            },
            pin: {
                required: true
            },
            address: {
                required: true
            },
            contact_firstname: {
                required: true
            },
            contact_email: {
                required: true,
                email: true
            },
            contact_phone: {
                required: true
            }
        },
        messages: {
            country_id: {
                required: "Country is required"
            },
            zone_id: {
                required: "State is required"
            },
            pin: {
                required: "Pin is required"
            },
            address: {
                required: "Address is required"
            },
            contact_firstname: {
                required: "First Name is required"
            },
            contact_email: {
                required: "Email Id is required",
                email: "Valid email is required"
            },
            contact_phone: {
                required: "Mobile is required"
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });
    $(".saveNextStoreContact").click(function () {
        if ($("#storeContactForm").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.stores.saveUpdateContact') }}",
                data: $("#storeContactForm").serialize(),
                cache: false,
                success: function (data) {

                    if (data.id) {
                        $("input[name='id']").val(data.id);
                        $('.nav-tabs a[href="#storeBusiness"]').tab('show');
                        addParamToCurrentURL('id', data.id);
                    } else {
                       
                        console.log(data);
                        $.each(data, function (k, v) {
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v + '</div>');
                            $("#storeContactForm " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $("#storeContactForm " + eltype + "[name='" + k + "']").parent().append(msg);
                        });
                    }
                }
            });
        }
    });
    $(".saveExitStoreContact").click(function () {
        if ($("#storeContactForm").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.stores.saveUpdateContact') }}",
                data: $("#storeContactForm").serialize(),
                cache: false,
                success: function (data) {
                    if (data.id) {
                        window.location.href = "{{ route('admin.stores.view') }}";
                    } else {
                        res = JSON.parse(data);
                        console.log(res);
                        $.each(res, function (k, v) {
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v + '</div>');
                            $("#storeContactForm " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $("#storeContactForm " + eltype + "[name='" + k + "']").parent().append(msg);
                        });
                    }
                }
            });
        }
    });
    // save Business
//    $("#storeBusinessForm").validate({
//        rules: {
//            tin: {
//                required: true
//            },
//            pan: {
//                required: true
//            }
//        },
//        messages: {
//            tin: {
//                required: "Tin is required"
//            },
//            pan: {
//                required: "PAN is required"
//            }
//        },
//        errorPlacement: function (error, element) {
//            var name = $(element).attr("name");
//            var errorDiv = $(element).parent();
//            errorDiv.append(error);
//        }
//    });

    $(".saveNextStoreBusiness").click(function () {
        if ($("#storeBusinessForm").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.stores.saveUpdateBusiness') }}",
                data: $("#storeBusinessForm").serialize(),
                cache: false,
                success: function (data) {

                    if (data.id) {
                        $("input[name='id']").val(data.id);
                        $('.nav-tabs a[href="#storeBank"]').tab('show');
                        addParamToCurrentURL('id', data.id);
                    } else {
                        res = JSON.parse(data);
                        console.log(res);
                        $.each(res, function (k, v) {
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v + '</div>');
                            $("#storeBusinessForm " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $("#storeBusinessForm " + eltype + "[name='" + k + "']").parent().append(msg);
                        });
                    }
                }
            });
        }
    });
    $(".saveExitStoreBusiness").click(function () {
        if ($("#storeBusinessForm").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.stores.saveUpdateBusiness') }}",
                data: $("#storeBusinessForm").serialize(),
                cache: false,
                success: function (data) {
                    if (data.id) {
                        window.location.href = "{{ route('admin.stores.view') }}";
                    } else {
                        res = JSON.parse(data);
                        console.log(res);
                        $.each(res, function (k, v) {
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v + '</div>');
                            $("#storeBusinessForm " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $("#storeBusinessForm " + eltype + "[name='" + k + "']").parent().append(msg);
                        });
                    }
                }
            });
        }
    });
    
    $(".checkStore").on("keyup", function () {
        storename = $("input[name='store_name']").val();

        if (storename.length < 4) {
            $(".storeErr").text("Store name should be more than 4 letters");
            $(".getVeestore").prop('disabled', true);
            return false;
        } else {
            $(".storeErr").text("");
            $(".getVeestore").removeAttr('disabled');
        }

        $.ajax({
            type: "POST",
            url: "{{route('checkStoreAdmin')}}",
            data: {storename: storename},
            cache: false,
            success: function (resp) {
                if (resp == 1) {
                    $(".storeErr").text("Sorry, this Store name is taken. Try another.");
                    $(".getVeestore").prop('disabled', true);

                } else {
                    $(".storeErr").text("");
                    $(".getVeestore").removeAttr('disabled');
                }

            }


        });
    });
    
    
    // save Bank
    $("#storeBankForm").validate({
        rules: {
            ac_holder_name: {
                required: true
            },
            bank_name: {
                required: true
            }, branch_name: {
                required: true
            },
            ac_no: {
                required: true
            }, ifsc_code: {
                required: true
            }
        },
        messages: {
            ac_holder_name: {
                required: 'Name as per Bank  is required.'
            },
            bank_name: {
                required: 'Bank Name is required.'
            }, branch_name: {
                required: 'Branch Name is required.'
            },
            ac_no: {
                required: 'Account Number is required.'
            }, ifsc_code: {
                required: 'IFSC Code is required.'
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });
    $(".saveNextStoreBank").click(function () {
        if ($("#storeBankForm").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.stores.saveUpdateBank') }}",
                data: $("#storeBankForm").serialize(),
                cache: false,
                success: function (data) {
                    if (data.id) {
                        $("input[name='id']").val(data.id);
                        $('.nav-tabs a[href="#storeDocs"]').tab('show');
                        addParamToCurrentURL('id', data.id);
                    } else {
                        res = JSON.parse(data);
                        console.log(res);
                        $.each(res, function (k, v) {
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v + '</div>');
                            $("#storeBankForm " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $("#storeBankForm " + eltype + "[name='" + k + "']").parent().append(msg);
                        });
                    }
                }
            });
        }
    });

    $(".saveExitStoreBank").click(function () {
        if ($("#storeBankForm").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.stores.saveUpdateBank') }}",
                data: $("#storeBankForm").serialize(),
                cache: false,
                success: function (data) {
                    if (data.id) {
                        window.location.href = "{{ route('admin.stores.view') }}";
                    } else {
                        res = JSON.parse(data);
                        console.log(res);
                        $.each(res, function (k, v) {
                            var eltype = $('[name="' + k + '"]').prop('tagName').toLowerCase();
                            var msg = $('<div style="color:red;" class="serverValid">' + v + '</div>');
                            $("#storeBankForm " + eltype + "[name='" + k + "']").parent().find("div.serverValid").remove();
                            $("#storeBankForm " + eltype + "[name='" + k + "']").parent().append(msg);
                        });
                    }
                }
            });
        }
    });
    // save Documents
    $("#storeDocForm").validate({
        rules: {
            "des[]": {
                required: true
            },
            "docs[]":
            {
                required:true
            }
        },
        messages: {
            "des[]": {
                required: "Please add description"
            },
            "docs[]":
            {
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


    $(".docClose").click(function () {
        window.location.href = "{{ route('admin.stores.view') }}";
    });

    $("body").on("click", ".deleteImg", function () {
<?php $totFile--; ?>
        $(this).parent().parent().remove();
    });

    $("body").on("click", ".DelDoc", function () {
        var docId = $(this).attr("data-value");
        var chk = confirm("Are you sure want to delete this document?");
        var delrow = $(this);
        if (chk == true) {
            $.ajax({
                type: "POST",
                url: "{!! route('admin.stores.deleteStoreDoc') !!}",
                catch : false,
                data: {docId: docId},
                success: function (data) {
                    $('#doc-' + docId).remove();
                    //window.location.reload();
                }
            });
        }
    });

    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        e.preventDefault();
        history.pushState({}, "", this.href);
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
        //alert(id);
    });
// on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('.nav-tabs a[href="' + hash + '"]').tab('show');

    var countryId = $(".country").val();
    var zoneid = $(".zoneId").val();

    if (countryId != '') {
        $.get("{{ route('admin.stores.getZoneDropdown')}}/" + countryId, function (data) {

            var zoneoption = jQuery.parseJSON(data);
            $.each(zoneoption, function (key, value) {

                if (value['id'] == zoneid)
                {
                    $(".zone").append('<option selected="true" value="' + value['id'] + '">' + value['name'] + '</option>');
                }
                $(".zone").append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
            });
        });
    }
    $(document).on("change", ".country", function () {
        $(".zone").empty();
        var value = $(this).val();
        $.get("{{route('admin.stores.getZoneDropdown')}}/" + value, function (data) {
            var zoneoption = jQuery.parseJSON(data);
            $(".zone").append('<option value="">Please select</option>');
            $.each(zoneoption, function (key, value) {

                $(".zone").append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
            });
        });
    });

    

</script>
@stop