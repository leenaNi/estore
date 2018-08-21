@extends('Frontend.layouts.default')
@section('content')
<div ng-controller="productListingController">
    <section id="page-title">
         <input type="hidden" value="{{Request::url()}}" class="fbShareUrl" />
        <input type="hidden" value="[[product.images[0].img]]" class="fbShareImg" />
        <span class="hide fbShareDesc">[[product.short_desc]]</span>
        <input type="hidden" value="[[product.product]]" class="fbShareTitle" />
        <div class="container clearfix">
            <ul class="catergories-filter">
                <li ng-repeat="cat in catChild"><a href="{{route('home')}}/explore/[[cat.url_key]]" class="currenttab">[[cat.category]]</a></li>
<!--                <li><a href="#">Breads</a></li>
                <li><a href="#">Rice and Biryani</a></li>
                <li><a href="#">Special Dishes</a></li>
                <li><a href="#">Desserts and Beverages</a></li>-->
            </ul>
        </div>
    </section>
    <!-- Content
                ============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">

                <div id="shop" class="shop col-md-12 product-4 clearfix bottommargin-sm">

                    <div class="product clearfix product-item productbox" ng-repeat="prd in pdts">
                        <div class="product-image">
                            <a href="#" ng-click='quickLook(prd.url_key)'><img src="[[prd.mainImage]]" alt="[[prd.alt_text]]"> </a>
                      <a href="#" ng-click='quickLook(prd.url_key)'><img  src="[[prd.mainImage]]" alt="[[prd.alt_text]]"> </a>
                            				

                        </div>
                        <div class="product-desc product-desc-transparent">
                            <div class="product-title"><h3><a href="#" ng-click='quickLook(prd.url_key)'>[[prd.product]]</a></h3></div>

                            <div class="product-price product-price-theme3"><del ng-show="prd.delPrice == 1"><span class="currency-sym"></span> [[ prd.price * currencyVal | number : 2 ]]</del> <ins><span class="currency-sym"></span></i>[[ prd.getPrice * currencyVal | number : 2 ]]</ins></div>
