@extends('layouts.monitor')

@section('content')
    <div   >
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="x_panel">
                <h1>{{ trans('monitoring.omguhe.edit_title') }}</h1>
                <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                <form action="{{ route('omguhe.update', $omguhe) }}" method="POST">
                    @method('patch')
                    @csrf
                    <omguhe-form :omguhe='@json($omguhe)' :validation-params='@json($validationParams)' :is-editing="true"></omguhe-form>
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
