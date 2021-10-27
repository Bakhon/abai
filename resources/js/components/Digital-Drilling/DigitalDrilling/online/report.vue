<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Отчеты</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        {{ trans(mainTable.name) }} <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="dropdown-menu1">
                        <a class="dropdown-item" v-for="table in main_tables" v-if="mainTable.name!=table.name" @click="changeTable(table)">{{ trans(table.name) }}</a>
                        <a class="dropdown-item">Отчет службы супервайзинга об окончании строительства скважины</a>
                        <a class="dropdown-item">Отчет службы сопровождения 24/7 с офиса КМГИ</a>
                        <a class="dropdown-item">Отчет буровой компании по строительству скважины</a>
                        <a class="dropdown-item">Отчет подрядной компании по буровым растворам</a>
                        <a class="dropdown-item">Отчет подрядной компании по ННБ и геонавигации </a>
                        <a class="dropdown-item">Отчет подрядной компании по цементированию скважины</a>
                        <a class="dropdown-item">Отчет подрядной компании по ГИС</a>
                        <a class="dropdown-item">Отчет подрядной компании по ГТИ  </a>
                        <a class="dropdown-item">Сводная таблица анализа проектных скважин 2021г</a>
                        <a class="dropdown-item">Консолидированные рекомендации по улучшению и осложнениям в процессе строительства скважины</a>
                        <a class="dropdown-item">Отчет по извлеченным урокам в процессе строительства скважины</a>
                    </div>
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
    </div>
</template>

<script>
    export default {
        name: "report",
        data(){
            return{
                main_tables: [
                    {
                        "name":  "digital_drilling.online.reservoir_share_horizontal",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<report1></report1>"
                        }
                    },
                    {
                        "name": "digital_drilling.online.scheduled_drilling_support",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<report2></report2>"
                        }
                    },
                ],
                mainTable:  {
                    "name":  "digital_drilling.online.reservoir_share_horizontal",
                    "id": 1,
                    "component": {
                        "name": "main-table",
                        "template": "<report1></report1>"
                    }
                },
            }
        },
        methods: {
            changeTable(table){
                this.mainTable = table
                let element = document.getElementById("dropdown-menu1");
                element.classList.remove("show");
            },
        },
    }
</script>

<style scoped>
    .dropdown-toggle, .dropdown-menu{
        width: calc(100% + 20px)!important;
    }
</style>