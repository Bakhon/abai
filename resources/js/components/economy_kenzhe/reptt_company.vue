<template>
  <div>
    <div class="row">
      <div class="col-sm-4">
        <select name="company" v-model="company" @change="updateData('betweenMonthsValue')" class="form-control mb-3">
          <option v-for="company in repttData.companies" :value="company.id">{{company.name}}</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <select name="dateTo" v-model="betweenMonthsValue" @change="updateData('betweenMonthsValue')" class="form-control mb-3">
          <option v-for="month in betweenMonths" :value="month.value">{{month.title + ' ' +currentYear}}</option>
        </select>
      </div>
      <div class="col-sm-4">
        <select name="dateTo" v-model="monthsValue"  @change="updateData('monthsValue')"  class="form-control mb-3">
          <option v-for="month in months" :value="month.value">{{month.title + ' ' + currentYear}}</option>
        </select>
      </div>
      <div class="col-sm-4">
        <select name="dateTo" v-model="quarterValue"  @change="updateData( 'quarterValue')"  class="form-control mb-3">
          <option v-for="month in quarter" :value="month.value">{{month.title + ' ' + currentYear}}</option>
        </select>
      </div>
    </div>

    <el-table
        :data="repttData.reptt"
        :tree-props="defaultProps"
        style="width: 100%;"
        row-key="id"
        border
        :row-class-name="hideEmptyValues"
    >
      <el-table-column prop="name" :label="trans('economy_pf.repttTable.name')" min-width="400" :key="Math.random()">
      </el-table-column>
      <el-table-column prop="fact_value" :label="trans('economy_pf.repttTable.factZa')+' '+previousYear +trans('economy_pf.repttTable.year')" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.fact_value[previousYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="plan_value" :label="trans('economy_pf.repttTable.factZa') + ' ' + '30.01.19'" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.intermediate_fact_value[previousYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="fact_value" :label="trans('economy_pf.repttTable.planNa') + ' ' + currentYear +trans('economy_pf.repttTable.year')" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.plan_value[currentYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="plan_value" :label="trans('economy_pf.repttTable.plan') + ' ' + trans('economy_pf.repttTable.sinceTheBeginningOfTheYear')" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.intermediate_plan_value[currentYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="fact_value" :label="trans('economy_pf.repttTable.fact')" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.intermediate_fact_value[currentYear] }}
        </template>
      </el-table-column>
      <el-table-column :label="trans('economy_pf.repttTable.absDeviation')  +' '+ trans('economy_pf.repttTable.sinceTheBeginningOfTheYear') + ', +/-'">
        <template slot-scope="scope" v-if="scope.row">
          {{ absoluteDeviation(scope.row.plan_value[currentYear], scope.row.fact_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column :label="trans('economy_pf.repttTable.relativeDeviation') +' '+ trans('economy_pf.repttTable.sinceTheBeginningOfTheYear') + ', %'">
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
        repttData: this.dataReptt,
        defaultProps: {
          id: "id",
          children: "handbook_items",
        },
        tableHeader: [
          {
            label: this.trans('economy_pf.repttTable.name'),
            prop: 'name'
          }, {
            label: this.trans('economy_pf.repttTable.planNa') + this.trans('economy_pf.repttTable.january'),
            prop: 'value'
          }
        ],
        betweenMonthsValue: '01',
        monthsValue: '00',
        quarterValue: '01',
        company: '116',
          betweenMonths:[
              {title: this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear'), value: '01'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.1'), value: '02'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.2'), value: '03'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.3'), value: '04'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.4'), value: '05'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.5'), value: '06'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.6'), value: '07'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.7'), value: '08'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.8'), value: '09'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.9'), value: '10'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.10'), value: '11'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.11'), value: '12'},
          ],
          months:[
              {title: this.trans('economy_pf.perMonth'), value: '00'},
              {title: this.trans('economy_pf.months.0'), value: '01'},
              {title: this.trans('economy_pf.months.1'), value: '02'},
              {title: this.trans('economy_pf.months.2'), value: '03'},
              {title: this.trans('economy_pf.months.3'), value: '04'},
              {title: this.trans('economy_pf.months.4'), value: '05'},
              {title: this.trans('economy_pf.months.5'), value: '06'},
              {title: this.trans('economy_pf.months.6'), value: '07'},
              {title: this.trans('economy_pf.months.7'), value: '08'},
              {title: this.trans('economy_pf.months.8'), value: '09'},
              {title: this.trans('economy_pf.months.9'), value: '10'},
              {title: this.trans('economy_pf.months.10'), value: '11'},
              {title: this.trans('economy_pf.months.11'), value: '12'},
          ],
          quarter: [
              {title: this.trans('economy_pf.quarter'), value: '01'},
              {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.2'), value: '03'},
              {title: this.trans('economy_pf.months.3')+' - '+this.trans('economy_pf.months.5'), value: '06'},
              {title: this.trans('economy_pf.months.6')+' - '+this.trans('economy_pf.months.8'), value: '09'},
              {title: this.trans('economy_pf.months.9')+' - '+this.trans('economy_pf.months.11'), value: '12'},        
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
        this.repttData.reptt.reduce(function x(r, a) {
          let hasChild = a.handbook_items.length > 0;
          let yearValue = a[attributeName][year];
          if(yearValue < 0){
            a[attributeName][year] = yearValue * -1
          }
          if(hasChild){
            a[attributeName][year] = a.handbook_items.reduce(x, 0)
          }
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
      },
      updateData(attributeName){
          axios.get('/module_economy/company?'+attributeName+'='+this[attributeName]+'&company='+this.company).then(response => {
              this.repttData = response.data;
              this.recalculate();
          });
      },
      recalculate(){
        let handbookKeys = ['plan_value', 'fact_value', 'intermediate_plan_value', 'intermediate_fact_value'];
        handbookKeys.forEach(key => {
          this.distributionSumOverTree(key, this.currentYear);
          this.distributionSumOverTree(key, this.previousYear);
        });
      }
    },
    mounted() {
      this.recalculate();
      console.log(this.dataReptt);
    },
  };
</script>