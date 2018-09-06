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
                    <span class="info-box-icon bg-green"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';        ?><span class="currency-sym"></span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales Today</span>
                        <span class="info-box-number">{{ number_format($todaysSales * Session::get('currency_val')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';        ?><span class="currency-sym"></span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales This Week</span>
                        <span class="info-box-number ">{{ number_format($weeklySales * Session::get('currency_val')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';        ?><span class="currency-sym"></span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales This Month</span>
                        <span class="info-box-number">{{ number_format($monthlySales * Session::get('currency_val')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';        ?><span class="currency-sym"></span></span>
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
                        <span class="info-box-text">Total Users</span>
                        <span class="info-box-number">{{ number_format($userCount) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Users This Week</span>
                        <span class="info-box-number">{{ number_format($userThisWeekCount) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Users This Month</span>
                        <span class="info-box-number">{{ number_format($userThisMonthCount) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Users This Year</span>
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
                                        <td>{{ @$order->id }}</td>
                                        <td>{{ ucfirst(@$order->orderDetails->first_name) }} {{ @$order->orderDetails->last_name }} </td>
                                        <td>{{ @$order->orderDetails->users->email }}  </td>
                                        <td>{{ @$order->orderDetails->phone_no }}</td>
                                        <td>{{ @$order->orderDetails->orderstatus['order_status'] }}</td>  
                                        <td>{{ @$order->orderDetails->paymentstatus['payment_status'] }}</td>
                                        <td>{{ @$order->orderDetails->paymentmethod['name'] }}</td>
                                        <td><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';        ?><span class="currency-sym"></span> {{ number_format((@$order->pay_amt * Session::get('currency_val')), 2, '.', '')}}</td>
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
                        {{print_r($topProducts) }}
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
                                        <td><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';        ?><span class="currency-sym"></span> {{number_format((@$product->product->price  * Session::get('currency_val')), 2, '.', '')}}</td>
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
                                        <td>{{@$user->first_name}} {{@$user->last_name}}</td>
                                        <td>{{@$user->email}}</td>
                                        <td><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';        ?><span class="currency-sym"></span> {{ number_format((@$user->total_amount  * Session::get('currency_val')), 2, '.', '')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--                <div class="box-footer clearfix">
                                        <a href="{{route('admin.customers.view')}}" class="btn btn-sm btn-danger btn-flat pull-right">View All Users</a>
                                    </div>-->
                </div>
            </div>
        </div>

      

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
                                        <td><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';        ?><span class="currency-sym"></span> {{ number_format((@$product->selling_price* Session::get('currency_val')), 2, '.', '')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--                <div class="box-footer clearfix">
                                        <a href="{{route('admin.products.view')}}" class="btn btn-sm btn-info btn-flat pull-right">View All Products</a>
                                    </div>-->
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
                <div class="box box-primary">
                    <div class="box-header dashbox-header with-border">
                        <h3 class="box-title dashbox-title">Weekly Sales</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn-box-tool blackColor" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn-box-tool blackColor" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="areaChart" style="height: 278px; width: 610px;" width="610" height="278"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header dashbox-header with-border">
                        <h3 class="box-title dash dashbox-title">Weekly Orders</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn-box-tool blackColor" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn-box-tool blackColor" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="bar-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@section('myscripts')
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
    var areaChart = new Chart(areaChartCanvas);
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

    ////////////// Order Chart
<?php
$orderdata = '[';
foreach ($orderGraph as $order) {
    $orderdata .= '["' . date('d M', strtotime($order['created_at'])) . '",' . $order['total_order'] . '],';
}
$orderdata .= ']';
?>
    var bar_data = {
        data: <?php echo $orderdata; ?>,
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
    /* END BAR CHART */
</script>

@stop