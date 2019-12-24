@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        {{ count($data['merchants']) }}
                    </h3>
                    <p>Total Merchants</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people"></i>
                </div>
                <a href="{{ route('admin.merchants.view') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ count($data['stores']) }}
                    </h3>

                    <p>Total  Stores</p>
                </div>
                <div class="icon">
                    <i class="ion ion-briefcase"></i>
                </div>
                <a href="{{ route('admin.stores.view')  }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        {{ $data['allStoreOperatores'] }}

                    </h3>

                    <p>Total Store Operators</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.stores.view') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">

                    <h3>{{ $data['happyCustomers'] }}</h3>

                    <p>Happy Customers</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fa"></i></a>
            </div>
        </div>
		<div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>
                         {{ number_format($data['totalOrders']) }}
                    </h3>
                    <p>Total Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
		
		<div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-olive">
                <div class="inner">
                    <h3>
                       <span class="currency-sym"> </span><span class="priceConvert"> 
                           {{ number_format(  $data['totalSales']) }}</span>
                    </h3>
                    <p>Total Sales</p>
                </div>
                <div class="icon">
                    <i class="ion ion-connection-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="row">

        <section class="col-lg-6 connectedSortable">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Top Stores </h3>


                </div>
                <!-- /.box-header -->
                @if(!empty($data['topStoreSales']))
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <!--<th></th> -->
                                    <th>Store </th>
                                    <th>Merchant</th>
                                    <!--<th>Bank </th> -->
                                    <th>Sales </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data['topStoreSales'] as $topS)
                                <tr>
                                    <?php
                                    if (!empty($topS->logo)) {
                                        $topSLogo = $topS->logo;
                                    } else {
                                        $topSLogo = 'default-store.jpg';
                                    }
                                    
                                 
                                    ?>

                                    <!-- <td><a href="javascript:void(0)"><img src="{{ asset(Config('constants.AdminStoreLogo').@$topSLogo) }}" width="50"  alt="User Image"></a></td> -->
                                    <td>{{ @$topS->store_name}}</td>
                                    <td>{{$topS->firstname  }}</td>
                                    <!--<td>{{implode(',',array_unique(explode(',', $topS->banknames)))}}</td> -->
                                    <td> <span class="currency-sym"> </span><span class="priceConvert"> {{number_format($topS->total_sales)}}</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#00c0ef" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                    </td>
                                </tr>


                                @endforeach                         

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                @endif
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                </div>
                <!-- /.box-footer -->
            </div>

        </section>

        <section class="col-lg-6 connectedSortable">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Latest Stores </h3>


                </div>
                <!-- /.box-header -->
                @if(!empty($data['latestStores']))
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <!--<th></th>-->
                                    <th>Store </th>
                                    <!--<th>Bank </th>-->
                                    <th>Merchant</th>
									<th>Created Date</th>	
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data['latestStores'] as $latestS)
                                <tr>

                                    <?php
                                    if (!empty($latestS->logo)) {
                                        $latestSLogo = $latestS->logo;
                                    } else {
                                        $latestSLogo = 'default-store.jpg';
                                    }
                                    ?>
                                    <!-- <td><a href="javascript:void(0)"><img src="{{ asset(Config('constants.AdminStoreLogo').@$latestSLogo) }}" width="50"  alt="User Image"></a></td>-->

                                    <td>{{$latestS->store_name }}</td>
                                    <!--<td>{{implode(',',array_unique(explode(',', $latestS->banknames)))}}</td>-->
                                    <td><span>{{ $latestS->firstname }}</span></td>
									<td><span>{{ date("d-M-Y",strtotime($latestS->created_at)) }}</span></td>
                                    <!--<td>
                                        <div class="sparkbar" data-color="#00c0ef" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                    </td>-->
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                    <!-- <div class="box-body">
                        <div class="chart">
                            <canvas id="bareaChart" style="height: 278px; width: 610px;" width="610" height="278"></canvas>
                        </div>

                    </div> -->
                    
                </div>
                @endif
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                </div>
                <!-- /.box-footer -->
            </div>

        </section>
    </div>
    <div class="row">
        <div class="clearfix mb-15"></div>
        <section class="col-lg-6 connectedSortable">
            <div class="box box-info">
                <div class="bg-blue bg-blue-box">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div class="small-box bg-blue">
                                <div class="inner">

                                    <h3 id="order_count"> 0 </h3>

                                    <p><span id="total_order_label">Orders Count</span></p>
                                </div>
                                <div class="icon bg-icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            {!! Form::select('merchants_name',$merchants_name,Input::get('merchants_name'), ["class"=>'form-control filter_type order-data','id' => 'merchants_id',"placeholder"=>"Store Name"]) !!}
                            {!! Form::select('time_duration',$time_duration,Input::get('time_duration'), ["class"=>'form-control filter_type order-data','id' => 'time_duration_id', "placeholder"=>"Time Duration"]) !!}
                        </div>
                    </div>
                    <a href="#" class="small-box-footer"> <i class="fa"></i></a>
                </div>
                <div class="row">
                        <div class="box-body">
                            <div class="chart">
                                <canvas class="areaChart" id="areaChart_id" style="height: 278px; width: 610px;" width="610" height="278"></canvas>
                            </div>
                        </div>
                </div>
            </div>
        </section>

        <section class="col-lg-6 connectedSortable">
            <div class="box box-info">
                <div class="bg-blue bg-blue-box">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div class="small-box bg-blue">
                                <div class="inner">

                                    <h3 > 
                                    <!-- <span class="currency-sym"> </span> -->
                                    <span class="priceConvert" id="total_sales">
                                    0 </span></h3>
                                    <p><span id="total_sales_label">Total Sales</span></p>
                                </div>
                                <div class="icon bg-icon">
                                   <i class="ion ion-connection-bars"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            {!! Form::select('merchants_name',$merchants_name,Input::get('merchants_name'), ["class"=>'form-control filter_type sales-data','id' => 'sale_merchants_id',"placeholder"=>"Store Name"]) !!}
                            {!! Form::select('time_duration',$time_duration,Input::get('time_duration'), ["class"=>'form-control filter_type sales-data','id' => 'sale_time_duration_id', "placeholder"=>"Time Duration"]) !!}
                        </div>
                    </div>
                    <a href="#" class="small-box-footer"> <i class="fa"></i></a>
                </div>
                <div class="row">
                        <div class="box-body">
                            <div class="chart">
                                <canvas class="areaChart_sales" id="areaChart_sales_id" style="height: 278px; width: 610px;" width="610" height="278"></canvas>
                            </div>
                        </div>
                </div>
            </div>
        </section>
    </div>
