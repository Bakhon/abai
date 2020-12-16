<template>
    <div class="indicatorCell flex-grow-1 mr-xs-0 mr-xl-2 mb-1 mb-md-0"  @click="$emit('changeTable', tableToChange)">
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
                    {{ (100 - (prevPeriodValue / progressValue - 1) * 100).toFixed(2) }}%
                </div>
                <div class="progress" v-if="hasProgressBar">
                    <div class="progress-bar" role="progressbar" :style="{width: progressPercents + '%'}" :aria-valuenow="progressValue"
                         aria-valuemin="0" :aria-valuemax="progressValue"></div>
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
        <div class="w-100 text-nowrap pr-3 mt-2" v-if="prevPeriodValue && progressValue">
            <div v-if="(prevPeriodValue - progressValue ) / prevPeriodValue * 100 > 0" class="arrow2"></div>
            <div v-if="(prevPeriodValue - progressValue ) / prevPeriodValue * 100 < 0" class="arrow3"></div>
            <div>
                    <span class="txt2-2">
                        {{ new Intl.NumberFormat("ru-RU").format(Math.abs((prevPeriodValue - progressValue ) / prevPeriodValue * 100).toFixed(2)) }}%
                    </span>
                <span class="txt3 ml-1"> {{ lastPeriod }}</span>
            </div>
        </div>
    </div>
</template>
<script src="./Indicator.js"></script>