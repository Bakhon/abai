@extends('layouts.app')

@section('module_icon')
    <img src="/img/economic/icon.svg" alt="">
@endsection

@section('module_title', trans('economic_reference.economic_module_full'))

@section('content')
    <div class="col-sm-12 overflow-hidden">
        <economic-optimization></economic-optimization>
    </div>
@endsection

<style>
    .main {
        background-color: #0F1430;
        background-image: url({{ asset('img/level1/grid.svg') }});
        border: 1px solid #0D2B4D;
        margin-bottom: 15px;
    }

    #app {
        flex-wrap: nowrap;
        overflow: hidden;
    }

    body{
        overflow: hidden;
    }
</style>
