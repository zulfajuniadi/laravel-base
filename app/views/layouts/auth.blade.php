<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>App Name {{isset($controller) ? '| ' . $controller : '' }}</title>
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}">
  @yield('styles')
</head>
<body>
  <div class="container">
    @include('partials.notification')
    @yield('content')
  </div>
  @yield('scripts')
</body>
</html>