@extends('Frontend.layouts.default')
@section('content')
<section id="slider" class="full-screen force-full-screen ohidden" style="background: url('{{ asset(Config('constants.frontendPublicEstorifiImgPath').'slider/4.jpg') }}') center center no-repeat; background-size: cover">

    <div class="">

        <div class="full-screen force-full-screen nopadding nomargin noborder ohidden">

            <div class="container mob-container clearfix">

                <div class="landing-wide-form landing-form-overlay dark nobottommargin clearfix"><!-- contact-widget-->



                    <!--<form action="#" id="getStartedForm" method="post" class="col-md-6 landing-wide-form landing-form-overlay dark nobottommargin clearfix">-->
                        <div class="heading-block nobottommargin nobottomborder">
                               @if(Session::get('storeadded'))
                        <div class="alert alert-danger"> {{ Session::get('storeadded') }}</div>
                        @endif
                            <h3>Create your online store in just 5 mins!</h3>
                            <span>No technical skills required. An all-in-one E-commerce platform.</span>
                        </div>
                        <div class="line" style="margin: 20px 0 20px;"></div>
<!--                        <div class="col_half bottommargin-xs">
                            <input type="text" class="form-control stName required not-dark"   name="store_name" placeholder="Enter Your Store Name">
                            <p class="error storeErr" style="color:red;"> </p>
                        </div>-->
                        @if(Session::get('merchantstorecount') <= 0  && !empty(Session::get('merchantid')))
                        <div class="col_full text-center bottommargin-xs noMobBottomMargin">
                            <a href="{{route('selectThemes')}}" class="btn theme-btn nomargin getVeestore"  value="Get Started" style="">Select Themes</a>
                        </div>
                        @else
                        <div class="col_full text-center bottommargin-xs noMobBottomMargin">
                            <a href="/new-store" class="btn theme-btn nomargin getVeestore">Get Started</a>
                            <!-- <input class="btn theme-btn nomargin getVeestore"  value="Get Started" type="submit" style="" data-toggle="modal" data-target="#getstartModal"> -->
                        </div>
                        @endif
                        <div class="clearfix"></div>

                        <!--  <div class="col_full topmargin-sm nobottommargin">
                             <button class="btn btn-default btn-block nomargin "  type="button">Get VeeStores free trial for a year today!</button>
                         </div> -->
                    <!--</form>-->



                </div>

            </div>

            <!--   <div class="image-wrap">
                  <img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/slider/4.jpg') }}" alt="Image">
              </div> -->

        </div>

    </div>

</section>


<!-- Content
            ============================================= -->
<section id="content">

    <div class="content-wrap nobottompadding">

        <div id="features-list"></div>
        <div class="container clearfix nobottommargin">
            <div class="row clearfix disp-flex">

                <div class="col-lg-5 col-md-5 col-sm-6">
                    <h2 class="marginBottom10">Highlights</h2>
                    <!--                     <form action="{{route('newstore')}}" id="getStartedForm" method="post">
                                             <input type="text" class="form-control required not-dark" required="true"  name="store_name" placeholder="Store Name">
                                            <input class="btn theme-btn btn-block nomargin" id="create_store" value="Get Started" type="submit" style="" >

                                        </form>-->



                    <ul class="iconlist iconlist-large iconlist-color">
                        <li><i class="icon-ok-sign"></i> Ready to use beautiful themes for 20+ business categories</li>
                        <li><i class="icon-ok-sign"></i> Customer Ordering App</li>
                        <li><i class="icon-ok-sign"></i> Start accepting online payments  </li>
                        <li><i class="icon-ok-sign"></i> In-built SEO</li>
                        <li><i class="icon-ok-sign"></i> Customer management to get ensure highest customer satisfaction index</li>
                        <li><i class="icon-ok-sign"></i> Coupons & discount management to woo more customers </li>
                        <li><i class="icon-ok-sign"></i> Loyalty program to reward returning customers</li>
                        <li><i class="icon-ok-sign"></i> Business App</li>
                        <li><i class="icon-ok-sign"></i> Inventory management to keep a track of your stocks</li>
                        <li><i class="icon-ok-sign"></i> Reports to analyse your stores performance</li>
                    </ul>
                    <div class="featuresListButton"><a href="/features" class="btn theme-btn nomargin">View Complete Features List</a></div>
                </div>

                <div class="col-lg-7  col-md-7 col-sm-6">

                    <div style="position: relative; bottom:-10px;" class="ohidden" data-height-lg="426" data-height-md="567" data-height-sm="470" data-height-xs="287" data-height-xxs="183">
                        <img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/main-fbrowser.png') }}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100" alt="Chrome">
                        <img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/main-fmobile.png') }}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="400" alt="iPad">
                    </div>

                </div>

            </div>
        </div>



        <div class="clearfix"></div>
        <div id="howitwork"></div>
        <div class="section notopmargin pd100topbottom mob-pd50topbottom">
            <div class="container clearfix">

                <div class="col_one_third nobottommargin mob-mb-30">
                    <div class="feature-box fbox-center fbox-light fbox-effect nobottomborder">
                        <div class="fbox-icon">
                            <a href="#"><i class="i-alt noborder icon-shopping-cart"></i></a>
                        </div>

                        <h3>Create an online store <br/>in just 5 minutes<span class="subtitle hidden-mobile">Set Up a business name, buy a domain, and create an online brand for free.</span></h3>
                    </div>
                </div>



                <div class="col_one_third nobottommargin mob-mb-30">
                    <div class="feature-box fbox-center fbox-light fbox-effect nobottomborder">
                        <div class="fbox-icon">
                            <a href="#"><i class="i-alt noborder icon-cloud-upload"></i></a>
                        </div>
                        <h3>Sell everything, <br/>everywhere!<span class="subtitle hidden-mobile">Use a single platform to sell products to anyone, anywhere - your ecommerce store, marketplaces, social media and in-person with point of sale.</span></h3>
                    </div>
                </div>

                <div class="col_one_third nobottommargin col_last">
                    <div class="feature-box fbox-center fbox-light fbox-effect nobottomborder">
                        <div class="fbox-icon">
                            <a href="#"><i class="i-alt noborder icon-thumbs-up2"></i></a>
                        </div>
                        <h3>Get live business insights <br/>and Market smarter<span class="subtitle hidden-mobile">Take the guesstimation out of marketing campaigns with built-in tools that help you create, execute, and analyze SMS and email campaigns.</span></h3>
                    </div>
                </div>

                <div class="clear"></div>

            </div>
        </div>
        <div class="clearfix"></div>



        <div class="container clearfix ">

            <div class="row notopmargin nobottommargin">

                <div class="heading-block center nobottommargin">
                    <h2 class="">Beautiful and professional themes for your online store</h2>
                </div>
                <div class="fslider testimonial testimonial-full nobottommargin" data-animation="slide" data-arrows="false" style="border:0px; box-shadow: none;">
                    <div class="flexslider">
                        <div class="slider-wrap">
                            <div class="slide">

                                <div class="col-lg-6 col-xs-12 sameheight">

                                    <div style="position: relative; margin-bottom: -60px;" class="ohidden" data-height-lg="426" data-height-md="567" data-height-sm="567" data-height-xs="260" data-height-xxs="260">
                                        <img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/theme1.png') }}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100" alt="Chrome">
                                    </div>

                                </div>
                                <div class="col-lg-6 col-xs-12 sameheight">
                                    <div class="heading-block content-vertica-middle">
                                        <h3>Wide varieties of custom themes to choose from</h3>
                                        <a href="{{route('selectThemes')}}" class="button button-border button-rounded topmargin-sm">View Samples</a>
                                    </div>
                                </div>
                            </div>
                            <div class="slide">

                                <div class="col-lg-6 col-xs-12 sameheight">

                                    <div style="position: relative; margin-bottom: -60px;" class="ohidden" data-height-lg="426" data-height-md="567" data-height-sm="567" data-height-xs="260" data-height-xxs="260">
                                        <img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/theme2.png') }}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100" alt="Chrome">
                                    </div>

                                </div>
                                <div class="col-lg-6 col-xs-12 sameheight">
                                    <div class="heading-block content-vertica-middle">
                                        <h3>Create an online store that matches your brand</h3>
                                        <a href="{{route('selectThemes')}}" class="button button-border button-rounded topmargin-sm">View Samples</a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section parallax dark topmargin-sm nobottommargin" style="background-image: url('{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/home-testi-bg.jpg') }}'); padding: 50px 0;" data-stellar-background-ratio="0.4">

            <div class="heading-block center">
                <h2>What Merchants Say?</h2>
            </div>

            <div class="fslider testimonial testimonial-full" data-animation="fade" data-arrows="false">
                <div class="flexslider">
                    <div class="slider-wrap">
                        <div class="slide">
                            <div class="testi-content">
                                <p>I am seriously happy about running my store on eStorifi. Powerful features and easy to set up, running an online store shouldn’t be this much fun!</p>
                                <div class="testi-meta">
                                    Naresh Guntuka
                                    <span>Radian Stores</span>
                                </div>
                            </div>
                        </div>
                        <div class="slide">
                            <div class="testi-content">
                                <p>eStorifi has helped me grow my business amazingly. It’s been a pleasure because everything has been easier than I ever imagined.</p>
                                <div class="testi-meta">
                                    Deepak Hase
                                    <span>Interlink Electronic</span>
                                </div>
                            </div>
                        </div>
                        <div class="slide">
                            <div class="testi-content">
                                <p>The best thing about eStorifi is that it’s made me not have to worry about anything that has to do with ecommerce.</p>
                                <div class="testi-meta">
                                    Avinash Sharma
                                    <span>Kirti Stores</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--   <div class="container clearfix">

              <div class="row topmargin-sm nobottommargin">
                  <div id="oc-clients" class="owl-carousel image-carousel carousel-widget" data-margin="60" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false" data-items-xxs="2" data-items-xs="3" data-items-sm="4" data-items-md="5" data-items-lg="6">

                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/1.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/2.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/3.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/4.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/5.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/6.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/7.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/8.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/9.png') }}" alt="Clients"></a></div>
                      <div class="oc-item"><a href="#"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/clients/10.png') }}" alt="Clients"></a></div>

                  </div>
              </div>
          </div> -->

    </div>

