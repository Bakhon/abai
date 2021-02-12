@extends('layouts.monitor')

@section('content')
    <div class="row" id="app">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="x_panel">
                <h1>{{ trans('monitoring.corrosion.create_title') }}</h1>
                <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i
                        class="fas fa-arrow-left"></i></a>
                <form action="{{ route('corrosioncrud.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <corrosion-form :validation-params='@json($validationParams)'></corrosion-form>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<style>
    body {
        color: white !important;
    }

    .table {
        color: white !important;
    }
</style>
