@extends('layouts.monitor')

@section('content')
    <div class="row"  >
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="x_panel">
                <h1>{{ trans('monitoring.pumps.create_title') }}</h1>
                <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i
                        class="fas fa-arrow-left"></i></a>
                <form action="{{ route('pumps.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <pumps-form :validation-params='@json($validationParams)'></pumps-form>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<style>
    body {
        color: white;
    }

    .table {
        color: white;
    }
</style>
