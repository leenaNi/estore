@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<style type="text/css">.capitalizeText select {
        text-transform: capitalize;
    } 
    select.form-control{ padding: 7px!important;}.fnt14{font-size: 14px;text-transform: capitalize !important;}</style>
@stop

@section('content')
<section class="content-header">
    <h1>
        Add Merchant
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Add merchant</li>
    </ol>
</section>
<section class="main-content">
    <div class="notification-column">
        <label class="error" id="sendRequestErorr">{{$sendRequestError}}</label>
    </div>
    <div id="addMerchantDiv">
        <div class="grid-content">
            <div class="section-main-heading">
                <h1>Add merchant</h1>
            </div>
            <div class="filter-section displayFlex">

                <div class="col-md-9 noAll-padding displayFlex">
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
                <div class="col-md-3 noAll-padding displayFlex" style="background:#fff;">
                    <div class="filter-right-section">
                        <div class="clearfix" id="merchantDetailDiv" style="display:none;" >
                            <div class="info-box">
                                <form action="{{ route('admin.vendors.send-notification') }}" method="post">
                                
                                        <label>Business Name: </label> <span id="storeName"></span><br>
                                        <label>Person Name: </label> <span id="firstname"></span><br>
                                        <label>Email: </label> <span id="email"></span><br>
                                        <label>Mobile number: </label> <span id="phone"></span><br>
                                        <label>Industry: </label> <span id="businessName"></span><br>
                                        
                                        <input type="hidden" id="hdnMerchantEmail" name="hdnMerchantEmail" value="">
                                        <input type="hidden" id="hdnMerchantPhone" name="hdnMerchantPhone" value="">
                                        <input type="hidden" id="hdnMerchantId" name="hdnMerchantId" value="">
                                        <input type="hidden" id="hdnStoreIdForNotification" name="hdnStoreIdForNotification" value="">
                                        <input type="hidden" id="hdnCountryCode" name="hdnCountryCode" value="">
                                        <button type="submit">Connect</button>
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
            <div class="listing-section">
                <table class="table table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">Business Name</th>
                            <th class="text-center">Concern Person Name</th>
                            <th class="text-center">Mobile Number</th>
                            <th class="text-right">Connection Date</th>
                            <th class="text-center">Ledger</th>
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
                            $connectionData = date("d-m-Y", strtotime($data->updated_at));;
                        ?>
                        <tr>
                            <td  class="text-left">{{$i}}</td>
                            <td  class="text-left">{{$decodedMerchantDetail->store_name}}</td>
                            <td  class="text-center">{{$decodedMerchantDetail->firstname}}</td>
                            <td  class="text-center">{{$decodedMerchantDetail->phone}}</td>
                            <td  class="text-Right">{{$connectionData}}</td>
                            <td  class="text-center">
                                <div class="actionCenter">
                                        <span><a class="btn-action-default" href=""><i class="fa fa-pencil-square-o fa-fw" aria-hidden="true"></i> Ledger</a></span> 
                                    
                                </div>
                            <!-- <i class="fa fa-pencil-square-o fa-fw" title="Ledger"></i></td> -->
                        </tr> 
                        @endforeach
                    @else
                        <label class="text-center"> No records found.</label>
                    @endif 
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- <section class="content">
    <div class="row">
        <div id="addMerchantDiv">
            <div class="col-md-12">
                <label class="error" id="sendRequestErorr">{{$sendRequestError}}</label>
                <div class="box">
                    
                    <div class="box-header box-tools filter-box col-md-9 col-sm-12 col-xs-12 noBorder">                
                        <form  method="get" id="merchantCodeForm">
                            <div class="form-group col-md-8 col-sm-6 col-xs-12" id="inputDiv">
                                <input type="text" name="merchantIdentityCode" id="merchantIdentityCode" value="{{isset($identityCode)?$identityCode:''}}" onkeypress="hideErrorMsg('errorLbl')" class="form-control medium pull-right " placeholder="Enter Merchant Code">
                            <label class="error" id="errorLbl"></label>
                            </div>
                            <div class="form-group col-md-2 col-sm-3 col-xs-12">
                                <button id="searchMerchant" class="btn btn-primary form-control" style="margin-left: 0px;">Search</button>
                            </div>
                            <input type="hidden" id="hdnStoreId" name="hdnStoreId" value="{{$storeId}}">
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12" id="merchantDetailDiv" style="display:none">
                <div class="info-box">
                <form action="{{ route('admin.vendors.send-notification') }}" method="post">
                   
                        <label>Business Name: </label> <span id="storeName"></span><br>
                        <label>Person Name: </label> <span id="firstname"></span><br>
                        <label>Email: </label> <span id="email"></span><br>
                        <label>Mobile number: </label> <span id="phone"></span><br>
                        <label>Industry: </label> <span id="businessName"></span><br>
                        
                        <input type="hidden" id="hdnMerchantEmail" name="hdnMerchantEmail" value="">
                        <input type="hidden" id="hdnMerchantPhone" name="hdnMerchantPhone" value="">
                        <input type="hidden" id="hdnMerchantId" name="hdnMerchantId" value="">
                        <input type="hidden" id="hdnStoreIdForNotification" name="hdnStoreIdForNotification" value="">
                        <input type="hidden" id="hdnCountryCode" name="hdnCountryCode" value="">
                        <button type="submit">Connect</button>
                    {{-- @else
                        <label> No merchant found.</label>
                    @endif --}}
                </form>
                </div>
            </div>
        </div>
       
    
        <div>
            <table class="table table-striped table-hover tableVaglignMiddle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Business Name</th>
                        <th>Concern Person Name</th>
                        <th>Mobile Number</th>
                        <th>Connection Date</th>
                        <th>Ledger</th>
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
                        $connectionData = date("d-m-Y", strtotime($data->updated_at));;
                    ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$decodedMerchantDetail->store_name}}</td>
                        <td></td>
                        <td>{{$decodedMerchantDetail->phone}}</td>
                        <td>{{$connectionData}}</td>
                        <td><i class="fa fa-pencil-square-o fa-fw" title="Ledger"></i></td>
                    </tr> 
                    @endforeach
                @else
                    <label> No records found.</label>
                @endif 
                
                </tbody>
            </table>
        </div>
        
    </div> 
</section> -->
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
                        if(data['status'] == 0)
                        {
                            $("#errorLbl").html(data['error']);
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
                $("#errorLbl").html("Enter valid code");
                return false;
            }
        }
        else
        {
            $("#errorLbl").html("Enter merchant code");
            return false;
        }
    });
    function hideErrorMsg(id)
    {
        $("#"+id).hide();
    }
</script>
@stop