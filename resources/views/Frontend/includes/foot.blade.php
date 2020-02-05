
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
$("body select").msDropDown();
} catch(e) {
alert(e.message);
}
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