@extends('layouts.db')

@section('content')
    <div class="row" id="app">
        <proto-form :well-id="{{$well->id}}"></proto-form>
    </div>
@endsection