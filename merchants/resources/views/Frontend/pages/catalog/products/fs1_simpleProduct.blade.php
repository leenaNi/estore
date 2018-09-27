@extends('Frontend.layouts.default')

@section('title',$product->metaTitle)
@section('og-title',$product->metaDesc)
@section('meta-description',$product->metaTitle)
@section('content')
<div class="clearfix"></div>
<section id="content">
    <input type="hidden" value="{{Request::url()}}" class="fbShareUrl" />
    <input type="hidden" value="{{@$product->images[0]->img}}" class="fbShareImg" />
    <span class="hide fbShareDesc">{{strip_tags($product->short_desc)}}</span>
    <input type="hidden" value="{{ $product->product }}" class="fbShareTitle" />
    <div class="content-wrap">
        <div class="container clearfix">


            <div class="single-product">

                <div class="product">
                    <form id="{{"form".$product->id }}" action="{{ route('addToCart') }}">
                        <div class="col_half">
                            <!-- Product Single - Gallery
                                                                            ============================================= -->
                            <div class="product-image">
                                <div class="fslider" data-pagi="false" data-autoplay="false" data-arrows="false" data-thumbs="true">
                                    <div class="flexslider">
                                        <div class="slider-wrap" data-lightbox="gallery" style="width:100% !important;">
                                            <?php
                                            if (count($product->images) > 0) {
                                                foreach ($product->images as $pk => $prdimg) {
                                                    ?>
                                                    <div class="slide" data-thumb="{{$prdimg->img}}">
                                                        <a href="{{$prdimg->img}}" title="{{$prdimg->product}}" data-lightbox="gallery-item">
                                                            <img src="{{$prdimg->img}}" alt="{{ $prdimg->product }}" class="zoom-me zoom-me1 {{ ($pk == 0)?'fimg':''  }} " data-zoom-image="{{$prdimg->img}}">
                                                        </a>
                                                    </div>

                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="slide" >
                                                    <a href="javascript:void(0);" title="Default" data-lightbox="gallery-item"><img src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}" alt="default Img" class="zoom-me zoom-me1 fimg " data-zoom-image="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}"> </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Single - Gallery End -->
                        </div>
                        <div class="col_last col_half product-desc">
                            <h1 class="product_title">{{ $product->product }}</h1>
                            @if($product->product_code)
                            <div class="product-rating">
                                <p>PRODUCT CODE: {{ $product->product_code }}</p>
                            </div>
                            @endif
                            @if($product->spl_price > 0 && $product->spl_price < $product->price)
                            <div class="product-price"> <del><span class="currency-sym"></span> {{number_format(@$product->price * Session::get('currency_val'), 2, '.', '')}}</del> <ins><span class="currency-sym"></span>  {{number_format(@$product->spl_price * Session::get('currency_val'), 2, '.', '')}}</ins></div>   

                            @else 
                            <div class="product-price"> <ins><span class="currency-sym"></span> {{number_format(@$product->price * Session::get('currency_val'), 2, '.', '')}}</ins></div>
                            @endif
                            @if($product->is_stock == 1 && $isstock==1)

                            <span class="stockL span2 " style="color: red;">   @if($product->stock < $stocklimit) <b class="stockChk">{{ 'STOCK LEFT : '.$product->stock }}</b>@endif</span>
                            @endif



                            <div class="clear"></div>
                            <div class="line"></div>

                            <input type='hidden' name='prod_id' value='{{$product->id}}' data-parentid = "{{ $product->id }}">
                            <input type='hidden' name='prod_type' value='{{$product->prod_type}}'>
                            <div class="quantity clearfix mobMB15">
                                <?php
                                if ($isstock == 1) {
                                    $maxValue = $product->is_stock == 1 ? $product->stock : '1000000';
                                } else {
                                    $maxValue = '1000000';
                                }
                                ?>
                                <input type="button" value="-" class="minus">
                                <input type="number" id="quantity" step="1" min="1" name="quantity" value="1" title="Qty" max="{{$maxValue}}" class="qty" size="4" onkeypress="return isNumber(event);" onkeypress="return isNumber(event);" style="text-align: center;" />
                                <input type="button" value="+" class="plus">
                            </div>
                            <input type="button"  form-id='{{ $product->id }}' value="Add to cart" class="add-to-cart button nomargin addToCartB addToCart mobMB15">
                            <button type="button" data-prodid="{{ $product->id }}" class="add-to-wishlist button nomargin "><i  id="wish{{ $product->id}}" class=" {{ ($product->wishlist == 1) ? 'icon-heart3 red-heart' : 'icon-heart'}}" style="margin-right:0px;"></i></button>

                            <!-- Product Single - Quantity & Cart Button End -->
                            <div class="clear"></div>
                            <div class="line"></div>

                            <div class="shortDesc"><?php echo html_entity_decode($product->short_desc) ?></div>

                            <!-- AddToAny BEGIN -->
                            <div class="shareSociIconBox">
                                <strong>Share:</strong> 
                                <?php
                                $social['url'] = Request::url();
                                print_r(App\Library\Helper::socialShareIcon($social));
                                ?>
                            </div>
                            <!-- AddToAny END -->
                            <!-- Product Single - Share End -->
                        </div>
                        @if(@$is_desc->status)
                        <div class="col_full nobottommargin">
                            <div class="tabs clearfix nobottommargin" id="tab-1">
                                <ul class="tab-nav clearfix">
                                    <li class="noMobileMargin"><a href="#tabs-1"><span>Additional Description</span></a> </li>
                                     <!-- <li><a href="#tabs-2"><span>Additional Information</span></a> </li> -->
                                </ul>
                                <div class="tab-container">
                                    <div class="tab-content tabBox clearfix" id="tabs-1">
                                        <?php if (!empty($product->long_desc)) {
                                            echo html_entity_decode($product->long_desc);
                                        } else {
                                            echo "No data found";
                                        } ?>
                                    </div>
                                    <!-- <div class="tab-content tabBox clearfix" id="tabs-2">
