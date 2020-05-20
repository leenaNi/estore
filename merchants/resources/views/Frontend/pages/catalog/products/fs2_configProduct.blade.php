@extends('Frontend.layouts.default')
@section('title',$product->metaTitle)
@section('og-title',$product->metaDesc)
@section('meta-description',$product->metaTitle)
<?php $imgUrl = $product->prodImage; ?>
@section('og:image', $imgUrl)
@section('content')
<div  ng-controller="configProductController">
    <section id="content">
                <input type="hidden" value="{{Request::url()}}" class="fbShareUrl" />
        <input type="hidden" value="[[product.images[0].img ]] " class="fbShareImg" />
       
        <input type="hidden" value="[[product.product]]" class="fbShareTitle" />
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="single-product">
            <div class="product">
         <form class="cart nobottommargin clearfix" id="form[[product.id]]" action="{{ route('addToCart')}}">	
              <div class="col_half">
                <!-- Product Single - Gallery
								============================================= -->
                <div class="product-image">
                  <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true" data-direction="false">
                    <div class="flexslider"  ng-if="product.images.length > 0">
                      <div class="slider-wrap "  data-lightbox="gallery" style="width:100% !important;">
                       
                          <div class="slide" ng-repeat="prdimg in product.images"  data-thumb="[[prdimg.img]]">
                          <a href="[[prdimg.img]]" title="[[product.product]]" data-lightbox="gallery-item"><img src="[[prdimg.img]]" alt="[[product.product]]" class="zoom-me zoom-me1" data-zoom-image="[[prdimg.img]]"> </a>
                        </div>
