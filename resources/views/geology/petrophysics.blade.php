@extends('layouts.app')
@section('module_icon')

@endsection
@section('module_title', 'Геология')
@section('sidebar_menu_additional')
    @include('partials.sidebar.gno_menu')
@endsection
@section('content')
    <div class="geology ">
        <div class="preloader" v-cloak></div>
        <div class="layout gis" v-cloak>
            <div class="layout__t-side">
                <Geology-Top-Side />
            </div>
            <div class="layout__content layout__content--background layout__l-side">
                <Petrophysics-Left-Side />
            </div>
            <div class="layout__content layout__center">
                <Base-Petrophysics />
            </div>
            <div class="layout__content layout__content--background layout__r-side">
                <Petrophysics-Right-Side />
            </div>
        </div>
    </div>
@endsection
