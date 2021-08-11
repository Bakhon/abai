<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalMap"
                draggable=".modal-bign-header"
                :width="1500"
                :height="700"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">{{kpd.name}} {{managerInfo.title}} ({{managerInfo.manager}}) на {{currentYear}} г.</div>
                    <button type="button" class="modal-bign-button" @click="$modal.hide('modalMap')">
                        {{trans('pgno.zakrit')}}
                    </button>
                </div>
                <div class="modal-bign-header mt-2 justify-content-between d-flex">
                    <div class="d-flex">
                        <div
                                v-for="(filter,index) in filters"
                                :class="[selectedFilter === filter ? 'filter_selected' : '',
                                    index === 0 ? 'ml-2' : 'ml-5',
                                    'd-flex main-buttons p-2']"
                                @click="handleFilter(index)"
                        >
                            <img :src="filter.icon" class="filter-icon"></img>
                            <div class="ml-2">{{filter.name}}</div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="main-buttons p-2 d-flex">
                            <div class="img-export"></div>
                            <div class="ml-1">Экспорт</div>
                        </div>
                        <div class="main-buttons p-2 d-flex ml-5">
                            <div class="img-monitoring"></div>
                            <div @click="$modal.show('modalMonitoring')" class="ml-1">Мониторинг КПД</div>
                        </div>
                    </div>
                </div>
                <table class="modal_table mt-2">
                    <tr>
                        <th class="p-3" v-for="header in kpd.table.headers">{{header}}</th>
                    </tr>
                    <tr v-for="row in kpd.table.body">
                        <td class="p-1" v-for="column in row">{{column}}</td>
                        <td class="p-1">
                            <select class="filter_select p-1">
                                <option
                                        v-for="filter in filters"
                                        :value="filter.name"
                                        class="p-1"
                                >
                                    {{filter.name}}
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-1">
                            {{kpdCount + 1}}
                        </td>
                        <td class="p-1">
                            <div class="input-group filter_select border-0">
                                <input type="text" class="form-control filter_select border-0" placeholder="Введите или выберите название КПД" :value="selectedKpd">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split border-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" v-for="kpd in kpd.table.body" @click="selectedKpd = kpd[1]">{{kpd[1]}}</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-1">
                            <div class="input-group filter_select border-0">
                                <input type="text" class="form-control filter_select border-0" aria-label="Ед. измерения" :value="selectedUnit">
                                <div class="input-group-append border-0">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split border-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" v-for="unit in units" @click="selectedUnit = unit">{{unit}}</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-1">
                            <div class="input-group filter_select border-0">
                                <input type="text" class="form-control filter_select border-0" aria-label="Введите вес">
                            </div>
                        </td>
                        <td class="p-1">
                            <div class="input-group filter_select border-0">
                                <input type="text" class="form-control filter_select border-0" aria-label="">
                            </div>
                        </td>
                        <td class="p-1">
                            <div class="input-group filter_select border-0">
                                <input type="text" class="form-control filter_select border-0" aria-label="">
                            </div>
                        </td>
                        <td class="p-1">
                            <div class="input-group filter_select border-0">
                                <input type="text" class="form-control filter_select border-0" aria-label="">
                            </div>
                        </td>
                        <td class="p-1">

                                <input type="text" class="form-control filter_select border-0" aria-label="">

                        </td>
                        <td class="p-1">
                            <select class="filter_select p-1">
                                <option v-for="filter in filters" :value="filter.name">
                                    {{filter.name}}
                                </option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="modal-bign-header mt-5 d-flex">
                    <div class="d-flex">
                        <div class="col-3 kpd-ceo_header-b row p-4 chairmaster" v-for="manager in managerInfo.concordants">
                            <img :src="manager.img" class="manager-icon"></img>
                            <img :src="statusMapping[manager.status]" class="filter-icon ml-2 mt-2"></img>
                            <span class="ml-2">{{manager.status}}</span>
                            <br>
                            <div class="ml-5 text-left manager-about">
                                <b>{{manager.name}}</b>
                                ({{manager.position}})
                            </div>
                        </div>
                    </div>
                </div>
                <div align="center" class="bottom-buttons col-12 row">
                    <div class="col-1 download-button m-4" @click="$modal.hide('modalMap')">ОК</div>
                    <div class="col-1 cancel-button m-4" @click="$modal.hide('modalMap')">Отмена</div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import Vue from "vue";

