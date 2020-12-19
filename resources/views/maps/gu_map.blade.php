@extends('layouts.app')
@section('content')
    <div class="col p-4" id="app">
        <h1>Карта</h1>
        <gu-map :gus='@json($gus)'></gu-map>
    </div>
@endsection
