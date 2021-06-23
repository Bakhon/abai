@extends('layouts.app')
@section('module_icon')

@endsection
@section('module_title', 'Геология')
@section('sidebar_menu_additional')
    @include('partials.sidebar.gno_menu')
@endsection
@section('content')
    <div class="geology">
        <div class="preloader" v-cloak></div>
        <div class="layout" v-cloak>
            <div class="layout__t-side">
                <Geology-T-Side />
            </div>
            <div class="layout__content layout__content--background layout__l-side">
                <Geology-L-Side />
            </div>
            <div class="layout__content layout__center">
                <Geology-Page />
            </div>
            <div class="layout__content layout__content--background layout__r-side">
                <Geology-R-Side />
            </div>
        </div>
    </div>
@endsection
{{--<link href="{{ asset('css/gis.css')}}" rel="stylesheet">--}}
