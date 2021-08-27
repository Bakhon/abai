@extends('layouts.db')

@section('content')
    <div  >
        <view-table :params='@json($params)'></view-table>
    </div>
@endsection
