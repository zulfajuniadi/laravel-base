<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  @yield('meta')
  <title>App Name</title>
  {{Asset::tags('css')}}
  @yield('styles')
</head>
<body>
  <div class="container">
    <br>
    @include('partials.notification')
    @yield('content')
    {{Asset::tags('js')}}
    @yield('scripts')
  </div>
</body>
</html>