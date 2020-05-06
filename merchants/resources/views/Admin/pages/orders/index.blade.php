@extends('Admin.layouts.default')

@section('mystyles')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.css' }}"> 
@stop

@section('content')
<section class="content-header">
    <h1>
        All Orders 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Sales</a></li>
        <li class="active">All Orders</li>
    </ol>
</section>

<section class="main-content">

    <div class="notification-column">           
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
    </div>

    <div class="col-md-9 noLeft-padding">
    <div class="grid-content" data-match-height="groupName">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section equal-height-div-1">
                <div class="filter-left-section">
                    {!! Form::open(['method' => 'get', 'route' => 'admin.orders.view' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                            {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Search for Order Id"]) !!}
                        </div>                        
                    </div>
                    <div class="form-group col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'noun_user.svg'}}"></span>                        
                        {!! Form::text('search',Input::get('search'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Search for Name, Email or Mobile Number"]) !!}
                        </div>
                    </div>

                    @if($order_status->count())
                    @php echo Input::get('searchStatus[]'); @endphp
                    <div class="btn-group form-group col-md-4 col-xs-12">
                        <select name='searchStatus[]' class="multiselect form-control" multiple="multiple">
                            @php echo $order_options @endphp
                        </select>
                    </div>
                    @endif
                    @if($feature['flag'])
                    <div class="btn-group col-md-4 col-xs-12 mob-marBottom15">
                        <select name='searchFlag' class="form-control">
                            <option  value="">Select Flag</option>
                            @foreach($flags as $flag)
                            <option  value="{{$flag->id }}"  <?php echo (Input::get('searchFlag') == $flag->id) ? "selected" : '' ?> >{{$flag->flag }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group col-md-4">

                        <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'calendar.svg'}}"></span>
                             {!! Form::text('date',Input::get('date'), ["class"=>'form-control-no-border-radius darkPlaceholder', "placeholder"=>"Order Date"]) !!}
                            <span class="input-group-addon date"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'arrow_drop_down.png'}}" class="autoWidth"></span>
                        </div> 
                    </div>
                    <span id="advanced-filter"> 
                        <div class="form-group col-md-3"> 
                            {!! Form::text('order_number_from',Input::get('order_number_from'), ["class"=>'form-control form-control-border-radius', "placeholder"=>"Order No. From"]) !!} 
                        </div>
                        <div class="form-group col-md-3"> 
                            {!! Form::text('order_number_to',Input::get('order_number_to'), ["class"=>'form-control form-control-border-radius', "placeholder"=>"Order No. To"]) !!} 
                        </div> 
                        <div class="form-group col-md-3"> 
                            {!! Form::text('pricemin',Input::get('pricemin'), ["class"=>'form-control form-control-border-radius', "placeholder"=>"Minimum Amount"]) !!} 
                        </div>
                        <div class="form-group col-md-3"> 
                            {!! Form::text('pricemax',Input::get('pricemax'), ["class"=>'form-control form-control-border-radius', "placeholder"=>"Maximum Amount"]) !!} 
                        </div>  
                    </span>
                    <span id="dots"></span><div class="clearfix"></div> 
                    <div class="form-group col-md-6 noBottomMargin">
                        <span onclick="myFunction()" id="advanced-filter-Btn"><i class="fa fa-caret-down" aria-hidden="true"></i> Advanced Filters</span>
                    </div>
                    <div class="form-group col-md-6 noBottomMargin"> 
                        <a href="{{route('admin.orders.view')}}"><button type="button" class="btn reset-btn noMob-leftmargin pull-right mn-w120">Reset</button></a> 
                        <button type="submit" class="btn btn-primary noAll-margin pull-right marginRight-sm mn-w120"> Filter</button> 
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 noRight-padding">
    <div class="grid-content" data-match-height="groupName">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'transfer-2.svg'}}"> Import & Export</h1>
        </div>
        <div class="filter-section equal-height-div-2">
                <div class="filter-right-section"> 
                    <div class="form-group">
                    <a class="btn btn-default fullWidth noAll-margin" href="{{route('admin.orders.sampleexport')}}">Download Sample</a>
                    </div>
                    <div class="form-group">
                     <a href="{{route('admin.orders.export')}}"  class="btn btn-default noAll-margin fullWidth">Export All Order</a>
                    </div> 
                    <form action="{{route('admin.traits.orders')}}"  method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="input-group file-upload-column">
                                <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'up-arrow.svg'}}"></span>
                                <div class="file-upload-wrapper" data-text="Upload Import File">
                                    <input type="file" class="validate[required] fileUploder fullWidth form-control form-control-right-border-radius file-upload-field" name="order_file" placeholder="Upload Import File"  required onChange="validateFile(this.value)"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group noAll-margin">
                            <input type="submit" class="btn sbtn btn-secondary submitBulkUpload fullWidth noAll-margin" value="Import from File"/>
                        </div>
                    </form>  

                </div>
            </div>

        </div>
    </div>


    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> All Orders
			<?php
                if($ordersCount > 0)
                {
                ?>
                    <span class="listing-counter"> {{$startIndex}}-{{$endIndex}} of  {{$ordersCount }}</span>
                <?php
                }
                ?>  
			
            </h1>
            <a href="{{route('admin.orders.createOrder')}}" target="_blank" class="btn btn-listing-heading pull-right noAll-margin"> <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'plus.svg'}}"> Create </a>   
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <label class="custom-checkbox">
                                   <input type="checkbox" id="checkAll" />
                                  <span class="checkmark"></span>
                                </label>

                              <form action="" class="formMul" method="post" >
                                <input type="hidden" value="" name="OrderIds" />
                                <span class="dropdown">
                                  <button class="checkbox-dropdown dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> 
                                  <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                  </button>
                                  <ul name="orderAction" id="orderAction" class="dropdown-menu bulk-action-dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li role="presentation" class="dropdown-header">Select Bulk Action</li>
                                    <li id="1"><input type="radio" id="1" name="Bulk Action" value="1">
                                        <label for="1">Print Invoice</label> 
                                    </li>
                                    <li id="3"><input type="radio" id="3" name="Bulk Action" value="3">
                                        <label for="3">Export</label> 
                                    </li> 
                                    @if($feature['flag'] == 1) 
                                    <li id="30"><input type="radio" id="30" name="Bulk Action" value="30">
                                        <label for="30">Flag</label> 
                                    </li> 
                                     @endif
                                    <li role="presentation" class="dropdown-header"> Courier Services </li>
                                    <li id="31"><input type="radio" id="31" name="Bulk Action" value="31">
                                        <label for="31">E-courier</label> 
                                    </li>  
                                    <li role="presentation" class="dropdown-header"> Update Order Status </li>
                                     <li id="8"><input type="radio" id="8" name="Bulk Action" value="8">
                                        <label for="8">Cancelled</label> 
                                    </li>
                                     <li id="12"><input type="radio" id="12" name="Bulk Action" value="12">
                                        <label for="12">Delayed</label> 
                                    </li>
                                     <li id="6"><input type="radio" id="6" name="Bulk Action" value="6">
                                        <label for="6">Delivered</label> 
                                    </li>
                                     <li id="9"><input type="radio" id="9" name="Bulk Action" value="9">
                                        <label for="9">Exchanged</label> 
                                    </li>
                                     <li id="10"><input type="radio" id="10" name="Bulk Action" value="10">
                                        <label for="10">Returned</label> 
                                    </li> 
                                     <li id="20"><input type="radio" id="20" name="Bulk Action" value="20">
                                        <label for="20">Partially Shipped</label> 
                                    </li> 
                                     <li id="4"><input type="radio" id="4" name="Bulk Action" value="4">
                                        <label for="4">Processing</label> 
                                    </li> 
                                     <li id="21"><input type="radio" id="21" name="Bulk Action" value="21">
                                        <label for="21">Refunded</label> 
                                    </li> 
                                     <li id="5"><input type="radio" id="5" name="Bulk Action" value="5">
                                        <label for="5">Shipped</label> 
                                    </li> 
                                     <li id="11"><input type="radio"  name="Bulk Action" value="11">
                                        <label for="11">Undelivered</label> 
                                    </li>   
                                    <li role="presentation" class="dropdown-header"> Update Payment Status </li>
                                    <li id="13"><input type="radio" id="13" name="Bulk Action" value="13">
                                        <label for="13">Pending</label> 
                                    </li>
                                     <li id="14"><input type="radio" id="14" name="Bulk Action" value="14">
                                        <label for="14">Cancelled</label> 
                                    </li>
                                     <li id="15"><input type="radio" id="15" name="Bulk Action" value="15">
                                        <label for="15">Partially Paid</label> 
                                    </li>
                                     <li id="16"><input type="radio" id="16" name="Bulk Action" value="16">
                                        <label for="16">Paid</label> 
                                    </li> 
                                  </ul>
                                </span>  
                            </form>

                            </th>
                            <th class="text-right">@sortablelink ('id', 'Order Id')</th>
                            <th class="text-right">Order Date</th> 
                            <th class="text-left">Customer Name</th>
                            <th class="text-center">Order Status</th>
                            <th class="text-center">Payment Status</th>
                            <th class="text-right">@sortablelink ('pay_amt', 'Amount (INR)')</th>
                            <!-- <th class="text-right">Paid Amount</th>  -->
                            @if($feature['courier-services'] == 1)
                            <!-- <th>Courier Service</th>-->
                            @endif
                            <th class="text-center mn-w100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($orders) >0 )
                        @foreach($orders as $order)
                     
                        <tr>
                            <td class="text-center">
                                <!-- <input type="checkbox" name="orderId[]" class="checkOrderId" value="{{ $order->id }}" /> -->

                                <label class="custom-checkbox">
                                  <input type="checkbox" name="orderId[]" class="checkOrderId" value="{{ $order->id }}" />
                                  <span class="checkmark"></span>
                                </label>

                            </td>
                            <td class="text-right"><a href="{!! route('admin.orders.edit',['id'=>$order->id]) !!}">{{$order->id }}</a></td>
                            <td class="text-right">{{ date('d-M-Y',strtotime($order->created_at)) }}
                                <div class="clearfix"></div>
                                <span class="list-light-color list-small-font">10:53:12 AM</span>
                            </td>
                            <td class="text-left"><a href="{!! route('admin.orders.edit',['id'=>$order->id]) !!}">
                                @if(@$order->users->firstname !='' ){{ @$order->users->firstname }} {{ @$order->users->lastname }} 
                                @elseif(@$order->first_name !='')
                                {{ @$order->first_name }} {{ @$order->last_name }} 
                                @else 
                                -
                                @endif
                            </a><div class="clearfix"></div>
                                <span class="list-light-color list-small-font">{{ @$order->users->telephone }}</span>
                            </td> 
