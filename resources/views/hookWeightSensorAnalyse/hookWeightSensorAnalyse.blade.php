@extends('layouts.tr')
@section('content')
    <div class="col px-4 tkrs_page"  >
        <a href="{{url('/')}}/ru/export" class="float-right">
        </a>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
            <hook-weight-sensor-analyse></hook-weight-sensor-analyse>

            </div>
        </div>
    </div>
@endsection
<link href="{{ asset('css/main_tkrs.scss')}}" rel="stylesheet">
<!-- <link href="{{ asset('css/tr_unit.css')}}" rel="stylesheet"> -->
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