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
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($agzu->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu.gu') }}</td>
                        <td>{{$agzu->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.model') }}</td>
                        <td>{{$agzu->model}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.agzu.method_of_measurement') }}</td>
                        <td>{{ $agzu->method_of_measurement }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.agzu.number_of_connected_wells') }}</td>
                        <td>{{ $agzu->number_of_connected_wells }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.date_of_exploitation') }}</td>
                        <td>{{ $agzu->date_of_exploitation }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.current_state') }}</td>
                        <td>{{ $agzu->current_state }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.date_of_repair') }}</td>
                        <td>{{ $agzu->date_of_repair }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.type_of_repair') }}</td>
                        <td>{{ $agzu->type_of_repair }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('agzu.index') }}">{{__('app.back')}}</a>
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
