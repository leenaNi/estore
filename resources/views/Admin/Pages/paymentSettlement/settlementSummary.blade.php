@extends('Admin.Layouts.default')

@section('contents')

<section class="content-header">
    <h1>
        Payment Settlement Summary

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Payment Settlement  Summary</li>
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
                

             
      
                
                 <div class="clearfix"></div>
                <div class="box-body table-responsive">
                    <table class="table table-hover orderTable">
                        <tr>
                           
                          

                         
                            <th>Store Name</th>
                            <!--total sales, paid via veestores, settled amt, unsettled amt, commision-->
                            <th>Total Sales</th>
                            <th>Paid via veestores</th>
                            <th>Settled Amt</th>
                          
                            <th>UnSettled Amt</th>
                            <th>Commision</th>
                           
                        </tr>
                        @foreach($orders as $key=>$order)
                        <tr>
                           
                         
                            <td>{{ $order->store_name }}</td>
                            <td><span class="currency-sym"> </span><span class="priceConvert">{{ $order->totalOrder }}</span></td>
                            <td><span class="currency-sym"> </span><span class="priceConvert">{{ @$orderWithCourier[$key]->totalOrder?$orderWithCourier[$key]->totalOrder:'0' }}</span></td>
                            <td><span class="currency-sym"> </span><span class="priceConvert"> {{ $order->totalPaid ?$order->totalPaid:'0'}}</span></td>
                            <!--<td><span class="currency-sym"> </span><span class="priceConvert"> {{ ($order->totalPaid)-($order->totalPaid) }}</span></td>-->
                            <td><span class="currency-sym"> </span><span class="priceConvert">{{ @$orderWithCourier[$key]->totalOrder?$orderWithCourier[$key]->totalOrder - ($order->totalPaid:'0') }}</span></td>
                            <td><span class="currency-sym"> </span><span class="priceConvert">{{ ($order->orderAmt) - ($order->totalPaid) }}</span></td>
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