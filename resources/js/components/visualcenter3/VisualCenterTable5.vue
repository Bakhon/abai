<template>
    <div class="d-flex flex-column flex-sm-row justify-content-between w-sm-100">
        <div class="flex-grow-1">
            <horizontal-indicators></horizontal-indicators>
            <div class="d-flex flex-column first-string flex-sm-row mr-sm-2">
                <div class="w-25 m-3">
                    <h5>
                        <strong>
                            Оперативные итоги<br />
                            по финансовым показателям
                        </strong>
                    </h5>
                </div>
                <div class="w-50">
                    <select class="w-100 h-50 mt-3 mb-3" :style="{background: '#2A2E5C', color: 'white'}" v-model="dzoSelect">
                        <option :value="'ALL'" :selected="'selected'">Выбор ДЗО</option>
                        <option v-for="company in fullCompanyNames" v-bind:value="company.code">{{ company.title }}</option>
                    </select>
                </div>
                <div class="w-25">
                    <div class="w-25 float-right m-3">
                        <div class="close2 d-none d-sm-block">Закрыть</div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column first-string flex-sm-row justify-content-between mr-sm-2">
                <div class="w-25 ml-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}" v-model="fromBeginOfYearSelect">
                        <option :value="0" :selected="'selected'">С начала года</option>
                        <option :value="1">Январь 2020</option>
                        <option :value="2">Февраль 2020</option>
                        <option :value="3">Март 2020</option>
                        <option :value="4">Апрель 2020</option>
                        <option :value="5">Май 2020</option>
                        <option :value="6">Июнь 2020</option>
                        <option :value="7">Июль 2020</option>
                        <option :value="8">Август 2020</option>
                        <option :value="9">Сентябрь 2020</option>
                        <option :value="10">Октябрь 2020</option>
                        <option :value="11" disabled="disabled">Ноябрь 2020</option>
                        <option :value="12" disabled="disabled">Декабрь 2020</option>
                    </select>
                </div>
                <div class="w-25 ml-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}" v-model="byMonthSelect">
                        <option :value="0" :selected="'selected'">За месяц</option>
                        <option :value="1">Январь 2020</option>
                        <option :value="2">Февраль 2020</option>
                        <option :value="3">Март 2020</option>
                        <option :value="4">Апрель 2020</option>
                        <option :value="5">Май 2020</option>
                        <option :value="6">Июнь 2020</option>
                        <option :value="7">Июль 2020</option>
                        <option :value="8">Август 2020</option>
                        <option :value="9">Сентябрь 2020</option>
                        <option :value="10">Октябрь 2020</option>
                        <option :value="11" disabled="disabled">Ноябрь 2020</option>
                        <option :value="12" disabled="disabled">Декабрь 2020</option>
                    </select>
                </div>
                <div class="w-25 ml-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}" v-model="quarterSelect">
                        <option :value="0" :selected="'selected'">Квартал</option>
                        <option :value="1">Январь - Март 2020</option>
                        <option :value="4">Апрель - Июнь 2020</option>
                        <option :value="7">Июль - Сентябрь 2020</option>
                        <option :value="10">Октябрь - Декабрь 2020</option>
                    </select>
                </div>
                <div class="w-25 ml-3 mr-3">
                    <button class="w-100 mt-3 mb-3 p-2 vc-button" :style="{background: '#2A2E5C', color: 'white'}"
                            :value="actualMonthSelect"
                            @click="actualMonthSelect = (actualMonthSelect + 1) % 2">
                        Актуализированный месяц
                    </button>
                </div>
            </div>
            <div class="first-string mr-2">
                <h5 class="text-center mr-2"><strong>Макропоказатели</strong></h5>
                <div class="ml-0 ml-sm-3 mr-0 mr-sm-3 pb-3">
                    <div class="w-100">
                        <table class="table pl-2 table-striped table-borderless text-right economics-table-border">
                            <thead class="economics-table-color">
                            <tr>
                                <th class="text-left" scope="col">Наименование</th>
                                <th scope="col">Ед.изм.</th>
                                <th scope="col">План за отч.<br />период&nbsp;2020&nbsp;г.</th>
                                <th scope="col">Факт за отч.<br />период&nbsp;2020&nbsp;г.</th>
                                <th scope="col">Абс. откл.<br />за&nbsp;отч.&nbsp;период,&nbsp;+/-</th>
                                <th scope="col">Отн. откл.<br />за&nbsp;отч.&nbsp;период,&nbsp;%</th>
                                <th scope="col">Факт за отч.<br />период&nbsp;2019&nbsp;г.</th>
                                <th scope="col">Абс. откл.<br />(факт&nbsp;2020г.&nbsp;-&nbsp;факт&nbsp;2019г.),&nbsp;+/-</th>
                                <th scope="col">Годовой план 2020 г.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-left">Обменный курс</td>
                                <td>Тенге/$</td>
                                <td>450</td>
                                <td>405</td>
                                <td><span class="arrow2"></span>45</td>
                                <th scope="col"><span class="arrow3"></span>12</th>
                                <td>379</td>
                                <td><span class="arrow3"></span>45</td>
                                <td>450</td>
                            </tr>
                            <tr>
                                <td class="text-left">Обменный курс</td>
                                <td>Тенге/$</td>
                                <td>450</td>
                                <td>405</td>
                                <td><span class="arrow2"></span>45</td>
                                <th scope="col"><span class="arrow3"></span>54</th>
                                <td>379</td>
                                <td><span class="arrow3"></span>45</td>
                                <td>450</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5 class="text-center mr-2" v-if="dzoData.length > 0"><strong>Финансовые показатели</strong></h5>
                <div class="ml-0 ml-sm-3 mr-0 mr-sm-3 pb-3" v-if="dzoData.length > 0">
                    <div class="w-100">
                        <table class="table pl-2 table-striped table-borderless text-right economics-table-border">
                            <thead class="economics-table-color">
                            <tr>
                                <th class="text-left" scope="col">Наименование</th>
                                <th scope="col">Ед.изм.</th>
                                <th scope="col">План<br />за&nbsp;отч.&nbsp;период 2020г.</th>
                                <th scope="col">Факт<br />за&nbsp;отч.&nbsp;период 2020г.</th>
                                <th scope="col">Абс. откл.<br />за&nbsp;отч.&nbsp;период, +/-</th>
                                <th scope="col">Отн. откл.<br />за&nbsp;отч.&nbsp;период, %</th>
                                <th scope="col">Факт<br />за&nbsp;отч.период 2019г.</th>
                                <th scope="col">Абс. откл.<br />(факт&nbsp;2020г.&nbsp;-&nbsp;факт&nbsp;2019г.), +/-</th>
                                <th scope="col">Годовой план 2020 г.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in dzoData">
                                <td class="text-left">{{ item.title }}</td>
                                <td>{{ item.units }}</td>
                                <td>{{ (item.dataPlan).toFixed(2) }}</td>
                                <td>{{ (item.dataFact).toFixed(2) }}</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <span v-if="item.dataPlan - item.dataFact > 0" class="arrow2"></span>
                                        <span v-else class="arrow3"></span>
                                        {{ (Math.abs(item.dataPlan - item.dataFact)).toFixed(2) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <span v-if="((item.dataPlan - item.dataFact) / item.dataPlan * 100) > 0" class="arrow2"></span>
                                        <span v-else class="arrow3"></span>
                                        {{ Math.abs((item.dataPlan - item.dataFact) / item.dataPlan * 100).toFixed(2) }}
                                    </div>
                                </td>
                                <td>{{ (item.dataFactPrevYear).toFixed(2) }}</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <span v-if="item.dataFact - item.dataFactPrevYear > 0" class="arrow2"></span>
                                        <span v-else class="arrow3"></span>
                                        {{ (Math.abs(item.dataFact - item.dataFactPrevYear)).toFixed(2) }}
                                    </div>
                                </td>
                                <td>
                                    <div v-if="item.plan2020">{{ (item.plan2020).toFixed(2) }}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-grow-1">
            <vertical-indicators></vertical-indicators>
        </div>
    </div>
</template>
<script src="./VisualCenterTable5.js"></script>