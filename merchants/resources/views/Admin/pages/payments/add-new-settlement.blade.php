@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Add New Settlement
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="">Payments</li>
        <li class="active">Add New Settlement</li>
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
                    <form action="{{ route('admin.payments.newSettlement') }}" method="get" >
                        <div class="form-group col-md-4">
                            <input type="text" name="custSearch" value="{{ !empty(Input::get('custSearch')) ? Input::get('custSearch') : '' }}" class="form-control input-sm pull-right fnt14" placeholder="Customer/Email/Contact">
                        </div>
                        <!-- <div class="form-group col-md-4">
                            <div class="input-group date Nform_date" id="datepickerDemo">
                                <input placeholder="Created Date" type="text" id="" name="daterangepicker" value="{{ !empty(Input::get('daterangepicker')) ? Input::get('daterangepicker') : '' }}" class="form-control datefromto textInput">
                                <span class="input-group-addon">
                                    <i class=" ion ion-calendar"></i>
                                </span>
                            </div>
                        </div> -->
                        <!-- <div class="clearfix"></div> -->

                        <a href="{{route('admin.payments.newSettlement')}}">
                        <button type="button" class="btn reset-btn noMob-leftmargin pull-right" value="reset">Reset
                        </button>
                        </a>
                        <button type="submit" name="search" class="btn btn-primary noAll-margin pull-right marginRight-lg" value="Search"> Search
                        </button>
                    </form>
                </div>
                <div class="box-header col-md-3">
                    <!-- <a href="{!! route('admin.payments.export') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" >Add new settlement</a> -->
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <form method="post" id="settlement-form" action="{{ route('admin.payments.settlePayments') }}">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Order Id</th>
                                <th class="text-right">Actual Payable Amount</th>
                                <th class="text-right">Paid Amount</th>
                                <th class="text-right">Pending Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($userPayments) > 0 )
                            @foreach($userPayments as $userPayment)
                            <tr>
                                <td>{{date('d-M-Y H:i:s', strtotime($userPayment->created_at))}}</td>
                                <td>{{$userPayment->order_id}}</td>
                                <td class="text-right""><span class="currency-sym"></span>{{number_format(($userPayment->pay_amt  * Session::get('currency_val')), 2)}}</td>
                                <td class="text-right">
                                    <span class="currency-sym"></span>{{number_format(($userPayment->amt_paid  * Session::get('currency_val')), 2)}}
                                </td>
                                <td class="text-right">
                                    <span class="currency-sym"></span>{{number_format((($userPayment->pay_amt-$userPayment->amt_paid)  * Session::get('currency_val')), 2)}}
                                </td>
                                <td>
                                    <input name="order_id[]" type="hidden" value="{{$userPayment->order_id}}" />
                                    <input name="pay_amt[]" data-orderAmt="{{$userPayment->pay_amt}}" value="" maxlength="{{$userPayment->pay_amt-$userPayment->pay_amount}}" />
                                </td>
                            </tr>
                            @endforeach
                            <!-- <tr>
                                <th colspan="2" class="text-right">Total</th>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($totalCreditAmount->total_credit * Session::get('currency_val')), 2)}}</td>
                                <td class="text-right"><span class="currency-sym"></span>{{number_format(($totalPaid->total_paid * Session::get('currency_val')), 2)}}</td>
                            </tr> -->
                            <!-- <tr>
                                <th colspan="3" class="text-right">Outstanding</th>
                                <th colspan="1" class="text-right"><span class="currency-sym"></span>{{number_format((($totalCreditAmount->total_credit - $totalPaid->total_paid) * Session::get('currency_val')), 2)}}</th>
                            </tr> -->
                            @else
                            <tr><td colspan=4> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php
if (Input::get('custSearch') && !empty(Input::get('custSearch'))) {
    echo $userPayments->render();
}
?>
                </div>
                <div class="row">
                    <div class="col-md-3 pull-right">
                    @if(count($userPayments) > 0 )
                        <div class="form-group ">
                            <button type="button" class="btn btn-primary settle-payment" >Settle Payments</button>
                        </div>
                    @endif
                    </div>
                </div>
                </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
</section>
@stop

@section('myscripts')
<script>
    var cnt = 0;
    $('.settle-payment').click(function() {
        console.log(checkInputValues(), $('input[name=pay_amt]').length);
        $('#settlement-form').submit();
        if($('input[name=pay_amt]').length == checkInputValues()){

        }
    });
    $('input[name="pay_amt[]"]').change(function() {
        console.log($(this).val());
        var actualPayAmt = parseInt($(this).attr('data-orderAmt'));
        var curAmt = parseInt($(this).val());
        console.log(actualPayAmt, curAmt);
        if(actualPayAmt < curAmt) {
            alert('Amount can not be greater than total payable amount!');
            $(this).val('');
        }
    });
    function checkInputValues() {
        var inputCnt = 0
        $('input[name=pay_amt]').each(function(){
            if($(this).val() || $(this).val() == '') inputCnt++;
        });
        return inputCnt;
    }
</script>
@stop