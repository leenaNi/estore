@extends('Admin.layouts.default')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <div class="panel-body">
                    <h2 class="page-header">  Order Status History</h4>
                        <table class="table orderTable table-hover general-table">
                            <thead>
                                <tr class="noBorder">
                                    <th>
                                        Order Id : {{ $order->id }} <br/><br/>
                                        Order Creation Date :  {{date("d-M-Y H:i A",strtotime($order->created_at))}}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <th>Comment</th>
                                    <th>Customer Notified</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$orderStatusHistory->isEmpty())
                                @foreach($orderStatusHistory as $history)
                                <tr>
                                    <td> {{$history->getStatus->order_status}}</td>
                                    <td> {{$history->remark}}</td>
                                    <td> {{ ($history->notify == 1)?"Yes":"No" }}</td>
                                    <td>{{date("d-M-Y H:i A",strtotime($history->created_at))}}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr><td colspan="4">No Record Found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        <h2 class="page-header"> <i class="fa fa-flag"></i>  Flag History</h4>
                            <table class="table orderTable table-hover general-table">
                                <thead>
                                    <tr>
                                        <th>Flag Name</th>
                                        <th>Flag Comment</th>
                                        <th>Flag Description</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!$flags->isEmpty())
                                    @foreach($flags as $flag)
                                    <tr>
                                        <td> {{$flag->getFlag->flag}}</td>
                                        <td> {{$flag->remark}}</td>
                                        <td> {{$flag->getFlag->desc}}</td>
                                        <td>{{date("d-M-Y H:i A",strtotime($flag->created_at))}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td colspan="4">No Record Found.</td></tr>
                                    @endif
                                </tbody>
                            </table>
<!--                            <h2 class="page-header"> <i class="fa fa-shopping-cart"></i>  Cart History</h4>
                                <table class="table orderTable table-hover general-table">
                                    <thead><tr>
                                            <th>Cart Details</th>
                                            <th>Cod</th>
                                            <th>Shipping Amt</th>
                                            <th>Gifting Amt</th>
                                            <th>Coupon Amt</th>
                                            <th>Voucher Amt</th>
                                            <th>Referral Amt</th>
                                            <th>Reward Points Used</th>
                                            <th>Order Amt</th>
                                            <th>Pay Amt</th>
                                            <th>Modified Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <td>-->
                            <?php foreach ($order->products()->get() as $ordProd) { ?>
                                <!--                                            {{$ordProd->product}}-->
                            <?php } ?>
                            <!--                                    </td>
                                                                <td>{{$order->cod_charges}}</td>
                                                                <td>{{$order->shipping_amt}}</td>
                                                                <td>{{$order->gifting_charges}}</td>
                                                                <td>{{$order->coupon_amt_used}}</td>
                                                                <td>{{$order->voucher_amt_used}}</td>
                                                                <td>{{$order->referal_code_amt}}</td>
                                                                <td>{{$order->cashback_used}}</td>
                                                                <td>{{$order->order_amt}}</td>
                                                                <td>{{$order->pay_amt}}</td>
                                                                <td>{{date("d-M-Y H:i A",strtotime($order->updated_at))}}</td>
                                                                </tbody>
                                                            </table>-->

                            <h2 class="page-header"> <i class="fa fa-shopping-cart"></i>  Order History</h4>
                                <table class="table orderTable table-hover general-table">
                                    <thead><tr>
                                            <th>Cart Details</th>
                                            <th>Cod</th>
                                            <th>Shipping Amt</th>
                                            <th>Gifting Amt</th>
                                            <th>Coupon Amt</th>
                                            <th>Voucher Amt</th>
                                            <th>Referral Amt</th>
                                            <th>Reward Points Used</th>
                                            <th>Order Amt</th>
                                            <th>Pay Amt</th>
                                            <th>Modified Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!$orderHistory->isEmpty())
                                        @foreach($orderHistory as $ordProd)
                                        <tr>
                                            <td>
                                                <?php
                                                $cart = json_decode($ordProd->cart);
                                                foreach ($cart as $key => $value) {
                                                    echo $value->name . '(' . $value->qty . ') ' . $value->price . '</br>';
                                                }
                                                ?>
                                            </td>
                                            <td>{{ $ordProd->cod * Session::get('currency_val') }}</td>
                                            <td>{{ ($ordProd->shipping_amt * Session::get('currency_val')) }}</td>
                                            <td>{{ $ordProd->gifting_amt * Session::get('currency_val') }}</td>
                                            <td>{{ $ordProd->coupon_amt * Session::get('currency_val') }}</td>
                                            <td>{{ $ordProd->voucher_amt * Session::get('currency_val') }}</td>
                                            <td>{{ $ordProd->referral_amt * Session::get('currency_val') }}</td>
                                            <td>{{ $ordProd->cashback_used * Session::get('currency_val') }}</td>
                                            <td>{{ $ordProd->order_amt * Session::get('currency_val') }}</td>
                                            <td>{{ $ordProd->pay_amt * Session::get('currency_val') }}</td>
                                            <td>{{ date("d-M-Y H:i A",strtotime($ordProd->updated_at)) }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr><td colspan="11">No Record Found.</td></tr>
                                        @endif
                                    </tbody>
                                </table>
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