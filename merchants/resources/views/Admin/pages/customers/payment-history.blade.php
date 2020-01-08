@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<style type="text/css">.capitalizeText select {
        text-transform: capitalize;
    } 
    select.form-control{ padding: 7px!important;}.fnt14{font-size: 14px;text-transform: capitalize !important;}</style>
@stop

@section('content')
<section class="content-header">
    <h1>
        Customers Payment History
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
                            <div class="input-group date Nform_date" id="datepickerDemo">
                                <input placeholder="Created Date" type="text" id="" name="daterangepicker" value="{{ !empty(Input::get('daterangepicker')) ? Input::get('daterangepicker') : '' }}" class="form-control datefromto textInput">
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
                        <div class="form-group col-md-2">
                            <a  href="{{route('admin.customers.view')}}" class="form-control medium btn reset-btn" style="margin-left:0px">Reset</a>
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
                <div class="dividerhr"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Order Id</th>
                                <th>Payable Amount</th>
                                <th>Paid Amount</th>
                            </tr>
                        </thead>
                        <tbody>   
                            @if(count($userPayments) > 0 )
                            @foreach($userPayments as $userPayment)
                            <tr> 
                                <td>{{date('d-M-Y H:i:s', strtotime($userPayment->created_at))}}</td>
                                <td>{{$userPayment->order_id}}</td>
                                <td class=""><span class="currency-sym"></span>{{number_format(($userPayment->pay_amt  * Session::get('currency_val')), 2)}}</td>
                                <td><span class="currency-sym"></span>{{number_format(($userPayment->pay_amount  * Session::get('currency_val')), 2)}}</td>
                            </tr>
                            @endforeach
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
@stop

@section('myscripts')

<script src="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
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