@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="container">
                <h1>Просмотр карточки</h1>
                <h2>Дата: {{ \Carbon\Carbon::parse($omgngdu->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>Наименование</b></th>
                        <th><b>Значение</b></th>
                    </tr>
                    <tr>
                        <td>Месторождение</td>
                        <td>
                            @if ($omgngdu->field === 1)
                                Узень
                            @else
                                Карамандыбас
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>НГДУ</td>
                        <td>{{$omgngdu->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЦДНГ</td>
                        <td>{{$omgngdu->cdng->name}}</td>
                    </tr>
                    <tr>
                        <td>ГУ</td>
                        <td>{{$omgngdu->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЗУ</td>
                        <td>{{$omgngdu->zu->name}}</td>
                    </tr>
                    <tr>
                        <td>Скважина</td>
                        <td>{{$omgngdu->well->name}}</td>
                    </tr>
                    <tr>
                        <td>Суточная добыча  жидкости, м3/сут</td>
                        <td>{{$omgngdu->daily_fluid_production}}</td>
                    </tr>
                    <tr>
                        <td>Давление в буферной емкости, кгс/см2</td>
                        <td>{{$omgngdu->surge_tank_pressure}}</td>
                    </tr>
                    <tr>
                        <td>Давление на выходе насоса, кгс/см2</td>
                        <td>{{$omgngdu->pump_discharge_pressure}}</td>
                    </tr>
                    <tr>
                        <td>Давление на входе, кгс/см2</td>
                        <td>{{$omgngdu->heater_inlet_pressure}}</td>
                    </tr>
                    <tr>
                        <td>Давление на выходе, кгс/см2</td>
                        <td>{{$omgngdu->heater_output_pressure}}</td>
                    </tr>
                    <tr>
                        <td>Обозначение Кормасса</td>
                        <td>{{$omgngdu->kormass_number}}</td>
                    </tr>
                    <tr>
                        <td>Давление, кгс/см2</td>
                        <td>{{$omgngdu->pressure}}</td>
                    </tr>
                    <tr>
                        <td>Температура</td>
                        <td>{{$omgngdu->temperature}}</td>
                    </tr>
                    <tr>
                        <td>Суточная добыча жидкости, м3/сут</td>
                        <td>{{$omgngdu->daily_fluid_production_kormass}}</td>
                    </tr>
                </table>
                {{-- <a class="btn btn-warning" href="{{ route('watermeasurement.edit',$omgngdu->id) }}">{{__('app.edit')}}</a> --}}
                <a class="btn btn-primary" href="{{ route('omgngdu.index') }}">{{__('app.back')}}</a>
            </div>
        </div>
    </div>
@endsection
<style>
    body{color: white !important;}
    .table{
        color: white !important;
    }
</style>
