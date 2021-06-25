@extends('layouts.db')

@section('content')
    <div id="app">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="x_panel">
            <h1>{{ trans('bd.forms.'.$modelName.'.edit_title') }}</h1>
            <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                <form action="{{ route($link.'.update', [$data->id]) }}" method="PUT">
                    @method('patch')
                    @csrf
                    <div class="row">
                        <geo-mapping-form :link = '@json($link)' :model-name='@json($modelName)' :is-editing="true" :dict-data='@json($data)' :validation-params='@json($validationParams)' :geo-list='@json($geoList)'></geo-mapping-form>
                    </div>
                </form>
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
