@extends('Frontend.layouts.default')
@section('content')

<div class="container clearfix topmargin-sm">
    <div class="col_three_fourth nobottommargin">

        <div class="fslider" data-arrows="false">
            <div class="flexslider">
                <div class="slider-wrap">
                    @if(count($home_page_slider) > 0)
                    @foreach($home_page_slider as $homeS)
                    <div class="slide">

                        <a href="{{ !empty($homeS->link)?$homeS->link:'javascript:void();'}}" target="_blank">
                            <img src="{{ Config('constants.layoutImgPath').'/'.$homeS->image}}" alt="{{$homeS->alt}}">
                            <div class="flex-caption"><h2>{{@$homeS->name}}</h2></div>

                        </a>
                               @if(Session::get('login_user_type') == 1)
                        <div class="updateHomeBannerfs2">
                <a href="#" class="button button-rounded" data-toggle="modal" data-target="#manageSlider"><span><i class="fa fa-pencil"></i>Manage Slider</span></a></div>
                        @endif
                    </div>
                    @endforeach
                    @else  
                    <div class="slide"> 
                        <a href="javascript:void();"> <img src="{{ Config('constants.defaultImgPath').'default-banner.jpg'}}" alt="Default Slider"> </a>
                        <!--<div class="flex-caption"><h2>{{@$homeS->banner_text}}</h2></div>-->
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col_one_fourth nobottommargin col_last">
        @if(count($home_page_3_boxes) >0)
        @foreach($home_page_3_boxes as $k => $dynl)
        <div class="col_full bottommargin-sm">
   @if(Session::get('login_user_type') == 1)
                <a href="#" class="homePage3Boxes edit-menow2" data-info='{{$dynl}}'  data-imgSrc="{{Config('constants.layoutUploadPath').'/'.@$dynl->image}}"><i class="fa fa-pencil  fa-lg"></i></a>
                @endif
            <a href="{{!empty($dynl->link)?$dynl->link:'javascript:void(0)'}}" target="_blank">
                <img class="full-width" src="{{Config('constants.layoutUploadPath').'/'.@$dynl->image}}" alt="feature2">
                <div class="overlayContentBox">
                    <div><h3 class="nobottommargin text-center">{{@$dynl->name}}</h3></div>
                </div>
            </a>
                      @if(Session::get('login_user_type') == 1)
                <div class="switchBox">
                	<label class="switch text-center">
                            <input data-id='{{$dynl->id}}' class="switch-input 3BoxStatus" name="status"  value="{{$dynl->is_active}}" type="checkbox"  <?php echo ($dynl->is_active == 1)? 'checked="&quot;checked&quot;"':'' ?> >
                                    <span class="switch-label" data-on="Enabled" data-off="Disabled"></span> 
                                    <span class="switch-handle"></span> 
                         </label>
               </div>
                
                <div class="{{($dynl->is_active == 0 )?'overlayFBox':''}}  overL_{{$dynl->id}}"></div>
                  @endif
               

        </div>
        @endforeach
        @endif
    </div>

    <div class="clear"></div>

</div>



<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">
        @if(count($homePageAbout) >0)
        <div class="container clearfix bottommargin-sm">
            <div class="fancy-title title-bottom-border">
                <h3>About Us</h3>
            </div>

            <div class="Col_full text-justify">
                <?php echo html_entity_decode($homePageAbout->desc); ?>
<!--				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p><a href="#">Read more →</a></p>-->
            </div>

        </div>
        @endif
        <div class="container clearfix" ng-controller="quickAddToCartProduct">

            <div class="fancy-title title-bottom-border" ng-if="quickAddProduct.length > 0">
                <h3>Trending</h3>
            </div>
            <div id="shop" class="shop clearfix">

                <div class="product clearfix fs_product product-item productbox" ng-repeat="quickproduct in quickAddProduct">
                    <form id="form[[quickproduct.id]]" action="{{ route('addToCart')}}">
                        <div class="product-image fs_product-image fs2_product-image producImgBoxSize_4Col">
                            <a ng-if="quickproduct.prodImage != ''" href="{{ route('home')}}/[[quickproduct.url_key]]"><img src=" [[quickproduct.prodImage]]" alt="[[quickproduct.product]]"></a>

                            <a ng-if="quickproduct.prodImage == ''" href="javascript:void"><img src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg')}}" alt="default image"></a> 

                            <div class="product-overlay2">
                                <a href="{{ route('home')}}/[[quickproduct.url_key]]" class="center-icon"><i class="icon-line-plus"></i></a>

                            </div>
                        </div>
                        <div class="product-desc product-desc-transparent">
                            <div class="product-title"><h3><a href="{{ route('home')}}/[[quickproduct.url_key]]">[[quickproduct.product]]</a></h3></div>

                            <div class="product-price" ng-show="quickproduct.spl_price > 0"><del><span class="currency-sym"></span> [[quickproduct.price * currencyVal | number : 2 ]]</del> <ins><span class="currency-sym"></span> <span class="mrp_price[[quickproduct.id]]">[[quickproduct.spl_price * currencyVal | number : 2 ]]</ins></span>
                                <input type="hidden" name="price" value="[[quickproduct.spl_price * currencyVal | number : 2 ]]" class="parent_price[[quickproduct.id]]"></div>
                        </div>

                        <div class="product-price" ng-show="quickproduct.spl_price == 0"><ins><span class="currency-sym"></span> <span class="mrp_price[[quickproduct.id]]"> [[quickproduct.price * currencyVal | number : 2 ]] </span></ins>
                            <input type="hidden" name="price" value="[[quickproduct.price * currencyVal | number : 2 ]]" class="parent_price[[quickproduct.id]]"></div>
<!--                            <div class="stock-info-Box">
                        @if($isstock==1)

                        <span class="stock-info span2 span[[quickproduct.id]] hide" style="color:red;" ng-show="quickproduct.is_stock == 1">STOCK LEFT - [[ quickproduct.stock ]]</span>
                        @endif
                        </div>-->
<!--                        <div class="quantity-box-full" ng-if="quickproduct.prod_type==1">
              <input type='hidden' name='prod_id' value='[[quickproduct.id]]' data-parentid ="[[quickproduct.id]]">
              <input type='hidden' name='prod_type' value='[[quickproduct.prod_type]]'>
               <input type="button" value="-" class="minus" field="quantity">
            
              @if($isstock==1)
              
              <input type="text" id="quantity" step="1" min="1" name="quantity" value="1" title="Qty" max="[[(quickproduct.is_stock == 1)?quickproduct.stock:'1000000000']]" class="qty quantity[[quickproduct.id]]" size="4" onkeypress="return isNumber(event);" style="text-align: center;" />
              @else 
                  <input type="text" step="1" name="quantity" id="quantity" value="1"  max="1000000000" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" />
              @endif
              <input type="button" value="+" class="plus" field="quantity"> 
              <div class="clearfix"></div>
       </div>-->
<!--            <div class="quantity-box" ng-if="quickproduct.prod_type==3">
              <input type='hidden' name='prod_id' value='[[quickproduct.id]]' data-parentid ="[[quickproduct.id]]">
              <input type='hidden' name='prod_type' value='[[quickproduct.prod_type]]'>
               <input type="button" value="-" class="minus" field="quantity">
            
              @if($isstock==1)
              
              <input type="text" id="quantity" step="1" min="1" name="quantity" value="1" title="Qty" max="[[(quickproduct.is_stock == 1)?quickproduct.stock:'1000000000']]" class="qty quantity[[quickproduct.id]]" size="4" onkeypress="return isNumber(event);" style="text-align: center;" />
              @else 
                  <input type="text" step="1" name="quantity" id="quantity" value="1"  max="1000000000" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" />
              @endif
              <input type="button" value="+" class="plus" field="quantity"> 
       </div>-->

