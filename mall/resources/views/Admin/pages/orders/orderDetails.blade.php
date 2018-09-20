@extends('Admin.layouts.default')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <div class="panel-body">
                    <h2 class="page-header"> <i class="fa fa-shopping-cart"></i>  Order Details</h4>
                        <table class="table orderTable table-hover general-table">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Sub Order Id</th>
                                    <th>Product </th>
                                    <th>Qty </th>
                                    <th>Pay Amount</th>
                                    <th>Order Status</th>
                                    <th>Sold By</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($orders) > 0)
                                @foreach($orders as $order)
                                <tr>
                                    <td> {{$order->order_id}}</td>
                                    <td> {{$order->id}}</td>
                                    <td> {{json_decode($order->product_details)->name}}</td>
                                    <td> {{$order->qty}}</td>
                                    <td><span class="currency-sym"></span> {{number_format(($order->pay_amt  * Session::get('currency_val')), 2)}}</td>
                                    <td> {{$order->orderstatus->order_status}}</td>
                                    <td> {{$order->getStore->store_name}}</td>
                                    <td>{{date("d-M-Y",strtotime($order->created_at))}}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr><td colspan="4">No Record Found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        <a href="{!! route('admin.orders.view') !!}"  class="pull-right"  ><button type="button" class="btn btn-success"><span> Back </span></button></a>
                </div>
            </section>
        </div>
    </div>
</div>
</section>
@stop
@section('myscripts')
<script>
    $(document).ready(function () {

    });
</script>
@stop