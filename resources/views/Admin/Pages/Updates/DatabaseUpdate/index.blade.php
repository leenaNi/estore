@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Database Updates
     
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Database Updates</li>
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
                             <div class="col-md-3">
                                    <input type="text" name="date_search" id="dateSearch" class="form-control " placeholder="From Date">

                                </div>
                              <div class="col-md-3">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                             
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.updates.databaseUpdate.newDatabaseUpdate','method'=>'post']) !!}
                            {!! Form::submit('New Database Update',['class'=>'btn btn-info']) !!}
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
                            <th>Date</th>
                          
                            <th>Number of Stores</th>
                            <th>Actual Updated</th>
                            <th>Action</th>
                           
                        </tr>



               
                        <tr>
                            <td>1</td>
                            <td>1.1</td>
                            <td>4 Jan 2017</td>
                         
                            <td>55</td>
                            <td>48</td>
                            <td><a href="#"><i class="fa fa-search"></i></a></td>
                        </tr>  

                        <tr>
                            <td>1</td>
                            <td>1.11</td>
                            <td>17 Jan 2017</td>
                           
                            <td>61</td>
                            <td>59</td>
                            <td><a href="#"><i class="fa fa-search"></i></a></td>
                        </tr>  

                    </table>
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