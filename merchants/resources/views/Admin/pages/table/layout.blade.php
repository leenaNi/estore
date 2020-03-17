@extends('Admin.layouts.default')

@section('mystyles')
<style>
    .box-body{ width: 100%;}
    #box{ width: 100%; min-height: 450px;}
    .ui-rotatable-handle {
        height: 16px;
        width: 16px;
        cursor: pointer;
        background-image: url(https://d2102t1lty3x1n.cloudfront.net/Admin/dist/img/rotate.png);
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
    .text-v-center {
    display: flex;
    justify-content: center;
    flex-direction: column;
}
.size1 > .target3 a, .size2 .target3 a, .size3 .target3 a {
    display: block;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
}
</style>
@stop 
@section('content') 
<form id="set-layout-form" method="POST" action="{{ route('admin.restaurantlayout.save') }}">
<section class="content-header">   
    <h1>
        Restaurant Layout
        <small>Arrange </small>
    
        <input type="submit" value="Set" class="btn btn-default pull-right col-md-1 buttonClick"></h1>   
        
</section>
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box pull-left">
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body pull-left">
                        <div id='box'  class="pull-left">
                            @foreach($tables as $table)
                            <div class="draggable3 size{{$table->table_type }} col-md-3 col-sm-6 col-xs-12">
                                <div class="target3 text-v-center" id="target_{{$table->id }}" data-myval="{{$table->id }}">
                                    <a href="#">Table No: {{ $table->table_no  . ($table->table_label !='' ? ' - ' . $table->table_label : '') }}
                                        <br>{{$table->chairs}} (Packs)
                                    </a>
                                    <div class="clearfix"></div>    
                                </div>
                            </div>
                            @endforeach

                            <input type="hidden" name="hdn_layout_rotate_array[]" id="hdn_layout_rotate_array" value="">
                            <input type="hidden" name="hdn_layout_draggable_array[]" id="hdn_layout_draggable_array" value="">
                            <input type="hidden" name="hdn_layout_resizable_array[]" id="hdn_layout_resizable_array" value="">
                        </div>

                </div><!-- /.box-body -->
            </div>
        </div>
    </div>

</section>
</form>
@stop

@section('myscripts')
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script src='https://d2102t1lty3x1n.cloudfront.net/Admin/dist/js/jquery.ui.rotatable.min.js'></script>
<script>
  

//$("#target_1").css("opacity", "0.5px");
//$('.target3').resizable().rotatable().draggable();

$(document).ready(function() {
    
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
        
        $('#target_'+tableId).rotatable({
        //degrees: tableAngle,
        // when rotation starts
        start: function (event, ui) { 
            //console.log("Rotating started")
            return true; 
        },

        // while rotating
        rotate: function (event, ui) {
                //if (Math.abs(ui.angle.current > 6)) {
                console.log("Rotating " + ui.angle.current)
                //}
            return true;
            },

        // when rotation stops
        stop: function (event, ui) { 
            //console.log("rotate ui::"+JSON.stringify(ui));
        //alert(event.target.id);
        var layoutDivId = event.target.id;
        var splitDivId = layoutDivId.split('_');
        var getLayoutDivIdValue = splitDivId[1];
        //alert("layout id::"+layoutDivIdValue);
        var getLastRotateValue = ui.angle.current;
        //console.log("Rotating stopped");
        addLayoutKeyValue(getLayoutDivIdValue, getLastRotateValue, 'angle');
        
        return true; 
        
        }
        
        });  //rotatable ends here

        //Draggable start here
        $('#target_'+tableId).draggable({
            containment: "#box",
            scroll: false,
		    start: function(e, ui) {
                //ui.helper.addClass("dragging");
                return true;
            },
            stop: function(e, ui) {
                //var dragDivId = $(this).find('div').attr('id');
                var myValId = $(this).data('myval');
                //console.log("draggable ui::"+JSON.stringify(ui));
                var topPosition = ui.position.top;
                var leftPosition = ui.position.left;
                var draggableVal = topPosition+','+leftPosition;
                //console.log("top position::"+topPosition+"::Left position::"+leftPosition);
                addLayoutDraggableKeyValue(myValId, draggableVal, 'draggable')
                return true;
            }
        });

        //Resizable start here
        $('#target_'+tableId).resizable({
            resize: function(event, ui) { 

            },
            stop: function(e, ui) {
                var myValId = $(this).data('myval');
                //console.log("resizable::"+JSON.stringify(ui));
                var layoutWidth = ui.size.width;
                var layoutHeight = ui.size.height;
                var resizableVal = layoutWidth+","+layoutHeight;
                addLayoutResizableKeyValue(myValId, resizableVal, 'resizable')
                return true;
            }
        });

    }//for loop ends here
});

var layoutArray = [];
function addLayoutKeyValue(id, val, type)
{
    //alert(id +"::"+ val);
    item = {};
    if(type == 'angle')
    {
        var getHdnRotateArray = $("#hdn_layout_rotate_array").val();
        if(getHdnRotateArray == '')
        {
            item['id'] = id;
            item[type] = val;
            layoutArray.push(item);
            //console.log("json array::"+JSON.stringify(layoutArray));
            $("#hdn_layout_rotate_array").val(JSON.stringify(layoutArray));
        }
        else
        {
            getHdnRotateArray = JSON.parse(getHdnRotateArray);
            //console.log("else json array::"+JSON.stringify(layoutArray));
            //alert(Object.keys(getHdnRotateArray).length);
            var flag = 0;
            for(var i = 0; i < getHdnRotateArray.length; i++)
            {
                //Search each key in your object
                if(getHdnRotateArray[i]['id'] == id)
                {
                    getHdnRotateArray[i][type] = val;
                    $("#hdn_layout_rotate_array").val(JSON.stringify(getHdnRotateArray));
                    flag = 1;
                    break;//Exit the loop
                }
            }
            if(flag == 0)
            {
                item['id'] = id;
                item[type] = val;
                layoutArray.push(item);
                $("#hdn_layout_rotate_array").val(JSON.stringify(layoutArray));
            }
        }//else ends here
    }//type if ends here
    else if(type == 'draggable')
    {


    }
}//rotatable function ends here

var layoutDraggableArray = [];
function addLayoutDraggableKeyValue(id, val, type)
{   
    drggableItem = {};
    var getHdnDraggableArray = $("#hdn_layout_draggable_array").val();
    if(getHdnDraggableArray == '')
    {
        
        drggableItem['id'] = id;
        drggableItem[type] = val;
        layoutDraggableArray.push(drggableItem);
        //console.log("json array::"+JSON.stringify(layoutDraggableArray));
        $("#hdn_layout_draggable_array").val(JSON.stringify(layoutDraggableArray));
    }
    else
    {
        getHdnDraggableArray = JSON.parse(getHdnDraggableArray);
        //alert(Object.keys(getHdnDraggableArray).length);
        var flag = 0;
        for(var i = 0; i < getHdnDraggableArray.length; i++)
        {
            //Search each key in your object
            if(getHdnDraggableArray[i]['id'] == id)
            {
                getHdnDraggableArray[i][type] = val;
                $("#hdn_layout_draggable_array").val(JSON.stringify(getHdnDraggableArray));
                flag = 1;
                break;//Exit the loop
            }
        }
        if(flag == 0)
        {
            drggableItem['id'] = id;
            drggableItem[type] = val;
            layoutDraggableArray.push(drggableItem);
            $("#hdn_layout_draggable_array").val(JSON.stringify(layoutDraggableArray));
        }
    }//else ends here

}//draggable function ends here

var layoutResizableArray = [];
function addLayoutResizableKeyValue(id, val, type)
{   
    resizeItem = {};
    var getHdnResizableArray = $("#hdn_layout_resizable_array").val();
    if(getHdnResizableArray == '')
    {
        
        resizeItem['id'] = id;
        resizeItem[type] = val;
        layoutResizableArray.push(resizeItem);
        //console.log("json array::"+JSON.stringify(layoutResizableArray));
        $("#hdn_layout_resizable_array").val(JSON.stringify(layoutResizableArray));
    }
    else
    {
        getHdnResizableArray = JSON.parse(getHdnResizableArray);
        //alert(Object.keys(getHdnResizableArray).length);
        var flag = 0;
        for(var i = 0; i < getHdnResizableArray.length; i++)
        {
            //Search each key in your object
            if(getHdnResizableArray[i]['id'] == id)
            {
                getHdnResizableArray[i][type] = val;
                $("#hdn_layout_resizable_array").val(JSON.stringify(getHdnResizableArray));
                flag = 1;
                break;//Exit the loop
            }
        }
        if(flag == 0)
        {
            resizeItem['id'] = id;
            resizeItem[type] = val;
            layoutResizableArray.push(resizeItem);
            $("#hdn_layout_resizable_array").val(JSON.stringify(layoutResizableArray));
        }
    }//else ends here

}//resizable function ends here
</script>
@stop