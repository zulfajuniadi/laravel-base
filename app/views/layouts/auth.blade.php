<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @yield('meta')
    <title>App Name</title>
    <link rel="stylesheet" href="/assets/login.less">
    @yield('styles')
</head>
<body>
    <div class="container">
        <br>
        @include('partials.notification')
        @yield('content')
        @yield('scripts')
    </div>
</body>
</html>
