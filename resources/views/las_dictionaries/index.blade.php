@extends('layouts.db')

@section('content')
    <div id="app">
        <view-table :params='@json($params)'></view-table>
    </div>
@endsection
