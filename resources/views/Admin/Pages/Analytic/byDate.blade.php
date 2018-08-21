@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sales   

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">By Date</li>
    </ol>
</section>
<section class="content">


    <!-- LINE CHART -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Daily Sales</h3>

            <div class="row">
                <div class="box-tools pull-right">
                    <div class="col-md-3">
                        <div class="input-group">   
                            <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                            {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control dateSearch1','placeholder'=>'Order Date','autocomplete'=>'off']) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="chart">
                <canvas id="lineChart" style="height:250px"></canvas>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.row -->

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Monthly Sales</h3>
            <div class="row">
                <div class="box-tools pull-right">
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                            {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control dateSearch2','id'=>'','placeholder'=>'Order Date','autocomplete'=>'off']) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
            </div>
        </div>
        <!-- /.box-body -->
    </div>


    <div class="row">
        <section class="col-lg-12 connectedSortable">
            <div class="box">
                <div class="box-header" >
                    <div class="row">
                        <div class="col-md-2"><h3 class="box-title">Yearly Sales </h3></div>

                        <div class="col-md-5">
                            <!--                            <div class="input-group">
                                                            <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                                            {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control dateSearch','id'=>'dateSearch','placeholder'=>'Order Date','autocomplete'=>'off']) }}
                                                        </div>-->
                            {{ Form::open() }}
                            <div class="col-md-5">
                                {{ Form::select('from_year',$fromY,null,['class'=>'form-control']) }}
                            </div>
                            <div class="col-md-5">
                                {{ Form::select('to_year',$toY,null,['class'=>'form-control']) }}
                            </div>
                            <div class="col-md-2 pull-right">
                                <button type="button" class="btn btn-success yearSearch"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>

                </div>

                <div class="box-body">

                    <div class="nav-tabs-custom">


                        <div class="tab-content no-padding">

                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
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
<script>
    /* Morris.js Charts */
    // Sales chart



    var yearlySales = <?php echo json_encode($yearlySales); ?>;




    //console.log(yearlySales);

    var area = new Morris.Area({
        element: 'revenue-chart',
        resize: true,
        parseTime: false,
        data: yearlySales,
        // The name of the data record attribute that contains x-values.
        xkey: 'year',
        // A list of names of data record attributes that contain y-values.
        ykeys: ['value'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Total Sales'],
        lineColors: ['#a0d0e0', '#3c8dbc'],
        hideHover: 'auto'
    });
   

    $(".yearSearch").click(function () {
        var chkF = $("select[name='from_year']").val();
        var chkT = $("select[name='to_year']").val();


        $.ajax({
            type: "POST",
            url: "{{route('admin.analytics.byDateGetYearly')}}",
            data: {chkF: chkF, chkT: chkT},
            cache: false,
            success: function (data) {
                area.setData(data);
            }
        });

    });

    s_from_date = '<?php echo date('Y-m-d', strtotime('-30 days')); ?>';
    s_to_date = '<?php echo date('Y-m-d'); ?>';





//    var dailyChartData = {
//        labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11"],
//        datasets: [
//            {
//                label: "Overall Sales",
//                fillColor: "rgba(210, 214, 222, 1)",
//                strokeColor: "rgba(210, 214, 222, 1)",
//                pointColor: "rgba(210, 214, 222, 1)",
//                pointStrokeColor: "#c1c7d1",
//                pointHighlightFill: "#fff",
//                pointHighlightStroke: "rgba(220,220,220,1)",
//                data: [6500, 5900, 8000, 8100, 56000, 5500, 4000, 2800, 48000, 4000, 1900]
//            }
//        ]
//    };






    var areaChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [
            {
//                label: "Sales",
//                fillColor: "rgba(210, 214, 222, 1)",
//                strokeColor: "rgba(210, 214, 222, 1)",
//                pointColor: "rgba(210, 214, 222, 1)",
//                pointStrokeColor: "#c1c7d1",
//                pointHighlightFill: "#fff",
//                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [6500, 5900, 8000, 8100, 5600, 5500, 4000, 8000, 8100, 5600, 5500, 4000]
            }
//            ,
//            {
//                label: "Digital Goods",
//                fillColor: "rgba(60,141,188,0.9)",
//                strokeColor: "rgba(60,141,188,0.8)",
//                pointColor: "#3b8bba",
//                pointStrokeColor: "rgba(60,141,188,1)",
//                pointHighlightFill: "#fff",
//                pointHighlightStroke: "rgba(60,141,188,1)",
//                data: [28, 48, 40, 19, 86, 27, 90]
//            }
        ]
    };

    var barchartMonthly = <?php echo json_encode($barchartdata); ?>;


    var dailyChart = <?php echo json_encode($dailychartdata); ?>







    console.log("monthly===== " + JSON.stringify(barchartMonthly));

    console.log("daily===== " + JSON.stringify(dailyChart));

    console.log("yearly===== " + JSON.stringify(yearlySales));

    var areaChartOptions = {
        //Boolean - If we should show the scale at all
        showScale: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: false,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 0.2,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - Whether the line is curved between points
        bezierCurve: true,
        //Number - Tension of the bezier curve between points
        bezierCurveTension: 0.3,
        //Boolean - Whether to show a dot for each point
        pointDot: false,
        //Number - Radius of each point dot in pixels
        pointDotRadius: 4,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth: 1,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius: 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke: true,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth: 1,
        //Boolean - Whether to fill the dataset with a color
        datasetFill: true,
        //String - A legend template
        legendTemplate: "<ul class=\"<%= name . toLowerCase() %>-legend\"><% for (var i = 0;tasets . length;i++) { %><li><span style=\"background-color:<%= datasets[i] . lineColor %>\"></span><% if (datasets[i] . label) { %><%= datasets[i] . label %><% } %></li><% } %></ul>",
        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true
    };
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = barchartMonthly;
//    barChartData.datasets[0].fillColor = "#00a65a";
    // barChartData.datasets[0].strokeColor = "#00a65a";
    //   barChartData.datasets[0].pointColor = "#00a65a";
    var barChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 0.5,
        //barValueSpacing:30,
    
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //    barGap:4000,
        //barSizeRatio:0.55,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 0.5,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 80,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 10,
      //  isFixedWidth:true,
//barWidth:1,
        //String - A legend template
        legendTemplate: "<ul class=\"<%= name . toLowerCase() %>-legend\"><% for (var i = 0;i < datasets . length;i++) { %><li><span style=\"background-color:<%= datasets[i] . fillColor %>\"></span><% if (datasets[i] . label) { %><%= datasets[i] . label %><% } %></li><% } %></ul>",
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
    };



    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);


    $('.dateSearch2').daterangepicker(
            {
                locale: {
                    format: 'YYYY-MM-DD'
                },
                startDate: s_from_date,
                endDate: s_to_date,
                autoUpdateInput: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            },
    function (start, end, label) {
        // alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('.dateSearch2').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));
        var getdaterange = $('.dateSearch2').val();
        //for daily search

        $.ajax({
            type: "POST",
            url: "{{ route('admin.analytics.byDateGetMonthly') }}",
            data: {getdaterange: getdaterange},
            cache: false,
            success: function (data) {
                console.log(data);

                barChart.Bar(data, barChartOptions);


            }
        });

    });


    //-------------
    //- LINE CHART -
    //--------------

    var dailylineChartOptions = {
        //Boolean - If we should show the scale at all
        showScale: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: false,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 0.2,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - Whether the line is curved between points
        bezierCurve: true,
        //Number - Tension of the bezier curve between points
        bezierCurveTension: 0.3,
        //Boolean - Whether to show a dot for each point
        pointDot: false,
        //Number - Radius of each point dot in pixels
        pointDotRadius: 4,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth: 1,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius: 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke: true,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth: 1,
        //Boolean - Whether to fill the dataset with a color
        datasetFill: true,
        //String - A legend template
        legendTemplate: "<ul class=\"<%= name . toLowerCase() %>-legend\"><% for (var i = 0;tasets . length;i++) { %><li><span style=\"background-color:<%= datasets[i] . lineColor %>\"></span><% if (datasets[i] . label) { %><%= datasets[i] . label %><% } %></li><% } %></ul>",
        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true
    };
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
    var lineChartOptions = dailylineChartOptions;
    lineChartOptions.datasetFill = false;
    lineChart.Line(dailyChart, lineChartOptions);

    $('.dateSearch1').daterangep