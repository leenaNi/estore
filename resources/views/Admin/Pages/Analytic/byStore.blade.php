@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Store Sales </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Stores</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-10">

                            {{ Form::open(["method"=>"get"]) }}
                            {{ Form::hidden("get_search",1) }}
                            <div class="row">
                                   <div class="col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                        {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Order Date']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ Form::select('s_cat',$sCats,(Input::get('s_cat'))?Input::get('s_cat'):null,['class'=>'form-control']) }}

                                </div>

                                <div class="col-md-3">
                                    <input type="text" name="s_mer_name" class="form-control" value="{{!empty(Input::get('s_mer_name'))?Input::get('s_mer_name'):null}}" placeholder="Merchant">

                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="s_store_name" class="form-control" value="{{!empty(Input::get('s_store_name'))?Input::get('s_store_name'):null}}" placeholder="Store">
                                </div>

                             
                            </div>
                            <div class='row mt15' >
                                <div class="col-md-3">
                                    {{ Form::select("s_status",[""=>"Select Status","1"=>"Enabled","0"=>"Disabled"],null,['class'=>'form-control']) }}

                                </div>
                                
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>

                            {{ Form::close() }}
                        </div>

                        <div class="col-md-2 text-right">
                            <a href="{{ route("admin.analytics.byStore.export") }}" class="btn  btn-info"> <i class="fa fa-file-excel-o" ></i> Export</a>
                        </div>



                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Merchant</th>
                            <th>Store </th>
                            <th>Category </th>
                            <th>Sales</th>
                        </tr>
                        @if(count($storesales) > 0)
                        @foreach($storesales as $ssale)
                        <tr>

                            <?php
                            if (!empty($ssale->logo)) {
                                $simg = asset('/public/admin/uploads/logos/' . $ssale->logo);
                            } else {
                                $simg = asset('/public/admin/uploads/logos/default-store.jpg');
                            }
                            ?>


                            <!--<td><img src="{{ @$simg }}" width="50"  alt="User Image"></td>-->
                            <td>{{$ssale->firstname}}</td>
                            <td>{{$ssale->store_name}}</td>
                            <td>{{$ssale->category}}</td>
                            <!--<td>{{$ssale->banknames}}</td>-->
                            <td>{{ Session::get('cur') }}  {{number_format($ssale->total_sales)}}</td>

                        </tr>

                        @endforeach
                        @else
                        <tr> <td colspan="4" align="center">No records found!</td></tr>
                        @endif



                    </table>
                    <?php
                    $arguments = [];
                    !empty(Input::get('s_cat')) ? $arguments['s_cat'] = Input::get('s_cat') : '';
                    !empty(Input::get('s_mer_name')) ? $arguments['s_mer_name'] = Input::get('s_mer_name') : '';
                    !empty(Input::get('s_store_name')) ? $arguments['s_store_name'] = Input::get('s_store_name') : '';
                    !empty(Input::get('s_status')) ? $arguments['s_status'] = Input::get('s_status') : '';
                    !empty(Input::get('s_bank_name')) ? $arguments['s_bank_name'] = Input::get('s_bank_name') : '';
                    !empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
                    ?>
                    <div class="pull-right">
                        {{ $storesales->appends($arguments)->links() }}
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