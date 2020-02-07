@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
       Return Orders
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Return Orders</li>
    </ol>
</section>


<section class="main-content">

    <div class="notification-column">          
        @if(!empty(Session::get('message')))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
        @endif
        @if(!empty(Session::get('messageError')))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('messageError') }}
        </div>
        @endif
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 no-padding">
                <div class="filter-full-section">

                    {!! Form::open(['method' => 'get', 'route' => 'admin.orders.OrderReturn' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                        {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control', "placeholder"=>"Order Id"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_number_from',Input::get('order_number_from'), ["class"=>'form-control ', "placeholder"=>"Order No. From"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_number_to',Input::get('order_number_to'), ["class"=>'form-control ', "placeholder"=>"Order No. To"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('search',Input::get('search'), ["class"=>'form-control ', "placeholder"=>"Name/Email/Mobile"]) !!}
                    </div> 
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-3 col-xs-12 no-padding mob-marBottom15">
                            <button type="submit" class="btn btn-primary fullWidth noAll-margin"> Filter</button>
                        </div>
                        <div class=" button-filter col-md-3 col-xs-12 no-padding noBottomMargin">
                            <a href="{{route('admin.orders.OrderReturn')}}">
                            <button type="button" class="btn reset-btn fullWidth noMob-leftmargin">Reset</button></a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Return Orders</h1>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table orderTable table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Return Order Id</th>
                            <th class="text-center">Order Id</th>
                            <th class="text-left">Customer</th>
                            <th class="text-left">Email</th> 
                            <th class="text-left">Product</th>
                            <!-- <th>Order Status</th>-->
                            <th class="text-center">Returns Status</th>
                            <th class="text-right">Return Request Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
             <?php
             $returnOrder=[1=>"Cancelled",2=>"Returned",3=>'Exchange'];
             ?>
                        @if(count($return)>0)
                        @foreach($return as $r)                        
                        <tr>
                            <td class="text-center">{{ $r['id'] }}</td>
                            <td class="text-center">{{ $r['order_id']['id'] }}</td>
                            <td class="text-left"><span class="list-dark-color">{{ $r['order_id']['user']['firstname'] }} {{ $r['order_id']['user']['lastname'] }}</span><div class="clearfix"></div><span class="list-light-color list-small-font">{{ $r['order_id']['user']['telephone'] }}</span></td>
                            <td class="text-left">{{ $r['order_id']['user']['email'] }}</td> 
                            <td class="text-left">{{ $r['product_id']['product'] }}</td>
                            <!-- <td>{{ @$returnOrder[$r['order_status']]?$returnOrder[$r['order_status']]:"-" }}</td>-->
                            <th class="text-center"><span class="alertWarning">{{ @$r['return_status_id']['status'] }}</span></th>
                            <td class="text-right">{{ date('d-M-Y',strtotime($r['created_at'])) }}
                            <div class="clearfix"></div>
                                <span class="list-light-color list-small-font">8:30 PM</span></td>
                            <td class="text-center">
                                <a href="{{route('admin.orders.editreturn',['id' => $r['id']])}}"  class="btn-action-default">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="8" class="text-center"> No Record Found</td></tr>
                        @endif 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div> 
@stop
@section('myscripts')
<script>
    $(document).ready(function () {


    });
</script>

@stop