<template>
    <div>
        <div class="row mx-0 mt-lg-2 gtm">
            <div class="col-lg-10 p-0">
                <div class="row col-12 p-0 m-0">
                    <div class="col-6 d-none d-lg-block p-0 pl-1">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Скважины-кандидаты
                            </div>
                            <div class="gtm-dark p-1 pl-2">
                                <table class="table text-center text-white podbor-middle-table">
                                    <thead>
                                        <tr>
                                            <th class="align-middle" rowspan="2">№ скв.</th>
                                            <th class="align-middle" rowspan="2">ГТМ</th>
                                            <th colspan="3">Прогнозные показатели</th>
                                        </tr>
                                        <tr>
                                            <th>Qж</th>
                                            <th>Qн</th>
                                            <th>обв. %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="candidate in candidates">
                                            <td>{{ candidate[0] }}</td>
                                            <td>{{ candidate[1] }}</td>
                                            <td>{{ candidate[2] }}</td>
                                            <td>{{ candidate[3] }}</td>
                                            <td>{{ candidate[4] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Карта текущих отборов
                            </div>
                            <div class="gtm-dark p-3">
                                <img src="/img/GTM/map.svg" class="gtm-map-img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-12 p-0 m-0 pb-2">
                    <div class="col-6 d-none d-lg-block p-0 pl-1">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Скважина 4931
                            </div>
                            <div class="gtm-dark p-1 pl-2 mh-370">
                                <gtm-line-chart :chartdata="{labels: lineLabels, datasets: lineChartData}" :options="lineChartOptions" :height="360"></gtm-line-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="gtm-dark h-100 pb-2">
                            <div class="block-header pb-0 pl-2">
                                Факторный анализ по объекту разработки, тыс. тонн
                            </div>
                            <div class="gtm-dark p-1 pl-2">
                                <!--                                <pie-chart :height="360"></pie-chart>-->
                                <img class="demo-img" src="/img/GTM/podbo_demo_graph.svg" height="350">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 p-0 pl-2 pr-1">
                <div class="position-absolute tree-setting-block d-flex z-index-1">
                    <keep-alive>
                        <component v-bind:is="treeSettingComponent" class="gtm-dark h-100"></component>
                    </keep-alive>
                    <keep-alive>
                        <component v-bind:is="treeChildrenComponent" class="gtm-dark ml-2 h-100" @node-click="nodeClick"></component>
                    </keep-alive>
                </div>
                <div class="gtm-dark pb-3 position-relative z-index-1">
                    <div class="block-header text-center">
                        Поиск потенциала
                    </div>
                    <div class="gtm-dark">
                        <gtm-tree
                            v-for="treeDataChild in treeData"
                            :treeData="treeDataChild"
                            :key="treeDataChild.name"
                            @node-click="nodeClick"
                        ></gtm-tree>
                    </div>
                </div>
                <div class="mt-2 row m-0">
                    <div class="col-5 p-0">
                        <div class="calendar-filter-block d-flex align-items-center">
                            01.08.2018
                            <img class="calendar-icon" src="/img/GTM/calendar_icon.svg">
                        </div>
                    </div>
                    <div class="col-5 p-0">
                        <div class="ml-1 calendar-filter-block d-flex align-items-center">
                            01.08.2018
                            <img class="calendar-icon" src="/img/GTM/calendar_icon.svg">
                        </div>
                    </div>
                    <div class="col-1 p-0">
                        <div class="ml-1 calendar-filter-block d-flex align-items-center">
                            <img class="gear-icon m-auto" src="/img/GTM/gear.svg">
                        </div>
                    </div>
                </div>
                <div class="gtm-dark mt-2">
                    <div class="block-header text-center p-2">
                        Вид ГТМ
                    </div>
                    <div class="gtm-dark text-white pl-2">
                        1) Все ГТМ <br />
                        2) ВНС <br />
                        3) ГРП <br />
                        4) ПВЛГ <br />
                        5) ПВР <br />
                        6) РИР <br />
                    </div>
                </div>
                <div class="gtm-dark mt-2 row m-0">
                    <div class="col-1 text-right mt-1 mb-1 p-0">
                        <img src="/img/GTM/lens.svg">
                    </div>
                    <div class="col-11 m-0 mt-1 mb-1 row p-0">
                        <input class="search-input w-75" type="text" placeholder="Поиск по скважине">
                        <button class="search-button pl-2 pr-2">Поиск</button>
                    </div>
                    <div class="gtm-dark text-white pl-2" style="min-height: 213px;">
                        Все скважины
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import structureMain from './structure_main.json'
export default {
    data: function () {
        return {
            candidates: [
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
            ],
            treeData: structureMain.finder_model.children,
            lineLabels: ['Янв.', 'Фев.', 'Мар.', 'Апр.', 'Май', 'Июнь', 'Июль', 'Авг.', 'Сен.', 'Окт.', 'Ноя.', 'Дек.'],
            lineChartData: [
                {
                    label: 'Пласт',
                    borderColor: "rgba(242, 126, 49, 1)",
                    data: [1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500],
                    fill: false,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'Обводненность',
                    borderColor: "rgba(57, 81, 206, 1)",
                    data: [3200, 4700, 1950, 2800, 2400, 3300, 800, 1100, 3100, 4400, 1000, 2700],
                    fill: false,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'Qн (По МЭР), м3/сут',
                    borderColor: "rgba(239, 83, 80, 1)",
                    backgroundColor: 'rgba(239, 83, 80, 0.2)',
                    data: [500, 700, 900, 500, 1100, 1500, 1000, 560, 780, 1300, 2000, 1750],
                    fill: true,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'Qж (По МЭР), м3/сут',
                    borderColor: "rgba(76, 175, 80, 1)",
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    data: [2800, 4700, 2400, 1000, 2400, 200, 2800, 3400, 2450, 2000, 1000, 800],
                    fill: true,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                }
            ],
            lineChartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#3C4270',
                        },
                        ticks: {
                            display: false,
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#3C4270',
                        },
                        ticks: {
                            display: false,
                        },
                    }],
                }
            },
            treeSettingHeader: '',
            treeSettingBody: '',
        };
    },
    methods: {
        nodeClick (data) {
            this.$_setTreeChildrenComponent(data);
            this.$store.commit('changeTreeSettingComponent', {
                name: 'gtm-tree-setting',
                data: function () {
                    return {
                        treeData: {
                            children: data.node.setting_model.children
                        },
                    }
                },
                template: '<div><div class="block-header text-center">'+ data.node.name + '</div><gtm-tree :treeData="treeData"></gtm-tree></div>',
            });
        },
        $_setTreeChildrenComponent(data) {
            let node = data.node;
            this.$store.commit('changeIsShadowBlockShow',true);
            if (node.ioi_finder_model === undefined) {
                if (data.hideIoiMenu) {
                    this.$store.commit('changeTreeChildrenComponent',null);
                    return;
                } else {
                    return;
                }
            }
            this.$store.commit('changeTreeChildrenComponent', {
                name: 'gtm-tree-setting',
                data: function () {
                    return {
                        treeData: {
                            children: node.ioi_finder_model.children
                        },
                    }
                },
                template: '<div><div class="block-header text-center">'+ node.name + '</div><gtm-tree :treeData="treeData" @node-click="handleClick"></gtm-tree></div>',
                methods: {
                    handleClick (data) {
                        this.$emit('node-click', {node: data.node, hideIoiMenu: false});
                    }
                }
            });
        }
    },
    computed: {
        treeChildrenComponent() {
            return this.$store.state.treeChildrenComponent;
        },
        treeSettingComponent() {
            return this.$store.state.treeSettingComponent;
        },
    },
}
</script>