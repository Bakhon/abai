@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle">Данные по непроизводительному времени: Визуализация непроизводительного времени</p>
                <div class="row">
                    <div class="col-sm-12">
                        <img src="/img/digital-drilling/npv.png" alt="" style="max-width: 90%;width: 90%;display: table;margin: 20px auto;height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection