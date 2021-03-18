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
                    <span>{{status}}</span>
                </div>
                <div
                        :class="[!isDataExist ? 'button-disabled' : '','button col-12']"
                        @click="handleValidate()"
                >
                    {{trans('visualcenter.validateButton')}}
                </div>
                <div
                        :class="[!isDataReady ? 'button-disabled' : '','button col-12 mt-3']"
                        @click="processSummary()"
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
    import moment from "moment";

    const defaultDzoTicker = "KOA";
    const dzoMapping = {
        "KOA" : {
            rows: initialRowsKOA,
            format: formatMappingKOA
        },
        "KTM" : {
            rows: initialRowsKTM,
            format: formatMappingKOA
        },
    };

    const dzoOptionsMapping = {
        cells: fieldsMapping,
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
                kgmCellsMapping: _.cloneDeep(dzoOptionsMapping.cells),
                rowsFormatMapping: _.cloneDeep(dzoOptionsMapping.format.rowsFormatMapping),
                columnsFormatMapping: _.cloneDeep(dzoOptionsMapping.format.columnsFormatMapping),
            };
        },
        async mounted() {
            this.dzoPlans = await this.getDzoMonthlyPlans();
            this.selectedDzo.plans = this.getSelectedDzoPlans();
            await this.sleep(1000);
            this.setTableFormat();
        },
        methods: {
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
                const grid = document.querySelector('revo-grid');
                let self = this;
                this.isDataReady = true;
                this.isDataExist = false;
                this.status = this.trans("visualcenter.importForm.status.dataValid");
            },
            processSummary() {
                this.isDataReady = !this.isDataReady;
                const grid = document.querySelector('revo-grid');
                this.status = this.trans("visualcenter.importForm.status.dataSaved");
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

