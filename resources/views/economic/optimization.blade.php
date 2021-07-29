@extends('layouts.app')
@section('content')
    <div id="app" class="col-sm-12">
        <economic-optimization></economic-optimization>
    </div>
@endsection
<style>
    .main {
        background-color: #0F1430;
        background-image: url({{ asset('img/level1/grid.svg') }});
        border: 1px solid #0D2B4D;
        margin-bottom: 15px;
    }
</style>
