<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
    <body>
        <div class="row">
            <div class="col-md-6">
                <img src="img/bank1.png" alt="" id="logo">
            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <img src="img/logoKMGI.png" alt="" id="logokmgi">
                    <h2>Вход <br> в панель управления</h2>
                    <form method="POST" action="{{ route('login') }}" id="form">
                        @csrf

                        <div>
                            <input id="username" type="text"  name="username" class="loginInput" value="{{ old('username') }}" placeholder="{{ __('Login') }}">
                        </div>

                        <div>
                            <input id="password" type="password"  name="password" class="loginInput"  required autocomplete="current-password"  placeholder="{{  __('Password') }}">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit">
                                ВОЙТИ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<style>
    body {
        background: url("img/loginBackground.png") no-repeat fixed;
        color: white;
        font-family: 'Roboto', sans-serif;
    }
    .row {
        margin-left: 0px;
        margin-right: 0px;
    }

    #logo {
        padding: 50px 0 0 50px;
        width: 286px;
    }

    #logokmgi {
        padding: 50px 0 150px 0px;
    }

    h2  {
        padding-bottom: 40px;
    }

    form {
        margin: auto;
        width: 50%;
    }

    .loginInput {
        width: 80%;
        border-left: solid #3490dc 5px;
        border-top: none;
        border-right: none;
        border-bottom: none;
        height: 50px;
        margin-bottom: 15px;
        font-size: 20px;
        text-indent: 10px;
    }

    .form-check {
        float: left;
        margin-left: 30px;
    }

    #remember {
        width: 20px;
        height: 20px;
        border: none;
        margin-top: 25px;
    }

    label{
        margin:0 0 5px 10px;
        height: 20px;
    }

    button {
        width: 80%;
        height: 50px;
        border-radius: 50px;
        background-color: #3490dc;
        border: none;
        color: white;
        margin-top: 40px;
        font-size: 20px;
    }
</style>
