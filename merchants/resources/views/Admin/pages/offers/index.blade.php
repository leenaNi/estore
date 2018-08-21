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
                                <!--<th>Offer Discount Type</th>-->
                                <th>Offer Type</th>
                                <th>Offer Discount Value</th>
<!--                                <th>Min Order Discount</th>
                                <th>Min Free Quantity</th>-->
                                <th>User Specific</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offerInfo as $offer)
                            <tr>
                                <td>{{$offer->id}}</td>
                                <td>{{$offer->offer_name}}</td>
                                <!--<td>{{$offer->offer_discount_type == 1 ? "Percentage" : "Fixed"}}</td>-->
                                <td>{{$offer->offer_type == 1 ? "Entire Order" : ($offer->offer_type == 2 ? "Specific Categories" : "Specific Products")}}</td>
                                <td>{{$offer->offer_discount_value}} {{$offer->offer_discount_type == 1 ? "%" : "Rs."}}</td>
<!--                                <td>{{$offer->min_order_discount}}</td>
                                <td>{{$offer->min_free_quantity}}</td>-->
                                <td>{{$offer->user_specific == 1 ? "Yes" : "No"}}</td>
                                <td>{{$offer->status == 1 ? "Yes" : "No"}}</td>
                                <td>{{$offer->start_date}}</td>
                                <td>{{$offer->end_date}}</td>
                                <td>{{$offer->created_at}}</td>
                                <td>
                                    <a href="{{route('admin.offers.edit',['id'=>$offer->id])}}" class="label label-success active" ui-toggle-class="" class="btnNo-margn-padd">Edit</a> 
                                    <a href="{{route('admin.offers.delete',['id'=>$offer->id])}}" class="label label-danger active" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
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