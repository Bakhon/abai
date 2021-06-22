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
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($corrosion->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.field') }}</td>
                        <td>
                            @if ($corrosion->field === 1)
                                Узень
                            @else
                                Карамандыбас
                            @endif
                        </td>
                    </tr>
                    {{-- <tr>
                        <td>{{ trans('monitoring.ngdu') }}</td>
                        <td>{{$corrosion->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.cdng') }}</td>
                        <td>{{$corrosion->cdng->name}}</td>
                    </tr> --}}
                    <tr>
                        <td>{{ trans('monitoring.gu.gu') }}</td>
                        <td>{{$corrosion->gu->name}}</td>
                    </tr>
                    
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.background_corrosion_velocity') }}</td>
                        <td>{{ $corrosion->background_corrosion_velocity }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu.fields.date') }}</td>
                        <td>{{ $corrosion->date_for_corrosion }}</td>
                    </tr>
                    
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.corrosion_velocity_with_inhibitor') }}</td>
                        <td>{{ $corrosion->carbon_dioxide }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.sample_number') }}</td>
                        <td>{{ $corrosion->date_for_carbon_dioxide }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.weight_before') }}</td>
                        <td>{{ $corrosion->volume_fractions_for_carbon_dioxide }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.days') }}</td>
                        <td>{{ $corrosion->surge_tank_pressure }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.weight_after') }}</td>
                        <td>{{ $corrosion->carbon_dioxide_pressure }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.avg_speed') }}</td>
                        <td>{{ $corrosion->hydrogen_sulfide_in_gas }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.avg_speed') }}</td>
                        <td>{{ $corrosion->date_for_hydrogen_sulfide }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.avg_speed') }}</td>
                        <td>{{ $corrosion->volume_fractions_for_hydrogen_sulfide }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.avg_speed') }}</td>
                        <td>{{ $corrosion->hydrogen_sulfide_in_gas_pressure }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.corrosion.fields.avg_speed') }}</td>
                        <td>{{ $corrosion->calculated_corrosion_speed }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('corrosioncrud.index') }}">{{__('app.back')}}</a>
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
