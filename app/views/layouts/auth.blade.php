<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>App Name {{isset($controller) ? '| ' . $controller : '' }}</title>
  {{stylesheet_link_tag('auth')}}
</head>
<body>
  <div class="container">
    <br>
    @include('partials.notification')
    @yield('content')
    {{javascript_include_tag('auth')}}
  </div>
</body>
</html>