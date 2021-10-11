@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление скважины</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Визуализация<i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-deepening') }}">Подбор КНБК</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-deepening-params') }}">Параметры и режимы бурения</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <img src="/img/digital-drilling/deepening.png" alt="" class="deepening-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection