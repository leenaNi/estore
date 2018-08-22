@extends('Frontend.layouts.default') 
@section('content')
<section id="slider" class="slider-parallax full-screen clearfix">
    <div class="slider-parallax-inner">
        <div class="fslider" data-arrows="true" data-pagi="false">
            <div class="flexslider">
                <div class="slider-wrap">
                   
                    @if(count($home_page_slider) > 0) @foreach($home_page_slider as $homeS)
                    <div class="slide">
                        <a href="{{ !empty($homeS->link)?$homeS->link:'javascript:void();'}}" target="_blank"> <img src="{{Config('constants.layoutImgPath').'/'.$homeS->image}}" alt="{{$homeS->alt}}"> 
                            <div class="flex-caption">
                                <h2>{{@$homeS->name}}</h2>
                            </div>
                        </a> @if(Session::get('login_user_type') == 1)
                        <div class="updateHomeBanner">
                            <a href="#" class="button button-rounded" data-toggle="modal" data-target="#manageSlider">
                                <span>
                                    <i class="fa fa-pencil"></i>Manage Slider
                                </span>
                            </a>
                        </div>
                        <!-- <div class="updateHomeBanner" id="{{ $homeS->id }}">
<a href="#" class="button button-rounded"><span><i class="fa fa-pencil"></i>Manage Slider</span></a></div> -->
                        @endif
                    </div>
                    @endforeach @else
                    <div class="slide">
                        <a href="javascript:void();"> <img src="{{(Config('constants.defaultImgPath').'/default-banner.jpg')}}" alt="Default Slider">
<!--                            <div class="flex-caption">
                                <h2>{{@$homeS->name}}</h2>
                            </div>-->
                        </a> @if(Session::get('login_user_type') == 1)
                        <div class="updateHomeBanner" id="manageSlider">
                            <a href="#" class="button button-rounded" data-toggle="modal" data-target="#manageSlider">
                                <span>
                                    <i class="fa fa-pencil"></i>Manage Slider
                                </span>
                            </a>
                        </div>
                      
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>

<!-- Content
            ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            @if(count($home_page_3_boxes) >0) @foreach($home_page_3_boxes as $k => $dynl)
            <div class="col_one_third {{ ($k == 2)?'col_last':''}}">
                @if(Session::get('login_user_type') == 1)
                <a href="#" class="homePage3Boxes edit-menow" data-info='{{$dynl}}' data-imgSrc="{{Config('constants.layoutImgPath').'/'.@$dynl->image}}">
                    <i class="fa fa-pencil  fa-lg"></i>
                </a> @endif
                <a href="{{!empty($dynl->link)?$dynl->link:'javascript:void(0)'}}" target="_blank">
                    <img class="full-width" src="{{Config('constants.layoutImgPath').'/'.@$dynl->image}}" alt="feature1">
                </a> @if(Session::get('login_user_type') == 1)
                      <div class="switchBox">
                	<label class="switch text-center">
                            <input data-id='{{$dynl->id}}' class="switch-input 3BoxStatus" name="status"  value="{{$dynl->is_active}}" type="checkbox"  <?php echo ($dynl->is_active == 1)? 'checked="&quot;checked&quot;"':'' ?> >
                                    <span class="switch-label" data-on="Enabled" data-off="Disabled"></span> 
                                    <span class="switch-handle"></span> 
                         </label>
               </div>
                
                <div class="{{($dynl->is_active == 0 )?'overlayFBox':''}}  overL_{{$dynl->id}}"></div>
                @endif
                <div class="overlayContentBox">
                    <div>
                        <h3 class="nobottommargin text-center">{{@$dynl->name}}</h3>
                    </div>
                </div>
            </div>
            @endforeach @endif
        </div>
        @if(Session::get('login_user_type') == 1)
        <?php $cat = count($rootsS) > 0 ? '' : "Cat"; ?>
        <div class="text-center bottommargin-sm">
            <a style="z-index: 99;" class="btn btn-default button button-rounded" type="button" data-toggle="modal" data-target="#addProduct{{$cat}}">Add New Product</a>
        </div>
        @endif
