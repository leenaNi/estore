<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
  <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' || $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3' ||  $_GET['theme'] == 'bs1' ||  $_GET['theme'] == 'bs3' ||  $_GET['theme'] == 'bw1' ||  $_GET['theme'] == 'bw3' ||  $_GET['theme'] == 'el1' ||  $_GET['theme'] == 'el3' ||  $_GET['theme'] == 'fg1' ||  $_GET['theme'] == 'fg3' ||  $_GET['theme'] == 'ft1' ||  $_GET['theme'] == 'ft3' ||  $_GET['theme'] == 'hd1' ||  $_GET['theme'] == 'hd3' ||  $_GET['theme'] == 'jw1' ||  $_GET['theme'] == 'jw3' ||  $_GET['theme'] == 'kh1' ||  $_GET['theme'] == 'kh3' ||  $_GET['theme'] == 'os1' ||  $_GET['theme'] == 'os3' ||  $_GET['theme'] == 'rs1' ||  $_GET['theme'] == 'rs3' ||  $_GET['theme'] == 'ts1' ||  $_GET['theme'] == 'ts3')
    include( 'includes/header_style1.php');

    if($_GET['theme'] == 'fs2' || $_GET['theme'] == 'ac2' ||  $_GET['theme'] == 'bs2' ||  $_GET['theme'] == 'bw2' ||  $_GET['theme'] == 'el2' ||  $_GET['theme'] == 'fg2' ||  $_GET['theme'] == 'ft2' ||  $_GET['theme'] == 'hd2' ||  $_GET['theme'] == 'jw2' ||  $_GET['theme'] == 'kh2' ||  $_GET['theme'] == 'os2' ||  $_GET['theme'] == 'rs2' ||  $_GET['theme'] == 'ts2')
    include( 'includes/header_style2.php');
     ?>
    <!-- Content
		============================================= -->
    <div itemscope="" itemtype="#" class="container">
    <div class="page-content">
        <div class="sidebar-position-left">
            <div class="row">
                <div class="col-md-1">

                </div>


                <div class="col-md-10 col-xs-12 margin-top-5">
                                        <div class="col-lg-12 col-md-12">
                        <div class="wpb_column vc_column_container ">
                            <div class="wpb_wrapper">
                                <div class="vc_separator wpb_content_element vc_separator_align_left vc_sep_width_100 vc_sep_pos_align_center vc_sep_color_black">
                                <div class="ordersuccess-block">
                                    <h2>Order Details</h2>
                                </div>
                                    <span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                </div>
                                <div id="contactsMsgs"></div>
                                <form action="#" method="post" class="ng-pristine ng-valid">
                                    <div class="mb-top15">
                                        <table class=".table-condensed table-bordered mb-mb0 orderdetail-steps" cellspacing="0">
                                            <thead>
                                                <tr>

                                                    <th class="product-name text-center">ORDER ID: <span class="cart-item-details">129</span></th>
                                                    <th class=" text-center">Date: <span class="cart-item-details"> 12-Jul-2018</span></th>
                                                    <th class="product-quantity text-center">Status: <span class="cart-item-details">Processing  </span></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                            </form></div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="wpb_column vc_column_container ">
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper">
                                                                        
                                        <div class="table-responsive shop-table">

                                            <table class="shop_table cart table table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="product-name text-center" style="width:20%;">Product Details</th>
                                                        <th class="product-price text-center" style="width:20%;">Price</th>
                                                        <th class="product-quantity text-center" style="width:20%;">Qty</th>
                                                        <th class="product-subtotal text-center" style="width:20%;">Total</th>
                                                                                                            </tr>
                                                </thead>
                                                <tbody>
                                                     
                                                      

                                                                                                                                                            <tr class="cart_item">
                                                <input type="hidden" id="oid" value="129">
                                                <td class="text-center">
                                                    <div class="cart-item-details">
                                                                                                                    <img src="images/fashion/products/default-product.jpg" height="50px" width="50px">
                                                        
                                                        <br>
                                                        
                                                            <span class="customer-name">Women Western Wear</span><br>
                                                            <span class="product-size"></span>   
                                                       

                                                                                                            </div>
                                                </td>
                                                <td class="text-center">
                                                                                                        <span class="cart-item-details"><span class="">31.48</span></span>                   
                                                </td>
                                                <td class="text-center" align="center">
                                                    <div class="product-quntity">1</div>
                                                </td>

                                                
                                                <td class="product-subtotal text-right">
                                                    <span class="cart-item-details"><span class="product-total">31.48</span></span>                   
                                                </td>
                                                <td class="hide">

                                                                                                       
                                                                                                                                                                   
                                                    <a href="#" class="button hide button-3d button-mini button-rounded orderReturnTypeClick" data-toggle="modal" order-type="1" data-target="#viewDetail2">Cancel Item</a>
                                                                                                                                                                                                                                                                        <div class="modal fade viewDetailModal" id="viewDetail2" role="dialog">
                                                                                                                        <div class="modal-dialog  modal-lg">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                                        <h4 class="modal-title">Product Details</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="clearfix"></div>
                                                                          
                                                                        <form action="https://dev.cartini.online/myaccount/order-return-cal" onsubmit="return validate()" method="post" class="orderReturnForm ng-pristine ng-valid">            
                                                                            <input type="hidden" name="_token" value="208uSOWMWrFBndGTx4HlL4TjDE8F4nlLBduOOk7f">
                                                                            <input class="orderType" name="order_status" type="hidden" value="">
                                                                            <div class="table-responsive shop-table">

                                                                                <table class="shop_table cart table table-bordered" cellspacing="0">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="product-name text-left" style="width:35%">Name</th>
                                                                                            <th style="width:10%" class="product-quantity text-center">QTY</th>
                                                                                                                                                                                        <th class="product-quantity text-center" style="width:20%">Reason</th>
                                                                                            <th class="product-price text-center" style="width:10%">Price</th>
                                                                                        </tr>
                                                                                    </thead>

                                                                                    <tbody>
                                                                                        <tr class="cart_item">
                                                                                    <input type="hidden" name="oid" value="129">
                                                                                    <td class="text-left">
                                                                                        <div class="cart-item-details">
                                                                                                                                                                                            <img src="https://dev.cartini.online/public/Admin/uploads/catalog/products/prod-20180508133917.jpg" height="50px" width="50px">
                                                                                             

                                                                                            <a href="javascript:void(0)">
                                                                                                <br>
                                                                                                <span class="customer-name">Women Western Wear</span><br>
                                                                                            </a> 
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="">
                                                                                                                                                                                <div class="product-quntity"><input type="number" main-qty="1" name="return_product[2][quantity]" class="form-control returnProduct" min="1" max="1" value="1"></div>
                                                                                    </td>
                                                                                                                                                                        <td class="orderReturnSelect">
                                                                                        <select class="form-control " name="return_product[2][reason]"><option value="1">Dead on arrival</option><option value="2">Faulty Product</option><option value="3">Order error</option><option value="4">Received wrong item</option><option value="5">Bought by mistake</option><option value="6">Better price available</option><option value="7">Item arrived too late</option><option value="8">Both product and shipping box damaged</option><option value="9">Item defective or doesn’t work</option><option value="10">Received extra item I didn’t buy (no refund needed)</option><option value="11">No longer needed</option><option value="12">Too small</option><option value="13">Too large</option><option value="14">Style not as expected</option><option value="15">Ordered wrong size/colour</option><option value="16">Inaccurate website description</option><option value="17">Quality not as expected</option><option value="18">Managed By Admin</option></select>
                                                                                        <input class="" name="return_product[2][amount]" type="hidden" value="2299.00">
                                                                                        <input class="" name="return_product[2][sub_prod]" type="hidden" value="2">
                                                                                    </td>


                                                                                    <td class="">
                                                                                        <span class="cart-item-details"><span class="product-price">
                                                                                                31.48</span>
                                                                                        </span>   
                                                                                    </td>
                                                                                    </tr>
                                                                                    <tr class="cart_item">
                                                                                        <td colspan="5" class="product-subtotal text-left">
                                                                                            <span class="cart-item-details"><input type="submit" class=" button closeModal" value="Submit"><span id="ret24"></span></span>                   
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <div id="cancelMsg"></div>
                                                                            </div>
                                                                            <div class="clearfix"> </div> 
                                                                        </form>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                </td>
                                                </tr>
                                                <tr class="cart_item">
                                                  <td class="text-right" colspan="3">
                                                        <div class="product-quntity"><strong>Sub-Total</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details">
                                                            <span class="product-total">31.48</span></span>                   
                                                    </td>
                                                </tr>
                                                <tr class="cart_item">
                                                  <td class="text-right" colspan="3">
                                                        <div class="product-quntity"> <strong>Coupon Used</strong> </div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total">0.00</span></span>                   
                                                    </td> 
                                                </tr>
                                                <tr class="cart_item">
                                                  <td class="text-right" colspan="3">
                                                        <div class="product-quntity"> <strong>COD Charges</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total">0.68 </span></span>                   
                                                    </td> 
                                                </tr>
                                                <tr class="cart_item">
                                                            <td class="text-right" colspan="3">
                                                                <div class="product-quntity"> <strong>Service Charge</strong></div>
                                                            </td>
                                                            <td class="product-subtotal text-right">
                                                                <span class="cart-item-details"><span class="product-total">0.00 </span></span>                   
                                                            </td> 
                                                        </tr>
                                                        <tr class="cart_item">
                                                                                                                  <td class="text-right" colspan="3">
                                                                <div class="product-quntity"> <strong>Transport Charge</strong></div>
                                                            </td>
                                                            <td class="product-subtotal text-right">
                                                                <span class="cart-item-details"><span class="product-total">0.00 </span></span>                   
                                                            </td> 
                                                        </tr>
                                                        <tr class="cart_item">
                                                    <td class="text-right" colspan="3">
                                                        <div class="product-quntity"><strong>Total</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total">32.16</span></span>                   
                                                    </td> 
                                                </tr>
                                                <tr class="cart_item ">
                                                        <td colspan="6" class="product-subtotal text-right">
                                                            <a href="#" class="button button-3d button-mini button-rounded orderCancelled"  data-toggle="modal" data-target="#cancelOrderModal">Cancel Order</a>
                                                        </td>
                                                    </tr>
                                                                                                                                                        </tbody>
                                            </table>
                                            <div id="cancelMsg"></div>
                                        </div>

                                        <div class="clearfix"> </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
                <div class="col-md-1">
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- Modal -->
 <div class="modal fade" id="cancelOrderModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cancel Order</h4>
        </div>
        <div class="modal-body">
        <form action="#" id="cancelForm" method="post">  
                    <input name="orderId" type="hidden" value="129">
                    <input name="returnAmount" type="hidden" value="2,349.00">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_email">Reason</label>
                                <select class="form-control " name="reasonId"><option value="1">Dead on arrival</option><option value="2">Faulty Product</option><option value="3">Order error</option><option value="4">Received wrong item</option><option value="5">Bought by mistake</option><option value="6">Better price available</option><option value="7">Item arrived too late</option><option value="8">Both product and shipping box damaged</option><option value="9">Item defective or doesn’t work</option><option value="10">Received extra item I didn’t buy (no refund needed)</option><option value="11">No longer needed</option><option value="12">Too small</option><option value="13">Too large</option><option value="14">Style not as expected</option><option value="15">Ordered wrong size/colour</option><option value="16">Inaccurate website description</option><option value="17">Quality not as expected</option><option value="18">Managed By Admin</option></select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_message">Remark</label>
                                <textarea id="form_message" name="remark" class="form-control" placeholder="Remark *" rows="4" required="required" data-error="Please, leave us a message."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="button" class="btn btn-success btn-send cancelSubmit" value="Submit">
                        </div>
                    </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    <!-- #content end -->
    <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' || $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3' ||  $_GET['theme'] == 'bs1' ||  $_GET['theme'] == 'bs3' ||  $_GET['theme'] == 'bw1' ||  $_GET['theme'] == 'bw3' ||  $_GET['theme'] == 'el1' ||  $_GET['theme'] == 'el3' ||  $_GET['theme'] == 'ft1' ||  $_GET['theme'] == 'ft3' ||  $_GET['theme'] == 'hd1' ||  $_GET['theme'] == 'hd3' ||  $_GET['theme'] == 'jw1' ||  $_GET['theme'] == 'jw3' ||  $_GET['theme'] == 'kh1' ||  $_GET['theme'] == 'kh3' ||  $_GET['theme'] == 'fg1' ||  $_GET['theme'] == 'fg3' ||  $_GET['theme'] == 'rs1' ||  $_GET['theme'] == 'rs3' ||  $_GET['theme'] == 'os1' ||  $_GET['theme'] == 'os3' ||  $_GET['theme'] == 'ts1' ||  $_GET['theme'] == 'ts3')
    include( 'includes/footer_style1.php');

    if($_GET['theme'] == 'fs2' || $_GET['theme'] == 'ac2' ||  $_GET['theme'] == 'bs2' ||  $_GET['theme'] == 'bw2' ||  $_GET['theme'] == 'el2' ||  $_GET['theme'] == 'ft2' ||  $_GET['theme'] == 'hd2' ||  $_GET['theme'] == 'jw2' ||  $_GET['theme'] == 'kh2' ||  $_GET['theme'] == 'fg2' ||  $_GET['theme'] == 'os2' ||  $_GET['theme'] == 'rs2' ||  $_GET['theme'] == 'ts2')
    include( 'includes/footer_style2.php');
     ?>
      </div>
  <!-- #wrapper end -->
  <?php include( 'includes/foot.php'); ?> </body>

</html>