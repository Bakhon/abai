<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}" ></script>
    <script src="{{ asset('js/vendor.js') }}" ></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">
    <link href="{{ asset('css/loader.css')}}" rel="stylesheet">

</head>
    <body>
        <div class="row">
            <div id="app"></div>
            <div class="container">
            <div class=" align-items-center">
            <div class="align-items-sm-center" style="
    text-align: center;
    padding-top: 65px;
    padding-bottom: 65px;
">
            <svg width="50%" height="auto" viewBox="0 0 129 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M48.7953 8.90239H58.1889L66.9862 26.621H60.5993L58.9097 23.6428H48.0746L46.385 26.621H39.998L48.7953 8.90239ZM53.9147 12.8978H53.0696L50.1124 19.0522H56.8468L53.9147 12.8978ZM75.0872 19.5484H84.5557C85.0689 19.5484 85.4625 19.6522 85.7358 19.8586C86.0094 20.0657 86.1456 20.4501 86.1456 21.0128C86.1456 21.906 85.6154 22.3531 84.5557 22.3531H75.0872V19.5484ZM69.62 8.85254V26.621H86.1456C88.1011 26.621 89.5005 26.2485 90.3456 25.5041C91.1908 24.7557 91.6125 23.4903 91.6125 21.6992C91.6125 19.6308 90.7928 18.2292 89.1523 17.501C89.6659 17.2695 90.0971 16.8397 90.4449 16.2065C90.7928 15.5784 90.9667 14.8005 90.9667 13.8737C90.9667 11.7687 90.387 10.3461 89.2276 9.59765C88.4485 9.10103 87.2061 8.85254 85.4995 8.85254H69.62ZM75.0872 13.1707H84.7791C85.2266 13.1707 85.5659 13.2619 85.7982 13.4439C86.03 13.626 86.1456 13.9317 86.1456 14.3622C86.1456 14.7757 86.0256 15.0778 85.7856 15.2676C85.5453 15.4577 85.2096 15.5533 84.7791 15.5533H75.0872V13.1707ZM102.373 8.90239H111.766L120.563 26.621H114.177L112.487 23.6428H101.652L99.9626 26.621H93.5764L102.373 8.90239ZM107.492 12.8978H106.647L103.69 19.0522H110.425L107.492 12.8978ZM123.024 26.6709V8.92749H128.491V26.6709H123.024Z" fill="#FEFEFE"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M45.0969 37.784L44.7203 36.6161H41.6771C41.638 36.7417 41.5781 36.9344 41.4991 37.1951C41.4201 37.4557 41.3603 37.6522 41.3204 37.784H39.7246C40.4649 35.3759 41.2776 33.2314 42.1626 31.3505H44.3042C45.262 33.3698 46.0913 35.5143 46.7917 37.784H45.0969ZM42.1032 35.3194H44.2842C43.9205 34.2833 43.5539 33.3403 43.1836 32.4889C42.8273 33.3071 42.4673 34.2508 42.1032 35.3194ZM48.4968 32.7067L48.6655 33.2605C49.2866 32.8319 49.9604 32.6111 50.6874 32.5978V34.0234C50.0132 34.0164 49.3793 34.1847 48.7844 34.5277V37.784H47.2876V32.7067H48.4968ZM54.9598 32.7067V33.8941H53.3732V35.8736C53.3732 36.1376 53.4279 36.3359 53.5375 36.4677C53.6461 36.5995 53.8462 36.6656 54.1372 36.6656C54.4078 36.6656 54.6814 36.6191 54.9598 36.5268V37.7146C54.6094 37.8401 54.2295 37.9033 53.8196 37.9033C53.2314 37.9033 52.761 37.7659 52.4073 37.4923C52.0536 37.2183 51.8767 36.7682 51.8767 36.1413V33.8941H51.0146V32.7067H51.9366L52.1049 31.41H53.3732V32.7067H54.9598ZM60.8668 32.5978C61.7459 32.5978 62.4493 32.8289 62.978 33.2905C63.5068 33.752 63.7715 34.4055 63.7715 35.25C63.7715 36.0951 63.5068 36.7483 62.978 37.2098C62.4493 37.6717 61.7459 37.9033 60.8668 37.9033C59.9817 37.9033 59.2724 37.6732 58.7407 37.2154C58.209 36.7568 57.9432 36.1014 57.9432 35.25C57.9432 34.4055 58.209 33.752 58.7407 33.2905C59.2724 32.8289 59.9817 32.5978 60.8668 32.5978ZM60.8273 33.8347C60.4307 33.8347 60.1102 33.9617 59.8658 34.2157C59.6214 34.4698 59.4991 34.815 59.4991 35.25C59.4991 35.6661 59.6261 36.0061 59.8805 36.2698C60.1353 36.5334 60.4706 36.6656 60.8867 36.6656C61.2833 36.6656 61.6038 36.5323 61.8478 36.2646C62.093 35.9973 62.2148 35.6598 62.2148 35.25C62.2148 34.8013 62.0874 34.4535 61.8334 34.2061C61.5786 33.9584 61.2437 33.8347 60.8273 33.8347ZM67.0318 30.6279C67.4417 30.6279 67.8017 30.6841 68.1122 30.7963V32.0037C67.8677 31.9047 67.6133 31.8553 67.349 31.8553C67.0318 31.8553 66.8217 31.8999 66.7198 31.9889C66.6168 32.0783 66.5662 32.2411 66.5662 32.4789V32.7067H68.1417V33.8941H66.5662V37.784H65.069V33.8941H64.0185V32.7067H65.069V32.3899C65.069 31.7892 65.2529 31.3461 65.6199 31.0588C65.9861 30.7719 66.4573 30.6279 67.0318 30.6279ZM72.602 31.9841H70.9272V30.7077H72.602V31.9841ZM72.513 37.784H71.0162V32.7067H72.513V37.784ZM77.241 32.5978C77.8421 32.5978 78.3085 32.7525 78.6386 33.063C78.9687 33.3735 79.1345 33.8941 79.1345 34.6267V37.784H77.6372V34.815C77.6372 34.4845 77.57 34.2394 77.4341 34.0777C77.299 33.9156 77.0723 33.8347 76.7551 33.8347C76.2268 33.8347 75.7412 33.9935 75.2985 34.3095V37.784H73.8017V32.7067H75.0109L75.1693 33.241C75.8236 32.8119 76.5144 32.5978 77.241 32.5978ZM83.6243 32.7067V33.8941H82.0381V35.8736C82.0381 36.1376 82.0927 36.3359 82.2017 36.4677C82.3106 36.5995 82.5111 36.6656 82.8017 36.6656C83.0723 36.6656 83.3466 36.6191 83.6243 36.5268V37.7146C83.2743 37.8401 82.894 37.9033 82.4845 37.9033C81.8959 37.9033 81.4255 37.7659 81.0718 37.4923C80.7181 37.2183 80.5416 36.7682 80.5416 36.1413V33.8941H79.6791V32.7067H80.601L80.7698 31.41H82.0381V32.7067H83.6243ZM89.5911 35.7946H85.7555C85.7884 36.0324 85.8943 36.2236 86.0727 36.3687C86.2506 36.5142 86.4378 36.608 86.6324 36.6505C86.827 36.6937 87.0375 36.7154 87.262 36.7154C87.8897 36.7154 88.5764 36.5995 89.3234 36.3687V37.537C88.5502 37.7807 87.8498 37.9033 87.2221 37.9033C86.2772 37.9033 85.5406 37.6799 85.0119 37.2346C84.4831 36.7897 84.2191 36.1147 84.2191 35.2108C84.2191 34.3664 84.4931 33.7195 85.0418 33.2705C85.5901 32.8223 86.2573 32.5978 87.0434 32.5978C87.8764 32.5978 88.5089 32.8119 88.9416 33.241C89.3743 33.67 89.5911 34.29 89.5911 35.1023V35.7946ZM85.7651 34.8641H88.0551C88.0484 34.5211 87.9587 34.2519 87.787 34.0573C87.6153 33.8631 87.3709 33.7657 87.0533 33.7657C86.2735 33.7657 85.8445 34.1319 85.7651 34.8641ZM92.0786 37.784H90.5821V30.9447H92.0786V37.784ZM94.8242 37.784H93.3273V30.9447H94.8242V37.784ZM97.6979 31.9841H96.0234V30.7077H97.6979V31.9841ZM97.6093 37.784H96.1128V32.7067H97.6093V37.784ZM104.26 32.7067V37.3487C104.26 37.8036 104.18 38.202 104.022 38.5413C103.864 38.8813 103.644 39.1453 103.364 39.3333C103.082 39.5209 102.77 39.6593 102.427 39.749C102.083 39.838 101.706 39.8823 101.296 39.8823C100.483 39.8823 99.7575 39.7738 99.1161 39.5559V38.2987C99.869 38.5361 100.539 38.655 101.128 38.655C101.611 38.655 102.004 38.569 102.307 38.3977C102.612 38.226 102.763 37.9623 102.763 37.6057V37.4868C102.281 37.7511 101.789 37.8833 101.286 37.8833C100.527 37.8833 99.8889 37.6437 99.3742 37.1655C98.858 36.687 98.6007 36.042 98.6007 35.2304C98.6007 34.3664 98.8599 33.7132 99.3786 33.2705C99.8978 32.8289 100.553 32.6077 101.346 32.6077C101.947 32.6077 102.505 32.7728 103.021 33.1021L103.15 32.7067H104.26ZM101.564 36.656C101.98 36.656 102.38 36.5268 102.763 36.2698V34.2013C102.367 33.9573 101.954 33.8347 101.525 33.8347C101.108 33.8347 100.777 33.9521 100.528 34.1862C100.281 34.4207 100.157 34.7622 100.157 35.2108C100.157 35.6927 100.289 36.0541 100.553 36.2941C100.817 36.5356 101.154 36.656 101.564 36.656ZM110.623 35.7946H106.788C106.821 36.0324 106.927 36.2236 107.104 36.3687C107.283 36.5142 107.47 36.608 107.665 36.6505C107.859 36.6937 108.07 36.7154 108.294 36.7154C108.922 36.7154 109.609 36.5995 110.356 36.3687V37.537C109.583 37.7807 108.883 37.9033 108.255 37.9033C107.309 37.9033 106.572 37.6799 106.044 37.2346C105.516 36.7897 105.252 36.1147 105.252 35.2108C105.252 34.3664 105.526 33.7195 106.074 33.2705C106.622 32.8223 107.29 32.5978 108.076 32.5978C108.908 32.5978 109.541 32.8119 109.974 33.241C110.407 33.67 110.623 34.29 110.623 35.1023V35.7946ZM106.797 34.8641H109.087C109.081 34.5211 108.992 34.2519 108.819 34.0573C108.648 33.8631 108.403 33.7657 108.086 33.7657C107.306 33.7657 106.877 34.1319 106.797 34.8641ZM115.054 32.5978C115.655 32.5978 116.121 32.7525 116.451 33.063C116.782 33.3735 116.947 33.8941 116.947 34.6267V37.784H115.45V34.815C115.45 34.4845 115.382 34.2394 115.248 34.0777C115.112 33.9156 114.885 33.8347 114.568 33.8347C114.039 33.8347 113.553 33.9935 113.111 34.3095V37.784H111.615V32.7067H112.824L112.982 33.241C113.636 32.8119 114.327 32.5978 115.054 32.5978ZM120.793 32.5978C121.48 32.5978 122.107 32.6938 122.676 32.885V34.1618C122.174 33.9436 121.635 33.8347 121.06 33.8347C120.611 33.8347 120.238 33.9521 119.94 34.1862C119.643 34.4207 119.494 34.7685 119.494 35.2304C119.494 35.7056 119.655 36.0634 119.975 36.3049C120.295 36.5452 120.66 36.6656 121.07 36.6656C121.659 36.6656 122.194 36.5895 122.676 36.4378V37.695C122.028 37.8338 121.473 37.9033 121.012 37.9033C120.099 37.9033 119.359 37.6836 118.791 37.2449C118.222 36.8059 117.938 36.1476 117.938 35.2703C117.938 34.4192 118.214 33.7605 118.765 33.2956C119.317 32.8304 119.994 32.5978 120.793 32.5978ZM128.613 35.7946H124.777C124.811 36.0324 124.916 36.2236 125.095 36.3687C125.272 36.5142 125.459 36.608 125.655 36.6505C125.849 36.6937 126.059 36.7154 126.284 36.7154C126.912 36.7154 127.599 36.5995 128.345 36.3687V37.537C127.572 37.7807 126.872 37.9033 126.244 37.9033C125.299 37.9033 124.562 37.6799 124.033 37.2346C123.505 36.7897 123.241 36.1147 123.241 35.2108C123.241 34.3664 123.515 33.7195 124.064 33.2705C124.612 32.8223 125.279 32.5978 126.065 32.5978C126.898 32.5978 127.531 32.8119 127.964 33.241C128.396 33.67 128.613 34.29 128.613 35.1023V35.7946ZM124.787 34.8641H127.077C127.07 34.5211 126.981 34.2519 126.809 34.0573C126.637 33.8631 126.393 33.7657 126.076 33.7657C125.295 33.7657 124.867 34.1319 124.787 34.8641Z" fill="#FEFEFE"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M21.0287 10.54L29.9626 24.9057C32.4634 29.894 32.1628 34.3037 28.921 38.1061L27.1693 35.3597L16.5684 18.4161L21.0287 10.54Z" fill="#1D70B7"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.139 18.4592L10.4584 23.2688C9.59401 24.8192 8.98773 25.7575 9.43672 27.642C9.95992 29.8382 11.953 31.4842 14.2939 31.4842C16.0312 31.4842 17.5358 30.5774 18.3695 29.2123C18.4212 29.1765 18.4699 29.1481 18.5165 29.1296C18.6952 30.5892 18.6165 31.938 18.3023 33.1122C17.6004 35.7341 15.4696 37.9354 12.6575 38.2932C5.18355 39.5106 -1.2514 32.449 0.391304 25.3022C0.803734 23.5088 1.83463 21.635 2.70306 20.0248C3.71733 18.1439 4.81801 16.2682 5.74367 14.8061L8.51623 10.4277L13.139 18.4592Z" fill="#FEFEFE"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0918 7.75235L14.4701 0.046875L19.2554 7.75235L14.8497 15.532L10.0918 7.75235Z" fill="#1D70B7"></path></svg>
            </div>
                <div class="text-center">
                    <h2>{{ __('app.Login') }} в систему</h2>
                    <form method="POST" action="{{ route('login') }}" id="form">
                        @csrf
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

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
                                    <!-- {{ __('Remember Me') }} -->
                                    Запомнить меня
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
            <div class="fixed-bottom" style="
    text-align: right;
    text-decoration: unset;
">
            <a href="#" type="button"  data-toggle="modal" data-target="#techModal" style="
    color: #e8f0fe;
    padding-right: 20px;
">
            <h5>Техническая поддержка</h5>
            </a>

            <a href="#" type="button"  data-toggle="modal" data-target="#faqModal" style="
    color: #e8f0fe;
    padding-right: 20px;
">
            <h5>F.A.Q.</h5>
            </a>
            </div>

        </div>
 <!-- Тех поддержка-->
 <div class="modal fade" id="techModal" tabindex="-1" aria-labelledby="techModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="techModalLabel">Техническая поддержка</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> Техническая поддержка  </p>
        <p> Email</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>

      </div>
    </div>
  </div>
</div>

<!-- FAQ-->
<div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="faqModalLabel">FAQ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> FAQ  </p>
        <p> text</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>

      </div>
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
        background-size: 100vw 100vh;
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
        max-width: 510px ;
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
