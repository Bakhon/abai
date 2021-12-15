<template>
    <div class="page-wrapper h-100">
        <div class="page-container row">
            <div class="col-12 mt-3 header">
                <div class="header-title">
                    Оперативная суточная информация по добыче нефти и конденсата АО НК "КазМунайГаз"
                </div>
                <div class="img-download" @click="handleExcelDownload()"></div>
            </div>
       </div>
   </div>
</template>
<script src="./index.js"></script>

<style scoped lang="scss">
    .header {
        justify-content: center;
        display: flex;
    }
    .img-download {
        background: url(/img/visualcenter3/download.png) no-repeat;
        height: 25px;
        width: 25px;
        position: absolute;
        right: 60px;
    }
    .header-title {
        font-style: normal;
        font-weight: bold;
        font-size: 20px;
        line-height: 24px;
    }

   .page-container {
       flex-wrap: wrap;
       margin: 0 !important;
   }
   .page-wrapper {
       font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
       position: relative;
       min-height: calc(100vh - 88px);
       background: #272953;
       color: white;
       text-align: center;
   }
</style>