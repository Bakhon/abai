@extends('layouts.visualcenter')
@section('content')
<div>
    <visual-center-table3 user-id={{Auth::id()}} oil-dynamic-route="{{ route('oil-dynamic') }}"></visual-center-table3>
</div>
@endsection
<link href="{{ asset('css/visualcenter3.css')}}" rel="stylesheet">