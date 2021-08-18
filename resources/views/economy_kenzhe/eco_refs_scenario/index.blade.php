@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <a href="{{ route('eco_refs_list') }}"
           class="btn btn-info">
            {{ __('economic_reference.return_menu') }}
        </a>
    </div>

    <div class="mt-4">
        <economic-data-scenario-component></economic-data-scenario-component>
    </div>
@endsection