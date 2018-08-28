@extends('Frontend.layouts.default')

@section('title',$product->metaTitle)
@section('og-title',$product->metaDesc)
@section('meta-description',$product->metaTitle)
@section('content')
<?php
//dd($product);
?>
<div class="clearfix"></div>
<!-- Content
            ============================================= -->
<section id="content">
    <input type="hidden" value="{{Request::url()}}" class="fbShareUrl" />
    <input type="hidden" value="{{@$product->images[0]->img}}" class="fbShareImg" />
    <span class="hide fbShareDesc">{{strip_tags($product->short_desc)}}</span>
    <input type="hidden" value="{{ $product->product }}" class="fbShareTitle" />
    <div class="content-wrap">
        <div class="container clearfix topmargin-sm bottommargin-sm">
            <div class="single-product">
                <div class="product">
                    <form id="{{"form".$product->id }}" action="{{ route('addToCart') }}">
                        <div class="col_half">
                            <!-- Product Single - Gallery               ============================================= -->
                            <div class="product-image noborder">
                                <div class="fslider" data-pagi="false" data-autoplay="false" data-arrows="false" data-thumbs="true">
                                    <div class="flexslider">
                                        <div class="slider-wrap" data-lightbox="gallery" style="width:100% !important;">
                                            <?php
                                            if ($isstock == 1) {
                                                $maxValue = $product->is_stock == 1 ? $product->stock : '1000000';
                                            } else {
                                                $maxValue = '1000000';
                                            }
                                            if (count($product->images) > 0) {
                                                foreach ($product->images as $pk => $prdimg) {
                                                    ?>
                                                    <div class="slide" data-thumb="{{$prdimg->img}}">
                                                        <a href="{{$prdimg->img}}" title="" data-lightbox="gallery-item"><img src="{{$prdimg->img}}" alt="" class="zoom-me zoom-me1" data-zoom-image="{{$prdimg->img}}"> </a>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="slide">
                                                    <a href="javascript:void(0);" title="Default" data-lightbox="gallery-item"><img src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}" alt="default Img" class="zoom-me zoom-me1 fimg " data-zoom-image="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}"> </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Single - Gallery End -->
                        </div>
                        <div class="col_last col_half product-desc noborder">
                            <h2 class="product_title bottommargin-xs">{{$product->product}}</h2>
                            @if($product->product_code)
                            <div class="product-code">
                                <p><strong>Product Code:</strong> {{$product->product_code}}</p>
                            </div>
                            @endif
                            <div class="seller-name">
                                <h4 style="margin: 0 0 15px 0;">Sold By: {{$product->store_name}}</h4>
                            </div>
                            @if($product->spl_price > 0 && $product->spl_price < $product->price)
                            <div class="product-price"> <span class="currency-sym"></span> {{number_format($product->spl_price * Session::get('currency_val'), 2, '.', '')}} <del> <span class="currency-sym"></span> {{number_format($product->price * Session::get('currency_val'), 2, '.', '')}}</del></div> 
                            @else
                            <div class="product-price"> <span class="currency-sym"></span> {{number_format($product->price * Session::get('currency_val'), 2, '.', '')}}  </div> 
                            @endif
                            <div class="clear"></div>
                            @if($product->is_stock == 1 && $isstock==1)
                            <span class="span2" style="color:red;">@if($product->stock < $stocklimit){{ 'STOCK LEFT : '.$product->stock }} @endif</span>
                            @endif
                            <div class="clear"></div>
                            <div class="line"></div>
                            <!-- Product Single - Quantity & Cart Button  ============================================= -->                        
                            <input type='hidden' name='prod_id' value='{{$product->id}}' data-parentid = "{{ $product->id }}">
                            <input type='hidden' name='prod_type' value='{{$product->prod_type}}'>
                            <div class="quantity clearfix">
                                <input type="button" value="-" class="minus">
                                <input type="text" step="1" min="1" name="quantity" value="1" title="Qty" class="qty"  onkeypress="return isNumber(event);" onkeypress="return isNumber(event);" max="{{$maxValue }}"size="4" />
                                <input type="button" value="+" class="plus"> </div>
                            <button  form-id='{{ $product->id }}'type="button" class="add-to-cart button nomargin addToCartB addToCart">Add to cart</button>
                            <button type="button"  data-prodid="{{ $product->id }}" class="add-to-wishlist button nomargin">Add To Wishlist<i id="wish{{ $product->id}}" class="{{($product->wishlist == 1) ? 'icon-heart3 red-heart' : 'icon-heart'}}" style="margin-right:0px;"></i></button>
                            <!-- Product Single - Quantity & Cart Button End -->
                            @if($product->short_desc!='')
                            <div class="clear"></div>
                            <div class="line"></div>
                            <!-- Product Single - Short Description ============================================= -->
                            <p>{{ $product->short_desc}}</p>
                            @endif
                            <div class="line"></div>
                            <div class="clear"></div>
                            <!-- Product Single - Share ============================================= -->
                            <div class="shareSociIconBox">
                                <strong>Share:</strong> 
                                <?php
                                $social['url'] = Request::url();
                                print_r(App\Library\Helper::socialShareIcon($social));
                                ?>
                            </div>
                            <div class="si-share noborder clearfix"> <span class="pull-left">Share:</span>
                                <div class="pull-left">
                                    <?php
                                    $social['url'] = Request::url();
                                    print_r(App\Library\Helper::socialShareIcon($social));
                                    ?>
    <!--                                <a href="#" class="social-icon si-borderless si-facebook"> <i class="icon-facebook"></i> <i class="icon-facebook"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-twitter"> <i class="icon-twitter"></i> <i class="icon-twitter"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-pinterest"> <i class="icon-pinterest"></i> <i class="icon-pinterest"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-gplus"> <i class="icon-gplus"></i> <i class="icon-gplus"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-rss"> <i class="icon-rss"></i> <i class="icon-rss"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-email3"> <i class="icon-email3"></i> <i class="icon-email3"></i> </a>-->
                                </div>
                            </div>
                            <!-- Product Single - Share End -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="clear"></div>
            <div class="line"></div>
            <div class="col_full nobottommargin">
                <h3>Other Products Sold By {{$product->store_name}}</h3>
                <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
                    <div class="oc-item">
                        <div class="product clearfix mobwidth100 ">
                            <div class="product-image producImgBoxSize_4Col">
                                <a href="fs1_product_detail.php"><img src="images/products/t-shirt.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-desc text-center">
                                <div class="product-title">
                                    <h4><a href="#">Men's T-Shirt - White</a>
                                    <!-- <span class="subtitle">Flat 10% Off*</span> -->
                                    </h4>
                                </div>
                                <div class="product-price"><del><i class="icon-rupee"></i> 699</del> <ins><i class="icon-rupee"></i> 599</ins>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="oc-item">
                        <div class="product clearfix mobwidth100 ">
                            <div class="product-image producImgBoxSize_4Col">
                                <a href="fs1_product_detail.php"><img src="images/products/shoe.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-desc text-center">
                                <div class="product-title">
                                    <h4><a href="#">MEN'S FOOTWEAR</a>
                                    <!-- <span class="subtitle">Flat 50% Off*</span> -->
                                    </h4>
                                </div>
                                <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="oc-item">
                        <div class="product clearfix mobwidth100 ">
                            <div class="product-image producImgBoxSize_4Col">
                                <a href="fs1_product_detail.php"><img src="images/products/shirt.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-desc text-center">
                                <div class="product-title">
                                    <h4><a href="#">Formal Shirts</a>
                                    <!-- <span class="subtitle">Flat 10% Off*</span> -->
                                    </h4>
                                </div>
                                <div class="product-price"><del><i class="icon-rupee"></i> 5999</del> <ins><i class="icon-rupee"></i> 4999</ins>
                                </div>

                            </div>
                        </div>  
                    </div>
                    <div class="oc-item">
                        <div class="product clearfix mobwidth100 ">
                            <div class="product-image producImgBoxSize_4Col">
                                <a href="fs1_product_detail.php"><img src="images/products/shoe.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-desc text-center">
                                <div class="product-title">
                                    <h4><a href="#">MEN'S FOOTWEAR</a>
                                    <!-- <span class="subtitle">Flat 50% Off*</span> -->
                                    </h4>
                                </div>
                                <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="oc-item">
                        <div class="product clearfix mobwidth100 ">
                            <div class="product-image producImgBoxSize_4Col">
                                <a href="fs1_product_detail.php"><img src="images/products/t-shirt.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-desc text-center">
                                <div class="product-title">
                                    <h4><a href="#">Men's T-Shirt - White</a>
                                    <!-- <span class="subtitle">Flat 10% Off*</span> -->
                                    </h4>
                                </div>
                                <div class="product-price"><del><i class="icon-rupee"></i> 699</del> <ins><i class="icon-rupee"></i> 599</ins>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- #content end -->
