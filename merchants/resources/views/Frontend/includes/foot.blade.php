
<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- External JavaScripts
============================================= -->
<script type="text/javascript" src="{{ Config('constants.frontendPublicJsPath').'/jquery.js' }}"></script>
<script src="{{ Config('constants.frontendPublicJsPath').'/jquery.validate.min.js' }}"></script>
<script type="text/javascript" src="{{ Config('constants.frontendPublicJsPath').'/plugins.js' }}"></script>	

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="{{ Config('constants.frontendPublicJsPath').'/functions.js' }}"></script>
<script type="text/javascript" src="{{ Config('constants.frontendPublicJsPath').'/custom.js' }}"></script>
<script type="text/javascript" src="{{ Config('constants.frontendPublicJsPath').'/jquery.elevatezoom.js' }}"></script>
<script src="//connect.facebook.net/en_US/all.js"></script>
<script async src="https://static.addtoany.com/menu/page.js"></script>

<script src="{{Config('constants.adminDistJsPath').'/bootstrap-select.js' }}"></script>


<div class="modal fade" id="manageSlider" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add or Update Slider Images</h4>
            </div>
            <form role="form" id="frmUpdateBanner" class="nobottommargin" >
                <div class="modal-body">
                    @foreach($layoutPage as $page)                    
                    <div class="row mb-20">
                        <div class="col-md-4 col-sm-6 col-xs-6"><div class="slider-thumb-box"><img src="{{asset(Config('constants.layoutUploadPath')).'/'.$page->image}}" height="50px" width="70px"></div></div>
                        <div class="col-md-4 col-sm-6 col-xs-6">
                            <div class="vert-middle">
                                <label class="switch text-center">
                                    <input class="switch-input"  name="slider[{{ $page->id }}][status]" id="prodStatus" value="1" type="checkbox"  {{ ($page->is_active == 1) ? 'checked="checked"' : ''  }}  />
                                    <span class="switch-label"  data-on="Enabled" data-off="Disabled"></span> 
                                    <span class="switch-handle"></span> 
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 mobiletopmargin15"><input type="number" name="slider[{{$page->id}}][sort_order]" class="sm-form-control" placeholder="Sort Order" value="{{ $page->sort_order }}" required></div>
                    </div>
                    @endforeach
                    <div class="row addnew-row text-center spacingsliderbtn">
                        <a class="btn btn-primary addButton"  data-toggle="modal" data-target="#addNewSliderImage">Add New Slider</a>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" id="updateSlider" class="btn btn-default">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="addNewSliderImage" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Slider Image</h4>
            </div>
            <form role="form" id="addSlider" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <div class="col-md-6 col-sm-12 col-xs-12"><div class="form-group">
                            <div class="choosebtnbox text-center">
                                <input type="file" class="custom-file-input chooselogottext" name="sliderImg" id="sliderImg"  >
                            </div>

                            <span id="error-banner" class="text-danger"></span>
                        </div></div>      
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box-2 padd-0">
                            <div class="result-slider padd-0" style="width: 300px; min-height:10px; max-height: 180px;"></div>
                        </div>
                        <div class="options-slider hide" >                      
                        </div>
                    </div> 
                </div>  

                <div class="clearfix"></div>

                <div class="modal-footer text-center topmargin-sm">
                    <button type="submit" class="btn btn-default" id="saveSlider">Add</button>
                </div>
            </form>

        </div>        
    </div>
</div>

<script>
//Banner Cropping script
var resultSlider = document.querySelector('.result-slider'),
        options = document.querySelector('.options-slider'),
        save = document.querySelector('#saveSlider'),
        upload = document.querySelector('#sliderImg'),
        cropper = '';
