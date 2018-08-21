@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
       Return Orders
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Return Orders</li>
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
                @if(!empty(Session::get('messageError')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('messageError') }}
                </div>
                @endif
                

                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Return Order Id</th>
                                <th>Order Id</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Product</th>
<!--                                <th>Order Status</th>-->
                                <th>Returns Status</th>
                                <th>Return Request Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                 <?php
                 $returnOrder=[1=>"Cancelled",2=>"Returned",3=>'Exchange'];
                 ?>
                            @if(count($return)>0)
                            @foreach($return as $r)
                            
                            <tr>
                                <td>{{ $r['id'] }}</td>
                                <td>{{ $r['order_id']['id'] }}</td>
                                <td>{{ $r['order_id']['user']['firstname'] }} {{ $r['order_id']['user']['lastname'] }}</td>
                                <td>{{ $r['order_id']['user']['email'] }}</td>
                                <td>{{ $r['order_id']['user']['telephone'] }}</td>
                                <td>{{ $r['product_id']['product'] }}</td>
<!--                               <td>{{ @$returnOrder[$r['order_status']]?$returnOrder[$r['order_status']]:"-" }}</td>-->
                                <th>{{ @$r['return_status_id']['status'] }}</th>
                                <td>{{ date('d-M-Y',strtotime($r['created_at'])) }}</td>
                                <td>
                                    <a href="{{route('admin.orders.editreturn',['id' => $r['id']])}}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
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