@stop
@section('myscripts')
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    $('.plus').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var maxvalue = parseInt($('input[name="quantity"]').attr('max'));
        // console.log(maxvalue);
        // Get its current value
        var currentVal = parseInt($('#quantity').val());
        //  console.log(currentVal);
        // If is not undefined
        if (!isNaN(currentVal) && (currentVal < maxvalue)) {
            // Increment
            //$('.plus').css('pointer-events', '');
            $('#quantity').val(parseInt(currentVal) + 1);
            // alert(parseInt(currentVal)+ 1);
        } else if (currentVal >= maxvalue) {
            // console.log(maxvalue);
            //$('.plus').css('pointer-events', 'none');
            $('#quantity').val(parseInt(maxvalue));
        } else {
            // Otherwise put a 0 there
            $('#quantity').val(1);
        }
    });

    $('.minus').click(function (e) {
        var minvalue = parseInt($('input[name="quantity"]').attr('min'));
        // Stop acting like a button
        e.preventDefault();
        var currentVal = parseInt($('#quantity').val());
        if (minvalue != currentVal)
            $('#quantity').val(parseInt(currentVal) - 1);
    });
    $(document).ready(function () {
        $("#email_notify_btn").click(function () {
            var mail = $("#email_notify").val();
            var prod = $("#prod_id").val();
            $.ajax({
                data: "email=" + mail + "&prod=" + prod,
                url: "{{ route('notifyMail') }}",
                type: "post",
                dataType: "json",
                beforeSend: function () {
                    $("#notify_err").text("Please wait");
                },
                success: function (r) {
                    $("#notify_err").text(r.msg);
                }
            });
        });
    });
</script>   
@stop