<template>
    <div class="row ml-10 h-100">
        <div class="col-sm-12 leftBlock pl-0 pr-0">
            <div class="resultsBlock" v-if="!cardFull">
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
                    <li>
                        <div class="analyticsBlock">
                            <p class="num"><span>1230</span>{{ trans('digital_drilling.default.meters') }}</p>
                            <p class="name"><img src="/img/digital-drilling/drilling-day.svg" alt=""><span>{{ trans('digital_drilling.default.drilled_per_day') }}</span></p>
                        </div>
                    </li>
                    <li>
                        <div class="analyticsBlock">
                            <p class="num"><span>14251</span>{{ trans('digital_drilling.default.meters') }}</p>
                            <p class="name"><img src="/img/digital-drilling/drilling-all.svg" alt=""><span>{{ trans('digital_drilling.default.total_drilled') }}</span></p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="contentBlock" :class="{fullPage: cardFull}">
                <digital-map @cardFullPage="cardFull=!cardFull"/>
            </div>
        </div>
    </div>
</template>

<script>
    import DigitalMap from './DigitalMap'
    export default {
        name: "home",
        components: {DigitalMap},
        data(){
            return{
                cardFull: false,
                operatingCosts: [
                    {
                        year: '2016 г.',
                        item: 8228564
                    },
                    {
                        year: '2017 г.',
                        item: 8785866
                    },
                    {
                        year: '2018 г.',
                        item: 7947803
                    },
                    {
                        year: '2019 г.',
                        item: 14397692
                    },
                    {
                        year: '2020 г.',
                        item: 15093826
                    },
                    {
                        year: '2021 г.',
                        item: 10325881
                    },
                ]
            }
        },
    }
</script>

<style scoped>
.ml-10{
    padding: 0 10px 0 18px!important;
}

</style>