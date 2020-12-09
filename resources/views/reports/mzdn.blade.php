@extends('layouts.app')
@section('content')
<div class="background-table">
    <h2 class="subtitle">Отчет месячной замерной добычи нефти </h2>
    <new-reports-table></new-reports-table>
</div>
@endsection
<link href="{{ asset('css/mzdn.css')}}" rel="stylesheet">
