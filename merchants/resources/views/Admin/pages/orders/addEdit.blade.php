@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Orders
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Orders</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#order-detail" data-toggle="tab" aria-expanded="true">Order Details</a></li>
            <li class=""><a href="#customer-detail" data-toggle="tab" aria-expanded="true">Customer Details</a></li>
            <li class=""><a href="#product-detail" data-toggle="tab" aria-expanded="true">Product Details</a></li>
        </ul>
        <div  class="tab-content" >
            <div class="tab-pane active" id="order-detail">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
                </div>
                <?php
//                print_r(Session::all());
                $currencySym = !empty(Session::get('currency_symbol')) ? '(' . Session::get('currency_symbol') . ')' : '';
                ?>
                {!! Form::model($order, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('payment_method', 'Payment Method ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                </div>
                    <div class="col-md-10">
                        {!! Form::select('payment_method', $payment_methods,null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Select Payment Method']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('payment_status', 'Payment Status ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
</div>
                    <div class="col-md-10">
                        {!! Form::select('payment_status',$payment_status ,null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Select Payment Status',]) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('order_status', 'Order Status ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::select('order_status',$order_status ,null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Select Order Status']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('amount', "Order Amount $currencySym",['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::text('order_amt',null, ["class"=>'form-control priceConvertTextBox validate[required,custom[number]]]' ,"placeholder"=>'Order Amount']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('payamount', "Customer Payable Amount $currencySym",['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::text('pay_amt',null, ["class"=>'form-control priceConvertTextBox validate[required,custom[number]]' ,"placeholder"=>'Customer Payable Amount']) !!}
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('gifting_charges', "Gifting Charges $currencySym",['class'=>'control-label']) !!}</div>
                    <div class="col-md-10">
                        {!! Form::text('gifting_charges',null, ["class"=>'form-control priceConvertTextBox validate[custom[number]]' ,"placeholder"=>'Gifting Charges']) !!}
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('cod charges', "COD Charges $currencySym",['class'=>'control-label']) !!}
</div>
                    <div class="col-md-10">
                        {!! Form::text('cod_charges',null, ["class"=>'form-control priceConvertTextBox validate[custom[number]]' ,"placeholder"=>'COD Charges']) !!}
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('description', 'Description',['class'=>'control-label']) !!}</div>
                    <div class="col-md-10">
                        {!! Form::textarea('description',null, ["class"=>'form-control' ,"placeholder"=>'Description']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('comment', 'Order Comment',['class'=>'control-label']) !!}</div>
                    <div class="col-md-10">
                        {!! Form::text('order_comment',null, ["class"=>'form-control' ,"placeholder"=>'Order Comment']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('shipping_amt', "Shipping Amount $currencySym",['class'=>'control-label']) !!} </div>
                    <div class="col-md-10">
                        {!! Form::text('shipping_amt',null, ["class"=>'form-control priceConvertTextBox validate[custom[number]]' ,"placeholder"=>'Shipping Amount']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('shiplabel_tracking_id', 'Tracking Id',['class'=>'control-label']) !!}</div>
                    <div class="col-md-10">
                        {!! Form::text('shiplabel_tracking_id',null, ["class"=>'form-control' ,"placeholder"=>'Tracking Id']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('voucher_amt_used', "Voucher Amount Used $currencySym", ['class'=>'control-label']) !!}</div>
                    <div class="col-md-10">
                        {!! Form::text('voucher_amt_used',null, ["class"=>'form-control validate[custom[number]]' ,"placeholder"=>'Voucher Amount Used']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('coupon_amt_used', "Coupon Amount Used $currencySym", ['class'=>'control-label']) !!} </div>
                    <div class="col-md-10">
                        {!! Form::text('coupon_amt_used',null, ["class"=>'form-control priceConvertTextBox validate[custom[number]]' ,"placeholder"=>'Coupon Amount Used']) !!}
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('referal_code_amt', "Referral Amount Used $currencySym", ['class'=>'control-label']) !!}  </div>
                    <div class="col-md-10">
                        {!! Form::text('referal_code_amt',null, ["class"=>'form-control priceConvertTextBox validate[custom[number]]' ,"placeholder"=>'Referral Amount Used']) !!}
                    </div>
                </div>
                @if($feature['flag'] == 1)  
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('flag_id', 'Flag ',['class'=>'control-label']) !!} 
</div>
                    <div class="col-md-10">
                        {!! Form::select('flag_id',$flags ,@$order->flag_id, ["class"=>'form-control ' ,"placeholder"=>'Select flag']) !!}
                    </div>
                </div>
                @endif

                @if($feature['courier-services'] == 1)  
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('courier', 'Courier Service ',['class'=>'control-label']) !!}
</div>
                    <div class="col-md-10">
                        {!! Form::select('courier',$courier ,@$order->courier, ["class"=>'form-control ' ,"placeholder"=>'Select Courier Service']) !!}
                    </div>
                </div>
                @endif
            <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('remark', "Customer Remark", ['class'=>'control-label']) !!} </div>
                    <div class="col-md-10">
                        {!! Form::text('remark',null, ["class"=>'form-control' ,"placeholder"=>'', "readonly"]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-2"> 
                        {!! Form::submit('Submit',["class" => "btn btn-primary margin-left0"]) !!}                            
                    </div>
                </div>
                {!! Form::hidden('id',null) !!}
                {!! Form::close() !!}
            </div>
            <div class="tab-pane" id="customer-detail">

                {!! Form::model($order, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal']) !!}

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('first_name', 'First Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::text('first_name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'First Name']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('last_name', 'Last Name',['class'=>'control-label']) !!}</div>
                    <div class="col-md-10">
                        {!! Form::text('last_name',null, ["class"=>'form-control' ,"placeholder"=>'Last Name']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('address1', 'Address 1 ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::text('address1',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Address 1']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('address2', 'Address 2 ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::text('address2',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Address 2']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('address3', 'Address 3',['class'=>'control-label']) !!}</div>
                    <div class="col-md-10">
                        {!! Form::text('address3',null, ["class"=>'form-control' ,"placeholder"=>'Address 3']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('phone_no', 'Mobile Number ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::text('phone_no',null, ["class"=>'form-control validate[required,custm[phone]]' ,"placeholder"=>'Phone Number']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('city', 'City ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::text('city',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'City']) !!}
                    </div>
                </div>
                  <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('thana', 'Thana ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::text('thana',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Thana']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('country_id', 'Country ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::select('country_id', $countries,null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Select Country']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('zone_id', 'State/Zone ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::select('zone_id', $zones, null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Select Zone']) !!}
                    </div>
                </div> 
                <div class="form-group">
                <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('postal_code', 'Pincode ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span></div>
                    <div class="col-md-10">
                        {!! Form::number('postal_code',null, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Pincode']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-2">
                        {!! Form::submit('Submit',["class" => "btn btn-primary margin-left0"]) !!}                            
                    </div>
                </div>
                {!! Form::hidden('id',null) !!}
                {!! Form::close() !!}

            </div>

            <!-- Product Deatails form open -->
            <div class="tab-pane" id="product-detail">
                <div class="panel-body">
                    <!-- {{ Form::model($order, ['method' => 'post', 'route' => 'admin.orders.update.return' ,'id' => 'updateReturnQty', 'class' => 'bucket-form rtForm' ]) }} -->
                    {{ Form::hidden('id') }}

                    {{ Form::model($order, ['method' => 'post', 'url' => $action , 'class' => 'bucket-form rtForm', 'id' => 'updateReturnQty', ]) }}
                    {!! Form::hidden('user_id',$order->user_id) !!}
                    <div class="clear clear_fix clearfix"> </div>
                    <div class="col-md-6 pull-right form-group text-right">       
                        {{ Form::button('Reset',["class" => "btn btn-primary resetButton"]) }} &nbsp;
                        {{ Form::submit('Submit',["class" => "btn btn-info"]) }}
                    </div>
                    <div class="clear clear_fix clearfix"> </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('cod_charges', 'COD Charges') }}
                        {{ Form::text('cod_charges',null,["class"=>'form-control additionalCharges priceConvertTextBox otherAmt validate[required, custom[number]]']) }}
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('shipping_amt', 'Shipping Amount') }}
                        {{ Form::text('shipping_amt',null,["class"=>'form-control additionalCharges priceConvertTextBox otherAmt validate[required, custom[number]]']) }}
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('Gifting Charges', 'Gifting Charges') }}
                        {{ Form::text('gifting_charges',null,["class"=>'form-control additionalCharges priceConvertTextBox otherAmt validate[required, custom[number]]']) }}
                    </div>
                    <div class="clear clear_fix clearfix"> </div>
                    @if($feature['coupon']==1)
                    <div class="col-md-4 form-group">
                        {{ Form::label('coupon_amt_used', 'Coupon Amount Used') }}
                        {{ Form::text('coupon_amt_used',null,["class"=>'form-control disc otherAmt priceConvertTextBox validate[required, custom[number]]' ,'readonly'=>'true']) }}
                    </div>
                    @endif


                    @if($feature['manual-discount']==1)
                    <div class="col-md-4 form-group">
                        {{ Form::label('discount_amt', 'User Discount') }}
                        {{ Form::text('discount_amt',null,["class"=>'form-control disc user_disc priceConvertTextBox validate[required,custom[number]]' , 'readonly'=>'true']) }}
                    </div>
                    @endif
                     @if($feature['referral']==1)
                    <div class="col-md-4 form-group">
                        {{ Form::label('referal_code_amt', 'Referral Amount Used') }}
                        {{ Form::text('referal_code_amt',null,["class"=>'form-control disc eqlDistReff priceConvertTextBox validate[required,custom[number]]' , 'readonly'=>'true']) }}
                    </div>
                    @endif
                     <div class="clear clear_fix clearfix"> </div>
                    @if($feature['loyalty']==1)
                    <div class="col-md-4 form-group">
                        {{ Form::label('Reward Points Usedt', 'Loyalty Points') }}
                        {{ Form::text('cashback_used',null,["class"=>'form-control disc  eqlDistCash priceConvertTextBox validate[required,custom[number]]' ,'readonly'=>'true']) }}

                    </div>
                    @endif
                   
                    <div class="col-md-4 form-group">
                        {{ Form::label('order_amt', 'Order Amount') }}
                        {{ Form::text('order_amt',null,["class"=>'form-control ordT priceConvertTextBox validate[required, custom[number]]' ,"placeholder"=>'Enter Order Amount','readonly'=>'true']) }}
                    </div>

                    <div class="col-md-4 form-group">
                        {{ Form::label('pay_amt', 'Customer Payable Amount') }}
                        {{ Form::text('pay_amt',null,["class"=>'form-control ordP priceConvertTextBox validate[required, custom[number]]' ,'readonly'=>'true']) }}
                    </div>
                    <div class="clear clear_fix clearfix"> </div>
                    {{ Form::hidden('ordereditCal',null) }}
                    {{ Form::hidden('id') }}
                    {{ Form::hidden('cashback_to_add',0) }}
                    <div class="clear clear_fix clearfix"> </div>
                    <div class="pull-right mob-marBottom15">
                        <a href="#" class="btn btn-success addProd">Add New Product</a>
                    </div>
                    
                    <div class="clear clear_fix clearfix"> </div>
                    <div class="table-responsive">
                    <table class="table table-hover general-table prodETable" id="tableProd">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Product Variant</th>
                                <th>Qty</th>
                                <th>Unit Price <span class="currency-sym-in-braces"></span></th>
                                <th>Price <span class="currency-sym-in-braces"></span></th>
                                @if($feature['coupon']==1)
                                <th>Coupon <span class="currency-sym-in-braces"></span></th>
                                @endif
                                @if($feature['loyalty']==1)
                                <th>Cashback <span class="currency-sym-in-braces"></span></th>
                                @endif
    <!--                            <th>Voucher</th>-->
                                @if($feature['referral']==1)
                                <th>Referral <span class="currency-sym-in-braces"></span></th>
                                @endif
                                <!-- <th>SubTotal</th> -->
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;
                            ?>
                            @foreach($products as $k =>$prd)
                                <?php
                                    
                                    $getProductId = $prd->id;
                                    $hasCategories = DB::table('has_categories')
                                            ->where("prod_id", $getProductId )
                                            ->first();
                                    if(!empty($hasCategories))
                                    {
                                        $getStoreCategoryId = $hasCategories->cat_id;
                                        $storeCategories = DB::table('store_categories as sc')
                                            ->join('categories as c', 'c.id', '=', 'sc.category_id')
                                            ->where("sc.id", $getStoreCategoryId)
                                            ->select('c.category')
                                            ->get();
                                        //echo "<pre>";
                                        //print_r($storeCategories);
                                        if(!empty($storeCategories))
                                        {
                                             foreach($storeCategories as $getCatName)
                                            {
                                                $categoryName = ucwords($getCatName->category);
                                            }
                                            //$categoryName = ucwords($storeCategories->[0]->category);
                                            //$categoryName = ucwords($storeCategories[0]['category']);
                                            //$categoryName = ucwords($storeCategories->$i->category);
                                            
                                        }
                                    }
                                    else {
                                        $categoryName = '-';    
                                    }
                                    
                                       
                                 ?>
                                <tr> 
                                <!--<td>{{ @$prd->categories()->first()->category }}</td>-->
                                <td>{{$categoryName}}</td>
                                <td>{{ $prd->product }}</td>
                                @if($prd->prod_type == 3)
                                <?php
                                $parentid = App\Models\Product::find($prd->sub_prod_id)->parent_prod_id;
                                $getSubprods = App\Models\Product::find($parentid)->subproducts()->get();
                                $configPrds = [];
                                foreach ($getSubprods as $subp) {
                                    $nameProd = explode("Variant", $subp->product, 2);
                                    $filtered_words = array(
                                        '(',
                                        ')',
                                        'frames',
                                        'posters',
                                    );
                                    $gap = '';

                                    $prodSize = str_replace($filtered_words, $gap, $nameProd[1]);
                                    $configPrds[$subp->id] = $prodSize;
                                }
                                ?>
                                <td>
                                    {{ Form::select("cartdata[".$i."][".$prd->id."][subprd]",$configPrds,$prd->sub_prod_id,['class'=>'form-control selConfigProd addPrdVar']) }}
                                </td>
                                @elseif($prd->prod_type == 2)
                                <?php
                                $cmb = json_decode($prd->sub_prod_id);
                                $comboSub = [];
                                // foreach ($cmb as $combos) {
                                //     $comboSub[App\Models\Product::find($combos)->parent_prod_id] = $combos;
                                // }
                                    $comboSub[App\Models\Product::find($prd->sub_prod_id)->parent_prod_id] = $prd->sub_prod_id;
                                ?>
                                <td>
                                    <?php
                                    $comboProds = App\Models\Product::find($prd->id)->comboproducts()->get();
                                    foreach ($comboProds as $combP) {
                                        $cprd = App\Models\Product::find($combP->id);
                                        if ($cprd->prod_type == 1) {
                                            echo $cprd->product . "(" . $cprd->categories()->first()->category . ")<br/>";
                                        }
                                        if ($cprd->prod_type == 3) {
                                            echo $cprd->product . "(" . $cprd->categories()->first()->category . ")<br/>";
                                            $getS = $cprd->subproducts()->get();
                                            $csub = [];
                                            foreach ($getS as $getSub) {
                                                $nameProd1 = explode("Variant", $getSub->product, 2);
                                                $filtered_words = array(
                                                    '(',
                                                    ')',
                                                    'frames',
                                                    'posters',
                                                );
                                                $gap = '';
                                                $prodSize1 = str_replace($filtered_words, $gap, $nameProd1[1]);
                                                $csub[$getSub->id] = $prodSize1;
                                            }
                                            ?>
                                            {{ Form::select("cartdata[".$i."][".$prd->id."][subprd][]", $csub, $prd->sub_prod_id,['class'=>'form-control subComboProd selPrdVar']) }}
                                            <?php
                                        }
                                    }
                                    ?>
                                </td>
                                @else
                                <td>-</td>
                                @endif
                                <td>
                                    <input type="hidden" class="pid_{{$prd->id}}" value="{{ $prd->qty }}"  />
                                    <input  name="{{"cartdata[".$k."][".$prd->id."]"}}[qty]" type="number" min="1" data-ppid="{{$prd->id}}" data-prdType="{{$prd->prod_type}}" {{ $prd->prod_type == 3?' subprod-id='.$prd->sub_prod_id:'' }} class="qtyOrder editqty form-control validate[required, custom[number],,min[1]]" value="{{ $prd->qty }}" />
                                </td>
                                <td><b class="price">{{ number_format((@$prd->selling_price * Session::get("currency_val")), 2) }}</b></td>
                                <td><b class="subT">{{ number_format((@$prd->hasPrice * Session::get("currency_val")), 2)}}</b></td>
                                @if($feature['coupon']==1)
                                <td><b class="coupDisc">{{  round($prd->disc * Session::get("currency_val"))  }}</b></td>
                                @endif
                                <?php
                                $productP = ($prd->hasPrice / 100);
                                $orderAmtP = ($order->order_amt / 100);
                                $fixedVaoucherUsed = $order->voucher_amt_used;
                                $fixedCashbackUsed = $order->cashback_used;
                                $fixedReferalUsed = $order->referal_code_amt;
                                $discCashBackA = 0;
                                $discVoucherA = 0;
                                $discReferalA = 0;
                                // $discCashBackA = App\Library\Helper::discForProduct($productP, $orderAmtP, $fixedCashbackUsed);
                                // $discVoucherA = App\Library\Helper::discForProduct($productP, $orderAmtP, $fixedVaoucherUsed);
                                // $discReferalA = App\Library\Helper::discForProduct($productP, $orderAmtP, $fixedReferalUsed);
                                // $allDiscFor = round($discCashBackA + $discVoucherA + $discReferalA + round($prd->pivot->disc));
                                ?>
                                @if($feature['loyalty']==1)
                                <td><b class="cashbackDisc">{{ number_format((@$fixedCashbackUsed * Session::get('currency_val')), 2)  }}</b></td>
                                @endif
                             
                                @if($feature['referral']==1 )
                                <td><b class="referalDisc">{{ @$fixedReferalUsed  }}</b></td>
                                @endif
                              
                                <td><a href="#" class="delPrd"><i class="fa fa-trash-o" style="color:red;"></i></a></td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                                </div>
                    <div class="clear clear_fix clearfix"> </div>
                    <div class="col-md-6 pull-right form-group text-right mob-marTop15">       
                        <!-- {{ Form::button('Reset',["class" => "btn btn-primary resetButton"]) }} &nbsp;
                        {{ Form::submit('Submit',["class" => "btn btn-info"]) }} -->
                        <input type="hidden" name="attrgetid" class="getArr" value="{{$i}}">
                        {{ Form::hidden('return_url',Input::get('returnUrl')) }}
                        {{ Form::button('Submit',["class" => "btn btn-info submitReturn"]) }}

                        {{ Form::close() }}
                    </div>
                    <table class="table table-striped table-hover additional-charge">
                        @if($feature['additional-charge']==1)
                        @if(isset($order->additional_charge))
                        <?php $additional_charges = json_decode($order->additional_charge, true); ?>
                        @foreach($additional_charges['details'] as $key => $val)
                        <tr class="order-total">
                            <th>{{ $val['label']  }}</th>
                            <td>{{ $val['applied'] * Session::get("currency_val") }}</td> 
                        </tr>
                        @endforeach
                        @endif
                        @endif
                        <tr>
                            <th>Total {{$currencySym}}</th>
                            <td>{{ $order->pay_amt * Session::get("currency_val")}}</td> 
                        </tr>

                    </table>
                    <!-- {{ Form::close() }} -->

                    <div class="col-md-12">
                        <div class="cal-shipping  mar-bot15">
                            @if($feature['coupon'] == 1)
                            <h4 class="heading-title">HAVE A COUPON?</h4>
                            <div class="list-group horizontal-list-group">
                                <div class="list-group-item">
                                    <label class="ui-radio-inline">
                                        <input type="radio" checked name="radioEg" checked value="none"> 
                                        <span>None</span>
                                    </label>
                                    <p class="list-group-item-text">No coupon applicable</p>
                                </div>
                                <?php $coupon_id = $coupon ? $coupon->id : null; ?>
                                @if(!$coupons->isEmpty())
                                @foreach($coupons as $coupon)
                                <div class="list-group-item">
                                    <label class="ui-radio-inline">
                                        <input type="radio" name="radioEg" <?php echo $coupon_id == $coupon->id ? 'checked' : ''; ?> value="{{ $coupon->coupon_code }}" > 
                                        <span>{{ $coupon->coupon_code }}</span>
                                    </label>
                                    <p class="list-group-item-text">{{ $coupon->coupon_name }}</p>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @endif
                            <!-- <form class="checkout_coupon" method="post">
                              <div class="cart-input">
                              <input name="coupon_code" class="userCouponCode" id="" value="" placeholder="Coupon code"  type="text"> 
                               </div>
                            <div class="input-submit">
                           <input class="button bold default" name="apply_coupon" id="couponApply" value="Apply Coupon" type="button">
                            </div>
                           </form> -->
                            <!-- <div class="col-md-12 col-xs-12 space3">
                           <p class="cmsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p>
                             </div>
                           </div> -->
                            <!-- .cal-shipping -->

                            <!-- Start voucher refferel Cashback Discount -->

                            <div class="summry_col">
                                @if($feature['loyalty'] == 1)
                                <h3>
                                    <span class="pull-left summry_title">Current Reward Points </span>&nbsp;&nbsp;<span class="currency-sym"></span>
                                    <span class="rwd_pont curRewPointsOld">&nbsp; {{ number_format(($order->users->cashback * Session::get('currency_val')), 2) }}</span>
                                    <span class="pull-right rwd_pont curRewPointsNew" style="display:none;"></span>
                                </h3>
                                @endif
                                <ul class="current-list-reward">
                                    @if($feature['loyalty'] == 1) 
                                    <li><div class="cashbackAmt"><input id="checkbox1"  class="requireCashback" type="checkbox" name="requireCashback" value="1" ><label for="checkbox1"><span></span>Apply Reward Points <p><a href="" target="_blank" class="blue_text">Check Reward Points</a></p></label>
                                            <p class="cashbackMsg" style="display:none;" ></p></div>
                                    </li>
                                    @endif
                                    <div>
                                        <div>
                                            @if(@$settingStatus['des'] == 1)
                                            <!--                                                <li> 
                                                                                                <div class="form-group">
                                                                                                    <label for="email" class="col-md-12">GIFT VOUCHER</label>
                                                                                                    <p class="col-md-8"><input name="user_voucher_code" type="text" class="form-control userVoucherCode cartinput" placeholder="Enter Voucher Code"></p>
                                                                                                    <p class="col-md-4"><button type="button" class="btn new_user_btn" id="voucherApply">APPLY</button></p>
                                                                                                    <div class="col-sm-12 col-xs-12"><p class="vMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p></div>
                                                                                                </div>
                                                                                            </li>-->
                                            @endif

                                            @if($feature['des'] == 1)
                                            <li> 
                                                <div class="form-group">
                                                    <label for="email" class="col-md-12 col-sm-12 col-xs-12">Discount</label>
                                                    <div class="col-md-4 col-sm-4 col-xs-12 mob-marBottom15">
                                                        <select class="form-control" name="user-level-disc-type" id="user-level-disc" >
                                                            <option >Please Select</option>
                                                            <option value="1">Percentage</option>
                                                            <option value="2">Absolute</option>
                                                        </select> 
                                </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-12 mob-marBottom15">
                                                        <input name="user_level_discount" type="text" class="form-control userLevelDiscount" placeholder="Enter value for discount">
                                </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <button type="button" class="btn new_user_btn mobileSpecialfullBTN noMob-leftmargin" id="userlevelDiscApply">APPLY</button>
                                </div>
                                                    <div class="col-sm-12 col-xs-12">
                                                        <p class="dMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p>
                                                    </div>
                                                </div>
                                                <div class="clearfix marginBottom15"></div>
                                            </li>
                                            @endif
                                            @if($feature['referral'] == 1)
                                            <li>
                                                <div class="form-group">
                                                    <label for="email" class="col-md-12 col-sm-12 col-xs-12 mob-marBottom15">REFERRAL</label>
                                                    <div class="col-md-8 col-sm-4 col-xs-12 mob-marBottom15"><input name="require_referal" type="text" class="form-control requireReferal cartinput" placeholder="Enter Referral Code"></div>
                                                    <div class="col-md-4 col-sm-4 col-xs-12 mob-marBottom15"><button type="button" class="btn new_user_btn referalCodeClass mobileSpecialfullBTN noMob-leftmargin" id="requireReferalApply">APPLY</button></div>
                                                    <div class="col-sm-12 col-xs-12"> 
                                                        <p class="blue_text">Applicable only for first time users.</p>
                                                        <p class="referalMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endif
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section> 
@stop 

@section('myscripts')
<script>

    $("#showCategories").hide();
    $("#showProducts").hide();
    if ($("#order_status").val() == 2 || $("#order_status").val() == 3) {
    $("#customer-detail input, #customer-detail select").prop('disabled', true);
    }
//    $("a.deleteImg").click(function () {
//        var imgs = $("input[name='c_image']").val();
//        var r = confirm("Are You Sure You want to Delete this Image?");
//        if (r == true) {
//            $("input[name='c_image']").val('');
//            $(this).parent().hide();
//        } else {
//
//        }
//    });

    $(".checkCategoryId").click(function () {
    var ids = $(".allCategories input.checkCategoryId:checkbox:checked").map(function () {
    return $(this).val();
    }).toArray();
    $("input[name='CategoryIds']").val(ids);
    });
    $(".checkProductId").click(function () {
    var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
    return $(this).val();
    }).toArray();
    $("input[name='ProductIds']").val(ids);
    });
    if ($("#coupon_type").val() == 2) {
    $("#showProducts").hide();
    $("#showCategories").show();
    var ids = $(".allCategories input.checkCategoryId:checkbox:checked").map(function () {
    return $(this).val();
    }).toArray();
    $("input[name='CategoryIds']").val(ids);
    }

    if ($("#coupon_type").val() == 3) {
    $("#showCategories").hide();
    $("#showProducts").show();
    var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
    return $(this).val();
    }).toArray();
    $("input[name='ProductIds']").val(ids);
    }

    $("#coupon_type").change(function () {
    if ($("#coupon_type").val() == 2) {
    $("#showProducts").hide();
    $("#showCategories").show();
    $("input[name='ProductIds']").val("");
    }

    if ($("#coupon_type").val() == 3) {
    $("#showCategories").hide();
    $("#showProducts").show();
    $("input[name='CategoryIds']").val("");
    }

    if ($("#coupon_type").val() == 1) {
    $("#showCategories").hide();
    $("#showProducts").hide();
    $("input[name='CategoryIds']").val("");
    $("input[name='ProductIds']").val("");
    }
    });
    if ($("#user_specific").val() == 0) {
    $(".userslist").hide();
    }

    $("#user_specific").change(function () {
    if ($("#user_specific").val() == 1) {
    $(".userslist").show();
    } else {
    $(".userslist").hide();
    }
    });
    $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
/////////////////////// return qty
    $(".undolink").hide();
    if ($("#order_status").val() != 3) {
    $("table .inputReturn").attr("disabled", true);
    }
    if ($("#order_status").val() == 1){
    $("table .orderQty").attr("disabled", false);
    }
    var chkD = $("table :input").attr("disabled");
    $(".undolink").click(function () {

    $("table *").removeAttr("disabled");
    $(".rtForm").attr("action", "{{ URL::route('admin.orders.revert.return')}}");
    var r = confirm("Are you sure you want to continue this?");
    if (r == true) {
    $("#updateReturnQty").submit();
    }


    });
    $(".retQtyChk").keyup(function () {
    var Qtychk = parseInt($(this).val());
    var orderQty = parseInt($(".orderQty").val());
    if (Qtychk <= orderQty) {
    $(this).closest("tr").find(".retError").text("");
    } else {
    $(this).closest("tr").find(".retError").text("Please enter valid quantity");
    }
    });
    $(".submitReturn").click(function () {
    i = 0;
    var errorText = [];
    $(".table").find("tr").each(function () {

    if ($(this).find(".retError").text() != "") {

    errorText[i++] = $(this).find(".retError").text();
    }

    });
    if (errorText != "") {
    } else {

    var r = confirm("Are you sure you want to continue this?");
    if (r == true) {
    $("#updateReturnQty").submit();
    }

    }

    });
    ///////////////////////   

    $(".orderQty").keyup(function () {
    var qty = $(this).val();
    var price = $(this).closest('tr').find('.prodPrice').val();
    $(this).closest('tr').find('.totalPrice').html(price * qty);
    var subtotal = 0;
    $('.totalPrice').each(function (index) {
    subtotal += parseInt($(this).html()) || 0;
    });
    $('.subTotal').html(subtotal);
    var couponAmt = parseInt($('.couponAmt').html()) || 0;
    var discountAmt = parseInt($('.discountAmt').html()) || 0;
    var cashbackAmt = parseInt($('.cashbackAmt').html()) || 0;
    var shippingAmt = parseInt($('.shippingAmt').html()) || 0;
    $('.grandTotal').html(subtotal - couponAmt - discountAmt - cashbackAmt + shippingAmt);
    });
///////////////////////////
    var tagFunction = function () {
    function log(message) {
    $("<div>").html(message).prependTo("#log");
    $("#log").scrollTop(0);
    }

    $products = $("#pdcts");
    $products.autocomplete({
    source: "{{route('admin.coupons.searchUser')}}",
            minLength: 2,
            select: function (event, ui) {
            log(ui.item ?
                    ui.item.email + "<input type='hidden' name='uid[]' value='" + ui.item.id + "' ><a href='#' class='pull-right remove-rag'  ><i class='fa fa-trash'></i></a>" : "");
            }
    });
    $products.data("ui-autocomplete")._renderItem = function (ul, item) {
    return $("<li>")
            .append("<a>" + item.email + "</a>")
            .appendTo(ul);
    };
    ;
    };
    jQuery('body').on('click', '.remove-rag', function (event) {
    /* Act on the event */
    event.preventDefault();
    jQuery(this).parent().remove();
    });
    $(".addProd").click(function () {
<?php
$caTs = App\Models\Category::where("is_nav", 1)->with(['categoryName' => function($query) {
    return $query->orderBy('category', 'ASC');
}])->get();
$cats = ["" => "Please select"];
foreach ($caTs as $c) {
    if ($c->id != 153)
        $cats[$c->id] = $c->category;
}
$phoneCoversSel = App\Models\Category::where("parent_id", "=", 153)->with(['categoryName' => function($query) {
    return $query->orderBy('category', 'ASC');
}])->get();
foreach ($phoneCoversSel as $phoneC) {
    $cats["test" . $phoneC->id] = $phoneC->category;
    foreach ($phoneC->subcategories()->get() as $subCat) {
        $cats[$subCat->id] = " &nbsp; &nbsp;- " . $subCat->category;
    }
}
$selCat = \Form::select("cat", $cats, null, ["class" => "form-control addProdCat validate[required]"]);
$productSel = \Form::select("product", [], null, ["class" => "form-control addPrd validate[required]"]);
$productVar = \Form::select("product_var", [], null, ["class" => "form-control addPrdVar"]);
$prodQty = '<input  name="cartdata[qty]" type="number" min="1"  class="qtyOrder editqty form-control addPrdQty validate[required, custom[number],,min[1]]" data-ppid="" data-prdType=""  value="" />';
$priceSel = '<b class="price"></b>';
$subTotSel = '<b class="subT"></b>';
$couponDisc = '<b class="coupDisc"></b>';
$cashbackDisc = '<b class="cashbackDisc"></b>';
$voucherDisc = '<b class="voucherDisc"></b>';
$referalDisc = '<b class="referalDisc"></b>';
// $finalSubTotDiv = '<i class="fa fa-rupee"></i><b class="finalSubTotal"></b>';
$seldel = '<a href="#" class="delPrd"><i class="fa fa-trash-o" style="color:red;"></i></a>';
?>
    var newtd = '<td><?php echo $selCat; ?></td>';
    newtd += '<td><?php echo $productSel; ?></td>';
    newtd += '<td class="forPrdVar"><?php echo $productVar; ?></td>';
    newtd += '<td><?php echo $prodQty; ?></td>';
    newtd += '<td><?php echo $priceSel; ?></td>';
    newtd += '<td><?php echo $subTotSel; ?></td>';
    newtd += '<td><?php echo $couponDisc; ?></td>';
    newtd += '<td><?php echo $cashbackDisc; ?></td>';
//    newtd += '<td><?php echo $voucherDisc; ?></td>';
    newtd += '<td><?php echo $referalDisc; ?></td>';
    //  newtd += '<td><?php // echo $finalSubTotDiv;   ?></td>';
    newtd += '<td><?php echo $seldel; ?></td>';
    var newtr = '<tr>' + newtd + '</tr>';
    $("#tableProd tr:last").after(newtr);
    // add_coupon_amt_to_total();
    });
    function calamt() {
    var ordT = 0;
    $(".prodETable").find(".subT").each(function () {
    var sub_p = isNaN(parseInt($(this).text()))?0:parseInt($(this).text())
            ordT = ordT + sub_p;
    });
    console.log(ordT);
    $(".ordT").val(ordT);
    var orderamt = parseInt($(".ordT").val());
    var additionalCharges = 0;
    $(".additionalCharges").each(function () {
    if (parseInt($(this).val()) >= 0)
            additionalCharges = additionalCharges + parseInt($(this).val());
    });
    var disc = 0
            $(".disc").each(function () {
    if (parseInt($(this).val()) >= 0)
            disc = disc + parseInt($(this).val());
    });
    var finalpayableamt = parseInt((orderamt + additionalCharges) - disc);
    console.log(finalpayableamt);
    $(".ordP").val(finalpayableamt);
    $("input[name='ordereditCal']").val(1);
    newCoupA = parseFloat($("input[name='coupon_amt_used']").val());
    newVoucherA = parseFloat($("input[name='voucher_amt_used']").val());
    newReferalA = parseFloat($("input[name='referal_code_amt']").val());
    newCashbackA = parseFloat($("input[name='cashback_used']").val());
    $("#tableProd").find(".subT").each(function () {
    additionalCash = 0;
    newSubTotT = $(this).text();
    if (newCoupA > 0) {
    newCouponAmt = $(this).parent().parent().find(".coupDisc").text();
    if (newCouponAmt > 0)
            additionalCash += parseInt(newCouponAmt);
    }
    if (newCashbackA > 0) {
    calCashback = parseFloat((newSubTotT / 100) * newCashbackA / ($("#order_amt").val() / 100));
    newCamtCashback = (calCashback).toFixed(2);
    if (newCamtCashback > 0)
            additionalCash += parseFloat(newCamtCashback);
    $(this).parent().parent().find(".cashbackDisc").text(newCamtCashback);
    }

    if (newReferalA > 0) {
    calReff = parseFloat((newSubTotT / 100) * newReferalA / ($("#order_amt").val() / 100));
    newCamtReff = (calReff).toFixed(2);
    if (newCamtReff > 0)
            additionalCash += parseFloat(newCamtReff);
    $(this).parent().parent().find(".referalDisc").text(newCamtReff);
    }
    if (newVoucherA > 0) {
    calVouch = parseFloat((newSubTotT / 100) * newVoucherA / ($("#order_amt").val() / 100));
    newCamtVouch = (calVouch).toFixed(2);
    if (newCamtVouch > 0)
            additionalCash += parseFloat(newCamtVouch);
    $(this).parent().parent().find(".voucherDisc").text(newCamtVouch);
    }
    $(this).parent().parent().find(".finalSubTotal").empty();
    newFinalSubtot = parseInt(newSubTotT) - parseInt(additionalCash);
    newFinalSubtot = isNaN(parseInt(newFinalSubtot))? 0 : parseInt(newFinalSubtot);
    $(this).parent().parent().find(".finalSubTotal").text(newFinalSubtot);
    });
    // getAdditionalcharge();
    }

    $(".delete").click(function () {
    var r = confirm("Are You Sure You want to Delete this Attribute Set?");
    if (r == true) {
    $(this).parent().submit();
    } else {
    }
    });
    $(".resetButton").click(function () {
    window.location.reload();
    });
    $("#tableProd").on('click', ".delPrd", function () {
    // var coupAmt = parseFloat($(this).parent().parent().find(".coupDisc").text());
    // var voucherAmt = parseFloat($(this).parent().parent().find(".voucherDisc").text());
    // var referalAmt = parseFloat($(this).parent().parent().find(".referalDisc").text());
    // var cashbackAmt = parseFloat($(this).parent().parent().find(".cashbackDisc").text());
    chk = confirm("Are you sure you want to delete this product?");
    if (chk == true) {
    // $("input[name='ordereditCal']").val(1);
    // var addCashback = parseFloat($("input[name='cashback_to_add']").val()) + cashbackAmt;
    // $("input[name='cashback_to_add']").val(addCashback);
    // if (coupAmt >= 0 && coupAmt != '') {
    //     var newCoupA = parseFloat($("input[name='coupon_amt_used']").val());
    //     $("input[name='coupon_amt_used']").val(parseInt(newCoupA - coupAmt));
    // }
    // if (voucherAmt >= 0 && voucherAmt != '') {
    //     var newVoucherA = parseFloat($("input[name='voucher_amt_used']").val());
    //     $("input[name='voucher_amt_used']").val(parseInt(newVoucherA - voucherAmt));
    // }
    // if (referalAmt >= 0 && referalAmt != '') {
    //     var newReferalA = parseFloat($("input[name='referal_code_amt']").val());
    //     $("input[name='referal_code_amt']").val(parseInt(newReferalA - referalAmt));
    // }
    // if (cashbackAmt >= 0 && cashbackAmt != '') {
    //     var newCashbackA = parseFloat($("input[name='cashback_used']").val());
    //     $("input[name='cashback_used']").val(parseInt(newCashbackA - cashbackAmt));
    // }
    console.log('all update');
    $(this).parent().parent().remove();
    // add_coupon_amt_to_total();
    clearAllDiscount();
    // ApplyCoupon();
    // var voucherCode = $(".userVoucherCode").val();
    // applyVoucher(voucherCode);
    // var discVal = $('input[name="user_level_discount"]').val();
    // applyUserLevelDisc(discVal);
    // var RefCode = $(".requireReferal").val();
    // applyReferal(RefCode);

    } else {
    return false;
    }
    });
    $("#tableProd").delegate(".editqty", "change", function () {
    var qty = parseInt($(this).val());
    var ppid = $(this).attr('data-ppid');
    var ptype = $(this).attr('data-prdType');
    var required_qty = qty - parseInt($(".pid_" + ppid).val());
    var p = parseInt($(this).parent().parent().find(".price").text());
    thisq = $(this);
    if (ptype == 1) {
    var spid = "";
    } else if (ptype == 3) {
    var spid = $(this).parent().parent().find(".selConfigProd").val();
    } else if (ptype == 2) {
    var spidArr = $(this).parent().parent().find(".subComboProd");
    spid = [];
    $(spidArr).each(function () {
    spid.push($(this).val());
    });
    }
    // if (qty <= $(".pid_" + ppid).val()) {
    //     thisq.css("border", "");
    //     var subT = parseInt(qty * p);
    // thisq.parent().parent().find(".subT").text(subT);
    //thisq.parent().parent().find(".finalSubTotal").text(subT);
    // calamt();
    // } else {
    $.ajax({
    type: "POST",
            url: "{{ URL::route('admin.orders.editOrderChkStock') }}",
            data: {ppid: ppid, qty: required_qty, spid: spid, ptype: ptype},
            cache: false,
            success: function (data) {
            if (data == "In Stock") {
            thisq.css("border", "");
            clearAllDiscount();
            } else {
            thisq.css("border", "solid red");
            alert("Out of Stock");
            }
            }
    });
    // }

    });
    $('#tableProd').on('change', '.addProdCat', function () {
    $("input[name='ordereditCal']").val(1);
    var catid = $(this).val();
    if (catid.indexOf("test") == 0) {
    getThis.closest('td').next().find('.addPrd').html('');
    exit;
    }
    $(this).parent().parent().find(".price").text(0);
    $(this).parent().parent().find(".subT").text(0);
    $(this).parent().parent().find(".addPrdVar").hide();
    $(this).parent().parent().find(".addPrdQty").hide();
    $(this).parent().parent().find(".selPrdVar").hide();
    var getThis = $(this);
    $.ajax({
    type: "POST",
            url: "{{URL::route('admin.orders.getCartEditProd')}}",
            data: {catid: catid},
            cache: false,
            success: function (data) {
            getThis.closest('td').next().find('.addPrd').show();
            getThis.closest('td').next().find('.addPrd').html('');
            getThis.closest('td').next().find('.addPrd').append(data);
            }
    });
    });
    $('#tableProd').on('change', '.addPrd', function () {
    var prdid = $(this).val();
    var getarr = parseInt(parseInt($(".getArr").val()) + 1);
    $(".getArr").val(getarr);
    //  alert(getarr);
    // $(this).attr('name', 'cartdata[' + $(this).val() + ']');
    var getpThis = $(this);
    $.ajax({
    type: "POST",
            url: "{{URL::route('admin.orders.getCartEditProdVar')}}",
            data: {prdid: prdid},
            cache: false,
            success: function (data) {
            // console.log(data);
            getpThis.parent().parent().find(".addPrdQty").show();
            var data1 = data.split("||||");
            var getPriceProd = parseInt(data1[0]);
            var getProdType = parseInt(data1[1]);
            var subtotal = data1[4];
            getpThis.parent().parent().find(".price").text((getPriceProd * <?php echo Session::get("currency_val") ?>).toFixed(2));
            getpThis.parent().parent().find(".addPrdQty").val(1);
            getpThis.parent().parent().find(".addPrdQty").attr("data-ppid", prdid);
            getpThis.parent().parent().find(".addPrdQty").attr("data-prdType", getProdType);
            getpThis.parent().parent().find(".subT").text((subtotal * <?php echo Session::get("currency_val") ?>).tofixed(2));
            // getpThis.parent().parent().find(".finalSubTotal").text(subtotal);
            getpThis.parent().parent().find(".addPrdQty").attr('name', "cartdata[" + getarr + "][" + prdid + "][qty]");
            getpThis.parent().parent().find(".addPrdQty").attr('max', data1[3]);
            // calamt();
            if (data1[2] != "invalid") {
            if (getProdType == 3) {
            console.log('type3 -' + data1[2]);
            getpThis.closest('td').next().find('.addPrdVar').show();
            getpThis.closest('td').next().find('.addPrdVar').html('');
            getpThis.closest('td').next().find('.addPrdVar').addClass("selConfigProd");
            getpThis.closest('td').next().find('.addPrdVar').attr('name', 'cartdata[' + getarr + '][' + prdid + '][subprd]');
            getpThis.parent().parent().find(".price").text(0);
            getpThis.closest('td').next().find('.addPrdVar').append(data1[2]);
            }
            } else if (getProdType == 2) {
            $.ajax({
            type: "POST",
                    url: "{{ URL::route('admin.orders.cartEditGetComboSelect') }}",
                    data: {prdid: prdid, getarr: getarr},
                    cache: false,
                    success: function (data) {
                    getpThis.closest('td').next("td").html(data);
                    }
            });
            clearAllDiscount();
            } else {
            getpThis.closest('td').next().find('.addPrdVar').hide();
            getpThis.closest('td').next().find('.forPrdVar').hide();
            clearAllDiscount();
            }

            }
    });
    });
    $("table").delegate(".addPrdVar", "change", function () {
    subprdid = $(this).val();
    subp = $(this);
    var qty_element = $(this).parent().next().find('.qtyOrder');
    parentprodid = qty_element.attr('data-ppid');
    qty_element.attr('subprod-id', subprdid);
    var qty = qty_element.val();
    var send_data = {subprdid: subprdid, qty: qty, pprd: 0};
    $.post("{{route('admin.orders.getProdPrice')}}", send_data, function (data) {

    subp.parent().parent().find('.price').text(data.unitPrice.toFixed(2));
    clearAllDiscount();
    });
    });
    // 
    // $(".selPrdVar").change(function () {
    //     $("input[name='ordereditCal']").val(1);
    //     add_coupon_amt_to_total();
    // });
    // $(".otherAmt").keyup(function () {
    //     if ($(this).val() >= 0)
    //         calamt();
    // });
    $(".OrderS").change(function () {
    //alert("sdfsdf");
    $("#myModal").modal('show');
    $(".saveChanges").click(function () {
    var check = $(".notifyChk").is(":checked");
    var Comment = $(".statusComment").val();
    if (check == true) {
    var notfyVal = 1;
    //  $(".notify").val(1);
    } else {
    var notfyVal = 0;
    }
    // $(".comment").val(Comment);
    $(".addComment").html("<input type='hidden' class='comment' name='comment' value='" + Comment + "'><input type='hidden' class='notify' name='notify' value='" + notfyVal + "'><input type='hidden' name='commentChanges' value='1'>");
    $("#myModal").modal('hide');
    });
    });
    // $(".eqlDistCash").keyup(function () {
    //     var cashbackA = parseInt($(this).val());
    //     if (cashbackA != 0) {
    //         $("#tableProd").find(".subT").each(function () {
    //             newSubTotT = $(this).text();
    //             calCashback = ((newSubTotT / 100) * cashbackA / ($("#order_amt").val() / 100));
    //             newCamt = (calCashback).toFixed(2);
    //             $(this).parent().parent().find(".cashbackDisc").text(newCamt);
    //         });
    //         calamt();
    //     }
    // });
    // $(".eqlDistReff").keyup(function () {
    //     var reffA = parseInt($(this).val());
    //     if (reffA != 0) {
    //         $("#tableProd").find(".subT").each(function () {
    //             newSubTotT = $(this).text();
    //             calCashback = ((newSubTotT / 100) * reffA / ($("#order_amt").val() / 100));
    //             newReff = (calCashback).toFixed(2);
    //             $(this).parent().parent().find(".referalDisc").text(newReff);
    //         });
    //         calamt();
    //     }
    // });
    // $(".eqlDistVoucher").keyup(function () {
    //     var voucherA = parseInt($(this).val());
    //     if (voucherA != 0) {
    //         calamt();
    //     } else {
    //         $(this).val(0);
    //         $(this).parent().parent().find(".voucherDisc").text(0);
    //     }
    // });

    // function add_coupon_amt_to_total(){
    //      var coupon_amt_used = $("input[name='coupon_amt_used']").val(0);
    //      calamt();
    //      $(".clearCoup").click();
    // }


    $("input[name='radioEg']").change(function(){
    event.preventDefault();
    ApplyCoupon();
    });
    function ApplyCoupon(){
    $(".code-err").remove();
    var rows = $(".newRow").find('tr');
    var input_code = $("input[name='radioEg']:checked").parent();
    var couponCode = $("input[name='radioEg']:checked").val();

            var prod = [];
    $.each($(".qtyOrder"), function(qtk, qtv){
    if ($(qtv).attr('data-ppid') != ""){
    var subprodid = $(this).parent().parent().find(".addPrdVar option:selected").val();
    if (subprodid == null){
    subprodid = "";
    }
    var prod_id = $(qtv).attr('data-ppid');
    var qty = $(qtv).val();
    var data = {prod_id:prod_id, subprodid:subprodid, qty:qty};
    prod.push(data);
    }
    });
    // console.log(prod);
    if (prod.length <= 0){
    $(".finalAmt").text('0.00');
    getAdditionalcharge();
    return false;
    }
  
    $.ajax({
    type: "POST",
            url: "{{ route('admin.orders.checkOrderCoupon') }}",
            data: {mycart:prod, couponCode:couponCode},
            dataType:"json",
            cache: false,
            success: function (msg) {
            $(".cmsg").css("display", "block");
            if (msg['remove'] == 1) {
            if (couponCode != 'none'){
            input_code.parent().append("<p class='code-err' style='color:red'>Coupon Code Invalid OR Not applicable on current cart value.</p>");
            }

            $("input[name='coupon_amt_used']").val(0.00);
            } else {
            $(".coupon-code").remove();
            $(".coupon-value").remove();
            $("input[name='coupon_amt_used']").val(msg['disc']);
            }
            priceTaxUpdate(msg['cart']);
            $("#order_amt").val(msg['orderAmount'].toFixed(2));
            getAdditionalcharge();
            }

    });
    }

    function getAdditionalcharge(){
    var coupon_amt = parseInt($("#coupon_amt_used").val());
    var order_amt = parseFloat($(".ordT").val());
    var order_pay = parseFloat($(".ordP").val());
    var cod = parseFloat($("#cod_charges").val());
    // var price = order_amt - coupon_amt; 
    var total_amt = 0;
    $.ajax({
    url: "{{ route('admin.additional-charges.getAditionalCharge') }}",
            type: 'POST',
            cache: false,
            success: function (msg) {


            var data = JSON.parse(msg);
            $(".additional-charge").empty();
            if (!isEmpty(data)){
            $.each(JSON.parse(msg), function(i, v){
            if (i == 'list'){
            $.each(v, function(j, w){
            $(".additional-charge").append('<tr><th>' + j + '</th><td>' +( w *<?php echo Session::get("currency_val") ?> )+ '</td>');
            })
            }

            total_amt = order_amt +( v * <?php echo Session::get("currency_val") ?> );
            });
            } else{
            total_amt = order_pay;
            }
            $(".additional-charge").append('<tr><th>Total (Included Additional Charges <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?>)</th><td>' + (total_amt+cod ).toFixed(2) + '</td>');
            $(".ordP").val((total_amt+cod).toFixed(2));
            }
    });
    }

    function priceTaxUpdate(cart){

    $.each(cart, function (key, value) {
    var id = value.id;
    //  var prod = $("[data-ppid="+id+"]");
    var price = value.subtotal;
    if (value.options.tax_type == 2){
    price = price + value.options.tax_amt;
    }

    var abc = $("[subprod-id=" + value.options.sub_prod + "]").get();
    if (abc != null && abc != ""){
    var prod = $("[subprod-id=" + value.options.sub_prod + "]");
    } else{
    var prod = $("[data-ppid=" + id + "]");
    }

    prod.parent().parent().find('.subT').text((price * <?php echo Session::get("currency_val") ?>).toFixed(2));
    prod.parent().parent().find('.coupDisc').text((value.options.disc * <?php echo Session::get("currency_val") ?>).toFixed(2));
    prod.parent().parent().find('.cashbackDisc').text((value.options.wallet_disc * <?php echo Session::get("currency_val") ?>).toFixed(2));
    prod.parent().parent().find('.voucherDisc').text((value.options.voucher_disc * <?php echo Session::get("currency_val") ?>).toFixed(2));
    prod.parent().parent().find('.referalDisc').text((value.options.referral_disc * <?php echo Session::get("currency_val") ?>).toFixed(2));
    });
    }

    function applyVoucher(voucherCode){

    $.ajax({
    url: "{{ route('admin.orders.applyVoucher') }}",
            type: 'POST',
            data: {voucherCode: voucherCode},
            cache: false,
            success: function (data) {
            if (data != "invalid data") {
            priceTaxUpdate(data.cart);
            $("#order_amt").val(data['orderAmount'].toFixed(2));
            if (data.voucherAmount != null) {
            $(".vMsg").css("display", "block");
            $("#voucherApply").attr("disabled", "disabled");
            $(".userVoucherCode").attr("disabled", "disabled");
            var Cmsg = "<span style='color:green;'>Voucher Code Applied!</span> <a href='#' style='border-bottom: 1px dashed;' onclick='clearVouch()'>Remove!</a>";
            $(".vMsg").html(Cmsg);
            $("input[name='voucher_amt_used']").val(data.voucherAmount);
            } else {
            $("#voucherApply").removeAttr("disabled");
            $(".userVoucherCode").removeAttr("disabled");
            $("input[name='voucher_amt_used']").val(0);
            $(".voucher-code").remove();
            if (data.clearCoupon){
            $(".vMsg").css("display", "none");
            } else{
            $(".vMsg").css("display", "block");
            $(".vMsg").html("Invalid Voucher!");
            }

            }
            }
            getAdditionalcharge();
            }
    });
    }
    $("#voucherApply").click(function(){
    var voucherCode = $(".userVoucherCode").val();
    applyVoucher(voucherCode);
    });
    function clearVouch(){
    var voucherCode = '';
    applyVoucher(voucherCode);
    }

    function applyUserLevelDisc(discVal){
    var discType = $('#user-level-disc').val();
    $("#userlevelDiscApply").attr('disabled', true);
    $.ajax({
    url: "{{ route('admin.orders.applyUserLevelDisc') }}",
            type: 'POST',
            data: {discType: discType, discVal: discVal},
            cache: false,
            success: function (data) {
            priceTaxUpdate(data.cart);
            $("#order_amt").val(data['orderAmount'].toFixed(2));
             $(".user_disc").val(data['discAmt'].toFixed(2));
            if (data['discAmt'] != null && data['discAmt'] != 0) {
          
            var msg = "<span style='color:green;'>Discount Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' onclick='clearDisc()' class='clearDiscount' id='discAmt'>Remove!</a>"

                    $(".dMsg").css("display", "block");
            $(".dMsg").html(msg);
            // var userdisc_td = '<tr class="discount-code"><th>Discount Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">'+data.discAmt +'</span></td></tr>';
            //    $(".priceTable tbody").prepend(userdisc_td);
            } else {
            $("#userlevelDiscApply").attr('disabled', false);
            var err = "<span style='color:red;'>Invalid Code</span>"
                    $(".discount-code").remove();
            if (data.clearDisc){
            $(".dMsg").css("display", "none");
            } else{
            $(".dMsg").css("display", "block");
            $(".dMsg").html(err);
            }
            }
            getAdditionalcharge();
            }
    });
    }
    $("#userlevelDiscApply").click(function(){
    var discVal = $('input[name="user_level_discount"]').val();
    applyUserLevelDisc(discVal);
    });
    function clearDisc(){
    var discVal = 0;
    applyUserLevelDisc(discVal);
    }

    function applyReferal (RefCode) {
    // var RefCode = $(".requireReferal").val();
    $.ajax({
    url: "{{ route('admin.orders.applyReferel')}}",
            type: 'POST',
            data: {RefCode: RefCode},
            cache: false,
            success: function (data) {
            $(".referalMsg").show();
            priceTaxUpdate(data.cart);
            $("input[name='referal_code_amt']").val(data.referalCodeAmt);
            $("#order_amt").val(data['orderAmount'].toFixed(2));
            if (data['referalCodeAmt'] != null && data['referalCodeAmt'] != 0) {
            $(".referalCodeClass").attr("disabled", "disabled");
            $(".requireReferal").attr("disabled", "disabled");
            var Cmsg = "<span style='color:green;'>Referral Code Applied!</span> <a href='javascript:void(0);' class='clearRef' onclick='clearRef()' style='border-bottom: 1px dashed;'>Remove!</a>";
            $(".referalMsg").html(Cmsg);
            } else {
            $(".referalCodeClass").removeAttr("disabled");
            $(".requireReferal").removeAttr("disabled");
            $(".referal-code").remove();
            if (data.clearReferrel){
            $(".referalMsg").css("display", "none");
            } else{
            $(".vMsg").css("display", "block");
            $(".referalMsg").text("Invalid Referral Code!");
            }
            }
            getAdditionalcharge();
            }
    });
    };
    $("#requireReferalApply").click(function(){
    var RefCode = $(".requireReferal").val();
    applyReferal(RefCode);
    });
    function clearRef(){
    var RefCode = '';
    applyReferal(RefCode);
    }

    $(".requireCashback").click(function(){
    var user_id = $("input[name='user_id']").val();
    var checkbox = $("#checkbox1");
    var isChecked = checkbox.is(':checked');
    if (isChecked) {
    $.ajax({
    url: "{{ route('admin.orders.applyCashback') }}",
            type: 'POST',
            data: {userId: user_id},
            cache: false,
            success: function (data) {
            $("#order_amt").val(data['orderAmount'].toFixed(2));
            $("input[name='cashback_used']").val(data.cashbackUsedAmt);
            $(".curRewPointsOld").text(data.cashbackRemain);
           
            var cashback_td = '<tr class="cashback-code"><th>Cashback Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + data.cashbackUsedAmt + '</span></td></tr>';
            $(".priceTable tbody").prepend(cashback_td);
            priceTaxUpdate(data.cart);
            getAdditionalcharge();
            }
    });
    } else{
    $.ajax({
    url: "{{ route('admin.orders.applyCashback') }}",
            type: 'POST',
            data: '',
            cache: false,
            success: function (data) {
            $("#order_amt").val(data['orderAmount'].toFixed(2));
            $("input[name='cashback_used']").val(0);
            //  $(".cashback-code").remove();
            $(".curRewPointsOld").text({{$order->users->cashback}});
            priceTaxUpdate(data.cart);
            getAdditionalcharge();
            }
    });
    }
    });
    $(document).ready(function(){
    ApplyCoupon();
    })

            function clearAllDiscount(){
            // ApplyCoupon();

            // var checkbox = $("#checkbox1");
            // var isChecked = checkbox.is(':checked');
            // console.log(isChecked);
            // if(isChecked){
            //    $(".requireCashback").click(); 
            // }

            //cashback remove
            $('#checkbox1').attr('checked', false);
            $("input[name='cashback_used']").val(0);
            $(".curRewPointsOld").text({{$order->users->cashback}});
            // remove refereal code
            $(".referalCodeClass").removeAttr("disabled");
            $(".requireReferal").removeAttr("disabled");
            $(".referal-code").remove();
            $(".referalMsg").css("display", "none");
            $("input[name='referal_code_amt']").val(0);
            //remove User Level Discount
            $("#userlevelDiscApply").attr('disabled', false);
            $(".discount-code").remove();
            $(".dMsg").css("display", "none");
            //Remove Voucher Discount
            $("#voucherApply").removeAttr("disabled");
            $(".userVoucherCode").removeAttr("disabled");
            $("input[name='voucher_amt_used']").val(0);
            $(".voucher-code").remove();
            $(".vMsg").css("display", "none");
            ApplyCoupon();
            }
    // to check is object empty
    function isEmpty(obj) {
    for (var prop in obj) {
    if (obj.hasOwnProperty(prop))
            return false;
    }

    return true;
    }
    
        // $("#couponApply").click(function(event){
    /* function ApplyCoupon(){
     // event.preventDefault();
     var prod = [];
     $.each($(".qtyOrder"),function(qtk,qtv){
     if($(qtv).attr('data-ppid') != ""){
     // var subprodid = $(this).parent().parent().find(".addPrdVar").val();
     var subprodid = $(this).parent().parent().find(".selPrdVar").val();
     if(subprodid == null){
     subprodid = "";
     }
     var prod_id = $(qtv).attr('data-ppid');
     var qty = $(qtv).val();
     var data = {prod_id:prod_id,subprodid:subprodid,qty:qty};
     prod.push(data);
     }
     });
     // console.log(prod);
     var couponCode = $(".userCouponCode").val();
     
     $.ajax({
     type: "POST",
     url: "{{ route('admin.orders.checkOrderCoupon') }}",
     data: {mycart:prod,couponCode:couponCode},
     cache: false,
     success: function (msg) {
     console.log(msg);
     $(".cmsg").css("display", "block");
     $("#order_amt").val(msg['orderAmount'].toFixed(2));
     if (msg['remove'] == 1) {
     $(".cmsg").html("Coupon Code Invalid OR Not applicable on current cart value.");
     
     $("input[name='coupon_amt_used']").val(0.00);
     $("#couponApply").removeAttr("disabled");
     $("#userCouponCode").val('');
     $("#userCouponCode").removeAttr("disabled");
     $(".disc_indv").text("0.00");
     $("#amountallSubtotal").text(msg[4]);
     
     } else {
     $("#couponApply").attr("disabled", "disabled");
     $(".userCouponCode").attr("disabled", "disabled");
     coupon_msg = "<span style='color:green;'>Coupon Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearCoup'>Remove!</a>";
     var newAmount = msg['new_amt'];
     var usedCouponAmount = (msg['disc'])
     
     $("input[name='coupon_amt_used']").val(usedCouponAmount.toFixed(2));
     $(".cmsg").html(coupon_msg);
     }
     priceTaxUpdate(msg.cart);
     //  calamt(); 
     getAdditionalcharge();                  
     }
     
     });
     };
     */
</script>
@stop
