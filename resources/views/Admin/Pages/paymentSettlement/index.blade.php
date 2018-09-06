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
                 @if(!empty(Session::get('message')))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div class="alert alert-danger" role="alert">
                    {{Session::get('msg')}}
                </div>
                @endif
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
                    <table class="table table-hover orderTable">
                        <tr>
                            <th><input type="checkbox" id="checkAll" /></th>
                            <th>Order Id</th>

                            <th>Sub order Id</th>
                            <th>Store Name</th>
                            <th>Paid Amount</th>
                            <th>Settled Amt</th>
                            <th>Settled Date</th>
                            <th>Created Date</th>
                            <th>Settled Status</th>
                        </tr>
                        @foreach($orders as $order)
                        <tr>
                            <td><input type="checkbox" name="orderId[]" class="checkOrderId" value="{{ $order->id }}" /></td>
                            <td>{{ $order->order_id }}</td>

                            <td>{{ $order->id }}</td>
                            <td>{{ $order->store_name }}</td>
                            <td>{{ $order->pay_amt }}</td>
                            <td>{{ $order->settled_amt }}</td>
                            <td>{{ date('d-M-Y',strtotime($order->settled_date)) }}</td>


                            <td>{{ date('d-M-Y',strtotime($order->created_at)) }}</td>
                            <td>
                                @if($order->settled_status==1)
                                Settled
                                @else
                                Unsettle
                                @endif
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
<script>
      $('#checkAll').click(function (event) {
            var checkbox = $(this),
                    isChecked = checkbox.is(':checked');
            if (isChecked) {
                $('.checkOrderId').attr('Checked', 'Checked');
            } else {
                $('.checkOrderId').removeAttr('Checked');
            }
        });
        
           $("select#orderAction").change(function () {
            var ids = $(".orderTable input.checkOrderId:checkbox:checked").map(function () {
                return $(this).val();
            }).toArray();
            console.log(ids);
            if (ids.length == 0) {
                alert('Error! No Order Selected! Please Select Order first.');
                $(this).val('');
                return false;
            }
            // $("input[name='OrderIds']").val(ids);
            if ($(this).val() == 1) {
                chkInvoice = confirm("Are you sure you want to payment settlement ?");
                if (chkInvoice == true) {
                    $.ajax({
                        method:"POST",
                        data:{'id': ids },
                        url:"<?php echo route('admin.payment-settlements.settledPayment') ;?>",
                        success: function(data){
                                 location.reload();
                                }
                        })
                } else {
                    return false;
                }
            }
            
        });
    </script>
@stop