<div class="container clearfix" ng-controller="quickAddToCartProduct">
            <div class="fancy-title title-dotted-border title-center" ng-if="quickAddProduct.length > 0">
                <h3>Trending</h3>
            </div>
            <div id="shop" class="shop clearfix">
                <div class="product clearfix fs_product fs1_product" ng-repeat="quickproduct in quickAddProduct">
                    <form id="form[[quickproduct.id]]" action="{{ route('addToCart')}}">
                        <div class="product-image fs_product-image fs1_product-image producImgBoxSize_4Col">
                            <a ng-if="quickproduct.prodImage != ''" href="{{ route('home')}}/[[quickproduct.url_key]]"><img src=" [[quickproduct.prodImage]]" alt="">
                                    </a>
                            <a ng-if="quickproduct.prodImage == ''" href="javascript:void">
                                        <img src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}" alt="default Img">
                                    </a>
                            <div class="clearfix"></div>
                            <div class="product-overlay">
                                <a href="{{ route('home')}}/[[quickproduct.url_key]]" class="add-to-cart ">
                                <i class="icon-eye"></i><span>View Details</span></a>
                            </div>
                        </div>
                        <div class="product-desc">
                            <div class="product-title">
                                <h3>
                                    <a href="{{ route('home')}}/[[quickproduct.url_key]]">[[quickproduct.product]]</a>
                                </h3>
                            </div>
                        </div>
                        <div class="product-price" ng-if="quickproduct.spl_price  > 0">
                            <del><span class="currency-sym"></span> [[quickproduct.price * currencyVal | number : 2 ]]</del>
                            <ins>
                                            <span class="currency-sym"></span><span class="mrp_price[[quickproduct.id]]"> [[quickproduct.spl_price * currencyVal | number : 2 ]] </span>
                                        </ins>
                            <input type="hidden" name="price" value="[[quickproduct.spl_price  * currencyVal | number : 2  ]]" class="parent_price[[quickproduct.id]]">
                        </div>
                        <div class="product-price" ng-if="quickproduct.spl_price == 0">
                            <ins class="mrp_price[[quickproduct.id]]">
                                            <span class="currency-sym"></span> <span class="mrp_price[[quickproduct.id]]">[[quickproduct.price* currencyVal | number : 2]]</span>
                                        </ins>
                            <input type="hidden" name="price" value="[[quickproduct.price* currencyVal | number : 2]]" class="parent_price[[quickproduct.id]]">
                        </div>
<!--                        <div class="stock-info-Box">
                            @if($isstock==1)
                            <span class="stock-info span2 span[[quickproduct.id]] hide" style="color:red;" ng-show="quickproduct.is_stock == 1">STOCK LEFT - [[ quickproduct.stock ]]</span> @endif
                        </div>-->
                        <!-- <div style="text-align:center"> No product found.</div> -->
<!--                        <div class="quantity-box-full" ng-if="quickproduct.prod_type==1">
                            <input type='hidden' name='prod_id' value='[[quickproduct.id]]' data-parentid="[[quickproduct.id]]">
                            <input type='hidden' name='prod_type' value='[[quickproduct.prod_type]]'>
                            <input type="button" value="-" class="minus" field="quantity"> 
                            @if($isstock==1)
                            <input type="text" id="quantity" step="1" min="1" name="quantity" value="1" title="Qty" max="[[(quickproduct.is_stock == 1)?quickproduct.stock:'1000000000']]" class="qty quantity[[quickproduct.id]]" size="4" onkeypress="return isNumber(event);" style="text-align: center;"
                            /> @else
                            <input type="text" step="1" name="quantity" id="quantity" value="1" max="1000000000" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" /> @endif
                            <input type="button" value="+" class="plus" field="quantity">
                            <div class="clearfix"></div>
                        </div>-->
<!--                        <div class="quantity-box" ng-if="quickproduct.prod_type==3">
                            <input type='hidden' name='prod_id' value='[[quickproduct.id]]' data-parentid="[[quickproduct.id]]">
                            <input type='hidden' name='prod_type' value='[[quickproduct.prod_type]]'>
                            <input type="button" value="-" class="minus" field="quantity">
                            @if($isstock==1)
                            <input type="text" id="quantity" step="1" min="1" name="quantity" value="1" title="Qty" max="[[(quickproduct.is_stock == 1)?quickproduct.stock:'1000000000']]" class="qty quantity[[quickproduct.id]]" size="4" onkeypress="return isNumber(event);" style="text-align: center;" />
                            @else
                            <input type="text" step="1" name="quantity" id="quantity" value="1" max="1000000000" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" /> @endif
                            <input type="button" value="+" class="plus" field="quantity">
                        </div>-->
