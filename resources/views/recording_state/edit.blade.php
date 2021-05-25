@extends('layouts.monitor')

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
            <h1>{{ trans('monitoring.recording_state.edit_title') }}</h1>
            <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                <form action="{{ route('recording_state.update', ['recording_state' => $recording_state->id]) }}" method="PUT">
                    @method('patch')
                    @csrf
                    <div class="row">
                        <file-status-form :is-editing="true" :file-status='@json($recording_state)' :validation-params='@json($validationParams)'></file-status-form>
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