<td class="text-center"><span class="alertWarning" style="background-color: {{@$order->orderstatus['color']}}">{{ @$order->orderstatus['order_status']  }}</span></td>
                            <td class="text-center"><span class="alertWarning">{{ @$order->paymentstatus['payment_status'] }}</span></td>
                            <td class="text-right">@if(@$order->prefix)
                                <!-- <span class="currency-sym"></span> --> <span class="list-dark-color">{{ number_format((@$order->pay_amt  * Session::get('currency_val')), 2) }}</span>
                                @else
                                <!-- <span class="currency-sym"></span> --> <span class="list-dark-color">{{ number_format((@$order->hasPayamt  * Session::get('currency_val')), 2) }}</span>
                                @endif
                            </td>
                            <!-- <td class="text-right">
                                @if(@$order->prefix)
                                <span class="currency-sym"></span> {{ number_format((@$order->amt_paid  * Session::get('currency_val')), 2) }}
                                @endif
                            </td>
                            <td>@if(@$order->order_source==1)
                                Mall
                                @elseif(@$order->order_source==2)
                                {{ Session::get("storeName")}}
                                @endif
                            </td>
                         
                            @if($feature['flag'] == 1)
                            <td>
                                <div id="flagD{{$order->id }}" class="flagD">
                                    <div class="flagDName" id="flagDName{{$order->id }}">
                                        <div style='width: 20px;height: 20px;background:{{ @$order->orderFlag->value }} ; border-radius: 50%'></div>
                                        <br/>{{  (strpos(@$order->orderFlag->flag, 'No Flag') !== false)?"":@$order->orderFlag->flag}} <br> {{  $order->flag_remark}}
                                    </div>
                                </div>
                            </td> -->

                            @endif
                            @if($feature['courier-services'] == 1)
