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
                        <td>{{$ovens->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.ovens.cipher') }}</td>
                        <td>{{$ovens->cipher}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.type') }}</td>
                        <td>{{ $ovens->type }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.ovens.rated_heat_output') }}</td>
                        <td>{{ $ovens->rated_heat_output }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.date_of_exploitation') }}</td>
                        <td>{{ $ovens->date_of_exploitation }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.current_state') }}</td>
                        <td>{{ $ovens->current_state }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.date_of_repair') }}</td>
                        <td>{{ $ovens->date_of_repair }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.buffer_tank.type_of_repair') }}</td>
                        <td>{{ ovens->type_of_repair }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('ovens.index') }}">{{__('app.back')}}</a>
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
