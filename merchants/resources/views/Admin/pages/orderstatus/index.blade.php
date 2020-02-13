@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Order Status ({{$orderstatusCount }})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Order Status</li>
    </ol>
</section>

<section class="main-content">
    
<div class="notification-column">                       
    @if(!empty(Session::get('message')))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('message') }}
    </div>
    @endif
    @if(!empty(Session::get('msg')))
    <div class="alert alert-success" role="alert">
        {{Session::get('msg')}}
    </div>
    @endif
</div>

<div class="grid-content">
    <div class="section-main-heading">
        <h1>Filter</h1>
    </div>
    <div class="filter-section displayFlex">
        <div class="col-md-9 noAll-padding displayFlex">
            <div class="filter-left-section"> 
                <form action="{{ route('admin.order_status.view') }}" method="get" >
                <div class="form-group col-md-8 noAll-margin">
                        <input type="text" value="{{ !empty(Input::get('order_status')) ? Input::get('order_status') : '' }}" name="order_status" aria-controls="editable-sample" class="form-control medium" placeholder="Order Status"/>    
                    </div>
                    <div class="form-group noAll-margin col-md-2 col-sm-12 col-xs-12">
                        <input type="submit" name="submit" class="btn btn-primary fullWidth noAll-margin" value="Search">
                    </div>
                    <div class="btn-group noAll-margin col-md-2 col-sm-12 col-xs-12">
                        <a href="{{route('admin.order_status.view')}}"><button type="button" class="btn reset-btn fullWidth noMob-leftmargin" >Reset</button></a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3 noAll-padding displayFlex">
            <div class="filter-right-section">                    
                <button id="editable-sample_new" class="btn btn-default pull-right col-md-12 noMob-leftmargin mobAddnewflagBTN" onclick="window.location.href ='{{ route('admin.order_status.add')}}'">Add New Order Status</button>
            </div>
        </div>
    </div>
</div>

<div class="grid-content">
    <div class="section-main-heading">
        <h1> Order Status <span class="listing-counter"> {{$orderstatusCount }} </span> </h1>
    </div>
    <div class="listing-section">
        <div class="table-responsive overflowVisible no-padding">
        <table class="table table-striped table-hover tableVaglignMiddle">
            <thead>
                <tr>
                    <th class="text-center">Order Status</th>
                    <th class="text-center">Sort Order</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($orderstatusInfo) >0)
                @foreach ($orderstatusInfo as $status)
                <tr>
                    <td class="text-center"><span class="alertSuccess">{{$status->order_status}}</span></td>
                    <td class="text-center">{{$status->sort_order}}</td>
                    <td class="text-center">
                        <?php $route=  ($status->id!=1)?route('admin.order_status.changeStatus',['id'=>$status->id]):'#';?>
                        @if($status->status==1)
                        <a href="{!! $route!!}" class="" ui-toggle-class="" onclick="return confirm(($status->id !=1 )?'Are you sure you want to disable this status?':'you can not disabled this')" data-toggle="tooltip" title="Enabled" disabled><i class="fa fa-check btn-plen btn"></i></a>
                        @elseif($status->status==0)
                        <a href="{!!$route !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this status?')" data-toggle="tooltip" title="Disabled" disabled><i class="fa fa-times btn-plen btn"></i></a>
                        @endif
                    </td>
                    <td class="text-center">
                         @if($status->id !=1) 
                         <div class="actionCenter">
                            <span><a class="btn-action-default" href="{!! route('admin.order_status.edit',['id'=>$status->id]) !!}">Edit</a></span> 
                            <span class="dropdown">
                                <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">  
                                    <li><a href="{!! route('admin.order_status.delete',['id'=>$status->id]) !!}" onclick="return confirm('Are you sure you want to delete this status?')"><i class="fa fa-trash "></i> Delete</a></li>
                                </ul>
                            </span>  
                        </div> 
                      @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td class="text-center" colspan="4">No Record found.</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="pull-right">
                @if(empty(Input::get("order_status")))
                {!! $orderstatusInfo->links() !!}
                @endif
            </div>
        </div>
    </div>
</div> 
</section>

<div class="clearfix"></div>

@stop 
@section('myscripts')
<script>
    
</script>
@stop