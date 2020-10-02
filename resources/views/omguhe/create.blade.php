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
            <h1>Ввод данных ОМГ УХЭ</h1>
            <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                <form action="{{ route('omguhe.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <omguhe-create></omguhe-create>
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
