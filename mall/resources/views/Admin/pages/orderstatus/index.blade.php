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

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
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
                <div class="box-header box-tools filter-box col-md-9 noBorder">

                    <form action="{{ route('admin.order_status.view') }}" method="get" >
                    <div class="form-group col-md-8">
                            <input type="text" value="{{ !empty(Input::get('order_status')) ? Input::get('order_status') : '' }}" name="order_status" aria-controls="editable-sample" class="form-control medium" placeholder="Order Status"/>    
                        </div>
                        <div class="form-group col-md-2 col-sm-12 col-xs-12">

                            <input type="submit" name="submit" class="btn btn-primary form-control" style="margin-left: 0px;" value="Search">
                        </div>
                        <div class="btn-group col-md-2 col-sm-12 col-xs-12">
                            <a href="{{route('admin.order_status.view')}}"><button type="button" class="btn reset-btn form-control noMob-leftmargin" >Reset</button></a>
                        </div>

                    </form> 
                    
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12 noMob-leftmargin mobAddnewflagBTN" onclick="window.location.href ='{{ route('admin.order_status.add')}}'">Add New Order Status</button>
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
              
                
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Order Status</th>
<!--                                <th>Created At</th>-->
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($orderstatusInfo) >0)
                            @foreach ($orderstatusInfo as $status)
                            <tr>
                                <td>{{$status->order_status}}</td>
<!--                                <td>{{date('d-M-Y',strtotime($status->created_at))}}</td>-->
                                <td>
                                    <?php $route=  ($status->id!=1)?route('admin.order_status.changeStatus',['id'=>$status->id]):'#';?>
                                    @if($status->status==1)
                                    <a href="{!! $route!!}" class="" ui-toggle-class="" onclick="return confirm(($status->id !=1 )?'Are you sure you want to disable this status?':'you can not disabled this')" data-toggle="tooltip" title="Enabled" disabled><i class="fa fa-check btn-plen btn"></i></a>
                                    @elseif($status->status==0)
                                    <a href="{!!$route !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this status?')" data-toggle="tooltip" title="Disabled" disabled><i class="fa fa-times btn-plen btn"></i></a>
                                    @endif
                                </td>
                                <td>
                                     @if($status->id !=1) 
                                    <a href="{!! route('admin.order_status.edit',['id'=>$status->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw btnNo-margn-padd"></i></a>
                                  
                                    <a href="{!! route('admin.order_status.delete',['id'=>$status->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this status?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash fa-fw"></i>
                                  @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr><td colspan=6>No Record found.</td></tr>
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

@stop 
@section('myscripts')
<script>
    
</script>
@stop