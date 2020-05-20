@extends('Admin.layouts.default')
@section('mystyles')

<link rel="stylesheet" href="{{ Config('constants.adminDistCssPath').'/jquery.tagit.css' }}">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/select2/select2.min.css' }}">

@stop

@section('content')

<section class="content-header">
    <div class="flash-message"><b>{{ Session::get("ProductCode") }} {{ Session::get("errorMessage") }}</b></div>
    <h1>
        Add/Edit Product

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
                    <div class="row">
                    </div>
                    <div class="row"> 
                        {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'EditGeneralInfo']) !!}
                        {!! Form::hidden('id',null) !!}
                        {!! Form::hidden('updated_by', Auth::id()) !!}

                        <div class="col-md-12">
                            <div class="box box-solid boxNew">
                                <div class="box-header boxHeaderNew with-border">
                                    <h3 class="box-title">Basic Details</h3>
                                </div>
                                <div class="box-body text-center">
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">     
                                                {!! Form::label('Status', 'Status',['class'=>'pull-left col-md-2 noLeftpadding text-left']) !!}
    
                                                <div class="checkbox pull-left col-md-2">
                                                    <label class="Nocheckbox-highlight">
                                                        <input type="checkbox"> Active
                                                    </label>
                                                </div> 
                                                <div class="checkbox pull-left col-md-2">
                                                    <label class="Nocheckbox-highlight">
                                                        <input type="checkbox"> Inactive
                                                    </label>
                                                </div>
                                            </div>
                                        </div>  -->
                                        <div class="col-md-3">
                                            <div class="form-group"> 
                                                {!! Form::label('Status', 'Status ',['class'=>'pull-left']) !!}
                                                <span class="red-astrik pull-left ml-2">*</span>
                                                {!! Form::select('status',["0"=>"Disabled", "1"=>"Enabled"] ,null, ["class"=>'form-control validate[required]']) !!}
                                               <!--  <p style="color: red;" class="errorPrdCode"></p> -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('product', 'Product Name ',['class'=>'pull-left']) !!}
                                                <span class="red-astrik pull-left ml-2">*</span>
                                                {!! Form::text('product',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Product Name']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">                       
                                                {!! Form::label('product Code', 'Product Code ',['class'=>'pull-left']) !!}

                                                {!! Form::text('product_code',null, ["class"=>'form-control ProdC' ,"placeholder"=>'Enter Product Code']) !!}
                                                <p style="color: red;" class="errorPrdCode"></p>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">                       
                                                {!! Form::label('Brand *', 'Brand *',['class'=>'pull-left']) !!}
                                                {{-- {!! Form::select('brand_id',$brandList,null, ["class"=>'form-control' ,"placeholder"=>'Select Brand']) !!} --}}
                                                <select class="form-control" name="brand_id" id="brand_id" required>
                                                     @foreach($brandList as $brandId=> $brandName)
                                                        @if($brandId == $prod->brand_id)
                                                            <option value="{{$brandId}}" selected>{{$brandName}}</option>
                                                        @else
                                                            <option value="{{$brandId}}">{{$brandName}}</option>
                                                        @endif
                                                    @endforeach 
                                                </select>
                                                <p style="color: red;" class="errorBrandId"></p>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12">
        
                                            <div class="form-group">                       
                                                {!! Form::label('short_desc', 'Description',['class'=>'pull-left']) !!}<br><br>
                                                {!! Form::textarea('short_desc',$prod->short_desc ,["class"=>'form-control pull-left',"placeholder"=>"Enter Short Description", "id"=>"editor1",  "rows" => "1"]) !!}
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        @if($is_desc->status)
                                        <div class="col-md-12">
                                            <div class="form-group">                       
                                                {!! Form::label('long_desc', 'Additional Description',['class'=>'pull-left']) !!}<br><br>
                                                {!! Form::textarea('long_desc',null,["class"=>'form-control pull-left',"placeholder"=>"Enter Description", "id"=>"editor2", "rows" => "1"]) !!}
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <!--                                <div class="col-md-12">
                                                                            <div class="form-group">                       
                                                                                {!! Form::label('add_desc', 'Additional Description',['class'=>'pull-left']) !!}<br><br>
                                                                                {!! Form::textarea('add_desc',null,["class"=>'form-control editor pull-left',"placeholder"=>"Enter Additional Description", "rows" => "1"]) !!}
                                                                            </div>
                                                                        </div>-->
                                        @endif
                                        <!--                                <div class="col-md-6">
                                                                            <div class="form-group">                        
                                                                                {!! Form::label('url_key', 'URL Key ',['class'=>'pull-left']) !!}
                                                                              <span class="red-astrik pull-left ml-2">*</span>
                                                                                {!! Form::text('url_key',null,["class"=>'form-control validate[required]',"placeholder"=>"Enter URL Key"]) !!}
                                                                            </div>
                                                                        </div>-->
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                {!! Form::label('product_tags', 'Product Tags',['class'=>'pull-left']) !!}
                                                <ul id="myTags" class="pull-left full-width">
                                                    @foreach($prod->tagNames() as $tag)
                                                    <li>{{ $tag }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <!--                                <div class="clearfix"></div>-->
                                        <div class="col-md-6">
                                            <div class="form-group">                       
                                                {!! Form::label('is_trending', ' Mark as Trending?',['class'=>'pull-left']) !!}<br><br>
                                                {!! Form::select('is_trending',['0' => 'No','1' => 'Yes'], null,["class"=>'form-control pull-left validate[required]']) !!}
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('length', 'Length(cm)',['class'=>'pull-left']) !!}
                                                {!! Form::text('length',null, ["class"=>'form-control validate[custom[number]]',"placeholder"=>'Enter Length']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('width', 'Width(cm)',['class'=>'pull-left']) !!}
                                                {!! Form::text('width',null, ["class"=>'form-control validate[custom[number]]',"placeholder"=>'Enter Width']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('weight', 'Weight(kg) ',['class'=>'pull-left']) !!}
                                                {!! Form::text('weight',null, ["class"=>'form-control validate[custom[number]]',"placeholder"=>'Enter Weight']) !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="box box-solid boxNew">
                                <div class="box-header boxHeaderNew with-border">
                                    <h3 class="box-title">Pricing Details</h3>
                                </div>
                                <div class="box-body text-center">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">                        

                                                {!! Form::label('MRP/Listing Price', 'MRP/Listing Price ',['class'=>'pull-left']) !!}
                                                <span class="red-astrik pull-left ml-2">*</span>
                                                @if($prod->prod_type != 2)
                                                {!! Form::text('price',null,["class"=>'form-control priceConvertTextBox validate[required,custom[number]] priceConvertTextBox',"placeholder"=>"Max Price"]) !!}
                                                @else
                                                {!! Form::text('price',null,["class"=>'form-control priceConvertTextBox validate[required,custom[number]] priceConvertTextBox',"placeholder"=>"Max Price", "readonly"]) !!}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">                      
                                                {!! Form::label('Selling Price', 'Selling Price',['class'=>'pull-left']) !!}
                                                @if($prod->prod_type != 2)
                                                {!! Form::text('spl_price',null,["class"=>'form-control priceConvertTextBox  validate[custom[number]]',"placeholder"=>"Selling Price"]) !!}
                                                @else
                                                {!! Form::text('spl_price',null,["class"=>'form-control priceConvertTextBox  validate[custom[number]]',"placeholder"=>"Selling Price", "readonly"]) !!}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">                        
                                                {!! Form::label('Purchase Price', 'Purchase Price ',['class'=>'pull-left']) !!}
                                                <span class="red-astrik pull-left ml-2">*</span>
                                                {!! Form::text('purchase_price',null,["class"=>'form-control priceConvertTextBox validate[required,custom[number]] priceConvertTextBox',"placeholder"=>"Purchase Price"]) !!}
                                            </div>
                                        </div>

                                        @if($feature['tax']==1)  
                                        <div class="col-md-12">
                                            <div class="form-group"> 
                                                <label class="pull-left"> {!! Form::radio('is_tax',1,null,['checked']) !!} Inclusive of Tax </label>  
                                                <label class="marginleft20">{!! Form::radio('is_tax',2,null,[]) !!} Exclusive of Tax </label>

                                                <label class="pull-right">{!! Form::radio('is_tax',0,null,[]) !!} No Tax </label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 applicable-tax">
                                            <div class="form-group">                        
                                                {!! Form::label('Applicable Tax', 'Applicable Tax',['class'=>'pull-left']) !!}
                                                {!! Form::select('applicable_tax[]',$taxes, $selected_taxes, ["class"=>'form-control select2', "multiple" => "True",'placeholder' => 'Please Select Taxes']) !!}
                                            </div>
                                        </div>
                                        @else 
                                        <input type="hidden" name ='is_tax' value ='0'>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                       @if($prod->prod_type == 1 && $feature['stock'] == 1 && $prod->is_stock == 1)
                        <div class="col-md-12">
                            <div class="box box-solid boxNew">
                                <div class="box-header boxHeaderNew with-border">
                                    <h3 class="box-title">Inventory Details</h3>
                                </div>
                                <div class="box-body text-center">
                                   
                                    <div class="row">                               
                                        <!-- <div class="col-md-12"> -->

                                        <div class="col-md-6">
                                            <div class="form-group">                        
                                                {!! Form::label('Stock', 'Stock ',['class'=>'pull-left']) !!}
                                                <span class="red-astrik pull-left ml-2">*</span>
                                                {!! Form::number('stock',null,["class"=>'form-control validate[required,custom[number]]', "min"=>'0', "placeholder"=>"Stock"]) !!}
                                            </div>
                                        </div>

                                        <!-- <div class="row"> -->
                                        @if($feature['minimum-order']==1)
                                        <div class="col-md-6">
                                            <div class="form-group">                        
                                                {!! Form::label('minimum order quantity', 'Minimum Order Quantity ',['class'=>'pull-left']) !!}<span class="red-astrik">*</span>

                                                {!! Form::number('min_order_quantity',null,["class"=>'form-control validate[required,custom[number]]', "min"=>'0', "placeholder"=>"Minimum Order Quantity"]) !!}
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                       
                                    </div>
                                    @endif
                                    <!-- <div class="col-md-6">
                                        <div class="form-group"> 
                                            {!! Form::label('Status', 'Status',['class'=>'pull-left']) !!}
                                            {!! Form::select('status',["0"=>"Inactive", "1"=>"Active"] ,null, ["class"=>'form-control']) !!}
                                            <p style="color: red;" class="errorPrdCode"></p>
                                        </div>
                                    </div> -->
                                    @if($feature['barcode'] ==1 && $prod->prod_type == 1 ||$prod->prod_type == 7 || $prod->prod_type == 5)

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label name="barcode" class="pull-left full-width text-left">Barcode  <span class="red-astrik ml-2">*</span></label>
                                                <!--                                         {!! Form::label('barcode', 'Barcode ',['class'=>'pull-left full-width text-left']) !!}-->
                                                <!--                                        <span class="red-astrik pull-left ml-2">*</span>-->
                                                {!! Form::select('barcode_select',["0"=>"System generated", "1"=>"Capture"] ,null, ["class"=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">                       
                                                <label name="barcode" class="pull-left full-width text-left">&nbsp;</label>
                                                {!! Form::text('barcode',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Barcode code']) !!}
                                                <p style="color: red;" class="errorPrdCode"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($prod->prod_type == 7)
                            <div class="row">
                                <div class="form-group"> 
                                    <div class="col-md-6">
                                        {!! Form::label('is_avail', 'Availability',['class'=>'pull-left']) !!}
                                        {!! Form::select("is_avail",['1'=>'Yes','0'=>'No'],null,["class"=>"form-control"]) !!}
                                    </div>
                                </div>
                            </div>
                            @endif   
                        </div>
                        @if($feature['product-daimention']==1)
                        <div class="col-md-12">
                            <div class="box box-solid boxNew">
                                <div class="box-header boxHeaderNew with-border">
                                    <h3 class="box-title"><input type="checkbox" name="colorCheckbox" value="red"> Dimension Details</h3>
                                </div>
                                <div class="box-body text-center red boxhide" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">                        
                                                {!! Form::label('Unit of Measure', 'Unit of Measure',['class'=>'pull-left']) !!}
                                                {!! Form::select('unit_measure',$unit_measure, null,["class"=>'form-control',"placeholder"=>"UOM"]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">                       
                                                {!! Form::label('Height', 'Height',['class'=>'pull-left']) !!}
                                                {!! Form::text('height',null,["class"=>'form-control decimal',"placeholder"=>"Height (CM)"]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">                       
                                                {!! Form::label('Width', 'Width',['class'=>'pull-left']) !!}
                                                {!! Form::text('width',null,["class"=>'form-control decimal',"placeholder"=>"Width (CM)"]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">                        
                                                {!! Form::label('length', 'Length',['class'=>'pull-left']) !!}
                                                {!! Form::text('length',null,["class"=>'form-control decimal',"placeholder"=>"Length (CM)"]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">                        
                                                {!! Form::label('Weight', 'Weight',['class'=>'pull-left']) !!}
                                                {!! Form::text('weight',null,["class"=>'form-control decimal',"placeholder"=>"Weight (KG)"]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endif
                        <!-- </div> -->


                        <!-- <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">                        
                            {!! Form::label('long_desc', 'Long Description',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('long_desc',null,["class"=>'form-control editor',"placeholder"=>"Enter Details", "rows" => "4"]) !!}
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">                        
                            {!! Form::label('Additional Details', 'Additional Information',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('add_desc',null,["class"=>'form-control editor',"placeholder"=>"Remarks", "rows" => "4"]) !!}
                            </div>
                        </div> -->


                        <!-- <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">                        
                            {!! Form::label('Sort Order', 'Sort Order',['class'=>'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::number('sort_order',null, ["class"=>'form-control' ,"placeholder"=>'Sort Order']) !!}
                            </div>
                        </div> -->
                        <!--                    <div class="form-group">                        
                                                {!! Form::label('Currency', 'Currency',['class'=>'control-label col-sm-2']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::text('cur',null,["class"=>'form-control']) !!}
                                                </div>
                                            </div>-->


                        @if($prod->prod_type == 5)
                        <div class="col-md-6">
                            <div class="form-group">                        
                                {!! Form::label('No of times allowed', 'No of times allowed') !!}
                                {!! Form::number('eCount',null, ["class"=>'form-control' ,"placeholder"=>'No of times allowed']) !!}
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">                        
                                {!! Form::label('No of days allowed', 'No of days allowed') !!}
                                {!! Form::number('eNoOfDaysAllowed',null, ["class"=>'form-control' ,"placeholder"=>'No of days allowed']) !!}
                            </div>
                        </div>
                        @endif                 

                        {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group col-sm-12 ">
                            {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveExit"]) !!}
                            {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveContine"]) !!}
                            {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right"]) !!}
                        </div>
                        {!! Form::close() !!}   
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</div>
</div>
</section>

@stop 

@section('myscripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ Config('constants.adminDistJsPath').'/tag-it.min.js' }}"></script>

<script>



  CKEDITOR.replace( 'editor1' );
  @if($is_desc->status)
  CKEDITOR.replace( 'editor2' );
  @endif
   $('.textarea').wysihtml5()
var stock = $("#stock").val();
$("#before_updated_stock").val(stock);

$("#stock_type,#stock_update_qty").bind("change keyup", function () {
    $("#qtyerr").text('');
    var bus = $("#before_updated_stock").val();

    var stqty = $("#stock_update_qty").val();

    $("#qtyerr").text('');
    var stock_type = $("#stock_type").val();
    if (stock_type === "no") { // no change
        $("#stock_update_qty").val(0);
        $("#stock").val(bus);
        $("#qtyerr").text('Please select stock update type');
    } else if (stock_type === "0") { // minus qty
        if (stqty.length > 0) {
            if (parseInt(stqty) < parseInt(bus)) {
                var s = parseInt(bus) - parseInt(stqty);
                $("#stock").val(s);
            } else {
                $("#stock").val(bus);
                $("#qtyerr").text('you don\'t have enough stock to minus it ');
            }
        } else {
            $("#stock").val(bus);
            $("#qtyerr").text('');
        }
    } else if (stock_type === "1") { // add qty
        if (stqty.length > 0) {
            var s = parseInt(bus) + parseInt(stqty);
            $("#stock").val(parseInt(s));
        } else {
            $("#stock").val(bus);
        }
    }
});
$(".saveContine").click(function () {
    //     alert($(".prodC").val());

    // if($(".prodC").val() !=""){
    $(".rtUrl").val("{!!route('admin.products.general.info',['id'=>Input::get('id')])!!}");
    $("#EditGeneralInfo").submit();
    //   }else{
    //   alert("szdf");
    //   $(".errorPrdCode").text("Please enter product code.");

    //  }

});
$(".saveExit").click(function () {
    $(".rtUrl").val("{!!route('admin.products.view')!!}");
    $("#EditGeneralInfo").submit();

});



$("#myTags").tagit({
    caseSensitive: false,
    singleField: true,
    singleFieldDelimiter: ","
});

$('.decimal').keyup(function () {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
});
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$(document).ready(function () {
    $('input[type="checkbox"]').click(function () {
        var inputValue = $(this).attr("value");
        $("." + inputValue).toggle();
    });

    $('input[name="is_tax"]').on('change', function () {
        var is_tax = $('input[name="is_tax"]:checked').val();
        if (is_tax == 0) {
            $(".applicable-tax").hide();
        } else {
            $(".applicable-tax").show();
        }
    }).trigger('change');
});
</script>
@stop