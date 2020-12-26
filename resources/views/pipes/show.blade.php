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
                        <td>{{ trans('monitoring.gu') }}</td>
                        <td>{{$pipe->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe.fields.length') }}</td>
                        <td>{{ $pipe->length }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe.fields.outside_diameter') }}</td>
                        <td>{{ $pipe->outside_diameter }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe.fields.inner_diameter') }}</td>
                        <td>{{ $pipe->inner_diameter }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe.fields.thickness') }}</td>
                        <td>{{ $pipe->thickness }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe.fields.roughness') }}</td>
                        <td>{{ $pipe->roughness }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe.fields.material') }}</td>
                        <td>{{ $pipe->material_id }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe.fields.plot') }}</td>
                        <td>{{ $pipe->plot }}</td>
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