<!--                        <div class="slide" data-thumb="images/slider/1.jpg">
                          <a href="images/slider/1.jpg" title="Pink Printed Dress - Side View" data-lightbox="gallery-item"><img src="images/slider/1.jpg" alt="Pink Printed Dress" class="zoom-me zoom-me1" data-zoom-image="images/slider/1.jpg"> </a>
                        </div>
                        <div class="slide" data-thumb="images/slider/1.jpg">
                          <a href="images/slider/1.jpg" title="Pink Printed Dress - Back View" data-lightbox="gallery-item"><img src="images/slider/1.jpg" alt="Pink Printed Dress" class="zoom-me zoom-me1" data-zoom-image="images/slider/1.jpg"> </a>
                        </div>-->
                      </div>
                    </div>
                       <div class="flexslider"  ng-if="product.images.length == 0">
                      <div class="slider-wrap " ng-repeat="prdimg in product.images"  data-lightbox="gallery" style="width:100% !important;">
                       
                          <div class="slide" data-thumb="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}">
                          <a href="javascript:void(0);" title="default Img" data-lightbox="gallery-item"><img src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}" alt="[[product.product]]" class="zoom-me zoom-me1" data-zoom-image="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}"> </a>
                        </div>
                      </div>
                    </div>
                      
                  </div>
                </div>
                <!-- Product Single - Gallery End -->
              </div>
              <div class="col_last col_half product-desc">
                <h1 class="product_title">[[product.product]]</h1>
                <div class="product-rating" ng-show="product.product_code !=''">
                  <p>PRODUCT CODE: [[product.product_code]]</p>
                </div>

                <div class="product-price  prodDetailPrice" ng-show="product.spl_price > 0 && product.price > product.spl_price">
                <del><span class="currency-sym"></span>  [[product.price  * currencyVal |number :2]]</del>
                    <span class="currency-sym"></span><ins class="mrp_price">[[product.spl_price  * currencyVal |number :2]]</ins>
                </div> 
                  <div class="product-price  prodDetailPrice" ng-show="product.spl_price == 0">
                    <span class="currency-sym"></span><ins class="mrp_price">[[product.price * currencyVal |number :2]] </ins>
                </div> 
                   <input type="hidden" name="price" value="[[product.spl_price]]" class="parent_price">

                @if($isstock==1)
                <span class="span2 hide" style="color:red;"  ng-show="product.is_stock == 1">STOCK LEFT : [[product.stock]]</span>
                @endif
                <div class="clear"></div>
                <div class="line"></div>
                 <div id="selAT">
                                    <select  ng-repeat="(attrsk,attrsv) in selAttributes" name='[[attrsv.name]]' class="selatts attrSel  form-control" id="selID[[$index]]"  ng-init="modelName = selaTT[[attrsk]]" ng-model="modelName"   ng-if="$index == 0" ng-change="selAttrChange(modelName, attrsk, $index + 1)" ng-options="optk as optv for (optk,optv) in attrsv.options " required>
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
                <!-- Product Single - Quantity & Cart Button
								============================================= -->
                  <div class="quantity clearfix">
                    <input type="button" value="-" class="minus">
                   @if($isstock==1)
                           <input type="number" step="1" name="quantity" id="quantity" value="1"  max="[[(product.is_stock == 1)?product.stock:'1000000000']]" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" />
                             @else 
                          <input type="number" step="1" name="quantity" id="quantity" value="1"  max="1000000000" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" />
                          @endif
                    <input type="button" value="+" class="plus"> </div>
                       <input type='hidden' name='prod_id' value='[[product.id]]' data-parentid = "[[product.id]]">
                            <input type='hidden' name='prod_type' value='[[product.prod_type]]'>
                             <input type='hidden' name='sub_prod' value='' class="subPRod">
                             <button type="button" form-id='[[product.id]]' class="add-to-cart button nomargin  addToCartB addToCart">Add to cart</button>
                             <button type="button"  data-prodid="[[product.id]]"  class="add-to-wishlist button nomargin [[(product.wishlist == 1) ? 'red-heart' : '']]"><i id="wish[[product.id]]" class="icon-heart" style="margin-right:0px;"></i></button>
                </form>
                <!-- Product Single - Quantity & Cart Button End -->
                <div class="clear"></div>
                <div class="line"></div>
                <div class="shortDesc" ng-show="product.short_desc!=''" >[[product.short_desc | removeHTMLTags]]</div> 
                <!-- Product Single - Share ============================================= -->
                <div class="si-share noborder clearfix"> <span class="pull-left">Share:</span>
                  <div class="pull-left">
                                    <?php
                        $social['url']=Request::url();
                        print_r(App\Library\Helper::socialShareIcon($social));
                        ?>  
                  </div>
                </div>
                <!-- Product Single - Share End -->
              </div>
              @if($is_desc->status)
              <div class="col_full nobottommargin">
                <div class="tabs clearfix nobottommargin" id="tab-1">
                  <ul class="tab-nav clearfix">
                    <li class="noMobileMargin"><a href="#tabs-1"><span> Additional Description</span></a> </li>
                    <!-- <li><a href="#tabs-2"><span> Additional Information</span></a> </li> -->
                  </ul>
                  <div class="tab-container">
                    <div class="tab-content clearfix" id="tabs-1">
                           <p><?php if(!empty($product->long_desc)) { echo html_entity_decode($product->long_desc); } else { echo "No data found";} ?></p>
                     
                  </div>
                  <!-- <div class="tab-content clearfix" id="tabs-2">
                  <p><?php //if(!empty($product->add_desc)) { echo html_entity_decode($product->add_desc); } else { echo "No data found";} ?></p>
                  </div> -->

                </div>
              </div>
            </div>
            @endif
          </div>
         
          @if($is_rel_prod->status)
        
            @if(count($product->relatedproducts()->get()) >0)
          <div class="col_full bottommargin" >
             
            <h4>Related Products</h4>
            <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
             <!--<div class="item" ng-repeat="res in records" ng-class="{active:!$index}">-->
              @foreach($product->relatedproducts()->with('catalogimgs')->get() as $relProduct)
                <div class="oc-item" >
                <div class="product clearfix mobwidth100 relatedProduct">
                  <div class="product-image">
                    <a href="{{route('home').'/'.$relProduct->url_key}}"><img src="{{asset(Config('constants.productImgPath')).'/'.$relProduct->catalogimgs[0]->filename}}" alt="{{$relProduct->product}}" class="boxSizeImage"> </a>
                    <!-- <a href="#"><img src="images/shop/yellow-half-sleeve2.jpg" alt="Unisex Sunglasses"> </a> -->
                    <div class="product-overlay"> <a href="{{route('home').'/'.$relProduct->url_key}}" class="add-to-cart"><i class="icon-shopping-cart"></i><span> View Detail</span></a> <a href="#" class="item-quick-view"><i class="icon-heart"></i><span>Wishlist</span></a> </div>
                  </div>
                  <div class="product-desc">
                    <div class="product-title">
                      <h3><a href="{{route('home').'/'.$relProduct->url_key}}">{{$relProduct->product}}</a></h3> </div>
                       
                    <div class="product-price" >
                         @if($relProduct->spl_price > 0 && $relProduct->price > $relProduct->spl_price)
                        <del><span class="currency-sym"></span> {{number_format($relProduct->price * Session::get('currency_val'), 2, '.', '')}}</del> <ins><span class="currency-sym"></span>{{number_format($relProduct->spl_price * Session::get('currency_val'), 2, '.', '')}} </ins>
                         @else 
                        <ins><span class="currency-sym"></span> {{number_format($relProduct->price * Session::get('currency_val'), 2, '.', '')}}</ins>
                       @endif
                    </div>
                   
                  </div>
                </div>
              </div>
             @endforeach

            </div>
          </div>
            @endif
          @endif
          <!-- You may like also section open -->
          @if($is_like_prod->status)
           
              @if(count($product->upsellproducts()->get()) >0)
            <div class="col_full nobottommargin" >
                <h4>You may like also</h4>
                <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
                    @foreach($product->upsellproducts()->with('catalogimgs')->get() as $upSellProduct)
                    <div class="oc-item" >
                        <div class="product clearfix mobwidth100 youmayLikeProduct">
                            <div class="product-image">
                                <a href="{{route('home').'/'.$upSellProduct->url_key}}"><img src="{{asset(Config('constants.productImgPath')).'/'.$upSellProduct->catalogimgs[0]->filename}}" alt="{{$upSellProduct->product}}" class="boxSizeImage"> </a>
                               <!--  <a href="[[prdr.url_key]]"><img src="[[prdr.img]]" alt="[[prdr.product]]"> </a> -->
                                <div class="product-overlay"> <a href="{{route('home').'/'.$upSellProduct->url_key}}" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a> <a href="#" class="item-quick-view"><i class="icon-heart"></i><span>Wishlist</span></a> </div>
                            </div>
                            <div class="product-desc">
                                <div class="product-title">
                                    <h3><a  href="{{route('home').'/'.$upSellProduct->url_key}}">{{$upSellProduct->product}}</a></h3> </div>
                               
                                    <div class="product-price"> 
                                             @if($upSellProduct->spl_price >0 && $upSellProduct->price > $upSellProduct->spl_price)
                                            <del><span class="currency-sym"></span> {{number_format(@$upSellProduct->price * Session::get('currency_val'), 2, '.', '')}}</del> <ins><span class="currency-sym"></span> {{number_format(@$upSellProduct->spl_price * Session::get('currency_val'), 2, '.', '')}}</ins>
                                            @else 
                                            <ins><span class="currency-sym"></span> {{number_format(@$upSellProduct->price * Session::get('currency_val'), 2, '.', '')}}</ins>
                                            @endif
                                        </div>
                               
                                
                            </div>
                        </div>
                    </div>
