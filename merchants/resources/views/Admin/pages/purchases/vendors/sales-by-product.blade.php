@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        By Products 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">By Products</li>
    </ol>
</section>
<?php // dd('hii'); ?>

<section class="main-content">     
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 no-padding">
                <div class="filter-full-section">
                    <form method="get" action="{{ route('admin.vendors.saleByProduct')}}">
                        <input type="hidden" value="dateSearch" name="dateSearch"> 
                        <div class="form-group col-md-4 noBottomMargin">
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Product"/>
                        </div>

                        <div class="form-group col-md-2 noBottomMargin">
                            <input type="submit" name="submit" class="btn btn-primary noAll-margin fullWidth" value="Submit">
                        </div>
                       <div class="form-group col-md-2 noBottomMargin">
                         <a  href="{{route('admin.sales.byproduct')}}" class="medium btn btn-block fullWidth reset-btn">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Product{{$prodCount > 1 ?'s':'' }} <span class="listing-counter"> {{$prodCount }} </span> </h1>  
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding"> 
                <table class="table  prodSalesTable  table-hover general-table tableVaglignMiddle">
                <thead>
                    <tr> 
                        <th class="text-left">Product</th>
                        <th class="text-left">Category</th>
                        <th class="text-center">Quantity Sold</th>
                        <th class="text-right">Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prods as $prd)

                    <tr>
                        @if(@$prd->prod_type == 1)
                            <td class="text-left">{{ @$prd->product->product }}</td>
                        @elseif(@$prd->prod_type == 3)
                            <td class="text-left">{{ @$prd->subProduct->product }}</td>
                        @else
                          <td></td>
                        @endif
                      
                        <td class="text-left">{{ @$prd->product->categories()->first()->category }}</td>
                        <td class="text-center">
                            <?php
                            $sales = $prd->product->sales();

                            if (!empty(Input::get('from_date')) && !empty(Input::get('to_date'))) {
                                $sales = $sales->whereBetween('has_products.created_at', [ Input::get('from_date'), Input::get('to_date') . " 23:59:59"]);
                            }

                             echo $sales->sum('qty');
                            ?>

                        </td>
                        <td class="text-right">
                            <?php
                            echo number_format($sales->sum('price'), 2);
                            ?>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
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
