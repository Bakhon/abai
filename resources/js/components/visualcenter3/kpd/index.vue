<template>
    <div class="page-wrapper">
        <div class="row m-0">
            <div class="mt-3 col-12 row m-0">
                <div class="col-4"></div>
                <div class="col-4 main-title">
                    Дерево КПД блока Upstream на {{currentYear}} год
                </div>
                <div class="col-4 d-flex">
                    <div class="main-buttons p-2 d-flex">
                        <div class="img-documents"></div>
                        <div @click="$modal.show('modalDocuments')" class="ml-1">Нормативные документы</div>
                    </div>
                    <div class="main-buttons p-2 d-flex ml-4">
                        <div class="img-catalog"></div>
                        <div @click="$modal.show('modalCatalog')" class="ml-1">Каталог КПД</div>
                    </div>
                    <div class="main-buttons p-2 d-flex ml-4">
                        <div class="img-export"></div>
                        <div class="ml-1">Экспорт</div>
                    </div>
                </div>
            </div>
            <div class="mt-3 col-12 row m-0">
                <div class="col-2 d-flex">
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
                <div class="col-6">
                    <div class="col-12 table-header p-1">
                        Карты КПД СЕО-2<br />
                        (директора департаментов)
                    </div>
                </div>
                <div class="col-2 row m-0">
                    <div class="col-12 p-0">
                        <div class="col-12 kpd-main d-flex p-4 kpd-ceo_list">
                            <div class="img-goals"></div>
                            <div class="ml-2">Цели и задачи <br>&emsp;блока UPSTREAM</div>
                        </div>
                        <div class="col-12 p-2 kpd-column">
                            <div
                                    v-for="kpd in kpdCeo"
                                    class="col-12 p-3 kpd-ceo_item"
                            >
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
                <div class="col-4 row m-0">
                    <div class="col-12 kpd-main d-flex p-4 kpd-ceo_list chairmaster" @click="switchManager(kpdDecompositionA)">
                        <img class="filter-icon" :src="kpdDecompositionA.img"></img>
                        <div class="ml-2 text-left"><b>{{kpdDecompositionA.manager}}</b> <br> {{kpdDecompositionA.title}}</div>
                    </div>
                    <div class="col-12 p-4 kpd-column">
                        <div
                                v-for="(kpd, index) in kpdCeoDecompositionA"
                                class="col-12 p-4 kpd-ceo-a_item"
                                @mouseover="getHoveredElement(index,'kpdCeoDecompositionA')"
                        >
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
                <div class="col-6 row m-0">
                    <div class="col-12 kpd-ceo_list-b p-0">
                        <div v-for="master in kpdCeoDecompositionB" class="col-12 kpd-main row p-0 m-0">
                            <div class="col-12 kpd-ceo_header-b d-flex p-4 chairmaster" @click="switchManager(master)">
                                <img :src="master.img" class="filter-icon"></img>
                                <div class="ml-2 text-left"><b>{{master.manager}}</b><br>{{master.title}}</div>
                            </div>
                            <div v-for="kpd in master.kpd" class="col-12 kpd-ceo_item-b p-1 d-flex">
                                <div class="item-list_vector m-2"></div>
                                <div class="text-left ml-4 col-8 kpd-name_b" @click="[selectedManager = master, selectedKpd = kpd,$modal.show('modalKpdPassport')]">{{kpd.name}}</div>
                                <div class="progress progress_template mt-2 p-0 progress-ceo_b">
                                    <div
                                            :class="[getProgressBarFillingColor(kpd.progress),'progress-bar progress-bar_filling']"
                                            :style="{width: kpd.progress + '%',}"
                                            role="progressbar"
                                            :aria-valuenow="kpd.progress"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                    ></div>
                                </div>
                                <div class="col-1 text-right">
                                    {{kpd.progress}}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <kpd-modal-documents></kpd-modal-documents>
            <kpd-modal-catalog></kpd-modal-catalog>
            <kpd-modal-map :manager-info="selectedManager"></kpd-modal-map>
            <kpd-modal-monitoring :manager-info="selectedManager"></kpd-modal-monitoring>
            <kpd-modal-kpd-passport :manager-info="selectedManager" :kpd="selectedKpd"></kpd-modal-kpd-passport>
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
    min-height: 780px;
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
    border: 2px solid #2A3A85;
    border-bottom: 2px solid #656A8A;
    max-height: 99px;
}
.kpd-ceo_list-b {
    border: 1px solid #2A3A85;
}
.kpd-ceo_header-b {
    border-bottom: 4px solid #656A8A;
}
.kpd-ceo_item-b {
    background: #272C5C;
}
.chairmaster:hover, .kpd-ceo_item:hover, kpd-ceo_item-b:hover  {
    background: #3C4280;
    border-radius: 5px;
    border: 2px solid #272953;
}
.kpd-ceo-a_item:hover {
    background: #3C4280;
    .item-list_vector {
        opacity: 1;
    }
}
.kpd-ceo_item {
    margin-top: 5rem;
}
.kpd-ceo-a_item {
    margin-top: 3rem;
    &:nth-child(4) {
        margin-top: 120px;
    }
    &:last-child,&:first-child {
        margin-top: 0;
    }
}
.item-list_vector {
    background: #3366FF;
    opacity: 0.25;
    transform: matrix(1, 0, 0, -1, 0, 0);
    position: absolute;
    width: 9px;
    height: 9px;
}
.progress-ceo_b {
    width: 160px;
}
.kpd-name_b {
    font-size: 14px;
}
.main-buttons:hover, .kpd-name_b:hover {
    background: #3A4280;
}
.filter-icon {
    width: 45px;
}
</style>