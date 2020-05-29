
  <!-- JavaScript Libraries -->

  <script src="{{ asset('public/Frontend/js/easing.min.js')}}"></script>
  <script src="{{ asset('public/Frontend/js/mobile-nav.js')}}"></script>
  <script src="{{ asset('public/Frontend/js/owl.carousel.min.js')}}"></script>

  <!-- Template Main Javascript File -->
  <script src="{{ asset('public/Frontend/js/main.js')}}"></script>
  <script src="{{ asset('public/Frontend/js/jquery.dd.min.js')}}"></script>
<script language="javascript">
$(document).ready(function(e) {
	try {
	$("body select#country_code").msDropDown();
	} catch(e) {
	alert(e.message);
	}

jQuery(window).load(function() {
        // will first fade out the loading animation
    	// jQuery("#status").fadeOut();
        // will fade out the whole DIV that covers the website.
    		jQuery("#preloader").delay(100).fadeOut('slow', function() {
                $(this).remove();
            });
	})
});

</script>

  <script>

    jQuery(document).ready(function($) {
        		"use strict";
        		//  TESTIMONIALS CAROUSEL HOOK
		        $('#screen-testimonials').owlCarousel({
		            loop: true,
		            center: true,
		            items: 2,
		            margin: 0,
		            autoplay: true,
		            dots:false,
                // nav:true,
		            autoplayTimeout: 8500,
		            smartSpeed: 450,
		            responsive: {
		              0: {
		                items: 1
		              },
		              768: {
		                items: 2
		              },
		              1170: {
		                items: 2
		              }
		            }
		        });
        	});
  </script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106944065-9"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'UA-106944065-9');
</script>

<!--Start of Zendesk Chat Script-->
<!-- <script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?5pJbEGEoZtWR1KmVOcuBvtRB6XLX6qKI";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script> -->
<!--End of Zendesk Chat Script-->


<script>
    grecaptcha.ready(function () {
        grecaptcha.execute("{{env('GOOGLE_RECAPTCHA_KEY')}}", { action: 'contact' }).then(function (token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
</script>
