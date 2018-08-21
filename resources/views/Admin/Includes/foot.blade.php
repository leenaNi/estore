<script src="{{ asset(Config('constants.AdminPluginPath').'jQuery/jquery-2.2.3.min.js') }}"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset(Config('constants.AdminDistJsPath').'jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset(Config('constants.AdminBootstrapJsPath').'bootstrap.min.js') }}"></script>


<!-- jQuery Knob Chart -->
<!-- daterangepicker -->
<script src="{{ asset(Config('constants.AdminDistJsPath').'moment.min.js') }}"></script> 
<script src="{{ asset(Config('constants.AdminPluginPath').'daterangepicker/daterangepicker.js') }}"></script>
<!-- ColorPicker -->
<script src="{{ asset(Config('constants.AdminDistJsPath').'jscolor.js') }}"></script>

<!-- datepicker -->
<script src="{{ asset(Config('constants.AdminPluginPath').'datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset(Config('constants.AdminPluginPath').'bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset(Config('constants.AdminPluginPath').'slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset(Config('constants.AdminPluginPath').'fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset(Config('constants.AdminDistJsPath').'app.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->



<script src="{{ asset(Config('constants.AdminDistJsPath').'pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset(Config('constants.AdminDistJsPath').'demo.js') }}"></script>


<script src="{{ asset(Config('constants.AdminDistJsPath').'jquery.validationEngine.js') }}"></script>
<script src="{{ asset(Config('constants.AdminDistJsPath').'jquery.validationEngine-en.js') }}"></script>

<!--<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>-->
<script src="{{ asset(Config('constants.AdminDistJsPath').'jquery.validate.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
    $("form").validationEngine();
   
//    jQuery.validator.addMethod("phone", function(phone_number, element) {
//            phone_number = phone_number.replace(/\s+/g, "");
//            return this.optional(element) || phone_number.length > 4 &&
//                    phone_number.match(/^[\d\-\+\s/\,]+$/);
//        }, "Please specify a valid phone number");

jQuery.validator.addMethod("phone", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 4 &&
                phone_number.match(/^[\d\-\+\s/\,]+$/);
    }, "Please specify a valid phone number");
    

            
var lang = <?= $langs ?>;
var userLang = '<?= @strtolower(App\Library\Helper::getSettings()->store_language->name); ?>';

$( window ).load(function() {
    if(userLang != 'english')
    {
      $.each(lang, function (key, val) {
         $('body :not(script)').contents().filter(function () {
             return this.nodeType === 3;
         }).replaceWith(function () {
             return this.nodeValue.replace(val.english, val[userLang]);
         });

     });  
    }     
 });
@if (!empty($_REQUEST['lang']))
 var selectedLang = '<?= $_REQUEST['lang'] ?>';
 $(document).ready(function () {
    if(selectedLang != 'english')
    {
        $.each(lang, function (key, val) {
            $('body :not(script)').contents().filter(function () {
                return this.nodeType === 3;
            }).replaceWith(function () {
                return this.nodeValue.replace(val.english, val[selectedLang]);
            });

        });
    }
 });
@endif

        function addParamToCurrentURL(param, value) {
        var currURL = window.location.href;
        if (currURL.indexOf("?") !== -1) {
            if (currURL.indexOf(param) !== -1) {
            } else {
                window.history.replaceState('', '', currURL + '&' + param + '=' + value);
            }
        } else {
            if (currURL.indexOf("#") !== -1) {
                newurl = currURL.split("#");
                window.history.replaceState('', '', newurl[0] + '?' + param + '=' + value + '#' + newurl[1]);
            } else {
                window.history.replaceState('', '', currURL + '?' + param + '=' + value);
            }
            }
        }
</script>

<script>
    $("#bankGeneral").validate({
        rules: {
            name: {
                required: true
            },
            file: {
                extension: "zip"
              }
        },
        messages: {            
            name: {
                required: "Template Name is required."
            },
            file: {
                required: "Template File is required.",
                extension: "Please upload .zip file."
               
            }, screenshot: {
                required: "Screenshot is required."
            }           
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });
</script>