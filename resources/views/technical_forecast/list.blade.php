@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{ route('tech_data_forecast.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.forecast_data_production') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
