<template>
    <div class="row ml-10">
        <div class="col-sm-10 leftBlock pl-0 pr-0">
            <div class="resultsBlock">
                <ul>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">14</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title green">{{ trans('digital_drilling.default.in_drilling') }}</p>
                            <p class="percent">
                                <img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>5,2%</span> vs 23.03.2021
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">506</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title yellow">{{ trans('digital_drilling.default.drilled') }}</p>
                            <p class="percent"><img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">0</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title red">{{ trans('digital_drilling.default.in_mastering') }}</p>
                            <p class="percent"><span>0,0%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">520</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title">{{ trans('digital_drilling.default.Total') }}</p>
                            <p class="percent"><img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="contentBlock">
                <digital-map />
            </div>
        </div>
        <div class="col-sm-2 rightBlock pr-0">
            <div class="analyticsBlock">
                <p class="num"><span>1230</span>{{ trans('digital_drilling.default.meters') }}</p>
                <p class="name"><img src="/img/digital-drilling/drilling-day.svg" alt=""><span>{{ trans('digital_drilling.default.drilled_per_day') }}</span></p>
            </div>
            <div class="analyticsBlock">
                <p class="num"><span>14251</span>метров</p>
                <p class="name"><img src="/img/digital-drilling/drilling-all.svg" alt=""><span>{{ trans('digital_drilling.default.total_drilled') }}</span></p>
            </div>
            <div class="analyticsBlock">
                <div class="techNumsBlock">
                    <p class="name">{{ trans('digital_drilling.default.technical_and_economic') }}</p>
                    <label>{{ trans('digital_drilling.default.mechanical_speed') }}</label>
                    <div class="lineBlock">
                        <p>21 {{ trans('digital_drilling.default.m_h') }}</p>
                        <input type="range" max="40" min="0" value="21" class="rangeInput" disabled>
                    </div>
                    <label>{{ trans('digital_drilling.default.cruising_speed') }}</label>
                    <div class="lineBlock">
                        <p>15 {{ trans('digital_drilling.default.m_h') }}</p>
                        <input type="range" max="40" min="0" value="15" class="rangeInput" disabled>
                    </div>
                    <label>{{ trans('digital_drilling.default.technical_speed') }}</label>
                    <div class="lineBlock">
                        <p>2200 {{ trans('digital_drilling.default.m_st_month') }}</p>
                        <input type="range" max="3000" min="0" value="2200" class="rangeInput" disabled>
                    </div>
                    <label>{{ trans('digital_drilling.default.commercial_speed') }}</label>
                    <div class="lineBlock">
                        <p>1500 {{ trans('digital_drilling.default.m_st_month') }}</p>
                        <input type="range" max="3000" min="0" value="1500" class="rangeInput" disabled>
                    </div>
                    <label>{{ trans('digital_drilling.default.cycle_speed') }}</label>
                    <div class="lineBlock">
                        <p>1700 {{ trans('digital_drilling.default.m_st_month') }}</p>
                        <input type="range" max="3000" min="0" value="1700" class="rangeInput" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DigitalMap from './DigitalMap'
    export default {
        name: "home",
        components: {DigitalMap},
    }
</script>

<style scoped>
.ml-10{
    padding-left: 10px;
}
</style>