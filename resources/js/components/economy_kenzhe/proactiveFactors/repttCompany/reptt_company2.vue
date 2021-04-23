<template>
  <div>
    <el-table
      header-row-class-name="reptt-header"
      :data="dataReptt.reptt"
      :tree-props="defaultProps"
      style="width: 100%"
      row-key="id"
      border
      :cell-class-name="getChangedColumnClass"
      :header-cell-class-name="getChangedColumnClass"
      :row-class-name="hideEmptyValues"
      class="reptt"
    >
      <el-table-column
        prop="name"
        label="Наименование"
        :min-width="12"
        :key="Math.random()"
      >
      </el-table-column>

      <el-table-column
        prop="plan_value"
        label="План на январь - март"
        :min-width="8"
        :key="Math.random()"
      >        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_plan_value[previousYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        label="Факт за январь - март"
        :min-width="8"
        :key="Math.random()"
      >        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_fact_value[previousYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        label="Откл. абс"
        :min-width="8"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.fact_value[previousYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="plan_value"
        label="Откл. %"
        :min-width="8"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_fact_value[previousYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        label="Прогноз"
        :min-width="8"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="plan_value"
        label="Откл. абс. от утв. плана"
        :min-width="8"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        label="Откл. % от утв. плана"
        :min-width="8"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_fact_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        label="Прогноз"
        :min-width="8"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column :label="col8Reptt" :min-width="8">
        <template slot-scope="scope" v-if="scope.row">
          {{
            formatter(
              getAbsoluteDeviation(
                scope.row.plan_value[currentYear],
                scope.row.fact_value[currentYear]
              )
            )
          }}
        </template>
      </el-table-column>
      <el-table-column :label="col9Reptt" :min-width="8">
        <template slot-scope="scope" v-if="scope.row">
          {{
            formatter(
              getRelativeDeviation(
                scope.row.plan_value[currentYear],
                scope.row.fact_value[currentYear]
              )
            )
          }}
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script src="./reptt_company2.js"></script>
<style scoped>
.el-table .hidden-row {
  display: none;
}
</style>
