@extends('Admin.layouts.default')

@section('mystyles')
<style>
    .box-body{ width: 100%;}
    #box{ width: 100%; min-height: 450px;}
    .ui-rotatable-handle {
        height: 16px;
        width: 16px;
        cursor: pointer;
        background-image: url({{asset(Config('constants.adminImgPath').'/rotate.png')}});
        background-size: 100%;
        left: 5px;
        bottom: 5px;
        position: absolute;
    }
    .target3.ui-resizable {
        border: 2px dotted;
        text-align: center;
        padding-top: 10px;
        margin-bottom: 20px;
        min-width: 100px;
        min-height: 100px;
    }
/*    .draggable3{
        margin: 5px;
    }*/

    .size1 > .target3 {
        width: 150px;
        height: 150px;
        max-width: 100%;
        max-height: auto !important;
    }

    .size2 .target3{
        width: 200px;
        height: 150px;
        max-width: 100%;
        max-height: auto !important;
    }
    .size3  .target3{
        width: 150px;
        height: 150px;
        border-radius: 50%;
        max-width: 100%;
        max-height: auto !important;
    }
</style>
@stop
@section('content')
<section class="content-header">
    <h1>
        Restaurant Layout
        <small>Arrange </small>

        <a href="#" class="btn btn-default pull-right col-md-1 buttonClick">Set</a></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box pull-left">
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body pull-left">
                        <div id='box' class="pull-left">
                            @foreach($tables as $table)
                            <div class="draggable3 size{{$table->table_type }} col-md-3 col-sm-6 col-xs-12">
                                <div class="target3">
                                    {{ $table->table_no  . ($table->table_label !='' ? ' - ' . $table->table_label : '') }}
                                    <br>({{$table->chairs}})
                                <div class="clearfix"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
@stop
@section('myscripts')
<script src="{{asset(Config('constants.adminDistJsPath').'/jquery.ui.rotatable.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.size1 .target3, .size3 .target3').resizable({
            aspectRatio: 1 / 1
        }).rotatable();
        $('.size2 .target3').resizable().rotatable();
        $('.draggable3').draggable({
            containment: "#box",
            scroll: false
        })
    });

    $(document).ready(function () {
        $(".sidebar-toggle").click();
    });

    $('#box').each(function(){
        console.log($(this).outerWidth());
        console.log($(this).outerHeight());
    });

    $( ".buttonClick" ).click(function() {
        $('.target3').each(function(){
            console.log($(this).outerWidth());
            console.log($(this).outerHeight());
        })
    });
</script>
@stop