</section>
<!-- /.content -->
@stop
@section('myscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
<script>
    let x_axis = '<?php echo (json_encode($orderGraph_x)) ?>';
    x_axis = x_axis.replace('[','').replace(']','').split(',');
    x_axis = x_axis.map(label => label.replace('"',"").replace('"',""))

    $('svg').height(1000);

    var storedata = <?php echo json_encode($data['allStoreSales']); ?>;
//var storeSales = storedata.replace(/"(\w+)"\s*:/g, '$1:');
    console.log(JSON.stringify(storedata));
   
    $('.order-data').on('change', function(){
        var merchants_id = $('#merchants_id').val();
        var time_duration_id = $('#time_duration_id').val();
        $.ajax({
            type:"GET",
            url: "{{route('admin.getOrderDateWise')}}",
            data: {merchants_id : merchants_id,time_duration_id : time_duration_id},
            dataType: 'json',
            success : function(results) {
                            $("#order_count").text(results.Orders);
                            if (time_duration_id == 1) {
                                $("#total_order_label").text("Orders Today");
                            }else if(time_duration_id == 2){
                                $("#total_order_label").text("Orders This Week");
                            }else if(time_duration_id == 3){
                                $("#total_order_label").text("Orders This Month");
                            }else{
                                $("#total_order_label").text("Orders This Year");
                            }
                            let x_axis = results.orderGraph_x;
                            const drawChart = () => {
                            new Chart($('.areaChart'), {
                                type: 'line',
                                data: {
                                    labels: x_axis,
                                    datasets: [
                                        {
                                            label: `Number Of Orders`,
                                            fill: true,
                                            data: results.orderGraph_y,
                                            borderWidth: 1,
                                            order: 1,
                                        }, 
                                    ]
                                },
                                options: {
                                    legend: {
                                        position:'bottom'
                                    },
                                    scales: {
                                        yAxes: [{
                                            stacked: false,
                                        }]
                                    },
                                    animation: {
                                        duration: 1000,
                                    },
                                }
                            });
                        }
                        drawChart();
            }
        });   
    });
</script>
<script>
    $('.sales-data').on('change', function(){
        var merchants_id = $('#sale_merchants_id').val();
        var time_duration_id = $('#sale_time_duration_id').val();
        $.ajax({
            type:"GET",
            url: "{{route('admin.getSalesDateWise')}}",
            data: {merchants_id : merchants_id,time_duration_id : time_duration_id},
            dataType: 'json',
            success : function(results) {
                        $("#total_sales").text(results.totalSales);
                        if (time_duration_id == 1) {
                            $("#total_sales_label").text("Revenues Today");
                        }else if(time_duration_id == 2){
                            $("#total_sales_label").text("Revenues This Week");
                        }else if(time_duration_id == 3){
                            $("#total_sales_label").text("Revenues This Month");
                        }else{
                            $("#total_sales_label").text("Revenues This Year");
                        }
                        let x_axis = results.salesGraph_x;
                        const drawChart1 = () => {
                            new Chart($('.areaChart_sales'), {
                                type: 'line',
                                data: {
                                    labels: x_axis,
                                    datasets: [
                                        {
                                            label: `Number Of Orders`,
                                            fill: true,
                                            data: results.salesGraph_y,
                                            borderWidth: 1,
                                            order: 1,
                                        }, 
                                    ]
                                },
                                options: {
                                    legend: {
                                        position:'bottom'
                                    },
                                    scales: {
                                        yAxes: [{
                                            stacked: false,
                                        }]
                                    },
                                    animation: {
                                        duration: 1000,
                                    },
                                }
                            });
                        }
                        drawChart1();

            }
        });   
    });
</script>

<script>
    const drawChart = () => {
    new Chart($('.areaChart'), {
        type: 'line',
        data: {
            // labels: orderGraph_x,
            labels: x_axis,
            datasets: [
                {
                    label: `Number Of Orders(Last 7 days)`,
                    fill: true,
                    // backgroundColor: forecastLineColors.darkBlue.fill,
                    // pointBackgroundColor: forecastLineColors.darkBlue.stroke,
                    // borderColor: forecastLineColors.darkBlue.stroke,
                    // pointHighlightStroke: forecastLineColors.darkBlue.stroke,
                    data: [{{$orderGraph_y}}],
                    borderWidth: 1,
                    order: 1,
                },
               
                
            ]
        },
        options: {
            legend: {
                position:'bottom'
            },
            // responsive: false,
            // Can't just just `stacked: true` like the docs say
            scales: {
                yAxes: [{
                    stacked: false,
                }]
            },
            animation: {
                duration: 1000,
            },
        }
    });
}
drawChart();
</script>

<script>
    const salesDrawChart = () => {
    new Chart($('.areaChart_sales'), {
        type: 'line',
        data: {
            // labels: orderGraph_x,
            labels: x_axis,
            datasets: [
                {
                    label: `Total Sales(Last 7 days)`,
                    fill: true,
                    // backgroundColor: forecastLineColors.darkBlue.fill,
                    // pointBackgroundColor: forecastLineColors.darkBlue.stroke,
                    // borderColor: forecastLineColors.darkBlue.stroke,
                    // pointHighlightStroke: forecastLineColors.darkBlue.stroke,
                    data: [{{$salesGraph_y}}],
                    borderWidth: 1,
                    order: 1,
                },
               
                
            ]
        },
        options: {
            legend: {
                position:'bottom'
            },
            // responsive: false,
            // Can't just just `stacked: true` like the docs say
            scales: {
                yAxes: [{
                    stacked: false,
                }]
            },
            animation: {
                duration: 1000,
            },
        }
    });
}
salesDrawChart();
</script>


@stop