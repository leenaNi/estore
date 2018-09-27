
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
        <title>{{$storeName}}</title>


        <style>
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 20px;
                border: 2px solid #444;
                font-size: 16px;
                line-height: 24px;
                font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                color: #555;
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }

            .invoice-box table td {
                padding: 5px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: left;
            }


            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.heading td {
                border-bottom: 1px solid #ddd;
                border-top: 1px solid #ddd;
                font-weight: bold;
                border-left: 1px solid #ddd;
            }
            .invoice-box table tr.heading td:nth-child(1){border-left: 0px;}
            .invoice-box table tr.details td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.item td{
                border-bottom: 1px solid #ddd;
                border-left: 1px solid #ddd;
            }
            .invoice-box table tr.item td:nth-child(1){border-left: 0px;}
            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(2) {
                /*border-top: 2px solid #eee;*/
                font-weight: bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }
            }

            /** RTL **/
            .rtl {
                direction: rtl;
                font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            }

            .rtl table {
                text-align: right;
            }

            .rtl table tr td:nth-child(2) {
                text-align: left;
            }
            .headerText{ color: #444!important; }
            .invcontainer:last-child {
                page-break-after: avoid;
            }
            .invcontainer{
                width:970px;  margin: 0 auto; background: #fff; color: #000; padding: 30px; font-family: source_sans_prolight; font-size:16px; display: table;
                border: 1px solid #ccc;
                margin-bottom: 20px;
                page-break-after:always;
            }
        </style>
    </head>

    <body>
        <a class="printInvoice" align="left" style=" width: 180px; color: #fff; text-decoration: none; border: 1px solid #ccc; background: #009EDA; text-align: center; padding: 10px 20px; border-radius: 10px; position: relative; top: 25px; left: 30px;" href="#"  data-orderids="{{$allids}}">Print</a>
<?php   
$ordCurrency = App\Models\HasCurrency::where('id', Session::get('currency_id'))->first();
$currency_val = $ordCurrency->currency_val;
$currency_sym = $ordCurrency->css_code;
?>

        @foreach($orders as $order)
        <div class="invcontainer">
            <div class="invoice-box">


                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table cellpadding="0" cellspacing="0" style="border-bottom: 2px solid #ddd;">
                                <tr>
                                    <td class="title">
                                        <img src="https://{{$_SERVER['HTTP_HOST']}}/uploads/logo/logo.png">
                                    </td>
                                    <td class="headerText">
                                        {{$storeName}}<br>
                                        Email: {{$storeContact->email}}
                                    </td>

                                    <td class="headerText" style="border-left: 2px solid #ddd; padding-left: 10px;">
                                        Invoice No.: {{$order->id}}  <br>
                                            Invoice Date:{{ date('d-M-Y',strtotime($order->updated_at)) }} <br>
<!--                                                GST NO:19AAECA1796L1Z7-->

                                                </td>
                                                </tr>
                                                </table>
                                                </td>
                                                </tr>

                                                <tr class="information">
                                                    <td colspan="2">
                                                        <table cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>
                                                                    <span style="text-decoration: underline;">DELIVERY TO:</span><br>
                                                                        <b>{{$order->first_name}} {{$order->last_name}}</b><br>
                                                                            {{$order->address1}}<br>{{$order->address2}}<br> {{$order->city}}
                                                                                       , {{$order->postal_code}}  <br>  {{ $order->country->name}}
                                                                                            </td>

                                                                                            <td>
                                                                                                <table cellpadding="0" cellspacing="0">

                                                                                                    <b>AWB No.: {{$order->shiplabel_tracking_id}}</b><br>
<!--                                                                                                        <b>Weight:</b> 0.50(Kgs)<br>
                                                                                                            <b>Dimensions(Cms): 30 X 25 X 5</b><br>-->
                                                                                                                <b>Order ID:</b> {{$order->id}}<br>
                                                                                                                    <b>Order Date: </b> {{ date('d-M-Y',strtotime($order->created_at)) }} <br>
                                                                                                                        <!--                                            <b>Pieces:</b> 1-->
                                                                                                                        </td>
                                                                                                                        </tr>
                                                                                                                        </table>
                                                                                                                        </td>
                                                                                                                        </tr>
                                                                                                                        </table>
                                                                                                                        </td>
                                                                                                                        </tr>

                                                                                                                        <tr>
                                                                                                                            <td colspan="2">
                                                                                                                                <table cellpadding="0" cellspacing="0">
                                                                                                                                    <tr class="heading">
                                                                                                                                        <td>Sr. No.</td>
                                                                                                                <!--                        <td>Item Code</td>-->
                                                                                                                                        <td>Description</td>
                                                                                                                                        <td>Quantity</td>
                                                                                                                                        <td>Value</td>
                                                                                                                <!--                        <td>Tax</td>-->
                                                                                                                                        <td>Amount (Including Taxes)</td>
                                                                                                                                    </tr>
                                                                                                                                    <?php
                                                                                                                                    $subtotal = 0;
                                                                                                                                    $i = 1
                                                                                                                                    ?>
                                                                                                                                    @foreach(json_decode($order->cart,true) as $prd)

                                                                                                                                    <tr class="item">
                                                                                                                                        <td>{{$i}}</td>
                                                                                                                <!--                        <td>1015</td>-->
                                                                                                                                        <td>{{$prd['name']}}</td>
                                                                                                                                        <td>{{$prd['qty']}}</td>
                                                                                                                                        <td><span class="">{{$currency_sym}}</span> {{number_format($prd['subtotal']*$currency_val),2}}</td>
                                                                                                                <!--                        <td>143.00</td>-->
                                                                                                                                        <td><span class="">{{$currency_sym}}</span> <b> {{number_format($prd['subtotal']*$currency_val,2)}}</b></td>
                                                                                                                                    </tr>
                                                                                                                                    <?php
                                                                                                                                    $subtotal += $prd['subtotal'];
                                                                                                                                    $i++
                                                                                                                                    ?>
                                                                                                                                    @endforeach
                                                                                                                                    <tr class="item">
                                                                                                                                        <td colspan="4" align="right"><b>Subtotal</b></td>
                                                                                                                                        <td><span class="currency-sym">{{$currency_sym}}</span>  {{number_format($order->order_amt*$currency_val,2)}}</td>
                                                                                                                                    </tr>
                                                                                                                                    @if(!empty($order->shipping_amt)) 
                                                                                                                                    <tr class="item">
                                                                                                                                        <td colspan="4" align="right"><b>Shipping</b></td>
                                                                                                                                        <td><span class="currency-sym">{{$currency_sym}}</span>  <b>{{ number_format($order->shipping_amt*$currency_val,2) }}</b></td>
                                                                                                                                    </tr>
                                                                                                                                    @endif
                                                                                                                                    @if(!empty($order->coupon_amt_used)) 
                                                                                                                                    <tr class="item">
                                                                                                                                        <td colspan="4" align="right"><b>Coupan Code Applied</b></td>
                                                                                                                                        <td><span class="{{$currency_sym}}}">{{$currency_sym}}</span> <b> {{ number_format($order->coupon_amt_used*$currency_val,2) }}</b></td>
                                                                                                                                    </tr>
                                                                                                                                    @endif

                                                                                                                                    <tr class="item">
                                                                                                                                        <td colspan="4" align="right"><b>Total</b></td>
                                                                                                                                        <td> <span class="{{$currency_sym}}">{{$currency_sym}}</span> <b> {{ number_format($order->pay_amt *$currency_val,2) }}</b></td>
                                                                                                                                    </tr>

                                                                                                                                </table>
                                                                                                                            </td>
                                                                                                                        </tr>

                                                                                                                        <tr>
                                                                                                                            <td colspan="2" style="border-top: 1px solid #ddd;">
                                                                                                                                <b>Return Address:</b> {{$storeContact->address_line1 }} , {{$storeContact->address_line2 }} <br>
                                                                                                                                  {{$storeContact->city}}, {{$storeContact->pincode }}<br>
                                                                                                                                        {{$storeContact->mobile }}

                                                                                                                                        </td>
                                                                                                                                        </tr>
                                                                                                                                        </table>
                                                                                                                                        </div>
       
                                                                                                                                        </div>
                                                                                                                                        @endforeach
    </body>
                                                          <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"></script>
                                                                                                                                        <script>
$(document).ready(function () {
    $('.invcontainer').last().css('page-break-after', 'avoid');
    $(".printInvoice").click(function () {
        var AllOrders = $(this).attr("data-orderids");
         $(".printInvoice").hide();
                window.print();
      

    });

});
                                                                                                                                        </script>
                                                                                                                                        </body>
                                                                                                                                        </html>
