@extends('layouts.app')
@section('sidebar_menu_additional')
    @include('partials.sidebar.visualcenter_menu')
@endsection
@section('module_icon')
    <img src="/img/gno/kpi.png" width="25" height="25" class="companyLogo">
@endsection
@section('module_title', __('visualcenter.kpdModuleTitle'))