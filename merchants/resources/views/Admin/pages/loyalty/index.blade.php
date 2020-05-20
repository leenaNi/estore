@extends('Admin.layouts.default')




@section('content')


<section class="content-header">
    <h1>Loyalty Programs </h1>
    <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Marketing</a></li>
        <li class="active">Loyalty Program</li>
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
        @if(!empty(Session::get('updateLoyaltyScuccess')))
        <div  class="alert alert-success" role="alert">
            {{ Session::get('updateLoyaltyScuccess') }}
        </div>
        @endif
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 noAll-padding">
                <div class="filter-left-section"> 
                    <form method="get" action="{{ route('admin.loyalty.view')}}" >
                           <div class="form-group col-md-8 col-sm-8 col-xs-12 noBottom-margin">
                            <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control form-control-right-border-radius medium" placeholder="Loyalty Group"/>
                            </div>
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12 noBottom-margin">
                            <a  href="{{route('admin.loyalty.view')}}" class="btn reset-btn noMob-leftmargin pull-right mn-w100">Reset</a>
                            <input type="submit" name="submit" class="btn btn-primary noAll-margin pull-right marginRight-sm mn-w100" value="Filter"> 
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Loyalty Programs 
                <?php
                if($loyaltyCount > 0)
                {
                ?>
                   <span class="listing-counter">{{$startIndex}}-{{$endIndex}} of {{$loyaltyCount}}</span> </h1>
                <?php
                }
                ?> 

            <button id="editable-sample_new" class="btn btn-listing-heading pull-right noAll-margin" onclick="window.location.href ='{{ route('admin.loyalty.add')}}'"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'plus.svg'}}"> Create</button>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                 <table class="table table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr> 
                            <th class="text-left">Loyalty Group</th>
                            <th class="text-right">Minimum Order Amount</th>
                            <th class="text-right">Maximum Order Amount</th>
                            <th class="text-center">Cashback Percent</th>
                            <th class="text-center"> Status</th>
                            <th class="text-center mn-w100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                           @if(count($loyalty) >0 )
                        @foreach($loyalty as $lyt)

                        <tr> 
                            <td class="text-left">{{ $lyt->group }}</td>
                            <td class="text-right"><span class="priceConvert">{{ $lyt->min_order_amt }}</span></td>
                            <td class="text-right"><span class="priceConvert">{{ $lyt->max_order_amt }}</span></td>
                            <td class="text-center">{{ $lyt->percent }}</td>
                            <td class="text-center">  @if($lyt->status==1)
                                <a href="{!! route('admin.loyalty.changeStatus',['id'=>$lyt->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable loyalty?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn btnNo-margn-padd"</a>
                                @elseif($lyt->status==0)
                                <a href="{!! route('admin.loyalty.changeStatus',['id'=>$lyt->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this loyalty?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn btnNo-margn-padd"></i></a>
                                @endif</td>
                            <td class="text-center mn-w100">
                                <div class="actionCenter">
                                    <span><a class="btn-action-default edit" href="{{  route('admin.loyalty.edit',['id'=>$lyt->id]) }}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                                    <span class="dropdown">
                                        <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">  
                                            <li><a href="{{route('admin.loyalty.delete',['id'=>$lyt])}}" onclick="return confirm('Are you sure you want to delete the loyalty group ?')"><i class="fa fa-trash "></i> Delete</a></li>
                                        </ul>
                                    </span>  
                                </div>  
                            </td>
                        </tr>
                        @endforeach
                         @else
                         <tr><td colspan="6" class="text-center"> No Record Found.</td></tr>
                         @endif
                    </tbody>
                </table>
            </div>
            <?php
            $args = [];
            !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
            !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
            !empty(Input::get("order")) ? $args["order"] = Input::get("order") : '';
            ?>
            <?php
            if (empty(Input::get('search'))) {
                echo $loyalty->render();
            }
            ?>
        </div>
    </div>


</section>
<div class="clearfix"></div>
@stop

@section('myscripts')
<script>
    $(document).ready(function () {
        $(".delete").click(function () {
            var r = confirm("Are You Sure You want to Delete this Attribute?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop