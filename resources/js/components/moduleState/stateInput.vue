<template>
    <div class="page-wrapper">
        <div class="block-container">
            <div class="d-flex p-3 justify-content-end">
                <div class="menu-buttons p-2" @click="handleSaveStates()">Сохранить</div>
            </div>
            <div class="row m-0 p-3 main-table">
                <table class="col-12 module-state_table">
                    <tr>
                        <th></th>
                        <th colspan="2">
                            <input class="input-date__inherit" v-model="date"></input>
                        </th>
                        <th colspan="2">Ожидаемое к 31.12.21</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>МОДУЛЬ</th>
                        <th>% исп. нов.БПП, план/факт</th>
                        <th>% готовности тестовой/промышл. рабочей версии</th>
                        <th>% исп. нов.БПП, план/факт</th>
                        <th>% готовности тестовой/промышл. рабочей версии</th>
                        <th>Ожидаемые результаты до конца года (в свободной форме, несколько буллетов)</th>
                        <th>Дата протокола тестовой версии</th>
                    </tr>
                    <tr v-for="(row,index) in rows">
                        <td>
                            <div class="row m-0">
                                <span>{{getIndex(index)}}&nbsp;</span>
                                <input :class="row.is_sub_section ? 'padding-left_30 width__90 input__inherit' : ' width__90 input__inherit'" v-model="row.name"></input>
                            </div>
                        </td>
                        <td>
                            <div class="row m-0">
                                <div class="col-7 progress p-0 progress-bar_header">
                                    <div
                                            class="background__green"
                                            role="progressbar"
                                            :aria-valuenow="row.current_execution_percent"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            :style="{width: row.current_execution_percent + '%'}"
                                    ></div>
                                </div>
                                <input class="col-3 p-0 m-1 input-percent__inherit" v-model="row.current_execution_percent">
                                    <span class="percent-indicator">%</span>
                                </input>
                            </div>
                        </td>
                        <td>
                            <div class="row m-0">
                                <div class="col-7 progress p-0 progress-bar_header">
                                    <div
                                            class="background__green"
                                            role="progressbar"
                                            :aria-valuenow="row.current_ready_percent"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            :style="{width: row.current_ready_percent + '%'}"
                                    ></div>
                                </div>
                                <input class="col-3 p-0 m-1 input-percent__inherit" v-model="row.current_ready_percent">
                                    <span class="percent-indicator">%</span>
                                </input>
                            </div>
                        </td>
                        <td>
                            <div class="row m-0">
                                <div class="col-7 progress p-0 progress-bar_header">
                                    <div
                                            class="background__green"
                                            role="progressbar"
                                            :aria-valuenow="row.planning_execution_percent"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            :style="{width: row.planning_execution_percent + '%'}"
                                    ></div>
                                </div>
                                <input class="col-3 p-0 m-1 input-percent__inherit" v-model="row.planning_execution_percent">
                                    <span class="percent-indicator">%</span>
                                </input>
                            </div>
                        </td>
                        <td>
                            <div class="row m-0">
                                <div class="col-7 progress p-0 progress-bar_header">
                                    <div
                                            class="background__green"
                                            role="progressbar"
                                            :aria-valuenow="row.planning_ready_percent"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            :style="{width: row.planning_ready_percent + '%'}"
                                    ></div>
                                </div>
                                <input class="col-3 p-0 m-1 input-percent__inherit" v-model="row.planning_ready_percent">
                                    <span class="percent-indicator">%</span>
                                </input>
                            </div>
                        </td>
                        <td>
                            <textarea class="textarea_inherit" :style="{height: getAreaHeight(row.result) + 'px'}" v-model="row.result"></textarea>
                        </td>
                        <td>
                            <input class="input-date__inherit" v-model="row.date"></input>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</template>

