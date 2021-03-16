<template>
    <div class="d-flex flex-column flex-sm-row justify-content-between w-sm-100">
        <div class="flex-grow-1 mr-2">
            <horizontal-indicators
                v-bind:dateStart="dateStart"
                v-bind:dateEnd="dateEnd"
                v-bind:dzo="dzoSelect"
            ></horizontal-indicators>
            <div class="d-flex flex-column first-string flex-sm-row">
                <div class="col-sm-3 p-3 flex-column">
                    <h5>
                        <strong>
                            <!-- Оперативные итоги -->{{ trans("visualcenter.operResults") }}
                            <br />
                            <!-- по финансовым показателям -->{{ trans("visualcenter.finIndicators") }}
                        </strong>
                    </h5>
                    <select class="w-100 p-2" :style="{background: '#2A2E5C', color: 'white'}" v-model="fromBeginOfYearSelect">
                        <option :value="0" :selected="'selected'">
                            <!-- С начала года -->{{ trans("visualcenter.yearBegin") }}
                            </option>
                        <option :value="1">
                            <!-- Январь 2020 -->{{ trans("visualcenter.jan2020") }}
                            </option>
                        <option :value="2" :disabled="actualMonth < 1">
                            <!-- Январь - Февраль 2020 -->{{ trans("visualcenter.jan_feb2020") }}
                            </option>
                        <option :value="3" :disabled="actualMonth < 2">
                            <!-- Январь - Март 2020 -->{{ trans("visualcenter.jan_mar2020") }}
                            </option>
                        <option :value="4" :disabled="actualMonth < 3">
                            <!-- Январь - Апрель 2020 -->{{ trans("visualcenter.jan_apr2020") }}
                            </option>
                        <option :value="5" :disabled="actualMonth < 4">
                            <!-- Январь - Май 2020 -->{{ trans("visualcenter.jan_may2020") }}
                            </option>
                        <option :value="6" :disabled="actualMonth < 5">
                            <!-- Январь - Июнь 2020 -->{{ trans("visualcenter.jan_june2020") }}
                            </option>
                        <option :value="7" :disabled="actualMonth < 6">
                            <!-- Январь - Июль 2020 -->{{ trans("visualcenter.jan_july2020") }}
                            </option>
                        <option :value="8" :disabled="actualMonth < 7">
                            <!-- Январь - Август 2020 -->{{ trans("visualcenter.jan_aug2020") }}
                            </option>
                        <option :value="9" :disabled="actualMonth < 8">
                            <!-- Январь - Сентябрь 2020 -->{{ trans("visualcenter.jan_sept2020") }}
                            </option>
                        <option :value="10" :disabled="actualMonth < 9">
                            <!-- Январь - Октябрь 2020 -->{{ trans("visualcenter.jan_oct2020") }}
                            </option>
                        <option :value="11" :disabled="actualMonth < 10">
                            <!-- Январь - Ноябрь 2020 -->{{ trans("visualcenter.jan_nov2020") }}
                            </option>
                        <option :value="12" :disabled="actualMonth < 11">
                            <!-- Январь - Декабрь 2020 -->{{ trans("visualcenter.jan_dec2020") }}
                            </option>
                    </select>
                </div>
                <div class="col-sm-6 flex-column pt-3">
                    <select class="w-100 p-2" :style="{background: '#2A2E5C', color: 'white'}" v-model="dzoSelect">
                        <option :value="'ALL'" :selected="'selected'">
                            <!-- Все НДО -->{{ trans("visualcenter.allNDO") }}
                            </option>
                        <option v-for="company in fullCompanyNames" v-bind:value="company.code">{{ company.title }}</option>
                    </select>
                    <div class="w-100 d-flex" style="margin-top: 14px;">
                        <select class="w-50 p-2 mr-3" :style="{background: '#2A2E5C', color: 'white'}" v-model="byMonthSelect">
                            <option :value="0" :selected="'selected'">
                                <!-- За месяц -->{{ trans("visualcenter.monthZa") }}
                                </option>
                            <option :value="1">
                                <!-- Январь 2020 -->{{ trans("visualcenter.jan2020") }}
                                </option>
                            <option :value="2" :disabled="actualMonth < 1">
                                <!-- Февраль 2020 -->{{ trans("visualcenter.feb2020") }}
                                </option>
                            <option :value="3" :disabled="actualMonth < 2">
                                <!-- Март 2020 -->{{ trans("visualcenter.mar2020") }}
                                </option>
                            <option :value="4" :disabled="actualMonth < 3">
                                <!-- Апрель 2020 -->{{ trans("visualcenter.apr2020") }}
                                </option>
                            <option :value="5" :disabled="actualMonth < 4">
                                <!-- Май 2020 -->{{ trans("visualcenter.may2020") }}
                                </option>
                            <option :value="6" :disabled="actualMonth < 5">
                                <!-- Июнь 2020 -->{{ trans("visualcenter.june2020") }}
                                </option>
                            <option :value="7" :disabled="actualMonth < 6">
                                <!-- Июль 2020 -->{{ trans("visualcenter.july2020") }}
                                </option>
                            <option :value="8" :disabled="actualMonth < 7">
                                <!-- Август 2020 -->{{ trans("visualcenter.aug2020") }}
                                </option>
                            <option :value="9" :disabled="actualMonth < 8">
                                <!-- Сентябрь 2020 -->{{ trans("visualcenter.sept2020") }}
                                </option>
                            <option :value="10" :disabled="actualMonth < 9">
                                <!-- Октябрь 2020 -->{{ trans("visualcenter.oct2020") }}
                                </option>
                            <option :value="11"  :disabled="actualMonth < 10">
                                <!-- Ноябрь 2020 -->{{ trans("visualcenter.nov2020") }}
                                </option>
                            <option :value="12" :disabled="actualMonth < 11">
                                <!-- Декабрь 2020 -->{{ trans("visualcenter.dec2020") }}
                                </option>
                        </select>
                        <select class="w-50 p-2" :style="{background: '#2A2E5C', color: 'white'}" v-model="quarterSelect">
                            <option :value="0" :selected="'selected'">
                                <!-- Квартал -->{{ trans("visualcenter.quarter") }}
                                </option>
                            <option :value="1">
                                <!-- Январь - Март 2020 -->{{ trans("visualcenter.jan_mar2020") }}
                                </option>
                            <option :value="4" :disabled="actualMonth < 3">
                                <!-- Апрель - Июнь 2020 -->{{ trans("visualcenter.apr_june2020") }}
                                </option>
                            <option :value="7" :disabled="actualMonth < 6">
                                <!-- Июль - Сентябрь 2020 -->{{ trans("visualcenter.july_sept2020") }}
                                </option>
                            <option :value="10" :disabled="actualMonth < 9">
                                <!-- Октябрь - Декабрь 2020 -->{{ trans("visualcenter.oct_dec2020") }}
                                </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 flex-column p-3">
                    <div class="w-25 float-right">
                        <div class="close2 d-none d-sm-block">
                            <!-- Закрыть -->{{ trans("visualcenter.close") }}
                            </div>
                    </div>
                    <button class="w-100 p-2 vc-button mt-4" :style="{background: '#2A2E5C', color: 'white'}"
                            :value="actualMonthSelect"
                            @click="actualMonthSelect = (actualMonthSelect + 1) % 2">
                        <!-- Актуализированный месяц -->{{ trans("visualcenter.monthAct") }}
                    </button>
                </div>
            </div>
            <div class="first-string vc-5-tables-block">
                <div v-if="macroData.length > 0">
                    <h5 class="text-center mr-2"><strong>
                        <!-- Макропоказатели -->{{ trans("visualcenter.macroIndicators") }}
                        </strong></h5>
                    <div class="ml-0 ml-sm-3 mr-0 mr-sm-3 pb-3">
                        <div class="w-100">
                            <table class="table pl-2 table-striped table-borderless text-right economics-table-border">
                                <thead class="economics-table-color">
                                <tr>
                                    <th class="text-left" scope="col">
                                        <!-- Наименование -->{{ trans("visualcenter.name") }}
                                        </th>
                                    <th scope="col">
                                        <!-- Ед.изм. -->{{ trans("visualcenter.unit") }}
                                        </th>
                                    <th scope="col">
                                        <!-- План -->{{ trans("visualcenter.Plan") }}
                                        <br />за&nbsp;отч.&nbsp;период 2020г.</th>
                                    <th scope="col">
                                        <!-- Факт -->{{ trans("visualcenter.Fact") }}
                                        <br />за&nbsp;отч.&nbsp;период 2020г.</th>
                                    <th scope="col">
                                        <!-- Абс. откл. -->{{ trans("visualcenter.deviationAbs") }}
                                        <br />за&nbsp;отч.&nbsp;период, +/-</th>
                                    <th scope="col">
                                        <!-- Отн. откл. -->{{ trans("visualcenter.deviationOtn") }}
                                        <br />за&nbsp;отч.&nbsp;период, %</th>
                                    <th scope="col">
                                        <!-- Факт -->{{ trans("visualcenter.Fact") }}
                                        <br />за&nbsp;отч.период 2019г.</th>
                                    <th scope="col">
                                        <!-- Абс. откл. -->{{ trans("visualcenter.deviationAbs") }}
                                        <br />(факт&nbsp;2020г.&nbsp;-&nbsp;факт&nbsp;2019г.), +/-</th>
                                    <th scope="col">
                                        <!-- Годовой план -->{{ trans("visualcenter.yearPlan") }}
                                        <br />2020 г.</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in macroData">
                                    <td class="text-left" style="white-space: nowrap;">{{ item.title }}</td>
                                    <td style="white-space: nowrap;">{{ item.units }}</td>
                                    <td>{{ (item.dataPlan).toFixed(1) }}</td>
                                    <td>{{ (item.dataFact).toFixed(1) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <span v-if="item.dataPlan - item.dataFact > 0" class="arrow2"></span>
                                            <span v-else class="arrow3"></span>
                                            {{ (Math.abs(item.dataPlan - item.dataFact)).toFixed(1) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <span v-if="((item.dataPlan - item.dataFact) / item.dataPlan * 100) > 0" class="arrow2"></span>
                                            <span v-else class="arrow3"></span>
                                            {{ Math.abs((item.dataPlan - item.dataFact) / item.dataPlan * 100).toFixed(1) }}
                                        </div>
                                    </td>
                                    <td>{{ (item.dataFactPrevYear).toFixed(1) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <span v-if="item.dataFact - item.dataFactPrevYear > 0" class="arrow2"></span>
                                            <span v-else class="arrow3"></span>
                                            {{ (Math.abs(item.dataFact - item.dataFactPrevYear)).toFixed(1) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="item.plan2020">{{ (item.plan2020).toFixed(1) }}</div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div v-if="dzoData.length > 0">
                    <h5 class="text-center mr-2"><strong>
                        <!-- Финансовые показатели -->{{ trans("visualcenter.yearPlan") }}
                        </strong></h5>
                    <div class="ml-0 ml-sm-3 mr-0 mr-sm-3 pb-3">
                        <div class="w-100">
                            <table class="table pl-2 table-striped table-borderless text-right economics-table-border">
                                <thead class="economics-table-color">
                                <tr>
                                    <th class="text-left" scope="col">
                                        <!-- Наименование -->{{ trans("visualcenter.name") }}
                                        </th>
                                    <th scope="col">
                                        <!-- Ед.изм. -->{{ trans("visualcenter.unit") }}
                                        </th>
                                    <th scope="col">
                                        <!-- План -->{{ trans("visualcenter.Plan") }}
                                        <br />за&nbsp;отч.&nbsp;период 2020г.</th>
                                    <th scope="col">
                                        <!-- Факт -->{{ trans("visualcenter.Fact") }}
                                        <br />за&nbsp;отч.&nbsp;период 2020г.</th>
                                    <th scope="col">
                                        <!-- Абс. откл. -->{{ trans("visualcenter.deviationAbs") }}
                                        <br />за&nbsp;отч.&nbsp;период, +/-</th>
                                    <th scope="col">
                                        <!-- Отн. откл. -->{{ trans("visualcenter.deviationOtn") }}
                                        <br />за&nbsp;отч.&nbsp;период, %</th>
                                    <th scope="col">
                                        <!-- Факт -->{{ trans("visualcenter.Fact") }}
                                        <br />за&nbsp;отч.период 2019г.</th>
                                    <th scope="col">
                                        <!-- Абс. откл. -->{{ trans("visualcenter.deviationAbs") }}
                                        <br />(факт&nbsp;2020г.&nbsp;-&nbsp;факт&nbsp;2019г.), +/-</th>
                                    <th scope="col">
                                        <!-- Годовой план 2020 г. -->{{ trans("visualcenter.yearPlan2020") }}
                                        </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in dzoData">
                                    <td class="text-left">{{ item.title }}</td>
                                    <td>{{ item.units }}</td>
                                    <td>{{ (item.dataPlan).toFixed(1) }}</td>
                                    <td>{{ (item.dataFact).toFixed(1) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <span v-if="item.dataPlan - item.dataFact > 0" class="arrow2"></span>
                                            <span v-else class="arrow3"></span>
                                            {{ (Math.abs(item.dataPlan - item.dataFact)).toFixed(1) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <span v-if="((item.dataPlan - item.dataFact) / item.dataPlan * 100) > 0" class="arrow2"></span>
                                            <span v-else class="arrow3"></span>
                                            {{ Math.abs((item.dataPlan - item.dataFact) / item.dataPlan * 100).toFixed(1) }}
                                        </div>
                                    </td>
                                    <td>{{ (item.dataFactPrevYear).toFixed(1) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <span v-if="item.dataFact - item.dataFactPrevYear > 0" class="arrow2"></span>
                                            <span v-else class="arrow3"></span>
                                            {{ (Math.abs(item.dataFact - item.dataFactPrevYear)).toFixed(1) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="item.plan2020">{{ (item.plan2020).toFixed(1) }}</div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-grow-1" v-if="dateStart">
            <vertical-indicators
                v-bind:dateStart="dateStart"
                v-bind:dateEnd="dateEnd"
                v-bind:dzo="dzoSelect"
            ></vertical-indicators>
        </div>
        <cat-loader />
    </div>
</template>
<script src="./VisualCenterTable5.js"></script>