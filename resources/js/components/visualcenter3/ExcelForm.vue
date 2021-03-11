<template>
    <div class="row">
        <div class="table-form col-10">
            <v-grid
                    theme="material"
                    :source="rows"
                    :columns="columns"
                    @afterEdit="afterEdit"
                    :rowSize="30"
                    @beforeRangeEdit="beforeRangeEdit"
                    :frameSize="72"
            ></v-grid>
        </div>
        <div class="ml-3 col-3 helpers">
            <div
                    :class="[!isDataExist ? 'button-disabled' : '','button']"
                    @click="handleValidate()"
            >
                {{trans('visualcenter.validateButton')}}
            </div>
            <div :class="[isDataValid ? 'error-list_disabled' : '','col-12']">
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
                rowsCount: 59,
                errorsList: [],
                possibleErrors : {
                    incorrectDocumentFormat: 'Неверный формат Excel документа',
                },
                columnsCountForHighlight: {
                    four: [0,1,2,3],
                    three: [0,1,2],
                    two: [0,1],
                    one: 0
                },
            };
        },
        created: function() {
            let self = this;
            //https://stackoverflow.com/questions/60297446/vuetify-hide-a-skeleton-loader-after-a-element-loads
            const readyHandler = () => {
                if ($('div[data-col="0"][data-row="0"]').length > 0) {
                    self.setTableFormat();
                    //window.removeEventListener('readystatechange', readyHandler);
                }
            };
            document.addEventListener('readystatechange', readyHandler);
            readyHandler();
        },
        methods: {
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
                let self = this;

                for (let rowIndex = 0; rowIndex < this.rowsCount; rowIndex++) {
                    if (rowIndex === 0) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.four,'title');
                    } else if ([1,2].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    } else if (rowIndex === 3) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.two,'title');
                    } else if ([4,5].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    } else if (rowIndex === 6) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.two,'title');
                    } else if ([7,8].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    } else if (rowIndex === 9) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.two,'title');
                    } else if ([10,11,12].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    } else if (rowIndex === 13) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.two,'title');
                    } else if ([14,15,16,17].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    } else if (rowIndex === 18) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.four,'title');
                    } else if ([19,20].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.four,'sub-title');
                    } else if ([21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    } else if (rowIndex === 40) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.three,'table-footer-format');
                    } else if (rowIndex === 41) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.three,'title');
                    } else if (rowIndex === 42) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.three,'sub-title');
                    } else if ([43,44,45,46,47,48,49,50,51].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    } else if (rowIndex === 52) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.three,'title');
                    } else if ([53,54,55,56,57,58].includes(rowIndex)) {
                        self.selectClassForCell(rowIndex,this.columnsCountForHighlight.one,'main-header');
                    }
                }
            },
            setClassToElement(el,className) {
                el.addClass(className);
            },
            createInitialRows() {
                let self = this;
                _.forEach(this.rows, function(row) {
                    self.getRowData(row);
                });
            },
            getRowData(inputRow) {
                let row = [];
                _.forEach(this.columns, function (column) {
                    let initialObject = {};
                    initialObject[column.prop] = "";
                    //console.log('column ' + JSON.stringify(column));
                   // console.log(inputRow);
                    // cellProperties: ({prop, model, data, column}) => {
                    //     return {
                    //         class: {
                    //             'bank': true
                    //         }
                    //     }
                    // };
                    //row.push(initialObject);
                })
                return row;
            },
            afterEdit(e) {
                //console.log(e);
            },
        },
        components: {
            VGrid,
        },
    };
</script>

<style>
    .error-list_disabled {
        display: none;
    }
    .helpers {
        display: flex;
        flex-wrap: wrap;
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
        height: 750px;
    }

    .table-form {
        max-width: 1320px;
        background-color: white;
    }
    .title {
        background-color: #92d050;
        text-align: center;
        line-height: 30px;
        font-size: 18px;
        font-weight: bold;
    }
    .sub-title {
        background-color: #92d050;
        text-align: center;
        line-height: 30px;
        font-size: 14px;
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
</style>

