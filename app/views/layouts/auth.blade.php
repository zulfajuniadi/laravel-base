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
    <br>
    @include('partials.notification')
    @yield('content')
  </div>
  <script src="{{asset('/assets/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('/assets/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  @yield('scripts')
</body>
</html>