<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        <baseBlock />
        
        <div class="tkrs-content">
            <div>
                <Plotly :data="areaChartData" :layout="layout" :display-mode-bar="false"></Plotly>
                <div>
                    <ul class="nav nav-tabs all-tabs">
                        <li class="nav-item">
                            <a class="nav-link active tab-header" @click="selectTab(1)" href="#">События</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab-header " @click="selectTab(2)" href="#">Превышения</a>
                        </li>
                        
                    </ul>

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
      fields: ['№', 'Начало', 'Конец', 'Продолжительность', 'Количество превышений', 'Событие'],
      items: [['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '], ['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '],['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '],['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '],['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг '],['1', '15.06.2021  14:30:26', '15.06.2021  14:30:26', '14:30:26', "1", 'Подъём штанг ']],
      calendarDate: '2020-06-17',
      Date1: null,
      areaChartData: [],
      layout:{
        title: "My graph"
      },
    }
  },
  created: async function () {
    this.$store.commit("globalloading/SET_LOADING", true);
    console.log("TEST")  
    await this.axios
      .get(
          'http://172.20.103.203:8090/db/17/6/2020/'
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
</style>