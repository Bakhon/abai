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
                <a href="tr" class="col but-nav__link but"><i style=" margin-right: 10px; "><svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z" fill="white"/>
                    </svg>
                    </i>Технологический режим</a>
                <!-- <form class="form-group but-nav__link">
                        <label for="inputDate">Введите дату:</label>
                        <input type="date" class="form-control" v-model="dt">
                </form> -->
                <!-- <form class="form-group but-nav__link">
                        <label for="inputDate">Выбор даты 2:</label>
                        <input type="date" class="form-control" v-model="dt2">
                </form> -->
                
                <div class="col">
                       
                        <div class="input-group input-group-sm">
                            <input type="text" placeholder="Поиск" class="form-control fix-rounded-right" required>
                            <div class="input-group-prepend">
                                <button class="input-group-text" style="font-size: 14px;">Поиск</button>
                            </div>
                        </div>
                </div>

                <!-- <a href="#" class="but-nav__link but" @click.prevent="chooseDt">Сформировать</a> -->
                <!-- <a href="#" class="but-nav__link but">Редактировать</a> -->
                <a class="but-nav__link but " @click="pushBign('chart')">Графики</a>
                <!-- <a href="http://172.20.103.51:7576/api/techregime/factor/download" download="Факторный анализ.xlsx" class="but-nav__link but">Экспорт</a> -->
        </div>
        <div class="tech">
            <td> Факторный анализ</td>
        </div>
        <!-- <div>
            <select name="Company" class="from-control" id="companySelect"
                v-model="filter" @change="chooseField">
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
                    <td rowspan="3" @click="sortBy('well')"><span>Скважина</span></td>
                    <td rowspan="3" @click="sortBy('field')"><span>Месторождение</span></td>
                    <td rowspan="3" @click="sortBy('horizon')"><span>Горизонт</span></td>
                    <td rowspan="3" @click="sortBy('exp_meth')"><span>Способ Эксплуатации</span></td>
                    <td class="colspan" colspan="6">ТР на {{dt}}</td>
                    <td class="colspan" colspan="6">ТР на {{dt2}}</td>
                    <td class="colspan" colspan="1">Отклон. Qн</td>
                    <td class="colspan" colspan="1">Технологические</td>
                    <td class="colspan" colspan="3">Геологические</td>
                    <td rowspan="3" @click="sortBy('Main_problem')"><span>Основное отклонение в ТР</span></td>
                </tr>
                <tr class="headerColumn">
                    <td rowspan="2" @click="sortBy('q_l_1')"><span>Qж</span></td>
                    <td rowspan="2" @click="sortBy('q_o_1')"><span>Qн</span></td>
                    <td rowspan="2" @click="sortBy('wct_1')"><span>Обводненность</span></td>
                    <td rowspan="2" @click="sortBy('bhp_1')"><span>Pзаб</span></td>
                    <td rowspan="2" @click="sortBy('p_res_1')"><span>Pпл</span></td>
                    <td rowspan="2" @click="sortBy('pi_1')"><span>Кпр</span></td>
                    <td rowspan="2" @click="sortBy('q_l_2')"><span>Qж</span></td>
                    <td rowspan="2" @click="sortBy('q_o_2')"><span>Qн</span></td>
                    <td rowspan="2" @click="sortBy('wct_2')"><span>Обводненность</span></td>
                    <td rowspan="2" @click="sortBy('bhp_2')"><span>Pзаб</span></td>
                    <td rowspan="2" @click="sortBy('p_res_2')"><span>Pпл</span></td>
                    <td rowspan="2" @click="sortBy('pi_2')"><span>Кпр</span></td>
                    <td rowspan="2" @click="sortBy('dqo')"><span>dQн</span></td>
                    <td rowspan="2" @click="sortBy('Pbh')"><span>Недостижение режимного Pзаб</span></td>
                    <td rowspan="2" @click="sortBy('wct')"><span>Рост обводненности</span></td>
                    <td rowspan="2" @click="sortBy('p_res')"><span>Снижение Pпл</span></td>
                    <td rowspan="2" @click="sortBy('PI')"><span>Снижение Kпрод</span></td>
                </tr>
                <tr></tr>
                <tr class="subHeaderColumn">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>м3/сут</td>
                    <td>м3/сут</td>
                    <td></td>
                    <td>ат</td>
                    <td>ат</td>
                    <td>м3/сут/ат</td>
                    <td>м3/сут</td>
                    <td>м3/сут</td>
                    <td></td>
                    <td>ат</td>
                    <td>ат</td>
                    <td>м3/сут/ат</td>
                    <td>т/сут</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr v-for="(row, row_index) in wells" :key="row_index">
                    <td> {{row.well}}</td>
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
                            background: getColor(Math.round(row.dqn*10)/10),
                        }"
                    >
                        <span> {{Math.round(row.dqn*10)/10}} </span>
                    </td>

                    <!-- <td>{{Math.round(row.Pbh*10)/10}}</td> -->
                    <td :style="`background :${getColor(
                    Math.round(row.Pbh*10)/10)}`">
                        <span> {{Math.round(row.Pbh*10)/10}} </span>
                    </td>

                    <!-- <td>{{Math.round(row.wct*10)/10}}</td> -->
                    <td :style="`background :${getColor(
                    Math.round(row.wct*10)/10)}`">
                        <span> {{Math.round(row.wct*10)/10}} </span>
                    </td>

                    <!-- <td>{{Math.round(row.p_res*10)/10}}</td> -->
                    <td :style="`background :${getColor(
                    Math.round(row.p_res*10)/10)}`">
                        <span> {{Math.round(row.p_res*10)/10}} </span>
                    </td>

                    <td :style="`background :${getColor(
                    Math.round(row.PI*10)/10)}`">
                        <span> {{Math.round(row.PI*10)/10}} </span>
                    </td>
                    <!-- <td>{{Math.round(row.PI*10)/10}}</td> -->
                    <td>{{row.Main_problem}}</td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>

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
            wells.sort((a, b) => a[type].localeCompare(b[type]))
            this.sortType = 'desc';
          } else {
            wells.sort((a, b) => b[type].localeCompare(a[type]))
            this.sortType = 'asc';
          }

      },
      chooseDt() {
          const { dt, dt2 } = this;
          console.log('dt1-', dt, ' dt2-', dt2);
          var choosenDt = dt.split("-");
          var choosenSecDt = dt2.split("-");
          this.axios.get("http://172.20.103.51:7576/api/techregime/factor/"+choosenDt[0]+"/"+choosenDt[1]+"/"+choosenSecDt[0]+"/"+choosenSecDt[1]+"/").then((response) => {
                let data = response.data;
                this.editdtm = choosenDt[1];
                this.editdty = choosenDt[0];
                this.editdtprevm = choosenSecDt[1];
                this.editdtprevy = choosenSecDt[0];
                if(data) {
                    console.log(data);
                    this.wells = data.data;
                }
                else {
                    console.log('No data');
                }

            });
      },
      chooseField() {
          const { filter, fullWells } = this;
          console.log(filter, fullWells);

          this.wells = fullWells.filter(e => e.field === filter);
      },
      pushBign(bign){
          switch (bign) {
              case 'bign1':
                  this.params.data = this.wellsList;
                  break;
          }
          this.$modal.show(bign);
      },
      getColor(status) {
          if (status < "0") return "#ac3939";
      },
    },
    beforeCreate: function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        var prMm = mm-2;
        var prPrMm = mm-3;
        this.axios.get("http://172.20.103.51:7576/api/techregime/factor/"+yyyy+"/"+prMm+"/"+yyyy+"/"+prPrMm+"/").then((response) => {
        let data = response.data;
        this.editdtm = prMm;
        console.log(this.editdtm);
        this.editdty = yyyy;
        console.log(this.editdty);
        this.editdtprevm = prPrMm;
        console.log(this.editdtprevm);
        this.editdtprevy = yyyy;
        console.log(this.editdtprevy);
        if(data) {
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
            this.chartWells = data.data;
        }
        else {
            console.log('No data');
        }
        if(prMm < 10 && prPrMm < 10) {
            this.dt = '01' + '.0' + prMm + '.' + yyyy;
            this.dt2 = '01' + '.0' + prPrMm + '.' + yyyy ;
        }
        else if(prMm <= 10 && prPrMM <=10) {
            this.dt = '01'+ '.' + prMm + '.' + yyyy;
            this.dt2 = '01' + '.' + prPrMm + '.' + yyyy;
        }
        else if(prMm >= 10 && prPrMM < 10) {
            this.dt = '01' + '.0' + prMm + '.' + yyyy;
            this.dt2 = '01' + '.0' + prPrMm + '.' + yyyy;
        }
        if(prMm < 10) {
            this.dt = '01' + '.0' + prMm + '.' + yyyy;
        }
        else {
            this.dt = '01' + '.' + prMm + '.' + yyyy;
        }
        if(prPrMm < 10) {
            this.dt2 = '01' + '.0' + prPrMm + '.' + yyyy;
        }
        else {
            this.dt2 = '01' + '.' + prPrMm + '.' + yyyy;
        }
    });
   },
}
</script>
<style>
body {
  color: white !important;
}

input, .form-control, .fix-rounded-right{
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
a:hover{
    color: white!important;
    text-decoration: none!important;
}
.maintable{
    
    padding-top: 35px;

}
.maintable-level2{
    background: #272953;
}
.table th, .table td {
    padding: 5px !important; 
    /* vertical-align: top;
    border-top: 1px solid #dee2e6; */
}
table.table.table-bordered.table-dark.table-responsive.ce {
    position: sticky;
    inset: 48.21% 2.4% 66.58% 5.31%;
    background: rgb(13, 30, 99);
    font-size: 9px;
    padding: unset;
}

tr:nth-child(odd) {background-color:#454d7d;}
tr:nth-child(even) {background-color:#454d7d73;}
</style>
