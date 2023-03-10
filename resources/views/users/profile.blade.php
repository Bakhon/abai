@extends('layouts.app')
@section('content')
    <Profile :user="{{json_encode(auth()->user()->load('profile'))}}" :logs="{{ json_encode($logs) }}" :modules="{{ json_encode($modules) }}" :other_modules="{{ json_encode($other_modules) }}" :accesses="{{ json_encode($accesses) }}"></Profile>
@endsection