<!--                                   <td>{{ ($order->courier != 0)?$order->getcourier['name']:'-' }}</td>-->
                            @endif
                            <td class="text-center mn-w100">  
                            <div class="actionCenter">
                                <span><a class="btn-action-default" href="{!! route('admin.orders.edit',['id'=>$order->id]) !!}"> <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                                <span class="dropdown">
                                    <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                        <li><a href="#" data-ordId ="{{$order->id}}"  class="flage"><i class="fa fa-flag-o btn-plen"></i> Flag</a></li>
                                        <li><a data-orderId="{{$order->id}}" class="add-payment"><i class="fa fa-money" ></i> Add Payment</a></li>
                                        <li><a href="{!! route('admin.orders.delete',['id'=>$order->id]) !!}"><i class="fa fa-trash "></i> Delete</a></li>
                                    </ul>
                                </span>  
                            </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td class="text-center" colspan="8"> No Record Found.</td></tr>
                        @endif
                    </tbody>
                </table>
                <div class="clearfix">
                    <?php
echo $orders->appends(Input::except('page'))->render();
?>
                    <?php //}
?>
                </div>
            </div>
        </div>
    </div>
</section>

 <div class="clearfix"></div>

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
<div class="modal fade" id="add-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Payment for order ID: <span class="payment-order-id"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label"><b>Pending Amount:</b> <span class="currency-sym"></span><span class="remaining-amt"></span></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 payment-msg">
                    </div>
                </div>
                <div class="clear-fix"></div>
                <div class="row brbottom1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter amount" name="pay_amt" value="" required />
                            <input type="hidden" name="remaining_amt" required/>
                            <input type="hidden" name="order_id" required/>
                        </div>
                    </div>
                    <div class="col-md-6"><button class="btn btn-primary add-new-payment">Submit</button></div>
                </div>
                <div class="clear-fix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th class="text-right">Amount Paid</th>
                                    </tr>
                                </thead>
                                <tbody class="payment-details"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 
