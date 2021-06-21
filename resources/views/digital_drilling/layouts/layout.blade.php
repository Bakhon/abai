@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="/css/digital_drilling.css">
        <div class="row digital_drilling">
            <div class="col-sm-12 centerBlock">
                @include('digital_drilling.layouts.menu')
            </div>
            <div class="col-sm-10 leftBlock">
                <div class="resultsBlock">
                    <ul>
                        <li>
                            <div class="block">
                                <p class="num">
                                    <span class="big">14</span>
                                    <span>скважин</span>
                                </p>
                                <p class="title green">В бурении</p>
                                <p class="percent"><span>5,2%</span> vs 23.03.2021</p>
                            </div>
                        </li>
                        <li>
                            <div class="block">
                                <p class="num">
                                    <span class="big">506</span>
                                    <span>скважин</span>
                                </p>
                                <p class="title yellow">Пробурено</p>
                                <p class="percent"><span>1,4%</span> vs 23.03.2021</p>
                            </div>
                        </li>
                        <li>
                            <div class="block">
                                <p class="num">
                                    <span class="big">0</span>
                                    <span>скважин</span>
                                </p>
                                <p class="title red">В освоении</p>
                                <p class="percent"><span>0,0%</span> vs 23.03.2021</p>
                            </div>
                        </li>
                        <li>
                            <div class="block">
                                <p class="num">
                                    <span class="big">520</span>
                                    <span>скважин</span>
                                </p>
                                <p class="title">Итого</p>
                                <p class="percent"><span>1,4%</span> vs 23.03.2021</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="contentBlock">@yield('in-content')</div>
            </div>
            <div class="col-sm-2 rightBlock">
                <div class="analyticsBlock">
                    <div class="techNumsBlock">
                        <p class="name">Технико-экономические показатели</p>
                        <label>Механическая скорость</label>
                        <div class="lineBlock">
                            <p>21 м/ч</p>
                            <input type="range" max="40" min="0" value="21" class="rangeInput" disabled>
                        </div>
                        <label>Рейсовая скорость</label>
                        <div class="lineBlock">
                            <p>15 м/ч</p>
                            <input type="range" max="40" min="0" value="15" class="rangeInput" disabled>
                        </div>
                        <label>Техническая скорость</label>
                        <div class="lineBlock">
                            <p>2200 м/ст.мес</p>
                            <input type="range" max="3000" min="0" value="2200" class="rangeInput" disabled>
                        </div>
                        <label>Коммерческая скорость</label>
                        <div class="lineBlock">
                            <p>1500 м/ст.мес</p>
                            <input type="range" max="3000" min="0" value="1500" class="rangeInput" disabled>
                        </div>
                        <label>Цикловая скорость</label>
                        <div class="lineBlock">
                            <p>1700 м/ст.мес</p>
                            <input type="range" max="3000" min="0" value="1700" class="rangeInput" disabled>
                        </div>
                    </div>
                </div>
                <div class="analyticsBlock">
                    <p class="num"><span>1230</span>метров</p>
                    <p class="name"><img src="/img/digital-drilling/drilling.svg" alt=""><span>Пробурено за сутки</span></p>
                </div>
                <div class="analyticsBlock">
                    <p class="num"><span>14251</span>метров</p>
                    <p class="name"><img src="/img/digital-drilling/drilling.svg" alt=""><span>Пробурено итого</span></p>
                </div>
                <button class="alarm">ALARM</button>
            </div>
        </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.rangeInput').each(function () {
            var value = ((this.value - this.min) / (this.max - this.min)) * 100;
            var inputVal = this.value;
            var back = "linear-gradient(to right, #454D7D 0%, #454D7D " + value + "%, #3C4270 " + value + "%, #3C4270 100%)";
            $(this).css("background", back);
        });
    });
</script>