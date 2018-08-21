@extends('Frontend.layouts.default')
@section('content')
    <section id="slider" class="slider-parallax clearfix slider-restro">
      <div class="slider-parallax-inner">
        <div class="fslider" data-arrows="true" data-pagi="false">
          <div class="flexslider">
            <div class="slider-wrap">
              @if(count($home_page_slider) > 0)
               @foreach($home_page_slider as $homeS)
              <div class="slide">
                <a href="{{ !empty($homeS->link)?$homeS->link:'javascript:void();'}}">
                    <img  src="{{ Config('constants.layoutImgPath').'/'.$homeS->image }}" alt="{{$homeS->alt}}"> </a>

              </div>
               @endforeach
               @else 
                <div class="slide">
                <a href="javascript:void();"> <img src="{{ Config('constants.defaultImgPath').'/default-banner.jpg') }}"  alt="Restro Image"> </a>
              </div>
               @endif
             
            </div>
          </div>
        </div>
      </div>

     
    </section>
 @stop