@stop
@section('myscripts')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.js' }}"></script>
<script>
$(document).ready(function() {

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
    $(".ereorder").click(function() {
        var r = confirm("Edit order will cancel the current order and create new order.\nAre you sure you want to continue?");
        if (r == false) {
            return false;
        }
    });

    $('#checkAll').click(function(event) {
        var checkbox = $(this),
            isChecked = checkbox.is(':checked');
        if (isChecked) {
            $('.checkOrderId').attr('Checked', 'Checked');
        } else {
            $('.checkOrderId').removeAttr('Checked');
        }
    });
    $('#searchForm input').keydown(function(e) {
        if (e.keyCode == 13) {
            $('#SForm').submit();
        }
    });

    $("#orderAction li").click(function() {
   // $("select#orderAction").change(function() {
        var ids = $(".orderTable input.checkOrderId:checkbox:checked").map(function() {
            return $(this).val();
        }).toArray();
        if (ids.length == 0) {
            alert('Error! No Order Selected! Please Select Order first.');
            $(this).val('');
            return false;
        }
        $("input[name='OrderIds']").val(ids);
        if (this.id == 1) {
            chkInvoice = confirm("Are you sure you want to continue (yes/no)?");
            if (chkInvoice == true) {

                $(this).parent().attr("action", "{{ route('admin.orders.invoice') }}");
                $(this).parent().attr("target", "_blank");
            } else {
                return false;
            }
        }
        if (this.id == 17) {
            chkshipRocket = confirm("Are you sure you want to continue (yes/no)?");
            if (chkshipRocket == true) {
                $(this).parent().attr("action", "");
            } else {
                return false;
            }
        } else if (this.id == 2) {
            chkWaybill = confirm("Are you sure you want to continue (yes/no)?");
            if (chkWaybill == true) {
                $(this).parent().attr("action", "");
            } else {
                return false;
            }
        } else if (this.id == 3) {
            expChk = confirm("Are you sure you want to continue (yes/no)?");
            if (expChk == true) {
                $(this).parent().attr("action", "{{ route('admin.orders.export') }}");
            } else {
                return false;
            }
        } else if (this.id == 25) {
            expChk = confirm("Are you sure you want to continue (yes/no)?");
            if (expChk == true) {
                $(this).parent().attr("action", "");
            } else {
                return false;
            }
        } else if (this.id == 4) {
            chkOrderStatus1 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus1 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(1);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
            } else {
                return false;
            }
        } else if (this.id == 5) {
            chkOrderStatus2 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus2 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(2);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
            } else {
                return false;
            }
        } else if (this.id == 6) {
            chkOrderStatus3 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus3 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(3);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
            } else {
                return false;
            }
        } else if (this.id == 8) {
            chkOrderStatus42 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus42 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(4);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
                // $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=4");
            } else {
                return false;
            }
        } else if (this.id == 9) {
            chkOrderStatus5 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus5 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(5);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                }); //
                //  $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=5");
            } else {
                return false;
            }
        } else if (this.id == 10) {
            chkOrderStatus6 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus6 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(6);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
                //   $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=6");
            } else {
                return false;
            }
        } else if (this.id == 11) {
            chkOrderStatus7 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus7 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(7);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
                //    $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=7");
            } else {
                return false;
            }

        } else if (this.id == 12) {
            chkOrderStatus8 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus8 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(8);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
                //   $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=8");
            } else {
                return false;
            }

        } else if (this.id == 20) {
            chkOrderStatus9 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus9 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(9);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
                //  $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=9");
            } else {
                return false;
            }
        } else if (this.id == 21) {
            chkOrderStatus10 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkOrderStatus10 == true) {
                $(".formMul").removeAttr("target");
                $("#mulModal").modal('show');
                $(".saveMulChanges").click(function() {
                    $(".OdStatus").val(10);
                    $("#mulForm").submit();
                    $("#mulModal").modal('hide');
                });
                // $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=10");
            } else {
                return false;
            }

        } else if (this.id == 13) {
            chkPaymentStatus1 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkPaymentStatus1 == true) {
                $(this).parent().attr("action", "{{ route('admin.orders.update.payment') }}?status=1");
            } else {
                return false;
            }
        } else if (this.id == 14) {
            chkPaymentStatus2 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkPaymentStatus2 == true) {
                $(this).parent().attr("action", "{{ route('admin.orders.update.payment') }}?status=2");
            } else {
                return false;
            }
        } else if (this.id == 15) {
            chkPaymentStatus3 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkPaymentStatus3 == true) {
                $(this).parent().attr("action", "{{ route('admin.orders.update.payment') }}?status=3");
            } else {
                return false;
            }
        } else if (this.id == 16) {
            chkPaymentStatus4 = confirm("Are you sure you want to continue (yes/no)?");
            if (chkPaymentStatus4 == true) {
                $(this).parent().attr("action", "{{ route('admin.orders.update.payment') }}?status=4");
            } else {
                return false;
            }
        } else if (this.id == 30) {
            chkFlag = confirm("Are you sure you want to continue (yes/no)?");
            if (chkFlag == true) {
                $(".formMul").removeAttr("target");
                $("#flagForm")[0].reset();
                $("#flagBox").modal('show');
                console.log(ids + "Order Ids");
                $(".saveFlag").click(function() {
                    $(".OdID").val(ids);
                    $("#flagForm").attr('action', "{{ route('admin.orders.addMulFlag') }}");
                    $("#flagForm").submit();
                    $("#flagBox").modal('hide');
                });
                //  $(this).parent().attr("action", "{{ route('admin.orders.update') }}?status=9");
            } else {
                return false;
            }
        } else if (this.id == "") {
            window.location.href = "{{route('admin.orders.view')}}";
            // location.reload();
        } else if (this.id == 31) {
            checkConfirm = confirm("Are you sure you want to continue (yes/no)?");
            if (checkConfirm) {
                $(this).parent().attr("action", "{{route('admin.orders.getECourier')}}");
                $(this).parent().submit();
            } else {
                return false;
            }

        }
        var Thisval = this.id;
        if (ids.length > 0) {
            if (Thisval != 4 && Thisval != 5 && Thisval != 6 && Thisval != 8 && Thisval != 9 && Thisval != 10 && Thisval != 11 && Thisval != 12 && Thisval != 20 && Thisval != 21 && Thisval != 30 && Thisval != 31) {
                $(this).parent().submit();
            }
        }
    });

    /* Flag add*/
    $(".getFlag").click(function() {
        var orderid = $(this).attr('data-ordId');
        $(".selFlag").val("");
        $(".flagComment").val("");
        $(".OdID").val(orderid);
        $("#flagBox").modal('show');
    });
    $(".saveFlag").click(function() {
        var ordid = $(".OdID").val();
        if ($(".selFlag").val() !== "") {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.addFlag') }}",
                data: $("#flagForm").serialize(),
                cache: false,
                success: function(response) {
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
    $(".flage").click(function() {
        $("#flagBox").modal('show');
        var ids = $(this).attr('data-ordId');
        console.log(ids);
        $(".OdID").val(ids);
        $(".saveFlag").click(function() {
            $("#flagForm").attr('action', "{{ route('admin.orders.addMulFlag') }}");
            //$("#flagForm").submit(); alert("hjh");
            $("#flagBox").modal('hide');
            });
    });

    //Add Payment
    $('.add-payment').click(function() {
        var orderId = $(this).attr('data-orderId');
        console.log(orderId);
        $('span.payment-order-id').html(orderId);
        //Get order payments
        $('tbody.payment-details').html('');
        $.post("{{ route('admin.orders.getPayments') }}", {orderId: orderId}, function (res) {
            if(res.status) {
                $('tbody.payment-details').html(res.payments);
                $('input[name=remaining_amt]').val(res.remainingAmt);
                $('input[name=order_id]').val(orderId);
                $('.remaining-amt').text(res.remainingAmt);
                $('#add-payment').modal('show');
            }
        });
    });
    $('input[name=pay_amt]').blur(function(){
        var payAmt = parseInt($('input[name=pay_amt]').val());
        var remainingAmt = parseInt($('input[name=remaining_amt]').val());
        var orderId = parseInt($('input[name=order_id]').val());
        if(payAmt > remainingAmt){
            alert('Amount can not be greater than total payable amount!');
            $('input[name=pay_amt]').val('');
        }
    });
    var paymentAdded = 0;
    $('.add-new-payment').click(function () {
        var payAmt = parseInt($('input[name=pay_amt]').val());
        var remainingAmt = parseInt($('input[name=remaining_amt]').val());
        var orderId = parseInt($('input[name=order_id]').val());
        if(payAmt > remainingAmt){
            alert('Amount can not be greater than total payable amount!');
        } else {
            $.post("{{ route('admin.orders.addNewOrderPayment') }}", {orderId: orderId, payAmt: payAmt}, function (res) {
                if(res.status) {
                    paymentAdded = 1;
                    $('.payment-msg').addClass('brbottom1').html('<div class="success">' + res.msg + '</div>');
                    $.post("{{ route('admin.orders.getPayments') }}", {orderId: orderId}, function (res) {
                    if(res.status) {
                        $('input[name=pay_amt]').val('');
                        $('tbody.payment-details').html(res.payments);
                        $('input[name=remaining_amt]').val(res.remainingAmt);
                        $('input[name=order_id]').val(orderId);
                        $('.remaining-amt').text(res.remainingAmt);
                        // $('#add-payment').modal('show');
                    }
                });
                } else {
                    $('.payment-msg').html('<div class="error">' + res.msg + '</div>');
                }
            });
        }
    });
    $("#add-payment").on("hidden.bs.modal", function () {
        if(paymentAdded) {
            paymentAdded = 0;
            window.location.reload();
        }
    });

});


$(window).load(function() {
    setTimeout(function() {
        $('#checkAll').show();
    }, 1000);
});


</script>

@stop
