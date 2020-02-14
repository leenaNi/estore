@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
       Cancel Orders 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Cancel Orders</li>
    </ol>
</section>
<section class="main-content">

    <div class="notification-column">            
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
    </div>
    
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Cancel Orders</h1>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table orderTable table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Cancel Order Id</th>
                            <th class="text-center">Order Id</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Email</th> 
                            <th class="text-center">Cancel Status</th>
                            <th class="text-right">Return Request Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
             <?php
             $returnOrder=[1=>"Cancelled",2=>"Returned",3=>'Exchange'];
             ?>
                        @if(count($data)>0)
                        @foreach($data as $cancel)
                        
                        <tr>
                            <td class="text-center">{{ @$cancel->id }}</td>
                            <td class="text-center">{{ @$cancel->getorders->id }}</td>
                            <td class="text-left"><span class="list-dark-color">{{ @$cancel->getorders->users->firstname }} {{ @$cancel->getorders->users->lastname }}</span><div class="clearfix"></div><span class="list-light-color list-small-font">{{ @$cancel->getorders->users->telephone }}</span></td>
                            <td class="text-left">{{ @$cancel->getorders->users->email}}</td> 
                            <th class="text-center"><span class="alertWarning">{{ @$cancel->status==0?"Pending":"Cancelled" }}</span></th>
                            <td class="text-right">{{ date('d-M-Y',strtotime(@$cancel->created_at)) }}
                            <div class="clearfix"></div>
                                <span class="list-light-color list-small-font">8:30 PM</span></td>
                            <td class="text-center">
                                <a href="{{route('admin.orders.cancelOrderEdit',['id' => $cancel->id])}}"  class="btn-action-default">Edit</a>
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
</section>
<div class="clearfix"></div>
@stop
@section('myscripts')
<script>
    $(document).ready(function () {


    });
</script>

@stop