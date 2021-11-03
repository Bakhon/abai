<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        <div class="data-analysis-left-block">
          <div class="left-block-collapse-holder">
            <div>
              <img
                src="/img/PlastFluids/chooseParameters.svg"
                alt="choose parameters icon"
              />
              <span>Параметры</span>
            </div>
          </div>
          <div class="dropdown-holder">
      
            <b-form-select  @change="onChangeWell" :options="wellList.data" ></b-form-select>
            

            <b-form-select   :options="wellDate.data" @change="onChangeWellDate"></b-form-select>
            
            
          </div>
          
        </div>
        
        <div class="tkrs-content">
            <div>
                <div class="hws-header">
                  <div class="hws-header-info">
                    <img class="hws-tab-img"
                    src="/img/tkrs/back.svg"
                    />
                    
                    <a class="hws-header-info-name back-icon"><img class="hws-tab-img"
                    src="/img/tkrs/brigada_table.svg"
                    />Бригада №11</a>
                    <a class="hws-header-info-name">Месторождение: 0</a>
                    <a class="hws-header-info-name">Скважина: 417</a>
                    <img class="hws-tab-img comp-charts-icon"
                    src="/img/tkrs/comparison-charts.svg"
                    />
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle input-form-dropdown calendar-form"  
                    type="button" id="dropdownMenuButton" data-toggle="dropdown" 
                    aria-haspopup="true" aria-expanded="false">{{trans('tkrs.sensors')}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">{{trans('tkrs.gps_positioning')}}</a>
                      <a class="dropdown-item" href="#">{{trans('tkrs.video_surveillance')}}</a>
                      <a class="dropdown-item" href="#">{{trans('tkrs.sensors')}}</a>
                    </div>
                  </div>
                  <button class="calendar-form">{{trans('tkrs.analyze_pv_npv')}}</button>
                  
                </div>
                <div class="plotly-graph-custom">
                <Plotly :data="areaChartData" :displaylogo="false" 
                :layout="layoutData" :display-mode-bar="true" 
                :mode-bar-buttons-to-remove="buttonsToRemove" v-if="isChart"></Plotly>
                </div>
                <div>
                    <div class="nav nav-tabs all-tabs">
                      <div style="display:flex">
                        <li class="nav-item">
                            <a class="nav-link active tab-header" 
                            @click="selectTab(1)" href="#">
                            <img class="hws-tab-img"
                              src="/img/tkrs/event.svg"
                              
                            /><a>{{trans('tkrs.event')}}</a></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab-header " 
                            @click="selectTab(2)" href="#">
                            <img class="hws-tab-img"
                              src="/img/tkrs/excess.svg"
                              
                            /><a>{{trans('tkrs.excess')}}</a></a>
                        </li>
                      </div>
                        <div class="header-hide-expand-buttons">
                          <button @click="cancelChat()">
                            <img
                              src="/img/PlastFluids/tableArrow.svg"
                              
                            /></button
                          ><button @click="returnChat()">
                            <img src="/img/PlastFluids/tableArrow.svg" />
                          </button>
                        </div>
                       
                    </div>

                  <div v-if="currentTab == 1">
                      <event></event>
                  </div>

                  <div v-if="currentTab == 2">
                      <excess></excess>
                  </div>


                </div>

            </div>

        </div>
    </div>
    
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import baseBlock from './baseBlock.vue';
import BaseTable from './BaseTable.vue';
import event from './tabs/event.vue';
import excess from './tabs/excess.vue';
import { Plotly } from 'vue-plotly'


export default {
  name: "hookWeightSensor",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    BaseTable,
    baseBlock,
    event,
    excess,
    Plotly,
  },
  computed: {
    layoutData() {
      return {
        width: 1550,
        height: 600,
        margin: {
    l: 50,
    r: 10,
    b: 30,
    t: 30,
    pad: 4
  },
        paper_bgcolor: "rgba(0,0,0,0)",
        plot_bgcolor: "rgba(0,0,0,0)",
        xaxis: {
          color: "#FFFFFF",
          title: 'Время',
          range: [this.minimum, this.maximum],
          type: 'date',
          rangeslider: true,
          showgrid: false
        
        },
        yaxis: {
          title: 'W (TC)',
          color: "#FFFFFF",
          linecolor: "#EF5350",
          showgrid: false
        },    
      };
    },
  },
  data(){
    return {
      currentTab: 1,
      calendarDate: '2020-06-17',
      Date1: null,
      areaChartData: [],
      buttonsToRemove: [
        'hoverClosestCartesian',
        'hoverCompareCartesian',
        'toggleSpikelines',
        'resetScale2d',
        'autoScale2d',
      ],

      isChart: true,
      wellList: [],
      wellDate: [],
      wellNumber: null,
      wellFile: null,
      maximum: null,
      minimum: null,
      
    }
  },
  created: async function () {
    this.$store.commit("globalloading/SET_LOADING", true);
    await this.axios
      .get(
          'http://172.20.103.203:8090/db1/'
        )
      .then((response) => {
        console.log("TEST2")  
        this.$store.commit("globalloading/SET_LOADING", false);
        let data = response.data;
        if (data) {
          this.areaChartData = data.data;
          this.maximum = data.data[0].rangeSlider.max;
          this.minimum = data.data[0].rangeSlider.min;
        } else {
          console.log("No data");
        }
        return Promise
      })
      .catch((error) => {
        console.log(error.data);
        this.$store.commit("globalloading/SET_LOADING", false);
      });
      this.getListWell();
    },
  
  methods: {
    onChangeWell(number) {
      this.wellNumber = number;
      this.postSelectedtWell();        
        
    },
    onChangeWellDate(number) {
      this.wellFile = number;
      this.postSelectedtWellFile();
    },
    getListWell() {
      
        this.axios
            .get(
                'http://172.20.103.203:8090/wellName/',
            )
            .then((response) => {
              
                let data = response.data;
                if (data) {
                    this.wellList = data;
                    
                } else {
                    console.log("No data");
                }
            });
    },
    postSelectedtWell() {
        this.axios
            .get(
                `http://172.20.103.203:8090/wellDates/${this.wellNumber}`,
            )
            .then((response) => {
                let data = response.data;
                if (data) {
                    this.wellDate = data;
                    
                } else {
                    console.log("No data");
                }
            });
    },
    postSelectedtWellFile() {
      this.$store.commit("globalloading/SET_LOADING", false);
        this.axios
            .get(
                `http://172.20.103.203:8090/chooseDate/${this.wellNumber}/${this.wellFile}/`,
            )
            .then((response) => {
              
                let data = response.data;
                if (data) {
                    this.wellDate = data;
                    this.areaChartData = data.data;
                    this.maximum = data.data[0].rangeSlider.max;
                    this.minimum = data.data[0].rangeSlider.min;
                    
                } else {
                    console.log("No data");
                }
            });
    },
    cancelChat() {
        this.isChart = false;
    },
    returnChat() {
      this.isChart = true;
    },
    
    selectTab(selectedTab) {
            this.currentTab = selectedTab
    },
    chooseDate() {
      const { calendarDate} = this;
      var Date1 = new Date(calendarDate)
      this.Date1 = Date1.toLocaleDateString();
      this.axios
        .get(
            'http://127.0.0.1:7580/db/' + Date1.toLocaleDateString("en-GB") + '/'
          )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          let data = response.data;
          if (data) {
            this.areaChartData = data.data;
          } else {
            console.log("No data");
          }
        })
    },
  },
};
</script>

