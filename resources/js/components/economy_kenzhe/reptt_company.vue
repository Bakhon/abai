<template>
    <div>
        <el-table
                :data="reptt"
                :tree-props="defaultProps"
                style="width: 100%;"
                row-key="id"
                border
                :row-class-name="hideEmptyValues"
        >
            <el-table-column prop="name" label="Наименование"  min-width="400" :key="Math.random()">
            </el-table-column>
            <el-table-column prop="plan_value" label="План на январь"  width="200" :key="Math.random()">
            </el-table-column>
            <el-table-column prop="fact_value" label="Факт"  width="200" :key="Math.random()">
            </el-table-column>
            <el-table-column label="Абс. откл. за. отч. период, +/-">
                <template slot-scope="scope" v-if="scope.row">
                    {{ (Math.abs(scope.row.plan_value - scope.row.fact_value)).toFixed(1) }}
                </template>
            </el-table-column>
            <el-table-column label="Отн. откл. за. отч. период, %">
                <template slot-scope="scope" v-if="scope.row">
                    {{ (Math.abs(scope.row.plan_value - scope.row.fact_value)/scope.row.plan_value*100).toFixed(1) }}
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>
<style>
    .el-table .hidden-row {
        display: none;
    }
</style>
<script>
    export default {
        props: ["reptt"],
        data() {
            return {
                defaultProps: {
                    id: "id",
                    children: "handbook_items",
                },
                tableHeader: [
                    {
                        label: 'Наименование',
                        prop: 'name'
                    }, {
                        label: 'План на январь',
                        prop: 'value'
                    }
                ]
            };
        },
        methods: {
            distributionSumOverTree() {
                this.reptt.reduce(function x(r, a, index) {
                    let hasChild = a.handbook_items.length > 0;
                    a.plan_value = ((a.plan_value < 0) ? a.plan_value * -1 : a.plan_value) || hasChild && a.handbook_items.reduce(x, 0) || 0;

                    return r + a.plan_value;
                }, 0);
                this.reptt.reduce(function x(r, a, index) {
                    let hasChild = a.handbook_items.length > 0;
                    a.fact_value = ((a.fact_value < 0) ? a.fact_value * -1 : a.fact_value) || hasChild && a.handbook_items.reduce(x, 0) || 0;

                    return r + a.fact_value;
                }, 0);
            },
            hideEmptyValues: function (row, index) {
                if (row.row.plan_value === 0 && row.row.level !== 0) {
                    return 'hidden-row';
                }
                return '';
            }
        },
        mounted() {
            this.distributionSumOverTree();
        },
    };
</script>