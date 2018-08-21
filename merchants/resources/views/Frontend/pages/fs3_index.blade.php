@extends('Frontend.layouts.default')
@section('content')
<section id="slider" class="full-screen clearfix">
  <div class="slider-parallax-inner">
    <div class="fslider" data-arrows="true" data-pagi="false">
      <div class="flexslider">
        <div class="slider-wrap">
          @if(count($home_page_slider) > 0)
          @foreach($home_page_slider as $homeS)
         
          <div class="slide">
            <a href="{{!empty($homeS->link)?$homeS->link:'javascript:void();'}}"> 
              <img src="{{Config('constants.layoutImgPath').'/'.$homeS->image }}" alt="{{$homeS->alt}}"> 
              <div class="flex-caption"><h2 class="nobottommargin text-center"> {{@$homeS->name}}</h2></div>
            </a>
            @if(Session::get('login_user_type') == 1)
                        <div class="updateHomeBanner">
<a href="#" class="button button-rounded" data-toggle="modal" data-target="#manageSlider"><span><i class="fa fa-pencil"></i>Manage Slider</span></a></div>
                        @endif
            </div>
            @endforeach
            @else 
            <div class="slide"> 
              <a href="#"> 
                <img src="{{ Config('constants.defaultImgPath').'/default-banner.jpg' }}" alt="Default Slider">
                <div class="flex-caption"><h2>{{ @$homeS->name}}</h2></div> 
              </a>
              <div class="updateHomeBanner">
                <a href="#" class="button button-rounded" data-toggle="modal" data-target="#manageSlider"><span><i class="fa fa-pencil"></i>Manage Slider</span></a></div>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>      
    </section> 
    @stop