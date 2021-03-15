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
        <div class="ml-3 col-3 helpers">
            <div
                    :class="[!isDataExist ? 'button-disabled' : '','button col-12']"
                    @click="handleValidate()"
            >
                {{trans('visualcenter.validateButton')}}
            </div>
            <div
                    :class="[!isDataReady ? 'button-disabled' : '','button col-12 mt-5']"
                    @click="processSummary()"
            >
                {{trans('visualcenter.saveButton')}}
            </div>
            <div :class="[isDataValid ? 'error-list_disabled' : '','col-12 error-list']">
                <ul>{{trans('visualcenter.errors')}}:</ul>
                <li v-for="error in errorsList">
                    <span>{{error}}</span>
                </li>
            </div>
        </div>
    </div>
</template>

<script>
    import VGrid from "@revolist/vue-datagrid";
    import initialRowsKMG from './importForm/initial_rows_data_kmg.json';
    import cellsMappingKGM from './importForm/cells_mapping_kgm.json';
    import moment from "moment";


    export default {
        data: function () {
            return {
                columns: [
                    {
                        prop: "column1",
                        size: 350,
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
                ],
                rows: _.cloneDeep(initialRowsKMG),
                isDataExist: false,
                isDataValid: true,
                isDataReady: false,
                rowsCount: 57,
                errorsList: [],
                possibleErrors : {
                    incorrectDocumentFormat: this.trans("visualcenter.importFormErrorList-incorrectDocumentFormat"),
                },
                columnsCountForHighlight: {
                    four: [0,1,2,3],
                    three: [0,1,2],
                    two: [0,1],
                    one: 0
                },
                dzoPlans: [],
                selectedDzo: {
                  name: 'КГМ',
                  plans: [],
                },
                currentMonthNumber: moment().format('M'),
                kgmCellsMapping: _.cloneDeep(cellsMappingKGM),
                rowsFormatMapping: {
                    title: [0,3,6,9,13,18,39,50],
                    subTitle: [19,20,40],
                    tableFooter: [38],
                },
            };
        },
        async mounted() {
            this.dzoPlans = await this.getDzoMonthlyPlans();
            this.selectedDzo.plans = this.getSelectedDzoPlans();
            await this.sleep(1000);
            this.setTableFormat();
        },
        methods: {
            sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            },
            getSelectedDzoPlans() {
                let self = this;
                  return _.filter(this.dzoPlans, function(row) {
                      let rowMonthNumber = moment(row.date).format('M');
                      return (rowMonthNumber === self.currentMonthNumber && row.dzo === self.selectedDzo.name);
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
                grid.getSource()
                    .then(function(dataSource) {
                        self.deleteEmptyRows(dataSource);
                    })
                    .catch(function(error) {
                        console.error(error);
                    })
            },
            processSummary() {
                const grid = document.querySelector('revo-grid');
            },
            deleteEmptyRows(dataSource) {
                let self = this;
                let sourceLength = dataSource.length;
                while (sourceLength--) {
                    if (self.isRowForDelete(dataSource[sourceLength])) {
                        dataSource.splice(sourceLength,1);
                    }
                }
                this.rows = dataSource;
                sourceLength = this.rows.length;
                if (sourceLength !== this.rowsCount) {
                    this.isDataValid = false;
                    this.rows = _.cloneDeep(initialRowsKMG);
                    this.errorsList.push(this.possibleErrors.incorrectDocumentFormat);
                    return;
                }
                this.isDataValid = true;
                this.isDataReady = true;
            },
            isRowForDelete(row,sourceLength) {
                return this.isRowHeader(row) || this.isRowEmpty(row);
            },
            isRowHeader(row) {
                return row['column1'].toLowerCase().includes('рапорт');
            },
            isRowEmpty(row) {
                return row['column1'].length < 2 && row['column2'].length < 2 && row['column3'].length < 2 && row['column4'].length < 2;
            },
            beforeRangeEdit(e) {
                this.setTableFormat();
                this.isDataExist = true;
            },
            selectClassForCell(rowIndex,columnsList,className) {
                let self = this;
                if (typeof(columnsList) === 'object') {
                    columnsList.forEach(function(columnIndex) {
                        self.setClassToElement($('div[data-col="'+ columnIndex + '"][data-row="' + rowIndex + '"]'),className);
                    });
                } else {
                    self.setClassToElement($('div[data-col="'+ columnsList + '"][data-row="' + rowIndex + '"]'),className);
                }
            },
            setTableFormat() {
                for (let rowIndex = 0; rowIndex < this.rowsCount; rowIndex++) {
                    if (this.rowsFormatMapping.title.includes(rowIndex)) {
                        this.selectClassForCell(rowIndex,this.columnsCountForHighlight.four,'title');
                    } else if (this.rowsFormatMapping.subTitle.includes(rowIndex)) {
                        this.selectClassForCell(rowIndex,this.columnsCountForHighlight.four,'sub-title');
                    } else if (this.rowsFormatMapping.tableFooter.includes(rowIndex)) {
                        this.selectClassForCell(rowIndex,this.columnsCountForHighlight.four,'table-footer-format');
                    } else {
                        this.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    }
                }
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
    .error-list {
        margin-top: 80%;
    }
    .error-list_disabled {
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
        height: 44px;
        background: rgba(19, 176, 98, 0.8);
        border-radius: 8px;
        text-align: center;
        margin-bottom: 0;
        line-height: 18px;
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

