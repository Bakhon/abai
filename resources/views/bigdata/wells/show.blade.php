@extends('layouts.db')

@section('content')
    <div class="row">
        <bigdata-form :well-id="{{$well->id}}"></bigdata-form>
    </div>
@endsection