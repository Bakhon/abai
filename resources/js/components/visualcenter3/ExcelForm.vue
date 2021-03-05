<template>
    <div class="table-form">
        <v-grid
                theme="material"
                :source="rows"
                :columns="columns"
                @afterEdit="afterEdit"
                :rowSize="30"
        ></v-grid>
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
                                    fontWeight: 'bold'
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
                        size: 260,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                    {
                        prop: "name4",
                        size: 150,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                    {
                        prop: "name5",
                        size: 150,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                    {
                        prop: "name6",
                        size: 150,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    },
                    {
                        prop: "name7",
                        size: 150,
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
            };
        },
        async mounted() {
            this.createInitialRows();
        },
        methods: {
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
                console.log(e);
                //console.log(e.detail.data[0]['column_1']);
                //e.detail.data[0]['column_1'] = "55";
                // e.detail.data.val = "123";
            },
        },
        components: {
            VGrid,
        },
    };
</script>

<style>
    revo-grid {
        height: 900px;
    }

    .table-form {
        max-width: 1700px;
        background-color: white;
    }
</style>

