@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Offers 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Offers</li>
    </ol>
</section> 

<section class="main-content">
    <div class="notification-column">
       <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
    </div> 
    <div class="grid-content">
        <div class="section-main-heading">
            <h1 class="lineHeight-30">Offer
            <span>
            <a href="{!! route('admin.offers.add') !!}" class="btn btn-default pull-right col-md-3" target="_" type="button">Add New Offer</a></span></h1>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Type</th>
                            <th class="text-left">Discount Type</th>
                            <th class="text-right">Discount Value</th> 
                            <th class="text-center">User Specific</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Start Date</th>
                            <th class="text-right">End Date</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offerInfo as $offer)
                        <tr>
                            <td class="text-center">{{$offer->id}}</td>
                            <td class="text-left">{{$offer->offer_name}}</td>
                            <td class="text-left">{{$offer->type == 1 ? "Buy X qty of A, Get Y/Y% OFF" : "Buy X qty of A, Get Y qty of B"}}</td>
                            <td class="text-left">{{$offer->offer_type == 1 ? "Entire Order" : ($offer->offer_type == 2 ? "Specific Categories" : "Specific Products")}}</td>
                            <td class="text-right">
                                @if($offer->type == 1)
                                {{$offer->offer_discount_value}} {{$offer->offer_discount_type == 1 ? "%" : "Rs."}}
                                @endif
                            </td> 
                            <td class="text-center">{{$offer->user_specific == 1 ? "Yes" : "No"}}</td>
                            <td class="text-center"> 
                                @if($offer->status == 1)
                                <label class="alertSuccess">Enabled</label>
                                @else
                                <label class="alertDanger">Disabled</label>
                                @endif
                            </td>
                            <td class="text-right">{{date('d-M-Y', strtotime($offer->start_date))}}</td>
                            <td class="text-right">{{date('d-M-Y', strtotime($offer->end_date))}}</td>
                            <td class="text-center"> 
                                <div class="actionCenter">
                                    <span><a class="btn-action-default" href="{{route('admin.offers.edit',['id'=>$offer->id])}}">Edit</a></span> 
                                    <span class="dropdown">
                                        <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                            <?php if ($offer->status == 1) { ?>
                                            <li><a href="{!! route('admin.offers.changeStatus',['id'=>$offer->id]) !!}" onclick="return confirm('Are you sure you want to disable this offer?')"><i class="fa fa-check "></i> Enabled</a></li>
                                            <?php } elseif ($offer->status == 0) { ?>
                                            <li><a href="{!! route('admin.offers.changeStatus',['id'=>$offer->id]) !!}" onclick="return confirm('Are you sure you want to enable this offer?')"><i class="fa fa-times "></i> Disabled</a></li>
                                            <?php } ?>
                                            <li><a href="{{route('admin.offers.delete',['id'=>$offer->id])}}" onclick="return confirm('Are you sure you want to delete this offer?')"><i class="fa fa-trash "></i> Delete</a></li>
                                        </ul>
                                    </span>  
                                </div>                             
                            </td>
                        </tr>
                        @endforeach
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
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
@stop