<!-- jQuery 2.1.4 -->
<script src="{{  Config('constants.adminPlugins').'/jQuery/jQuery-2.1.4.min.js' }}"></script>
<script src="{{ Config('constants.adminDistJsPath').'/jqueryui1.11.4.js' }}"></script>
<script src="{{ Config('constants.adminDistJsPath').'/jquery-ui-timepicker-addon.js' }}"></script>
<script src="{{ Config('constants.adminDistJsPath').'/jquery-ui.multidatespicker.js'}}"></script>
<script src="{{ Config('constants.adminDistJsPath').'/moment.js' }}"></script>
<script src="{{ Config('constants.adminDistJsPath').'/chosen.jquery.js' }}"></script>
<!-- Bootstrap 3.3.5 --><!--
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  -->
<script src="{{  Config('constants.adminBootstrapJsPath').'/bootstrap.min.js' }}"></script>
<!-- ColorPicker -->
<script src="{{ Config('constants.adminDistJsPath').'/jscolor.js' }}"></script>
<!--jquery validater -->
<script src="{{ Config('constants.adminDistJsPath').'/jquery.validate.min.js' }}"></script>
<!-- FastClick -->
<script src="{{ Config('constants.adminPlugins').'/fastclick/fastclick.min.js' }}"></script>
<!-- AdminLTE App -->
<script src="{{ Config('constants.adminDistJsPath').'/app.min.js' }}"></script>
<!-- Sparkline -->
<script src="{{ Config('constants.adminPlugins').'/sparkline/jquery.sparkline.min.js' }}"></script>
<!-- jvectormap -->
<script src="{{ Config('constants.adminPlugins').'/jvectormap/jquery-jvectormap-1.2.2.min.js' }}"></script>
<script src="{{ Config('constants.adminPlugins').'/jvectormap/jquery-jvectormap-world-mill-en.js' }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ Config('constants.adminPlugins').'/slimScroll/jquery.slimscroll.min.js' }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ Config('constants.adminPlugins').'/chartjs/Chart.min.js' }}"></script>
<script src="{{ Config('constants.adminPlugins').'/flot/jquery.flot.min.js' }}"></script>
<script src="{{ Config('constants.adminPlugins').'/flot/jquery.flot.resize.min.js' }}"></script>
<script src="{{ Config('constants.adminPlugins').'/flot/jquery.flot.pie.min.js' }}"></script>
<script src="{{ Config('constants.adminPlugins').'/flot/jquery.flot.categories.min.js' }}"></script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="{{ asset('public/Admin/dist/js/pages/dashboard2.js') }}"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="{{ Config('constants.adminDistJsPath').'/demo.js' }}"></script>

<script src="{{  Config('constants.adminPlugins').'/select2/select2.full.min.js' }}" type="text/javascript" charset="utf-8"></script>

<script src="{{ Config('constants.adminDistJsPath').'/bootstrap-select.js' }}"></script>

<script src="{{ Config('constants.adminDistJsPath').'/jquery.validationEngine-en.js' }}"></script>

<script src="{{ Config('constants.adminDistJsPath').'/jquery.validationEngine.js' }}"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>-->
<!-- ckEditor-->
<script src="{{ Config('constants.adminPlugins').'/ckeditor/ckeditor.js' }}"></script>

<script src="{{ Config('constants.adminPlugins').'/ckeditor/bootstrap3-wysihtml5.all.min.js' }}"></script>
<!--<script>
 $(function () {
   // Replace the <textarea id="editor1"> with a CKEditor
   // instance, using default configuration.
   CKEDITOR.replace('editor1');

   //bootstrap WYSIHTML5 - text editor
   $('.textarea').wysihtml5()
 })
</script>-->

