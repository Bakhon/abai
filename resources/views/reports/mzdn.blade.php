@extends('layouts.app')
@section('content')

<div class="background-table">
    <div  id="app">
        <a href="{{url('/')}}/ru/export" class="float-right">
            <!-- <button type="button" class="btn btn-success">в Excel</button> -->
        </a>
        <h2 class="subtitle">Отчет месячной замерной добычи нефти </h2>
        <div>
            <div class="main col-md-12 col-lg-12 ">
            <!-- <reports-table></reports-table> -->

                              </div>
                              <div >
                              <new-reports-table></new-reports-table>
                              </div>
                              
        </div>
    </div>
</div>
@endsection
<script>
$('select').selectpicker();
</script>

<style>

.background-table {
    Width: 1822px;
    Height: 960px;
    Top: 100px;
    right: 20px;
    left: 8px;
    background-color: #272953;
}
.fixed-columns {
    left: 0;
    background: #20274e!important;
}
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