<!--                        <div ng-if="quickproduct.prod_type == 3" class="attrCheck select-productbox">
                            <input type='hidden' name='sub_prod' value='' class="subPRod[[quickproduct.id]]">
                            <div id="selAT[[quickproduct.id]]" class="productVarient">
                                <select  ng-repeat="(attrsk,attrsv) in quickproduct.selAttrs" name='[[attrsv.name]]' class="selatts attrSel  form-control" id="selID[[quickproduct.id]][[$index]]"  ng-init="modelName = selaTT[[attrsk]]" ng-model="modelName"   ng-if="$index == 0" ng-click="quickSelAttrChange(modelName, attrsk, $index + 1, quickproduct.id, quickproduct.price)" ng-options="optk as optv for (optk,optv) in attrsv.options " required>
                                    <option value="">[[attrsv.placeholder]]</option>
                                </select>  
                            </div>

                        </div>    -->
                        <div class="clearfix"></div><div class="clearfix"></div>
                        <div class="add-to-cart-btn viewDetailBtn">
                            <a  href="{{ route('home')}}/[[quickproduct.url_key]]" class="button button-grey full-width-btn"><span>View Detail</span></a>
                        </div>
                    </form>
                </div>




            </div>

        </div>
        <!-- Testimonial open -->
        @if(@$testimonial_status->status && !$testimonial->isEmpty())
        <div class="section footer-touch">

            <h4 class="uppercase center">Testimonials</h4>

            <div class="fslider testimonial testimonial-full" data-animation="fade" data-arrows="false">
                <div class="flexslider">
                    <div class="slider-wrap">
                        @foreach($testimonial as $test)
                        <div class="slide">
                            <div class="testi-image">
                               <a href="#">
                                    @if($test->gender == 'male')
                                    <img src="{{($test->image)?Config('constants.adminTestimonialImgPath').'/'.$test->image:Config('constants.defaultImgPath').'/default-male.png'}}" alt="Customer Testimonails">
                                    @else
                                    <img src="{{($test->image)?Config('constants.adminTestimonialImgPath').'/'.$test->image:Config('constants.defaultImgPath').'/default-female.png'}}" alt="Customer Testimonails">
                                    @endif
                                </a>
                            </div>
                            <div class="testi-content">

                                <p>{{ $test->testimonial}}</p>
                                <div class="testi-meta">
                                    {{ $test->customer_name}}

                                    <!-- <span>Apple Inc.</span> -->
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
        @endif
         <div id="addProduct" class="modal fade in" role="dialog">
  
       
  <div class="modal-dialog addProduct-modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header addProduct-modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add New Product (1000px W X 1000px H)</h4>
</div>
 
    @include('Frontend.pages.addProductPopup')     
</div>

    </div>

  </div>
</section><!-- #content end -->
@stop
@section('myscripts')
<script>
      function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
    
    
        $(document).on("click", '.plus', function () {
        //alert("sdf");
        var fieldName = $(this).attr("field");
        //   var maxValue = parseInt($('input[name="quantity"]').attr('max'));
        var currentVal = parseInt($(this).parent().find('input[name=' + fieldName + ']').val());


        $(this).parent().find('input[name=' + fieldName + ']').val(currentVal + 1);
    });

    $(document).on("click", '.minus', function () {
        //alert("sdf");
        var fieldName = $(this).attr("field");
        //   var maxValue = parseInt($('input[name="quantity"]').attr('max'));
        var currentVal = parseInt($(this).parent().find('input[name=' + fieldName + ']').val());

        if (!isNaN(currentVal) && (currentVal > 1)) {
            $(this).parent().find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            $(this).parent().find('input[name=' + fieldName + ']').val(1);
        }
    });
</script>
@stop