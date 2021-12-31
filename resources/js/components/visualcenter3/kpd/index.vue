<template>
    <div class="page-wrapper">
        <div class="row m-0">
            <div class="mt-3 col-12 row m-0">
                <div class="col-4"></div>
                <div class="col-4 main-title">
                    Дерево КПД ТОО "КМГ Инжиниринг" на {{currentYear}} год
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
            <div class="mt-3 col-12 row m-0">
                <div v-if="menuVisibility.strategic" class="col-2 d-flex">
                    <div class="col-12 table-header">
                        <span><b>Стратегические КПД</b></span>
                    </div>
                </div>

                <div v-if="menuVisibility.corporate" class="col-3 d-flex p-0">
                    <div class="col-12 table-header">
                        <span><b>Корпоративные КПД</b></span>
                    </div>
                </div>

                <div v-if="menuVisibility.manager" class="col-7">
                    <div class="col-12 table-header">
                        <span><b>Функциональные КПД руководящих работников (членов Правления)</b></span>
                    </div>
                </div>

                <div v-if="menuVisibility.deputy" class="col-7">
                    <div class="col-12 table-header">
                        <span><b>Функциональные КПД управленческих работников</b></span>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-12 row m-0">
                <div v-if="menuVisibility.strategic" class="col-2 row m-0">
                    <div class="col-12 p-0">
                        <div class="col-12 row m-0 p-2 table-sub-header">
                            <img height="45px" src="/img/kpd-tree/kmgi-1.svg" />
                            <div>Цели и задачи <br>&emsp;ТОО "КМГ Инжиниринг"</div>
                            <div class="col-12 d-flex p-0 mt-3 justify-content-between strategic-header">
                                <div class="d-flex p-0">
                                    <div class="text-left">Результативность</div>
                                    <div class="text-right ml-2">
                                        125%
                                    </div>
                                </div>
                                <div class="d-flex p-0">
                                    <div class="text-left strategic-kpd-header">Ожидание</div>
                                    <div class="text-right ml-2 strategic-kpd-header">
                                        118%
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 p-0 progress progress_template">
                                <div
                                        :class="[getProgressBarFillingColor(corporateManager[0].fact),'progress-bar progress-bar_filling']"
                                        :style="{width: 125 + '%',}"
                                        role="progressbar"
                                        :aria-valuenow="125"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                ></div>
                            </div>
                        </div>
                        <div class="col-12 p-2 kpd-column">
                            <div
                                    v-for="(kpd, index) in strategicKpdList"
                                    class="d-flex align-items-center"
                                    @click="[selectedKpd = kpd,$modal.show('modalKpdEdit')]"
                            >
                                <div class="col-12">
                                    <div class="text-right">
                                        0%
                                    </div>
                                    <div class="progress progress_template">
                                        <div
                                                :class="[getProgressBarFillingColor(kpd),'progress-bar progress-bar_filling']"
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

                <div v-if="menuVisibility.corporate" class="col-3 row m-0 p-0">
                    <div class="col-12 p-0">
                        <div class="col-12 row m-0 p-2 table-sub-header chairmaster cursor-pointer" @click="switchManager(corporateManager[0],'corporate')">
                            <img v-if="corporateManager[0].avatar" width="43px" height="40px" :src="'/img/kpd-tree/managers/' + corporateManager[0].avatar" class="rounded-circle"></img>
                            <div class="ml-2 text-left"><b>{{corporateManager[0].name}}</b> <br> {{corporateManager[0].title}}</div>
                            <div class="col-12 d-flex p-0 mt-3 justify-content-between">
                                <div class="d-flex p-0">
                                    <div class="text-left">Результативность</div>
                                    <div class="text-right ml-2">
                                        {{corporateManager[0].fact}}%
                                    </div>
                                </div>
                                <div class="d-flex p-0">
                                    <div class="text-left kpd-header">Ожидание</div>
                                    <div class="text-right ml-2 kpd-header">
                                        {{getCorporateSummaryWaiting()}}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 p-0 progress progress_template">
                                <div
                                        :class="[getProgressBarFillingColor(corporateManager[0].fact),'progress-bar progress-bar_filling']"
                                        :style="{width: corporateManager[0].fact + '%',}"
                                        role="progressbar"
                                        :aria-valuenow="corporateManager[0].fact"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                ></div>
                            </div>
                        </div>
                        <div class="col-12 p-2 kpd-column">
                            {{corporateManager.kpdList}}
                            <div
                                    v-for="(kpd, index) in corporateManager[0].kpdList"
                                    class="d-flex align-items-center"
                                    @click="[selectedKpd = kpd,$modal.show('modalKpdEdit')]"
                            >
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex p-0">
                                            <div class="text-left">Результативность</div>
                                            <div class="text-right ml-2">
                                                {{kpd.rating}}%
                                            </div>
                                        </div>
                                        <div class="d-flex p-0">
                                            <div class="text-left kpd-header">Ожидание</div>
                                            <div class="text-right ml-2 kpd-header">
                                                {{kpd.waiting}}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress progress_template">
                                        <div
                                                :class="[getProgressBarFillingColor(kpd),'progress-bar progress-bar_filling']"
                                                :style="{width: kpd.rating + '%',}"
                                                role="progressbar"
                                                :aria-valuenow="kpd.rating"
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
                        <div v-for="(manager, index) in managers" class="manager-header cursor-pointer">
                            <div class="d-flex p-0">
                                <div :class="[manager.isSelected ? 'chairmaster_selected' : '','col-11 d-flex align-items-center chairmaster']" @click="switchKpdVisibility(manager,managers)">
                                    <img :src="'/img/kpd-tree/managers/' + manager.avatar" height="40em" class="rounded-circle"></img>
                                    <div class="col-7 ml-2 text-left"><b>{{manager.name}}</b><br>{{manager.title}}</div>
                                        <div class="col-4 row m-0 p-0">
                                           <div class="col-12 d-flex p-0 mt-3 justify-content-between">
                                                <div class="d-flex p-0">
                                                    <div class="text-left manager-result">Результативность</div>
                                                    <div class="text-right ml-2 manager-result">
                                                        {{manager.fact}}%
                                                    </div>
                                                </div>
                                                <div class="d-flex p-0">
                                                    <div class="text-left kpd-header">Ожидание</div>
                                                    <div class="text-right ml-2 kpd-header">
                                                        {{getCorporateSummaryWaiting()}}%
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 p-0 progress progress_template">
                                                <div
                                                        :class="[getProgressBarFillingColor(manager.fact),'progress-bar progress-bar_filling']"
                                                        :style="{width: manager.fact + '%',}"
                                                        role="progressbar"
                                                        :aria-valuenow="manager.fact"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-1 d-flex justify-content-end"  @click="switchManager(manager,'manager')">
                                    <img class="mt-3 mr-2" height="15em" src="/img/icons/link.svg" />
                                </div>
                            </div>

                            <div v-if="manager['isSelected'] && manager.kpdList['length'] > 0" class="col-12 row m-0 manager-kpd-list p-2">
                                <div v-for="kpd in manager.kpdList" class="col-12 d-flex kpd-item" @click="[selectedKpd = kpd,$modal.show('modalKpdEdit')]">
                                    <div class="col-8 d-flex p-0">
                                        <div class="kpd-id"></div>
                                        <div>{{kpd.name}}</div>
                                    </div>
                                    <div class="col-3 d-flex mt-3 p-0">
                                        <div class="col-12 p-0 progress progress_template">
                                            <div
                                                    :class="[getProgressBarFillingColor(kpd),'progress-bar progress-bar_filling']"
                                                    :style="{width: kpd.rating + '%',}"
                                                    role="progressbar"
                                                    :aria-valuenow="kpd.rating"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                            ></div>
                                        </div>
                                        <div class="kpd-decomposition-fact">{{kpd.rating}}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div v-if="menuVisibility.deputy" class="col-7 row m-0">
                    <div class="col-12 kpd-ceo_list-b p-0 manager-column pt-1">
                        <div v-for="(manager, index) in deputy" class="manager-header cursor-pointer">
                            <div class="d-flex p-0">
                                <div :class="[manager.isSelected ? 'chairmaster_selected' : '','col-11 d-flex align-items-center chairmaster']" @click="switchKpdVisibility(manager,deputy)">
                                    <img :src="'/img/kpd-tree/managers/' + manager.avatar" height="40em" width="40em" class="rounded-circle"></img>
                                    <div class="col-7 ml-2 text-left"><b>{{manager.name}}</b><br>{{manager.title}}</div>
                                    <div class="col-4 row m-0 p-0">
                                        <div class="col-12 d-flex p-0 mt-3 justify-content-between">
                                            <div class="d-flex p-0">
                                                <div class="text-left manager-result">Результативность</div>
                                                <div class="text-right ml-2 manager-result">
                                                    {{manager.fact}}%
                                                </div>
                                            </div>
                                            <div class="d-flex p-0">
                                                <div class="text-left kpd-header">Ожидание</div>
                                                <div class="text-right ml-2 kpd-header">
                                                    {{getCorporateSummaryWaiting()}}%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 p-0 progress progress_template">
                                            <div
                                                    :class="[getProgressBarFillingColor(manager.fact),'progress-bar progress-bar_filling']"
                                                    :style="{width: manager.fact + '%',}"
                                                    role="progressbar"
                                                    :aria-valuenow="manager.fact"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 d-flex justify-content-end"  @click="switchManager(manager,'manager')">
                                    <img class="mt-3 mr-2" height="15em" src="/img/icons/link.svg" />
                                </div>
                            </div>
                            <div v-if="manager['isSelected'] && manager.kpdList['length'] > 0" class="col-12 row m-0 manager-kpd-list p-2">
                                <div v-for="kpd in manager.kpdList" class="col-12 d-flex kpd-item" @click="[selectedKpd = kpd,$modal.show('modalKpdEdit')]">
                                    <div class="col-8 d-flex p-0">
                                        <div class="kpd-id"></div>
                                        <div>{{kpd.name}}</div>
                                    </div>
                                    <div class="col-3 d-flex mt-3 p-0">
                                        <div class="col-12 p-0 progress progress_template">
                                            <div
                                                    :class="[getProgressBarFillingColor(kpd),'progress-bar progress-bar_filling']"
                                                    :style="{width: kpd.rating + '%',}"
                                                    role="progressbar"
                                                    :aria-valuenow="kpd.rating"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                            ></div>
                                        </div>
                                        <div class="kpd-decomposition-fact">{{kpd.rating}}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <kpd-modal-documents></kpd-modal-documents>
            <kpd-modal-catalog :managers="managers" :deputy="deputy" :corporate-manager="corporateManager[0]"></kpd-modal-catalog>
            <kpd-modal-monitoring :manager-info="selectedManager" ref="kpdMonitoring" :manager-type="managerType"></kpd-modal-monitoring>
            <modal-settings :corporate-manager="corporateManager[0]" @update-required="updateData"></modal-settings>
            <modal-corporate-manager :corporate-manager="corporateManager[0]"></modal-corporate-manager>
            <kpd-modal-kpd-edit :managers="managers" :corporate-manager="corporateManager[0]" :kpd-list="kpdList" :current-kpd="selectedKpd" :deputy="deputy"></kpd-modal-kpd-edit>
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
    height: 110px;
    border: 2px solid #2A3A85;
    border-bottom: 2px solid #656A8A;
    background: #272953;
}
.table-header.kpd-main {
    padding-top: 5%;
}
.kpd-column {
    border: 1px solid #2A3A85;
    background: #272C5C;
    height: 780px;
    max-height: 780px;
    display: grid;
}
.progress.progress_template {
    background-color: #A4A8BF !important;
}
.progress-bar_filling__low {
    background-color: #F12F42 !important;
    color: #F12F42 !important;
}
.progress-bar_filling__medium {
    background-color: #FF8736 !important;
    color: #FF8736 !important;
}
.progress-bar_filling__high {
    background-color: #009847 !important;
    color: #009847 !important;
}
.manager-header {
    border: 0.2em solid #272C5C;
    background: #343771;
    border-radius: 7px;
    display: grid;
}
.chairmaster:hover {
    background: #535591;
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
    border-radius: 7px;
}
.manager-column {
    border: 1px solid #2A3A85;
    background: #272C5C;
    height: 890px;
    max-height: 890px;
    display: grid;
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
.kpd-id {
    background: #3366FF;
    height: 10px;
    min-width: 10px;
    margin: 7px;
}
.manager-kpd-list {
    background: #333975;
    border-radius: 4px;
}
.chairmaster_selected {
    background: #535591;
}
.monitoring-button {
    background: #334296;
    height: 30px;
    margin-top: -3%;
}
.cursor-pointer {
    cursor: pointer;
}
.kpd-item {
    text-align: left;
}
.kpd-decomposition-fact {
    margin-top: -10px;
    margin-left: 10px;
}
.kpd-header {
    color: #9FA5C7;
    font-size: 14px;
}
.strategic-kpd-header {
    color: #9FA5C7;
    font-size: 12px;
}
.strategic-header {
    font-size: 12px;
}
.manager-result {
    font-size: 14px;
}
</style>