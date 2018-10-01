@extends('Frontend.layouts.default')
@section('content')
<section id="page-title">
      <div class="container clearfix">
        <h1>About Us</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">About Us</li>
        </ol>
      </div>
    </section>
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col_half nobottommargin text-justify">
            <?php echo html_entity_decode($about->description) ?>
          </div>
            @if($about->image)
          <div class="col_half col_last nobottommargin">
            <img src="{{ asset(Config('constants.frontendStaticpage').$about->image)}}" class="img-responsive"/>
          </div>
            @endif
        </div>
      </div>
    </section>
@stop