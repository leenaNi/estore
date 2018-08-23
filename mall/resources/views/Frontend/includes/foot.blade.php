
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
        
    });
</script>
<!---- Subscription Link ------------->
<script type="text/javascript">
//    $("#btn-subscribe").click(function () {
//        $('#subscribe').validate();
//        if (!$('#subscribe').valid()) {
//            return false;
//        }
//        var email = $('.newsletter-email').val();
//        console.log("email value " + email);
//        var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
//        $('#subscription-success').empty();
//        if (!pattern.test(email))
//        {
//            $('#subscription-success').append("Please enter valid email.");
//        } else {
//            $.ajax({
//                type: "POST",
//                url: "{{route('subscriptionMail')}}",
//                data: {email: email},
//                cache: false,
//                success: function (data) {
//                    console.log("data: " + data);
//                    $('#subscription-success').append(data);
//                    $('#EmailIcon').find('i').removeClass('icon-line-loader icon-spin').addClass('icon-email2')
//                    //  $(form).find('.input-group-addon')
//                }
//            });
//        }
//
//    });
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
        var lang = ''; /* //$langs ?>; */
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
      appId      : '644176742612237', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.0' // use graph api version 2.8
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
//            url: "{{route('checkFbUser')}}",
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

</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular.js"></script>

<script type="text/javascript" src="{{ Config('constants.frontendPublicJsPath').'/ng-app.js' }}"></script>

