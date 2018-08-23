<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Veestores" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="@yield('meta-description')">
<meta name="og:image" content="@yield('og:image')">
<!--<meta property="og:image" content="http://cartini.cruxservers.in/public/Admin/uploads/layout/20180131131939.jpg"/>-->
<link rel="stylesheet" href="{{ Config('constants.frontendThemeCssCommonPath').'/style.css' }}" type="text/css" />	
<link rel="stylesheet" href="{{ Config('constants.frontendThemeCssCommonPath').'/responsive.css' }}" type="text/css" />
@if(config('app.active_theme'))
<link rel="stylesheet" href="{{ Config('constants.frontendThemeCssPath').'/'.config('app.active_theme').'style.css' }}" type="text/css" />
@if(strtolower(config('app.active_theme')) =='rs1_' || strtolower(config('app.active_theme')) =='fs3_')
@if(Route::currentRouteName()!='home')
<link rel="stylesheet" href="{{ Config('constants.frontendThemeCssPath').'/'.config('app.active_theme').'style_inner.css' }}" type="text/css" />
@endif
@endif
@endif
<title>{{App\Library\Helper::getSettings()['storeName']}}  @yield('title')</title>
<link rel="icon" type="image/png" href="{{ Config('constants.frontendThemeImagePath').'/favicon.png' }}">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
<link rel="stylesheet" href="{{Config('constants.adminDistCssPath').'/bootstrap-select.css' }}">
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>

