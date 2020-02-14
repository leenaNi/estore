@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Products ({{$productCount }})
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Running Sort</li>
    </ol>
</section>

<section class="main-content">
    <div class="notification-column">       
        @if(!empty(Session::get('message')))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('message') }}
        </div>
        @endif
        @if(!empty(Session::get('msg')))
        <div class="alert alert-success" role="alert">
            {{Session::get('msg')}}
        </div>
        @endif
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 no-padding">
                <div class="filter-full-section">
                    <form method="get" action=" " id="searchForm">
                       <div class="form-group col-md-4 col-sm-6 col-xs-12 noBottom-margin">
                        <input type="text" value="{{ !empty(Input::get('product_name'))?Input::get('product_name'):'' }}" name="product_name" aria-controls="editable-sample" class="form-control medium" placeholder="Search Product">
                        </div>
                        <div class="from-group col-md-2 col-sm-3 col-xs-12 mob-marBottom15 noBottom-margin">
                            <button type="submit" class="btn btn-primary fullWidth noAll-margin"> Search</button>
                       </div>
                       <div class="form-group col-md-2 col-sm-3 col-xs-12 mob-marBottom15 noBottom-margin">
                        <a href="{{route('admin.stock.runningShort')}}" class="btn reset-btn fullWidth noMob-leftmargin">Reset </a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Products <span class="listing-counter">{{$productCount }} </span> </h1>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr> 
                            <th class="text-center">Image</th>
                            <th class="text-left">@sortablelink ('product', 'Product')</th> 
                            <th class="text-right">@sortablelink ('selling_price', 'Price')</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         @if(count($products) >0)

                        @foreach($products as $product)
                        <tr> 
                            <td class="text-center"><img src="{{@$product->prodImage }}" class="admin-profile-picture" /></td>
                            <td class="text-left">{{$product->product }}</td> 
                            <td class="text-right"><?php echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert">  {{$product->selling_price }}</span></td>
                            <td class="text-center">
                                <div class="actionCenter">
                                    <span>
                                        <a class="btn-action-default active update-stock cursorPointer" data-prodId="{{$product->prod_type}}" data-prod-name="{{$product->prod_type==3?$product->subproduct:$product}}">Update Stock</a>
                                    </span>
                                </div> 
                            </td>
                        </tr>
                        @endforeach
                        @else
                       <tr><td colspan="4" class="text-center"> No Record Found.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <?php
            $args = [];
            if(empty(Input::get("product_name"))){
              echo $products->links();  
            }         
            ?>
        </div>
    </div>

</section>
 
    <!-- Modal --> 
      <div class="modal fade" id="update-stock-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <form class="form-horizontal" id="updateProdStock" method="post" action="{{route('admin.stock.updateProdStock')}}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="modal-title">Update Stock</h4>
                    </div>
                    <div class="modal-body" >
                        <input type="hidden" name="csrf-token" value="<?php echo csrf_token() ?>"/>
                       

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
<input type="hidden" id="page_type" value="main"/>
<div class="clearfix"></div>
@stop
@section('myscripts')
<script>

    ////////////////////////////////////////////////////
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('input[name="csrf-token"]').val()
        }
    });

    $('.update-stock').click(function () {
 var proId = $(this).attr('data-prodId');
        var prodName = $(this).attr('data-prod-name');
       var updateData='';
      
       $('.modal-body').empty();
      var prod= $.parseJSON(prodName);
       
        console.log(JSON.stringify(prod));
        if(proId==3){
            $.each(prod, function(key, value){
              
           updateData+='<input type="hidden" id="" name="prod-id[]" value="'+value.id+'" required/><div class="form-group"><div class="col-md-12"><label class="col-md-6">'+value.product+' </label><div class="col-md-3"><input min="1" type="number" class="form-control" name="stock[]" placeholder="Enter Stock" required/></div><label class="col-md-3">Current stock '+value.stock+'</label></div></div>';
                         
       
            })
            }else{
             updateData+='<input type="hidden" id="" name="prod-id[]" value="'+prod.id+'" required/><div class="form-group"><div class="col-md-12"><label class="col-md-6">'+prod.product+' </label><div class="col-md-2"><input min="1" type="number" class="form-control" name="stock[]" placeholder="Enter Stock" required/></div><label class="col-md-3">Current stock '+prod.stock+'</label></div></div>'; 
            }
        //$('#modal-title').html("Update Stock "+prodName);
        //$('#prod-id').val(proId);
        $('.modal-body').append(updateData);
        $('#update-stock-modal').modal('show');
    });

    $('html body').on('submit', '#updateProdStock', function () {
          $('#update-stock-modal').modal('hide');
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: new FormData(this),
            processData: false,
            contentType: false,
         //   dataType: 'json',
            beforeSend: function () {
                // $("#barerr" + id).text('Please wait');
            },
            success: function (result) {
                //alert(result);
                if(result){
                   
                    alert('Stock updated successfully.');
                   location.reload();
                } else {
                    alert("Oops something went wrong, Please try again later.");
                }
            }
        });
        return false;
    });

</script>
@stop


