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
                
                @if(Route::currentRouteName() != 'newstore' && Route::currentRouteName() != 'waitProcess' && Route::currentRouteName() != 'getcongrats')
                    @include('Frontend.includes.header')  
                @endif 
                    @yield('content')
                @if(Route::currentRouteName() != 'newstore' && Route::currentRouteName() != 'waitProcess' && Route::currentRouteName() != 'getcongrats')
                    @include('Frontend.includes.footer')
                @endif    
                    @include('Frontend.includes.foot')
                    
                    @yield('myscripts')
                </div>
            </div>
        </div>


    </body>
</html>