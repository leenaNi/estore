@extends('Frontend.layouts.default')
@section('content')
<div ng-controller="comboProductController" data-ng-init="onloadFun()" >
    <div class="container">
        <form id="form[[product.id]]" action="{{ route('addToCart')}}">
            <span> 
                <div class="courseImg">
                    <img src="[[product.prodImage ]]">
                </div>
                <span> 
                    <div>[[product.product]]</div>         
                    <div>Description : [[product.shortDesc]]</div>
                    <div class="mt-5 mb-5">Price : 
                        <span class="price">
                            <div class="bfont splPDiv"><strike ng-show="checksplprice > 0 && checkprice > checksplprice"><?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> [[ product.price ]]</strike></div>
                            <div class="bfont fcblue whiteshadowtext"><span class="currency-sym"></span> [[ product.selling_price| number: 2 ]]</div><br/>
                        </span>
                    </div>
                    <input type='hidden' name='prod_id' value='[[product.id]]' data-parentid = "[[product.id]]">
                    <input type='hidden' name='prod_type' value='[[product.prod_type]]'>
                    <!--<input type="number" name="quantity" value="1"  max="[[product.stock]]" class="qty" style="text-align: center;" />--> 
                    <input type="hidden" name="price" value="[[product.spl_price]]" class="parent_price">
                    <div ng-if="product.comboproducts != ''">
                        <div class="row">      
                            <div ng-repeat="comboprd in product.comboproducts" class="col-md-2 col-sm-6 col-xs-6 align-center comboPrd" id="[[ 'combo'+comboprd.id]]">
                                <a class='comboProdsImg' data-comboid='[[comboprd.id]]'  href="javascript:void(0)"  ng-click="getComboInfo($event, comboprd.id)"> 
    <!--                                <img  class="image-responsive" src="{{ asset(Config('constants.productImgPath'))}}/[[ product.images]]"> -->
                                    <img src="[[comboprd.prodImage ]]">
                                </a>
                                <p class="text-center">[[comboprd.product]]</p>
                                <div ng-if='comboprd.prod_type == 3'>

                                    <div id="selAT[[comboprd.id]]" class="selAT-set">
                                        <div  ng-repeat="(attrsk1, attrsv1) in selAttributes" ng-init="start = 1">
                                            <span ng-if='attrsk1 == comboprd.id'>
                                                <div ng-repeat="(attrsk, attrsv) in attrsv1" ng-init="modelName = selaTT[[attrsk]]" ng-if="$index == 0" ng-init="start = start + 1">
                                                    <select  name="[[attrsv.name]]" class="selatts col_one_fourth  form-control mr-1-per attrSel selID[[$index]]_[[comboprd.id]]" id="selID[[$index]]"  ng-init="modelName = selaTT[[attrsk]]" ng-model="modelName"   ng-if="$index == 0" ng-change="selAttrChange(modelName, attrsk, start, comboprd.id)" ng-options="optk as optv for (optk, optv) in attrsv.options">
                                                        <option value="">[[attrsv.placeholder]]</option>
                                                    </select>
                                                </div>
                                                <!--                                    </span>
                                                                                </div>-->          
                                                <div ng-if="otherOptions.length == 0" >
                                                    <select ng-model="prodAttrValId" class="col_one_fourth  form-control attrSel" ng-change="getProductVarient(comboprd.id, prodAttrValId)" >
                                                        <option  ng-repeat="otherOptionsVal in otherOptions"  data-attr-id="[[getattrsval.attr_id]]" value="[[getattrsval.id]]">[[getattrsval.option_name]]</option>
                                                    </select>
                                                </div>                             
                                                <input type='hidden' name="sub_prod[['['+comboprd.id+']']]" value='' class="subPRod[[comboprd.id]]">   
                                                </div>
                                                <div class="clearfix"></div>
                                        </div>                           
                                    </div>
                                </div>             
                            </div> 
                            <input type="number" name="quantity" value="1"  max="[[product.stock]]" class="qty" id="quantity[[comboprd.id]]" style="text-align: center;" /> 
                            <input type='button' form-id='[[product.id]]' value='Add To Cart' class='addToCartB addToCart' >
                        </div>
                </span>
            </span>
        </form>
    </div>
</div>
@stop
@section('myscripts')
<script>
    $(document).ready(function () {
        $(".attr123").click(function () {
            alert("dfdsf");
        });
        $(".attrSel").each(function () {
            $(this).change(function () {
                var parentPRod = $(this).attr('parentPrd');
                console.log(parentPRod);
                $("input[name='sub_prod']").val("");
                attrval = [];
                $(".attrSel").each(function () {
                    attrval.push($(this).val());
                });
                $.ajax({
                    type: "POST",
                    url: "{!! route('getSubProd') !!}",
                    data: {attrval: attrval, parentPRod: parentPRod},
                    cache: false,
                    success: function (data) {
                        if (data != "invalid") {
                            $("input[name='sub_prod']").val(data.id);
                            $(".stockL").css("display", "block");
                            //$(".stockChk").text(data.stock);
                            $(".addToCartB").removeAttr("disabled", "disabled");
                        } else {
                            $(".stockL").css("display", "none");
                            $(".addToCartB").attr("disabled", "disabled");
                        }
                    }
                });
            });
        });

        $("#email_notify_btn").click(function () {
            var mail = $("#email_notify").val();
            var prod = $("#prod_id").val();
            $.ajax({
                data: "email=" + mail + "&prod=" + prod,
                url: "{{ route('notifyMail') }}",
                type: "post",
                dataType: "json",
                beforeSend: function () {
                    $("#notify_err").text("Please wait");
                },
                success: function (r) {
                    $("#notify_err").text(r.msg);
                }
            });
        });

    });
</script>
@stop
