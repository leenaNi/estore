@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
       Return Orders 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Sales</a></li>
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
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 no-padding">
                <div class="filter-full-section">

                    {!! Form::open(['method' => 'get', 'route' => 'admin.orders.OrderReturn' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                        {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Order Id"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                        {!! Form::text('order_number_from',Input::get('order_number_from'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Order No. From"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                        {!! Form::text('order_number_to',Input::get('order_number_to'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Order No. To"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'noun_user.svg'}}"></span>
                            {!! Form::text('search',Input::get('search'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Search for Name, Email or Mobile No."]) !!}
                        </div>
                    </div> 
                    <div class="form-group col-md-4 noBottomMargin"> 
                        <a href="{{route('admin.orders.OrderReturn')}}">
                        <button type="button" class="btn reset-btn noMob-leftmargin pull-right mn-w120">Reset</button></a> 
                        <button type="submit" class="btn btn-primary noAll-margin pull-right mn-w120 marginRight-sm"> Filter</button> 
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Return Orders</h1>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table orderTable table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-right">Return Order Id</th>
                            <th class="text-right">Order Id</th>
                            <th class="text-left">Customer</th>
                            <th class="text-left">Email</th> 
                            <th class="text-left">Product</th>
                            <!-- <th>Order Status</th>-->
                            <th class="text-center">Returns Status</th>
                            <th class="text-right">Return Request Date</th>
                            <th class="text-center mn-w100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
             <?php
             $returnOrder=[1=>"Cancelled",2=>"Returned",3=>'Exchange'];
             ?>
                        @if(count($return)>0)
                        @foreach($return as $r)                        
                        <tr>
                            <td class="text-right">{{ $r['id'] }}</td>
                            <td class="text-right">{{ $r['order_id']['id'] }}</td>
                            <td class="text-left"><span class="list-dark-color">{{ $r['order_id']['user']['firstname'] }} {{ $r['order_id']['user']['lastname'] }}</span><div class="clearfix"></div><span class="list-light-color list-small-font">{{ $r['order_id']['user']['telephone'] }}</span></td>
                            <td class="text-left">{{ $r['order_id']['user']['email'] }}</td> 
                            <td class="text-left">{{ $r['product_id']['product'] }}</td>
                            <!-- <td>{{ @$returnOrder[$r['order_status']]?$returnOrder[$r['order_status']]:"-" }}</td>-->
                            <th class="text-center"><span class="alertWarning">{{ @$r['return_status_id']['status'] }}</span></th>
                            <td class="text-right">{{ date('d-M-Y',strtotime($r['created_at'])) }}
                            <div class="clearfix"></div>
                                <span class="list-light-color list-small-font">8:30 PM</span></td>
                            <td class="text-center mn-w100">
                                <div class="actionCenter">
                                    <span>
                                        <a href="{{route('admin.orders.editreturn',['id' => $r['id']])}}"  class="btn-action-default"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a>
                                    </span>
                                </div>
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