@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Orders Report
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">C</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
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
