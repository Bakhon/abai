<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        <baseBlock />
        
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
                <Plotly :data="areaChartData" :displaylogo="false" 
                :layout="layout" :display-mode-bar="true" 
                :mode-bar-buttons-to-remove="buttonsToRemove" v-if="isChart"></Plotly>
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
      layout: {
        shapes: [{
          type: 'line',
      x0: '2020-06-18 00:00:00',
      y0: 14,
      x1: '2020-06-18 23:59:00',
      y1: 14,
      line: {
        color: '#EF5350',
        width: 2,
        dash: 'dashdot'
          }
        },
        {
          type: 'line',
      x0: '2020-06-18 00:00:00',
      y0: 12,
      x1: '2020-06-18 23:59:00',
      y1: 12,
      line: {
        color: '#D77D2A',
        width: 2,
        dash: 'dashdot'
          }
        }],
        width: 1550,
        height: 600,
        paper_bgcolor: "#272953",
        plot_bgcolor: "#272953",
        xaxis: {
          color: "#FFFFFF",
          title: 'Время',
          range: ['2020-06-18 00:00:00', '2020-06-18 23:59:00'],
          type: 'date',
          rangeslider: true,
        
        },
        yaxis: {
          title: 'W (TC)',
          color: "#FFFFFF",
          linecolor: "#EF5350",
        },
   
    
      },
      isChart: true,
    }
  },
  created: async function () {
    this.$store.commit("globalloading/SET_LOADING", true);
    console.log("TEST")  
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
          console.log(data.data);
        } else {
          console.log("No data");
        }
        return Promise
      })
      .catch((error) => {
        console.log(error.data);
        this.$store.commit("globalloading/SET_LOADING", false);
      });
    },
  
  methods: {
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
      console.log(this.Date1);
      this.axios
        .get(
            'http://127.0.0.1:7580/db/' + Date1.toLocaleDateString("en-GB") + '/'
          )
        .then((response) => {
          console.log("TEST2")  
          this.$store.commit("globalloading/SET_LOADING", false);
          let data = response.data;
          if (data) {
            this.areaChartData = data.data;
            console.log(data.data);
          } else {
            console.log("No data");
          }
        })
    },
  },
  
  
  
};
</script>

<style scoped>
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
</style>