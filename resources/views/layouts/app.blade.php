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
        @if (basename(Request::url()) === "economic")
        @elseif (basename(Request::url()) === "gtmscor")
        @elseif (basename(Request::url()) === "mfond")
        @elseif (basename(Request::url()) === "bigdata")
        @elseif (basename(Request::url()) === "mzdn")
        @elseif (basename(Request::url()) === "constructor")
        @elseif (basename(Request::url()) === "production")
        @elseif (basename(Request::url()) === "watermeasurement")
        @elseif (basename(Request::url()) === "visualcenter")
        @include('layouts.visual-center-sidebar')
        @else
        @include('layouts.sidebar')
        @endif
        {{-- <div class="col p-4"> --}}
        @yield('content')
        {{-- </div> --}}
    </div>
</body>

</html>
