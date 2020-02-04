@extends('Admin.layouts.default')

@section('mystyles')
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/daterangepicker/daterangepicker-bs3.css' }}">
<link rel="stylesheet" href="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.css' }}">
<style type="text/css">
    .multiselect-container {
        width: 100% !important;
    }
    .brbottom1{
        margin-bottom: 10px;
        padding: 10px;
    }
    .success{
        color: #3c763d;
    }
    .error{
        color: #d73925;
    }
</style>
@stop

@section('content')
<section class="content-header">
    <h1>
        Inward Transaction
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li><a href="{{ route('admin.distributor.orders.view') }}"><i class="fa fa-dashboard"></i>Distributor Order</a></li>
        <li class="active">Inward Transaction</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9 noBorder rightBorder">
                    {!! Form::open(['method' => 'get', 'route' => 'admin.distributor.orders.inwardList' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                        <input type="hidden" id="hdnOrderId" name="hdnOrderId" value="{{$hdnOrderId}}">
                        {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control', "placeholder"=>"Order Id"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_number_from',Input::get('order_number_from'), ["class"=>'form-control ', "placeholder"=>"Order No. From"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_number_to',Input::get('order_number_to'), ["class"=>'form-control ', "placeholder"=>"Order No. To"]) !!}
                    </div>
                    {{-- <div class="form-group col-md-4">
                        {!! Form::text('date',Input::get('date'), ["class"=>'form-control  date', "placeholder"=>"Order Date"]) !!}
                    </div> --}}
                    <div class="clearfix"></div>
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-6 col-xs-12 no-padding mob-marBottom15">
                            <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Filter</button>
                        </div>
                        <div class=" button-filter col-md-5 col-xs-12 no-padding noBottomMargin">
                            <a href="{{route('admin.distributor.orders.inwardList',['id'=>$hdnOrderId])}}"><button type="button" class="btn reset-btn form-control noMob-leftmargin">Reset</button></a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>GRN No.</th>
                                <th>GRN Date</th>
                                <th>Total Qty</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($inwardTransaction) >0 )
                            @foreach($inwardTransaction as $inwardTransactionData)
                            <tr>
                                <td>{{$inwardTransactionData->id}}</td>
                                <td>{{ date('d-M-Y',strtotime($inwardTransactionData->created_at)) }}</td>
                                <td>{{ $inwardTransactionData->grn_number }}</td>
                                <td>{{ date('d-M-Y',strtotime($inwardTransactionData->grn_date))}}</td>
                                <td>{{ $inwardTransactionData->received_qty }}</td>
                                <td>{{ $inwardTransactionData->total_price }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=14> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                   
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</section>
@stop
@section('myscripts')
<script src="{{  Config('constants.adminPlugins').'/daterangepicker/daterangepicker.js' }}"></script>
<script src="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.js' }}"></script>
<script>
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('.date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        $('.date').daterangepicker({
            startDate: start,
            endDate: end,
            format: 'YYYY/MM/DD',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
    });
</script>
@stop