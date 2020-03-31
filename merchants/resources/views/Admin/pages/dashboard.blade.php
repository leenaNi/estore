@extends('Admin.layouts.default')
@section('content')
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/daterangepicker/daterangepicker-bs3.css' }}">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard

    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Dashboard </li>
    </ol>
</section>
<!-- Main content -->
<section>
    <div class="panel-body">   
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Today Orders</span>
                        <span class="info-box-number">{{ number_format($todaysOrders) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Orders  This Week</span>
                        <span class="info-box-number">{{ number_format($weeklyOrders) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Orders This Month</span>
                        <span class="info-box-number">{{ number_format($monthlyOrders) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Orders This Year</span>
                        <span class="info-box-number">{{ number_format($yearlyOrders) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';         ?><span class="currency-sym"></span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales Today</span>
                        <span class="info-box-number">{{ number_format($todaysSales * Session::get('currency_val')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';         ?><span class="currency-sym"></span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales This Week</span>
                        <span class="info-box-number ">{{ number_format($weeklySales * Session::get('currency_val')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';         ?><span class="currency-sym"></span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales This Month</span>
                        <span class="info-box-number">{{ number_format($monthlySales * Session::get('currency_val')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';         ?><span class="currency-sym"></span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales This Year</span>
                        <span class="info-box-number">{{ number_format($yearlySales  * Session::get('currency_val')) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Customers</span>
                        <span class="info-box-number">{{ number_format($userCount) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Customers This Week</span>
                        <span class="info-box-number">{{ number_format($userThisWeekCount) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Customers This Month</span>
                        <span class="info-box-number">{{ number_format($userThisMonthCount) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Customers This Year</span>
                        <span class="info-box-number">{{ number_format($userThisYearCount) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 marginBottom20">
                <div class="box box-info" >
                    <div class="box-header dashbox-header with-border bg-aqua">
                        <h3 class="box-title dashbox-title">Latest Orders</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Order Status</th>
                                        <th>Payment Status</th>
                                        <th>Payment Method</th>
                                        <th>Order Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestOrders as $order)
                                    <tr>
                                        <td>{{ @$order["order_id"] }}</td>
                                        <td>{{ ucfirst(@$order["first_name"]) }} {{ @$order["last_name"] }} </td>
                                        <td>{{ @$order["phone_no"] }}</td>
                                        <td>{{ @$order["order_status"] }}</td>  
                                        <td>{{ @$order["payment_status"] }}</td>
                                        <td>{{ @$order["payment_method"] }}</td>
                                        <td><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';         ?><span class="currency-sym"></span> {{ @$order["total_amount"] }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--                <div class="box-footer clearfix">
                                        <a href="{{route('admin.orders.view')}}" class="btn btn-sm btn-warning btn-flat pull-right">View All Orders</a>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 marginBottom20">
                                <div class="box box-success" >
                                    <div class="box-header dashbox-header with-border bg-green">
                                        <h3 class="box-title dashbox-title">Top Selling Products</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table no-margin">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th></th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($topProducts as $product)

                                                    <tr>
                                                        <td><img src="{{@$product->product->prodImage}}" class="admin-profile-picture" /></td>
                                                        <td>{{@$product->product->product}}</td>
                                                        <td><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';         ?><span class="currency-sym"></span> {{number_format((@$product->product->selling_price  * Session::get('currency_val')), 2, '.', '')}}</td>
                                                        <td>{{@$product->quantity}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                    <!--                <div class="box-footer clearfix">
                                        <a href="{{route('admin.sales.byproduct')}}" class="btn btn-sm btn-success btn-flat pull-right">View All Products</a>
                                    </div>-->
                                </div>
                            </div>
                            <div class="col-md-6 marginBottom20">
                                <div class="box box-warning" >
                                    <div class="box-header dashbox-header with-border bg-yellow">
                                        <h3 class="box-title dashbox-title">Top Customers</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table no-margin">
                                                <thead>
                                                    <tr>
                                                        <!--<th>Picture</th>-->
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($topUsers as $user)
                                                    <tr>
                                                        <!--                                    <td><img src="{{@$user->users->profile ? @$user->users->profile : asset('public/Admin/dist/img/no-image.jpg')}}" class="admin-profile-picture" /></td>-->
                                                        <td>{{@$user->firstname}} {{@$user->lastname}}</td>
                                                        <td>{{@$user->email}}</td>
                                                        <td><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';         ?><span class="currency-sym"></span> {{ number_format((@$user->total_amount  * Session::get('currency_val')), 2, '.', '')}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <!-- Charts  -->

                        <div class="row">
                            <div class="col-md-6 marginBottom20">
                                <div class="box box-success" >
                                    <div class="box-header dashbox-header with-border bg-green">
                                        <h3 class="box-title dashbox-title">Top Selling Products</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <center> <canvas id="productCanvas" width="300" height="300"></canvas>  </center>
                                        <div class="table-responsive">
                                            <table class="table no-margin">
                                                <tbody>
                                                    @foreach($products as $product)
                                                    <tr>
                                                        <td>
                                                            <div style="width: 20px; height: 20px; background-color: {{$product["color"]}}"></div>
                                                        </td>
                                                        <td>
                                                            {{@$product["product_name"]->product}}
                                                        </td>
                                                        <td>
                                                         Rs. {{ number_format((@$product["product_name"]->price* Session::get('currency_val')), 2, '.', '')}} 
                                                     </td>
                                                     <td class="pull-left">
                                                        {{$product["quantity"]}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 marginBottom20">
                            <div class="box box-warning" >
                                <div class="box-header dashbox-header with-border bg-yellow">
                                    <h3 class="box-title dashbox-title">Top Customers</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                   <center>  <canvas id="mycanvas" width="300" height="300"></canvas>
                                   </canvas> 
                                   <div class="table-responsive">
                                    <table class="table no-margin">

                                        <tbody>
                                            @foreach($items as $item)
                                            <tr>
                                                <td>
                                                    <div style="width: 20px; height: 20px; background-color: {{$item["color"]}}"></div>
                                                </td>
                                                <td>
                                                    {{$item["customer_name"]}}
                                                </td>
                                                <td>
                                                    Rs. {{$item["total"]}} 
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> 
                            </div>

                        </div>
                    </div>
                </div>

                <!--piecharts end -->

                <div class="row">
                    <div class="col-md-6 marginBottom20">
                        <div class="box box-success" >
                            <div class="box-header dashbox-header with-border bg-green">
                                <h3 class="box-title dashbox-title">Latest Products</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th></th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($latestProducts as $product)

                                            <tr>
                                                <td><img src="{{@$product->prodImage}}" class="admin-profile-picture" /></td>
                                                <td>  {{@$product->product}}</td>
                                                <td><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';         ?><span class="currency-sym"></span> {{ number_format((@$product->selling_price* Session::get('currency_val')), 2, '.', '')}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 marginBottom20">
                        <div class="box box-warning" >
                            <div class="box-header dashbox-header with-border bg-yellow">
                                <h3 class="box-title dashbox-title">Latest Customers</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <table class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <!--<th>Picture</th>-->
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Registered Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($latestUsers as $user)
                                                <tr>
                                                    <!--<td><img src="{{@$user->users->profile ? @$user->users->profile : asset('public/Admin/dist/img/no-image.jpg')}}" class="admin-profile-picture" /></td>-->
                                                    <td>{{@$user->firstname}} {{@$user->lastname}}</td>
                                                    <td>{{@$user->email}}</td>
                                                    <td>{{date("d-M-Y",strtotime($user->created_at))}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    <!--                <div class="box-footer clearfix">
                                        <a href="{{route('admin.customers.view')}}" class="btn btn-sm btn-info btn-flat pull-right">View All Users</a>
                                    </div>-->
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="box box-success" >
                            <div class="box-header dashbox-header with-border bg-green">
                                <h3 class="box-title dashbox-title">Sales Statistics</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                                <div class="box-body">
                                    <div class="input-group date Nform_date" id="datepickerDemo">
                                    <input placeholder="Select Date" type="text" id="" name="sales_daterange"  class="form-control sales_daterange textInput">

                                    <span class="input-group-addon">
                                        <i class=" ion ion-calendar"></i>
                                    </span>
                                    </div>
                                    <div id="SalesChart">
                                    {!! $Sales_chart->html() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <!-- <div class="panel panel-default">
                                <div class="panel-heading">Orders Statistics</div> -->
                            <div class="box box-warning" >
                            <div class="box-header dashbox-header with-border bg-yellow">
                                <h3 class="box-title dashbox-title">Orders Statistics</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                                <div class="box-body">
                                <div class="input-group date Nform_date" id="datepickerDemo">
                                    <input placeholder="Select Date" type="text" id="" name="datefrom"  class="form-control datefromto textInput">

                                    <span class="input-group-addon">
                                        <i class=" ion ion-calendar"></i>
                                    </span>
                                </div>
                                <div id="ordersChart">
                                     {!! $orders_chart->html() !!}
                                </div>
                                   
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-success" >
                                <div class="box-header dashbox-header with-border bg-green">
                                    <h3 class="box-title dashbox-title">New Customers</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                    <div class="box-body">
                                        <div class="input-group date Nform_date" id="datepickerDemo">
                                        <input placeholder="Select Date" type="text" id="" name="customers_daterange"  class="form-control customers_daterange textInput">

                                        <span class="input-group-addon">
                                            <i class=" ion ion-calendar"></i>
                                        </span>
                                        </div>
                                        <div id="NewCustomerChart">
                                        {!! $Newcustomer_chart->html() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                         <!--    <div class="col-md-6">
                                <div class="box box-success" >
                                <div class="box-header dashbox-header with-border bg-green">
                                    <h3 class="box-title dashbox-title">Average Order/Bill</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                    <div class="box-body">
                                        <div class="input-group date Nform_date" id="datepickerDemo">
                                        <input placeholder="Select Date" type="text" id="" name="bill_daterange"  class="form-control bill_daterange textInput">

                                        <span class="input-group-addon">
                                            <i class=" ion ion-calendar"></i>
                                        </span>
                                        </div>
                                        <div id="AvgBillChart">
                                        {!! $Avgbill_chart->html() !!}
                                        </div>
                                    </div>
                                </div>
                            </div> -->




                        </div>

                        <div class="clearfix"></div>
                        <br>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="box box-success" >
                                <div class="box-header dashbox-header with-border bg-green">
                                    <h3 class="box-title dashbox-title">Customers Visited</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                    <div class="box-body">
                                        <div class="input-group date Nform_date" id="datepickerDemo">
                                        <input placeholder="Select Date" type="text" id="" name="vcustomers_daterange"  class="form-control vcustomers_daterange textInput">

                                        <span class="input-group-addon">
                                            <i class=" ion ion-calendar"></i>
                                        </span>
                                        </div>
                                        <div id="CustomerVisitedChart">
                                        {!! $Customervisited_chart->html() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="box box-success" >
                                <div class="box-header dashbox-header with-border bg-green">
                                    <h3 class="box-title dashbox-title">Customers Not Visited</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                    <div class="box-body">
                                        <div class="input-group date Nform_date" id="datepickerDemo">
                                        <input placeholder="Select Date" type="text" id="" name="nvcustomers_daterange"  class="form-control nvcustomers_daterange textInput">

                                        <span class="input-group-addon">
                                            <i class=" ion ion-calendar"></i>
                                        </span>
                                        </div>
                                        <div id="CustomernotVisitedChart">
                                        {!! $Customernotvisited_chart->html() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>

                        






                        </div>
            </div>
        </section>

        @stop
         {!! Charts::scripts() !!}
{!! $Sales_chart->script() !!}
{!! $orders_chart->script() !!}
{!! $Newcustomer_chart->script() !!}
{!! $Customernotvisited_chart->script() !!}
{!! $Customervisited_chart->script() !!}
{!! $Avgbill_chart->script() !!}
        @section('myscripts')
        <script src="{{  Config('constants.adminPlugins').'/daterangepicker/daterangepicker.js' }}"></script>
<script type="text/javascript">

    $(function () {

    var start = moment().subtract(29, 'days');
    var end = moment();

    $('.sales_daterange').daterangepicker({
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
    }, function (start,end,label) {
        
        var startdate = start.format('YYYY-MM-DD');
        var enddate = end.format('YYYY-MM-DD');
        
        $.ajax({
           type:'POST',
           url:'sales-stat',
           data:{startdate:startdate,enddate:enddate},
           success:function(data){
              $("#SalesChart").html(data);
           }
        });
    });


    //new customer
      $('.customers_daterange').daterangepicker({
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
    }, function (start,end,label) {
        
        var startdate = start.format('YYYY-MM-DD');
        var enddate = end.format('YYYY-MM-DD');
        
        $.ajax({
           type:'POST',
           url:'customers-stat',
           data:{startdate:startdate,enddate:enddate},
           success:function(data){
              $("#NewCustomerChart").html(data);
           }
        });
    });

    //customer not visited
      $('.nvcustomers_daterange').daterangepicker({
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
    }, function (start,end,label) {
        
        var startdate = start.format('YYYY-MM-DD');
        var enddate = end.format('YYYY-MM-DD');
        
        $.ajax({
           type:'POST',
           url:'notvisitedcustomers-stat',
           data:{startdate:startdate,enddate:enddate},
           success:function(data){
              $("#CustomernotVisitedChart").html(data);
           }
        });
    });


      //customer  visited
      $('.vcustomers_daterange').daterangepicker({
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
    }, function (start,end,label) {
        
        var startdate = start.format('YYYY-MM-DD');
        var enddate = end.format('YYYY-MM-DD');
        
        $.ajax({
           type:'POST',
           url:'visitedcustomers-stat',
           data:{startdate:startdate,enddate:enddate},
           success:function(data){
              $("#CustomerVisitedChart").html(data);
           }
        });
    });







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
    }, function (start,end,label) {
        
        var startdate = start.format('YYYY-MM-DD');
        var enddate = end.format('YYYY-MM-DD');
        
        $.ajax({
           type:'POST',
           url:'order-stat',
           data:{startdate:startdate,enddate:enddate},
           success:function(data){
              $("#ordersChart").html(data);
           }
        });
    });

    $('.datefromto').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('.datefromto').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
});
</script>
        <script>
            $(document).ready(function(){
             
               $('.OrderDate').blur(function (){
                     var form = $('#orderForm');
                     var url = form.attr('action');

                     $.ajax({
                       type: "POST",
                       url: url,
                   data: form.serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                    console.log(data);
                        // var orderData = [];
                        // for(var k in data) {
                        //     orderData[k] =  data[k].created_at +":"+ data[k].total_order;
                        //  }
                        var bar_data = {
                            data: data,
                            color: "#3c8dbc"
                        };
                
                        $.plot("#bar-chart", [bar_data], {
                            grid: {
                                borderWidth: 1,
                                borderColor: "#f3f3f3",
                                tickColor: "#f3f3f3"
                            },
                            series: {
                                bars: {
                                    show: true,
                                    barWidth: 0.5,
                                    align: "center"
                                }
                            },
                            xaxis: {
                                mode: "categories",
                                tickLength: 0
                            }
                        });

                    }
                });

               });


                 $('.saleDate').blur(function (){
                     var form = $('#saleForm');
                     var url = form.attr('action');

                     $.ajax({
                       type: "POST",
                       url: url,
                   data: form.serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                    console.log(data);
                        // var orderData = [];
                        // for(var k in data) {
                        //     orderData[k] =  data[k].created_at +":"+ data[k].total_order;
                        //  }
                        var bar_data = {
                            data: data,
                            color: "#3c8dbc"
                        };
                        // $("#bar-chart").html('');

                        $.plot("#bar-chart", [bar_data], {
                            grid: {
                                borderWidth: 1,
                                borderColor: "#f3f3f3",
                                tickColor: "#f3f3f3"
                            },
                            series: {
                                bars: {
                                    show: true,
                                    barWidth: 0.5,
                                    align: "center"
                                }
                            },
                            xaxis: {
                                mode: "categories",
                                tickLength: 0
                            }
                        });

                    }
                });

               });


               var ctx1 = $("#mycanvas").get(0).getContext("2d");
               var dataCustomers = [
               <?php 
               foreach($items as $item)
               {
                ?>
                {
                    value: {{$item['total']}},
                    color: "{{$item['color']}}",

                    label: "{{$item['customer_name']}}",
                },
                <?php 
            }
            ?>

            ];  
            var piechartCustomers = new Chart(ctx1).Pie(dataCustomers);
            var ctx2 = $("#productCanvas").get(0).getContext("2d");
            var dataProducts = [
            <?php 
            foreach($products as $product)
            {
                ?>
                {
                    value: {{$product['quantity']}},
                    color: "{{$product['color']}}",

                    label: "{{@$product["product_name"]->product}}",
                },  
                <?php 
            }
            ?> 
            ];
            var piechartProducts = new Chart(ctx2).Pie(dataProducts);
        });
    </script>

    <script>
        <?php
        $labels = '[';
        $amount = '[';
        foreach ($salesGraph as $sale) {
            $labels .= '"' . date('d M', strtotime($sale['created_at'])) . '",';
            $amount .= '"' . $sale['total_amount'] . '",';
        }
        $labels .= ']';
        $amount .= ']';
        ?>
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        var bareaChartCanvas = $("#bareaChart").get(0).getContext("2d");
        var barea = $("#bareaChart").get(0).getContext("2d");

        var areaChart = new Chart(areaChartCanvas);
        var bareaChart = new Chart(bareaChartCanvas);
        var areaChartData = {
            labels: <?php echo $labels; ?>,
            datasets: [
            {
                label: "Electronics",
                fillColor: "rgba(60,141,188,0.9)",
                strokeColor: "rgba(60,141,188,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data: <?php echo $amount; ?>
            }
            ]
        };
        var areaChartOptions = {
        showScale: true, //Boolean - If we should show the scale at all        
        scaleShowGridLines: true, //Boolean - Whether grid lines are shown across the chart        
        scaleGridLineColor: "rgba(0,0,0,.05)", //String - Colour of the grid lines        
        scaleGridLineWidth: 1, //Number - Width of the grid lines        
        scaleShowHorizontalLines: true, //Boolean - Whether to show horizontal lines (except X axis)        
        scaleShowVerticalLines: true, //Boolean - Whether to show vertical lines (except Y axis)        
        bezierCurve: true, //Boolean - Whether the line is curved between points       
        bezierCurveTension: 0.3, //Number - Tension of the bezier curve between points      
        pointDot: true, //Boolean - Whether to show a dot for each point      
        pointDotRadius: 5, //Number - Radius of each point dot in pixels      
        pointDotStrokeWidth: 1, //Number - Pixel width of point dot stroke       
        pointHitDetectionRadius: 20, //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        datasetStroke: true, //Boolean - Whether to show a stroke for datasets      
        datasetStrokeWidth: 2, //Number - Pixel width of dataset stroke
        datasetFill: false, //Boolean - Whether to fill the dataset with a color
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>", //String - A legend template
        maintainAspectRatio: true, //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        responsive: true  //Boolean - whether to make the chart responsive to window resizing
    };
    areaChart.Line(areaChartData, areaChartOptions);
    bareaChart.Line(areaChartData, areaChartOptions);

    ////////////// Order Chart
    <?php
    $orderdata = '[';
    foreach ($orderGraph as $order) {

        //echo date('d M', strtotime($order['created_at'])) . ',' . $order['total_order'];
         $orderdata .= '["' . date('d M', strtotime($order['created_at'])) . '",' . $order['total_order'] . '],';

    }
    $orderdata .= ']';
    
    ?>

    var bar_data = {
        data: <?php echo $orderdata; ?>,
        color: "#3c8dbc"
    };

    var orderBarChart  =  $.plot("#bar-chart", [bar_data], {
        grid: {
            borderWidth: 1,
            borderColor: "#f3f3f3",
            tickColor: "#f3f3f3"
        },
        series: {
            bars: {
                show: true,
                barWidth: 0.5,
                align: "center"
            }
        },
        xaxis: {
            mode: "categories",
            tickLength: 0
        }
    });

    /* END BAR CHART */
</script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
    </script>

@stop