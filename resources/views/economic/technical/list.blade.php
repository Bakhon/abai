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
                </div>
            </div>
        </div>
    </div>
@endsection
