@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center mb-3">
        <a href="{{ route('eco_refs_list') }}"
           class="btn btn-info">
            {{ __('economic_reference.return_menu') }}
        </a>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
        <a href="{{ route('paegtm-gtm-fact-costs-upload-excel') }}" class="text-decoration-none">
            <h4 class="text-secondary cursor-pointer mb-0">
                {{ __('paegtm.gtm_fact_costs') }}
            </h4>
        </a>
    </div>
@endsection
