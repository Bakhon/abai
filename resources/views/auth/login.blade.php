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
            <div id="app"></div>
            <div class="col-md-6">
               <div id="logo"></div>
               <div id="logo2"></div>
            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <div id="logokmgi"></div>
                    <h2>{{ __('app.Login') }} <br> в панель управления</h2>
                    <form method="POST" action="{{ route('login') }}" id="form">
                        @csrf

                        <div>
                            <input id="username" type="text"  name="username" class="loginInput" value="{{ old('username') }}" placeholder="{{ __('app.Login') }}">
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
        background: url('{{ asset('img/loginBackground.png') }}') no-repeat;
        color: white;
        font-family: 'Roboto', sans-serif;
    }
    .row {
        margin-left: 0px;
        margin-right: 0px;
    }

   
    

    #logo {
    display: inline-block;
    background: url(../img/logokmg.png) no-repeat;
    height: 350px;
    width: 370px;
    background-size: contain;
    margin-left: 150px;
    margin-top: 94px;
    margin-bottom: -120px;
}


#logo2 {
    display: inline-block;
    background: url(../img/kmgi.png) no-repeat;
    height: 131px;
    width: 200px;
    background-size: contain;
    margin-left: 285px;
    margin-top: 85px;
    /* margin-bottom: -120px; */
    position: absolute;
}

#logokmgi {
    background: url(../img/abai.png) no-repeat;
    height: 344px;
    width: 294px;
    background-size: contain;
    margin-left: 290px;
    margin-top: 107px;
    margin-bottom: -120px;
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
