@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css"> 
@stop

@section('content')
<section class="content-header">
    <h1>
        All Merchants 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Merchants</a></li>
        <li class="active">All Merchants</li>
    </ol>
</section>
<section class="main-content"> 
    <div class="notification-column">
        @if(!empty(Session::get('message')))
        <div class="alert alert-danger" role="alert">
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
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
            <a href="{!! route('admin.customers.export') !!}" class="btn btn-listing-heading pull-right noAll-margin" target="_" type="button">Export</a> 
        </div>
        <div class="filter-section">
            <div class="col-md-12 noAll-padding">
                <div class="filter-left-section">
                <form action="{{ route('admin.customers.view') }}" method="get" >
                    <div class="form-group col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'noun_user.svg'}}"></span>
                            <input type="text" name="custSearch" value="{{ !empty(Input::get('custSearch')) ? Input::get('custSearch') : '' }}" class="form-control form-control-right-border-radius" placeholder="Search for Name, Email or Mobile Number">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group date Nform_date" id="datepickerDemo">                            
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'calendar.svg'}}"></span>
                            <input placeholder="Created Date" type="text" id="" name="daterangepicker" value="{{ !empty(Input::get('daterangepicker')) ? Input::get('daterangepicker') : '' }}" class="form-control-no-border-radius datefromto textInput">
                            <span class="input-group-addon date"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'arrow_drop_down.png'}}" class="autoWidth"></span>
                        </div>
                    </div>

                    @if($setting->status ==1)
                    <div class="form-group col-md-4 capitalizeText">

                        {{ Form::select('loyalty', array_map('ucfirst', $loyalty), @Input::get('loyalty'), ['class' => 'form-control input sm']) }}
                    </div>
                    @endif  
                    <div class="form-group col-md-4 noBottom-margin">
                        {{ Form::select('status', ['' => 'Select Status','1' => 'Enabled', '0'=>'Disabled'], Input::get('status'), ['class' => 'form-control input sm']) }}
                    </div> 

                    <div class="form-group col-md-4 noBottom-margin">
                        <a  href="{{route('admin.customers.view')}}" class="btn reset-btn noMob-leftmargin pull-right mn-w100">Reset</a>
                        <input type="submit" name="submit" class="btn btn-primary noAll-margin pull-right marginRight-sm mn-w100" value="Filter"> 
                    </div>
                </form> 
                </div>
            </div>          
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> All Merchants 
                <?php
                if($customerCount > 0)
                {
                ?>
                <span class="listing-counter">{{$startIndex}}-{{$endIndex}} of {{$customerCount }}</span></h1>
                <?php
                }
                ?>
                
            <a href="{!! route('admin.customers.add') !!}" class="btn btn-listing-heading pull-right noAll-margin"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'plus.svg'}}"> Create</a>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr> 
                            <th class="text-left">Name</th> 
                            <th class="text-left">Email Id</th>
                            <th class="text-center">Mobile</th>
                            <th class="text-center">Total No. of Orders</th>
                            <th class="text-right">Total Order Amt</th>
                            <th class="text-right">Credit</th>
                            @if($setting->status ==1)
                            <th class="text-left">Loyalty Group</th>
                            <th class="text-right">Loyalty Point</th>
                            @endif
                            <th class="text-center">Status</th>
                            <th class="text-center mn-w100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($customers) >0 )
                        @foreach($customers as $customer)
                        <?php //dd($customer->orders) ?> 
                        <tr>  
                            <td class="text-left">{{$customer->firstname }} {{$customer->lastname }}</td>
                            <td class="text-left">{{ $customer->email }}</td>
                            <td class="text-center">{{ $customer->telephone }}</td>
                            <td class="text-right">{{ count($customer->orders) }}</td>
                            <td class="text-right">{{ $customer->total_order_amt }}</td>
                            <td class="text-right">
                                <a class="cursorPointer view-payments" data-toggle="tooltip" title="View payments" data-userId="{{$customer->id}}">
                                    <b>{{ number_format(($customer->credit_amt  * Session::get('currency_val')), 2) }}</b></a>
                            </td>
                            @if($setting->status ==1)
                            <?php 
                                $group=@$customer->userCashback->loyalty_group?@$customer->userCashback->loyalty_group:0;
                            ?>         
                            <td class="text-left">{{ isset($group)?ucfirst(strtolower(@$loyalty["$group"])):'' }}</td>
                            <td class="text-right"><span class="currency-sym"> </span> {{ number_format((@$customer->userCashback->cashback * Session::get('currency_val')), 2) }}</td>
                            @endif
                            <td class="text-center">@if($customer->status==1)
                                <span class="alertSuccess"  title="Enabled">Enabled</span>
                                @elseif($customer->status==0)
                                <span class="alertDanger" title="Disabled">Disabled</span>
                                @endif
                            </td>
                            <td class="text-center mn-w100">

                                <div class="actionCenter">
                                    <span><a class="btn-action-default" href="{!! route('admin.customers.edit',['id'=>$customer->id]) !!}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                                    <span class="dropdown">
                                        <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">  
                                            @if($customer->status==1)
                                            <li><a href="{!! route('admin.customers.changeStatus',['id'=>$customer->id]) !!}"  onclick="return confirm('Are you sure you want to disable this customer?')"><i class="fa fa-check"></i> Enabled</a></li>
                                            @elseif($customer->status==0)
                                            <li><a href="{!! route('admin.customers.changeStatus',['id'=>$customer->id]) !!}"  onclick="return confirm('Are you sure you want to enable this customer?')"><i class="fa fa-times"></i> Disabled</a></li>
                                            @endif
                                            <li><a href="{!! route('admin.orders.view',['search'=> $customer->firstname.' '.$customer->lastname]) !!}"><i class="fa fa-eye"></i> View Order</a></li>

                                            <li><a href="{!! route('admin.customers.delete',['id'=>$customer->id]) !!}"  onclick="return confirm('Are you sure you want to delete this customer?')"><i class="fa fa-trash"></i> Delete</a></li>
                                        </ul>
                                    </span>  
                                </div> 
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="10" class="text-center"> No Record Found.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
             <?php
                if (empty(Input::get('custSearch'))) {
                    echo $customers->render();
                }
                ?> 
            <form class="payment-form" method="post">
                <input type="hidden" name="user_id"/>
            </form>
        </div>
    </div>
</section>
<div class="clearfix"></div>

@stop

@section('myscripts')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
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

    $('.view-payments').click(function() {
        var customerId = $(this).attr('data-userId');
        $('input[name=user_id]').val(customerId);
        $('form.payment-form').attr('action', "{{route('admin.customers.payment.history')}}");
        $('form.payment-form').submit();
    });
    
});
</script>
@stop 