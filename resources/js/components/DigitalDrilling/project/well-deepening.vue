<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление скважины</p>
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
        name: "well-deepening",
        data(){
            return{
                main_tables: [
                    {
                        "name":  "digital_drilling.project1.BHA_selection",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<w-deepening></w-deepening>"
                        }
                    },
                    {
                        "name": "digital_drilling.project1.drilling_parameters_modes",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<w-deepening-params></w-deepening-params>"
                        }
                    },
                    {
                        "name": "digital_drilling.project1.visualization",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<w-deepening-graph></w-deepening-graph>"
                        }
                    },
                ],
                mainTable:   {
                    "name":  "digital_drilling.project1.BHA_selection",
                    "id": 1,
                    "component": {
                        "name": "main-table",
                        "template": "<w-deepening></w-deepening>"
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