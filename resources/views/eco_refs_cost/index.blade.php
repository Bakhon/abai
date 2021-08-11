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
                <div class="list-group text-center">
                    <a href="{{ route('economic_data_upload', ['is_forecast'=> $isForecast]) }}"
                       class="list-group-item list-group-item-action">
                        {{ __('economic_reference.upload_excel') }}
                    </a>

                    <a href="{{ route('economic_data_log.index') }}"
                       class="list-group-item list-group-item-action">
                        {{ __('economic_reference.delete_wrong_uploaded_data') }}
                    </a>

                    @if ($isForecast)
                        <a href="{{ route('eco_refs_scenario.index') }}"
                           class="list-group-item list-group-item-action">
                            {{ __('economic_reference.scenarios') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col p-4 bg-light"  >
        @if($isForecast)
            <economic-data-component is-forecast></economic-data-component>
        @else
            <economic-data-component></economic-data-component>
        @endif
    </div>
@endsection

<style>
    .container-main {
        overflow-x: auto;
    }
</style>
