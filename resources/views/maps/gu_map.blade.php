@extends('layouts.app')
@section('content')
    <div class="col p-4" id="app">
        <h2 class="subtitle">Карта</h2>
        <gu-map :gus='@json($gus)'></gu-map>
    </div>
@endsection
