@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Coupon
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.coupons.view') }}"><i class="fa fa-coffee"></i> Coupon</a></li>
        <li class="active">Add/Edit {{Session::get('id')}}</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            @if(in_array(Route::currentRouteName(),['admin.coupons.edit','admin.coupons.history']))
            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.edit']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.edit', ['id' => Input::get('id')]) !!}" aria-expanded="false">Coupons</a>
            </li>
            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.history']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.history', ['id' => Input::get('id')]) !!}"  aria-expanded="false">History</a>
            </li>
            @else
            <li class="{{ Route::currentRouteName()=='admin.coupons.add' ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.add') !!}" aria-expanded="false">Category</a>
            </li>
            @endif
        </ul>
        <div  class="tab-content" >
            @if(isset($orders))
            <div class="tab-pane active" id="coupon-history">
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>@sortablelink ('id', 'Id')</th>
                                <th>Customer Name</th>
                                <th>Email ID</th>
                                <th>Contact No</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Payment Method</th>
                                <th>@sortablelink ('pay_amt', 'Order Amt')</th>
                                <th>Order Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id }}</td>
                                <td>{{ @$order->users->firstname }} {{ @$order->users->lastname }} </td>
                                <td>{{ @$order->users->email }}  </td>
                                <td>{{ @$order->users->telephone }}</td>
                                <td>{{ @$order->orderstatus['order_status']  }}</td>
                                <td>{{ @$order->paymentstatus['payment_status'] }}</td>
                                <td>{{ @$order->paymentmethod['name'] }}</td>
                                <td><span class="currency-sym"></span> {{ @$order->pay_amt * Session::get('currency_val') }}</td>
                                <td>{{ date('d M y h:i:s a',strtotime($order->created_at)) }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="box-footer clearfix">
                        <?php
                        echo $orders->appends(Input::except('page'))->render();
                        ?>
                        <div class="pull-right" style="margin-top: 15px;">
                            <a class="btn btn-primary" href="{!! route('admin.coupons.view') !!}">Back to all coupons</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section> 
@stop 

@section('myscripts')

@stop