<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>{{Config::get('app.name')}}</title>
    <link rel="stylesheet" href="/assets/stylesheets/login.min.css">
    @yield('styles')
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <br>
        @include('partials.notification')
        @yield('content')
    </div>
    <script src="/assets/javascripts/login.min.js"></script>
    @yield('scripts')
    @if(App::environment('local'))
    <script type="text/javascript">document.write('<script src="' + (location.protocol || 'http:') + '//' + (location.hostname || 'localhost') + ':35729/livereload.js?snipver=1" type="text/javascript"><\/script>')</script>
    @endif
</body>
</html>