</section>
<!-- #content end -->
  <!-- Modal -->
  <div class="modal fade" id="getstartModal" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header regPopheader">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <div class="errorMessage alert-danger"></div>
        </div>
        <div class="modal-body">
        <div class="col-md-12 text-center marginBottom20">
<!--               <a href="{{ route('login',['provider'=>'facebook']) }}"  class="col-md-12 col-sm-6 col-xs-12" style="margin-bottom:11px;">-->
<a class="btn btn-block btn-social btn-facebook" onclick="fbLogin()" id="fbLink" class="fb_login_btn">
            <span class="icon-facebook"></span> Register with Facebook</a>
        </div>
       <div class="col-md-12 orDivider-box marginBottom20">
       <div class="orDivider">or</div>
       </div>

       <div class="col-md-12 text-center">
                <a href="{{route('newstore')}}">  <button class="btn btn-success btn-social fullWidthbtn theme-color marginBottom20"><span class="icon-vlogo"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/register-button-logo.png') }}" alt="V"></span> Register with Mobile</button></a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix">
        </div>
      </div>

    </div>
  </div>
@stop
@section("myscripts")

<script>

//function toTitleCase(str) {
//    return str.replace(/(?:^|\s)\w/g, function(match) {
//        return match.toUpperCase();
//    });
//}
//
//    $(".stName").on("keyup",function(){
//       $(this).val(toTitleCase($(this).val()));
//    });
//
//
//    $(".checkStore").on("keyup", function () {
//        storename = $("input[name='store_name']").val();
//
//        if (storename.length < 4) {
//            $(".storeErr").text("Store name should be more than 4 letters");
//            $(".getVeestore").prop('disabled', true);
//            return false;
//        } else {
//            $(".storeErr").text("");
//            $(".getVeestore").removeAttr('disabled');
//
//        }
//
//        $.ajax({
//            type: "POST",
//            url: "{{route('checkStore')}}",
//            data: {storename: storename},
//            cache: false,
//            success: function (resp) {
//                if (resp == 1) {
//                    $(".storeErr").text("Sorry, this Store name is taken. Try another.");
//                    $(".getVeestore").prop('disabled', true);
//
//                } else {
//                    $(".storeErr").text("");
//                    $(".getVeestore").removeAttr('disabled');
//                }
//
//            }
//
//
//        });
//    });
//
//
//
//    $("#getStartedForm").validate({
//        // Specify the validation rules
//        rules: {
//            store_name: {
//                required: true
//            }
//        },
//        messages: {
//            store_name: {
//                required: "Please enter your Store name"
//            }
//        },
//        errorPlacement: function (error, element) {
//            $(element).append(error);
//        }
//    });
//



</script>
@stop
