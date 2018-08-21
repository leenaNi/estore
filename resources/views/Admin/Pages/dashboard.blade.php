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
                        {{ number_format(  $data['totalSales']) }}
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
    <!-- Main row -->
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
                                    <td><span >{{ Session::get('cur') }}  {{number_format($topS->total_sales)}}</span></td>
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
                </div>
                @endif
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                </div>
                <!-- /.box-footer -->
            </div>

        </section>

    </div>


    <!--<div class="row">
        <section class="col-lg-12 connectedSortable">
            <div class="box box-info">

                <div class="box box-solid bg-teal-gradient">
                    <div class="box-header">
                        <i class="fa fa-th"></i>

                        <h3 class="box-title">All Stores Sales (Last 10 days)</h3>

                    </div>
                    <div class="box-body border-radius-none">
                        <div class="chart" id="line-chart" style="height: 250px;"></div>
                    </div>

                </div>
            </div>
        </section>


    </div>-->
</section>
<!-- /.content -->


@stop

@section('myscripts')
<script>
 

    $('svg').height(1000);

    var storedata = <?php echo json_encode($data['allStoreSales']); ?>;
//var storeSales = storedata.replace(/"(\w+)"\s*:/g, '$1:');
    console.log(JSON.stringify(storedata));
   
    /*var line = new Morris.Line({
        element: 'line-chart',
        parseTime: false,
        resize: true,
        data: storedata,
        xkey: 'y',
        ykeys: ['item1'],
        labels: ['Store Sales'],
        // behaveLikeLine:true,
        xLabelAngle: 45,
        //   xLabelWidth:100,
     //   xLabelMargin: 50,
        //   
        //  eventStrokeWidth: 0,
        xLabelFormat: function (x) {
            lab = x.label;
            console.log(lab);
            return lab.toString();
        },
//  
        //    ymax: 0,
        lineColors: ['#efefef'],
        behaveLikeLine: true,
        lineWidth: 2,
        hideHover: 'auto',
        gridTextColor: "#fff",
        gridStrokeWidth: 0.4,
        pointSize: 4,
        pointStrokeColors: ["#efefef"],
        gridLineColor: "#efefef",
        gridTextFamily: "Open Sans",
        gridTextSize: 18
    });*/




</script>
@stop