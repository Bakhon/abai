<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalMonitoring"
                draggable=".modal-bign-header"
                :width="1500"
                :height="800"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header d-flex">
                    <img :src="managerInfo.img" class="manager-icon ml-5"></img>
                    <div class="modal-bign-title modal_header">{{kpd.name}}</div>
                    <button type="button" class="modal-bign-button" @click="$modal.hide('modalMonitoring')">
                        {{trans('pgno.zakrit')}}
                    </button>
                </div>
                <table class="modal_table mt-5">
                    <tr>
                        <th rowspan="2" class="p-3">№<br>п/п</th>
                        <th rowspan="2" class="p-3">Наименование КПД</th>
                        <th rowspan="2" class="p-3">Единица<br>измерения</th>
                        <th rowspan="2" class="p-3">Вес</th>
                        <th rowspan="2" class="p-3">Порог (50%)&emsp;&emsp;Цель (100%)&emsp;&emsp;Вызов (125%)</th>
                        <th colspan="3" class="p-3">Результаты</th>
                        <th rowspan="2" class="p-3">Комментарии</th>
                    </tr>
                    <tr>
                        <th class="p-3">Факт за</th>
                        <th class="p-3">Оценка<br>(баллы)</th>
                        <th class="p-3">Вклад<br>в суммарную<br>результативность</th>
                    </tr>
                    <tr v-for="row in kpd.table.body">
                        <td class="p-3" v-for="column in row">{{column}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>100%</td>
                        <td></td>
                        <td colspan="3">
                            Итоговая результативность
                            <span class="summary ml-4">74%</span>
                        </td>
                        <td></td>
                    </tr>
                </table>
                <div align="center" class="bottom-buttons col-12 row">
                    <div class="col-1 download-button m-4" @click="$modal.hide('modalMonitoring')">ОК</div>
                    <div class="col-1 cancel-button m-4" @click="$modal.hide('modalMonitoring')">Отмена</div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
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
            kpd: {
                'name': 'Мониторинг КПД заместителя председателя правления по разведке и добыче (Марабаев Ж.Н.) на 2021 год',
                'table': {
                    'body': [
                        [
                            1,
                            'Прирост извлекаемых запасов',
                            'млн. тонн',
                            '20%',
                            '',
                            '31',
                            '70%',
                            '25%',
                            ''
                        ],
                        [
                            2,
                            'Операционные и капитальные затраты по ДЗО дивизиона',
                            'млн. тенге',
                            '20%',
                            '',
                            '1 000 000',
                            '125%',
                            '25%',
                            ''
                        ],
                        [
                            3,
                            'Чистый денежный поток в КЦ КМГ от дивизиона',
                            'млн. тенге',
                            '20%',
                            '',
                            '-15 000',
                            '0',
                            '0',
                            ''
                        ],
                        [
                            4,
                            'Исполнение бизнес-инициатив',
                            '%',
                            '20%',
                            '',
                            '104%',
                            '125%',
                            '25%',
                            ''
                        ],
                        [
                            5,
                            'Реализация инвестиционных проектов',
                            '%',
                            '20%',
                            '',
                            '90%',
                            '50%',
                            '10%',
                            ''
                        ],
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
    tr th {
        background: #3A4280;
        border: 1px solid #545580;
        max-height: 40px;
        height: 40px;
    }
    tr td {
        border: 1px solid #545580;
        height: 30px;
    }
    tr:last-child {
        td:not(:first-child){
            border: none;
            background: #3A4280;
        }
        td:not(:last-child){
            border: none;
            background: #3A4280;
        }
        td:first-child {
            border-left: 1px solid #545580;
        }
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
}
.img-export {
    background: url(/img/kpd-tree/export.png) no-repeat;
    height: 25px;
    width: 25px;
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
    height: 70px;
}
.manager-about {
    margin-top: -15px;
}
.summary {
    color: #FF8736;
    font-size: 20px;
}
</style>