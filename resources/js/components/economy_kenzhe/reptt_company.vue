<template>
  <div>
    <div class="row">
      <div class="col-sm-4">
        <select
          name="company"
          v-model="company"
          @change="updateData('betweenMonthsValue')"
          class="form-control mb-3"
        >
          <option v-for="company in repttData.companies" :value="company.id">
            {{ company.name }}
          </option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <select
          name="dateTo"
          v-model="betweenMonthsValue"
          @change="updateData('betweenMonthsValue')"
          class="form-control mb-3"
        >
          <option v-for="month in betweenMonths" :value="month.value">
            {{ month.title + " " + currentYear }}
          </option>
        </select>
      </div>
      <div class="col-sm-4">
        <select
          name="dateTo"
          v-model="monthsValue"
          @change="updateData('monthsValue')"
          class="form-control mb-3"
        >
          <option v-for="month in months" :value="month.value">
            {{ month.title + " " + currentYear }}
          </option>
        </select>
      </div>
      <div class="col-sm-4">
        <select
          name="dateTo"
          v-model="quarterValue"
          @change="updateData('quarterValue')"
          class="form-control mb-3"
        >
          <option v-for="month in quarter" :value="month.value">
            {{ month.title + " " + currentYear }}
          </option>
        </select>
      </div>
    </div>

    <el-table
      header-row-class-name="reptt-header"
      :data="repttData.reptt"
      :tree-props="defaultProps"
      style="width: 100%"
      row-key="id"
      border
      :cell-class-name="changeColumn"
      :header-cell-class-name="changeColumn"
      :row-class-name="hideEmptyValues"
      class="reptt table-striped"
    >
      <el-table-column
        prop="name"
        :label="this.trans('economy_pf.repttTable.name')"
        :min-width="150"
        :key="Math.random()"
      >
      </el-table-column>
      <el-table-column
        prop="unit"
        :label="this.trans('economy_pf.repttTable.unit')"
        :min-width="30"
        :key="Math.random()"
      >
      </el-table-column>
      <el-table-column
        prop="unit"
        :label="col3Reptt"
        :min-width="90"
        :key="Math.random()"
      >
      </el-table-column>

      <el-table-column
        prop="plan_value"
        :label="col4Reptt"
        :min-width="90"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_fact_value[previousYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        :label="col5Reptt"
        :min-width="90"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="plan_value"
        :label="col6Reptt"
        :min-width="90"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        :label="col7Reptt"
        :min-width="90"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_fact_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column :label="col8Reptt">
        <template slot-scope="scope" v-if="scope.row">
          {{
            formatter(
              absoluteDeviation(
                scope.row.plan_value[currentYear],
                scope.row.fact_value[currentYear]
              )
            )
          }}
        </template>
      </el-table-column>
      <el-table-column :label="col9Reptt">
        <template slot-scope="scope" v-if="scope.row">
          {{
            formatter(
              relativeDeviation(
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
<script src="./reptt_company.js"></script>

<style scoped>
.el-table .hidden-row {
  display: none;
}
</style>