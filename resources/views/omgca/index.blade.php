@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('omgca.export') }}"><i class="fas fa-file-export"></i></a>
                <a class="btn btn-success" href="{{ route('omgca.create') }}">+</a>
            </div>
            <h1 style="color:#fff">База данных ОМГ ДДНГ</h1>
            <table-editor></table-editor>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <omgca-table></omgca-table>
            </div>
        </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
