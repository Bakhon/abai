@extends('layouts.app')
@section('content')
<pf-data-analysis :route="{{ json_encode(Request::path()) }}"></pf-data-analysis>
@endsection