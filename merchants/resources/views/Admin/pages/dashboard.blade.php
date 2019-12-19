@extends('Admin.layouts.default')
@section('content')
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
                                        <th>Email</th>
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
                                        <td>{{ @$order["email"] }}  </td>
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
                                                            {{$product["product_name"]->product}}
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
                  
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                              <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                <div class="panel-heading">Weekly Sales</div>

                                <div class="panel-body">
                                    {!! $chart->html() !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="panel panel-default">
                                <div class="panel-heading">Weekly Orders</div>

                                <div class="panel-body">
                                    {!! $chart->html() !!}
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </section>

        @stop
        {!! Charts::scripts() !!}
{!! $chart->script() !!}
        @section('myscripts')
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

  
          
        });
    </script>

@stop