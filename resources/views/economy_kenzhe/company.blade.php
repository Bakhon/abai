@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <reptt-company :reptt="{{$repTtReportValues}}"></reptt-company>
            </div>
        </div>
    </div>
@endsection