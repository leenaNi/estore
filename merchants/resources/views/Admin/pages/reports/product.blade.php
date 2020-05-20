@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Products Sales Report 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Reports</a></li>
        <li class="active">Products Sales Report</li>
    </ol>
</section>

<section class="main-content"> 
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-12 noAll-padding displayFlex">
                <div class="filter-left-section"> 
                     <form method="get" action=" " id="searchForm">
                        <input type="hidden" name="attrSetCatalog"> 
                        <div class="form-group noBottom-margin col-md-4 col-sm-4 col-xs-12">
                            <div class="input-group">
                            <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                            <input type="text" value="{{ !empty(Input::get('product_name'))?Input::get('product_name'):'' }}" name="product_name" aria-controls="editable-sample" class="form-control form-control-right-border-radius medium" placeholder="Product Name">
                        </div>
                        </div> 
                        <div class="form-group noBottom-margin col-md-4 col-sm-4 col-xs-12">
                            {!! Form::select('category',$categrs,Input::get('category'), ["class"=>'form-control filter_type', "placeholder"=>"Category"]) !!}
                        </div> 
                        <div class="form-group noBottom-margin col-md-4 col-sm-4 col-xs-12">
                            <a href="{{ route('admin.report.productIndex')}}" class="btn reset-btn noMob-leftmargin pull-right mn-w100">Reset </a>
                            <button type="submit" name="submit" vlaue='Filter' class='btn btn-primary noAll-margin pull-right marginRight-sm mn-w100'>Filter</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Products Sales Report </h1>            
            <a href="{!! route('admin.report.productIndexExport') !!}" class="btn btn-listing-heading pull-right noAll-margin" target="_">Export</a>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr>
                            <th class="text-left">Product Name</th>
                            <th class="text-left">Category Name</th>
                            <th class="text-center">Quantity Sold</th>
                            <th class="text-right">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($prods)>0)
                            @foreach($prods as $pr)
                            <tr>
                                <td class="text-left">{{ $pr->product }}</td>
                                <td class="text-left">{{ $pr->category  }}</td>
                                <td class="text-center">
                                    <a class="label label-default prod-data" data-name="{{$pr->product}}" id="productId">{{ $pr->tot_qty }}</a>
                                </td>
                                <td class="text-right">{{ $pr->sales }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td colspan="4" class="text-center"> No Data Found </td></tr>
                        @endif

                    </tbody>
                </table>
                {{ $prods->links() }}
            </div>
        </div>
    </div>

</section>


 
  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Report</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Sub Total</th>
                        <th>Total Order Amount</th>
                    </tr>
                </thead>
                <tbody id="print_loop">
                </tbody>
            </table>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
@stop
@section('myscripts')
<script>
    $('.prod-data').on('click', function(){
        var prodName = $(this).attr('data-name');
        console.log(prodName);
        $('#myModal').modal('show');
        $.ajax({
            type:"GET",
            url: "{{route('admin.report.categoryWise')}}",
            data: "name=" + prodName,
            dataType: 'json',
            success : function(results) {
                            var str = '';
                            $.each(results, function (index, val) {
                                str += '<tr>';
                                str += '<td>' + val.order_id + '</td>';
                                str += '<td>' + val.first_name + ' ' + val.last_name +'</td>';
                                str += '<td>' + val.order_date + '</td>';
                                str += '<td>' + val.orders[0].qty +'</td>';
                                str += '<td>' + val.orders[0].price +'</td>';
                                str += '<td>' + val.orders[0].subtotal +'</td>';
                                str += '<td>' + val.order_amount +'</td>';
                                str += '</tr>';
                            });
                            $("#print_loop").html(str);
            }
        });   
    });
</script>
@stop
