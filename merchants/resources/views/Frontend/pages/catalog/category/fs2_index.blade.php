@extends('Frontend.layouts.default')
@section('title',$metaTitle)
@section('og-title',$metaTitle)
@section('meta-description',$metaDesc)
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<div ng-controller="productListingController">




    <section id="page-title">
        <div class="container clearfix">
            <h1>[[cat.category]]</h1>
            <ol class="breadcrumb">
                <li><a href="#">Home</a> </li>
                <li class="active">[[cat.category]]</li>
            </ol>
        </div>
    </section>
    <!-- Content
                ============================================= -->

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="col-md-12 clearfix">
                    <select class="form-control pull-right sort-dropdown" ng-init="-1" ng-model="sel" name="orderby" ng-change="applyFilters()">
                        <option value="1" selected="selected">Popularity</option>
                        <option value="2">Newest</option>
                        <option  value="3">Price Low-High</option>
                        <option  value="4">Price High-Low</option>
                        <option  value="5">A-Z</option>
                        <option  value="6">Z-A</option>
                    </select>
                </div>
                <div class="sidebar nobottommargin col-md-2">
                    <div class="sidebar-widgets-wrap">
                    <aside class="widget">
                            <h4 class="widget-title pricerange-titlebox">Filter By Price </h4>
                            <div class="f-price price-rangebox">
                                <span> <strong id="amount" ></strong></span>
                                <div class="minPriceBox"><span class="currency-sym"></span>
                                <input type="text" id="min_price" name="min_price" min="0" placeholder="Min price" class="min-price-filter"></div><div class="priceHypen">-</div>
                                <div class="maxPriceBox"><span class="currency-sym"></span> 
                                <input type="text" id="max_price" name="max_price" placeholder="Max price" class="max-price-filter">
</div>
                                <div class="clearfix"></div>
                                <div id="slider-range"></div>
                                <div class="filterbtn-box"><button class="btn btn-dashed textup themebtn-color"  ng-click="applyFilters()" type="button">Apply</button></div>
                            </div>
                        </aside>

                        <div class="widget clearfix">
                            <div class="accordion accordion-bg clearfix">

                                <div class="acctitle cat-title" ng-if="catChild.length > 0">Categories</div>
                                <div class="acc_content clearfix">
                                    <ul class="cat-list">
                                        <li ng-repeat="cat in catChild"><a  href="javascript:void(0)"><div>
                                                    <input id="[[cat.id]]" class="checkbox-style filterChk" type="checkbox" name="filterd[]"  ng-model="filteredCheck[cat.id]" ng-click="filterProds(cat.id, 'cat')" ng-checked="getPreFilters([[cat.id]])">
                                                    <label for="[[cat.id]]" class="checkbox-style-3-label">[[cat.category]]</label>
                                                </div></a> </li>


                                    </ul>
                                </div>
                                <div ng-repeat="filtername in getfilters" >
                                    <div class="acctitle cat-title"><i class="acc-closed icon-plus-sign"></i><i class="acc-open icon-minus-sign"></i>[[filtername.filterby ]]</div>
                                    <div class="acc_content clearfix">
                                        <ul class="cat-list">
                                            <li ng-repeat="(childk,childv) in filtername.childs"><a href="javascript:void(0)"><div>
                                                        <input id="[[childv]]"  class="checkbox-style filterChk" type="checkbox" name="filter[]" ng-model="filteredCheck[childk]" ng-click="filterProds(childk, filtername.filterby)" ng-checked="getPreFilters([[childk]])">
                                                        <label for="[[childv]]" class="checkbox-style-3-label">[[childv]]</label>
                                                    </div></a> </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- .sidebar end -->
                <div id="shop" class="shop col-md-9 product-3 clearfix bottommargin-sm">

                    <div class="product clearfix product-item productbox"  ng-repeat="prd in pdts" ng-if='[[prd.is_stock_status]]==1'>
                     
                        <div class="product-image product-image-listing">
                            <a href="{{ route('home')}}/[[prd.url_key]]"><img src="[[prd.mainImage]]" alt="[[prd.alt_text]]"> </a>
                            <a href="{{ route('home')}}/[[prd.url_key]]"><img  src="[[prd.mainImage]]" alt="[[prd.alt_text]]"> </a>
                            <div class="product-overlay2">
                                <a  href="{{ route('home')}}/[[prd.url_key]]" class="center-icon" data-toggle="tooltip" data-placement="top" title="View Detail"><i class="icon-line-plus"></i></a>

                            </div>
                        </div>
                        <div class="product-desc product-desc-transparent" style="margin-bottom: -20px;">
                            <div class="product-title"><h3><a href="{{ route('home')}}/[[prd.url_key]]">[[prd.product]]</a></h3></div>
                            <div class="product-price"><del ng-show="prd.delPrice == 1"> <span class="currency-sym"></span> <span class="priceConvert">[[ prd.price * currencyVal | number : 2 ]]</span></del> <ins><span class="currency-sym"></span>[[ prd.getPrice *currencyVal | number : 2 ]]</ins></div>
                        </div>
                            <div>
                                [[prd.reviews]] reviews , [[prd.ratings]]<i class="fa fa-star" aria-hidden="true"></i>
                            </div>
                            <div>
                                <form id="form[[prd.id]]" action="{{ route('addToCart') }}">
                                <input type="hidden" name='prod_id' value='[[prd.id]]'>
                                <input type="hidden" name='quantity' value='1'>
                                <input type="hidden" name='prod_type' value='[[prd.prod_type]]'>    
                                <input type="button"  form-id='[[prd.id]]' value="Add to cart" class="add-to-cart button nomargin addToCartB addToCart mobMB15 button-grey full-width-btn">
                                </form>
                            </div>
                        <!-- <div class="add-to-cart-btn">
                            <a  href="{{ route('home')}}/[[prd.url_key]]" class="button button-grey full-width-btn"><span>View Detail</span></a>
                        </div> -->
                    </div>
                    
