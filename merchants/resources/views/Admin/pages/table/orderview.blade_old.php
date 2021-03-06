@extends('Admin.layouts.default')

@section('mystyles')
<link rel="stylesheet" href="{{ asset('public/Admin/dist/css/tabs-css.css') }}">
<style>
    .target3 {border: 2px dotted; text-align: center; padding-top: 10px; min-width: 100px; min-height: 100px; cursor: pointer; color : #fff;}
    .draggable3{margin: 5px;}
    .size1 > .target3 {width: 150px; height: 150px;}
    .size2 .target3{width: 200px; height: 150px;}
    .size3  .target3{width: 150px; height: 150px; border-radius: 50%;}
    .green{background-color: #2ecc71;}
    .red{background-color: #d35400;}
    .yellow{background-color: #f1c40f;}
    .billedColor{ background: #f1c40f; }


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
            <div class="box-header box-tools filter-box col-md-9 noBorder rightBorder">
                <ul class="orderTableColor">
                    <li>Free<br/><div class="freeColor"></div></li>
                    <li>Occupy<br/><div class="occupyColor"></div></li>
                    <li>Billed<br/><div class="freeColor billedColor"></div></li>
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
                                        <div  id='box' class="pull-left">
                                        <?php //  dd($tables); ?>
                                            @foreach($tables as $table)
                                            <div class="draggable3 size{{$table->table_type }} col-md-3 ">
                                                <div data-tableid="{{ $table->id }}" class="target3 {{@$table->tablestatus->color}} context-menu-one">
                                                    {{ $table->table_no  . ($table->table_label !='' ? ' - ' . $table->table_label : '') }}
                                                    <br>({{$table->chairs}})
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
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
                                                    <td>{{ date("d-M-Y H:i a",strtotime($allorder->created_at)) }}</td>
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

    $(".sidebar-toggle").click();
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
            } else if(key == 'cut'){
              $.post("{{ route('admin.tableOccupiedOrder') }}",{tableid:tableid,keyname:key},function(respurl){
                  window.location.href=respurl+"?from=regenerateBill";
                });  
            } else if(key == 'paste'){
              $.post("{{ route('admin.tables.changeOccupancyStatus') }}/1",{tableid:tableid, keyname:key},function(res){
                  console.log(res);
                  if(res.status){
                    window.location.href = "{{route('admin.tableorder.view')}}";
                  }
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
                
            } else if(key=='cut') {
                $.post("{{route('admin.tableOccupiedOrder')}}", {tableid: tableid, keyname:'edit'}, function (resp) {
                    if (resp.order.id) {
                        window.location.href = resp.redirectUrl;
                    }
                });
            //   $.post("{{ route('admin.tableOccupiedOrder') }}",{tableid:tableid,keyname:key},function(respurl){
            //       // console.log(respurl);
            //         window.location.href=respurl+"?from=BillTable";
            //     });  
            }
            
        },
        items: itemsOccupied

    });

    $('.context-menu-one').on('click', function (e) {
        console.log('clicked', this);
    })

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

//    $.ajax({
//       type:"POST",
//       url:"",
//    });
});

</script>
@stop


