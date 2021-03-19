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
                <h1>{{ trans('monitoring.show_title') }}</h1>
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($omgngdu->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.field') }}</td>
                        <td>{{$omgngdu->field->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.ngdu') }}</td>
                        <td>{{$omgngdu->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.cdng') }}</td>
                        <td>{{$omgngdu->cdng->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu.gu') }}</td>
                        <td>{{$omgngdu->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.zu.zu') }}</td>
                        <td>{{$omgngdu->zu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.well.well') }}</td>
                        <td>{{$omgngdu->well->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_fluid_production') }}</td>
                        <td>{{$omgngdu->daily_fluid_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_water_production') }}</td>
                        <td>{{$omgngdu->daily_water_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_oil_production') }}</td>
                        <td>{{$omgngdu->daily_oil_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_gas_production_in_sib') }}</td>
                        <td>{{$omgngdu->daily_gas_production_in_sib}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.bsw') }}</td>
                        <td>{{$omgngdu->bsw}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.surge_tank_pressure') }}</td>
                        <td>{{$omgngdu->surge_tank_pressure}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.pump_discharge_pressure') }}</td>
                        <td>{{$omgngdu->pump_discharge_pressure}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.heater_inlet_pressure') }}</td>
                        <td>{{$omgngdu->heater_inlet_pressure}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.heater_output_pressure') }}</td>
                        <td>{{$omgngdu->heater_output_pressure}}</td>
                    </tr>
                </table>
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
