@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Orders Report
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">  Orders Report </li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                  <div class="box-header box-tools filter-box col-md-9 col-sm-12 col-xs-12">              
                    <form method="get" action=" " id="searchForm">
                        <input type="hidden" name="attrSetCatalog">
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" value="{{ !empty(Input::get('order_number'))?Input::get('order_number'):'' }}" name="order_number" aria-controls="editable-sample" class="form-control medium" placeholder="Order Number">
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" value="{{ !empty(Input::get('customer_name'))?Input::get('customer_name'):'' }}" name="customer_name" aria-controls="editable-sample" class="form-control medium" placeholder="Customer Name">
                            </div>
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <input type="submit" name="submit" vlaue='Submit' class='form-control btn btn-primary noMob-leftmargin'>
                        </div>
                        <div class="from-group col-md-2 col-sm-3 col-xs-12">
                            <a href="{{ route('admin.report.ordersIndex')}}" class="form-control btn reset-btn noMob-leftmargin">Reset </a>
                        </div>
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {!! Form::text('datefrom',Input::get('datefrom'), ["class"=>'form-control fromDate', "placeholder"=>"From Date"]) !!}
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {!! Form::text('dateto',Input::get('dateto'), ["class"=>'form-control toDate', "placeholder"=>"To Date"]) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {!! Form::select('order_status',$o_status,Input::get('order_status'), ["class"=>'form-control filter_type', "placeholder"=>"Order Status"]) !!}
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <a href="{!! route('admin.report.orderIndexExport') !!}" class="btn btn-primary pull-left" target="_" type="button">Export</a>
                </div> 
                <div class="dividerhr"></div>
                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Order Status</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>COD Charges</th>
                                <th>Gifting Charges</th>
                                <th>Discount Amount</th>
                                <th>Shipping Amount</th>
                                <th>Referal Code Amount</th>
                                <th>Voucher Amount Used</th>
                                <th>Coupon Amount Used</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ date('d-M-Y',strtotime($order->order_date)) }}</td>
                                <td>{{ @$order->first_name }} {{ @$order->last_name }} </td>
                                <td>{{ $order->order_status }}</td>
                                <td>{{ $order->payment_method  }}</td>
                                <td>{{ $order->amount }}</td>
                                <td>{{ $order->cod_charges }}</td>
                                <td>{{ $order->gifting_charges }}</td>
                                <td>{{ $order->discount_amt }}</td>
                                <td>{{ $order->shipping_amt }}</td>
                                <td>{{ $order->referal_code_amt }}</td>
                                <td>{{ $order->voucher_amt_used }}</td>
                                <td>{{ $order->coupon_amt_used }}</td>
                                <td>{{ $order->total_amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $orders->links() }}

                    <!-- <div class="box-footer clearfix">


                        <?php
                        // echo $orders->appends(Input::except('page'))->render();
                        ?>

                        <?php //}
                        ?>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
</section>
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
