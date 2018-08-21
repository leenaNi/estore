
	<!-- Go To Top

	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/plugins.js"></script>	
	<script type="text/javascript" src="js/rangeslider.min.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<script type="text/javascript" src="js/jquery.elevatezoom.js"></script>
  <script type="text/javascript">
$(document).ready( function() {
$(".closeTheme").click( function() {
$('.applyTheme-stickyHeader').hide();
$('#header.transparent-header.full-header #header-wrap').css('top','0');
});
});

$('.applythemelink').click(function(){
  var marchantId=  $(this).attr("data-mId");
  var store="gupta-stores";
  jQuery.ajax({
    type: "POST",
    url: 'ajaxcall.php',
    dataType: 'json',
    data: {storeName:store},
    success: function (textstatus) {
               alert(textstatus);   
            }
});
 
});
</script>
	<script>
	$( document ).ready(function() {
    console.log( "ready!" );
	
		if($(window).width()<768){
			setTimeout(function(){
    $('.zoom-me').elevateZoom({
    zoomType: "inner",
	cursor: "crosshair",
zoomWindowFadeIn: 500,
zoomWindowFadeOut: 750
   }); 
	},1000)    
    }
    else{
     $('.zoom-me').elevateZoom();
    }
	

});
   
</script>
	<script type="text/javascript">

		$(document).ready(function () {

			$(".range_02").ionRangeSlider({
				min: 150,
				max: 10000,
				from: 3500,
            prefix: "Rs. ",
			});
			});
			</script>
