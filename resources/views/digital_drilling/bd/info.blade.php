@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <img src="/img/digital-drilling/map1.jpg" alt="">
        </div>
        <div class="WindowFooter">
            <div class="row">
                <div class="col-sm-5 borderRightGrey">
                    <div class="footBlock">
                        <p><img src="/img/digital-drilling/foot5.svg" alt=""><span>Действующий нефтепровод</span></p>
                        <p><img src="/img/digital-drilling/foot6.svg" alt=""><span>Действующий газопроводя</span></p>
                    </div>
                </div>
                <div class="col-sm-5 borderRightGrey">
                    <div class="footBlock">
                        <p><img src="/img/digital-drilling/foot1.svg" alt=""><img src="/img/digital-drilling/foot2.svg" alt=""><span>Разведка и добыча</span></p>
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
    </div>
@endsection