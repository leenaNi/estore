<div id="content" class="site-content shop-content left-sidebar">
    <div class="container">
        <div class="row">
            <main id="main" class="site-main col-md-9">
                <div class="sort clearfix">
                </div>
                <div id="mainList" class="prodlist">
                    <div  class="products list">
                        @foreach($prods as $prod)
                        @include(Config('constants.frontendCatlogProducts').'.prodCard',['prod'=>$prod])
                        @include(Config('constants.frontendCatlogProducts').'.quickView',['prod'=>$prod])
                        @endforeach
                    </div>

                </div>
                <?php
                $args = [];
                $args['slug'] = $getslug;
                $prods->appends($args);
                ?>                <a href="javascript:void(0)" data-nexturl="{{$prods->nextPageUrl() }}" class="button black  showmore">Show More </a>
                <div>
            </main><!-- .site-main -->
        </div><!-- .row -->
        <!-- .container -->
    </div><!-- .site-content -->