<style  scoped lang='scss'>
.data-analysis-left-block {
  width: 249px;
  flex-shrink: 0;
  display: flex;
  flex-flow: column;
  height: 865px;
  background: #272953;
  color: #fff;
}

.left-block-collapse-holder {
  display: flex;
  width: 100%;
  height: 42px;
  background-color: #323370;
}

.left-block-collapse-holder > div {
  display: flex;
  height: 100%;
  width: calc(100% - 29px);
  align-items: center;
  background-color: #323370;
}

.left-block-collapse-holder > div > img {
  margin: 0 8px 0 10px;
}

.collapse-left__sidebar {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 29px;
  background: var(--a-accent);
  padding: 14px 6px;
  border-radius: 10px 0 0 10px;
  border: none;
  border-left: 5px solid #272953;
}

.dropdown-holder {
  background-color: rgba(255, 255, 255, 0.04);
  width: 100%;
  padding: 6px 6px 1px 6px;
  margin-bottom: 10px;
}
.tkrs-main {
  width: 100%;
  height: 100%;
}

.tkrs-content {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
  padding-left: 5px;
}
table {
  color: white;
  background: #333975;
}
table, th, td {
  border:1px solid black;
}
.all-tabs {
  background: #323370;
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 32px;
}
.tab-header {
  color: white !important;
}
.active {
  background: #2E50E9;
}
.nav-link.active {
  background: #2E50E9;
}

.js-plotly-plot .plotly .modebar {
    position: absolute;
    top: 22px;
    right: 2px;
}
.header-hide-expand-buttons {
  width: 42px;
  border: 1px solid #545580;
  border-radius: 4px;
  margin-left: 4px;
  height: 100%;
}

.header-hide-expand-buttons > button {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 50%;
  border: 1px solid #545580;
  background-color: #333975;
}

.header-hide-expand-buttons > button:nth-of-type(2) > img {
  transform: rotate(180deg);
}
.hws-tab-img {
  padding-right: 6px;
}
.hws-header {
  background: #323370;
  width: 100%;
  height: 37px;
  display: flex;
  justify-content: space-between;
}
.hws-header-info {
  padding-top: 7px;
}
.calendar {
  display: flex;
}
.hws-header-info-name {
  color: #ffff;
  padding-left: 53px;
  padding-top: 7px;
}
.back-icon {
  padding-left: 3px;
}
.calendar-form {
  background: #20274F;
  border: none;
  color: #ffff;
  padding-left: 14px;
  height: 33px
}
.calendar-input {
  color: #ffff;
}
.comp-charts-icon {
  padding-left: 22px;
}

.plotly-graph-custom {
  background-color: #2B2E5E !important;
  background-image: linear-gradient(#545580 1px, transparent 1px), 
  linear-gradient(90deg, #545580 1px, transparent 1px);
  background-size: 20px 20px, 20px 20px;
}
</style>