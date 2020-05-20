@extends('Frontend.layouts.default')
@section('content')
<!--==========================
	    step1 Section starts
	  ============================-->
      <section class="settingup-section">
		<div class="vert-middle-container">
		<div class="container h-100">
	      	<div class="row">
		        <div class="col-md-5 intro-info">
					<div class="setup-img">
						<img src="{{ asset('public/Frontend/images/settings.svg')}}" alt=""> 
					</div>
		          	<h1>Setting up your Store</h1>
		          	<p>Now sit back and relax while your store <br/>
is being setup. </p>
		          	<div class="warning-text">
					  * Don’t hit the back button or try to refresh
					  </div>
					  <div class="progress-holder">
						<div class="progress">
							<div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<h2>60%</h2>
					  </div>
		        </div>
			</div>
		</div>
		</div>
	</section>
	<section class="settingup-section-img mob-disp">
		<img src="{{ asset('public/Frontend/images/bg-mobile.png')}}" class="img-responsive"/>
	</section>
	  <!--==========================
	      step1 Section ends
	    ============================-->
@stop
@section('myscripts')
<script>
    $(document).ready(function(){
        allinput = <?= $themeInput ?>;
        console.log("allinput >> "+JSON.stringify(allinput));
        //alert(" call ajax");
     $.ajax({
        type:"POST",
       // dataType:"json",
        data:{themeInput:allinput},
        url:"{{ route('congrats') }}",
        cache:false,
        success:function(data){
            console.log(data);
            if(data.status == 'success'){
                form = "";
                form += '<input type="hidden" name="id" value="'+data.id+'">';
            $('<form action="{{route("getcongrats")}}" method="POST">'+form+'</form>').appendTo('body').submit();
            }
        }
     });
    });

</script>
@stop