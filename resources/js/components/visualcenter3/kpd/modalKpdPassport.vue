<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalKpdPassport"
                draggable=".modal-bign-header"
                :width="1500"
                :height="700"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">Паспорт и целевые значения КПД</div>
                    <button type="button" class="modal-bign-button" @click="$modal.hide('modalMap')">
                        {{trans('pgno.zakrit')}}
                    </button>
                </div>
                <div class="modal-bign-header mt-2 justify-content-between d-flex">
                    <div class="col-12">
                        {{kpd.name}}
                    </div>
                </div>
                <table class="modal_table mt-2">
                    <tr>
                        <th v-for="header in kpdMainHeaders">{{header}}</th>
                    </tr>
                    <tr>
                        <td>{{kpd.name}}</td>
                        <td v-for="(value,index) in kpd.main">
                            <select v-if="index === 'unit'" class="filter_select p-1">
                                <option v-for="key in Object.keys(unitMapping)" :value="kpd.main.unit">
                                    {{key}}
                                </option>
                            </select>
                            <div v-else>
                                <input class="filter_select text-right p-1" type="text" :value="value">
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="modal-bign-title modal_header mt-2">Паспорт и целевые значения КПД</div>
                <table class="modal_table table-target-values mt-2">
                    <tr>
                        <th v-for="header in kpdTargetHeaders">{{header}}</th>
                    </tr>
                    <tr>
                        <td>Значение</td>
                        <td v-for="value in kpd.targetValues.value">
                            <div>
                                <input class="filter_select text-right p-1" type="text" :value="value">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td v-for="(value,index) in kpd.targetValues.description">
                            <div v-if="index === 'stepUrl'" class="d-flex justify-content-between">
                                Порог установлен согласно:
                                <img class="mr-2" src="/img/kpd-tree/document.png"></img>
                            </div>
                            <div v-else>
                                <input class="filter_select text-right p-1" type="text" :value="value">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Расчет (если применимо)</td>
                        <td v-for="(value,index) in kpd.targetValues.calculation">
                            <div v-if="index === 'stepUrl'" class="d-flex justify-content-between">
                                Производственные и финансовые показатели:
                                <img class="mr-2" src="/img/kpd-tree/document.png"></img>
                            </div>
                            <div v-else>
                                <input class="filter_select text-right p-1" type="text" :value="value">
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="modal-bign-title modal_header mt-2">Паспорт КПД</div>
                <table class="modal_table passport-table mt-2">
                    <tr>
                        <th v-for="header in kpdPassportHeaders">{{header}}</th>
                    </tr>
                    <tr>
                        <td v-for="(value, index) in kpd.passport">
                            <div v-if="index === 'polarity'" class="justify-content-center d-flex">
                                <div class="indicator-grow"></div>
                                <div class="indicator-fall"></div>
                            </div>
                            <select v-else-if="index === 'source'" class="filter_select p-1">
                                <option v-for="source in sourceDictionary" :value="source">
                                    {{source}}
                                </option>
                            </select>
                            <select v-else-if="index === 'periodicity'" class="filter_select p-1">
                                <option v-for="period in periodDictionary" :value="period">
                                    {{period}}
                                </option>
                            </select>
                            <div v-else>
                                <input class="filter_select text-right p-1" type="text" :value="value">
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="modal-bign-header mt-2 d-flex">
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
                    <div class="col-1 download-button m-4" @click="$modal.hide('modalKpdPassport')">ОК</div>
                    <div class="col-1 cancel-button m-4" @click="$modal.hide('modalKpdPassport')">Отмена</div>
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
            unitMapping: {
                'тенге': 'тенге',
                'доллар': 'тенге',
                'тонн': 'тенге'
            },
            selectedUnit: null,
            selectedKpd: null,
            kpdMainHeaders: [
                'Наименование КПД',
                'Единица измерения',
                'Вес',
                'Порог (50%)',
                'Цель (100%)',
                'Вызов (125%)'
            ],
            kpdTargetHeaders: [
                '',
                'Порог (50%)',
                'Цель (100%)',
                'Вызов (125%)',
                'Факт за'
            ],
            sourceDictionary: [
                'Протокол СД',
                'Протокол КИП'
            ],
            periodDictionary: [
                'Ежесуточно',
                'Ежемесячно',
                'Квартал',
                'Полгода',
                'Год'
            ],
            kpdPassportHeaders: [
                'Описание',
                'Полярность',
                'Формула расчета',
                'Переменные',
                'Источник данных',
                'Ответственные за \nдостоверность',
                'Функции',
                'Переодичность \nмониторинга'
            ],
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
    props: ['kpd','managerInfo'],
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.table-target-values {
    tr td:first-child {
        background: #3A4280;
    }
    tr:nth-child(3),tr:nth-child(4) {
        td:nth-child(2){
            background: #272953;
        }
    }
}
.passport-table {
    table-layout: fixed;
    tr:first-child th:first-child {
        width: 400px;
    }
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
    border: none;
    width: 100%;
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
.main-buttons:hover {
    background: #3A4280;
}
.indicator-grow {
    background: url(/img/visualcenter3/green-arrow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
}

.indicator-fall {
    background: url(/img/visualcenter3/red-arrow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
}
</style>