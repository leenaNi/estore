@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        By Orders
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">By Orders</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9 noBorder">
                    <form method="get" action="{{URL::route('admin.vendors.saleByOrder')}}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <div class="form-group col-md-4 noBottomMargin">
                            <input type="text" name="from_date" value="{{ @Input::get('from_date') }}" required="true"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        </div>
                        <div class="form-group col-md-4 noBottomMargin">
                            <input type="text" name="to_date" value="{{ @Input::get('to_date') }}"   required="true"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        </div>
                        <div class="form-group col-md-2 noBottomMargin">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="Submit">
                        </div>
                         <div class="form-group col-md-2 noBottomMargin">
                         <a  href="{{route('admin.vendors.saleByOrder')}}" class="medium btn btn-block reset-btn" style="margin-left:0px">Reset</a>
                        </div>
                    </form>
                </div>
                <!-- </div> -->
               <!--  <div class="box-header col-md-3 noBottomMargin">
                    <form method="post" id="ByOrderExport" action="{{ URL::route('admin.vendor.export.order') }}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <input type="hidden" value="excelExport" name="excelExport">
                        <input type="hidden" name="from_date" id="from_date" value="{{ @Input::get('from_date') }}" required="true"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        <input type="hidden" name="to_date" id="to_date" value="{{ @Input::get('to_date') }}"   required="true"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        <input type="button" class="byorderExport btn btn-default pull-right col-md-12" value="Export">
                    </form>
                </div>  -->
               <div class="clearfix"></div>
                <!-- <div class="dividerhr"></div> -->
            <div class="form-group col-md-4 ">
                        <div class="button-filter-search pl0">
                    {{$orderCount }} Order{{$orderCount > 1 ?'s':'' }}
                </div>
              </div> 
                <div style="clear: both"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table ByOrderSalesTable orderTable table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>                                
<!--                                <th>Id</th>-->
                                <th>Date</th>
                                <th>Order Count</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order as $od)
                            <tr>                                
<!--                                <td>{{ $od->id }}</td>-->
                                <td>{{date("d-M-Y",strtotime($od->created_at)) }}</td>
                                <td>{{ $od->order_count }}</td>
                                <td><i class='fa fa-rupee'></i> {{ number_format($od->sales) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <?php if (empty(Input::get('dateSearch'))) {
                       echo $order->links();
                    } ?> 

                </div>
            </div>
        </div>
    </div>

</section>
</div>
</div>

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