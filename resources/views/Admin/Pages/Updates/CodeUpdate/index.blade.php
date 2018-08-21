@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Code Updates
     
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Code Updates</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="row">
                            {!! Form::open(['route'=>'admin.updates.codeUpdate.view','method'=>'get']) !!}
                                <div class="col-md-3">
                                    <input type="text" name="date_search" id="dateSearch" class="form-control " placeholder="From Date">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                </div>
                            {!! Form::close() !!}
                            </div>                         

                        </div>

                          <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.updates.codeUpdate.newCodeUpdate','method'=>'post']) !!}
                            {!! Form::submit('New Code Update',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                            </div>


                    </div>



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Version</th>
                            <th>Number of Files</th>
                            <th>Number of Stores</th>
                            <th>Actual Files Updated</th>
                            <th>Date Time</th>
                            <th>Action</th>
                           
                        </tr>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{$log->id}}</td>
                            <td>{{$log->version}}</td>
                            <td>{{$log->no_of_files}}</td>
                            <td>{{$log->no_of_stores}}</td>
                            <td>{{$log->no_of_files_updated}}</td>
                            <td>{{date('d M Y h:i A',strtotime($log->created_at))}}</td>
                            <td><a href="{{route('admin.updates.backup.index',['id'=>$log->id])}}"><i class="fa fa-search"></i></a></td>
                        </tr>  
                        @endforeach

                    </table>
                    <div class="pull-right">
                        {{ $logs->links() }}
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
 var s_from_date = '<?php echo date('Y-m-d', strtotime('-30 days')); ?>';
 var s_to_date = '<?php echo date('Y-m-d'); ?>';


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
        console.log("start"+start);
         console.log("end"+end);
        alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });


</script>
@stop