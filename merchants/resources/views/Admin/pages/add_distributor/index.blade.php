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
        Add Distributor
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Add Distributor</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div id="addDistributorDiv">
            <div class="col-md-12">
                <label class="error" id="sendRequestErorr">{{$sendRequestError}}</label>
                <div class="box">
                    
                    <div class="box-header box-tools filter-box col-md-9 col-sm-12 col-xs-12 noBorder">                
                        <form  method="get" id="DistributorCodeForm">
                            <div class="form-group col-md-8 col-sm-6 col-xs-12" id="inputDiv">
                                <input type="text" name="distributorIdentityCode" id="distributorIdentityCode" value="{{isset($identityCode)?$identityCode:''}}" onkeypress="hideErrorMsg('errorLbl')" class="form-control medium pull-right " placeholder="Enter Distributor Code">
                            <label class="error" id="errorLbl"></label>
                            </div>
                            <div class="form-group col-md-2 col-sm-3 col-xs-12">
                                <button id="searchDistributor" class="btn btn-primary form-control" style="margin-left: 0px;">Search</button>
                            </div>
                            <input type="hidden" id="hdnStoreId" name="hdnStoreId" value="{{$storeId}}">
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12" id="distributorDetailDiv" style="display:none">
                <div class="info-box">
                <form action="{{ route('admin.distributor.send-notification') }}" method="post">
                   
                        <label>Business Name: </label> <span id="storeName"></span><br>
                        <label>Person Name: </label> <span id="firstname"></span><br>
                        <label>Email: </label> <span id="email"></span><br>
                        <label>Mobile number: </label> <span id="phone"></span><br>
                        {{-- <label>Industry: </label> <span id="businessName"></span><br> --}}
                        
                        <input type="hidden" id="hdnDistributorEmail" name="hdnDistributorEmail" value="">
                        <input type="hidden" id="hdnDistributorPhone" name="hdnDistributorPhone" value="">
                        <input type="hidden" id="hdnDistributorId" name="hdnDistributorId" value="">
                        <input type="hidden" id="hdnStoreIdForNotification" name="hdnStoreIdForNotification" value="">
                        <input type="hidden" id="hdnCountryCode" name="hdnCountryCode" value="">
                        <button type="submit">Connect</button>
                    {{-- @else
                        <label> No Distributor found.</label>
                    @endif --}}
                </form>
                </div>
            </div>
        </div>
       
        <!--Listing Template start from here -->
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
                        $decodedDistributorDetail = json_decode($data->register_details);
                        $connectionData = date("d-m-Y", strtotime($data->updated_at));;
                    ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$decodedDistributorDetail->store_name}}</td>
                        <td>{{$decodedDistributorDetail->firstname}}</td>
                        <td>{{$decodedDistributorDetail->phone}}</td>
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
        <!--Listing Template ends from here -->
    </div> 
</section>
@stop
@section('myscripts')
<script>
    $("#searchDistributor").on("click", function () 
    {
        var identityCode = $("#distributorIdentityCode").val();
        var hdnStoreId = $("#hdnStoreId").val();

        if(identityCode != '')
        {
            if(identityCode.length > 9)
            {
                $.ajax({
                    method: "POST",
                    data: {'distributorIdentityCode': identityCode,'hdnStoreId':hdnStoreId},
                    url: "{{route('admin.distributor.verifyCode')}}",
                    dataType: "json",
                    success: function (data) {
                        if(data['status'] == 0)
                        {
                            $("#inputDiv #errorLbl").html(data['error']).show();
                            $("#distributorDetailDiv").hide();
                        }
                        else
                        {
                            var resgisterDetail = data['distributorData']['register_details'];
                            var parsedRegistrationDtaa = JSON.parse(resgisterDetail);

                            $("#storeName").html(parsedRegistrationDtaa['store_name']);
                            $("#firstname").html(parsedRegistrationDtaa['firstname']);
                            $("#email").html(parsedRegistrationDtaa['email']);
                            $("#phone").html(parsedRegistrationDtaa['phone']);
                            $("#businessName").html(parsedRegistrationDtaa['business_name']);
                            $("#hdnDistributorEmail").val(data['distributorData']['email']);
                            $("#hdnDistributorPhone").val(data['distributorData']['phone']);
                            $("#hdnDistributorId").val(data['distributorId']);
                            $("#hdnCountryCode").val(data['distributorData']['country_code']);
                            $("#hdnStoreIdForNotification").val(hdnStoreId);
                            $("#distributorDetailDiv").show();
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
            $("#errorLbl").html("Enter Distributor code");
            return false;
        }
    });
    function hideErrorMsg(id)
    {
        $("#"+id).hide();
    }
</script>
@stop