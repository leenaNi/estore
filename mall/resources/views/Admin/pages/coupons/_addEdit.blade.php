@extends('Admin.layouts.default')
@section('content')


<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Edit Order</h1>
</div>

<div class="panel panel-default">

    <div class="panel-body">
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div>
            <h4 class="m-n font-thin h3">Order Summery</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>

                    <tr>
                        <th class="product-thumbnail">Product Details</th>
                        <th class="product-quantity">Quantity</th>
                        <th class="product-price">Unit Price</th>
                        <th class="product-subtotal">Total Price</th>
                    </tr>
                </thead>

                <?php
                
//                 echo "<pre>";
//                    print_r($orderDetails);
//                    echo "</pre>";
                foreach ($orderDetails as $orderDetailsVal) {
                    $orderCartInfo = json_decode($orderDetailsVal->cart, true);
//                    echo "<pre>";
//                    print_r($orderCartInfo);
//                    echo "</pre>";
                    ?>
                    <tbody>
                        <?php
                        foreach ($orderCartInfo as $orderProd) {
                            ?>
                            <tr>
                                <td>{{$orderProd['name']}}</td>
                                
                                <td>{{$orderProd['qty']}}</td>
                                <td>{{$orderProd['price']}}</td>
                                <td>{{$orderProd['price']*$orderProd['qty']}}</td>


                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Sub Total</td>
                            <td>{{$orderDetailsVal->totalOrderAmt}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Shipping Charges</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Discount Coupon</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Shippment Total</td>
                            <td>{{$orderDetailsVal->totalOrderAmt}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                <?php } ?>

            </table></div>

        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div>
            <h4 class="m-n font-thin h3">Order Details</h4>
        </div>
        {!! Form::model($orders, ['method' => 'post',  'url' => $action , 'class' => 'form-horizontal','id'=>'orderEditForm' ]) !!}



        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Payment Method', 'Payment Method',['class'=>'control-label']) !!}
                {!! Form::hidden('id',$orders->id) !!}
                {!! Form::select('payment_method',$paymentMethod, isset($orders->payment_method)?$orders->payment_method:null,["class"=>'form-control' ,"placeholder"=>'Enter Payment Method', "required"]) !!}
            </div>
        </div>

        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Payment Status', 'Payment Status',['class'=>'control-label']) !!}
                {!! Form::select('payment_status',$paymentStatus, isset($orders->payment_status)?$orders->payment_status:null, ["class"=>'form-control' ,"placeholder"=>'Enter Payment Status', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Order Status', 'Order Status',['class'=>'control-label']) !!}
                {!! Form::select('order_status',$orderStatus,isset($orders->order_status)?$orders->order_status:null, ["class"=>'form-control' ,"placeholder"=>'Enter Order Status', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Current Payable Amount', 'Current Payable Amount',['class'=>'control-label']) !!}
                {!! Form::text('payable_amount',$orders->pay_amt, ["class"=>'form-control' ,"placeholder"=>'Enter Payable Amount', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('COD Charges', 'COD Charges',['class'=>'control-label']) !!}
                {!! Form::text('cod_charges',$orders->cod_charges, ["class"=>'form-control' ,"placeholder"=>'Enter COD Charges', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Shipping Amount', 'Shipping Amount',['class'=>'control-label']) !!}
                {!! Form::text('shipping_amount',$orders->shipping_amt, ["class"=>'form-control' ,"placeholder"=>'Enter Shipping Amount', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Coupon Amount Used', 'Coupon Amount Used',['class'=>'control-label']) !!}
                {!! Form::text('coupon_amount',$orders->coupon_amt_used, ["class"=>'form-control' ,"placeholder"=>'Coupon Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Voucher Amount Used', 'Voucher Amount Used',['class'=>'control-label']) !!}
                {!! Form::text('voucher_amt_used',$orders->voucher_amt_used, ["class"=>'form-control' ,"placeholder"=>'Voucher Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12"> 
                {!! Form::label('Comments', 'Comments',['class'=>'control-label']) !!}
                {!! Form::text('comments',$orders->order_comment, ["class"=>'form-control' ,"placeholder"=>'Enter Comments', "required"]) !!}
            </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div>
            <h4 class="m-n font-thin h3">Customer Details</h4>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('First Name', 'First Name',['class'=>'control-label']) !!}
                {!! Form::text('first_name',$orders->first_name, ["class"=>'form-control' ,"placeholder"=>'Voucher Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Last Name', 'Last Name',['class'=>'control-label']) !!}
                {!! Form::text('last_name',$orders->last_name, ["class"=>'form-control' ,"placeholder"=>'Voucher Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Phone', 'Phone',['class'=>'control-label']) !!}
                {!! Form::text('mobile',$orders->mobile, ["class"=>'form-control' ,"placeholder"=>'Voucher Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Country', 'Country',['class'=>'control-label']) !!}
                {!! Form::select('country',$country, isset($orders->country_id)?$orders->country_id:null,["id"=>'country',"class"=>'form-control' ,"placeholder"=>'Voucher Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('State', 'State',['class'=>'control-label']) !!}
                {!! Form::select('state',$state,isset($orders->state_id)?$orders->state_id:null, ["id"=>'state',"class"=>'form-control' ,"placeholder"=>'Voucher Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('City', 'City',['class'=>'control-label']) !!}
                {!! Form::text('city',$orders->city, ["class"=>'form-control' ,"placeholder"=>'Voucher Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="col-md-12">
                {!! Form::label('Location', 'Location',['class'=>'control-label']) !!}
                {!! Form::text('location',$orders->location, ["class"=>'form-control' ,"placeholder"=>'Voucher Amount Used', "required"]) !!}
            </div>
        </div>
        <div class="form-group col-md-10">
            <div class="col-md-12 fright ">
                {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}
                {!! Form::close() !!}     


            </div>
        </div>
        </form>
 <div class="line line-dashed b-b line-lg pull-in"></div>
    </div>

   


</div>
</div>

@stop 

@section('myscripts')

<script>
    $(document).ready(function () {

        $("#country").change(function () {
            $("#state").empty();

            var country_id = $("#country").val();

            $.ajax({
                type: "POST",
                url: "{{ URL::route('ajax-country-states') }}",
                data: {country_id: country_id},
                cache: false,
                success: function (data) {

                    $.each(data, function (key, value) {

                        $("#state").append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                    });

                }
            });
        });
    });
</script>
@stop