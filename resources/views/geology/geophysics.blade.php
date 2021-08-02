@extends('layouts.app')
@section('module_icon')

@endsection
@section('module_title', 'Геология')
@section('sidebar_menu_additional')
    @include('partials.sidebar.gno_menu')
@endsection
@section('content')
    <page-geophysics></page-geophysics>
@endsection
