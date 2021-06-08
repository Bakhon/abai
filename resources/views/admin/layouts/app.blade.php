<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">
    <link href="{{ asset('css/loader.css')}}" rel="stylesheet">

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ route('assets.lang') }}"></script>
    @yield('custom_css')
</head>

<body>
@include('admin.layouts.navbar')
<div class="no-row row" id="app">
    <div class="col m-lg-3 m-1 p-0">
        @yield('content')
    </div>
</div>
@yield('custom_js')
</body>
</html>
