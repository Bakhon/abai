@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Отчеты</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Доля коллектора в горизонтальных скв. (по данным интерпретации ГИС)<i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('digital-drilling-report2')}}">Календарный план сопровождения бурения сложных скв. по ДЗО НК КМГ на 2021г.</a>
                        <a class="dropdown-item">Отчет службы супервайзинга об окончании строительства скважины</a>
                        <a class="dropdown-item">Отчет службы сопровождения 24/7 с офиса КМГИ</a>
                        <a class="dropdown-item">Отчет буровой компании по строительству скважины</a>
                        <a class="dropdown-item">Отчет подрядной компании по буровым растворам</a>
                        <a class="dropdown-item">Отчет подрядной компании по ННБ и геонавигации </a>
                        <a class="dropdown-item">Отчет подрядной компании по цементированию скважины</a>
                        <a class="dropdown-item">Отчет подрядной компании по ГИС</a>
                        <a class="dropdown-item">Отчет подрядной компании по ГТИ  </a>
                        <a class="dropdown-item">Сводная таблица анализа проектных скважин 2021г</a>
                        <a class="dropdown-item">Консолидированные рекомендации по улучшению и осложнениям в процессе строительства скважины</a>
                        <a class="dropdown-item">Отчет по извлеченным урокам в процессе строительства скважины</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <img src="/img/digital-drilling/dolya.png" alt="" style="max-width: 70%;width: 70%;display: table;margin: 20px auto;height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection