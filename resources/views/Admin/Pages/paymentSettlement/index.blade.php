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
                
              
                    <div class="box-header box-tools filter-box col-md-9 noBorder rightBorder">
                    {!! Form::open(['method' => 'get', 'route' => 'admin.payment-settlement.view' , 'id' => 'searchForm' ]) !!}
                    {!! Form::hidden('is_export',null,['id' => 'is_export']) !!}
                  <div class="form-group col-md-4">
                        {!! Form::select('storeId', $stores,Input::get('storeId') ,["class"=>'form-control', "placeholder"=>"store name"]) !!}
                    </div>
                    
<!--                    <div class="form-group col-md-4">
                        {!! Form::text('date',Input::get('date'), ["class"=>'form-control  date', "placeholder"=>"Settlement Date"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_date',Input::get('date'), ["class"=>'form-control date', "placeholder"=>"Order Date"]) !!}
                    </div>-->
                    <div class="form-group col-md-4">
                        {!! Form::select('settlement', ['1' => 'Settled','0' => 'Unsettled','2' => 'Both' ],Input::get('settlement') ,["class"=>'form-control', "placeholder"=>"Settlement Status"]) !!}
                    </div>
                    
                   
                   
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-5 no-padding">
                            <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Filter</button>
                        </div>
                        <div class=" button-filter col-md-5 no-padding noBottomMargin">
                            <a href="{{route('admin.payment-settlement.view')}}"><button type="button" class="btn btn-default form-control">Reset</button></a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
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
                
                 <div class="clearfix"></div>
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
                            <td> <span class="currency-sym"> </span><span class="priceConvert"> {{ $order->pay_amt }}<span></td>
                            <td> <span class="currency-sym"> </span> <span class="priceConvert"> {{ $order->settled_amt? $order->settled_amt:'0'}}</span></td>
                            <td > {{ date('d-M-Y',strtotime($order->settled_date)) }}</td>


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