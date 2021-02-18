@extends('layouts.app')
@section('content')
<div class="col p-4">
    <h1>Оперативная информация по ДЗО для АО "НК "КазМунайГаз""</h1>
    <form action="{{ route('excelform2.store') }}" method="POST">
        @csrf
        <visualcenter3-excelform></visualcenter3-excelform>
    </form>
    <link href="{{ asset('css/visualcenter/handsontable.full.min.css')}}" rel="stylesheet">    
    <script src="{{ asset('js/visualcenter/handsontable.full.min.js')}}"></script>      
</div>
@endsection
