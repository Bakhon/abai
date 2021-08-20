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
                <h1>{{ trans('monitoring.buffer_tank.edit_title') }}</h1>
                <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i
                        class="fas fa-arrow-left"></i></a>
                <form action="{{ route('buffer-tank.update', $buffer_tank->id) }}" method="POST">
                    @method('patch')
                    @csrf
                    <div class="row">
                        <buffer-tank-form :buffer_tank='@json($buffer_tank)' :validation-params='@json($validationParams)'></buffer-tank-form>
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
