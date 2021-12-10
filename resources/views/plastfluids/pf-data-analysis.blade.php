@extends('layouts.app')
@section('content')
<pf-data-analysis :route="{{ json_encode(Request::path()) }}" :user="{{json_encode(auth()->user())}}"></pf-data-analysis>
@endsection