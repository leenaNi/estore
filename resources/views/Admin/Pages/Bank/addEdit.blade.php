@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Add/Edit </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Bank</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs ">
                        <li class="active"><a href="#bank_tab_1" data-toggle="tab" aria-expanded="true">General Info</a></li>
                        <li class=""><a href="#bank_tab_2" data-toggle="tab" aria-expanded="false">Documents</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="bank_tab_1">
                            <div class="row"> 
                                <div class="col-md-8 col-xs-12"> 
                                    <div class="">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Bank Details</h3>
                                        </div>
                                        {{ Form::model($bank, ['route' => ['admin.banks.saveUpdate', $bank->id], 'class'=>'form-horizontal bankGeneral','id'=>'bankGeneral','method'=>'post','files'=>true]) }}
                                        {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                                        <div class="box-body">
                                            <div class="form-group">
                                                {{ Form::label('Bank Name', 'Bank Name *', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::text('name',  null, ['class'=>'form-control bankVal','required'=>'true']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('Branch Name', 'Branch Name *', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::text('branch',  null, ['class'=>'form-control bankVal','required'=>'true']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('Email Id', 'Email Id *', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::email('email',  null, ['class'=>'form-control bankVal','required'=>'true']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('Phone Number', 'Phone Number *', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::text('phone',  null, ['class'=>'form-control bankVal','required'=>'true']) }}
                                                </div>
                                            </div>
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Contact Person's Details</h3>
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('Contact firstname', 'Firstname *', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::text('contact_firstname',  null, ['class'=>'form-control bankVal','required'=>'true']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('Contact lastname', 'Lastname', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::text('contact_lastname',  null, ['class'=>'form-control bankVal']) }}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                {{ Form::label('Contact lastname', 'Email Id *', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::email('contact_email',  null, ['class'=>'form-control','required'=>'true']) }}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                {{ Form::label('Contact phone', 'Phone Number *', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::text('contact_phone',  null, ['class'=>'form-control','required'=>'true']) }}
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                            {{Form::button('Save & Exit', ['class'=>'btn btn-info pull-right saveExitBankGeneral']) }} &nbsp; &nbsp; 
                                            {{Form::button('Save & Next', ['class'=>'btn btn-info pull-right saveNextBankGeneral mr10']) }}
                                        </div>
                                        <!-- /.box-footer -->
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="bank_tab_2">
                            <div class="box-body">
                                {!! Form::model($bank, ['method' => 'post', 'files' => true, 'route' => 'admin.banks.saveUpdateDocuments' ,'id'=>'bankDoc' ,'class' => 'form-horizontal','files'=>true ]) !!}
                                {!! Form::hidden('id',(Input::get('id'))?Input::get('id'):null) !!}
                                <?php
                                $bankDocs = $bank->documents()->get();
                                $totFile = 0;
                                ?>
                                <div class="row col-sm-8 form-group existingImg">
                                    @if(count($bankDocs) > 0)
                                    @foreach($bankDocs as $mKey => $bankdoc)
                                    <div id="doc-{{$bankdoc->id}}" class="documents">
                                        <div class="col-sm-2">
                                            <img src="{{asset('public/admin/uploads/bankDocuments/')."/".$bankdoc->filename}}" class="img-responsive thumbnail"   >
                                        </div>
                                        <div class="col-sm-4">
                                            <input name="docs[]" type="file" class="form-control filestyle" id="{{++$totFile}}" data-input="false" >
                                            <input name="is_doc[]" type="hidden" value="0" />
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::text('des[]',@$bankdoc->des, ["class"=>'form-control' ,"placeholder"=>'Document Name','required'=>true]) !!}
                                        </div>
                                        <div class="col-sm-2">
                                            {!! Form::hidden('id_doc[]',@$bankdoc->id) !!}
                                            <a href="javascript:void(0);"  data-value="{{$bankdoc->id}}" class="label label-danger active deleteDocument DelDoc">Delete</a> 
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    @endforeach
                                    @else
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="docs[]" type="file" class="form-control filestyle" id="{{$totFile}}"  data-input="false">
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
                                    <a class="btn btn-info pull-right" href="{{route('admin.banks.view')}}">Close</a> &nbsp;
                                &nbsp;&nbsp;&nbsp;    {{Form::submit('Save & Exit', ['class'=>'btn btn-info pull-right saveExitbankDoc']) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                            <div class="addNew" style="display: none;">
                                <div class="clearfix mt15 documents">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="docs[]" type="file" class="form-control filestyle" data-input="false">
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
<script>
    var checkANew = $("input[name='id']").val();
    if (checkANew == '') {
        //alert(checkANew);
        $("a[href='#bank_tab_2']").removeAttr("data-toggle");
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

    $(".bankVal").change(function () {
        if ($(this).next("div .serverValid").length == 1) {
            $(this).next("div .serverValid").remove();
        }

    });

    $("#bankGeneral").validate({
        rules: {
            name: {
                required: true
            }, branch: {
                required: true
            }, email: {
                required: true,
                email: true
            },
            phone: {
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
            name: {
                required: "Bank name is required"
            }, branch: {
                required: "Branch name is required"
            }, email: {
                required: "Email Id is required",
                email: "Valid Email Id is required"
            },
            phone: {
                required: "Phone is required"
            },
            contact_firstname: {
                required: "Contact Firstname is required"
            },
            contact_email: {
                required: "Contact Email Id is required",
                email: "Valid Email Id is required"
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });

    $("#bankDoc").validate({
        rules: {
            "des[]": {
                required: true
            }
        },
        messages: {
            "des[]": {
                required: "Please add description"
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
    $(".saveNextBankGeneral").on('click', function () {
        if ($("#bankGeneral").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.banks.saveUpdate') }}",
                data: $("#bankGeneral").serialize(),
                cache: false,
                success: function (data) {
                    if (data.id) {
          