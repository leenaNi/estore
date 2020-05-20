@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<style type="text/css">.capitalizeText select {
        text-transform: capitalize;
    } 
    select.form-control{ padding: 7px!important;}.fnt14{font-size: 14px;text-transform: capitalize !important;}</style>
@stop

@section('content')
<section class="content-header">
    <h1>
        Customers ({{$customerCount }})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Customers</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div  class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div  class="alert alert-success" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
                @if(!empty(Session::get('updatesuccess')))
                <div  class="alert alert-success" role="alert">
                    {{ Session::get('updatesuccess') }}
                </div>
                @endif
                <div class="box-header noBorder box-tools filter-box col-md-9">

                    <form action="{{ route('admin.customers.view') }}" method="get" >
                        <div class="form-group col-md-4">
                            <input type="text" name="custSearch" value="{{ !empty(Input::get('custSearch')) ? Input::get('custSearch') : '' }}" class="form-control input-sm pull-right fnt14" placeholder="Customer/Email/Contact">
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input-group date Nform_date" id="datepickerDemo">
                                <input placeholder="Created Date" type="text" id="" name="daterangepicker" value="{{ !empty(Input::get('daterangepicker')) ? Input::get('daterangepicker') : '' }}" class="form-control datefromto textInput">

                                <span class="input-group-addon">
                                    <i class=" ion ion-calendar"></i>
                                </span>
                            </div>
                        </div>

                        @if($setting->status ==1)
                        <div class="form-group col-md-4 capitalizeText">

                            {{ Form::select('loyalty', array_map('ucfirst', $loyalty), @Input::get('loyalty'), ['class' => 'form-control input sm']) }}
                        </div>
                        @endif
                        <div class="clearfix"></div>
                        <div class="form-group col-md-4">
                            {{ Form::select('status', ['' => 'Select Status','1' => 'Enabled', '0'=>'Disabled'], Input::get('status'), ['class' => 'form-control input sm']) }}
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group col-md-2">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="Search" style="margin-left:0px">
                        </div>
                        <div class="form-group col-md-2">
                            <a  href="{{route('admin.customers.view')}}" class="form-control medium btn reset-btn" style="margin-left:0px">Reset</a>
                        </div>
                    </form>


                </div>
                <div class="box-header col-md-3">
                    <a href="{!! route('admin.customers.add') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN"  type="button">Add New User</a>
                </div> 
                <div class="box-header col-md-3">
                    <a href="{!! route('admin.customers.export') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" target="_" type="button">Export</a>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <!--                                <th>id</th>-->
                                <th>Name</th>
                                <!--                                <th>Last Name</th>-->
                                <th>Email Id</th>
                                <th>Mobile</th>
                                <th>Date Created</th>
                                @if($setting->status ==1)
                                <th>Loyalty Group</th>
                                <th>Loyalty Point</th>
                                @endif
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($customers) >0 )
                            @foreach($customers as $customer)
                            <tr> 
                              <!--                            <td>{{$customer->id }}</td>-->
                                <td>{{$customer->firstname }} {{$customer->lastname }}</td>

                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->telephone }}</td>
                                <td>{{ date("d-M-Y",strtotime($customer->created_at)) }}</td>

                                @if($setting->status ==1)
                                <?php 
                                    $group=@$customer->userCashback->loyalty_group?@$customer->userCashback->loyalty_group:0;
                                ?>         
                                <td>{{ isset($group)?ucfirst(strtolower(@$loyalty["$group"])):'' }}</td>
                                <td><span class="currency-sym"> </span> {{ number_format((@$customer->userCashback->cashback * Session::get('currency_val')), 2) }}</td>
                                @endif
                                <td>@if($customer->status==1)
                                    <a href="{!! route('admin.customers.changeStatus',['id'=>$customer->id]) !!}"  onclick="return confirm('Are you sure you want to disable this customer?')" data-toggle='tooltip' title='Enabled' ><i class="fa fa-check btn-plen btn btnNo-margn-padd"></i></a>
                                    @elseif($customer->status==0)
                                    <a href="{!! route('admin.customers.changeStatus',['id'=>$customer->id]) !!}"  onclick="return confirm('Are you sure you want to enable this customer?')" data-toggle="tooltip" title="Disabled"> <i class="fa fa-times btn-plen btn btnNo-margn-padd"></i></a>
                                    @endif
                                </td>
                                <td>

                                    <a href="{!! route('admin.customers.edit',['id'=>$customer->id]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn-plen btn btnNo-margn-padd" ></i></a>               
                                    <a href="{!! route('admin.customers.delete',['id'=>$customer->id]) !!}" onclick="return confirm('Are you sure you want to delete this customer?')" class="" ui-toggle-class="" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash btn-plen btn"></i></a>
                                    <a href="{!! route('admin.orders.view',['search'=> $customer->firstname.' '.$customer->lastname]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="View Order"> <i class="fa fa-eye btn-plen btn"></i></a>

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=8> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php
                    if (empty(Input::get('custSearch'))) {
                        echo $customers->render();
                    }
                    ?> 

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>

@stop

@section('myscripts')
<script src="{{ asset('public/Admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
                                        $(function () {

                                            var start = moment().subtract(29, 'days');
                                            var end = moment();

                                            // function cb(start, end) {
                                            //      $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                                            // }

                                            $('.datefromto').daterangepicker({
                                                startDate: start,
                                                endDate: end,
                                                ranges: {
                                                    'Today': [moment(), moment()],
                                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                                }
                                            }, function () {
                                            });

                                            //cb(start, end);
                                            $('.datefromto').on('apply.daterangepicker', function (ev, picker) {
                                                $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
                                            });

                                            $('.datefromto').on('cancel.daterangepicker', function (ev, picker) {
                                                $(this).val('');
                                            });
                                        });
</script>
@stop 