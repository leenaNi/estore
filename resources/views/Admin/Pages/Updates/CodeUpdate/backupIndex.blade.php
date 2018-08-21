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
                   
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Filename</th>
                            <th>Backup Path</th>
                            <th>Source Path</th>
                            <th>Date Time</th>
                           
                        </tr>
                        @foreach($backups as $file)
                        <tr>
                            <td>{{$file->id}}</td>
                            <td>{{$file->filename}}</td>
                            <td>{{$file->file_path}}</td>
                            <td>{{$file->source_path}}</td>                            
                            <td>{{date('d M Y h:i A',strtotime($file->created_at))}}</td>
                        </tr>  
                        @endforeach

                    </table>
                    <div class="pull-right">
                        {{ $backups->links() }}
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
function(start, end, label) {
    alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
});


</script>
@stop