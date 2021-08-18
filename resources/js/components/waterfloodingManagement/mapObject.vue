<template >
  <div id="wrapper" class="row m-0 p-0">
    <div class="col-md-12 col-xl-9 m-0 p-0  ">
      <div class=" row map-wells m-0">
          <div class="col-md-12 col-lg-2 col-xl-3 map-object d-flex align-items-center">
            <span> {{ trans('waterflooding_management.map_object') }}</span>
          </div>
          <div class="col-md-12 col-lg-10 col-xl-9">
            <div class="w-100 map-tool d-flex">
              <img src="/img/waterfloodingManagement/map-tools-icon.svg" alt="">
              <div class="d-flex align-items-center tool-title">
                {{ trans('waterflooding_management.toolbar') }}
              </div>
              <button class="btn">
                <img src="/img/waterfloodingManagement/map-tools-choose-map-button.svg" alt="">
              </button>
              <button class="btn">
                <img src="/img/waterfloodingManagement/map-tools-present-map-button.svg" alt="">
              </button>
              <button class="btn">
                <img src="/img/waterfloodingManagement/map-tools-accumulated-map-button.svg" alt="">
              </button>
              <button class="btn">
                <img src="/img/waterfloodingManagement/map-tools-highlight-map-button.svg" alt="">
              </button>
              <button class="btn">
                <img src="/img/waterfloodingManagement/map-tools-close-map-button.svg" alt="">
              </button>
              <button class="btn">Выбрать</button>
              <a href="" class="transition"><img src="/img/waterfloodingManagement/transition.svg" alt=""></a>
            </div>
        </div>
      </div>
      <div class="map-block">
        <div class="map-images">
          <img src="/img/waterfloodingManagement/mapoil.png" alt="">
        </div>
      </div>
    </div>
    <div class=" col-xl-3">
      <div class="w-100 choose-object">
        <div class="choose-object-title">{{ trans('waterflooding_management.object_selection') }}</div>
        <div class="choose-object-into">
          <div class="row m-0 p-0">
            <div class="col-4 d-flex align-items-center choose-object-select-title"> {{ trans('waterflooding_management.DZO') }}</div>
            <div class="col-8">
              <v-select
                  :options="dzo"
                  label="name"
                  v-model="defaultDzo"
              ></v-select>
            </div>
            <div class="col-4 d-flex align-items-center choose-object-select-title">{{ trans('waterflooding_management.field') }}</div>
            <div class="col-8">
              <v-select
                  :options="occurrence"
                  label="name"
                  v-model="defaultOccurrence"
              ></v-select>
            </div>
            <div class="col-4 d-flex align-items-center choose-object-select-title">{{ trans('waterflooding_management.object') }}</div>
            <div class="col-8">
              <v-select
                  :options="object"
                  label="name"
                  v-model="defaultObject"
                  @input="changeFieldObject"
              ></v-select>
            </div>
          </div>
        </div>
      </div>
      <div class="w-100 choose-object">
        <div class="choose-object-title">{{ trans('waterflooding_management.rating_object') }}</div>
        <div class="choose-object-into">
          <table class="choose-object-table w-100">
            <thead>
              <tr>
                <th scope="col">№</th>
                <th scope="col">ОИЗ, тыс. т.</th>
                <th scope="col">MOPVinj, д. ед.</th>
                <th scope="col">КИН,%</th>
                <th scope="col">VRRнакоп, %</th>
                <th scope="col">Score</th>
                <th scope="col">
                  <br>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="r in ratingObject">
              <th scope="row">{{ r.name }}</th>
              <td>{{ r.oiz }}</td>
              <td>{{ r.hcpv }}</td>
              <td>{{ r.kin }}%</td>
              <td>{{ r.vrr }}%</td>
              <td class="d-flex justify-content-center align-items-center">
                <button class="choose-object-score-btn">
                  <div :style="width(2)"></div>
                  <span>
                  {{ r.score }}
                  </span>
                </button>
              </td>
              <td><img src="/img/waterfloodingManagement/water-flooding-managment-choose-object-table.svg" alt="" @click="openModal('object_1', r)"></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="w-100 choose-object">
        <div class="choose-object-title">{{ trans('waterflooding_management.poligon') }}</div>
        <div class="choose-object-into">
          <table class="choose-object-table w-100">
            <thead class="">
            <tr>
              <th scope="">№  полигонов</th>
              <th scope="">Кол-во скважин</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>Полигон I</td>
              <td>5 доб, 1 нагн.</td>
            </tr>
            <tr>
              <td>Полигон I</td>
              <td>5 доб, 1 нагн.</td>
            </tr>
            <tr>
              <td>Полигон I</td>
              <td>5 доб, 1 нагн.</td>
            </tr>
            </tbody></table>
        </div>
      </div>
      <button class="w-100 choose-object prediction-btn" @click="menuClick(menu[1].component)" >
        {{ trans('waterflooding_management.build_forecast') }}
      </button>
    </div>
    <div class="col-md-12 col-xl-6  m-0 p-0">
      <div class="w-100 choose-object">
        <div class="choose-object-title d-flex justify-content-between">
          <p>
            {{ trans('waterflooding_management.current_indicators') }}
          </p>
          <div class="calendar-date">
          <dataPicker @dateChanged="getDate"></dataPicker>
          </div>
        </div>
        <div class="choose-object-into2">
          <div class="row  m-0 p-0">
            <div class="col-md-4 m-0 p-0" v-for="item in show_choose_object">
              <div class="info-for-object d-flex flex-column justify-content-around">
                <div class="info-object-title">
                  {{ item.title }}
                </div>
                <div class="info-object-detail">{{ item.count }} <span>{{ item.measure }}</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
    <div class="col-md-12 col-xl-6  ">
      <div class="w-100 choose-object">
        <div class="choose-object-title d-flex justify-content-between">
          <div class="btn-group">
            <button type="button" class="btn btn-setting">
              {{ trans('waterflooding_management.config_graphic') }}
            </button>
            <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="/img/waterfloodingManagement/Path.svg" alt="">
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" type="button" >День</a>
              <a class="dropdown-item" type="button" >Месяц</a>
            </div>
          </div>
          <div class="d-flex justify-content-between">
              <dataPickerRange @dateRangeChanged="dateRangeChanged"></dataPickerRange>
          </div>
        </div>
        <div class="choose-object-into2">
          <div class="row  m-0 p-0" >
            <LineChart
                :chartdata="datacollection"
                :width="getHalfWindowWidth"
                :options="options"
                :height="250"
            >
            </LineChart>
          </div>
        </div>
      </div>
    </div>
    <keep-alive>
      <WFM_modal
          :modal_name="modal_name"
          :r_object="r_object"
          v-if="modal_show"
          @modalClose="modalClose"
      ></WFM_modal>
    </keep-alive>
  </div>
