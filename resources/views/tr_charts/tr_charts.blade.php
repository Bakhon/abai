@extends('layouts.tr')
@section('content')
    <div class="col px-4 trfa_page" id="app">
        <a href="{{url('/')}}/ru/export" class="float-right">
        </a>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
            <tr-charts-table></tr-charts-table>

            </div>
        </div>
    </div>
@endsection
<link href="{{ asset('css/trfa.css')}}" rel="stylesheet">
<link href="{{ asset('css/tr_unit.css')}}" rel="stylesheet">
<style>
    .p-4{
        background-color: #0F1430;
    }
    .title, .subtitle {
        color:white;
    }
    .top{
        display: none;
    }
</style>


