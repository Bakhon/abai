@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center mb-3">
        <a href="{{ route('eco_refs_gtm.index') }}"
           class="btn btn-info">
            {{ __('app.back') }}
        </a>

        <div class="mt-3 text-center">
            <a href="{{ route('eco_refs_gtm_value_upload') }}"
               class="list-group-item list-group-item-action">
                {{ __('economic_reference.upload_excel') }}
            </a>
        </div>
    </div>

    <economic-data-gtm-value-component></economic-data-gtm-value-component>
@endsection
