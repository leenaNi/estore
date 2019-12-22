@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Products fdsfasf

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
    <div class="nav-tabs-custom"> 
        {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">

                <div class="panel-body">
                    <div class="row ">
                        @if(!empty(Session::get('message')))<div class="col-md-12"><div class="alert alert-danger" role="alert">{{@Session::get('message')}}</div></div>@endif
                    </div>
                    <div class="row ">
                        @if(!empty(Session::get('msg')))<div class="col-md-12"><div class="alert alert-success" role="alert">{{@Session::get('msg')}}</div></div>@endif
                    </div>
                    <div class="row col-md-12">
                        {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'ProdV','class' => 'form-horizontal' ]) !!}
                        {!! Form::hidden('id',null) !!}
                        {!! Form::hidden('updated_by', Auth::id()) !!}
                        {!! Form::hidden('prod_id',$prod->id) !!}
                        <div class="ExistProdVAr">
                            <div class="row form-group col-md-12">
                                @foreach($attrs as $id => $attr)
                                <div class="col-md-3">
                                    {!! Form::label('select varient', 'Select ' . $attr['name'] ,['class'=>'control-label']) !!}
                                    {!! Form::select($id.'[]', $attr['options'] ,null,["class"=>'form-control']) !!}
                                </div>
                                @endforeach
                                <div class="col-md-2">
                                    {!! Form::label('price', 'Extra Price',['class'=>'control-label']) !!}
                                    {!! Form::text("price[]",0,["class"=>"form-control priceConvertTextBox"]) !!}
                                </div>

                                @if(($settingStatus['stock'] == 1 && $prod->prod_type == 3) && $prod->is_stock == 1 )
                                
                                <div class="col-md-2">
                                    {!! Form::label('stock', 'Stock',['class'=>'control-label']) !!}
                                    {!! Form::number("stock[]",0,["class"=>"form-control"]) !!}
                                </div>
                              
                                @else
                                 {!! Form::hidden("stock[]",0,["class"=>"form-control"]) !!}
                                @endif
                                <div class="col-md-2">
                                    {!! Form::label('is_avail', 'Availability',['class'=>'control-label']) !!}
                                    {!! Form::select("is_avail[]",['1'=>'Yes','0'=>'No'],null,["class"=>"form-control"]) !!}
                                </div>
                                {!! Form::hidden("id[]",null) !!}
                                <div class="col-md-2">
                                    <a href="javascript:void();" class="addNewProd"><span class="label label-success label-mini">Add</span></a>
                                </div>
                            </div>  
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group col-sm-12 ">
                            {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                            {!! Form::submit('Save & Exit',["class" => "btn btn-primary pull-right saveProdVExit"]) !!}
                            {!! Form::submit('Save & Continue',["class" => "btn btn-primary pull-right saveProdVContine"]) !!}
                            {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right saveProdVNext"]) !!}
                        </div>
                        {!! Form::close() !!}
                          <div class="form-group col-sm-12 ">
                          <a href="{!! route('admin.product.vendors',['id'=>$prod->id]) !!}"><button class="btn pull-right btn btn-warning skipVarient"    style="margin-right: 2%;" >Skip</button></a>
                         </div>
                    </div>
                </div>
                <div class="toAdd"  style="display:none;">
                    <div class="row form-group col-md-12">
                        @foreach($attrs as $id => $attr)
                        <div class="col-md-3">
                            {!! Form::label('select varient', 'Select ' . $attr['name'] ,['class'=>'control-label']) !!}
                            {!! Form::select($id.'[]', $attr['options'] ,null,["class"=>'form-control']) !!}
                        </div>
                        @endforeach

                        <div class="col-md-2">
                            {!! Form::label('price', 'Extra Price',['class'=>'control-label']) !!}
                            {!! Form::text("price[]",0,["class"=>"form-control priceConvertTextBox"]) !!}
                        </div>
                        @if(($settingStatus['stock'] == 1 && $prod->prod_type == 3) && $prod->is_stock == 1 )
                         
                        <div class="col-md-2">
                            {!! Form::label('stock', 'Stock',['class'=>'control-label']) !!}
                            {!! Form::number("stock[]",null,["class"=>"form-control"]) !!}
                        </div>
                         @else
                         {!! Form::hidden("stock[]",0,["class"=>"form-control"]) !!}
                         @endif
                        <div class="col-md-2">
                            {!! Form::label('is_avail', 'Availability',['class'=>'control-label']) !!}
                            {!! Form::select("is_avail[]",['1'=>'Yes','0'=>'No'],null,["class"=>"form-control"]) !!}
                        </div>
                       
                        {!! Form::hidden("id[]",null) !!}
                        <div class="col-md-2">
                            <a href="javascript:void();" class="DelProd"><span class="label label-danger ">Delete</span></a>
                        </div>
                    </div>  
                </div>
                <div class="bg-light lter b-b wrapper-md">
                    <h1 class="m-n font-thin h3">Product Variants</h1>
                    @if($settingStatus['18'] == 1)
                    @if($barcode == 1)
                    <button id="print_all" data-toggle="modal" data-target="#myModal">Print Barcode</button>
                    @endif
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                @if($barcode == 1)   <th><input type="checkbox" id="masterCheck" value="00"/></th>  @endif
                                <th>Product</th>
                                <th>Availability</th>
                                <th>Price</th>
                                @if($settingStatus['stock'] == 1 && $prod->prod_type == 3 && $prod->is_stock == 1)
                                
                                <th>Stock</th>
                              
                                @endif

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prodVariants as $prd)

                            <tr>
                                @if($barcode == 1)  <td><input type="checkbox" class="singleCheck" name="singleCheck[]" value="{{ $prd->id }}"/></td>  @endif
                                <td>{{ $prd->product }}</td>
                                <td>{{ $prd->is_avail == 1 ? "Yes" : "No" }}</td>
                                <td><span class="priceConvert">{{ $prd->price }}</span></td>
                                @if($settingStatus['stock'] == 1 && $prod->prod_type == 3 && $prod->is_stock == 1)
                               
                                <td>{{ $prd->stock }}</td>
                               
                                @endif
                                <td>
                                    <a href="{!! route('admin.products.variant.update',['id'=>$prd->id]) !!}" class="label label-success active" ui-toggle-class="" target="_blank">Edit</a>
                                    @if($prd->status==1)
                                    <a href="{!! route('admin.products.changeStatus',['id'=>$prd->id]) !!}" class="label label-info active" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this variant?')">Enabled</a>
                                    @elseif($prd->status==0)
                                    <a href="{!! route('admin.products.changeStatus',['id'=>$prd->id]) !!}" class="label label-danger active" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this variant?')">Disabled</a>
                                    @endif
                                    <a href="{!! route('admin.products.deleteVarient',['id'=>$prd->id]) !!}" class="label label-danger active" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this variant?')">Delete</a>
                                @if($settingStatus['18'] == 1)
                                    @if($barcode == 1)   <button class="genBarcode barcode_print" title="Generate Barcode" data-id="{{ $prd->id }}">Generate</button><button class="barcode_print bprint" data-toggle="modal" title="Print Barcode" data-target="#myModal" data-id="{{ $prd->id }}">Print</button>
                                    <span id="barerr{{ $prd->id }}"></span>
                                    @endif
                                     @endif
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-4 text-right text-center-xs pull-right">                

                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <form id="get_quantity"  method="post" action="">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Product Print Quantity</h4>
                        </div>
                        <div class="modal-body" >
                            <input type="hidden" name="csrf-token" value="<?php echo csrf_token() ?>"/>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="print_loop">
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default" >Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                    <span id="tempHtml"></span>
                </div>

            </div>
        </div>
    </div>
</section>
<input type="hidden" id="page_type" value="var"/>
@stop 

@section('myscripts')

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('input[name="csrf-token"]').val()
        }
    });

