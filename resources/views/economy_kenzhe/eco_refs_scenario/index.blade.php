@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-centermt-5">
            <a href="{{ route('eco_refs_list') }}"
               class="btn btn-info">
                {{ __('economic_reference.return_menu') }}
            </a>
        </div>
    </div>

    <div class="mt-4 col"  >
        <economic-data-scenario-component></economic-data-scenario-component>
    </div>
@endsection