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
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.name') }}</td>
                        <td>{{$pipe_type->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.outside_diameter') }}</td>
                        <td>{{ $pipe_type->outside_diameter }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.inner_diameter') }}</td>
                        <td>{{ $pipe_type->inner_diameter }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.thickness') }}</td>
                        <td>{{ $pipe_type->thickness }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.roughness') }}</td>
                        <td>{{ $pipe_type->roughness }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.material') }}</td>
                        <td>{{ $pipe_type->material_id }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.plot') }}</td>
                        <td>{{ $pipe_type->plot }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('pipes.index') }}">{{__('app.back')}}</a>
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
