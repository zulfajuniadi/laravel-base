<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>App Name {{isset($controller) ? '| ' . $controller : '' }}</title>
  {{stylesheet_link_tag($style_name)}}
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
  {{javascript_include_tag($script_name)}}
</body>
</html>