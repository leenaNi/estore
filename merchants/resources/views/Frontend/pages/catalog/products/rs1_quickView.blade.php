
<div class="modal-dialog" ng-controller="quickView">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="icon-remove"></span></a>
                <h3 class="modal-title">{{$product->product}}</h3>
            </div>
   
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 product_img">
                        <img src="" class="img-responsive">
                    </div>
                    <div class="col-md-6 col-sm-6 product_content">
                        <div class="product-desc">
                   @if($product->produc_code)
                <div class="product-rating">
                  <p>PRODUCT CODE: {{$product->produc_code}}</p>
                </div>
                  @endif
                <div class="product-price"><del  ><i class="icon-rupee"></i> 399 </del> <i class="icon-rupee"></i> 299 </div> <span class="span2" style="color:red;">STOCK LEFT - 1</span>
                <div class="row topmargin-sm">
                            <div class="col-md-4 col-sm-6 col-xs-12 bottommargin-xs">
                                <select class="form-control" name="select">
                                    <option value="">1kg</option>
                                    <option value="">2kg</option>
                                    <option value="">3kg</option>
                                    
                                </select>
                            </div>
                            <!-- end col -->
                            <div class="col-md-4 col-sm-6 col-xs-12 bottommargin-xs">
                                <select class="form-control" name="select">
                                    <option value="">Chicken</option>
                                    <option value="">Mutton</option>
                                    <option value="">Beef</option>
                                    <option value="">Vegetable</option>
                                </select>
                            </div>
                            <!-- end col -->
                            <div class="col-md-4 col-sm-12 bottommargin-xs">
                               
                  <div class="quantity quantitypopup clearfix">
                    <input type="button" value="-" class="minus quantitypopupinput">
                    <input type="text" step="1" min="1" name="quantity" value="1" title="Qty" class="qty quantitypopupinput" size="4" />
                    <input type="button" value="+" class="plus quantitypopupinput"> </div>
                            </div>
                            <!-- end col -->
                        </div>
                <div class="clear"></div>
                <!-- Product Single - Quantity & Cart Button
								============================================= -->
                
                  <button type="submit" class="add-to-cart button nomargin"><i class="icon-cart"></i> <span class="addtocart-text">Add to cart</span></button>
                  <button type="submit" class="add-to-cart button nomargin"><i class="icon-heart" style="margin-right:0px;"></i></button>
               
                <!-- Product Single - Quantity & Cart Button End -->
                <div class="clear"></div>
                <div class="line topmargin-sm bottommargin-sm"></div>
                <!-- Product Single - Short Description
								============================================= -->
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis at nisi optio dolor!</p>
               
                <!-- Product Single - Share
								============================================= -->
                <div class="si-share noborder clearfix"> <span class="pull-left">Share:</span>
                  <div class="pull-left">
                <!-- AddToAny BEGIN -->
<?php
$social['url']=Request::url();
print_r(App\Library\Helper::socialShareIcon($social));
?>
<!-- AddToAny END --> </div>
                </div>
                <!-- Product Single - Share End -->
              </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
