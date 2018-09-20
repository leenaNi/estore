@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        By Orders ({{$orderCount }})
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">By Orders</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9 noBorder col-sm-12 col-xs-12">
                    <form method="get" action="{{URL::route('admin.sales.byorder')}}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" name="from_date" value="{{ @Input::get('from_date') }}" required="true"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" name="to_date" value="{{ @Input::get('to_date') }}"   required="true"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        </div>
                        <div class="form-group col-md-2 col-sm-6 col-xs-12">
                            <input type="submit" name="submit" class="form-control btn btn-primary noMob-leftmargin" value="Submit">
                        </div>
                         <div class="form-group col-md-2 col-sm-6 col-xs-12 noBottomMargin">
                         <a  href="{{route('admin.sales.byorder')}}" class="medium btn btn-block reset-btn" style="margin-left:0px">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <form method="post" id="ByOrderExport" action="{{ URL::route('admin.sales.export.order') }}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <input type="hidden" value="excelExport" name="excelExport">
                        <input type="hidden" name="from_date" value="{{ @Input::get('from_date') }}" required="true"  class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        <input type="hidden" name="to_date" value="{{ @Input::get('to_date') }}"   required="true"  class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        <input type="button" class="byorderExport btn btn-default pull-right col-md-12 mobAddnewflagBTN" value="Export">
                    </form>
                </div> 
               <div class="clearfix"></div>
                <div class="dividerhr"></div>
      

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
                              @if(count($order) >0)
                            @foreach($order as $od)
                            <tr>                                
<!--                                <td>{{ $od->id }}</td>-->
                                <td>{{date("d-M-Y",strtotime($od->created_at)) }}</td>
                                <td>{{ $od->order_count }}</td>
                                <td><?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';  ?> <span class="priceConvert"> 
                                        @if($od->prefix)
                                        {{ number_format($od->sales,2) }}
                                        @else 
                                        {{number_format($od->hasPayamt,2)}}
                                        @endif
                                    </span></td>
                            </tr>
                            @endforeach
                            @else
                           <tr><td colspan=6> No Record Found.</td></tr>
                            @endif
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