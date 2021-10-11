@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Профиль скважины</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Ввод данных <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-well-profile-graph') }}">Визуализация</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable">
                            <tr>
                                <th></th>
                                <th>МД, (м)</th>
                                <th>CL, (м)</th>
                                <th>Inc, (м)</th>
                                <th>Azi, (м)</th>
                                <th>TVD, (м)</th>
                                <th>TVDSS, (м)</th>
                                <th>NS, (м)</th>
                                <th>EW, (м)</th>
                                <th>V.Sec (м)</th>
                                <th>Dogleg, (м)</th>
                                <th>T.Face, (м)</th>
                                <th>Build, (м)</th>
                                <th>Turn, (м)</th>
                                <th>Section Type</th>
                                <th>Targetz</th>
                            </tr>
                            @for ($i = 0; $i < 20; $i++)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>3946, 12</td>
                                    <td>16,12</td>
                                    <td>42,61</td>
                                    <td>264,15</td>
                                    <td>3209,93</td>
                                    <td>3057,43</td>
                                    <td>-210,59</td>
                                    <td>-2014,63</td>
                                    <td>2025,60</td>
                                    <td>0,000</td>
                                    <td>0,00</td>
                                    <td>0,000</td>
                                    <td>0,000</td>
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