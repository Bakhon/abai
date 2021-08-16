@extends('layouts.monitor')

@section('content')
    <div class="row">
        <div class="col-md-12 ">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="container table-page">
                <h1>{{ trans('monitoring.show_title') }}</h1>
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($omgngdu_zu->date)->format('d.m.Y')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.ngdu') }}</td>
                        <td>{{$omgngdu_zu->zu->gu->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu.gu') }}</td>
                        <td>{{$omgngdu_zu->zu->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.zu.zu') }}</td>
                        <td>{{$omgngdu_zu->zu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_fluid_production') }}</td>
                        <td>{{$omgngdu_zu->daily_fluid_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_water_production') }}</td>
                        <td>{{$omgngdu_zu->daily_water_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_oil_production') }}</td>
                        <td>{{$omgngdu_zu->daily_oil_production}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.daily_gas_production_in_sib') }}</td>
                        <td>{{$omgngdu_zu->gas_factor}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.bsw') }}</td>
                        <td>{{$omgngdu_zu->bsw}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.surge_tank_pressure') }}</td>
                        <td>{{$omgngdu_zu->pressure}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu.fields.heater_inlet_temperature') }}</td>
                        <td>{{$omgngdu_zu->temperature}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu_well.fields.sg_oil') }}</td>
                        <td>{{$omgngdu_zu->sg_oil}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu_well.fields.sg_gas') }}</td>
                        <td>{{$omgngdu_zu->sg_gas}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgngdu_well.fields.sg_water') }}</td>
                        <td>{{$omgngdu_zu->sg_water}}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('omgngdu-zu.index') }}">{{__('app.back')}}</a>
            </div>
        </div>
    </div>
@endsection
