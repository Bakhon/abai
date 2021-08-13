<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        {{ trans(mainTable.name) }} <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="dropdown-menu1">
                        <a class="dropdown-item" v-for="table in main_tables" v-if="mainTable.name!=table.name" @click="changeTable(table)">{{ trans(table.name) }}</a>
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
        name: "analytics-deepening",
        data(){
            return{
                main_tables: [
                    {
                        "name":  "digital_drilling.analytics.well_profile_survey",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<deepening></deepening>"
                        }
                    },
                    {
                        "name":  "digital_drilling.analytics.well_profile_visualization",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<deepening-visual></deepening-visual>"
                        }
                    },
                    {
                        "name":  "digital_drilling.analytics.KNBK",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<deepening-knbk></deepening-knbk>"
                        }
                    },
                    {
                        "name":  "digital_drilling.analytics.mode_parameters",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<deepening-params></deepening-params>"
                        }
                    },
                    {
                        "name":  "digital_drilling.analytics.drilling_fluids_parameters_composition",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<deepening-bur></deepening-bur>"
                        }
                    },
                    {
                        "name":  "digital_drilling.analytics.drilling_fluids_hydraulics",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<deepening-gidro></deepening-gidro>"
                        }
                    },
                    {
                        "name":  "digital_drilling.analytics.drilling_fluids_distribution_pressure",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<deepening-sorting></deepening-sorting>"
                        }
                    },
                    {
                        "name":  "digital_drilling.analytics.coring",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<deepening-selection></deepening-selection>"
                        }
                    },
                ],
                mainTable:  {
                    "name":  "digital_drilling.analytics.well_profile_survey",
                    "id": 1,
                    "component": {
                        "name": "main-table",
                        "template": "<deepening></deepening>"
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

</style>