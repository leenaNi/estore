@extends('Admin.errors.error-layout')
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
		.content-wrapper {
    margin: 0px;
    border: 0;
        margin-top: 50px;
}
footer.main-footer {
    margin-left: 60px;
    border-left: 0px;
    position: absolute;
    width: 95%;
    bottom: 0;
}

	</style>
@endsection

@section('content')
	<div class="container">
	<div class="content">
	<div class="error-page" style="margin-top: 0;">
		<h2 class="headline text-green" style="margin-top: -16px;"> 404 </h2>
		<div class="error-content">
			<h3><i class="fa fa-warning text-green"></i> Oops! Page not found.</h3>
			<p>Sorry,the page you are looking for could not be found.
			Meanwhile, you may <a href="{{ route('admin.dashboard') }}">return to home page</a>.</p>
		</div>
	</div>
	</div>
	</div>
@endsection