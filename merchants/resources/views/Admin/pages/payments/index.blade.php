<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
?>
@extends('Admin.layouts.default')
@section('mystyles')
<style type="text/css">.capitalizeText select {
        text-transform: capitalize;
    }
    select.form-control{ padding: 7px!important;}.fnt14{font-size: 14px;text-transform: capitalize !important;}</style>
@stop
@section('content')
<section class="content-header">
    <h1>
        Settlements
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Payments</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div  class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div  class="alert alert-success" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
                @if(!empty(Session::get('updatesuccess')))
                <div  class="alert alert-success" role="alert">
                    {{ Session::get('updatesuccess') }}
                </div>
                @endif
                <div class="box-header noBorder box-tools filter-box col-md-9">
                    <form action="{{ route('admin.payments.view') }}" method="get" >
                    <div class="form-group col-md-4">
                            <input type="text" name="custSearch" value="{{ !empty(Input::get('custSearch')) ? Input::get('custSearch') : '' }}" class="form-control input-sm pull-right fnt14" placeholder="Customer/Email/Contact">
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input-group date Nform_date" id="datepickerDemo">
                                <input placeholder="Created Date" type="text" id="" name="daterangepicker" value="{{ !empty(Input::get('daterangepicker')) ? Input::get('daterangepicker') : '' }}" class="form-control datefromto textInput">
                                <span class="input-group-addon">
                                    <i class=" ion ion-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="search-resetsubmit">
                                <input type="submit" name="submit" class=" btn btn-default noLeftMargin mn-w100" value="Search">
                                <a href="{{route('admin.payments.view')}}" class="btn reset-btn noLeftMargin mn-w100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-header col-md-3">
                    <a href="{{ route('admin.payments.newSettlement') }}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" >Add new settlement</a>
                </div>
                <!-- <div class="box-header col-md-3">
                    <form action="{!! route('admin.payments.export') !!}" target="_" method="post">
                        <button class="btn btn-default pull-right col-md-12 mobAddnewflagBTN"  type="submit">Export</button>
                    </form>
                </div> -->
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Order Id</th>
                                <th class="text-right">Payable Amount</th>
                                <th class="text-right">Paid Amount</th>
                                <th class="text-center mn-w100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($userPayments) > 0 )
                            @foreach($userPayments as $userPayment)
                            <tr>
                                <td>{{@$userPayment->name}}</td>
                                <td>{{@$userPayment->email}}</td>
                                <td>{{@$userPayment->telephone}}</td>
                                <td>{{date('d-M-Y H:i:s', strtotime($userPayment->created_at))}}</td>
                                <td>{{$userPayment->order_id}}</td>
                                <td class="text-right""><span class="currency-sym"></span>{{number_format(($userPayment->pay_amt  * Session::get('currency_val')), 2)}}</td>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($userPayment->amt_paid  * Session::get('currency_val')), 2)}}</td>
                                <td class="text-center mn-w100">
                                    <a class="view-payments" data-useremail="{{@$userPayment->email}}" data-username="{{@$userPayment->name}}" data-orderId="{{$userPayment->orderId}}" data-toggle="tooltip" title="View Details"><i class="fa fa-eye btn-plen btn"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($totalCreditAmount->total_credit * Session::get('currency_val')), 2)}}</td>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($totalPaid->total_paid * Session::get('currency_val')), 2)}}</td>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Outstanding</th>
                                <th colspan="1" class="text-right"><span class="currency-sym"></span>{{number_format(((@$totalCreditAmount->total_credit - @$totalPaid->total_paid) * Session::get('currency_val')), 2)}}</th>
                            </tr>
                            @else
                            <tr><td colspan=4 class="text-center"> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php
echo $userPayments->render();
?>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
</section>
<div class="modal fade" id="payments-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Payment details for order ID: <span class="payment-order-id"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label"><b>Pending Amount:</b> <span class="currency-sym"></span><span class="remaining-amt"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 payment-msg">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th class="text-right">Amount Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody class="payment-details"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
@stop
@section('myscripts')
<script>
$('.view-payments').click(function() {
    $('#payments-view').modal('show');
    var orderId = $(this).attr('data-orderId');
        console.log(orderId);
        $('span.payment-order-id').html(orderId);
        //Get order payments
        $('tbody.payment-details').html('');
        $.post("{{ route('admin.orders.getPayments') }}", {orderId: orderId}, function (res) {
            if(res.status) {
                $('tbody.payment-details').html(res.payments);
                $('.remaining-amt').text(res.remainingAmt);
                $('#payments-view').modal('show');
            }
        });
});
</script>
@stop
