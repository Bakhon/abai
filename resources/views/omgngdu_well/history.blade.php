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
            <div class="container  table-page">
                <h1>{{ trans('monitoring.history.title') }}</h1>
                <edit-history :history='@json($omgngdu_well->history)'></edit-history>
                <a class="btn btn-primary" href="{{ route('omgngdu_well.index') }}">{{__('app.back')}}</a>
            </div>
        </div>
    </div>
@endsection
