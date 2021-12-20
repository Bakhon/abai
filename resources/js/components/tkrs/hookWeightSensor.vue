<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        <div class="data-analysis-left-block">
          <div class="left-block-collapse-holder">
            <div>

              <div class="nav nav-tabs all-tabs">
                <div style="display:flex; width: 249px;">
                  <li class="nav-item">
                      <a class="nav-link active tab-lblock-header" 
                      @click="selectBlockTab(1)" href="#">
                      <a>{{trans('tkrs.current_work')}}</a></a>
                  </li>
                  <li class="nav-item" style="width: 107px;">
                      <a class="nav-link tab-lblock-header" 
                      @click="selectBlockTab(2)" href="#">
                      <a>{{trans('tkrs.archive')}}</a></a>
                  </li>
                </div>
              </div>
             
            </div>
          </div>
          <div class="dropdown-holder">
            <b-dropdown>
              <template #button-content>
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6 0C2.7 0 0 2.7 0 6C0 9.3 2.7 12 6 12C9.3 12 12 9.3 12 6C12 2.7 9.3 0 6 0ZM6 11.2714C3.08571 11.2714 0.771429 8.91429 0.771429 6C0.771429 3.08571 3.08571 0.771429 6 0.771429C8.91429 0.771429 11.2714 3.08571 11.2714 6C11.2714 8.91429 8.91429 11.2714 6 11.2714Z" fill="#868BB2"/>
<path d="M5.99799 9.04286C6.42404 9.04286 6.76942 8.69748 6.76942 8.27143C6.76942 7.84538 6.42404 7.5 5.99799 7.5C5.57194 7.5 5.22656 7.84538 5.22656 8.27143C5.22656 8.69748 5.57194 9.04286 5.99799 9.04286Z" fill="#868BB2"/>
<path d="M5.99799 4.54286C6.42404 4.54286 6.76942 4.19748 6.76942 3.77143C6.76942 3.34538 6.42404 3 5.99799 3C5.57194 3 5.22656 3.34538 5.22656 3.77143C5.22656 4.19748 5.57194 4.54286 5.99799 4.54286Z" fill="#868BB2"/>
<path d="M5.99799 6.77137C6.42404 6.77137 6.76942 6.42599 6.76942 5.99994C6.76942 5.5739 6.42404 5.22852 5.99799 5.22852C5.57194 5.22852 5.22656 5.5739 5.22656 5.99994C5.22656 6.42599 5.57194 6.77137 5.99799 6.77137Z" fill="#868BB2"/>
</svg>
<a>Бригада/Скважина</a>
              </template>
              <b-dropdown-item href="#">Бригада</b-dropdown-item>
              <b-dropdown-item href="#">Скважина</b-dropdown-item>
            </b-dropdown>
            <div class="line-block"></div>
            <div class="tab-archive-div" v-if="currentBlockTab == 1">
                  <currentWorkHook v-for="template in wellsTreeCurrent"
            :key="template.well_name" :template="template"></currentWorkHook>
              </div>

              <div class="tab-archive-div" v-if="currentBlockTab == 2">
                  <archWorkHook v-for="template in wellsTree"
            :key="template.year" type="year" :template="template"></archWorkHook>
              </div>
         
          </div>
          
        </div>
        
        <div class="tkrs-content">
            <div class="tkrs-content-down">
                <div class="hws-header">
                  <div class="hws-header-info">
                    <a href="tkrsMain" class="back-a"><img class="hws-tab-img"
                    src="/img/tkrs/back.svg"
                    /></a>
                    
                    <a class="hws-header-info-name back-icon"><img class="hws-tab-img"
                    src="/img/tkrs/brigada_table.svg"
                    />Бригада №11</a>
                    <a class="hws-header-info-name">Месторождение: 0</a>
                    <a class="hws-header-info-name">Скважина: 417</a>
                    <img class="hws-tab-img comp-charts-icon" 
                    @click="comparison_graphs()" data-toggle="modal" 
                    data-target="#exampleModalCenter"
                    src="/img/tkrs/comparison-charts.svg"
                    />
                  </div>
                  <div class="dropdown analyze-div">
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
                  <div class="analyze-div">
                    <button class="calendar-form">
                      <a class="a-link" href="hookWeightSensorAnalyse">{{trans('tkrs.analyze_pv_npv')}}
          </a>
                    </button>
                  </div>
                  
                </div>
                <div class="plotly-graph">
                </div>
                <div class="plotly-graph-custom">
                  <Plotly 
                    :data="areaChartData" 
                    :displaylogo="false" 
                    :layout="layoutData" 
                    :display-mode-bar="true" 
                    :mode-bar-buttons-to-remove="buttonsToRemove" 
                    v-if="isChart">
                  </Plotly>
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
                      <event :table_work="table_work"></event>
                  </div>

                  <div v-if="currentTab == 2">
                      <excess></excess>
                  </div>


                </div>

            </div>

        </div>
    </div>
    <modal name="comparison_graphs" :width="560" :height="220"  :adaptive="true" style="z-index:9900000; ">
                <div class="main_modals" style="background: #272953;  height:100%; border: 3px solid #656A8A;">
                  <a class="comparison-graphs">{{trans('tkrs.comparison_graphs')}}</a>

                </div>
    </modal>
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import baseBlock from './baseBlock.vue';
import BaseTable from './BaseTable.vue';
import event from './tabs/event.vue';
import excess from './tabs/excess.vue';
import currentWorkHook from './tabs/currentWorkHook.vue';
import archWorkHook from './tabs/archWorkHook.vue';
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
    currentWorkHook,
    archWorkHook,
    Plotly,
  },
  computed: {
    layoutData() {
      return {
        modebar: {
          bgcolor: "rgba(0,0,0,0)"
        },
        margin: {
          l: 50,
          r: 15,
          b: 50,
          t: 20,
          pad: 4
        },
        paper_bgcolor: "#1A214A",
        plot_bgcolor: "#2B2E5E",
        
        xaxis: {
          color: "#FFFFFF",
          dtick: 1167567,
          title: 'Время',
          range: [this.minimum, this.maximum],
          type: 'date',
          rangeslider: true,
          gridcolor: "#3C4270",
        },
        yaxis: {
          color: "#FFFFFF",
          dtick: 1,
          title: 'W (TC)',
          gridcolor: "#3C4270",
          linecolor: "#EF5350",
        },    
      };
    },
  },
  data(){
    return {
      currentTab: 1,
      currentBlockTab: 1,
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
      chartData: null,
      table_work: [],
      postApiUrl: process.env.MIX_TKRS_POST_API_URL,
      linkWorkTable: "dayliWork1/",
      wellsTree: {},
      wellsTreeCurrent: {},
      archiveData: ['Бригада', 'Скважина'],
      
    }
  },
  created: async function () {
    this.$store.commit("globalloading/SET_LOADING", true);
    await this.axios
      .get(
          'http://172.20.103.203:8090/chooseDate/AKH_0482/05.08.2020/'
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
      this.getDataTreeArchive();
      this.getDataTreeCurrent();
      this.getTableWork();
      
    },
  
  methods: {
    comparison_graphs() {
        this.$modal.show('comparison_graphs')
    },
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
      this.$store.commit("globalloading/SET_LOADING", true);
        this.axios
            .get(
                `http://172.20.103.203:8090/chooseDate/${this.wellNumber}/${this.wellFile}/`,
            )
            .then((response) => {
                this.$store.commit("globalloading/SET_LOADING", false);
                let data = response.data;
                if (data) {
                    this.wellFile = data;
                    this.areaChartData = data.data;
                    this.maximum = data.data[0].rangeSlider.max;
                    this.minimum = data.data[0].rangeSlider.min;
                    
                } else {
                    console.log("No data");
                }
            });
      this.getTableWork();
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
    selectBlockTab(selectedBlockTab) {
      this.currentBlockTab = selectedBlockTab
    },
    getTableWork() {
      
      this.axios
          .get(
              this.postApiUrl + this.linkWorkTable + "AKH_0482/05.08.2020/",
              
          )
          .then((response) => {
              let data = response.data;
              if (data) {
                this.table_work = data

              } else {
                  console.log("No data");
              }
          });
    },

    getDataTreeArchive() {
      
      this.axios
          .get(
               `http://172.20.103.203:8090/wellTreeName/`,
              
          )
          .then((response) => {
              let data = response.data;
              if (data) {
                this.wellsTree = data

              } else {
                  console.log("No data");
              }
          });
    },
    getDataTreeCurrent() {
      
      this.axios
          .get(
               `http://172.20.103.203:8090/wellNameDate1/`,
              
          )
          .then((response) => {
              let data = response.data;
              if (data) {
                this.wellsTreeCurrent = data

              } else {
                  console.log("No data");
              }
          });
    },

  },
};
</script>
<style scoped>
.btn-secondary {
    color: #fff;
    background-color: #20274F;
    border-color: #20274F;
}
</style>
<style  scoped lang='scss'>
.data-analysis-left-block {
  width: 249px;
  flex-shrink: 0;
  display: flex;
  flex-flow: column;
  height: 100%;
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
.tab-lblock-header {
  color: white !important;
  background: #181837 !important;
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
  width: 100%;
  border: 6px solid #20274F;
}
.sidebar_graph {
  height: calc(100% - 36px);
}
.tkrs-content-down {
  height: 100%;
}
.custom-dropdown-block {
  background: #1F2142;
  border: none;
  color: #fff;
}
.line-block {
  height: 4px;
  padding-bottom: 22px;
}
.online-block {
  width: 100%;
}
.comparison-graphs {
  color: #fff;
  font-size: 16px;
}
.a-link {
  color: #fff;
}
.a-link:hover {
  color: #fff;
}
.plotly-graph {
  height: 8px;
}
.analyze-div {
  margin-right: 15px;
  margin-top: 2px; 
}
.back-a {
  margin-left: 10px
}
::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #2f315a;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
::-webkit-scrollbar-corner {
  background: #2f315a;
}
.tab-archive-div {
  padding-left: 3%;
  overflow: scroll; 
  height: 824px;
}

</style>