//new FormData(this)
    $('html body').on('submit', '#get_quantity', function () {
        $.ajax({
            url: "{{ route('admin.products.barcodeForm') }}",
            type: 'post',
            data: new FormData(this),
            processData: false,
            contentType: false,
            //   dataType: 'json',
            beforeSend: function () {
                // $("#barerr" + id).text('Please wait');
            },
            success: function (res) {
                window.location.href = "{{ route('admin.products.downloadbarcode') }}?url=" + res;
            }
        });
        return false;
    });
    $('#masterCheck').click(function (event) {
        if ($(this).is(':checked')) {
            $('.singleCheck').attr('Checked', 'Checked');
            ;
        } else {
            $('.singleCheck').removeAttr('Checked');
            ;
        }
    });
//
//$("#masterCheck").change(function() {
//    $(".singleCheck").attr("checked", this.checked);
//});

    $(".singleCheck").change(function () {
        $("#masterCheck").attr("checked", $(".singleCheck:checked").length == $(".singleCheck").length);
    });
//$("#masterCheck").change(function(){
//    if ($(this).prop('checked')) {
//        $(".singleCheck").attr("checked","checked");
//}else{
//    $(".singleCheck").removeAttr("checked");
//}
//});



//    $('.genBarcode').hover(function () {
//        $(this).text('Generate Barcode');
//    }, function () {
//        $(this).text('Generate');
//    });
//
//    $('.bprint').hover(function () {
//        $(this).text('Print Barcode');
//    }, function () {
//        $(this).text('Print');
//    });


    $("#print_all").click(function () {
        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
            return n.value;
        }).join(',');
        get_print_form(ids);
    });

    $(".bprint").click(function () {
        var id = $(this).attr("data-id");
        get_print_form(id);
    });


    function get_print_form(id) {

        $.ajax({
            data: "id=" + id + "&pt=" + $("#page_type").val(),
            type: 'post',
            url: "{{ route('admin.products.printBarcode') }}",
            dataType: 'json',
            beforeSend: function () {
                $("#print_loop").text('Please wait');
                $("#barerr" + id).text('Please wait');
            },
            success: function (res) {
                $("#barerr" + res.id).text('');
                var str = '';
                $.each(res, function (index, val) {
                    $("#barerr" + val.id).text('');
                    str += '<tr>';
                    str += '<td>' + val.product + '</td>';
                    str += '<td>';
                    //              str += '<input type="hidden" name="proId[]" value="' + val.id + '"/>';
                    str += '<input type="hidden" name="product[' + val.product + '][id]" value="' + val.id + '"/>';
                    str += '<input type="hidden" name="product[' + val.product + '][barcode]" value="' + val.barcode + '"/>';
                    str += '<input type="number"  min="1" name="product[' + val.product + '][quantity]" /></td>';
                    str += '</tr>';
                });
                $("#print_loop").html(str);
            }
        });
    }

    $(".genBarcode").click(function () {
        var id = $(this).attr("data-id");

        $.ajax({
            data: "id=" + id,
            type: 'post',
            url: "{{ route('admin.products.generateBarcode') }}",
            dataType: 'json',
            beforeSend: function () {
                $("#barerr" + id).text('Please wait');
            },
            success: function (res) {
                $("#barerr" + res.id).text('Barcode Generated');
                setTimeout(function () {
                    $("#barerr" + res.id).text('');
                }, 3000);
            }
        });
    });

    $(".saveProdVExit").click(function () {
        $(".rtUrl").val("{!!route('admin.products.view')!!}");
        $("#ProdV").submit();

    });

    $(".saveProdVContine").click(function () {
      
        $(".rtUrl").val("{!!route('admin.products.configurable.attributes',['id'=>$prod->id])!!}");
        $("#ProdV").submit();

    });
    
    $(".saveProdVNext").click(function () {
         var prod_type = "{{ $prod->prod_type }}";
         var like_product = "{{ $feature['like-product'] }}";
         var sco = "{{ $feature['sco'] }}";
         var storeversion = "{{ $store_version_id }}";
         var related_prod = "{{ $feature['related-products']}}";
        var feature = '<?= $feature["market-place"] ?>';
         if(feature == 1){
             $(".rtUrl").val("{!!route('admin.product.vendors',['id'=>$prod->id])!!}");  
           
            }else if(feature == 0 && related_prod==1 ){
              $(".rtUrl").val("{!! route('admin.products.upsell.related',['id' => $prod->id]) !!}");  
                
            }else if(feature==0 && like_product==1){
                $(".rtUrl").val("{!! route('admin.products.upsell.product',['id'=>$prod->id])!!}");  
               
            }else if(feature==0 && sco==1 && storeversion==2){
               $(".rtUrl").val("{!! route('admin.products.prodSeo',['id'=>$prod->id])!!}");   
            }else{
                 $(".rtUrl").val("{!!route('admin.products.view')!!}");
            }
            
       
          $("#ProdV").submit();
    });
    
    $("body").on("click", ".addNewProd", function () {
        $(".ExistProdVAr").append($(".toAdd").html());
    });
    $("body").on("click", ".DelProd", function () {

        $(this).parent().parent().remove();

    });


</script>
@stop