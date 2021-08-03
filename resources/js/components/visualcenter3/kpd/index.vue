<template>
    <div class="page-wrapper">
        <div class="row m-0">
            <div class="mt-3 col-12 row m-0">
                <div class="col-4"></div>
                <div class="col-4 main-title">
                    Дерево КПД блока Upstream
                </div>
                <div class="col-4 d-flex">
                    <div class="img-documents"></div>
                    <div class="ml-1">Нормативные документы</div>
                    <div class="img-catalog ml-5"></div>
                    <div class="ml-1">Каталог КПД</div>
                    <div class="img-export ml-5"></div>
                    <div class="ml-1">Экспорт</div>
                </div>
            </div>
            <div class="mt-3 col-12 row m-0">
                <div class="col-3 d-flex">
                    <div class="col-12 table-header kpd-main">
                        КПД CEO
                    </div>
                </div>
                <div class="col-4 d-flex">
                    <div class="col-12 table-header p-1">
                        Карта КПД СЕО-1<br />
                        (заместитель председателя Правления)
                    </div>
                </div>
                <div class="col-5">
                    <div class="col-12 table-header p-1">
                        Карты КПД СЕО-2<br />
                        (директора департаментов)
                    </div>
                </div>
                <div class="col-3 row m-0">
                    <div class="col-12 p-0">
                        <div class="col-12 kpd-main d-flex p-4 kpd-ceo_list">
                            <div class="img-goals"></div>
                            <div class="ml-2">Цели и задачи <br>&emsp;блока UPSTREAM</div>
                        </div>
                        <div class="col-12 p-4 mt-5 kpd-column">
                            <div v-for="kpd in kpdCeo" class="col-12 p-4 mt-5">
                                <div class="text-right">
                                    {{kpd.progress}}%
                                </div>
                                <div class="progress progress_template">
                                    <div
                                            :class="[getProgressBarFillingColor(kpd.progress),'progress-bar progress-bar_filling']"
                                            :style="{width: kpd.progress + '%',}"
                                            role="progressbar"
                                            :aria-valuenow="kpd.progress"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                    ></div>
                                </div>
                                <div class="text-left">
                                    {{kpd.name}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 d-flex">
                    <div class="col-12 kpd-main d-flex p-4">
                        <div class="img-goals"></div>
                        <div class="ml-2">Цели и задачи <br> блока UPSTREAM</div>
                    </div>
                </div>
                <div class="col-5 d-flex">
                    <div class="col-12 kpd-main d-flex p-4">
                        <div class="img-goals"></div>
                        <div class="ml-2">Цели и задачи <br> блока UPSTREAM</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script src="./index.js"></script>

<style scoped lang="scss">
.page-wrapper {
    font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
    position: relative;
    min-height: calc(100vh - 78px);
    background: #272953;
    color: white;
    text-align: center;
    font-size: 16px;
}
.page-container {
    flex-wrap: wrap;
}
.main-title {
    font-size: 21px;
    font-weight: 700;
}
.img-documents {
    background: url(/img/kpd-tree/documents.png) no-repeat;
    height: 25px;
    width: 25px;
}
.img-catalog {
    background: url(/img/kpd-tree/catalog.png) no-repeat;
    height: 25px;
    width: 25px;
}
.img-export {
    background: url(/img/kpd-tree/export.png) no-repeat;
    height: 25px;
    width: 25px;
}
.table-header {
    background: #2A3A85;
}
.table-header.kpd-main {
    padding-top: 5%;
}
.img-goals {
    background: url(/img/kpd-tree/goals.png) no-repeat;
    width: 45px;
}
.kpd-column {
    border: 1px solid #2A3A85;
    background: #272C5C;
}
.progress.progress_template {
    background-color: #A4A8BF !important;
}
.progress-bar_filling__medium {
    background-color: #FF8736 !important;
}
.progress-bar_filling__high {
    background-color: #009847 !important;
}
.kpd-ceo_list {
    border-bottom: 2px solid #656A8A;
}
</style>