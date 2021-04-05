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
      <el-table-column prop="name" label="Наименование" min-width="400" :key="Math.random()">
      </el-table-column>
      <el-table-column prop="fact_value" label="Факт за 2019 год" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.fact_value[previousYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="plan_value" label="Факт за 30.01.19" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.intermediate_fact_value[previousYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="fact_value" label="План на 2020 год" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.plan_value[currentYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="plan_value" label="План сначала года" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.intermediate_plan_value[currentYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="fact_value" label="Факт" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.intermediate_fact_value[currentYear] }}
        </template>
      </el-table-column>
      <el-table-column label="Абс. откл. за. отч. период, +/-">
        <template slot-scope="scope" v-if="scope.row">
          {{ absoluteDeviation(scope.row.plan_value[currentYear], scope.row.fact_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column label="Отн. откл. за. отч. период, %">
        <template slot-scope="scope" v-if="scope.row">
          {{ relativeDeviation(scope.row.plan_value[currentYear], scope.row.fact_value[currentYear]) }}
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
      distributionSumOverTree(attributeName, year) {
        this.dataReptt.reptt.reduce(function x(r, a) {
          let hasChild = a.handbook_items.length > 0;
          a[attributeName][year] = ((a[attributeName][year] < 0) ? a[attributeName][year] * -1 : a[attributeName][year]) || hasChild && a.handbook_items.reduce(x, 0) || 0;

          return r + a[attributeName][year];
        }, 0);
      },
      hideEmptyValues: function (row, index) {
        if (row.row.plan_value[this.currentYear] === 0 && row.row.level !== 0) {
          return 'hidden-row';
        }
        return '';
      },
      absoluteDeviation(currentYearPlanValue, currentYearFactValue) {
        let result = (Math.abs(currentYearPlanValue - currentYearFactValue)).toFixed(1);
        return result;
      },
      relativeDeviation(currentYearPlanValue, currentYearFactValue) {
        let result = (Math.abs(currentYearPlanValue - currentYearFactValue) / currentYearPlanValue * 100).toFixed(1);
        if (isNaN(result) || !isFinite(result)) {
          return 0;
        }
        return result;
      }
    },
    mounted() {
      this.distributionSumOverTree('plan_value', this.currentYear);
      this.distributionSumOverTree('fact_value', this.currentYear);
      this.distributionSumOverTree('plan_value', this.previousYear);
      this.distributionSumOverTree('fact_value', this.previousYear);
      this.distributionSumOverTree('intermediate_plan_value', this.currentYear);
      this.distributionSumOverTree('intermediate_fact_value', this.currentYear);
      this.distributionSumOverTree('intermediate_plan_value', this.previousYear);
      this.distributionSumOverTree('intermediate_fact_value', this.previousYear);
    },
  };
</script>