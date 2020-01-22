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
        Enter Merchant Code
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Enter Code</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9 col-sm-12 col-xs-12 noBorder">                
                    <form action="{{ route('admin.vendors.verifyCode') }}" method="get" id="merchantCodeForm">
                        <div class="form-group col-md-8 col-sm-6 col-xs-12" id="inputDiv">
                            <input type="text" name="merchantIdentityCode" id="merchantIdentityCode" value="{{isset($identityCode)?$identityCode:''}}" onkeypress="hideErrorMsg('errorLbl')" class="form-control medium pull-right " placeholder="Enter Merchant Code">
                        <label class="error" id="errorLbl">{{isset($error)?$error:''}}</label>
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <button type="submit" id="searchMerchant" class="btn btn-primary form-control" style="margin-left: 0px;">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12" id="merchantDetailDiv" style={{isset($merchantData)?'display:block':'display:none'}}>
            <div class="info-box">
               <form action="{{ route('admin.vendors.send-notification') }}" method="get">
                @if(!empty($merchantData))
                    <label>Business Name: </label> <span>{{$merchantData->store_name}}</span><br>
                    <label>Person Name: </label> <span>{{$merchantData->firstname}}</span><br>
                    <label>Email: </label> <span>{{$merchantData->email}}</span><br>
                    <label>Mobile number: </label> <span>{{$merchantData->phone}}</span><br>
                    <label>Industry: </label> <span>{{$merchantData->business_name}}</span><br>

                    <input type="hidden" id="hdnMerchantEmail" name="hdnMerchantEmail" value="{{$merchantData->email}}">
                    <input type="hidden" id="hdnMerchantPhone" name="hdnMerchantPhone" value="{{$merchantData->phone}}">
                    <input type="hidden" id="hdnMerchantId" name="hdnMerchantId" value="{{$merchantId}}">
                    <input type="hidden" id="hdnMerchantCode" name="hdnMerchantCode" value="{{$identityCode}}">
                    <button type="submit">Connect</button>
                @else
                    <label> No merchant found.</label>
                @endif
               </form>
            </div>
        </div>


        <!--Listing Template start from here -->
        <div class="tableListing">
                  
                  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <caption>Distributor Listing</caption>
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>Business Name</th>
                             <th>Concern Person Name</th>
                             <th>Mobile Number</th>
                             <th>Connection Date</th>
                             <th>Ledgs</th>
                         </tr>
                     </thead>	
                     <tbody>
                        @if(!empty($merchantData))
                        <tr>
                             <td>1</td>
                             <td>{{$merchantData->store_name}}</td>
                             <td>{{$merchantData->firstname}}</td>
                             <td>{{$merchantData->phone}}</td>
                             <td>-</td>
                             <td>-</td>
                        </tr> 
                        @else
                            <label> No records found.</label>
                        @endif 
                        
                     </tbody>
                 </table>
        </div>
        <!--Listing Template ends from here -->
        
    </div> 
</section>
@stop
@section('myscripts')
<script>
    $("#searchMerchant").on("click", function () 
    {
        var identityCode = $("#merchantIdentityCode").val();

        if(identityCode != '')
        {
            if(identityCode.length > 9)
            {
                $("#merchantCodeForm").submit();
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