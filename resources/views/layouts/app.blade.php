</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head >
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
@if (($_SERVER['REQUEST_URI']) === "/public/ru/visualcenter")
@include('layouts.visual-center-navbar')  
@else
 @include('layouts.navbar')
@endif
	        <div class="row" id="app">
@if (($_SERVER['REQUEST_URI']) === "/public/ru/visualcenter")
@include('layouts.visual-center-sidebar')  
@else
@include('layouts.sidebar')
@endif
            {{-- <div class="col p-4"> --}}
                @yield('content')
            {{-- </div> --}}
        </div >
    </body>
</html>
