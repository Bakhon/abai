@extends('layouts.app')
@section('content')
<div class="col p-4">
    <div>    
        <h1>Оперативная информация по ДЗО для АО "НК "КазМунайГаз""</h1>
        <form action="{{ route('viscenter2.store') }}" method="POST">
        @csrf  
        <viscenter2-create></viscenter2-create>
        </form>
    </div>
</div>
@endsection
<link href="{{ asset('css/visualcenter2.css')}}" rel="stylesheet">