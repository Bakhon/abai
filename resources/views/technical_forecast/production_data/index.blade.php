@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center mb-3">
        <a href="{{ route('tech_data_list') }}"
           class="btn btn-info">
            {{ __('economic_reference.return_menu') }}
        </a>

        <div class="mt-3 text-center">
            <a href="{{ route('tech_refs_upload') }}"
               class="list-group-item list-group-item-action">
                {{ __('economic_reference.upload_excel') }}
            </a>

            <a href="{{ route('tech_data_log.index') }}"
               class="list-group-item list-group-item-action">
                {{ __('economic_reference.delete_wrong_uploaded_data') }}
            </a>
        </div>
    </div>

    <tech-data-component></tech-data-component>
@endsection
