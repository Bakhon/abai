<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
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
        name: "well-fastening",
        data(){
            return{
                main_tables: [
                    {
                        "name":  "digital_drilling.project.casing_strings_OK",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<fastening></fastening>"
                        }
                    },
                    {
                        "name": "digital_drilling.project.casing_running_mode",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<fastening-page2></fastening-page2>"
                        }
                    },
                    {
                        "name":  "digital_drilling.project.casing_pressure_testing",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<fastening-page3></fastening-page3>"
                        }
                    },
                    {
                        "name": "digital_drilling.project.casing_strings_overpressure",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<fastening-page4></fastening-page4>"
                        }
                    },
                    {
                        "name":  "digital_drilling.project.cementing_fluid_characteristics",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<fastening-page5></fastening-page5>"
                        }
                    },
                    {
                        "name": "digital_drilling.project.cementing_component_composition",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<fastening-page6></fastening-page6>"
                        }
                    },
                    {
                        "name": "digital_drilling.project.cementing_technological_operations",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<fastening-page7></fastening-page7>"
                        }
                    },
                ],
                mainTable:   {
                    "name":  "digital_drilling.project.casing_strings_OK",
                    "id": 1,
                    "component": {
                        "name": "main-table",
                        "template": "<fastening></fastening>"
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