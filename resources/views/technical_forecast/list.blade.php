@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{ route('tech_refs_upload') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.source_data') }} </a>
                    <a href="{{ route('tech_struct_source.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.source_data') }}и данных </a>
                    <a href="{{ route('tech_struct_bkns.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.BKNS') }}</a>
                    <a href="{{ route('tech_struct_company.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.company') }}</a>
                    <a href="{{ route('tech_struct_field.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.field') }}</a>
                    <a href="{{ route('tech_struct_ngdu.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.NGDU') }}</a>
                    <a href="{{ route('tech_struct_cdng.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.CDNG') }}</a>
                    <a href="{{ route('tech_struct_gu.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.gu') }}</a>
                    <a href="{{ route('tech_data_forecast.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.oil_liquid_days_prs') }}</a>
                    <a href="{{ route('tech_data_log.index') }}" class="list-group-item list-group-item-action">
                        {{ __('forecast.delete_wrong_uploaded_data') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
