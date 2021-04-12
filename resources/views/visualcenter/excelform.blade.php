@extends('layouts.app')
@section('content')
<div class="col">
    <h1 class="header-block p-2">Оперативная информация по ДЗО для АО НК "КазМунайГаз"</h1>
    <form action="{{ route('excelform2.store') }}" method="POST">
        @csrf
        <visualcenter3-excelform user-id={{Auth::id()}}></visualcenter3-excelform>
    </form>
  
    
</div>
@endsection
<style>
    .header-block {
        background-color: #272953;
        margin-left: -15px;
        margin-right: -15px;
    }
</style
