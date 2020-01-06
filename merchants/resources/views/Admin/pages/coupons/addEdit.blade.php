@extends('Admin.layouts.default')
@section('content')
<style type="text/css">
    input[type=checkbox]{display:none;}
</style>
<section class="content-header">
    <h1>
        Coupons
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><a href="{{route('admin.coupons.view')}}" >Coupons </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            @if(in_array(Route::currentRouteName(),['admin.coupons.edit','admin.coupons.history']))

            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.edit']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.edit', ['id' => Input::get('id')]) !!}" aria-expanded="false">Coupons</a>
            </li>
            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.history']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.history', ['id' => Input::get('id')]) !!}"  aria-expanded="false">History</a>
            </li>
            @else
            <li class="{{ Route::currentRouteName()=='admin.coupons.add' ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.add') !!}" aria-expanded="false">Coupon Details</a>
            </li>
            @endif
        </ul>
        <div  class="tab-content" >
            <div class="active tab-pane" id="activity">
                <div class="row">
                    <div>
                        <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
                    </div>
                    <div class="col-md-12">
                        <div class="box noShadow noBorder">
                            <div class="box-body">
                                {!! Form::model($coupon, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'save_coupon' ]) !!}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('coupon_name', 'Coupon Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::hidden('id',null) !!}
                                        {!! Form::hidden('created_by', Session::get('loggedinAdminId')) !!}
                                        <input type="hidden" name="return_url" value="{{ Route::currentRouteName()=='admin.coupons.add' ? 'active' : '' }}" />                                    
                                        {!! Form::text('coupon_name',null, ["class"=>'form-control validate[required] ' ,"placeholder"=>'Coupon Name']) !!}
                                        <div id="coupon_name_re_validate" style="color:red;"></div>
                                    </div>                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('coupon_code', 'Coupon Code ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('coupon_code',null, ["id"=>"coupon_code","class"=>'form-control validate[required]' ,"placeholder"=>'Coupon Code']) !!}
                                        <span id="error_msg"></span>
                                        <div id="coupon_code_re_validate" style="color:red;"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('discount_type','Discount Type',['class'=>'control-label']) !!}
                                        {!! Form::select('discount_type',["2" => "Fixed", "1" => "Percentage"],null,["class"=>'form-control','id' => 'disc_type']) !!}
                                        <div id="discount_type_re_validate" style="color:red;"></div>
                                    </div>

                                </div>
                                @if($coupon->discount_type == '1')
                                <div class="col-md-6">
                                    <div class="form-group" id="coupon_val_div">
                                        {!!Form::label('coupon_value','Coupon Value ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('coupon_value', null ,["class"=>'form-control validate[required,custom[number],min[1]]',"placeholder"=>"Coupon Value" ]) !!}
                                        <div id="coupon_value_re_validate" style="color:red;"></div>
                                    </div>
                                </div>
                                @else
                                <div class="col-md-6">
                                    <div class="form-group" id="coupon_val_div">
                                        {!!Form::label('coupon_value','Coupon Value ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('coupon_value', ($coupon->coupon_value > 0)? number_format(($coupon->coupon_value * Session::get('currency_val')), 2):null ,["class"=>'form-control validate[required,custom[number],min[1]]',"placeholder"=>"Coupon Value" ]) !!}
                                        <div id="coupon_value_re_validate" style="color:red;"></div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('min_order_amt','Minimum Order Amount ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('min_order_amt',null,["class"=>'form-control priceConvertTextBox validate[required,custom[number],min[1]]',"placeholder"=>"Minimum Order Amount"]) !!}
                                        <div id="min_order_amt_re_validate" style="color:red;"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <?php
                                    if ($coupon->coupon_type != 0) {
                                        ?>
                                        <div class="form-group">
                                            {!!Form::label('coupon_type','Coupon Type ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                            {!! Form::select('coupon_type',["1" => "Entire Order", "2" => "Specific Categories", "3" => "Specific Products"],null,["class"=>'form-control validate[required]' ,"disabled"=>"disabled"]) !!}
                                            <input type="hidden" value="<?php echo $coupon->coupon_type; ?>" name="coupon_type">
                                        </div>

                                        <?php
                                    } else {
                                        ?>            
                                        <div class="form-group">
                                            {!!Form::label('coupon_type','Coupon Type',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                            {!! Form::select('coupon_type',["1" => "Entire Order", "2" => "Specific Categories", "3" => "Specific Products"],null,["class"=>'form-control validate[required] ']) !!}
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('start_date','From Date',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        <input type="text" name="start_date" value="{{ date('Y-m-d',strtotime(($coupon->start_date)?$coupon->start_date:date('Y-m-d'))) }}"  class="form-control  fromDate validate[required,custom[date]]" placeholder="From Date"   autocomplete="off" id="fromdatepicker">
                                        <div id="start_date_re_validate" style="color:red;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('end_date','To Date',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        <input type="text" name="end_date" value="{{ date('Y-m-d',strtotime(($coupon->end_date)?$coupon->end_date:date('Y-m-d'))) }}"  class="form-control  toDate col-md-3 validate[required,custom[date]]" placeholder="To Date" autocomplete="off" id="todatepicker">
                                        <div id="end_date_re_validate" style="color:red;"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('coupon_desc','Coupon Description',['class'=>'control-label']) !!}
                                        {!! Form::textarea('coupon_desc',null,["class"=>'form-control ',"placeholder"=>"Coupon Description",'rows'=>"1"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('no_times_allowed','Maximum Coupon Usage ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('no_times_allowed',null,["class"=>'form-control validate[required,custom[number]]', 'min'=>1,"placeholder"=>"No. of times this coupon is allowed"]) !!}
                                        <div id="no_times_allowed_re_validate" style="color:red;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('user_specific','User Specific',['class'=>'control-label']) !!}
                                        {!! Form::select('user_specific',["0" => "No", "1" => "Yes"],null,["class"=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group userslist">
                                        {!!Form::label('allowed_per_user','No of times allowed per User',['class'=>'control-label']) !!}
                                        {!! Form::text('allowed_per_user',null,["class"=>'form-control validate[required,custom[number]]', "placeholder"=>"No of times allowed per User"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group userslist">
                                        <lebel class="control-label">
                                            Search Customer
                                        </lebel>
                                        <input class="form-control" type="text" name="pdcts" onclick="tagFunction()" id="pdcts" placeholder="Start Typing Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group userslist">
                                        <lebel class="control-label">
                                            Selected Customers
                                        </lebel>
                                        <?php
                                       
                                        if (!empty($userCoupon)) {
                                            $arr =$userCoupon;
                                            ?>
                                            <div id="log" style="height: 42px; overflow: auto; padding: 10px;" class="ui-widget-content">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('image','Coupon Image',['class'=>'control-label']) !!}
                                        <input type="file" name="c_image" id="c_image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <?php if (!empty($coupon->coupon_image)) { ?>
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <img src="{{asset('public/Admin/uploads/coupons/')."/".$coupon->coupon_image}}" class="img-responsive"   >
                                                <a href="javascript:void();" class="deleteImg" data-value="{{ $coupon->coupon_image }}"><span class="label label-danger label-mini">Delete</span></a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    {!! Form::hidden('c_image', $coupon->coupon_image) !!}

                                    <input type="hidden" value="" name="CategoryIds">
                                    <input type="hidden" value="" name="ProductIds">
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                    <div class="form-group" id="showCategories">
                                        {!!Form::label('parent_id','Select Categories ',['class'=>'control-label']) !!}

                                        <div class="allCategories">
                                            <?php
                                            if (!empty($coupon->categories()->get()->toArray())) {
                                                $idArr = [];
                                                $arr = $coupon->categories()->get(['categories.id'])->toArray();
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
                                                // print_r($idArr); echo $node->id;
                                                $classStyle = (in_array($node->id, $idArr) ? 'checkbox-highlight' : '');
                                                echo "<li class='tree-item fl_left ps_relative_li'>";
                                                echo '<div class="checkbox">
                        <label class="i-checks checks-sm ' . $classStyle . '"><input type="checkbox" class="checkCategoryId" name="category_id[]" value="' . $node->id . '" ' . (in_array($node->id, $idArr) ? 'checked' : '') . '  /><i></i>' . $node->category . '</label></div>';

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
                                </div>
                                <div class="col-md-12 form-group" id="showProducts">
                                    {!!Form::label('parent_id','Select Products',['class'=>'col-sm-2 control-label']) !!}
                                    <div class="col-sm-3">
                                        <input class="form-control searchProducts" placeholder="Select Products" name="searchProducts" type="text">
                                    </div>

                                    <div class="col-sm-10 allProducts">
                                        <?php
                                        if (!empty($coupon->products()->get()->toArray())) {
                                            $pIDArr = [];
                                            $arr = $coupon->products()->get(['products.id'])->toArray();
                                            foreach ($arr as $a) {
                                                array_push($pIDArr, $a['id']);
                                            }
                                        } else
                                            $pIDArr = [];

                                        echo "<ul id='catTree' class='tree icheck'>";
                                        foreach ($products as $product) {
                                            echo "<li class='tree-item fl_left ps_relative_li searchProductsList' style='list-style-type:none;'>";
                                            echo '<div class="checkbox">
                                <label class="i-checks checks-sm"><input type="checkbox" class="checkProductId" name="product_id[]" value="' . $product->id . '" ' . (in_array($product->id, $pIDArr) ? 'checked' : '') . '  /><i></i>' . $product->product . '</label>
                            </div>';
                                            echo "</li>";
                                        }
                                        echo "</ul>";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="submit" value="Submit" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" >
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section> 
@stop 

@section('myscripts')
<script>
    /*  $("#save_coupon").validate({
     // Specify the validation rules
     rules: {
     coupon_name: "required",
     coupon_code: "required",
     coupon_value: {
     required: true,
     min: 1,
     number: true
     },
     min_order_amt: {
     required: true,
     min: 1,
     number: true
     },
     start_date: {
     required: true
     
     },
     end_date: {
     required: true
     
     }, no_times_allowed: {
     required: true,
     min: 1
     }
     },
     // Specify the validation error messages
     messages: {
     coupon_name: "Please enter coupon name",
     coupon_code: "Please enter coupon code",
     coupon_value: {
     required: "Please enter coupon discount value",
     min: "Number must be greater than 0",
     number: "Please enter valid number"
     },
     min_order_amt: {
     required: "Please enter min order amount.",
     min: "Number must be greater than 0",
     number: "Please enter valid number"
     },
     start_date: {
     required: "Please enter start date"
     },
     end_date: {
     required: "Please enter end date"
     },
     no_times_allowed: {
     required: "Please enter no. of times coupon allowed",
     min: "Number must be greater than 0",
     number: "Please enter valid number"
     }
     },
     errorPlacement: function (error, element) {
     var name = $(element).attr("name");
     error.appendTo($("#" + name + "_re_validate"));
     }
     });
     */

</script>
<script>

    $(document).on('keyup', '.searchProducts', function () {
        var getVal = $(this).val().toLowerCase().trim();
        var getMatchedList = $('.searchProductsList');
        $('.searchProductsList').hide();
        $.each(getMatchedList, function (k, v) {
            var getLi = $(this).text().toLowerCase();
            console.log(getLi.search(getVal));
            if (getLi.search(getVal) >= 0) {
                $(this).show();
            }
        })
    })
    $("#showCategories").hide();
    $("#showProducts").hide();

    $("a.deleteImg").click(function () {
        var imgs = $("input[name='c_image']").val();
        var r = confirm("Are You Sure You want to Delete this Image?");
        if (r == true) {
            $("input[name='c_image']").val('');
            $(this).parent().hide();
        } else {

        }
    });

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

    if ($("#coupon_type").val() == 2) {
        $("#showProducts").hide();
        $("#showCategories").show();

        var ids = $(".allCategories input.checkCategoryId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='CategoryIds']").val(ids);
    }

    if ($("#coupon_type").val() == 3) {
        $("#showCategories").hide();
        $("#showProducts").show();

        var ids = $(".allProducts input.checkProductId:checkbox:checked").map(function () {
            return $(this).val();
        }).toArray();
        $("input[name='ProductIds']").val(ids);
    }

    $("#coupon_type").change(function () {
        if ($("#coupon_type").val() == 2) {
            $("#showProducts").hide();
            $("#showCategories").show();
            $("input[name='ProductIds']").val("");
        }

        if ($("#coupon_type").val() == 3) {
            $("#showCategories").hide();
            $("#showProducts").show();
            $("input[name='CategoryIds']").val("");
        }

        if ($("#coupon_type").val() == 1) {
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
        } else {
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
            source: "{{route('admin.coupons.searchUser')}}",
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
<script>
    $(document).ready(function () {
        $("#coupon_code").keyup(function () {
            var code = $(this).val();
            console.log('code' + code);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.coupons.checkcoupon') }}",
                data: {code: code},
                cache: false,
                success: function (response) {
                    // console.log('@@@@'+response['msg'])
                    if (response['status'] == 'success') {
                        $('#coupon_code').val('');
                        $('#error_msg').text(response['msg']).css({'color': 'red'});
                    } else
                        $('#coupon_code').text('');
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
        });

        $('#disc_type').change(function () {
            var coupVal = <?php echo $coupon->coupon_value; ?>;
            console.log($(this).val() + " type of " + typeof ($(this).val()));
            if ($(this).val() == '1') {
                console.log("Div " + $('#coupon_val_div input[name="not_in_used"]'));
                $('#coupon_val_div input[name="coupon_value"]').remove(); //.removeClass('priceConvertTextBox');
//                $('#coupon_val_div input[name="coupon_value"]').remove();
                $('#coupon_val_div input[name="not_in_used"]').attr('name', 'coupon_value').val(coupVal);
//                $('#coupon_val_div input[name="coupon_value"]').val(coupVal);
            } else {
//                $('input[name="coupon_value"]').addClass('priceConvertTextBox');
                convertCouponVal();

            }
        });

        function convertCouponVal() {
            $ele = $('input[name="coupon_value"]');
            var getPrice = $ele.val();
            getPrice = getPrice.replace(",", "");
            getPrice = parseFloat($ele.val());
            if (isNaN(getPrice)) {
                var getPrice = " ";
            } else {
                var calCulate = (getPrice * <?= Session::get('currency_val') ?>).toFixed(2);
                $ele.attr("value", calCulate);
            }
            var getName = 'coupon_value';
            $ele.parent().append("<input type='hidden' name='" + getName + "' class='priceConvertTextBoxMain' value='" + getPrice + "' > ");
            $ele.attr("name", "not_in_used");
        }
    });
</script>

@stop