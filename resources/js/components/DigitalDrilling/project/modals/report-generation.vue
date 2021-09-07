<template>
    <div>
    <div class="report__modal-header">
        <div class="report__modal-title">
            {{title}}
        </div>
        <div class="report__modal-right-btns">
            <div class="report__modal-export">
                <span>Export:</span>
                <img src="/img/digital-drilling/word.png" alt="">
            </div>
            <div class="report__modal-close">
                <button @click="close">Закрыть</button>
            </div>
        </div>
    </div>
    <div class="report__modal">

        <div class="report__modal-body">
           <slot></slot>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        name: "report-generation",
        props: ['title'],
        methods:{
            close(){
                this.$emit('closeReportModal')
            }
        }
    }
</script>

<style scoped>
    .report__modal{
        position: absolute;
        top: 130px;
        left: 10%;
        width: 80%;
        height: 650px;
        background-color: #272953;
        box-shadow: 0 0 0 rgba(0,0,0,0.5), 0 10px 10px rgba(0,0,0,0.5), 0 10px 10px rgba(0,0,0,0.5);
        z-index: 500;
        color: #FFFFFF;
        padding: 15px;
        overflow: scroll;

    }
    .report__modal-header{
        position: absolute;
        top: 50px;
        left: 10%;
        width: 80%;
        height: 80px;
        background-color: #272953;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
        z-index: 500;
        color: #FFFFFF;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .report__modal-title{
        color: #fff;
        font-size: 22px;
        font-weight: bolder;
        margin-bottom: 15px;
    }
    .report__modal-close button{
        border: 0;
        color: #FFFFFF;
        background-color: #2E50E9;
        padding: 5px 7px;
    }
    .report__modal-right-btns{
        display: flex;
        align-items: center;
    }
    .report__modal-export{
        margin-right: 15px;
        cursor: pointer;
    }
    .report__modal-export span{
        margin-right: 7px;
    }
    .digital_drilling table.defaultTable {

        position: relative;
        display: block;
        width: 100%;
        color: #FFFFFF;
        font-size: 14px;
        margin-bottom: 30px;
    }
    .digital_drilling table.defaultTable:last-child{
        margin-bottom: 0;
    }
    .digital_drilling table.defaultTable tbody {
        width: 100%;
        display: table;
    }

    .report__modal::-webkit-scrollbar-thumb{
        background-color: #000000;
        border: 2px solid #ffffff;
    }
    .report__modal::-webkit-scrollbar{
        width:4px;
    }
    .digital_drilling table.defaultTable tr:nth-child(even) {
        background: rgba(69, 77, 125, 0.7);
    }
    .digital_drilling table.defaultTable tr th {
        border: 0.6px solid #3B4380;
        background: #323370;
        font-weight: normal;
        text-align: center;
        vertical-align: middle;
    }
    td:last-of-type {
        border-right: 0.6px solid #3B4380!important;
    }
    .digital_drilling table tr td {
        text-align: center;
        vertical-align: middle;
        border: 1px solid #3B4380;
        font-size: 14px;
    }
</style>