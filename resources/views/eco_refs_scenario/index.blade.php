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

    <div class="mt-2 col" id="app">
        <economic-data-scenario-component></economic-data-scenario-component>
    </div>
@endsection

<style>
    .container-main {
        overflow-x: auto;
    }
</style>
