@extends('Admin.Layouts.default')

@section('contents')

<section class="content-header">
    <h1>
        Payment Settlement

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Payment Settlement</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">

              
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                 
                            <th>Order Id</th>
                
                            <th>Sub order Id</th>
                            <th>pay Amount</th>
                       
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($orders as $order)
                        <tr>

                            <td>{{ $order->order_id }}</td>
                         
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->pay_amt }}</td>
                       
                            <td>{{ date('d-M-Y',strtotime($order->created_at)) }}</td>
                            <td>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <div class="pull-right">
                        {{ $orders->appends($arguments)->links() }}
                    </div>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

@stop
@section('myscripts')

@stop