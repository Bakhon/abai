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
    changeColumn(obj) {
      if (obj.columnIndex > 4) { return 'reptt-column-blue reptt-cell' } else
        return obj.columnIndex === 0 ? 'reptt-column-zero reptt-column reptt-cell' : 'reptt-column reptt-cell';
    },

    hideEmptyValues: function (row, index) {
      if (row.row.plan_value[this.currentYear] === 0 && row.row.level !== 0) {
        return 'hidden-row';
      }
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
    formatter: (data) => {
   data=data / 1000000000  
   data= data.toLocaleString();
      return  data
    
    }
  },
  updated() {
    console.log(new Intl.NumberFormat("ru-RU").format('1000000000'));
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
  },
};
