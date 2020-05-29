@extends('Frontend.layouts.default')
@section('content')
<div class="container" ng-controller="configProductController">
    <form id="form[[product.id]]" action="{{ route('addToCart')}}">
        <span>
            <a href='[[product.url_key]]'>
                <img ng-src="[[product.prodImage]]" height="200" width="200"/>
            </a>
        </span>
        <div>[[product.product]]</div>
        <div ng-bind-html="proDesc | toTrust"></div>
        <div>Price : <span class="currency-sym"></span>[[product.selling_price]]</div><br/>
        <div>
            <form id="form[[product.id]]" action="{{ route('addToCart')}}">
                <div id="selAT">
                    <select  ng-repeat="(attrsk, attrsv) in selAttributes" name='[[attrsv.name]]' class="selatts attrSel  form-control" id="selID[[$index]]"  ng-init="modelName = selaTT[[attrsk]]" ng-model="modelName"   ng-if="$index == 0" ng-change="selAttrChange(modelName, attrsk, $index + 1)" ng-options="optk as optv for (optk, optv) in attrsv.options" required>
                        <option value="">[[attrsv.placeholder]]</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div ng-if="otherOptions.length == 0" >
                    <select ng-model="prodAttrValId" class='attrSel'  ng-change="getProductVarient(product.id, prodAttrValId)" >

                        <option  ng-repeat="otherOptionsVal in otherOptions"  data-attr-id="[[getattrsval.attr_id]]" value="[[getattrsval.id]]">[[getattrsval.option_name]]</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div>
                    <input type='hidden' name='prod_id' value='[[product.id]]' data-parentid = "[[product.id]]">
                    <input type='hidden' name='prod_type' value='[[product.prod_type]]'>
                    <input type='hidden' name='sub_prod' value='' class="subPRod">
                    <p class="stockL" style="display: none;">Stock Left<b class="stockChk"></b></p>
                    <input type="number" name="quantity" id="quantity" value="1"  max="[[product.stock]]" class="qty" min="1" onkeypress="return isNumber(event);" style="text-align: center;" />
                    <input type='button' form-id='[[product.id]]' value='Add To Cart' class='addToCartB addToCart'>
                </div>        
        </div>
    </form>
</div>
@stop
@section('myscripts')
<script>
    $(document).ready(function () {
        $('head').append('<meta property="og:image" content="<?= asset(Config('constants.productImgPath')) ?>/<?= $product->prodImage ?>" /> ');
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 49 || charCode > 57)) {
            return false;
        }
        return true;
    }

</script>
@stop
