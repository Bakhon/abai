@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('eco_refs_list') }}"
               class="btn btn-info">
                {{ __('economic_reference.return_menu') }}
            </a>
        </div>
    </div>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="{{ route('economic_data_upload', ['is_forecast'=> 1]) }}"
                       class="list-group-item list-group-item-action">
                        {{ __('economic_reference.upload_excel') }}
                    </a>

                    <a href="{{ route('economic_data_log.index') }}"
                       class="list-group-item list-group-item-action">
                        {{ __('economic_reference.delete_wrong_uploaded_data') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col" id="app">
        <economic-data-scenario-component></economic-data-scenario-component>
    </div>
@endsection