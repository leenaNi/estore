@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        By Attributes ({{$prodCount }})
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">By Attributes</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header box-tools filter-box col-md-9 noBorder  col-sm-12 col-xs-12">
                    <form method="get" action="{{URL::route('admin.sales.byattribute')}}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" name="from_date" value="{{ @Input::get('from_date') }}" class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" name="to_date" value="{{ @Input::get('to_date') }}" class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Product"/>
                        </div>
                        <div class="form-group col-md-2  col-sm-6 col-xs-12">
                            <input type="submit" name="submit" class="form-control btn btn-primary noMob-leftmargin" value="Search">
                        </div>
                        <div class="form-group col-md-2 col-sm-12 col-xs-12 noBottomMargin">
                           <a href="{{route('admin.sales.byattribute')}}" class="btn btn-block reset-btn noLeftMargin">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <form method="post" id="AttrExport" action="{{ URL::route('admin.sales.export.attribute') }}">
                        <input type="hidden" value="dateSearch" name="dateSearch">
                        <input type="hidden" name="from_date" value="{{ @Input::get('from_date') }}" class="form-control fromDate " placeholder="From Date" autocomplete="off" id="">
                        <input type="hidden" name="to_date" value="{{ @Input::get('to_date') }}" class="form-control toDate col-md-3" placeholder="To Date" autocomplete="off" id="">
                        <input type="hidden" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Product"/>
                        <input type="button" class="attrExport btn btn-default pull-right col-md-12 mobAddnewflagBTN" value="Export">
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
          
                
                <div class="box-body table-responsive no-padding">
                    <table class="table attrSalesTable  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                                <th>Sr No</th>-->
                                <th>Product</th>
                               
                                <th>Sub Products</th>
                                 <th>Category</th>
                                <th>Order Count</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(count($prods) >0)
                            @foreach($prods as $prd)
                            <?php  $qty='';
                            $sale='';
                            ?>
                            <tr>
<!--                                <td>{{ $prd->id }}</td>-->
                                <td>{{ $prd->product }}</td>
                              
                               <td>{{ @$prd->category }}</td>
                                <td>
                                    <ul>
                                        @foreach($prd->subproducts as $sub)
                                        <li>{{$sub->product}}</li>
                                 <?php foreach($sub->detials as $details){
                                       $qty.='<li>'.$details->qty.'</li>';  
                                      
                                       $sale.='<li>'.Session::get("currency_symbol").' <span class="priceConvert">'.$details->price.'</span> </li>';  
                                    
                                 } 
                               
                                 ?>
                                        @endforeach
                                    </ul>
                                </td>
                                
                                <td>
                                    <ul>
                                       <?php echo html_entity_decode($qty); ?>                     
                                    </ul>
                                </td>
                                <td>
                               <ul>
                                <?php echo html_entity_decode($sale); ?>                  
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                             @else
                           <tr><td colspan=6> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <?php   if(empty(Input::get('dateSearch'))){ ?>
                <div class="box-footer clearfix">
                    <?php
                    $args = [];
                    !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
                    !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
                    !empty(Input::get("order")) ? $args["order"] = Input::get("order") : '';

                    !empty(Input::get("from_date")) ? $args["from_date"] = Input::get("from_date") : '';
                    !empty(Input::get("to_date")) ? $args["to_date"] = Input::get("to_date") : '';
                    ?>
                    <?php echo $prods->appends($args)->links() ?>

                </div>
                <?php  } ?>
            </div>
        </div>
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
                $('.checkattrId').attr('Checked', 'Checked');
            } else {
                $('.checkattrId').removeAttr('Checked');
            }
        });


        $(".attrExport").click(function () {
            //alert("sgfsg");
//            var ids = $(".attrSalesTable input.checkattrId:checkbox:checked").map(function () {
//                return $(this).val();
//            }).toArray();
            //$("input[name='artistIds']").val(ids); 
            // alert(ids);
//            $("#AttrExport").append("<input type='hidden' name='attrIds' value=' " + ids + " '/><br/>");
            $("#AttrExport").submit();



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
