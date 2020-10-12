@extends('layouts.app')
@section('content')
<div class="pivot">
    <h1>
        Конструктор. Добыча нефти
    </h1>
    <div class="x_panel">
        <oil-pivot></economic-oil>
    </div>
</div>
@endsection
<style>
    .p-4{
        background-color: #0F1430;
        overflow-x: auto  !important;
        white-space: nowrap;
    }
    .main{
        background-color: #0F1430;
        background-image: url({{ asset('img/level1/grid.svg') }});
        border: 1px solid #0D2B4D;
        margin-bottom:15px;
    }
    .pivot{
        color: #ffffff;
    }
</style>
