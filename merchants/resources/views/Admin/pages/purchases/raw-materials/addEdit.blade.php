@extends('Admin.layouts.default')

@section('mystyles')

<link rel="stylesheet" href="{{ asset('public/Admin/dist/css/jquery.tagit.css') }}">

<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">


@stop

@section('content')
<section class="content-header">
    <div class="flash-message"><b>{{ Session::get("ProductCode") }} {{ Session::get("errorMessage") }}</b></div>
    <h1>
        Raw Material

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="{{route('admin.raw-material.view')}} " > Raw Material </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
    <div class="nav-tabs-custom"> 

       


        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div class="panel-body">
                <div class="row"> 
                    {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'EditGeneralInfo']) !!}
                    
                    {!! Form::hidden('id',null) !!}
                    {!! Form::hidden('prod_type',6) !!}
                    @if($prod->id == 0)
                        {!! Form::hidden('added_by', Auth::id()) !!}
                    @else
                        {!! Form::hidden('updated_by', Auth::id()) !!}
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('product', 'Product Name') !!}
                       <span class="red-astrik"> *</span>
                            {!! Form::text('product',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Product Name']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                        
                        {!! Form::label('product SKU', 'Product SKU ', ["class"=>'span_made']) !!}
                        <span class="red-astrik"> *</span>
                            {!! Form::text('product SKU',null, ["class"=>'form-control ProdC validate[required]' ,"placeholder"=>'Enter Product SKU']) !!}
                            <p style="color: red;" class="errorPrdCode"></p>
                        </div>
                    </div>

                    @if($barcode == 1)
                    <div class="col-md-12">
                        <div class="form-group">
                        {!! Form::label('barcode', 'Barcode') !!}
                         <span class="span-mand"> *</span>
                            <div class="row">
                                <div class="col-sm-6">
                                    {!! Form::select('barcode_select',["0"=>"System generated", "1"=>"Capture"] ,null, ["class"=>'form-control']) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::text('barcode',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Barcode code']) !!}
                                </div>
                            </div>
                            <p style="color: red;" class="errorPrdCode"></p>
                    </div>
                    </div>
                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('Status', 'Status') !!}
                            {!! Form::select('status',["0"=>"Disabled", "1"=>"Enabled"] ,null, ["class"=>'form-control']) !!}
                            <p style="color: red;" class="errorPrdCode"></p>
                        </div>
                    </div>
                    <!-- <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">                        
                        {!! Form::label('is_avail', 'Product Available?',['class'=>'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('is_avail',["0" => "No", "1" => "Yes"],null,["class"=>'form-control']) !!}
                        </div>
                    </div> -->
                  
                    <div class="col-md-6">
                        <div class="form-group">                        
                            {!! Form::label('Stock', 'Stock') !!}
                            <span class="red-astrik"> *</span>
                                {!! Form::number('stock',null,["class"=>'form-control validate[required,custom[number]]', "min"=>'0', "placeholder"=>"Stock"]) !!}
                            </div>
                        </div>

                  <div class="col-md-6">
                        <div class="form-group">                        
                        {!! Form::label('Unit of Measure', 'Unit of Measure') !!}
                        <span class="red-astrik"> *</span>
                            {!! Form::select('unit_measure',$unit_measure,null, ["class"=>'form-control validate[required]',"placeholder"=>"UOM"]) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">                       
                        {!! Form::label('Consumption Unit of Measure', 'Consumption Unit of Measure') !!}
                       <span class="red-astrik"> *</span>
                            {!! Form::select('consumption_uom',$unit_measure,null, ["class"=>'form-control validate[required]',"placeholder"=>"CUOM"]) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">                       
                        {!! Form::label('BUOM TO CUOM conversion', 'BUOM TO CUOM conversion') !!}
                        <span class="red-astrik"> *</span>
                            {!! Form::number('conversion',null,["class"=>'form-control validate[required]',"placeholder" => "Conversion","step" => "0.01"]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                       
                        {!! Form::label('Height', 'Height') !!}
                            {!! Form::text('height',null,["class"=>'form-control validate[custom[number]]',"placeholder"=>"Height (CM)"]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                       
                        {!! Form::label('Width', 'Width') !!}
                            {!! Form::text('width',null,["class"=>'form-control validate[custom[number]]',"placeholder"=>"Width (CM)"]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                       
                        {!! Form::label('length', 'Length') !!}
                            {!! Form::text('length',null,["class"=>'form-control validate[custom[number]]',"placeholder"=>"Length (CM)"]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                       
                        {!! Form::label('Weight', 'Weight') !!}
                            {!! Form::text('weight',null,["class"=>'form-control validate[custom[number]]',"placeholder"=>"Weight (KG)"]) !!}
                        </div>
                    </div>

                    {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group col-sm-12 ">
                        {!! Form::submit('Save',["class" => "btn btn-primary margin-left0"]) !!}
                        
                    </div>
                    {!! Form::close() !!}     
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop 

@section('myscripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('public/Admin/dist/js/tag-it.min.js') }}"></script>
<script>
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

</script>
@stop