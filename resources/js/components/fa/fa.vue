<template>
    <div class="container-fluid">
        <modal name="chart" :width="2000" :height="1000" :adaptive="true">
            <div class="main_modals">
                <div class="row">
                    <div class="col-sm">
                        <div class="first_block">
                            <apexchart
                                v-if="barChartData && pieChartRerender"
                                type="bar"
                                :options="chartBarOptions"
                                :series="[{ name:'', data: barChartData}]"
                            ></apexchart>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="first_block">
                            <apexchart
                                v-if="pieChartData && pieChartRerender"
                                type="pie"
                                :options="chartOptions"
                                :series="pieChartData"
                            ></apexchart>
                        </div>
                    </div>
                    <div class="filter_chart">
                        <td class="filter_font"> Фильтр по: </td>
                        <div>
                            <select
                                class="form-control"
                                v-model="chartFilter_field"
                                value="Месторождение"
                            >
                                <option
                                    v-for="(f, k) in fieldFilters"
                                    :key="k"
                                    :value="f">{{f}}</option>
                            </select>
                        </div>
                        <div>
                            <select
                                class="form-control"
                                v-model="chartFilter_horizon"
                            >
                                <option
                                    v-for="(f, k) in horizonFilters"
                                    :key="k"
                                    :value="f">{{f}}</option>
                            </select>
                        </div>
                        <div>
                            <select
                                v-if="exp_methFilters"
                                class="form-control"
                                v-model="chartFilter_exp_meth"
                            >
                                <option
                                    v-for="(f, k) in exp_methFilters"
                                    :key="k"
                                    :value="f">{{f}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
        <div class="row justify-content-between">
                <a href="tr" class="but-nav__link but">Технологический режим</a>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Введите дату:</label>
                        <input type="date" class="form-control" v-model="date1">
                </form>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Выбор даты 2:</label>
                        <input type="date" class="form-control" v-model="date2">
                </form>
                <a href="#" class="but-nav__link but" @click="chooseDt">Сформировать</a>
                <!-- <a href="#" class="but-nav__link but">Редактировать</a> -->
                <!-- <a class="but-nav__link but " @click="pushBign('chart')">Графики</a> -->
                <!-- <a href="http://172.20.103.51:7576/api/techregime/factor/download" download="Факторный анализ.xlsx" class="but-nav__link but">Экспорт</a> -->
                <div class="col">

                        <div class="input-group input-group-sm">
                            <input type="text" placeholder="Поиск" class="form-control fix-rounded-right" required>
                            <div class="input-group-prepend fainputgr">
                                <button class="input-group-text" style="font-size: 14px;">Поиск</button>
                            </div>
                        </div>
                </div>




        </div>
        <div class="tech">
            <td> Факторный анализ</td>
        </div>
        <!-- <div>
            <select name="Company" class="from-control" id="companySelect"
                v-model="filter" @change="chooseField">
                <option value="Казгермунай">КазГерМунай</option>
                <option value="Акшабулак Центральный">Акшабулак Центральный</option>
                <option value="Акшабулак Южный">Акшабулак Южный</option>
                <option value="Акшабулак Восточный">Акшабулак Восточный</option>
                <option value="Нуралы">Нуралы</option>
                <option value="Аксай">Аксай</option>
                <option value="Аксай Южный">Аксай Южный</option>
            </select>
        </div> -->
        <div>
            <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
                <tr class="headerColumn">
                    <td rowspan="3" style="background: #12135C"><span>Скважина</span></td>
                    <td rowspan="3" style="background: #12135C"><span>Месторождение</span></td>
                    <td rowspan="3" style="background: #12135C"><span>Горизонт</span></td>
                    <td rowspan="3" style="background: #12135C"><span>Способ Эксплуатации</span></td>
                    <td class="colspan" colspan="6" style="background: #2C3379">ТР на {{dt}}</td>
                    <td class="colspan" colspan="6" style="background: #1A2370">ТР на {{dt2}}</td>
                    <td class="colspan" colspan="1" style="background: #E50303">Отклон. Qн</td>
                    <td class="colspan" colspan="1" style="background: #F08143">Технологические</td>
                    <td class="colspan" colspan="3" style="background: #4FB26A">Геологические</td>
                    <td rowspan="3" style="background: #272953"><span>Основное отклонение в ТР</span></td>
                </tr>
                <tr class="headerColumn">
                    <td rowspan="2" style="background: #2C3379"><span>Qж</span></td>
                    <td rowspan="2" style="background: #2C3379"><span>Qн</span></td>
                    <td rowspan="2" style="background: #2C3379"><span>Обводненность</span></td>
                    <td rowspan="2" style="background: #2C3379"><span>Pзаб</span></td>
                    <td rowspan="2" style="background: #2C3379"><span>Pпл</span></td>
                    <td rowspan="2" style="background: #2C3379"><span>Кпр</span></td>
                    <td rowspan="2" style="background: #1A2370"><span>Qж</span></td>
                    <td rowspan="2" style="background: #1A2370"><span>Qн</span></td>
                    <td rowspan="2" style="background: #1A2370"><span>Обводненность</span></td>
                    <td rowspan="2" style="background: #1A2370"><span>Pзаб</span></td>
                    <td rowspan="2" style="background: #1A2370"><span>Pпл</span></td>
                    <td rowspan="2" style="background: #1A2370"><span>Кпр</span></td>
                    <td rowspan="2" style="background: #E50303"><span>dQн</span></td>
                    <td rowspan="2" style="background: #F08143"><span>Недостижение режимного Pзаб</span></td>
                    <td rowspan="2" style="background: #4FB26A"><span>Рост обводненности</span></td>
                    <td rowspan="2" style="background: #4FB26A"><span>Снижение Pпл</span></td>
                    <td rowspan="2" style="background: #4FB26A"><span>Снижение Kпрод</span></td>
                </tr>
                <tr></tr>
                <tr class="subHeaderColumn">
                    <td @click="sortBy('well')" style="background: #12135C"></td>
                    <td @click="sortBy('field')" style="background: #12135C"></td>
                    <td @click="sortBy('horizon')" style="background: #12135C"></td>
                    <td @click="sortBy('exp_meth')" style="background: #12135C"></td>
                    <td @click="sortBy('q_l_1')" style="background: #2C3379">м3/сут</td>
                    <td @click="sortBy('q_o_1')" style="background: #2C3379">м3/сут</td>
                    <td @click="sortBy('wct_1')" style="background: #2C3379"></td>
                    <td @click="sortBy('bhp_1')" style="background: #2C3379">ат</td>
                    <td @click="sortBy('p_res_1')" style="background: #2C3379">ат</td>
                    <td @click="sortBy('pi_1')" style="background: #2C3379">м3/сут/ат</td>
                    <td @click="sortBy('q_l_2')" style="background: #1A2370">м3/сут</td>
                    <td @click="sortBy('q_o_2')" style="background: #1A2370">м3/сут</td>
                    <td @click="sortBy('wct_2')" style="background: #1A2370"></td>
                    <td @click="sortBy('bhp_2')" style="background: #1A2370">ат</td>
                    <td @click="sortBy('p_res_2')" style="background: #1A2370">ат</td>
                    <td @click="sortBy('pi_2')" style="background: #1A2370">м3/сут/ат</td>
                    <td @click="sortBy('dqn')" style="background: #E50303">т/сут</td>
                    <td @click="sortBy('Pbh')" style="background: #F08143"></td>
                    <td @click="sortBy('wct')" style="background: #4FB26A"></td>
                    <td @click="sortBy('p_res')" style="background: #4FB26A"></td>
                    <td @click="sortBy('PI')" style="background: #4FB26A"></td>
                    <td @click="sortBy('Main_problem')" style="background: #272953"></td>
                </tr>
                <tr
                    v-for="(row) in wells"
                    :key="row.well"
                >
                    <td>{{row.well}}</td>
                    <td>{{row.field}}</td>
                    <td>{{row.horizon}}</td>
                    <td>{{row.exp_meth}}</td>
                    <td>{{Math.round(row.q_l_1*10)/10}}</td>
                    <td>{{Math.round(row.q_o_1*10)/10}}</td>
                    <td>{{Math.round(row.wct_1*10)/10}}</td>
                    <td>{{Math.round(row.bhp_1*10)/10}}</td>
                    <td>{{Math.round(row.p_res_1*10)/10}}</td>
                    <td>{{Math.round(row.pi_1*10)/10}}</td>
                    <td>{{Math.round(row.q_l_2*10)/10}}</td>
                    <td>{{Math.round(row.q_o_2*10)/10}}</td>
                    <td>{{Math.round(row.wct_2*10)/10}}</td>
                    <td>{{Math.round(row.bhp_2*10)/10}}</td>
                    <td>{{Math.round(row.p_res_2*10)/10}}</td>
                    <td>{{Math.round(row.pi_2*10)/10}}</td>

                    <!-- <td>{{Math.round(row.dqo*10)/10}}</td> -->
                    <!-- :style="`background :${getColor(Math.round(row.dqo*10)/10)}`" -->
                    <td
                        :style="{
                            background: getColorone(Math.round(row.dqn*10)/10),
                        }"
                    >
                        <span> {{Math.round(row.dqn*10)/10}} </span>
                    </td>

                    <!-- <td>{{Math.round(row.Pbh*10)/10}}</td> -->
                    <td :style="`background :${getColor(
                        Math.round(row.Pbh*10)/10,
                        Math.round(row.wct*10)/10,
                        Math.round(row.p_res*10)/10,
                        Math.round(row.PI*10)/10)}`">
                        <span> {{Math.round(row.Pbh*10)/10}} </span>
                    </td>

                    <!-- <td>{{Math.round(row.wct*10)/10}}</td> -->
                    <td :style="`background :${getColor(
                        Math.round(row.wct*10)/10,
                        Math.round(row.Pbh*10)/10,
                        Math.round(row.p_res*10)/10,
                        Math.round(row.PI*10)/10)}`">
                        <span> {{Math.round(row.wct*10)/10}} </span>
                    </td>

                    <!-- <td>{{Math.round(row.p_res*10)/10}}</td> -->
                    <td :style="`background :${getColor(
                        Math.round(row.p_res*10)/10,
                        Math.round(row.Pbh*10)/10,
                        Math.round(row.wct*10)/10,
                        Math.round(row.PI*10)/10)}`">
                        <span> {{Math.round(row.p_res*10)/10}} </span>
                    </td>

                    <td :style="`background :${getColor(
                        Math.round(row.PI*10)/10,
                        Math.round(row.Pbh*10)/10,
                        Math.round(row.wct*10)/10,
                        Math.round(row.p_res*10)/10)}`">
                        <span> {{Math.round(row.PI*10)/10}} </span>
                    </td>
                    <!-- <td>{{Math.round(row.PI*10)/10}}</td> -->
                    <td>{{row.Main_problem}}</td>
                </tr>
            </table>
        </div>
        <notifications position="top"></notifications>
    </div>
</template>
<script>
import { eventBus } from "../../event-bus.js";
import NotifyPlugin from "vue-easy-notify";
import 'vue-easy-notify/dist/vue-easy-notify.css';
import { VueMomentLib }from "vue-moment-lib";
import moment from "moment";
import Vue from 'vue';

Vue.use(NotifyPlugin,VueMomentLib);

import VueApexCharts from "vue-apexcharts";
export default {
    computed: {
      // field horizon exp_meth
      // Pbh wct p_res PI
        pieChartData(){
            if (this.chartWells && this.chartWells.length > 0){
                let field = this.chartFilter_field;
                let horizon = this.chartFilter_horizon;
                let exp_meth = this.chartFilter_exp_meth;
                try {
                    let filteredResult = this.chartWells.filter((row) => (
                        (!field || row.field === field)
                        && (!horizon || row.horizon === horizon)
                        && (!exp_meth || row.exp_meth === exp_meth)
                    ));
                    console.log(filteredResult);
                    let filteredData = filteredResult.reduce((acc, res) => {
                        //acc = {
                        //    'Pbh': acc['Pbh'] + res['Pbh'],
                        //    'wct': acc['wct'] + res['wct'],
                        //    'p_res': acc['p_res'] + res['p_res'],
                        //    'PI': acc['PI'] + res['PI'],
                        //}
                        if (acc.hasOwnProperty(res['Main_problem'])) {
                            acc[res['Main_problem']]+=1;
                        } else {
                            acc[res['Main_problem']]=1;
                        }
                        return acc;
                    }, {})
                    console.log('Pie chart filtered data:',filteredData)
                    return [
                        filteredData['Pbh'] || 0,
                        filteredData['wct'] || 0,
                        // filteredData['p_res'],
                        filteredData['No problem'] || 0,
                        filteredData['PI'] || 0,
                    ]
                } catch(err) {
                    console.error(err);
                    return false
                }
                return false;
            } else return false
        },
        barChartData(){
            if (this.chartWells && this.chartWells.length > 0){
                let field = this.chartFilter_field;
                let horizon = this.chartFilter_horizon;
                let exp_meth = this.chartFilter_exp_meth;
                try {
                    let filteredResult = this.chartWells.filter((row) => (
                        (!field || row.field === field)
                        && (!horizon || row.horizon === horizon)
                        && (!exp_meth || row.exp_meth === exp_meth)
                    ));
                    console.log(filteredResult);
                    let filteredData = filteredResult.reduce((acc, res) => {
                        acc = {
                            'Pbh': acc['Pbh'] + res['Pbh'],
                            'wct': acc['wct'] + res['wct'],
                            'p_res': acc['p_res'] + res['p_res'],
                            'PI': acc['PI'] + res['PI'],
                        }
                        return acc;
                    }, {
                        Pbh: 0,
                        wct: 0,
                        p_res:0,
                        PI: 0,
                    })
                    return [filteredData['Pbh'],
                        filteredData['wct'],
                        filteredData['p_res'],
                        filteredData['PI']
                    ]
                } catch(err) {
                    console.error(err);
                    return false
                }
                //return false;
            } else return false
        },

        fieldFilters(){
            if (this.chartWells && this.chartWells.length > 0){
                let filters = []
                this.chartWells.forEach((el) => {
                    if (filters.indexOf(el.field) === -1){
                        filters = [ ...filters, el.field]
                    }
                })
                return [ undefined, ...filters]
            } else return []
        },
        horizonFilters(){
            if (this.chartWells && this.chartWells.length > 0){
                let filters = []
                this.chartWells.forEach((el) => {
                    if (filters.indexOf(el.horizon) === -1){
                        filters= [ ...filters, el.horizon]
                    }
                })
                return [ undefined, ...filters]
            } else return []
        },
        exp_methFilters(){
            if (this.chartWells && this.chartWells.length > 0){
                let filters = []
                this.chartWells.forEach((el) => {
                    if (filters.indexOf(el.exp_meth) === -1){
                        filters = [ ...filters, el.exp_meth]
                    }
                })
                return [ undefined, ...filters]
            } else return []
        },
  },
  data: function () {
    return {
        pieChartRerender: true,
        wells: [],
        chartWells: [],
        sortType: 'asc',
        dt: null,
        dt2: null,
        date1: null,
        date2: null,
        fullWells: [],
        filter: null,
        editdtm: null,
        editdty: null,
        editdtprevm: null,
        editdtprevy: null,
        chartFilter_field: undefined,
        chartFilter_horizon: undefined,
        chartFilter_exp_meth: undefined,
        chartBarOptions: {
            chart: {
              height: 350,
              type: 'bar',
            },
            plotOptions: {
              bar: {
                dataLabels: {
                  position: 'bottom', // top, center, bottom
                },
              }
            },
            dataLabels: {
              enabled: true,
              formatter: function (val) {
                return val;
              },
              offsetY: -20,
              style: {
                fontSize: '12px',
                colors: ["#304758"]
              }
            },

            xaxis: {
              categories: ["Недостижение режимного Pзаб", "Рост обводненности", "Снижение Pпл", "Снижение Kпрод"],
              position: 'bottom',
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false
              },
              crosshairs: {
                fill: {
                  type: 'gradient',
                  gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                  }
                }
              },
              tooltip: {
                enabled: true,
              }
            },
            yaxis: {
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false,
              },
              labels: {
                show: true,
                formatter: function (val) {
                  return val;
                }
              }

            },
            // title: {
            //   text: 'asd',
            //   floating: true,
            //   offsetY: 500,
            //   align: 'top',
            //   style: {
            //     color: '#444'
            //   }
            // }
        },
        chartOptions: {
            labels: ["Недостижение режимного Pзаб", "Рост обводненности","Снижение Pпл","Снижение Kпрод"],
            chart: {
            type: "pie",
            },
            dataLabels: {
            enabled: false,
            } /*убирается подсветка процентов на круге*/,
            /*tooltip: {
        enabled: false},*/
            legend: {
            show: false,
            } /*убирается навигация рядом с кругом*/,
            colors: ["#330000", "#804d00", "#00004d", "#999900"],
            plotOptions: {
                pie: {
                    expandOnClick: true,
                },
            },
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200,
                        },
                        legend: {
                            position: "bottom",
                        },
                    },
                },
            ],
        },
    }
  },
  watch: {
      pieChartData(){
          this.pieChartRerender = false;
          this.$nextTick(() => {
              this.pieChartRerender = true;
          })
      },
      barChartData(){
          this.pieChartRerender = false;
          this.$nextTick(() => {
              this.pieChartRerender = true;
          })
      }
  },
  methods: {
      sortBy(type) {
        let { wells, sortType } = this;
        console.log(type, sortType);
        if(sortType === 'asc') {
            this.wells = wells.sort((a, b) => {
                let aVal = a[type];
                let bVal = b[type];
                if(Array.isArray(aVal)){
                    if ( (typeof aVal[0] === 'string') ){
                        return aVal[0].localeCompare(bVal[0])
                    } else {
                        if ( Number(aVal[0]) > Number(bVal[0]) ) return 1;
                        else if ( Number(aVal[0]) < Number(bVal[0]) ) return -1;
                        else return 0
                    }
                } else{
                    if (typeof aVal === 'string'){
                        return aVal.localeCompare(bVal)
                    } else {
                        if (Number(aVal) > Number(bVal)) return 1;
                        else if (Number(aVal) < Number(bVal)) return -1;
                        else return 0
                    }
                }
            })
            this.sortType = 'desc';
        }
        else {
            this.wells = wells.sort((a, b) => {
                let aVal = a[type];
                let bVal = b[type];
                if(Array.isArray(aVal)){
                    if ( (typeof aVal[0] === 'string') && isNaN(Number(aVal[0])) ){
                        return bVal[0].localeCompare(aVal[0])
                    } else {
                        if (Number(aVal[0]) > Number(bVal[0])) return -1;
                        else if ( Number(aVal[0]) < Number(bVal[0]) ) return 1;
                        else return 0;
                    }
                } else{
                    if ( (typeof aVal === 'string') && isNaN(Number(aVal)) ){
                        return aVal.localeCompare(bVal)
                    } else {
                        if (Number(aVal) > Number(bVal)) return -1;
                        else if ( Number(aVal) < Number(bVal) ) return 1;
                        else return 0
                    }
                }
            })
            this.sortType = 'asc';
        }
      },
      chooseDt() {
          const { date1, date2 } = this;
          console.log('dt1-', date1, ' dt2-', date2);
          var choosenDt = date1.split("-");
          var choosenSecDt = date2.split("-");
          if(choosenDt[1]==1){
              var prMm = 12;
              var prPrMm = 11;
              var yyyy = choosenDt[0] - 1;
              var pryyyy = choosenSecDt[0];
          }
          else if(choosenSecDt[1] == 1){
              var prMm = choosenDt[1] - 1;
              var prPrMm = 12;
              var yyyy = choosenDt[0];
              var pryyyy = choosenSecDt[0] - 1;
          }
          else{
              var prMm = choosenDt[1] - 1;
              var prPrMm = choosenSecDt[1] - 1;
              var yyyy = choosenDt[0];
              var pryyyy = choosenSecDt[0];
          }
          if(choosenDt[1] < choosenSecDt[1] && choosenDt[0] === choosenSecDt[0]){
              Vue.prototype.$notifyError("Дата 2 должна быть меньше, чем Дата 1");
          }
          else{
              console.log('date1', prMm, yyyy, 'date2', prPrMm, pryyyy)
              this.axios.get("http://172.20.103.51:7576/api/techregime/factor/"+yyyy+"/"+prMm+"/"+pryyyy+"/"+prPrMm+"/").then((response) => {
                      let data = response.data;
                      this.editdtm = choosenDt[1];
                      this.editdty = choosenDt[0];
                      this.editdtprevm = choosenSecDt[1];
                      this.editdtprevy = choosenSecDt[0];
                      if(data) {
                          console.log(data);
                          this.wells = data.data;
                          this.fullWells = data.data;
                          this.chartWells = data.data;
                      }
                      else {
                          console.log('No data');
                      }
                      this.dt = '01' + '.' + this.editdtm + '.' + this.editdty;
                      this.dt2 = '01' + '.' + this.editdtprevm + '.' + this.editdtprevy ;

                });
          }
      },
      chooseField() {
          const { filter, fullWells } = this;
          console.log(filter, fullWells);
          if(filter == 'Казгермунай'){
            this.wells = fullWells;
          }
          else{
            this.wells = fullWells.filter(e => e.field === filter);
          }
      },
      pushBign(bign){
          switch (bign) {
              case 'bign1':
                  this.params.data = this.wellsList;
                  break;
          }
          this.$modal.show(bign);
      },
      getColor(status, ...values) {
          if (status < "0" && status === Math.min(status, ...values)) return "#ac3939";
      },
      getColorone(status) {
          if (status < "0") return "#ac3939";
      },

    },
    beforeCreate: function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        var pryyyy = today.getFullYear();
        var prMm = mm;
        var prPrMm = mm;
        if(mm==0){
            var prMm = 12;
            var prPrMm = 11;
            var yyyy = yyyy - 1;
            var pryyyy = pryyyy - 1;
        }
        else{
            var prMm = prMm - 1;
            var prPrMm = prPrMm -2;
            var yyyy = yyyy;
            var pryyyy = pryyyy;
        }
        EventBus.$on('halu', (data) => {
            this.emmit = data;
            // console.log(`Oh, that's nice. It's gotten ${this.editdtm} clicks! :)`)
        });
        this.axios.get("http://172.20.103.51:7576/api/techregime/factor/"+yyyy+"/"+prMm+"/"+pryyyy+"/"+prPrMm+"/").then((response) => {
        let data = response.data;
        // this.editdtm = prMm;
        console.log(this.emmit);
        this.editdty = yyyy;
        console.log(this.editdty);
        this.editdtprevm = prPrMm;
        console.log(this.editdtprevm);
        this.editdtprevy = yyyy;
        console.log(this.editdtprevy);
        console.log(this.good);

        if(data) {
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
            this.chartWells = data.data;
        }
        else {
            console.log('No data');
        }
        if(this.editdtm < 10 && this.editdtprevm < 10) {
            this.dt = '01' + '.0' + this.editdtm + '.' + this.editdty;
            this.dt2 = '01' + '.0' + this.editdtprevm + '.' + this.editdtprevy ;
        }
        else if(this.editdtm <= 10 && this.editdtprevm <=10) {
            this.dt = '01'+ '.' + this.editdtm + '.' + this.editdty;
            this.dt2 = '01' + '.' + this.editdtprevm + '.' + this.editdtprevy;
        }
        else if(editdtm >= 10 && editdtprevm < 10) {
            this.dt = '01' + '.0' + this.editdtm + '.' + this.editdty;
            this.dt2 = '01' + '.0' + this.editdtprevm + '.' + this.editdtprevy;
        }
        if(this.editdtm < 10) {
            this.dt = '01' + '.0' + this.editdtm + '.' + this.editdty;
        }
        else {
            this.dt = '01' + '.' + this.editdtm + '.' + this.editdty;
        }
        if(this.editdtprevm < 10) {
            this.dt2 = '01' + '.0' + this.editdtprevm + '.' + this.editdtprevy;
        }
        else {
            this.dt2 = '01' + '.' + this.editdtprevm + '.' + this.editdtprevy;
        }
    });
   },
}
</script>
<style  scoped>
body {
  color: white !important;
}
.but-nav__link {

    font-weight: inherit;
    padding: 5px 15px;
    border-radius: 5px;
    font-family: Roboto;
    font-style: normal;
    font-size: 17px;
    color: #FFFFFF;
    background: #656A8A;
    border: none!important;
    text-align: left!important;
    cursor: pointer;
}
.form-control, .fix-rounded-right{
    background: #272953!important;
    border: 1px solid #656A8A!important;
    height: 35px!important;
    color: white!important;
}
.input-group-text
{
    background: #656A8A!important;
    color: white!important;
    border-radius: 6px!important;
    border: none!important;
    position: absolute!important;
    right: 0!important;
    z-index: 9999;

}
.input-group-prepend{

    padding-top: 3px!important;
    margin-right: -3px!important;
}
.table th, .table td {
    padding: 5px !important;
}


</style>
