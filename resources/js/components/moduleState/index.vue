<template>
    <div class="page-wrapper">
        <div class="block-container">
            <div class="row m-0 p-3 main-table">
                <table class="col-12 module-state_table">
                    <tr>
                        <th></th>
                        <th colspan="2">{{date}}</th>
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
                                <span>{{getIndex(index)}}</span>
                                <span :class="row.is_sub_section ? 'padding-left_30' : ''">&nbsp;{{row.name}}</span>
                            </div>
                        </td>
                        <td>
                            <div class="row m-0" v-if="row.current_execution_percent !== null">
                                <div class="col-7 progress p-0 progress-bar_header">
                                    <div
                                            class="percent-progress-bar"
                                            role="progressbar"
                                            :aria-valuenow="row.current_execution_percent"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            :style="{width: row.current_execution_percent + '%'}"
                                    ></div>
                                </div>
                                <span class="col-3 p-0 m-1">{{row.current_execution_percent}}%</span>
                            </div>
                        </td>
                        <td>
                            <div class="row m-0" v-if="row.current_ready_percent !== null">
                                <div class="col-7 progress p-0 progress-bar_header">
                                    <div
                                            class="percent-progress-bar"
                                            role="progressbar"
                                            :aria-valuenow="row.current_ready_percent"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            :style="{width: row.current_ready_percent + '%'}"
                                    ></div>
                                </div>
                                <span class="col-3 p-0 m-1">{{row.current_ready_percent}}%</span>
                            </div>
                        </td>
                        <td>
                            <div class="row m-0" v-if="row.planning_execution_percent !== null">
                                <div class="col-7 progress p-0 progress-bar_header">
                                    <div
                                            class="percent-progress-bar"
                                            role="progressbar"
                                            :aria-valuenow="row.planning_execution_percent"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            :style="{width: row.planning_execution_percent + '%'}"
                                    ></div>
                                </div>
                                <span class="col-3 p-0 m-1">{{row.planning_execution_percent}}%</span>
                            </div>
                        </td>
                        <td>
                            <div class="row m-0" v-if="row.planning_ready_percent !== null">
                                <div class="col-7 progress p-0 progress-bar_header">
                                    <div
                                            class="percent-progress-bar"
                                            role="progressbar"
                                            :aria-valuenow="row.planning_ready_percent"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            :style="{width: row.planning_ready_percent + '%'}"
                                    ></div>
                                </div>
                                <span class="col-3 p-0 m-1">{{row.planning_ready_percent}}%</span>
                            </div>
                        </td>
                        <td>
                            <div v-for="comment in row.result">
                                {{comment}}<br>
                            </div>
                        </td>
                        <td>{{row.date}}</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    data: function () {
        return {
            rows: [],
            date: null
        };
    },
    methods: {
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
        getFormatted() {
            let result = [];
            _.forEach(this.rows, (row) => {
                let formmated = row;
                if (row.result !== null) {
                    let splitted = row.result.split('\n');
                    formmated.result = splitted;
                }
                result.push(formmated);
            });
            return result;
        },
        getIndex(rowIndex) {
            if (rowIndex < 4) {
                return rowIndex + 1;
            } else if (rowIndex > 5) {
                return rowIndex - 1;
            } else {
                return '';
            }
        }
    },
    async mounted() {
        this.rows = await this.getStates();
        this.rows = this.getFormatted();
        this.date = await this.getHeader();
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
.percent-progress-bar {
    background: #009847;
    border-radius: 5px;
}
</style>