// on change show image with crop options
upload.addEventListener('change', function (e) {
    if (e.target.files.length) {
        // start file reader
        var reader = new FileReader();
        reader.onload = function (e) {
            if (e.target.result) {
                // create new image
                var img = document.createElement('img');
                img.id = 'image';
                img.src = e.target.result;
                // clean result before
                resultSlider.innerHTML = '';
                resultSlider.appendChild(img);
                //console.log(resultSlider);
                // init cropper
                save.classList.remove('hide');
                options.classList.remove('hide');

                cropper = new Cropper(img, {
                    aspectRatio: 1.77,
                    dragMode: 'move',
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    zoom: -0.1,
                    built: function () {
                        $toCrop.cropper("setCropBoxData", {width: "1920", height: "1080"});
                    }
                });
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
// save on click
save.addEventListener('click', function (e) {
    e.preventDefault();

    if ($("#sliderImg").val() == "")
    {
        $("#error-banner").html("Please select Slider.");
        return false;
    } else
    {
        var fileUpload = $("#sliderImg")[0];
        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
                var form = $('#addSlider');
                var formdata = false;
                if (window.FormData) {
                    formdata = new FormData(form[0]);
                }
                var ImageURL = cropper.getCroppedCanvas({
                    width: 1980 // input value
                }).toDataURL();
                formdata.append("slider_img_url", ImageURL);
                $.ajax({
                    url: "{{route('addHomeBanner')}}",
                    type: 'post',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        $("#addNewSliderImage").modal('hide');
                        $("#manageSlider").load(location.href + " #manageSlider>", "");
                    }
                });
            } else
            {
                $("#error-banner").html("This browser does not support HTML5.");
                return false;
            }
        } else
        {
            $("#error-banner").html("Please select a valid Image file.");
            return false;
        }
    }

});</script>

<script type="text/javascript">

    $('.prod_type').change(function () {
        var prod_type = $('.prod_type').val();
        if (prod_type == 3) {
            $('#attribute').removeClass("hide");
        } else if (prod_type == 1 || prod_type == 2 || prod_type == 5) {
            $('#attribute').addClass("hide");
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#SelecedImg').removeClass("hide");
                $('#SelecedImg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".prodImage").change(function () {
        readURL(this);
    });

    $(document).ready(function () {
        $("#productAddPopUp").validate({
            // Specify the validation rules
            rules: {
                prod_type: "required",
                product: {
                    required: true
                },
                attr_set: {
                    required: true
                },
                price: {
                    required: true
                },
              
                'category[]': {
                    required: true
                }
            },
            // Specify the validation error messages
            messages: {
                prod_type: "Product Type is required.",
                product: "Product is required.",
                attr_set: "Attribute Set is required.",
                price: {
                    required: "Price is required."
                },
               
                'category[]': {
                    required: "Category is required."
                }
            },
            errorPlacement: function (error, element) {
                $(element).after(error);

            }
        });

        $(".manageCate").on("click", function () {
            $("#manageCateModal").modal('show');
        });

        $(".homePage3Boxes").on("click", function () {
            info = jQuery.parseJSON($(this).attr('data-info'));
            console.log(info);
            imgsrc = $(this).attr('data-imgSrc');
            $(".homePageStatus").val(info.is_active);
            $(".homePageLink").val(info.link);
            $(".existingImg3Box").attr("src", imgsrc);
            $(".homePageId").val(info.id);
            $(".homePageSortOrder").val(info.sort_order);
            $("#homepage3Boxespopup").modal("show");
        });

        $(".homePageStatus").on("change", function () {
            if ($(this).is(":checked")) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });
        $(".3BoxStatus").on("change", function () {
            if ($(this).is(":checked")) {
                isActive = 1;
            } else {
                isActive = 0;
            }
            id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: "{{ route('changeStatusHomePage3Boxes') }}",
                data: {isActive: isActive, id: id},
                cache: false,
                success: function (data) {
                    if (data == 1) {
                        if (isActive == 1) {
                            $(".overL_" + id).removeClass("overlayFBox");
                        } else {
                            $(".overL_" + id).addClass("overlayFBox");
                        }
                    }
                }
            });
        });
        $(".catCheck").on("change", function () {
            if ($(this).is(":checked")) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });

        $(".closeTheme").click(function () {
            $('.applyTheme-stickyHeader').hide();
            $('#header.transparent-header.full-header #header-wrap').css('top', '0');
        });
    });
</script>
<script>

    $(document).ready(function () {
        console.log("ready!");
        if ($(window).width() < 768) {
            // setTimeout(function () {
            //     $('.zoom-me').elevateZoom({
            //         zoomType: "inner",
            //         cursor: "crosshair",
            //         zoomWindowFadeIn: 500,
            //         zoomWindowFadeOut: 750
            //     });
            // }, 1000)
            $('.zoomContainer').remove();
        } else {
            $('.zoom-me').elevateZoom();
            
        }
        

        $('html body').on('submit', '#frmUpdateBanner', function () {
            var form = $('#frmUpdateBanner');
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                url: "{{route('updateHomeBanner')}}",
                type: 'post',
                data: formdata,
                processData: false,
                contentType: false,
                //   dataType: 'json',
                beforeSend: function () {
                    // $("#barerr" + id).text('Please wait');
                },
                success: function (res) {
                    window.location.reload();
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $("#btn-subscribe").click(function () {
        $('#subscribe').validate();
        if (!$('#subscribe').valid()) {
            return false;
        }
        var email = $('.newsletter-email').val();
        console.log("email value " + email);
        var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        $('#subscription-success').empty();
        if (!pattern.test(email))
        {
            $('#subscription-success').append("Please enter valid email.");
        } else {
            $.ajax({
                type: "POST",
                url: "{{route('subscriptionMail')}}",
                data: {email: email},
                cache: false,
                success: function (data) {
                    console.log("data: " + data);
                    $('#subscription-success').append(data);
                    $('#EmailIcon').find('i').removeClass('icon-line-loader icon-spin').addClass('icon-email2')
                    //  $(form).find('.input-group-addon')
                }
            });
        }

    });
</script>
<script>
    $(document).ready(function () {
        /* JQUERY FORM VALIDATION */
        jQuery.validator.addMethod("phonevalidate", function (telephone, element) {
            telephone = telephone.replace(/\s+/g, "");
            return this.optional(element) || telephone.length > 9 &&
                    telephone.match(/^[\d\-\+\s/\,]+$/);
        }, "Please specify a valid phone number");
        jQuery.validator.addMethod("emailvalidate", function (email, element) {
            // email = email.replace(/\s+/g, "");
            return this.optional(element) || email.length > 12 &&
                    email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/);
        }, "Please specify a valid Email Id");
        jQuery.validator.addMethod("emailPhonevalidate", function (telephone, element) {
            telephone = telephone.replace(/\s+/g, "");
            // var telephone1=this.optional(element) || telephone.length > 9 &&  telephone.match(/^[\d\-\+\s/\,]+$/);
            if (this.optional(element) || telephone.length > 9 && telephone.match(/^[\d\-\+\s/\,]+$/)) {
                return this.optional(element) || telephone.length > 9 && telephone.match(/^[\d\-\+\s/\,]+$/);
            } else {
                return this.optional(element) || telephone.length > 9 &&
                        telephone.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/);
            }
        }, "Please specify a valid Email/Mobile");
        /* END JQUERY FORM VALIDATION */
        if (get('lasturl')) {
            var url = get('lasturl');
            var urlParts = url.split('/');
            console.log("Is proListing " + jQuery.inArray('explore', urlParts) > -1);
            if (jQuery.inArray('explore', urlParts) > -1) {
                console.log('Destroy filters');
                unset(['filtered', 'filters', 'maxp', 'minp', 'sort']);
            } else {
                console.log('Apply filters');
            }
            store({'lasturl': document.referrer});
        } else {
            store({'lasturl': document.referrer});
        }

        $("body").delegate('.addToCart', 'click', function (e) {
            console.log('addtocart');
            e.preventDefault();
            var getThis = $(this);
            var formId = $(this).attr("form-id");
            var qty = $("#form" + formId + ' input[name="quantity"]').val();
            var attrSel = true;
            var prod_type = $("#form" + formId + ' input[name="prod_type"]').val();
            //console.log("product type" +prod_type);
            if (prod_type != 1) {
                var sub_prod = $("#form" + formId + ' input[name="sub_prod"]').val();
                //alert("sub product" +sub_prod);
            }
            if (qty == 0 || !qty) {
                // $('.quantity').addClass('error');
                $("#form" + formId + ' input[name="quantity"]').val('1');
                $('.quantity').css({"border-color": "#FF0000", "border-weight": "1px", "border-style": "solid"});
                return false
            }
            $('.quantity').css({"border-color": "", "border-weight": "", "border-style": ""});
            $("#form" + formId).find(".attrSel").each(function () {
                $(this).parent().find(".optError").remove();
//            if ($(this).val() == "") {
//                $(this).addClass("addCartError");
//                $(this).parent().append("<p style='color:red' class='optError'>Please select " + $(this).attr('name') + "!</p>");
//
//            }
                if ($(this).is("select")) {
                    if ($(this).val() == "") {
                        console.log("lee " + $(this).attr('name') + " ====" + $(this).hasClass("error") + "==");
                        if ($(this).hasClass("error")) {
                            $(this).removeClass("error");
                            $(this).parent().find(".optError").remove();
                        }
                        attrSel = false;
                        //alert('Please select product variant');
                        $(this).addClass("error");
                        $(this).parent().append("<p style='color:red' class='optError'>Please select " + $(this).attr('name') + "!</p>");
                    } else {
                        attrSel = true;
                        $(this).removeClass("error");
                        $(this).parent().find(".optError").remove();
                    }
                } else { //if ($(this).is("input:radio")) {
                    //alert($(this).attr('data-name'));
                    if ($(this).hasClass("error")) {
                        $(this).removeClass("error");
                        $(this).parent().find(".optError").remove();
                    }

                    $('input.radioAttrs').each(function () {
                        if ($(this).is(':checked')) {
                            console.log("Chekced radio");
                            atLeastOneIsChecked = true;
                            // Stop .each from processing any more items
                            return false;
                        }
                    });
                    console.log(atLeastOneIsChecked + " radio cheched");
                    if (!atLeastOneIsChecked) {
                        attrSel = false;
                        //alert('Please select product variant');
                        $(this).addClass("error");
                        $(this).append("<p style='color:red' class='optError'>Please select " + $(this).attr('data-name') + "!</p>");
                    } else {
                        attrSel = true;
                        $(this).removeClass("error");
                        $(this).parent().find(".optError").remove();
                    }
                }

            });
            //var attr1=$("#form" + formId).attr('action');
            //alert("action "+$("#form" + formId).serialize());
            $("#form" + formId).find(".attrSel").each(function () {
                if ($(this).hasClass("addCartError")) {
                    $(this).removeClass("error");
                    $(this).parent().find(".optError").remove();
                }
            });

            if(!attrSel)
                return false;

            //console.log(attrSel);
            $.post($("#form" + formId).attr('action'), $("#form" + formId).serialize(), function (result) {

                if (result == 1) {
                    //  alert(result);
                    alert('Specified quantity is not available');
                } else {
//                var cart_cont = result.split("||||||");
//                $(".cartDiv").replaceWith(cart_cont[0]);
                    var newCart = result.split("||||||");
                    var cart = $('.shop-cart');
                    //alert(html());
                    // var imgtodrag = $("#form" + formId).find(".fimg").eq(0);
                    var imgtodrag = $("#form" + formId + " img").eq(0);
                    console.log(imgtodrag);
                    if (imgtodrag) {
                        var imgclone = imgtodrag.clone()
                                .offset({
                                    top: imgtodrag.offset().top,
                                    left: imgtodrag.offset().left
                                })
                                .css({
                                    'opacity': '0.5',
                                    'position': 'absolute',
                                    'height': '150px',
                                    'width': '150px',
                                    'z-index': '99999999'
                                })
                                .appendTo($('body'))
                                .animate({
                                    'top': cart.offset().top + 10,
                                    'left': cart.offset().left + 10,
                                    'width': 75,
                                    'height': 75
                                }, 800, 'easeInOutExpo');
                        setTimeout(function () {
                            cart.effect("shake", {
                                times: 2
                            }, 200);
                        }, 1500);
                        imgclone.animate({
                            'width': 0,
                            'height': 0
                        }, function () {
                            $(this).detach();
                        });
                    }
                    //  alert(newCart[1]);
                    $('.shop-cart').text(newCart[1]);
                    $("#product_viewtest").modal('hide');
                }
            });
        });
        $("#myCart").delegate(".removeShoppingCartProd", "click", function () {
            var rowid = $(this).attr('data-rowid');
            var thisEle = $(this);
            $.ajax({
                type: "POST",
                url: "{{route('deleteCart')}}",
                data: {rowid: rowid},
                cache: false,
                success: function (data) {

                    data = data.split("||||||||||");
                    $('.shop-cart').replaceWith(data[2]);
                    thisEle.parent().parent().remove();
                }
            });
        });
        $("#currencycheck").change(function () {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{route('changeCountry')}}",
                data: {id: id},
                cache: false,
                success: function (data) {
                    localStorage.setItem('currency_id', '<?php echo Session::get('currency_val'); ?>');
                    localStorage.setItem('currency_val', '<?php echo Session::get('currency_val'); ?>');
                    window.location.reload(true);
                }
            });
        });
        $("body").delegate('.add-to-wishlist', 'click', function (e) {
            var ele = $(this);
            var prodid = ele.attr("data-prodid");
            console.log('ele ' + ele);
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{route('addToWishlist')}}",
                data: {prodid: ele.attr("data-prodid")},
                cache: false,
                success: function (data) {
                    console.log("data: " + data);
                    console.log(ele.attr("data-prodid"));
                    if (data == 'login')
                        location.href = "{{route('loginUser')}}";
                    // alert(ele.children());
                    if (data == 1) {
                        $('#wish' + prodid).addClass("red-heart");
                        $('#wish' + prodid).addClass("icon-heart3");
                        $('#wish' + prodid).removeClass("icon-heart");
                    } else {
                        $('#wish' + prodid).removeClass("red-heart");
                        $('#wish' + prodid).removeClass("icon-heart3");
                        $('#wish' + prodid).addClass("icon-heart");
                    }

                }
            });
        });
        $("body").delegate('.add-to-wishlist-page', 'click', function (e) {
            var ele = $(this);
            $.ajax({
                type: "POST",
                url: "{{route('addToWishlist')}}",
                data: {prodid: ele.attr("data-prodid")},
                cache: false,
                success: function (data) {
                    console.log("data: " + data);
                    console.log(ele.attr("data-prodid"));
                    if (data == 'login')
                        location.href = "{{route('loginUser')}}"
                    if (data == 1)
                        ele.addClass("red-heart");
                    else
                        ele.removeClass("red-heart");
                    location.href = window.location.href;
                }
            });
        });
//        var cur = '<?php echo Session::get('currency'); ?>';
//        console.log('Currency <?php echo Session::get('currency'); ?>');
        getCur();
    });
    function store(data) {
        jQuery.each(data, function (k, v) {
            window.localStorage.setItem(k, v);
        });
    }

    function get(data) {
        return window.localStorage.getItem(data);
    }

    function unset(data) {
        jQuery.each(data, function (k, v) {
            window.localStorage.removeItem(v);
        });
    }
    function getCur() {
        console.log("get currency");
        $.post("{{route('setCurrency')}}", {}, function (response) {
            console.log("Success Response");
            console.log(response);
            $('.currency-sym').html('').html(response.sym);
            $('.currency-sym-in-braces').html('').html("(" + response.sym + ")");
            $('.currency-sym').html('').html(response.sym);
            var currentCurrency = parseFloat(response.curval);
            console.log(currentCurrency);
<?php if (empty(Session::get('currency_val'))) { ?>
                console.log("In IF");
                $(".priceConvert").each(function (k, v) {
                    var filterNumber = $(this).text().trim();
                    filterNumber = filterNumber.replace(",", "");
                    var getPrice = parseFloat(filterNumber);
                    var calCulate = (getPrice * currentCurrency).toFixed(2)
                    $(this).text(calCulate);
                })

                $(".priceConvertTextBox").each(function (k, v) {
                    var getPrice = $(this).val();
                    getPrice = getPrice.replace(",", "");
                    getPrice = parseFloat($(this).val());
                    if (isNaN(getPrice)) {
                        var getPrice = " ";
                    } else {
                        var calCulate = (getPrice * currentCurrency).toFixed(2);
                        $(this).attr("value", calCulate);
                    }
                    var getName = $(this).attr("name");
                    $(this).parent().append("<input type='hidden' name='" + getName + "' class='priceConvertTextBoxMain' value='" + getPrice + "' > ");
                    $(this).attr("name", "not_in_use");
                });
<?php } else { ?>
                console.log("Else If");
<?php } ?>
        });
    }
    //ar maxP =
    //var minP = 0;
    //var minp = (get('minp')) ? get('minp') : 0;
    //var maxp = (get('maxp')) ? get('maxp') : maxP;
