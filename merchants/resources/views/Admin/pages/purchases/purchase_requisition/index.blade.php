@extends('Admin.layouts.default')

@section('mystyles')
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/daterangepicker/daterangepicker-bs3.css' }}">
<link rel="stylesheet" href="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.css' }}">
<style type="text/css">
    .multiselect-container {
        width: 100% !important;
    }
</style>
@stop

@section('content')
<section class="content-header">
    <h1>
        All Purchase Orders (0)
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">All Purchase Orders</li>
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
                    {!! Form::open(['method' => 'get', 'route' => 'admin.requisition.view' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                        {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control', "placeholder"=>"PO No."]) !!}
                    </div>
                    
                    <div class="form-group col-md-4">
                        {!! Form::text('search',Input::get('search'), ["class"=>'form-control ', "placeholder"=>"Name/Email/Mobile"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('date',Input::get('date'), ["class"=>'form-control  date', "placeholder"=>"Order Date"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('pricemin',Input::get('pricemin'), ["class"=>'form-control ', "placeholder"=>"Minimum Amount"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('pricemax',Input::get('pricemax'), ["class"=>'form-control ', "placeholder"=>"Maximum Amount"]) !!}
                    </div>
                    
                   
                    @if($order_status->count())
                    @php echo Input::get('searchStatus[]'); @endphp
                    <div class="btn-group form-group col-md-4 col-xs-12">
                        <select name='searchStatus[]' class="multiselect form-control" multiple="multiple" style="background-color: none!important;">
                            @php echo $order_options @endphp
                        </select>                                  
                    </div>
                    @endif
                   
                    <div class="clearfix"></div>
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-6 col-xs-12 no-padding mob-marBottom15">
                            <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Filter</button>
                        </div>
                        <div class=" button-filter col-md-5 col-xs-12 no-padding noBottomMargin">
                            <a href="{{route('admin.requisition.view')}}"><button type="button" class="btn reset-btn form-control noMob-leftmargin">Reset</button></a>
                        </div>
                    </div>
                    {!! Form::close() !!}


                </div>

                <div class="box-header col-md-3 col-xs-12 pull-right mobPadding noMob-leftBorder mob-bottomBorder">
                    <a href="{{route('admin.requisition.add')}}" target="_blank" class="btn btn-default pull-right col-md-12 fullMobile-width">Create Purchase Order</a>

                    
                    <div class="clearfix" style="margin-bottom:15px;"></div>
                    <a href="{{route('admin.orders.export')}}"  class="btn btn-default pull-right col-md-12 fullMobile-width">Export All Purchase Order</a>

                    <div class="clearfix" style="margin-bottom:15px;"></div>
                    <form action="" class="formMul" method="post" >
                        <input type="hidden" value="" name="OrderIds" />
                        <select name="orderAction" id="orderAction" class="form-control pull-right col-md-12" style="margin-bottom:15px;">
                            <option value="">Select Bulk Action</option>
                            <!--                            <option value="">Generate Waybill</option>-->
                            <option value="1">Print Invoice</option>
                            <!--<option value="17">Send to Shiprocket</option>-->
                            <option value="3" >Export</option>
                            @if($feature['flag'] == 1)  
                            <option value="30" >Flag</option>
                            @endif

                            <optgroup label="Courier Services">
                                <option value="31">E-courier</option>
                            </optgroup>

                            <!--<option value="25" >Warehouse Order Export</option>-->
                            <optgroup label="Update Order Status">                                           
                                <option value="8">Cancelled</option>
                                <option value="12" >Delayed</option>
                                <option value="6" >Delivered</option>
                                <option value="9">Exchanged</option>
                                <option value="10">Returned</option>
                                <option value="20">Partially Shipped</option>
                                <option value="4" >Processing</option>
                                <option value="21">Refunded</option>
                                <option value="5">Shipped</option>
                                <option value="11">Undelivered</option>

                            </optgroup>
                            <optgroup label="Update Payment Status">
                                <option value="13">Pending</option>
                                <option value="14">Cancelled</option>
                                <option value="15">Partially Paid</option>
                                <option value="16">Paid</option>
                            </optgroup>

                        </select>
                    </form> 
                </div>



                <div class="dividerhr"></div>

                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll" /></th>
                                <th>@sortablelink ('id', 'PO No.')</th>
                                <th>Date</th>
                                <th>Name</th>
<!--                                <th>Email ID</th>-->
                                <th>Mobile</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
<!--                                <th>Payment Method</th>-->
                                <th>@sortablelink ('pay_amt', 'Amount') <?php //echo!empty(Session::get('currency_symbol')) ? '('.Session::get('currency_symbol').')' : '';  ?></th>
                               
                                <th width="6%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td><input type="checkbox" id="checkAll" /></td>
                                <td>21</td>
                                <td>21-Nov-2019</td>
                                <td>Clay Jensen</td>
                                <td>9878987678</td>
                                <td>Processing</td>
                                <td>Pending</td>
                                <td><span class="currency-sym">₹</span> 4000</td>
                                <td>
                                    <a href="{!! route('admin.requisition.vieworder',['id'=>1]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="View"><i class="fa fa-eye fa-fw btnNo-margn-padd"></i>
                                    </a>
                                    <a href="{!! route('admin.requisition.edit',['id'=>1]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw btnNo-margn-padd"></i></a>

                                    </td>
                            </tr>
                           
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
                            <form method="post" id="mulForm" action="{{ route('admin.orders.update.status') }}"> 
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
<script src="{{  Config('constants.adminPlugins').'/daterangepicker/daterangepicker.js' }}"></script>
<script src="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.js' }}"></script>
<script>
                                        $(document).ready(function () {

                                            $('.multiselect').multiselect({
                                                includeSelectAllOption: true,
                                                buttonWidth: '100%',
                                                nonSelectedText: 'Select Status'
                                            });

                                            $(function () {

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
                                                        $(this).parent().attr("target", "_blank");
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
                                                } else if ($(this).val() == "") {
                                                    window.location.href = "{{route('admin.orders.view')}}";
                                                    // location.reload();
                                                } else if ($(this).val() == 31) {
                                                    checkConfirm = confirm("Are you sure you want to continue (yes/no)?");
                                                    if (checkConfirm) {
                                                        $(this).parent().attr("action", "{{route('admin.orders.getECourier')}}");
                                                        $(this).parent().submit();
                                                    } else {
                                                        return false;
                                                    }

                                                }
                                                var Thisval = $(this).val();
                                                if (ids.length > 0) {
                                                    if (Thisval != 4 && Thisval != 5 && Thisval != 6 && Thisval != 8 && Thisval != 9 && Thisval != 10 && Thisval != 11 && Thisval != 12 && Thisval != 20 && Thisval != 21 && Thisval != 30 && Thisval != 31) {
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
                                        $(".flage").click(function () {
                                         
                                            $("#flagBox").modal('show');
                                            var ids = $(this).attr('data-ordId');
                                            console.log(ids);
                                            $(".OdID").val(ids);
                                            $(".saveFlag").click(function () {

                                                $("#flagForm").attr('action', "{{ route('admin.orders.addMulFlag') }}");
                                                //$("#flagForm").submit(); alert("hjh");
                                                $("#flagBox").modal('hide');
                                            });
                                        });
                                        $(window).load(function () {
                                            setTimeout(function () {
                                                $('#checkAll').show();
                                            }, 1000);
                                        });


</script>

@stop
