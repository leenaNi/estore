@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Products

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>


<div class="nav-tabs-custom">
    {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
    <div class="tab-content">
        <div class="tab-pan-active" id="activity">
            <div class="panel-body">
            <div class="search-box-header">
                <form method="post" action="{{route('admin.products.update.combo.attach') }}"  id="searchForm">
                    <input type="hidden" name="id" value="{{$prod->id}}">
                    <div class="row">
                    <div class="form-group col-md-4 ">
                        <!-- <label for="related_prod">Related Product: </label> -->
                        <input id="combo_prod" class="form-control" name="combo_prod" placeholder="Search Product">
                    </div>                    
                    <div class="form-group col-md-2">
                        <input type="submit" name="search" class="btn sbtn btn-block" value="Add">
                    </div>
                    </div>
                    <div id="prod_log" class="hidden">
                    <div class='row'>
                        <div class='col-md-4 form-group'><label class="control-label">Product</label></div>
                        <div class='col-md-2 form-group'><label class="control-label">Price</label></div>
                        <div class='col-md-2 form-group'><label class="control-label">New Price</label></div>
                        <div class='col-md-2 form-group'><label class="control-label">Qty</label></div>
                        <div class='col-md-2 form-group'><label class="control-label pull-left">Remove</label></div>
                    </div>
                    </div>
                </form>
            </div>
                {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'ComboProdID' ,'class' => 'form-horizontal' ]) !!}
                {!! Form::hidden("id",$prod->id) !!}
                <?php $combo_prods = $prod->comboproducts()->get()->toArray();
                ?>
                <div class="table-responsive">
                    <table class="table comboProds table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Availability</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($combo_prods as $prd)
                            <tr>
                                <td>{!! $prd['product'] !!}</td>
                                <td>{!! $prd['pivot']['qty'] !!}</td>
                                <td>{!! $prd['is_avail'] == 0 ? "Out of Stock" : "In Stock" !!}</td>
                                <td>{!! $prd['stock'] !!}</td>
                                <!-- <td> <a class="deletecombo" id="{{$prd['id']}}"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                <div class="form-group col-sm-12 ">
                    {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveComboExit"]) !!}
                    {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveComboContine"]) !!}
                    {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right"]) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('myscripts')
<script>
    function log( message ) {
        console.log();
        $( "#prod_log" ).removeClass("hidden");
        $( "#prod_log" ).append( message );
        $( "#prod_log" ).scrollTop( 0 );
    }
    $( "#combo_prod" ).autocomplete({
        source: "{{route('admin.products.combo.search',['id'=>$prod->id])}}",
        minLength: 2,
        select: function( event, ui ) {
            var str = "<div class='row'><div class='col-md-4 form-group'><input class='form-control' value='"+ui.item.product+"' readonly><input type='hidden' name='prod_id[]' value='" + ui.item.id + "' ></div>";
            var price = (ui.item.selling_price<ui.item.price)? ui.item.selling_price: ui.item.price;
            str += "<div class='col-md-2 form-group'><input class='form-control' type='text' name='price[]' value='" + price + "' readonly></div>";
            str += "<div class='col-md-2 form-group'><input class='form-control' type='text' name='new_price[]' value='" + price + "' ></div>";
            str += "<div class='col-md-2 form-group'><input class='form-control' type='tel' name='qty[]' value='' ></div>";
            str += '<div class="col-md-2" ><a href="#" class="pull-left remove-rag"><i class="fa fa-trash"></i></a></div></div>';
            console.log(str);
            log(str);
        }
        });
    $( "#combo_prod" ).data("ui-autocomplete")._renderItem = function (ul, item) {
        return $("<option>")
        .append( item.product )
        .appendTo(ul);
    };

    $(".deletecombo").click(function(e) {
        e.preventDefault;
        sync("{{ $prod->id }}", $(this).attr("id"), "{{ URL::route('admin.products.update.combo.detach') }}",$(this));
    });

    $(".saveComboExit").click(function() {
        $(".rtUrl").val("{!! route('admin.products.view')!!}");
        $("#ComboProdID").submit();
    });
    $(".saveComboContine").click(function() {
        $(".rtUrl").val("{!! route('admin.combo.products.view',['id'=>$prod->id])!!}");
       // $(".rtUrl").val("{!! route('admin.combo.products.view')!!}");
        $("#ComboProdID").submit();
    });
    $(".comboProds input[type='checkbox']").click(function() {
        if ($(this).prop("checked")) {
            sync("{{ $prod->id }}", $(this).val(), "{{ URL::route('admin.products.update.combo.attach') }}");
        } else {
            sync("{{ $prod->id }}", $(this).val(), "{{ URL::route('admin.products.update.combo.detach') }}");
        }
    });

    $('body').on('click', '.remove-rag', function (event) {
        /* Act on the event */
        event.preventDefault();
        jQuery(this).parent().parent().remove();
         var kids = $('#prod_log').children();
         console.log(kids.length);
         if(kids.length == 1){
            $("#prod_log").addClass("hidden");  
        }      
    });

    function sync(id, prod_id, action) {
        $("input[type='submit']").prop("diabled", true);
        $.ajax({
            url: action,
            type: "POST",
            data: {id: id, prod_id: prod_id},
            sucess: function(data) {
                console.log(data);
                $("input[type='submit']").prop("diabled", false);
            }
        });
    }
</script>
@stop