@endforeach
                </div>
            </div>
              @endif
          @endif
          <!-- You may like also section close -->
        </div>
    </section>
</div>
@stop
@section('myscripts')
<script>
    $(document).ready(function () {
        $('head').append('<meta property="og:image" content="<?= $product->prodImage ?>" /> ');
        
   $( "div" ).delegate( "select", "change", function() {
   $(".optError").remove();
});
 
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
        
        // Get its current value
        var currentVal = parseInt($('input[name="quantity"]').val());
        //  console.log(currentVal);
        // If is not undefined
        if (!isNaN(currentVal) && (currentVal < maxvalue)) {
            // Increment
            //$('.plus').css('pointer-events', '');
            $('input[name="quantity"]').val(parseInt(currentVal) + 1);
          //   alert(parseInt(currentVal)+ 1);
        } else if (currentVal >= maxvalue) {
            // console.log(maxvalue);
            //$('.plus').css('pointer-events', 'none');
            $('input[name="quantity"]').val(parseInt(maxvalue));
        } else {
            // Otherwise put a 0 there
            $('#quantity').val(1);
        }
    });

    $('.minus').click(function (e) {
        var minvalue = parseInt($('input[name="quantity"]').attr('min'));

        // Stop acting like a button
        e.preventDefault();
        var currentVal = parseInt($('input[name="quantity"]').val());

        if (minvalue < currentVal){
            $('input[name="quantity"]').val(parseInt(currentVal) - 1);

        }else{
           $('#quantity').val(1); 
        }
            


    });
 
</script>
@stop