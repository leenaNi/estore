@extends('Admin.layouts.default')

@section('mystyles')
    <link rel="stylesheet" href="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <link rel="stylesheet" href="{{ asset('public/Admin/plugins/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <style type="text/css">
        .multiselect-container {
            width: 100% !important;
        }
    </style>
@stop

@section('content')
<section class="content-header">
    <h1>
        All Orders
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Orders</li>
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
                <div class="box-header box-tools filter-box col-md-9 noBorder rightBorder">
                    {!! Form::open(['method' => 'get', 'route' => 'admin.vendors.orders' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                        {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control', "placeholder"=>"Order Ids"]) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::text('search',Input::get('search'), ["class"=>'form-control ', "placeholder"=>"Customer/Email/Contact"]) !!}
                    </div>
                    
                    <div class="form-group col-md-4">
                        {!! Form::text('date',Input::get('date'), ["class"=>'form-control  date', "placeholder"=>"Order Date"]) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::select('product',$products,Input::get('product'), ["class"=>'form-control', "placeholder"=>"Select Product"]) !!}
                    </div>
                   
                    <div class="clearfix"></div>
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-6 no-padding">
                            <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Filter</button>
                        </div>
                        <div class=" button-filter col-md-5 no-padding noBottomMargin">
                            <a href="{{route('admin.vendors.orders')}}"><button type="button" class="btn reset-btn form-control">Reset</button></a>
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
                            <option value="1">Print Invoice</option>
                            <!--<option value="17">Send to Shiprocket</option>-->
                            <option value="3" >Export</option>
                            <!--<option value="25" >Warehouse Order Export</option>-->
                            <optgroup label="Update Order Status">
                                <option value="4" >Processing</option>
                                <option value="5">Shipped</option>
                                <option value="6" >Delivered</option>
                                <option value="8">Cancelled</option>
                                <option value="9">Exchanged</option>
                                <option value="10">Returned</option>
                                <option value="11">Undelivered</option>
                                <option value="12" >Delayed</option>
                                <option value="20">Partially Shipped</option>
                                <option value="21">Refunded</option>
                            </optgroup>
                        </select>
                    </form> 
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                 <div class="form-group col-md-4 ">
                        <div class="button-filter-search pl0">
                    {{$ordersCount }} Order{{$ordersCount > 1 ?'s':'' }}
                </div>
              </div> 
                    <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll" /></th>
                                <th>@sortablelink ('id', 'Order ID')</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Customer Name</th>
                                <th>Contact No</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Payment Method</th>
                                <th>@sortablelink ('pay_amt', 'Order Amt')</th>
                                <th>Order Date</th>
                                <th width="6%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(count($orders) >0 )
                            @foreach($orders as $order)
                            <tr>
                                <td><input type="checkbox" name="orderId[]" class="checkOrderId" value="{{ $order->id }}" /></td>
                                <td><a href="{!! route('admin.orders.edit',['id'=>$order->id]) !!}">{{ $order->id }}</a></td>
                                @if(@$order->prod_type == 1)
                                    <td>{{ @$order->product->product }}</td>
                                @elseif(@$order->prod_type == 3)
                                    <td>{{ @$order->subProduct->product }}</td>
                                @else
                                  <td></td>
                                @endif
                                <td> {{ @$order->qty }} </td>
                                <td>{{ @$order->orderDetails->users->firstname }} {{ @$order->orderDetails->users->lastname }} </td>
                                <td>{{ @$order->orderDetails->users->telephone }}</td>
                                <td>{{ @$order->order_status  }}</td>
                                <td>{{ @$order->orderDetails->paymentstatus['payment_status'] }}</td>
                                <td>{{ @$order->orderDetails->paymentmethod['name'] }}</td>
                                <td>{{ @$order->price }}</td>
                                <td>{{ date('d M y h:i:s a',strtotime($order->orderDetails->created_at)) }}</td>
                                <td>
                                <a href="{!! route('admin.vendors.ordersDetails',['id'=> $order->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw btnNo-margn-padd"></i></a>
                                <a type="button" class="fa fa-times" title="Cancel Order" onclick="datacheck({{$order->id}})" ></a>
                                <!-- <button type="button" class="btn btn-danger btn-sm" onclick="datacheck({{$order->id}})" >Reject</button> -->
                                </td>
                            </tr>
                            @endforeach
                             @else
                            <tr><td colspan=14> No Record Found</td></tr>
                         @endif
                        </tbody>
                    </table>

                    <div class="box-footer clearfix">

                        <?php
                        echo $orders->appends(Input::except('page'))->render();
                        ?>

                        <?php //}
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="mulModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Change Order Status</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="mulForm" action="{{ route('admin.vendor.order.status') }}"> 
                                <input  type="checkbox" name="notify" value="1">  Confirm & Notify Customer.
                                <br/>
                                <label>Comments</label>
                                <textarea name="remark"  class="form-control"></textarea>
                                <input type="hidden" name="status" class="OdStatus">
                                <input type='hidden' name='commentChanges' value='1'>
                                <input type="hidden" value="" name="OrderIds" />
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary saveMulChanges">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="commentBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                        <p class="ordComment"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="flagBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Flag</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="flagForm" action=""> 
                            <label>Select Flag</label>
                            <select name="flagid" class="form-control selFlag">
                                <option value="">Please select</option>
                                @foreach($flags as $flag)
                                <option value="{{ $flag->id }}">{{ $flag->flag  }}</option>
                                @endforeach
                            </select>
                            <br/>
                            <label>Comments</label>
                            <textarea name="flag_remark"  class="form-control flagComment"></textarea>
                            <input type="hidden" name="ord_id" class="OdID">
                        </form>   
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="saveFlag" class="btn btn-primary saveFlag" >Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@stop
@section('myscripts')
<script src="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('public/Admin/plugins/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>

<script>
function datacheck(id){
    var userId = id;
    var conf = confirm('Are you sure you want to reject this order? You\'ll not be able to undo this action.');
        if(conf){
            $.ajax({
            method:"POST",
            data:{'id':userId },
            url:"<?php echo route('admin.vendors.rejectOrders') ;?>",
            success: function(data){
                     location.reload();
                    }
            })
        }
      
    }

    $(document).ready(function () {

        $('.multiselect').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '100%',
            nonSelectedText: 'Select Status'
        });

        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('.date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('.date').daterangepicker({
                startDate: start,
                endDate: end,
                format: 'YYYY/MM/DD',
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
            
        });

        /*$(".toDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".fromDate").datepicker("option", "maxDate", selected);
            }
        });*/
        $(".ereorder").click(function () {
            var r = confirm("Edit order will cancel the current order and create new order.\nAre you sure you want to continue?");
            if (r == false) {
                return false;
            }
        });

        $('#checkAll').click(function (event) {
            var checkbox = $(this),
                    isChecked = checkbox.is(':checked');
            if (isChecked) {
                $('.checkOrderId').attr('Checked', 'Checked');
            } else {
                $('.checkOrderId').removeAttr('Checked');
            }
        });
        $('#searchForm input').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#SForm').submit();
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
            $("input[name='OrderIds']").val(ids);
            if ($(this).val() == 1) {
                chkInvoice = confirm("Are you sure you want to continue (yes/no)?");
                if (chkInvoice == true) {
                    $(this).parent().attr("action", "{{ route('admin.orders.invoice') }}");
                } else {
                    return false;
                }
            }
            if ($(this).val() == 17) {
                chkshipRocket = confirm("Are you sure you want to continue (yes/no)?");
                if (chkshipRocket == true) {
                    $(this).parent().attr("action", "");
                } else {
                    return false;
                }
            } else if ($(this).val() == 2) {
                chkWaybill = confirm("Are you sure you want to continue (yes/no)?");
                if (chkWaybill == true) {
                    $(this).parent().attr("action", "");
                } else {
                    return false;
                }
            } else if ($(this).val() == 3) {
                expChk = confirm("Are you sure you want to continue (yes/no)?");
                if (expChk == true) {
                    $(this).parent().attr("action", "{{ route('admin.orders.export') }}");
                } else {
                    return false;
                }
            } else if ($(this).val() == 25) {
                expChk = confirm("Are you sure you want to continue (yes/no)?");
                if (expChk == true) {
                    $(this).parent().attr("action", "");
                } else {
                    return false;
                }
            } else if ($(this).val() == 4) {
                chkOrderStatus1 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus1 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(1);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                } else {
                    return false;
                }
            } else if ($(this).val() == 5) {
                chkOrderStatus2 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus2 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(2);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                } else {
                    return false;
                }
            } else if ($(this).val() == 6) {
                chkOrderStatus3 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus3 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(3);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                } else {
                    return false;
                }
            } else if ($(this).val() == 8) {
                chkOrderStatus42 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus42 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(4);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                    // $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=4");
                } else {
                    return false;
                }
            } else if ($(this).val() == 9) {
                chkOrderStatus5 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus5 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(5);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });//
                    //  $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=5");
                } else {
                    return false;
                }
            } else if ($(this).val() == 10) {
                chkOrderStatus6 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus6 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(6);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                    //   $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=6");
                } else {
                    return false;
                }
            } else if ($(this).val() == 11) {
                chkOrderStatus7 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus7 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(7);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                    //    $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=7");
                } else {
                    return false;
                }

            } else if ($(this).val() == 12) {
                chkOrderStatus8 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus8 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(8);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                    //   $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=8");
                } else {
                    return false;
                }

            } else if ($(this).val() == 20) {
                chkOrderStatus9 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus9 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(9);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                    //  $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=9");
                } else {
                    return false;
                }
            } else if ($(this).val() == 21) {
                chkOrderStatus10 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkOrderStatus10 == true) {
                    $(".formMul").removeAttr("target");
                    $("#mulModal").modal('show');
                    $(".saveMulChanges").click(function () {
                        $(".OdStatus").val(10);
                        $("#mulForm").submit();
                        $("#mulModal").modal('hide');
                    });
                    // $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=10");
                } else {
                    return false;
                }

            } else if ($(this).val() == 13) {
                chkPaymentStatus1 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkPaymentStatus1 == true) {
                    $(this).parent().attr("action", "{{ route('admin.orders.update.payment') }}?status=1");
                } else {
                    return false;
                }
            } else if ($(this).val() == 14) {
                chkPaymentStatus2 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkPaymentStatus2 == true) {
                    $(this).parent().attr("action", "{{ route('admin.orders.update.payment') }}?status=2");
                } else {
                    return false;
                }
            } else if ($(this).val() == 15) {
                chkPaymentStatus3 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkPaymentStatus3 == true) {
                    $(this).parent().attr("action", "{{ route('admin.orders.update.payment') }}?status=3");
                } else {
                    return false;
                }
            } else if ($(this).val() == 16) {
                chkPaymentStatus4 = confirm("Are you sure you want to continue (yes/no)?");
                if (chkPaymentStatus4 == true) {
                    $(this).parent().attr("action", "{{ route('admin.orders.update.payment') }}?status=4");
                } else {
                    return false;
                }
            } else if ($(this).val() == 30) {
                chkFlag = confirm("Are you sure you want to continue (yes/no)?");
                if (chkFlag == true) {
                    $(".formMul").removeAttr("target");
                    $("#flagForm")[0].reset();
                    $("#flagBox").modal('show');
                    console.log(ids + "Order Ids");
                    $(".saveFlag").click(function () {
                        $(".OdID").val(ids);
                        $("#flagForm").attr('action', "{{ route('admin.orders.addMulFlag') }}");
                        $("#flagForm").submit();
                $("#flagBox").modal('hide');
                    });
                    //  $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=9");
                } else {
                    return false;
                }
            }else if ($(this).val() =="") {           
                  location.href("{{route('admin.orders.view')}}");
            // location.reload();
            }
            var Thisval = $(this).val();
            if (ids.length > 0) {
                if (Thisval != 4 && Thisval != 5 && Thisval != 6 && Thisval != 8 && Thisval != 9 && Thisval != 10 && Thisval != 11 && Thisval != 12 && Thisval != 20 && Thisval != 21 && Thisval != 30) {
                    $(this).parent().submit();
                }
            }
        });

        /* Flag add*/
        $(".getFlag").click(function () {
            var orderid = $(this).attr('data-ordId');
            $(".selFlag").val("");
            $(".flagComment").val("");
            $(".OdID").val(orderid);
            $("#flagBox").modal('show');
        });
        $(".saveFlag").click(function () {
            var ordid = $(".OdID").val();
            if ($(".selFlag").val() !== "") {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.orders.addFlag') }}",
                    data: $("#flagForm").serialize(),
                    cache: false,
                    success: function (response) {
                        var divF = "<div class='flagDName" + ordid + "' id='flagDName" + ordid + "'><div style='width: 20px;height: 20px;background:" + response['value'] + " ;border-radius: 50%'></div><br/>" + response['flag'] + "</div>";
                        $("#flagD" + ordid).find("#flagDName" + ordid).replaceWith(divF);
                        $("#flagC" + ordid).find("#flagDC" + ordid).replaceWith("<div id='flagDC" + ordid + "' class='flagDC" + ordid + "'><div>" + response['remark'] + "<div></div>");
                        $("#flagBox").modal('hide');
                    }
                });
            } else {
                alert("Please select flag");
            }
        });
        /* Flag end */
    });
    $(window).load(function () {
        setTimeout(function () {
            $('#checkAll').show();
        }, 1000);
    });
</script>

@stop