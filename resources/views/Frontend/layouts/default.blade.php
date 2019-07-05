<!DOCTYPE html>
<html lang="en-US" ng-app="app">
    <head>
        @include('Frontend.includes.head')
        @yield('mystyles')
    </head>
    <body>
        <div id="preloader">
          <div id="status"></div>
        </div>
        <div class="">
            <div id="wrapper" class="shop">
                <div class="w1">
                    @include('Frontend.includes.header')
                    
                    @yield('content')
                    
                    @include('Frontend.includes.footer')
                    
                    @include('Frontend.includes.foot')
                    
                    @yield('myscripts')
                </div>
            </div>
        </div>


    </body>
</html>