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
          <option v-for="month in betweenMonths" :value="month.value">{{month.title + currentYear}}</option>
        </select>
      </div>
      <div class="col-sm-4">
        <select name="dateTo" v-model="monthsValue"  @change="updateData('monthsValue')"  class="form-control mb-3">
          <option v-for="month in months" :value="month.value">{{month.title + currentYear}}</option>
        </select>
      </div>
      <div class="col-sm-4">
        <select name="dateTo" v-model="quarterValue"  @change="updateData( 'quarterValue')"  class="form-control mb-3">
          <option v-for="month in quarter" :value="month.value">{{month.title + currentYear}}</option>
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
      <el-table-column prop="name" label="Наименование" min-width="400" :key="Math.random()">
      </el-table-column>
      <el-table-column prop="fact_value" :label="'Факт за '+ previousYear +' год'" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.fact_value[previousYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="plan_value" label="Факт за 30.01.19" width="200" :key="Math.random()">
        <template slot-scope="scope" v-if="scope.row">
          {{ scope.row.intermediate_fact_value[previousYear] }}
        </template>
      </el-table-column>
      <el-table-column prop="fact_value" :label="'План на '+ currentYear +' год'" width="200" :key="Math.random()">
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
        repttData: this.dataReptt,
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
        ],
        betweenMonthsValue: '01',
        monthsValue: '00',
        quarterValue: '01',
        company: '116',
          betweenMonths:[
              {title:'С началао года ', value: '01'},
              {title:'Январь - Февраль ', value: '02'},
              {title:'Январь - Март ', value: '03'},
              {title:'Январь - Апрель ', value: '04'},
              {title:'Январь - Май ', value: '05'},
              {title:'Январь - Июнь ', value: '06'},
              {title:'Январь - Июль ', value: '07'},
              {title:'Январь - Август ', value: '08'},
              {title:'Январь - Сентябрь ', value: '09'},
              {title:'Январь - Октябрь ', value: '10'},
              {title:'Январь - Ноябрь ', value: '11'},
              {title:'Январь - Декабрь ', value: '12'},
          ],
          months:[
              {title:'За месяц ', value: '00'},
              {title:'Январь ', value: '01'},
              {title:'Февраль ', value: '02'},
              {title:'Март ', value: '03'},
              {title:'Апрель ', value: '04'},
              {title:'Май ', value: '05'},
              {title:'Июнь ', value: '06'},
              {title:'Июль ', value: '07'},
              {title:'Август ', value: '08'},
              {title:'Сентябрь ', value: '09'},
              {title:'Октябрь ', value: '10'},
              {title:'Ноябрь ', value: '11'},
              {title:'Декабрь ', value: '12'},
          ],
          quarter: [
              {title:'Квартал ', value: '01'},
              {title:'Январь - Март ', value: '03'},
              {title:'Апрель - Июнь ', value: '06'},
              {title:'Июль - Сентябрь ', value: '9'},
              {title:'Октябрь - Декабрь ', value: '12'},
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
          axios.get('/ru/module_economy/company?'+attributeName+'='+this[attributeName]).then(response => {
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
    },
  };
</script>