<script type="text/javascript">
var currentCurrency = parseFloat(<?=Session::get('currency_val');?>);
var map = {63: false, 98: false, 121: false, 101: false, 97: false, 112: false, 99: false, 116: false, 117: false, 103: false, 104: false, 111: false, 115: false};
$(document).keypress(function (e) {
    if ($(e.target).prop("tagName") == 'BODY') {
        //console.log(e.currentTarget.activeElement);
        if (e.keyCode in map) {
            map[e.keyCode] = true;
            // open popup model
            if (e.keyCode == 63) {
                $('#shortcut-popup').modal('show');
            }
            if (map[98] && map[121] && e.keyCode == 101) {
                window.location.href = "<?php echo route('adminLogout'); ?>";
            }

            // Adding items to your store
            if (map[97] && e.keyCode == 112) {
                window.location.href = "<?php echo route('admin.products.add'); ?>";
            } else if (map[97] && e.keyCode == 99) {
                window.location.href = "<?php echo route('admin.category.add'); ?>";
            } else if (map[97] && e.keyCode == 116) {
                window.location.href = "<?php echo route('admin.tax.add'); ?>";
            } else if (map[97] && e.keyCode == 117) {
                window.location.href = "<?php echo route('admin.customers.add'); ?>";
            }

            //Navigating your admin panel
            if (map[103] && e.keyCode == 111) {
                window.location.href = "<?php echo route('admin.orders.view'); ?>";
            } else if (map[103] && e.keyCode == 104) {
                window.location.href = "<?php echo route('admin.home.view'); ?>";
            } else if (map[103] && e.keyCode == 112) {
                window.location.href = "<?php echo route('admin.products.view'); ?>";
            }
        }
    }
});</script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
<script type="text/javascript">
    $('.checkbox').on('click', 'input:checkbox', function () {
        if ($(this).is(':checked')) {
            $(this).parent().addClass('checkbox-highlight');
        } else {
            $(this).parent().removeClass('checkbox-highlight');
        }
    });
// to Instantiation validationEngine
    $(function () {
        // $("form").validationEngine();

        jQuery("form").validationEngine('attach', {
            scroll: false
        });
        getCur();
    });
    function validateFile(file) {

        var ext = file.split(".");
        ext = ext[ext.length - 1].toLowerCase();
        var arrayExtensions = ["csv", "xlml"];
        if (arrayExtensions.lastIndexOf(ext) == -1) {
            alert("Wrong extension type.");
            $(".fileUploder").val("");
        }
    }
    function getCur() {
        $.post("{{route('setCurrency')}}", {}, function (response) {
            console.log(response);
            $('.currency-sym').html('').html(response.sym);
            $('.currency-sym-in-braces').html('').html("(" + response.sym + ")");
            $('.currency-sym').html('').html(response.sym);
            currentCurrency = parseFloat(response.curval);
            console.log(currentCurrency);
            $(".priceConvert").each(function (k, v) {
                var filterNumber = $(this).text().trim();
                filterNumber = filterNumber.replace(",", "");
                var getPrice = parseFloat(filterNumber);
                var calCulate = (getPrice * currentCurrency).toFixed(2);
                console.log("PriceConvert", calCulate);
                $(this).text(calCulate);
            });

            $(".priceConvertTextBox").each(function (k, v) {
                var getPrice = $(this).val();
                getPrice = getPrice.replace(",", "");
                getPrice = parseFloat($(this).val());
                if (isNaN(getPrice)) {
                    var getPrice = " ";
                } else {
                    var calCulate = (getPrice * currentCurrency).toFixed(2);
                    console.log("PriceConvert", calCulate);
                    $(this).attr("value", calCulate);
                }
                var getName = $(this).attr("name");
                $(this).parent().append("<input type='hidden' name='" + getName + "' class='priceConvertTextBoxMain' value='" + getPrice + "' > ");
                $(this).attr("name", "not_in_use");
            });
        });
    }
</script>

<script  type="text/javascript">
    $(document).on("keyup", ".priceConvertTextBox", function () {
        var getPrice = $(this).val();
        getPrice = getPrice.replace(",", "");
        getPrice = parseFloat($(this).val());
        var calCulate = (getPrice / currentCurrency).toFixed(2)
        $(this).parent().find(".priceConvertTextBoxMain").val(calCulate);
    });
</script>

<script>
// vars
    var result = document.querySelector('.result'),
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
                        aspectRatio: 1.70,
                        dragMode: 'move',
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        zoom: -0.1,
                        built: function () {
                            $toCrop.cropper("setCropBoxData", {width: "170", height: "100"});
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
        // get result to data uri



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
                        width: 170 // input value
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



    });


    // declare variable
    var scrollTop = $("#go-to-top");

    $(window).scroll(function () {
        // declare variable
        var topPos = $(this).scrollTop();

        // if user scrolls down - show scroll to top button
        if (topPos > 100) {
            $(scrollTop).css("opacity", "1");

        } else {
            $(scrollTop).css("opacity", "0");
        }

    });

    $('#go-to-top').click(function () {
        $(window.opera ? 'html' : 'html, body').animate({
            scrollTop: 0
        }, 'slow');
    });
</script>

