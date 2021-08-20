@extends('layouts.monitor')

@section('content')
    <div  >
        <view-table :params='@json($params)' :isResponsive="true" ></view-table>
    </div>
@endsection
