@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Буровые растворы</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Геологические данные <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-rasters-params') }}">Параметры БР</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-rasters-component') }}">Компонентный состав БР</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable ">
                            <tr>
                                <th>Стратиграфия</th>
                                <th>Литология</th>
                                <th>Пластовое давление</th>
                                <th>Поровое давление</th>
                                <th>Гидроразрыв пород</th>
                                <th>Горное давление</th>
                            </tr>
                            @for ($i = 0; $i < 20; $i++)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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