<script>
    $(document).ready(function () {
        $(".renewStore").on("click", function () {

            $("#renewModal").modal(
                    {backdrop: 'static',
                        keyboard: false});

            $.ajax({
                url: "{{ route('admin.generalSetting.storeVersion')}}",
                type: 'post',
                data: {version: 0, pagetype: 1},
                success: function (res) {
                    $('#chargesDetails').empty();
                    if (res.status == 2) {
                        var trackData = '<td>Advance<input type="hidden" id="storeV" name="store_version"  value="2"></td><td><span class="currency-sym">  </span><span class="priceConvert"> ' + res.charge + '</span><input type="hidden" name="store_charge" id="store_charge" value="' + res.charge + '"></td> ';
                        $('#chargesDetails').append(trackData);
//                        var vrsn = $('#storeV').val();
//                        $('#storerenewSubmit').attr("href", 'https://veestores.com/get-city-pay-renew/{{Session::get("store_id")}}/' + vrsn);
                    } else {
                        var trackData = ' <td><select name="store_version" id="storeV" class="form-control storeV"><option value="1">Starter</option><option value="2">Advance</option></select></td><td><span class="currency-sym"> </span><span class="priceConvert renewCharge">' + res.charge + '</span><input type="hidden" name="store_charge" id="store_charge" value="' + res.charge + '"></td> ';
                        $('#chargesDetails').append(trackData);
                    }
                }
            });
            getCur();
        });




        $('div#renewModal').on('click', '.storerenewSubmit', function (e) {
//            alert();
            e.preventDefault();
            var vrsn = $('#storeV').val();
            // window.open('https://192.168.2.47:8025/get-city-pay-renew/{{Crypt::encrypt(Session::get("store_id"))}}', '_blank', 'scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
//            window.open('https://veestores.com/get-city-pay-renew/{{Session::get("store_id")}}/' + vrsn, 'scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
            window.location.href = 'https://veestores.com/get-city-pay-renew/{{Session::get("store_id")}}/' + vrsn;
        });
    });
    $('div#renewModal').delegate('#storeV', 'change', function () {
        var version = $(this).val();
        $.ajax({
            url: "{{ route('admin.generalSetting.storeVersion')}}",
            type: 'post',
            data: {version: version, pagetype: 2},
            success: function (res) {
                //  alert(res);
                $('.renewCharge').text(parseFloat(res).toFixed(2));
                $('#store_charge').val(parseFloat(res).toFixed(2));
//                var vrsn = $('#storeV').val();
//                $('#storerenewSubmit').attr("href", 'https://veestores.com/get-city-pay-renew/{{Session::get("store_id")}}/' + vrsn);
            }
        });
        getCur();
    });

// Dropdown auto Position
    $(document).on("shown.bs.dropdown", ".dropdown", function () {
        // calculate the required sizes, spaces
        var $ul = $(this).children(".dropdown-menu");
        var $button = $(this).children(".dropdown-toggle");
        var ulOffset = $ul.offset();
        // how much space would be left on the top if the dropdown opened that direction
        var spaceUp = (ulOffset.top - $button.height() - $ul.height()) - $(window).scrollTop();
        // how much space is left at the bottom
        var spaceDown = $(window).scrollTop() + $(window).height() - (ulOffset.top + $ul.height());
        // switch to dropup only if there is no space at the bottom AND there is space at the top, or there isn't either but it would be still better fit
        if (spaceDown < 0 && (spaceUp >= 0 || spaceUp > spaceDown))
          $(this).addClass("dropup");
    }).on("hidden.bs.dropdown", ".dropdown", function() {
        // always reset after close
        $(this).removeClass("dropup");
    });

    function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("advanced-filter");
  var btnText = document.getElementById("advanced-filter-Btn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "<i class='fa fa-caret-down'></i> Advanced Filters";
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "<i class='fa fa-caret-up'></i> Advanced Filters";
    moreText.style.display = "inline";
  }
}

// File Uploade Placeholder
$(".file-upload-column").on("change", ".file-upload-field", function() {
  $(this)
    .parent(".file-upload-wrapper")
    .attr(
      "data-text",
      $(this)
        .val()
        .replace(/.*(\/|\\)/, "")
    );
});

// manage 2 div same height
$( document ).ready(function() {
    var s1 = $('.equal-height-div-1').height();
    var s2 = $('.equal-height-div-2').height();

    if (s1 > s2)
        $('.equal-height-div-2').css('height', s1 + "px");
    else
        $('.equal-height-div-1').css('height', s2 + "px");

});


(function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
	});
})(jQuery);

</script>