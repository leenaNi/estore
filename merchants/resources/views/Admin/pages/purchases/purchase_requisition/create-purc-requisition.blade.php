@extends('Admin.layouts.default')
@section('mystyles')
<style>
    .error{
        color:red;
        font-size: 13;
    }
    .trError{
        background-color: #ffece6 !important;

    }
    .nav-tabs-custom>.nav-tabs>li>a, .nav-tabs-custom>.nav-tabs>li>a:hover{cursor: not-allowed;}
    .cashbackAmt input {
        margin-right: 10px;
        position: relative;
        top: -18px;
    }
    ul.adminListing {
        list-style: none;
        padding-left: 0px !important;
        margin-top: 30px;
    }
    ul.adminListing li{margin-bottom: 15px;}
    .cashbackAmt p a {
        color: #0c00b3;
    }
    .mar-bot15{margin-bottom: 15px;}
</style>
@stop
@section('content')
<section class="content-header">
    <h1>
        
        <small>Create Purchase Order</small>
    </h1>
    <ol class="breadcrumb">
        <li> <i class="fa fa-cart-arrow-down"></i> Purchase Order</li>
        <li class="active">Create Purchase Order</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h3>Vendor Details</h3>
                <div class="panel-body noMobilePadding">
                            {{ Form::open(['id'=>'custInfo','class'=>'custInfo']) }}
                            <div class="line line-dashed b-b line-lg pull-in"></div>
                            <div class="form-group col-md-12">
                                {!! Form::label('Email Id', 'Mobile Number ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                {!! Form::text('s_phone',null, ["autofocus" =>"autofocus","id"=>'customerEmail',"class"=>'form-control customerEmail validate[required]' ,"placeholder"=>'Enter Mobile Number', "required","tabindex"=>1]) !!}
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in"></div>
                            <div class="form-group custdata col-md-6 mob-marBottom15" style="display: none;"> 
                                {!! Form::label('First Name', 'First Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                {!! Form::text('cust_firstname',null, ["class"=>'form-control inpt validate[required]']) !!}
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in"></div>
                            <div class="form-group custdata col-md-6 mob-marBottom15" style="display: none;">
                                {!! Form::label('Last Name', 'Last Name',['class'=>'control-label']) !!}
                                {!! Form::text('cust_lastname',null, ["class"=>'form-control inpt']) !!}  
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in" ></div>

                            <div class="form-group custdata col-md-6" style="display: none;">
                                {!! Form::label('Email Id', 'Email Id',['class'=>'control-label']) !!}
                                {!! Form::email('email_id',null, ["class"=>'form-control inpt']) !!}
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in"></div>

                            <div class="form-group custdata col-md-6" style="display: none;">
                                {!! Form::label('Telephone', 'Mobile Number',['class'=>'control-label']) !!}
                                {!! Form::text('cust_telephone',null, ["class"=>'form-control inpt']) !!}
                            </div>

                            <div class="line line-dashed b-b line-lg pull-in" ></div>

                            {{ Form::hidden("customer_id",null,['class'=>'inpt']) }}

                            {{ Form::close() }}
                        </div>

                        <h3>Product Details</h3>
<address class="pull-left col-md-6" class="shippedAdd">

                        </address>
                        <div class="pull-right">
                            <button  class="btn sbtn btn-primary margin addCourse ">Add New Product</button>
                        </div>
                        <div class="panel-body">
                            {{ Form::open(['method'=>'post','route'=>'admin.orders.saveCartData','id'=>'prodDetailsForm']) }}
                            {{ Form::hidden('addressid',null) }}
                            {{ Form::hidden('userid',null) }}
                            <table class="table table-striped tableVaglignMiddle table-hover prodTable">
                                <thead>
                                <th width="30%">Product</th>
                                <th width="20%">Variant</th>
                                <th width="20%">Quantity </th>
                                <th width="20%">Price ({{htmlspecialchars_decode(Session::get('currency_symbol'))}})</th>
                                @if($feature['tax']==1)
                                <th width="20%">Tax ({{htmlspecialchars_decode(Session::get('currency_symbol'))}})</th>
                                @endif
                                <th width="5%">Action</th>
                                </thead>
                                <tbody class="newRow">
                                    <tr>
                                        <td width="30%">
                                            <input type="text" class="form-control prodSearch validate[required]" placeholder="Search Product" name="prod_search" >
                                        </td >
                                        <td width="20%">
                                            {{ Form::select("cartData[prod_id][sub_prod_id]",[],null,['class'=>'form-control subprodid validate[required]','style'=>"display:none;"]) }}   
                                        </td>
                                        <td width="20%">
                                            <span class='prodQty' style="display:none"><input type="number" name='cartData[prod_id][qty] validate[required]' class='qty form-control' min="1" value="1"></span>
                                        </td>
                                        <td width="20%">
                                            <span class='prodPrice'>0</span>
                                        </td>
                                        @if($feature['tax']==1)
                                        <td width="20%">
                                            <span class='taxAmt'>0</span>
                                        </td>
                                        @endif
                                        <td width='5%' class="text-center">
                                            <span class="delRow" data-toggle="tooltip" title="Delete" data-original-title="Remove"><i class="fa fa-trash fa-fw"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td>
                                        {{ Form::select("payment_mode",[''=>"Payment Mode","Cash"=>"Cash","DD"=>"DD","Other"=>"Other"],null,['class'=>'form-control validate[required] paymode']) }}
                                    </td>
                                    <td colspan="2">{{ Form::textarea("remarks",null,['class'=>'form-control remark','rows'=>"1",'cols'=>"50","Placeholder"=>'Remarks (If any)']) }}</td>
                                    <td colspan="3"> Subtotal: <b><span class="subtotal">0</span></b></td>
                                </tr>

                            </table>

                            <div class="col-md-6 noRightpadding noMobilePadding">
                                <table class="table tableVaglignMiddle table-hover priceTable">
                                   
                                    <tr class="sub-total-amt">
                                        <th><div class="black-bg">Subtotal</div></th>

                                        <td><div class="black-bg"><strong> <span class="amount finalAmt"></span></strong></div></td>
                                    </tr>
                                    <tr class="order-total">
                                    </tr>
                                </table>
                            </div>    

                            <div class="form-group text-right col-sm-12 noallMargin noAllpadding">
                               <!--  <button class="btn btn-black placeOrderBack mobileSpecialfullBTN">Back</button> -->
                                <button class="btn btn-black cancelBtn mobileSpecialfullBTN">Cancel</button> {!! Form::button('Place Order <i class="fa fa-spinner placeorderSpinner" aria-hidden="true"></i>',["class" => "btn btn-primary placeOrder mobileSpecialfullBTN"]) !!}  
                            </div>
                            {{ Form::close() }}
                        </div>
                        <table  style="display:none;">
                            <tbody class="toClonetr">
                                <tr>
                                    <td width="30%">
                                        <input type="text" class="form-control prodSearch validate[required]" placeholder="Search Product" name="prod_search">

                                    </td>
                                    <td width="20%">
                                        {{ Form::select("cartData[prod_id][sub_prod_id]",[],null,['class'=>'form-control subprodid validate[required]','style'=>"display:none;"]) }}   
                                    </td>

                                    <td width="20%" >
                                        <span class='prodQty' style="display:none"><input type="number" min="1" value="1" name='cartData[prod_id][qty]' class='qty form-control'></span>
                                    </td>
                                    <td width="20%">
                                        <span class='prodPrice'>0</span>
                                    </td>
                                    @if($feature['tax']==1)
                                    <td width="20%">
                                        <span class='taxAmt'>0</span>
                                    </td>
                                    @endif
                                    <td width="5%" class="text-center"> 
                                        <span class="delRow" data-toggle="tooltip" title="Delete" data-original-title="Remove"><i class="fa fa-trash fa-fw"></i></a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

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
    jQuery.validator.addMethod("phonevalidate", function (telephone, element) {
        telephone = telephone.replace(/\s+/g, "");
        return this.optional(element) || telephone.length > 9 &&
                telephone.match(/^[\d\-\+\s/\,]+$/);
    }, "Please specify a valid Mobile number");
    $(".placeorderSpinner").hide();
    $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle');
    $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');



    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    function calc() {
        prodPrice = 0;
        $.each($(".prodPrice"), function (prodpv) {
            prodPrice += parseInt($(this).text());
        });
        //console.log( prodPrice);exite;
        $(".subtotal").text(prodPrice);
    }

    function setValuesToInpt(custid, firstname, lastname, telephone, emailid) {
        $("input[name='s_phone']").val(telephone);
        $("input[name='customer_id']").val(custid);
        $("input[name='cust_firstname']").val(firstname);
        $("input[name='cust_lastname']").val(lastname);
        $("input[name='cust_telephone']").val(telephone);
        $("input[name='email_id']").val(emailid);
        $(".customerEmail").css("border-color", "");
        $(".inpt").prop('readonly', false);
    }
    function removeError(thisEle) {
        thisEle.parent().parent().removeClass('trError');
    }
    function getAdd(addid) {
        addData = addid
        $.post("{{ route('admin.orders.getCustomerAdd') }}", {addData: addData}, function (data) {
            $.each(data, function (addk, addv) {
                $("input[name='" + addk + "']").val("");

                $("input[name='" + addk + "']").val(addv);

                if (addk == 'country_id' || addk == 'zone_id') {
                    $("select[name='" + addk + "']").val("");
                    $("select[name='" + addk + "']").val(addv);
                }
                if (addk == 'id')
                    $("input[name='address_id']").val(addv);
            });
        });
    }

    function getSubprods(prodid, ele) {
        var rows = $(".newRow").find('tr');
        //console.log($(".newRow").find('tr'));
        var selected_prod = [];
        jQuery.each(rows, function (i, item) {
            var subprodid = parseInt($(this).find('.subprodid').val());
            if (subprodid != "" && subprodid != null) {
                selected_prod.push(subprodid);
            }
        });

        prodid = prodid;
        prodSel = ele;
        removeError(prodSel);
        prodSel.attr("name", "cartData[" + prodid + "]");
        $.post("{{ route('admin.orders.getSubProds') }}", {prodid: prodid, data: selected_prod}, function (subprods) {
            prodSel.parent().parent().find('.subprodid').html("");
            // prodSel.parent().parent().find('.prodPrice').text(0);
            prodSel.parent().parent().find('.prodQty').show();
            if (subprods.length > 0) {
                prodSel.parent().parent().find('.subprodid').show();
                // attr('data-subpr', ui.item.id);
                subProdOpt = "<option value=''>Please select</option>";
                $.each(subprods, function (subprdk, subprdv) {
                    subprodname = subprdv.product.split("Variant (");
                    if (selected_prod.indexOf(subprdv.id) == -1) {
                        subProdOpt += "<option value='" + subprdv.id + "'>" + subprodname[1].replace(")", "") + "</option>";
                    }
                });
                prodSel.parent().parent().find('.subprodid').html(subProdOpt);
            } else {
                qty = prodSel.parent().parent().find('.qty').val();
                parentprdid = prodid;
                //console.log(parentprdid);exite;
                $.post("{{route('admin.orders.getProdPrice')}}", {parentprdid: parentprdid, qty: qty, pprd: 1}, function (price) {
                    console.log(JSON.stringify(price));
                    prodSel.parent().parent().find('.prodPrice').text((price.price).toFixed(2));
                    <?php if ($feature['tax'] == 1) { ?>
                    prodSel.parent().parent().find('.taxAmt').text((price.tax).toFixed(2));
                    <?php } ?>
                    // calc();
                });
                prodSel.parent().parent().find('.subprodid').hide();
                clearAllDiscount();
            }
        });
    }

    $(".cancelBtn").on("click", function () {
        window.location.href = "{{ route('admin.requisition.view') }}";
    });
    $("#customerEmail").autocomplete({
        source: "{{ route('admin.orders.getCustomerEmails') }}",
        minLength: 1,
        select: function (event, ui) {
            ele = event.target;
            setValuesToInpt(ui.item.id, ui.item.firstname, ui.item.lastname, ui.item.telephone, ui.item.email);
            $(".custdata").show();

        }
    });
    $(".customerEmail").on("keyup", function () {
        $(".custdata").show();
    });
    $(".customerEmail").on("change", function () {
        $(".custdata").show();
        term = $(this).val();
        thisEle = $(this);
        thisEle.css("border-color", "");
        thisEle.closest("p").remove();
        $.post("{{route('admin.orders.getCustomerEmails') }}", {term: term}, function (res) {
            resp = JSON.parse(res);
            chkLengh = Object.keys(resp).length;
            if (chkLengh == 1) {
                setValuesToInpt(resp[0].id, resp[0].firstname, resp[0].lastname, resp[0].telephone, resp[0].email);
            } else if (chkLengh == 0) {
                $(".inpt").removeAttr('readonly');
                $(".inpt").val('');
                phonev = $("input[name='s_phone']").val();
                $("input[name='cust_telephone']").val(phonev);
            }

        });

    });
    $(".skipAddress").on("click", function () {
        $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#product-details"]').tab('show');

        $("input[name='address_id']").val('')
    });
    /* $("#custInfo").validate({
     // Specify the validation rules
     rules: {
     s_phone: {required: true,
     phonevalidate: true},
     cust_telephone: {required: true,
     phonevalidate: true}
     },
     // Specify the validation error messages
     messages: {
     s_phone: {
     required: "Telephone is required"
     },
     cust_telephone: {
     required: "Telephone is required"
     }
     },
     errorPlacement: function (error, element) {
     $(element).after(error);
     }
     });*/
    $(".fa-spinner").hide();
    $(".custDetailsNext").on("click", function () {
        var valid = $("#custInfo").validationEngine('validate');
        //  if ($("#custInfo").valid()) {
        if (valid) {
            $(".fa-spinner").show();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.getCustomerData') }}",
                data: $(".custInfo").serialize(),
                cache: false,
                success: function (data) {
                    $(".fa-spinner").hide();
                    $("input[name='customer_id']").val(data.id);
                    $("input[name='user_id']").val(data.id);
                    $("input[name='firstname']").val(data.firstname);
                    $("input[name='lastname']").val(data.lastname);
                    $("input[name='phone_no']").val(data.telephone);
                    $(".curRewPointsOld").text(data.cashback);
                    $("input[name='cashback_hidden']").val(data.cashback);
                    address = data.addresses;
                    addDiv = "";
                    $.each(address, function (addk, addv) {
                        addData = JSON.stringify(addv);
                        addDiv += "<div class='col-md-6'><div class='box addressColumn paddingAll10'>";
                        addDiv += "<input data-add='" + addv.id + "' id='opt_" + addv.id + "'  class='addRadio pull-left marginright10' type='radio' value='" + addv.id + "' name='addRedioBut' >";
                        addDiv += "<div data-adddiv='" + addv.id + "' class='appendedAddDiv'  style='cursor:pointer;'><p>" + addv.firstname + " " + addv.lastname + "</p>";
                        addDiv += "<p>" + addv.address1 + " " + addv.address2 + " " + addv.address3 + "</p>";
                        addDiv += "<p>" + addv.city + " - " + addv.postcode + "</p>";
                        addDiv += "<p>" + addv.statename + "</p>";
                        addDiv += "<p>" + addv.countryname + "</p>";
                        addDiv += "<p> Contact Number: " + addv.phone_no + "</p>";
                        addDiv += "</div></div></div>";
                    });
                    $(".addressDiv").html(addDiv);
                    $("input[type='radio']:first").trigger('click');
                    $('.nav-tabs a[href="#shipping-address"]').tab('show')
                    $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
                    $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');
                }
            });
        } else {
            $("#custInfo").validationEngine();
        }
    });
    $(".addressDiv").delegate(".appendedAddDiv", "click", function (e) {
        att = $(this).attr('data-adddiv');
        $('#opt_' + att).prop('checked', true);
        getAdd(att);
    });
    $(".addressDiv").delegate(".addRadio", "click", function () {
        var addData = $(this).attr('data-add');
        getAdd(addData);
    });
    $(".country").on("change", function () {
        countryid = $(this).val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin.orders.getCustomerZone') }}",
            data: {countryid: countryid},
            cache: false,
            success: function (data) {
                $("#state").html(data);
            }
        });
    });


    $(".NextAdd").on("click", function (e) {
        var valid = $("#custAddForm").validationEngine('validate');
        //  if ($("#custInfo").valid()) {
        e.preventDefault();
        if (valid) {
            $(".fa-spinner").show();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.saveCustomerAdd') }}",
                data: $("#custAddForm").serialize(),
                cache: false,
                success: function (res) {
                    if (res !== 0) {
                        $("input[name=addressid]").val(res.addressid);
                        $("input[name=userid]").val(res.userid);



                        // var  addData = $("input[name='address_id']").val();
                        $('.nav-tabs a[href="#product-details"]').tab('show');
                        $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle')
                        $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
                        $('.nav-tabs a[href="#product-details"]').tab('show');
                    }
                }
            })
        } else {
            $("#custAddForm").validationEngine();
        }
    })
    /*
     $("#custAddForm").validate({
     // Specify the validation rules
     rules: {
     firstname: "required",
     country_id: "required",
     zone_id: "required",
     address1: "required",
     address2: "required",
     postcode: {required: true,
     number: true
     },
     city: "required",
     phone_no: {
     required: true,
     phonevalidate: true,
     }
     },
     // Specify the validation error messages
     messages: {
     firstname: "First Name is required.",
     country_id: "Country is required.",
     zone_id: "State is required.",
     address1: "Address Line 1 is required.",
     address2: "Address Line 2 is required.",
     postcode: {
     required: "Pin Code is required.",
     number: "Valid pin Code is required"
     },
     city: "City is required.",
     phone_no: {
     required: "Mobile number is required.",
     }
     },
     submitHandler: function (form) {
     $.post("{{ route('admin.orders.saveCustomerAdd') }}", $("#custAddForm").serialize(), function (res) {
     if (res !== 0) {
     $("input[name=addressid]").val(res.addressid);
     $("input[name=userid]").val(res.userid);
     
     addData = $("input[name='address_id']").val();
     //          alert(addData);
     //        $.post("{{ route('admin.orders.getCustomerAdd') }}", {addData: addData}, function (data) {
     //           alert(JSON.stringify(data)); console.log('-----------------');
     //           console.log(JSON.stringify(data));
     //            htmlAdd = "";
     //            htmlAdd += "<strong>Shipped To:</strong><br>";
     //            htmlAdd += "<p>" + addData.firstname + "</p><br/>";
     //            htmlAdd += "<p>" + addData.lastname + "</p><br/>";
     //            htmlAdd += "<p>" + addData.address1 + " " + addData.address2 + "</p><br/>";
     //            htmlAdd += "<p>" + addData.city + "</p><br/>";
     //            $(".shippedTo").append(htmlAdd);
     //        });
     $('.nav-tabs a[href="#product-details"]').tab('show');
     }
     });
     },
     errorPlacement: function (error, element) {
     $(element).after(error);
     }
     });
     */
    $(".inptAdd").on('change', function () {
        $("input[name='address_id']").val("");
    });


    $(".prodSearch").autocomplete({
        source: "{{route('admin.orders.getSearchProds')}}",
        /* source: function(req, response){
         var rows = $(".newRow").find('tr');
         var selected_prod = [];
         jQuery.each(rows, function(i, item) {
         var prod_id = $(this).find('.prodSearch').attr('data-prdid');
         var subprodid = $(this).find('.subprodid').val();
         selected_prod.push({prod_id:prod_id,subprodid:subprodid});  
         });
         console.log(selected_prod);
         $.ajax({
         type: "get",
         url:"{{route('admin.orders.getSearchProds')}}",
         data: {data:selected_prod,req:req},
         dataType:"json",
         success:response, 
         })
         }, */
        minLength: 1,
        select: function (event, ui) {
            getSubprods(ui.item.id, $(this));
            $(this).attr('data-prdid', ui.item.id);

        }
    });

    $("table").delegate(".subprodid", "change", function () {
        subprdid = $(this).val();
        subp = $(this);
        parentprodid = subp.parent().parent().find('.prodSearch').attr('data-prdid');
        removeError(subp);
        $(this).attr("name", "cartData[" + parentprodid + "][subprodid]");
        qty = subp.parent().parent().find('.qty').val();
        subp.parent().parent().find('.qty').attr('subprod-id', subprdid);
        $.post("{{route('admin.orders.getProdPrice')}}", {subprdid: subprdid, qty: qty, pprd: 0}, function (data) {
            subp.parent().parent().find('.prodPrice').text((data.price).toFixed(2));
<?php if ($feature['tax'] == 1) { ?>
                subp.parent().parent().find('.taxAmt').text((data.tax).toFixed(2));
<?php } ?>
            clearAllDiscount();
        });
    });
    $(".addCourse").on("click", function () {
        $(".product-empty").remove();
        $(".newRow").append($(".toClonetr").html());
        $(".prodSearch").autocomplete({
            source: "{{route('admin.orders.getSearchProds')}}",
            minLength: 1,
            select: function (event, ui) {
                getSubprods(ui.item.id, $(this));
                $(this).attr('data-prdid', ui.item.id);
                //$("#couponApply").click();
                // ApplyCoupon();
                //  clearAllDiscount();
            }
        });
    });

    $("table").delegate(".delRow", "click", function () {
        $(this).parent().parent().remove();
        clearAllDiscount();
    });

    $(".placeOrder").on("click", function () {
        var rowCount = $(".newRow").find('tr');
        if ($('.prodSearch').val() == '') {
            $('input[name=prod_search]').blur();
            $('input[name=prod_search]').focus();
        }
        $(".product-empty").remove();

        if (rowCount.length <= 0) {
            $(".prodTable tbody.newRow").append('<tr class="product-empty" style="color:red"><th colspan="4">Please select at least one product </th></tr>');
            return false;
        }
        $.each($(".prodTable .prodPrice"), function () {
            if ($(this).text() == 0) {
                $(this).parent().parent().addClass("trError");
                $(".finalAmt").text('0.00');
            } else {
                $(this).parent().parent().removeClass("trError");
            }
        });
        chk = 0;
        $.each($(".prodTable tr"), function () {
            if ($(this).hasClass('trError')) {
                chk = 1;
            }
        });
        var rows = $(".newRow").find('tr');
        var prod = [];
        jQuery.each(rows, function (i, item) {
            if ($(item).attr('data-ppid') != "") {
                var prod_id = $(this).find('.prodSearch').attr('data-prdid');
                var subprodid = $(this).find('.subprodid').val();
                var qty = $(this).find('.qty').val();
                var prodPrice = $(this).find('.prodPrice').text();
                var data = {prod_id: prod_id, subprodid: subprodid, qty: qty, prodPrice: prodPrice};
                prod.push(data);
            }
        });
        var address_id = $("input[name=address_id]").val();
        var user_id = $("input[name=user_id]").val();
        var payment_mode = $(".paymode").val()
        var remark = $(".remark").val();
        var post_data = {mycart: prod, payment_mode: payment_mode, remark: remark, user_id: user_id, address_id: address_id};
        if (chk == 0) {
            $(".placeorderSpinner").show();
            $.post("{{ route('admin.orders.saveCartData') }}", post_data, function (res) {
                $(".placeorderSpinner").hide();
                if (res == 1)
                    $("#invalidCoursePopUp").modal('show');
                if (res == 2)
                    $("#alreadyAdeedCoursePopUp").modal('show');
                if (res == 3) {
                    $(".orderContent").hide();
                    $(".msg").addClass("alert alert-success").text("Order Placed successfully.");
                } else if (res == 4) {
                    $(".msg").addClass("alert alert-danger").text("Error being place order. Please try again.");
                }
            });
        }
    });

    $(".addBack").on("click", function (e) {
        e.preventDefault();
        $('.nav-tabs a[href="#customer-details"]').tab('show');
        $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');
    });

    $(".placeOrderBack").on("click", function (e) {
        e.preventDefault();
        $('.nav-tabs a[href="#shipping-address"]').tab('show');
        $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');
    });

    $("table").delegate(".qty", "change", function () {
        console.log("inside qty");
        var qty = $(this).val();
        var subprdid = $(this).parents("td").prev().find(".subprodid").val();

        var parentprdid = $(this).parents("td").siblings().find(".prodSearch").attr('data-prdid');

        if (subprdid == null || subprdid == "") {
            var pprd = 1;
            var data = {qty: qty, parentprdid: parentprdid, pprd: pprd};
        } else {
            var pprd = 0;
            var data = {qty: qty, subprdid: subprdid, pprd: pprd};
        }
        var qtty = $(this)
        $.ajax({
            type: "POST",
            url: "{{ route('admin.orders.getProdPrice') }}",
            data: data,
            cache: false,
            success: function (price) {
                qtty.parents("td").next().find('.prodPrice').text((price.price).toFixed(2));
                <?php if ($feature['tax'] == 1) { ?>
                qtty.parents("td").next().next().find('.taxAmt').text((price.tax).toFixed(2));
                <?php } ?>
                // ApplyCoupon();
                clearAllDiscount();
            }

        });
    });



    $("input[name='radioEg']").change(function () {
        event.preventDefault();
        ApplyCoupon();
    });


    function ApplyCoupon() {
        $(".code-err").remove();
        var rows = $(".newRow").find('tr');
        var input_code = $("input[name='radioEg']:checked").parent();

        var couponCode = $("input[name='radioEg']:checked").val()

        var prod = [];
        jQuery.each(rows, function (i, item) {
            if ($(item).attr('data-ppid') != "") {
                var prod_id = $(this).find('.prodSearch').attr('data-prdid');
                var subprodid = $(this).find('.subprodid').val();
                var qty = $(this).find('.qty').val();
                var prodPrice = $(this).find('.prodPrice').text();
                var data = {prod_id: prod_id, subprodid: subprodid, qty: qty, prodPrice: prodPrice};
                prod.push(data);
            }
        });
        if (prod.length <= 0) {
            $(".finalAmt").text('0.00');
            getAdditionalcharge();
            return false;
        }
        $.ajax({
            type: "POST",
            url: "{{ route('admin.orders.checkOrderCoupon') }}",
            data: {mycart: prod, couponCode: couponCode},
            dataType: "json",
            cache: false,
            success: function (msg) {

                $(".cmsg").css("display", "block");

                if (msg['remove'] == 1) {
                    if (couponCode != 'none') {
                        input_code.parent().append("<p class='code-err' style='color:red'>Coupon Code Invalid OR Not applicable on current cart value.</p>");
                    }
                    priceTaxUpdate(msg['cart']);

                    $(".coupon-code").remove();
                    $(".coupon-value").remove();

                    $(".subtotal").text(msg['subtotal'].toFixed(2));
                    $(".finalAmt").text(msg['orderAmount'].toFixed(2));
                    $(".disc_indv").text("0.00");
                    $("#amountallSubtotal").text(msg[4]);

                } else {
                    $(".coupon-code").remove();
                    $(".coupon-value").remove();

                    var usedCouponAmount = (msg['disc']);

                    $.each(msg['individual_disc_amt'], function (key, value) {
                        $(".disc_indv" + key).text(value);
                    });
                    priceTaxUpdate(msg['cart']);

                    var coupon_td = '<tr class="coupon-code"><th>Coupon Applied</th><td><span class="couponUsedAmount" id="couponUsedcode">' + couponCode + '</span></td></tr><tr class="coupon-value"><th>Coupon Value</th><td><span class="couponUsedAmount" id="couponUsedAmount">' + usedCouponAmount.toFixed(2) + ' </span></td></tr>';

                    $(".priceTable tbody").prepend(coupon_td);

                    $(".subtotal").text(msg['subtotal'].toFixed(2));
                    $(".finalAmt").text(msg['orderAmount'].toFixed(2));

                    $("#amountallSubtotal").text(msg[4]);

                }
                getAdditionalcharge();
            }

        });
    }

    function getAdditionalcharge() {
        var price = parseFloat($(".finalAmt").text());
        var total_amt = 0;
        $.ajax({
            url: "{{ route('admin.additional-charges.getAditionalCharge') }}",
            type: 'POST',
            // data: {price : price},
            cache: false,
            success: function (msg) {
                $(".order-total").nextAll().remove();
                var data = JSON.parse(msg);
                if (!isEmpty(data)) {
                    $.each(JSON.parse(msg), function (i, v) {
                        if (i == 'list') {
                            $.each(v, function (j, w) {
                                $(".order-total").after('<tr><th>' + j + '</th><td>' + (w * <?php echo Session::get("currency_val") ?>) + '</td>');
                            })
                        }

                        total_amt = price + (v * <?php echo Session::get("currency_val") ?>);
                    });
                } else {
                    total_amt = price;
                }
                $(".order-total").parent().append('<tr><th>Total (Rs.)</th><td>' + total_amt.toFixed(2) + '</td>');
            }
        });

    }

    $(".requireCashback").click(function () {
        var user_id = $("input[name='user_id']").val();
        console.log(user_id);
        var checkbox = $("#checkbox1");
        var isChecked = checkbox.is(':checked');
        if (isChecked) {
            $.ajax({
                url: "{{ route('admin.orders.applyCashback') }}",
                type: 'POST',
                data: {userId: user_id},
                cache: false,
                success: function (data) {
                    $(".subtotal").text(data['subtotal'].toFixed(2));
                    $(".finalAmt").text(data['orderAmount'].toFixed(2));
                    $(".curRewPointsOld").text(data.cashbackRemain);
                    var cashback_td = '<tr class="cashback-code"><th>Cashback Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + (data.cashbackUsedAmt).toFixed(2) + '</span></td></tr>';
                    $(".priceTable tbody").prepend(cashback_td);
                    priceTaxUpdate(data.cart);
                    getAdditionalcharge();
                }
            });
        } else {
            $.ajax({
                url: "{{ route('admin.orders.applyCashback') }}",
                type: 'POST',
                data: '',
                cache: false,
                success: function (data) {
                    $(".subtotal").text(data['subtotal'].toFixed(2));
                    $(".finalAmt").text(data['orderAmount'].toFixed(2));
                    $(".cashback-code").remove();
                    $(".curRewPointsOld").text(data.cashbackRemain);
                    priceTaxUpdate(data.cart);
                    getAdditionalcharge();
                }
            });
        }
    });

    function applyVoucher(voucherCode) {

        $.ajax({
            url: "{{ route('admin.orders.applyVoucher') }}",
            type: 'POST',
            data: {voucherCode: voucherCode},
            cache: false,
            success: function (data) {
                if (data != "invalid data") {
                    var VoucherVal = data.voucherAmount;
                    priceTaxUpdate(data.cart);

                    if (data.voucherAmount != null) {
                        $(".vMsg").css("display", "block");
                        $("#voucherApply").attr("disabled", "disabled");
                        $(".userVoucherCode").attr("disabled", "disabled");
                        var Cmsg = "<span style='color:green;'>Voucher Code Applied!</span> <a href='#' style='border-bottom: 1px dashed;' onclick='clearVouch()'>Remove!</a>";
                        $(".vMsg").html(Cmsg);
                        $(".subtotal").text(data['subtotal'].toFixed(2));
                        $(".finalAmt").text(data['orderAmount'].toFixed(2));
                        $(".curRewPointsOld").text(data.cashbackRemain);
                        var voucher_td = '<tr class="voucher-code"><th>Voucher Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + (data.voucherAmount).toFixed(2) + '</span></td></tr>';
                        $(".priceTable tbody").prepend(voucher_td);

                    } else {
                        $("#voucherApply").removeAttr("disabled");
                        $(".userVoucherCode").removeAttr("disabled");
                        $(".subtotal").text(data['subtotal'].toFixed(2));
                        $(".finalAmt").text(data['orderAmount'].toFixed(2));
                        $(".voucher-code").remove();
                        if (data.clearCoupon) {
                            $(".vMsg").css("display", "none");
                        } else {
                            $(".vMsg").css("display", "block");
                            $(".vMsg").html("Invalid Voucher!");
                        }

                    }
                    getAdditionalcharge();
                }
            }
        });
    }
    $("#voucherApply").click(function () {
        var voucherCode = $(".userVoucherCode").val();
        applyVoucher(voucherCode);
    });

    function clearVouch() {
        var voucherCode = '';
        applyVoucher(voucherCode);
    }

    function priceTaxUpdate(cart) {
        $.each(cart, function (key, value) {
            var id = value.id;

            var price = value.subtotal;
            if (value.options.tax_type == 2) {
                price = price + value.options.tax_amt;
            }

            var is_subprod = $("[subprod-id=" + value.options.sub_prod + "]").get();
            if (is_subprod != null && is_subprod != "") {
                var prod = $("[subprod-id=" + value.options.sub_prod + "]");
            } else {
                var prod = $("[data-prdid=" + id + "]");
            }

            prod.parent().parent().find('.prodPrice').text((price * <?php echo Session::get('currency_val'); ?>).toFixed(2));
            prod.parent().parent().find('.taxAmt').text((value.options.tax_amt * <?php echo Session::get('currency_val'); ?>).toFixed(2));
        });
    }

    function applyUserLevelDisc(discVal) {
        var discType = $('#user-level-disc').val();
        $("#userlevelDiscApply").attr('disabled', true);
        $.ajax({
            url: "{{ route('admin.orders.applyUserLevelDisc') }}",
            type: 'POST',
            data: {discType: discType, discVal: discVal},
            cache: false,
            success: function (data) {
                priceTaxUpdate(data.cart);
                $(".subtotal").text(data['subtotal'].toFixed(2));
                $(".finalAmt").text(data['orderAmount'].toFixed(2));
                if (data['discAmt'] != null && data['discAmt'] != 0) {
                    var msg = "<span style='color:green;'>Discount Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' onclick='clearDisc()' class='clearDiscount' id='discAmt'>Remove!</a>"

                    $(".dMsg").css("display", "block");
                    $(".dMsg").html(msg);
                    var userdisc_td = '<tr class="discount-code"><th>Discount Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + (data.discAmt).toFixed(2) + '</span></td></tr>';
                    $(".priceTable tbody").prepend(userdisc_td);
                } else {
                    $("#userlevelDiscApply").attr('disabled', false);
                    var err = "<span style='color:red;'>Invalid Code</span>"
                    $(".discount-code").remove();
                    if (data.clearDisc) {
                        $(".vMsg").css("display", "none");
                    } else {
                        $(".vMsg").css("display", "block");
                        $(".vMsg").html(err);
                    }
                }
                getAdditionalcharge();
            }
        });
    }
    $("#userlevelDiscApply").click(function () {
        var discVal = $('input[name="user_level_discount"]').val();
        applyUserLevelDisc(discVal);
    });

    function clearDisc() {
        var discVal = 0;
        applyUserLevelDisc(discVal);
    }

    function applyReferal(RefCode) {
        // var RefCode = $(".requireReferal").val();
        $.ajax({
            url: "{{ route('admin.orders.applyReferel')}}",
            type: 'POST',
            data: {RefCode: RefCode},
            cache: false,
            success: function (data) {
                $(".referalMsg").show();
                priceTaxUpdate(data.cart);
                getAdditionalcharge();
                $(".subtotal").text(data['subtotal'].toFixed(2));
                $(".finalAmt").text(data['orderAmount'].toFixed(2));

                if (data['referalCodeAmt'] != null && data['referalCodeAmt'] != 0) {
                    $(".referalCodeClass").attr("disabled", "disabled");
                    $(".requireReferal").attr("disabled", "disabled");
                    var Cmsg = "<span style='color:green;'>Referral Code Applied!</span> <a href='javascript:void(0);' class='clearRef' onclick='clearRef()' style='border-bottom: 1px dashed;'>Remove!</a>";
                    $(".referalMsg").html(Cmsg);
                    var userdisc_td = '<tr class="referal-code"><th>Referral Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + (data.referalCodeAmt).toFixed(2) + '</span></td></tr>';
                    $(".priceTable tbody").prepend(userdisc_td);
                    // if ($(".referalCodeText").text() == 0) {
                    //     var newCartAmt = msg.split(":-")[2];
                    //     $(".referalCodeText").text(msg.split(":-")[1]);
                    //     $(".refDisc").val(msg.split(":-")[1]);
                    //     $(".referalDiscount").text(msg.split(":-")[1]);
                    //     $(".TotalCartAmt").text(newCartAmt);
                    // }
                } else {
                    $(".referalCodeClass").removeAttr("disabled");
                    $(".requireReferal").removeAttr("disabled");

                    $(".referal-code").remove();
                    if (data.clearReferrel) {
                        $(".referalMsg").css("display", "none");
                    } else {
                        $(".vMsg").css("display", "block");
                        $(".referalMsg").text("Invalid Referral Code!");
                    }
                    // if ($(".referalCodeText").text() != 0) {
                    //     var newCartAmt = msg.split(":-")[2];
                    //     $(".referalCodeText").text(0);
                    //     $(".refDisc").val(0);
                    //     $(".referalDiscount").text(0);
                    //     $(".TotalCartAmt").text(newCartAmt);
                    // }
                }
            }
        });
    }
    ;

    $("#requireReferalApply").click(function () {
        var RefCode = $(".requireReferal").val();
        applyReferal(RefCode);
    });

    function clearRef() {
        var RefCode = '';
        applyReferal(RefCode);
    }

    function clearAllDiscount() {

        //cashback remove
        $('#checkbox1').attr('checked', false);
        $("input[name='cashback_used']").val(0);
        $(".cashback-code").remove();
        var cashback = $("input[name='cashback_hidden']").val()
        $(".curRewPointsOld").text(cashback);

        // remove refereal code
        $(".referalCodeClass").removeAttr("disabled");
        $(".requireReferal").removeAttr("disabled");
        $(".referal-code").remove();
        $(".referalMsg").css("display", "none");
        $("input[name='referal_code_amt']").val(0);

        //remove User Level Discount
        $("#userlevelDiscApply").attr('disabled', false);
        $(".discount-code").remove();
        $(".dMsg").css("display", "none");

        //Remove Voucher Discount
        $("#voucherApply").removeAttr("disabled");
        $(".userVoucherCode").removeAttr("disabled");
        $("input[name='voucher_amt_used']").val(0);
        $(".voucher-code").remove();
        $(".vMsg").css("display", "none");

        ApplyCoupon();

    }

    // to check is object empty
    function isEmpty(obj) {
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop))
                return false;
        }

        return true;
    }
</script>
@stop