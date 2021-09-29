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
                <h1>{{ trans('monitoring.zu_cleanings.create_title') }}</h1>
                <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                <form action="{{ route('zu-cleanings.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <zu-cleanings-form type="create" :validation-params='@json($validationParams)'></zu-cleanings-form>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<style>
    body{
        color: white;
    }

    .table{
        color: white;
    }
</style>
