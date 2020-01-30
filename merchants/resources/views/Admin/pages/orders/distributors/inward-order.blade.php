@extends('Admin.layouts.default')

@section('mystyles')
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/daterangepicker/daterangepicker-bs3.css' }}">
<link rel="stylesheet" href="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.css' }}">
<style type="text/css">
    .multiselect-container {
        width: 100% !important;
    }
    .brbottom1{
        margin-bottom: 10px;
        padding: 10px;
    }
    .success{
        color: #3c763d;
    }
    .error{
        color: #d73925;
    }
</style>
@stop

@section('content')
<section class="content-header">
    <h1>
       Inward Order
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li><a href="{{ route('admin.distributor.orders.view') }}"><i class="fa fa-dashboard"></i>Distributor Order</a></li>
        <li class="active">All Orders</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="dividerhr"></div>
                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover tableVaglignMiddle" id="orderListTable">
                        <thead>
                            <tr>
                                <th>Product name</th>
                                <th>Ordered Qty</th>
                                <th>Received Qty</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Map My product</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($orders) >0 )
                            <?php
                            $totalOrderedQty = 0;
                            $orderId = Input::get('id');
                            ?>
                            @foreach($orders as $orderData)
                            <?php
                            $hasProductId = $orderData->id;
                            $productDetail = json_decode($orderData->product_details);
                            $totalOrderedQty = $totalOrderedQty + $productDetail->qty;
                            $merchantProductId = $orderData->merchant_product_id;
                            $totalReceivedQty = 0;
                            if(isset($totalQtyProductwise[$hasProductId]) && !empty($totalQtyProductwise[$hasProductId]))
                            {
                                $totalReceivedQty = $totalQtyProductwise[$hasProductId];
                            }
                            $productName = '';
                            $inputAttr = '';
                            $merchantId = 0;
                            $isProductMapped = 0;
                            if($merchantProductId > 0)
                            {
                                $productData = DB::table('products')->where('id', $merchantProductId)->get(['product']);
                                $productName = $productData[0]->product;
                                $merchantId = $orderData->mappedMerchantId;
                                $inputAttr = 'readonly';
                                $isProductMapped = 1;
                            }
                            ?>
                            <tr id="tr_{{$orderData->id}}">
                                <td>{{$productDetail->name}}</td>
                                <td id="orderedQty_{{$orderData->id}}">{{$productDetail->qty}}</td>
                                <td><input type="text" id="receivedQty_{{$orderData->id}}" name="receivedQty_{{$orderData->id}}" value="" size="4" onkeyup="calculateQtyAndPrice('{{$orderData->id}}')"></td>
                                <td id="unitPrice_{{$orderData->id}}">{{$productDetail->price}}</td>
                                <td id="totalPrice_{{$orderData->id}}">0</td>
                                <td>
                                <input type="text" id="searchProduct_{{$orderData->id}}" name="searchProduct_{{$orderData->id}}" onkeypress="searchProduct({{$orderData->id}})" value="{{$productName}}" {{$inputAttr}} placeholder="Search & Select" size="15" >
                                <input type="hidden" id="merchantProductId_{{$orderData->id}}" name="merchantProductId_{{$orderData->id}}" value="{{$merchantProductId}}">
                                <input type="hidden" id="merchantId_{{$orderData->id}}" name="merchantId_{{$orderData->id}}" value="{{$merchantId}}">
                                <input type="hidden" id="isProductMapped_{{$orderData->id}}" name="isProductMapped_{{$orderData->id}}"  value="{{$isProductMapped}}">
                                </td>
                                <input type="hidden" id="distributorId_{{$orderData->id}}" name="distributorId_{{$orderData->id}}" value="{{$orderData->distributor_id}}">
                                <input type="hidden" id="distributorProductId_{{$orderData->id}}" name="distributorProductId_{{$orderData->id}}" value="{{$productDetail->id}}">
                                <input type="hidden" id="orderProductId_{{$orderData->id}}" name="orderProductId_{{$orderData->id}}" value="{{$orderData->id}}">
                                <input type="hidden" id="totalReceivedQty_{{$orderData->id}}" name="totalReceivedQty_{{$orderData->id}}"  value="{{$totalReceivedQty}}">
                                <input type="hidden" id="qtyErorr_{{$orderData->id}}" name="qtyErorr_{{$orderData->id}}"  value="{{$totalReceivedQty}}">
                                
                            </tr>
                            @endforeach
                            <tr>
                                <th>Total</th>
                                <th>{{$totalOrderedQty}}</th>
                                <th id="totalReceivedQty">-</th>
                                <th></th>
                                <th id="totalReceivedProductPrice">0</th>
                                <th></th>
                                <input type="hidden" id="orderId" name="orderId" value="{{$orderId}}">
                            </tr>
                            @else
                            <tr><td colspan=14> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="box-footer clearfix">
                    <button type="button" onclick="saveData()">Submit</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
