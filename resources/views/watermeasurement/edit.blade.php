@extends('layouts.app')

@section('content')
    <div class="row" id="app">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a><hr>
            <div class="container">
                <h1>Редактирование данных по воде</h1>
                <form action="{{ route('watermeasurement.update', ['watermeasurement' => $watermeasurement->id]) }}" method="POST">
                    @method('patch')
                    @csrf
                    <div class="row">
                        <wm-form :wm='@json($watermeasurement)' :validation-params='@json($validationParams)'></wm-form>
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
