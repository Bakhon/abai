<template>
  <div class="row m-0 p-0">
    <div class="wft__right__side ">
      <div class="card-block mt-0">
        <div class="card-title justify-content-between ">
          <p>{{ trans('waterflooding_management.total_selection') }}</p>
          <div class="total-selection d-flex ">
            <div class="total-selection-blue d-flex align-items-center">
              <span v-for="item in getInjWellNames">{{item}},</span>
            </div>
            <div class="total-selection-red">
              <span v-for="item in getProdWellNames">{{item}} <span>,</span></span>
            </div>
          </div>
        </div>
        <div class="block block-graphic">
          <div>
            <apexchart
                type="line"
                height="500"
                :options="chartOptions"
                :series="series"/>
            <div  class="d-flex flex-wrap justify-content-center" >
              <div class="d-flex justify-content-around flex-wrap" style="width: 90%;" >
                <div class="d-flex flex-column"  style="width: 33%; " >
                  <div class="d-flex"  v-for="(s, index) in series" v-if="index<3">
                    <div><img :src="s.img" alt=""></div>
                    <div style="margin-left: 10px"> {{ s.name }}</div>
                  </div>
                </div>
                <div class="d-flex flex-column" style="width: 33%" >
                  <div class="d-flex"  v-for="(s, index) in series" v-if="index>2 && index<6">
                    <div><img :src="s.img" alt=""></div>
                    <div style="margin-left: 10px"> {{ s.name }}</div>
                  </div>
                </div>
                <div class="d-flex flex-column" style="width: 33%" >
                  <div class="d-flex"  v-for="(s, index) in series" v-if="index>5">
                    <div><img :src="s.img" alt=""></div>
                    <div style="margin-left: 10px"> {{ s.name }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex">
        <div class="card-block percent-card" v-for="(total, index) in total_selection_card">
          <div class="card-title" :class="index==total_selection_card.length - 1?'justify-content-between':'justify-content-center'">
            <div></div>
            <p>{{ total.title }}</p>
            <a v-if="index==total_selection_card.length - 1" @click="openModal('table_graphic')">
              <img src="/img/waterfloodingManagement/transition.svg" alt="">
            </a>
          </div>
          <div class="h-100 block percent-block d-flex justify-content-center align-items-center">
            <div class="d-flex align-items-center">
              <p style="margin-bottom: 0">{{total.count }}</p>
              <div class="d-flex flex-column ">
                <img :src="total.img" alt="">
                <span class="measurement" v-html="total.measurement">
              </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="wft__left__side   d-flex flex-column justify-content-between ">
      <div class="wtf__left__forecasting h-100">
        <div class="card-block bg__card__block">
          <div class="card-title justify-content-between">
            <p class="p-0 m-0">{{ trans('waterflooding_management.selected_forecast_option')}}</p>
          </div>
          <div class="block d-flex justify-content-between">
            <button class="period-btn variant__btn w-100 d-flex justify-content-between align-items-center" @click="openModal('variant')">
              <span>?????????????? 1</span>
              <img src="/img/waterfloodingManagement/pencil.svg" alt="">
            </button>
          </div>
        </div>

        <div class="card-block bg__card__block">
          <listTable
              v-bind:data="[
                          {title: this.trans('waterflooding_management.selected_object')},
                          {title: this.trans('waterflooding_management.first_object')},
                          {title: this.trans('waterflooding_management.selected_polygon')},
                          {title: this.trans('waterflooding_management.polygon_1')}
                          ]">

          </listTable>
        </div>
        <div class="card-block bg__card__block">
          <div class="card-title justify-content-between">
            <p class="p-0 m-0">{{ trans('waterflooding_management.forecast_period')}}</p>
          </div>
          <div class="block d-flex justify-content-between">
            <button class="period-btn" v-for="item in [30, 90]">
              {{ item }} ????????
            </button>
          </div>
        </div>
        <div class="card-block bg__card__block">
          <div class="card-title justify-content-between m-0">
            <p class="p-0 m-0 ">{{ trans('waterflooding_management.setting_restrictions')}}</p>
            <a @click="openModal('window_limitation')">
              <img src="/img/waterfloodingManagement/transition.svg" alt="">
            </a>
          </div>
        </div>
        <div class="card-block bg__card__block">
          <div class="card-title justify-content-between" @click="showBtnToggle('2')">
            <p>?????????? ???????????? ????????????????</p>
            <img src="/img/waterfloodingManagement/down.png" class="show__down__btn__over" alt="" v-bind:class="{ show__btn__over: show__btn == 2 }">
          </div>
          <div class="block show__over" v-bind:class="{ show__btn__active: show__btn == 2 }">
            <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/physical_model.svg" alt="">{{ trans('waterflooding_management.physical_model')}}</button>
            <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/machine_learn.svg" alt="">{{ trans('waterflooding_management.machine_learn')}}</button>
            <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/physical_model.svg" alt="">{{ trans('waterflooding_management.hybird') }}</button>
          </div>
        </div>
        <div class="card-block bg__card__block">
          <div class="card-title justify-content-between" @click="showBtnToggle('1')">
            <p>?????????? ?????????????????????????????? ????????????</p>
            <img src="/img/waterfloodingManagement/down.png" class="show__down__btn__over" alt="" v-bind:class="{ show__btn__over: show__btn == 1 }">
          </div>
          <div class="block show__over" v-bind:class="{ show__btn__active: show__btn == 1 }">
            <!--        <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/physical_model.svg" alt="">{{ trans('waterflooding_management.rpl_recovery')}}</button>-->
            <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/machine_learn.svg" alt="">{{ trans('waterflooding_management.maximizing_oil_production')}}</button>
            <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/physical_model.svg" alt="">{{ trans('waterflooding_management.reduced_water_production') }}</button>
          </div>
        </div>
      </div>
      <div class="forecasting__btn__group">
        <button class="prediction-btn action-btn" @click="openModal('recommendation_implementation')">{{ trans('waterflooding_management.optimize')}} </button>
        <button class="prediction-btn action-btn" @click="openModal('fact')">{{ trans('waterflooding_management.edit')}}</button>
        <button class="prediction-btn action-btn" >{{ trans('waterflooding_management.save')}}</button>
        <button class="prediction-btn action-btn" >{{ trans('waterflooding_management.monitoring')}}</button>
      </div>
    </div>
    <keep-alive>
      <WFM_modal
          :modal_name="modal_name"
          v-if="modal_show"
          @modalClose="modalClose"
      ></WFM_modal>
    </keep-alive>
  </div>
