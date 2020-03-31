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
<?php
$implodedJoinTablesId = '';
$joinTableIdString = ''; 
if($order->join_tables != '')
{
    $joinTableIdArry = json_decode($order->join_tables);
    $tableIdArry = [];
    foreach($joinTableIdArry as $getTableId)
    {
        $restaurantTableResult = DB::table('restaurant_tables')
            ->where('id', $getTableId)
            //->orderBy('id', 'DESC')
            ->get();
            foreach ($restaurantTableResult as $restTble) {
        
                $tableNo = $restTble->table_no;
                array_push($tableIdArry,$tableNo);
            }
        
          
    
    }//foreach ends here
    //echo "<pre>";
    //print_r($tableIdArry);
    $implodedJoinTablesId = implode('-', $tableIdArry);
    $joinTableIdString = '#Table Id ('.$implodedJoinTablesId.')';
}

?>
<section class="content-header">
    <h1>
        Add/Edit Items
        <small>{{ $order->type->otype }} #{{ $order->id }} {{$joinTableIdString}}</small>
    </h1>
</section>

<section class="main-content">

    <div class="col-md-8 noLeft-padding">
        <div class="grid-content">
            <div class="section-main-heading">
                <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> New KOT</h1>
                <a href="#" target="_blank" class="btn btn-listing-heading pull-right noAll-margin"> <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'plus.svg'}}"> New KOT </a>
            </div>
            <div class="filter-section equal-height-div-1">
                <div class="filter-left-section">
                    <div class="form-group col-md-6">
                        <label class="fnt-bold">Add Items</label>
                        <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                            <input type="text" class="form-control" placeholder="Search Category/Product Name/SKU/ID" name="Search Category/Product Name/SKU/ID">
                        </div>                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="cat-list">
                        <div class="form-group col-md-3">
                            <div class="item-cat-list">
                            <a href="#">
                                Cat 1
                                </a>
                            </div>                        
                        </div>
                        <div class="form-group col-md-3">
                            <div class="item-cat-list">
                            <a href="#">
                                Cat 2
                                </a>
                            </div>                        
                        </div>
                        <div class="form-group col-md-3">
                            <div class="item-cat-list">
                            <a href="#">
                                Cat 3
                                </a>
                            </div>                        
                        </div>
                        <div class="form-group col-md-3">
                            <div class="item-cat-list">
                            <a href="#">
                                Cat 4
                                </a>
                            </div>                        
                        </div>
                        <div class="form-group col-md-3">
                            <div class="item-cat-list">
                            <a href="#">
                                Cat 5
                                </a>
                            </div>                        
                        </div>
                        <div class="form-group col-md-3">
                            <div class="item-cat-list">
                            <a href="#">
                                Cat 6
                                </a>
                            </div>                        
                        </div>
                        <div class="form-group col-md-3">
                            <div class="item-cat-list">
                            <a href="#">
                                Cat 7
                                </a>
                            </div>                        
                        </div>
                        <div class="form-group col-md-3">
                            <div class="item-cat-list">
                                <a href="#">
                                    Cat 8
                                </a>
                            </div>                        
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="search-item-list">
                        <div class="form-group col-md-6">
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#">Dosa</a></td>
                                            <td><input type="number" value="" class="form-control" placeholder="No."></td>
                                            <td class="text-center"><a href="#anyRemark" data-toggle="modal" class="remark-plus"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'black-plus.svg'}}"></a></td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">Idali</a></td>
                                            <td><input type="number" value="" class="form-control" placeholder="No."></td>
                                            <td class="text-center"><a href="#anyRemark" data-toggle="modal" class="remark-plus"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'black-plus.svg'}}"></a></td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">Wada</a></td>
                                            <td><input type="number" value="" class="form-control" placeholder="No."></td>
                                            <td class="text-center"><a href="#anyRemark" data-toggle="modal" class="remark-plus"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'black-plus.svg'}}"></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 noRight-padding">
        <div class="grid-content">
            <div class="section-main-heading">
                <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'transfer-2.svg'}}"> Current Order</h1>
            </div>
            <div class="filter-section equal-height-div-2">
                <div class="filter-right-section notop-padding">
                    <div class="table-responsive">
                        <div class="kot-order">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Remark</th>
                                        <th class="text-center">Qty</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="table table-condensed no-top-border mb-30">
                                <tbody>
                                    <tr>
                                        <td colspan="3"><strong>KOT #3</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Item 1</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">5</td>
                                    </tr>
                                    <tr>
                                        <td>Item 2</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">3</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-condensed no-top-border mb-30">
                                <tbody>
                                    <tr>
                                        <td colspan="3"><strong>KOT #2</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Item 4</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">2</td>
                                    </tr>
                                    <tr>
                                        <td>Item 3</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">1</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-condensed no-top-border mb-30">
                                <tbody>
                                    <tr>
                                        <td colspan="3"><strong>KOT #1</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Item 4</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">7</td>
                                    </tr>
                                    <tr>
                                        <td>Item 3</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">6</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="kot-btn">
                            <button type="button" class="btn btn-primary pull-left mleft0">Reset</button>
                            <button type="button" class="btn btn-primary pull-right">Save KOT</button>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>

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
                    <form id="order-addItem" action="" method="post">
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
                        <button type="button" class="btn btn-primary pull-right" style="display:none;" id="saveItem">Save KOT</button>
                    </form>
                </div>
            </div>


            <div class="box box-solid">

                <h3 class="list marginBottom20">
                    <div class="col-md-6 noRightpadding noLeftpadding">
                        <input type="text" class="form-control" placeholder="Search Category/Product Name/SKU/ID" name="Search Category/Product Name/SKU/ID">
                    </div>
                </h3>

                <!-- /.box-header -->
                <div class="box-body">

                    <div class="box-group" id="accordion">
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                        <div class="panel box box-primary">
                           <?php  //echo "<pre>";
                                //print_r($categories);?>
                            @foreach($categories as $key =>  $cat)
                            <div class="box-header with-border">
                                <h6 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#{{ $cat->url_key }}">
                                       {{ $cat->categoryName->category }}
                                    </a>
                                </h6>
                            </div>
                            <div id="{{ $cat->url_key }}" class="panel-collapse collapse {{ $key == 0? 'in' : ''}}">
                                <div class="box-body">
                                    <ul>
                                          @foreach($cat->products as $prd)
                                       
                                        <li class="prod" data-prdid="{{$prd->id }}" id="prd-{{$prd->id}}"><b>{{ $prd->product }}</b>
                                            <a href="#"  class="pull-right" ui-toggle-class="" data-toggle="tooltip" title="Add Item"><i class="fa fa-plus fa-fw addItem"></i></a>
                                            <input value="" type="text" placeholder="Remarks"  name="remarks" class="input-mini pull-right remark">
                                            <input value="1" type="text" placeholder="Qty"  name="qty" class="qty input-mini pull-right">
                                            <input value="{{ $prd->selling_price * Session::get('currency_val') }}" type="hidden"  name="price" class="price">
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endforeach

                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
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
                                <button class="btn btn-primary addCustomer noLeftMargin col-md-12 noAllpadding marginBottom20">Add Customer Details</button>
                            </div>
                        </div>

                        <div id="shippedTo">

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Subtotal (Without Taxes): <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> <span class="finalSubTotal" >0</span></label>
                            </div>
                        </div>

                        @if($feature['coupon']==1)
                        <div class="col-md-12 marginBottom20">
                            <label class="col-md-3 noAllpadding control-label">Coupon: </label>
                            <div class="col-md-9 noRightpadding noLeftpadding">
                                {{ Form::select('coupon',$coupon,null,['class'=>'form-control applyCoupon']) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group coupan-amt">
                                <!-- <label>Coupon Value: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 100</label> -->
                            </div>
                        </div>
                        @endif
                        @if($feature['referral']==1)
                        <div class="col-md-12 marginBottom20">
                            <label class="col-md-3 noAllpadding control-label">Referral Code: </label>
                            <div class="col-md-9 noRightpadding noLeftpadding">
                                <input type="text" class="form-control referral-code" placeholder="Enter Referral Code" name="Referral">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group referral-amt">
                                <!-- <label>Referral Pts. Earned: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 50</label> -->
                            </div>
                        </div>
                        @endif
                        @if($feature['manual-discount']==1)
                        <div class="col-md-12 marginBottom20">
                            <label class="col-md-3 noAllpadding control-label">Discount: </label>
                            <div class="col-md-5 noRightpadding noLeftpadding">
                                <select class="form-control discount-type" name="discount-type">
                                    <option value="1">Percentage</option>
                                    <option value="2">Fixed</option>
                                </select>
                            </div>
                            <div class="col-md-3 noRightpadding noLeftpadding">
                                <input type="text" class="form-control discount-amt" placeholder="Enter Discount" name="discount-amt">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group discount-amount">
                                <!-- <label>Discount Amount: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 50</label> -->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group total-amount">
                                <!-- <label>Total(After Discount): <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 50</label> -->
                            </div>
                        </div>
                        @endif
                        @if($feature['loyalty']==1)
                        <div class="col-md-12 hide" id="loyaltyCheck">
                            <div class="form-group">
                                <label class="ui-checkbox-inline">
                                    <input type="checkbox"  class='loyaltyCheck' value=''> 
                                    <div > loyalty point <span class="lolytyPoint"></span> </div>
                                </label>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <div class="panel-group" id="accordionDemo">
                                <div class="panel panel-default">
                                    <div class="panel-heading noBackground">
                                        <h4 class="panel-title">
                                            <a href="#collapseTwo" class="accordion-toggle total-charge" data-toggle="collapse" data-parent="#accordionDemo">Taxes/Additional Charges: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?>00
                                                <i class="fa pull-right fa-angle-down" aria-hidden="true"></i></a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapseTwo">
                                        <div class="panel-body addi-charge-list">
                                            <!-- <div class="col-md-12 noAllpadding">
                                                <div class="form-group">
                                                    <label>Product Level Tax: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 90</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 noAllpadding">
                                                <div class="form-group">
                                                    <label>Service Charges (5%): <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 100</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 noAllpadding">
                                                <div class="form-group">
                                                    <label>Additional Charges: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 60</label>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group payable-amt">
                                <!-- <label>Payable Amount: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 1150</label> -->
                            </div>
                        </div>                        



                        <!--                        <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Final Amount: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 0</label>
                                                    </div>
                                                </div> -->
                        <form id="tableOrderForm" method="post">
                            <div class="col-md-12">

                                <input type="hidden" name="userId" value="" class="userId">
                                <input type="hidden" name="addressId" value="" class="addressId">
                                <input type="hidden" name="orderId" value="" class="orderId">
                                <input type="hidden" name="payamt" value="" class="payamt">
                                <input type="hidden" name="additionalcharge" value="" class="additionalcharge">

                                <div class="form-group">
                                    <div class="ui-radio ui-radio-pink">
                                        <label class="ui-radio-inline">
                                            <input type="radio"  name="radioEg" checked=""  class="codChek" onclick="getPaymentMethod()"> 
                                            <span>Cash</span>
                                        </label>
                                        <label class="ui-radio-inline">
                                            <input type="radio" name="radioEg" class="payu" onclick="getPaymentMethod()"> 
                                            <span>Card</span>
                                        </label>

                                        <label class="ui-radio-inline">
                                            <input type="radio" name="radioEg"  class="paypal" onclick="getPaymentMethod()"> 
                                            <span>Credit Card</span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn col-md-12 noAllpadding  btn-primary noLeftMargin " onclick="placeOrder()">Complete Order</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div id="transferKot" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 75%;top:40px">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Transfer KOT</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <form method="POST" action="{{route("admin.order.transferKot")}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            <input type="hidden" name="kot_id">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Table</label>
                                <div class="col-sm-10">
                                    {{ Form::select('table_id',$tables,null,['class'=>'form-control']) }}
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-primary" type="submit" value="Submit">
                    </form>  
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Model Print Invoice -->
    <div id="printInvoicce" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bord-bot0">
                    <button type="button" onClick="redirectOrderListing()" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">

                    </h4>
                </div>
                <div class="modal-body">
                    <div class="box-body invoiceData" id="printcontent">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="getAddCustomer" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Customer Details</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#basicTab" data-toggle="tab" aria-expanded="true">Basic Details</a></li>
                                <li class=""><a href="#addressTab" data-toggle="tab" aria-expanded="false">Address</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="basicTab">

                                    <div class="post clearfix">
                                        {{ Form::open(['id'=>'custInfo','class'=>'custInfo']) }}
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            {!! Form::label('Email Id', 'Phone Number',['class'=>'control-label']) !!}
                                            {!! Form::text('s_phone',null, ["autofocus" =>"autofocus","id"=>'customerEmail',"class"=>'form-control customerEmail' ,"placeholder"=>'Type Phone Number', "required","tabindex"=>1]) !!}
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group custdata" style="display: none;"> 
                                            {!! Form::label('First Name', 'First Name',['class'=>'control-label']) !!}
                                            {!! Form::text('cust_firstname',null, ["class"=>'form-control inpt']) !!}
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group custdata" style="display: none;">
                                            {!! Form::label('Last Name', 'Last Name',['class'=>'control-label']) !!}
                                            {!! Form::text('cust_lastname',null, ["class"=>'form-control inpt']) !!}  
                                        </div>
                                        {{ Form::hidden('cust_telephone',null) }}
                                        <div class="line line-dashed b-b line-lg pull-in" ></div>
                                        <div class="form-group custdata" style="display: none;">
                                            {!! Form::label('Email Id', 'Email Id',['class'=>'control-label']) !!}
                                            {!! Form::email('email_id',null, ["class"=>'form-control inpt']) !!}
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        {{ Form::hidden("customer_id",null,['class'=>'inpt userId']) }}
                                        <div class="form-group col-sm-12 noallMargin noallpadding">
                                            <div class="custdata pull-right" style="display: none;">
                                                {!! Form::button('Next<i class="fa fa-spinner custDetailsS"></i>',["class" => "btn btn-primary custDetailsNext"]) !!}  
                                            </div>    
                                            <button class="btn btn-black cancelBtn pull-right">Cancel</button>
                                        </div>
                                        {{ Form::close() }}


                                    </div>

                                </div>

                                <div class="tab-pane" id="addressTab">
                                    <div class="post clearfix">
                                        <div  class="col-md-12 noallMargin noallpadding">
                                            {!! Form::open(['id'=>'custAddForm']) !!}
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    {!! Form::label('First Name', 'First Name' ,['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                                    {!! Form::text('firstname',null, ["class"=>'form-control inptAdd','required', 'placeholder'=>'First Name']) !!}
                                                </div>
                                                <div class="col-md-6">
                                                    {!! Form::label('Last Name', 'Last Name',['class'=>'control-label']) !!}
                                                    {!! Form::text('lastname',null, ["class"=>'form-control inptAdd','placeholder'=>'Last Name']) !!}
                                                </div> 
                                            </div>
                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    {!! Form::label('Address Line 1', 'Address Line 1 ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                                    {!! Form::text('address1',null, ["class"=>'form-control inptAdd','required'=>'true','placeholder'=>'Address Line 1']) !!}
                                                </div>
                                                <div class="col-md-6">
                                                    {!! Form::label('Address Line 2', 'Address Line 2 ',['class'=>'control-label']) !!}
                                                    {!! Form::text('address2',null, ["class"=>'form-control inptAdd','placeholder'=>'Address Line 2']) !!}
                                                </div>
                                            </div>
                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    {!! Form::label('Address Line 3', 'Address Line 3',['class'=>'control-label']) !!}
                                                    {!! Form::text('address3',null, ["class"=>'form-control inptAdd','placeholder'=>'Address Line 3']) !!}
                                                </div>
                                                <div class="col-md-6">
                                                    {!! Form::label('City', 'City ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                                    {!! Form::text('city',null,["class"=>'form-control inptAdd','required'=>'true','placeholder'=>'City']) !!}
                                                </div>
                                            </div>
                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    {!! Form::label('Pin Code', 'Pin Code ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                                    {!! Form::text('postcode',null,["class"=>'form-control inptAdd','required'=>'true','placeholder'=>'Pin Code']) !!}
                                                </div>

                                                <div class="col-md-6">
                                                    {!! Form::label('Country', 'Country ',['class'=>'control-label']) !!}
                                                    {!! Form::select('country_id',$ordcountries,null ,["class"=>'form-control country inptAdd']) !!}
                                                </div>
                                            </div>
                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    {!! Form::label('State', 'State/Zone ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                                    {!! Form::select('zone_id',$ordstates,null ,["class"=>'form-control inptAdd','required'=>'true','id'=>'state','placeholder'=>'Address Line 3']) !!}
                                                </div>

                                                <div class="col-md-6">
                                                    {!! Form::label('Telephone', 'Phone Number ',['class'=>'control-label']) !!}
                                                    {!! Form::text('phone_no',null,["class"=>'form-control inptAdd','placeholder'=>'Contact Number']) !!}
                                                </div>
                                            </div>
                                            <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="form-group noallMargin noallpadding">
                                                <button class="btn btn-black addBack noLeftMargin">Back</button>
                                                <button class="btn btn-black cancelBtn">Cancel</button>
                                                {!! Form::submit('Submit',["class" => "btn btn-primary NextAdd"]) !!}                              
                                            </div>
                                            {{ Form::hidden('address_id',null) }}
                                            {{ Form::hidden('user_id',null) }}
                                            {{ Form::close() }}
                                        </div>
                                        <div  class="col-md-6 addressDiv pull-right"> </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>



<div id="anyRemark" class="modal fade in" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bord-bot0">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title text-left">
                        Any Remark
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="">
                        <textarea class="form-control height-auto" rows="3"></textarea> 
                    </form>
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

    function getAdd(addid) {
        addData = addid
        $.post("{{ route('admin.orders.getCustomerAdd') }}", {addData: addData}, function (data) {
            $.each(data, function (addk, addv) {
                $("input[name='" + addk + "']").val("");

                $("input[name='" + addk + "']").val(addv);

                if (addk == 'country_id' || addk == 'zone_id') {
                    $("select[name='" + addk + "']").val("");
                    $("select[name='" + addk + "']").val(addv);
                }
                if (addk == 'id')
                    $("input[name='address_id']").val(addv);
            });
        });
    }

    $(".cancelBtn").on("click", function () {
        $("#getAddCustomer").modal("hide");
        // window.location.href = "{{ route('admin.order.additems',['id'=><?= request()->route('id'); ?>]) }}";
    });

    $(".custDetailsS").hide();
    jQuery.validator.addMethod("phonevalidate", function (telephone, element) {
        telephone = telephone.replace(/\s+/g, "");
        return this.optional(element) || telephone.length > 9 &&
                telephone.match(/^[\d\-\+\s/\,]+$/);
    }, "Please specify a valid phone number");
    $(".placeorderSpinner").hide();
    $(document).ready(function () {

        $(".sidebar-toggle").click();
    });
    $("input[name='orderId']").val(<?= $order->id; ?>);
    getOrderKotWithProds(<?= $order->id; ?>);
    function getOrderKotWithProds(orderid) {
       // alert(orderid);
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

    $(".addItem").click(function () {
        $("#saveItem").show();
        var prodList = $(this).parents('li').attr('id').split('-');
        var prodId = prodList[1];
        prodid = $(this).parents('li').attr('data-prdid')
        var prod = $(this).parents('li').find('b').text();
        var remark = $(this).parents('li').find('.remark').val();
        //alert("remark val::"+remark);
        var qty = $(this).parents('li').find('.qty').val();
        var itemPrice = $(this).parents('li').find('.price').val();
        //console.log("itemprice::"+itemPrice);
        var totalPrice = itemPrice * qty;
        totalPrice = totalPrice.toFixed(2);
        //console.log("<br>total price::"+totalPrice);
        trClassName = 'row-' + prodid;
        if ($("table.tableVaglignMiddle").find("tr").hasClass(trClassName)) {
            addQty = $("table.tableVaglignMiddle").find("." + trClassName).find(".qty").val();
            addPrice = $("table.tableVaglignMiddle").find("." + trClassName).find(".price").val();
            addRemark = $("table.tableVaglignMiddle").find("." + trClassName).find(".remark").val();

            remarK = addRemark + " " + remark;
            qtY = parseInt(addQty) + parseInt(qty);
            //alert("if remark val::"+remark);
            itemp = addPrice;
            totalItemP = qtY * addPrice;
            totalItemP = totalItemP.toFixed(2);


            var addrow = '<tr class="newRow row-' + prodid + '"><td>' + prod + '</td><td>' + remarK + '</td><td>' + qtY + '</td>' +
                    '<td>' + itemp.toFixed(2) + '<input type="hidden" class="price" name="orderdata[' + prodid + '][price]" value="' + itemp.toFixed(2) + '"> </td><td>' + totalItemP + '</td>' +
                    '<input type="hidden" class="qty" name="orderdata[' + prodid + '][qty]" value="' + qtY + '">' +
                    '<input type="hidden" class="remark" name="orderdata[' + prodid + '][remark]" value="' + remarK + '"><td><i class="fa fa-trash fa-fw deleteItem" style="color:red;cursor:pointer;"></i></td>' +
                    '</tr>';


            $("table.tableVaglignMiddle").find("." + trClassName).replaceWith(addrow);

        } else {
            //alert("else remark val::"+remark);
            var row = '<tr class="newRow row-' + prodid + '"><td>' + prod + '</td><td>' + remark + '</td><td>' + qty + '</td>' +
                    '<td>' + parseFloat(itemPrice).toFixed(2) + '<input type="hidden" class="price" name="orderdata[' + prodid + '][price]" value="' + parseFloat(itemPrice).toFixed(2) + '"> </td><td>' + parseFloat(totalPrice).toFixed(2) + '</td>' +
                    '<input type="hidden" class="qty" name="orderdata[' + prodid + '][qty]" value="' + qty + '">' +
                    '<input type="hidden" class="remark" name="orderdata[' + prodid + '][remark]" value="' + remark + '"><td><i class="fa fa-trash fa-fw deleteItem" style="color:red;cuser;cursor:pointer;"></i></td>' +
                    '</tr>';
            $("table.tableVaglignMiddle").append(row);
        }

    });

    $("#saveItem").click(function () {
        $("input[name='orderId']").val($("input[name='order_id']").val());
        $.ajax({
            url: "{{ route('admin.order.saveitems') }}",
            type: 'POST',
            data: $("#order-addItem").serialize(),
            cache: false,
            success: function (kotdata) {
                console.log(JSON.stringify(kotdata));
                getOrderKotWithProds(kotdata.order_id);
            }
        });
    });

    $("#order-addItem").delegate(".deleteItem", "click", function () {
        chkconfirm = confirm("Are you really want delete this product?");

        if (chkconfirm) {
            $(this).parent().parent().remove();
        }

        if ($("table.tableVaglignMiddle").find("tr").hasClass("newRow") == false)
            $("#saveItem").hide();
    });

    $("#order-addItem").delegate(".transferKOT", "click", function () {
        kotid = $(this).attr('data-kotid');
        $("input[name='kot_id']").val(kotid);
        $("#transferKot").modal("show");

    });
    $("#order-addItem").delegate(".deleteExistingItem", "click", function () {
        //   alert("sdfsdf");
        hasprdid = $(this).attr('data-hasprdid');
        chkconfirm = confirm("Are you really want delete this product?");

        if (chkconfirm) {
            $.post("{{route('admin.order.deleteKotProds')}}", {hasprdid: hasprdid}, function (deletedprd) {
                if (deletedprd) {
                    getOrderKotWithProds(deletedprd);
                    //$(this).parent().parent().remove();
                    // window.location.reload();
                }
            });
        } else {
            return false;
        }
    });

    $(".addCustomer").on("click", function () {
        $("#getAddCustomer").modal("show");
    });

    $("#customerEmail").autocomplete({
        source: "{{ route('admin.orders.getCustomerEmails') }}",
        minLength: 1,
        appendTo: $("#getAddCustomer"),
        select: function (event, ui) {
            ele = event.target;
            setValuesToInpt(ui.item.id, ui.item.firstname, ui.item.lastname, ui.item.telephone, ui.item.email);
            $(".custdata").show();

        }
    });
//
    $(".customerEmail").on("keyup", function () {
        $(".custdata").show();
    });
    $(".customerEmail").on("change", function () {
        $(".custdata").show();
        term = $(this).val();
        thisEle = $(this);
        thisEle.css("border-color", "");
        thisEle.closest("p").remove();
        $.post("{{route('admin.orders.getCustomerEmails') }}", {term: term}, function (res) {
            resp = JSON.parse(res);
            chkLengh = Object.keys(resp).length;
            if (chkLengh == 1) {
                setValuesToInpt(resp[0].id, resp[0].firstname, resp[0].lastname, resp[0].telephone, resp[0].email);
            } else if (chkLengh == 0) {
                $(".inpt").removeAttr('readonly');
                $(".inpt").val('');
                phonev = $("input[name='s_phone']").val();
                $("input[name='cust_telephone']").val(phonev);
            }

        });

    });
//
    function setValuesToInpt(custid, firstname, lastname, telephone, emailid) {
        $("input[name='s_phone']").val(telephone);
        $("input[name='customer_id']").val(custid);
        $("input[name='cust_firstname']").val(firstname);
        $("input[name='cust_lastname']").val(lastname);
        $("input[name='cust_telephone']").val(telephone);
        $("input[name='email_id']").val(emailid);
        $(".customerEmail").css("border-color", "");
        $(".inpt").prop('readonly', false);
    }
    $("#custInfo").validate({
        // Specify the validation rules
        rules: {
            s_phone: {required: true,
                phonevalidate: true},
            cust_telephone: {required: true,
                phonevalidate: true}
        },
        // Specify the validation error messages
        messages: {
            s_phone: {
                required: "Telephone is required"
            },
            cust_telephone: {
                required: "Telephone is required"
            }
        },
        errorPlacement: function (error, element) {
            $(element).after(error);
        }
    });

    $(".custDetailsNext").on("click", function () {
        if ($("#custInfo").valid()) {
            $(".custDetailsS").show();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.getCustomerData') }}",
                data: $(".custInfo").serialize(),
                cache: false,
                success: function (data) {
                    $(".fa-spinner").hide();
                    if (data.id != '') {
                        $('#loyaltyCheck').removeClass('hide');
                        $(".lolytyPoint").html(data.cashback);
                        $(".loyaltyCheck").val(data.cashback);
                        // alert(data.cashback);
                    }
                    $("input[name='customer_id']").val(data.id);
                    $("input[name='user_id']").val(data.id);
                    $("input[name='firstname']").val(data.firstname);
                    $("input[name='lastname']").val(data.lastname);
                    $("input[name='phone_no']").val(data.telephone);
                    $("input[name='userId']").val(data.id);


                    address = data.addresses;

                    addDiv = "";
                    $.each(address, function (addk, addv) {
                        addData = JSON.stringify(addv);
                        addDiv += "<div class='col-md-6'><div class='box addressColumn paddingAll10'>";
                        addDiv += "<input data-add='" + addv.id + "' id='opt_" + addv.id + "'  class='addRadio pull-left marginright10' type='radio' value='" + addv.id + "' name='addRedioBut' >";
                        addDiv += "<div data-adddiv='" + addv.id + "' class='appendedAddDiv'  style='cursor:pointer;'><p>" + addv.firstname + " " + addv.lastname + "</p>";
                        addDiv += "<p>" + addv.address1 + " " + addv.address2 + " " + addv.address3 + "</p>";
                        addDiv += "<p>" + addv.city + " - " + addv.postcode + "</p>";
                        addDiv += "<p>" + addv.statename + "</p>";
                        addDiv += "<p>" + addv.countryname + "</p>";
                        addDiv += "<p> Contact Number: " + addv.phone_no + "</p>";
                        addDiv += "</div></div></div>";
                    });
                    $(".addressDiv").html(addDiv);
                    // $("input[type='radio']:first").trigger('click');
                    $("#addressTab input[type='radio']:first").trigger('click');
                    $('.nav-tabs a[href="#addressTab"]').tab('show');
                    $('.nav-tabs a[href="#basicTab"]').removeAttr('data-toggle');

                }
            });
        }
    });

    $(".addressDiv").delegate(".appendedAddDiv", "click", function (e) {
        att = $(this).attr('data-adddiv');
        $('#opt_' + att).prop('checked', true);
        $("input[name='addressId']").val(att);
        getAdd(att);
    });
    $(".addressDiv").delegate(".addRadio", "click", function () {
        var addData = $(this).attr('data-add');

        getAdd(addData);
    });
    $(".country").on("change", function () {
        countryid = $(this).val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin.orders.getCustomerZone') }}",
            data: {countryid: countryid},
            cache: false,
            success: function (data) {
                $("#state").html(data);
            }
        });
    });

    $("#custAddForm").validate({
        // Specify the validation rules
        rules: {
            firstname: "required",
            country_id: "required",
            zone_id: "required",
            address1: "required",
            address2: "required",
            postcode: {required: true,
                number: true
            },
            city: "required",
            phone_no: {
                required: true,
                phonevalidate: true,
            }
        },
        // Specify the validation error messages
        messages: {
            firstname: "First Name is required.",
            country_id: "Country is required.",
            zone_id: "State is required.",
            address1: "Address Line 1 is required.",
            address2: "Address Line 2 is required.",
            postcode: {
                required: "Pin Code is required.",
                number: "Valid pin Code is required"
            },
            city: "City is required.",
            phone_no: {
                required: "Phone number is required.",
            }
        },
        submitHandler: function (form) {
            $.post("{{ route('admin.orders.saveCustomerAdd') }}", $("#custAddForm").serialize(), function (res) {
                if (res !== 0) {
                    $("input[name=addressId]").val(res.addressid);
                    $("input[name=userid]").val(res.userid);
                    addData = $("input[name='address_id']").val();
                    data = res.myadd;
                    htmlAdd = "";
                    htmlAdd += '<div class="col-md-12"><div class="form-group"><label>' + data.firstname + ' ' + data.lastname + ' (' + data.phone_no + ')</label></div></div>';
                    htmlAdd += '<div class="col-md-12"><div class="form-group"><label>' + data.address1 + ',' + data.address2 + '<br/>' + data.city + ',' + data.statename + ' ' + data.postcode + '</label></div></div>';
                    console.log(htmlAdd);
                    $("#getAddCustomer").modal("hide");
                    $("#shippedTo").html(htmlAdd);

                }
            });
        },
        errorPlacement: function (error, element) {
            $(element).after(error);
        }
    });
    $(".inptAdd").on('change', function () {
        $("input[name='address_id']").val("");
    });

    $(".addBack").on("click", function (e) {
        e.preventDefault();
        $('.nav-tabs a[href="#basicTab"]').tab('show');
        $('.nav-tabs a[href="#addressTab"]').removeAttr('data-toggle');
    });


    $(".applyCoupon").change(function () {
        var couponCode = $(".applyCoupon").val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin.tables.checkCoupon') }}",
            data: {couponCode: couponCode},
            dataType: "json",
            cache: false,
            success: function (msg) {
                console.log(msg);

                if (msg.remove == 1) {
                    $('.coupan-amt').html("<label style='color:red'>Invalid Coupon!</label>");
                } else {
                    $('.coupan-amt').html("<label>Coupon Value: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> <span id='coupon_value'>" + msg.disc.toFixed(2) + "</span></label>");
                }
                $(".total-amount").html("<label>Total(After Discount): <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> " + msg.orderAmount.toFixed(2) + "</label>");
                getAdditionalcharge();
            }

        });
    });
    $(".referral-code").blur(function () {
        var RefCode = $(".referral-code").val();
        $.ajax({
            url: "{{ route('admin.orders.applyReferel')}}",
            type: 'POST',
            data: {RefCode: RefCode},
            cache: false,
            success: function (data) {

                if (data.referalCodeAmt != null && data.referalCodeAmt != 0) {
                    $(".referral-amt").html("<label>Referral Pts. Earned: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> " + data.referalCodeAmt.toFixed(2) + "</label>");
                } else {
                    $(".referral-amt").html("<label style='color:red'>Invalid Referral Code!</label>");
                }
                $(".total-amount").html("<label>Total(After Discount): <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> " + data.orderAmount.toFixed(2) + "</label>");
                getAdditionalcharge();
            }
        });
    });

    $(".discount-amt").blur(function () {
        var discVal = $(".discount-amt").val();
        var discType = $('.discount-type option:selected').val();
        $.ajax({
            url: "{{ route('admin.orders.applyUserLevelDisc') }}",
            type: 'POST',
            data: {discType: discType, discVal: discVal},
            cache: false,
            success: function (data) {
                if (data.discAmt != null && data.discAmt != 0) {
                    $(".discount-amount").html("<label>Discount Amount: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?>" + data.discAmt.toFixed(2) + "</label>");
                } else {
                    $(".discount-amount").html("<label></label>");
                }

                $(".total-amount").html("<label>Total(After Discount): <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> " + data.orderAmount.toFixed(2) + "</label>");
                getAdditionalcharge();
            }
        });
    });
    $(function () {
        getAdditionalcharge();
        getPaymentMethod();

    });
    function getAdditionalcharge() {

        var total_amt = 0;
        var total_price = 0;
        var addi_charge_with_price = 0
        $.ajax({
            url: "{{ route('admin.tables.getAdditionalcharge') }}",
            type: 'POST',
            cache: false,
            success: function (msg) {

                var data = JSON.parse(msg.additionalCharge);
                // alert(JSON.stringify(msg));
                $(".addi-charge-list").empty();
                if (!isEmpty(data)) {
                    $.each(data, function (i, v) {
                        if (i == 'details') {
                            $.each(v, function (j, w) {
                                var rate = '';
                                if (w.type == 2) {
                                    var rate = '(' + w.rate + '%)';
                                }
                                var charges = '<div class="col-md-12 noAllpadding"><div class="form-group"><input data-id="' + w.id + '" type="checkbox" name="addtionalCharge" value="' + w.applied + '" checked class="checkboxCheck"/><label>' + w.label + '</label> <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> ' + (w.applied * <?php echo Session::get('currency_val'); ?>).toFixed(2) + '</div>' +
                                        '</div>'
                                $(".addi-charge-list").append(charges);
                            })
                        }
                        if (i == 'total_amt') {

                            total_amt = (v * <?php echo Session::get('currency_val'); ?>).toFixed(2);
                        }
                        if (i == 'total_with_price') {
                            addi_charge_with_price = v;

                        }
                        if (i == 'total') {
                            total_price = v;
                        }
                    });
                    $(".total-charge").html('Taxes/Additional Charges: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> <span class="additionalTotal"> ' + total_amt + '</span><i class="fa pull-right fa-angle-down" aria-hidden="true"></i>');
                }

                var couponVal = $("#coupon_value").text();
                var getTotalAmount = $("#final_total_amount").val();
                var finalAmt = ''
                if(couponVal != '')
                {
                    finalAmt = (getTotalAmount - couponVal);
                }
                else
                {
                    finalAmt = getTotalAmount;
                }
                $(".payable-amt").html('<label>Payable Amount: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> <span class="payAmount" >' + finalAmt + '</span></label><input type="hidden" name="payAmount" value="' + finalAmt + '">');
                //$(".payable-amt").html('<label>Payable Amount: <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> <span class="payAmount" >' + addi_charge_with_price + '</span></label><input type="hidden" name="payAmount" value="' + total_price + '">');
                $('input[name="payamt"]').val($('input[name="payAmount"]').val());
                $('input[name="payamt"]').val($('.payAmount').text());
                //   alert(parseInt($('.payAmount').text()));
            }
        });

    }

    // to check is object empty
    function isEmpty(obj) {
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop))
                return false;
        }

        return true;
    }
    $(document).ready(function () {
        $(document).on('change', '.checkboxCheck', function (e) {
            var charge = $(this).val();
            var addtional = $('.additionalTotal').text();
            var payamt = $('input[name="payAmount"]').val();
            if ($(this).is(':checked')) {
                var add = parseInt(addtional) + parseInt(charge);
                $('.additionalTotal').html(add);
                $('.payAmount').html(addCommas((parseInt(payamt) + parseInt($(this).val())).toFixed(2)));
                $('input[name="payAmount"]').val(parseInt(payamt) + parseInt($(this).val()));
            } else {
                var add = parseInt(addtional) - parseInt(charge);
                 $('.additionalTotal').html(add);
                $('.payAmount').html(addCommas((parseInt(payamt) - parseInt($(this).val())).toFixed(2)));
                $('input[name="payAmount"]').val(parseInt(payamt) - parseInt($(this).val()));
            }
        });

    });

    $(document).on('change', '.loyaltyCheck', function (e) {
        var charge = $(this).val();
        var user_id = $('.userId').val();
        //   alert(user_id);
        var orderAmt = parseInt($('.payAmount').text());
        if ($(this).is(':checked')) {

            $.ajax({
                url: "{{ route('admin.tables.reqloyalty') }}",
                type: 'POST',
                data: {user_id: user_id, orderAmt: orderAmt},
                cache: false,
                success: function (msg) {
                    $('.lolytyPoint').text(msg.cashbackremaining.toFixed(2));
                    $(".loyaltyCheck").val(msg.cashbackremaining.toFixed(2));
                    getAdditionalcharge();
                    // alert(JSON.stringify(msg));
                }
            });

        } else {
            $.ajax({
                url: "{{ route('admin.tables.revloyalty') }}",
                type: 'POST',
                data: {user_id: user_id, orderAmt: orderAmt},
                cache: false,
                success: function (msg) {

                    // alert(msg)
                    $('.lolytyPoint').text(parseInt(msg));
                    $(".loyaltyCheck").val(parseInt(msg));
                    getAdditionalcharge();
                    //  getAdditionalcharge();
                    // alert(JSON.stringify(msg));
                }
            });
        }

    });

    function getPaymentMethod() {

        if ($(".codChek").is(':checked')) {
            var route = "{{ route('admin.tables.tableCod')}}";
            $("#tableOrderForm").attr("action", route);


        } else if ($(".payu").is(':checked')) {
            var route = "#";
            $("#tableOrderForm").attr("action", route);
        } else if ($(".paypal").is(':checked')) {
            var route = "#";
            $("#tableOrderForm").attr("action", route);
        } else {
            var route = "{{ route('admin.tables.tableCod')}}";
            $("#tableOrderForm").attr("action", route);

        }



    }

    function placeOrder() {
      
        var sThisVal=new Array();
        $('input:checkbox.checkboxCheck').each(function () {
            if(this.checked){
            sThisVal.push($(this).attr("data-id"));
            }
       
        });
  //console.log("<br>table order firm action::"+$("#tableOrderForm").attr('action'));
   $("input[name='additionalcharge']").val(sThisVal);
  
        $.ajax({
            type: "POST",
            url: $("#tableOrderForm").attr('action'),
            data: $("#tableOrderForm").serialize(),
            cache: false,
            success: function (data) {
               //console.log(JSON.stringify(data));
        var tableId=data.orders.table_id?data.orders.table_id:'#';
    var subtotal=0;
    var userDisc=0;
    //if(data.contact.address1){
    if(data.address1){
               var table = "<div><table id='DivIdToPrint' class='invocieBill-table' style='width: 400px;margin: 0 auto;'>";
           }else{
                var table = "<table  id='DivIdToPrint' class='invocieBill-table'  style='width: 400px;margin: 0 auto;'><tr class='double-dashed-border'> <td colspan='4' class='text-center'> <div class='shop-logo'><img src='{{ Config('constants.adminImgangePath') }}/shop-logos/{{'btown-logo.png'}}' alt='shop-logo'/></div> <span class='shopname'>"+data.storeName+"</span><br/><span class='shopaddress'>"+data.orders.address1+" "+data.orders.address2+" "+data.orders.address3+"</span><br><span class='shopnumber'>"+data.orders.phone_no+"</span></td></tr><tr class='double-dashed-border'> <td colspan='2' class='text-left'>Dine In<br>Table No: 329<br>Server: Krista 11:59 AM</td> <td colspan='2' class='text-right'>1 (Packs)<br>Bill No: 4002<br>Date 002/26/14</td></tr>";
            }
               
                table = table + "<tr  style='padding-bottom: 10px !important;padding-top: 10px !important;'><th class='text-left pl10'>Product </th><th class='text-left'>Price</th><th class='text-left'>Qty </th><th class='text-right'>Total</th>";
                $.each(jQuery.parseJSON(data.orders.cart), function (cartk, cartv) {
                    //console.log("cartk ::"+JSON.stringify(cartk));
                    //console.log("<br> cartv ::"+JSON.stringify(cartv));
                    subtotal=subtotal+parseInt(cartv.subtotal);
                    //alert("sub total::"+subtotal);
                    userDisc=userDisc+parseInt(cartv.options.user_disc);
                    table = table + "<tr  style='padding-bottom: 10px !important;padding-top: 10px !important;'><td class='text-left pl10'>" + cartv.name + "</td><td class='text-left'>" + cartv.price + "</td><td>" + cartv.qty + "</td><td class='text-right'>" + cartv.subtotal + "</td></tr>";

                });
                table = table + "<tr   style='padding-bottom: 10px !important;padding-top: 10px !important;' class='double-dashed-top-border'><td>&nbsp;</td><td>&nbsp;</td><td class='text-left sbtot'>Subtotal</td><td class='text-right sbtot'>"+subtotal+"</td></tr>";
                if(data.orders.coupon_amt_used){
                 table = table + "<tr   style='padding-bottom: 10px !important;padding-top: 10px !important;' class=''><td>&nbsp;</td><td>&nbsp;</td> <td class='text-left sbtot'>Coupon (" +data.orders.couponCode+ ")</td><td class='text-right sbtot'>"+data.orders.coupon_amt_used+"</td></tr>";
             } 
              if(data.orders.cashback_used){
                table = table + " <tr class=''><td>&nbsp;</td><td>&nbsp;</td><td class='text-left sbtot'>Cashback</td><td class='text-right sbtot'>"+data.orders.cashback_used+"</td></tr>";   
              }
               if(userDisc){
                table = table + " <tr class=''><td>&nbsp;</td><td>&nbsp;</td><td class='text-left sbtot'>User disc</td><td class='text-right sbtot'>"+userDisc+"</td></tr>";   
              }
               if(data.orders.referal_code_amt){
                table = table + " <tr  style='padding-bottom: 10px !important;padding-top: 10px !important;' class=''><td>&nbsp;</td><td>&nbsp;</td><td class='text-left sbtot'>Referal Amt</td><td class='text-right sbtot'>"+data.orders.referal_code_amt+"</td></tr>";   
              }
              var additional=jQuery.parseJSON(data.orders.additional_charge);
              console.log(JSON.stringify(additional));
               $.each((additional.details), function (chargek, chargev) {
                if(chargev.rate){
                    table = table + " <tr  style='padding-bottom: 10px !important;padding-top: 10px !important;' class=''><td>&nbsp;</td><td>&nbsp;</td><td class='text-left sbtot'>"+chargev.label+"</td><td class='text-right sbtot'>"+chargev.applied+"</td></tr>";
                }
             });
         table = table + "<tr  style='padding-bottom: 10px !important;padding-top: 10px !important;'r class='double-dashed-border'><td>&nbsp;</td><td>&nbsp;</td><td class='text-left grtot double-dashed-top-border'>Grand Total</td><td class='text-right grtot double-dashed-top-border'>"+data.orders.order_amt+"</td></tr><tr><td colspan='4' class='text-center'>Thank You</td></tr></table> </div><br/><div class='clearfix' style='width: 400px;margin: 0 auto; text-right'><button class='btn btn-primary addCustomer noLeftMargin col-md-12 noAllpadding marginBottom20 pull-right' onclick='getprint()'>Print Bill</button></div>";
              
    //console.log('==' + JSON.stringify(table));
                $("#printInvoicce").modal("show");
                $(".invoiceData").html(table);
                //$('.complete-order').text('Complete Order');
                changeOccupancyStatus();
            }
            // $("#tableOrderForm").attr("action",route);
        });
    }
    
    function changeOccupancyStatus() {
        var orderId = $('input[name=order_id]').val();
        $.ajax({
            type: "POST",
            url: "{{route('admin.tables.changeOccupancyStatus')}}/1",
            data: {orderId: orderId},
            cache: false,
            success: function (data) {
                // window.location.href = "{{route('admin.tableorder.view')}}";
            }
        });
    }
    
     function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function redirectOrderListing()
    {
        localStorage.setItem('orderCompleted', 1);
        window.location.href = "{{ route('admin.tableorder.view')}}"
    }
    
    function getprint(){
     // window.print();
      var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);
    }
</script>
@stop