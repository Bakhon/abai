import mainMenu from "../../GTM/mock-data/main_menu.json";
import BtnDropdown from "../components/BtnDropdown";
import {rowsOil,rowsHorizon,horizons,actualIndicators} from '../json/data';
import apexchart from 'vue-apexcharts';

export default {
  name: 'CompareDrilling',

  components: {
    BtnDropdown,
    apexchart
  },

  data() {
    return {
      menu: mainMenu,
      parentType: '',
      horizonList: horizons,
      actualIndicators: actualIndicators,
      coincidences: [
        {
          id: 50,
          title: '50 м'
        },
        {
          id: 100,
          title: '100 м'
        },
        {
          id: 150,
          title: '150 м'
        }
      ],
      horizon: 12,
    }
  },

  computed: {
    getSelectedHorizon() {
      return this.horizon;
    },
    rowsOil() {
      return rowsOil;
    },
    rowsHorizon() {
      return rowsHorizon;
    },
    chartOptions() {
      return {
        colors: ["#009847", "#F27E31"],
        fill: {
          opacity: 1
        },
        stroke: {
          width: [2, 2]
        },
        legend: {
          horizontalAlign: "left",
          offsetX: 20
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: this.getYearList
        },
        toolbar: {
          show: false,
        }
      }
    },
    chartOptionsArea() {
      return {
        chart: {
          height: 350,
          type: 'area'
        },
        fill: {
          opacity: 1
        },
        stroke: {
          width: [1, 1]
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: this.getYearList
        },
      }
    },
    getYearList() {
      return ['2007','2008','2009','2010','2011','2012','2013','2014','2015','2016','2017','2018','2019','2020'];
    },
    series() {
      return [
        {
          name: 'Факт',
          data: [21, 23, 26, 33, 34, 39, 44, 44, 50, 56, 67, 73, 79, 88.5]
        },
        {
          name: "Проект",
          data: [10, 22, 24, 28, 32, 35, 40, 34, 40, 50, 60, 69, 70, 80]
        },
      ]
    },
    seriesArea() {
      return [
        {
          name: 'Факт',
          data: [231, 140, 328, 251, 142, 109, 100, 123, 209, 259, 399, 249, 123, 234, 350]
        }, {
          name: 'Проект',
          data: [114, 322, 245, 232, 434, 152, 241, 132, 100, 150, 234, 328, 294,245,214]
        }
      ]
    }
  },

  methods: {
    menuClick(data) {
      const path = window.location.pathname.slice(3);
      if (data?.url && data.url !== path) {
        window.location.href = this.localeUrl(data.url);
      }
    },
  }
}