<!--                        <div ng-if="quickproduct.prod_type==3" class="attrCheck select-productbox">
                            <input type='hidden' name='sub_prod' value='' class="subPRod[[quickproduct.id]]">
                            <div id="selAT[[quickproduct.id]]" class="productVarient">
                                <select ng-repeat="(attrsk,attrsv) in quickproduct.selAttrs" name='[[attrsv.name]]' class="selatts attrSel  form-control" id="selID[[quickproduct.id]][[$index]]" ng-init="modelName = selaTT[[attrsk]]" ng-model="modelName" ng-if="$index == 0" ng-click="quickSelAttrChange(modelName, attrsk, $index + 1,quickproduct.id,quickproduct.price)"
                                    ng-options="optk as optv for (optk,optv) in attrsv.options " required>
                                                <option value="">[[attrsv.placeholder]]</option>
                                            </select>
                            </div>
                        </div>-->
                        <div class="clearfix"></div>
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
    </div>

    <div id="addProductCat" class="modal fade in" role="dialog">
        <div class="modal-dialog addProduct-modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header addProduct-modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Plese Create/Select Category First</h4>
                </div>
                <div class="box-body">
                    <p>Please select/create minimum one Category before adding a product by clicking on Manage Categories in the header menu.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="addProduct" class="modal fade in" role="dialog">
        <div class="modal-dialog addProduct-modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header addProduct-modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Add New Product (1000px W X 1000px H)</h4>
                </div>
                @include('Frontend.pages.addProductPopup')
            </div>
        </div>
    </div>
</div>
</section>

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

    function calc(thisQty) {
        var qty = thisQty.val();
        var maxvalue = parseInt(thisQty.attr('max'));
        var currentVal = parseInt(thisQty.val());

        if (!isNaN(currentVal) && (currentVal <= (maxvalue))) {
            // Increment
            //$('.plus').css('pointer-events', '');
            //  alert(parseInt(thisQty.val()));
            thisQty.val(parseInt(currentVal));
            var rowid = thisQty.attr('data-rowid');
            var productId = thisQty.attr('data-productid');
            $.ajax({
                type: "POST",
                url: "{{ route('editCart') }}",
                data: {
                    qty: qty,
                    rowid: rowid,
                    productId: productId
                },
                cache: false,
                success: function (result) {
                    console.log(result);
                    $(".subtotal" + rowid).text(result['subtotal'].toFixed(2));
                    $(".allSubtotal").text(result['total'].toFixed(2));
                    $(".finalAmt").text(result['finaltotal'].toFixed(2));
                    if (result['coupon_amount']) {
                        $("#couponApply").click();
                    }
                    $(".tax_" + rowid).text(result['tax'].toFixed(2));
                    $('.shop-cart').text(result['cart_count']);

                }
            });
        } else if (currentVal >= maxvalue) {
            // Need to write ajax call for cart count.
            thisQty.val(parseInt(maxvalue));
            calc(thisQty);
            $.ajax({
                type: "POST",
                url: "{{ route('getCartCount') }}",
                cache: false,
                success: function (cartCount) {

                    $('.shop-cart').text(cartCount);
                }
            });
            alert("Specified quantity is not available!");

        } else {
            // Otherwise put a 0 there
            thisQty.val(1);
        }

    }
    $(document).on("click", '.plus', function () {
        //alert("sdf");
        var fieldName = $(this).attr("field");
        //   var maxValue = parseInt($('input[name="quantity"]').attr('max'));
        var thisQty = $(this).parent().find('input[name=' + fieldName + ']');
        //  $(this).parent().find('input[name=' + fieldName + ']').val();
        thisQty.val(parseInt(thisQty.val()) + 1);
        calc(thisQty);
        //                $(this).parent().find('input[name=' + fieldName + ']').val(currentVal + 1);
    });

    $(document).on("click", '.minus', function () {
       // alert("sdf");
        var fieldName = $(this).attr("field");
        //   var maxValue = parseInt($('input[name="quantity"]').attr('max'));
        var thisQty = $(this).parent().find('input[name=' + fieldName + ']');
        // $(this).parent().find('input[name=' + fieldName + ']').val(currentVal - 1);
        var currentVal = $(this).parent().find('input[name=' + fieldName + ']').val()
        if (!isNaN(currentVal) && (currentVal > 1)) {
            thisQty.val(parseInt(thisQty.val() - 1));
            calc(thisQty);
        } else {
            thisQty.val(parseInt(1));
            calc(thisQty);
        }

        //                $(this).parent().find('input[name=' + fieldName + ']').val(currentVal + 1);
    });
</script>
@stop