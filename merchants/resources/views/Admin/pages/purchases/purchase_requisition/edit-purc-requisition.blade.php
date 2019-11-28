@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Purchase Order
        <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Purchase Order</li>
        <li class="active">Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
    <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4>Order Details</h4>
                    <?php
                $currencySym = !empty(Session::get('currency_symbol')) ? '(' . Session::get('currency_symbol') . ')' : '';
                ?>
                {!! Form::model(['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}

                <div class="line line-dashed b-b line-lg pull-in"></div>

                <div class="col-md-4">
                    {!! Form::label('payment_method', 'Payment Method ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        <select name="payment_status" class="form-control">
                            <option>Select Payment Status</option>
                            <option>Pending</option>
                            <option>Cancelled</option>
                            <option>Partially Paid</option>
                            <option>Paid</option>
                        </select>
                   
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4">
                
                    {!! Form::label('payment_status', 'Payment Status ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        <select name="payment_status" class="form-control">
                            <option>Select Payment Status</option>
                            <option>Pending</option>
                            <option>Cancelled</option>
                            <option>Partially Paid</option>
                            <option>Paid</option>
                        </select>
                   
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4">
                    {!! Form::label('order_status', 'Order Status ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        <select class="form-control validate[required]" id="order_status" name="order_status"><option disabled="disabled" hidden="hidden" value="">Select Order Status</option><option value="1" selected="selected">Processing </option><option value="2">Shipped</option><option value="3">Delivered</option><option value="4">Cancelled</option><option value="5">Exchanged</option><option value="6">Returned</option><option value="7">Undelivered</option><option value="8">Delayed</option><option value="9">Partially Shipped</option><option value="10">Refunded</option></select>
                   
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4">
                    {!! Form::label('amount', "Order Amount $currencySym",['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('order_amt',null, ["class"=>'form-control priceConvertTextBox validate[required,custom[number]]]' ,"placeholder"=>'Order Amount']) !!}
                    
                </div>
               
                <div class="col-md-4">
                    {!! Form::label('payamount', "Vendor Payable Amount $currencySym",['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('pay_amt',null, ["class"=>'form-control priceConvertTextBox validate[required,custom[number]]' ,"placeholder"=>'Vendor Payable Amount']) !!}
                  
                </div>

                <div class="col-md-4">
                    {!! Form::label('comment', 'Order Comment',['class'=>'control-label']) !!}
                        {!! Form::text('order_comment',null, ["class"=>'form-control' ,"placeholder"=>'Order Comment']) !!}
                   
                </div>
              
                <div class="col-md-4">
                    {!! Form::label('shipping_amt', "Shipping Amount $currencySym",['class'=>'control-label']) !!} 
                        {!! Form::text('shipping_amt',null, ["class"=>'form-control priceConvertTextBox validate[custom[number]]' ,"placeholder"=>'Shipping Amount']) !!}
                  
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4">
                    {!! Form::label('shiplabel_tracking_id', 'Tracking Id',['class'=>'control-label']) !!}
                        {!! Form::text('shiplabel_tracking_id',null, ["class"=>'form-control' ,"placeholder"=>'Tracking Id']) !!}
                    
                </div>
                <div class="col-md-4">
                    {!! Form::label('po_no', 'PO No. ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('po_no',null, ["class"=>'form-control validate[required,custom[number]]]' ,"placeholder"=>'PO No.']) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::label('billno', 'Bill Number',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('billno',null, ["class"=>'form-control validate[required,custom[number]]]' ,"placeholder"=>'Bill Number']) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::label('billcopy', 'Bill Copy',['class'=>'control-label']) !!}
                    <input type="file" name="billcopy">
                </div>
                <div class="row"></div><br>
          
                <!-- <div class="row" style="margin-left: 0px">
                    <div class="col-md-4"> 
                        {!! Form::submit('Submit',["class" => "btn btn-primary margin-left0"]) !!}                            
                    </div>
                </div> -->
                {!! Form::hidden('id',null) !!}
                {!! Form::close() !!}
               
                <h4>Vendor Details</h4>
                {!! Form::model(['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal']) !!}

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4">
                    {!! Form::label('first_name', 'First Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('first_name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'First Name']) !!}
                   
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4">
                    {!! Form::label('last_name', 'Last Name',['class'=>'control-label']) !!}
                        {!! Form::text('last_name',null, ["class"=>'form-control' ,"placeholder"=>'Last Name']) !!}
                    
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4">
                    {!! Form::label('phone_no', 'Mobile Number ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('phone_no',null, ["class"=>'form-control validate[required,custm[phone]]' ,"placeholder"=>'Phone Number']) !!}
                   
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="col-md-4">
                    {!! Form::label('address1', 'Address 1 ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('address1',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Address 1']) !!}
                   
                </div>
                
                
                {!! Form::hidden('id',null) !!}
                {!! Form::close() !!}
                <div class="row"></div><br>
                <h4>Product Details</h4>
                {{ Form::hidden('id') }}

                    {{ Form::model(['method' => 'post', 'url' => $action , 'class' => 'bucket-form rtForm', 'id' => 'updateReturnQty', ]) }}
                   
                    
                    <div class="clear clear_fix clearfix"> </div>
                    
                    <div class="col-md-4 form-group">
                        {{ Form::label('shipping_amt', 'Shipping Amount') }}
                        {{ Form::text('shipping_amt',null,["class"=>'form-control additionalCharges priceConvertTextBox otherAmt validate[required, custom[number]]']) }}
                    </div>
                   
                   
                    <div class="col-md-4 form-group">
                        {{ Form::label('order_amt', 'Order Amount') }}
                        {{ Form::text('order_amt',null,["class"=>'form-control ordT priceConvertTextBox validate[required, custom[number]]' ,"placeholder"=>'Enter Order Amount','readonly'=>'true']) }}
                    </div>

                    <div class="col-md-4 form-group">
                        {{ Form::label('pay_amt', 'Vendor Payable Amount') }}
                        {{ Form::text('pay_amt','689.00',["class"=>'form-control' ,'readonly'=>'true']) }}
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
                                <th>Ordered Qty</th>
                                <th>Unit Price <span class="currency-sym-in-braces"></span></th>
                                <th>Total Price <span class="currency-sym-in-braces"></span></th>
                                <th>Delivery Inwards</th>
                                <th>Rejected Quantity</th>
                                <th>Reason</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <tr>
                                <td>Vases & Flowers</td>
                                <td style="width: 30%">THE CHERRY Myvilla Cute Plastic Round Shape Artificial Flower Plant Bonsai with Pot</td>
                                <td></td>
                                <td><input type="number" name="" value="1" min="1"></td>
                                <td>389.00</td>
                                <td>389.00</td>
                                <td><input type="number" name="" value="1" min="1"></td>
                                <td><input type="number" name="" value="0" ></td>
                                <td><input type="text" name="" value=""></td>
                            </tr>
                        </tbody>
                    </table>


                            <div class="col-md-6 noRightpadding noMobilePadding">
                                <table class="table tableVaglignMiddle table-hover priceTable">
                                   
                                    <tr class="sub-total-amt">
                                        <th><div class="black-bg">Subtotal: ₹664</div></th>

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
    
</section> 
@stop 

@section('myscripts')

@stop
