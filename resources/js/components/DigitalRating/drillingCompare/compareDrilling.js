import mainMenu from "../../GTM/mock-data/main_menu.json";
import BtnDropdown from "../components/BtnDropdown";
import {rowsHorizon,horizons,actualIndicators} from '../json/data';
import apexchart from 'vue-apexcharts';
import maps from '../mixins/maps.js';
import wellList from "../json/wells/13.json";
import owcList from '../json/owc_out_uzn_13_osn.json'

export default {
  name: 'CompareDrilling',

  components: {
    BtnDropdown,
    apexchart
  },

  mixins: [maps],

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
      horizon: 13,
      year: 2008,
      type: 'oil_production',
      rowsOil: [],
      indicatorTitle: 'Добыча нефти, тыс.т',
      diagramData: [],
    }
  },

  async created() {
    await this.fetchData();
  },

  async mounted() {
    await this.initMap('wellMap');
    await this.initWellOnMap();
    await this.initContourOnMap();
  },

  watch: {
    type() {
      this.fetchData();
    }
  },

  computed: {
    getSelectedHorizon() {
      return this.horizon;
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
            },
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
  },

  methods: {
    async fetchData() {
      const res = await axios.get(this.localeUrl(
        `digital-rating/api/get_compaer_data?horizon=${this.horizon}&year=${this.year}&type=${this.type}`
      ));
      if (!res.error) {
        this.rowsOil = res.data;
        this.setDiagramData(res.data);
      }
    },

    setDiagramData(data) {
      this.diagramData = [];
      const obj1 = {};
      obj1['name'] = 'Факт';
      obj1['data'] = data.map(el => el.actual);
      const obj2 = {};
      obj2['name'] = 'Проект';
      obj2['data'] = data.map(el => el.project);
      this.diagramData.push(obj1, obj2);
    },

    initWellOnMap() {
      for(let i = 0; i < wellList.length; i++) {
        const coordinate = this.xy(wellList[i]['x'], wellList[i]['y']);
        switch (wellList[i]['type']) {
          case 1:
            this.setCircleMarker(coordinate, wellList[i]['well'], '#fcad00');
            break;
          case 4:
            this.setTriangleMarker(coordinate, wellList[i]['well'], '#fcad00');
            break;
        }
      }
    },

    initContourOnMap() {
      for (let i = 0; i < owcList.length; i++) {
        owcList[i].reverse();
      }

      L.polyline(owcList, {
        renderer: this.renderer,
        color: 'white',
        weight: 1,
        smoothFactor: 1
      }).addTo(this.map);
    },

    getColors(count, color) {
      let colors = [];
      for (let i = 0; i < count; i++) {
        colors.push(color);
      }
      return colors;
    },

    handleSelectIndicator(indicator) {
      this.indicatorTitle = indicator.title;
      if (indicator?.value) {
        this.type = indicator.value;
      }
    },
  }
}