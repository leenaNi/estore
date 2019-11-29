@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Orders
        <small>View</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Orders</li>
        <li class="active">View</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#order-detail" data-toggle="tab" aria-expanded="true">Order Details</a></li>
            <li class=""><a href="#customer-detail" data-toggle="tab" aria-expanded="true">Vendor Details</a></li>
            <li class=""><a href="#product-detail" data-toggle="tab" aria-expanded="true">Product Details</a></li>
        </ul>
        <div  class="tab-content" >
            <div class="tab-pane active" id="order-detail">
                <div class="panel-body">
                {!! Form::model(['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}

                <div class="clear clear_fix clearfix"> </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('po_no', 'PO No. ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('po_no','986767', ["class"=>'form-control validate[required,custom[number]]]' ,"placeholder"=>'PO No.']) !!}
                </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('billno', 'Vendor Bill Number',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('billno','78788', ["class"=>'form-control validate[required,custom[number]]]' ,"placeholder"=>'Bill Number']) !!}
                </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('billcopy', 'Vendor Bill Copy',['class'=>'control-label']) !!}
                    <input type="file" name="billcopy">
                </div>
                <div class="clear clear_fix clearfix"> </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('payment_method', 'Payment Method ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        <select name="payment_status" class="form-control">
                            <option>Select Payment Method</option>
                           <option value="1" selected="selected">COD</option>
                           <option value="2">EBS</option>
                           <option value="3">Cashback/Points/Vouchers/Coupons</option>
                           <option value="4">Paypal</option>
                           <option value="5">PayU</option>
                           <option value="6">Citrus</option>
                           <option value="7">Razorpay</option>
                        </select>
                   
                </div>
              
                <div class="col-md-4 form-group">
                
                    {!! Form::label('payment_status', 'Payment Status ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        <select name="payment_status" class="form-control">
                            <option>Select Payment Status</option>
                            <option>Pending</option>
                            <option>Cancelled</option>
                            <option selected="">Partially Paid</option>
                            <option>Paid</option>
                        </select>
                   
                </div>
              
                <div class="col-md-4 form-group">
                    {!! Form::label('order_status', 'Order Status ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        <select class="form-control validate[required]" id="order_status" name="order_status">
                            <option disabled="disabled" hidden="hidden" value="">Select Order Status</option>
                            <option value="1" selected="selected">Processing </option>
                            <option value="2">Shipped</option><option value="3">Delivered</option>
                            <option value="4">Cancelled</option>
                            <option value="5">Exchanged</option>
                            <option value="6">Returned</option>
                            <option value="7">Undelivered</option>
                            <option value="8">Delayed</option>
                            <option value="9">Partially Shipped</option>
                            <option value="10">Refunded</option></select>
                   
                </div>
              
              
                <div class="col-md-4 form-group">
                    {!! Form::label('shipping_amt', "Shipping Amount",['class'=>'control-label']) !!} 
                        {!! Form::text('shipping_amt','100', ["class"=>'form-control priceConvertTextBox validate[custom[number]]' ,"placeholder"=>'Shipping Amount','readonly']) !!}
                  
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4 form-group">
                    {!! Form::label('shiplabel_tracking_id', 'Shipment No.',['class'=>'control-label']) !!}
                        {!! Form::text('shiplabel_tracking_id','2398878', ["class"=>'form-control' ,"placeholder"=>'Tracking Id']) !!}
                    
                </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('comment', 'Order Remarks',['class'=>'control-label']) !!}
                        {!! Form::text('order_comment','order is pending', ["class"=>'form-control' ,"placeholder"=>'Order Comment']) !!}
                   
                </div>
               
                {!! Form::close() !!}
            </div>
            </div>
            <div class="tab-pane" id="customer-detail">
                <div class="panel-body">
                {!! Form::model(['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal']) !!}

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4 form-group">
                    {!! Form::label('first_name', 'First Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('first_name','Clay', ["class"=>'form-control validate[required]' ,"placeholder"=>'First Name']) !!}
                   
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4 form-group">
                    {!! Form::label('last_name', 'Last Name',['class'=>'control-label']) !!}
                        {!! Form::text('last_name','Jensen', ["class"=>'form-control' ,"placeholder"=>'Last Name']) !!}
                    
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4 form-group">
                    {!! Form::label('phone_no', 'Mobile Number ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('phone_no','9878987678', ["class"=>'form-control validate[required,custm[phone]]' ,"placeholder"=>'Phone Number']) !!}
                   
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4 form-group">
                    {!! Form::label('address1', 'Billing Address',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('address1','RN-303, Pearl Building,khandeshwar', ["class"=>'form-control validate[required]' ,"placeholder"=>'Billing Address']) !!}
                   
                </div>
                
                
                {!! Form::hidden('id',null) !!}
                {!! Form::close() !!}
            </div>
            </div>

            <!-- Product Deatails form open -->
            <div class="tab-pane" id="product-detail">
                <div class="panel-body">
                    
                    {{ Form::model(['method' => 'post', 'url' => $action , 'class' => 'bucket-form rtForm', 'id' => 'updateReturnQty', ]) }}
                   
                    
                    <div class="clear clear_fix clearfix"> </div>
                    
                    
                    <div class="col-md-4 form-group">
                        {{ Form::label('order_amt', 'Order Amount') }}
                        {{ Form::text('order_amt','3900.00',["class"=>'form-control ordT priceConvertTextBox validate[required, custom[number]]' ,"placeholder"=>'Enter Order Amount','readonly'=>'true']) }}
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('shipping_amt', 'Shipping Amount') }}
                        {{ Form::text('shipping_amt','100',["class"=>'form-control additionalCharges priceConvertTextBox otherAmt validate[required, custom[number]]','readonly']) }}
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('pay_amt', 'Vendor Payable Amount') }}
                        {{ Form::text('pay_amt','4000.00',["class"=>'form-control' ,'readonly'=>'true']) }}
                    </div>
                    <div class="clear clear_fix clearfix"> </div>
                    {{ Form::hidden('ordereditCal',null) }}
                    {{ Form::hidden('id') }}
                    {{ Form::hidden('cashback_to_add',0) }}
                    <div class="clear clear_fix clearfix"> </div>
                    <!-- <div class="pull-right mob-marBottom15">
                        <a href="#" class="btn btn-success addProd">Add New Product</a>
                    </div> -->
                    
                    <div class="clear clear_fix clearfix"> </div>
                    <div class="table-responsive">
                    
                        <table class="table table-hover general-table prodETable" id="tableProd">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Product Variant</th>
                                <th>Ordered Quantity</th>
                                <th>Unit Price <span class="currency-sym-in-braces"></span></th>
                                <th>Total Price <span class="currency-sym-in-braces"></span></th>
                                <th>Inward Quantity</th>
                                <th>Rejected Quantity</th>
                                <th>Reason</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <tr>
                                <td>Atta & Rice</td>
                                <td>Rice Surti Kolam 1KG pkg</td>
                                <td></td>
                                <td><input type="number" style="width: 80%" name="" value="50" min="1"></td>
                                <td>78.00</td>
                                <td>3900.00</td>
                                <td><input type="number" name="" style="width: 80%" value="1" min="1"></td>
                                <td><input type="number" name="" style="width: 80%" value="0" ></td>
                                <td><input type="text" name="" style="width: 80%" value=""></td>
                               
                                <td><a href="#" class="delPrd"><i class="fa fa-trash-o" style="color:red;"></i></a></td>
                            </tr>
                        </tbody>
                    </table>


                            <div class="col-md-6 noRightpadding noMobilePadding">
                                <table class="table tableVaglignMiddle table-hover priceTable">
                                   
                                    <tr class="sub-total-amt">
                                        <th><div class="black-bg">Subtotal: ₹4000</div></th>

                                        <td><div class="black-bg"><strong> <span class="amount finalAmt"></span></strong></div></td>
                                    </tr>
                                    <tr class="order-total">
                                    </tr>
                                </table>
                                </div>

                    <div class="clear clear_fix clearfix"> </div>
                  
                    <div class="col-md-4"> 
                        
                        <button type="submit" class="btn btn-primary">Submit</button>                     
                    </div>
                
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</section> 
@stop 

@section('myscripts')

@stop
