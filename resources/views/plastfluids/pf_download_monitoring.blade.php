@extends('layouts.pf')
@section('content')
<div>
    <pf-download-monitoring :user="{{json_encode(auth()->user())}}"></pf-download-monitoring>
</div>
@endsection