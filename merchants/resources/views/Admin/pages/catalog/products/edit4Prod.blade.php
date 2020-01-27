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
        {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'ComboProdID' ,'class' => 'form-horizontal' ]) !!}
            <div class="panel-body">
            <div class="search-box-header">
                <form method="post" action="{{route('admin.products.update.combo.attach') }}"  id="searchForm">
                    <input type="hidden" name="id" value="{{$prod->id}}">
                    <div class="row">
                    <div class="form-group col-md-4 ">
                        <!-- <label for="related_prod">Related Product: </label> -->
                        <input id="combo_prod" class="form-control" name="combo_prod" placeholder="Search Product">
                    </div>
                    <!-- <div class="form-group col-md-2">
                        <input type="submit" name="search" class="btn sbtn btn-block" value="Add">
                    </div> -->
                    </div>
                    <div id="prod_log" class="hidden">
                    <table class="table tableVaglignMiddle table-hover priceTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Variant</th>
                                <th>Price</th>
                                <th>New Price</th>
                                <th>Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="prod_list">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <div class='row'>
                        <div class='col-md-4 form-group'><label class="control-label">Product</label></div>
                        <div class='col-md-2 form-group'><label class="control-label">Price</label></div>
                        <div class='col-md-2 form-group'><label class="control-label">New Price</label></div>
                        <div class='col-md-2 form-group'><label class="control-label">Qty</label></div>
                        <div class='col-md-2 form-group'><label class="control-label pull-left">Remove</label></div>
                    </div> -->
                    <div class="row">
                    <div class="form-group col-md-2 pull-right">
                        <input type="submit" name="search" class="btn sbtn btn-block pull-right" value="Add">
                    </div>
                    </div>
                    </div>
                </form>
            </div>                
                {!! Form::hidden("id",$prod->id) !!}
                    <?php $combo_prods = $prod->comboproducts()->get()->toArray(); ?>
                <div class="table-responsive">
                    <table class="table comboProds table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <!-- <th>Availability</th> -->
                                <!-- <th>Stock</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($combo_prods as $prd)
                            <tr>
                                <td>
                                    <?php if(@$prd['pivot']['sub_prod_id'] && $prd['pivot']['sub_prod_id'] != null) {
                                        $subProd = DB::table('products')->where('id', $prd['pivot']['sub_prod_id'])->first(['product']);
                                        $prodName = str_replace(')', '', str_replace('Variant (', '', $subProd->product));
                                        } else {
                                            $prodName = $prd['product'];
                                        }
                                    ?>
                                     {!! $prodName !!}
                                </td>
                                <td>{!! $prd['pivot']['new_price'] !!}</td>
                                <td>{!! $prd['pivot']['qty'] !!}</td>
                                <!-- <td>{!! $prd['is_avail'] == 0 ? "Out of Stock" : "In Stock" !!}</td> -->
                                <!-- <td>{!! $prd['stock'] !!}</td> -->
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
        $( "#prod_list" ).append( message );
        $( "#prod_log" ).scrollTop( 0 );
    }
    $( "#combo_prod" ).autocomplete({
        source: "{{route('admin.products.combo.search',['id'=>$prod->id])}}",
        minLength: 2,
        select: function( event, ui ) {
            // var str = "<div class='row'><div class='col-md-4 form-group'><input class='form-control' value='"+ui.item.product+"' readonly><input type='hidden' name='prod_id[]' value='" + ui.item.id + "' ></div>";
            var price = (ui.item.selling_price<ui.item.price)? ui.item.selling_price: ui.item.price;
            // str += "<div class='col-md-2 form-group'><input class='form-control' type='text' name='price[]' value='" + price + "' readonly></div>";
            // str += "<div class='col-md-2 form-group'><input class='form-control' type='text' name='new_price[]' value='" + price + "' ></div>";
            // str += "<div class='col-md-2 form-group'><input class='form-control' type='tel' name='qty[]' value='' ></div>";
            // str += '<div class="col-md-2" ><a href="#" class="pull-left remove-rag"><i class="fa fa-trash"></i></a></div></div>';

            var str = "<tr data-prdid='"+ui.item.id+"' id='"+ui.item.id+"'><td>"+ui.item.product+"<input type='hidden' name='prod_id[]' value='" + ui.item.id + "' ></td>";
            str += "<td><select name='subprodid[]' class='form-control subprodid' style='display:none;'></select></td>";
            str += "<td><input class='form-control' type='hidden' name='old_price[]' value='" + price + "' ><span class='ProdPrice'>"+price+"</span></td>";
            str += "<td><input class='form-control' type='text' name='new_price[]' required value='" + price + "' ></td>";
            str += "<td><input class='form-control' type='tel' name='qty[]' required value='' ></td>";
            str += "<td><a href='#' class='pull-left remove-rag'><i class='fa fa-trash'></i></a></td></tr>";
            console.log(str);
            log(str);
            getSubprods(ui.item.id);
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
        console.log($(this).parent());
        $(this).parent().parent().remove();
         var kids = $('#prod_list').children();
         console.log(kids.length);
         if(kids.length == 1){
            $("#prod_log").addClass("hidden");
        }
    });

    $("table").delegate(".subprodid", "change", function () {
        subprdid = $(this).val();
        subp = $(this);
        parentprodid = subp.parent().parent().attr('id');
        removeError(subp);
        // $(this).attr("name", "cartData[" + parentprodid + "][subprodid]");
        qty = subp.parent().parent().find('.qty').val();
        subp.parent().parent().find('.qty').attr('subprod-id', subprdid);
        $.post("{{route('admin.orders.getProdPrice')}}", {subprdid: subprdid, qty: qty, pprd: 0}, function (data) {
            var price = (data.unitPrice).toFixed(2);
            subp.parent().parent().find('.ProdPrice').text((data.unitPrice).toFixed(2));
            subp.parent().parent().find('input[name="old_price[]"]').val(price);
            subp.parent().parent().find('input[name="new_price[]"]').val(price);
            console.log(subp.parent().parent().find('input[name="old_price[]"]').val());
            console.log(subp.parent().parent().find('input[name="new_price[]"]').val());
            <?php if ($feature['tax'] == 1) {?>
                // subp.parent().parent().find('.taxAmt').text((data.tax).toFixed(2));
            <?php }?>
        });
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

    function getSubprods(prodid) {        
        var rows = $("#prod_list").find('tr');
        //console.log($(".newRow").find('tr'));
        var selected_prod = [];
        jQuery.each(rows, function (i, item) {
            var subprodid = parseInt($(this).find('.subprodid').val());
            if (subprodid != "" && subprodid != null) {
                selected_prod.push(subprodid);
            }
        });
        prodid = prodid;
        prodSel = $('tr#'+prodid);
        removeError(prodSel);
        // prodSel.attr("name", "cartData[" + prodid + "]");
        $.post("{{ route('admin.orders.getSubProds') }}", {prodid: prodid, data: selected_prod}, function (subprods) {
            prodSel.find('.subprodid').html("");
            // prodSel.parent().parent().find('.prodPrice').text(0);
            prodSel.find('.prodQty').show();
            if (subprods.length > 0) {
                prodSel.find('.subprodid').show();
                // attr('data-subpr', ui.item.id);
                subProdOpt = "<option value=''>Please select</option>";
                $.each(subprods, function (subprdk, subprdv) {
                    subprodname = subprdv.product.split("Variant (");
                    if (selected_prod.indexOf(subprdv.id) == -1) {
                        subProdOpt += "<option value='" + subprdv.id + "'>" + subprodname[1].replace(")", "") + "</option>";
                    }
                });
                prodSel.find('.subprodid').html(subProdOpt);
            } else {
                qty = prodSel.parent().parent().find('.qty').val();
                parentprdid = prodid;
                //console.log(parentprdid);exite;
                $.post("{{route('admin.orders.getProdPrice')}}", {parentprdid: parentprdid, qty: qty, pprd: 1}, function (price) {
                    //console.log(JSON.stringify(price));
                    prodSel.parent().parent().find('.prodPrice').text((price.price).toFixed(2));
                    <?php if ($feature['tax'] == 1) {?>
                    prodSel.parent().parent().find('.taxAmt').text((price.tax).toFixed(2));
                    <?php }?>
                    // calc();
                });
                prodSel.find('.subprodid').hide();
                // clearAllDiscount();
            }
        });
    }

    function removeError(thisEle) {
        thisEle.parent().parent().removeClass('trError');
    }
</script>
@stop