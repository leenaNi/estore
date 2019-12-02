var app = angular.module('app', []); 

//var hostname = location.hostname;
//var pathname = document.location.pathname;
//var arr = pathname.split("/");
//var domain = "http://"+hostname+"/"+arr[1];
//var domain = "http://localhost/Cartini";
var domain = document.location.origin;


app.filter('removeHTMLTags', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.filter('capitalize', function () {
    return function (input) {
        return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
app.config(['$interpolateProvider', function ($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }]);
app.filter('toTrust', ['$sce', function ($sce) {
        return function (text) {
            return $sce.trustAsHtml(text);
        };
    }]);
app.filter('htmlToPlaintext', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.controller('checkoutController', function ($http, $rootScope, $scope, $filter) {
    //for existing user
    $scope.loginExistingUser = function () {
        $("#loginEX").validate({
            // Specify the validation rules
            rules: {
                loginemail: {
                    required: true,
                    emailPhonevalidate: true
                },
                loginpassword: {
                    required: true,
                    minlength: 5
                }
            },
            // Specify the validation error messages
            messages: {
                loginemail: {
                    required: "Please enter email id",
                    email: "Please enter valid email id"
                },
                loginpassword: {
                    required: "Please enter a password",
                    minlength: "Your password must be at least 5 characters long"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    cache: false,
                    success: function (data)
                    {
                        if (data.status == 1) {
                            $scope.$apply(function () {
                                $scope.addressData = data.address;
                            });
                            if (data.address.length > 0) {
                                addid = $scope.addressData[0].id;
                                selPrevSelAdd(addid);
                            }
                            $("#collapseOne").removeClass("in");
                            $("div .loginPanel").addClass("hidepanel");
                            $("div .addressPanel").removeClass("hidepanel");
                            $("#collapseTwo").addClass("in");
                            $("div .loginPanel .panel-heading").removeClass("panel_heading_black");
                            $("div .loginPanel .panel-heading").addClass("panel_heading_grey");
                            $("div .addressPanel .panel-heading").removeClass("panel_heading_grey");
                            $("div .addressPanel .panel-heading").addClass("panel_heading_black");
                            $("div .billPanel").addClass("hidepanel");
                            $("div .paymentPanel").addClass("hidepanel");
                        } else {
                            $(".existUserError").show();
                            $(".existUserError").text('Invalid Email id or Password');
                        }
                    }
                });
                return false; // required to block normal submit since you used ajax
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_checkout_re_validate"));
            }
        });
    };

    $scope.loginExistingCancel = function () {
        $(".ExistEmail").val("");
        $(".ExistPassword").val("");
        $(".existUserError").text("");
        $(".loginF").css("display", "none");

    };
    //new user
    $scope.newUserLog = function () {
        $("#checkoutRegisterFormid").validate({
            // Specify the validation rules
            rules: {
                firstname: "required",
                email: {
                    // required: true,
                    // email: true,
                    emailvalidate: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                cpassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }, country_code: {
                    required: true
                },
                telephone: {
                    required: true,
                    phonevalidate: true
                }
            },
            // Specify the validation error messages
            messages: {
                firstname: "Please enter first name",
                email: {
                    required: "Please enter email id",
                    email: "Please enter valid email id"
                },
                password: {
                    required: "Please enter a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                cpassword: {
                    required: "Please enter a confirm password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Enter Confirm Password Same as Password"
                },
                country_code: {
                    required: "Please select country code"
                },
                telephone: {
                    required: "Please enter mobile number"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    success: function (data) {
                        $("#collapseOne").removeClass("in");
                        $("div .loginPanel").addClass("hidepanel");
                        $("div .addressPanel").removeClass("hidepanel");
                        $("#collapseTwo").addClass("in");
                        $("div .loginPanel .panel-heading").removeClass("panel_heading_black");
                        $("div .loginPanel .panel-heading").addClass("panel_heading_grey");
                        $("div .addressPanel .panel-heading").removeClass("panel_heading_grey");
                        $("div .addressPanel .panel-heading").addClass("panel_heading_black");
                        $("div .billPanel").addClass("hidepanel");
                        $("div .paymentPanel").addClass("hidepanel");
                        if (data != "Account already exists.") {
                            $scope.$apply(function () {
                                $scope.addressData = data;
                            });
                            if (data.address.length > 0) {
                                addid = $scope.addressData[0].id;
                                selPrevSelAdd(addid);
                            }
//                            addid = $scope.addressData[0].id;
//                            selPrevSelAdd(addid);
                        } else {
                            $scope.$apply(function () {
                                $scope.newUserError = data;
                            });
                            $('form').find("input[type=text], textarea,input[type=password],input[type=email]").val("");
                            $(".loginFormNewUser").show();
                        }
                    }
                });
                return false; // required to block normal submit since you used ajax
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_checkout_re_validate"));
            }
        });
    };

    // for guest checkout
    $scope.doGuestCheckout = function () {
        // alert("asdjhasdj");
        $("#guestCheckoutFrm").validate({
            // Specify the validation rules
            rules: {
                guestemail: {
                    required: true,
                    emailvalidate: true
                }
            },
            // Specify the validation error messages
            messages: {
                guestemail: {
                    required: "Please enter email id",
                    email: "Please enter valid email id"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: domain + "/guest_checkout",
                    data: $(form).serialize(),
                    cache: false,
                    success: function (data)
                    {
                        console.log(" Bhavana " + data);
                        $("#collapseOne").removeClass("in");
                        $("div .loginPanel").addClass("hidepanel");
                        $("div .billingaddressPanel").removeClass("hidepanel");
                        $("#collapseTwo").addClass("in");
                        $("div .loginPanel .panel-heading").removeClass("panel_heading_black");
                        $("div .loginPanel .panel-heading").addClass("panel_heading_grey");
                        $("div .billingaddressPanel .panel-heading").removeClass("panel_heading_grey");
                        $("div .billingaddressPanel .panel-heading").addClass("panel_heading_black");
                        $("div .billPanel").addClass("hidepanel");
                        $("div .paymentPanel").addClass("hidepanel");
                        if (isset(data)) {
                            $scope.$apply(function () {
                                $scope.addressData = data;
                            });
                            if (data.address.length > 0) {
                                addid = $scope.addressData[0].id;
                                selPrevSelAdd(addid);
                            }
//                            addid = $scope.addressData[0].id;
//                            selPrevSelAdd(addid);
                        } else {
                            $scope.$apply(function () {
                                $scope.newUserError = data;
                            });
                            $('form').find("input[type=text], textarea,input[type=password],input[type=email]").val("");
                            $(".loginFormNewUser").show();
                        }
                    }
                });
                return false; // required to block normal submit since you used ajax
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_checkout_re_validate"));
            }
        });

    };

    //google plus 
    $scope.googlepluslogin = function () {
        var myParams = {
            'clientid': '896852962079-ntj4u99fsmg1tfknvc2neubni02uuraj.apps.googleusercontent.com',
            'cookiepolicy': 'single_host_origin',
            'callback': $scope.googleplusResponse,
            'approvalprompt': 'force',
            'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read https://www.googleapis.com/auth/userinfo.profile'
        };
        gapi.auth.signIn(myParams);
    };

    $scope.googleplusResponse = function (result) {
        if (result['status']['signed_in']) {
            var request = gapi.client.plus.people.get({'userId': 'me'});
            request.execute(function (resp) {
                respon = resp;
                if (respon.emails[0].value) {
                    useremail = respon.emails[0].value;
                    lastname = respon.name.familyName;
                    firstname = respon.name.givenName;
                    userid = respon.id;
                    $.ajax({
                        type: "POST",
                        url: domain + "/get_g_plus_login",
                        data: {useremail: useremail, lastname: lastname, firstname: firstname, userid: userid},
                        cache: false,
                        success: function (data) {
                            $("#collapseOne").removeClass("in");
                            $("div .loginPanel").addClass("hidepanel");
                            $("div .addressPanel").removeClass("hidepanel");
                            $("#collapseTwo").addClass("in");
                            $("div .loginPanel .panel-heading").removeClass("panel_heading_black");
                            $("div .loginPanel .panel-heading").addClass("panel_heading_grey");
                            $("div .addressPanel .panel-heading").removeClass("panel_heading_grey");
                            $("div .addressPanel .panel-heading").addClass("panel_heading_black");
                            $("div .billPanel").addClass("hidepanel");
                            $("div .paymentPanel").addClass("hidepanel");
                            $scope.$apply(function () {
                                $scope.addressData = data;
                            });
                            if (data.address.length > 0) {
                                addid = $scope.addressData[0].id;
                                selPrevSelAdd(addid);
                            }
//                            addid = $scope.addressData[0].id;
//                            selPrevSelAdd(addid);
                        }
                    });
                } else {
                    alert("Your google Account Setting doesn't allow us to fetch your email address. Kindly change your Setting on Account setting or try another account. ")
                }
            });
        }
    };

    $scope.showNewAddDiv = function () {
        $scope.getAddData = {};
        $(".newAddFormDiv").css("display", "block");
        $("#postal_code_checkout_new_add_form").text('');
        $(".pincodeMessage").text("");
        $("#forAddress input[type='radio']").each(function () {
            $(this).prop('checked', false);
        });
        // $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
        $.ajax({
            type: "POST",
            url: domain + "/get_country_zone",
            data: "",
            cache: false,
            success: function (data) {
                var countr = data.countryid;
                $scope.selCountryId = data.countryid;
                // $scope.countryChangedValue(countr);
                $scope.$apply(function () {
                    $scope.zones = data.zone;
                    $scope.countryid = data.countryid;
                    $scope.getAddData = {'countryid': data.countryid, 'firstname': data.firstname, 'lastname': data.lastname, 'phone_no': data.phone_no};
                    $scope.country = data.country;
                });
            }
        });
    };

    $scope.showNewBillAddDiv = function () {
        $scope.getAddData = {};
        $(".newBillAddFormDiv").css("display", "block");
        $("#postal_code_checkout_new_add_form").text('');
        $(".pincodeMessage").text("");
        $("#forBillAddress input[type='radio']").each(function () {
            $(this).prop('checked', false);
        });
        // $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
        $.ajax({
            type: "POST",
            url: domain + "/get_country_zone",
            data: "",
            cache: false,
            success: function (data) {
                var countr = data.countryid;
                $scope.countryChangedValue(countr);
                $scope.$apply(function () {
                    $scope.zones = data.zone;
                    $scope.countryid = data.countryid;
                    $scope.getAddData = {'countryid': data.countryid, 'firstname': data.firstname, 'lastname': data.lastname, 'phone_no': data.phone_no};
                    $scope.country = data.country;
                });
            }
        });
    };

    $scope.countryChangedValue = function (country) {
        $.ajax({
            type: "POST",
            url: domain + "/get_zone",
            data: {country: country},
            cache: false,
            success: function (data) {
                $scope.$apply(function () {
                    $scope.zones = data;
                });
            }
        });
    };


    $scope.addNewAddSubmit = function () {
        $("#addNewAddForm").attr("action", domain + "/save_address");
        $("#addNewAddForm").validate({
            // Specify the validation rules
            rules: {
                firstname: "required",
                country_id: "required",
                state: "required",
                address1: "required",
                postal_code: {
                    required: $("#pincodeCheck").val() == 1,
                    minlength: 4
                },
                city: "required",
                phone_no: {
                    phonevalidate: true
                }
            },
            // Specify the validation error messages
            messages: {
                firstname: "Please enter your first name",
                country_id: "Please select country",
                state: "Please select state",
                address1: "Please enter address",
                city: "Please enter city",
                postal_code: {
                    required: "Please enter postcode",
                    minlength: "Your pincode must be at least 4 characters long"
                },
                phone_no: {
                    required: "Please enter phone number"
                }
            },
            submitHandler: function (form) {
                var chkadd = $("input[name='address1']").val();
                //  console.log(chkadd);
                //   var pincode = ("#pincode_check").val();
                if (chkadd.length > 0) {
                    $.ajax({
                        type: $(form).attr('method'),
                        url: $(form).attr('action'),
                        data: $(form).serialize(),
                        success: function (data) {
                            $("#addNewAddForm").attr("action", "");
                            $scope.$apply(function () {
                                $scope.addressData = data.addressdata;
                            });
                            addidD = data.curaddid;
                            $.ajax({
                                type: "POST",
                                url: domain + "/sel_address",
                                data: {addid: addidD},
                                cache: false,
                                success: function () {
                                    $scope.pincodecheck();
                                    // checkPinCode(addidD,2);
                                    billInterChkSummary();
                                }
                            });
                            $(".newAddFormDiv").css("display", "none");
                        }
                    });
                }
                return false; // required to block normal submit since you used ajax
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_checkout_new_add_form"));
            }
        });
    };

    $scope.addNewBillAddSubmit = function () {
        $("#addNewBillAddForm").attr("action", domain + "/save_billing_address");
        $("#addNewBillAddForm").validate({
            // Specify the validation rules
            rules: {
                firstname: "required",
                country_id: "required",
                state: "required",
                address1: "required",
                postal_code_bill: "required",
                // postal_code: {
                //     required: true,
                //     minlength: 4
                // },
                city: "required",
                phone_no: {
                    phonevalidate: true
                }
            },
            // Specify the validation error messages
            messages: {
                firstname: "Please enter your first name",
                country_id: "Please select country",
                state: "Please select state",
                address1: "Please enter address",
                city: "Please enter city",
                postal_code_bill: "Please enter Post Code",
                // postal_code: {
                //     required: "Please enter postcode",
                //     minlength: "Your pincode must be at least 4 characters long"
                // },
                phone_no: {
                    required: "Please enter phone number"
                }
            },
            submitHandler: function (form) {
                var chkadd = $("input[name='address1']").val();
                //  console.log(chkadd);
                //   var pincode = ("#pincode_check").val();
                if (chkadd.length > 0) {
                    $.ajax({
                        type: $(form).attr('method'),
                        url: $(form).attr('action'),
                        data: $(form).serialize(),
                        success: function (data) {
                            $("#addNewBillAddForm").attr("action", "");
                            $scope.$apply(function () {
                                $scope.addressData = data.addressdata;
                            });
                            addidD = data.curaddid;
                            $.ajax({
                                type: "POST",
                                url: domain + "/sel_address",
                                data: {addid: addidD},
                                cache: false,
                                success: function () {
                                    $scope.pincodecheck();
                                    // checkPinCode(addidD,2);
                                    getShippingAddress();
                                    
                                }
                            });
                            $(".newBillAddFormDiv").css("display", "none");
                        }
                    });
                }
                return false; // required to block normal submit since you used ajax
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_checkout_new_add_form"));
            }
        });
    };

    $scope.addressContinue = function () {
        var chkaddid = $("#addI").val();
        if ($("#forAddress input[type='radio']:checked").length) {
            if (chkaddid.length > 0) {
                $scope.addNewAddSubmit();
            } else {
                $("#addNewAddForm").submit(function (e) {
                    e.preventDefault();
                });
                $("#forAddress input[type='radio']").each(function () {
                    if ($(this).is(":checked")) {
                        var chkph = $(this).attr("phno");
                        var chkPincode = $(this).attr("addCodMsg");
                        $scope.pincodecheck();
                        if (chkph == '') {
                            alert("Invalid phone number.Please edit address");
                            $scope.editAdd($("#forAddress input[type='radio']:checked").val());
                        } else if (chkPincode != "" && chkPincode.indexOf("not") >= 0) {
                            msgP = chkPincode + " Please edit address";
                            alert(msgP);
                            $scope.editAdd($("#forAddress input[type='radio']:checked").val());
                        } else {
                            billInterChkSummary();
                        }
                    }
                });
            }
        } else {
            $scope.addNewAddSubmit();
        }
    };

    $scope.billAddressContinue = function () {
        var chkaddid = $("#addI").val();
        if ($("#forBillAddress input[type='radio']:checked").length) {
            if (chkaddid.length > 0) {
                $scope.addNewBillAddSubmit();
            } else {
                $("#addNewBillAddForm").submit(function (e) {
                    e.preventDefault();
                });
                $("#forBillAddress input[type='radio']").each(function () {
                    if ($(this).is(":checked")) {
                        var chkph = $(this).attr("phno");
                        var chkPincode = $(this).attr("addCodMsg");
                        // $scope.pincodecheck();
                        if (chkph == '') {
                            alert("Invalid phone number.Please edit address");
                            $scope.editBillAdd($("#forBillAddress input[type='radio']:checked").val());
                        } else if (chkPincode != "" && chkPincode.indexOf("not") >= 0) {
                            msgP = chkPincode + " Please edit address";
                            alert(msgP);
                            $scope.editBillAdd($("#forBillAddress input[type='radio']:checked").val());
                        } else {
                            getShippingAddress();
                        }
                    }
                });
            }
        } else {
            $scope.addNewBillAddSubmit();
        }
    };


    $scope.paymentL = function (cl) {
        nameC = cl;
        //$scope.paymentmethodChk();
        $("." + nameC).click();
    };

    $scope.pincodecheck = function () {
        // console.log("inside pin cjheck===");
        $(".pincodeMessage").css('color', "");
        $(".pincodeMessageLoader").show();
        $(".pincodeMessage").hide();
        $(".pincodeMessageLoader").hide();
        setTimeout(function () {
            var pincode = $('#pincode_check').val();
            console.log(pincode);
            $.ajax({
                url: domain + "/check-pincode-home",
                type: 'POST',
                data: {pincode: pincode},
                success: function (data) {

                    if (data.errorType == 'error') {
                        $(".pincodeMessage").show();
                        $(".pincodeMessage").css('color', 'red');
                        $(".pincodeMessage").text(data.message);
                    }
                    if (data.errorType == 'success') {
                        $(".pincodeMessage").show();
                        $(".pincodeMessage").text(data.message);
                    }

                    if (data.errorType == 'errorNotCont') {
                        //  console.log('inside err type');
                        $(".pincodeMessage").show();
                        $(".pincodeMessage").css('color', 'red');
                        $(".pincodeMessage").text(data.message);
                        $(".toBillSummary").attr('disabled', 'disabled');
                    } else {
                        $(".toBillSummary").removeAttr('disabled');
                    }
                },
                error: function (data) {
                    console.log(data);
                    $(".pincodeMessageLoader").hide();
                }

            });
        }, 0);
    };

    $scope.editAdd = function (addid) {
        var $ = jQuery;
        // $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
        // $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
        id = "adrs_" + addid;
        $("#" + id).parent().find("input[type='radio']").prop("checked", true);
        //$("#" + id).parent().children("h1").children("input[type='radio']").prop("checked", true);
        selPrevSelAdd(addid);
//        $("#" + id).parent().children("h1").children("input[type='radio']").click();
        $.ajax({
            type: "POST",
            url: domain + "/get_address",
            data: {addid: addid},
            cache: false,
            success: function (data) {
                $(".newAddFormDiv").css("display", "block");
                //  $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
                $scope.getAddData = null;
                $scope.$apply(function () {
                    $scope.getAddData = data.addData;
                    $scope.country = data.country;
                    $scope.zones = data.zone;
                });
                $scope.pincodecheck();
            }
        });
    };

    $scope.editBillAdd = function (addid) {
        var $ = jQuery;
        // $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
        // $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
        id = "adrs_" + addid;
        $("#" + id).parent().find("input[type='radio']").prop("checked", true);
        //$("#" + id).parent().children("h1").children("input[type='radio']").prop("checked", true);
        selPrevSelAdd(addid);
//        $("#" + id).parent().children("h1").children("input[type='radio']").click();
        $.ajax({
            type: "POST",
            url: domain + "/get_address",
            data: {addid: addid},
            cache: false,
            success: function (data) {
                $(".newBillAddFormDiv").css("display", "block");
                //  $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
                $scope.getAddData = null;
                $scope.$apply(function () {
                    $scope.getAddData = data.addData;
                    $scope.country = data.country;
                    $scope.zones = data.zone;
                });
                $scope.pincodecheck();
            }
        });
    };

    $scope.deleteAdd = function (addid) {
        chk = confirm("Do you want to delete this address?");

        if (chk) {
            $.ajax({
                type: "POST",
                url: domain + "/del_address",
                data: {addid: addid},
                success: function (data) {
                    $scope.$apply(function () {
                        $scope.addressData = data;
                    });
                }
            });
        } else {
            return false;
        }
    };

    $scope.deleteBillAdd = function (addid) {
        chk = confirm("Do you want to delete this address?");

        if (chk) {
            $.ajax({
                type: "POST",
                url: domain + "/del_bill_address",
                data: {addid: addid},
                success: function (data) {
                    $scope.$apply(function () {
                        $scope.billaddressData = data;
                    });
                }
            });
        } else {
            return false;
        }
    };
    // check pin code before going to bill page
//    var checkPinCode = function (data_cod,type) {
//        // console.log('hiii'+data_cod);
//                var pintype = data_cod;
//                $.ajax({
//                    url: domain + "/check-pincode",
//                    type: 'POST',
//                    data: {'pintype': pintype, 'type': type},
//                    cache: false,
//                    success: function (msg) {
//                        // if (msg == '1') {
//                        //     $("#postal_code_checkout_new_add_form").text('COD Available');
//                        // } else {
//                        //     $("#postal_code_checkout_new_add_form").text('COD Not Available');
//                        // }
//                    }
//                });
//    }

    var billInterChkSummary = function () {
        $.ajax({
            type: "POST",
            url: domain + "/check_international",
            data: "",
            cache: false,
            success: function (data) {
                if (data == "valid") {
                    getBillSummary();
                } else {
                    if (data == "shippedInternational") {
                        getBillSummary();
                    } else if (data == "notShippedInternational") {
                        $("#internationallyProdPopUp").modal("show");
                    }
                }
            }
        });
    };

    var getShippingAddress = function(){
        $.ajax({
            type: "POST",
            url: domain + "/get_loggedindata",
            data: '',
            cache: false,
            success: function (data) {
                console.log(data);
                if (data != "Invalid") {
                    $scope.$apply(function () {
                        $scope.addressData = data;
                    });
                    if (typeof ($scope.addressData[0]) != "undefined" && $scope.addressData[0] !== null) {
                        addid = $scope.addressData[0].id;
                        selPrevSelAdd(addid);
                    }
                    $("div .loginPanel").addClass("hidepanel");
                    $("#collapseOne").removeClass("in");
                    $("div .loginPanel .panel-heading").removeClass("panel_heading_black");
                    $("div .loginPanel .panel-heading").addClass("panel_heading_grey");
                    $("div .addressPanel").removeClass("hidepanel");
                    $("#collapseBA").removeClass("in");
                    $("#collapseTwo").addClass("in");
                    $("div .addressPanel .panel-heading").removeClass("panel_heading_grey");
                    $("div .addressPanel .panel-heading").addClass("panel_heading_black");
                    $("div .billPanel").addClass("hidepanel");
                    $("div .paymentPanel").addClass("hidepanel");

                    $("div .billingaddressPanel").addClass("hidepanel");
                    $("div .billingaddressPanel .panel-heading").removeClass("panel_heading_black");
                    $("div .billingaddressPanel .panel-heading").addClass("panel_heading_grey");
                } else {
                    $("div .loginPanel").removeClass("hidepanel");
                    $("#collapseOne").addClass("in");
                    $("div .addressPanel").addClass("hidepanel");
                    $("div .billPanel").addClass("hidepanel");
                    $("div .paymentPanel").addClass("hidepanel");
                }
            },
            error: function () {
                $("div .loginPanel").removeClass("hidepanel");
                $("#collapseOne").addClass("in");
                $("div .addressPanel").addClass("hidepanel");
                $("div .billPanel").addClass("hidepanel");
                $("div .paymentPanel").addClass("hidepanel");
            }
        });
    }

    var getBillSummary = function () {
        $("textarea#commentTT").val("");
        $.ajax({
            type: "POST",
            url: domain + "/getBillSummary",
            data: "",
            success: function (data) {
                $scope.$apply(function () {
                    $scope.billSummary = data;
                });
                $("div .loginPanel").addClass("hidepanel");
                $("div .addressPanel").addClass("hidepanel");
                $("div .addressPanel .panel-heading").removeClass("panel_heading_black");
                $("div .addressPanel .panel-heading").addClass("panel_heading_grey");
                $("#collapseTwo").removeClass("in");
                $("#collapseThree").addClass("in");
                $("div .billPanel").removeClass("hidepanel");
                $("div .billPanel .panel-heading").removeClass("panel_heading_grey");
                $("div .billPanel .panel-heading").addClass("panel_heading_black");
                $("div .paymentPanel").addClass("hidepanel");
            }
        });
    };
    var selPrevSelAdd = function (seladd) {
        addid = seladd;
        $.ajax({
            type: "POST",
            url: domain + "/sel_address",
            data: {addid: addid},
            cache: false,
            success: function () {
            }
        });
    }
    $scope.reqCashback = function () {

        var CartAmt = $(".TotalCartAmt").text();
        var checkbox = $("#checkbox1");
        var isChecked = checkbox.is(':checked');
        if (isChecked) {
            $.ajax({
                url: domain + "/require_cashback",
                type: 'POST',
                data: {CartAmt: CartAmt},
                cache: false,
                success: function (response) {
                    $(".cashbackMsg").css("display", "block");
                    if (response.msg == "success") {
                        // alert(response.checkbackUsedAmt);
                        console.log(JSON.stringify(response));
                        if (response.checkbackUsedAmt > 0) {
                            //$(".curRewPointsOld").hide();
                            // $(".curRewPointsNew").removeClass("hide");
                            //alert(response.remainingCashback);
                            $(".curRewPointsOld").text((response.remainingCashback).toFixed(2));
                            var newCartAmt = response.pay_amt;
                        }
                        if (newCartAmt <= 0) {
                            var url = $("#frmTransaction").attr('action');
                            $("#frmTransaction").attr("action", "{{ URL::route('order_cash_on_delivery'); }}");
                        }
                        $(".TotalCartAmt").text((response.pay_amt).toFixed(2));
                        $(".cashbackUsedAmount").text((response.checkbackUsedAmt).toFixed(2));
                    }
                }
            });
        } else {
            $.ajax({
                url: domain + "/revert_cashback",
                type: 'POST',
                data: '',
                cache: false,
                success: function (response) {
                    console.log(response.finalamt);
                    newCartAmt = response.finalamt;
                    $(".TotalCartAmt").text(response.finalamt);
                    $(".cashbackUsedAmount").text(0);
                    // $(".curRewPointsOld").show();
                    $(".curRewPointsOld").text(response.cashback.toFixed(2));
                    // $(".curRewPointsNew").addClass("hide");
                    if (newCartAmt <= 0) {
                        var url = $("#frmTransaction").attr('action');
                        $("#frmTransaction").attr("action", "{{ URL::route('order_cash_on_delivery'); }}");
                    }
                }
            });
        }
    };
    $scope.voucherApply = function () {
        var voucherCode = $(".userVoucherCode").val();
        $.ajax({
            url: domain + "/check_voucher",
            type: 'POST',
            data: {voucherCode: voucherCode},
            cache: false,
            success: function (response) {
                if (response.msg != "invalid data") {
                    $(".vMsg").css("display", "block");
                    var VoucherVal = response.voucherAmount;
                    if (response.msg != "Invalid Voucher") {
                        $("#voucherApply").attr("disabled", "disabled");
                        $(".userVoucherCode").attr("disabled", "disabled");
                        var Cmsg = "<span style='color:green;'>Voucher Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearVouch'>Remove!</a>";
                        $(".vMsg").html(Cmsg);
                        var newCartAmt = response.finalAmt;
                        if (newCartAmt > 0) {
                            var newCartAmt = newCartAmt;
                        } else {
                            var newCartAmt = 0;
                        }
                        $(".TotalCartAmt").text(newCartAmt.toFixed(2));
                        $(".voucherUsedAmount").text(VoucherVal.toFixed(2));
                    } else {
                        $("#voucherApply").removeAttr("disabled");
                        $(".userVoucherCode").removeAttr("disabled");
                        if (response.finalAmt) {
                            $(".vMsg").html("Invalid Voucher!");
                            var newCartAmt = parseInt(response.finalAmt.toFixed(2));
                            $(".TotalCartAmt").text(newCartAmt.toFixed(2));
                        }
                        $(".voucherUsedAmount").text("0");
                    }
                }
            }
        });
        return false;
    };

    $scope.userlevelDiscApply = function () {
        var discType = $('#user-level-disc').val();
        var discVal = $('input[name="user_level_discount"]').val();
        $("#userlevelDiscApply").attr('disabled', true);
        $.ajax({
            url: domain + "/check_user_level_discount",
            type: 'POST',
            data: {discType: discType, discVal: discVal},
            cache: false,
            success: function (response) {
                //console.log('@@@@ ' + msg);
                if (response['status'] == "success") {
                    $(".dMsg").css("display", "block");
                    $(".dMsg").html(response['msg']);
                    $(".TotalCartAmt").text(parseFloat(response['discountedAmt']).toFixed(2));
                    $(".discountUsedAmount").text(parseFloat(response['discVal']).toFixed(2));
                } else {
                    $("#userlevelDiscApply").attr('disabled', false);
                    $(".dMsg").html(response['msg']);
                    $(".TotalCartAmt").text(parseFloat(response['cartAmount']).toFixed(2));
                    $(".discountUsedAmount").text("0.00");
                }
            }
        });
        return false;
    };

    $scope.applyReferal = function () {
        var RefCode = $(".requireReferal").val();
        $.ajax({
            url: domain + "/check_referal_code",
            type: 'POST',
            data: {RefCode: RefCode},
            cache: false,
            success: function (response) {
                $(".referalMsg").show();
                $(".referalMsg").text(response.msg);
                if (response.msg != "Invalid") {
                    $(".referalCodeClass").attr("disabled", "disabled");
                    $(".requireReferal").attr("disabled", "disabled");
                    var Cmsg = "<span style='color:green;'>Referral Code Applied!</span> <a href='javascript:void(0);' class='clearRef' style='border-bottom: 1px dashed;'>Remove!</a>";
                    $(".referalMsg").html(Cmsg);
                    if ($(".referalCodeText").text() == 0) {
                        var newCartAmt = response.finalAmt;
                        $(".referalCodeText").text(response.referalCodeAmt.toFixed(2));
                        $(".refDisc").val(response.referalCodeAmt.toFixed(2));
                        $(".referalDiscount").text(response.referalCodeAmt.toFixed(2));
                        $(".TotalCartAmt").text(newCartAmt.toFixed(2));
                    }
                } else {
                    $(".referalCodeClass").removeAttr("disabled");
                    $(".requireReferal").removeAttr("disabled");
                    $(".referalMsg").text("Invalid Referral Code!");
                    if ($(".referalCodeText").text() != 0) {
                        var newCartAmt = response.finalAmt;
                        $(".referalCodeText").text(0);
                        $(".refDisc").val(0);
                        $(".referalDiscount").text('0.00');
                        $(".TotalCartAmt").text(newCartAmt.toFixed(2));
                    }
                }
            }
        });
    };
    $scope.addSel = function (addid) {

        $('#addNewAddForm')[0].reset();
        //$('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
        $(".newAddFormDiv").css("display", "none");
        $scope.getAddData = null;
        $scope.codPinValidate(addid);

        $.ajax({
            type: "POST",
            url: "/sel_address",
            data: {addid: addid},
            cache: false,
            success: function () {
            }
        });
    };


    $scope.selAddB = function (addid) {

        $('#addNewAddForm').find("input[type=text], textarea,input[type=hidden],input[type=select],input[type=email]").val("");
        $(".newAddFormDiv").css("display", "none");
        id = "adrs_" + addid;
        $scope.codPinValidate(addid);
        addidD = addid;


        $.ajax({
            type: "POST",
            url: domain + "/sel_address",
            data: {addid: addidD},
            cache: false,
            success: function () {
                $("#" + id).parent().find("input[type='radio']").prop("checked", true);
                //console.log("sdkjfsl success");
            }
        });
    };


    $scope.codPinValidate = function (addid) {

        $scope.getAddData = {};
        $scope.getAddData.id = "";
        $scope.getAddData.firstname = "";
        $scope.getAddData.lastname = "";

        $scope.getAddData.address1 = "";
        $scope.getAddData.address2 = "";
        $scope.getAddData.countryid = "";
        $scope.getAddData.postal_code_bill = "";
        $scope.getAddData.city = "";
        $scope.getAddData.zoneid = "";
        $scope.getAddData.phone_no = "";


        id = "adrs_" + addid;
        codmsg = $("#" + id).attr('codmsg');
        if (codmsg != "" && codmsg.indexOf("not") > 0) {
            $scope.editAdd(addid);
            $(".toBillSummary").attr('disabled', 'disabled');
        } else {
            $(".toBillSummary").removeAttr('disabled');
        }
    }

    $scope.backToBillingAddress = function () {
        $.ajax({
            type: "POST",
            url: domain + "/back_to_address",
            data: "",
            cache: false,
            success: function (data) {
                $("#collapseThree").removeClass("in");
                $("div .billPanel").addClass("hidepanel");
                $("div .billingaddressPanel").removeClass("hidepanel");
                $("#collapseTwo").addClass("in");
                $("div .billPanel .panel-heading").removeClass("panel_heading_black");
                $("div .billPanel .panel-heading").addClass("panel_heading_grey");
                $("div .billingaddressPanel .panel-heading").removeClass("panel_heading_grey");
                $("div .billingaddressPanel .panel-heading").addClass("panel_heading_black");
                $("div .loginPanel").addClass("hidepanel");
                $("div .paymentPanel").addClass("hidepanel");
                $(".toBillSummary").removeAttr('disabled');
                var selAddid = $('#forAddress input:radio:first').val();
                $('#forAddress input:radio:first').prop("checked", true);
                init();
                selPrevSelAdd(selAddid);

            }
        });
    };

    $scope.backToAddress = function () {
        $.ajax({
            type: "POST",
            url: domain + "/back_to_address",
            data: "",
            cache: false,
            success: function (data) {
                $("#collapseThree").removeClass("in");
                $("div .billPanel").addClass("hidepanel");
                $("div .addressPanel").removeClass("hidepanel");
                $("#collapseTwo").addClass("in");
                $("div .billPanel .panel-heading").removeClass("panel_heading_black");
                $("div .billPanel .panel-heading").addClass("panel_heading_grey");
                $("div .addressPanel .panel-heading").removeClass("panel_heading_grey");
                $("div .addressPanel .panel-heading").addClass("panel_heading_black");
                $("div .loginPanel").addClass("hidepanel");
                $("div .paymentPanel").addClass("hidepanel");
                $(".toBillSummary").removeAttr('disabled');
                var selAddid = $('#forAddress input:radio:first').val();
                $('#forAddress input:radio:first').prop("checked", true);
                //init();
                selPrevSelAdd(selAddid);

            }
        });
    };

    $scope.backToCart = function () {
        console.log('asajflakjfsk');
        window.location.href = domain + "/cart";
    };
    $scope.backToBill = function () {
        $("textarea#commentTT").val("");
        $.ajax({
            type: "POST",
            url: domain + "/back_to_bill",
            data: "",
            cache: false,
            success: function () {
                billInterChkSummary();
                $("#radioEbs").click();
                $("#collapseFour").removeClass("in");
                $("div .paymentPanel").addClass("hidepanel");
                $("div .billPanel").removeClass("hidepanel");
                $("#collapseThree").addClass("in");
                $("div .paymentPanel .panel-heading").removeClass("panel_heading_black");
                $("div .paymentPanel .panel-heading").addClass("panel_heading_grey");
                $("div .billPanel .panel-heading").removeClass("panel_heading_grey");
                $("div .billPanel .panel-heading").addClass("panel_heading_black");
                $("div .loginPanel").addClass("hidepanel");
                $("div .paymentPanel").addClass("hidepanel");
                $("div .addressPanel").addClass("hidepanel");
            }
        });
    };

    $scope.toPaymentF = function () {
        var commentText = $("textarea#commentTT").val();
        //console.log(commentText);
        $.ajax({
            type: "POST",
            url: domain + "/toPayment",
            data: {commentText: commentText},
            success: function (data) {
                $scope.$apply(function () {
                    $scope.toPayment = data;
                });
                $('.currency-sym').html('').html($scope.toPayment.curData.sym);
                $('.currency-sym-in-braces').html('').html("(" + $scope.toPayment.curData.sym + ")");
                $("div .loginPanel").addClass("hidepanel");
                $("div .addressPanel").addClass("hidepanel");
                $("div .billPanel .panel-heading").removeClass("panel_heading_black");
                $("div .billPanel .panel-heading").addClass("panel_heading_grey");
                $("div .paymentPanel .panel-heading").removeClass("panel_heading_grey");
                $("div .paymentPanel .panel-heading").addClass("panel_heading_black");
                $("#collapseThree").removeClass("in");
                $("#collapseFour").addClass("in");
                $("div .billPanel").addClass("hidepanel");
                $("div .paymentPanel").removeClass("hidepanel");
            }
        });
    };

    $scope.codcharges = function (event) {
        var element = event.target;
        //console.log("=========bhavana COD  " );
        if ($(element).data('method') == 'cod' && $(".codCharges").html() == 0) {
            $.ajax({
                type: "POST",
                url: domain + "/apply_cod_charges",
                data: "",
                cache: false,
                success: function (data) {
                    //  $(".codCharges ").html("50");
                    //console.log(" safaf  sg "+$filter('number')(parseFloat(data.finalAmt), 2)) ;
                    //console.log("asdas " +parseFloat(data.payamt).toFixed(2)) ;
                    $(".finalamt").text(parseFloat(data.payamt).toFixed(2));
                    $(".total_amt").text(parseFloat(data.finalAmt).toFixed(2));
                    //  encrypt(newCartAmt);
                }
            });
        } else if ($(element).data('method') != 'cod') {
            $.ajax({
                type: "POST",
                url: domain + "/revert_cod_charges",
                data: "",
                cache: false,
                success: function (data) {
                    $(".finalamt").text(parseFloat(data.payamt).toFixed(2));
                    $(".total_amt").text(parseFloat(data.finalAmt).toFixed(2));
                    // var newCartAmt = $filter('number')(parseFloat(amt.finalAmt), 2);
                    // $(".finalamt").text(newCartAmt);
                }
            });
        }
    };


    $scope.paymentmethodChk = function ($event) {
        event = $event;
        if ($(".codChk").is(':checked')) {
            $scope.codcharges(event);
            $("#frmTransaction").attr("action", domain + "/order_cash_on_delivery");
        }
        if ($(".chk_paypal").is(':checked')) {
            $scope.codcharges(event);
            $("#frmTransaction").attr("action", domain + "/paypal_process");
        }
        if ($(".chk_EBS").is(':checked')) {
            $scope.codcharges(event);
            $("#frmTransaction").attr("action", domain + "/ebs");
        }
        if ($(".chk_razPay").is(':checked')) {
            $scope.codcharges(event);
            $("#frmTransaction").attr("action", domain + "/get-razorpay");
        }
        if ($(".chk_payUmoney").is(':checked')) {
            $scope.codcharges(event);
            $("#frmTransaction").attr("action", domain + "/get-payu");
        }
        if ($(".chk_citrus").is(':checked')) {
            $scope.codcharges(event);
            $("#frmTransaction").attr("action", domain + "/get-citrus");
        }
        if ($(".chk_cit_pay").is(':checked')) {
            $scope.codcharges(event);
            $("#frmTransaction").attr("action", domain + "/get-city-pay");
        }
    };

    $scope.placeOrder = function ($event) {
        ev = $event;
        ev.preventDefault();
        $.ajax({
            type: "POST",
            url: domain + "/chk-cart-inventory",
            data: "",
            cache: false,
            success: function (data) {
                // alert(data);
                if (data === "valid") {
                    // alert("valid Data");
                    console.log("sdfsdfsdfsdfsdf form submit code");
                    $("#frmTransaction").submit();
                } else {
                    // alert("else invalid Data");
                    $("#OutofStockPopUp").modal("show");
                }
            }
        });
    };
    var init = function () {

        $.ajax({
            type: "POST",
            url: domain + "/get_billingdata",
            data: '',
            cache: false,
            success: function (data) {
                console.log(data);
                if (data != "Invalid") {
                    $scope.$apply(function () {
                        $scope.billaddressData = data;
                    });
                    if (typeof ($scope.billaddressData[0]) != "undefined" && $scope.billaddressData[0] !== null) {
                        addid = $scope.billaddressData[0].id;
                        selPrevSelAdd(addid);
                    }
                    $("div .loginPanel").addClass("hidepanel");
                    $("#collapseOne").removeClass("in");
                    $("div .loginPanel .panel-heading").removeClass("panel_heading_black");
                    $("div .loginPanel .panel-heading").addClass("panel_heading_grey");
                    $("div .billingaddressPanel").removeClass("hidepanel");
                    $("#collapseTwo").removeClass("in");
                    $("#collapseBA").addClass("in");
                    $("div .billingaddressPanel .panel-heading").removeClass("panel_heading_grey");
                    $("div .billingaddressPanel .panel-heading").addClass("panel_heading_black");
                    $("div .billPanel").addClass("hidepanel");
                    $("div .paymentPanel").addClass("hidepanel");

                    $("div .addressPanel").addClass("hidepanel");
                    $("div .addressPanel .panel-heading").addClass("panel_heading_grey");
                    $("div .addressPanel .panel-heading").removeClass("panel_heading_black");
                } else {
                    $("div .loginPanel").removeClass("hidepanel");
                    $("#collapseOne").addClass("in");
                    $("div .addressPanel").addClass("hidepanel");
                    $("div .billingaddressPanel").addClass("hidepanel");
                    $("div .billPanel").addClass("hidepanel");
                    $("div .paymentPanel").addClass("hidepanel");
                }
            },
            error: function () {
                $("div .loginPanel").removeClass("hidepanel");
                $("#collapseOne").addClass("in");
                $("div .addressPanel").addClass("hidepanel");
                $("div .billPanel").addClass("hidepanel");
                $("div .paymentPanel").addClass("hidepanel");
            }
        });


    };
    init();
});


app.controller('configProductController', function ($http, $rootScope, $scope, $location, $compile) {
    $scope.product = [];
    $scope.proDesc = '';
    $scope.testmadhu = 'madhu';
    $scope.prodAttrValId = '';
    $scope.suprodarr = [];
    $scope.suprodarrId = [];

    $scope.getslug = function () {
        absurl = $location.absUrl();
        slug = absurl.substr(absurl.lastIndexOf('/') + 1);
        return slug;
    };

    $scope.commaSeparateNumber = function (val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }

    $scope.chekAvailProduct = function (selectedVal, parentPrdId, nextattrid) {
        $scope.parentprodid = parentPrdId;
        $scope.attributeid = selectedVal;
        $scope.nextattr = nextattrid;
        console.log("next attr id==" + nextattrid);
        $http.get(domain + "/get-avail-prod?parentprodid=" + $scope.parentprodid + "&attributeid=" + $scope.attributeid + "&nextattrid=" + $scope.nextattr)
                .then(function (response) {
                    $scope.options = response.data;
                });
    };
    $scope.getProductVarient = function (productId, attrValId) {
        alert(productId + " **** " + attrValId);
        $scope.attrValId = attrValId;
        $scope.productId = productId;
        $http.get(domain + "/get-prod-varient?attrValId=" + $scope.attrValId + "&productId=" + $scope.productId)
                .then(function (response) {
                    console.log(response.data);
                    $scope.otherOptions = response.data;
                });
    }
    ;

    $scope.selAttrChange = function (selOpt, selid, getnext) {
        console.log(selOpt + ", " + selid + ", " + getnext);
        $scope.selprods = [];
        $scope.subProd = [];
        $scope.allSubProds = [];
        console.log($scope.suprodarr.length + " subprod length " + $scope.suprodarr[0]);
        if (($scope.suprodarr.length > 0) && (getnext == 1) && (($('#selID' + (getnext - 1)).val()) !== $scope.suprodarr[0])) {
            console.log($scope.suprodarr[0]);
            $scope.suprodarr = [];
            $scope.suprodarrId = [];
            $('.subPRod').val('');
        }
        $scope.suprodarr.push(selOpt);
        $scope.suprodarrId.push(selid);
        $("selID" + getnext).removeClass("ng-hide");
        var mySel = angular.element(document.querySelector('#selAT'));
        $("#selID" + getnext).remove();
        $scope.sel = [];
        $scope.getsel = "";
        $.each($scope.selAttributes, function (k, v) {
            $scope.sel.push({id: k, opt: v});
        });
        $scope.reqSubPrd = [];
        $scope.newOpt = [];
        if ($scope.sel[getnext]) {
            $.each($scope.selAttributes[selid]['attrs'][selOpt]['prods'], function (Valk, ValV) {
                $scope.selprods.push(ValV);
            });
            $(".optError").hide();
            console.log("====1 " + JSON.stringify($scope.sel[getnext]));
            $.each($scope.sel[getnext], function (chk, ckv) {
                if (chk == 'opt') {
                    $.each(ckv['attrs'], function (getattK, getattV) {
                        $.map($scope.selprods, function (a) {
                            return $.inArray(a, getattV['prods']) < 0 ? null : $scope.newOpt.push(getattK);
                        });
                        $.map($scope.selprods, function (a) {
                            return $.inArray(a, getattV['prods']) < 0 ? null : $scope.reqSubPrd.push(a);
                        });
                    });
                }
            });
        } else {
            for (var i = getnext; i > 0; i--) {
                var optn = $scope.suprodarr[(i - 1)];
                if ((i - 1) == (getnext - 1)) {
                    $scope.subProd.push($scope.selAttributes[selid].attrs[selOpt].prods);
                } else {
                    $scope.subProd.push($scope.selAttributes[$scope.suprodarrId[(i - 1)]].attrs[optn].prods);
                }
            }
        }
        $.unique($scope.newOpt);
        if ($scope.sel[getnext]) {
            nextindex = getnext + 1;
            $scope.getsel += "<select  id='selID" + getnext + "'  class='selatts attrSel' name=" + $scope.sel[getnext].opt.name + "  ng-init='modelName = selaTT" + $scope.sel[getnext].id + "' ng-model='modelName' ng-change='selAttrChange(modelName," + $scope.sel[getnext].id + "," + nextindex + ")'>";
            $scope.getsel += "<option value=''>" + $scope.sel[getnext].opt.placeholder + "</option>";
            $scope.newoptions = [];
            $.each($scope.newOpt, function (newK, newV) {
                var object = {};
                object[newV] = $scope.sel[getnext].opt.options[newV];
                $scope.newoptions.push(object);
            });
            $.each($scope.newoptions, function (opk, opv) {
                $.each(opv, function (optk, optv) {
                    $scope.getsel += "<option  value='" + (optk) + "'>" + optv + "</option>";
                });
            });
            $scope.getsel += "</select>";
            var newSel = $compile($scope.getsel)($scope);
            mySel.append(newSel);
        } else {
            $scope.allSubProds = $scope.subProd;
            //alert(JSON.stringify($scope.allSubProds));
            var subprodId = $scope.allSubProds.shift().filter(function (v) {
                return $scope.allSubProds.every(function (a) {
                    return a.indexOf(v) !== -1;
                });
            });
            console.log("Sub prod " + subprodId);
            $('.subPRod').val(subprodId);
            $(".optError").hide();
            if ($scope.product.is_stock == 1) {
                if (subprodId) {
                    $http.post(domain + "/check-stock", {prodId: subprodId}).then(function (response) {

                        //  alert(parseInt($(".mrp_price").html()));
                        if (response.data.product.stock > 0 && response.data.stockLimit >= response.data.product.stock) {
                            $(".span2").removeClass("hide");
                            $(".span2").empty();
                            var price = parseInt($(".parent_price").val());
                            $('#quantity').attr('max', response.data.stock);
                            $(".span2").append("STOCK LEFT : " + response.data.product.stock);
                            $(".mrp_price").empty();
                            console.log("in1===p=====" + price);
                            console.log("in2===prd=====" + response.data.product.price);
                            console.log("currency Val ==== " + $scope.currencyVal);
                            $(".mrp_price").append($scope.commaSeparateNumber(((price + parseInt(response.data.product.price)) * $scope.currencyVal).toFixed(2)));
                            //  $('#quantity').attr('max', response.data.stock);
                        } else if (response.data.product.stock == 0) {
                            //  $(".span2").addClass("hide"); 
                            $('#quantity').attr('max', response.data.stock);
                            $(".span2").empty();
                            $(".span2").append("Out Of Stock ");
                        } else {
                            var price = parseInt($(".parent_price").val());
                            console.log("in3===p=====" + price);
                            console.log("in4===prd=====" + response.data.product.price);
                            console.log("currency Val ==== " + $scope.currencyVal);
                            $(".mrp_price").empty();
                            $('#quantity').attr('max', response.data.stock);
                            $(".mrp_price").append($scope.commaSeparateNumber(((price + parseInt(response.data.product.price)) * $scope.currencyVal).toFixed(2)));
                            $(".span2").addClass("hide");
                        }
                        $("#selID" + (getnext - 1)).removeClass('error');

                    });
                }
            }
        }
    };

    var configProd = function () {
        $scope.slug = $scope.getslug();
        $http.get(domain + "/get-config-prod?slug=" + $scope.slug)
                .then(function (response) {
                    $scope.product = response.data.product;
                    $scope.currencyVal = response.data.currencyVal;
                    $scope.selAttributes = response.data.selAttrs;
                    $scope.proDesc = $scope.product.shortDesc;
                    setTimeout(function () {
                        $('.currency-sym').html('').html(response.data.curData.sym);
                        $('.currency-sym-in-braces').html('').html("(" + response.data.curData.sym + ")");
                    }, 1000);
                });
    };
    configProd();
}).directive("owlCarousel", function () {
    return {
        restrict: 'E',
        transclude: false,
        link: function (scope) {
            scope.initCarousel = function (element) {
                // provide any default options you want
                var defaultOptions = {
                    responsive: {
                        0: {
                            items: 1,
                            nav: true
                        },
                        600: {
                            items: 2,
                            nav: true
                        }
                    }
                };
                var customOptions = scope.$eval($(element).attr('data-options'));
                // combine the two options objects
                for (var key in customOptions) {
                    defaultOptions[key] = customOptions[key];
                }
                // init carousel
                $(element).owlCarousel(defaultOptions);
            };
        }
    };
}).directive('owlCarouselItem', [function () {
        return {
            restrict: 'A',
            transclude: false,
            link: function (scope, element) {
                // wait for the last item in the ng-repeat then call init
                if (scope.$last) {
                    scope.initCarousel(element.parent());
                }
            }
        };
    }]);
app.controller('comboProductController', function ($http, $rootScope, $scope, $location, $compile) {
    $scope.product = [];
    $scope.proDesc = '';
    var subProd = [];
    $scope.prodAttrValId = '';
    $scope.suprodarr = [];
    $scope.suprodarrId = [];

    $scope.getslug = function () {
        absurl = $location.absUrl();
        slug = absurl.substr(absurl.lastIndexOf('/') + 1);
        return slug;
    };
    $scope.chekAvailProduct = function (selectedVal, parentPrdId, nextattrid) {
        $scope.parentprodid = parentPrdId;
        $scope.attributeid = selectedVal;
        $scope.nextattr = nextattrid;

        $http.get(domain + "/get-avail-prod?parentprodid=" + $scope.parentprodid + "&attributeid=" + $scope.attributeid + "&nextattrid=" + $scope.nextattr)
                .then(function (response) {
                    $scope.options = response.data;
                });
    };
    $scope.getProductVarient = function (productId, attrValId) {
        $scope.attrValId = attrValId;
        $scope.productId = productId;
        $http.get(domain + "/get-prod-varient?attrValId=" + $scope.attrValId + "&productId=" + $scope.productId)
                .then(function (response) {

                    $scope.otherOptions = response.data;
                });
    };


    $scope.selAttrChange = function (selOpt, selid, getnext, parentprod) {

        $scope.selprods = [];
        $scope.subProd = [];
        $scope.allSubProds = [];
        $scope.childItems = {};

        $scope.attvarients = {};

        $.each($scope.attrVarients, function (attrVarK, attrVarK) {
            attrVarKey = attrVarK.id;
            attrVarValue = attrVarK.des;
            $scope.attvarients[attrVarKey] = attrVarValue;
        });


        if (($scope.suprodarr.length > 0) && (getnext == 1) && (($('#selID' + (getnext - 1)).val()) !== $scope.suprodarr[0])) {

            $scope.suprodarr = [];
            $scope.suprodarrId = [];
            $('.subPRod' + parentprod).val('');
        }
        $scope.suprodarr.push(selOpt);
        $scope.suprodarrId.push(selid);


        $("selID" + getnext).removeClass("ng-hide");
        var mySel = angular.element(document.querySelector('#selAT'));
        $("#selID" + getnext).remove();
        $scope.sel = [];
        $scope.getsel = "";
        $.each($scope.selAttributes, function (k, v) {
            $scope.sel.push({id: k, opt: v});
        });
        $scope.reqSubPrd = [];
        $scope.newOpt = [];

//        if ($scope.sel[getnext] != '')
        console.log("option " + selOpt + ",select Id  " + selid + ",Next  " + getnext + " Parent  " + parentprod);
        console.log($scope.selAttributes[parentprod][selid]['attrs'][selOpt]['prods']);
        if ($scope.sel[getnext]) {
            // alert(JSON.stringify($scope.selAttributes[parentprod][selid]['attrs'][selOpt]['prods']));
            $.each($scope.selAttributes[parentprod][selid]['attrs'][selOpt]['prods'], function (Valk, ValV) {
                $scope.selprods.push(ValV);
            });

            $.each($scope.sel[getnext], function (chk, ckv) {

                if (chk == 'opt') {
                    var select1 = (parseInt(selid) + 1).toString();
                    $.each(ckv[select1]['attrs'], function (getattK, getattV) {

                        $.map($scope.selprods, function (a) {
                            return $.inArray(a, getattV['prods']) < 0 ? null : $scope.newOpt.push(getattK);
                        });
                        $.map($scope.selprods, function (a) {
                            return $.inArray(a, getattV['prods']) < 0 ? null : $scope.reqSubPrd.push(a);
                        });
                    });
                }

            });
        } else {
            for (var i = getnext; i > 0; i--) {
                var optn = $scope.suprodarr[(i - 1)];
                if ((i - 1) == (getnext - 1)) {
                    alert("fdsfsd");
                    $scope.subProd.push($scope.selAttributes[parentprod][selid].attrs[selOpt].prods);

                } else {
                    alert($scope.suprodarrId[(i - 1)]);
                    // console.log($scope.selAttributes[$scope.suprodarrId[(i - 1)]].attrs[optn]);
                    $scope.subProd.push($scope.selAttributes[parentprod][$scope.suprodarrId[(i - 1)]].attrs[optn].prods);

                }
            }
        }
        $.unique($scope.newOpt);

        lengthopt = $scope.newOpt.length;
        if ($scope.sel[getnext]) {
            var select = (parseInt(selid) + 1).toString();
            nextindex = getnext + 1;
            $scope.getsel += "<select  id='selID" + getnext + "'  class='selatts col_one_fourth  form-control' ng-init='modelName = selaTT" + $scope.sel[getnext].id + "' ng-model='modelName' ng-change='selAttrChange(modelName," + $scope.sel[getnext].id + "," + nextindex + ")'>";
            $scope.getsel += "<option value=''>" + $scope.sel[getnext].opt.placeholder + "</option>";
            $scope.newoptions = [];
            $.each($scope.newOpt, function (newK, newV) {
                var object = {};


                //  alert(JSON.stringify($scope.sel[getnext].opt[select].options));

                object[newV] = $scope.sel[getnext].opt[select].options[newV.toLowerCase()];
                $scope.newoptions.push(object);
            });
            var selOptionNew = $scope.newoptions[0];


            $.each($scope.newoptions, function (opk, opv) {

                $.each(opv, function (optk, optv) {
                    alert(optk);
                    //  console.log("==== " + JSON.stringify($scope.sel[getnext].opt.options[newV.toLowerCase()]));
                    var forSel = Object.keys(selOptionNew)[0];
                    $scope.forSel = Object.keys(selOptionNew)[0];
                    if (forSel == optk) {
                        $scope.getsel += "<option ng-selected='" + forSel + "' value='" + (optk) + "'>" + optv + "</option>";
                    } else {
                        $scope.getsel += "<option  value='" + (optk) + "'>" + optv + "</option>";
                    }
                });
            });
            $scope.getsel += "</select>";

            var newSel = $compile($scope.getsel)($scope);
            // alert(JSON.stringify( $scope.getsel));
            mySel.append(newSel);

            if (lengthopt == 1) {
                angular.element(document.querySelector('#selID' + getnext)).hide();
            }
            //      console.log('---isstok--'+$scope.product.is_stock);

            //   alert(JSON.stringify($scope.sel[getnext]));
            $scope.selAttrChange($scope.forSel, select, nextindex, parentprod);
        } else {
            console.log("subprod" + $scope.subProd)
            $scope.allSubProds = $scope.subProd;
            var subprodId = $scope.allSubProds.shift().filter(function (v) {
                return $scope.allSubProds.every(function (a) {
                    return a.indexOf(v) !== -1;
                });
            });
            //  subProd[parentprod]=subprodId; 
            // console.log(subProd);
            $('.subPRod' + parentprod).val(subprodId);
            //  console.log('---isstok--'+$scope.product.is_stock);
            if ($scope.product.is_stock == 1) {
                if (subprodId) {
                    $http.post(domain + "/check-stock", {prodId: subprodId}).then(function (response) {
                        console.log(response.data);
                        if (response.data.stock > 0) {
                            $(".product_left").text("");
                            $('#quantity' + parentprod).attr('max', response.data.stock);

                        }
                    });
                }
            }
            subprodPrice = $scope.childItems[subprodId];
            if (parseInt($scope.splprice) > 0 && parseInt($scope.splprice) < parseInt($scope.price)) {
                $scope.actualPrice = $scope.splprice;
            } else {
                $scope.actualPrice = $scope.price;
            }

            // console.log("-- actual price-----"+ $scope.actualPrice);
            //  console.log("---sub prod price----"+ subprodPrice);
            //  console.log("--- price----"+ $scope.price);
            //    console.log("---spl price----"+ $scope.splprice);

            $scope.product.selling_price = parseFloat(parseInt($scope.actualPrice) + parseInt(subprodPrice)).toFixed(2);


            if (parseInt($scope.product.selling_price) < parseInt($scope.price)) {
                angular.element(document.querySelector('.splPDiv')).show();
            } else {
                angular.element(document.querySelector('.splPDiv')).hide();
            }

        }
    };



    var comboProd = function () {

        $scope.slug = $scope.getslug();
        $http.get(domain + "/get-combo-prod?slug=" + $scope.slug)
                .then(function (response) {
                    $scope.product = response.data.product;
                    $scope.generalSetting = response.data.generalSetting;
                    $scope.selAttributes = response.data.selAttrs;
//                    $scope.proDesc = $scope.product.shortDesc;
//                    $scope.prodBreadcrumbs = $scope.product.breadcrumbs;
                    $scope.comboprds = response.data.product.comboproducts;
                    //  $scope.getComboInfo(null, $scope.comboprds[0].id);
                    $scope.getChildProds = response.data.getChildProds;
                    $scope.splprice = $scope.product.spl_price;
                    $scope.selprice = $scope.product.selling_price;
                    $scope.price = $scope.product.price;
                    $scope.checksplprice = parseInt($scope.product.spl_price);
                    $scope.checkprice = parseInt($scope.product.price);
                    $scope.attrVarients = response.data.attrVarients;
                    setTimeout(function () {
                        $('.currency-sym').html('').html(response.data.curData.sym);
                        $('.currency-sym-in-braces').html('').html("(" + response.data.curData.sym + ")");
                    }, 1000);
//                    $scope.viewVideo(response.data.generalSetting, $scope.product);
                });


    };
    comboProd();
});


app.controller('productListingController', function ($http, $rootScope, $scope, $filter, $location, $compile) {
    var getparameters = function (name, url) {
        if (!url)
            url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
        if (!results)
            return null;
        if (!results[2])
            return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
    $scope.searchTerm = getparameters('searchTerm', $location.absUrl());
    $scope.sel = (get("sort")) ? get("sort") : '1';
    $scope.pdts = [];
    $scope.prodts = {};
    $scope.minp = '0';
    $scope.maxp = '0';
    //$scope.pdts.getPrice = [];
    $scope.filtered = {};
    $scope.filters = [];
    $scope.filteredCheck = '';
    $scope.suprodarr = [];
    $scope.suprodarrId = [];
    $scope.getslug = function () {
        absurl = $location.absUrl();
        slug = absurl.substr(absurl.lastIndexOf('/') + 1);
        return slug;
    }
    $scope.load = function (event, url) {
        console.log("searchtermon load== " + $scope.searchTerm);
        angular.element(event.target).children("i").addClass("fa fa-spinner fa-pulse");
        $http.get(url, {
            params: {
                'filters': $scope.filtered,
                'minp': $scope.minp,
                'maxp': $scope.maxp,
                'slug': $scope.getslug(),
                'sort': $scope.sel,
                'searchTerm': $scope.searchTerm
                        // 'userId': (window.localStorage.getItem('id') != null ? window.localStorage.getItem('id') : "")
            }
        }).success(function (data, status, headers, config) {
            console.log('data ' + data.prods.data[0]);
            console.log($scope.pdts);
            if (data.prods.data.length > 0) {
                jQuery.each(data.prods.data, function (k, v) {
                    $scope.pdts.push(v);
                });
                $scope.nextpageurl = data.prods.next_page_url;
            }
            $scope.$digest;
            setTimeout(function () {
                $('.currency-sym').html('').html(data.curData.sym);
                $('.currency-sym-in-braces').html('').html("(" + data.curData.sym + ")");
            }, 300);
        });
    };

    //for check box filter in right side check box menu
    $scope.filterProds = function (option, parent) {
        console.log("Option => " + option + " Parent =>" + parent + " saize => " + $scope.filtered);
        if (option) {
            if (!(parent in $scope.filtered)) {
                $scope.filtered[parent] = [];
                //$scope.filteredCheck[parent] = [];
            }
            var idx = $scope.filtered[parent].indexOf(option);
            if (idx > -1) {
                var indx = $scope.filters.indexOf(option);
                $scope.filters.splice(indx, 1);
                $scope.filtered[parent].splice(idx, 1);
            } else {
                //$scope.filteredCheck[parent][option] = option;
                $scope.filtered[parent].push(option);
                $scope.filters.push(option);
            }
            if ($scope.filtered[parent].length <= 0)
                delete $scope.filtered[parent];
        }

        // $scope.sel = jQuery("select.orderby").val();

        $http.get(domain + "/get-product-listing?", {
            params: {
                'filters': $scope.filtered,
                'minp': $scope.minp,
                'maxp': $scope.maxp,
                'slug': $scope.getslug(),
                'sort': $scope.sel,
                'searchTerm': $scope.searchTerm
            }
        }).success(function (data) {
            // console.log("pradeep" +data.currency_val);
            $scope.pdts = data.prods.data;
            //  $scope.currencyVal = data.currency_val;
            $scope.nextpageurl = data.prods.next_page_url;
            store({'maxp': $scope.maxp, 'minp': $scope.minp, 'sort': $scope.sel, 'filtered': JSON.stringify($scope.filtered), 'filters': JSON.stringify($scope.filters)});
            setTimeout(function () {
                $('.currency-sym').html('').html(data.curData.sym);
                $('.currency-sym-in-braces').html('').html("(" + data.curData.sym + ")");
            }, 300);
            $scope.$digest;
        });
    };
    $scope.getPreFilters = function (filterId) {

        if ($scope.filters.indexOf(filterId) > -1)
            return 1;
        else
            return 0;
    };

    // filters function for select filter optopn like low-to high-price ,high-to low price ,popularity etc...
    $scope.applyFilters = function () {
        var currencyVal = localStorage.getItem('currency_val');
        $scope.minp = jQuery("#min_price").val();
        $scope.maxp = jQuery("#max_price").val();
        $http.get(domain + "/get-product-listing", {
            params: {
                'filters': $scope.filtered,
                'minp': $scope.minp,
                'maxp': $scope.maxp,
                'slug': $scope.getslug(),
                'sort': $scope.sel,
                'searchTerm': $scope.searchTerm
                        //  'userId': (window.localStorage.getItem('id') != null ? window.localStorage.getItem('id') : "")
            }
        }).success(function (response) {

            $scope.pdts = response.prods.data;
            $scope.nextpageurl = response.prods.next_page_url;
            $scope.$digest;
            store({'maxp': $scope.maxp, 'minp': $scope.minp, 'sort': $scope.sel, 'filtered': JSON.stringify($scope.filtered), 'filters': JSON.stringify($scope.filters)});
            setTimeout(function () {
                $('.currency-sym').html('').html(response.curData.sym);
                $('.currency-sym-in-braces').html('').html("(" + response.curData.sym + ")");
                var currentCurrency = response.data.curData.curval;
//                $(".priceConvert").each(function (k, v) {
//                    var filterNumber = $(this).text().trim();
//                    filterNumber = filterNumber.replace(",", "");
//                    var getPrice = parseFloat(filterNumber);
//                    var calCulate = (getPrice * currentCurrency).toFixed(2)
//                    $(this).text(calCulate);
//                })
//
//                $(".priceConvertTextBox").each(function (k, v) {
//                    var getPrice = $(this).val();
//                    getPrice = getPrice.replace(",", "");
//                    getPrice = parseFloat($(this).val());
//                    if (isNaN(getPrice)) {
//                        var getPrice = " ";
//                    } else {
//                        var calCulate = (getPrice * currentCurrency).toFixed(2);
//                        $(this).attr("value", calCulate);
//                    }
//                    var getName = $(this).attr("name");
//                    $(this).parent().append("<input type='hidden' name='" + getName + "' class='priceConvertTextBoxMain' value='" + getPrice + "' > ");
//                    $(this).attr("name", "not_in_use");
//                });
            }, 300);
        });
    };
    var historyPush = function (pageurl) {
        var pageurl = pageurl;
        window.history.pushState({path: pageurl}, '', pageurl);
    }
    $scope.selAttrChange = function (selOpt, selid, getnext) {
        console.log(selOpt + ", " + selid + ", " + getnext);
        $scope.selprods = [];
        $scope.subProd = [];
        $scope.allSubProds = [];
        console.log($scope.suprodarr.length + " subprod length " + $scope.suprodarr[0]);
        if (($scope.suprodarr.length > 0) && (getnext == 1) && (($('#selID' + (getnext - 1)).val()) !== $scope.suprodarr[0])) {
            console.log($scope.suprodarr[0]);
            $scope.suprodarr = [];
            $scope.suprodarrId = [];
            $('.subPRod').val('');
        }
        $scope.suprodarr.push(selOpt);
        $scope.suprodarrId.push(selid);
        $("selID" + getnext).removeClass("ng-hide");
        var mySel = angular.element(document.querySelector('#selAT'));
        $("#selID" + getnext).remove();
        $scope.sel = [];
        $scope.getsel = "";
        $.each($scope.selAttributes, function (k, v) {
            $scope.sel.push({id: k, opt: v});
        });
        $scope.reqSubPrd = [];
        $scope.newOpt = [];
        if ($scope.sel[getnext]) {
            $.each($scope.selAttributes[selid]['attrs'][selOpt]['prods'], function (Valk, ValV) {
                $scope.selprods.push(ValV);
            });

            console.log("====2 " + JSON.stringify($scope.sel[getnext]));
            $.each($scope.sel[getnext], function (chk, ckv) {
                if (chk == 'opt') {
                    $.each(ckv['attrs'], function (getattK, getattV) {
                        $.map($scope.selprods, function (a) {
                            return $.inArray(a, getattV['prods']) < 0 ? null : $scope.newOpt.push(getattK);
                        });
                        $.map($scope.selprods, function (a) {
                            return $.inArray(a, getattV['prods']) < 0 ? null : $scope.reqSubPrd.push(a);
                        });
                    });
                }
            });
        } else {
            for (var i = getnext; i > 0; i--) {
                var optn = $scope.suprodarr[(i - 1)];
                if ((i - 1) == (getnext - 1)) {
                    $scope.subProd.push($scope.selAttributes[selid].attrs[selOpt].prods);
                } else {
                    $scope.subProd.push($scope.selAttributes[$scope.suprodarrId[(i - 1)]].attrs[optn].prods);
                }
            }
        }
        $.unique($scope.newOpt);
        if ($scope.sel[getnext]) {
            nextindex = getnext + 1;
            $scope.getsel += "<select  id='selID" + getnext + "'  class='selatts' ng-init='modelName = selaTT" + $scope.sel[getnext].id + "' ng-model='modelName' ng-change='selAttrChange(modelName," + $scope.sel[getnext].id + "," + nextindex + ")'>";
            $scope.getsel += "<option value=''>" + $scope.sel[getnext].opt.placeholder + "</option>";
            $scope.newoptions = [];
            $.each($scope.newOpt, function (newK, newV) {
                var object = {};
                object[newV] = $scope.sel[getnext].opt.options[newV];
                $scope.newoptions.push(object);
            });
            $.each($scope.newoptions, function (opk, opv) {
                $.each(opv, function (optk, optv) {
                    $scope.getsel += "<option  value='" + (optk) + "'>" + optv + "</option>";
                });
            });
            $scope.getsel += "</select>";
            var newSel = $compile($scope.getsel)($scope);
            mySel.append(newSel);
        } else {
            $scope.allSubProds = $scope.subProd;
            var subprodId = $scope.allSubProds.shift().filter(function (v) {
                return $scope.allSubProds.every(function (a) {
                    return a.indexOf(v) !== -1;
                });
            });
            console.log("Sub prod " + subprodId);
            $('.subPRod').val(subprodId);
            if ($scope.product.is_stock == 1) {
                if (subprodId) {
                    $http.post(domain + "/check-stock", {prodId: subprodId}).then(function (response) {
                        //    console.log("product" +JSON.stringify(response.data));
                        //  alert(JSON.stringify(response.data.product.price));
                        if (response.data.product.stock != 0 && response.data.stockLimit >= response.data.product.stock) {
                            $scope.product.selling_price = 0;

                            $(".span2").removeClass("hide");
                            $(".span2").empty();
                            var price = parseInt($(".parent_price").val());

                            // console.log("iff "+$scope.product.price);
                            $(".span2").append("STOCK LEFT : " + response.data.product.stock);
                            //  $(".mrp_price").empty();
                            if ($scope.product.spl_price > 0 && $scope.product.spl_price < $scope.product.price) {
                                $scope.product.selling_price = (price + parseInt(response.data.product.price)).toFixed(2);
                            } else {
                                $scope.product.selling_price = (price + parseInt(response.data.product.price)).toFixed(2);
                            }
                            //  $(".mrp_price").append((price+parseInt(response.data.product.price)).toFixed(2));
                            //  $('#quantity').attr('max', response.data.stock);
                        } else if (response.data.product.stock == 0) {
                            //  $(".span2").addClass("hide");  
                            $(".span2").empty();
                            $(".span2").append("Out Of Stock ");
                        } else {
                            var price = parseInt($(".parent_price").val());
                            if ($scope.product.spl_price > 0 && $scope.product.spl_price < $scope.product.price) {
                                $scope.product.selling_price = (price + parseInt(response.data.product.price)).toFixed(2);
                            } else {
                                $scope.product.selling_price = (price + parseInt(response.data.product.price)).toFixed(2);
                            }

                            // $(".mrp_price").empty();
                            // console.log("else "+$scope.product.price);
                            // $(".mrp_price").append((price+parseInt(response.data.product.price)).toFixed(2));
                            $(".span2").addClass("hide");
                        }

                    });
                }
            }
        }
    };
    $scope.quickLook = function ($slug) {
        slug = $slug;
        $http.get(domain + "/get-config-prod", {
            params: {
                'slug': slug

            }}).then(function (response) {
            //   $scope.$apply(function () {
            //  console.log(response.data.product);
            $scope.product = response.data.product;
            $scope.selAttributes = response.data.selAttrs;
            $scope.proDesc = $scope.product.shortDesc;
            $scope.stocklimit = response.data.stocklimit;
            // alert("asdf");
            $("#product_viewtest").modal('show');
            //    });

        });

    }


    var prodListing = function () {
        $scope.slug = $scope.getslug();
        console.log("product listing");
        if (get("filtered") != null || get("minp") != null || get("maxp") != null) {
            $scope.filtered = (get("filtered")) ? get("filtered") : {};
            $scope.filters = (get("filters")) ? get("filters") : [];
            if (!(jQuery.isEmptyObject($scope.filtered))) {
                $scope.filtered = JSON.parse($scope.filtered);
                $scope.filters = JSON.parse($scope.filters);
            }
            var currencyVal = localStorage.getItem('currency_val');
            //$scope.filters = $scope.filters;
            $scope.minp = (get("minp")) ? get("minp") : jQuery("#min_price").val();
            $scope.maxp = (get("maxp")) ? get("maxp") : jQuery("#max_price").val();
            $scope.sort = (get("sort")) ? get("sort") : jQuery("select.orderby").val();
            console.log("Filter Applied");
            $http.get(domain + "/get-product-listing", {
                params: {
                    'filters': $scope.filtered,
                    'slug': $scope.slug,
                    'minp': $scope.minp,
                    'maxp': $scope.maxp,
                    'sort': $scope.sel,
                    'searchTerm': $scope.searchTerm
                }}).then(function (response) {
                jQuery.each(response.data.prods.data, function (k, v) {
                    $scope.pdts.push(v);
                });
                $scope.nextpageurl = response.data.prods.next_page_url;
                $scope.getfilters = response.data.getfilters;
                $scope.currencyVal = response.data.currency_val;
                $scope.catChild = response.data.catChild;
                $scope.cat = response.data.cat;
                $scope.breadcrumbs = response.data.breadcrumbs;
                newurl = "";
                newurl = "";
                historyPush($location.absUrl());
                setTimeout(function () {
                    $('.currency-sym').html('').html(response.data.curData.sym);
                    $('.currency-sym-in-braces').html('').html("(" + response.data.curData.sym + ")");
                    var currentCurrency = response.data.curData.curval;
//                    $(".priceConvert").each(function (k, v) {
//                        var filterNumber = $(this).text().trim();
//                        filterNumber = filterNumber.replace(",", "");
//                        var getPrice = parseFloat(filterNumber);
//                        var calCulate = (getPrice * currentCurrency).toFixed(2)
//                        $(this).text(calCulate);
//                    })
//
//                    $(".priceConvertTextBox").each(function (k, v) {
//                        var getPrice = $(this).val();
//                        getPrice = getPrice.replace(",", "");
//                        getPrice = parseFloat($(this).val());
//                        if (isNaN(getPrice)) {
//                            var getPrice = " ";
//                        } else {
//                            var calCulate = (getPrice * currentCurrency).toFixed(2);
//                            $(this).attr("value", calCulate);
//                        }
//                        var getName = $(this).attr("name");
//                        $(this).parent().append("<input type='hidden' name='" + getName + "' class='priceConvertTextBoxMain' value='" + getPrice + "' > ");
//                        $(this).attr("name", "not_in_use");
//                    });
                }, 1000);
            });
        } else {
            console.log("Without Filter");
            $http.get(domain + "/get-product-listing", {
                params: {
                    'slug': $scope.slug,
                    'searchTerm': $scope.searchTerm
                }}).then(function (response) {
                //console.log(response.config.url);
                //console.log(JSON.stringify(response));
                //$scope.pdts = response.data.prods.data;
                jQuery.each(response.data.prods.data, function (k, v) {
                    $scope.pdts.push(v);
                });
                // console.log("Without Filter currency val"+response.data.currency_val);
                console.log("Initial " + $scope.pdts + " ==== " + response.data.maxp);
                $scope.nextpageurl = response.data.prods.next_page_url;
                $scope.getfilters = response.data.getfilters;
                $scope.catChild = response.data.catChild; //tej code
                $scope.cat = response.data.cat;
                $scope.minp = $scope.minp;
                $scope.maxp = response.data.maxp;
                newurl = "";
                newurl = "";
                $scope.currencyVal = response.data.currency_val;
                console.log(response.data.maxp);
                historyPush($location.absUrl());
                setTimeout(function () {
                    $('.currency-sym').html('').html(response.data.curData.sym);
                    $('.currency-sym-in-braces').html('').html("(" + response.data.curData.sym + ")");
                    var currentCurrency = response.data.curData.curval;
//                    $(".priceConvert").each(function (k, v) {
//                        var filterNumber = $(this).text().trim();
//                        filterNumber = filterNumber.replace(",", "");
//                        var getPrice = parseFloat(filterNumber);
//                        var calCulate = (getPrice * currentCurrency).toFixed(2)
//                        $(this).text(calCulate);
//                    })
//
//                    $(".priceConvertTextBox").each(function (k, v) {
//                        var getPrice = $(this).val();
//                        getPrice = getPrice.replace(",", "");
//                        getPrice = parseFloat($(this).val());
//                        if (isNaN(getPrice)) {
//                            var getPrice = " ";
//                        } else {
//                            var calCulate = (getPrice * currentCurrency).toFixed(2);
//                            $(this).attr("value", calCulate);
//                        }
//                        var getName = $(this).attr("name");
//                        $(this).parent().append("<input type='hidden' name='" + getName + "' class='priceConvertTextBoxMain' value='" + getPrice + "' > ");
//                        $(this).attr("name", "not_in_use");
//                    });
                }, 1000);
            });
        }
    };

//        if (angular.equals({}, $scope.filtered)) {
//            console.log("Null object");
//        }else{
//            $scope.filtered = JSON.parse($scope.filtered);
//        }
    $scope.getProduct = function (prod) {

        $('#product_viewtest').modal('show');

        // $('#product_viewtest').empty();
//      $http.get(domain + "/get-product-quickview", {
//                params: {
//                   
//                    'prod_id': prod,
//                    
//                }}).then(function (response) {
//                
//             
//                
//             $('#product_viewtest').append(response.data);   
//                           // console.log(JSON.stringify($scope.productData));
//                             $('#product_viewtest').modal('show');
//                });

    }
    $scope.quickpopup = function (ab) {
        // zoomify();
        console.log("in quickpopup" + ab);
        var _this = $('#' + ab)
        console.log(_this + 'test');
        $(_this).addClass('popup-open');
        var sync1 = $(_this).find('.p-preview .slider');
        var sync2 = $(_this).find('.thumb-slider');
        sync1.owlCarousel({
            singleItem: true,
            slideSpeed: 1000,
            navigation: false,
            pagination: false,
            afterAction: syncPosition,
            responsiveRefreshRate: 200,
        });
        sync2.owlCarousel({
            items: 4,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [979, 4],
            itemsTablet: [768, 4],
            itemsMobile: [479, 3],
            pagination: false,
            navigation: true,
            navigationText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            responsiveRefreshRate: 100,
            afterInit: function (el) {
                el.find(".owl-item").eq(0).addClass("synced");
            }
        });

        function syncPosition(el) {
            console.log("sync1");
            var current = this.currentItem;
            $(sync2)
                    .find(".owl-item")
                    .removeClass("synced")
                    .eq(current)
                    .addClass("synced")
            if ($(".slider-images").data("owlCarousel") !== undefined) {
                //console.log("inside cener");
                center(current)
            }
            ;
        }
        $(sync2).on("click", ".owl-item", function (e) {
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });

        function center(number) {
            console.log("center==");
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
            var num = number;
            var found = false;
            for (var i in sync2visible) {
                if (num === sync2visible[i]) {
                    var found = true;
                }
            }
            if (found === false) {
                if (num > sync2visible[sync2visible.length - 1]) {
                    sync2.trigger("owl.goTo", num - sync2visible.length + 2)
                } else {
                    if (num - 1 === -1) {
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if (num === sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", sync2visible[1])
            } else if (num === sync2visible[0]) {
                sync2.trigger("owl.goTo", num - 1)
            }
        }
        if ($('.quantity').length > 0) {
            console.log("sdf");
            var form_cart = $('form .quantity');
            form_cart.prepend('<span class="minus"><i class="fa fa-minus"></i></span>');
            form_cart.append('<span class="plus"><i class="fa fa-plus"></i></span>');

            var minus = form_cart.find($('.minus'));
            var plus = form_cart.find($('.plus'));

            minus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                if (qty.val() <= 1) {
                    qty.val(1);
                } else {
                    qty.val((parseInt(qty.val(), 10) - 1));
                }
            });
            plus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                qty.val((parseInt(qty.val(), 10) + 1));
            });
        }
    }
    $scope.popupclose = function (popupid) {
        console.log("===" + popupid);
        $("#quick" + popupid).removeClass('popup-open');
    };
    prodListing();
});

//newsletter
app.controller('myctrl', function ($scope, $window) {
    //$('#notify').prop('disabled',false );
    $scope.getemail = '';
    /*$scope.checkemail=function(){
     if ($scope.getemail != "")
     {
     
     $.ajax({
     url:"checkemail",
     type:'get',
     data:{email:$scope.getemail},
     dataType:'json',
     success: function(data){
     console.log(data);
     if(data >= "1")
     
     {
     $window.alert("Already Registered on website");
     $('#notify').prop('disabled',true );
     }
     }
     });
     
     }
     }*/

    $scope.doentry = function ()
    {
        $.ajax({
            url: "notification",
            type: 'get',
            data: {emailvalue: $scope.getemail},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data >= "1")
                {
                    $window.alert("Already Registered on website");
                } else
                    $window.alert("Check your mail");
            }
        });
    }
});

