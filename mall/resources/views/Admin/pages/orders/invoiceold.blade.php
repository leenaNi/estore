

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<style type="text/css">
    .invcontainer{
        width:970px;  margin: 0 auto; background: #fff; color: #000; padding: 25px; font-family: source_sans_prolight; font-size:14px; display: table;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        page-break-after:always;
    }
    .w100{width:100%; float: left; }
    .w50{width:50%; float: left;}
    .w20{width:20%; float: left;} 
    .w10{width:10%; float: left;} 
    .w15{width:15% !important; float: left;} 
    .w30{width:30%; float: left;}
    .w60{width:50%; float: left;}
    .w40{width:40%; float: left;}
    .w45{width:40%; float: left;}
    .w70{width:70%; float: left;}
    .w85{width:85%; float: left;}
    img{width:85%;} 
    .compname{font-family: source_sans_probold; font-size: 20px;}
    .mt50{margin-top: 50px;}
    .compaddress{font-size:20px;}
    .inv{font-family: source_sans_problack; font-size: 45px; text-transform: uppercase;}
    .mt100{margin-top: 100px;}
    table{width:100%; border-spacing: 0px; border-collapse: collapse; }
    table td{border: 1px solid #C5C5C5; padding: 5px 15px; font-size: 18px;}
    table td span{font-family:source_sans_prosemibold;  font-size:20px;}
    .mt70{margin-top:70px;}
    .txtc{text-align: center;}
    .txtr{text-align: right;}
    .br0{border-right: 1px solid #fff;}
    .tupp{text-transform: uppercase;}
    .noborder table td{border:none !important;}
    .noborder{line-height: 23px;}
    .txtright{text-align: right;}

    .invcontainer:last-child {
        page-break-after: avoid;
    }
</style>

<a class="printInvoice" align="left" style=" width: 180px; color: #fff; text-decoration: none; border: 1px solid #ccc; background: #009EDA; text-align: center; padding: 10px 20px; border-radius: 10px; position: relative; top: 25px; left: 30px;" href="#" data-orderids="{{$allids}}" >Print</a>
<?php
$jsonString = file_get_contents(storage_path() . '/json/storeSetting.json');
$data = json_decode($jsonString);
//$addCharge = GeneralSetting::where('url_key', 'additional-charge')->first();
?>

@foreach($orders as $order)

<?php
$vatTotal = 0;
$address = $order->users->addresses->first();
?>

<div class="invcontainer">

    <div class="w100">
        <div class="w20">
            <img src="{{ $data->logo }}" />
        </div>
        <div class="w50 mt50">
            <div class="compname">{{Config('constants.storeName')}}</div>
            <!-- <div class="compaddress">Ground Floor, Herman House (Back Gate),Goraswadi, Behind Milap Cinema, Malad (West), Mumbai - 400064</div>
             <div class="compaddress">Telephone: +919920918248</div> -->

            <div class="compaddress">224,  Mumbai- 400011</div>
            <div class="compaddress">Telephone: 12345678</div>

        </div>
        <div class="w30 mt50">
            <div class="inv">Invoice</div>
        </div>
    </div>

    <div class="w100 mt100">
        <table>
            <tr>
                <td class="w60"><span> Date Added: </span>{{ date('d/m/y' , strtotime($order->created_at)) }}</td>
                <td class="w40"><span> Payment Method: </span>{{$order->paymentmethod['name'] }}</td>
            </tr>
            <tr>
                <td class="w60"><span> Order ID: </span> {{ $order->id }} </td>
                <td class="w40"><span> Shipping Method: </span> Free Shipping</td>
            </tr>
        </table>
    </div>

    <div class="w100 mt70">
        <table class="noborder">
            <tr>
                <td class="w60"><span> Billing Address </span></td>
                <td class="w40"> <span> Shipping Address</span> </td>
            </tr>

            <tr>
                <td class="w60">
                    {{ @$order->first_name }}     {{ @$order->last_name }} <br/>
                    {{ @$order->address1 }} <br/>
                    {{ @$order->address2 }} <br/>
                    {{ @$order->city }}  {{ @$order->postal_code }} <br/>
                    {{ @$order->zone->name }} <br/>
                    {{ @$order->country->name }} <br/>
                    {{ @$order->users->email }}  <br/>
                    {{ @$order->phone_no }} <br/>
                </td>
                <td class="w40"> 
                    {{ @$order->first_name }}     {{ @$order->last_name }} <br/>
                    {{ @$order->address1 }} <br/>
                    {{ @$order->address2 }} <br/>
                    {{ @$order->city }}  {{ @$order->postal_code }} <br/>
                    {{ @$order->zone->name }} <br/>
                    {{ @$order->country->name }} <br/>
                    {{ @$order->users->email }}  <br/>
                    {{ @$order->phone_no }} <br/>
                </td>
            </tr>
        </table>
    </div>
    <?php
    $currency = "inr";
    $currency_val = 1;
//    if (isset($order->currency->currency)) {
//        $currency = $order->currency->currency;
//        $currency_val = $order->currency->currency_val;
//    }
    if ($order->currency_id != Session::get('currency_id')) {
        $ordCurrency = DB::table('has_currency')->where('id', Session::get('currency_id'))->first();
    } else {
        $ordCurrency = DB::table('has_currency')->where('id', $order->currency_id)->first();
    }
    $currency_val = $ordCurrency->currency_val;
    $currency_code = $ordCurrency->currency;
    ?>
    <div class="w100 mt70">
        <table>
            <tr>
                <td class=" "><span> Product </span></td>
                <td class="  txtc"><span> Qty </span></td>
                <td class="  txtc"> <span> Price</span> </td>
                <!--<td class=" txtc"> <span>TAX</span> </td>-->
                <?php if ($feature['tax'] == 1) { ?>
                    <td class="cart-product-quantity"><span>Tax</span> </td>
                <?php } ?>
                <td class=" txtc"> <span> Total</span> </td>
            </tr>
            <?php
//                   echo "<pre>";
//        print_r(json_decode($order));
            // die;
            $subtotal = 0;
            $weight = 0;
            $unitPSubtotal = 0;
            //print_r($order->cartItems);
            ?>
            @foreach($order->cartItems as $prd)
            <tr>
                <td>{{ $prd['name'] }} <br/>

                    <?php //print_r($prd); ?>   
                    <?php
                    $prdT = $prd['product']->prod_type;
                    $warehouseCode = $prd['product']->warehouse_code;
                    if ($prdT == 1) {
                        //echo "SKU: " . $prd['id'] . str_repeat('&nbsp;', 2) . "WC: " . $warehouseCode;
                    }
                    ?>

                    <?php
                    if (!empty($prd['options']['options'])) {
                        //$warehouseCode = @Product::find($prd['options']['sub_prod'])->warehouse_code;
                        foreach ($prd['options']['options'] as $key => $value) {
                            echo $key . ": " . $value . str_repeat('&nbsp;', 2) . "SKU: " . $prd['options']['sub_prod'] . str_repeat('&nbsp;', 2) . "WC: " . $warehouseCode . "<br/>";
                        }
                    }

                    if (!empty($prd['options']['combos'])) {
                        foreach ($prd['options']['combos'] as $key => $value) {

                            if (!empty($value['options'])) {
                                foreach ($value['options'] as $opt => $optval) {
                                    echo $value['name'] . "<br/>";
                                    echo $opt . ": " . $optval . str_repeat('&nbsp;', 2) . "SKU: " . $value['sub_prod'] . str_repeat('&nbsp;', 2) . "WC: " . @Product::find($value['sub_prod'])->warehouse_code . "<br/><br/>";
                                }
                            } else {
                                $simpleProd = app\Models\Product::find($key);
                                $prodName = $simpleProd->product;
                                $prodCat = $simpleProd->categories()->first()->category;
                                $wc = $simpleProd->warehouse_code;
                                echo $prodName . "(" . $prodCat . ") <br/>" . "SKU: " . $simpleProd->id . str_repeat('&nbsp;', 2) . "WC: " . $wc . "<br/>";
                            }
                        }
                    }
                    ?> {{ @$prd['category']->category }}

                </td>
                <!--<td ></td>-->
                <td class="txtc"> {{ $prd['qty'] }} </td>
                <?php
                $unitP = $prd['price'] / (1 + (@$prd['category']->vat / 100));
                $unitPSubtotal += round($prd['price'] / (1 + (@$prd['category']->vat / 100))) * $prd['qty'];
                ?>
                <td class="txtc">
                    <span class="currency-sym"></span> {{ number_format(($prd['price']  * $currency_val)/(1 + (@$prd['category']->vat/100)),2) }} </td>
                <?php $vatTotal += round(1 * (@$prd['category']->vat / 100) * $unitP) * $prd['qty']; ?>
                <td ><span class="currency-sym"></span>{{ number_format(1*(@$prd['category']->vat/100)*$unitP ,2) }}</td>
                <td class="txtright" align=""><span class="currency-sym"></span> {{ number_format(@$prd['subtotal']  * $currency_val,2) }}</td>
            </tr>
            <?php $subtotal += @$prd['subtotal'] ?>
            @endforeach
            @if($weight)
            <tr>
                <td  colspan="4" class="txtr br0"> <span>Total Order Weight </span>  </td>
                <td class=" txtright">{{ $weight  }} Kg </td>
            </tr>
            @endif
            <tr>
                <td  colspan="4" class="txtr br0"> <span>Sub-Total</span>  </td>
                <td class=" txtright"><span class="currency-sym"></span> {{ number_format(($unitPSubtotal + $vatTotal) * $currency_val ,2)  }} </td>
            </tr>
            <?php if ($order->cod_charges > 0) { ?>
                <tr>
                    <td  colspan="4" class="txtr br0"> <span>Cash on Delivery </span>  </td>
                    <td class=" txtright">+  {{ number_format($order->cod_charges) }} </td>
                </tr>

            <?php } ?> 
            <?php if ($order->coupon_amt_used > 0) { ?>
                <tr>
                    <td  colspan="4" class="txtr br0"> <span> Coupon Used ({{ $order->coupon['coupon_code'] }})</span>  </td>
                    <td class=" txtright"><span class="currency-sym"></span>{{ number_format(($order->coupon_amt_used * $currency_val), 2) }} </td>
                </tr>
            <?php } ?>
            <?php if (!empty($order->cashback_used)) { ?>
                <tr>
                    <td  colspan="4" class="txtr br0"> <span>Cashback Used</span>  </td>
                    <td class=" txtright"><span class="currency-sym"></span>  {{ number_format(($order->cashback_used * $currency_val), 2) }} </td>
                </tr>
            <?php } ?>
            <?php if (!empty($order->referal_code_amt)) { ?>
                <tr>
                    <td  colspan="4" class="txtr br0"> <span>Referal Code Used{{ !empty($order->referal_code_used)?"(".$order->referal_code_used.")":'' }} </span>  </td>
                    <td class=" txtright">
                        <span class="currency-sym"></span> {{ number_format(($order->referal_code_amt * $currency_val), 2) }} </td>
                </tr>
            <?php } ?>
            @if($feature['manual-discount']== 1)
            <?php if ($order->discount_amt > 0) { ?>
                <tr>
                    <td  colspan="4" class="txtr br0"> <span>Discount </span>  </td>
                    <td class=" txtright"><span class="currency-sym"></span>  {{ number_format(($order->discount_amt * $currency_val), 2)}} </td>
                </tr>

            <?php }
            ?>  
            @endif    

            <?php //if ($order->shipping_amt > 0) { ?>
<!--                <tr>
    <td  colspan="5" class="txtr br0"> <span>Shipping Charges: </span>  </td>
    <td class=" txtright">+ <i class="fa fa-<?php // echo strtolower($currency);                             ?>"></i> {{ number_format($order->shipping_amt) }} </td>
</tr>-->
            <?php // }  ?>


            <?php if (!empty($order->voucher_amt_used)) { ?>
                <tr>
                    <td  colspan="4" class="txtr br0"> <span> Voucher used ({{ $order->voucher['voucher_code'] }})</span>  </td>
                    <td class=" txtright"><span class="currency-sym"></span> {{ number_format(($order->voucher_amt_used * $currency_val), 2)	 }} </td>
                </tr>
                <?php
            }
            if ($chrges->status == 1) {
                foreach ($additional['details'] as $add) {
                    //  print_r($additional);die;
                    ?> 

                    <?php if (count($add) > 0) { ?>  
                        <tr>

                            <td colspan="4" class="txtr br0"> <span> {{$add['label'] }}</span>  </td>
                            <td class=" txtright"><span class="currency-sym"></span> {{number_format(($add['applied'] * $currency_val), 2)}} </td>
                        </tr>
                    <?php } ?> 

                    <?php
                }
            }
            if (!empty($order->gifting_charges)) {
                ?>
                <tr>
                    <td  colspan="4" class="txtr br0"> <span>Gifting Charges</span>  </td>
                    <td class=" txtright"><span class="currency-sym"></span> {{ number_format(($order->gifting_charges * $currency_val), 2)}} </td>
                </tr>
            <?php } ?>  
            <tr>
                <td  colspan="4" class="txtr br0"> <span>TOTAL:</span>  </td>
                <td class=" txtright"><span class="currency-sym"></span>  {{ number_format(($order->pay_amt * $currency_val), 2) }} </td>
            </tr>
        </table>  
    </div>

    <div class="w100 mt50">

        <div class="tupp w50"> vat tin no. 12345678901V <br/>
            cst tin no. 27121012345C <br/> PAN NO. AAAA9591L <br/>
            Subject to Mumbai Jurisdiction <br/>
            This is a computer generted invoice 
            <br/> <br/>
            <?php if (strlen($order->description) > 1) { ?>
                <?php echo ucfirst('Order Comment') ?>: {{$order->description}}
            <?php } ?>
        </div>
        <div class="txtr w50"> connect@inficart.com <br/> http://infistore.com</div>
    </div> 
</div>
@endforeach
<script src="{{ asset('public/Admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('.invcontainer').last().css('page-break-after', 'avoid');
    $(".printInvoice").click(function () {
        var AllOrders = $(this).attr("data-orderids");
        $.ajax({
            type: "POST",
            url: "{{ URL::route('admin.orders.invoice.print') }}",
            data: {AllOrders: AllOrders},
            cache: false,
            success: function () {
                $(".printInvoice").hide();
                window.print();
            }
        });

    });
    console.log("get currency");
    $.post("{{route('setCurrency')}}", {}, function (response) {
        console.log("Success Response");
        console.log(response);
        $('.currency-sym').html('').html(response.sym);
        $('.currency-sym-in-braces').html('').html("(" + response.sym + ")");
        $('.currency-sym').html('').html(response.sym);
    });

});
</script>
