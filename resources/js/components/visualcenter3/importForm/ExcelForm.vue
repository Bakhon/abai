<template>
    <div>

        <div class="row main-layout pb-3">
            <div class="col-12 row mt-3 ml-1 justify-content-center">
                <div
                        :class="[category.isFactActive ? 'category-button_border' : '',' col-3 category-button d-flex justify-content-center']"
                        @click="changeCategory('isFactActive')"
                >
                    <div class="col-1 insert-data-icon"></div>
                    <div class="col-7">{{trans('visualcenter.importForm.insertData')}}</div>
                </div>
                <div
                        :class="[category.isArchieveActive ? 'category-button_border' : '',' col-3 category-button d-flex justify-content-center']"
                        @click="changeCategory('isArchieveActive')"
                >
                    <div class="col-1 archieve-icon"></div>
                    <div class="col-6">{{trans('visualcenter.importForm.dataArchieve')}}</div>
                </div>
                <div
                        :class="[category.isPlanActive ? 'category-button_border' : '',' col-3 category-button d-flex justify-content-center']"
                        @click="changeCategory('isPlanActive')"
                >
                    <div class="insert-data-icon col-1"></div>
                    <div class="col-8">{{trans('visualcenter.importForm.planParams')}}</div>
                </div>
            </div>
        </div>
        <div class="row main-layout mt-2">
            <div class="col-2 row mt-3 ml-1">
                <div class="col-12 status-block currentdate-label status-label">
                    <span>{{trans('visualcenter.importForm.yesterdayDate')}}:</span><br>
                    <span class="dzo-name">{{currentDate}}</span><br>
                </div>
                <div class="col-12 status-block dzoname-label status-label">
                    <span class="dzo-name">{{selectedDzo.name}}</span>
                </div>
            </div>
            <div v-if="category.isPlanActive" class="col-2 row mt-3 ml-1">
                <div
                        class="col-12 status-block status-block_little menu__button rainbow menu__button_disabled"
                        @click="pasteClipboardContent()"
                >
                    {{trans('visualcenter.importForm.pasteData')}}
                </div>
                <div
                        :class="[!isDataExist ? 'menu__button_disabled' : '','col-12 status-block status-block_little menu__button mt-3']"
                        @click="validatePlan()"
                >
                    {{trans('visualcenter.validateButton')}}
                </div>
                <div
                        :class="[!isDataReady ? 'menu__button_disabled' : '','status-block status-block_little menu__button col-12 mt-3']"
                        @click="savePlan()"
                >
                    {{trans('visualcenter.saveButton')}}
                </div>
            </div>
            <div v-else-if="category.isFactActive" class="col-2 row mt-3 ml-1">
                <div
                        class="col-12 status-block status-block_little menu__button rainbow"
                        @click="pasteClipboardContent()"
                >
                    {{trans('visualcenter.importForm.pasteData')}}
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
            <div v-else-if="category.isArchieveActive" class="col-2 row mt-3 ml-1">
                <div class="col-12 date-select">
                    <span>{{trans('visualcenter.importForm.dateSelect')}}:</span><br>
                </div>
                <div
                        class="col-12 status-block status-block_little p-0 mt-1"
                >
                    <el-date-picker
                            v-model="period"
                            type="date"
                            format="dd.MM.yyyy"
                            popper-class="custom-date-picker"
                            :picker-options="datePickerOptions"
                            @change="changeDate"
                    >
                    </el-date-picker>
                </div>
                <div
                        :class="[isUserNameCompleted && isChangeReasonCompleted && isUserPositionCompleted && !isDataSended ? '' : 'menu__button_disabled','col-12 status-block status-block_little menu__button mt-3']"
                        @click="sendToApprove"
                >
                    {{trans('visualcenter.importForm.approve')}}
                </div>
            </div>
            <div v-else class="col-2 row mt-3 ml-1"></div>
            <div v-if="!category.isFactActive" class="col-4 mt-3 row ml-1">
                <b-form-input
                        size="sm"
                        v-model="userName"
                        :placeholder="trans('visualcenter.importForm.executor')"
                        :state="nameState"
                ></b-form-input>
                <b-form-input
                        size="sm"
                        class="mt-1"
                        v-model="userPosition"
                        :placeholder="trans('visualcenter.importForm.position')"
                        :state="userPositionState"
                ></b-form-input>
                <b-form-textarea
                        class="mt-1"
                        id="textarea"
                        v-model="changeReason"
                        :placeholder="trans('visualcenter.importForm.reason')"
                        rows="2"
                        :state="changeReasonState"
                ></b-form-textarea>
            </div>
            <div v-else class="col-4 mt-3 row ml-1"></div>
            <div class="col-2 row mt-3 ml-1">
                <div class="col-12 status-block status-block_little status-label">
                    <span>{{trans('visualcenter.importForm.statusLabel')}}:</span>
                    <span :class="[isValidateError ? 'status-error' : '','label']">&nbsp;{{status}}</span>
                </div>
                <select
                        class="form-select col-12 mt-3 status-block status-block_little"
                        v-if="!dzoUsers.includes(parseInt(userId))"
                        @change="switchCompany($event)"
                >
                    <option v-for="company in dzoCompanies" :value="company.ticker">{{company.name}}</option>
                </select>
                <div v-else class="col-12 mt-3 status-block status-block_little">
                    &nbsp;
                </div>
                <div class="col-12 mt-3 status-block status-block_little">
                    &nbsp;
                </div>
            </div>

            <div v-if="category.isFactActive || category.isArchieveActive" class="col-2 row mt-3 ml-1">
                <div class="vert-line"></div>
                <div
                        id="chemistryButton"
                        :class="[!isChemistryButtonVisible ? 'menu__button_disabled' : 'rainbow','col-12 status-block status-block_little menu__button ml-1']"
                        @click="changeButtonVisibility()"
                >
                    {{trans('visualcenter.importForm.enterChemistryButton')}}
                </div>
                <div :class="[isChemistryNeeded ? 'chemistry-disabled' : '','chemistry-block row col-12 p-2']">
                    <h4 class="col-12">{{trans("visualcenter.importForm.chemistry")}}</h4>
                    <div class="col-12 d-flex">
                        <span class="col-7">{{trans("visualcenter.chemProdZakackaDemulg")}}</span>
                        <input v-model="chemistryData.demulsifier" @change="formatCategoryByType($event,'chemistryData','demulsifier')" class="col-5"></input>
                    </div>
                    <div class="col-12 d-flex">
                        <span class="col-7">{{trans("visualcenter.chemProdZakackaBakteracid")}}</span>
                        <input v-model="chemistryData.bactericide" @change="formatCategoryByType($event,'chemistryData','bactericide')" class="col-5"></input>
                    </div>
                    <div class="col-12 d-flex">
                        <span class="col-7">{{trans("visualcenter.chemProdZakackaIngibatorKorrozin")}}</span>
                        <input v-model="chemistryData.corrosion_inhibitor" @change="formatCategoryByType($event,'chemistryData','corrosion_inhibitor')" class="col-5"></input>
                    </div>
                    <div class="col-12 d-flex">
                        <span class="col-7">{{trans("visualcenter.chemProdZakackaIngibatorSoleotloj")}}</span>
                        <input v-model="chemistryData.scale_inhibitor" @change="formatCategoryByType($event,'chemistryData','scale_inhibitor')" class="col-5"></input>
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
                <div
                        :class="[!isChemistryButtonVisible && category.isFactActive ? 'menu__button_disabled' : 'rainbow','col-12 status-block status-block_little menu__button ml-1 mt-3']"
                        @click="changeWellBlockVisibility()"
                >
                    {{trans('visualcenter.importForm.wellWorkover')}}
                </div>
                <div :class="[isWellsWorkoverNeeded ? 'chemistry-disabled' : '','chemistry-block well-workover-block row col-12 p-2']">
                    <h4 class="col-12">{{trans("visualcenter.importForm.wellWorkover")}}</h4>
                    <div class="col-12 d-flex">
                        <span class="col-7">{{trans("visualcenter.undergroundRepairFond")}}</span>
                        <input v-model="wellWorkover.otm_underground_workover" @change="formatCategoryByType($event,'wellWorkover','otm_underground_workover')" class="col-5"></input>
                    </div>
                    <div class="col-12 d-flex">
                        <span class="col-7">{{trans("visualcenter.overhaulFond")}}</span>
                        <input v-model="wellWorkover.otm_well_workover_fact" @change="formatCategoryByType($event,'wellWorkover','otm_well_workover_fact')" class="col-5"></input>
                    </div>
                    <div class="col-6"></div>
                    <div class="col-8 mt-2"></div>
                    <div
                            class="status-block status-block_little col-4 mt-2 menu__button"
                            @click="wellWorkoverSave()"
                    >
                        {{trans('visualcenter.saveButton')}}
                    </div>
                </div>

                <div class="col-12 mt-3 status-block status-block_little">
                    &nbsp;
                </div>

            </div>

            <div class="table-form col-12 mt-3 ml-1">
                <v-grid
                        v-if="!category.isPlanActive"
                        id="factGrid"
                        theme="material"
                        :source="rows"
                        :columns="columns"
                        :rowSize="30"
                        @beforeRangeEdit="beforeRangeEdit"
                        @beforeEdit="beforeRangeEdit"
                        :frameSize="72"
                ></v-grid>
                <v-grid
                        v-else
                        id="planGrid"
                        theme="material"
                        :source="currentPlan.rows"
                        :columns="currentPlan.columns"
                        :rowSize="30"
                        @beforeRangeEdit="beforeRangeEdit"
                        @beforeEdit="beforeRangeEdit"
                        :frameSize="72"
                ></v-grid>

            </div>
        </div>
        <modal
                class="modal-bign-wrapper"
                name="additionalParamsReminder"
                :width="720"
                :height="250"
                style="background-color: rgba(0, 0, 0, 0.1);"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">Напоминание</div>
                    <button type="button" class="modal-bign-button" @click="$modal.hide('additionalParamsReminder')">
                        {{trans('pgno.zakrit')}}
                    </button>
                </div>
                <hr class="solid">
                <div class="modal_header mt-2">
                    <h2 class="text-center">Необходимо с 5 по 10 число заполнить параметры:</h2>
                    <div class="row justify-content-center mt-4 mx-5">
                        <div
                                :class="[!isChemistryButtonVisible ? 'menu__button_disabled' : '','col-12 status-block status-block_little menu__button ml-1']"
                                @click="changeButtonVisibility()"
                        >
                            {{trans('visualcenter.importForm.enterChemistryButton')}}
                        </div>
                        <div
                                :class="[!isChemistryButtonVisible ? 'menu__button_disabled' : '','col-12 status-block status-block_little menu__button ml-1 mt-3']"
                                @click="changeWellBlockVisibility()"
                        >
                            {{trans('visualcenter.importForm.wellWorkover')}}
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script src="./ExcelForm.js"></script>

