@extends('Admin.layouts.default')

@section('mystyles')
<style>
    @media print
{
body * { visibility: hidden; }
#printcontent * { visibility: visible; }
#printcontent { position: absolute; top: 40px; left: 30px; }
}
.double-dashed-border {
    border-bottom: double;
    border-bottom-style: double;
    position: relative;
    border-width: 4px;
}
.double-dashed-top-border {
    border-top: double;
    border-top-style: double;
    position: relative;
    border-width: 4px;
}
.double-dashed-border td{margin-bottom: 10px;}
    .bord-bot0{border-bottom: 0;}
    .pl10{padding-left: 10px;}
    .sbtot{font-weight: normal;
    font-size: 15px;}
    .grtot{font-weight: bold;font-size: 16px;}
    .bord-bot-dash{border-bottom: 1px dashed #000;}
    .bord-top-dash td{padding-top: 10px;}
    .bord-bott-black{border-bottom: 1px solid #000;}
/*    table.invocieBill-table tbody tr th {
        padding-bottom: 10px !important;
        padding-top: 10px !important;
    }
    table.invocieBill-table tbody tr td {
        padding-bottom: 10px !important;
        padding-top: 10px !important;
    }
    .invocieBill-table{
        width: 400px;
        margin: 0 auto;
    }*/
    span.shopname {
        font-size: 18px;
        font-weight: bold;
        letter-spacing: 1px;
    }
    span.shopaddress, span.shopnumber {
        font-size: 15px;
        font-weight: 400;
    }
    .green{
        background-color: #8ab34f!important;
        color: #fff !important;
    }

    #accordion h6 a {
        font-size: 14px;
        font-weight: normal;
        margin: 0px;
    }
    #accordion ul{
        padding: 0;
    }

    #accordion li{
        list-style: none;
        clear: both;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid;
    }

    #accordion .box-header {
        padding: 5px;
        border-left-width: 0px;
    }

    input.input-mini.pull-right.qty {
        width: 35px;
        padding: 0;
        margin-right: 10px;
    }
    .list{ padding: 15px;}

    #accordion a.pull-right {
        margin-top: 4px;
        margin-left: 10px;
    }
    .form-group label{ font-size: 14px!important; }
    .panel-title{ font-size: 14px!important; }
    .control-label{ font-size: 14px!important; }
    .error{color:red;}
    .shop-logo img {max-width: 100px;}
    .item-cat-list {
            border: 1px solid #e6e6e6;
            text-align: center;
            border-radius: 5px;
            background: #fafafa;
        }
        .item-cat-list a{
            display:block;
            width:100%;
            height:100%;
            padding: 30px;
            font-size: 16px;
            font-weight: 450;
        }
        label.fnt-bold {
            font-weight: 450 !important;
            font-size: 16px !important;
        }
        a.remark-plus {
            line-height: 36px;
        }
        .height-auto{
            height:auto !important;
        }
        .search-item-list input {
            max-width: 80px;
            text-align: center;
        }
        .kot-order table tr th, .kot-order table tr td {
            width: 33.33%;
        }
        .kot-order .table.no-top-border>tbody>tr>td{
            border-top:0 !important;
        }
        .kot-btn {
            clear: both;
            overflow: auto;
            margin-top: 50px;
        }
        .mleft0{
            margin-left:0px;
        }
        .notop-padding{
            padding-top:0;
        }
</style>
@stop
@section('content')

<section class="content-header">
    <h1>
        View Items
        <small>{{ $order->type->otype }} #{{ $order->id }} </small>
    </h1>
</section>


<section class="content">

    <div class="row">

        <div class="col-md-9">
            <div class="box box-solid">
                <div class="col-md-12">
                    <h3>Currently Ordered</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive  ">
                    
                        <input type="hidden" name="order_id" value="{{ $order->id }}" >
                        <table class="table table-bordered table-condensed table-hover tableVaglignMiddle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Remarks</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>                        
                    
                </div>
            </div>

            <!-- /.box -->
        </div>
        <div class="col-md-3">
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Subtotal (Without Taxes): <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> <span class="finalSubTotal" >0</span></label>
                            </div>
                            <div class="form-group" id="orderDetailsDiv">
                                
                            </div>
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
    calAmt();
    function calAmt() {

        $.post("{{ route('admin.getCartAmt') }}", function (response) {
            carttot = response.cartAmt.toFixed(2);
            $(".finalSubTotal").text(carttot);
        });

    }

    $(document).ready(function () {

        //$(".sidebar-toggle").click();
        
    });
    $("input[name='orderId']").val(<?= $order->id; ?>);
    getOrderKotWithProds(<?= $order->id; ?>);
    getStoreDetails(<?= $order->id; ?>);
    function getOrderKotWithProds(orderid) {
        
        $.post("{{route('admin.order.getOrderKotProds')}}", {orderid: orderid}, function (existingprods) {
           // alert('dfdfd');
            //console.log(existingprods);
          //calAmt();
            $("table.tableVaglignMiddle tbody").html(existingprods);
            var getTotalAmount = $("#final_total_amount").val();
            //alert("total amt::"+getTotalAmount);
            $(".finalSubTotal").text(getTotalAmount);
            $(".payAmount").html(getTotalAmount);
        });
    }

    function getStoreDetails(orderid) {
        
        $.post("{{route('admin.order.getOrderDetails')}}", {orderid: orderid}, function (data) {
            console.log(data);
            $("#orderDetailsDiv").html(data);
        });
    }

</script>
@stop