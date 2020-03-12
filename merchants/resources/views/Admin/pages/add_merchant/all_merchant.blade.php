@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css"> 
@stop

@section('content')
<section class="content-header">
    <h1>
        All Merchants 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Merchants</a></li>
        <li class="active">All Merchants</li>
    </ol>
</section>
<section class="main-content"> 
    <div class="notification-column">
        <div class="alert alert-danger" role="alert" id="errorMsgDiv" style="display: none;"></div>
        <div class="alert alert-success" role="alert" id="successMsgDiv" style="display: none;"></div> 
        <label class="error" id="sendRequestErorr">{{$sendRequestError}}</label>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section">

            <div class="col-md-12 noAll-padding">
                <div class="filter-left-section">
                   
                    <form  method="post" id="merchantCodeForm">
                        <div class="form-group col-md-8 col-sm-6 col-xs-12" id="inputDiv">
                            <input type="text" value="{{ !empty(Input::get('merchant_search_keyword'))?Input::get('merchant_search_keyword'):'' }}" name="merchant_search_keyword" id="merchant_search_keyword" onkeypress="hideErrorMsg('errorLbl')" class="form-control medium pull-right " placeholder="Enter Merchant Business name or Phone number">
                            <label class="error" id="errorLbl" style="color:red"></label>
                        </div>
                        
                        <div class="form-group col-md-4 noBottomMargin">
                            <a href="{{ route('admin.vendors.allMerchant')}}" class="btn reset-btn noMob-leftmargin pull-right">Reset </a> 
                            <button type="submit" id="searchMerchant" name="submit" vlaue="Filter" class='btn btn-primary noAll-margin pull-right marginRight-lg'>Filter</button> 
                        </div>
                        <input type="hidden" id="hdnStoreId" name="hdnStoreId" value="">
                    </form>
                </div>
            </div>
         
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> All Merchant</h1>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr> 
                            <th class="text-left">Business Name</th> 
                            <th class="text-center">Mobile</th>
                            <th class="text-center">Total No. of Orders</th>
                            <th class="text-center">Total Order Amt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($merchantListingData))
                        <?php
                        $i = 0;
                        ?>
                        @foreach($merchantListingData as $data)
                        <?php
                            $i++;
                            $merchantBusinessName = ucwords($data['business_name']);
                            $merchantPhoneNum = $data['phone_number'];
                            $merchantTotalOrderCnt = $data['order_count'];
                            $merchantTotalOrderAmt = $data['total_order_amt'];
                            $getMerchantStoreId = $data['merchant_store_id'];
                        ?>
                        <tr>  
                            <td class="text-left">{{ $merchantBusinessName }}</td>
                            <td class="text-center">{{ $merchantPhoneNum }}</td>
                            <?php if($merchantTotalOrderCnt > 0)
                            {
                            ?>
                            <td class="text-center"><a href="{{ URL::route('admin.orders.view',['id'=>"$getMerchantStoreId"]) }}">{{ $merchantTotalOrderCnt }}</a></td>
                            <?php
                            }
                            else
                            {?>
                             <td class="text-center">{{ $merchantTotalOrderCnt }}</td>   
                            <?php 
                            }
                            ?>
                            
                            <td class="text-center">{{ $merchantTotalOrderAmt }}</td>
                        </tr>
                        @endforeach
                        @else
                            <tr colspan="6">
                                <td> No records found.</td>
                            </tr>
                        @endif 
                    </tbody>
                </table>
                <div class="clearfix">
                   
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>

@stop

@section('myscripts')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
$("#searchMerchant").on("click", function () 
    {
        var searchKeyword = $("#merchant_search_keyword").val();
        
        if(searchKeyword != '')
        {   
            $("#merchantCodeForm").submit();
        }
        else
        {
            //$("#errorLbl").html("Enter merchant Business Name or Phone Number").show().fadeOut(4000);
            $("#errorLbl").html("Enter merchant Business Name or Phone Number");
            return false;
        }
    });

    function hideErrorMsg(id)
    {
        $("#"+id).hide();
    }

    
</script>
@stop 