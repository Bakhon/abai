@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="/css/digital_drilling.css">
    <div class="digital_drilling">
        <import-daily-raport />
    </div>
@endsection
@section('sidebar_menu_additional')
    @include('partials.sidebar.digital_drilling_menu')
@endsection