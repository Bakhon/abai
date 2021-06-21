@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Визуализация данных</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Визуализация данных<i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item">Глубина забоя</a>
                        <a class="dropdown-item">Положение долота</a>
                        <a class="dropdown-item">Давление на стояке</a>
                        <a class="dropdown-item">Давление на забое</a>
                        <a class="dropdown-item">Обороты ротора</a>
                        <a class="dropdown-item">Обороты с ВЗД/РУС</a>
                        <a class="dropdown-item">Нагрузка на долото</a>
                        <a class="dropdown-item">Вес на крюке</a>
                        <a class="dropdown-item">Текущая операция</a>
                        <a class="dropdown-item">Плотность бур. Раствора</a>
                        <a class="dropdown-item">ЭЦП</a>
                        <a class="dropdown-item">Температура раствора на выходе</a>
                        <a class="dropdown-item">Температура раствора на входе</a>
                        <a class="dropdown-item">Зенитный угол</a>
                        <a class="dropdown-item">Азимутальный угол</a>
                        <a class="dropdown-item">Показания шлама</a>
                        <a class="dropdown-item">Газ</a>
                        <a class="dropdown-item">Гамма</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <img src="/img/digital-drilling/visual1.png" alt="" style="max-width: 90%;width: 90%;display: table;margin: 20px auto;height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection