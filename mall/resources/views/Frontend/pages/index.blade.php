
@extends('Frontend.layouts.default')
@section('content')
<section id="slider" class="slider swiper_wrapper clearfix slider-parallax-visible">
    <div class="" style="transform: translateY(0px);">
        <div class="swiper-container swiper-parent swiper-container-horizontal" style="cursor: -webkit-grab;">
            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                <div class="swiper-slide dark swiper-slide-active slider" 
                     style="background-image: url({{Config('constants.layoutImgPath').'/banner1.jpg'}});">
                </div>
                <div class="swiper-slide dark swiper-slide-active slider"
                     style="background-image: url({{Config('constants.layoutImgPath').'/banner2.jpg'}});">
                </div>
                <div class="swiper-slide dark swiper-slide-active slider" 
                     style="background-image: url({{Config('constants.layoutImgPath').'/banner3.jpg'}});">
                </div>
                <div class="swiper-slide dark swiper-slide-active slider" 
                     style="background-image: url({{Config('constants.layoutImgPath').'/banner4.jpg'}});">
                </div>
            </div>
            <div id="slider-arrow-left" class="swiper-button-disabled" style="opacity: 1;"><i class="icon-angle-left"></i></div>
            <div id="slider-arrow-right" style="opacity: 1;"><i class="icon-angle-right"></i></div>
            <div id="slide-number"><div id="slide-number-current">1</div><span>/</span><div id="slide-number-total">3</div></div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<!-- Content
            ============================================= -->
<section id="content">
    @if(count($products) > 0)
    <div class="content-wrap" >
        <div class="container clearfix topmargin-sm">
            <div id="" class="heading-block title-center page-section">
                <h2>Trending Products</h2>
            </div>
            <div id="shop" class="shop clearfix">
                @foreach($products as $product)
                <div class="product clearfix">
                    <div class="product-image producImgBoxSize_4Col">
                        <a  href="{{route("home")}}/{{$product->prefix.'/'.$product->url_key}}"><img src="{{$product->mainImage}}" alt="{{$product->alt_text}}">
                        </a>
                    </div>
                    <div class="product-desc text-center">
                        <div class="product-title">
                            <h4 class="limit-txt"><a  href="{{route("home")}}/{{$product->prefix.'/'.$product->url_key}}">{{$product->product}}</a>
<!--                                <span class="subtitle">Flat 10% Off*</span>-->
                            </h4>
                        </div>
                        @if($product->spl_price > 0 && $product->price > $product->spl_price)
                        <div class="product-price">
                            <del><i class="currency-sym"></i> {{number_format($product->price * Session::get('currency_val'),2)}}</del> 
                            <ins><i class="currency-sym"></i>{{number_format($product->selling_price * Session::get('currency_val'),2)}}</ins>
                        </div>
                        @else
                        <div class="product-price">

                            <ins><i class="currency-sym"></i>{{number_format($product->selling_price * Session::get('currency_val'),2)}}</ins>
                        </div>
                        @endif
                        <!-- <a href="{{route("home")}}/{{$product->url_key}}" class="btn btn-default">View Detail</a> -->
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container topmargin">          
        <div id="" class="heading-block title-center page-section bottommargin-xxs">
            <h2>Shop By Industry</h2>
        </div>
    </div>
</div>
@endif
<!-- Portfolio Items
                          ============================================= -->
<div id="portfolio" class="portfolio grid-container portfolio-6 portfolio-nomargin clearfix">
    @foreach($rootsS as $rootcat)   
    <article class="portfolio-item pf-media pf-icons">
        <div class="portfolio-image">
            <a href="portfolio-single.html">
                <img src="{{Config('constants.catImgPath').'/'.(@$rootcat->catimgs->first()->filename)}}"  alt="Fashion">
            </a>
            <div class="portfolio-overlay">
                <a href="{{route("home")}}/explore/{{$rootcat->url_key}}">{{$rootcat->category}}</a>
            </div>
        </div>
    </article>
    @endforeach
</div><!-- #portfolio end -->
</section>
@stop
