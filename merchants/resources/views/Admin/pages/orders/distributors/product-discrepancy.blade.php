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
        Discrepancy
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li><a href="{{ route('admin.distributor.orders.view') }}"><i class="fa fa-dashboard"></i>Distributor Order</a></li>
        <li class="active">Discrepancy</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            
            <div class="box-body table-responsive no-padding">
                <table class="table orderTable table-striped table-hover tableVaglignMiddle" id="orderListTable">
                    <thead>
                        <tr>
                            <th>Product name</th>
                            <th>Ordered Qty</th>
                            <th>Received Qty</th>
                            <th>Scrap Qty</th>
                            <th>Map My product</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($inwardTransaction) >0 )
                        <?php
                        $totalOrderedQty = 0;
                        $orderId = Input::get('id');
                        ?>
                        @foreach($inwardTransaction as $inwardTransactionData)
                        <?php
                        $hasProductId = $inwardTransactionData->id;
                        $productDetail = json_decode($inwardTransactionData->product_details);
                        $totalOrderedQty = $totalOrderedQty + $productDetail->qty;
                        $merchantProductId = $inwardTransactionData->merchant_product_id;
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
                            $merchantId = $inwardTransactionData->mappedMerchantId;
                            $inputAttr = 'readonly';
                            $isProductMapped = 1;
                        }
                        ?>
                        <tr id="tr_{{$hasProductId}}">
                            <td>{{$productDetail->name}}</td>
                            <td id="orderedQty_{{$hasProductId}}">{{$productDetail->qty}}</td>
                            <td>{{$totalReceivedQty}}</td>
                            <td><input type="text" id="scrapQty_{{$hasProductId}}" name="scrapQty_{{$hasProductId}}" value="" size="4" onkeyup="calculateQtyAndPrice('{{$hasProductId}}')"></td>
                            <td>
                            <input type="text" id="searchProduct_{{$hasProductId}}" name="searchProduct_{{$hasProductId}}" onkeypress="searchProduct({{$hasProductId}})" value="{{$productName}}" {{$inputAttr}} placeholder="Search & Select" size="15" >
                            <input type="hidden" id="merchantProductId_{{$hasProductId}}" name="merchantProductId_{{$hasProductId}}" value="{{$merchantProductId}}">
                            <input type="hidden" id="merchantId_{{$hasProductId}}" name="merchantId_{{$hasProductId}}" value="{{$merchantId}}">
                            <input type="hidden" id="isProductMapped_{{$hasProductId}}" name="isProductMapped_{{$hasProductId}}"  value="{{$isProductMapped}}">
                            </td>
                            <input type="hidden" id="distributorId_{{$hasProductId}}" name="distributorId_{{$hasProductId}}" value="{{$inwardTransactionData->distributor_id}}">
                            <input type="hidden" id="distributorProductId_{{$hasProductId}}" name="distributorProductId_{{$hasProductId}}" value="{{$productDetail->id}}">
                            <input type="hidden" id="orderProductId_{{$hasProductId}}" name="orderProductId_{{$hasProductId}}" value="{{$inwardTransactionData->id}}">
                            <input type="hidden" id="totalReceivedQty_{{$hasProductId}}" name="totalReceivedQty_{{$hasProductId}}"  value="{{$totalReceivedQty}}">
                            <input type="hidden" id="qtyErorr_{{$hasProductId}}" name="qtyErorr_{{$hasProductId}}"  value="{{$totalReceivedQty}}">
                            <input type="hidden" id="orderId" name="orderId" value="{{$orderId}}">
                        </tr>
                        @endforeach
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
</section>
@stop
@section('myscripts')
<script>
    function calculateQtyAndPrice(productId)
    {
        var scrapQty = $("#scrapQty_"+productId).val();
        var totalReceivedQtyFromDb = $("#totalReceivedQty_"+productId).val();
        var orderedQty = $("#orderedQty_"+productId).html();
        var totalReceivedQty = 0;
        var totalReceivedProductPrice = 0;

        if(scrapQty > 0 && scrapQty != '')
        {
            totalReceivedQtyFromDb = parseInt(totalReceivedQtyFromDb) + parseInt(scrapQty);
            //alert(totalReceivedQtyFromDb+" < "+orderedQty);
            if(totalReceivedQtyFromDb > orderedQty)
            {
                $("#qtyErorr_"+productId).val(1);
                alert("Scrap qty should not be grater than Ordered qty");
                return false;
            }
            else
            {
                $("#qtyErorr_"+productId).val(0);
            }
        } // End else if

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
                var scrapQty = $("#scrapQty_"+orderProductId).val();
                var orderProductId = $("#orderProductId_"+orderProductId).val(); // had_product table primary key
                var isProductMapped = $("#isProductMapped_"+orderProductId).val();
                if((scrapQty > 0 || scrapQty != '') && merchantProductId == '')
                {
                    isMapping = 1;
                    isSubmit = 1;
                    return false;
                }

                if(scrapQty > 0 || scrapQty != '')
                {
                    dataJson[i] = 
                    {
                        'order_id': orderId,
                        'order_product_id': orderProductId,
                        'm_id': merchantId,
                        'd_id': distributorId,
                        'm_product_id': merchantProductId,
                        'd_product_id': distributorProductId,
                        'scrap_qty': scrapQty,
                        'is_mapped': isProductMapped
                    };
                }
                i++;
            }
            else
            {
                isSubmit = 1;
            }
        }); // End each loop
       
        if(isSubmit == 0)
        {
            alert("orderId >> "+orderId);
            $.ajax({
                    type: "POST",
                    url: "{{ route('admin.distributor.orders.saveDiscrepancyData') }}",
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