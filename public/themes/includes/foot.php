
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

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js"></script>
    <script>

        $(function() {
          $( "#slider-range" ).slider();
      });


        $(document).ready(function () {
            minP = 0;
            minp = 0;
            maxP =4000;
						maxp =4000;
            maxp = Math.ceil(maxp);
            console.log("fs1Min price => " + minp + "Max price => " + maxp);
//    setTimeout(sliderFun, 500);
//    var sliderFun = function(){
    setTimeout(function () {
        $('#slider-range').slider({
            range: true,
            min: minp,
            max: maxp,
            values: [minp, maxp],
            slide: function (event, ui) {

                $("input[name='min_price']").val(ui.values[0]);
                $("input[name='max_price']").val(ui.values[1]);
            }
        });
    }, 2000);
    $("input[name='min_price']").val(minp);
    $("input[name='max_price']").val(maxp);
    console.log("Min price => " + minp + "Max price => " + maxp);
                            // $("#min_price").val(minp);

                            //   $("#max_price").val(maxp);
                            //};
                        });
                    </script>
