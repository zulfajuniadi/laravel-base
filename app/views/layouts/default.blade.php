<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>App Name {{isset($controller) ? '| ' . $controller : '' }}</title>
  @yield('styles')
</head>
<body>
  @yield('content')
  @yield('scripts')
</body>
</html>