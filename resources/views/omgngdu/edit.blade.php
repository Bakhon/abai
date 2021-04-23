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
                <h1>{{ trans('monitoring.omgngdu.edit_title') }}</h1>
                <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                <form action="{{ route('omgngdu.update', ['omgngdu' => $omgngdu->id]) }}" method="POST">
                    @method('patch')
                    @csrf
                    <div class="row">
                        <omgngdu-form :omgngdu='@json($omgngdu)' :validation-params='@json($validationParams)'></omgngdu-form>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
