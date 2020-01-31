<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
?>
@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/daterangepicker/daterangepicker-bs3.css' }}">
<style type="text/css">.capitalizeText select {
        text-transform: capitalize;
    }
    select.form-control{ padding: 7px!important;}.fnt14{font-size: 14px;text-transform: capitalize !important;}</style>
@stop
@section('content')
<section class="content-header">
    <h1>
        Ledger
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
                    
                        <div class="form-group col-md-6">
                        <div class="input-group date Nform_date" id="datepickerDemo">
                                <input placeholder="Anniversary Date" type="text" id="" name="anniversary" value="{{ !empty(Input::get('anniversary')) ? Input::get('anniversary') : '' }}" class="form-control datefromto textInput">

                                <span class="input-group-addon">
                                    <i class=" ion ion-calendar"></i>
                                </span>
                                </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-2">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="Search" style="margin-left:0px">
                        </div>
                        
                    </form>
                </div>
              
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
                                <th class="text-right">Balance Amount</th>
                               
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
                                <!-- <td class="text-right"><span class="currency-sym"></span>{{number_format(($userPayment->amt_paid  * Session::get('currency_val')), 2)}}</td> -->
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($userPayment->pay_amount  * Session::get('currency_val')), 2)}}</td>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format((($userPayment->pay_amt-$userPayment->pay_amount)  * Session::get('currency_val')), 2)}}</td>
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
                            <tr><td colspan=4> No Record Found.</td></tr>
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
<script src="{{  Config('constants.adminPlugins').'/daterangepicker/daterangepicker.js' }}"></script>
<script>
$(function () {

var start = moment().subtract(29, 'days');
var end = moment();

// function cb(start, end) {
//      $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
// }

$('.datefromto, .datefromtodob').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, function () {
});

//cb(start, end);
$('.datefromto, .datefromtodob').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
});

$('.datefromto, .datefromtodob').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
});
});
</script>
@stop
