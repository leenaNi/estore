@extends('Frontend.layouts.default')

@section('content')



<div id="content" class="site-content single-product">
    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('myProfile') }}">Home</a></li>
                <li><span class="current">My Account</span></li>
            </ul>
        </div><!-- .container -->
    </div><!-- .breadcrumb -->


    <div class="container">

        <div class="row">
            <div class="col-md-3">
                @include('Frontend.includes.myacc')
            </div>
            

            <main id="main" class="site-main col-md-9">
                 

                <div class="products list Nlist">
                <h3 class="widget-title">My Wishlist</h3>
                  <div class="row">
                        @foreach($whislist as $prod)

                        @include(Config('constants.frontendCatlogProducts').'.prodWishlist',['prod'=>$prod])

                        @endforeach

                        <!-- .product -->
                   </div>
                </div><!-- .products -->

            </main><!-- .site-main -->
            
            @foreach($whislist as $prod)

            @include(Config('constants.frontendCatlogProducts').'.quickView',['prod'=>$prod])
            @endforeach

        </div><!-- .row -->

    </div><!-- .container -->
</div><!-- .site-content -->
@stop
