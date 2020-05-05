@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Orders Report 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Reports</a></li>
        <li class="active">  Orders Report </li>
    </ol>
</section>

<section class="main-content"> 
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 noAll-padding">
                <div class="filter-left-section"> 
                    <form method="get" action=" " id="searchForm">
                        <input type="hidden" name="attrSetCatalog">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                                <input type="text" value="{{ !empty(Input::get('order_number'))?Input::get('order_number'):'' }}" name="order_number" aria-controls="editable-sample" class="form-control form-control-right-border-radius medium" placeholder="Order Number">
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'noun_user.svg'}}"></span>
                                <input type="text" value="{{ !empty(Input::get('customer_name'))?Input::get('customer_name'):'' }}" name="customer_name" aria-controls="editable-sample" class="form-control form-control-right-border-radius medium" placeholder="Customer Name">
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12"> 
                                {!! Form::select('order_status',$o_status,Input::get('order_status'), ["class"=>'form-control filter_type', "placeholder"=>"Order Status"]) !!}
                        </div>
                        <div class="form-group col-md-4 noBottom-margin col-sm-6 col-xs-12">
                             <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'calendar.svg'}}"></span>
                                {!! Form::text('datefrom',Input::get('datefrom'), ["class"=>'form-control form-control-right-border-radius fromDate', "placeholder"=>"From Date"]) !!} 
                        </div> 
                        </div>
                        <div class="form-group noBottom-margin col-md-4 col-sm-6 col-xs-12 noBottom-margin"> 
                             <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'calendar.svg'}}"></span>
                                {!! Form::text('dateto',Input::get('dateto'), ["class"=>'form-control form-control-right-border-radius toDate', "placeholder"=>"To Date"]) !!} 
                        </div> 
                        </div>
                        <div class="form-group noBottom-margin col-md-4 noBottom-margin">  
                            <a href="{{ route('admin.report.ordersIndex')}}" class="btn reset-btn noMob-leftmargin pull-right mn-w100">Reset </a>
                            <button type="submit" name="submit" vlaue='Filter' class='btn btn-primary noAll-margin pull-right marginRight-sm mn-w100'>Filter</button> 
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Orders Report </h1>
            <a href="{!! route('admin.report.orderIndexExport') !!}" class="btn btn-listing-heading pull-right noAll-margin" target="_" type="button">Export</a>
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
