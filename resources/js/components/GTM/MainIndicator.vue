<template>
    <div>
        <div class="d-flex">
            <div class="gtm-indicator-item flex-fill d-inline-block p-2" v-for="item in data">
                <div class="bigNumber">{{ new Intl.NumberFormat("ru-RU").format(item.number.toFixed(1)) }} <span class="units">{{ item.units }}</span></div>
                <div class="title">{{ item.title }}</div>
                <div class="progress gtm-progress mb-0">
                    <div
                        class="progress-bar"
                        role="progressbar"
                        :style="{width: item.progressPercents + '%'}"
                        :aria-valuenow="item.progressValue"
                        aria-valuemin="0"
                        :aria-valuemax="item.progressMax">
                    </div>
                </div>
                <div class="percent d-flex justify-content-between m-0 mt-1">
                    <div class="d-inline-block m-0 text-white dr-fw-700 ">
                        <div class="triangle-indicator" :class="item.progressPercents - 100 > 0 ? 'growth' : 'fall'"></div>
                        {{ Math.abs(Math.round(item.progressPercents) - 100) }}%
                    </div>
                    <div class="progressMax d-inline-block m-0">{{ new Intl.NumberFormat("ru-RU").format(item.progressMax.toFixed(1)) }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        data: Array
    },
    data: function () {
        return {};
    },
}
</script>