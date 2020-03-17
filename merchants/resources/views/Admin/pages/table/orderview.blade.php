@extends('Admin.layouts.default')

@section('mystyles')
<!-- <link rel="stylesheet" href="{{ asset('public/Admin/dist/css/tabs-css.css') }}"> -->
<style>
    .target3 {border: 2px dotted; text-align: center; padding-top: 10px; min-width: 100px; min-height: 100px; cursor: pointer;}
    .draggable3{margin: 5px;}
    .size1 > .target3 {width: 150px; height: 150px;}
    .size2 .target3{width: 200px; height: 150px;}
    .size3  .target3{width: 150px; height: 150px; border-radius: 50%;}
    .green{background-color: #2ecc71;}
    .red{background-color: #d35400;}
    .yellow{background-color: #f1c40f;}
    .text-v-center{
        display: flex;
        justify-content: center;
        flex-direction: column;
    }
    .size1 > .target3 a {
        display: block;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        flex-direction: column;
}

</style>

<style>
    .box-body{ width: 100%;}
    #box{ width: 100%; min-height: 450px;}
    /* .ui-rotatable-handle {
        height: 16px;
        width: 16px;
        cursor: pointer;
        background-image: url(https://d2102t1lty3x1n.cloudfront.net/Admin/dist/img/rotate.png);
        background-size: 100%;
        left: 5px;
        bottom: 5px;
        position: absolute;
    } */
    /* .target3.ui-resizable {
        border: 2px dotted;
        text-align: center;
        padding-top: 10px;
        margin-bottom: 20px;
        min-width: 100px;
        min-height: 100px;
    } */
/*    .draggable3{
        margin: 5px;
    }*/
/* 
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
    } */
</style>
@stop 

@section('content') 
<section class="content-header">   
    <h1>
        Manage Orders
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
            <div class="box-header box-tools filter-box col-md-9 noBorder rightBorder">
                <ul class="orderTableColor">
                    <li>Occupied<br/><div class="occupyColor"></div></li>
                    <li>Available<br/><div class="freeColor"></div></li>
                </ul>
            </div>
                <div class="box-header  col-md-3 col-xs-12 pull-right">
                    <a class="btn btn-default pull-right" type="button" data-toggle="modal" data-target="#addOrder">Add New Order</a>
                    <div id="addOrder" class="modal fade" role="dialog">
                        <div class="modal-dialog" style="width: 75%;top:40px">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add Product</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="box-body">
                                        <form method="POST" action="{{route("admin.tableorder.save")}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                            <input name="added_by" type="hidden" value="{{ Auth::id() }}">
                                            <div class="form-group">
                                                <label for="Product Name" class="col-sm-2 control-label">Order Type</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" required name="ordertype">
                                                        @foreach($otypes as $type)
                                                        <option value="{{ $type->id }}">
                                                            {{ $type->otype }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input class="btn btn-primary" type="submit" value="Submit">
                                    </form>  
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body ">
                    <div class="row" >
                        <!-- style four -->
                        <div class="col-md-12">
                            <!-- tab style -->
                            <div class="clearfix tabs-linearrow">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-linearrow-one" data-toggle="tab">Dine In Orders</a></li>
                                    <li><a href="#tab-linearrow-two" data-toggle="tab">Other Orders</a></li>
                                    <li><a href="#tab-linearrow-three" data-toggle="tab">All Orders</a></li>
                                </ul>
                                <div class="tab-content pull-left" style="width:100%;">
                                    <div class="tab-pane active" id="tab-linearrow-one">
                                        <div class="box-body pull-left">
                                            <div id='box'  class="pull-left">
                                                @foreach($tables as $table)
                                                <div class="draggable3 size{{$table->table_type }} col-md-3 col-sm-6 col-xs-12">
                                                    <div class="target3 text-v-center context-menu-one {{@$table->tablestatus->color}}" data-tableid="{{ $table->id }}" id="target_{{$table->id }}" data-myval="{{$table->id }}">
                                                        <a href="#">Table No: {{ $table->table_no  . ($table->table_label !='' ? ' - ' . $table->table_label : '') }}
                                                            <br>{{$table->chairs}} (Packs)
                                                        </a>
                                                        <div class="clearfix"></div>    
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>                    
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="tab-pane" id="tab-linearrow-two">
                                        <table class="table table-bordered table-condensed table-hover tableVaglignMiddle">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Order Type</th>
                                                    <th>Date</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($otherorders as $otherorder)
                                                <tr>
                                                    <td>{{ $otherorder->id }}</td>
                                                    <td>{{ @$otherorder->type()->first()->otype }}</td>
                                                    <td>{{ date("d-M-Y H:i:s",strtotime($otherorder->created_at)) }}</td>
                                                    <td><a href="{{route('admin.order.additems', ['id' => $otherorder->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="pull-right">
                                            {{ $otherorders->links() }}
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-linearrow-three">
                                        <table class="table table-bordered table-condensed table-hover tableVaglignMiddle">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Order Type</th>
                                                    <th>Tables</th>
                                                    <th>Date</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($allorders as $allorder)
                                                <tr>
                                                    <td>{{ $allorder->id }}</td>
                                                    <td>{{ $allorder->type()->first()->otype }}</td>
                                                    
                                                    <td> <?php 
                                                    $tablesnumbers = "";
                                                    if($allorder->otype == 1){
                                                        if(!empty($allorder->table_id)){
                                                            $tablesnumbers .= $allorder->table['table_no'];
                                                        }else if(!empty($allorder->join_tables)){
                                                            $tabl = json_decode($allorder->join_tables);
                                                            foreach($tabl as $t){
                                                                $tablesnumbers .= App\Models\Table::find($t)->table_no.",";
                                                            }
                                                         $tablesnumbers =   rtrim($tablesnumbers,',');
                                                        }
                                                        
                                                        
                                                    }
                                                    echo $tablesnumbers;                                                    
                                                    ?> </td>
                                                    <td>{{ date("d-M-Y H:i:s",strtotime($allorder->created_at)) }}</td>
                                                    <td><a href="{{route('admin.order.additems', ['id' => $allorder->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        <div class="pull-right">
                                            {{ $allorders->links() }}
                                        </div> 
                                    </div>
                                </div>
                                <!-- tab style -->
                            </div>
                            <!-- #end style-four -->
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
        <div id="newOrdersTables" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 75%;top:40px">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class='chkMsg'></div>
                        <div class="box-body">
                            <form method="POST" action="{{route("admin.order.addNewOrder")}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                <input type="hidden" name='tableid' value=''>
                                <div class="tableSel"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-primary submitJoinTableOrder" type="button"  value="Submit">
                        </form>  
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</section>
@stop

@section('myscripts')

<link href="https://swisnl.github.io/jQuery-contextMenu/dist/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<script src="https://swisnl.github.io/jQuery-contextMenu/dist/jquery.contextMenu.js" type="text/javascript"></script>
<script src="https://swisnl.github.io/jQuery-contextMenu/dist/jquery.ui.position.min.js" type="text/javascript"></script>
<script src="https://swisnl.github.io/jQuery-contextMenu/js/main.js" type="text/javascript"></script>
<script src='https://d2102t1lty3x1n.cloudfront.net/Admin/dist/js/jquery.ui.rotatable.min.js'></script>
<script>
var itemsNew = {
    "edit": {name: "Add Order", icon: "edit"},
    copy: {name: "Join Table", icon: "copy"},
};

var itemsOccupied = {
    "edit": {name: "Add/Edit Items", icon: "edit"},
    "cut": {name: "Bill Table", icon: "paste"},
    copy: {name: "Join Table", icon: "copy"},
}

var billNew = {
    "edit": {name: "Add/Edit Items", icon: "edit"},
    "cut": {name: "Regenerate Bill", icon: "paste"},
    "paste": {name: "Free Up Table", icon: "delete"},
}
$(document).ready(function () {
    setTableLayout();
    function setTableLayout() {
        var tableLayoutDbArray = <?php echo $tables;?>;
        //console.log("db array::"+JSON.stringify(tableLayoutDbArray));
        for(var j=0;j<tableLayoutDbArray.length;j++)
        {
            var tableId = tableLayoutDbArray[j]['id'];
            var tableAngle = tableLayoutDbArray[j]['angle'];
            var tablePosition = tableLayoutDbArray[j]['position'];
            var tableSize = tableLayoutDbArray[j]['size'];
            if(tablePosition && tablePosition != '')
            {
                var splitPosition = tablePosition.split(",");
                var topPosition = splitPosition[0]+"px";
                var leftPosition = splitPosition[1]+"px";
                $('#target_'+tableId).css({top: topPosition, left: leftPosition});
            }

            if(tableSize && tableSize != '')
            {
                var splitSize = tableSize.split(",");
                var tblWidth = splitSize[0]+"px";
                var tblHeight = splitSize[1]+"px";
                $('#target_'+tableId).css({width: tblWidth, height: tblHeight});
            }

            //console.log("table id::"+tableId+"::angle::"+tableAngle);
            $('#target_'+tableId).rotatable( {degrees: tableAngle} )
            
            // $('#target_1').rotatable( {degrees: -2.54856555} )
            //alert("angle::"+tableAngle);
            $('#target_'+tableId).resizable().rotatable();
            
            //$("#target_1").css("transform", "rotate(-1.69872rad)");
            var rotateAngle = tableAngle+'rad';
            $("#target_"+tableId).css("transform", "rotate("+rotateAngle+")");
            $('#target_'+tableId).resizable('disable');
            // if(j == tableLayoutDbArray.length){
            //     contextMenuCall();
            // }
        }
    }
    // $(".sidebar-toggle").click();    
    // contextMenuCall();
    // function contextMenuCall() {
        $.contextMenu({
            selector: '.context-menu-one.green',
            callback: function (key, options) {
                var m = "clicked: " + key;
                tableid = $(this).attr('data-tableid');
                if (key == 'edit') {
                    $.post("{{route('admin.order.addNewOrder')}}", {tableid: tableid}, function (resp) {
                        if (resp.order.id) {
                            window.location.href = resp.redirectUrl;
                        }
                    });
                } else if (key == 'copy') {
                    $.post("{{route('admin.order.getJoinTableCheckbox')}}", {tableid: tableid}, function (resp) {
                        if(resp.length > 0){
                        $(".tableSel").html("");
                        $("input[name='tableid']").val("");
                        $("input[name='tableid']").val(tableid);
                        $(".tableSel").append(resp);
                        $("#newOrdersTables").modal("show");
                    }else{
                        alert("Free table is not available.");
                    }
                    });
                }
                //window.console && console.log(m) || alert(m);
            },
            items: itemsNew
        });
    
        $.contextMenu({
            selector: '.context-menu-one.yellow',
            callback: function (key, options) {
                var m = "clicked: " + key;
                //window.console && console.log(m) || alert(m);
                tableid = $(this).attr('data-tableid');
                if (key == 'edit') {
                    $.post("{{ route('admin.tableOccupiedOrder') }}",{tableid:tableid,keyname:key},function(respurl){
                        window.location.href=respurl;
                    });                
                }else if(key == 'cut'){
                    $.post("{{ route('admin.tableOccupiedOrder') }}",{tableid:tableid,keyname:key},function(respurl){
                        window.location.href=respurl+"?from=regenerateBill";
                    });  
                }            
            },
            items: billNew
        });

        $.contextMenu({
            selector: '.context-menu-one.red',
            callback: function (key, options) {
                var m = "clicked: " + key;
                //window.console && console.log(m) || alert(m);
                tableid = $(this).attr('data-tableid');
                //alert(key);
                if (key == 'edit') {
                    $.post("{{ route('admin.tableOccupiedOrder') }}",{tableid:tableid,keyname:key},function(respurl){
                        window.location.href=respurl;
                    });                
                }else if(key=='cut'){
                $.post("{{ route('admin.tableOccupiedOrder') }}",{tableid:tableid,keyname:key},function(respurl){
                    // console.log(respurl);
                        window.location.href=respurl+"?from=BillTable";
                    });
                }            
            },
            items: itemsOccupied
        });
        $('.context-menu-one').on('click', function (e) {
            console.log('clicked', this);
        });
    // }

});

$(".submitJoinTableOrder").on("click", function () {
    tableid = $("input[name='tableid']").val();
    selTables = [];
    $.each($("[name='join_tableChk[]']:checked"), function (k, v) {
        selTables.push(parseInt($(this).val()));
    });
    selTables.push(tableid);
    if ($("[name='join_tableChk[]']:checked").length > 0) {
        $(".chkMsg").hide();
        $.post("{{route('admin.order.saveJoinTableOrder')}}", {selTables: selTables}, function (resp) {
            //console.log(resp);
            if (resp.order.id) {
                window.location.href = resp.redirectUrl;
            }
        });
    } else {
        $(".chkMsg").addClass("alert alert-danger");
        $(".chkMsg").text("Please select at least one table.");
    }

});

</script>
@stop


