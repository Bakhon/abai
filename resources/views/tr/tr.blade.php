@extends('layouts.app')
@section('content')
    <div class="col p-4 tr_page" id="app">
        <a href="{{url('/')}}/ru/export" class="float-right">
            <!-- <button type="button" class="btn btn-success">в Excel</button> -->
        </a>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
            <tr-table></tr-table>

            </div>
        </div>
    </div>
@endsection
<link href="{{ asset('css/tr.css')}}" rel="stylesheet">
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


