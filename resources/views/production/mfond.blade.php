@extends('layouts.app')
@section('content')
    {{-- content --}}
    <div class="col p-4" id="app">
        <h2 class="subtitle">Мехфонд</h2>
        <button class="mleft" onclick="document.location='{{url('/')}}/ru/map'">Карта</button>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
            <iframe onload="this.style.opacity=1;" style="opacity:0;border:none;" src="{{ url(env(MIX_SUPERSET)+'/superset/dashboard/7') }}" width="100%" height="1050px" frameborder="0" allowfullscreen></iframe>
            <!--<iframe onload="this.style.opacity=1;" style="opacity:0;border:none;" src="{{ url('http://localhost:8088/superset/dashboard/24') }}" width="100%" height="1050px" frameborder="0" allowfullscreen></iframe>-->
            </div>
        </div>
    </div>
@endsection
<style>
    .p-4{
        background-color: #0F1430;
    }
    .main{
        background-color: #0F1430;
        background-image: url({{ asset('img/level1/grid.svg') }});
        border: 1px solid #0D2B4D;
        margin-left: 0px !important;
        padding-top: 20px;
    }
    .title, .subtitle {
        color:white;
    }
    .top{
        display: none;
    }
</style>

