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

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
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
                <div class="box-header box-tools filter-box col-md-9 col-sm-12 col-xs-12 noBorder">                
                    <form action="{{ route('admin.coupons.view') }}" method="get" >
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <input type="text" name="couponSearch"  class="form-control medium pull-right " placeholder="Coupon Name/Code">
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Search</button>
                        </div>
                        <div class="from-group col-md-2 col-sm-3 col-xs-12">
                            <a href="{{ route('admin.coupons.view')}}" class="form-control btn reset-btn noMob-leftmargin">Reset </a>
                        </div>
                    </form>
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <a href="{!! route('admin.coupons.add') !!}" class="btn btn-default pull-right mobFloatLeft mobAddnewflagBTN" type="button">Add New Coupon</a>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>             
                <div class="clearfix"></div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                                <th>Coupon ID</th>-->
                                <th>Image</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Min. Order</th>
<!--                                <th>Coupon Type</th>-->

<!--                                <th>No of Times Allowed</th>-->
                                <th>Start Date</th>
                                <th>End Date</th>
<!--                                <th>User Specific</th>-->
<!--                                <th>Created At</th>-->
                                <th>Status</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($coupons) > 0) { ?>
                                @foreach ($coupons as $coupon)
                                <tr>
    <!--                                <td>{{$coupon->id}}</td>-->
                                    <td><img class="img-responsive img-thumbnail admin-profile-picture" src="{{($coupon->coupon_image)?Config('constants.couponImgPath').'/'.$coupon->coupon_image:Config('constants.defaultImgPath').'/no-image.jpg' }}" /></td>
                                    <td>{{$coupon->coupon_name}}</td>
                                    <td>{{$coupon->coupon_code}}</td>
                                    <td>{{$coupon->discount_type==2?'Fixed':'Percentage'}}</td>
                                    <td>
                                        @if($coupon->discount_type == '1')
                                        %  {{$coupon->coupon_value}}
                                        @else
                                     <span class="currency-sym"></span>   <span class="priceConvert">{{$coupon->coupon_value}}</span>
                                        @endif
                                    </td>
                                    <td><span class="currency-sym"></span> <span class="priceConvert"> {{$coupon->min_order_amt}}</span></td>
                                    <?php
                                    if ($coupon->coupon_type == 1) {
                                        $coupontype = 'Entire Order';
                                    } elseif ($coupon->coupon_type == 2) {
                                        $coupontype = 'Specific Categories';
                                    } else {
                                        $coupontype = 'Specific Products';
                                    }
                                    ?>
    <!--                                    <td>{{$coupontype}}</td>-->
    <!--                                    <td>{{$coupon->no_times_allowed}}</td>-->
                                    <td>{{date('d-M-Y', strtotime($coupon->start_date))}}</td>
                                    <td>{{date('d-M-Y', strtotime($coupon->end_date))}}</td>
    <!--                                    <td>{{$coupon->user_specific==0?'--':'Yes'}}</td>-->
    <!--                                    <td>{{ date('d M,y', strtotime($coupon->created_at))}}</td>-->
                                    <td>  <?php if ($coupon->status == 1) { ?>
                                            <a href="{!! route('admin.coupons.changeStatus',['id'=>$coupon->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this coupon?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btnNo-margn-padd"></i></a>
                                        <?php } elseif ($coupon->status == 0) { ?>
                                            <a href="{!! route('admin.coupons.changeStatus',['id'=>$coupon->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this coupon?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btnNo-margn-padd"></i></a>
                                        <?php } ?> </td>

                                    <td>
                                        <a href="{{route('admin.coupons.edit',['id'=>$coupon->id])}}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btnNo-margn-padd"></i></a> 
                                        <a href="{!! route('admin.coupons.delete',['id'=>$coupon->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this coupon?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>

                                    </td>
                                </tr>
                                @endforeach
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5">No Record Found.</td>
                                </tr>
                            <?php } ?>      
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    <?php
                    if (empty(Input::get('couponSearch'))) {
                        echo $coupons->render();
                    }
                    ?> 

                </div>
            </div>
        </div>
    </div>
</section>

@stop 
@section('myscripts')
<script>
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
@stop