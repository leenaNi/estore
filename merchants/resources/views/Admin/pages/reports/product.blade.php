@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Products Report
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">C</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="dividerhr"></div>
                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category Name</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($prods as $pr)
                            <tr>
                                <td>{{ $pr->product }}</td>
                                <td>{{ $pr->category  }}</td>
                                <td>
                                    <a class="label label-default prod-data" data-name="{{$pr->product}}" id="productId">{{ $pr->tot_qty }}</a>
                                </td>
                                <td>{{ $pr->sales }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
</section>
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
