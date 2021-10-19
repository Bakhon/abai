<template>
    <div class="report__download">
        <div class="report__download-header">
            <div class="report__download-back" @click="close">
                <img src="/img/digital-drilling/back.svg" alt="">
                Назад
            </div>
            <div class="report__download-download">
                <div class="text">
                    Скачать:
                </div>
                <div class="export">
                    <img src="/img/digital-drilling/pdf.png" alt="">
                    <img src="/img/digital-drilling/excel.png" alt="">
                    <img src="/img/digital-drilling/word.png" alt="">
                </div>
            </div>
        </div>
        <div class="report__download-body defaultScroll">
            <slot name="tableBody"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReportDownload",
        mounted() {
            document.body.style.overflow = "hidden"
        },
        methods:{
            close(){
                this.$emit('close')
                document.body.style.overflow = "auto"
            }
        }
    }
</script>

<style scoped>
.report__download{
    position: fixed;
    left: 64px;
    top: 86px;
    right: 0;
    bottom: 0;
    background-color: #272953;
    padding: 15px 20px;
}
    .report__download-header{
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .report__download-back{
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    .report__download-back img{
        margin-right: 8px;
    }
    .report__download-download{
        display: flex;
        align-items: center;
    }
    .text{
        font-weight: 600;
        font-size: 14px;
        line-height: 17px;
        color: #FFFFFF;
    }
    .export{
        display: flex;
        align-items: center;
    }
    .export img{
        margin-left: 30px;
    }
    .report__download-body{
        background-color: #FFFFFF;
        overflow-y: scroll;
        overflow-x: hidden;
        width: 100%;
        height: calc(100% - 24px);
        padding: 50px 100px;
    }
    .black{
        color: black!important;
    }
    .name{
        text-align: center;
        font-style: normal;
        font-weight: normal;
        font-size: 24px;
        line-height: 29px;
        color: #000000;
        margin-bottom: 50px;
    }
</style>