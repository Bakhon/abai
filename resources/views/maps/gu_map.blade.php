@extends('layouts.monitor')
@section('content')
    <div class="col p-0" id="app">
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />
        <gu-map :gus='@json($gus)'></gu-map>
    </div>
@endsection
