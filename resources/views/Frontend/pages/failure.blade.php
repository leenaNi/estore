@extends('Frontend.layouts.default')
@section('content')
<section id="slider" class="full-screen dark" style="background: url({{ asset(Config('constants.frontendPublicImgPath').'/static.jpg') }}) center center no-repeat; background-size: cover">

    <div class="">

        <div class="container vertical-middle clearfix">
            <div class="heading-block center nobottomborder">
                <h1 data-animate="fadeInUp">OPPs Some Things went worng</h1>
                <p data-animate="fadeInUp" data-delay="300">Your payment is fail due to some issue.</p>
            </div>


        </div>

    </div>

</section>
@stop