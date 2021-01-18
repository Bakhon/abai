<template>
    <div class="d-flex flex-column flex-sm-row justify-content-between w-sm-100">
        <div class="flex-grow-1 mr-2 mb-2">
            <horizontal-indicators
                @changeTable="tableToChange => changeTable(tableToChange)"
                v-bind:dateStart="dateStart"
                v-bind:dateEnd="dateEnd"
            ></horizontal-indicators>
            <div class="first-string mr-2" v-if="isShowInteractiveBlock">
                <vc-upstream-table
                    v-if="tableToShowId === 2"
                    v-bind:tableData="t2TableData"
                    v-bind:tableTitle="'Чистый денежный поток'"
                    @closeTable="closeTable"
                ></vc-upstream-table>
                <vc-upstream-table
                    v-if="tableToShowId === 3"
                    v-bind:tableData="t3TableData"
                    v-bind:tableTitle="'Операционные затраты'"
                    @closeTable="closeTable"
                ></vc-upstream-table>
                <vc-upstream-table
                    v-if="tableToShowId === 4"
                    v-bind:tableData="t4TableData"
                    v-bind:tableTitle="'Капитальные затраты по операционным активам'"
                    @closeTable="closeTable"
                ></vc-upstream-table>
                <vc-upstream-table
                    v-if="tableToShowId === 5"
                    v-bind:tableData="t5TableData"
                    v-bind:tableTitle="'Капитальные затраты крупных проектов'"
                    @closeTable="closeTable"
                ></vc-upstream-table>
            </div>
            <div class="vc-central-block">
                <div v-if="isShowMainBlock">
                    <div class="d-flex flex-row mb-2">
                        <div class="flex-grow-1 first-string">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center p-2">
                                <h5 class="font-weight-bold m-0">
                                    <!-- КПД Блока добычи -->{{ trans("visualcenter.prodKPI") }}
                                    </h5>
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
                                <div class="close2 d-none d-sm-block">
                                    <!-- Закрыть -->{{ trans("visualcenter.close") }}
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row mb-sm-3 vc-speedometer-line" v-if="isEnableSpeedometers">
                        <vc-speedometer-block
                            v-bind:title="trans('visualcenter.prirostZapasov')"
                            v-bind:mainValue="t1"
                            v-bind:units="'млн. тонн'"
                            v-bind:planWeight="'20'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="trans('visualcenter.cashFlow')" 
                            v-bind:mainValue="t2"
                            v-bind:units="'млн. тенге'"
                            v-bind:showLink="true"
                            v-bind:tableToChange="2"
                            @changeTable="tableToChange => changeTable(tableToChange)"
                            v-bind:planWeight="'20'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="trans('visualcenter.operZatraty')" 
                            v-bind:mainValue="t3"
                            v-bind:units="'млн. тенге'"
                            v-bind:showLink="true"
                            v-bind:tableToChange="3"
                            v-bind:isLastBlock="true"
                            @changeTable="tableToChange => changeTable(tableToChange)"
                            v-bind:planWeight="'20'"
                        ></vc-speedometer-block>
                    </div>
                    <div class="d-flex flex-column flex-sm-row mb-1 mb-sm-2 vc-speedometer-line" v-if="isEnableSpeedometers">
                        <vc-speedometer-block
                            v-bind:title="trans('visualcenter.kapitalZatratyNeOper')"
                            v-bind:mainValue="t4"
                            v-bind:units="'млн. тенге'"
                            v-bind:showLink="true"
                            v-bind:tableToChange="4"
                            @changeTable="tableToChange => changeTable(tableToChange)"
                            v-bind:planWeight="'20'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="trans('visualcenter.kapitalZatratyBigProjects')"
                            v-bind:mainValue="t5"
                            v-bind:units="'млн. тенге'"
                            v-bind:showLink="true"
                            v-bind:tableToChange="5"
                            @changeTable="tableToChange => changeTable(tableToChange)"
                            v-bind:planWeight="'15'"
                        ></vc-speedometer-block>
                        <vc-speedometer-block
                            v-bind:title="trans('visualcenter.KPIdobycha6')" 
                            v-bind:mainTitle="trans('visualcenter.November')"
                            v-bind:toolTipPorog="trans('visualcenter.December')"
                            v-bind:toolTipAim="trans('visualcenter.November')"
                            v-bind:toolTipVizov="'-'"
                            v-bind:mainValue="t6"
                            v-bind:units="trans('visualcenter.date')"
                            v-bind:isLastBlock="true"
                            v-bind:planWeight="'5'"
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
<script src="./VisualCenterTable7.js"></script>