</template>
<script>
import axios from "axios";
import moment from "moment"
import vSelect from 'vue-select'

import mainMenu from './main_menu.json'
import WFM_modal from './modal'
import dataPicker from './DatePicker'
import LineChart from './LineChart'
import dataPickerRange from "./dataPickerRange";

export default {
  components: {
    vSelect,
    WFM_modal,
    dataPicker,
    LineChart
  },
  created() {
    this.getDzo();
    this.getGraphic(1,1,1, '17.03.2021', '17.04.2021' )
    this.getRatingObject()
  },
  data: function () {
    return {
      r_object: {},
      options: {
        responsive: true,
        elements: {
          point:{
            radius: 0
          },
        },
        legend: {
          position:'bottom',
          labels: {
            fill: "#f00",
            fontColor: "#fff",
            fontSize: 14,
            useLineStyle: true,
          }
        },
        scales: {
          xAxes: [{
            ticks: {
              fontColor: "#fff",
            },
          }],
          yAxes: [{
            display: true,
            position: 'left',
            type: "linear",
            scaleLabel: {
              fontColor: '#fff',
              fontSize: 9,
              display: true,
              labelString: "Добыча жидкости, закачка – м3, нефти – т",
              beginAtZero: true,
            },
            ticks: {
              fontColor: "#fff",
            },
            id: "left_side"
          },{
            scaleLabel: {
              fontColor: '#fff',
              display: true,
              labelString: 'Обводненность, %',
              beginAtZero: true,
            },
            display: true,
            type: "linear",
            position:"right",
            gridLines: {
              display: false
            },

            ticks: {
              fontColor: "#fff",
              beginAtZero: true,
              steps: 10,
              stepValue: 5,
              max: 100
            },
            id: "right_side"
          }]

        }
      },
      ratingObject: [],
      windowWidth: 0,
      datacollection: null,
      modal_show: false,
      modal_name: '',
      dzo: [],
      defaultDzo: null,
      occurrence:[],
      defaultOccurrence: null,
      object:[
        { name: 'Объект I', id: 2},
        { name: 'Объект III', id: 3},
      ],
      defaultObject: null,
      show_choose_object:[
        {title: "Добыча жидкости", count: 0, measure: "м3"},
        {title: "Добыча нефти", count: 0, measure: "т." },
        {title: "Закачка", count: 0, measure: "м3"},
        {title: "Фонд добывающих", count: 0, measure: "скв."},
        {title: "Фонд нагнетательных", count: 0, measure: "скв."},
        {title: "Компенсация", count: 0, measure: "%"}
      ],
      menu: mainMenu,
    }
  },
  methods: {
    getRatingObject(){
      let url = 'http://127.0.0.1:8001/api/v1/object_selections/rating-object/'
      axios.get(url)
          .then((response) =>{
            this.ratingObject = response.data
          }).catch((error) => {
        console.log(error)
      })
    },
    getChooseObject(dzo, field, field_object, object_date){
      let url = 'http://127.0.0.1:8001/api/v1/object_selections/prod-list/?dzo='+ dzo
          + '&field=' + field
          + '&field_object=' + field_object
          + '&start_date=' + object_date;
      axios.get(url)
          .then((response) =>{
            if ( typeof response.data !== 'undefined' && response.data.length == 0){
              this.show_choose_object.forEach(function(part, index) {
                part.count = 0;
              });
            }
            else{
            let data = response.data
              this.show_choose_object.forEach(function(part, index) {
                part.count = data[index].count;
              })
            }

          }).catch((error) => {
        console.log(error)
      })
    },
    getDzo(){
      let url = 'http://127.0.0.1:8001/api/v1/object_selections/dzo/'
      axios.get(url)
          .then((response) =>{
            this.dzo = response.data
            this.defaultDzo = this.dzo[0]
            this.getField(this.defaultDzo.id);
          }).catch((error) => {
            console.log(error)
          });
    },
    getField(dzoId){
      let url = 'http://127.0.0.1:8001/api/v1/object_selections/field/' + dzoId + '/'
      axios.get(url)
          .then((response) =>{
            this.occurrence = response.data
            this.defaultOccurrence = this.occurrence[0]
            this.getFieldObject(this.defaultOccurrence.id)
          }).catch((error) => {
        console.log(error)
      });
    },
    getFieldObject(fieldId){
      let url = 'http://127.0.0.1:8001/api/v1/object_selections/field-object/' + fieldId + '/'
      axios.get(url)
          .then((response) =>{
            this.object = response.data
            this.defaultObject = this.object[0]
            this.getDate();
            this.dateRangeChanged()
          }).catch((error) => {
        console.log(error)
      });
    },
    changeFieldObject(){
      this.getDate()
      this.dateRangeChanged()
    },
    getGraphic(dzo, field, field_object, object_start_date, object_end_date){
      let url = 'http://127.0.0.1:8001/api/v1/object_selections/graphic/?dzo='+ dzo
          + '&field=' + field
          + '&field_object=' + field_object
          + '&start_date=' + object_start_date
          + '&end_date=' + object_end_date;
      axios.get(url)
          .then((response) =>{
            this.datacollection = {
              labels: response.data.labels,
              datasets: [
                {
                  borderColor: '#3366FF',
                  label: 'Закачка, м3/сут.',
                  data: response.data.sum_inj_water_vol,
                  yAxisID:'left_side',
                },
                {
                  borderColor: "#EFBD74",
                  color: '#fff',
                  label: 'Q нефти, т/сут.',
                  backgroundColor: '#efbd7466',
                  data: response.data.sum_oil_mass,
                  yAxisID:'left_side'
                },
                {
                  borderColor: "#6EBB71",
                  label: 'Q жидкости, т/сут.',
                  backgroundColor: '#6ebb7199',
                  data: response.data.data_set,
                  yAxisID:'left_side'
                },
                {
                  borderColor: '#02a6f2',
                  label: 'Обводненность',
                  data: response.data.sum_water_cut_vol,
                  borderDash: [10, 5],
                  yAxisID:'right_side',
                }
              ]
            }
          }).catch((error) => {
        console.log(error)
      })
    },
    getDate: function () {
      let dateString = moment(this.$store.getters['waterfloodingManagement/chooseObjectDate']).format('DD.MM.YYYY')
      this.getChooseObject(this.defaultDzo.id, this.defaultOccurrence.id, this.defaultObject.id, dateString )
    },
    dateRangeChanged: function(){
      let dateStart = moment(this.$store.getters['waterfloodingManagement/graphicStartDate']).format('DD.MM.YYYY');
      let dateEnd = moment(this.$store.getters['waterfloodingManagement/graphicEndDate']).format('DD.MM.YYYY');
      this.getGraphic(this.defaultDzo.id, this.defaultOccurrence.id, this.defaultObject.id, dateStart, dateEnd);
    },
    menuClick (childComponent) {
      this.$emit('menuClick', childComponent);
    },
    modalClose() {
      this.modal_show = false;
    },
    openModal(modal_name, r){
      this.modal_show = true;
      this.modal_name = modal_name;
      this.r_object = r
    },
    width(s){
      width: s+'%';
    }
  },
  computed: {
    getHalfWindowWidth(){
      return window.innerWidth / 2 - 100;
    },
  },
}
</script>
<style scoped>
  .btn-setting{
    font-weight: bold;
    font-size: 18px;
    line-height: 22px;
    color: #FFFFFF;
  }
    .map-wells{
      background-color: #272953;
      color: #FFFFFF;
      align-items: center;
      margin-top: 15px!important;
      padding: 10px 0;
    }
    .map-object{
      height:100%;
      text-align: start;
      border-right: 2px solid #454D7D;
    }
    .map-object span{
      margin-left: 8px;
      font-weight: bold;
      font-size: 21px;
      line-height: 25px;
    }
    .map-tool{
      position: relative;
    }
    .map-tool .transition{
      position: absolute;
      right: -11px;
      top: -4px;
    }
    .v-select{
      margin: 4px 0;
    }
    .map-tool .tool-title{
      margin-left: 13px;
      margin-right: 13px;
      font-weight: normal;
      font-size: 18px;
      line-height: 22px;
    }

    .map-tool button{
      height: 33px;
      background-color: #656A8A;
      padding: 0 18px;
      margin: 0 7px;

      font-weight: 600;
      font-size: 18px;
      line-height: 22px;
      text-align: center;
      color: #FFFFFF;
    }
    .map-block{
      height: 540px;
      width: 100%;
      padding: 5px;
      background-color: #F1EBDA;
    }
    .map-images{
      height: 100%;
      width: 100%;
      background-color: #F1EBDA;
    }
    .choose-object{
      background-color: #272953;
      padding: 10px 7px 7px 7px;
      margin-top: 15px;
    }
    .choose-object-into{
      background-color: #313560;
      color: #fff!important;
    }
    .choose-object-select-title{
      font-style: normal;
      font-weight: 600;
      font-size: 14px;
      line-height: 24px;
      color: #fff;
      padding-left: 8px;
    }
    .choose-object-into2{
      height: auto;
    }
    .choose-object-title{
      font-size: 18px;
      color: #fff;
    }
    .calendar-date{
      width: 124px;
    }
    .choose-object-table thead tr th{
      height: 39px;
      text-align: center;
      background: #333975;
      border: 1px solid #454D7D;
    }
    .choose-object-table tbody tr td,
    .choose-object-table tbody tr th{
      height: 25px;
      text-align: center;
      border: 1px solid #454D7D;
    }
    .choose-object-score-btn{
      width: 100%;
      height: 18px;
      border-radius: 5px;
      background: #1A1D46;
      color: #fff;
      position: relative;
      outline: none;
      border: none;
      z-index: 2;
    }
  .choose-object-score-btn div{
    width: 59%;
    height: 100%;
    background:  #2E50E9;

  }
  .choose-object-score-btn span{
    position: absolute;
    top: 0;
    left: 0;
  }
  .info-for-object{
    height: 120px;
    background: #2B2E5E;
    border: 1px solid #454D7D;
    border-radius: 1px;
    color: #fff;
    text-align: center;
    margin: 3px 5px;
  }
  .info-object-title{
    font-weight: bold;
    font-size: 18px;
    line-height: 22px;
    text-align: center;
  }
  .info-object-detail{
    font-style: normal;
    font-weight: bold;
    font-size: 60px;
    line-height: 72px;
    text-align: center;
    letter-spacing: -0.28px;
  }
  .info-object-detail span{
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 29px;
  }
</style>