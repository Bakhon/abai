@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center mb-3">
        <a href="{{ route('eco_refs_list') }}"
           class="btn btn-info">
            {{ __('economic_reference.return_menu') }}
        </a>

        <div class="mt-3 text-center">
            <a href="{{ route('economic.cost.upload', ['is_forecast'=> $isForecast]) }}"
               class="list-group-item list-group-item-action">
                {{ __('economic_reference.upload_excel') }}
            </a>

            <a href="{{ route('economic.log.index', ['type_id'=> $logType]) }}"
               class="list-group-item list-group-item-action">
                {{ __('economic_reference.delete_wrong_uploaded_data') }}
            </a>

            @if ($isForecast)
                <a href="{{ route('economic.scenario.index') }}"
                   class="list-group-item list-group-item-action">
                    {{ __('economic_reference.scenarios') }}
                </a>
            @endif
        </div>
    </div>

    @if($isForecast)
        <economic-data-cost-component is-forecast></economic-data-cost-component>
    @else
        <economic-data-cost-component></economic-data-cost-component>
    @endif
@endsection
