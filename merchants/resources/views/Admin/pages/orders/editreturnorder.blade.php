@extends('Admin.layouts.default')
@section('content')
<style>
    
    .exchProdAlign{
        background-color: #eee;    
        min-height: 35px;
        padding-top: 8px;
        padding-left: 3%;
    }
</style>
<section class="content-header">
    <h1>
        Return Orders
        <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""> <a href="{{ route('admin.orders.OrderReturn') }}" >Return Orders </a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#order-detail" data-toggle="tab" aria-expanded="true">Order Details</a></li>
            <li class=""><a href="#customer-detail" data-toggle="tab" aria-expanded="true">Customer Details</a></li>
        </ul>
        <div  class="tab-content" >
            <div class="tab-pane active" id="order-detail">
            <div class="row">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
                </div>
                {!! Form::model($return, ['method' => 'post', 'files'=> true, 'route' => 'admin.orders.UpdateReturnOrderStatus' , 'id'=>'returnedit']) !!}

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('product_name', 'Product Name') !!}
                        {!! Form::text('',$return[0]['product_id']['product'], ["class"=>'form-control' ,"placeholder"=>'Product Name', "required","readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('product_code', 'Product Code') !!}
                        {!! Form::text('',$return[0]['product_id']['product_code'], ["class"=>'form-control' ,"placeholder"=>'Product Code', "required","readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('quantity', 'Quantity') !!}
                        {!! Form::text('',$return[0]['quantity'], ["class"=>'form-control' ,"placeholder"=>'Quantity', "required","readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('return_amount', 'Return Amount') !!}
                        {!! Form::text('',$return[0]['return_amount'], ["class"=>'form-control priceConvertTextBox' ,"placeholder"=>'Return Amount', "required","readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('reason', 'Reason') !!}
                        {!! Form::text('',$return[0]['reason']['reason'], ["class"=>'form-control' ,"placeholder"=>'Reason', "required","readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('opened', 'Opened') !!}
                        {!! Form::text('',$return[0]['opened']['status'], ["class"=>'form-control' ,"placeholder"=>'Opened', "required","readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('remark', 'Remark') !!}
                        {!! Form::textarea('',$return[0]['remark'], ["class"=>'form-control' ,"placeholder"=>'Remark',"readonly" => 'true','rows'=>'1']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('return_status', 'Return Status') !!}
                        @if($return[0]['return_status'] == 2)
                         Completed
                        @else
                       {!! Form::select('return_status', $returnStatus, $return[0]['return_status'], ["class"=>'form-control' ,"placeholder"=>'Select Status']) !!}
                        @endif
                    </div>
                </div>
                 <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('return_status', 'Order Status') !!}
                       {!! Form::select('order_status', [1=>'Canceled',2=>'Returned',3=>'Exchange'], $return[0]['order_status'], ["class"=>'form-control' ,"placeholder"=>'Select Status','disabled']) !!}
                    </div>
                </div>
                 @if(isset($return[0]['exchange_product']['product']))
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('echanged_product', 'Exchanged Product') !!}
                    <p class="exchProdAlign">{{@$return[0]['exchange_product']['product']}}</p>
                    </div>
                </div>
                 @endif
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('return_action', 'Return Action') !!}
                         @if($return[0]['return_status'] == 2)
                         Credited
                        @else
                        Credit Pending
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                       @if($return[0]['return_status'] != 2)
                          {!! Form::submit('Submit',["class" => "btn btn-primary pull-right"]) !!}   
                        @endif
   
                        <span  id='err'></span>
                    </div>
                </div>
                {!! Form::hidden('id',$return[0]['id']) !!}
                {!! Form::close() !!}
            </div>
            </div>

            <div class="tab-pane" id="customer-detail">

                {!! Form::model($return, ['method' => 'post', 'files'=> true, 'url' => '' ]) !!}
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('first_name', 'First Name') !!}
                        {!! Form::text('first_name',$return[0]['order_id']['first_name'], ["class"=>'form-control' ,"placeholder"=>'First Name',"readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('last_name', 'Last Name') !!}
                        {!! Form::text('last_name',$return[0]['order_id']['last_name'], ["class"=>'form-control' ,"placeholder"=>'Last Name',"readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('address1', 'Address Line 1') !!}
                        {!! Form::text('address1',$return[0]['order_id']['address1'], ["class"=>'form-control' ,"placeholder"=>'Address 1',"readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('address2', 'Address Line 2') !!}
                        {!! Form::text('address2',$return[0]['order_id']['address2'], ["class"=>'form-control' ,"placeholder"=>'Address 2',"readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('address3', 'Address Line 3') !!}
                        {!! Form::text('address3',$return[0]['order_id']['address3'], ["class"=>'form-control' ,"placeholder"=>'Address 3',"readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('phone_no', 'Mobile') !!}
                        {!! Form::text('phone_no',$return[0]['order_id']['phone_no'], ["class"=>'form-control' ,"placeholder"=>'Phone Number',"readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('city', 'City') !!}
                        {!! Form::text('city',$return[0]['order_id']['city'], ["class"=>'form-control' ,"placeholder"=>'City',"readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('country_id', 'Country',["readonly" => 'true']) !!}
                       {!! Form::text('country',$return[0]['order_id']['country']['name'], ["class"=>'form-control' ,"placeholder"=>'Country',"readonly" => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('zone_id', 'State/Zone',["readonly" => 'true']) !!}
                       {!! Form::text('zone',$return[0]['order_id']['zone']['name'], ["class"=>'form-control' ,"placeholder"=>'Zone',"readonly" => 'true']) !!}
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                    {!! Form::label('postal_code', 'Pincode',["readonly" => 'true']) !!}
                        {!! Form::number('postal_code',$return[0]['order_id']['postal_code'], ["class"=>'form-control' ,"placeholder"=>'Pincode',"readonly" => 'true']) !!}
                    </div>
                </div>
                </div>
                {!! Form::hidden('id',null) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section> 
@stop 

@section('myscripts')
<script>

//        $("html body").on('submit', '#returnedit', function () {
//        $.ajax({
//            url: "{{ route('admin.orders.UpdateReturnOrderStatus') }}",
//            type: 'post',
//            data: new FormData(this),
//            processData: false,
//            contentType: false,
//            //   dataType: 'json',
//            beforeSend: function () {
//                // $("#barerr" + id).text('Please wait');
//            },
//            success: function (res) {
//                   window.location.href="";
//            
//            }
//        });
//        return false;
//    });

</script>
@stop