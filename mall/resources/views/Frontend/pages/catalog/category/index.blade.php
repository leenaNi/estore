@extends('Frontend.layouts.default')
@section('content')
@if($cat_name)
<section id="page-title"> 
    <div class="container clearfix">
        <h1>{{$cat_name}}</h1>
    </div>
</section>
@endif
<div class="clearfix"></div>
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix topmargin-sm bottommargin-sm" ng-controller="productListingController">
            <div class="sidebar nobottommargin col-md-2">
                <div class="sidebar-widgets-wrap">
                    <div class="widget clearfix">
                        <h5 class="widget-title price-wid" ng-show="pdts.length > 0">Price</h5>
                        <div class="f-price price-rangebox price-wid" ng-show="pdts.length > 0">
                            <span> <strong id="amount" ></strong></span>
                            <div class="minPriceBox"><span class="currency-sym"></span>
                                <input type="text" id="min_price" name="min_price" min="0" placeholder="Min price" class="min-price-filter"></div><div class="priceHypen">-</div>
                            <div class="maxPriceBox"><span class="currency-sym"></span> 
                                <input type="text" id="max_price" name="max_price" placeholder="Max price" class="max-price-filter">
                            </div>
                            <div class="clearfix"></div>
                            <div id="slider-range"></div>
                            <div class="filterbtn-box"><button class="btn btn-dashed textup themebtn-color" ng-click="applyFilters()" type="button">Apply</button></div>
                        </div>

                        <div class="widget clearfix" ng-if="catChild.length > 0 && pdts.length > 0">
                            <h5 class="widget-title">Categories</h5>
                            <ul class="cat-list">
                                <li ng-repeat="cat in catChild" ><a href="javascript:void(0)">
                                        <label class="filtercheckbox">[[cat.category]] <input type="checkbox"  class="filterChk" name="filterd[]" ng-model="filteredCheck[cat.id]" ng-click="filterProds(cat.id, 'cat')" ng-checked="getPreFilters([[cat.id]])">
                                            <span class="checkmark"></span>
                                        </label>
                                    </a> 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .sidebar end -->

            <div id="shop" class="shop col-md-9 product-3 clearfix bottommargin-sm">
                <div class="product clearfix" ng-repeat="prd in pdts">
                    <form id="form[[prd.id]]" action="{{ route('addToCart')}}">
                        <div class="product-image producImgBoxSize_4Col">
                            <img src="images/products/t-shirt.jpg" alt="">
                            <a href="{{ route('home')}}/[[prd.prefix]]/[[prd.url_key]]">
                                <img ng-if="prd.catalogimgs != ''" src="[[prd.mainImage]]" alt="[[prd.alt_text]]">
                                <img ng-if="prd.catalogimgs == ''" src="{{ @asset(Config('constants.productImgPath'))}}/default-image.jpg" alt="default-image">
                            </a>
                        </div>
                        <div class="product-desc text-center">
                            <div class="product-title">
                                <h4><a href="[[prd.prefix]]/[[prd.url_key]]">[[prd.product]]</a>
                                <!-- <span class="subtitle">Flat 10% Off*</span> -->
                                </h4>
                            </div>
                            <input type='hidden' name='prod_id' value='[[prd.id]]' data-parentid = "[[prd.id]]">
                            <input type='hidden' name='prod_type' value='[[prd.prod_type]]'>
                            <input type="hidden" name="quantity"  value="1"  max="[[prd.stock]]" class="qty" style="text-align: center;" /> 
                            <div class="product-price">
                                <del ng-show="prd.delPrice == 1"><span class="currency-sym"></span> <span class="priceConvert">[[ prd.price  * currencyVal | number : 2 ]]</span></del>
                                <ins> <span class="currency-sym"></span> <span class="amount priceConvert">[[ prd.getPrice  * currencyVal | number : 2 ]]</span></ins>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="text-center col-md-12">
                    <a href="#" class="button button-large button-dark  topmargin-sm" ng-if="nextpageurl != null"  ng-click="load($event, nextpageurl)">Load More</a>
                    <!--<a href="#" class="button button-large button-dark  topmargin-sm">Load More</a>--> 
                </div>

                <div class="content-wrap text-center errorBlock" ng-show="pdts.length == 0">
                    <div class="button button-large button-dark " style="text-align: center;">No product found</div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div><!-- .container -->
    </div>
</section>
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
        minP = 0;
        minp = 0;
        maxP = <?php echo (@$maxp) ? $maxp * Session::get('currency_val') : '0'; ?>;
        maxp = <?php echo (@$maxp) ? $maxp * Session::get('currency_val') : '0'; ?>;
        maxp = Math.ceil(maxp);
        console.log("Min price => " + minp + "Max price => " + maxp);

        $('#slider-range').slider({
            range: true,
            min: minp,
            max: maxp,
            values: [minp, maxp],
            slide: function (event, ui) {
                $("input[name='min_price']").val(Math.round(ui.values[0] ));
                $("input[name='max_price']").val(Math.round(ui.values[1]));
            }
        });
        $("input[name='min_price']").val(minp);
        $("input[name='max_price']").val(maxp);
//        $('#amount').text('Amt. ' + $('#slider-range').slider('values', 0) + ' - Amt. ' + $('#slider-range').slider('values', 1));
    });
</script>
@stop
