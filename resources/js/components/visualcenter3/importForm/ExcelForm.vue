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

<script>
    import VGrid from "@revolist/vue-datagrid";
    import initialRowsKOA from './dzoData/initial_rows_koa.json';
    import initialRowsKTM from './dzoData/initial_rows_ktm.json';
    import fieldsMapping from './dzoData/fields_mapping.json';
    import formatMappingKOA from './dzoData/format_mapping_koa.json';
    import formatMappingKTM from './dzoData/format_mapping_ktm.json';
    import cellsMappingKOA from './dzoData/cells_mapping_koa.json';
    import cellsMappingKTM from './dzoData/cells_mapping_ktm.json';
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
            format: formatMappingKTM,
            cells: cellsMappingKTM
        },
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
                rows: _.cloneDeep(dzoMapping[defaultDzoTicker].rows),
                isDataExist: false,
                isDataReady: false,
                rowsCount: 75,
                columnsCountForHighlight: {
                    sixColumns: [0,1,2,3,4,5],
                    fiveColumns: [0,1,2,3,4],
                    fourColumns: [0,1,2,3],
                    threeColumns: [0,1,2],
                    twoColumns: [0,1]
                },
                dzoPlans: [],
                selectedDzo: {
                  ticker: defaultDzoTicker,
                  plans: [],
                },
                currentMonthNumber: moment().format('M'),
                cellsMapping: _.cloneDeep(dzoMapping[defaultDzoTicker].cells),
                rowsFormatMapping: _.cloneDeep(dzoMapping[defaultDzoTicker].format.rowsFormatMapping),
                columnsFormatMapping: _.cloneDeep(dzoMapping[defaultDzoTicker].format.columnsFormatMapping),
                excelData: {
                    downtimeReason: {},
                    decreaseReason: {},
                    fields: {}
                },
                isValidateError: false,
                errorSelectors: [],
                inputDataCategories: ['downtimeReason','decreaseReason','fields'],
                stringColumns: [1,2],
            };
        },
        async mounted() {
            this.dzoPlans = await this.getDzoMonthlyPlans();
            console.log(dzoMapping[defaultDzoTicker].rows.length)
            this.selectedDzo.plans = this.getSelectedDzoPlans();
            await this.sleep(1500);
            this.setTableFormat();
        },
        methods: {
            dzoChange($event) {
                let dzoTicker = $event.target.value;
                this.selectedDzo.ticker = dzoTicker;
                this.cellsMapping = _.cloneDeep(dzoMapping[dzoTicker].cells);
                this.rowsFormatMapping = _.cloneDeep(dzoMapping[dzoTicker].format.rowsFormatMapping);
                this.columnsFormatMapping = _.cloneDeep(dzoMapping[dzoTicker].format.columnsFormatMapping),
                this.rows = _.cloneDeep(dzoMapping[dzoTicker].rows);
                this.rowsCount = this.rows.length + 2;
                console.log(this.rowsCount);
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
                this.isValidateError = false;
                this.isDataReady = false;
                this.turnOffErrorHighlight();
                this.processTableData();

                if (!this.isValidateError) {
                    this.isDataExist = false;
                    this.isDataReady = true;
                    this.status = this.trans("visualcenter.importForm.status.dataValid");
                } else {
                    this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                }
            },
            processTableData() {
                let self = this;
                _.forEach(Object.keys(this.cellsMapping), function(key) {
                    if (self.inputDataCategories.includes(key)) {
                        self.processBlock(self.cellsMapping[key],key);
                    } else {
                        self.processNumberCells(self.cellsMapping[key],key);
                    }
                });
            },
            processBlock(block,category) {
                let self = this;
                _.forEach(Object.keys(block), function(key) {
                    if (category === self.inputDataCategories[1]) {
                        self.processStringCells(block[key],category);
                    } else if (category === self.inputDataCategories[2]) {
                        self.processFieldsBlock(block[key],category,key);
                    } else {
                        self.processNumberCells(block[key],category);
                    }
                });
            },
            processFieldsBlock(row,category,key) {
                let self = this;
                _.forEach(Object.keys(row), function(fieldName) {
                    self.processNumberCells(row[fieldName],category,fieldName)
                });
            },
            processNumberCells(row,category,fieldCategoryName) {
                for (let columnIndex = 1; columnIndex <= row.rowLength; columnIndex++) {
                    let selector = 'div[data-col="'+ columnIndex + '"][data-row="' + row.rowIndex + '"]';
                    let cellValue = parseFloat($(selector).text());
                    if (!this.isNumberCellValid(cellValue,selector)) {
                        continue;
                    }
                    if (fieldCategoryName) {
                        this.setNumberValueForCategories(category,row.fields[columnIndex-1],cellValue,fieldCategoryName);
                    } else if (category === this.inputDataCategories[0]) {
                        this.excelData[category][row.fields[columnIndex-1]] = cellValue;
                    } else {
                        this.excelData[row.fields[columnIndex-1]] = cellValue;
                    }
                }
            },
            setNumberValueForCategories(category,fieldName,cellValue,key) {
                if (key) {
                    this.setFieldData(category,key,fieldName,cellValue);
                } else {
                    this.excelData[category][fieldName] = cellValue;
                }
            },
            setFieldData(category,groupName,fieldName,cellValue) {
              if (!this.excelData[category][groupName]) {
                  this.excelData[category][groupName] = {};
              }
              this.excelData[category][groupName][fieldName] = cellValue;
            },
            isNumberCellValid(inputData,selector) {
                if (isNaN(inputData) || inputData < 0) {
                    this.setClassToElement($(selector),'cell__color-red');
                    this.errorSelectors.push(selector);
                    this.isValidateError = true;
                    return false;
                }
                return true;
            },
            processStringCells(row,category) {
                for (let columnIndex = 1; columnIndex <= row.rowLength; columnIndex++) {
                    let selector = 'div[data-col="'+ columnIndex + '"][data-row="' + row.rowIndex + '"]';
                    let cellValue = $(selector).text().trim();
                    if (this.isStringCell(columnIndex) && this.isStringCellValid(cellValue,selector)) {
                        this.excelData[category][row.fields[columnIndex-1]] = cellValue;
                        continue;
                    }
                    if (!this.isNumberCellValid(cellValue,selector)) {
                        continue;
                    }
                    this.setNumberValueForCategories(category,row.fields[columnIndex-1],cellValue);
                }
            },
            isStringCell(rowIndex) {
              return this.stringColumns.includes(rowIndex);
            },
            isStringCellValid(inputData,selector) {
                if (!inputData || typeof(inputData) === 'number' || inputData.length < 3) {
                    this.setClassToElement($(selector),'cell__color-red');
                    this.errorSelectors.push(selector);
                    this.isValidateError = true;
                    return false;
                }
                return true;
            },
            async handleSave() {
                await this.storeData();
                this.isDataReady = !this.isDataReady;
            },
            storeData() {
                this.excelData['dzo_name'] = this.selectedDzo.ticker;
                this.excelData['date'] = moment().format("YYYY-MM-DD HH:mm:ss");

                let uri = this.localeUrl("/dzo_excel_form");

                this.axios.post(uri, this.excelData).then((response) => {
                    if (response.status === 200) {
                        this.status = this.trans("visualcenter.importForm.status.dataSaved");
                    } else {
                        this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                    }
                });
            },
            turnOffErrorHighlight() {
                let self = this;
                _.forEach(this.errorSelectors, function(selector) {
                    self.setClassToElement($(selector),'cell__color-normal');
                });
                this.errorSelectors = [];
            },
            beforeRangeEdit(e) {
                this.setTableFormat();
                this.isDataExist = true;
            },
            setTableFormat() {
                for (let rowIndex = 0; rowIndex < this.rowsCount; rowIndex++) {
                    if (this.rowsFormatMapping.title.includes(rowIndex)) {
                        this.selectClassForCell(rowIndex,this.getColumnsForHighLight(rowIndex),'cell-title');
                    } else if (this.rowsFormatMapping.subTitle.includes(rowIndex)) {
                        this.selectClassForCell(rowIndex,this.getColumnsForHighLight(rowIndex),'cell-subtitle');
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
    .cell-title {
        background-color: #1e4e79;
        color: white !important;
        text-align: center;
        line-height: 30px;
        font-size: 14px;
        font-weight: bold;
    }
    .cell-subtitle {
        background-color: #1e4e79;
        color: white !important;
        text-align: center;
        line-height: 30px;
        font-size: 12px;
        font-weight: bold;
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

