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

<body style="background-color: #0F1430;">
    @include('layouts.navbar')
    <div class="row" id="app">
        @if (basename(Request::url()) === "ru")
        @include('layouts.sidebar')
        @elseif (basename(Request::url()) === "visualcenter")
        @include('layouts.visual-center-sidebar')
        @elseif (basename(Request::url()) === "podborgno")
        @include('layouts.gno-sidebar')
        @elseif (basename(Request::url()) === "monitor")
        @include('layouts.gno-sidebar')
        @elseif (basename(Request::url()) === "visualcenter3")
        @include('layouts.gno-sidebar')
        @elseif (basename(Request::url()) === "visualcenter4")
        @include('layouts.visual-center4-sidebar')
        @elseif (basename(Request::url()) === "tr")
        @include('layouts.gno-sidebar')
        @elseif (basename(Request::url()) === "fa")
        @include('layouts.gno-sidebar')
        @endif


        @if (basename(Request::url()) === "oilpivot")
        <div class="col">
            @yield('content')
        </div>
        @else
        <div class="container-fluid col spacing">
            @yield('content')
        </div>
        @endif
    </div>
</body>

</html>