app.controller('quickAddToCartProduct', function ($scope, $window, $http, $location, $compile) {
    $scope.suprodarr = [];
    $scope.suprodarrId = [];
    var prod = 12;

    $http.get(domain + "/get-product-quickview", {
        params: {
            'prod_id': prod,
        }}).then(function (response) {
        console.log(response.data);
        $scope.quickAddProduct = response.data.product;
        $scope.currencyVal = response.data.currencyVal;
        $scope.allAttrsset = response.data.selAttrs;
        setTimeout(function () {
            $('.currency-sym').html('').html(response.data.curData.sym);
            $('.currency-sym-in-braces').html('').html("(" + response.data.curData.sym + ")");
        }, 1000);
        //  $('#product_viewtest').append(response.data);   
        //  console.log(JSON.stringify($scope.quickAddProduct));
        //  $('#product_viewtest').modal('show');
    });

    $scope.quickSelAttrChange = function (selOpt, selid, getnext, parent) {
        // console.log(price)
        //var price =parseInt(price)
        // alert(JSON.stringify($scope.allAttrsset[parent]));
        $scope.selprods = [];
        $scope.subProd = [];
        $scope.allSubProds = [];
        // console.log($scope.suprodarr.length + " subprod length " + $scope.suprodarr[0]);
        if (($scope.suprodarr.length > 0) && (getnext == 1) && (($('#selID' + parent + (getnext - 1)).val()) !== $scope.suprodarr[0])) {
            // alert($scope.suprodarr[0]);
            $scope.suprodarr = [];
            $scope.suprodarrId = [];
            $('.subPRod' + parent).val('');
        }
        $scope.suprodarr.push(selOpt);
        $scope.suprodarrId.push(selid);
        $("selID" + parent + getnext).removeClass("ng-hide");
        var mySel = angular.element(document.querySelector('#selAT' + parent));
        $("#selID" + parent + getnext).remove();
        $scope.sel = [];
        $scope.getsel = "";
        $.each($scope.allAttrsset[parent], function (k, v) {
            $scope.sel.push({id: k, opt: v});
        });
        $scope.reqSubPrd = [];
        $scope.newOpt = [];
        if ($scope.sel[getnext]) {
            $.each($scope.allAttrsset[parent][selid]['attrs'][selOpt]['prods'], function (Valk, ValV) {
                $scope.selprods.push(ValV);
            });

            console.log("====3 " + JSON.stringify($scope.sel[getnext]));
            $.each($scope.sel[getnext], function (chk, ckv) {
                if (chk == 'opt') {
                    $.each(ckv['attrs'], function (getattK, getattV) {
                        $.map($scope.selprods, function (a) {
                            return $.inArray(a, getattV['prods']) < 0 ? null : $scope.newOpt.push(getattK);
                        });
                        $.map($scope.selprods, function (a) {
                            return $.inArray(a, getattV['prods']) < 0 ? null : $scope.reqSubPrd.push(a);
                        });
                    });
                }
            });
        } else {
            for (var i = getnext; i > 0; i--) {
                var optn = $scope.suprodarr[(i - 1)];
                if ((i - 1) == (getnext - 1)) {
                    $scope.subProd.push($scope.allAttrsset[parent][selid].attrs[selOpt].prods);
                } else {
                    $scope.subProd.push($scope.allAttrsset[parent][$scope.suprodarrId[(i - 1)]].attrs[optn].prods);
                }
            }
        }
        $.unique($scope.newOpt);
        if ($scope.sel[getnext]) {
            console.log($scope.sel[getnext]);
            nextindex = getnext + 1;
            $scope.getsel += "<select  id='selID" + parent + getnext + "' name=" + $scope.sel[getnext].opt.name + "  class='selatts attrSel  form-control select-color-box' ng-init='modelName = selaTT" + $scope.sel[getnext].id + "' ng-model='modelName' ng-change='quickSelAttrChange(modelName," + $scope.sel[getnext].id + "," + nextindex + "," + parent + ")'>";
            $scope.getsel += "<option value=''>" + $scope.sel[getnext].opt.placeholder + "</option>";
            $scope.newoptions = [];
            $.each($scope.newOpt, function (newK, newV) {
                var object = {};
                object[newV] = $scope.sel[getnext].opt.options[newV];
                $scope.newoptions.push(object);
            });
            $.each($scope.newoptions, function (opk, opv) {
                $.each(opv, function (optk, optv) {
                    $scope.getsel += "<option  value='" + (optk) + "'>" + optv + "</option>";
                });
            });
            $scope.getsel += "</select>";
            var newSel = $compile($scope.getsel)($scope);
            mySel.parent().append(newSel);
            //console.log("test-- "+parent + "--" + (getnext - 1));
            $("#selID" + parent + (getnext - 1)).removeClass('error');
            $(".optError").hide();
        } else {
            $scope.allSubProds = $scope.subProd;
            //alert(JSON.stringify($scope.allSubProds));
            var subprodId = $scope.allSubProds.shift().filter(function (v) {
                return $scope.allSubProds.every(function (a) {
                    return a.indexOf(v) !== -1;
                });
            });
            console.log("Sub prod " + subprodId);
            //  alert(subprodId);
            $('.subPRod' + parent).val(subprodId);
            // console.log("parent " + parent + (getnext -1));
            //     if ($scope.product.is_stock == 1) {
            if (subprodId) {
                $http.post(domain + "/check-stock", {prodId: subprodId}).then(function (response) {
                    //  console.log("product" + JSON.stringify(response.data));
                    //  alert(JSON.stringify(response.data.product.price));
                    if (response.data.product.stock != 0 && response.data.stockLimit >= response.data.product.stock) {
                        $(".span" + parent).removeClass("hide");
                        $(".span" + parent).empty();
                        var price = parseInt($(".parent_price" + parent).val());

                        $(".span" + parent).append("STOCK LEFT : " + response.data.product.stock);
                        $(".mrp_price" + parent).empty();
                        $('.quantity' + parent).attr('max', response.data.stock);
                        $(".mrp_price" + parent).append((price + parseInt(response.data.product.price)).toFixed(2));
                        //  $('#quantity').attr('max', response.data.stock);
                    } else if (response.data.product.stock == 0) {
                        //  $(".span2").addClass("hide");  
                        $(".span" + parent).empty();
                        $(".span" + parent).append("Out Of Stock ");
                    } else {
                        var price = parseInt($(".parent_price" + parent).val());
                        // var price=parseInt($(".parent_price").val());
                        $(".mrp_price" + parent).empty();
                        $('.quantity' + parent).attr('max', response.data.stock);
                        $(".mrp_price" + parent).append((price + parseInt(response.data.product.price)).toFixed(2));
                        $(".span" + parent).addClass("hide");
                    }

                });
                $("#selID" + parent + (getnext - 1)).removeClass('error');
                $(".optError").hide();
            }
            //   }

        }
    }
});


