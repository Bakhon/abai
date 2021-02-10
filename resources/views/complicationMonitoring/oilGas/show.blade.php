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
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($oilgas->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.other_objects') }}</td>
                        <td>{{$oilgas->other_objects->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.ngdu') }}</td>
                        <td>{{$oilgas->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.cdng') }}</td>
                        <td>{{$oilgas->cdng->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu') }}</td>
                        <td>{{$oilgas->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.zu') }}</td>
                        <td>{{$oilgas->zu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.well') }}</td>
                        <td>{{$oilgas->well->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.water_density_at_20') }}</td>
                        <td>{{ $oilgas->water_density_at_20 }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.oil_viscosity_at_20') }}</td>
                        <td>{{ $oilgas->oil_viscosity_at_20 }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.oil_viscosity_at_40') }}</td>
                        <td>{{ $oilgas->oil_viscosity_at_40 }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.oil_viscosity_at_50') }}</td>
                        <td>{{ $oilgas->oil_viscosity_at_50 }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.oil_viscosity_at_60') }}</td>
                        <td>{{ $oilgas->oil_viscosity_at_60 }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.hydrogen_sulfide_in_gas') }}</td>
                        <td>{{ $oilgas->hydrogen_sulfide_in_gas }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.oxygen_in_gas') }}</td>
                        <td>{{ $oilgas->oxygen_in_gas }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.carbon_dioxide_in_gas') }}</td>
                        <td>{{ $oilgas->carbon_dioxide_in_gas }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.gas_density_at_20') }}</td>
                        <td>{{ $oilgas->gas_density_at_20 }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.oil.fields.gas_viscosity_at_20') }}</td>
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
