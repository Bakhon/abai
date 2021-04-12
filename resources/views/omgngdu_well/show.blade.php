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
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($omgngdu_well->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.well.well') }}</td>
                        <td>{{$omgngdu_well->well->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_fluid_production') }}</td>
                        <td>{{$omgngdu_well->daily_fluid_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_water_production') }}</td>
                        <td>{{$omgngdu_well->daily_water_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_oil_production') }}</td>
                        <td>{{$omgngdu_well->daily_oil_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_gas_production_in_sib') }}</td>
                        <td>{{$omgngdu_well->gas_factor}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.bsw') }}</td>
                        <td>{{$omgngdu_well->bsw}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.surge_tank_pressure') }}</td>
                        <td>{{$omgngdu_well->pressure}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.heater_inlet_temperature') }}</td>
                        <td>{{$omgngdu_well->temperature}}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('omgngdu_well.index') }}">{{__('app.back')}}</a>
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
