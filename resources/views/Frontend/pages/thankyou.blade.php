@extends('Frontend.layouts.default')
@section('content')
<section id="slider" class="full-screen dark" style="background: url({{ asset(Config('constants.frontendPublicEstorifiImgPath').'/static.jpg') }}) center center no-repeat; background-size: cover">

    <div class="">

        <div class="container vertical-middle clearfix">
            <div class="heading-block center nobottomborder">
                <h1 data-animate="fadeInUp">Verify your email id</h1>
                <p data-animate="fadeInUp" data-delay="300">We have sent a verification link on your registered email id. Click on the link to complete the process.</p>
            </div>


        </div>

    </div>

</section>
@stop