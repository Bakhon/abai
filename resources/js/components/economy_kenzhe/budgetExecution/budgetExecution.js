import { slice } from "lodash";
import moment from "moment";
import dzoDataActual from './dzo_data_actual.json';
import dzoDataPrevYear from './dzo_data_prev_year.json';
export default {
  data: function () {
    return {
      dzoDataActual: dzoDataActual,
      dzoDataPrevYear: dzoDataPrevYear,
      params:{differenceBetweenMonths: "12", company: "7", reload: true},
      numbersOfMonths: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],  
      repttData: "0",
      dzoData: [],
      macroData: [],
      fullCompanyNames: [
        {
          code: 'ОМГ',
          title: this.trans('visualcenter.omg')          
        },
        {
          code: 'ЭМГ',
          title: this.trans('visualcenter.emg')        
        },
        {
          code: 'КГМ',
          title: this.trans('visualcenter.kgm')         
        },
        {
          code: 'ММГ',
          title: this.trans('visualcenter.mmg') 
        },
        {
          code: 'КТМ',
          title: this.trans('visualcenter.ktm')    
        },
        {
          code: 'КОА',
          title: this.trans('visualcenter.koa')         
        },
      ],
      dzoSelect: 'ALL',
      selectMonthFromBeginOfTheYearh: 0,
      selectMonth: 0,
      selectQuarter: 0,
      actualMonth: 0,
      selectActualMonth: 0,
      isNeedToChangeProperty: true,
      dateStart: '',
      dateEnd: '',
      factForOneDay:'30.01.2019',
    }
  },
  methods: {   
    getCompany() {  
      this.params['reload'] = true;
      return  axios.get('/ru/module_economy/company', {params: this.params})
      .then(response => {
      this.repttData = response.data;      
     });     
        
    },
    refreshData() {
      let uri = this.localeUrl("/getdzocalcs");
      let dateStart = (moment(this.dateStart).locale("en").format('MMM DD, YYYY'))  
      let dateEnd =(moment(this.dateEnd).locale("en").format('MMM DD, YYYY'))     
      let queryParams = {params: {'dateStart': dateStart, 'dateEnd': dateEnd}};
      this.$store.commit('globalloading/SET_LOADING',true);
      this.dzoData = [];
      this.macroData = [];
      if (this.dzoSelect !== 'ALL') {
        queryParams.params.dzo = this.dzoSelect;
      }   
    },
  },
  watch: {
    dzoSelect: function () {
      this.refreshData()
    },
    selectMonthFromBeginOfTheYearh: function (newValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, 0, 1);
        let dateEnd = new Date(2020, newValue, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.selectMonth = this.selectQuarter = this.selectActualMonth = 0;
      }
    },
    selectMonth: function (newValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, newValue - 1, 1);
        let dateEnd = new Date(2020, newValue, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.selectMonthFromBeginOfTheYearh = this.selectQuarter = this.selectActualMonth = 0;
      }
    },
    selectQuarter: function (newValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, newValue - 1, 1);
        let dateEnd = new Date(2020, newValue + 2, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.selectMonthFromBeginOfTheYearh = this.selectMonth = this.selectActualMonth = 0;
      }
    },
    selectActualMonth: function (newValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, this.actualMonth, 1);
        let dateEnd = new Date(2020, this.actualMonth + 1, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.selectMonthFromBeginOfTheYearh = this.selectMonth = this.selectQuarter = 0;
      }
    },

  },
  async created () {    
    await this.getCompany(); 
      this.axios
        .get('/ru/getdzocalcsactualmonth', {})
        .then(response => {
          if (response.data) {
            this.actualMonth = response.data - 1;
            this.selectActualMonth = 1;
          }
       })    
       console.log(this.getCompany());
  },  
}