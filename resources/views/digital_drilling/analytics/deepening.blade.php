@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                       Профиль скважины: инклинометрия <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-inclino') }}">Профиль скважины: инклинометрия</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-visual') }}">Профиль скважины: визуализация</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-knbk') }}">КНБК</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-params') }}">Параметры режимов</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-bur') }}">Буровые растворы: параметры и комп.состав</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-gidro') }}">Буровые растворы: Гидравлика - распределение потерь давления в цирк.системе</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-sorting') }}">Буровые растворы: распределение потерь давления на долоте</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-selection') }}">Отбор керна</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th></th>
                                <th>MD (м)</th>
                                <th>CL (м)</th>
                                <th>Inc (*)</th>
                                <th>Azi (*)</th>
                                <th>TVD (м)</th>
                                <th>TVDSS (м)</th>
                                <th>NS (м)</th>
                                <th>EW (м)</th>
                                <th>V.Sec (м)</th>
                                <th>Dogleg (м)</th>
                                <th>T.Face (м)</th>
                                <th>Build (м)</th>
                                <th>Turn (*/30м)</th>
                                <th>Section Type</th>
                                <th>Target</th>
                            </tr>
                            @for ($i = 0; $i < 16; $i++)
                                <tr>
                                        <td>{{ $i }}</td>
                                        <td>3946</td>
                                        <td>3946</td>
                                        <td>3946</td>
                                        <td>3946</td>
                                        <td>3946</td>
                                        <td>3946</td>
                                        <td>210</td>
                                        <td>3946</td>
                                        <td>3946</td>
                                        <td>3946</td>
                                        <td>3946</td>
                                        <td>0,00</td>
                                        <td>0,00</td>
                                        <td>Inc Azi MD</td>
                                        <td></td>
                                </tr>
                            @endfor
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection