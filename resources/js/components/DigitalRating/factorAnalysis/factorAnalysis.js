import apexchart from 'vue-apexcharts';
import BtnDropdown from "../components/BtnDropdown";
import mainMenu from "../../GTM/mock-data/main_menu.json";
import {analysis, factorTableHeads, factorRows} from '../json/data';

export default {
  name: "factorAnalysis",

  components: {
    BtnDropdown,
    apexchart
  },

  data() {
    return {
      menu: mainMenu,
      parentType: '',
      analysis: analysis,
      donutChartData: [45, 60, 12, 34],
      barChartData: [
        {
          name: '',
          data: [324.4, -21.4, -48.2, 78.3, -15.2, 251.3]
        }
      ],
      year: 2007
    }
  },

  computed: {
    tableHead() {
      return factorTableHeads;
    },
    rows() {
      return factorRows;
    },
    barChartOptions() {
      return {
        chart: {
          type: 'bar',
          foreColor: '#fff',
        },
        xaxis: {
          categories: [
            'Проект', 'Добыв.фонд', 'Дебит нефти', 'Обводненность', 'Др.факторы', 'Факт'
          ],
        },
        yaxis: {
          labels: {
            formatter: (val) => val.toFixed(0)
          },
        },
        grid: {
          show: false,
        },
        dataLabels: {
          enabled: false
        },
        plotOptions: {
          bar: {
            colors: {
              ranges: [
              {
                from: -1000,
                to: 0,
                color: '#F27E31'
              },
              {
                from: 0,
                to: 300,
                color: '#4CAF50'
              },
              {
                from: 301,
                to: 1000,
                color: '#F0AD81'
              }]
            },
            columnWidth: '50%',
          }
        },
      }
    },
    donutChartOptions() {
      return {
        chart: {
          type: 'donut',
          foreColor: '#fff',
        },
        plotOptions: {
          donut: {
            size: '1%'
          }
        },
        labels: ['Добывающий фонд', 'Дебит нефти', 'Обводненность', 'Др. факторы'],
        colors: ['#4CAF50', '#F0AD81', '#3F51B5', '#EF5350'],
        stroke: {
          show: false,
        }
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
  },

  methods: {
    handleSelectAnalysis() {

    },
    handleSelectYear(year) {
      this.year = year;
    },
    getColor(item) {
      if (item > 0) return '#00A859';
      return '#ED3237';
    },
    getIcon(item) {
      if (item > 0) {
        return '<i className="fas fa-caret-down" style="color: #ED3237; margin-right: 4px;"/>';
      }
      return '<i className="fas fa-caret-up" style="color: #00A859; margin-right: 4px;"/>';
    },
    menuClick(data) {
      const path = window.location.pathname.slice(3);
      if (data?.url && data.url !== path) {
        window.location.href = this.localeUrl(data.url);
      }
    },
  }
}