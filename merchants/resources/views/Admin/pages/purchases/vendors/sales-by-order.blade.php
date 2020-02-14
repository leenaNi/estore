@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        By Orders 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">By Orders</li>
    </ol>
</section>

<section class="main-content">     
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 no-padding">
                <div class="filter-full-section">
                    <form method="get" action="{{URL::route('admin.vendors.saleByOrder')}}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <div class="form-group col-md-4 noBottomMargin">
                            <div class="input-group">
                                <input type="text" name="from_date" value="{{ @Input::get('from_date') }}" required="true"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 noBottomMargin">
                            <div class="input-group">
                                <input type="text" name="to_date" value="{{ @Input::get('to_date') }}"   required="true"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2 noBottomMargin">
                            <input type="submit" name="submit" class="btn btn-primary fullWidth" value="Submit">
                        </div>
                         <div class="form-group col-md-2 noBottomMargin">
                         <a  href="{{route('admin.vendors.saleByOrder')}}" class="medium btn btn-block reset-btn">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Order{{$orderCount > 1 ?'s':'' }} <span class="listing-counter"> {{$orderCount }} </span> </h1> 
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding"> 
                <table class="table ByOrderSalesTable orderTable table-hover general-table tableVaglignMiddle">
                    <thead>
                        <tr>                    
                            <th class="text-left">Date</th>
                            <th class="text-center">Order Count</th>
                            <th class="text-right">Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order as $od)
                        <tr>                                
                            <td class="text-left">{{date("d-M-Y",strtotime($od->created_at)) }}</td>
                            <td class="text-center">{{ $od->order_count }}</td>
                            <td class="text-right"><i class='fa fa-rupee'></i> {{ number_format($od->sales) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <?php if (empty(Input::get('dateSearch'))) {
               echo $order->links();
            } ?>
        </div>
    </div>



</section>

<div class="clearfix"></div>

@stop
@section('myscripts')
<script>
    $(document).ready(function () {

        $('#checkAll').click(function (event) {

            var checkbox = $(this),
                    isChecked = checkbox.is(':checked');
            if (isChecked) {
                $('.checkbyordertId').attr('Checked', 'Checked');
            } else {
                $('.checkbyordertId').removeAttr('Checked');
            }
        });


        $(".monthTab").click(function () {
            $(".monthTab").attr("href", "{{ URL::route(Route::currentRouteName())}}?month=1");
        });
        $(".weekTab").click(function () {
            //  alert("asdfd");
            $(".weekTab").attr("href", "{{ URL::route(Route::currentRouteName())}}?week=1");
        });




        $(".byorderExport").click(function () {
            $("#from_date").val($("input[name='from_date']").val());
            $("#to_date").val($("input[name='to_date']").val());
            $('.ByOrderSalesTable').find('input').each(function () {
                chkvalues.push($(this).val());
            });



<?php if (!empty(Input::get('month'))) { ?>
                $("#ByOrderExport").append("<input type='hidden' name='month' value='1'/><br/>");
<?php } ?>



<?php if (!empty(Input::get('week'))) { ?>
                $("#ByOrderExport").append("<input type='hidden' name='week' value='1'/><br/>");
<?php } ?>


<?php if (!empty(Input::get('year'))) { ?>
                $("#ByOrderExport").append("<input type='hidden' name='year' value='1'/><br/>");
<?php } ?>

//            $("#ByOrderExport").append("<input type='hidden' name='byorderIds' value=' " + chkvalues + " '/><br/>");
            $("#ByOrderExport").submit();
//alert(ids);


        });



        $(".fromDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".toDate").datepicker("option", "minDate", selected);
            }
        });

        $(".toDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".fromDate").datepicker("option", "maxDate", selected);
            }
        });



        $(".month").click(function () {
            $.ajax({
                type: "GET",
                url: "{{ URL::route('admin.sales.byorder')}}",
                data: {month: "MONTH"},
                cache: false,
                success: function (data)
                {


                }
            });
        });

        $(".year").click(function () {
            $.ajax({
                type: "GET",
                url: "{{ URL::route('admin.sales.byorder')}}",
                data: {month: "YEAR"},
                cache: false,
                success: function (data)
                {

                }
            });
        });

        $(".week").click(function () {
            $.ajax({
                type: "GET",
                url: "{{ URL::route('admin.sales.byorder')}}",
                data: {week: "WEEK"},
                cache: false,
                success: function (data)
                {

                }
            });
        });

    });



</script>
@stop