<template>
    <div class="row mx-0 mt-lg-2">
        <div class="row col-12 p-0 m-0">
            <div class="gtm-dark col-12 col-md-4 col-lg-2 p-0">
                <div class="block-header text-center">
                    Соседние скважины
                </div>
                <div class="gtm-dark table-responsive near-wells-table-block table-scroll">
                    <table class="table table-striped table-borderless text-center text-white near-wells">
                        <tbody>
                        <tr>
                            <td class="align-middle text-left pl-3">Соседние скважины</td>
                            <td class="align-middle">Расстояние,м</td>
                            <td class="align-middle">Горизонты</td>
                        </tr>
                        <tr><td colspan="3" class="text-center near-wells-big">Добывающие</td></tr>
                        <tr class="near-wells-table-item" v-for="item in nearWellsData">
                            <td class="text-left p-2 pl-3">{{ item.name }}</td>
                            <td>{{ item.distance }}</td>
                            <td>{{ item.horizons }}</td>
                        </tr>
                        <tr><td colspan="3" class="text-center near-wells-big">Нагнетательные</td></tr>
                        <tr class="near-wells-table-item" v-for="item in nearWellsData">
                            <td class="text-left p-2 pl-3">{{ item.name }}</td>
                            <td>{{ item.distance }}</td>
                            <td>{{ item.horizons }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-none d-lg-block col-lg-5 p-0 pl-2 gtm-map-block">
                <div class="gtm-dark text-center h-100">
                    <div class="block-header">
                        Карты
                    </div>
                    <div class="gtm-dark p-3">
                        <img src="/img/GTM/map.svg" class="gtm-map-img">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-5 p-0 pl-md-2 pt-2 pt-md-0">
                <div class="gtm-dark h-100">
                    <div class="block-header text-center">
                        Таблица данных скважин
                    </div>
                    <div class="gtm-dark table-responsive table-scroll mh-400">
                        <table class="table table-striped table-borderless text-center text-white">
                            <tbody>
                            <tr class="near-wells-table-item" v-for="item in wellsData">
                                <td class="text-left p-2 pl-3">{{ item.fieldName }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-12 p-0 m-0">
            <div class="gtm-dark col-12 col-md-4 col-lg-2 p-0 mt-2">
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
            <div class="position-absolute tree-setting-block d-flex">
                <keep-alive>
                    <component v-bind:is="treeChildrenComponent" class="gtm-dark mt-2 mr-2 h-100" @node-click="nodeClick"></component>
                </keep-alive>
                <keep-alive>
                    <component v-bind:is="treeSettingComponent" class="gtm-dark mt-2 h-100"></component>
                </keep-alive>
            </div>
            <div class="col-12 col-md-8 col-lg-5 p-0 pl-md-2 pt-2 pt-md-0 mt-0 mt-md-2">
                <div class="gtm-dark">
                    <div class="block-header text-center">
                        Тип диаграммы
                    </div>
                    <div class="gtm-dark">
                        <div class="text-center text-white">
                            Распределение потерь нефти по факторам
                        </div>
                        <apexchart type="bar" height="290" class="mt-0" :options="chartOptions" :series="series"></apexchart>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 p-0 pl-lg-2 pt-2 pt-md-0 mt-0 mt-md-2">
                <div class="gtm-dark">
                    <div class="block-header text-center">
                        Планшет/кор.схема
                    </div>
                    <div class="gtm-dark table-responsive table-scroll h-324">
                        <table cellspacing="0" class="table text-center text-white schemaTable">
                            <thead class="schemaTHead">
                            <th>Вид ГТМ</th>
                            <th>Ед.</th>
                            <th>План</th>
                            <th>Факт</th>
                            <th>Откл.</th>
                            <th>Участвует в анализе</th>
                            <th>Экономически не рентаб.</th>
                            <th>Доля не успешных ГТМ</th>
                            <th>КВЛ общий</th>
                            <th>КВЛ не рентаб.</th>
                            <th>Доля, %</th>
                            </thead>
                            <tbody>
                            <tr class="near-wells-table-item" v-for="schemaItem in schemaData">
                                <td v-for="item in schemaItem">{{ item }}</td>
                            </tr>
                            </tbody>
                        </table>
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
            nearWellsData: [
                {name: 'Jet_2596', distance: '', horizons: ''},
                {name: 'Jet_3303', distance: '', horizons: ''},
                {name: 'Jet_2875', distance: '', horizons: ''},
                {name: 'Jet_1300', distance: '', horizons: ''},
                {name: 'Jet_4937', distance: '', horizons: ''},
                {name: 'Jet_3309', distance: '', horizons: ''},
                {name: 'Jet_0299', distance: '', horizons: ''},
                {name: 'Jet_0239', distance: '', horizons: ''},
                {name: 'Jet_4717', distance: '', horizons: ''},
            ],
            wellsData: [
                {fieldName: 'ВНС'},
                {fieldName: 'ВНС С ГРП'},
                {fieldName: 'ПВЛГ'},
                {fieldName: 'ПВР'},
                {fieldName: 'ГРП'},
                {fieldName: 'ВБД'},
                {fieldName: 'ВПС'},
                {fieldName: 'ВНС'},
                {fieldName: 'ВНС С ГРП'},
                {fieldName: 'ПВЛГ'},
                {fieldName: 'ПВР'},
                {fieldName: 'ГРП'},
                {fieldName: 'ВБД'},
                {fieldName: 'ВПС'},
            ],
            schemaData: [
                ['', '', 1, 2 , '(3)=(2)-(1)', 4, 5, '(6)=(5)(4)', 7, 8, '(9)=(7)(8)'],
                ['Бурение', 'скв.', 76, 56, -20, 46, '23(15 ВНС, 8 ВНС с ГРП)', 50, 11965, 5966, 50],
                ['ГРП', 'скв.', 76, 56, -20, 46, '23(15 ВНС, 8 ВНС с ГРП)', 50, 11965, 5966, 50],
                ['ПВЛГ', 'скв.', 76, 56, -20, 46, '23(15 ВНС, 8 ВНС с ГРП)', 50, 11965, 5966, 50],
                ['ВПС', 'скв.', 76, 56, -20, 46, '23(15 ВНС, 8 ВНС с ГРП)', 50, 11965, 5966, 50],
                ['ПВР', 'скв.', 76, 56, -20, 46, '23(15 ВНС, 8 ВНС с ГРП)', 50, 11965, 5966, 50],
                ['ВБД', 'скв.', 76, 56, -20, 46, '23(15 ВНС, 8 ВНС с ГРП)', 50, 11965, 5966, 50],
                ['Итого', 'скв.', 76, 56, -20, 46, '23(15 ВНС, 8 ВНС с ГРП)', 50, 11965, 5966, 50],
            ],
            treeData: structureMain.finder_model.children,
            contextMenuItems: [],
            series: [{
                type: 'bar',
                stroke: {
                    show: false
                },
                data: [1980, 2000, 1890, 2390, 2145, 2036, 2250, 2145, 2036, 2250, 1980, 2000, 1890, 2390, 2145, 2036, 2250, 2145, 2036, 2250]
            }],
            chartOptions: {
                labels: ['Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937',
                    'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937'],
                fill: {
                    colors: ['#855CF8'],
                    opacity: 0.24
                },
                dataLabels: {
                    enabled: false,
                },
                tooltip: {
                    enabled: false,
                },
                yaxis: {
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false
                    },
                },
                xaxis: {
                    position: 'bottom',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        rotate: -90,
                        style: {
                            colors: ['white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white',
                                'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white'],
                            fontSize: '10px',
                        }
                    }
                },
            },
            treeSettingHeader: '',
            treeSettingBody: '',
            treeSettingComponent: null,
            treeChildrenComponent: null,
        };
    },
    methods: {
        nodeClick (data) {
            let node = data.node;
            if (node.ioi_finder_model) {
                this.treeChildrenComponent = {
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
                };
            } else if (data.hideIoiMenu){
                this.treeChildrenComponent = null;
            }
            this.treeSettingComponent = {
                name: 'gtm-tree-setting',
                data: function () {
                    return {
                        treeData: {
                            children: node.setting_model.children
                        },
                    }
                },
                template: '<div><div class="block-header text-center">'+ node.name + '</div><gtm-tree :treeData="treeData"></gtm-tree></div>',
            };
        },
    },
}
</script>