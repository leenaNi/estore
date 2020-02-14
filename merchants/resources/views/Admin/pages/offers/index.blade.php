@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Offers
        <small>Add/Edit/Delete</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Offers</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">   <a href="{!! route('admin.offers.add') !!}" class="btn btn-default pull-right" type="button">Add New Offer</a> </h3>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Offer ID</th>
                                <th>Offer Name</th>
                                <th>Offer Type</th>
                                <th>Discount Type</th>
                                <th>Discount Value</th>
<!--                                <th>Min Order Discount</th>
                                <th>Min Free Quantity</th>-->
                                <th>User Specific</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offerInfo as $offer)
                            <tr>
                                <td>{{$offer->id}}</td>
                                <td>{{$offer->offer_name}}</td>
                                <td>{{$offer->type == 1 ? "Buy X qty of A, Get Y/Y% OFF" : "Buy X qty of A, Get Y qty of B"}}</td>
                                <td>{{$offer->offer_type == 1 ? "Entire Order" : ($offer->offer_type == 2 ? "Specific Categories" : "Specific Products")}}</td>
                                <td>
                                    @if($offer->type == 1)
                                    {{$offer->offer_discount_value}} {{$offer->offer_discount_type == 1 ? "%" : "Rs."}}
                                    @endif
                                </td>
<!--                                <td>{{$offer->min_order_discount}}</td>
                                <td>{{$offer->min_free_quantity}}</td>-->
                                <td>{{$offer->user_specific == 1 ? "Yes" : "No"}}</td>
                                <td>
                                    <!--- ////$offer->status == 1 ? "Enabled" : "Disabled"}} -->
                                    @if($offer->status == 1)
                                    <label class="label label-success active">Enabled</label>
                                    @else
                                    <label class="label label-danger active">Disabled</label>
                                    @endif
                                </td>
                                <td>{{date('d-M-Y', strtotime($offer->start_date))}}</td>
                                <td>{{date('d-M-Y', strtotime($offer->end_date))}}</td>
                                <td><!---label label-danger active -->
                                <?php if ($offer->status == 1) { ?>
                                            <a href="{!! route('admin.offers.changeStatus',['id'=>$offer->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this offer?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btnNo-margn-padd"></i></a>
                                        <?php } elseif ($offer->status == 0) { ?>
                                            <a href="{!! route('admin.offers.changeStatus',['id'=>$offer->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this offer?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btnNo-margn-padd"></i></a>
                                        <?php } ?>
                                    <a href="{{route('admin.offers.edit',['id'=>$offer->id])}}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btnNo-margn-padd"></i></a> 
                                    <a href="{{route('admin.offers.delete',['id'=>$offer->id])}}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this offer?')"data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</section>

@stop 
@section('myscripts')
<script>
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
@stop