@extends('Frontend.errors.error-layout')
@section('mystyles')
	<style>
		html, body {
			height: 100%;
		}

		body {
			margin: 0;
			padding: 0;
			width: 100%;
			display: table;
			font-family: 'Lato';
		}

		.container {
			text-align: center;
			display: table-cell;
			vertical-align: middle;
		}

		.content {
			text-align: left;
			display: inline-block;
		}
		h1.bigfnt {
    color: #1ABC9C;
    font-size: 80px;
    font-weight: normal;
    font-family: sans-serif;
    margin-bottom: 0;
}
a.button {
    background-color: #1ABC9C !important;
}
.static-contain h6 {
    font-size: 18px;
    font-weight: normal;
    font-family: cursive;
}
.static-contain {
    margin-top: 80px;
}
	</style>
@stop
@section('content')

<!-- <div class="loader"></div> -->

 <!-- main-container -->
 <div class="main-container col2-right-layout abt-page notexit-page">
   <div class="main container bottom_margin_20">
     <div class="row">
       <section class="col-sm-12">
         <div class="col-main">
           <div class="static-contain">
             <h1 class="bigfnt">404</h1>
           <h6>Unfortunately, this page does not exist</h6>
           
             <div class="btn-404-box">
               <a  href="/" class="button">Go to Home</a>
               <a  href="/contact-us" class="button">Contact Us</a>
             </div>
           </div>
         </div>
       </section>
          
     </div>
   </div>
 </div>


@section('myscripts')

@stop