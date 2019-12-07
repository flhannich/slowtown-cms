<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
    <title>@yield('title', 'Slowtown')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/icons/app/favicon.png') }}">

</head>
<body>

        <main id="site">
          @yield('content')
        </main>

    <script>
      window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user(),
        'api_token' => (Auth::user()) ? Auth::user()->api_token : null
        ]) !!};
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
