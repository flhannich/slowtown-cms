<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>@isset($item)@if(!is_null($item->subtitle)){{$item->subtitle}}@endif @else @isset($site->subtitle){{$site->subtitle}} @endisset @endisset</title>
    <meta property="og:title" itemprop="name" content="@isset($item)@if(!is_null($item->subtitle)){{$item->subtitle}}@endif @else @isset($site->subtitle){{$site->subtitle}} @endisset @endisset">
    {{-- <meta property="og:title" itemprop="name" content="@isset($item)@if(!is_null($item->title)){{$item->title}}@if(!is_null($item->subtitle)). {{$item->subtitle}} @endif @endif @endisset"> --}}
    {{-- <meta property="og:image" content="@isset($item)@if(!is_null($item->image)){{$item->image}}@endif @endisset"> --}}
    {{-- <link itemprop="image" href="@isset($item)@if(!is_null($item->image))https://{{$item->image}}@endif @endisset"> --}}
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    {{-- <meta name="twitter:site" content="twitterID"> --}}
    <meta property="og:description" itemprop="description" content="@isset($item)@if(!is_null($item->description)){{$item->description}}@endif @else @isset($site->description){{$site->description}} @endisset @endisset">
    {{-- <meta property="og:description" itemprop="description" content="@isset($item)@if(!is_null($item->description)){{$item->description}}@endif @else @isset($site->description){{$site->description}} @endisset @endisset"> --}}
    <meta name="description" ontent="@isset($item)@if(!is_null($item->description)){{$item->description}}@endif @else @isset($site->description){{$site->description}} @endisset @endisset">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('img/icons/favicon.png') }}">
    @if(empty($site)) <meta name="robots" content="noindex, nofollow, nocache, noydir"> @endif
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
   <link href="{{ asset('css/site.css') }}" rel="stylesheet">

</head>
<body>
  {{-- @isset($site) @if(!is_null($site->title)) {{ $site->title }} @else @endif @endisset --}}


        <main id="app">
          @yield('content')
        </main>

    <script>
      window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        // 'user' => Auth::user(),
        'api_token' => (Auth::user()) ? Auth::user()->api_token : null
        ]) !!};
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
