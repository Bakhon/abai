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
                        <td>{{ trans('monitoring.materials.fields.name') }}</td>
                        <td>{{$material->name}}</td>
                    </tr>              
                    <tr>
                        <td>{{ trans('monitoring.materials.fields.yield_point') }}</td>
                        <td>{{ $material->thickness }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.roughness') }}</td>
                        <td>{{ $material->roughness }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.pipe_types.fields.material') }}</td>
                        <td>{{ $material->material_id }}</td>
                    </tr>
                    
                </table>
                <a class="btn btn-primary" href="{{ route('materials.index') }}">{{__('app.back')}}</a>
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
