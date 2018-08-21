
@extends('Admin.layouts.default')

@section('content')
<section class="content-header">
    <h1>
        Cancel Orders
        <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
         <li class="active">Cancel Order </li>
        <li class="active">Edit</li>
    </ol>
</section>
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                {!! Form::model($data, ['method' => 'post', 'route' => "admin.orders.cancelOrderUpdate" , 'class' => 'form-horizontal' ]) !!}
                    {!! Form::hidden('id',@$data->id) !!}
                    <?php
                     $cartData = json_decode($data->getorders->cart, true);
                    ?>
                    @if(isset($cartData) && count($cartData)>0)
                        @foreach($cartData as $prd)
                                {{Form::hidden("prdId[".@$prd['options']['sub_prod']."][qty]",@$prd['qty'],[])}}
                        @endforeach
                    @endif
                <div class="form-group">
                    {!! Form::label('Cancel Order Id', 'Cancel Order Id', ["class"=>'col-md-2 control-label'] ) !!}
                    <div class="col-md-10">
                        {!! Form::text('cancel_order_id',@$data->id, ["class"=>'form-control validate[required]' ,"placeholder"=>'Cancel Order Id',"readonly"]) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('Order Id', 'Order Id', ["class"=>'col-md-2 control-label']) !!}
                    <div class="col-md-10">
                        {!! Form::text('order_id',@$data->order_id, ["class"=>'form-control validate[required]' ,"placeholder"=>'Order Id',"readonly"]) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('Customer Name', 'Name', ["class"=>'col-md-2 control-label']) !!}
                    <div class="col-md-10">
                        {!! Form::text('customer_name',@$data->getorders->users->firstname, ["class"=>'form-control' ,"placeholder"=>'Customer Name',"readonly"]) !!}
                    </div>
                </div>
           <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('Email', 'Email', ["class"=>'col-md-2 control-label']) !!}
                    <div class="col-md-10">
                        {!! Form::text('email',@$data->getorders->users->email, ["class"=>'form-control' ,"placeholder"=>'Email',"readonly"]) !!}
                    </div>
                </div>
           <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('Contact No', 'Mobile', ["class"=>'col-md-2 control-label']) !!}
                    <div class="col-md-10">
                        {!! Form::text('phone',@$data->getorders->users->telephone, ["class"=>'form-control' ,"placeholder"=>'Mobile',"readonly"]) !!}
                    </div>
                </div>
           <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('Reason', 'Reason', ["class"=>'col-md-2 control-label']) !!}
                    <div class="col-md-10">
                        {!! Form::text('reason',@$data->reason->reason, ["class"=>'form-control' ,"placeholder"=>'Reason',"readonly"]) !!}
                    </div>
                </div>
           <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    {!! Form::label('Status', 'Cancel Status', ["class"=>'col-md-2 control-label']) !!}
                    <div class="col-md-10">
                        <?php
                        $disable=$data->status==1?"disabled":"";
                        ?>
                        {!! Form::select('status',[0=>'Pending',1=>'Cancelled'],@$data->status, ["class"=>'form-control' ,"placeholder"=>'Status',$disable]) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::submit('Submit',["class" => "pull-right btn btn-primary noLeftMargin"]) !!}
                        {!! Form::close() !!}
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
    $(document).ready(function () {

    });
</script>
@stop