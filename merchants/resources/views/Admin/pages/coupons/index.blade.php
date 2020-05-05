@extends('Admin.layouts.default')
@section('content') 

<section class="content-header">   
    <h1>
        Coupons 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Marketing</a></li>
        <li class="active">Coupons</li>
    </ol>
</section>

<section class="main-content">
    <div class="notification-column">
        <div class="alert alert-danger" role="alert" id="errorMsgDiv" style="display: none;"></div>
        <div class="alert alert-success" role="alert" id="successMsgDiv" style="display: none;"></div>
        {{-- @if(!empty(Session::get('message')))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('message') }}
        </div>
        @endif
        @if(!empty(Session::get('msg')))
        <div class="alert alert-success" role="alert">
            {{Session::get('msg')}}
        </div>
        @endif --}}
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 noAll-padding">
                <div class="filter-left-section"> 
                    <form action="{{ route('admin.coupons.view') }}" method="get" >
                        <div class="form-group col-md-8 col-sm-6 col-xs-12 noBottom-margin">
                        <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                            <input type="text" name="couponSearch"  class="form-control form-control-right-border-radius medium" placeholder="Coupon Name / Code">
                        </div>
                        </div>
                        <div class="form-group col-md-4 col-sm-3 col-xs-12 noBottom-margin">
                            <a href="{{ route('admin.coupons.view')}}" class="btn reset-btn noMob-leftmargin pull-right mn-w100">Reset </a>
                            <button type="submit" class="btn btn-primary noAll-margin pull-right marginRight-sm mn-w100"> Filter</button> 
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Coupons 
                <?php
                if($couponCount > 0)
                {
                ?>
                   <span class="listing-counter">{{$startIndex}}-{{$endIndex}} of {{$couponCount }}</span> </h1>
                <?php
                }
                ?>
                
             <a href="{!! route('admin.coupons.add') !!}" class="btn btn-listing-heading pull-right noAll-margin"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'plus.svg'}}"> Create</a>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr> 
                            <th class="text-center">Image</th>
                            <th class="text-left">Name</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Type</th>
                            <th class="text-right">Value</th>
                            <th class="text-right">Min. Order</th> 
                            <th class="text-right">Start Date</th>
                            <th class="text-right">End Date</th> 
                            <th class="text-center">Status</th>
                            <th class="text-center mn-w100">Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($coupons) > 0) { ?>
                            @foreach ($coupons as $coupon)
                            <?php
                            if($coupon->status==1)
                            {
                                $statusLabel = 'Active';
                                $linkLabel = 'Mark as Inactive';
                            }
                            else
                            {
                                $statusLabel = 'Inactive';
                                $linkLabel = 'Mark as Active';
                            }
                            ?>
                            <tr> 
                                <td class="text-center"><img class="img-responsive img-thumbnail admin-profile-picture" src="{{($coupon->coupon_image)?asset('public/Admin/uploads/coupons/').'/'.$coupon->coupon_image:Config('constants.defaultImgPath').'/no-image.jpg' }}" /></td>
                                <td class="text-left">{{$coupon->coupon_name}}</td>
                                <td class="text-center">{{$coupon->coupon_code}}</td>
                                <td class="text-center">{{$coupon->discount_type==2?'Fixed':'Percentage'}}</td>
                                <td class="text-right">
                                    @if($coupon->discount_type == '1')
                                    %  {{$coupon->coupon_value}}
                                    @else
                                 <span class="currency-sym"></span>   <span class="priceConvert">{{$coupon->coupon_value}}</span>
                                    @endif
                                </td>
                                <td class="text-right"><span class="currency-sym"></span> <span class="priceConvert"> {{$coupon->min_order_amt}}</span></td>
                                <?php
                                if ($coupon->coupon_type == 1) {
                                    $coupontype = 'Entire Order';
                                } elseif ($coupon->coupon_type == 2) {
                                    $coupontype = 'Specific Categories';
                                } else {
                                    $coupontype = 'Specific Products';
                                }
                                ?> 
                                <td class="text-right">{{date('d-M-Y', strtotime($coupon->start_date))}}</td>
                                <td class="text-right">{{date('d-M-Y', strtotime($coupon->end_date))}}</td> 
                                <td class="text-center" id="couponStatus_{{$coupon->id}}"><span class="alertSuccess">{{$statusLabel}}</span></td>
                              
                                <td class="text-center mn-w100">
                                    <div class="actionCenter"> 
                                        <span><a class="btn-action-default" href="{{route('admin.coupons.edit',['id'=>$coupon->id])}}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                                        <span class="dropdown">
                                            <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">  
                                                <li><a href="{!! route('admin.coupons.delete',['id'=>$coupon->id]) !!}" onclick="return confirm('Are you sure you want to delete this coupon?')"><i class="fa fa-trash "></i> Delete</a></li>
                                                <li><a href="javascript:;" id="changeStatusLink_{{$coupon->id}}" onclick="changeStatus({{$coupon->id}},{{$coupon->status}})" ><i class="fa fa-check"></i> {{$linkLabel}}</a></li>
                                            </ul>
                                        </span>  
                                    </div>  
                                </td>
                            </tr>
                            @endforeach
                        <?php } else { ?>
                            <tr>
                                <td colspan="10" class="text-center">No Record Found.</td>
                            </tr>
                        <?php } ?>      
                    </tbody>
                </table>
            </div>
            <?php
            if (empty(Input::get('couponSearch'))) {
                echo $coupons->render();
            }
            ?>
        </div>
    </div>

</section>
<div class="clearfix"></div>

@stop 
@section('myscripts')
<script>
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
    function changeStatus(couponId,status)
    {
        if(status == 1)
            var msg = 'Are you sure you want to inactive this coupon?';
        else
            var msg = 'Are you sure you want to active this coupon?';

        if (confirm(msg)) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.coupons.changeStatus') }}",
                data: {id: couponId},
                cache: false,
                success: function(response) {
                    console.log("done");
                    if(response['status'] == 1)
                    {
                        if(status == 1)
                        {
                            $("#changeStatusLink_"+couponId).html('Mark as Active');
                            $("#couponStatus_"+couponId).html("Inactive");
                            $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                            $("#changeStatusLink_"+couponId).attr("onclick","changeStatus("+couponId+",0)");
                        }
                        else
                        {
                            $("#couponStatus_"+couponId).html("Active");
                            $("#changeStatusLink_"+couponId).html('Mark as Inactive');
                            $("#successMsgDiv").html(response['msg']).show().fadeOut(4000);
                            $("#changeStatusLink_"+couponId).attr("onclick","changeStatus("+couponId+",1)");
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
    } // ENd  changeStatus()
</script>
@stop