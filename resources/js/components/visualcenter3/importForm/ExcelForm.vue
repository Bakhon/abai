<template>
    <div class="row main-layout">
        <div class="col-2 row mt-3 ml-1">
            <div class="col-12 status-block currentdate-label status-label">
                <span>{{trans('visualcenter.importForm.yesterdayDate')}}</span><br>
                <span class="dzo-name">{{currentDate}}</span><br>
            </div>
            <div class="col-12 status-block dzoname-label status-label">
                <span class="dzo-name">{{selectedDzo.name}}</span>
            </div>
        </div>

        <div class="col-2 row mt-3 ml-1">
            <div class="col-12 status-block status-block_little status-label">
                <span>{{trans('visualcenter.importForm.statusLabel')}}&nbsp;</span>
                <span :class="[isValidateError ? 'status-error' : '','label']">{{status}}</span>
            </div>
            <div
                    :class="[!isDataExist ? 'menu__button_disabled' : '','col-12 status-block status-block_little menu__button mt-3']"
                    @click="handleValidate()"
            >
                {{trans('visualcenter.validateButton')}}
            </div>
            <div
                    :class="[!isDataReady ? 'menu__button_disabled' : '','status-block status-block_little menu__button col-12 mt-3']"
                    @click="handleSave()"
            >
                {{trans('visualcenter.saveButton')}}
            </div>
        </div>
        <div class="col-4 mt-3 row ml-1"></div>

        <div class="col-4 row mt-3 ml-1">
            <div class="col-12 mt-3 status-block status-block_little">
                &nbsp;
            </div>
            <div class="col-12 mt-3 status-block status-block_little">
                &nbsp;
            </div>
            <div class="col-6 status-block status-block_little"></div>
            <div
                    id="chemistryButton"
                    :class="[!isChemistryButtonVisible ? 'menu__button_disabled' : 'chemistry-button_animation','col-6 status-block status-block_little menu__button']"
                    @click="changeButtonVisibility()"
            >
                {{trans('visualcenter.importForm.enterChemistryButton')}}
            </div>
            <div :class="[isChemistryNeeded ? 'chemistry-disabled' : '','chemistry-block row col-12 p-2']">
                <h4 class="col-12">{{trans("visualcenter.importForm.chemistry")}}</h4>
                <div class="col-12 d-flex">
                    <span class="col-7">{{trans("visualcenter.chemProdZakackaDemulg")}}</span>
                    <input v-model="chemistryData.demulsifier" class="col-5"></input>
                </div>
                <div class="col-12 d-flex">
                    <span class="col-7">{{trans("visualcenter.chemProdZakackaBakteracid")}}</span>
                    <input v-model="chemistryData.bactericide" class="col-5"></input>
                </div>
                <div class="col-12 d-flex">
                    <span class="col-7">{{trans("visualcenter.chemProdZakackaIngibatorKorrozin")}}</span>
                    <input v-model="chemistryData.corrosion_inhibitor" class="col-5"></input>
                </div>
                <div class="col-12 d-flex">
                    <span class="col-7">{{trans("visualcenter.chemProdZakackaIngibatorSoleotloj")}}</span>
                    <input v-model="chemistryData.scale_inhibitor" class="col-5"></input>
                </div>
                <div v-if="chemistryErrorFields.length > 0" class="col-12 d-flex">
                    <span class="col-12 status-error">{{trans("visualcenter.errors")}}:</span>
                </div>
                <div v-if="chemistryErrorFields.length > 0" class="col-12 d-flex">
                    <span class="col-12">{{chemistryErrorFields.toString()}}</span>
                </div>
                <div class="col-6"></div>
                <div class="col-8 mt-2"></div>
                <div
                        class="status-block status-block_little col-4 mt-2 menu__button"
                        @click="chemistrySave()"
                >
                    {{trans('visualcenter.saveButton')}}
                </div>
            </div>
        </div>

        <div class="table-form col-10 mt-3 ml-1">
            <v-grid
                    theme="material"
                    :source="rows"
                    :columns="columns"
                    :rowSize="30"
                    @beforeRangeEdit="beforeRangeEdit"
                    @beforeEdit="beforeRangeEdit"
                    :frameSize="72"
            ></v-grid>
        </div>
    </div>
</template>

<script src="./ExcelForm.js"></script>

<style scoped lang="scss">
    @import './revogrid.css';

    .status-error {
        color: red;
    }
    .chemistry-block {
        background-color: #20274F;
        color: white;
        position: absolute;
        z-index: 9999;
        margin-top: 160px;
    }
    .chemistry-disabled {
        display: none;
    }
    .helpers-block {
        display: flex;
        flex-wrap: wrap;
        display: inline-block;
    }
    revo-grid {
        height: 782px;
        font-size: 12px;
        font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
    }
    .table-form {
        max-width: 1800px;
        background-color: white;
    }
    .menu__button_disabled {
        pointer-events: none;
        opacity: 0.4;
    }
    @media (max-width:1400px) {
        .table-form {
            max-width: 1270px;
        }
    }
    .chemistry-button_animation {
        animation: pulse 5s linear infinite alternate;
    }
    @keyframes pulse {
        from {background-color: #FFD700}
        to {background-color: #ff4c4c}
    }
    .status-block {
        font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
        font-size: 24px;
        color: white;
        text-align: center;
        border-radius: 8px;
    }
    .status-block_little {
        font-size: 16px;
        justify-content: center;
        align-items: center;
        display: flex;
    }
    .status-block_little .label {
        font-size: 13px;
        color: #82BAFF;
    }
    .status-block .dzo-name {
        font-size: 22px;
        color: #82BAFF;
    }
    .button-block {
        background: #656A8A;
        font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
        font-size: 14px;
        text-align: center;
        border-radius: 8px;
        font-weight: bold;
        font-weight: bold;
    }
    .main-layout {
        background: #272953;
    }
    .menu__button {
        background: #656A8A;
        font-weight: 500;
        cursor: pointer;
    }
    .status-label {
        border: 1px solid #656A8A;
    }
    .dzoname-label {
        bottom: 0;
        position: absolute;
        width: 90%;
        font-size: 16px;
        span.dzo-name {
            font-size: 16px;
        }
    }
    .currentdate-label {
        position: absolute;
        width: 90%;
        height: 65%;
        span.dzo-name {
            bottom: 0;
            position: absolute;
            left: 27%;
        }
    }
</style>