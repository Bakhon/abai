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
      header-row-class-name="reptt-header"
      :data="repttData.reptt"
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
        prop="unit"
        :label="col3Reptt"
        :min-width="10"
        :key="Math.random()"
      >
</el-table-column>

  
      <el-table-column prop="plan_value" :label="trans('economy_pf.repttTable.factZa') + ' ' + '30.01.19'" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_fact_value[previousYear]) }}
        </template>
      </el-table-column>
      <el-table-column prop="fact_value" :label="trans('economy_pf.repttTable.planNa') + ' ' + currentYear +trans('economy_pf.repttTable.year')" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column prop="plan_value" :label="trans('economy_pf.repttTable.plan') + ' ' + trans('economy_pf.repttTable.sinceTheBeginningOfTheYear')" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ formatter(scope.row.intermediate_plan_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column prop="fact_value" :label="trans('economy_pf.repttTable.fact')" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{formatter( scope.row.intermediate_fact_value[currentYear]) }}
        </template>
      </el-table-column>
      <el-table-column :label="trans('economy_pf.repttTable.absDeviation')  +' '+ trans('economy_pf.repttTable.sinceTheBeginningOfTheYear') + ', +/-'">
        <template slot-scope="scope" v-if="scope.row">
          {{
            formatter(absoluteDeviation(
              scope.row.plan_value[currentYear],
              scope.row.fact_value[currentYear]
            ))
          }}
        </template>
      </el-table-column>
      <el-table-column :label="trans('economy_pf.repttTable.relativeDeviation') +' '+ trans('economy_pf.repttTable.sinceTheBeginningOfTheYear') + ', %'">
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
<!--<script src="./reptt_company.js"></script>-->
<style scoped>
.el-table .hidden-row {
  display: none;
}
</style>
<script>
  export default {
    props: ["dataReptt"],
    data() {
      return {
        col3Reptt: '',
      col4Reptt: '',
      col5Reptt: '',
      col6Reptt: '',
      col7Reptt: '',
      col8Reptt: '',
      col9Reptt: '',
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
        return this.repttData.currentYear
      },
      previousYear: function () {
        return this.repttData.previousYear
      }
    },
    methods: {
        changeColumn(obj) {
      if (obj.columnIndex > 4) { return 'reptt-column-blue reptt-cell' } else
        return obj.columnIndex === 0 ? 'reptt-column-zero reptt-column reptt-cell' : 'reptt-column reptt-cell';
    },
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
      },
       formatter: (data) => {
   data=data / 1000000000  
   data= data.toLocaleString();
      return  data
    
    }
    },
    updated() {     
      console.log(this.dataReptt);
    let yearLast = 2019;
    let day = "30.01.19";
    let yearNow = 2020;
    this.col3Reptt = this.trans('economics.factZa') + ' \n' + yearLast + ' ' + this.trans('economics.year');
    this.col4Reptt = this.trans('economics.factZa') + ' \n' + day;
    this.col5Reptt = this.trans('economics.planNa') + ' \n' + yearNow;
    this.col6Reptt = this.trans('economics.plan') + ' \n' + this.trans('economics.sinceTheBeginningOfTheYear');
    this.col7Reptt = this.trans('economics.fact') + ' \n' + this.trans('economics.sinceTheBeginningOfTheYear');
    this.col8Reptt = this.trans('economics.absDeviation') + ' \n ' + this.trans('economics.sinceTheBeginningOfTheYear'); +', +/-';
    this.col9Reptt = this.trans('economics.relativeDeviation') + ' \n' + this.trans('economics.sinceTheBeginningOfTheYear'); +', %';
    let handbookKeys = ['plan_value', 'fact_value', 'intermediate_plan_value', 'intermediate_fact_value'];
    handbookKeys.forEach(key => {
      this.distributionSumOverTree(key, this.currentYear);
      this.distributionSumOverTree(key, this.previousYear);
    });
     
    this.$store.commit('globalloading/SET_LOADING', false);
     this.recalculate();     
      },
  };
</script>
