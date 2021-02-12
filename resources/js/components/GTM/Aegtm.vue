<template>
    <div class="row mx-0 mt-lg-2">
        <div class="col-lg-2 p-0">
            <div class="bg-dark">
                <div class="block-header text-center">
                    НДО
                </div>
                <div class="bg-dark table-responsive table-scroll">
                    <table class="table table-striped table-borderless text-center text-white near-wells-big">
                        <tbody>
                        <tr class="near-wells-table-item" v-for="ndoItem in ndo">
                            <td v-for="item in ndoItem">{{ item }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-dark mt-2">
                <div class="block-header text-center">
                    Графики
                </div>
                <div class="bg-dark">
                    <apexchart type="bar" style="margin-top:0px;" :options="demoChartOptions" :series="demoSeries"></apexchart>
                </div>
            </div>
        </div>
        <div class="col-lg-10 p-0">
            <div class="row col-12 p-0 m-0">
                <div class="col-6 d-none d-lg-block p-0 pl-2 gtm-map-block">
                    <div class="bg-dark text-center h-100">
                        <div class="block-header">
                            Карты
                        </div>
                        <div class="bg-dark p-3">
                            <img src="/img/GTM/map.svg" class="gtm-map-img">
                        </div>
                    </div>
                </div>
                <div class="col-6 p-0 pl-md-2 pt-2 pt-md-0">
                    <div class="bg-dark h-100">
                        <div class="block-header text-center">
                            Таблица данных скважин
                        </div>
                        <div class="bg-dark table-responsive table-scroll" style="height: 400px;">
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
                <div class="col-6 p-0 pl-md-2 pt-2 pt-md-0 mt-0 mt-md-2">
                    <div class="bg-dark h-100">
                        <div class="block-header text-center">
                            Тип диаграммы
                        </div>
                        <div class="bg-dark">
                            <div class="text-center text-white">
                                Распределение потерь нефти по факторам
                            </div>
                            <apexchart type="bar" height="290" style="margin-top:0px;" :options="chartOptions" :series="series"></apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-6 p-0 pl-lg-2 pt-2 pt-md-0 mt-0 mt-md-2">
                    <div class="bg-dark h-100">
                        <div class="block-header text-center">
                            Планшет/кор.схема
                        </div>
                        <div class="bg-dark table-responsive table-scroll" style="height: 324px;">
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
    </div>
</template>

<script>
import { bTreeView } from 'bootstrap-vue-treeview'
export default {
    components: {
        bTreeView
    },
    data: function () {
        return {
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
            nodeSelect: (item) => {
                console.log(item);
            },
            series: [{
                type: 'area',
                stroke: {
                    show: false
                },
                data: [1980, 2000, 1890, 2390, 2145, 2036, 2250, 2145, 2036, 2250, 1980, 2000, 1890, 2390, 2145, 2036, 2250, 2145, 2036, 2250]
            }],
            chartOptions: {
                labels: ['Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937',
                    'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937'],
                fill: {
                    colors: ['#109CF1'],
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
            demoSeries: [{
                type: 'bar',
                stroke: {
                    show: false
                },
                data: [1980, 2000, 1890, 2390, 2145, 2036, 2250, 2145, 2036, 2250, 1980, 2000, 1890, 2390, 2145]
            }],
            demoChartOptions: {
                labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15'],
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
                        style: {
                            colors: ['white', 'white', 'white', 'white', 'white', 'white', 'white', 'white',
                                'white', 'white', 'white', 'white', 'white', 'white', 'white'],
                            fontSize: '10px',
                        }
                    }
                },
            },
        };
    }
}
</script>
<style>
.tree-branch {
    color: white;
}
</style>