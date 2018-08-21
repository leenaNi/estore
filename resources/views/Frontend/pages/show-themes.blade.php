@extends('Frontend.layouts.default')
@section('content')
<section id="page-title" class=" page-title-center" style=" padding: 50px 0;" data-stellar-background-ratio="0.3">

    <div class="container clearfix">
        <h1 class="">Themes for your online store</h1>
        <span class="">Easily customizable and mobile friendly themes to match your brand</span>
    </div>

</section><!-- #page-title end -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Portfolio Filter
            ============================================= -->
            <ul id="portfolio-filter" class="portfolio-filter  style-4 clearfix " data-container="#portfolio">
                @if(empty(Session::get('merchantid')))
                <li class="activeFilter"><a href="#" data-filter=".tab0" data-filter="*">All</a></li>
                @endif
                @foreach($cats as $c)
                <li><a href="#" data-filter="{{'.tab'.$c->id}}">{{$c->category}}</a></li>
                @endforeach
            </ul><!-- #portfolio-filter end -->



            <div class="clear"></div>

            <!-- Portfolio Items
            ============================================= -->
            <div id="portfolio" class="portfolio  grid-container clearfix">
   @foreach($cats as $c)
   
   @foreach(App\Models\StoreTheme::where("cat_id",$c->id)->where("status",1)->get() as $theme)
  <?php $themimg = ($theme->image)?$theme->image:'default-theme.png'; ?>
   
                <article class="portfolio-item tab{{$c->id}} tab0">
                    <div class="portfolio-image port-img-outline">
                    
                            <img src="{{ asset('public/admin/themes/'.$themimg) }}" alt="{{$theme->name}}">
                        </a>
                      
                                <div class="portfolio-overlay">
                                    <div class="center-text" >
                                        <h3 class="nobottommargin white-text">{{$theme->name}}</h3>
                                <a type="button" href="{{ asset('themes/'.strtolower($theme->name)."_home.php") }}" target="_blank" class="btn btn-block marginauto btn-trans-whiteborder">View Demo</a>
                                    </div>
                                </div>
                    </div>
                </article>
   
   @endforeach
@endforeach



            </div><!-- #portfolio end -->

        </div>

    </div>

</section>
@stop