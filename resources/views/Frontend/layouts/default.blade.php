<!DOCTYPE html>
<html lang="en-US" ng-app="app">
    <head>
    @if(Route::currentRouteName() != 'newstore' && Route::currentRouteName() != 'waitProcess' && Route::currentRouteName() != 'getcongrats')
        @if(Route::currentRouteName() == 'selectThemes')
            @if(!empty(Session::get('merchantid')) && Session::get('merchantstorecount') <= 0)
                @include('Frontend.includes.head')
            @else            
                @include('Frontend.includes.head-estorifi')
            @endif 
        @else
            @include('Frontend.includes.head-estorifi')     
        @endif
    @else
        @include('Frontend.includes.head')
    @endif
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
                    @if(Route::currentRouteName() == 'selectThemes')
                        @if(!empty(Session::get('merchantid')) && Session::get('merchantstorecount') <= 0)

                        @else
                            @include('Frontend.includes.header-estorifi')
                        @endif
                    @else
                        @include('Frontend.includes.header-estorifi')
                    @endif
                @else
                @endif

                @yield('content')
                @if(Route::currentRouteName() != 'newstore' && Route::currentRouteName() != 'waitProcess' && Route::currentRouteName() != 'getcongrats')
                    @if(Route::currentRouteName() == 'selectThemes')
                        @if(!empty(Session::get('merchantid')) && Session::get('merchantstorecount') <= 0)

                        @else
                            @include('Frontend.includes.footer-estorifi')
                        @endif
                    @else
                        @include('Frontend.includes.footer-estorifi')    
                    @endif
                @else    
                    
                @endif
                @if(Route::currentRouteName() != 'newstore' && Route::currentRouteName() != 'waitProcess' && Route::currentRouteName() != 'getcongrats')
                    @if(Route::currentRouteName() == 'selectThemes')
                        @if(!empty(Session::get('merchantid')) && Session::get('merchantstorecount') <= 0)
                            @include('Frontend.includes.foot')
                        @else            
                            @include('Frontend.includes.foot-estorifi')
                        @endif
                    @else
                        @include('Frontend.includes.foot-estorifi')      
                    @endif
                @else
                    @include('Frontend.includes.foot')
                @endif

                @yield('myscripts')
                </div>
            </div>
        </div>


    </body>
</html>
