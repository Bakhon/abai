<template>
    <div class="page-wrapper">
        <div class="row m-0">
            <div class="mt-3 col-12 row m-0">
                <div class="col-4"></div>
                <div class="col-4 main-title">
                    Дерево КПД блока Upstream на {{currentYear}} год
                </div>
                <div class="col-4 d-flex">
                    <img @click="$modal.show('modalSettings')" class="p-2" src="/img/kpd-tree/settings.svg" width="40px">
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
            <div class="col-12 menu-block d-flex">
                <div :class="[menuVisibility.strategic ? 'menu-item_selected' : 'menu-item','ml-1']" @click="switchMenuVisiblity('strategic')"></div>
                <div :class="[menuVisibility.corporate ? 'menu-item_selected' : 'menu-item','ml-1']" @click="switchMenuVisiblity('corporate')"></div>
                <div :class="[menuVisibility.manager ? 'menu-item_selected' : 'menu-item','ml-1']" @click="switchMenuVisiblity('manager')"></div>
                <div :class="[menuVisibility.deputy ? 'menu-item_selected' : 'menu-item','ml-1']" @click="switchMenuVisiblity('deputy')"></div>
            </div>
            <div class="mt-3 mb-3 col-12 row m-0 ceo-table">
                <div v-if="menuVisibility.strategic" class="col-2 d-flex">
                    <div class="col-12 table-header">
                        <span>Стратегические КПД</span>
                    </div>
                </div>
                <div v-if="menuVisibility.corporate" class="col-3 d-flex">
                    <div class="col-12 table-header">
                        <span>Корпоративные КПД</span>
                    </div>
                </div>
                <div v-if="menuVisibility.manager" class="col-7">
                    <div class="col-12 table-header">
                        <span>КПД руководящих работников (членов Правления)</span>
                    </div>
                </div>
                <div v-if="menuVisibility.deputy" class="col-7">
                    <div class="col-12 table-header">
                        <span>КПД управленческих работников</span>
                    </div>
                </div>
                <div v-if="menuVisibility.strategic" class="col-2 row m-0">
                    <div class="col-12 p-0">
                        <div class="col-12 d-flex p-2 table-sub-header">
                            <div class="img-goals"></div>
                            <div>Цели и задачи <br>&emsp;блока UPSTREAM</div>
                        </div>
                        <div class="col-12 p-2 kpd-column">
                            <div
                                    v-for="(kpd, index) in strategicKpdList"
                                    class="d-flex align-items-center"
                                    :style="strategicDecompositionStyles"
                            >
                                <div class="col-12">
                                    <div class="text-right">
                                        0%
                                    </div>
                                    <div class="progress progress_template">
                                        <div
                                                :class="[getProgressBarFillingColor(kpd.progress),'progress-bar progress-bar_filling']"
                                                :style="{width: 0 + '%',}"
                                                role="progressbar"
                                                :aria-valuenow="0"
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
                </div>
                <div v-if="menuVisibility.corporate" class="col-3 row m-0">
                    <div class="col-12 p-0">
                        <div class="col-12 d-flex p-2 table-sub-header chairmaster" @click="switchManager(corporateManager)">
                            <img v-if="corporateManager.avatar" width="43px" :src="'/img/kpd-tree/managers/' + corporateManager.avatar" class="rounded-circle"></img>
                            <div class="ml-2 text-left"><b>{{corporateManager.name}}</b> <br> {{corporateManager.title}}</div>
                        </div>
                        <div class="col-12 p-2 kpd-column">
                            <div
                                    v-for="(kpd, index) in corporateKpdList"
                                    class="d-flex align-items-center"
                                    :style="corporateDecompositionStyles"
                            >
                                <div class="col-12">
                                    <div class="text-right">
                                        0%
                                    </div>
                                    <div class="progress progress_template">
                                        <div
                                                :class="[getProgressBarFillingColor(kpd.progress),'progress-bar progress-bar_filling']"
                                                :style="{width: 0 + '%',}"
                                                role="progressbar"
                                                :aria-valuenow="0"
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
                </div>
                <div v-if="menuVisibility.manager" class="col-7 row m-0">
                    <div class="col-12 kpd-ceo_list-b p-0 manager-column pt-1">
                        <div v-for="manager in managers"  :style="thirdDecompositionStyles" class="manager-header">
                            <div class="h-100 col-12 d-flex align-items-center chairmaster" @click="switchManager(master)">
                                <img :src="'/img/kpd-tree/managers/' + manager.avatar" height="40em" class="rounded-circle"></img>
                                <div class="ml-2 text-left"><b>{{manager.name}}</b><br>{{manager.title}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="menuVisibility.deputy" class="col-7 row m-0">
                    <div class="col-12 kpd-ceo_list-b p-0 manager-column pt-1">
                        <div v-for="manager in deputy"  :style="thirdDecompositionStyles" class="manager-header">
                            <div class="h-100 col-12 d-flex align-items-center chairmaster" @click="switchManager(master)">
                                <img :src="'/img/kpd-tree/managers/' + manager.avatar" height="40em" class="rounded-circle"></img>
                                <div class="ml-2 text-left"><b>{{manager.name}}</b><br>{{manager.title}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <kpd-modal-documents></kpd-modal-documents>
            <kpd-modal-catalog :managers="managers" :corporate-manager="corporateManager"></kpd-modal-catalog>
            <kpd-modal-monitoring :manager-info="selectedManager"></kpd-modal-monitoring>
            <modal-settings :corporate-manager="corporateManager"></modal-settings>
            <modal-corporate-manager :corporate-manager="corporateManager"></modal-corporate-manager>
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
    background: #213181;
    height: 60px;
    position: relative;
    span {
        margin: 0;
        position: relative;
        top: 30%;
        transform: translateX(-50%);
    }
}
.table-sub-header {
    height: 60px;
    border: 2px solid #2A3A85;
    border-bottom: 2px solid #656A8A;
    background: #272953;
}
.table-header.kpd-main {
    padding-top: 5%;
}
.img-goals {
    background: url(/img/kpd-tree/goals.png) no-repeat;
    width: 50px;
    height: 50px;
}
.kpd-column {
    border: 1px solid #2A3A85;
    background: #272C5C;
    height: 780px;
    max-height: 780px;
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
.manager-header {
    border: 0.2em solid #272C5C;
    background: #535591;
    border-radius: 7px;
}
.chairmaster:hover {
    background: #3C4280;
    border-radius: 5px;
    border: 2px solid #272953;
}
.kpd-ceo_item {
    margin-top: 5rem;
}
.kpd-ceo_item:hover {
    background: #3C4280;
}
.main-buttons:hover {
    background: #3A4280;
}
.manager-column {
    border: 1px solid #2A3A85;
    background: #272C5C;
    height: 840px;
    max-height: 840px;
}
.menu-block {
    padding-left: 30px;
    div:nth-child(1) {
        width: 40px;
        height: 20px;
    }
    div:nth-child(2) {
        width: 50px;
        height: 20px;
    }
    div:nth-child(3) {
        width: 70px;
        height: 20px;
    }
    div:nth-child(4) {
        width: 70px;
        height: 20px;
    }
}
.menu-item_selected {
    background: #989ecd;
    cursor: pointer;
}
.menu-item {
    background: #474F91;
    cursor: pointer;
}
</style>