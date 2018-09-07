@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Category Sales
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Category</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::open(['method'=>'get']) }}
                            <div class='row' class="col-md-10">
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                        {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Order Date']) }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    {{ Form::select('s_cat',$getCats,(Input::get('s_cat'))?Input::get('s_cat'):'',['class'=>'form-control']) }}
                                </div>

                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                </div>

                            </div>
                            {{ Form::close() }}
                        </div> 
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>

                            <th>Category</th>
                            <th>Sales</th>
                            <th>Action</th>

                        </tr>

                        @if(count($getCatSales) > 0)
                        @foreach($getCatSales as $cat)
                        <tr>

                            <td>{{ $cat->category }}</td>
                            <td><span class="currency-sym"> </span><span class="priceConvert">{{ number_format($cat->total_sales) }}</span></td>
                            <td> <a href="{{ route("admin.analytics.byCategoryExport") }}?catid={{$cat->id}}" class="label label-success active" ui-toggle-class="">Export</a></td>
                        </tr>                       
                        @endforeach
                         @else
                        <tr><td colspan="3" align="center">No records found!</td></tr>
                        @endif


                    </table>
                    <?php
                    $arguments = [];
                    !empty(Input::get('s_cat')) ? $arguments['s_cat'] = Input::get('s_cat') : '';
                    !empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
                    ?>
                    <div class="pull-right">
                        {{ $getCatSales->appends($arguments)->links() }}
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
        //alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });


</script>
@stop