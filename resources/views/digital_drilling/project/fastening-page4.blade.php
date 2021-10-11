@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Обсадные колонны: Эпюры избыточных давлений <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening') }}">Обсадные колонны: Данные по ОК</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page2') }}">Обсадные колонны: Режим спуска</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page3') }}">Обсадные колонны: Опрессовка и натяжение ОК</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page4') }}">Обсадные колонны: Эпюры избыточных давлений</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page5') }}">Цементирование: Характеристики жидкостей</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page6') }}">Цементирование: Компонентный состав</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page7') }}">Цементирование: Технологические операции</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="fasteningBlock">
                            <div class="head">
                                <p class="name">Направление</p>
                            </div>
                            <div class="body">
                                <p class="title">Эпюры избыточных давлений для колонны 177,8 мм</p>
                                <p class="second">Наружное, МПа</p>
                                <p class="second">Внутреннее, МПа</p>
                                <img src="/img/digital-drilling/fastening1.png" alt="">
                            </div>
                            <div class="foot">
                                <p class="legend">Легенда</p>
                                <img src="/img/digital-drilling/fasteninglegend.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="fasteningBlock">
                            <div class="head">
                                <p class="name">Кондуктор</p>
                            </div>
                            <div class="body">
                                <p class="title">Эпюры избыточных давлений для колонны 177,8 мм</p>
                                <p class="second">Наружное, МПа</p>
                                <p class="second">Внутреннее, МПа</p>
                                <img src="/img/digital-drilling/fastening2.png" alt="">
                            </div>
                            <div class="foot">
                                <p class="legend">Легенда</p>
                                <img src="/img/digital-drilling/fasteninglegend.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="fasteningBlock">
                            <div class="head">
                                <p class="name">Промежуточная колонна</p>
                            </div>
                            <div class="body">
                                <p class="title">Эпюры избыточных давлений для колонны 177,8 мм</p>
                                <p class="second">Наружное, МПа</p>
                                <p class="second">Внутреннее, МПа</p>
                                <img src="/img/digital-drilling/fastening3.png" alt="">
                            </div>
                            <div class="foot">
                                <p class="legend">Легенда</p>
                                <img src="/img/digital-drilling/fasteninglegend.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="fasteningBlock">
                            <div class="head">
                                <p class="name">Эксплуатационная колонна</p>
                            </div>
                            <div class="body">
                                <p class="title">Эпюры избыточных давлений для колонны 177,8 мм</p>
                                <p class="second">Наружное, МПа</p>
                                <p class="second">Внутреннее, МПа</p>
                                <img src="/img/digital-drilling/fastening4.png" alt="">
                            </div>
                            <div class="foot">
                                <p class="legend">Легенда</p>
                                <img src="/img/digital-drilling/fasteninglegend.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    th.verticalText {
        max-width: 100px;
    }

    th.verticalText span {
        width: 140px;
        margin-left: -40px;
    }
</style>