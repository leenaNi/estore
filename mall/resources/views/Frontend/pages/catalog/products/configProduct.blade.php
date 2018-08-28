@extends('Frontend.layouts.default')
@section('title',$product->metaTitle)
@section('og-title',$product->metaDesc)
@section('meta-description',$product->metaTitle)
<?php $imgUrl = $product->prodImage; ?>
@section('og:image', $imgUrl)
@section('content')
<div class="clearfix"></div>
<!-- Content
            ============================================= -->
<section id="content" ng-controller="configProductController">
    <input type="hidden" value="{{Request::url()}}" class="fbShareUrl" />
    <input type="hidden" value="[[product.images[0].img]]" class="fbShareImg" />
    <input type="hidden" value="[[product.product]]" class="fbShareTitle" />
    <div class="content-wrap">
        <div class="container clearfix topmargin-sm bottommargin-sm">
            <div class="single-product">
                <div class="product">
                    <form id="{{"form".$product->id}}" action="{{ route('addToCart')}}">
                        <div class="col_half">
                            <!-- Product Single - Gallery       ============================================= -->
                            <div class="product-image noborder">
                                <div class="fslider" data-pagi="false" data-autoplay="false" data-arrows="false" data-thumbs="true">
                                    <div class="flexslider">
                                        <div class="slider-wrap" data-lightbox="gallery" style="width:100% !important;">
                                            <div class="slide" ng-if="product.images.length > 0" ng-repeat="(key, prdimg) in product.images" data-thumb="[[prdimg.img]]">                                                    
                                                <a href="[[prdimg.img]]" title="[[product.title]]" data-lightbox="gallery-item">
                                                    <img src="[[prdimg.img]]" alt="[[product.product]]" class="zoom-me zoom-me1 [[(key==0)?'fimg':'']]" data-zoom-image="[[prdimg.img]]"> 
                                                </a>
                                            </div>
                                            <div class="slide" ng-if="product.images.length == 0" data-thumb="{{ asset(Config('constants.defaultImgPath').'default-product.jpg')}}" >
                                                <a href="javascript:void(0);" title="default Img" data-lightbox="gallery-item">
                                                    <img src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg')}}" alt="[[product.product]]" class="zoom-me zoom-me1" data-zoom-image="{{ asset(Config('constants.defaultImgPath').'default-product.jpg')}}"> 
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Single - Gallery End -->
                        </div>
                        <div class="col_last col_half product-desc noborder">
                            <h2 class="product_title bottommargin-xs">[[product.product]]</h2>         
                            <div class="product-rating" ng-show="product.product_code != ''">
                                <p>PRODUCT CODE: [[product.product_code]]</p>
                            </div>   
                            <div class="seller-name">
                                <h4 style="margin: 0 0 15px 0;">Sold By: {{$product->store_name}}</h4>
                            </div>
                            <div class="product-price" ng-show="product.spl_price > 0"> 
                                <del><span class="currency-sym"></span> [[product.price  * currencyVal |number :2]]</del> <span class="currency-sym"></span><ins class="mrp_price"> [[product.spl_price * currencyVal |number :2 ]]</ins>
                                <input type="hidden" name="price" value="[[product.spl_price]]" class="parent_price">
                            </div>
                            <div class="product-price" ng-show="product.spl_price == 0"> 
                                <ins class="mrp_price"><span class="currency-sym"></span> [[product.price  * currencyVal |number :2]]</ins>
                            </div>
                            @if($isstock==1)
                            <span class="span2 hide" style="color:red;" ng-show="product.is_stock == 1">STOCK LEFT : [[ product.stock ]]</span>
                            @endif
                            <div class="clear"></div>
                            <div class="line"></div>

                            <div id="selAT">
                                <select  ng-repeat="(attrsk, attrsv) in selAttributes" name='[[attrsv.name]]' class="selatts attrSel  form-control" id="selID[[$index]]"  ng-init="modelName = selaTT[[attrsk]]" ng-model="modelName"   ng-if="$index == 0" ng-change="selAttrChange(modelName, attrsk, $index + 1)" ng-options="optk as optv for (optk, optv) in attrsv.options" required>
                                    <option value="">[[attrsv.placeholder]]</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div ng-if="otherOptions.length == 0" >
                                <select ng-model="prodAttrValId" class='attrSel'  ng-change="getProductVarient(product.id, prodAttrValId)" >
                                    <option  ng-repeat="otherOptionsVal in otherOptions"  data-attr-id="[[getattrsval.attr_id]]" value="[[getattrsval.id]]">[[getattrsval.option_name]]</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Product Single - Quantity & Cart Button============================================= -->

                            <div class="quantity clearfix mobMB15">
                                <input type="button" value="-" class="minus">
                                @if($isstock==1)
                                <input type="number" step="1" name="quantity" id="quantity" value="1"  max="[[(product.is_stock == 1)?product.stock:'1000000000']]" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" />
                                @else 
                                <input type="number" step="1" name="quantity" id="quantity" value="1"  max="1000000000" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" />
                                @endif                                  
                                <input type="button" value="+" class="plus"> 
                            </div>
                            <input type='hidden' name='prod_id' value='[[product.id]]' data-parentid = "[[product.id]]">
                            <input type='hidden' name='prod_type' value='[[product.prod_type]]'>
                            <input type='hidden' name='sub_prod' value='' class="subPRod">
                            <button type="button" form-id='[[product.id]]' class="add-to-cart button nomargin addToCartB addToCart mobMB15">Add to cart</button>
                            <!--                  <button type="button" class="add-to-cart button nomargin buyNow">Buy Now</button>-->
                            <button type="button"   data-prodid="[[product.id]]" class="add-to-wishlist button nomargin [[(product.wishlist == 1) ? 'red-heart' : '']]"><i id="wish[[product.id]]" class="icon-heart" style="margin-right:0px;"></i></button>
                            <!-- Product Single - Quantity & Cart Button End -->
                            <div class="clear"></div>
                            <div class="line"></div>
                            <!-- Product Single - Short Description  ============================================= -->
                            <div class="shortDesc" >[[product.short_desc | removeHTMLTags]]</div>            
                            <!-- AddToAny BEGIN -->
                            <div class="shareSociIconBox">
                                <!--<strong>Share:</strong>--> 
                                <?php
                                $social['url'] = Request::url();
//                                    print_r(App\Library\Helper::socialShareIcon($social));
                                ?>
                            </div>
                            <!-- AddToAny END -->
                            <!-- Product Single - Share End -->
                        </div>
                    </form>
                </div>
            </div>                   
            <div class="clear"></div>
            <div class="line"></div>
            <div class="col_full nobottommargin">
                <h3>Other Products Sold By [[product.store_name]]</h3>
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
@stop
@section('myscripts')
<script>
            $(document).ready(function () {
    $('head').append('<meta property="og:image" content="<?= $product->prodImage ?>" /> ');
    });
            function isNumber(evt) {
            evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode > 31 && (charCode < 49 || charCode > 57)) {
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
            $('.attrSel').change(function () {
    alert("sdsf");
            $(".optError").remove();
    })


</script>
@stop
