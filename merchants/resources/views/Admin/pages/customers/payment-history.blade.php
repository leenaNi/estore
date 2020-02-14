@extends('Admin.layouts.default')
@section('mystyles')
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

<section class="main-content">
    <div class="notification-column">
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
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-9 noAll-padding displayFlex">
                <div class="filter-left-section">
                    <form action="{{ route('admin.customers.payment.history') }}" method="post" >
                        <div class="form-group col-md-4 noAll-margin">
                            <div class="input-group">    
                            {!! Form::text('datefrom',Input::get('datefrom'), ["class"=>'form-control fromDate', "placeholder"=>"From Date"]) !!}
                             <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                        <div class="form-group col-md-4 noAll-margin">
                            <div class="input-group">    
                            {!! Form::text('dateto',Input::get('dateto'), ["class"=>'form-control toDate', "placeholder"=>"To Date"]) !!}
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            </div>
                        </div> 
                        <div class="button-filter-search col-md-2 noAll-margin">
                            <button type="submit" name="search" class="btn sbtn btn-primary fullWidth noAll-margin" value="Search"> Search</button>
                        </div>
                        <div class="btn-group button-filter col-md-2 noAll-margin">
                            <a href="{{route('admin.products.view')}}"><button type="button" class="btn sbtn btn-block reset-btn fullWidth noAll-margin" value="reset">Reset</button></a>
                        </div> 
                    </form>
                </div>
            </div> 
            <div class="col-md-3 noAll-padding displayFlex">
                <div class="filter-right-section"> 
                    <form action="{!! route('admin.customers.export.payment') !!}" target="_" method="post">
                    <input type="hidden" name="user_id" value="{{$user->id}}" />
                    <button class="btn btn-default pull-right col-md-12 mobAddnewflagBTN"  type="submit">Export</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>  
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>{{$user->firstname}} {{($user->lastname=='')? "'s":""}} {{$user->lastname}}{{($user->lastname!='')? "'s":""}} Ledger</h1>
        </div>
        <div class="listing-section"> 
            <div class="table-responsive overflowVisible no-padding">
                <table class="table table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr style="background: #f1f1f1;">
                            <th class="text-center">
                                <label>Payable Amount : </label>
                                <label><span class="currency-sym"></span> {{number_format(($totalCreditAmount->total_credit * Session::get('currency_val')), 2)}}</label>
                            </th>
                            <th class="text-center">
                                <label>Paid Amount : </label>
                                <label><span class="currency-sym"></span> {{number_format(($totalPaid->total_paid * Session::get('currency_val')), 2)}}</label>
                            </th>
                            <th class="text-center" colspan="2">
                                <label>Outstanding : </label>
                                <label><span class="currency-sym"></span> 
                                {{number_format((($totalCreditAmount->total_credit - $totalPaid->total_paid) * Session::get('currency_val')), 2)}}
                                </label>
                            </th> 
                        </tr>
                        <tr>
                            <th class="text-center">Order Id</th>
                            <th class="text-right">Date</th>
                            <th class="text-right">Payable Amount</th>
                            <th class="text-right">Paid Amount</th>
                        </tr>
                    </thead>
                    <tbody>   
                        @if(count($userPayments) > 0 )
                        @foreach($userPayments as $userPayment)
                        <tr> 
                            <td class="text-center">{{$userPayment->order_id}}</td>
                            <td class="text-right">{{date('d-M-Y', strtotime($userPayment->created_at))}}</td>
                            <td class="text-right"><span class="currency-sym"></span>{{number_format(($userPayment->pay_amt  * Session::get('currency_val')), 2)}}</td>
                            <td class="text-right"><span class="currency-sym"></span>{{number_format(($userPayment->pay_amount  * Session::get('currency_val')), 2)}}</td>
                        </tr>
                        @endforeach               
                        @else
                        <tr><td colspan="4" class="text-center"> No Record Found.</td></tr>
                        @endif                        
                        <tr>
                            <th class="text-right"></th>
                            <th class="text-right">Total</th>
                            <th class="text-right"><span class="currency-sym"></span>{{number_format(($totalCreditAmount->total_credit * Session::get('currency_val')), 2)}}</th>
                            <th class="text-right"><span class="currency-sym"></span>{{number_format(($totalPaid->total_paid * Session::get('currency_val')), 2)}}</th>
                        </tr>
                        <tr>
                            <th class="text-right"></th>
                            <th class="text-right">Outstanding</th>
                            <th class="text-right"><span class="currency-sym"></span>{{number_format((($totalCreditAmount->total_credit - $totalPaid->total_paid) * Session::get('currency_val')), 2)}}</th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
                echo $userPayments->render();
            ?> 
        </div>
    </div>

</section>         

<div class="clearfix"></div>

@stop

@section('myscripts')

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
</script>
@stop 