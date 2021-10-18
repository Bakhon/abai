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
        ...this.generalOptions,
        colors: ["#009847", "#F27E31"],
        xaxis: {
          categories: this.getYearList,
          labels: {
            style: {
              colors: this.getColors(14, '#fff')
            }
          }
        },
        yaxis: {
          labels: {
            style: {
              colors: this.getColors(6, '#fff')
            }
          }
        },
        grid: this.getGrid
      }
    },
    chartOptionsArea() {
      return {
        ...this.generalOptions,
        xaxis: {
          categories: this.getYearList,
          labels: {
            style: {
              colors: this.getColors(14, '#fff')
            }
          }
        },
        yaxis: {
          labels: {
            style: {
              colors: this.getColors(7, '#fff')
            }
          }
        },
        grid: this.getGrid
      }
    },
    generalOptions() {
      return {
        fill: {
          opacity: 1
        },
        stroke: {
          width: [1, 1]
        },
        dataLabels: {
          enabled: false
        },
        legend:{
          labels: {
            colors: ['#FFFFFF']
          },
        },
      }
    },
    getGrid() {
      return {
        show: true,
        borderColor: '#454D7D',
        strokeDashArray: 0,
        position: 'back',
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: true
          },
        },
        row: {
          colors: ['transparent'],
          opacity: 0.5
        },
        column: {
          colors: ['transparent'],
          opacity: 0.5
        },
        padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
      }
    },
    getYearList() {
      const years = [];
      const currentYear = new Date().getFullYear();
      for (let i = 2007; i < currentYear; i++) {
        years.push(i);
      }
      return years.map(el => el.toString());
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
          data: [231, 140, 328, 251, 142, 109, 100, 123, 209, 259, 399, 249, 123, 234]
        }, {
          name: 'Проект',
          data: [114, 322, 245, 232, 434, 152, 241, 132, 100, 150, 234, 328, 294,245]
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
    getColors(count, color) {
      let colors = [];
      for (let i = 0; i < count; i++) {
        colors.push(color);
      }
      return colors;
    }
  }
}