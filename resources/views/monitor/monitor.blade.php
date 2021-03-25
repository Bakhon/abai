@extends('layouts.monitor')
@section('content')
    <monitor-table :gu="{{$gu ? $gu->id : 'null'}}"></monitor-table>
@endsection
<link href="{{ asset('css/monitor.css')}}" rel="stylesheet">
