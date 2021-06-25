import { slice } from "lodash";
import moment from "moment";

export default {
  data: function () {
    return {   
      currentYearForCalculation: 2020,
      params:{},
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
      numberOfMonthsSelectedFromYearBegginning: 0,
      numberOfMonthsSelected: 0,
      numberOfQuaterSelected: 0,
      numberOfActualMonth: 0,
      numberOfMonths: 0,   
      isNeedToChangeProperty: true,
      dateStart: '',
      dateEnd: '',
      factForOneDay:'30.01.2019',
    }
  },
  methods: {   
   
    getCompany() {
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
    numberOfMonthsSelectedFromYearBegginning: function (newValue) {
      if (newValue === 0) {
        return
      }
        this.dateStart = new Date(2020, 0, 1);
        this.dateEnd = new Date(2020, newValue, 1);    
        this.refreshData();
        this.numberOfMonthsSelected = 0;
        this.numberOfQuaterSelected = 0;
        this.numberOfMonths = 0;      
    },
    numberOfMonthsSelected: function (newValue) {
      if (newValue === 0) {
        return
      }
        this.dateStart = new Date(2020, newValue - 1, 1);
        this.dateEnd = new Date(2020, newValue, 1);
        this.refreshData();
        this.numberOfMonthsSelectedFromYearBegginning= 0;
        this.numberOfQuaterSelected = 0;
        this.numberOfMonths = 0;
      
    },
    numberOfQuaterSelected: function (newValue) {
      if (newValue === 0) {
        return
      }
        this.dateStart = new Date(2020, newValue - 1, 1);
        this.dateEnd = new Date(2020, newValue + 2, 1);
        this.refreshData();
        this.numberOfMonthsSelectedFromYearBegginning= 0;
        this.numberOfMonthsSelected = 0;
        this.numberOfMonths = 0;      
    },
    numberOfMonths: function (newValue) {
      if (newValue === 0) {
        return
      }
        this.dateStart = new Date(2020, this.numberOfActualMonth, 1);
        this.dateEnd = new Date(2020, this.numberOfActualMonth + 1, 1);
        this.refreshData();
        this.numberOfMonthsSelectedFromYearBegginning= 0;
        this.numberOfMonthsSelected = 0;
        this.numberOfQuaterSelected = 0;      
    },

  },
  async created () {    
    await this.getCompany(); 
      this.axios
        .get('/ru/getdzocalcsactualmonth', {})
        .then(response => {
          if (response.data) {
            this.numberOfActualMonth = response.data - 1;
            this.numberOfMonths = 1;
          }
       })       
  },  
}