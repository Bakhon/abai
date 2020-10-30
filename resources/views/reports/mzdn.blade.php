@extends('layouts.app')
@section('content')
    <div class="col p-4" id="app">
        <a href="{{url('/')}}/ru/export" class="float-right">
            <button type="button" class="btn btn-success">в Excel</button>
        </a>
        <h2 class="subtitle">Отчет месячной замерной добычи нефти</h2>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
                   <iframe onload="this.style.opacity=1;" style="opacity:0;border:none;" src="http://172.20.103.32:8080/superset/dashboard/20" width="100%" height="1050px" frameborder="0" allowfullscreen></iframe>
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


