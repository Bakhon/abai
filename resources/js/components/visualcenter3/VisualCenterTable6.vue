<template>
    <div class="d-flex flex-column flex-sm-row justify-content-between w-sm-100">
        <div class="flex-grow-1 vc-central-block mr-2 mb-2">
            <horizontal-indicators
                v-bind:dateStart="dateStart"
                v-bind:dateEnd="dateEnd"
            ></horizontal-indicators>
            <div>
                <div>
                    <div class="d-flex flex-row mb-2">
                        <div class="flex-grow-1 first-string">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center p-2">
                                <h5 class="font-weight-bold m-0">КПД Блока стратегии</h5>
                                <div class="w-75">
                                    <div class="progress2">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            :style="{width: tSum + '%'}"
                                            :aria-valuenow="tSum"
                                            aria-valuemin="0"
                                            :aria-valuemax="100"
                                        >
                                            <div v-if="tSum">
                                                {{ tSum.toFixed(1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="close2 d-none d-sm-block">Закрыть</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row mb-sm-2 vc-speedometer-line" v-if="isEnableSpeedometers">
                        <vc-speedometer-block
                            v-bind:title="'Заключение/реализация контрактов на недропользование'"
                            v-bind:mainValue="t1"
                            v-bind:units="'кол-во проектов'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Привлечение стратегических партнеров'"
                            v-bind:mainValue="t2"
                            v-bind:units="'кол-во проектов'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'ESG рейтинг'"
                            v-bind:mainValue="t3"
                            v-bind:units="'%'"
                            v-bind:isLastBlock="true"
                        ></vc-speedometer-block>
                    </div>
                    <div class="d-flex flex-column flex-sm-row mb-1 mb-sm-2 pb-2 vc-speedometer-line" v-if="isEnableSpeedometers">
                        <vc-speedometer-block
                            v-bind:title="'Оптимизированный Инвестиционный портфель'"
                            v-bind:mainTitle="'Октябрь'"
                            v-bind:mainValue="t4"
                            v-bind:toolTipPorog="'Ноябрь'"
                            v-bind:toolTipAim="'Октябрь'"
                            v-bind:toolTipVizov="'Сентябрь'"
                            v-bind:units="'дата'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Мероприятия по реструктуризации активов'"
                            v-bind:mainValue="t5"
                            v-bind:units="'%'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Мероприятия по передаче КазТрансГаз в Самрук-Казына'"
                            v-bind:mainTitle="'Декабрь'"
                            v-bind:toolTipPorog="'-'"
                            v-bind:toolTipAim="'Декабрь'"
                            v-bind:toolTipVizov="'-'"
                            v-bind:mainValue="t6"
                            v-bind:units="'дата'"
                            v-bind:isLastBlock="true"
                        ></vc-speedometer-block>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-grow-1" v-if="dateStart">
            <vertical-indicators
                v-bind:dateStart="dateStart"
                v-bind:dateEnd="dateEnd"
            ></vertical-indicators>
        </div>
        <cat-loader />
    </div>
</template>
<script src="./VisualCenterTable6.js"></script>