export default {
    data: function () {
        return {
            statusMapping: {
                'Утверждено': '/img/kpd-tree/filter_green.png',
                'Согласовано': '/img/kpd-tree/filter_blue.png',
                'Проект': '/img/kpd-tree/filter_gray.png',
            },
            units: [
                'сутки',
                'месяц',
                'полугодие',
                'год'
            ],
            selectedUnit: null,
            selectedKpd: null,
            currentYear: new Date().getFullYear(),
            kpd: {
                'name': 'Карта КПД',
                'table': {
                    'headers': [
                        '№ п/п',
                        'Наименование КПД',
                        'Единица измерения',
                        'Вес',
                        'Порог (50%)',
                        'Цель (100%)',
                        'Вызов (125%)',
                        'ФИО ответственного за КПД',
                        'Согласование'
                    ],
                    'body': [
                        [
                            1,
                            'Прирост извлекаемых запасов',
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Должность ФИО',
                        ],
                        [
                            2,
                            'Исполнение бизнес-инициатив',
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Должность ФИО',
                        ],
                        [
                            3,
                            'Реализация инвестиционных проектов',
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Должность ФИО',
                        ],
                        [
                            4,
                            'Чистый денежный поток в КЦ КМГ от дивизиона',
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Должность ФИО',
                        ],
                        [
                            5,
                            'Операционные и капитальные затраты по ДЗО',
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Должность ФИО',
                        ]
                    ]
                }
            },
            filters: [
                {
                    'name':'Проект',
                    'icon': '/img/kpd-tree/filter_gray.png',
                    'selected': false
                },
                {
                    'name':'Согласовано',
                    'icon': '/img/kpd-tree/filter_blue.png',
                    'selected': false

                },
                {
                    'name':'Утверждено',
                    'icon': '/img/kpd-tree/filter_green.png',
                    'selected': false
                }
            ],
            selectedFilter: null,
            kpdCount: 0
        };
    },
    methods: {
        handleFilter(index) {
            _.forEach(this.filters, (filter) => {
                filter.selected = false;
            });
            this.filters[index].selected = true;
            selectedFilter = this.filters[index];
        },
    },
    async mounted() {
        this.kpdCount = this.kpd.table.body.length;
    },
    props: ['managerInfo'],
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.modal_table {
    width: 100%;
    tr:first-child th {
        background: #3A4280;
        border: 1px solid #545580;
        max-height: 40px;
        height: 40px;
    }
    tr td {
        border: 1px solid #545580;
        height: 30px;
    }
    tr:nth-child(even) {
        background: #272953;
    }
    tr:nth-child(odd) {
        background: #2B2E5C;
    }
}
.download-button {
    background: #3366FF;
    border-radius: 5px;
}
.cancel-button {
    background: #40467E;
    border-radius: 5px;
}
.bottom-buttons {
    position: absolute;
    bottom: 0;
    justify-content: center;
}
.filter_selected {
    background: #3C4280;
}
.img-monitoring {
    background: url(/img/kpd-tree/monitoring.png) no-repeat;
    height: 25px;
    width: 35px;
    margin-top: -5px;
}
.img-export {
    background: url(/img/kpd-tree/export.png) no-repeat;
    height: 25px;
    width: 25px;
    margin-top: -5px;
}
.filter_select {
    background: #1A1D46;
    color: white;
    border-radius: 5px;
}
.filter-icon {
    height: 10px;
}
.manager-icon {
    height: 45px;
}
.manager-about {
    margin-top: -15px;
}
.main-buttons {
    line-height: 10px;
}
.main-buttons:hover {
    background: #3A4280;
}
</style>