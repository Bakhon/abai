@extends('layouts.db')
@section('content')
    <las :params='@json($permissionNames)'></las>
@endsection
<link href="{{ asset('css/bigdata.css')}}" rel="stylesheet">