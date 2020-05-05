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
    <div class="alert alert-danger" role="alert" id="errorMsgDiv" style="display: none;"></div>
    <div class="alert alert-success" role="alert" id="successMsgDiv" style="display: none;"></div>           
   
    {{-- @if(!empty(Session::get('message')))
    <div class="alert alert-danger" role="alert" id="errorMsgDiv">
        {{ Session::get('message') }}
    </div>
    @endif
    @if(!empty(Session::get('msg')))
    <div class="alert alert-success" role="alert" id="successMsgDiv">
        {{Session::get('msg')}}
    </div> 
    @endif --}}
</div>

<div class="grid-content">
    <div class="section-main-heading">
        <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
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
                        <a href="{{route('admin.order_status.view')}}"><button type="button" class="btn reset-btn noMob-leftmargin pull-right mn-w100" >Reset</button></a>
                        <input type="submit" name="submit" class="btn btn-primary noAll-margin pull-right marginRight-sm mn-w100" value="Filter"> 
                    </div>
                </form>
            </div>
        </div> 
    </div>
</div>

<div class="grid-content">
    <div class="section-main-heading">
        <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Order Status <span class="listing-counter">{{$startIndex}}-{{$endIndex}} of {{$orderstatusCount }} </span> </h1>
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
                    <th class="text-center">Is Default</th>
                    <th class="text-center mn-w120">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($orderstatusInfo) >0)
                @foreach ($orderstatusInfo as $status)
                <?php
                if($status->status==1)
                {
                    $statusLabel = 'Active';
                    $linkLabel = 'Mark as Inactive';
                }
                else
                {
                    $statusLabel = 'Inactive';
                    $linkLabel = 'Mark as Active';
                }

                if($status->is_default == 1)
                {
                    $isDefaultVal = 'Yes';
                }
                else {
                    
                    $isDefaultVal = 'No';
                }

                if(($status->color != null) || $status->color != NULL)
                {
                    $colorVal = "background-color:".$status->color;
                }
                else {
                    $colorVal = "background-color:#9bca6e";
                }
                ?>
                <tr>
                <td class="text-center"><span class="alertSuccess" style="{{$colorVal}}">{{$status->order_status}}</span></td>
                    <td class="text-center">{{$status->sort_order}}</td>
                    <td class="text-center" id="orderStatus_{{$status->id}}"><span class="alertSuccess">{{$statusLabel}}</span></td>
                    <td class="text-center isDefaultCls" id="orderStatusIsDefault_{{$status->id}}">{{$isDefaultVal}}</td>
                    <td class="text-center mn-w120">
                         @if($status->id !=1) 
                         <div class="actionCenter"> 
                            <span><a class="btn-action-default" href="{!! route('admin.order_status.edit',['id'=>$status->id]) !!}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span>  
                            <span class="dropdown">
                                <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">  
                                    <li><a href="{!! route('admin.order_status.delete',['id'=>$status->id]) !!}" onclick="return confirm('Are you sure you want to delete this status?')"><i class="fa fa-trash "></i> Delete</a></li>
                                    <li><a href="javascript:;" id="changeStatusLink_{{$status->id}}" onclick="changeStatus({{$status->id}},{{$status->status}})" > <i class="fa fa-thumbs-o-up"></i> {{$linkLabel}}</a></li>
                                    <?php
                                    if($status->is_default == 0)
                                    {
                                     ?>
                                    <li class="changeIsDefaultCls" id="changeIsDefaultLink_{{$status->id}}" ><a href="javascript:;" onclick="changeDefaultValue({{$status->id}},{{$storeId}},{{$status->is_default}})" ><i class="fa fa-check"></i> Mark as a Default</a></li>
                                    <?php 
                                    }
                                    else 
                                    {?>
                                    <li class="changeIsDefaultCls" id="changeIsDefaultLink_{{$status->id}}" style="display:none;"><a href="javascript:;" onclick="changeDefaultValue({{$status->id}},{{$storeId}},{{$status->is_default}})" >Mark as a Default</a></li>    
                                    <?php
                                    }
                                    ?>
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

    function changeStatus(orderStatusId,status)
    {
        if(status == 1)
            var msg = 'Are you sure you want to inactive this order status?';
        else
            var msg = 'Are you sure you want to active this order status?';

        if (confirm(msg)) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.order_status.changeStatus') }}",
                data: {id: orderStatusId},
                cache: false,
                success: function(response) {
                    console.log("done");
                    if(response['status'] == 1)
                    {
                        if(status == 1)
                        {
                            $("#changeStatusLink_"+orderStatusId).html('Mark as Active');
                            $("#orderStatus_"+orderStatusId).html("Inactive");
                            $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                            $("#changeStatusLink_"+orderStatusId).attr("onclick","changeStatus("+orderStatusId+",0)");
                        }
                        else
                        {
                            $("#orderStatus_"+orderStatusId).html("Active");
                            $("#changeStatusLink_"+orderStatusId).html('Mark as Inactive');
                            $("#successMsgDiv").html(response['msg']).show().fadeOut(4000);
                            $("#changeStatusLink_"+orderStatusId).attr("onclick","changeStatus("+orderStatusId+",1)");
                        }
                    }
                    else
                    {
                        $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                    }
                    //$(window).scrollTop(0);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        }
    } // ENd  changeStatus()
    

        //Change Id Dafault Value
    function changeDefaultValue(orderStatusId,storeId,isDefaultVal)
    {
      
        var msg = 'Are you sure you want to make as a default?';
       

        if (confirm(msg)) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.order_status.changeIsDefault') }}",
                data: {
                        id: orderStatusId,
                        storeId: storeId,
                        isDefaultValue: isDefaultVal
                    },
                cache: false,
                success: function(response) {
                   //alert(response['msg']);
                    if(response['status'] == 1)
                    {
                        //alert(1);
                        $(".isDefaultCls").html('No');
                        $(".changeIsDefaultCls").show();
                        $("#changeIsDefaultLink_"+orderStatusId).hide();
                        $("#orderStatusIsDefault_"+orderStatusId).html("Yes");
                        $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                    }
                    else
                    {
                        $("#errorMsgDiv").html(response['msg']).show().fadeOut(4000);
                    }
                    //$(window).scrollTop(0);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        }//ajax call ends here

    }//function ends here
</script>
@stop