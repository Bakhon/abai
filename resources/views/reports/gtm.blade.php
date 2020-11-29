@extends('layouts.app')
@section('content')
    <div  id="app">
        <a href="{{url('/')}}/ru/export" class="float-right">
            <!-- <button type="button" class="btn btn-success">в Excel</button> -->
        </a>
        <h2 class="subtitle">Анализ эффективности ГТМ</h2>
        <div>
            <div class="main col-md-12 col-lg-12 ">
            <reports-table2></reports-table2>


        </div>
    </div>
@endsection
<style>
    .p-4{
        background-color: #0F1430;
    }
    .fixed-table-container{
        background: #20274e;
    }
   
    .bootstrap-table .fixed-table-container .table {

    color: white;
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
    .table-hover tbody tr:hover 
    {
    color: #d4d4d4 !important;
    background-color: rgba(0, 0, 0, 0.075);
}

</style>


