<template>
    <div class="d-flex flex-column flex-sm-row justify-content-between w-sm-100">
        <div class="flex-grow-1">
            <horizontal-indicators
                @changeTable="tableToChange => changeTable(tableToChange)"
            ></horizontal-indicators>
            <div class="vc-tables" :style="`${Table1}`">
                <div class="mr-sm-2 vc-central-block">
                    <div class="d-flex flex-row mb-2">
                        <div class="flex-grow-1 first-string">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center p-2">
                                <div class="">Корпоративные КПД</div>
                                <div class="w-75">
                                    <div class="progress2">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            :style="{width: oil_factDayProgressBar + '%'}"
                                            :aria-valuenow="oil_planDay"
                                            aria-valuemin="0"
                                            :aria-valuemax="oil_factDay"
                                        ></div>
                                    </div>
                                </div>
                                <div class="close2 d-none d-sm-block">Закрыть</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row mb-sm-2">
                        <vc-speedometer-block
                            v-bind:title="'Снижение OPEX и CAPEX'"
                            v-bind:mainValue="t1"
                            v-bind:units="'млрд. тенге'"
                            v-bind:speedometerValue="17"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Долг/EBIDTA'"
                            v-bind:mainValue="t2"
                            v-bind:units="'млрд. тенге'"
                            v-bind:speedometerValue="42"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'ROACE'"
                            v-bind:mainValue="t3"
                            v-bind:units="'%'"
                            v-bind:speedometerValue="12"
                        ></vc-speedometer-block>
                    </div>
                    <div class="d-flex flex-column flex-sm-row mb-1 mb-sm-2 pb-2">
                        <vc-speedometer-block
                            v-bind:title="'Запасы (A+B+C1)'"
                            v-bind:mainValue="t4"
                            v-bind:units="'млрд. тенге'"
                            v-bind:speedometerValue="85"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'ESG рейтинг'"
                            v-bind:mainValue="t5"
                            v-bind:units="'млрд. тенге'"
                            v-bind:speedometerValue="27"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="'Местное содержание'"
                            v-bind:mainValue="t6"
                            v-bind:units="'%'"
                            v-bind:speedometerValue="58"
                        ></vc-speedometer-block>
                    </div>
                </div>
            </div>

            <div class="second-table vc-tables" :style="`${Table2}`"></div>

            <div class="third-table vc-tables" :style="`${Table3}`">
                <div class="first-string mb-2">
                    <div class="close2" @click="changeTable('1')">Закрыть</div>
                    <div class="big-area">
                        <br/>
                        <div
                            @click="selectedDMY2 = menuDMY.id"
                            class="period"
                            v-for="(menuDMY, index) in periodSelectFunc()"
                            :style="{color: menuDMY.current2}"
                            v-on:click="periodSelectUSD"
                        >
                            <div>{{ menuDMY.DMY }}</div>
                        </div>
                        <visual-center-chart-area-usd3></visual-center-chart-area-usd3>
                    </div>
                </div>
            </div>

            <div class="third-table vc-tables" :style="`${Table4}`">
                <div class="first-string mb-2">
                    <div class="close2" @click="changeTable('1')">Закрыть</div>
                    <div class="big-area">Удельные доходы</div>
                </div>
            </div>

            <div class="third-table vc-tables" :style="`${Table5}`">
                <div class="first-string mb-2">
                    <div class="close2" @click="changeTable('1')">Закрыть</div>
                    <div class="big-area">Удельные расходы</div>
                </div>
            </div>

            <div class="third-table vc-tables" :style="`${Table6}`">
                <div class="first-string mb-2">
                    <div class="close2" @click="changeTable('1')">Закрыть</div>
                    <div class="big-area">ОТМ</div>
                </div>
            </div>

            <div class="third-table vc-tables" :style="`${Table7}`">
                <div class="first-string mb-2">
                    <div class="close2" @click="changeTable('1')">Закрыть</div>
                    <div class="big-area">Химизация</div>
                </div>
            </div>
        </div>
        <div class="flex-grow-1">
            <vertical-indicators></vertical-indicators>
        </div>
    </div>
</template>
<script src="./VisualCenterTable4.js"></script>
