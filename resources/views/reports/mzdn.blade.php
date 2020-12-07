@extends('layouts.app')
@section('content')

<div  id="app">
        <a href="{{url('/')}}/ru/export" class="float-right">
            <!-- <button type="button" class="btn btn-success">в Excel</button> -->
        </a>
        <div>
            <div class="main col-md-12 col-lg-12 ">
            <!-- <reports-table></reports-table> -->

                              </div>
                              <div >
                            <div class="background-table">
                              <h2 class="subtitle">Отчет месячной замерной добычи нефти </h2>
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

.underHeader {
    position: relative;
    Width: 1795px;
    Height: 866px;
}
.underHeader > .col-sm1{
    width: 438px;
    right: 1500px;
}
/* .underHeader > .col-sm2 > .form-group2 > .dropdown bootstrap-select show-tick{
    width: 438px;
    left: 65px;
    bottom: 51px;
}
.underHeader > .col-sm3 {
    width: 438px;
    left: 515px;
    bottom: 101px;
}
.underHeader > .col-sm4 > .form-group4 > .btn report-btn{
    width: 451px;
    height: 40px;
} */

.background-table {
    Width: 1822px;
    Height: 960px;
    position: absolute;
    Top: 60px;
    right: 20px;
    left: 8px;
    background-color: #272953;
}
/* #companySelect {
    background-color: #333975;
    border-color: rgb(32, 39, 78);
    color: white;
    width: 438px;
} */
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
        position: absolute;
        top: 100px;
        left: -18px;
        font-size: 18px;
        font-family: Harmonia Sans Pro Cyr;

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


