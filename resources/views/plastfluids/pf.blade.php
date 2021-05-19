@extends('layouts.pf')
@section('content')
   <div class="wrapper">
   
       <div class="post-main"><div id="map"></div></div>
       <div class="post-menu"><pf-main></pf-main></div>
       
   </div>
@endsection
<script src="/js/plastFluids/mapdata.js"></script>
<script src="/js/plastFluids/countrymap.js"></script>

<style>
    .wrapper {
        margin: 0;
        padding: 0;
        display: grid;
        grid-template-rows: 1fr 975fr 1fr;
        grid-template-columns: 5fr 1467fr 10fr 355fr 5fr;
        background:#0f1430;
        weight:100%;
        height: 100%;
    }

    .post-main {
        grid-column: 2; 
        grid-row: 2;
        background:#2c3064;
    }
    .post-menu {
        grid-column: 4; 
        grid-row: 2;
        background:rgba(51, 57, 117, 1);
    }
   
</style>


