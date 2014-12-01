<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="_token" content="{{csrf_token()}}">
        @yield('meta')
        <title>App Name</title>
        {{Asset::tags('css')}}
        @yield('styles')
    </head>
    <body>
        @include('partials.navbar')
        <div class="row">
        <div class="container">
            <br>
            <div class="row">
                <div class="col-sm-12">
                    @include('partials.notification')
                    @yield('content')
                    @yield('scripts')
                </div>
            </div>
        </div>
        </div>
        {{Asset::tags('js')}}
        @yield('scripts')
    </body>
</html>
