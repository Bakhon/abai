@extends('layouts.app')
@section('content')
    <div   >
        <a href="{{url('/')}}/ru/export" class="float-right">
            <!-- <button type="button" class="btn btn-success">в Excel</button> -->
        </a>
        <h2 class="subtitle">Ежедневная динамика показателей добычи по скважинам</h2>
        <div>
            <div class="main col-md-12 col-lg-12 ">
            <reports-table3></reports-table3>


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
    .fixed-columns {
     background-color: #20274e !important;;

   }
   .fixed-columns-right {
     background-color: #20274e !important;;

   }

</style>


