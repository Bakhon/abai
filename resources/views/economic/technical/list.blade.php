@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{ route('economic.technical.company.index') }}"
                       class="list-group-item list-group-item-action">
                        {{ __('forecast.mapping_company_tbd') }}
                    </a>
                    <a href="{{ route('economic.gtm.index') }}"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_gtm')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
