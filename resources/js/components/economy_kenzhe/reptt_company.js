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
      differenceBetweenMonths: '01',
      monthsValue: '00',
      quarterValue: '01',
      company: '7',
        betweenMonths: this.listBetweenMonths(),       
        months: this.listMonths(),         
        quarter: [
            {title: this.trans('economy_pf.quarter'), value: '01'},
            {title: this.trans('economy_pf.months.0')+' - '+this.trans('economy_pf.months.2'), value: '03'},
            {title: this.trans('economy_pf.months.3')+' - '+this.trans('economy_pf.months.5'), value: '06'},
            {title: this.trans('economy_pf.months.6')+' - '+this.trans('economy_pf.months.8'), value: '09'},
            {title: this.trans('economy_pf.months.9')+' - '+this.trans('economy_pf.months.11'), value: '12'},        
        ],
        params: {}
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
      if (obj.columnIndex > 4) {
          return 'reptt-column-blue reptt-cell'
      } else {
          return obj.columnIndex === 0 ? 'reptt-column-zero reptt-column reptt-cell' : 'reptt-column reptt-cell';
      }
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
      return (Math.abs(currentYearPlanValue - currentYearFactValue)).toFixed(1);
    },
    relativeDeviation(currentYearPlanValue, currentYearFactValue) {
      let result = (Math.abs(currentYearPlanValue - currentYearFactValue) / currentYearPlanValue * 100).toFixed(1);
      if (isNaN(result) || !isFinite(result)) {
        return 0;
      }
      return result;
    },
    updateData(attributeName){         
      for (var param in this.params) delete this.params[param];
      this.params[attributeName] = this[attributeName];
      this.params['company'] = this.company;
      this.params['reload'] = true;       
        axios.get('/ru/module_economy/company', {params: this.params})
            .then(response => {
            this.repttData = response.data;
            this.recalculate();
        });
    },
    recalculate(){
      let handbookKeys = ['plan_value', 'fact_value', 'intermediate_plan_value', 'intermediate_fact_value'];
      handbookKeys.forEach(key => {
        this.distributionSumOverTree(key, this.repttData.currentYear);
        this.distributionSumOverTree(key, this.repttData.previousYear);
      });
    },
    formatter: (data) => {
      data=data / 1000    
            return  data.toLocaleString();  
     },

    pad(d) {
      return (d < 10) ? '0' + d.toString() : d.toString();
    },  

    listBetweenMonths() {
      let arr = [ {title: this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear'), value: '01'},
                  {title: this.trans('economy_pf.months.0')+' - '+ this.trans('economy_pf.months.1'), value: '02'}];
      for (let i = 2; i < 12; i++) {
          arr.push({
            title: this.trans('economy_pf.months.0')+' - '+ this.trans('economy_pf.months.' + (i)),
              value: (this.pad(i + 1))
          });
      } 
      return arr;
    },

    listMonths() {
      let arr = [{title: this.trans('economy_pf.perMonth'), value: '00'}];
      for (let i = 0; i < 12; i++) {
          arr.push({
              title: this.trans('economy_pf.months.' + i),
              value: (this.pad(i + 1))
          });
      } 
      return arr;
    },
},
  mounted() {    
    let yearLast = 2019;
    let day = "30.01.19";
    let yearNow = 2020;
    this.col3Reptt = this.trans('economy_pf.repttTable.factNa') + ' \n' + yearLast + ' ' + this.trans('economy_pf.repttTable.year');
    this.col4Reptt = this.trans('economy_pf.repttTable.factNa') + ' \n' + day;
    this.col5Reptt = this.trans('economy_pf.repttTable.planNa') + ' \n ' + yearNow + ' ' + this.trans('economy_pf.repttTable.year');
    this.col6Reptt = this.trans('economy_pf.repttTable.plan') + ' \n' + this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear');
    this.col7Reptt = this.trans('economy_pf.repttTable.fact') + ' \n' + this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear');
    this.col8Reptt = this.trans('economy_pf.repttTable.absDeviation') + ' \n ' + this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear') +', +/-';
    this.col9Reptt = this.trans('economy_pf.repttTable.relativeDeviation') + ' \n' + this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear') +', %';
    let handbookKeys = ['plan_value', 'fact_value', 'intermediate_plan_value', 'intermediate_fact_value'];
    
  handbookKeys.forEach(key => {
    this.distributionSumOverTree(key, this.currentYear);
    this.distributionSumOverTree(key, this.previousYear);
  });
    
  this.$store.commit('globalloading/SET_LOADING', false);
   this.recalculate();     
    },
};