</section>
@stop
@section('myscripts')
<script>
    function calculateQtyAndPrice(productId)
    {
        var receivedQty = $("#receivedQty_"+productId).val();
        var unitPrice = $("#unitPrice_"+productId).html();
        var totalReceivedQtyFromDb = $("#totalReceivedQty_"+productId).val();
        var orderedQty = $("#orderedQty_"+productId).html();
        var totalReceivedQty = 0;
        var totalReceivedProductPrice = 0;

        if(receivedQty == 0 || receivedQty == '')
        {
            $("#totalPrice_"+productId).html('-');
        } // End if
        else if(receivedQty > 0)
        {
            totalReceivedQtyFromDb = parseInt(totalReceivedQtyFromDb) + parseInt(receivedQty);
            //alert(totalReceivedQtyFromDb+" < "+orderedQty);
            if(totalReceivedQtyFromDb > orderedQty)
            {
                $("#qtyErorr_"+productId).val(1);
                alert("Received qty should not be grater than Ordered qty");
                return false;
            }
            else
            {
                $("#qtyErorr_"+productId).val(0);
                var totalPrice = unitPrice*receivedQty;
                $("#totalPrice_"+productId).html(totalPrice);
            }
        } // End else if

        // Calculate all received qty
        $("input[id^='receivedQty_']" ).each(function( index ) {
            if(this.value > 0 || this.value != '')
                totalReceivedQty = parseInt(totalReceivedQty)+parseInt(this.value);
        });
        
        if(totalReceivedQty == 0)
            totalReceivedQty = '-';
        $("#totalReceivedQty").html(totalReceivedQty);

        // Calculate all total price 
        $("td[id^='totalPrice_']" ).each(function( index ) {
            var value = $(this).text();
            //alert("value >> "+value);
            if(value > 0 || value != '')
            totalReceivedProductPrice = parseFloat(totalReceivedProductPrice)+parseFloat(value);
        });
        
        // alert(totalReceivedProductPrice);
        $("#totalReceivedProductPrice").html(totalReceivedProductPrice);
    }

    function searchProduct(distributorProductId)
    {
        $("#searchProduct_"+distributorProductId).autocomplete({
            source: "{{ route('admin.distributor.orders.getProduct') }}",
            minLength: 1,
            select: function (event, ui) {
                setValue(ui.item.id, ui.item.merchant_id,distributorProductId);
            }
        });
    } // End searchProduct()

    function setValue(merchantProductId,merchantId,distributorProductId)
    {
        $("#merchantProductId_"+distributorProductId).val(merchantProductId);
        $("#merchantId_"+distributorProductId).val(merchantId);
    } // End setValue();

    function saveData()
    {
        var dataJson = [];
        var i=0;
        var orderId = $("#orderId").val();
        var isSubmit = 0;
        var isMapping = 0;
        $("tr[id^='tr_']" ).each(function( index ) 
        {
            var orderProductId = $(this).attr('id').split('_')[1];
            var qtyErorr = $("#qtyErorr_"+orderProductId).val();
            
            if(qtyErorr == 0)
            {
                var merchantProductId = $("#merchantProductId_"+orderProductId).val();
                var merchantId = $("#merchantId_"+orderProductId).val();
                var distributorId = $("#distributorId_"+orderProductId).val();
                var distributorProductId = $("#distributorProductId_"+orderProductId).val();
                var receivedQty = $("#receivedQty_"+orderProductId).val();
                var unitPrice = $("#unitPrice_"+orderProductId).html();
                var totalPrice = $("#totalPrice_"+orderProductId).html();
                var orderProductId = $("#orderProductId_"+orderProductId).val(); // had_product table primary key
                var isProductMapped = $("#isProductMapped_"+orderProductId).val();
                if((receivedQty > 0 || receivedQty != '') && merchantProductId == '')
                {
                    isMapping = 1;
                    isSubmit = 1;
                    return false;
                }

                if(receivedQty > 0 || receivedQty != '')
                {
                    dataJson[i] = 
                    {
                        'order_id': orderId,
                        'order_product_id': orderProductId,
                        'm_id': merchantId,
                        'd_id': distributorId,
                        'm_product_id': merchantProductId,
                        'd_product_id': distributorProductId,
                        'received_qty': receivedQty,
                        'unit_price': unitPrice,
                        'total_price': totalPrice,
                        'is_mapped': isProductMapped
                    };
                }
                i++;
            }
            else
            {
                isSubmit = 1;
            }
        });
       
        if(isSubmit == 0)
        {
            $.ajax({
                    type: "POST",
                    url: "{{ route('admin.distributor.orders.saveInwardData') }}",
                    data: {'data': dataJson,'order_id': orderId},
                    cache: false,
                    success: function(response) {
                        if(response == true)
                        {
                            window.location = "{{route('admin.distributor.orders.view')}}";
                            return false;
                        }
                        else
                        {
                            alert("There is somthing wrong to inward order product.");
                        }
                    }
                });
        }
        else
        {
            if(isMapping == 1)
            {
                alert("Please select product for mapping");
            }
            else
            {
                alert("Received qty should not be grater than Ordered qty");
            }
            return false;
        }
    } // Edn saveData()
</script>
@stop