</script>
<script>
    $(document).on("click", '.socialShareFb', function () {
        var url = $(".fbShareUrl").val();
        var img = $(".fbShareImg").val();
        var desc = $(".fbShareDesc").html();
        var title = $(".fbShareTitle").val();
        FB.init({appId: '644176742612237', status: true, cookie: true});
        FB.ui({
            method: 'share_open_graph',
            action_type: 'og.shares',
            action_properties: JSON.stringify({
                object: {
                    'og:url': url,
                    'og:title': title,
                    'og:description': desc,
                    'og:og:image:width': '2560',
                    'og:image:height': '960',
                    'og:image': img,
                }
            })
        });
    });
    $(function () {
        changeLagauge();
    });
    function changeLagauge() {
        var lang = <?= $langs ?>;
        var userLang = 'english';
        // var userLang = localStorage.getItem('language');
        // if(userLang== null){
        //     userLang = 'english';
        // }

        $.each(lang, function (key, val) {
            $('body :not(script)').contents().filter(function () {
                return this.nodeType === 3;
            }).replaceWith(function () {
                return this.nodeValue.replace(val.english, val[userLang]);
            });
        });
    }

</script>
<script>
    //Logo Cropping script
    var result = document.querySelector('.resultLogo'),
            options = document.querySelector('.options'),
            save = document.querySelector('#saveLogo'),
            upload = document.querySelector('#logoF'),
            img_result = document.querySelector('.img-result'),
            img_w = document.querySelector('.img-w'),
            img_h = document.querySelector('.img-h'),
            cropper = '';
