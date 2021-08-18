<template>
  <div>
    <el-table
      header-row-class-name="reptt-header"
      :data="dataReptt.reptt"
      :tree-props="defaultProps"
      style="width: 100%;"
      row-key="id"
      border    
      :cell-class-name="getChangedColumnClass"
      :header-cell-class-name="getChangedColumnClass"
      :row-class-name="hideEmptyValues"
      class="reptt"
    >
      <el-table-column
        prop="name"
        :label="this.trans('economy_pf.repttTable.name')"
        :min-width="55"
        :key="Math.random()" 
      >
      </el-table-column>
       <el-table-column       
        prop="unit"
        :formatter = "stateFormat"
        :label="this.trans('economy_pf.repttTable.unit')"
        :min-width="10"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{ unit }}
        </template>
      </el-table-column>
      <el-table-column
        prop="plan_value"
        :label="col2Reptt"
        :min-width="10"
        :key="Math.random()"
      >
           <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        :label="col3Reptt"
        :min-width="10"
        :key="Math.random()"
      >
        <template slot-scope="scope" v-if="scope.row">
          {{formatter( scope.row.fact_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="plan_value"
        :label="col4Reptt"
        :min-width="10"
        :key="Math.random()"
      >
          <template slot-scope="scope" v-if="scope.row">
          {{
           formatter( getAbsoluteDeviation(
              scope.row.plan_value[currentYear],
              scope.row.fact_value[currentYear]
            ))
          }}
        </template>
      </el-table-column>
      <el-table-column
        prop="fact_value"
        :label="col5Reptt"
        :min-width="10"
        :key="Math.random()"
      >
         <template slot-scope="scope" v-if="scope.row">
          {{
            getRelativeDeviation(
              scope.row.plan_value[currentYear],
              scope.row.fact_value[currentYear]
            )
          }}
        </template>
      </el-table-column>
      <el-table-column
        prop="plan_value"
        :label="col6Reptt"
        :min-width="10"
        :key="Math.random()"
      >
         0
      </el-table-column>
      <el-table-column
        prop="fact_value"
        :label="col7Reptt"
        :min-width="10"
        :key="Math.random()"
      >
         0
      </el-table-column>
      <el-table-column :label="col8Reptt" :min-width="10">
        <template slot-scope="scope" v-if="scope.row">
         0
        </template>
      </el-table-column>
      <el-table-column :label="col9Reptt" :min-width="10">
        <template slot-scope="scope" v-if="scope.row">
         0
        </template>
      </el-table-column>
       <el-table-column :label="col10Reptt" :min-width="10">
        <template slot-scope="scope" v-if="scope.row">
         0
        </template>
      </el-table-column>
       <el-table-column :label="col11Reptt" :min-width="10">
        <template slot-scope="scope" v-if="scope.row">
         0
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script src="./reptt_company2.js"></script>
