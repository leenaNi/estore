@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Order Status 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Sales</a></li>
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
        <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filter</h1>
    </div>
     <div class="filter-section">
            <div class="col-md-12 no-padding">
                <div class="filter-full-section"> 
                <form action="{{ route('admin.order_status.view') }}" method="get" >
                <div class="form-group col-md-8 noAll-margin">
                    <div class="input-group">
                    <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                    <input type="text" value="{{ !empty(Input::get('order_status')) ? Input::get('order_status') : '' }}" name="order_status" aria-controls="editable-sample" class="form-control  form-control-right-border-radius  medium" placeholder="Order Status"/>  
                    </div>  
                    </div>
                    <div class="form-group col-md-4 noBottomMargin"> 
                        <a href="{{route('admin.order_status.view')}}"><button type="button" class="btn reset-btn noMob-leftmargin pull-right" >Reset</button></a>
                        <input type="submit" name="submit" class="btn btn-primary noAll-margin pull-right marginRight-lg" value="Search"> 
                    </div>
                </form>
            </div>
        </div> 
    </div>
</div>

<div class="grid-content">
    <div class="section-main-heading">
        <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Order Status <span class="listing-counter"> {{$orderstatusCount }} </span> </h1>
        <button onclick="window.location.href ='{{ route('admin.order_status.add')}}'" target="_blank" class="btn btn-listing-heading pull-right noAll-margin"> <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'plus.svg'}}"> Create </button> 
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
                            <span><a class="btn-action-default" href="{!! route('admin.order_status.edit',['id'=>$status->id]) !!}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                            <span class="dropdown">
                                <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
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