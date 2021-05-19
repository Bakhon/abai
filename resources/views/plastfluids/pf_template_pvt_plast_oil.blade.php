@extends('layouts.pf')
@section('content')
    <div class="col p-4" id="app">
        <a href="{{url('/')}}/ru/export" class="float-right">
        </a>
        <div class="level1-content row">
            <div class="main col-md-12 col-lg-12 row">
                
                <pf-template_pvt_plast_oil></pf-template_pvt_plast_oil>
                
            </div>
        </div>
        <cat-loader />
    </div>
@endsection
<!-- <link href="{{ asset('css/tr.css')}}" rel="stylesheet">
<link href="{{ asset('css/tr_unit.css')}}" rel="stylesheet"> -->
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