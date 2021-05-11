@extends('layouts.monitor')

@section('content')
    <div id="app">
        <view-table :params='@json($params)' :isResponsive="true" ></view-table>
    </div>
@endsection