<!--                            <div  class="quick-view quick-view1" rel="product-quickview" style="cursor:pointer;" ng-click='quickLook(prd.url_key)'>QUICK LOOK</div>-->
                         
                            <div class="theme3-productdesc-box">

                 <a class="add-to-cart-theme3 theme3-button nomargin pull-right" ng-click='quickLook(prd.url_key)' title="add to cart"><i class="icon-cart"></i> <span class="addtocart-text">Add to Cart</span></a>
                            </div>
                        </div>

                    </div>
                     <div class="text-center col-md-12">
                         <a href="#" class="button button-large button-dark  topmargin-sm" ng-if="nextpageurl != null"  ng-click="load($event, nextpageurl)">Load More</a>
                        <a href="#" ng-show="pdts.length  >0"  class="button button-large button-dark  topmargin-sm" ng-if="nextpageurl == null" >No More Products</a>
                       
                    </div>
                    <div class="content-wrap text-center" ng-show="pdts.length == 0">
                        <div class="button button-large button-dark " style="text-align: center;">No product found.</div>
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
  
    <div class="modal fade out product_view disabled" id="product_viewtest">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="#" data-dismiss="modal" class="class pull-right"><span class="icon-remove"></span></a>
                    <h3 class="modal-title">[[product.product]]</h3>
                </div>
               
                <div class="modal-body">
                        <form id="form[[product.id]]" action="{{ route('addToCart')}}">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 product_img">
                            <img src="[[product.images[0].img]]" class="img-responsive">
                        </div>
                        <div class="col-md-6 col-sm-6 product_content">
                            <div class="product-desc">
                                <div class="product-rating" ng-if="product.product_code!=''">
                                    <p>PRODUCT CODE:[[product.product_code]]</p>
                                </div>
                                <div class="product-price" ng-show="product.spl_price > 0">
                                <del ><i class="icon-rupee"></i> [[product.price]] </del>   <i class="icon-rupee"></i><span class="mrp_price">[[product.selling_price]] </span>
                               <input type="hidden" name="price" value="[[product.spl_price]]" class="parent_price">
                                </div> 
                                 <div class="product-price" ng-show="product.spl_price ==0">
                                     <i class="icon-rupee"></i> <span class="mrp_price">[[product.selling_price]]</span>
                                  <input type="hidden" name="price" value="[[product.spl_price]]" class="parent_price">
                                 </div> 
                                @if($isstock==1)
                                <span ng-if="product.prod_type==1">
                                    <span class="span2" style="color:red;"  ng-show="product.is_stock == 1"><div ng-if="stocklimit > product.stock">STOCK LEFT - [[product.stock]]</div></span>
                                </span>
                                <span ng-if="product.prod_type!=1">
                                    <span class="span2 hide" style="color:red;"  ng-show="product.is_stock == 1">STOCK LEFT - [[product.stock]]</span></span>
                                @endif
                                <div class="row topmargin-sm">
                                     <div class="col-md-4 col-sm-6 col-xs-12 bottommargin-xs">
                            <div id="selAT">
                    <select  ng-repeat="(attrsk,attrsv) in selAttributes" name='[[attrsv.name]]' class="selatts attrSel form-control" id="selID[[$index]]"  ng-init="modelName = selaTT[[attrsk]]" ng-model="modelName"   ng-if="$index == 0" ng-change="selAttrChange(modelName, attrsk, $index + 1)" ng-options="optk as optv for (optk,optv) in attrsv.options " required>
                        <option value="">[[attrsv.placeholder]]</option>
                    </select>
                </div>
                <div ng-if="otherOptions.length == 0" >
                    <select ng-model="prodAttrValId" class='attrSel'  ng-change="getProductVarient(product.id, prodAttrValId)" >
                      
                        <option  ng-repeat="otherOptionsVal in otherOptions"  data-attr-id="[[getattrsval.attr_id]]" value="[[getattrsval.id]]">[[getattrsval.option_name]]</option>
                    </select>
                </div></div>
                                   
                                    <div class="col-md-4 col-sm-12 bottommargin-xs">
                                        
                                        <div class="quantity quantitypopup clearfix">
                                            <input type="button" value="-" class="minus quantitypopupinput">
                                              @if($isstock==1)
                                            <input type="text" step="1" min="1" name="quantity"  id="quantity" value="1" title="Qty" value="1"  max="[[(product.is_stock == 1)?product.stock:'1000000000']]" min="1" onkeypress="return isNumber(event);" class="qty quantitypopupinput" size="4" />
                                          @else
                                           <input type="text" step="1" min="1" name="quantity"  id="quantity" value="1" title="Qty" value="1"  max="1000000000" min="1" onkeypress="return isNumber(event);" class="qty quantitypopupinput" size="4" />
                                          @endif
                                       
                                            <input type="button" value="+" class="plus quantitypopupinput"> </div>
                                    </div>
                                    <input type='hidden' name='prod_id' value='[[product.id]]' data-parentid = "[[product.id]]">
                                <input type='hidden' name='prod_type' value='[[product.prod_type]]'>
                                <input type='hidden' name='sub_prod' value='' class="subPRod">
                                <!--<button type="button" form-id='[[product.id]]' class="add-to-cart button nomargin addToCartB addToCart">Add to cart</button>-->
                                </div>
                            </div>
                            <div class="clear"></div>
                           

                            <button type="button" form-id='[[product.id]]' class="add-to-cart button nomargin addToCartB addToCart"><i class="icon-cart"></i> <span class="addtocart-text">Add to cart</span></button>
                            <button type="button" data-prodid=" [[product.id]]" class="add-to-wishlist button nomargin"><i id="wish[[product.id]]" class="[[(product.wishlist == 1 )? 'icon-heart3 red-heart' : 'icon-heart']]"   style="margin-right:0px;"></i></button>

                     
                            <div class="clear"></div>
                            <div class="line topmargin-sm bottommargin-sm"></div>
                          <p ng-bind-html="product.short_desc | toTrust"></p> 
                            <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis at nisi optio dolor!</p>-->

                         
                            <div class="si-share noborder clearfix"> <span class="pull-left">Share:</span>
                                <div class="pull-left">
                                      <script type="text/javascript">var switchTo5x = true;</script>
                                        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                                        <script type="text/javascript">stLight.options({publisher: "a9b4ed1a-eda2-4ff3-96df-f9fa6e95bd6b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

                                        <span class='st_facebook_large' displayText='Facebook'></span>
                                        <span class='st_twitter_large' displayText='Tweet'></span>
                                        <span class='st_pinterest_large' displayText='Pinterest'></span>
                                        <span class='st_email_large' displayText='Email'></span>
                                        <span class='st_linkedin_large' displayText='LinkedIn'></span>
<!--                                    <a href="#" class="social-icon si-borderless si-facebook"> <i class="icon-facebook"></i> <i class="icon-facebook"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-twitter"> <i class="icon-twitter"></i> <i class="icon-twitter"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-pinterest"> <i class="icon-pinterest"></i> <i class="icon-pinterest"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-gplus"> <i class="icon-gplus"></i> <i class="icon-gplus"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-rss"> <i class="icon-rss"></i> <i class="icon-rss"></i> </a>
                                    <a href="#" class="social-icon si-borderless si-email3"> <i class="icon-email3"></i> <i class="icon-email3"></i> </a>-->
                                </div>
                            </div>
                           
                        </div>

                    </div>
                            </form>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- #content end -->
@stop
@section('myscripts')
<script>
 
   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 49 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $('.plus').click(function (e) {

        e.preventDefault();
        // Get the field name
        var maxvalue = parseInt($('input[name="quantity"]').attr('max'));
       // alert(maxvalue);
      
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

        if (minvalue < currentVal){                
        $('#quantity').val(parseInt(currentVal) - 1);

        }else{
          $('#quantity').val(1);   
        }
          


    });

</script>
@stop