// on change show image with crop options
    upload.addEventListener('change', function (e) {
        if (e.target.files.length) {
            // start file reader
            var reader = new FileReader();
            reader.onload = function (e) {
                if (e.target.result) {
                    // create new image
                    var img = document.createElement('img');
                    img.id = 'image';
                    img.src = e.target.result;
                    // clean result before
                    result.innerHTML = '';
                    result.appendChild(img);
                    // init cropper
                    save.classList.remove('hide');
                    options.classList.remove('hide');

                    cropper = new Cropper(img, {
                        aspectRatio: 1.71,
                        dragMode: 'move',
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        zoom: -0.1,
                        built: function () {
                            $toCrop.cropper("setCropBoxData", {width: "171", height: "100"});
                        }
                    });
                }
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
// save on click
    save.addEventListener('click', function (e) {
        e.preventDefault();

        if ($("#logoF").val() == "")
        {
            $("#error-logo").html("Please select Logo.");
            return false;
        } else
        {
            var fileUpload = $("#logoF")[0];
            //Check whether the file is valid Image.
            var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
            if (regex.test(fileUpload.value.toLowerCase())) {
                //Check whether HTML5 is supported.
                if (typeof (fileUpload.files) != "undefined") {
                    var form = $('#store_save');
                    var formdata = false;
                    if (window.FormData) {
                        formdata = new FormData(form[0]);
                    }
                    var ImageURL = cropper.getCroppedCanvas({
                        width: 171 // input value
                    }).toDataURL();
                    formdata.append("logo_img_url", ImageURL);
                    $.ajax({
                        url: "{{route('updateHomeSettings')}}",
                        type: 'post',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        //   dataType: 'json',
                        beforeSend: function () {
                            // $("#barerr" + id).text('Please wait');
                        },
                        success: function (res) {
                            window.location.href = "";
                        }
                    });
                } else
                {
                    $("#error-logo").html("This browser does not support HTML5.");
                    return false;
                }
            } else
            {
                $("#error-logo").html("Please select a valid Image file.");
                return false;
            }
        }

    });</script>
<script>
//Banner Cropping script
var result3Boxes = document.querySelector('.result3Boxes'),
        save = document.querySelector('#save3Boxes'),
        upload = document.querySelector('#chooseImg'),
        cropper = '';
// on change show image with crop options
upload.addEventListener('change', function (e) {
    if (e.target.files.length) {
        // start file reader
        var reader = new FileReader();
        reader.onload = function (e) {
            if (e.target.result) {
                // create new image
                var img = document.createElement('img');
                img.id = 'image';
                img.src = e.target.result;
                // clean result before
                result3Boxes.innerHTML = '';
                result3Boxes.appendChild(img);
                //console.log(resultSlider);
                // init cropper
                save.classList.remove('hide');
                options.classList.remove('hide');

                cropper = new Cropper(img, {
                    aspectRatio: 1.77,
                    dragMode: 'move',
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    zoom: -0.1,
                    built: function () {
                        $toCrop.cropper("setCropBoxData", {width: "548", height: "308"});
                    }
                });
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
// save on click
save.addEventListener('click', function (e) {
    e.preventDefault();

    if ($("#chooseImg").val() == "")
    {
        $("#error3boxes").html("Please select Image.");
    } else
    {
        var fileUpload = $("#chooseImg")[0];
        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
                var form = $('#frm3boxes');
                var formdata = false;
                if (window.FormData) {
                    formdata = new FormData(form[0]);
                }
                var ImageURL = cropper.getCroppedCanvas({
                    width: 548 // input value
                }).toDataURL();
                $('#box3_image').val(ImageURL);
                $('#frm3boxes').submit();
                //formdata.append("box3_image", ImageURL);
                // $.ajax({
                //     url: "{{ route('updateHomePage3Boxes') }}",
                //     type: 'post',
                //     data: formdata,
                //     processData: false,
                //     contentType: false,
                //     success: function (res) {
                //         window.location.reload();
                //         // $("#addNewSliderImage").modal('hide');
                //         // $("#manageSlider").load(location.href + " #manageSlider>", "");
                //     }
                // });
            } else
            {
                $("#error3boxes").html("This browser does not support HTML5.");
                return false;
            }
        } else
        {
            $("#error3boxes").html("Please select a valid Image file.");
            return false;
        }
    }

});</script>
<script>

    $(".prodPopCheck").on('change', function () {
        $(this).val(this.checked ? "1" : "0");
    })
    $(document).ready(function () {
        $(".updateLogo").click(function () {
            $("#logoModal").modal('show');
        });
        $(".banner-btn").click(function () {
            $("#error-banner").html("");
            if ($(this).attr('id') == 'add')
            {
                $("#save_banner").hide();
                $("#add_banner").show();
                $(".lbl-banner").html("Add Banner Image");
                $("#banner_id").val('');
            } else
            {
                $("#save_banner").show();
                $("#add_banner").hide();
                $(".lbl-banner").html("Update Banner Image");
            }
            $(".btns").hide();
        });

//        $('html body').on('submit', '#addSlider', function () {
//            if ($("#sliderImg").val() == "")
//            {
//                $("#error-banner").html("Please choose valid image.");
//                return false;
//            } else
//            {
//                var fileUpload = $("#sliderImg")[0];
//                //Check whether the file is valid Image.
//                var regex = new RegExp("([a-zA-Z0-9()\s_\\.\-:])+(.jpg|.png|.gif)$");
//                if (regex.test(fileUpload.value.toLowerCase())) {
//                    //Check whether HTML5 is supported.
//                    if (typeof (fileUpload.files) != "undefined") {
//                        var form = $('#addSlider');
//                        var formdata = false;
//                        if (window.FormData) {
//                            formdata = new FormData(form[0]);
//                        }
//                        $.ajax({
//                            url: "{{route('addHomeBanner')}}",
//                            type: 'post',
//                            data: formdata,
//                            processData: false,
//                            contentType: false,
//                            //   dataType: 'json',
//                            beforeSend: function () {
//                                // $("#barerr" + id).text('Please wait');
//                            },
//                            success: function (res) {
//                                $("#addNewSliderImage").modal('hide');
//                                $("#manageSlider").load(location.href + " #manageSlider>", "");
//                            }
//                        });
//eurireTraking
//
//
//                    } else
//                    {
//                        $("#error-banner").html("This browser does not support HTML5.");
//                        return false;
//                    }
//                } else
//                {
//                    $("#error-banner").html("Please select a valid Image file.");
//                    return false;
//                }
//            }
//
//        });


    });
</script>

<script>
var resultProduct = document.querySelector('.product-popup'),
        //save = document.querySelector('#saveSlider'),
        upload = document.querySelector('#prodImg'),
        cropper = '';
// on change show image with crop options
upload.addEventListener('change', function (e) {
    if (e.target.files.length) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if (e.target.result) {
                var img = document.createElement('img');
                img.id = 'image';
                img.src = e.target.result;
                resultProduct.innerHTML = '';
                resultProduct.appendChild(img);
                cropper = new Cropper(img, {
                    aspectRatio: 1,
                    dragMode: 'move',
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    zoom: -0.1,
                    built: function () {
                        $toCrop.cropper("setCropBoxData", {width: "1000", height: "1000"});
                    }
                });
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
// save on click
//save.addEventListener('click', function (e) {
$(".saveButton").on('click', function (e) {
    e.preventDefault();
    console.log("savebtn");
    if ($("#prodImg").val() == "")
    {
        $("#error-product").html("Please select product image.");
        return false;
    } else
    {
        var fileUpload = $("#prodImg")[0];
        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
              $("#error-product").html("");
                var form = $('#productAddPopUp');
                var formdata = false;
                if (window.FormData) {
                    formdata = new FormData(form[0]);
                }
                var ImageURL = cropper.getCroppedCanvas({
                    width: "1000" // input value
                }).toDataURL();
                $("#prod_img_url").val(ImageURL);
                 console.log("formdata");
                $('#productAddPopUp').submit();

            } 
            else
            {
                $("#error-product").html("This browser does not support HTML5.");
                return false;
            }
        } else
        {
            $("#error-product").html("Please select a valid Image file.");
            return false;
        }
    }

});
</script>
<script>
   var cw = $('#shop .product a img').width();
jQuery('#shop .product a img').css({'height':cw+'px'}); 


 $( document ).ready(function() {
    var pw = $('div#oc-product .owl-stage-outer .owl-stage .owl-item').width();
jQuery('.boxSizeImage').css({'height':pw+'px'});
});
  

$(document).ready(function() { 
    $('p:empty').remove(); 
    $('.shortDesc:empty').remove(); 
    });
</script>


<script>
  
window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '964048603765450', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.3' // use graph api version 2.8
    });
    
    // Check whether the user already logged in
//    FB.getLoginStatus(function(response) {
//        if (response.status === 'connected') {
//            //display user data
//          
//            getFbUserData();
//            fbLogout();
//        }
//    });
    
};
function fbLogout() {
    FB.logout(function() {
    });
}
// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

function getFbUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email'},
    function (response) {
      //  console.log(JSON.stringif(response));
         $('.errorMessage').empty();
          if(response){
            console.log(JSON.stringify(response));
        $.ajax({
            type: "POST",
            url: "{{route('checkFbUser')}}",
            data: {userData: response},
             timeout: 10000,
            cache: false,
            success: function (resp) {
                 console.log("response"+JSON.stringify(resp));
                 if(resp.status == 1){
                   window.location=resp.url;
                 }else if(resp.status == 0){
                       $('#login-error').show();
                        $('#login-error').html('Invalid Email or Password');
                      fbLogout();
        
                 }
            }
        });
    }
   });
}
 $(".tracking").on("click", function () {
            $("#myModal").modal('show');
        });
        $("#trackingId").keyup(function(){
            if($("#trackingId").val().length < 12 || ($("#trackingId").val()=='')){
             $("#trackingId").css('border-color', 'red')   
            }else{
               $("#trackingId").css('border-color', '')   
            }
        })
        $(".eurireTraking").on("click", function () {
            var trackingId=$("#trackingId").val();
            if(trackingId.length < 12){
                $("#trackingId").focus();
                $("#trackingId").css('border-color', 'red');
                $("#trackingId").attr("placeholder", "Please enter tracking Id");
                return false;
            }else{
                
                           $.ajax({
                            url: "{{ route('ecurierTracking')}}",
                            type: 'post',
                            data: {trackingId:trackingId},
          
                            success: function (res) {
                             console.log(JSON.stringify(res.trackdata));
                               $('#trackingDetails').empty();
                               $('.tableVaglignMiddle').removeClass("hide");
                               if(res.status==1){
                             
                               var trackData=' <td>'+res.trackdata[0][0]+'</td><td>'+res.trackdata[0][2]+'</td> ';                     
                              $('#trackingDetails').append(trackData);  
                          }else{
                              var trackData='<td>'+res.trackdata+'</td>';
                             $('#trackingDetails').append(trackData); 
                            }
                            }
                        });
                    }
                    });


</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular.js"></script>

<script type="text/javascript" src="{{Config('constants.frontendNGAPPJsPath').'/ng-app.js' }}"></script>