<script>
import moment from "moment";
import {globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            rows: [],
            date: null,
            additionalWidth: 20,
            lineHeight: 22,
            bigElementLength: 65
        };
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        async getStates() {
            let uri = this.localeUrl("/get-module-state");
            const response = await axios.get(uri);
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
        async getHeader() {
            let uri = this.localeUrl("/get-module-header");
            const response = await axios.get(uri);
            if (response.status !== 200) {
                return [];
            }
            return response.data.date;
        },
        getIndex(rowIndex) {
            if (rowIndex < 4) {
                return rowIndex + 1;
            } else if (rowIndex > 5) {
                return rowIndex - 1;
            } else {
                return '';
            }
        },
        getAreaHeight(comments) {
            if (comments === null) {
                return this.lineHeight;
            }
            let bitElementsCount = 0;
            let splitted = comments.split('\n');
            for (let i in splitted) {
                if (splitted[i].length > this.bigElementLength) {
                    bitElementsCount++;
                }
            }
            return (splitted.length * this.lineHeight) + (bitElementsCount * this.additionalWidth);
        },
        async handleSaveStates() {
            this.SET_LOADING(true);
            let uri = this.localeUrl("/store-module-state");
            let queryOptions = {
                'states': this.rows,
                'date': this.date
            };
            await axios.post(uri, {params:queryOptions});
            this.showToast('Данные успешно обновлены!', 'Успешно', 'success');
            this.SET_LOADING(false);
        }
    },
    async mounted() {
        this.SET_LOADING(true);
        this.rows = await this.getStates();
        this.date = await this.getHeader();
        this.SET_LOADING(false);
    }
}
</script>

<style scoped lang="scss">
.page-wrapper {
    font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
    position: relative;
    min-height: calc(100vh - 78px);
    color: white;
    text-align: center;
}
.block-container {
    background: #272953;
    min-height: calc(100vh - 78px);
    flex-wrap: wrap;
    margin: 0;
}
.module-state_table {
    th {
        background: #46498E;
        color: white;
        padding: 5px;
        text-align: center;
        border-right: 3px solid #272953;
        &:first-child {
            min-width: 430px;
        }
        &:last-child {
            border-right: none;
        }
    }
    tr:nth-child(2) {
        th {
            &:nth-child(2),&:nth-child(3),&:nth-child(4),&:nth-child(5) {
                width: 150px;
            }
            &:last-child {
                width: 150px;
            }
        }
    }
    tr {
        background: white;
        text-align: left;
        td {
            padding: 5px;
            border-right: 3px solid #272953;
            &:last-child {
                border-right: none;
                text-align: center;
            }
            background: #272953;
        }
    }
    tr:nth-child(10),tr:nth-child(14) {
        td:nth-child(6) {
            background: #656A8A;
        }
    }
    tr:nth-child(23),tr:nth-child(24),tr:nth-child(25),tr:nth-child(26),tr:nth-child(27) {
        td:first-child {
            background: #656A8A;
        }
    }
    tr:nth-child(11),tr:nth-child(12),tr:nth-child(13),tr:nth-child(15),tr:nth-child(17),tr:nth-child(20) {
        td:nth-child(6) {
            background: #009847;
        }
    }
}
.progress-bar_header {
    height: 30px !important;
}
.padding-left_30 {
    padding-left: 30px;
}
.main-table {
    overflow-y: auto;
    max-height: 850px;
}
.background__green {
    background: #009847;
}
.width__90 {
    width: 90%;
}
.input__inherit {
    background: inherit;
    color: inherit;
    border: none;
}
.textarea_inherit {
    background: inherit;
    color: inherit;
    border: none;
    width: 100%;
    resize: none;
    overflow: hidden;
}
.input-date__inherit {
    background: inherit;
    color: inherit;
    border: none;
    text-align: center;
}
.input-percent__inherit {
    background: inherit;
    color: inherit;
    border: none;
    min-width: 30px;
}
.percent-indicator {
    margin-top: 5px;
}
.menu-buttons {
    background: #656A8A;
    text-align: center;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}
.menu-buttons:hover {
    background: #3A4280;
    border-radius: 5px;
}
</style>