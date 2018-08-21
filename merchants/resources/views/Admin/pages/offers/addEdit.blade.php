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
                        {!!Form::label('offer_discount_type','Offer Discount Type ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('offer_discount_type',["2" => "Fixed", "1" => "Percentage"],null,["class"=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('offer_discount_value','Enter Offer Discount Value',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('offer_discount_value',null,["class"=>'form-control',"placeholder"=>"Enter Offer Discount Value"]) !!}
                        </div>
                    </div>
                    
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    
                    <div class="form-group">
                        {!!Form::label('min_order_qty','Enter Minimum Order Quantity',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('min_order_qty',null,["class"=>'form-control',"placeholder"=>"Enter Minimum Order Quantity"]) !!}
                        </div>
                    </div>
                    
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    
                    <div class="form-group">
                        {!!Form::label('min_free_qty','Enter Minimum Free Quantity',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('min_free_qty',null,["class"=>'form-control',"placeholder"=>"Enter Minimum Free Quantity"]) !!}
                        </div>
                    </div>
                    
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    
                    <div class="form-group">
                        {!!Form::label('min_order_amt','Enter Minimum Order Amount',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('min_order_amt',null,["class"=>'form-control',"placeholder"=>"Enter Minimum Order Amount"]) !!}
                        </div>
                    </div>
                    
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    
                    <div class="form-group">
                        {!!Form::label('max_discount_amt','Enter Maximum Discount Amount',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('max_discount_amt',null,["class"=>'form-control',"placeholder"=>"Enter Maximum Discount Amount"]) !!}
                        </div>
                    </div>
                    
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    
                    <div class="form-group">
                        {!!Form::label('full_incremental_order','Full Incremental Order ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('full_incremental_order',["0" => "No", "1" => "Yes"],null,["class"=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <?php
                    if ($offer->offer_type != 0) {
                        ?>
                        <div class="form-group">
                            {!!Form::label('offer_type','Offer Type ?',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('offer_type',["1" => "Entire Order", "2" => "Specific Categories", "3" => "Specific Products"],null,["class"=>'form-control' , "disabled"=>"disabled"]) !!}
                                <input type="hidden" value="<?php echo $offer->offer_type; ?>" name="offer_type">
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>            
                        <div class="form-group">
                            {!!Form::label('offer_type','Offer Type ?',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('offer_type',["1" => "Entire Order", "2" => "Specific Categories", "3" => "Specific Products"],null,["class"=>'form-control']) !!}
                            </div>
                        </div>

                        <?php
                    }
                    ?>

                    <div class="col-md-12 form-group" id="showCategories">
                        {!!Form::label('parent_id','Select Categories',['class'=>'col-sm-2 control-label']) !!}

                        <div class="col-sm-10 allCategories">
                            <?php
                            if (!empty($offer->categories()->get()->toArray())) {
                                $idArr = [];
                                $arr = $offer->categories()->get(['categories.id'])->toArray();
                                foreach ($arr as $a) {
                                    array_push($idArr, $a['id']);
                                }
                            } else
                                $idArr = [];

                            $roots = App\Models\Category::roots()->get();
                            echo "<ul id='catTree' class='tree icheck'>";
                            foreach ($roots as $root)
                                renderNode($root, $idArr);
                            echo "</ul>";

                            function renderNode($node, $idArr) {
                                echo "<li class='tree-item fl_left ps_relative_li'>";
                                echo '<div class="checkbox">
                        <label class="i-checks checks-sm"><input type="checkbox" class="checkCategoryId" name="category_id[]" value="' . $node->id . '" ' . (in_array($node->id, $idArr) ? 'checked' : '') . '  /><i></i>' . $node->category . '</label></div>';

                                if ($node->children()->count() > 0) {
                                    echo "<ul class='treemap fl_left'>";
                                    foreach ($node->children as $child)
                                        renderNode($child, $idArr);
                                    echo "</ul>";
                                }

                                echo "</li>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-md-12 form-group" id="showProducts">
                        {!!Form::label('parent_id','Select Products',['class'=>'col-sm-2 control-label']) !!}

                        <div class="col-sm-10 allProducts">
                            <?php
                            if (!empty($offer->products()->get()->toArray())) {
                                $pIDArr = [];
                                $arr = $offer->products()->get(['products.id'])->toArray();
                                foreach ($arr as $a) {
                                    array_push($pIDArr, $a['id']);
                                }
                            } else
                                $pIDArr = [];

                            echo "<ul id='catTree' class='tree icheck'>";
                            foreach ($products as $product) {
                                echo "<li class='tree-item fl_left ps_relative_li' style='list-style-type:none;'>";
                                echo '<div class="checkbox">
                                <label class="i-checks checks-sm"><input type="checkbox" class="checkProductId" name="product_id[]" value="' . $product->id . '" ' . (in_array($product->id, $pIDArr) ? 'checked' : '') . '  /><i></i>' . $product->product . '</label>
                            </div>';
                                echo "</li>";
                            }
                            echo "</ul>";
                            ?>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('start_date','From Coupon Date ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <input type="text" name="start_date" value="{{ $offer->start_date }}"  class="form-control fromDate " placeholder="From Order Date" autocomplete="off" id="fromdatepicker">
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('end_date','To Coupon Date ?',['class'=>'col-sm-2 control-label']) !!}
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
                        {!!Form::label('status','Status ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('status',["0" => "No", "1" => "Yes"],null,["class"=>'form-control']) !!}
                        </div>
                    </div>

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

    $(".checkProductId").click(function () {
        var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='ProductIds']").val(ids);
    });

    if ($("#offer_type").val() == 2) {
        $("#showProducts").hide();
        $("#showCategories").show();

        var ids = $(".allCategories input.checkCategoryId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='CategoryIds']").val(ids);
    }

    if ($("#offer_type").val() == 3) {
        $("#showCategories").hide();
        $("#showProducts").show();

        var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='ProductIds']").val(ids);
    }

    $("#offer_type").change(function () {
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

    $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});


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