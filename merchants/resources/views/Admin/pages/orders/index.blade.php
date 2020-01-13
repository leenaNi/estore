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
        All Orders ({{$ordersCount }})
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
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
                    {!! Form::open(['method' => 'get', 'route' => 'admin.orders.view' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                        {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control', "placeholder"=>"Order Id"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_number_from',Input::get('order_number_from'), ["class"=>'form-control ', "placeholder"=>"Order No. From"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_number_to',Input::get('order_number_to'), ["class"=>'form-control ', "placeholder"=>"Order No. To"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('search',Input::get('search'), ["class"=>'form-control ', "placeholder"=>"Name/Email/Mobile"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('pricemin',Input::get('pricemin'), ["class"=>'form-control ', "placeholder"=>"Minimum Amount"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('pricemax',Input::get('pricemax'), ["class"=>'form-control ', "placeholder"=>"Maximum Amount"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('date',Input::get('date'), ["class"=>'form-control  date', "placeholder"=>"Order Date"]) !!}
                    </div>
                    <!-- <div class="form-group col-md-4">
                        {!! Form::text('dateto',Input::get('dateto'), ["class"=>'form-control  toDate', "placeholder"=>"To Date"]) !!}
                    </div> -->

                    @if($order_status->count())
                    @php echo Input::get('searchStatus[]'); @endphp
                    <div class="btn-group form-group col-md-4 col-xs-12">
                        <select name='searchStatus[]' class="multiselect form-control" multiple="multiple" style="background-color: none!important;">
                            @php echo $order_options @endphp
                        </select>                                  
                    </div>
                    @endif
                    @if($feature['flag'])
                    <div class="btn-group col-md-4 col-xs-12 mob-marBottom15">
                        <select name='searchFlag' class="form-control">
                            <option  value="">Select Flag</option>
                            @foreach($flags as $flag)
                            <option  value="{{$flag->id }}"  <?php echo (Input::get('searchFlag') == $flag->id ) ? "selected" : '' ?> >{{$flag->flag }}</option> 
                            @endforeach
                        </select>                                    
                    </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-6 col-xs-12 no-padding mob-marBottom15">
                            <button type="submit" class="btn btn-primary form-control" style="margin-left: 0px;"> Filter</button>
                        </div>
                        <div class=" button-filter col-md-5 col-xs-12 no-padding noBottomMargin">
                            <a href="{{route('admin.orders.view')}}"><button type="button" class="btn reset-btn form-control noMob-leftmargin">Reset</button></a>
                        </div>
                    </div>
                    {!! Form::close() !!}


                </div>

                <div class="box-header col-md-3 col-xs-12 pull-right mobPadding noMob-leftBorder mob-bottomBorder">
                    <a href="{{route('admin.orders.createOrder')}}" target="_blank" class="btn btn-default pull-right col-md-12 fullMobile-width">Create New Order</a>

                    <div class="clearfix" style="margin-bottom:15px;"></div>
                    <a class="btn btn-primary" href="{{ asset(Config('constants.BulkOrderUploadPath')). "/cartini_orderBulk_upload.csv"}}"style="margin-bottom:15px; margin-left: 0; width: 100%;">Download Sample</a>
                    <div class="clearfix"></div>
                    <form action="{{route('admin.traits.orders')}}"  method="post" enctype="multipart/form-data">
                        <div class=""> 
                            <input type="file" class="form-control validate[required] fileUploder" name="order_file" placeholder="Browse CSV file"  required style="margin-bottom:15px; "  onChange="validateFile(this.value)"/>
                        </div>
                        <div class="">
                            <input type="submit" class="btn sbtn btn-primary submitBulkUpload" value="Bulk Order Upload"  style="margin-left: 0; margin-bottom:15px; width: 100%; "/>
                        </div>
                    </form>
                    <div class="clearfix" style="margin-bottom:15px;"></div>
                    <a href="{{route('admin.orders.export')}}"  class="btn btn-default pull-right col-md-12 fullMobile-width">Export All Order</a>

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
                                <th>@sortablelink ('id', 'Order Id')</th>
                                <th>Date</th>
                                <th>Name</th>
<!--                                <th>Email ID</th>-->
                                <th>Mobile</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
<!--                                <th>Payment Method</th>-->
                                <th>@sortablelink ('pay_amt', 'Amount') <?php //echo!empty(Session::get('currency_symbol')) ? '('.Session::get('currency_symbol').')' : '';  ?></th>
                                <th>Order Source</th>
<!--                                <th>Courier</th>
                               <th>Tracking no.</th>
                               <th>Shipping date</th>-->

<!--                                <th>Invoice Printed?</th>-->
                                @if($feature['flag'] == 1)  
                                <th>Flag</th>
<!--                                <th>Flag Comment</th>-->
                                @endif
                                @if($feature['courier-services'] == 1)  
<!--                                <th>Courier Service</th>-->
                                @endif
                                <th width="6%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($orders) >0 )
                            @foreach($orders as $order)
                            <tr>
                                <td><input type="checkbox" name="orderId[]" class="checkOrderId" value="{{ $order->id }}" /></td>
                                <td><a href="{!! route('admin.orders.edit',['id'=>$order->id]) !!}">{{$order->id }}</a></td>
                                <td>{{ date('d-M-Y',strtotime($order->created_at)) }}</td>

                                <td>{{ @$order->users->firstname }} {{ @$order->users->lastname }} </td>
<!--                                <td>{{ @$order->users->email }}  </td>-->
                                <td>{{ @$order->users->telephone }}</td>
                                <td>{{ @$order->orderstatus['order_status']  }}</td>
                                <td>{{ @$order->paymentstatus['payment_status'] }}</td>
<!--                                <td>{{ @$order->paymentmethod['name'] }}</td>-->
                                <td>@if(@$order->prefix)<span class="currency-sym"></span> {{ number_format((@$order->pay_amt  * Session::get('currency_val')), 2) }}
                                    @else 
                                    <span class="currency-sym"></span> {{ number_format((@$order->hasPayamt  * Session::get('currency_val')), 2) }}
                                    @endif
                                </td>
                                <td>@if(@$order->order_source==1)
                                    Mall 
                                    @elseif(@$order->order_source==2)
                                    {{ Session::get("storeName")}}
                                    @endif
                                </td>
                               <!--                                <td><?php
//                                    if ($order->courier == 1) {
//                                        echo "Fedex";
//                                    } else if ($order->courier == 2) {
//                                        echo "Delhivery";
//                                    } else if ($order->courier == 3) {
//                                        if (!empty($order->courier_service_name)) {
//                                            $serviceN = "[" . $order->courier_service_name . "]";
//                                        }
//                                        echo "Other" . @$serviceN;
//                                    }
                                ?></td>
                               
                                                               <td>{{ @$order->shiplabel_tracking_id }}</td>
                               
                                                               <td>{{ !empty($order->ship_date != 00-00-00)?date('d M y',strtotime($order->ship_date)):'' }}</td>-->


<!--                                <td>{{ ($order->print_invoice == 0)?"No":"Yes" }}</td>-->
                                @if($feature['flag'] == 1)  
                                <td>
                                    <div id="flagD{{$order->id }}" class="flagD">   
                                        <div class="flagDName" id="flagDName{{$order->id }}">
                                            <div style='width: 20px;height: 20px;background:{{ @$order->orderFlag->value }} ; border-radius: 50%'></div>
                                            <br/>{{  (strpos(@$order->orderFlag->flag, 'No Flag') !== false)?"":@$order->orderFlag->flag}} <br> {{  $order->flag_remark}}
                                        </div>
                                    </div>
                                </td>
<!--                                 <td>
                                    <div class="flagC{{$order->id }}" id="flagC{{$order->id }}"> 
                                        <div class="flagDC{{$order->id }}" id="flagDC{{$order->id }}">
                                            {{  $order->flag_remark}}
                                        </div>
                                    </div>
                                </td>-->
                                @endif
                                @if($feature['courier-services'] == 1)  
<!--                                   <td>{{ ($order->courier != 0)?$order->getcourier['name']:'-' }}</td>-->
                                @endif
                                <td>
                                    <!--                                    <a href="{!! route('admin.orders.editReOrder',['id'=>$order->id]) !!}"  class="label label-success active ereorder" ui-toggle-class="">Edit / Update Order</a>-->
                                    <a href="{!! route('admin.orders.edit',['id'=>$order->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw btnNo-margn-padd"></i></a>
                                    <a href="#" data-ordId ="{{$order->id}}"  class="flage"  ui-toggle-class="" data-toggle="tooltip" title="Flag"><i class="fa fa-flag-o btn-plen"></i></a>
                                    <a href="{!! route('admin.orders.delete',['id'=>$order->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this order?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash "></i></a>
                                    <a href="{!! route('admin.orders.waybill',['id'=>$order->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="waybill"><i class="fa fa-barcode fa-fw btnNo-margn-padd"></i></a>
                       <!--                                    <a href="{!! route('admin.orders.orderHistory') !!}?id={{$order->id}}" target="_blank" class="viewHistory"><span class="label label-info label-mini">History</span></a>-->

   <!--  <a href="#" data-ordId ="{{ $order->id }}"  class="" ui-toggle-class="" data-toggle="tooltip" title="History"><i class="fa fa-history"></i></a> -->
                                    <!--                                    <a href="{!! route('admin.orders.ReturnOrder',['id'=>$order->id]) !!}"  class="label label-success active" ui-toggle-class="">Return Order</a>-->

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=14> No Record Found.</td></tr>
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
