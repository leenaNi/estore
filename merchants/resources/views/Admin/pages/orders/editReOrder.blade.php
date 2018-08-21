@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Orders
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Orders</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    {!! Form::model($order, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}

    <div class="pull-right"> {!! Form::button('Cancel Order',["class" => "btn btn-primary"]) !!}  {!! Form::submit('Place Order',["class" => "btn btn-primary"]) !!}     </div>
    <br>{{ Form::hidden('user_id',$order->user_id) }} 
    {{ Form::hidden('old_pay_amt',$order->pay_amt) }} 
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class=""><a href="#order-detail" data-toggle="tab" aria-expanded="true">Order Details</a></li>
            <li class=""><a href="#customer-detail" data-toggle="tab" aria-expanded="true">Customer Details</a></li>
            <li class="active"><a href="#product-detail" data-toggle="tab" aria-expanded="true">Product Details</a></li>
        </ul>
        <div  class="tab-content" >
            <div class="tab-pane " id="order-detail">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
                </div>


                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('payment_method', 'Payment Method',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('payment_method', $payment_methods,null, ["class"=>'form-control' ,"placeholder"=>'Select Payment Method', "required","readonly"]) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('payment_status', 'Payment Status',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('payment_status',$payment_status ,null, ["class"=>'form-control' ,"placeholder"=>'Select Payment Status', "required","readonly"]) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('order_status', 'Order Status',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('order_status',$order_status ,null, ["class"=>'form-control' ,"placeholder"=>'Select Payment Status', "required","readonly"]) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('amount', 'Order Amount',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('order_amt',null, ["class"=>'form-control priceConvertTextBox subTotalm',"placeholder"=>'Order Amount', "required"]) !!}
                    </div> 
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('payamount', 'Customer Payable Amount',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('pay_amt',null, ["class"=>'form-control priceConvertTextBox grandTotalm' ,"placeholder"=>'Customer Payable Amount', "required"]) !!}
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('gifting_charges', 'Gifting Charges',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('gifting_charges',null, ["class"=>'form-control priceConvertTextBox' ,"placeholder"=>'Gifting Charges', "required"]) !!}
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('cod charges', 'COD Charges',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('cod_charges',null, ["class"=>'form-control priceConvertTextBox' ,"placeholder"=>'COD Charges', "required"]) !!}
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('description', 'Description',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('description',null, ["class"=>'form-control' ,"placeholder"=>'Description']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('comment', 'Order Comment',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('order_comment',null, ["class"=>'form-control' ,"placeholder"=>'Order Comment']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('shipping_amt', 'Shipping Amount',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('shipping_amt',null, ["class"=>'form-control priceConvertTextBox' ,"placeholder"=>'Shipping Amount', "required"]) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('shiplabel_tracking_id', 'Tracking Id',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('shiplabel_tracking_id',null, ["class"=>'form-control' ,"placeholder"=>'Tracking Id']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('voucher_amt_used', 'Voucher Amount Used',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('voucher_amt_used',null, ["class"=>'form-control priceConvertTextBox' ,"placeholder"=>'Voucher Amount Used']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('coupon_amt_used', 'Coupon Amount Used',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('coupon_amt_used',null, ["class"=>'form-control priceConvertTextBox' ,"placeholder"=>'Coupon Amount Used']) !!}
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('referal_code_amt', 'Referral Amount Used',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('referal_code_amt',null, ["class"=>'form-control priceConvertTextBox' ,"placeholder"=>'Referral Amount Used']) !!}
                    </div>
                </div>
                {!! Form::hidden('id',null) !!}
            </div>
            <div class="tab-pane" id="customer-detail">
                <div class="row">
                    <div class="col-md-4">
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            {!! Form::label('first_name', 'First Name',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('first_name',null, ["class"=>'form-control readonly' ,"placeholder"=>'First Name','id'=>'first_name']) !!}
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            {!! Form::label('last_name', 'Last Name',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('last_name',null, ["class"=>'form-control readonly' ,"placeholder"=>'Last Name','id'=>'last_name']) !!}
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            {!! Form::label('address1', 'Address 1',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('address1',null, ["class"=>'form-control readonly' ,"placeholder"=>'Address 1','id'=>'address1']) !!}
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            {!! Form::label('address2', 'Address 2',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('address2',null, ["class"=>'form-control readonly' ,"placeholder"=>'Address 2','id'=>'address2']) !!}
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <!--                        <div class="form-group">
                                                    {!! Form::label('address3', 'Address 3',['class'=>'col-sm-2 control-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('address3',null, ["class"=>'form-control readonly' ,"placeholder"=>'Address 3','id'=>'address3']) !!}
                                                    </div>
                                                </div>-->
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            {!! Form::label('phone_no', 'Phone Number',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('phone_no',null, ["class"=>'form-control readonly' ,"placeholder"=>'Mobile Number','id'=>'phone_no']) !!}
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            {!! Form::label('city', 'City',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('city',null, ["class"=>'form-control readonly' ,"placeholder"=>'City','id'=>'city']) !!}
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            {!! Form::label('country_id', 'Country',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('country_id', $countries,null, ["class"=>'form-control readonly' ,"placeholder"=>'Select Country','id'=>'country_id']) !!}
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            {!! Form::label('zone_id', 'Zone',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('zone_id', $zones, null, ["class"=>'form-control readonly' ,"placeholder"=>'Select Zone','id'=>'zone_id']) !!}
                            </div>
                        </div> 
                        <div class="form-group">
                            {!! Form::label('postal_code', 'Postal Code',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::number('postal_code',null, ["class"=>'form-control readonly' ,"placeholder"=>'Pin Code','id'=>'postal_code']) !!}
                            </div>
                        </div>
                        {!! Form::hidden('id',null) !!}

                    </div>
                    <div class="col-md-8">
                        @foreach($address as $add)
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h4>
                                            <input type="radio" class="addressRadio" name="addressRadio" value="{{ $add->id }}"/> {{ $add->firstname }} {{ $add->lastname }}</h4>
                                        <input type="hidden" value="{{ $add->firstname }}" id="first_name{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->lastname }}" id="last_name{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->address1 }}" id="address1{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->address2 }}" id="address2{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->address3 }}" id="address3{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->city }}" id="city{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->postcode }}" id="postcode{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->country_id }}" id="country_id{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->zone_id }}" id="zone_id{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->postcode }}" id="postcode{{ $add->id }}" />
                                        <input type="hidden" value="{{ $add->phone_no }} " id="phone_no{{ $add->id }}" />
                                        <small>
                                            @if(!empty($add->address1))
                                            {{ $add->address1 }}
                                            <br>
                                            @endif
                                            @if(!empty($add->address2))
                                            {{ $add->address2 }}
                                            <br>
                                            @endif
                                            @if(!empty($add->address3))
                                            {{ $add->address3 }}
                                            <br>
                                            @endif
                                            {{ $add->city }}
                                            <br>
                                            {{ $add->zone->name }}, {{ $add->country->name }} - {{ $add->postcode }} <i class="glyphicon glyphicon-map-marker">
                                            </i></small>
                                        <p>
                                            <i class="glyphicon glyphicon-earphone"></i> {{ $add->phone_no }} 
                                            <!-- Split button -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h4>
                                            <button id='addnewAdd'>+ Add New</button>
                                        </h4>

                                        <!-- Split button -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane active" id="product-detail">

                {{ Form::hidden('id') }}
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <br />
                    <div class="restable">
                        <table class="table rttable table-hover general-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="append_prod">
                                @foreach($products as $prd)
                                {{ Form::hidden('old_product['.$prd->pivot->sub_prod_id.'][qty]',$prd->pivot->qty) }}
                                {{ Form::hidden('old_product['.$prd->pivot->sub_prod_id.'][pid]',$prd->id) }}
                                {{ Form::hidden('old_product['.$prd->pivot->sub_prod_id.'][sub]',$prd->pivot->sub_prod_id) }}
                                {{ Form::hidden('old_product['.$prd->pivot->sub_prod_id.'][prod_type]',$prd->prod_type) }}
                                @endforeach                            
                                @foreach($products as $prd)

                                <tr id="main{{$prd->pivot->prod_id }}"> 
                                    <td class="prod_name">{{ $prd->product }}
                                        <br/>
                                        <?php
//                                echo "<pre>";
//                                print_r($prd);
//                                echo "</pre>";
                                        ?>
                                    </td>  
                                    <td>
                                        {{ Form::number('edited_product['.$prd->pivot->sub_prod_id.'][qty]',$prd->pivot->qty, ["class"=>"orderQty".$prd->pivot->id." quantityUpdateMain","data-pid" => $prd->pivot->prod_id,"data-type" => '1']) }}
                                    </td>
                                    {{ Form::hidden('edited_product['.$prd->pivot->sub_prod_id.'][old_qty]',$prd->pivot->qty) }}
                                    {{ Form::hidden('edited_product['.$prd->pivot->sub_prod_id.'][pid]',$prd->id) }}
                                    {{ Form::hidden('edited_product['.$prd->pivot->sub_prod_id.'][sub]',$prd->pivot->sub_prod_id) }}
                                    {{ Form::hidden('edited_product['.$prd->pivot->sub_prod_id.'][prod_type]',$prd->prod_type) }}
                                    {{ Form::hidden('edited_product['.$prd->pivot->sub_prod_id.'][prc]',$prd->selling_price, ["class"=>"prodPrice"]) }}
                                    <td><i class="fa fa-rupee"></i>{{ @$prd->pivot->price }}</td>
                                    <td><i class="fa fa-rupee"></i><span class="totalPrice totalPrice{{$prd->pivot->prod_id }}">{{ @$prd->pivot->price }}</span></td>
                                    <td>
                                        <a href="#" class="remove" data-id="{{$prd->pivot->prod_id }}">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                    </td>  
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                        <table class="table rttable table-hover general-table">
                            <tbody>
                                <tr>                                 
                                    <td colspan="8">
                                        <button id='addprod' class = "btn btn-default">+ Add New Product</button>

                                        <span class="form-inline" id="toggleshow" style="display: none;">
                                            <div class="form-group">
                                                <?php $parent = array_unique(array_column($product_all, 'parent_prod_id')); ?>
                                                <select class="form-control" id='select_product' name="select_product">
                                                    <option value='00'>Please select</option>
                                                    @foreach($product_all as $pa)
                                                    @if(!in_array($pa['id'],$parent))
                                                    <option value='{{ $pa['id'] }}'>{{ $pa['product'] }}</option>
                                                    @endif
                                                    @endforeach 
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control quantityUpdate" data-pid="" data-type="0" min="1" placeholder="Quantity" value="1" id="tmp_qnty">
                                                <input type="hidden" id="tmp_id">
                                                <input type="hidden" id="tmp_prodType">
                                                <input type="hidden" id="tmp_parent_id">
                                                <input type="hidden" id="tmp_rowid">
                                            </div> 
                                            <div class="form-group">
                                                <input type="text" class="form-control priceConvertTextBox" readonly placeholder="Price" value="" id="tmp_price">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control priceConvertTextBox" readonly placeholder="Total Price" value="" id="tmp_total_price">
                                            </div>
                                            <br><br>
                                            <button id='addNewProd' class = "btn btn-success" >+ Add</button><button id='closeAddNewProd' class = "btn btn-default">Close</button>
                                        </span>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right">Subtotal</td>
                            <input type="hidden" class="subTotal_real" value="{{ number_format(($order->order_amt * Session::get('currency_val')),2) }}" />
                            <td><i class="fa fa-rupee"></i><span class="subTotal">{{ number_format(($order->order_amt * Session::get('currency_val')),2) }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">Coupon {{  $order->coupon_used != 0 ? "(".$coupon->coupon_code.")" : ""  }}</td>
                                <td><i class="fa fa-rupee"></i><span class="couponAmt">{{ number_format(($order->coupon_amt_used * Session::get('currency_val')),2) }}</span></td>
                            </tr>
                            @if(!empty($order->referal_code_amt ))
                            <tr>
                                <td colspan="4" align="right">Referal Discount</td>
                                <td><i class="fa fa-rupee"></i><span class="discountAmt">{{ number_format(($order->referal_code_amt * Session::get('currency_val')),2)  }}</span></td>
                            </tr>
                            @endif
                            @if(!empty($order->cashback_used))
                            <tr>
                                <td colspan="4" align="right">Used Reward Points</td>
                                <td><i class="fa fa-rupee"></i><span class="cashbackAmt">{{ number_format(($order->cashback_used * Session::get('currency_val')),2) }}</span></td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4" align="right">Shipping Charges</td>
                                <td><i class="fa fa-rupee"></i><span class="shippingAmt">{{ number_format(($order->shipping_amt * Session::get('currency_val')),2) }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">COD Charges</td>
                                <td><i class="fa fa-rupee"></i><span class="shippingAmt">{{ number_format(($order->cod_cahrges * Session::get('currency_val')),2) }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">Order Amount</td>
                            <input type="hidden" id="pay_amt_h" name="pay_amt_h"/>
                            <input type="hidden" id="order_amt_h" name="order_amt_h"/>
                            <input type="hidden" class="grandTotal_real"  value="{{ number_format(($order->pay_amt * Session::get('currency_val')),2) }}" />
                            <input type="hidden" class="grandTotal_extra" value="{{ number_format(($order->pay_amt * Session::get('currency_val')),2) - number_format(($order->order_amt * Session::get('currency_val')),2) }}" />
                            <td><i class="fa fa-rupee"></i><span class="grandTotal">{{ number_format(($order->pay_amt * Session::get('currency_val')),2) }}</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ Form::close() }}



            </div>
        </div>
    </div>
</section> 
<div id="loader" class=""></div>
@stop 

@section('myscripts')
<script>

    empty_tmp_field();
    $("#addNewProd").click(function () {
        if ($("#select_product").val() == '00') {
            alert('Please select product');
        } else {
            var html = '';
            html += '<tr id="main' + $("#tmp_id").val() + '">';
            html += '<input name="edited_product[' + $("#tmp_id").val() + '][qty]" value="' + $("#tmp_qnty").val() + '" type="hidden">';
            html += '<input name="edited_product[' + $("#tmp_id").val() + '][pid]" value="' + $("#tmp_parent_id").val() + '" type="hidden">';
            html += '<input name="edited_product[' + $("#tmp_id").val() + '][sub]" value="' + $("#tmp_id").val() + '" type="hidden">';
            html += '<input name="edited_product[' + $("#tmp_id").val() + '][prod_type]" value="' + $("#tmp_prodType").val() + '" type="hidden">';
            html += '<input name="edited_product[' + $("#tmp_id").val() + '][rowid]" value="' + $("#tmp_rowid").val() + '" type="hidden">';
            html += '<input class="prodPrice" name="edited_product[' + $("#tmp_id").val() + '][prc]" value="' + $("#tmp_price").val() + '" type="hidden">';
            html += '<td class="prod_name">' + $("select#select_product option:selected").text() + '</td>';
            html += '<td>';
            html += '<input class="orderQty' + $("#tmp_id").val() + ' quantityUpdateMain" data-pid="' + $("#tmp_id").val() + '" min="1" max="" data-type="1" name="edited_product[' + $("#tmp_id").val() + '][qty]" value="' + $("#tmp_qnty").val() + '" type="number">';
            html += '</td>';
            html += '<td><i class="fa fa-rupee"></i>' + $("#tmp_price").val() + '</td>';
            html += '<td><i class="fa fa-rupee"></i><span class="totalPrice totalPrice' + $("#tmp_id").val() + '">' + $("#tmp_total_price").val() + '</span></td>';
            html += '<td>';
            html += '<a href="#" class="remove" data-id="' + $("#tmp_id").val() + '">';
            html += '<span class="glyphicon glyphicon-remove"></span>';
            html += '</a>';
            html += '</td>';
            $("#append_prod").append(html);
            empty_tmp_field();
            total_price();
            $("#loader").removeClass('loading');
        }
        return false;
    });

    $("#tmp_qnty,.quantityUpdateMain").bind('keyup keydown change', function () {
        if ($(this).val() < 1) {
            $(this).val(1);
        }
    });

    $("#addprod").click(function () {
        $("#toggleshow").slideToggle();
        $("#addprod").hide();
        return false;
    });
    $("#closeAddNewProd").click(function () {
        $("#toggleshow").slideToggle();
        setTimeout(function () {
            $("#addprod").show();
        }, 350);
        return false;
    });

    function check_product(product_name) {
        var status = 0;
        $(".prod_name").each(function (index, val) {
            if (product_name == $(this).text()) {
                console.log('already');
                status = 1;
            }
        });
        console.log($(this).text());
        return status;

    }

    $('html body').on('click', '.remove', function () {
        var id = $(this).attr('data-id');
        $("#main" + id).remove();
        total_price();
        return false;
    });

    function total_price() {
        var sum = 0;
        $(".totalPrice").each(function (index, val) {
            sum = sum + parseFloat($(this).text());
        });

        $(".grandTotalm,#pay_amt_h").val(parseFloat(sum) + parseFloat($("#tmp_total_price").val()) + parseFloat($(".grandTotal_extra").val()));
        $(".subTotalm,#order_amt_h").val(parseFloat(sum) + parseFloat($("#tmp_total_price").val()));
        $(".grandTotal").text(parseFloat(sum) + parseFloat($("#tmp_total_price").val()) + parseFloat($(".grandTotal_extra").val()));
        $(".subTotal").text(parseFloat(sum) + parseFloat($("#tmp_total_price").val()));
    }

    $('html body').on('keyup keydown change', '.quantityUpdateMain', function () {
        //$(".quantityUpdateMain").bind('keyup keydown change', function () {
        var stock = $(this).val();
        var id = $(this).attr('data-pid');
        var type = $(this).attr('data-type');
        $.ajax({
            type: "POST",
            url: "{{ route('admin.orders.quantityUpdate') }}",
            data: {id: id, stock: stock, type: type},
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $("#loader").addClass('loading');
            },
            success: function (result) {
                if (result.err == 0) {
                    alert('only ' + result.stock + ' in stock');
                    $(".quantityUpdateMain").val(result.stock);
                    update_total_price(result.price);
                    $(".totalPrice" + result.pid).text(result.price);
                } else {
                    update_total_price(result.price);
                    $(".totalPrice" + result.pid).text(result.price);
                    $(".quantityUpdateMain").attr('max', result.stock);
                }
                $("#loader").removeClass('loading');
                total_price();
            }
        });
    });




    $(".quantityUpdate").bind('keyup keydown', function () {
        var stock = $(this).val();
        var id = $(this).attr('data-pid');
        var type = $(this).attr('data-type');
        if ($("#select_product").val() == '00') {
            empty_tmp_field();
            alert('Please select product');
        } else {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.quantityUpdate') }}",
                data: {id: id, stock: stock, type: type},
                cache: false,
                dataType: 'json',
                beforeSend: function () {
                    $("#loader").addClass('loading');
                },
                success: function (result) {
                    if (result.err == 0) {
                        alert('only ' + result.stock + ' in stock');
                        $("#tmp_qnty").val(result.stock);
                        $("#tmp_total_price").val(result.price);
                    } else {
                        if (result.type == 0) {
                            $("#tmp_id").val(result.pid);
                            $("#tmp_total_price").val(result.price);
                            $("#tmp_qnty").attr('max', result.stock);
                        } else {

                        }

                    }
                    $("#loader").removeClass('loading');
                }
            });
        }
    });

    function update_total_price(product_total_price) {
        $(".grandTotal").text(parseFloat($(".grandTotal").text()) + parseFloat(product_total_price));
        $(".subTotal").text(parseFloat($(".subTotal").text()) + parseFloat(product_total_price));
    }

    function empty_tmp_field() {
        $("#select_product").val('00');
        $("#tmp_qnty").attr('data-pid', '');
        $("#tmp_qnty").val('1');
        $("#tmp_price").val('0.00');
        $("#tmp_id").val('');
        $("#tmp_total_price").val('0.00');
        $("#tmp_qnty").attr('max', '');
    }
    $("#select_product").change(function () {
        var id = $(this).val();
        if (id == '00') {
            empty_tmp_field();
        } else {
            if (check_product($("select#select_product option:selected").text()) == 0) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.orders.getProdDetails') }}",
                    data: {id: id},
                    cache: false,
                    dataType: 'json',
                    success: function (result) {
                        if (result.err == 0) {
                            alert('product is out of stock');
                            empty_tmp_field();
                        } else if (result.err == 1) {
                            $("#tmp_qnty").attr('data-pid', result.pid);
                            $("#tmp_qnty").val('1');
                            $("#tmp_price").val(result.price);
                            $("#tmp_id").val(result.pid);
                            $("#tmp_prodType").val(result.product_type);
                            $("#tmp_total_price").val(result.price);
                            $("#tmp_qnty").attr('max', result.stock);
                            $("#tmp_parent_id").val(result.parent_prod);
                        }
                    }
                });
            } else {
                alert('Product already added')
                $("#select_product").val('00');
            }

        }
    });
    $(".readonly").attr("readonly", 'true');
    $("#addnewAdd").click(function () {
        $(".addressRadio").attr("checked", false);
        $(".readonly").removeAttr("readonly");
        $(".readonly").val('');
    });

    $(".addressRadio").click(function () {
        $(".readonly").attr("readonly", 'true');
        var id = $(this).val();

        $("#last_name").val($("#last_name" + id).val());
        $("#first_name").val($("#first_name" + id).val());
        $("#country_id").val($("#country_id" + id).val());
        $("#postal_code").val($("#postcode" + id).val());
        $("#zone_id").val($("#zone_id" + id).val());
        $("#city").val($("#city" + id).val());
        $("#phone_no").val($("#phone_no" + id).val());
        $("#address3").val($("#address3" + id).val());
        $("#address2").val($("#address2" + id).val());
        $("#address1").val($("#address1" + id).val());
    });


</script>
<style>
    /* Absolute Center Spinner */
    .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: show;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.3);
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
@stop