@extends('layouts.monitor')

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
                <h2>Дата: {{ \Carbon\Carbon::parse($oilgas->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>Наименование</b></th>
                        <th><b>Значение</b></th>
                    </tr>
                    <tr>
                        <td>Прочие объекты</td>
                        <td>{{$oilgas->other_objects->name}}</td>
                    </tr>
                    <tr>
                        <td>НГДУ</td>
                        <td>{{$oilgas->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЦДНГ</td>
                        <td>{{$oilgas->cdng->name}}</td>
                    </tr>
                    <tr>
                        <td>ГУ</td>
                        <td>{{$oilgas->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЗУ</td>
                        <td>{{$oilgas->zu->name}}</td>
                    </tr>
                    <tr>
                        <td>Скважина</td>
                        <td>{{$oilgas->well->name}}</td>
                    </tr>
                    <tr>
                        <td>Плотность нефти при 20°С, кг/м3</td>
                        <td>{{ $oilgas->water_density_at_20 }}</td>
                    </tr>
                    <tr>
                        <td>Вязкость нефти при 20С, мм2/с</td>
                        <td>{{ $oilgas->oil_viscosity_at_20 }}</td>
                    </tr>
                    <tr>
                        <td>Вязкость нефти при 40С, мм2/с</td>
                        <td>{{ $oilgas->oil_viscosity_at_40 }}</td>
                    </tr>
                    <tr>
                        <td>Вязкость нефти при 50С, мм2/с</td>
                        <td>{{ $oilgas->oil_viscosity_at_50 }}</td>
                    </tr>
                    <tr>
                        <td>Вязкость нефти при 60С, мм2/с</td>
                        <td>{{ $oilgas->oil_viscosity_at_60 }}</td>
                    </tr>
                    <tr>
                        <td>H2S в газе, ppm</td>
                        <td>{{ $oilgas->hydrogen_sulfide_in_gas }}</td>
                    </tr>
                    <tr>
                        <td>О2 в газе, %</td>
                        <td>{{ $oilgas->oxygen_in_gas }}</td>
                    </tr>
                    <tr>
                        <td>CO2 в газе, %</td>
                        <td>{{ $oilgas->carbon_dioxide_in_gas }}</td>
                    </tr>
                    <tr>
                        <td>Плотность газа при 20°С, кг/м3</td>
                        <td>{{ $oilgas->gas_density_at_20 }}</td>
                    </tr>
                    <tr>
                        <td>Вязкость газа при 20С, сП</td>
                        <td>{{ $oilgas->gas_viscosity_at_20 }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('oilgas.index') }}">{{__('app.back')}}</a>
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
