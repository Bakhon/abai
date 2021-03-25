@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_data_list') }}" class="btn btn-info">
                {{ __('forecast.return_menu') }}</a>
        </div>
    </div>
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="{{ route('tech_refs_upload') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.upload_excel') }} </a>
                    <a href="{{ route('tech_data_log.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.delete_wrong_uploaded_data') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col p-4 bg-light" id="app">
        <tech-data-component></tech-data-component>
    </div>
@endsection
