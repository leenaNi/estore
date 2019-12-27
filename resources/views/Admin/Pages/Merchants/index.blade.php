@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Merchants

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Merchants</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    @if (Auth::guard('merchant-users-web-guard')->check() !== true) 
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::open(['method'=>'get']) }}
                            {{ Form::hidden('search',1) }}
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                    {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Select Date']) }}
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                {{ Form::text('s_company_name',!empty(Input::get('s_company_name'))?Input::get('s_company_name'):null,['class'=>'form-control','placeholder'=>'Merchant']) }}
                            </div>
                            <div class="col-md-3">
                                {{ Form::text('s_email',!empty(Input::get('s_email'))?Input::get('s_email'):null,['class'=>'form-control','placeholder'=>'Email ID']) }}
                            </div>


                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.merchants.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Merchant',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>

                    @endif

                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
<!--                            <th>ID</th>-->  
                            <th>Merchant Name</th>
                          <!--  <th>Owned By</th>--> 
                            <th>Email ID</th>
                            <th>Mobile</th>
                            <th>Industry</th>
                            <!--<th>Bank</th>--> 
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($merchants as $merchant)
                        <tr>
<!--                            <td>{{ $merchant->id }}</td>-->
                            <td>{{ $merchant->firstname." ".$merchant->lastname }}</td>
                           <!--  <td>{{ $merchant->firstname." ".$merchant->lastname }}</td>-->
                            <td>{{ $merchant->email }}</td>
                            <td>{{ $merchant->phone }}</td>
                            <td>{{ !empty(json_decode($merchant->register_details)->business_name) ? json_decode($merchant->register_details)->business_name : " " }}</td>
                            <!--<td><?php
                                //$banks = '';
                                //print_r($merchant->hasMarchants()->get());
                                //foreach ($merchant->hasMarchants()->get() as $b) {
                                  //  $banks.=$b->name . ', ';
                               // }
                               //echo rtrim($banks, ", ");
                                ?></td>--> 
                            <td>{{ date('d-M-Y',strtotime($merchant->created_at)) }}</td>
                            <td>
                                <a href="{{ route('admin.merchants.addEdit') }}?id={{$merchant->id }}" class="btn btn-success btn-xs">Edit</a>
<!--                                <a href="{{ route('admin.stores.addEdit') }}?mid={{$merchant->id }}" class="btn btn-success btn-xs">+ Store</a>-->
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <?php
                    $arguments = [];
                    !empty(Input::get('s_bank_name')) ? $arguments['s_bank_name'] = Input::get('s_bank_name') : '';
                    !empty(Input::get('s_company_name')) ? $arguments['s_company_name'] = Input::get('s_company_name') : '';
                    !empty(Input::get('s_email')) ? $arguments['s_email'] = Input::get('s_email') : '';
                    !empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
                    ?>
                    <div class="pull-right">
                        {{ $merchants->appends($arguments)->links() }}
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
        //   alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });

</script>
@stop