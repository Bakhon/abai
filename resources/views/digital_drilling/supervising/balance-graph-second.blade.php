@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Баланс календарного времени</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Визуализация баланса календарного времени<i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-balance') }}">Баланс календарного времени </a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-balance-second') }}">Баланс календарного времени: Фактический график бурения</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <img src="/img/digital-drilling/balance2.png" alt="" style="max-width: 90%;width: 90%;display: table;margin: 20px auto;height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection