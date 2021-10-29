<template>
  <div>
    <div  v-if="modal_name=='recommendation'" class="wft__modal__window d-flex justify-content-center align-items-center">
      <div class="wft__modal card-block">
        <div class="card-title justify-content-between m-0">
          <div class="d-flex">
            <p>
              {{ recommendation_modal.title }}
            </p>
            <div>
            </div>
          </div>
          <button class="wft__modal__close" @click="modalClose" >
            Закрыть
          </button>
        </div>
        <div class="wft__modal__body">
          <table class="wft__modal__table">
            <thead>
            <tr>
              <th v-for="item in recommendation_modal.head" style="width: 8.3%">
                {{ item.title }}
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="items in recommendation_modal.body">
              <td v-for="item in items" style="height: 150px;">
                {{ item }}
              </td>
            </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
    <div  v-if="modal_name=='recommendation_implementation'" class="wft__modal__window d-flex justify-content-center align-items-center">
      <div class="wft__modal card-block">
        <div class="card-title justify-content-between m-0">
          <div class="d-flex align-items-center">
            <p>
              {{ recommendation_implementation.title }}
            </p>
            <div class="block d-flex justify-content-between" style="margin-left: 10px;">
              <button class="period-btn">
                7 дней
              </button>
              <button class="period-btn">
                30 дней
              </button>
              <button class="period-btn">
                90 дней
              </button>
            </div>
          </div>
          <button class="wft__modal__close" @click="modalClose" >
            Закрыть
          </button>
        </div>
        <div class="wft__modal__body">
          <table class="w-100 wft__modal__table">
            <thead>
            <tr>
              <th v-for="item in recommendation_implementation.head" >
                {{ item.title }}
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="items in recommendation_implementation.body">
              <td v-for="item in items" style="height: 60px;">
                {{ item }}
              </td>
            </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
    <div  v-if="modal_name=='fact'" class="wft__modal__window d-flex justify-content-center align-items-center">
      <div class="wft__modal card-block">
        <div class="card-title justify-content-between m-0">
          <div class="d-flex">
            <p>
              План-факт
            </p>
          </div>
          <button class="wft__modal__close" @click="modalClose" >
            Закрыть
          </button>
        </div>
        <div class="wft__modal__body">
          <table class="w-100 wft__modal__table">
            <thead>
            <tr>
              <th rowspan="2">
                Показатель
              </th>
              <th rowspan="2"> Ед. изм.</th>
              <th colspan="3">План</th>
              <th colspan="3">План</th>
              <th colspan="3">План</th>
            </tr>
            <tr>
              <th>нагн</th>
              <th>доб</th>
              <th>общ</th>
              <th>нагн</th>
              <th>доб</th>
              <th>общ</th>
              <th>нагн</th>
              <th>доб</th>
              <th>общ</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>Количество мероприятий</td>
              <td>Шт.</td>
              <td>3</td>
              <td>8</td>
              <td>11</td>
              <td>3</td>
              <td>8</td>
              <td>11</td>
              <td>3</td>
              <td>8</td>
              <td>11</td>
            </tr>
            <tr v-for="items in fact.body">
              <td v-for="(item, index) in items" :colspan="index>1? 3 : 1 ">{{ item }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div  v-if="modal_name=='window_limitation'"  class="wft__modal__window d-flex justify-content-center align-items-center">
      <div class="wft__modal card-block">
        <div class="card-title justify-content-between m-0">
          <div class="d-flex">
            <p>
              Окно ограничений: В целом по участку
            </p>
          </div>
          <button class="wft__modal__close" @click="modalClose" >
            Закрыть
          </button>
        </div>
        <div class="wft__modal__body">
          <div>
            <div class="window_limitation">
              <div class="cell_compare">
                <div class="cell_compare_title">
                  Дебит жидкости, м3/сут
                </div>
                <p class="cell_compare_sign"> >= </p>
                <button class="cell_compare_button">40</button>
              </div>
              <div>
                <div class="window_limitation_cell_out d-flex">
                  <div class="window_limitation_cell" v-for="n  in 20"  :class="n>10&n<15 ?'window_limitation_cell_green':''" style=""></div>
                </div>
                <div class="d-flex justify-content-between">
                  <p>0</p>
                  <p>50</p>
                  <p>100</p>
                  <p>150</p>
                  <p>200</p>
                </div>
              </div>
              <div class="cell_compare">
                <div class="cell_compare_title">
                  Дебит жидкости, м3/сут
                </div>
                <p class="cell_compare_sign"> >= </p>
                <button class="cell_compare_button">120</button>
              </div>
            </div>
            <div class="window_limitation">
              <div class="cell_compare">
                <div class="cell_compare_title">
                  Дебит жидкости, м3/сут
                </div>
              <p class="cell_compare_sign"> >= </p>
                <button class="cell_compare_button">40</button>
              </div>
              <div>
                <div class="window_limitation_cell_out d-flex">
                  <div class="window_limitation_cell" v-for="n  in 20"  style=""></div>
                </div>
                <div class="d-flex justify-content-between">
                  <p>0</p>
                  <p>50</p>
                  <p>100</p>
                  <p>150</p>
                  <p>200</p>
                </div>
              </div>
              <div class="cell_compare">
                <div class="cell_compare_title">
                  Дебит жидкости, м3/сут
                </div>
                <p class="cell_compare_sign"> >= </p>
                <button class="cell_compare_button">120</button>
              </div>
            </div>
          </div>
          <table class="w-100 wft__modal__table window_limitation__table">
            <thead>
            <tr>
              <th rowspan="2">
                № Скв
              </th>
              <th rowspan="2">Тип</th>
              <th colspan="2">Закачка воды, м3/сут</th>
              <th colspan="2">Дебит жидкости, м3/сут</th>
              <th colspan="2">Забойное давление, атм</th>
            </tr>
            <tr>
              <th scope="col">Мин</th>
              <th scope="col">Макс</th>
              <th scope="col">Мин</th>
              <th scope="col">Макс</th>
              <th scope="col">Мин</th>
              <th scope="col">Макс</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="items in window_limitation.body">
              <td v-for="item in items">{{ item }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div  v-if="modal_name=='object_1'"  class="wft__modal__window d-flex justify-content-center align-items-center ">
      <div class="wft__modal card-block object__modal">
        <div class="card-title justify-content-between m-0">
          <div class="d-flex">
            <p>
              Диогнастические графики по <span>объекту I</span>
            </p>
          </div>
          <button class="wft__modal__close" @click="modalClose" >
            Закрыть
          </button>
        </div>
        <div class="wft__modal__body">
          <div class="d-flex  justify-content-center flex-wrap ">
            <div class="object_graphic ">
              <h2 class="w-100 d-flex justify-content-center">КИН от MOPVinj</h2>
              <apexchart
                  type="line"
                  height="250"
                  :options="chartOptionsKin"
                  :series="seriesMopInj"
              />
              <h2 class="w-100 d-flex justify-content-center">MOPVinj,д.ед.</h2>
            </div>
            <div class="object_graphic ">
              <h2 class="w-100 d-flex justify-content-center">КИН от Обводненности</h2>
              <apexchart
                  type="line"
                  height="250"
                  :options="chartOptionsKin2"
                  :series="seriesWaterCut"
              />
              <h2 class="w-100 d-flex justify-content-center">Обводненность, %</h2>
            </div>
            <div class="object_graphic ">
              <h2 class="w-100 d-flex justify-content-center">КИН от Evol</h2>
              <apexchart
                  type="line"
                  height="250"
                  :options="chartOptionsKin2"
                  :series="seriesEVol"
              />
              <h2 class="w-100 d-flex justify-content-center">Evol,д.ед.</h2>
            </div>
          </div>
        </div>
        <div class="card-title justify-content-between m-0">
          <div class="">
            <p>
              MOPVinj – промытый поровый объем нефти
            </p>
            <p>
              Evol – коэффициент охвата заводнением по объему
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import VueApexCharts from 'vue-apexcharts'
import {waterfloodingManagementMapGetters} from '@store/helpers';
export default {
  name: "modal",
  props :[
    'modal_name',
    'r_object'
  ],
  components: {
    "apexchart": VueApexCharts,
  },
  data(){
    return {
      seriesMopInj: [],
      seriesWaterCut: [
        { type: 'line', data: []},
        { type: 'line', data: []}
      ],
      seriesEVol: [],
      chartOptionsKin:{
        chart: {
          height: 250,
          type: 'line',
          toolbar: { show: false },
        },
        legend: {
          show: false,
        },
        colors: ['#5b9bd5', '#FBC02D'],
        stroke: {
          width: [3, 3],
          curve: 'smooth',
          dashArray: [0, 5]
        },
        tooltip: {
          shared: false,
          intersect: true,
        },
        grid: {
          borderColor: '#3C4270',
          strokeDashArray: 0,
          xaxis: {
            lines: {
              show: true,
            }
          },
          yaxis: {
            lines: {
              show: true,
            }
          },
        },
        xaxis: {
          tickAmount: 6,
          min: 0,
          max: 1,
          labels: {
            style: {
              colors: '#fff'
            }
          }
        },
        yaxis: {
          labels: {
            formatter: function(val) {
              return val.toFixed(0);
            },
            style: {
              colors: '#fff'
            }
          },
          title: {
            text: "КИН, %",
            style: {
              color: '#fff'
            }
          }
        }
      },
      chartOptionsKin2:{
        chart: {
          height: 350,
          type: 'line',
          toolbar: { show: false },
        },
        legend: {
          show: false,
        },
        colors: ['#5b9bd5', '#FBC02D'],
        stroke: {
          width: [3, 3],
          curve: 'smooth',
          dashArray: [0, 5]
        },
        tooltip: {
          shared: false,
          intersect: true,
        },
        grid: {
          borderColor: '#3C4270',
          strokeDashArray: 0,
          xaxis: {
            lines: {
              show: true,
            }
          },
          yaxis: {
            lines: {
              show: true,
            }
          },
        },
        xaxis: {
          tickAmount: 6,
          labels: {
            style: {
              colors: '#fff'
            }
          }
        },
        yaxis: {
          labels: {
            formatter: function(val) {
              return val.toFixed(0);
            },
            style: {
              colors: '#fff'
            }
          },
          title: {
            text: "КИН, %",
            style: {
              color: '#fff'
            }
          }
        }
      },
      recommendation_modal :{
        title: this.trans('waterflooding_management.recommendation'),
        head:[
          {title: this.trans('waterflooding_management.modal_number_recommendation')},
          {title: this.trans('waterflooding_management.modal_cluster')},
          {title: this.trans('waterflooding_management.modal_over_well')},
          {title: this.trans('waterflooding_management.modal_current_over_well')},
          {title: this.trans('waterflooding_management.modal_target_well')},
          {title: this.trans('waterflooding_management.modal_reag_ext_well')},
          {title: this.trans('waterflooding_management.modal_current_deb_jew')},
          {title: this.trans('waterflooding_management.modal_current_deb_oil')},
          {title: this.trans('waterflooding_management.modal_current_obv')},
          {title: this.trans('waterflooding_management.modal_calc_deb_jew')},
          {title: this.trans('waterflooding_management.modal_calc_deb_oil')},
          {title: this.trans('waterflooding_management.modal_calc_obv')}
        ],
        body:[
          [1, 1, 299, 175, 210, 254, 62, 9.0, '82%', 95, 13, '83%'],
          [1, 1, 299, 175, 210, 254, 62, 9.0, '82%', 95, 13, '83%'],
          [1, 1, 299, 175, 210, 254, 62, 9.0, '82%', 95, 13, '83%'],
          [1, 1, 299, 175, 210, 254, 62, 9.0, '82%', 95, 13, '83%'],
        ]
      },
      recommendation_implementation: {
        title: this.trans('waterflooding_management.recommendation_implementation'),
        head :[
          {title: this.trans('waterflooding_management.modal_choose')},
          {title: this.trans('waterflooding_management.modal_pp')},
          {title: this.trans('waterflooding_management.modal_skv')},
          {title: this.trans('waterflooding_management.modal_well_type')},
          {title: this.trans('waterflooding_management.modal_recommendation')},
          {title: this.trans('waterflooding_management.modal_current_indicator')},
          {title: this.trans('waterflooding_management.modal_plan_indicator')},
        ],
        body:[
            [false, 1, 299, 'Нагн.', 'Увеличить приемистость', '175 м3/сут.', '210 м3/сут.' ],
            [false, 1, 299, 'Нагн.', 'Увеличить приемистость', '175 м3/сут.', '210 м3/сут.' ],
            [false, 1, 299, 'Нагн.', 'Увеличить приемистость', '175 м3/сут.', '210 м3/сут.' ],
            [false, 1, 299, 'Нагн.', 'Увеличить приемистость', '175 м3/сут.', '210 м3/сут.' ],
            [false, 1, 299, 'Нагн.', 'Увеличить приемистость', '175 м3/сут.', '210 м3/сут.' ],
            [false, 1, 299, 'Нагн.', 'Увеличить приемистость', '175 м3/сут.', '210 м3/сут.' ],
            [false, 1, 299, 'Нагн.', 'Увеличить приемистость', '175 м3/сут.', '210 м3/сут.' ],
            [false, 1, 299, 'Нагн.', 'Увеличить приемистость', '175 м3/сут.', '210 м3/сут.' ]
        ]
      },
      fact: {
        body:[
            ['Закачка', 'м3', 150, 120, -130],
            ['Добыча жидкости', 'м3', 150, 120, 130],
            ['Добыча нефти', 'м3', 150, 120, 130],
        ]
      },
      window_limitation: {
        body: [
            [254, 'доб', ' ', ' ', 65, 115, 53, 135],
            [299, 'нагн', 115, 193, ' ', ' ', ' ', ''],
            [452, 'доб', ' ', ' ', 65, 115, 53, 135]
        ]
      }
    }
  },
  computed:{
    ...waterfloodingManagementMapGetters([
      'kin',
    ]),
  },
  mounted() {
    if(this.modal_name == "object_1"){
      this.getKinLine(this.r_object.id)
      this.getMopInj(this.r_object.id)
      this.getWaterCut(this.r_object.id)
      this.getEVol(this.r_object.id)
    }
  },
  methods:{
    modalClose() {
      this.$emit('modalClose')
    },
    getKinLine(fieldObject){
      let url = process.env.MIX_WATERFLOODING_MANAGMENT +  'object_selections/field-object-kin/' + fieldObject + '/';
      axios.get(url)
          .then((response) =>{
            this.kinLine = response.data.kin;
          }).catch((error) => {
        console.log(error)
      })
    },
    getWaterCut(fieldObject){
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/water-cut/'+ fieldObject + '/'
      axios.get(url)
          .then((response) =>{
            response.data.forEach((element, index) => {
              this.seriesWaterCut[0].data.push({
                x: element,
                y: this.kin[index]
              })
            })
            let max = Math.max.apply(Math, this.kin)
            let x_max = Math.max.apply(Math, response.data)
            this.seriesWaterCut[1].data.push({
              x: 0,
              y: max
            })
            this.seriesWaterCut[1].data.push({
              x: x_max,
              y: max
            })
          }).catch((error) => {
        console.log(error)
      })
    },
    getMopInj(fieldObject){
      let series = [
          { type: 'line', data: []},
          { type: 'line', data: []}
      ]
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/mop-inj/'+ fieldObject + '/'
      axios.get(url)
          .then((response) =>{
            response.data.forEach((element, index) => {
              series[0].data.push({
                x: element,
                y: this.kin[index]
              })
            })
            let max = Math.max.apply(Math, this.kin)
            series[1].data.push({
              x: 0,
              y: max
            })
            series[1].data.push({
              x: 1,
              y: max
            })
            this.seriesMopInj = series
            return series
          }).catch((error) => {
        console.log(error)
      })
    },
    getEVol(fieldObject){
      let series = [
          { type: 'line', data: []},
          {type: 'line', data: []}
      ]
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/e-vol/'+ fieldObject + '/'
      axios.get(url)
          .then((response) =>{
            let data = response.data;
            let kinline = (this.kinLine * 100) / data.length
            let kinLineY = kinline
            data.forEach((element, index) => {
              series[0].data.push({
                x:element,
                y: this.kin[index]
              })
              series[1].data.push({
                x: (index + 1)/ data.length,
                y: kinLineY
              })
              kinLineY += kinline
            })
            this.seriesEVol = series;
          }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>
<style scoped>
.object__modal{
  background: linear-gradient(0deg, rgba(13, 43, 77, 0) 48%, #0d2b4d 50%, rgba(13, 43, 77, 0) 52%),
  linear-gradient(-90deg, rgba(13, 43, 77, 0) 48%, #0d2b4d 50%, rgba(13, 43, 77, 0) 52%);
  background-size: 3em 3em;
  background-color: #272953;
}
.wft__modal__body__scroll{
  max-height: 780px;
  overflow: auto;
  margin-top: 20px;
}
.window_limitation__scroll{
  max-height: 480px;
  overflow: auto;
  margin-top: 20px;
}
.wft__modal__body__scroll table,
.window_limitation__scroll table
{
  margin: 0;
}
.bg__card__color{
  background-color: #2B2E5E;
}
.window_limitation__table td{
  width: 12%;
}
.window_limitation{
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 13px 0;
  width: 100%;
}
.cell_compare{
  display: flex;
  align-items: center;
}
.cell_compare_title{
  width: 78px;
  height: 60px;
  border: 1px solid #323370;
  box-sizing: border-box;
  border-radius: 2px;
  padding: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: normal;
  font-size: 14px;
  line-height: 17px;
  text-align: center;
}
.cell_compare_sign{
  margin: 0 10px;
}
.cell_compare_button{
  height: 40px;
  width: 100px;
  background: #323370;
  border: 1px solid #272953;
  box-sizing: border-box;
  border-radius: 2px;
  font-weight: normal;
  font-size: 14px;
  line-height: 20px;
  color: #fff;
  text-align: center;
  padding: 10px;
}
.window_limitation_cell_out{
  border: 1px solid #fff;
  border-left: none;
}
.window_limitation_cell{
  height: 40px;
  width: 36.08px;
  background-color: #666666;
  border-left: 1px solid #fff;
}
.window__limitation__well,
.window_limitation__table input{
  background: #323370;
  border: 0.4px solid #272953;
  box-sizing: border-box;
  border-radius: 4px;
  color: #fff;
  height: 36px;
  width: 114px;
  padding: 10px;
}
.window_limitation_cell_green{
  background-color: #6EBB71;
}
.head_tr{
  display: flex;
  justify-content: space-around;
  border-bottom: 1px solid #454D7D;
}
.modal_table_td_center{
  border-left: 1px solid #454D7D;
  border-right: 1px solid #454D7D;
}
.wft__modal__window{
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 10000;
}
.wft__modal{
  width: 67%;
  border: 2px solid #656A8A;
  box-sizing: border-box;
  border-radius: 8px;
}
.wft__variant____modal{
  width: 516px;
  padding: 20px;
  border: 2px solid #656A8A;
  box-sizing: border-box;
  border-radius: 8px;
}
.wft__modal__close{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 30px;
  width: 100px;
  background: #656A8A;
  border-radius: 4px;
  color: #fff;
  outline: none;
  border: none;
  margin-left: 10px;
}
.wft__modal__save{
  background: #0ac71e;
}
.wft__modal__table{
  border-collapse: collapse;
  border: 1px solid #454D7D;
  margin-top: 14px;
}
.wft__modal__table td,
.wft__modal__table th{
  height: 60px;
  text-align: center;
  vertical-align: middle;
  font-weight: bold;
  font-size: 12px;
  line-height: 13px;
  border: 1px solid #454D7D;
  padding: 2px;
}
.wft__modal__table thead{
  background-color: #333975;
}
.period-btn{
  width: 90px!important;
  margin: 5px;
}
.object_graphic{
  margin-top: 20px;
  height: 400px;
  width: 45%;
}
.object_graphic img{
  height: 100%;
}
.object_graphic h2{
  font-size: 14px;
}
.variant__title{
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 19px;
}
.variant__btn{
  background: #40467E;
  border: none;
  height: 44px;
  padding: 0 34px;
  background: #333975;
  box-sizing: border-box;
  border-radius: 4px;
  text-align: center;
  vertical-align: middle;
  font-weight: bold;
  font-size: 14px;
  line-height: 17px;
  color: #FFFFFF;
  margin: 10px;
}
.variant__input{
  background: #1F2142;
  border: 0.5px solid #454FA1;
  box-sizing: border-box;
  border-radius: 4px;
  padding: 10px;
  margin-top: 14px;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 19px;
  color: rgba(255, 255, 255, 0.4);
}
.variant__card__block{
  margin-top: 10px;
}
.variant__dw__btn{
  background-color: #3366FF;
}
.table__graphic__modal{
  height: 803px;
}
.btn__table__graphic{
  width: 138px;
  height: 30px;
  background: #31335F;
  border: none;
  margin: 5px 5px 0 5px;
  border-radius: 5px 5px 0 0;
  font-size: 14px;
  line-height: 17px;
  text-align: center;
  color: #8389AF;
}
.btn__table__graphic__active{
  color: #fff;
  font-weight: 600;
  font-size: 14px;
  line-height: 17px;
  margin: 0;
  width: 143px;
  height: 35px;
}
.table__graphic__modal__body{
  padding: 10px;
  background: #363B68;
  border-radius: 5px;
}
.tb__table{
  padding: 10px;
  background-color: #363B68;
}
.tb__table td{
  height: 28px;
}
.tb__table__first{
  background-color: rgba(69, 77, 125, 0.32);
}
.tb__table__second{
  background-color: #272953;
}
.tb__table table{
  height: 100%;
  width: 100%;
  margin: 0;
}
.tb__table table tbody{
}
.tb__table__out{
  height: 688px;
  width: 100%;
  overflow: auto;
}
.tb__table .tb__table__out::-webkit-scrollbar {
  width: 7px;
}
.tb__table .tb__table__out::-webkit-scrollbar-thumb {
  border: 3px solid transparent;
  background: #656A8A;
  border-radius: 10px;
  box-shadow: inset 0 3px 3px rgba(0,0,0,0);
}
.tb__table .tb__table__out::-webkit-scrollbar-track {
  background-color: #20274F;
}
.tb__table__graphic{
  padding: 10px;
  background-color: #272953;
}
.tb__table__grShow{
  background: #2B2E5E;
  border: 0.5px solid #545580;
}
</style>