<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <title>@yield('title')</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    {!! file_get_contents(resource_path('views/auth/layouts/style.css')) !!}
  </style>
</head>

<body class="auth-body">
  @include('auth.layouts.sprinkles')
  @include('auth.layouts.strawberry')

  <div id="pageCard" class="auth-container">
    @yield('content')
  </div>

  @include('auth.layouts.script')
</body>
</html>
