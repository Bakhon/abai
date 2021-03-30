@extends('layouts.app')
@section('content')
<div class="col p-4">
    <h1>Оперативная информация по ДЗО для АО "НК "КазМунайГаз""</h1>
    <form action="{{ route('excelform2.store') }}" method="POST">
        @csrf
        <visualcenter3-excelform user-id={{Auth::id()}}></visualcenter3-excelform>
    </form>
  
    
</div>
@endsection
