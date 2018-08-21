@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Templates
      
     

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Templates</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    
                    <div class="row">
                        <div>
                            <p style="color:green;text-align: center;">{{ Session::get('successMessage') }}</p>
                            <p style="color:red;text-align: center;">{{ Session::get('errorMessage') }}</p>     
                        </div>
                        <div class="col-md-10">
                            {{ Form::open(['method'=>'get']) }}
                             <div class="col-md-5">
                                <div class="input-group">
                                    {{ Form::text('name',Input::get('name'),['class'=>'form-control','id'=>'nameSearch','placeholder'=>'Template Name']) }}
                                </div>
                            </div>  
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.templates.add','method'=>'post']) !!}
                            {!! Form::submit('Add New Template',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>                           
                            <th>File</th>
                            <th>Screenshot</th>                           
                            <th>Created On</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($templates as $val)
                        <tr>
                            <td>{{ @$val->name }}</td>                         
                            <td>{{ @$val->file }}</td>
                            <td>@if($val->screenshot)<img src="{{url('/public').$val->screenshot}}" style="height: 100px;width: 130px;" />@endif</td>                          
                            <td>{{ $val->created_at ? date('d-M-Y',strtotime($val->created_at)) : '' }}</td>
                            <td>
                                <a href="{{ route('admin.templates.edit') }}?id={{@$val->id }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="{{ route('admin.templates.delete') }}?id={{@$val->id }}" onclick="return confirm('Are you sure you want to delete this template?')" class="btn btn-danger btn-xs">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <?php
                    $arguments = [];
                    !empty(Input::get('name')) ? $arguments['name'] = Input::get('name') : '';
                    ?>
                    <div class="pull-right">
                        {{ $templates->appends($arguments)->links() }}
                    </div>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

@stop
@section('myscripts')
<script>
    s_from_date = '<?php echo date('Y-m-d', strtotime('-30 days')); ?>';
    s_to_date = '<?php echo date('Y-m-d'); ?>';



<?php if (!empty(Input::get('date_search'))) { ?>
    <?php $dateArr = explode(" - ", Input::get('date_search')); ?>
        s_from_date = '<?php echo date("Y-m-d", strtotime($dateArr[0])) ?>';
        s_to_date = '<?php echo date("Y-m-d", strtotime($dateArr[1])) ?>';
<?php } ?>



    $('#dateSearch').daterangepicker(
            {
                locale: {
                    format: 'YYYY-MM-DD'
                },
                startDate: s_from_date,
                endDate: s_to_date,
                autoUpdateInput: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            },
    function (start, end, label) {
       // alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });

</script>
@stop