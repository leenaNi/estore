@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker-bs3.css') }}">
@stop

@section('content')
<style>
.successMsgDiv{
    color:green;
}
div#merchantDetailDiv .info-box {
    padding: 15px;
    border: 1px solid #f2f2f2;
    border-radius: 4px;
    box-shadow: none;
}
    </style>
<section class="content-header">
    <h1>
        Add Merchant
    </h1>
    <ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-dashboard"></i> Merchants</a></li>
        <li class="active">Add merchant</li>
    </ol>
</section>
<section class="main-content">
    <div class="notification-column">
        <div class="alert alert-danger" role="alert" id="errorMsgDiv" style="display: none;"></div>
        <div class="alert alert-success" role="alert" id="successMsgDiv" style="display: none;"></div>
        @if(Session::get('sendRequestMsg'))
        <div class="alert alert-success" role="alert">{{Session::get('sendRequestMsg')}}</div>
        @endif
        @if(Session::get('sendRequestErrMsg'))
        <div class="alert alert-danger" role="alert">{{Session::get('sendRequestErrMsg')}}</div>
        @endif
        <!-- <label class="error" id="sendRequestErorr">{{$sendRequestError}}</label> -->
    </div>
    <div id="addMerchantDiv">
        <div class="grid-content">
            <div class="section-main-heading">
                <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
            </div>
            <div class="filter-section">
                <div class="col-md-12 noAll-padding">
                    <div class="filter-left-section">
                        <form  method="get" id="merchantCodeForm">
                            <div class="form-group col-md-8 col-sm-6 col-xs-12" id="inputDiv">
                                <input type="text" name="merchantIdentityCode" id="merchantIdentityCode" value="{{isset($identityCode)?$identityCode:''}}" onkeypress="hideErrorMsg('errorLbl')" class="form-control medium pull-right " placeholder="Enter Merchant Code">
                                <label class="error" id="errorLbl"></label>
                            </div>
                            <div class="form-group col-md-2 col-sm-3 col-xs-12">
                                <button id="searchMerchant" class="btn btn-primary fullWidth noAll-margin" style="margin-left: 0px;">Search</button>
                            </div>
                            <input type="hidden" id="hdnStoreId" name="hdnStoreId" value="{{$storeId}}">
                        </form>
                    </div>
                </div>
                <div class="col-md-6" style="display: none;" id="merchantDetailDiv">
                    <div class="filter-right-section">
                        <div class="clearfix">
                            <div class="info-box">
                                <form action="{{ route('admin.vendors.send-notification') }}" method="post">
                                        <label>Business Name: </label> <span id="storeName"></span><br>
                                        <!-- <label>Person Name: </label> <span id="firstname"></span><br> -->
                                        <!-- <label>Email: </label> <span id="email"></span><br> -->
                                        <label>Mobile number: </label> <span id="phone"></span><br>
                                        <!-- <label>Industry: </label> <span id="businessName"></span><br> -->
                                        <input type="hidden" id="hdnMerchantEmail" name="hdnMerchantEmail" value="">
                                        <input type="hidden" id="hdnMerchantPhone" name="hdnMerchantPhone" value="">
                                        <input type="hidden" id="hdnMerchantId" name="hdnMerchantId" value="">
                                        <input type="hidden" id="hdnStoreIdForNotification" name="hdnStoreIdForNotification" value="">
                                        <input type="hidden" id="hdnCountryCode" name="hdnCountryCode" value="">
                                        <button type="submit" class="btn btn-primary noAll-margin">Connect</button>
                                    {{-- @else
                                        <label> No merchant found.</label>
                                    @endif --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-content">
            <div class="section-main-heading">
                <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Add Merchant</h1>
            </div>
            <div class="listing-section">
                <table class="table table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">Business Name</th>
                            <th class="text-center">Mobile Number</th>
                            <th class="text-center">Connection Date</th>
                            <th class="text-center">Ledger</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
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
$decodedMerchantDetail = json_decode($data->register_details);
$connectionData = date("d-m-Y", strtotime($data->updated_at));
$distributorId = $data->distributor_id;
$merchantId = $data->merchant_id;
$isApprovedVal = $data->is_approved;

if ($isApprovedVal == 1) {
    $statusLabel = 'Approved';
    $linkLabel = 'Disapprove';
    $iClass = "remove";
} else {
    $statusLabel = 'Not Approved';
    $linkLabel = 'Approve';
    $iClass = "check";
}
?>
                        <tr>
                            <td  class="text-left">{{$i}}</td>
                            <td  class="text-left">{{$decodedMerchantDetail->store_name}}</td>
                            <td  class="text-left">{{$decodedMerchantDetail->phone}}</td>
                            <td  class="text-right">{{$connectionData}}</td>
                            <td  class="text-center">
                                <div class="actionCenter">
                                <span><a class="btn-action-default" href="" title="Ledger"><i class="fa fa-pencil-square-o fa-fw" aria-hidden="true"></i> </a></span>
                                </div>
                            </td>
                            <td class="text-center" id="merchantStatus_{{$distributorId}}">{{$statusLabel}}</td>
                            <td class="text-center">
                                <div class="actionCenter">
                                <span class="dropdown">
                                    <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                        <li><a id="changeStatusLink_{{$distributorId}}" href="javascript:;" onClick="changeStatus({{$merchantId}}, {{$distributorId}}, {{$isApprovedVal}})" title="{{$linkLabel}}"><!---<i class="fa fa-{{$iClass}}"></i>--->{{$linkLabel}}</a></li>
                                    </ul>
                                </span>
                                </div>
                            </td>
                            <!-- <i class="fa fa-pencil-square-o fa-fw" title="Ledger"></i></td> -->
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
<script>
    $("#searchMerchant").on("click", function ()
    {
        var identityCode = $("#merchantIdentityCode").val();
        var hdnStoreId = $("#hdnStoreId").val();

        if(identityCode != '')
        {
            if(identityCode.length > 9)
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
                            // $("#businessName").html(parsedRegistrationDtaa['business_name']);
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
            }
        }
        else
        {
            $("#errorLbl").html("Enter merchant code").show().fadeOut(4000);
            return false;
        }
    });
    function hideErrorMsg(id)
    {
        $("#"+id).hide();
    }

   function changeStatus(merchantId, distributorId, status)
  {
      if(status == 1)
          var msg = 'Are you sure you want to disapprove this merchant?';
      else
          var msg = 'Are you sure you want to approve this merchant?';

      if (confirm(msg)) {
          $.ajax({
              type: "POST",
              data: {'merchantId':merchantId,'distributorId':distributorId},
              url: "{{ route('admin.vendors.isApproveMerchant') }}",
              dataType: "json",
              cache: false,
              success: function(response) {
                  //console.log("done");
                  //alert(response['status']);
                  if(response['status'] == 1)
                  {
                      if(status == 1)
                      {
                          $("#changeStatusLink_"+distributorId).html('Approve');
                          $("#merchantStatus_"+distributorId).html("Not Approve");
                          $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                          $("#changeStatusLink_"+distributorId).attr("onclick","changeStatus("+distributorId+",0)");
                      }
                      else
                      {
                          $("#merchantStatus_"+distributorId).html("Approved");
                          $("#changeStatusLink_"+distributorId).html('Disapprove');
                          $("#successMsgDiv").html(response['msg']).show().fadeOut(4000);
                          $("#changeStatusLink_"+distributorId).attr("onclick","changeStatus("+distributorId+",1)");
                      }
                  }
                  else
                  {
                      $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                  }
                  //$(window).scrollTop(0);
                  $("html, body").animate({ scrollTop: 0 }, "slow");
              }
          });
      }
  } // End function
</script>
@stop