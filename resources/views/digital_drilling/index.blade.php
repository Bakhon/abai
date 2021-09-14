@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="/css/digital_drilling.css">
    <digital-drilling />
@endsection
@section('sidebar_menu_additional')
    @include('partials.sidebar.digital_drilling_menu')
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/digital-drilling/mapdata.js"></script>
<script src="/js/digital-drilling/countrymap.js"></script>
