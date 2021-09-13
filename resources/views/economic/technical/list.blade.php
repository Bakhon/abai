@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{ route('tech_struct_company.index') }}"
                       class="list-group-item list-group-item-action">
                        {{ __('forecast.mapping_company_tbd') }}
                    </a>
                    <a href="{{ route('tech-data-forecast.index') }}"
                       class="list-group-item list-group-item-action">
                        {{ __('forecast.forecast_data_production') }}
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
