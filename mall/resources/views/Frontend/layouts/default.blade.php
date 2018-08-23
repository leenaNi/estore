
<!DOCTYPE html>
<html dir="ltr" lang="en-US" ng-app="app">

    @include('Frontend.includes.head')
 
    @yield('mystyles')
       
    <body class="stretched">
      
        <!-- Document Wrapper
              ============================================= -->
        <div id="wrapper" class="clearfix">
            @include('Frontend.includes.'.config('app.active_theme').'header')
            @yield('content')
            @include('Frontend.includes.'.config('app.active_theme').'footer')
            <!-- #wrapper end -->
            @include('Frontend.includes.foot')
            @yield('myscripts')
    </body>

</html>