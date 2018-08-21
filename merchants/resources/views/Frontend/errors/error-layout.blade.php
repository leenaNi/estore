<!DOCTYPE html>
<html dir="ltr" lang="en-US" ng-app="app">

    @include('Frontend.includes.head')
 
    @yield('mystyles')
       
    <body class="stretched">
      
        <!-- Document Wrapper
              ============================================= -->
        <div id="wrapper" class="clearfix">
           
            @yield('content')
            
            <!-- #wrapper end -->
            @include('Frontend.includes.foot')
            @yield('myscripts')
    </body>

</html>