<?php // if(!empty($product->add_desc)) { echo html_entity_decode($product->add_desc); } else { echo "No data found";}  ?>
                    
                                     </div> -->
                                </div>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>

            </div>

            @if($is_rel_prod->status && !$product->related->isEmpty())
            <div class="clear"></div>
            <div class="line"></div>
            <div class="col_full bottommargin">
                <h4>Related Products</h4>
                <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
                    @foreach($product->related as $relprd)
                    <div class="oc-item">
                        <div class="product clearfix mobwidth100 relatedProduct">
                            <div class="product-image">
                                @if(!empty(@$relprd->catalogimgs()->first()->filename))
                                <a href="{{ $relprd->url_key }}"><img src="{{ asset(Config('constants.productImgPath') . @$relprd->catalogimgs()->first()->filename) }}" alt="{{ $relprd->product }}" class="boxSizeImage"> </a>
                                @else
                                <a href="{{ $relprd->url_key }}"><img src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}" alt="" class="boxSizeImage"> </a>
                                @endif
            <!--                    <div class="product-overlay"> <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a> <a href="#" class="item-quick-view"><i class="icon-heart"></i><span>Wishlist</span></a> </div>-->
                            </div>
                            <div class="product-desc">
                                <div class="product-title">
                                    <h3><a href="{{ $relprd->url_key }}">{{ $relprd->product }}</a></h3> </div>
                                <div class="product-price">
                                    @if($relprd->spl_price > 0 && $relprd->spl_price > $relprd->price)
                                    <del><span class="currency-sym"></span> {{number_format(@$relprd->price * Session::get('currency_val'), 2, '.', '')}}</del> <ins><span class="currency-sym"></span> {{number_format(@$relprd->spl_price * Session::get('currency_val'), 2, '.', '')}}</ins> 
                                    @else
                                    <ins><span class="currency-sym"></span> {{number_format(@$relprd->price * Session::get('currency_val'), 2, '.', '')}}</ins> 
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            @endif

            <!-- you may like also product open -->
            @if($is_like_prod->status && !$product->upsellproduct->isEmpty())
            <div class="clear"></div>
            <div class="line"></div>
            <div class="col_full nobottommargin">
                <h4>You may like also</h4>
                <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">

                    @foreach($product->upsellproduct as $upsellprd)
                    <div class="oc-item">
                        <div class="product clearfix mobwidth100 youmayLikeProduct">
                            <div class="product-image">
                                @if(!empty(@$upsellprd->catalogimgs()->first()->filename))
                                <a href="{{ $upsellprd->url_key }}"><img src="{{ asset(Config('constants.productImgPath') . @$upsellprd->catalogimgs()->first()->filename) }}" alt="{{ $upsellprd->product }}" class="boxSizeImage"> </a>
                                @else
                                <a href="{{ $upsellprd->url_key }}"><img src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}" alt="" class="boxSizeImage"> </a>
                                @endif
                                <!--                    <div class="product-overlay"> <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a> <a href="#" class="item-quick-view"><i class="icon-heart"></i><span>Wishlist</span></a> </div>-->

                            </div>
                            <div class="product-desc product-desc-youMayLike">
                                <div class="product-title">
                                    <h3><a href="{{ $upsellprd->url_key }}">{{ $upsellprd->product }}</a></h3> </div>

                                <div class="product-price">
                                    @if($upsellprd->spl_price > 0 && $upsellprd->spl_price > $upsellprd->price)
                                    <del><span class="currency-sym"></span> {{number_format(@$upsellprd->price * Session::get('currency_val'), 2, '.', '')}} </del> <ins><span class="currency-sym"></span>  {{number_format(@$upsellprd->spl_price * Session::get('currency_val'), 2, '.', '')}}</ins> 
                                    @else
                                    <ins><span class="currency-sym"></span>  {{number_format(@$upsellprd->price * Session::get('currency_val'), 2, '.', '')}}</ins> 
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            @endif
            <!-- you may like also product close -->

        </div>
    </div>




</section>


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