<template>
    <div class="indicatorCell flex-grow-1 mr-xs-0 mr-xl-2 mb-1 mb-md-0" v-bind:class="{ 'indicator-active': isActive }" v-on:click="onClick">
        <div class="text-right text-sm-left">
            <div>
                <div class="number">
                    {{ new Intl.NumberFormat("ru-RU").format(indicatorValue) }}
                </div>
                <div class="unit-vc">{{ units }}</div>
            </div>
            <div class="txt1 mt-2">{{ title }}</div>
            <div class="mt-1" v-if="hasProgressBar">
                <div class="percent-header">
                    {{ progressPercents }}%
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" :style="{width: progressPercents + '%'}" :aria-valuenow="progressValue"
                         aria-valuemin="0" :aria-valuemax="progressMax"></div>
                </div>
                <div class="flex-box progressBarFontSize">
                    <div class="col-6 text-left">
                        {{ new Intl.NumberFormat("ru-RU").format(0) }}
                    </div>
                    <div class="col-6 text-right">
                        {{ new Intl.NumberFormat("ru-RU").format(progressMax) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 text-nowrap mt-2 d-flex d-flex-row align-items-center" v-if="prevPeriodValue && progressValue">
            <div v-if="(prevPeriodValue - progressValue ) / progressValue * 100 > 0" class="arrow2"></div>
            <div v-if="(prevPeriodValue - progressValue ) / progressValue * 100 < 0" class="arrow3"></div>
            <div>
                <span class="txt2-2">
                    {{ Math.abs(Math.round((prevPeriodValue - progressValue ) / progressValue * 100))}}%
                </span>
                <span class="txt3 ml-1"> {{ lastPeriod }}</span>
            </div>
        </div>
    </div>
</template>
<script src="./Indicator.js"></script>
<style>
    .indicator-active {
        background-color: #0d2792;
    }
</style>