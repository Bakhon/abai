@extends('layouts.db')

@section('content')
    <div class="row"  >
        <proto-form :well-id="{{$well->id}}"></proto-form>
    </div>
@endsection