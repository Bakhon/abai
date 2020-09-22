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
            <div class="x_panel">
            <h1>Редактирование данных</h1>
                <form action="{{ route('updatewm') }}" method="POST">
                    @csrf
                    <div class="row">
                        <wm-edit :id={{ $wm->id }}></wm-edit>
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
