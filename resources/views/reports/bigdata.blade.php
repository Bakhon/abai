@extends('layouts.app')
@section('content')
    <div class="col p-4" id="app">
        <h2 class="subtitle">Big data</h2>   
           <div class="level1-content row">       
            <div class="main col-md-12 col-lg-12 row"> 
            <div style="float:left">
        <button onclick="document.location='{{url('/')}}/ru/mzdn'" type="button" class="btn report-btn">Отчёт месячной замерной нефти</button>
</div>
        <div>
        <button onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="btn report-btn">Конструктор отчётов</button> 
        </div>
                <div class="emptyPage"></div>
         
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
    }
    .title, .subtitle {
        color:white;
    }
    .top{
        display: none;
    }
</style>


