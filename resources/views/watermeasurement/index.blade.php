@extends('layouts.monitor')

@section('content')
    <div id="app">
        <view-table :params='@json($params)' :responsitive="true" ></view-table>
    </div>
@endsection
