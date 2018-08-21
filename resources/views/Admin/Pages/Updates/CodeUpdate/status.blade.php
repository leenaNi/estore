@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Code Updates Status

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Code Updates Status</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h4>Update Status</h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Sr. No.</th>
                            <th>File</th>
                            <th>Status</th>                           
                        </tr>
                        @foreach($update_log as $key=>$data)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$data['file']}}</td>
                            <td><div class="label <?= $data['status']== 'Success' ? 'label-success':'label-danger'?>">{{$data['status']}}</div></td>                            
                        </tr>  
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        @if($backup_log)
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h4>Backup Status</h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover" style="width:100%">
                        <tr>
                            <th>Sr. No.</th>
                            <th>File</th>
                            <th>Status</th>                           
                        </tr>
                        @foreach($backup_log as $key=>$data)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$data['file']}}</td>
                            <td><div class="label <?= $data['status']== 'Success' ? 'label-success':'label-danger'?>">{{$data['status']}}</div></td>                            
                        </tr>  
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        @endif
    </div>
</section>
<!-- /.content -->

@stop
@section('myscripts')
<script>
    $('#dateSearch').daterangepicker(
            {
                locale: {
                    format: 'YYYY-MM-DD'
                },
                startDate: '2013-01-01',
                endDate: '2013-12-31',
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
                alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });


</script>
@stop