</template>
<script>
import WFM_modal from './modal'
import waringModal from './components/warningModal'
import VueApexCharts from 'vue-apexcharts'
import {waterfloodingManagementMapActions, waterfloodingManagementMapGetters} from '@store/helpers';
import listTable from './components/list-table'

export default {
  name: "forecastingOptimization",
  components: {
    "apexchart": VueApexCharts,
    WFM_modal,
    waringModal,
    listTable
  },
  data: function () {
    return {
      series: [
        { type: 'line', name: '?????????????????????? ?????????? ????????????????, ??3', data: [], img: '/img/waterfloodingManagement/water_cut.svg'},
        { type: 'line', name: '???????????????????????????????? ?????????????? ???????????? ????????????????, ??3', data: [], img: '/img/waterfloodingManagement/water_cut2.svg'},
        { type: 'line', name: '?????????????? ?????????????? ???????????? ????????????????, ??3', data: [], img: '/img/waterfloodingManagement/water_cut3.svg'},

        { type: 'line', name: '?????????????????????? ?????????? ??????????, ??', data: [],  img: '/img/waterfloodingManagement/oil.svg'},
        { type: 'line', name: '???????????????????????????????? ?????????????? ???????????? ??????????, ??', data: [],  img: '/img/waterfloodingManagement/dot_oil.svg'},
        { type: 'line', name: '?????????????? ?????????????? ???????????? ??????????, ??', data: [],  img: '/img/waterfloodingManagement/dot_oil2.svg'},

        { type: 'line', name: '?????????????????????? ??????????????, ??3 ', data: [], img: '/img/waterfloodingManagement/Vector.svg'},
        { type: 'line', name: '???????????????????????????????? ?????????????? ??????????????, ??3', data: [], img: '/img/waterfloodingManagement/dotline2.svg'},
        { type: 'line', name: '?????????????? ?????????????? ??????????????, ??3', data: [], img: '/img/waterfloodingManagement/dotline.svg' }
      ],
      chartOptions: {
        chart: {
          height: 500,
          type: 'line',
          toolbar: { show: false },
        },
        colors: [ '#2C44BD',
          '#2C44BD',
          '#2C44BD',
          '#F94A5B', '#F94A5B', '#F94A5B', '#09A310', '#09A310', '#09A310'],
        tooltip: {
          enabled: true,
          custom: null,
        },
        legend: {
          show: false,
          labels: {
            colors: '#fff',
            useSeriesColors: false,
          },
          markers: {
            customHTML: [
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
              function(){return "<div> <img src='/img/waterfloodingManagement/Vector.svg' alt=''> gffffff</div>"},
            ]
          }
        },
        stroke: {
          width: [3, 3, 3, 3, 3, 3, 3, 3, 3],
          curve: 'smooth',
          strokeDash: 23,
          dashArray: [0, 6, 2, 0, 6, 2, 0, 6, 2]
        },
        grid: {
          borderColor: '#3C4270',
          strokeDashArray: 0,
          xaxis: {
            lines: {show: true}
          },
          yaxis: {
            lines: {show: true}
          },
        },
        yaxis:[
          {
            seriesName: '???????????????????????????????? ?????????????? ???????????? ????????????????, ??3',
            show: false,
          },
          {seriesName: '???????????????????????????????? ?????????????? ???????????? ????????????????, ??3',
            show: false,
          },
          {
            seriesName: '???????????????????????????????? ?????????????? ???????????? ????????????????, ??3',
            show: false,
          },
          {seriesName: '???????????????????????????????? ?????????????? ???????????? ????????????????, ??3',
            show: true,
            labels: {
              formatter: function(val) {
                if (val == null)
                  return 0;
                return val.toFixed(0);
              },
              style: {
                colors: '#fff'
              }
            },
            title: {
              text: "???????????? ????????????????(??3) ?? ??????????(??)",
              style: {color: '#fff'}
            }
          },
          {seriesName: '???????????????????????????????? ?????????????? ???????????? ????????????????, ??3',
            show: false,
          },
          {
            seriesName: '???????????????????????????????? ?????????????? ???????????? ????????????????, ??3',
            show: false,
          },
          {
            seriesName: '???????????????????????????????? ?????????????? ??????????????, ??3',
            show: true,
            opposite: true,
            labels: {
              formatter: function(val) {
                if (val == null)
                  return 0;
                return val.toFixed(0);
              },
              style: {
                colors: '#ffffff'
              }
            },
            title: {
              text: "?????????????? (??3)",
              style: {color: '#fff'}
            }
          },
          {
            seriesName: '???????????????????????????????? ?????????????? ??????????????, ??3',
            show: false,
            opposite: true,
          },
          {
            seriesName: '???????????????????????????????? ?????????????? ??????????????, ??3',
            show: false,
            opposite: true,
          }
        ],
        xaxis: {
          labels: {
            style: {colors: '#fff'}
          }
        },
      },
      show__btn: '1',
      modal_show: false,
      modal_name: '',
      total_selection_card: [
        {title: this.trans('waterflooding_management.fluid_change'), count: 185, img: '/img/waterfloodingManagement/triangle.svg', measurement: '??<sup>3</sup>'},
        {title: this.trans('waterflooding_management.oil_change'), count: 12, img: '/img/waterfloodingManagement/triangle-green.svg', measurement: '??.'},
        {title: this.trans('waterflooding_management.change_water_cut'), count: '2', img: '/img/waterfloodingManagement/triangle-red.svg', measurement: '%'},
        {title: this.trans('waterflooding_management.change_upload'), count: 887, img: '/img/waterfloodingManagement/triangle.svg', measurement: '??<sup>3</sup>'},
        {title: this.trans('waterflooding_management.reservoir_pressure'), count: 121, img: '/img/waterfloodingManagement/triangle.svg', measurement: '??????.'},
      ],

    };
  },
  computed:{
    ...waterfloodingManagementMapGetters([
      'totalSelection',
      'reverse_gr_table',
      'polygonWells',
      'clustersList'
    ]),
    getInjWellNames(){
      let injWells = new Set();
      let cluster = this.clustersList
      this.polygonWells.forEach(function(el) {
        for(let i=0;i<cluster.length;i++){
          if (el.well == cluster[i].inj_well || cluster[i].names_wells.includes(el.well)){
            injWells.add(cluster[i].inj_well.split('_')[1])
          }
        }
      })
      return injWells
    },
    getProdWellNames(){
      let prodWells = new Set();
      let cluster = this.clustersList
      this.polygonWells.forEach(function(el) {
        for(let i=0;i<cluster.length;i++){
          if (el.well == cluster[i].inj_well || cluster[i].names_wells.includes(el.well)){
            cluster[i].names_wells.forEach(function(e){
              prodWells.add(e.split('_')[1])
            })
          }
        }
      })
      return prodWells
    }
  },
  methods:{
    ...waterfloodingManagementMapActions([
      'getTotalSelection',
    ]),
    showBtnToggle(f){
      if (this.show__btn == f)
        this.show__btn = '';
      else
        this.show__btn = f;
    },
    modalClose() {
      this.modal_show = false;
    },
    openModal(modal_name){
      this.modal_show = true;
      this.modal_name = modal_name;
    },
    getRealDateList(){
      let real_date = []
      let predict_date = []
      real_date = this.totalSelection.real_date
      predict_date = this.totalSelection.predict_date

      let all_date = real_date.concat(predict_date)
      this.chartOptions.xaxis.categories = all_date
      all_date.forEach((element, i) => {
        this.series[0].data.push({
          x: element,
          y: this.totalSelection.data_real[i]
        })
        this.series[1].data.push({
          x: element,
          y: this.totalSelection.pred_data_basic[i]
        })
        this.series[2].data.push({
          x: element,
          y: this.totalSelection.pred_data_optim[i]
        })

        this.series[3].data.push({
          x: element,
          y: this.totalSelection.e_data_real[i]
        })
        this.series[4].data.push({
          x: element,
          y: this.totalSelection.e_data_prediction_crmp_real[i]
        })
        this.series[5].data.push({
          x: element,
          y: this.totalSelection.e_data_prediction_crmp_prediction[i]
        })

        this.series[6].data.push({
          x: element,
          y: this.totalSelection.u_data_real[i]
        })
        this.series[7].data.push({
          x: element,
          y: this.totalSelection.u_data_pred_basic[i]
        })
        this.series[8].data.push({
          x: element,
          y: this.totalSelection.u_data_pred_optim[i]
        })
      })
    },
  }
}
</script>
<style scoped>
.total-selection{
  background: #454D7D;
  border: 1px solid #454D7D;
  box-sizing: border-box;
  width: calc( 100% - 280px);
  padding: 5px 10px 0 10px;
}
.total-selection .total-selection-blue{
  color:#82BAFF;
}
.total-selection .total-selection-red{
  color: #EF5350;
  margin-left: 20px;
}
.percent-card{
  height: 253px;
}
.percent-block p{
  font-weight: bold;
  font-size: 80px;
  line-height: 96px;
  letter-spacing: -0.28px;
  margin-right: 14px;
}
.card-block .block .task-btn{
  width: 100%;
  height: 46px;
  background: #333975;
  border-radius: 4px;
  border: none;
  margin: 4px 0;
  padding: 0 16px;
  vertical-align: middle;
  text-align: left;
  font-weight: bold;
  font-size: 18px;
  line-height: 22px;
  color: #FFFFFF;
}
.card-block .block .task-btn img{
  margin-right: 10px;
}
.action-btn{
  width: calc(50% - 10px);
  margin: 4px;
}
.wtf__left__forecasting{
  padding: 10px;
  background-color: #272953;
}
.bg__card__block{
  background-color: #2B2E5E;
}
.variant__btn{
  height: 48px!important;
  padding: 0 12px;
  background-color: #334296!important;
  border: 1px solid #454FA1;
  box-sizing: border-box;
  border-radius: 4px;
}
.show__btn__active{
  max-height: 200px!important;
  transition: max-height 1500ms;
}
.show__btn__over {
  transform: rotate( 180deg )!important;
  transition: transform 1500ms ease;
}
.show__down__btn__over{
  transform: rotate( 0deg );
  transition: transform 1500ms ease;
}
.show__over{
  max-height: 0;
  overflow: hidden;
  transition: max-height 1500ms;
}
.forecasting__btn__group{
  margin-top: 15px;
}
.measurement{
  font-weight: bold;
  font-size: 24px;
  margin-top: 18px;
}
</style>