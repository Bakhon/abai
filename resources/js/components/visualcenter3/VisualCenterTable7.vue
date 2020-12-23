<template>
    <div class="d-flex flex-column flex-sm-row justify-content-between w-sm-100">
        <div class="flex-grow-1">
            <horizontal-indicators
                @changeTable="tableToChange => changeTable(tableToChange)"
                v-bind:dateStart="dateStart"
                v-bind:dateEnd="dateEnd"
            ></horizontal-indicators>
            <div class="vc-tables">
                <div class="mr-sm-2 vc-central-block">
                    <div class="d-flex flex-row mb-2">
                        <div class="flex-grow-1 first-string">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center p-2">
                                <h4 class="font-weight-bold">Upstream</h4>
                                <div class="w-75">
                                    <div class="progress2">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            :style="{width: t1Sum + '%'}"
                                            :aria-valuenow="t1Sum"
                                            aria-valuemin="0"
                                            :aria-valuemax="100"
                                        >
                                            <div v-if="t1Sum">
                                                {{ t1Sum.toFixed(1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="close2 d-none d-sm-block">Закрыть</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row mb-sm-2" v-if="isEnableSpeedometers">
                        <vc-speedometer-block
                            v-bind:title="'Прирост запасов (A+B+C1)'"
                            v-bind:mainValue="t1"
                            v-bind:units="'млн. тонн'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Чистый денежный поток'"
                            v-bind:mainValue="t2"
                            v-bind:units="'млн. тенге'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Операционные затраты'"
                            v-bind:mainValue="t3"
                            v-bind:units="'млн. тенге'"
                        ></vc-speedometer-block>
                    </div>
                    <div class="d-flex flex-column flex-sm-row mb-1 mb-sm-2 pb-2" v-if="isEnableSpeedometers">
                        <vc-speedometer-block
                            v-bind:title="'Капитальные затраты по операционным активам'"
                            v-bind:mainValue="t4"
                            v-bind:units="'млн. тенге'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Капитальные затраты крупных проектов'"
                            v-bind:mainValue="t5"
                            v-bind:units="'млн. тенге'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Разработка концепции Разведка и добыча'"
                            v-bind:mainValue="t6"
                            v-bind:units="'дата'"
                        ></vc-speedometer-block>
                    </div>
                    <div class="text-center p-3" v-else>
                        <div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
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
    </div>
</template>
<script src="./VisualCenterTable7.js"></script>
