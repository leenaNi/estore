@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Offers
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.offers.view') }}"><i class="fa fa-coffee"></i> Offer</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($offer, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}

                    <div class="form-group">
                        {!! Form::label('offer_name', 'Offer Name',['class'=>'col-sm-2 control-label']) !!}
                        {!! Form::hidden('id',null) !!}
                        <div class="col-sm-10">
                            {!! Form::text('offer_name',null, ["class"=>'form-control' ,"placeholder"=>'Enter Offer Name', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('type','Type ?',['class'=>'col-sm-2 control-label']) !!}
                        @if($offer->id)
                        <div class="col-sm-10">
                            {!! Form::select('type',["1" => "Buy X qty of A, Get Y/Y% OFF", "2" => "Buy X qty of A, Get Y qty of B"], $offer->type, ["class"=>'form-control offer-type', 'disabled']) !!}
                            <input type="hidden" value="<?php echo $offer->type; ?>" name="type">
                        </div>
                        @else
                        <div class="col-sm-10">
                            {!! Form::select('type',["1" => "Buy X qty of A, Get Y/Y% OFF", "2" => "Buy X qty of A, Get Y qty of B"],null,["class"=>'form-control offer-type']) !!}
                        </div>
                        @endif
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group discount_type">
                        {!!Form::label('offer_discount_type','Offer Discount Type ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('offer_discount_type',["2" => "Fixed", "1" => "Percentage"],null,["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group discount_type">
                        {!!Form::label('offer_discount_value','Offer Discount Value',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('offer_discount_value',null,["class"=>'form-control',"placeholder"=>"Enter Offer Discount Value"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('can_combined','Can offer be combined ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('can_combined',["2" => "No", "1" => "Yes"],null,["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                 
                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <?php
if ($offer->offer_type != 0) {
    ?>
                        <div class="form-group discount_type"> <!--- "2" => "Specific Categories",  --->
                            {!!Form::label('offer_type','Offer Type ?',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('offer_type',["1" => "Entire Order", "3" => "Specific Products"],null,["class"=>'form-control' , "disabled"=>"disabled" ]) !!}
                                <input type="hidden" value="<?php echo $offer->offer_type; ?>" name="offer_type">
                            </div>
                        </div>
                        <?php
} else {
    ?>
                        <div class="form-group discount_type"> <!--- "2" => "Specific Categories",  --->
                            {!!Form::label('offer_type','Offer Type ?',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('offer_type',["1" => "Entire Order", "3" => "Specific Products"], 3, ["class"=>'form-control', 'id'=> 'offer_type']) !!}
                            </div>
                        </div>
                        <?php
}
?>

                    <div class="col-md-12 form-group" id="showCategories">
                        {!!Form::label('parent_id','Select Categories',['class'=>'col-sm-2 control-label']) !!}

                        <div class="col-sm-10 allCategories discount_type">
                            <?php
if (!empty($offer->categories()->get()->toArray())) {
    $idArr = [];
    $arr = $offer->categories()->get(['store_categories.id'])->toArray();
    foreach ($arr as $a) {
        array_push($idArr, $a['id']);
    }
} else {
    $idArr = [];
}

$roots = App\Models\Category::roots()->with('categoryName')->get();
echo "<ul id='catTree' class='tree icheck'>";
foreach ($roots as $root) {
    renderNode($root, $idArr);
}

echo "</ul>";

function renderNode($node, $idArr)
{
    echo "<li class='tree-item fl_left ps_relative_li'>";
    echo '<div class="checkbox">
                                <label class="i-checks checks-sm"><input type="checkbox" class="checkCategoryId" name="category_id[]" value="' . $node->id . '" ' . (in_array($node->id, $idArr) ? 'checked' : '') . '  /><i></i>' . $node->categoryName->category . '</label></div>';
    if ($node->children()->with('categoryName')->count() > 0) {
        echo "<ul class='treemap fl_left'>";
        foreach ($node->children as $child) {
            renderNode($child, $idArr);
        }

        echo "</ul>";
    }
    echo "</li>";
}
?>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('start_date','Start Date ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <input type="text" name="start_date" value="{{ $offer->start_date }}"  class="form-control fromDate " placeholder="From Order Date" autocomplete="off" id="fromdatepicker">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('end_date','End Date ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <input type="text" name="end_date" value="{{ $offer->end_date }}" class="form-control toDate col-md-3" placeholder="To Order Date" autocomplete="off" id="todatepicker">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('user_specific','User Specific ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('user_specific',["0" => "No", "1" => "Yes"],null,["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="col-md-12 form-group userslist">
                        <div class="col-sm-2 control-label">
                            Search User
                        </div>
                        <div class="col-sm-10">
                            <input class="input-text" type="text" name="pdcts" onclick="tagFunction()" id="pdcts" placeholder="Start Typing Email...">
                        </div>
                    </div>
                    <div class="col-md-12 form-group userslist">
                        <div class="col-sm-2 control-label">
                            Selected Users
                        </div>
                        <div class="col-sm-10">
                            <?php
if (!empty($offer->userspecific()->get()->toArray())) {
    $arr = $offer->userspecific()->get()->toArray();
    ?>
                                <div id="log" style="height: 200px; width: 100%; overflow: auto;" class="ui-widget-content">
                                    <?php
foreach ($arr as $a) {
        ?>
                                        <div><?php echo $a['email']; ?><input type='hidden' name='uid[]' value='<?php echo trim($a['id']); ?>' ><a href='#' class='pull-right remove-rag'  ><i class='fa fa-trash'></i></a></div>
                                        <?php
}
    ?>
                                </div>
                                <?php
} else {
    ?>
                                <div id="log" style="height: 200px; width: 100%; overflow: auto;" class="ui-widget-content"></div>
                                <?php
}
?>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('preference','Preference',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('preference',null,["class"=>'form-control',"placeholder"=>"Select Preference"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('status','Status ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('status',["0" => "Disable", "1" => "Enable"],null,["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>                    
                    <div class="form-group">
                        {!!Form::label('image','Offer Image',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-md-10">
                            <input type="file" name="c_image" id="c_image">
                        </div>
                    </div>
                    <?php if (!empty($offer->offer_image)) {?>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-md-6">
                                <img height="150" width="150" src="{{asset('public/Admin/uploads/offers/').'/'.$offer->offer_image}}" class="img-responsive"   >
                                <a href="javascript:void();" class="deleteImg" data-value="{{ $offer->offer_image }}"><span class="label label-danger label-mini">Delete</span></a>
                            </div>
                        </div>
                        <?php } ?>
                    {!! Form::hidden('c_image', $offer->offer_image) !!}
                    <?php
                    $offerProducts = $offer->products()->whereIn('type', [1, 0])->get();
                    ?>
                    @if(count($offerProducts) > 0)
                    <div class="row">
                    <div class="col-md-2"><label class="control-label text-right" style="float: right;">Product Group</label></div>
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Product</th><th>Quantity</th>
                                            <!-- <th><button class="btn btn-sm btn-default" type="button" id="add-product"><i class="fa fa-plus"></i> Add</button></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($offerProducts as $offerProdcutKey => $offerProduct)
                                        <tr>
                                            <td>
                                                {{$offerProduct->product}}
                                            </td>
                                            <td>
                                            {{$offerProduct->pivot->qty}}
                                            </td>
                                            <td><a href="{{route('admin.offers.deleteProduct',['id'=>$offerProduct->pivot->id, 'offer_id' => $offer->id])}}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this product?')"data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($offerUsedcount==0)
                    <div class="row">
                    <div class="col-md-2"><label class="control-label text-right" style="float: right;">Product Group</label></div>
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Select Product</th><th>Quantity</th>
                                            <th><button class="btn btn-sm btn-default" type="button" id="add-product"><i class="fa fa-plus"></i> Add</button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-list">
                                        <tr>
                                            <td>
                                                <input type="text" class="col-md-12 form-control prod-search {{(count($offerProducts)==0)? 'validate[required]': ''}}" placeholder="Search Product" name="prod[]">
                                                <input type="hidden" class="col-md-12 form-control prod" name="prod_id[]">
                                            </td>
                                            <td>
                                                <input type="tel" class="col-md-12 form-control {{(count($offerProducts)==0)? 'validate[required]': ''}}" placeholder="Enter Order Quantity" name="prod_qty[]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    <?php
$offerProducts1 = $offer->products()->where('type', 2)->get();
?>
                    @if($offer->type == '2' && count($offerProducts1) > 0)
                    <div class="row">
                        <div class="col-md-2"><label class="control-label text-right" style="float: right;">Offer Product Group</label></div>
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Offer Product</th><th>Quantity</th>
                                            <!-- <th><button class="btn btn-sm btn-default" type="button" id="add-product"><i class="fa fa-plus"></i> Add</button></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($offerProducts1 as $offerProdcutKey1 => $offerProduct1)
                                        <tr>
                                            <td>
                                                {{$offerProduct1->product}}
                                            </td>
                                            <td>
                                            {{$offerProduct1->pivot->qty}}
                                            </td>
                                            <td><a href="{{route('admin.offers.deleteProduct',['id'=>$offerProduct1->pivot->id, 'offer_id' => $offer->id])}}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this product?')"data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($offerUsedcount==0)
                    <div class="row" id="show-offer-products">
                        <div class="col-md-2"><label class="control-label text-right" style="float: right;">Offered Product Group</label></div>
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Select Product</th><th>Quantity</th>
                                            <th><button class="btn btn-sm btn-default" type="button" id="add-offer-product"><i class="fa fa-plus"></i> Add</button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="offer-product-list">
                                        <tr>
                                            <td>
                                                <input type="text" class="col-md-12 form-control offer-prod-search {{(count($offerProducts1)==0)? 'validate[required]': ''}}" placeholder="Search Product" name="offer_prod[]">
                                                <input type="hidden" class="col-md-12 form-control offer-prod" name="offer_prod_id[]">
                                            </td>
                                            <td>
                                                <input type="tel" class="col-md-12 form-control {{(count($offerProducts1)==0)? 'validate[required]': ''}}" placeholder="Enter Order Quantity" name="offer_prod_qty[]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <input type="hidden" value="" name="CategoryIds">
                    <input type="hidden" value="" name="ProductIds">
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('myscripts')
<script>
    $("#showCategories").hide();
    $("#showProducts").hide();
    $(".checkCategoryId").click(function () {
        var ids = $(".allCategories input.checkCategoryId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='CategoryIds']").val(ids);
    });

    $("a.deleteImg").click(function () {
        var imgs = $("input[name='c_image']").val();
        var r = confirm("Are You Sure You want to Delete this Image?");
        if (r == true) {
            $("input[name='c_image']").val('');
            $(this).parent().hide();
        } else {

        }
    });

    $('#add-product').click(function () {
        var newProduct = '<tr><td><input type="text" class="col-md-12 form-control prod-search validate[required]" placeholder="Search Product" name="prod[]"><input type="hidden" class="col-md-12 form-control prod" name="prod_id[]"></td><td><input type="tel" class="col-md-12 form-control validate[required]" placeholder="Enter Order Quantity" name="prod_qty[]"></td><td><a class="del-product"><i class="fa fa-trash"></i></a></td></tr>';
        $('#product-list').append(newProduct);
        $(".prod-search").autocomplete({
        source: "{{route('admin.offers.searchProduct')}}",
        minLength: 1,
        select: function (event, ui) {
            // getSubprods(ui.item.id, $(this));
            console.log($(this).parent().find('input.prod'));
            $(this).attr('data-prdid', ui.item.id);
            $(this).parent().find('input.prod').val(ui.item.id);
            $(this).parent().parent().attr('data-prod-id', ui.item.id);
        }
    });
    });
    $('#add-offer-product').click(function () {
        var newProduct = '<tr><td><input type="text" class="col-md-12 form-control offer-prod-search validate[required]" placeholder="Search Product" name="offer_prod[]"><input type="hidden" class="col-md-12 form-control offer-prod" name="offer_prod_id[]"></td><td><input type="tel" class="col-md-12 form-control validate[required]" placeholder="Enter Order Quantity" name="offer_prod_qty[]"></td><td><a class="del-product"><i class="fa fa-trash"></i></a></td></tr>';
        //console.log(newProduct);
        $('#offer-product-list').append(newProduct);
        $(".offer-prod-search").autocomplete({
        source: "{{route('admin.offers.searchOfferProduct')}}",
        minLength: 1,
        select: function (event, ui) {
            // getSubprods(ui.item.id, $(this));
            $(this).attr('data-prdid', ui.item.id);
            console.log($(this).parent().find('input.offer-prod'));
            $(this).parent().find('input.offer-prod').val(ui.item.id);
            $(this).parent().parent().attr('data-offered-prod-id', ui.item.id);
        }
    });
    });

    $(".prod-search").autocomplete({
        source: "{{route('admin.offers.searchProduct')}}",
        minLength: 1,
        select: function (event, ui) {
            // getSubprods(ui.item.id, $(this));
            $(this).attr('data-prdid', ui.item.id);
            $(this).parent().find('input.prod').val(ui.item.id);
            $(this).parent().parent().attr('data-prod-id', ui.item.id);
        }
    });
    $(".offer-prod-search").autocomplete({
        source: "{{route('admin.offers.searchOfferProduct')}}",
        minLength: 1,
        select: function (event, ui) {
            // getSubprods(ui.item.id, $(this));
            $(this).attr('data-prdid', ui.item.id);
            console.log($(this).parent().find('input.offer-prod'));
            $(this).parent().find('input.offer-prod').val(ui.item.id);
            $(this).parent().parent().attr('data-offered-prod-id', ui.item.id);
        }
    });

    $('body').on('click', '.del-product', function () {
        // console.log($(this).parent().parent());
        $(this).parent().parent().remove();
    });

    $('.offer-type').change(function () {
        var offerType = $(this).val();
        console.log(offerType);
        if(offerType==1){
            $('.discount_type').show();
            checkOfferType();
        } else {
            $('.discount_type').hide();
            $('#show-offer-products').show();
        }
    });

    $(".checkProductId").click(function () {
        var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='ProductIds']").val(ids);
    });
    checkOfferType();

    function checkOfferType() {
        console.log($('.offer-type').val());
        if($('.offer-type').val()==2){
            $('#show-offer-products').show();
            $('.discount_type').hide();
        }else {
            $('.discount_type').show();
            $('#show-offer-products').hide();
        }
        // if ($("#offer_type").val() == 2) {
        //     $("#showProducts").hide();
        //     $("#showCategories").show();
        //     var ids = $(".allCategories input.checkCategoryId:checkbox:checked").map(function () {
        //         return $(this).val();
        //     }).toArray();
        //     $("input[name='CategoryIds']").val(ids);
        // }
        // if ($("#offer_type").val() == 3) {
        //     $("#showCategories").hide();
        //     $("#showProducts").show();
        //     var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
        //         return $(this).val();
        //     }).toArray();
        //     $("input[name='ProductIds']").val(ids);
        // }
    }

    $("#offer_type").change(function () {
        console.log($("#offer_type").val());
        if ($("#offer_type").val() == 2) {
            $("#showProducts").hide();
            $("#showCategories").show();
            $("input[name='ProductIds']").val("");
        }

        if ($("#offer_type").val() == 3) {
            $("#showCategories").hide();
            $("#showProducts").show();
            $("input[name='CategoryIds']").val("");
        }

        if ($("#offer_type").val() == 1) {
            $("#showCategories").hide();
            $("#showProducts").hide();
            $("input[name='CategoryIds']").val("");
            $("input[name='ProductIds']").val("");
        }
    });

    if ($("#user_specific").val() == 0) {
        $(".userslist").hide();
    }

    $("#user_specific").change(function () {
        if ($("#user_specific").val() == 1) {
            $(".userslist").show();
        }
        else {
            $(".userslist").hide();
        }
    });
    var d = new Date();
    // $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'}).datepicker("update", d);
    // $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'}).datepicker("update", d.setMonth(d.getMonth() + 1));
    $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd', startDate: '+1d'});
    $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd', startDate: '+1d'});


</script>
<script>
    var tagFunction = function () {
        function log(message) {
            $("<div>").html(message).prependTo("#log");
            $("#log").scrollTop(0);
        }

        $products = $("#pdcts");

        $products.autocomplete({
            source: "{{route('admin.offers.searchUser')}}",
            minLength: 2,
            select: function (event, ui) {
                log(ui.item ?
                        ui.item.email + "<input type='hidden' name='uid[]' value='" + ui.item.id + "' ><a href='#' class='pull-right remove-rag'  ><i class='fa fa-trash'></i></a>" : "");
            }
        });

        $products.data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li>")
                    .append("<a>" + item.email + "</a>")
                    .appendTo(ul);
        };
        ;
    };

    jQuery('body').on('click', '.remove-rag', function (event) {
        /* Act on the event */
        event.preventDefault();
        jQuery(this).parent().remove();
    });
</script>
@stop