<div class="clearfix"></div>
                    <div class="text-center col-md-12">
                        <a href="#" class="button button-large button-dark  topmargin-sm" ng-if="nextpageurl != null"  ng-click="load($event, nextpageurl)">Load More</a>
                        <!--<a href="#" class="button button-large button-dark  topmargin-sm">Load More</a>--> 
                    </div>
                    <div class="content-wrap col-md-12 text-center" ng-show="pdts.length == 0">
                        <div class="button button-large button-dark " style="text-align: center;">No product found</div>
                    </div>		

                </div>
                <div class="clearfix"></div>
            </div>
    </section>
</div>

@stop

@section("myscripts")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js"></script>
<script>

        $(function() {
          $( "#slider-range" ).slider();
        });


                        $(document).ready(function () {


                            minP = 0;
                            minp = 0;
                            maxP = <?php echo (@$maxp) ? $maxp * Session::get('currency_val') : '0'; ?>;
                            maxp = <?php echo (@$maxp) ? $maxp * Session::get('currency_val') : '0'; ?>;
                            maxp = Math.ceil(maxp);
                            console.log("fs2Min price => " + minp + "Max price => " + maxp);
//    setTimeout(sliderFun, 500);
//    var sliderFun = function(){
                            setTimeout(function () {
                                $('#slider-range').slider({
                                    range: true,
                                    min: minp,
                                    max: maxp,
                                    values: [minp, maxp],
                                    slide: function (event, ui) {

                                        $("input[name='min_price']").val(ui.values[0]);
                                        $("input[name='max_price']").val(ui.values[1]);
                                    }
                                });
                            }, 2000);
                            $("input[name='min_price']").val(minp);
                            $("input[name='max_price']").val(maxp);
                            console.log("Min price => " + minp + "Max price => " + maxp);
                            // $("#min_price").val(minp);

                            //   $("#max_price").val(maxp);
                            //};
                        });
</script>
@stop