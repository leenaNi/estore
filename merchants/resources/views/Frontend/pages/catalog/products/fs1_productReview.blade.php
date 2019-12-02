@extends('Frontend.layouts.default')

@section('title',$product->metaTitle)
@section('og-title',$product->metaDesc)
@section('meta-description',$product->metaTitle)
@section('content')
@php 
use App\Models\User;
use App\Models\CustomerReview;
@endphp
<style type="text/css">
      .rating {
  /*display: inline-block;*/
  position: relative;
  height: 50px;
  line-height: 50px;
  font-size: 50px;
}

.rating label {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  cursor: pointer;
}

.rating label:last-child {
  position: static;
}

.rating label:nth-child(1) {
  z-index: 5;
}

.rating label:nth-child(2) {
  z-index: 4;
}

.rating label:nth-child(3) {
  z-index: 3;
}

.rating label:nth-child(4) {
  z-index: 2;
}

.rating label:nth-child(5) {
  z-index: 1;
}

.rating label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.rating label .icon {
  float: left;
  color: transparent;
  font-size: medium;
}

.rating label:last-child .icon {
  color: #000;
}

.rating:not(:hover) label input:checked ~ .icon,
.rating:hover label:hover input ~ .icon {
  color: #09f;
}

.rating label input:focus:not(:checked) ~ .icon:last-child {
  color: #000;
  text-shadow: 0 0 5px #09f;
}   
</style>
<div class="clearfix"></div>
<section id="content">
    

<div class="container clearfix">
            <!-- <div class="single-product"> -->
  <h1>{{$product->product}}</h1>
  <div class="shortDesc"><?php echo html_entity_decode($product->short_desc) ?></div>
      @php 
    
       if(count($publishedReviews)>0)
       {
          $ratings = $totalRatings/count($publishedReviews);
       }
       else{
          $ratings = $totalRatings;
       }
      @endphp
      <div><h4>Reviews({{count($publishedReviews)}} reviews, {{$ratings}} <i class="fa fa-star" aria-hidden="true"></i>)</h4>
         @foreach($publishedReviews as $review)
         @php 
         $user = User::find($review->user_id);
         @endphp
         <span>{{$user->firstname}}</span>
         <h5 style="margin-bottom: 0px;">{{$review->title}}</h5>
       <div class="rating" style="    margin-bottom: -35px;line-height: 11px;">
  <label>
    <input type="radio" name="stars{{$review->id}}" disabled="" value="1" {{$review->rating==1?'checked':''}} />
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars{{$review->id}}" disabled="" value="2" {{$review->rating==2?'checked':''}} />
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars{{$review->id}}" disabled="" value="3" {{$review->rating==3?'checked':''}} />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>   
  </label>
  <label>
    <input type="radio" name="stars{{$review->id}}" disabled="" value="4" {{$review->rating==4?'checked':''}} />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars{{$review->id}}" disabled="" value="5" {{$review->rating==5?'checked':''}} />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
</div>
                               <span>{{$review->description}}</span><br><br>
                               @endforeach
</div>
</div>
</section>


@stop
@section('myscripts')


@stop