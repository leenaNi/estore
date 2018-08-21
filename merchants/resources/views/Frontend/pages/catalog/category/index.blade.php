@extends('Frontend.layouts.default')
@section('content')

<div class="container" ng-controller="productListingController">
    <div class="row">
        <main id="main" class="site-main col-md-9 mar-bot-50-300">
            <div class="sort clearfix">
                <form action="#" class="ordering pull-right sorting300" >
                    <div class="selectbox emphasize">
                        <select class="orderby" ng-init="- 1" ng-model="sel" name="orderby" ng-change="applyFilters()">
                            <option  value="1" selected="selected">Default sorting</option>
                            <option value="2">Popularity</option>
                            <option value="3">Discount</option>
                            <option  value="4">Price Low-High</option>
                            <option  value="5">Price High-Low</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="products list Nlist">
                <div class="row">   
                    <div class="product" ng-repeat="prd in pdts">
                        <form id="form[[prd.id]]" action="{{ route('addToCart')}}">
                            <div class="p-inner row">

                                <div class="Npthumb p-thumb col-md-4 col-sm-5">
                                    <a href="{{ route('home')}}/[[prd.url_key]]">
                                        <img ng-if="prd.catalogimgs != ''" src="[[prd.mainImage]]" alt="[[prd.alt_text]]">
                                        <img ng-if="prd.catalogimgs == ''" src="{{ @asset(Config('constants.productImgPath'))}}/default-image.jpg" alt="default-image">
                                    </a>
                                </div><!-- .p-thumb -->
                                <div class="p-info col-md-8 col-sm-7">
                                    <div  class="quick-view quick-view1" rel="product-quickview" style="cursor:pointer;" ng-click='quickpopup("quick" + prd.id)'>QUICK LOOK</div>
                                    <h3 class="p-title  product-name mar-bot-5"><a href="[[prd.url_key]]">[[prd.product]]</a></h3>
                                    <span class="price">
                                        <ins> <span class="currency-sym"></span> <span class="amount priceConvert">[[ prd.getPrice  * currency_val | number : 2 ]]</span></ins>
                                        <del ng-show="prd.delPrice == 1"><span class="currency-sym"></span> <span class="priceConvert">[[ prd.price  * currency_val | number : 2 ]]</span></del>
                                    </span>
                                    <input type='hidden' name='prod_id' value='[[prd.id]]' data-parentid = "[[prd.id]]">
                                    <input type='hidden' name='prod_type' value='[[prd.prod_type]]'>

                                    <input type="hidden" name="quantity"  value="1"  max="[[prd.stock]]" class="qty" style="text-align: center;" /> 
                                    <div class="pro-actions" style="margin:0px; padding:0px;">
                                        <button form-id='[[prd.id]]' id="cart-[[prd.id]]" class="button yellow add-to-cart-button addToCart1200 addToCart768 addToCart [[ prd.checkExists===false? '' : 'disabled']]" ><i class="icon-cart"></i> <span>Add to cart</span></button>
                                        <a href="javascript:void(0)" data-prodid="[[prd.id]]"  class="button yellow add-to-wishlist wishlist768 [[ prd.chkwishlist === 1 ? 'red-heart' : '']]"><i class="fa fa-heart"></i></a>
                    <!--                    <a href="#" class="button square dark quick-view"><i class="icon-zoom"></i></a>-->
                                    </div> 
                                    <!--                                    <div class="prod-btm-button">
                                                                            <a href="javascript:void(0)" form-id='[[prd.id]]' class="button black add-to-cart-button addToCart"><i class="icon-cart"></i><span>Add to cart</span></a>
                                                                        </div>-->
                                    <div class="p-desc">
                                        <p> [[prd.short_desc]] </p>
                                    </div><!-- .p-desc -->
                                </div><!-- .p-info -->
                            </div><!-- .p-inner -->
                        </form>
                        <div id="quick[[prd.id]]" class="quickview popup">
                            <div class="quickview-inner popup-inner clearfix">
                                <a href="javascript:void(0);"  ng-click="popupclose(prd.id)" class="popup-close">Close</a>
                                <form id="formquick[[prd.id]]" action="{{ route('addToCart')}}" method="post">
                                    <div class="images">
                                        <div class="p-preview">
                                            <div class="slider">
                                                <div class="item  app-figure" ng-repeat="prdimgs in prd.catalogimgs">
                                                    <a id="Zoom-[[prd.id]]" class="MagicZoom" href="{{ @asset(Config('constants.productImgPath'))}}/[[prdimgs.filename]]">
                                                        <img src="{{ @asset(Config('constants.productImgPath'))}}/[[prdimgs.filename]]" alt="[[prdimgs.alt_text]]">
                                                    </a>
                                                </div>
                                            </div>

                                        </div><!-- #p-preview --> 
                                        <div class="p-thumb">
                                            <div class="thumb-slider">
                                                <div ng-if="prd.catalogimgs.length > 0" class="item" ng-repeat="prdimgs in prd.catalogimgs">
                                                    <a href="{{ @asset(Config('constants.productImgPath'))}}/[[prdimgs.filename]]">
                                                        <img src="{{ @asset(Config('constants.productImgPath'))}}/[[prdimgs.filename]]" alt="[[prdimgs.alt_text]]" />
                                                    </a>
                                                </div>
                                                <div ng-if="prd.catalogimgs.length == 0">
                                                    <a href="{{ @asset(Config('constants.productImgPath'))}}/default-image.jpg">
                                                        <img src="{{ @asset(Config('constants.productImgPath'))}}/default-image.jpg" alt="default-image" />
                                                    </a>
                                                </div>
                                            </div><!-- .thumb-slider -->
                                        </div><!-- #p-thumb -->
                                    </div><!-- .images -->
                                    <div class="summary">
                                        <h3 class="p-title"><a href="/[[prd.url_key]]">[[prd.product]]</a></h3>
                                        <span class="price">
                                            <ins><span class="currency-sym"></span><span class="amount priceConvert"> [[ prd.getPrice  * currency_val | number : 2 ]]</span></ins>
                                            <del ng-show="prd.delPrice == 1"><span class="currency-sym"></span> <span class="priceConvert">[[ prd.price  * currency_val | number : 2 ]]</span></del>
                                        </span>

                                        <div class="p-desc" style="display: block;">
                                            <p>[[ prd.short_desc | htmlToPlaintext ]]</p>
                                        </div><!-- .p-desc -->
                                        <input type='hidden' name='prod_id' value='[[prd.id]]' data-parentid = "[[prd.id]]">
                                        <input type='hidden' name='prod_type' value='[[prd.prod_type]]'>
                                        <input type="hidden" name="quantity" value="1"  max="[[prd.stock]]" class="qty" style="text-align: center;" size="4"/> 
                                        <div class="attribute attribute-actions clearfix">
                                            <!--                                                <div class="attr-item">
                                                                                                <label>Qty:</label>
                                                                                                <div class="quantity">
                                                                                                    <input type="number" name="quantity" value="1"  max="[[prd.stock]]" class="qty" style="text-align: center;" size="4"/> 
                                                                                                </div>
                                                                                            </div>-->
                                            <!-- .attr-item -->
                                            <div class="attr-item">
                                                <div class="attr-item" >

                                                    <div class="prod-btm-button" ng-if="prd.stock > 0">
                                                        <a  href="javascript:void(0);" form-id="quick[[prd.id]]" class="button yellow add-to-cart-button addToCart" style="margin-top: -10px;"><i class="icon-cart"></i><span> Add to cart</span></a>
                                                        <a href="javascript:void(0)" data-prodid="[[prd.id]]"  class="button black add-to-wishlist [[ prd.chkwishlist === 1 ? 'red-heart' : '']]"><i class="fa fa-heart"></i></a>
                                                    </div>
                                                    <div ng-if="prd.stock == 0">Out of Stock</div>
                                                </div><!-- .attr-item -->
                                            </div><!-- .attr-item -->
                                        </div><!-- .attribute -->
                                        <div class="single-share">
                                            <strong>SHARE THIS:</strong>
                                            <div class="social">
                                                <span class='st_facebook_large' displayText='Facebook'></span>
                                                <span class='st_googleplus_large' displayText='Google +'></span>
                                                <span class='st_twitter_large' displayText='Tweet'></span>
                                                <span class='st_linkedin_large' displayText='LinkedIn'></span>
                                                <span class='st_pinterest_large' displayText='Pinterest'></span>
                                                <span class='st_email_large' displayText='Email'></span>
                                            </div>
                                        </div><!-- .single-share -->
                                    </div><!-- .summary -->
                                </form>
                            </div><!-- .quickview-inner -->
                            <div class="mask popup-close"></div>
                        </div>
                    </div>


                </div><!-- .product -->
            </div><!-- .products -->
            <div class="pagination padding-top-zero">
                <a href="#" class="button black" ng-if="nextpageurl != null"  ng-click="load($event, nextpageurl)">Load More</a>
                <a href="#" class="button black" ng-if="nextpageurl == null" >No More Products</a>
            </div>
        </main><!-- .site-main -->
        <div id="sidebar" class="sidebar left-sidebar col-md-3 mar-bot-zero">
            <aside class="widget product-cat-widget">
                <h3 class="widget-title">Filter By</h3>
                <ul class="gw-nav gw-nav-list">
                    <li ng-repeat="filtername in getfilters" class="init-arrow-down"> 
                        <a href="javascript:void(0)"> <span class="gw-menu-text">[[ filtername.filterby ]]</span> <b></b> </a>
                        <span  ng-repeat="(childk, childv) in filtername.childs">
                            <input type="checkbox" class="filterChk" name="filter[]" ng-model="filteredCheck[childk]" ng-click="filterProds(childk, filtername.filterby)" ng-checked="getPreFilters([[childk]])">
                            <span class="">[[childv]]</span><br/>
                        </span>
                    </li>
                    <!-- //tej code -->
                    <li class="init-arrow-down" ng-if="catChild.length > 0"> 
                        <a href="javascript:void(0)"> <span class="gw-menu-text">Category</span> <b></b> </a>
                        <span ng-repeat="cat in catChild">
                            <input type="checkbox" class="filterChk" name="filterd[]" ng-model="filteredCheck[cat.id]" ng-click="filterProds(cat.id, 'cat')" ng-checked="getPreFilters([[cat.id]])">
                            <span class="">[[cat.category]]</span><br/>
                        </span>
                    </li>
                    <!-- //tej code -->
                </ul>
            </aside>
            <aside class="widget">
                <h3 class="widget-title">Price</h3>
                <div class="f-price">
                    <div id="slider-range"></div>
                    <span>Price: <strong id="amount" ></strong></span>
                    <span class="currency-sym"></span>&nbsp;
                    <input type="hidden" id="min_price" name="min_price" min="0" placeholder="Min price" class="min-price-filter">&nbsp;-&nbsp;
                    <span class="currency-sym"></span>&nbsp;
                    <input type="hidden" id="max_price" name="max_price" placeholder="Max price" class="max-price-filter">
                    <button class="btn btn-dashed textup"  ng-click="applyFilters()" type="button">Filter now</button>
                </div>
            </aside>
        </div><!-- .left-sidebar -->
    </div><!-- .row -->
</div><!-- .container -->




@stop

@section('mystyles')
<style>
    .red-heart {
        color: #F00;
    }
</style>
@stop
@section("myscripts")
<script>

    $(document).ready(function () {
    var maxp = '{{$maxp}}';
    var minp = '{{$minp}}';
    //console.log("Min price => " + minp + "Max price => " + maxp);
    $('#slider-range').slider({
    range: true,
            min: minp,
            max: maxp,
            values: [minp, maxp],
            slide: function (event, ui) {
            $("#min_price").val(Math.round(ui.values[0] * <?php echo Session::get('currency_val'); ?>));
            $("#max_price").val(Math.round(ui.values[1] * <?php echo Session::get('currency_val'); ?>));
            $('#amount').text('Amt. ' + Math.round(ui.values[0]) + ' - Amt. ' + Math.round(ui.values[1]));
            }
    });
    $('#amount').text('Amt. ' + $('#slider-range').slider('values', 0) + ' - Amt. ' + $('#slider-range').slider('values', 1));
    });
</script>
@stop
