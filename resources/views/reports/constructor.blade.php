@extends('layouts.app')
@section('content')
    <div class="col p-4" id="app">
        <h2 class="subtitle">Конструктор отчётов</h2>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
                <economicpivot></economicpivot>
            </div>
        </div>
    </div>
@endsection
<style>
    .p-4{
        background-color: #0F1430;
    }
    .main{
        background-color: #0F1430;
        background-image: url({{ asset('img/level1/grid.svg') }});
        border: 1px solid #0D2B4D;
        margin-left: 0px !important;
        padding-top: 20px;
        color: white !important;
    }
    .title, .subtitle {
        color:white;
    }
    .table-responsive{
        color:white !important;
    }
    .table{
        color:white !important;
    }
</style>


