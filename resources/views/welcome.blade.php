@extends('layouts.app')
@section('content')
    {{-- content --}}
    <div id="app"></div>
    <div class="col p-4">
        <div class="level1-content row">
            <div>
                <div class="level1-tab"  tabindex="-1">Общие данные</div>
                <div class="level1-tab"  tabindex="-1">Аналитика</div>
            </div>
            <div class="main col-md-7 col-lg-7">
                <img src="{{ asset('img/level1/map_kz.svg') }}" class="map" alt="">
            </div>
            <div class="right-bar col-md-5 col-lg-5">
                <div>
                    <div class="right-tab"  tabindex="-1"></div>
                    <div class="right-tab"  tabindex="-1"></div>
                    <div class="right-tab"  tabindex="-1"></div>
                    <div class="right-tab"  tabindex="-1"></div>
                </div>
                <div class="info-panel"></div>
            </div>
        </div>
    </div>
@endsection
<style>
    .p-4{
        background-color: #0F1430;
    }
    .level1-tab{
        width: 390px;
        height: 25px;
        background-color: #0F254A;
        color: #41638A;
        display: inline-block;
        text-align: center;
    }
    .level1-tab:focus{
        background-color: #15509D;
        color: #FFFFFF;
        border: none;
    }
    .main{
        /* width: 980px; */
        height: 902px;
        background-color: #0F1430;
        background-image: url({{ asset('img/level1/grid.svg') }});
        border: 1px solid #0D2B4D;
    }
    .map{
        margin: 195.6px 25.95px 242.6px 33.95px;
    }
    .right-bar{
        /* width: 560px; */
        height: 918px;
        /* margin-left:10px; */
    }
    .right-tab{
        width: 137px;
        height: 25px;
        display: inline-block;
        background: #0F254A;
    }
    .right-tab:focus{
        background: #15509D;
        color: #FFFFFF;
        border: none;
    }
    .info-panel{
        /* width: 560px; */
        height: 870px;
        background: #20274F;
    }
</style>