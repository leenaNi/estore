@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        By Products
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">By Products</li>
    </ol>
</section>
<?php // dd('hii'); ?>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9 noBorder ">
                    <form method="get" action="{{ route('admin.vendors.saleByProduct')}}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <!-- <div class="form-group col-md-4">
                            <input type="text" name="from_date" value="{{ !empty(Input::get('from_date'))?Input::get('from_date'):'' }}" class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        </div> -->
                        <!-- <div class="form-group col-md-4">
                            <input type="text" name="to_date" value="{{ !empty(Input::get('to_date'))?Input::get('to_date'):'' }}" class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        </div> -->
                        <div class="form-group col-md-4">
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Product"/>
                        </div>

                        <div class="form-group col-md-2 noBottomMargin noAllpadding">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="Submit">
                        </div>
                       <div class="form-group col-md-2 noBottomMargin">
                         <a  href="{{route('admin.sales.byproduct')}}" class="medium btn btn-block reset-btn" style="margin-left:0px">Reset</a>
                        </div>
                    </form>
                </div>
               <!--  <div class="box-header col-md-3">
                    <form method="post" id="ProdExport" action="{{ route('admin.sales.export.product') }}">

                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <input type="hidden" name="from_date" value="{{ !empty(Input::get('from_date'))?Input::get('from_date'):'' }}" class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        <input type="hidden" name="to_date" value="{{ !empty(Input::get('to_date'))?Input::get('to_date'):'' }}" class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        <input type="hidden" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Product"/>
                        <input type="button" class="prodExport btn btn-default pull-right col-md-12" value="Export">
                    </form>
                </div>  -->
                <div class="clearfix"></div>
                <!-- <div class="dividerhr"></div> -->
            <div class="form-group col-md-4 ">
                        <div class="button-filter-search pl0">
                    {{$prodCount }} Product{{$prodCount > 1 ?'s':'' }}
                </div>
              </div> 
                <div style="clear: both"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table  prodSalesTable  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                                <th>Sr No</th>-->
                                <th>Product</th>
                                <th>Category</th>
                                <th>Quantity Sold</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prods as $prd)

                            <tr>
                                @if(@$prd->prod_type == 1)
                                    <td>{{ @$prd->product->product }}</td>
                                @elseif(@$prd->prod_type == 3)
                                    <td>{{ @$prd->subProduct->product }}</td>
                                @else
                                  <td></td>
                                @endif
                              
                                <td>{{ @$prd->product->categories()->first()->category }}</td>
                                <td>
                                    <?php
                                    $sales = $prd->product->sales();

                                    if (!empty(Input::get('from_date')) && !empty(Input::get('to_date'))) {
                                        $sales = $sales->whereBetween('has_products.created_at', [ Input::get('from_date'), Input::get('to_date') . " 23:59:59"]);
                                    }

                                     echo $sales->sum('qty');
                                    ?>

                                </td>
                                <td>
                                    <?php
                                    echo number_format($sales->sum('price'), 2);
                                    ?>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <?php
                    if (empty(Input::get('from_date')) &&
                            empty(Input::get('to_date')) &&
                            empty(Input::get('search'))
                    ) {
                        ?>
                    </div>
                    <div class="box-footer clearfix">
                        <?php
                        $args = [];
                        !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
                        !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
                        !empty(Input::get("order")) ? $args["order"] = Input::get("order") : '';

                        !empty(Input::get("from_date")) ? $args["from_date"] = Input::get("from_date") : '';
                        !empty(Input::get("to_date")) ? $args["to_date"] = Input::get("to_date") : '';
                        ?>
                    <?= $prods->appends($args)->links() ?>

                    </div>
<?php } ?>
            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')
<script>
    $(document).ready(function () {


        $('#checkAll').click(function (event) {

            var checkbox = $(this),
                    isChecked = checkbox.is(':checked');
            if (isChecked) {
                $('.checkprodId').attr('Checked', 'Checked');
            } else {
                $('.checkprodId').removeAttr('Checked');
            }
        });



        $(".prodExport").click(function () {
            //alert("sgfsg");
            var ids = $(".prodSalesTable input.checkprodId:checkbox:checked").map(function () {
                return $(this).val();
            }).toArray();
            //$("input[name='artistIds']").val(ids); 
//            $("#ProdExport").append("<input type='hidden' name='prodIds' value=' " + ids + " '/><br/>");
            $("#ProdExport").submit();



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



        $(".delete").click(function () {
            var r = confirm("Are You Sure You want to Delete this Category & All its Products?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop
