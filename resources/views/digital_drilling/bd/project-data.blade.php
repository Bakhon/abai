@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Проектные данные</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Техническое задание <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item">Геология</a>
                        <a class="dropdown-item">Конструкция скважины</a>
                        <a class="dropdown-item">Профиль ствола</a>
                        <a class="dropdown-item">Буровые растворы</a>
                        <a class="dropdown-item">Крепление скважины</a>
                        <a class="dropdown-item">Испытание/освоение</a>
                        <a class="dropdown-item">Дефектоскопия и опрессовка</a>
                        <a class="dropdown-item">Строительные и монтажные работы</a>
                        <a class="dropdown-item">Продолжительность строительства скважины</a>
                        <a class="dropdown-item">Консервация и ликвидация</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            @for ($i = 0; $i < 10; $i++)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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