@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center mb-3">
        <a href="{{ route('eco_refs_list') }}"
           class="btn btn-info">
            {{ __('economic_reference.return_menu') }}
        </a>

        <div class="mt-3 text-center">
            <a href="{{ route('eco_refs_gtm_upload') }}"
               class="list-group-item list-group-item-action">
                {{ __('economic_reference.upload_excel') }}
            </a>

            <a href="{{ route('eco_refs_gtm_value.index') }}"
               class="list-group-item list-group-item-action">
                {{ __('economic_reference.eco_refs_gtm_values') }}
            </a>
        </div>
    </div>

    <economic-data-gtm-component></economic-data-gtm-component>
@endsection