<style scoped lang="scss">
    @import './revogrid.css';

    ::v-deep .el-input__inner {
        color: white;
    }
    .status-error {
        color: red;
    }
    .chemistry-block {
        background-color: #20274F;
        color: white;
        position: absolute;
        z-index: 9999;
        margin-top: 30px;
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
        max-width: 99.8%;
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
        max-width: 1838px;
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
    @keyframes rotate {
        0% {
            transform:scaleX(0);
            transform-origin: left;
        }
        50%
        {
            transform:scaleX(1);
            transform-origin: left;
        }
        50.1%
        {
            transform:scaleX(1);
            transform-origin: right;
        }
        100%
        {
            transform:scaleX(0);
            transform-origin: right;
        }
    }

    .rainbow {
        position: relative;
        z-index: 0;
        overflow: hidden;
        &::before {
            content: '';
            position: absolute;
            z-index: -2;
            left: -50%;
            top: -50%;
            width: 200%;
            height: 200%;
            background-color: #82BAFF;
            background-repeat: no-repeat;
            background-size: 50% 50%, 50% 50%;
            background-position: 0 0, 100% 0, 100% 100%, 0 100%;
            animation: rotate 10s linear infinite;
        }
        &::after {
            content: '';
            position: absolute;
            z-index: -1;
            left: 6px;
            top: 6px;
            background: #656A8A;
            border-radius: 1px;
        }
    }

    .vert-line {
        background: url(/img/visualcenter3/line.png) no-repeat;
        position: absolute;
        width: 1px;
        margin-left: -10px;
        height: 90%;
        margin-top: 1vh;
    }
    .well-workover-block {
        margin-top: 75px;
    }
    .category-button {
        font-size: 24px;
        color: white;
        text-align: center;
        cursor: pointer;
    }
    .category-button_border {
        border-bottom: 2px solid #2E50E9;
    }
    .insert-data-icon {
        background: url(/img/visualcenter3/import-form-insert-data.svg) no-repeat;
        width: 20px;
        height: 20px;
        margin-top: 1vh;
    }
    .archieve-icon {
        background: url(/img/visualcenter3/import-form-archieve.svg) no-repeat;
        width: 20px;
        height: 20px;
        margin-top: 1vh;
    }
    .date-select {
        color: white;
        font-size: 16px;
        text-align: left;
    }
    hr.solid {
        border-top: 3px solid #bbb;
    }
    .reminder-titles {
        margin-top: 60px;
    }
    select.status-block {
        color: black;
    }

</style>