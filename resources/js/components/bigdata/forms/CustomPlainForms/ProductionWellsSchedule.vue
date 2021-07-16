<template>
    <div>
        <div class="d-flex justify-content-begin align-items-center text-white p-1">
            <img class="arrow-back pr-3" src="/img/icons/arrow.svg" @click.stop="$emit('changeScheduleVisible')">
            <div>График оперативной информации</div>
        </div>
        <div class="main-block text-white pb-2">
            <div class="d-flex justify-content-between align-items-center p-2">
                <div class="d-flex">
                    <div>
                        <div class="input-border">
                            <img class="pr-1" src="/img/icons/search.svg" alt="">
                            <input class="search-input" type="text" placeholder="Поиск скважины" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center pl-3">
                        <div>Скважина: KAL_8224</div>
                        <img src="/img/icons/close.svg" alt="">
                    </div>
                    <div class="d-flex align-items-center pl-3">
                        <img class="pr-1" src="/img/icons/page_to_form.svg" alt="">
                        <div>Cформировать</div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="d-flex align-items-center">
                        <input type="checkbox">
                        <div class="pl-1">Показывать события</div>
                    </div>
                    <div class="d-flex align-items-center pl-3">
                        <input type="checkbox">
                        <div class="pl-1">Показывать всю историю</div>
                    </div>
                </div>
            </div>
            <div class="row content-block m-0 mt-2 mx-2 p-0 rounded-top">
                <div class="col-3">Период:</div>
                <div class="col-6 d-flex justify-content-between">
                    <div>1 неделя</div>
                    <div>1 месяц</div>
                    <div>3 месяца</div>
                    <div>6 месяцев</div>
                    <div>1 год</div>
                    <div>Все</div>
                </div>
                <div class="col-3"></div>
            </div>
            <div class="content-block m-2 p-2 rounded-bottom">
                <line-chart :height="800"></line-chart>
            </div>
        </div>
    </div>
</template>
<script>
import Vue from "vue";
import VueChartJs from 'vue-chartjs'

Vue.component('line-chart', {
    extends: VueChartJs.Line,
    props: {
        isScheduleVisible: Boolean
    },
    mounted () {
        this.renderChart({
            labels: ["22 Март", "29 Март", "5 Апрель", "12 Апрель", "19 Апрель",
                "26 Апрель", "3 Май", "10 Май", "17 Май", "24 Май", "31 Май", "7 Июнь", "14 Июнь"],
            datasets: [
                {
                    label: "Жидкость",
                    borderColor: "rgba(68, 114, 196, 1)",
                    backgroundColor: 'rgba(130, 186, 255, 0.7)',
                    data: [100, 800, 900, 1400, 1200, 2100, 2900,
                        100, 800, 900, 1400, 1200, 2100, 2900,
                        100, 800, 900, 1400, 1200, 2100, 2900,
                        100, 800, 900, 1400, 1200, 2100, 2900,
                        100, 800, 900, 1400, 1200, 2100, 2900],
                    fill: true,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                    order: 1,
                    lineTension: 0,
                },
                {
                    label: "Нефть",
                    borderColor: "rgba(33, 186, 78, 1)",
                    backgroundColor: 'rgba(72, 81, 95, 1)',
                    data: [50, 300, 400, 300, 200, 500, 550,
                        50, 300, 400, 300, 200, 500, 550,
                        50, 300, 400, 300, 200, 500, 550,
                        50, 300, 400, 300, 200, 500, 550],
                    fill: true,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                    order: 0,
                    lineTension: 0,
                },
                {
                    label: "Обводненность",
                    borderColor: "rgba(110, 187, 113, 1)",
                    data: [800, 700, 700, 1000, 450, 2000, 1400,
                        800, 700, 700, 1000, 450, 2000, 1400,
                        800, 700, 700, 1000, 450, 2000, 1400,
                        800, 700, 700, 1000, 450, 2000, 1400],
                    fill: false,
                    showLine: true,
                    pointStyle: "rect",
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                    order: 0,
                    lineTension: 0,
                },
                {
                    label: "Н дин",
                    borderColor: "rgba(110, 187, 113, 1)",
                    data: [500, 900, 400, 400, 800, 1800, 1500,
                        500, 900, 400, 400, 800, 1800, 1500,
                        500, 900, 400, 400, 800, 1800, 1500,
                        500, 900, 400, 400, 800, 1800, 1500],
                    fill: false,
                    showLine: true,
                    pointStyle: "triangle",
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                    order: 0,
                    lineTension: 0,
                }
            ],
        },
        {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'right',
            },
            scales: {
                yAxes: [{
                    position: 'right',
                    gridLines: {
                        display: true,
                        color: '#3C4270',
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 4000,
                        fontColor: '#FFFFFF',
                    },
                }],
                xAxes: [{
                    gridLines: {
                        display: false,
                        color: '#3C4270'
                    },
                    ticks: {
                        fontColor: '#FFFFFF',
                    },
                }],
            }
        });
    }
});

export default {

}
</script>
<style scoped>
.main-block {
    background-color: rgba(51, 57, 117, 0.33);
}

.input-border {
    background-color: rgba(51, 57, 117, 1);
    border: 0.4px solid #656A8A;
    border-radius: 2px;
}

.input-border input {
    background-color: rgba(51, 57, 117, 1);
    border: none;
}

.content-block {
    background-color: rgba(39, 41, 83, 1);
    line-height: 2rem;
}

.arrow-back {
    transform: rotate(90deg);
}
</style>