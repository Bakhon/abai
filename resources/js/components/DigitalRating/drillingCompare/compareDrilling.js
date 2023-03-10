import apexchart from 'vue-apexcharts';
import mainMenu from "../../GTM/mock-data/main_menu.json";
import BtnDropdown from "../components/BtnDropdown";
import {rowsHorizon,actualIndicators,objectList} from '../json/data';
import maps from '../mixins/maps.js';
import wellList from "../json/wells/13.json";
import owcList from '../json/owc_out_uzn_13_osn.json';
import { globalloadingMutations } from '@store/helpers';

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
      horizonList: objectList,
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
      type: 'fds_operational_unit',
      rowsOil: [],
      indicatorTitle: 'Добыча нефти, тыс.т',
      diagramData: [],
      owcList: [],
      show: false
    }
  },

  async mounted() {
    await this.fetchHorizons();
    await this.fetchData();
    await this.initMap('wellMap');
    await this.initWellOnMap();
    await this.initContourOnMap();
    await this.initLegends();
  },

  watch: {
    type() {
      this.fetchData();
    },
    horizon() {
      this.fetchData();
    },
    year() {
      this.fetchData();
    }
  },

  computed: {
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
            formatter: (val) => val.toFixed(0)
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
            },
            formatter: (val) => val.toFixed(0)
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
      try {
        this.SET_LOADING(true);
        const res = await axios({
          url: this.localeUrl(`digital-rating/api/get-compare-data`),
          params: {
            horizon: this.horizon,
            year: this.year,
            type: this.type
          }
        });
        this.rowsOil = res.data;
        this.setDiagramData(res.data);
      } finally {
        this.SET_LOADING(false);
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

    async fetchHorizons() {
      try {
        const res = await axios.get(this.localeUrl(`digital-rating/api/get-horizon`));
      } catch (error) {
        console.error(error);
      }
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

    async initContourOnMap() {
      const res = await axios({
        url: this.localeUrl(`digital-rating/api/get-map-coordinates`),
        params: {
          field: 'kmb',
          horizon: '14',
          owc: 'owc_out_kmb_14_vost'
        }
      });
      if (!res.error) {
        this.owcList = res?.data[0]?.coordinates;

        for (let i = 0; i < owcList.length; i++) {
          owcList[i].reverse();
        }
        L.polyline(owcList, {
          renderer: this.renderer,
          color: 'white',
          weight: 1,
          smoothFactor: 1
        }).addTo(this.map);
      }
    },

    initLegends() {
      const legend = L.control({ position: "bottomleft" });

      legend.onAdd = function() {
        let div = L.DomUtil.create("div", "legend");
        div.innerHTML += '<i class="far fa-circle" style="color: #fcad00"></i>' +
          '<span> - Проектная добывающая скважина</span><br>';
        div.innerHTML += '<div id="triangle" style="display: inline-block;\n' +
          'width: 0;\n' +
          'height: 0;\n' +
          'border-style: solid;\n' +
          'border-width: 0 7px 7px 7px;\n' +
          'border-color: transparent transparent #fcad00 transparent;"></div>' +
          '<span> - Проектная нагнетательная скважина</span>';
        return div;
      };

      legend.addTo(this.map);
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

    handleSelectHorizon(horizon) {
      this.horizon = horizon?.id;
    },

    handleSelectYear(year) {
      this.year = year;
    },

    ...globalloadingMutations([
      'SET_LOADING'
    ]),

    getChildren(item) {
      return item?.children?.length;
    },
  }
}