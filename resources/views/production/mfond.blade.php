@extends('layouts.app')
@section('content')
    {{-- content --}}
    <div class="col p-4" id="app">
        <h2 class="subtitle">Мехфонд</h2>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
            <iframe src="{{ url('http://cent7-bigdata.kmg.kz:9088/superset/dashboard/44') }}" width="100%" height="1588x" frameborder="0" allowfullscreen></iframe>
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
