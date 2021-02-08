@extends('layouts.app')
@section('content')
    <div class="gtm-menu-block">
        <div class="bg-dark row text-center gtm-menu">
            <div class="col-4">АЭГТМ</div>
            <div class="col-4 active">Подбор ГТМ</div>
            <div class="col-4">Экономическая+технологическая успешность</div>
        </div>
    </div>
    <cat-loader />
@endsection
<link href="{{ asset('css/gtm.css')}}" rel="stylesheet">