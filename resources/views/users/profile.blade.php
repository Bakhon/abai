@extends('layouts.app')
@section('content')
    <Profile :user="{{json_encode(auth()->user()->load('profile'))}}"></Profile>
@endsection