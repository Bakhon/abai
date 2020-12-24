@extends('layouts.tr')
@section('content')
    <div class="col px-4 trfa_page" id="app">
        <a href="{{url('/')}}/ru/export" class="float-right">
            <!-- <button type="button" class="btn btn-success">в Excel</button> -->
        </a>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
            <tr-charts-table></tr-charts-table>

            </div>
        </div>
        <cat-loader />
    </div>
@endsection
<link href="{{ asset('css/trfa.css')}}" rel="stylesheet">
<style>
    .p-4{
        background-color: #0F1430;
    }
    /* .main{
        background-color: #0F1430;
        background-image: url({{ asset('img/level1/grid.svg') }});
        border: 1px solid #0D2B4D;
        margin-left: 0px !important;
        padding-top: 20px;
    } */
    .title, .subtitle {
        color:white;
    }
    .top{
        display: none;
    }
</style>


