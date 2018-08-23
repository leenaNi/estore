@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Sales By Customer
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Sales By Customer</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9">
                    <form method="post" action="{{ URL::route('admin.sales.orderByCustomer',['id' => $user_id]) }}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <div class="form-group col-md-4">
                            <select name="orderStatus" id="orderStatus" class="form-control onchange pull-right col-md-12">
                                <?php foreach ($orderStatus as $os) { ?>
                                    <option value="{{ $os->id }}">{{ $os->order_status }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                                  <select name="paymentMethod" id="paymentMethod" class="form-control onchange pull-right col-md-12">
                                <?php foreach ($paymentMethod as $os) { ?>
                                    <option value="{{ $os->id }}">{{ $os->name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                                  <select name="paymentStatus" id="paymentStatus" class="form-control onchange pull-right col-md-12">
                                <?php foreach ($paymentStatus as $os) { ?>
                                    <option value="{{ $os->id }}">{{ $os->payment_status }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="submit" name="submit" class="btn" value="Submit">
                        </div>
                          <div class="form-group col-md-3">
                            <a href="{{ route('admin.sales.orderByCustomer',['id' => $user_id])}}" class="reset-btn btn btn-block">Reset </a>
                        </div>
                    </form>   
                </div>
<!--                <div class="box-header col-md-3">
                    <form method="post" id="CatExport" action="{{ URL::route('admin.sales.orderByCustomerExport',['id' => $user_id]) }}">
                        <input type="hidden" name="orderStatusexport" id="orderStatusexport" value="<?php if(Input::get('orderStatus')){ echo Input::get('orderStatus');  }else{ echo 0; } ?>">
                        <input type="hidden" name="paymentMethodexport" id="paymentMethodexport" value="<?php if(Input::get('paymentMethod')){ echo Input::get('paymentMethod');  }else{ echo 0; } ?>">
                        <input type="hidden" name="paymentStatusexport" id="paymentStatusexport" value="<?php if(Input::get('paymentStatus')){ echo Input::get('paymentStatus');  }else{ echo 0; } ?>" />
                        <input type="submit" class="catExport btn pull-right col-md-12" value="Export">
                    </form>
                </div> -->
                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table  catSalesTable table-hover general-table">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Order Amount</th>
                                <th>Pay Amount</th>
                                <th>Cashback Used</th>
                                <th>Cashback Earned</th>
                                <th>Cashback Credited</th>
                                <th>Order Status</th>
                                 <th>Payment Method</th>
                                <th>Payment Status</th>
                                
                               
                            </tr>
                        </thead>
                        <tbody>
                             @if(count($orders) >0)
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td><?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert">{{ number_format($order->order_amt,2) }}</span></td>
                                <td><?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert">{{ number_format($order->pay_amt,2) }}</span></td>
                                <td><?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert">{{ number_format($order->cashback_used,2) }}</span></td>
                                <td><?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert">{{ number_format($order->cashback_earned,2) }}</span></td>
                                <td><?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert"> {{ number_format($order->cashback_credited,2)}}</span></td>
                                <td>{{ $order->orderstatus['order_status'] }}</td>
                                <td>{{ $order->paymentmethod['name'] }}</td>
                                <td>{{ $order->paymentstatus['payment_status'] }}</td>
                            </tr>
                            @endforeach
                              @else
                           <tr><td colspan=6> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                    <?php if (empty(Input::get('dateSearch'))) { ?>
                        <div class="pull-right">

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>


@stop

@section('myscripts')
<script type="text/javascript">
    $(document).ready(function () {
        
//
$('.onchange').change(function (event) {
           var val = $(this).val();
           var select = $(this).attr('id');
           $("#"+select+"export").val(val);
        });
//orderStatus paymentMethod paymentStatus
        $('#checkAll').click(function (event) {

            var checkbox = $(this),
                    isChecked = checkbox.is(':checked');
            if (isChecked) {
                $('.checkcatId').attr('Checked', 'Checked');
            } else {
                $('.checkcatId').removeAttr('Checked');
            }
        });


        $("#fromdatepicker").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: new Date(),
            onSelect: function (selected) {
                $("#todatepicker").datepicker("option", "minDate", selected);
            }
        });

        $("#todatepicker").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: new Date(),
            onSelect: function (selected) {
                $("#fromdatepicker").datepicker("option", "maxDate", selected);
            }
        });
    });
</script>

@stop