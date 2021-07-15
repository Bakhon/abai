@extends('layouts.pf')
@section('content')
   <div class="pf-index-wrapper">
   
       <div class="pf-index-main">
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



{{--<script src="/js/plastFluids/mapdata.js"></script>--}}
{{--<script src="/js/plastFluids/countrymap.js"></script>--}}

<style lang="scss" scoped>
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