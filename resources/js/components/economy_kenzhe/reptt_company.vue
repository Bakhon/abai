<template>
  <div>
    <el-table      
      header-row-class-name="reptt-header"
      :data="dataReptt.reptt"
      :tree-props="defaultProps"
      style="width: 100%;"
      row-key="id"
      border    
      :cell-class-name="changeColumn"
      :header-cell-class-name="changeColumn"
      :row-class-name="hideEmptyValues"
      class="reptt table-striped"
    >
      <el-table-column
        prop="name"
        :label="this.trans('economics.name')"
        :min-width="15"
        :key="Math.random()" 
      >
      </el-table-column>
      <el-table-column
        prop="unit"
        :label="this.trans('economics.unit')"
        :min-width="5"
        :key="Math.random()"
      >
      </el-table-column>
      <el-table-column   
        prop="fact_value"
        :label="col3Reptt"
        :min-width="10"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.fact_value[previousYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="plan_value"
        :label="col4Reptt"
        :min-width="10"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_fact_value[previousYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        :label="col5Reptt"
        :min-width="10"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="plan_value"
        :label="col6Reptt"
        :min-width="10"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        :label="col7Reptt"
        :min-width="10"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{formatter( scope.row.intermediate_fact_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column :label="col8Reptt" :min-width="10">
        <template slot-scope="scope" v-if="scope.row">
          {{
            formatter(absoluteDeviation(
              scope.row.plan_value[currentYear],
              scope.row.fact_value[currentYear]
            ))
          }}
        </template>
      </el-table-column>
      <el-table-column :label="col9Reptt" :min-width="10">
        <template slot-scope="scope" v-if="scope.row">
          {{formatter(
            relativeDeviation(
              scope.row.plan_value[currentYear],
              scope.row.fact_value[currentYear]
            ))
          }}
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script src="./reptt_company.js"></script>
<style scoped>
.el-table .hidden-row {
  display: none;
}
</style>
