@extends('layouts.visualcenter')
@section('content')
<div>
        <div>
        <visual-center-table3 user-id={{Auth::id()}}></visual-center-table3>
        </div>
    </div>
<cat-loader />
@endsection
<link href="{{ asset('css/visualcenter3.css')}}" rel="stylesheet">