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
        <div class="layout core" v-cloak>
            <div class="layout__t-side">
                <Geology-T-Side />
            </div>
            <div class="layout__content layout__content--background layout__l-side">
                <Geology-Core-Left-Side />
            </div>
            <div class="layout__content layout__center">
                <Geology-Core />
            </div>
            <div class="layout__content layout__content--background layout__r-side">
                <Geology-Core-Right-Side />
            </div>
        </div>
    </div>
@endsection
