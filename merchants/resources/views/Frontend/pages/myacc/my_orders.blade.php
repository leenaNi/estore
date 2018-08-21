@extends('Frontend.layouts.default')

@section('content')
<div class="page-heading bc-type-3">
    <div class="bc-type-profile bg-pos-crumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12 a-center">
                    <h1 class="title">Profile</h1>
                    <nav class="woocommerce-breadcrumb" itemprop="breadcrumb">
                        <a href="{{ route('home') }}">Home</a> <span class="delimeter">/</span> 
                        <a href="#">Profile</a> 
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div itemscope itemtype="#" class="container">
    <div class="page-content">
        <div class="page-content sidebar-position-left">
            <div class="row">
                @include('Frontend.includes.myacc')
                <div class="col-md-9 col-xs-12">
                    <div class="col-lg-12 col-md-12">
                        <div class="wpb_column vc_column_container ">
                            <div class="wpb_wrapper">
                                <div class="vc_separator wpb_content_element vc_separator_align_left vc_sep_width_100 vc_sep_pos_align_center vc_sep_color_black">
                                    <h4 class="text-left">My Orders</h4>
                                    <span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                </div>
                                 <div class="vc_separator wpb_content_element vc_separator_align_left vc_sep_width_100 vc_sep_pos_align_center vc_sep_color_black">
                                    <a href="{{ route('wishlists') }}" ><h4 class="text-left">Whislist</h4></a>
                                    <span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                </div>
                                <div class="wpb_text_column wpb_content_element ">
                                    <div class="wpb_wrapper">
                                        <?php if (count($orders) > 0) { ?>
                                            <form action="#" method="post">
                                                <div class="table-responsive shop-table pb40 mb30">
                                                    <table class="shop_table cart table table-bordered" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th class="product-name" style="width:20%;">Order ID</th>
                                                                <th class="product-price" style="width:20%;">Date</th>
                                                                <th class="product-quantity" style="width:20%;">Status</th>
                                                                <th class="product-subtotal" style="width:20%;">&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($orders as $ord)
                                                            <tr class="cart_item">
                                                                <td class="">
                                                                    <div class="cart-item-details">
                                                                        <a href="{{ route('orderDetails',['id'=>$ord->id]) }}">{{ $ord->id }}</a>                                                
                                                                    </div>
                                                                </td>
                                                                <td class="">
                                                                    <span class="cart-item-details">{{ date("d-M-Y",strtotime($ord->created_at)) }}</span>                   
                                                                </td>
                                                                <td class="">
                                                                    <div class="cart-item-details">{{ $ord->orderstatus['order_status']  }}</div>
                                                                </td>
                                                                <td class="product-subtotal">
                                                                    <span class="amount"><a class="btn gray small" href="{{ route('orderDetails',['id'=>$ord->id]) }}" name="viewdetails">View Details</a></span>               
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>
                                        <?php } else { ?>
                                        <h4 style="text-align: center;"> No orders found!!!
                                            </h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
