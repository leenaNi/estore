@extends('Frontend.layouts.default')

@section('content')

<div class="container">

    <h3><span>Order Details</span></h3>









    <?php $adddata = App\Models\Address::find(Session::get('addressid')); ?>



    <p class="form-row form-row-first validate-required" id="">
        <label class="" style="width: 103px;">Name </label>
        <label class="">: {{ ucwords($adddata->firstname." ".$adddata->lastname) }} </label>
    </p>


    <div class="clearfix"></div>
    <p class="form-row form-row-first validate-required" id="">
        <label class="" style="width: 103px;">Address Line 1 </label>
        <label class="">: {{ $adddata->address1 }} </label>
    </p>

    @if(!empty($adddata->address2))
    <div class="clearfix"></div>
    <p class="form-row form-row-first validate-required" id="">
        <label class="" style="width: 103px;">Address Line 2 </label>
        <label class="">: {{ $adddata->address2 }} </label>
    </p>

    @endif
    <div class="clearfix"></div>
    <p class="form-row form-row-first validate-required" id="">
        <label class="" style="width: 103px;">City </label>
        <label class="">: {{ $adddata->city." - ".$adddata->postcode }} </label>
    </p>
    <div class="clearfix"></div>
    <p class="form-row form-row-first validate-required" id="">
        <label class="" style="width: 103px;">State </label>
        <label class="">: {{ App\Models\Zone::find($adddata->zone_id)->name}} </label>
    </p>

    <div class="clearfix"></div>
    <p class="form-row form-row-first validate-required" id="">
        <label class="" style="width: 103px;">Country </label>
        <label class="">: {{App\Models\Country::find($adddata->country_id)->name }}</label>
    </p>










    <form name="checkout" method="post" class="paymentForm" action="{{ route('order_cash_on_delivery') }}">

        <ul class="">



            <li class="" style="padding-top:20px;">
                <input  name="payment_method" value="cod" id="cod" checked type="radio" class="paymethod" >

                <label for="payment_method_cheque" >Cash on Delivery</label>

            </li>
        </ul>
        <div class="clear"></div>

        <div class="form-row place-order">
            <input class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order" type="submit">
        </div>
        <div class="clear"></div>
    </form>




</div>


@stop

@section("myscripts")

@stop