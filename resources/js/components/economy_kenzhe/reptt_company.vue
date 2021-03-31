<template>
    <div>
        <el-table
                :data="dataReptt.reptt"
                :tree-props="defaultProps"
                style="width: 100%;"
                row-key="id"
                border
                :row-class-name="hideEmptyValues"
        >
            <el-table-column prop="name" label="Наименование"  min-width="400" :key="Math.random()">
            </el-table-column>
            <el-table-column prop="plan_value" label="Факт за 2019 год"  width="200" :key="Math.random()">
                <template slot-scope="scope" v-if="scope.row">
                    {{ scope.row.fact_value[previousYear] }}
                </template>
            </el-table-column>
            <el-table-column prop="plan_value" label="План на январь"  width="200" :key="Math.random()">
                <template slot-scope="scope" v-if="scope.row">
                    {{ scope.row.plan_value[currentYear] }}
                </template>
            </el-table-column>
            <el-table-column prop="fact_value" label="Факт"  width="200" :key="Math.random()">
                <template slot-scope="scope" v-if="scope.row">
                    {{ scope.row.fact_value[currentYear] }}
                </template>
            </el-table-column>
            <el-table-column label="Абс. откл. за. отч. период, +/-">
                <template slot-scope="scope" v-if="scope.row">
                    {{ (Math.abs(scope.row.plan_value[currentYear] - scope.row.fact_value[currentYear])).toFixed(1) }}
                </template>
            </el-table-column>
            <el-table-column label="Отн. откл. за. отч. период, %">
                <template slot-scope="scope" v-if="scope.row">
                    {{ (Math.abs(scope.row.plan_value[currentYear] - scope.row.fact_value[currentYear])/scope.row.plan_value[currentYear]*100).toFixed(1) }}
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
        props: ["dataReptt"],
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
        computed: {
            currentYear: function () {
                return this.dataReptt.currentYear
            },
            previousYear: function () {
                return this.dataReptt.previousYear
            }
        },
        methods: {
            distributionSumOverTree() {
                let that = this;
                this.dataReptt.reptt.reduce(function x(r, a) {
                    let hasChild = a.handbook_items.length > 0;
                    a.plan_value[that.currentYear] = ((a.plan_value[that.currentYear] < 0) ? a.plan_value[that.currentYear] * -1 : a.plan_value[that.currentYear]) || hasChild && a.handbook_items.reduce(x, 0) || 0;

                    return r + a.plan_value[that.currentYear];
                }, 0);
                this.dataReptt.reptt.reduce(function x(r, a) {
                    let hasChild = a.handbook_items.length > 0;
                    a.fact_value[that.currentYear] = ((a.fact_value[that.currentYear] < 0) ? a.fact_value[that.currentYear] * -1 : a.fact_value[that.currentYear]) || hasChild && a.handbook_items.reduce(x, 0) || 0;

                    return r + a.fact_value[that.currentYear];
                }, 0);
                this.dataReptt.reptt.reduce(function x(r, a) {
                    let hasChild = a.handbook_items.length > 0;
                    a.plan_value[that.previousYear] = ((a.plan_value[that.previousYear] < 0) ? a.plan_value[that.previousYear] * -1 : a.plan_value[that.previousYear]) || hasChild && a.handbook_items.reduce(x, 0) || 0;

                    return r + a.plan_value[that.previousYear];
                }, 0);
                this.dataReptt.reptt.reduce(function x(r, a) {
                    let hasChild = a.handbook_items.length > 0;
                    a.fact_value[that.previousYear] = ((a.fact_value[that.previousYear] < 0) ? a.fact_value[that.previousYear] * -1 : a.fact_value[that.previousYear]) || hasChild && a.handbook_items.reduce(x, 0) || 0;

                    return r + a.fact_value[that.previousYear];
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