@extends('Admin.layouts.default')
@section('content') 

<section class="content-header">   
    <h1>
        Coupons ({{$couponCount }})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Coupons</li>
    </ol>
</section>

<section class="main-content">
    <div class="notification-column">
        @if(!empty(Session::get('message')))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('message') }}
        </div>
        @endif
        @if(!empty(Session::get('msg')))
        <div class="alert alert-success" role="alert">
            {{Session::get('msg')}}
        </div>
        @endif
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-9 noAll-padding displayFlex">
                <div class="filter-left-section"> 
                    <form action="{{ route('admin.coupons.view') }}" method="get" >
                        <div class="form-group col-md-8 col-sm-6 col-xs-12 noBottom-margin">
                            <input type="text" name="couponSearch"  class="form-control medium pull-right " placeholder="Coupon Name / Code">
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-xs-12 noBottom-margin">
                            <button type="submit" class="btn btn-primary fullWidth noAll-margin"> Search</button>
                        </div>
                        <div class="from-group col-md-2 col-sm-3 col-xs-12 noBottom-margin">
                            <a href="{{ route('admin.coupons.view')}}" class="btn reset-btn fullWidth noMob-leftmargin">Reset </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3 noAll-padding displayFlex">
                <div class="filter-right-section">
                    <a href="{!! route('admin.coupons.add') !!}" class="btn fullWidth btn-default pull-right mobFloatLeft mobAddnewflagBTN" type="button">Add New Coupon</a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Coupons <span class="listing-counter">{{$couponCount }}</span> </h1>
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
                            <th class="text-center">Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($coupons) > 0) { ?>
                            @foreach ($coupons as $coupon)
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
                                <td class="text-center">  <?php if ($coupon->status == 1) { ?>
                                        <a href="{!! route('admin.coupons.changeStatus',['id'=>$coupon->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this coupon?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btnNo-margn-padd"></i></a>
                                    <?php } elseif ($coupon->status == 0) { ?>
                                        <a href="{!! route('admin.coupons.changeStatus',['id'=>$coupon->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this coupon?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btnNo-margn-padd"></i></a>
                                    <?php } ?> </td>

                                <td class="text-center">
                                    <div class="actionCenter">
                                        <span><a class="btn-action-default" href="{{route('admin.coupons.edit',['id'=>$coupon->id])}}">Edit</a></span> 
                                        <span class="dropdown">
                                            <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">  
                                                <li><a href="{!! route('admin.coupons.delete',['id'=>$coupon->id]) !!}" onclick="return confirm('Are you sure you want to delete this coupon?')"><i class="fa fa-trash "></i> Delete</a></li>
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
</script>
@stop