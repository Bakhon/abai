@extends('layouts.app')
@section('content')
    <div class="col p-4" id="app">
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />
        <h1>Карта</h1>
        <gu-map :gus='@json($gus)'></gu-map>
    </div>
@endsection
