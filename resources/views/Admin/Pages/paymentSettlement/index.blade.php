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
                <div class="box-header">
                    <div class="box-header col-md-3">
                        <form action="" class="formMul" method="post">
                            <input type="hidden" value="" name="OrderIds" />
                            <select name="orderAction" id="orderAction" class="form-control pull-right col-md-12">
                                <option value="">Please Select an Action</option>
                                <!-- <option value="">Generate Waybill</option> -->
                                <option value="1">Payment Settlement</option>
                                <!--<option value="17">Send to Shiprocket</option>-->
                            </select>
                        </form> 
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th><input type="checkbox" id="checkAll" /></th>
                            <th>Order Id</th>

                            <th>Sub order Id</th>
                            <th>Store Name</th>
                            <th>Paid Amount</th>
                            <th>Settled Amt</th>
                            <th>Settled Date</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($orders as $order)
                        <tr>
                            <td><input type="checkbox" name="orderId[]" class="checkOrderId" value="{{ $product->id }}" /></td>
                            <td>{{ $order->order_id }}</td>

                            <td>{{ $order->id }}</td>
                            <td>{{ $order->store_name }}</td>
                            <td>{{ $order->pay_amt }}</td>
                            <td>{{ $order->settled_amt }}</td>
                            <td>{{ date('d-M-Y',strtotime($order->settled_date)) }}</td>


                            <td>{{ date('d-M-Y',strtotime($order->created_at)) }}</td>
                            <td>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <div class="pull-right">
                        {{ $orders->links() }}
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