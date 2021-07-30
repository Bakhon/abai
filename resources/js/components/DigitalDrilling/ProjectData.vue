<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody" style="">
            <div class="bodyContent">
                <div class="row mb-3 bodyContentRow">
                    <div class="col-sm-3">
                        <div class="bigTitle ">Проектные данные</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dropdown" v-bind:class="{ full: mainTable.id<6}">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                {{ mainTable.name }} <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-menu1">
                                <a class="dropdown-item" v-for="table in tables" v-if="mainTable.name!=table.name" @click="changeTable(table)">{{table.name}}</a>
                            </div>
                        </div>
                        <div class="dropdown second" v-if="mainTable.id>5" >
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                {{ casingTable.name }} <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-menu2">
                                <a class="dropdown-item" v-for="table in casingTables" v-if="casingTable.name!=table.name" @click="changeCasingTable(table)">{{table.name}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="office-elements">
                            <div class="office-elements_text">Открыть в: </div>
                            <img src="/img/digital-drilling/pdf.png" alt="">
                            <img src="/img/digital-drilling/excel.png" alt="">
                            <img src="/img/digital-drilling/word.png" alt="">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <keep-alive>
                            <component v-bind:is="mainTable.component" v-if="mainTable.id<6"></component>
                            <component v-bind:is="casingTable.component" v-else></component>
                        </keep-alive>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import mainTables from './main_tables'
    import casingTables from './casing_tables'
    import vSelect from 'vue-select'


    export default {
        name: "ProjectData",
        components: {vSelect},
        data() {
            return{
                tables: mainTables,
                casingTables: casingTables,
                mainTable:mainTables[0],
                casingTable: casingTables[0],
                select: false
            }
        },
        methods: {
            changeTable(table){
                this.mainTable = table
                let element = document.getElementById("dropdown-menu1");
                element.classList.remove("show");
            },
            changeCasingTable(table){
                this.casingTable = table
                let element = document.getElementById("dropdown-menu2");
                element.classList.remove("show");
            },
        },
    }



</script>

<style scoped>
.dropdown-item{
    cursor: pointer;
}
</style>