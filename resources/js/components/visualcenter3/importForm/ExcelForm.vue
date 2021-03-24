<template>
    <div class="row">
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
        <div class="ml-3 col-3 helpers-block mt-5">
            <div class="row">
                <div class="data-status">
                    <span class="label">Выберите ДЗО: </span>
                </div>
                <select
                        class="dzo-select col-12"
                        @change="dzoChange($event)"
                >
                    <option v-for="dzo in dzoCompanies" :value="dzo.ticker">
                        {{dzo.name}}
                    </option>
                </select>
                <div class="data-status">
                    <span class="label">{{trans('visualcenter.importForm.statusLabel')}}</span>
                    <span :class="[isValidateError ? 'status-error' : '','']">{{status}}</span>
                </div>
                <div
                        :class="[!isDataExist ? 'menu__button_disabled' : '','menu__button col-12']"
                        @click="handleValidate()"
                >
                    {{trans('visualcenter.validateButton')}}
                </div>
                <div
                        :class="[!isDataReady ? 'menu__button_disabled' : '','menu__button col-12 mt-3']"
                        @click="handleSave()"
                >
                    {{trans('visualcenter.saveButton')}}
                </div>
                <div
                        class="menu__button col-12 mt-3"
                        @click="changeButtonVisibility()"
                >
                    {{trans('visualcenter.importForm.enterChemistryButton')}}
                </div>
            </div>
            <div :class="[isChemistryNeeded ? 'chemistry-disabled' : '','chemistry-block mt-5 row p-3']">
                <h4 class="col-12">{{trans("visualcenter.importForm.chemistry")}}</h4>
                <div class="col-12 d-flex">
                    <span class="col-7">{{trans("visualcenter.chem_prod_zakacka_demulg_fact")}}</span>
                    <input class="col-5"></input>
                </div>
                <div class="col-12 d-flex">
                    <span class="col-7">{{trans("visualcenter.chem_prod_zakacka_bakteracid_fact")}}</span>
                    <input class="col-5"></input>
                </div>
                <div class="col-12 d-flex">
                    <span class="col-7">{{trans("visualcenter.chem_prod_zakacka_ingibator_korrozin_fact")}}</span>
                    <input class="col-5"></input>
                </div>
                <div class="col-12 d-flex">
                    <span class="col-7">{{trans("visualcenter.chem_prod_zakacka_ingibator_soleotloj_fact")}}</span>
                    <input class="col-5"></input>
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
</template>

<script src="./ExcelForm.js"></script>

<style scoped>
    @import './revogrid.css';

    .status-error {
        color: red;
    }
    .cell__color-red {
        background-color: red;
    }
    .cell__color-normal {
        background-color: white;
    }
    .dzo-select {
        height: 24px;
    }
    .chemistry-block {
        background-color: #20274F;
        color: white;
    }
    .data-status {
        color: white;
        font-size: 18px;
    }
    .data-status .label {
        font-size: 36px;
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
        font-family: "HarmoniaSansProCyr-Regular";
    }
    .table-form {
        max-width: 1320px;
        background-color: white;
    }
    .menu__button {
        float: right;
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
            max-width: 930px;
        }
    }
</style>

