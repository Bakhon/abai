@extends('layouts.pf')
@section('content')
   <div class="pf-index-wrapper">

       <div class="pf-index-main">
{{--           <div id="map"></div>--}}
           <pf-oil-map />
       </div>
       <div class="pf-index-menu"><pf-main></pf-main></div>
      <div class="pf-index-footer"><pf-legend>
               <div class="WindowFooter">
                   <div class="row">
                       <div class="col-sm-5 borderRightGrey">
                           <div class="footBlock">
                               <p><img src="/img/digital-drilling/foot5.svg" alt=""><span>Действующий нефтепровод</span></p>
                           </div>
                           <div class="footBlock">
                               <p><img src="/img/digital-drilling/foot6.svg" alt=""><span>Действующий газопроводя</span></p>
                           </div>
                       </div>
                       <div class="col-sm-5 borderRightGrey">
                           <div class="footBlock">
                               <p><img src="/img/digital-drilling/foot1.svg" alt=""><img src="/img/digital-drilling/foot2.svg" alt=""><span>Разведка и добыча</span></p>
                           </div>
                           <div class="footBlock">
                               <p><img src="/img/digital-drilling/foot3.svg" alt=""><span>Переработка</span></p>
                           </div>
                       </div>
                       <div class="col-sm-2">
                           <div class="footBlock">
                               <p><img src="/img/digital-drilling/foot4.svg" alt=""><span>ДЗО</span></p>
                           </div>
                       </div>
                   </div>
               </div>
           </pf-legend></div>
   </div>
@endsection

<!--<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="./data/line.js"></script>
<script src="./data/point.js"></script>
<script src="./data/polygon.js"></script>
<script src="./data/nepaldata.js"></script>
<script src="./data/global.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="./data/usstates.js"></script>-->
<!--<script src="./resources/js/components/PlastFluids/components/mapZoom.js"></script>-->
{{--<script src="/js/plastFluids/mapdata.js"></script>--}}
{{--<script src="/js/plastFluids/countrymap.js"></script>--}}

<style lang="scss" scoped>
  #map {
    height: 100vh;
    width: 100%;
  }

  .info {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
  }
  .info h4 {
    margin: 0 0 5px;
    color: #777;
  }

  .legend {
    line-height: 18px;
    color: #555;
  }
  .legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
  }
    .pf-index-wrapper {
        margin: 0;
        padding: 0;
        display: grid;
        grid-template-rows: 1fr 975fr 1fr;
        grid-template-columns: 5fr 1467fr 10fr 355fr 5fr;
        background:#0f1430;
        width :100%;
        height: 100%;
    }

    .pf-index-main {
        grid-column: 2;
        grid-row: 2;
        background:#2c3064;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .pf-index-menu {
        grid-column: 4;
        grid-row: 2;
        grid-row-end: 5;
        background:rgba(51, 57, 117, 1);
    }
    .pf-index-footer{
        grid-column: 2;
        grid-row: 4;
        background: #1C1F4D;
        color: #fff;
    }
    .footBlock{
        display: flex;
        margin: 30px;
    }
    .borderRightGrey{
        display: flex;
    }

</style>

<script>

</script>