app.controller('giftcouponcntrl', function ($scope, $window) {
    //var url=window.location.href;
    var reset = $("#giftcoupon_code").val();
    var couponprice = $("#couponUsedAmount").text();
    var netcost = $("#amountfinalAmt").text();
    //var reset =angular.copy($scope.giftcoupon_code);
    $scope.sendcouponcode = function () {
        var couponcode = $("#giftcoupon_code").val();
        //console.log(couponcode);
        var cost = $("#amountallSubtotal").text();
        $.ajax({
            url: "verifygiftcoupon",
            type: 'post',
            data: {couponcode: couponcode, cost: cost},
            datatype: 'json',
            success: function (data) {
                if (data === '0')
                {
                    $window.alert("Not a valid coupon code");
                }

                if (data === '1')
                {
                    $window.alert('Your coupon has expired');
                }

                if (data === '2')
                {
                    $window.alert('Not Allowed');
                }

                if (data === '3')
                {
                    $window.alert('Please login');
                }
                $("#giftcoupon_code").val(reset);
                if (data.length > 1)
                {
                    for (var i = 0; i < data.length; i++)
                    {
                        var amount = data[0];
                        var valid = data[1];
                    }

                    var diff = $("#amountallSubtotal").text() - amount;
                    if (diff >= '0')
                    {
                        var coupon_amount = amount;
                        //$("#giftcoupon").hide();
                        //$("#Isvisible").show();  
                        $("#amountfinalAmt").html(diff);
                        $("#couponUsedAmount").html(coupon_amount);
                        window.location.href = domain + "/cart";
                    }
                    if (diff < '0')
                    {
                        var res = confirm('Selected item cost must be greater or equal than coupon price');

                        if (res === true)
                        {
                            $("#giftcoupon_code").val(reset);
                            $("#couponUsedAmount").html(couponprice);
                        }
                    }

                }

            }
        });
    }

    $scope.resetall = function ()
    {
        $.ajax({
            url: "erasegiftcoupon",
            type: 'post',
            datatype: 'json',
            success: function (data) {
                if (data === '1')
                {
                    window.location.href = domain + "/cart";
                }
            }
        });
    };
});

app.controller('configMyAccountController', function ($scope, $window, $http, $location, $compile) {
    $scope.suprodarr = [];
    $scope.suprodarrId = [];
    var prod = 12;

    $scope.getProducts = function (orderData) {
        console.log(orderData);


    }
    $http.get(domain + "/get-product-quickview", {
        params: {
            'prod_id': prod,
        }}).then(function (response) {

        $scope.quickAddProduct = response.data.product;
        $scope.allAttrsset = response.data.selAttrs;

        //     $('#product_viewtest').append(response.data);   
        //   console.log(JSON.stringify($scope.quickAddProduct));
//                             $('#product_viewtest').modal('show');
    });
});