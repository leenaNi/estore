@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Orders Report 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">  Orders Report </li>
    </ol>
</section>

<section class="main-content"> 
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-9 noAll-padding displayFlex">
                <div class="filter-left-section"> 
                    <form method="get" action=" " id="searchForm">
                        <input type="hidden" name="attrSetCatalog">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                <input type="text" value="{{ !empty(Input::get('order_number'))?Input::get('order_number'):'' }}" name="order_number" aria-controls="editable-sample" class="form-control medium" placeholder="Order Number">
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                <input type="text" value="{{ !empty(Input::get('customer_name'))?Input::get('customer_name'):'' }}" name="customer_name" aria-controls="editable-sample" class="form-control medium" placeholder="Customer Name">
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                {!! Form::text('datefrom',Input::get('datefrom'), ["class"=>'form-control fromDate', "placeholder"=>"From Date"]) !!}
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12 noBottom-margin"> 
                                {!! Form::text('dateto',Input::get('dateto'), ["class"=>'form-control toDate', "placeholder"=>"To Date"]) !!}
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12 noBottom-margin"> 
                                {!! Form::select('order_status',$o_status,Input::get('order_status'), ["class"=>'form-control filter_type', "placeholder"=>"Order Status"]) !!}
                        </div>
                        <div class="form-group col-md-4 noBottom-margin"> 
                            <div class="button-filter-search col-md-4 col-xs-12 no-padding mob-marBottom15">
                                <input type="submit" name="submit" vlaue='Submit' class='btn btn-primary fullWidth noAll-margin'>
                            </div>
                            <div class="button-filter col-md-4 col-xs-12 no-padding noBottomMargin">
                                <a href="{{ route('admin.report.ordersIndex')}}" class="btn reset-btn fullWidth noMob-leftmargin">Reset </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3 noAll-padding displayFlex">
                <div class="filter-right-section">                    
                    <a href="{!! route('admin.report.orderIndexExport') !!}" class="btn btn-primary fullWidth pull-left" target="_" type="button">Export</a>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Orders Report </h1>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr>
                            <th class="text-center">Order Number</th>
                            <th class="text-right">Date</th>
                            <th class="text-left">Name</th>
                            <th class="text-center">Order Status</th>
                            <th class="text-center">Payment Method</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">COD Charges</th>
                            <th class="text-right">Gifting Charges</th>
                            <th class="text-right">Discount Amount</th>
                            <th class="text-right">Shipping Amount</th>
                            <th class="text-right">Referal Code Amount</th>
                            <th class="text-right">Voucher Amount Used</th>
                            <th class="text-right">Coupon Amount Used</th>
                            <th class="text-right">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                         @if (count($orders)>0)
                            @foreach($orders as $order)
                            <tr>
                                <td class="text-center">{{ $order->order_id }}</td>
                                <td class="text-right">{{ date('d-M-Y',strtotime($order->order_date)) }}</td>
                                <td class="text-left">{{ @$order->first_name }} {{ @$order->last_name }} </td>
                                <td class="text-center"><span class="alertDanger">{{ $order->order_status }}</span></td>
                                <td class="text-center">{{ $order->payment_method  }}</td>
                                <td class="text-right">{{ $order->amount }}</td>
                                <td class="text-right">{{ $order->cod_charges }}</td>
                                <td class="text-right">{{ $order->gifting_charges }}</td>
                                <td class="text-right">{{ $order->discount_amt }}</td>
                                <td class="text-right">{{ $order->shipping_amt }}</td>
                                <td class="text-right">{{ $order->referal_code_amt }}</td>
                                <td class="text-right">{{ $order->voucher_amt_used }}</td>
                                <td class="text-right">{{ $order->coupon_amt_used }}</td>
                                <td class="text-right">{{ $order->total_amount }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td colspan="14" class="text-center"> No Data Found </td></tr>
                        @endif
                    </tbody>
                </table>

                {{ $orders->links() }}
            </div>
        </div>
    </div>
</section> 
<div class="clearfix"></div>
@stop

@section('myscripts')
<script>
    $(document).ready(function () {
        $(".fromDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".toDate").datepicker("option", "minDate", selected);
            }
        });
        $(".toDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".fromDate").datepicker("option", "maxDate", selected);
            }
        });
    });
</script>
@stop
