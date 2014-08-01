<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>App Name {{isset($controller) ? '| ' . $controller : '' }}</title>
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('app/css/style.css') }}">
  @yield('styles')
</head>
<body>
  <div class="container">
    <br>
    <div class="row">
      <div class="col-sm-2">
        @include('partials.menu')
      </div>
      <div class="col-sm-10">
        @include('partials.notification')
        @yield('content')
      </div>
    </div>
  </div>
  <script src="{{asset('/assets/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('/assets/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('/assets/bootbox/bootbox.js')}}"></script>
  <script src="{{asset('/app/js/script.js')}}"></script>
  @yield('scripts')
</body>
</html>