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
                    <select class="w-100 h-50 mt-3 mb-3" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">Выбор ДЗО</option>
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
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">С начала года</option>
                    </select>
                </div>
                <div class="w-25 ml-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">За месяц</option>
                    </select>
                </div>
                <div class="w-25 ml-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">Квартал</option>
                    </select>
                </div>
                <div class="w-25 ml-3 mr-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">Актуализированный месяц</option>
                    </select>
                </div>
            </div>
            <div class="first-string mr-2">
                <h5 class="text-center mr-2"><strong>Макропоказатели</strong></h5>
                <div class="ml-0 ml-sm-3 mr-0 mr-sm-3">
                    <div class="w-100">
                        <table class="table pl-2 table-striped table-borderless">
                            <thead class="economics-table-color">
                            <tr>
                                <th scope="col">Наименование</th>
                                <th scope="col">Ед.изм.</th>
                                <th scope="col">План 2020</th>
                                <th scope="col">Факт 2020</th>
                                <th scope="col">Факт-план 2020</th>
                                <th scope="col">Факт 2019</th>
                                <th scope="col">Факт 2020-факт 2019</th>
                                <th scope="col">План на 2020</th>
                                <th scope="col">План/факт</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Обменный курс</td>
                                <td>Тенге/$</td>
                                <td>450</td>
                                <td>405</td>
                                <td><span class="arrow2"></span>45</td>
                                <td>379</td>
                                <td><span class="arrow3"></span>45</td>
                                <td>450</td>
                                <td>План Факт</td>
                            </tr>
                            <tr>
                                <td>Обменный курс</td>
                                <td>Тенге/$</td>
                                <td>450</td>
                                <td>405</td>
                                <td><span class="arrow2"></span>45</td>
                                <td>379</td>
                                <td><span class="arrow3"></span>45</td>
                                <td>450</td>
                                <td>План Факт</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5 class="text-center mr-2 mt-3" v-if="data.length > 0"><strong>Финансовые показатели</strong></h5>
                <div class="ml-0 ml-sm-3 mr-0 mr-sm-3 mb-0 mb-sm-3" v-if="data.length > 0">
                    <div class="w-100">
                        <table class="table pl-2 table-striped table-borderless">
                            <thead class="economics-table-color">
                            <tr>
                                <th scope="col">Наименование</th>
                                <th scope="col">Ед.изм.</th>
                                <th scope="col">План 2020</th>
                                <th scope="col">Факт 2020</th>
                                <th scope="col">Факт-план 2020</th>
                                <th scope="col">Факт 2019</th>
                                <th scope="col">Факт 2020-факт 2019</th>
                                <th scope="col">План на 2020</th>
                                <th scope="col">План/факт</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in data">
                                <td>{{ item.title }}</td>
                                <td>{{ item.units }}</td>
                                <td>{{ (item.dataPlan / 1000000).toFixed(2) }}</td>
                                <td>{{ (item.dataFact / 1000000).toFixed(2) }}</td>
                                <td>
                                    <span v-if="item.dataPlan - item.dataFact > 0" class="arrow2"></span>
                                    <span v-else class="arrow3"></span>
                                    {{ (Math.abs(item.dataPlan - item.dataFact) / 1000000).toFixed(2) }}
                                </td>
                                <td>{{ (item.dataFactPrevYear / 1000000).toFixed(2) }}</td>
                                <td>
                                    <span v-if="item.dataFact - item.dataFactPrevYear > 0" class="arrow2"></span>
                                    <span v-else class="arrow3"></span>
                                    {{ (Math.abs(item.dataFact - item.dataFactPrevYear) / 1000000).toFixed(2) }}
                                </td>
                                <td>{{ (item.plan2020 / 1000000).toFixed(2) }}</td>
                                <td>{{ item.progress }}</td>
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