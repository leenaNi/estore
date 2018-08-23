@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
       Cancel Orders
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Cancel Orders</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
                

                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Cancel Order Id</th>
                                <th>Order Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Cancel Status</th>
                                <th>Return Request Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                 <?php
                 $returnOrder=[1=>"Cancelled",2=>"Returned",3=>'Exchange'];
                 ?>
                            @if(count($data)>0)
                            @foreach($data as $cancel)
                            
                            <tr>
                                <td>{{ @$cancel->id }}</td>
                                <td>{{ @$cancel->getorders->id }}</td>
                                <td>{{ @$cancel->getorders->users->firstname }} {{ @$cancel->getorders->users->lastname }}</td>
                                <td>{{ @$cancel->getorders->users->email}}</td>
                                <td>{{ @$cancel->getorders->users->telephone }}</td>
                                <th>{{ @$cancel->status==0?"Pending":"Cancelled" }}</th>
                                <td>{{ date('d-M-Y',strtotime(@$cancel->created_at)) }}</td>
                                <td>
                                    <a href="{{route('admin.orders.cancelOrderEdit',['id' => $cancel->id])}}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan="9" class="text-center"> No Record Found</td></tr>
                            @endif
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@stop
@section('myscripts')
<script>
    $(document).ready(function () {


    });
</script>

@stop