<template>
    <div class="row">
        <div class="col-4 row">
            <div class="data-status col-12">
                <span class="label">{{trans('visualcenter.importForm.yesterdayDate')}}</span>
                <span>{{currentDate}}</span>
            </div>
            <div class="data-status col-12">
                <span class="label">{{trans('visualcenter.importForm.selectedDZO')}}</span>
                <select
                        class="dzo-select col-6 ml-3"
                        disabled
                        :value="selectedDzo.ticker"
                >
                    <option v-for="dzo in dzoCompanies" :value="dzo.ticker">
                        {{dzo.name}}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-5">
            <div class="data-status col-12">
                <span class="label">{{trans('visualcenter.importForm.statusLabel')}}</span>
                <span :class="[isValidateError ? 'status-error' : '','']">{{status}}</span>
            </div>
            <div
                    :class="[!isDataExist ? 'menu__button_disabled' : '','menu__button col-6 m-2']"
                    @click="handleValidate()"
            >
                {{trans('visualcenter.validateButton')}}
            </div>
            <div
                    :class="[!isDataReady ? 'menu__button_disabled' : '','menu__button col-6 m-2']"
                    @click="handleSave()"
            >
                {{trans('visualcenter.saveButton')}}
            </div>
        </div>
        <div class="col-3 p-0">
            <div class="chemistry-container col-12 p-0">
                <div class="data-status col-12">
                    <span
                            v-if="!isChemistryButtonVisible"
                            class="label chemistry-label"
                    >
                        {{trans('visualcenter.importForm.chemistryNotNeeded')}}
                    </span>
                    <span
                            v-if="isChemistryButtonVisible"
                            class="label chemistry-label"
                    >
                        {{trans('visualcenter.importForm.chemistryNeeded')}}
                    </span>
                </div>
                <div
                        id="chemistryButton"
                        :class="[!isChemistryButtonVisible ? 'menu__button_disabled' : 'chemistry-button_animation','chemistry-button menu__button col-8 col-lg-8 m-2']"
                        @click="changeButtonVisibility()"
                >
                    {{trans('visualcenter.importForm.enterChemistryButton')}}
                </div>
                <div :class="[isChemistryNeeded ? 'chemistry-disabled' : '','chemistry-block row col-12 m-2 p-3']">
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
                        <span class="col-12 data-status">{{chemistryErrorFields.toString()}}</span>
                    </div>
                    <div class="col-6"></div>
                    <div
                            class="menu__button col-12 mt-2"
                            @click="chemistrySave()"
                    >
                        {{trans('visualcenter.saveButton')}}
                    </div>
                </div>
            </div>
        </div>



        <div class="table-form col-10">
            <v-grid
                    theme="material"
                    :source="rows"
                    :columns="columns"
                    :rowSize="30"
                    @beforeRangeEdit="beforeRangeEdit"
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
    .dzo-select {
        align-self: center;
        height: 24px;
    }
    .chemistry-block {
        background-color: #20274F;
        color: white;
        position: absolute;
        z-index: 9999;
    }
    .data-status {
        color: white;
        font-size: 18px;
    }
    .data-status .label {
        font-size: 26px;
        color: rgba(19, 176, 98, 0.8);
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
    .menu__button {
        font-size: 16px;
        font-weight: bold;
        position: relative;
        padding: 15px 15px;
        height: 24px;
        background: rgba(19, 176, 98, 0.8);
        border-radius: 8px;
        text-align: center;
        margin-bottom: 0;
        line-height: 0px;
        cursor: pointer;
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
    .chemistry-container {
        position: relative;
    }
    .chemistry-button {
        float: right;
    }
    .chemistry-button_animation {
        animation: pulse 2s linear infinite alternate;
    }
    .chemistry-label {
        float: right;
    }
    @keyframes pulse {
        from {background-color: #34bf49}
        to {background-color: #ff4c4c}
    }
</style>