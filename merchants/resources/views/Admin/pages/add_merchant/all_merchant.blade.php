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
                   
                    <form  method="get" id="merchantCodeForm">
                        <div class="form-group col-md-8 col-sm-6 col-xs-12" id="inputDiv">
                            <input type="text" name="merchant_search_keyword" id="merchant_search_keyword" value="" onkeypress="hideErrorMsg('errorLbl')" class="form-control medium pull-right " placeholder="Enter Merchant Business name or Phone number">
                            <label class="error" id="errorLbl" style="color:red"></label>
                        </div>
                        
                        <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <button id="searchMerchant" class="btn btn-primary fullWidth noAll-margin" style="margin-left: 0px;">Search</button>
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
                            <th class="text-right">Total Order Amt</th>
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

                        ?>
                        <tr>  
                            <td class="text-left">{{ $merchantBusinessName }}</td>
                            <td class="text-center">{{ $merchantPhoneNum }}</td>
                            <td class="text-right">{{ $merchantTotalOrderCnt }}</td>
                            <td class="text-right">{{ $merchantTotalOrderAmt }}</td>
                        </tr>
                        @endforeach
                        @else
                            <tr colspan="6">
                                <td> No records found.</td>
                            </tr>
                        @endif 
                    </tbody>
                </table>
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
        var hdnStoreId = $("#hdnStoreId").val();

        if(searchKeyword != '')
        {
            /*if(identityCode.length > 9)
            {
                $.ajax({
                    method: "POST",
                    data: {'merchantIdentityCode': identityCode,'hdnStoreId':hdnStoreId},
                    url: "{{route('admin.vendors.verifyCode')}}",
                    dataType: "json",
                    success: function (data) {
                        
                        if(data['status'] != 1)
                        {
                            $("#errorLbl").show();
                            $("#errorLbl").html(data['error']).show().fadeOut(4000);
                            $("#merchantDetailDiv").hide();
                        }
                        else
                        {
                            var resgisterDetail = data['merchantData']['register_details'];
                            var parsedRegistrationDtaa = JSON.parse(resgisterDetail);

                            $("#storeName").html(parsedRegistrationDtaa['store_name']);
                            $("#firstname").html(parsedRegistrationDtaa['firstname']);
                            $("#email").html(parsedRegistrationDtaa['email']);
                            $("#phone").html(parsedRegistrationDtaa['phone']);
                            $("#businessName").html(parsedRegistrationDtaa['business_name']);
                            $("#hdnMerchantEmail").val(data['merchantData']['email']);
                            $("#hdnMerchantPhone").val(data['merchantData']['phone']);
                            $("#hdnMerchantId").val(data['merchantId']);
                            $("#hdnCountryCode").val(data['merchantData']['country_code']);
                            $("#hdnStoreIdForNotification").val(hdnStoreId);
                            $("#merchantDetailDiv").show();
                        }
                        return false;
                        // location.reload();courier-services
                    }
                });
                return false;
            }
            else
            {
                $("#errorLbl").html("Enter valid code").show().fadeOut(4000);
                return false;
            }*/
        }
        else
        {
            $("#errorLbl").html("Enter merchant Business Name or Phone Number").show().fadeOut(4000);
            return false;
        }
    });

    function hideErrorMsg(id)
    {
        $("#"+id).hide();
    }
</script>
@stop 