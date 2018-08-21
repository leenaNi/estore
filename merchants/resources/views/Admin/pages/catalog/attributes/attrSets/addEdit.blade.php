@extends('Admin.layouts.default')

@section('content')

<section class="content-header">
    <h1>
        Variant Sets
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.attribute.set.view')}}" > Variant Sets </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($attrSets, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}

                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                        {!! Form::label('Attribute Set Name', 'Variant Set Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                    </div>
                        {!! Form::hidden('id',null) !!}
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            {!! Form::text('attr_set',null, ["class"=>'form-control validate[required]' ,"id"=>"attr_set","placeholder"=>'Enter Variant Set Name']) !!}
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <span id='error_msg' ></span>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {!! Form::submit('Submit',['id'=>'attrSetSubmit',"class" => "btn btn-primary pull-right"]) !!}
                            {!! Form::close() !!}     


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
    $(document).ready(function () {
        $("#attr_set").blur(function () {
            var attrset = $(this).val();
           
            $.ajax({
                type: "POST",
                url: "{{ route('admin.attribute.set.checkattrset') }}",
                data: {attrset: attrset},
                cache: false,
                success: function (response) {
                    // console.log('@@@@'+response['msg'])
                    if (response['status'] == 'success') {
                        $('#attr_set').val('');
                        $('#error_msg').text(response['msg']).css({'color': 'red'});
                    } else
                        $('#error_msg').text('');
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
        });
    });
</script>
@stop

