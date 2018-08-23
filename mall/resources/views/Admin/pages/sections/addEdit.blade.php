@extends('Admin.layouts.default')

@section('mystyles')

<link rel="stylesheet" href="{{ asset('public/Admin/dist/css/jquery.tagit.css') }}">

<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">


@stop

@section('content')
<section class="content-header">
    <div class="flash-message"><b>{{ Session::get("ProductCode") }} {{ Session::get("errorMessage") }}</b></div>
    <h1>
        Section

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Section </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
    <div class="nav-tabs-custom"> 

       


        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div class="panel-body">
                <div class="row"> 
                    {!! Form::model($section, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'EditGeneralInfo']) !!}
                    
                    {!! Form::hidden('id',null) !!}
                    
                    <div class="col-md-12">
                        <div class="form-group">
                        {!! Form::label('name', ' Name ') !!}<span class="red-astrik"> *</span>
                            {!! Form::text('name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Section Name']) !!}
                        </div>
                    </div>
                   

                    <div class="col-md-12">
                        <div class="form-group">
                        {!! Form::label('Status', 'Status ') !!}<span class="red-astrik"> *</span>
                            {!! Form::select('status',["0"=>"Inactive", "1"=>"Active"] ,null, ["class"=>'form-control validate[required]']) !!}
                            <p style="color: red;" class="errorPrdCode"></p>
                        </div>
                    </div>
                   
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group col-sm-12 ">
                        {!! Form::submit('Save',["class" => "btn btn-primary "]) !!}
                        
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