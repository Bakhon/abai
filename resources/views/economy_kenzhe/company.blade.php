@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <reptt-company :data-reptt="{{$data}}"></reptt-company>
            </div>
        </div>
    </div>
@endsection