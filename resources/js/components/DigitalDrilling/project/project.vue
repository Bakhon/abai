<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Профиль скважины</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        {{ trans(mainTable.name) }} <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="dropdown-menu1">
                        <a class="dropdown-item" v-for="table in main_tables" v-if="mainTable.name!=table.name" @click="changeTable(table)">{{ trans(table.name) }}</a>
                    </div>

                </div>
                <div class="report_generation">
                    <button @click="reportModalActive=true">Формировать отчет</button>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <keep-alive>
                            <component v-bind:is="mainTable.component"></component>
                        </keep-alive>
                    </div>
                </div>
            </div>
        </div>
        <reportGeneration
                @closeReportModal="closeReportModal"
                v-if="reportModalActive"
                title="Профиль скважины"
        >
            <slot>
                <div>Табл. 1.6.1 Входные данные по профилю скважины</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="2" colspan="2">
                            Интервал установки погружных насосов по вертикали, м
                        </th>
                        <th rowspan="2" colspan="2">
                            Mаксимально допустимые параметры профиля в интервале установки погружных насосов
                        </th>
                        <th colspan="3">
                            Зенитный угол, град.
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2">
                            Максимально  допустимый на интервале его увеличения
                        </th>
                        <th colspan="2">
                            При входе в продуктивный пласт
                        </th>
                    </tr>
                    <tr>
                        <th>
                            от
                            (верх)
                        </th>
                        <th>
                            до
                            (низ)
                        </th>
                        <th>
                            зенитный угол, град.
                        </th>
                        <th>
                            интенсивность изменения зенитного угла, град./10м
                        </th>
                        <th>
                            минимально допустимый
                        </th>
                        <th>
                            максимально допустимый
                        </th>
                    </tr>
                        <tr>
                            <td v-for="i in 7">{{ i }}</td>
                        </tr>
                        <tr>
                            <td rowspan="2" colspan="7"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.6.2 Профиль ствола скважины</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th>Глубина по стволу [m]</th>
                        <th>Зенитный угол [град.]</th>
                        <th>Азимут [град.]</th>
                        <th>Глубина по вертикали [m]</th>
                        <th>Север [m]</th>
                        <th>Восток [m]</th>
                        <th>Интенсивность искривления [град./30m]</th>
                        <th>Горизонтальное отклонение [m]</th>
                    </tr>
                    <tr>
                        <td v-for="i in 8">{{ i }}</td>
                    </tr>
                    <tr v-for="i in 5">
                        <td v-for="i in 8"></td>
                    </tr>
                    </tbody>
                </table>
                <div>Координаты точек</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th>Название</th>
                        <th>Скважина</th>
                        <th>Координаты Х</th>
                        <th>Координаты Y</th>
                        <th>Название карты</th>
                    </tr>
                    <tr>
                        <td v-for="i in 5">{{ i }}</td>
                    </tr>
                    <tr>
                        <td>Координаты устья</td>
                        <td rowspan="3"></td>
                        <td></td>
                        <td></td>
                        <td rowspan="3"></td>
                    </tr>
                    <tr>
                        <td>Цель-Т1 </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Цель-Т2 </td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </slot>
        </reportGeneration>
    </div>
</template>

<script>
    import reportGeneration from './modals/report-generation'
    export default {
        name: "project",
        components: {reportGeneration},
        data(){
            return{
                main_tables: [
                    {
                        "name":  "digital_drilling.project_data.data_input",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<well-profile></well-profile>"
                        }
                    },
                    {
                        "name": "digital_drilling.project_data.visualization",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<well-profile-graph></well-profile-graph>"
                        }
                    },
                ],
                mainTable:  {
                                "name":  "digital_drilling.project_data.data_input",
                                "id": 1,
                                "component": {
                                    "name": "main-table",
                                    "template": "<well-profile></well-profile>"
                                }
                            },
                reportModalActive: false
            }
        },
        methods: {
            changeTable(table){
                this.mainTable = table
                let element = document.getElementById("dropdown-menu1");
                element.classList.remove("show");
            },
            closeReportModal(){
                this.reportModalActive = false
            }
        },
    }
</script>

<style scoped>
    .digital_drilling .contentBlock .digitalDrillingWindow {
        position: static;
    }

</style>