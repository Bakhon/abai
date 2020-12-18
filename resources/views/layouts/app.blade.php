<?php
    $user = Auth::user()->username;
    if (strpos($user, 'Almukhan_test') !== false && $_SERVER['REQUEST_URI'] !== '/ru/bigdata') { 
        header('HTTP/1.1 200 OK');
        header('Refresh: 0; url=http://'.$_SERVER['HTTP_HOST'].'/ru/bigdata');
        
    }
    elseif(strpos($user, 'vcuser') !== false && $_SERVER['REQUEST_URI'] !== '/ru/visualcenter3') { 
        header('HTTP/1.1 200 OK');
        header('Refresh: 0; url=http://'.$_SERVER['HTTP_HOST'].'/ru/visualcenter3');
        
    }
    elseif(strpos($user, 'gnouser') !== false && $_SERVER['REQUEST_URI'] !== '/ru/podborgno') { 
        header('HTTP/1.1 200 OK');
        header('Refresh: 0; url=http://'.$_SERVER['HTTP_HOST'].'/ru/podborgno');
        
    }
    elseif(strpos($user, 'truser') !== false && $_SERVER['REQUEST_URI'] !== '/ru/tr') { 
        header('HTTP/1.1 200 OK');
        header('Refresh: 0; url=http://'.$_SERVER['HTTP_HOST'].'/ru/tr');
        
    }
        ?>
</html>
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

    <script src="{{ asset('js/jquery.js') }}"></script>
</head>

<body>
    @include('layouts.navbar')
    <div class="no-row row" id="app">
    @if (basename(Request::url()) === "visualcenter3")
        @include('layouts.visual-center4-sidebar')
        @elseif (basename(Request::url()) === "visualcenter4")
        @include('layouts.visual-center4-sidebar')
        @elseif (basename(Request::url()) === "tr" || basename(Request::url()) === "fa" || basename(Request::url()) === "trfa" || basename(Request::url()) === "tr_charts")
        @include('layouts.tr-sidebar')
        @else
        @include('layouts.head-sidebar')
        @endif

       {{-- @if (basename(Request::url()) === "ru")
        @include('layouts.sidebar')
        @elseif (basename(Request::url()) === "visualcenter")
        @include('layouts.visual-center-sidebar')
        @elseif (basename(Request::url()) === "podborgno")
        @include('layouts.gno-sidebar')
        @elseif (basename(Request::url()) === "monitor")
        @include('layouts.gno-sidebar')
        @elseif (basename(Request::url()) === "visualcenter3")
        @include('layouts.visual-center4-sidebar')
        @elseif (basename(Request::url()) === "visualcenter4")
        @include('layouts.visual-center4-sidebar')
        
        @endif--}}


        @if (basename(Request::url()) === "oilpivot")
        <div class="col">
            @yield('content')
        </div>
        @else
        <div class="container-fluid col m-lg-3 m-1 p-0">
            @yield('content')
        </div>
        @endif
    </div>
</body>

</html>
