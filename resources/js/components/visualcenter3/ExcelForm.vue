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
        <div class="ml-3 col-3 helpers mt-5">
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
                        :class="[!isDataExist ? 'button-disabled' : '','button col-12']"
                        @click="handleValidate()"
                >
                    {{trans('visualcenter.validateButton')}}
                </div>
                <div
                        :class="[!isDataReady ? 'button-disabled' : '','button col-12 mt-3']"
                        @click="handleSave()"
                >
                    {{trans('visualcenter.saveButton')}}
                </div>
                <div
                        class="button col-12 mt-3"
                        @click="changeButtonVisibility()"
                >
                    {{trans('visualcenter.importForm.enterChemistryButton')}}
                </div>
            </div>
            <div :class="[isChemistryNeeded ? 'disabled' : '','chemistry-block mt-5 row p-3']">
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
                        class="button col-12 mt-2"
                        @click="chemistrySave()"
                >
                    {{trans('visualcenter.saveButton')}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VGrid from "@revolist/vue-datagrid";
    import initialRowsKOA from './importForm/initial_rows_koa.json';
    import initialRowsKTM from './importForm/initial_rows_ktm.json';
    import fieldsMapping from './importForm/fields_mapping.json';
    import formatMappingKOA from './importForm/format_mapping_koa.json';
    import cellsMappingKOA from './importForm/cells_mapping_koa.json';
    import moment from "moment";

    const defaultDzoTicker = "KOA";
    const dzoMapping = {
        "KOA" : {
            rows: initialRowsKOA,
            format: formatMappingKOA,
            cells: cellsMappingKOA
        },
        "KTM" : {
            rows: initialRowsKTM,
            format: formatMappingKOA,
            cells: cellsMappingKOA
        },
    };

    const dzoOptionsMapping = {
        cells: dzoMapping[defaultDzoTicker].cells,
        initialRows: dzoMapping[defaultDzoTicker].rows,
        format: dzoMapping[defaultDzoTicker].format
    };


    export default {
        data: function () {
            return {
                dzoCompanies: [
                    {
                      ticker: 'KOA',
                      name: 'ТОО "Казахойл Актобе"'
                    },
                    {
                        ticker: 'KTM',
                        name: 'ТОО "Казахтуркмунай"'
                    },
                ],
                isChemistryNeeded: true,
                status: this.trans("visualcenter.importForm.status.waitForData"),
                columns: [
                    {
                        prop: "column1",
                        size: 440,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6',
                                },
                            };
                        },
                    },
                    {
                        prop: "column2",
                        size: 280,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                    {
                        prop: "column3",
                        size: 330,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                    {
                        prop: "column4",
                        size: 280,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                    {
                        prop: "column5",
                        size: 280,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },{
                        prop: "column6",
                        size: 280,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                ],
                rows: _.cloneDeep(dzoOptionsMapping.initialRows),
                isDataExist: false,
                isDataReady: false,
                rowsCount: 75,
                columnsCountForHighlight: {
                    six: [0,1,2,3,4,5],
                    five: [0,1,2,3,4],
                    four: [0,1,2,3],
                    three: [0,1,2],
                    two: [0,1],
                    one: []
                },
                dzoPlans: [],
                selectedDzo: {
                  ticker: defaultDzoTicker,
                  plans: [],
                },
                currentMonthNumber: moment().format('M'),
                cellsMapping: _.cloneDeep(dzoOptionsMapping.cells),
                rowsFormatMapping: _.cloneDeep(dzoOptionsMapping.format.rowsFormatMapping),
                columnsFormatMapping: _.cloneDeep(dzoOptionsMapping.format.columnsFormatMapping),
                excelData: {
                    downtimeReason: {},
                    decreaseReason: {},
                    mainData: {}
                },
                isValidateError: false,
            };
        },
        async mounted() {
            this.dzoPlans = await this.getDzoMonthlyPlans();
            this.selectedDzo.plans = this.getSelectedDzoPlans();
            await this.sleep(1000);
            this.setTableFormat();
            await this.storeData();
        },
        methods: {
            async storeData() {
                let downtimeReason = {
                    'dzoName': 'test',
                    'downtimeReason': {
                        'prs_downtime_production_wells_count': 2
                    }
                };
                let uri = this.localeUrl("/dzo_excel_form");

                this.axios.post(uri, downtimeReason);
            },
            dzoChange($event) {
                let dzoTicker = $event.target.value;
                this.selectedDzo.ticker = dzoTicker;
                dzoOptionsMapping.initialRows = dzoMapping[dzoTicker].rows;
                dzoOptionsMapping.format = dzoMapping[dzoTicker].format;
                this.rows = _.cloneDeep(dzoOptionsMapping.initialRows);
            },
            chemistrySave() {
                this.status = this.trans("visualcenter.importForm.status.dataSaved");
                this.isChemistryNeeded = !this.isChemistryNeeded;
            },
            changeButtonVisibility() {
                this.isChemistryNeeded = !this.isChemistryNeeded;
            },
            sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            },
            getSelectedDzoPlans() {
                let self = this;
                  return _.filter(this.dzoPlans, function(row) {
                      let rowMonthNumber = moment(row.date).format('M');
                      return (rowMonthNumber === self.currentMonthNumber && row.dzo === self.selectedDzo.ticker);
                  });
            },
            async getDzoMonthlyPlans() {
                let uri = this.localeUrl("/get-dzo-monthly-plans");
                const response = await axios.get(uri);
                if (response.status === 200) {
                    return response.data;
                }
                return [];
            },
            handleValidate() {
                let self = this;
                this.isValidateError = false;
                this.isDataReady = false;
                _.forEach(this.cellsMapping, function(row, index) {
                    self.processTableData(row,index);
                });
                if (!this.isValidateError) {
                    this.isDataExist = false;
                    this.isDataReady = true;
                    this.status = this.trans("visualcenter.importForm.status.dataValid");
                } else {
                    this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                }
                console.log(this.isDataReady);
            },
            handleSave() {
                let self = this;
                _.forEach(this.cellsMapping, function(row, index) {
                    self.processTableData(row,index);
                });

                this.status = this.trans("visualcenter.importForm.status.dataSaved");
            },
            processTableData(row,rowIndex) {
                let self = this;
                _.forEach(Object.keys(this.cellsMapping), function(key) {
                    if (key === 'downtimeReason') {
                        self.processBlock(self.cellsMapping[key],'downtimeReason');
                    }
                });
            },
            processBlock(block,category) {
                let self = this;
                _.forEach(block, function(row) {
                    self.processFields(row,category);
                });
            },
            processFields(row,category) {
                for (let i = 1; i <= row.index.length; i++) {
                    let selector = 'div[data-col="'+ i + '"][data-row="' + row.rowIndex + '"]';
                    let cellValue = parseFloat($(selector).text());
                    if (!this.isDowntimeReasonCellValid(cellValue,selector)) {
                        return;
                    }
                    this.excelData[category][row.fields[i]] = cellValue;
                }
            },
            isDowntimeReasonCellValid(inputData,selector) {
                if (isNaN(inputData) || inputData < 0) {
                    this.setClassToElement($(selector),'cell__color-red');
                    this.isValidateError = true;
                    return false;
                }
                return true;
            },
            beforeRangeEdit(e) {
                this.setTableFormat();
                this.isDataExist = true;
            },
            setTableFormat() {
                for (let rowIndex = 0; rowIndex < this.rowsCount; rowIndex++) {
                    if (this.rowsFormatMapping.title.includes(rowIndex)) {
                        this.selectClassForCell(rowIndex,this.getColumnsForHighLight(rowIndex),'title');
                    } else if (this.rowsFormatMapping.subTitle.includes(rowIndex)) {
                        this.selectClassForCell(rowIndex,this.getColumnsForHighLight(rowIndex),'sub-title');
                    }
                }
            },
            selectClassForCell(rowIndex,columnsList,className) {
                let self = this;
                columnsList.forEach(function(columnIndex) {
                    self.setClassToElement($('div[data-col="'+ columnIndex + '"][data-row="' + rowIndex + '"]'),className);
                });
            },
            getColumnsForHighLight(rowIndex) {
                let columnFormat = 'one';
                let self = this;
                _.forEach(Object.keys(this.columnsFormatMapping), function(key) {
                   if (self.columnsFormatMapping[key].includes(rowIndex)) {
                       columnFormat = key;
                   }
                });
                return this.columnsCountForHighlight[columnFormat];
            },
            setClassToElement(el,className) {
                el.addClass(className);
            },
        },
        components: {
            VGrid,
        },
    };
</script>

<style>
    .status-error {
        color: red;
    }
    .cell__color-red {
        background-color: red;
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
    .disabled {
        display: none;
    }
    .helpers {
        display: flex;
        flex-wrap: wrap;
        display: inline-block;
    }
    ul {
        color: red;
    }
    li {
        color: white;
    }
    revo-grid .header-wrapper {
        display: none;
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
    .title {
        background-color: #20274F;
        color: white !important;
        text-align: center;
        line-height: 30px;
        font-size: 14px;
        font-weight: bold;
    }
    .sub-title {
        background-color: #20274F;
        color: white !important;
        text-align: center;
        line-height: 30px;
        font-size: 12px;
        font-weight: bold;
    }
    .main-header {
        font-weight: bold;
    }
    .table-footer-format {
        font-weight: bold;
        line-height: 30px;
    }
    .button {
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
    .button-disabled {
        pointer-events: none;
        opacity: 0.4;
    }
    .button-enabled {
        pointer-events: all;
        opacity: 0;
    }
    @media (max-width:1400px) {
        .table-form {
            max-width: 930px;
        }
    }
</style>

