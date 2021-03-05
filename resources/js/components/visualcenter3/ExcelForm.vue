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
        <div :class="[!isDataExist ? 'button-disabled' : '','save-button col-2 ml-3']">Сохранить</div>
    </div>
</template>

<script>
    import VGrid from "@revolist/vue-datagrid";

    export default {
        data: function () {
            return {
                columns: [
                    {
                        prop: "name",
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
                        prop: "details",
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
                        prop: "name2",
                        size: 250,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                    {
                        prop: "name3",
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
                rows: [],
                rowsCount: 72,
                isDataExist: false,
            };
        },
        async mounted() {
            this.createInitialRows();
        },
        methods: {
            beforeRangeEdit(e) {
                this.setTableFormat();
                this.isDataExist = true;
                console.log(this.isDataExist);
            },
            setTableFormat() {
                //oil production
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="4"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="4"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="4"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="4"]'),'title');
                //main header
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="1"]'),'main-header');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="1"]'),'main-header');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="1"]'),'main-header');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="1"]'),'main-header');
                //oil production
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="8"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="8"]'),'title');
                //stock of goods
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="12"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="12"]'),'title');
                //OTM
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="16"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="16"]'),'title');
                //Chemistry
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="21"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="21"]'),'title');
                //downtimeReason
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="27"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="27"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="27"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="27"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="28"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="28"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="28"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="28"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="29"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="29"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="29"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="29"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="50"]'),'table-footer-format');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="50"]'),'table-footer-format');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="50"]'),'table-footer-format');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="50"]'),'table-footer-format');
                //fond status
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="52"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="52"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="52"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="52"]'),'title');
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="53"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="53"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="53"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="53"]'),'sub-title');
                //oil decrease reasons
                this.setClassToElement(document.querySelector('div[data-col="0"][data-row="64"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="1"][data-row="64"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="2"][data-row="64"]'),'sub-title');
                this.setClassToElement(document.querySelector('div[data-col="3"][data-row="64"]'),'sub-title');
            },
            setClassToElement(el,className) {
                el.classList.add(className);
            },
            createInitialRows() {
                for (let i = 1; i <= this.rowsCount; i++) {
                    this.rows.push(this.getRowData());
                }
            },
            getRowData() {
                let row = [];
                _.forEach(this.columns, function (column) {
                    let initialObject = {};
                    initialObject[column.prop] = "";
                    row.push(initialObject);
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
    revo-grid {
        height: 750px;
    }

    .table-form {
        max-width: 1210px;
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
        background-color: #92d050;
        font-weight: bold;
        line-height: 30px;
    }
    .save-button {
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

