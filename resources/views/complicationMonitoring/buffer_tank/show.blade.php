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
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($buffer_tank->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu.gu') }}</td>
                        <td>{{$buffer_tank->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.model') }}</td>
                        <td>{{$buffer_tank->start_date_of_background_corrosion}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.name') }}</td>
                        <td>{{$buffer_tank->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.type') }}</td>
                        <td>{{ $buffer_tank->background_corrosion_velocity }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.volume') }}</td>
                        <td>{{ $buffer_tank->volume }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.date_of_exploitation') }}</td>
                        <td>{{ $buffer_tank->date_of_exploitation }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.current_state') }}</td>
                        <td>{{ $buffer_tank->current_state }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.external_and_interlan_inspection') }}</td>
                        <td>{{ $buffer_tank->external_and_interlan_inspectio }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.hydraulic_test') }}</td>
                        <td>{{ $buffer_tank->hydraulic_test }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.date_of_repair') }}</td>
                        <td>{{ $buffer_tank->date_of_repair }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.type_of_repair') }}</td>
                        <td>{{ $buffer_tank->type_of_repair }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('buffer_tank.index') }}">{{__('app.back')}}</a>
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
