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
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($pumps->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu.gu') }}</td>
                        <td>{{$pumps->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pumps.number') }}</td>
                        <td>{{$pumps->number}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.model') }}</td>
                        <td>{{$pumps->model}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.type') }}</td>
                        <td>{{ $pumps->type }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pumps.perfomance') }}</td>
                        <td>{{ $pumps->perfomance }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pumps.power') }}</td>
                        <td>{{ $pumps->date_of_exploitation }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.date_of_exploitation') }}</td>
                        <td>{{ $pumps->date_of_exploitation }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.current_state') }}</td>
                        <td>{{ $pumps->current_state }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.date_of_repair') }}</td>
                        <td>{{ $pumps->date_of_repair }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.type_of_repair') }}</td>
                        <td>{{ $pumps->type_of_repair }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('pumps.index') }}">{{__('app.back')}}</a>
            </div>
        </div>
    </div>
@endsection
<style>
    body{
        color: white;
    }

    .table{
        color: white;
    }
</style>
