@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<style type="text/css">.capitalizeText select {
        text-transform: capitalize;
    } 
    select.form-control{ padding: 7px!important;}.fnt14{font-size: 14px;text-transform: capitalize !important;}
.displaylabel{
    font-weight: bold;
}
</style>
@stop

@section('content')
<section class="content-header">
    <h1>
        {{$user->firstname}} {{($user->lastname=='')? "'s":""}} {{$user->lastname}}{{($user->lastname!='')? "'s":""}} Ledger
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Customers</li>
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
                    <form action="{{ route('admin.customers.view') }}" method="get" >
                        <div class="form-group col-md-4">
                        {!! Form::text('datefrom',Input::get('datefrom'), ["class"=>'form-control fromDate', "placeholder"=>"From Date"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('dateto',Input::get('dateto'), ["class"=>'form-control toDate', "placeholder"=>"To Date"]) !!}
                    </div>
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-6 no-padding">
                            <button type="submit" name="search" class="btn sbtn btn-primary form-control" style="margin-left: 0px;" value="Search"> Search</button>
                        </div>
                        <div class="btn-group button-filter col-md-5 noBottomMargin no-padding">
                            <a href="{{route('admin.products.view')}}"><button type="button" class="btn sbtn btn-block reset-btn" value="reset">Reset</button></a>
                        </div>
                    </div>
                    </form>

                </div>
                <div class="box-header col-md-3">
                    <form action="{!! route('admin.customers.export.payment') !!}" target="_" method="post">
                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                    <button class="btn btn-default pull-right col-md-12 mobAddnewflagBTN"  type="submit">Export</button>
                    </form>
                </div> 
                <div class="clearfix"></div>
                <div class="col-md-4">
                        <label>Payable Amount : </label>
                        <label><span class="currency-sym"></span> {{number_format(($totalCreditAmount->total_credit * Session::get('currency_val')), 2)}}</label>
                </div>
                <div class="col-md-4">
                        <label>Paid Amount : </label>
                        <label><span class="currency-sym"></span> {{number_format(($totalPaid->total_paid * Session::get('currency_val')), 2)}}</label>
                </div>
                <div class="col-md-4">
                        <label>Outstanding : </label>
                        <label><span class="currency-sym"></span> 
                            {{number_format((($totalCreditAmount->total_credit - $totalPaid->total_paid) * Session::get('currency_val')), 2)}}
                        </label>
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Order Id</th>
                                <th class="text-right">Payable Amount</th>
                                <th class="text-right">Paid Amount</th>
                            </tr>
                        </thead>
                        <tbody>   
                            @if(count($userPayments) > 0 )
                            @foreach($userPayments as $userPayment)
                            <tr> 
                                <td>{{date('d-M-Y', strtotime($userPayment->created_at))}}</td>
                                <td>{{$userPayment->order_id}}</td>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($userPayment->pay_amt  * Session::get('currency_val')), 2)}}</td>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($userPayment->pay_amount  * Session::get('currency_val')), 2)}}</td>
                            </tr>
                            @endforeach                            
                            <!-- <tr>
                                <th colspan="2" class="text-right">Total</th>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($totalCreditAmount->total_credit * Session::get('currency_val')), 2)}}</td>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($totalPaid->total_paid * Session::get('currency_val')), 2)}}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Outstanding</th>
                                <th colspan="1" class="text-right"><span class="currency-sym"></span>{{number_format((($totalCreditAmount->total_credit - $totalPaid->total_paid) * Session::get('currency_val')), 2)}}</th>
                            </tr> -->
                            @else
                            <tr><td colspan=4> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><br>
                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr>
                                <th style="width: 25%;"></th>
                                <th style="width: 25%;" class="text-right">Total</th>
                                <th style="width: 25%;" class="text-right"><span class="currency-sym"></span>{{number_format(($totalCreditAmount->total_credit * Session::get('currency_val')), 2)}}</th>
                                <th style="width: 25%;" class="text-right"><span class="currency-sym"></span>{{number_format(($totalPaid->total_paid * Session::get('currency_val')), 2)}}</th>
                            </tr>
                            <tr>
                                <th style="width: 25%;"></th>
                                <th style="width: 25%;" class="text-right">Outstanding</th>
                                <th style="width: 25%;" class="text-right"><span class="currency-sym"></span>{{number_format((($totalCreditAmount->total_credit - $totalPaid->total_paid) * Session::get('currency_val')), 2)}}</th>
                                <th style="width: 25%;"></th>
                            </tr>
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
@stop

@section('myscripts')

<script src="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
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
$(function () {
    // var start = moment().subtract(29, 'days');
    // var end = moment();
    // function cb(start, end) {
    //      $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    // }
    // $('.datefromto').daterangepicker({
    //     startDate: start,
    //     endDate: end,
    //     ranges: {
    //         'Today': [moment(), moment()],
    //         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //         'This Month': [moment().startOf('month'), moment().endOf('month')],
    //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //     }
    // }, function () {
    // });
    // //cb(start, end);
    // $('.datefromto').on('apply.daterangepicker', function (ev, picker) {
    //     $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
    // });

    // $('.datefromto').on('cancel.daterangepicker', function (ev, picker) {
    //     $(this).val('');
    // });
});
</scripts>
@stop 