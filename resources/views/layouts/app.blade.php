<?php

$user = Auth::user()->username;
if (strpos($user, 'Almukhan_test') !== false && $_SERVER['REQUEST_URI'] !== '/ru/bigdata') {
    header('HTTP/1.1 200 OK');
    header('Refresh: 0; url=http://' . $_SERVER['HTTP_HOST'] . '/ru/bigdata');
} elseif (strpos($user, 'vcuser') !== false && $_SERVER['REQUEST_URI'] !== '/ru/visualcenter3') {
    header('HTTP/1.1 200 OK');
    header('Refresh: 0; url=http://' . $_SERVER['HTTP_HOST'] . '/ru/visualcenter3');
} elseif (strpos($user, 'gnouser') !== false && $_SERVER['REQUEST_URI'] !== '/ru/podborgno') {
    header('HTTP/1.1 200 OK');
    header('Refresh: 0; url=http://' . $_SERVER['HTTP_HOST'] . '/ru/podborgno');
} elseif (strpos($user, 'truser') !== false && $_SERVER['REQUEST_URI'] !== '/ru/tr') {
    header('HTTP/1.1 200 OK');
    header('Refresh: 0; url=http://' . $_SERVER['HTTP_HOST'] . '/ru/tr');
}
?>
@section('sidebar_menu')
    @include('partials.sidebar.menu')
@endsection
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
</head>

<body class="@yield('body_class')">
@include('layouts.navbar')
<div class="no-row row" id="app">

    @include('layouts.head-sidebar')

    <div class="container-fluid col m-1 p-0 container-main">
        @yield('content')
    </div>
</div>
@yield('custom_js')
</body>

</html>