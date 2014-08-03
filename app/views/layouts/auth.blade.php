<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  @yield('meta')
  <title>App Name {{isset($controller) ? '| ' . $controller : '' }}</title>
  {{stylesheet_link_tag('auth')}}
  @yield('styles')
</head>
<body>
  <div class="container">
    <br>
    @include('partials.notification')
    @yield('content')
    {{javascript_include_tag('auth')}}
    @yield('scripts')
  </div>
</body>
</html>