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

        <script src="{{ asset('js/jquery.js') }}"></script>
    </head>
    <body>
        @include('layouts.navbar')
        <div class="row" id="body-row">
            @include('layouts.sidebar')
            {{-- <div class="col p-4"> --}}
                @yield('content')
            {{-- </div> --}}
        </div>
    </body>
</html>
