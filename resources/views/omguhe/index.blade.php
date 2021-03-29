@extends('layouts.monitor')

@section('content')
    <div id="app">
        @if ($message = Session::get('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p>{{ $message }}</p>
            </div>
        @endif
        <view-table :params='@json($params)'></view-table>
    </div>
@endsection
