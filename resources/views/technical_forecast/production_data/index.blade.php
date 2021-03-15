@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_data_list') }}" class="btn btn-info">
                Вернуться в справочник</a>
        </div>
    </div>

    <div class="col p-4" id="app">
        <tech-data-component></tech-data-component>
    </div>
@endsection
