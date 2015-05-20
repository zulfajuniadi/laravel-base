<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{csrf_token()}}">
        @yield('meta')
        <title>{{Config::get('app.name')}}</title>
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
                    {{Breadcrumbs::render()}}
                    @include('partials.notification')
                    @yield('content')
                </div>
            </div>
        </div>
        </div>
        {{Asset::tags('js')}}
        @yield('scripts')
        @if(App::environment('local'))
        <script type="text/javascript">document.write('<script src="' + (location.protocol || 'http:') + '//' + (location.hostname || 'localhost') + ':35729/livereload.js?snipver=1" type="text/javascript"><\/script>')</script>
        @endif
    </body>
</html>
