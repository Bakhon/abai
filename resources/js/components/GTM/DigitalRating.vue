<template>
    <div>
        <div class="row mx-0 mt-lg-2 gtm">
            <div class="col-lg-10 p-0">
                <div class="row col-12 p-0 m-0">
                    <div class="col-6 d-none d-lg-block p-0 pl-1 gtm-map-block">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2">
                                Настройка сетки
                            </div>
                            <div class="gtm-dark p-1 pl-2 m-1 mr-2 dr-border-light dr-map-bg">
                                <div class="col-5 float-right">
                                    <div class="gtm-dark mt-2 row m-0 dr-search-bg dr-search-border-radius">
                                        <div class="col-1 text-right mt-1 mb-1 p-0">
                                            <img src="/img/GTM/lens.svg">
                                        </div>
                                        <div class="col-11 m-0 mt-1 mb-1 row p-0">
                                            <input class="search-input w-75 dr-search-bg" type="text" placeholder="Поиск по скважине">
                                            <button class="search-button pl-2 pr-2">Поиск</button>
                                        </div>
                                    </div>
                                </div>
                                <img class="mt-5 mb-4" src="/img/GTM/dr_map.png" height="235">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0 gtm-map-block">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Планшет по скважинам
                            </div>
                            <div class="gtm-dark mr-2">
                                <div class="dr-border-light">
                                    <table cellspacing="0" cellpadding="0" class="dr-wt-table text-white text-center m-0">
                                        <tbody>
                                        <tr v-for="wellsTabletNumber in wellsTabletNumbers">
                                            <td>
                                                <div>
                                                    <div class="text-left">
                                                        <img src="/img/GTM/dr_wt_triangle.svg">
                                                    </div>
                                                    {{ wellsTabletNumber }}
                                                </div>
                                            </td>
                                            <td v-for="wellsTabletMapName in wellsTabletMapNames"><div>{{ wellsTabletMapName }}</div></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-12 p-0 m-0 pb-2">
                    <div class="col-6 d-none d-lg-block p-0 pl-1 gtm-map-block">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2">
                                Настройка секторов
                            </div>
                            <div class="gtm-dark pr-1 pl-2 m-1 mr-2 dr-border-light dr-map-bg">
                                <div class="d-flex justify-content-around mt-2">
                                    <select class="calendar-filter-block border-0 mr-2 pl-2 pr-2 dr-fw-700" name="file" id="file">
                                        <option value="0">Файл</option>
                                    </select>
                                    <select class="calendar-filter-block border-0 mr-2 pl-2 pr-2 dr-fw-700" name="map" id="map">
                                        <option value="0">Карта</option>
                                    </select>
                                    <select class="calendar-filter-block border-0 mr-2 pl-2 pr-2 dr-fw-700" name="instr" id="instr">
                                        <option value="0">Инструменты</option>
                                    </select>
                                    <input class="calendar-filter-block border-0 mr-2" type="text" />
                                    <input class="calendar-filter-block border-0 mr-2" type="text" />
                                    <input class="calendar-filter-block border-0" type="text" />
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <img class="mt-5 mb-4" src="/img/GTM/dr_map.png" height="180">
                                    </div>
                                    <div class="mt-1 text-white">
                                        <div class="gtm-dark-2 p-1 pl-2 mr-1 mb-1">
                                            <div class="d-flex justify-content-between">
                                                <div class="dr-fw-700">Диспетчер слоев</div>
                                                <span>
                                                    <img src="/img/icons/link.svg" alt="">
                                                </span>
                                            </div>
                                            <p class="dr-fs-08 m-0">
                                                18-11-2020 максимальный <br />
                                                17-11-2020 макс+средний <br />
                                                13-11-2020 макс+средн+низк <br />
                                                13-11-2020 карта нак отборов <br />
                                                13-11-2020 карта фаций
                                            </p>
                                        </div>
                                        <div class="gtm-dark-2 p-1 pl-2 mr-1 mb-1">
                                            <div class="d-flex justify-content-between">
                                                <div class="dr-fw-700">Объект разработки</div>
                                                <span>
                                                    <img src="/img/icons/link.svg" alt="">
                                                </span>
                                            </div>
                                            <p class="dr-fs-08 m-0">13 горизонт
                                                14 горизонт <br />
                                                15 горизонт <br />
                                                16 горизонт <br />
                                                18 горизонт
                                            </p>
                                        </div>
                                        <div class="gtm-dark-2 p-1 pl-2 mr-1 mb-1">
                                            <div class="d-flex justify-content-between">
                                                <div class="dr-fw-700">Свойства</div>
                                                <span>
                                                    <img src="/img/icons/link.svg" alt="">
                                                </span>
                                            </div>
                                            <p class="dr-fs-08 m-0">Цвет
                                                Шрифт <br />
                                                Толщина <br />
                                                Прозрачность <br />
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0 gtm-map-block">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Статистика
                            </div>
                            <div class="gtm-dark p-1 pl-2 mh-370 table-responsive table-scroll">
                                <table class="table text-center text-white podbor-middle-table">
                                    <thead>
                                    <tr>
                                        <th class="align-middle" rowspan="2">№ скв.</th>
                                        <th colspan="2">Кол-во</th>
                                        <th colspan="2">Ср. дебит</th>
                                        <th colspan="2">Доп.добыча, тыс.т</th>
                                        <th class="align-middle" rowspan="2">% усп.</th>
                                    </tr>
                                    <tr>
                                        <th>план</th>
                                        <th>факт</th>
                                        <th>план</th>
                                        <th>факт</th>
                                        <th>план</th>
                                        <th>факт</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="statisticsItem in statistics">
                                        <td>{{ statisticsItem[0] }}</td>
                                        <td>{{ statisticsItem[1] }}</td>
                                        <td>{{ statisticsItem[2] }}</td>
                                        <td>{{ statisticsItem[3] }}</td>
                                        <td>{{ statisticsItem[4] }}</td>
                                        <td>{{ statisticsItem[5] }}</td>
                                        <td>{{ statisticsItem[6] }}</td>
                                        <td>{{ statisticsItem[7] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 p-0 pl-2 pr-1">
                <div class="gtm-dark">
                    <div class="block-header text-center p-2">
                        Планшет
                    </div>
                    <div class="gtm-dark m-0 overflow-hidden">
                        <img src="/img/GTM/dr_demo_graph.png">
                    </div>
                </div>
                <div class="gtm-dark mt-2" style="min-height: 360px;">
                    <div class="gtm-dark text-white text-center dr-graph-switch p-3">
                        <div v-for="graphSwitchItem in graphSwitchItems" class="d-flex align-items-center justify-content-center">
                            <div>
                                <span>График:</span>
                                <div v-html="graphSwitchItem"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueChartJs from 'vue-chartjs'
export default {
    data: function () {
        return {
            wellsTabletNumbers: [13402020, 1440307, 15402010, 1640203],
            wellsTabletMapNames: [
                'Структурная карта + текущих отборов',
                'Карта ННТ + Накопленных отборов',
                'Карта изобар',
                'Сейсмика (ВРС)',
                'Карта ОИЗ',
                'Карта инфраструктуры и поверхности',
                'Карта минерализации',
            ],
            statistics: [
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
            ],
            graphSwitchItems: [
                "Экономика и приоритет сектора",
                "Запасы сектора",
                "Выработка",
                "Текущие показатели добычи нефти, жидкости и закачки воды от времени",
            ],
            ndo: [
                ['ОМГ', '', ''],
                ['ЭМГ', 'Жетыбай', 'Ю-2+3'],
                ['', '', 'Ю-4'],
                ['', '', 'Ю-5'],
                ['', '', 'Ю-6'],
                ['', '', ''],
                ['', '', ''],
                ['', 'Аскар', ''],
                ['', 'Каламкас', ''],
            ],
        };
    }
}
</script>