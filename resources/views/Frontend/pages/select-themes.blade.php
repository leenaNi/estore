@extends('Frontend.layouts.default')
@section('content')
<!-- Page Title
                       ============================================= -->
<section id="page-title" class=" page-title-center" style=" padding: 50px 0;" data-stellar-background-ratio="0.3">
    @if(!empty(Session::get('merchantid')) && Session::get('merchantstorecount') <= 0)
    <div class="container clearfix">
        <h1 class="">Welcome to the VeeStores family</h1>
        <span class=""> Select a theme for your online {{ ucwords($cats->first()->category) }}  store</span>
    </div>
    @else
    <div class="container clearfix">
        <h1 class="">Themes for your online store</h1>
        <span class="">Easily customizable and mobile friendly themes to match your brand</span>
    </div>
    @endif
</section><!-- #page-title end -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <!-- Portfolio Filter
            ============================================= -->
            <ul id="portfolio-filter" class="portfolio-filter  style-4 clearfix " data-container="#portfolio">
                @if(empty(Session::get('merchantid')))
                <li class="activeFilter"><a href="#" data-filter=".tab0" data-filter="*">All</a></li>
                @foreach($cats as $c)
                <li><a href="#" data-filter="{{'.tab'.$c->id}}">{{$c->category}}</a></li>
                @endforeach
                @endif             

            </ul><!-- #portfolio-filter end -->
            <div class="clear"></div>
            <!-- Portfolio Items
            ============================================= -->
            <div id="portfolio" class="portfolio  grid-container clearfix">
                @foreach($cats as $c)
                @foreach(App\Models\StoreTheme::where("cat_id",$c->id)->where("status",1)->orderBy('sort_orders','asc')->get()  as $themeK=>$theme)
                <?php
                $themimg = ($theme->image) ? $theme->image : 'default-theme.png';
                $themeK++;
                 if($theme->theme_type==2 && !in_array($theme->id,$themeIds)){
                   $action= route('getCityPay');
                }else{
                      $action= route('waitProcess');
                }
                ?>
                <article class="portfolio-item tab{{$c->id}} tab0">
                    <div class="portfolio-image port-img-outline">
                        <form action="{{$action}}" method="post" class="sel-theme-form">
                            <a href="#">
                                <img src="{{ asset('public/admin/themes/'.$themimg) }}" alt="{{$theme->name}}">
                            </a>
                            <div class="portfolio-overlay">
                                <div class="center-text" >
                                    <h3 class="nobottommargin white-text">{{$theme->category['category']."".$themeK}} - {{$theme->theme_type==1?'Starter':'Advanced'}}</h3>
                                    @if(!empty(Session::get('merchantid')))
                                    <input type="hidden" name="storename" value="{{Session::get('storename')}}">
                                    <input type="hidden" name="firstname" value="{{$allinput['firstname']}}">
                                    <input type="hidden" name="email" value="{{$allinput['email']}}">
                                    <input type="hidden" name="telephone" value="{{$allinput['phone']}}">
                                    <input type="hidden" name="store_version" value="{{$allinput['store_version']}}">
                                    @if(!empty($allinput['password']))
                                    <input type="hidden" name="password" value="{{$allinput['password']}}">
                                    @endif
                                    @if(!empty($allinput['provider_id']))
                                    <input type="hidden" name="provider_id" value="{{$allinput['provider_id']}}">
                                    @endif
                                    <input type="hidden" name="business_type" value="{{$allinput['business_type']}}">
                                    <input type="hidden" name="already_selling" value="{{json_encode($allinput['already_selling'])}}">
                                    <input type="hidden" name="theme_id" value="{{$theme->id}}">
                                    <input type="hidden" name="cat_id" value="{{$c->id}}">
                                    <input type="hidden" name="domain_name" value="{{$allinput['domain_name']}}">
                                    <input type="hidden" name="currency" value="{{$allinput['currency']}}">
                                    @endif
                                    <a type="button" href="{{ asset('themes/'.strtolower($theme->name)."_home.php") }}" target="_blank" class="btn btn-block marginauto btn-trans-whiteborder">View Demo</a>
                                    @if(!empty(Session::get('merchantid')) && Session::get('merchantstorecount') <= 0)
                                 <button type="submit" class="btn theme-btn btn-block marginauto short-btn applythemebtn"> <?php echo $theme->theme_type==2 && !in_array($theme->id,$themeIds)?'Pay Now':'Apply Theme'  ?></button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </article>
                @endforeach
                @endforeach
            </div><!-- #portfolio end -->
        </div>
    </div>
</section>
@stop