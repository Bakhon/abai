<template>
    <div class="nozzles__table">
        <div class="nozzles__table-header">
            <div class="title">

            </div>
            <div class="icon__table" @click="tableShow=!tableShow">
                <i class="fas fa-table"></i>
            </div>
        </div>
        <div class="nozzles__table-body" id="nozzles" v-show="tableShow">

            <table class="table defaultTable">
                <tr>
                    <th style="width: 100px">1/32 Дюйма</th>
                    <th v-for="i in 10">{{i}}</th>
                </tr>
                <tr v-for="(tr, index) in table">
                    <td class="bg-color">{{index+7}}</td>
                    <td v-for="td in tr" class="hover">{{td}}</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NozzlesTable",
        props: ['table'],
        data(){
            return{
                tableShow: false
            }
        },
        mounted(){

        },
    }
</script>

<style scoped>
    .nozzles__table{
        width: 60px;
        height: 30px;
        position: relative;
        margin-left: 2px;
    }
    .nozzles__table-header{
        width: 100%;
        height: 100%;
        background-color: #454D7D;
        padding-right: 40px;
    }
    table th, .bg-color{
        border: 1px solid #353e74!important;
        background-color: #454D7D;
        vertical-align: center;
        text-align: center;
    }

    .hover:hover{
        background-color: #0d092a;
        cursor: pointer;
    }
    .icon__table{
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .icon__table i{
        display: block;
    }
    .nozzles__table-body{
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        width: auto;
        height: auto;
        background-color: #454D7D;
        border: 1px solid #0d3365;
        padding: 5px;
        z-index: 500;
    }
</style>