<template >
  <div id="wrapper" class="row m-0 p-0">
    <div class="col-md-12 col-xl-9 m-0 p-0  ">
      <div class=" row map-wells m-0">
        <div class="col-md-12 col-lg-2 col-xl-3 map-object d-flex align-items-center">
          <span> {{ trans('waterflooding_management.map_object') }}</span>
        </div>
        <div class="col-md-12 col-lg-10 col-xl-9">
          <div class="w-100 map-tool d-flex justify-content-lg-end">
            <button class="btn">
              <img src="/img/waterfloodingManagement/map-tools-choose-map-button.svg" alt="">
            </button>
            <button class="btn">
              <img src="/img/waterfloodingManagement/map-tools-present-map-button.svg" alt="">
            </button>
            <button class="btn">
              <img src="/img/waterfloodingManagement/map-tools-accumulated-map-button.svg" alt="">
            </button>
            <button class="btn" @click="draw" :disabled='isDisabledDrawPolygon'>
              <img src="/img/waterfloodingManagement/map-tools-highlight-map-button.svg" alt="">
            </button>
            <button class="btn" @click="trash" :disabled='isDisabledDrawPolygon'>
              <img src="/img/waterfloodingManagement/map-tools-close-map-button.svg" alt="">
            </button>
            <button class="btn add__polygon" @click="addPolygon">Добавить полигон</button>
          </div>
        </div>
      </div>
      <div class="map-block">
        <div class="map-images" style="position: relative">
          <MglMap
              ref="mgl-map"
              :accessToken="accessToken"
              :mapStyle ="mapStyle"
              :center="center"
              :boxZoom="true"
              :zoom=11>
            <mgl-navigation-control position="bottom-right" />
            <MglMarker  v-for="c in getWells"
                        ref="mgl-marker"
                        :key="c[0]"
                        :coordinates="c.coordinate">
              <div slot="marker">
                <map-pie-chart
                    :data_value="c.value"
                    :wellName="c.well"
                    :type="c.type"
                    :radiusWidth="c.radius"
                />
              </div>
            </MglMarker>
          </MglMap>
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
                  id="mySelect"
                  class="style-chooser"
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
          <div class="choose-object-table w-100 polygon__head ">
            <div scope="" class="t__polygon t__head__element">№  полигонов</div>
            <div scope="" class="t_well__count t__head__element">Кол-во скважин</div>
            <div scope="" class="t_deleted__btn t__head__element">Удалить</div>
          </div>
          <div class="t_polygon__body" style="max-height: 99px; overflow: auto ">
            <div class="polygon__body__element"
                 v-for="(item, index) in getPolygon"
                 :class="item.isChoose? 'tr__click':''"
                 @click="choose__polygon(index)">
              <div class="t__polygon t_polygon_elemnt ">Полигон {{ index + 1 }}</div>
              <div class="t_well__count t_polygon_elemnt">{{ item.prod }} доб, {{ item.inj }} нагн.</div>
              <div class="t_deleted__btn t_polygon_elemnt">
                <button @click.stop="trash(item.id, index)" class="polygon__delete__btn">
                  <img src="/img/waterfloodingManagement/buttons/icons-delete.png" alt="">
                </button>
              </div>
            </div>
          </div>
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
          </div>
          <div class="d-flex justify-content-between">
            <dataPickerRange @dateRangeChanged="dateRangeChanged"></dataPickerRange>
          </div>
        </div>
        <div class="choose-object-into2">
          <apexchart
              ref="realtimeChart"
              type="line"
              height="250"
              :options="chartOptions"
              :series="series"/>
        </div>
      </div>
    </div>
    <WFM_modal
        :modal_name="modal_name"
        :r_object="r_object"
        v-if="modal_show"
        @modalClose="modalClose"
    ></WFM_modal>
  </div>
</template>
<script>
import mapWell from "./mapWell";
import axios from "axios";
import moment from "moment"
import vSelect from 'vue-select'
import mainMenu from './main_menu.json'
import mapWaterFloodingDrawStyle from './mapWaterFloodingDrawStyle.json'
import WFM_modal from './modal'
import dataPicker from './DatePicker'
import dataPickerRange from "./dataPickerRange"
import VueApexCharts from 'vue-apexcharts'
import {MglMap, MglNavigationControl, MglMarker} from 'vue-mapbox'
import {waterfloodingManagementMapGetters, waterfloodingManagementMapActions} from '@store/helpers';
import MapboxDraw from "@mapbox/mapbox-gl-draw";
import * as turf from '@turf/turf'
import MapPieChart from "./mapPieChart";

export default {
  components: {
    MapPieChart,
    vSelect,
    WFM_modal,
    dataPicker,
    dataPickerRange,
    "apexchart": VueApexCharts,
    MglMap,
    MglNavigationControl,
    MglMarker,
    mapWell
  },
  created() {
    this.map = null;
    this.getDzo();
    this.getGraphic(1,1,1, '17.04.2021', '17.05.2021' )
    this.getRatingObject()
  },
  data: function () {
    return {
      choose__polygons: [],
      isDisabledDrawPolygon: true,
      drawPolygon:[],
      yAsixMin: 0,
      markerCoordinates:'[50, 50]',
      accessToken: process.env.MIX_MAPBOX_TOKEN,
      mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
      center: [65.72577732, 45.96753508],
      coordinates: [
        {coordinate:[65.72577732, 45.96753508], value: 30, well_name: "AKB_244", radius: 100, type: 'inj'},
        {coordinate:[65.70349475, 45.95575476], value: 70, well_name: "AKB_245", radius: 50, type: 'prod'},
        {coordinate: [65.7121539, 45.92514497], value: 50, well_name: "AKB_246", radius: 150, type: 'inj'},
      ],
      series: [],
      chartOptions: {
        legend: {
          show: true,
          labels: {
            colors: '#fff',
            useSeriesColors: false
          },
        },
        chart: {
          height: 350,
          background: '#272953',
          type: 'line',
          toolbar: {show: false},
        },
        colors: ['#3366FF', '#EFBD74', 'rgba(110,187,113,0.4)', '#02a6f2'],
        markers: {
          size: [0, 0, 0, 0],
        },
        stroke: {
          width: [3, 3, 3, 3],
          curve: 'smooth',
          dashArray: [0, 0, 0, 5]
        },
        title:{
          style: {colors: '#ffffff'}
        },
        tooltip: {
          shared: false,
          intersect: true,
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
        xaxis: {
          labels: {
            style: {colors: '#fff'}
          }
        },
        yaxis: [
          {
            min: 1300,
            seriesName: 'Q жидкости, т/сут',
            showAlways: true,
            tickAmount: 6,
            dataLabels: {enabled: true},
            title: {
              text: ["Добыча жидкости, закачка – м3,"," нефти – т"],
              style: {color: '#fff'}
            },
            labels: {
              style: {colors: '#fff'}
            }
          },{
            seriesName: 'Q жидкости, т/сут',
            show: false
          },{
            seriesName: 'Q жидкости, т/сут',
            show: false
          },{
            min: 0,
            max: 100,
            showAlways: true,
            labels: {
              style: {colors: '#fff'}
            },
            opposite: true,
            seriesName: 'Обводненность',
            axisTicks: {show: true},
            axisBorder: {show: true},
            title: {
              text: "Обводненность %",
              style: {color: '#fff'}
            }
          }
        ],
      },
      r_object: {},
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
      mapWaterFlooding: null,
      mapWaterFloodingDraw: null,
      polygon: []
    }
  },
  mounted() {
    let map = this.$refs["mgl-map"]
    setTimeout(() => {
      this.map = map.map;
      this.isDisabledDrawPolygon = false;
      if(this.map != null){
        this.map.on('load', function (){
          map.resize();
        })
      }
      this.vSelectStyle();
    }, 2000);
    this.getWellList();
  },
  computed: {
    ...waterfloodingManagementMapGetters([
      'chooseObjectDate',
      'wellList',
      'graphicStartDate',
      'graphicEndDate',
    ]),
    getPolygon(){ return this.polygon },
    getWells(){ return this.wellList },
  },
  methods: {
    ...waterfloodingManagementMapActions([
      'getKin',
      'getWellList'
    ]),
    vSelectStyle(){
      let elements = document.getElementsByClassName('vs__selected');
      for(let i=0;i<elements.length;i++){
        elements[i].style.fontSize = '15px';
      }
    },
    choose__polygon(index){
      let polygon = this.polygon[index]
      polygon.isChoose = !polygon.isChoose;
      if(polygon.isChoose)
        this.mapWaterFloodingDraw.setFeatureProperty(polygon.id, 'portColor', '#2ab31c');
      else
        this.mapWaterFloodingDraw.setFeatureProperty(polygon.id, 'portColor', 'transparent');
      this.mapWaterFloodingDraw.add(this.mapWaterFloodingDraw.get(polygon.id))
    },
    trash(id, index){
      this.mapWaterFloodingDraw.delete(id)
      this.polygon.splice(index, 1)
    },
    draw(){
      if (this.mapWaterFloodingDraw == null) {
        this.mapWaterFloodingDraw = new MapboxDraw({
          displayControlsDefault: false,
          defaultMode: 'draw_polygon',
          iconSize: ['interpolate', ['linear'], ['zoom'], 10, 1, 15, 0.5],
          userProperties: true,
          controls: {
            'combine_features': false,
            'uncombine_features': false,
          },
          styles: mapWaterFloodingDrawStyle
        })
        this.map.addControl(this.mapWaterFloodingDraw);
        this.map.on('draw.create', this.updateArea);
        this.map.on('draw.delete', this.updateArea);
        this.map.on('draw.update', this.updateArea);
      }else{
        let delete_polygon = true
        let features = this.mapWaterFloodingDraw.getAll().features
        if (features.length > 0){
          let id = features[features.length - 1].id
          for(let i = 0;i < this.polygon.length;i++){
            if(this.polygon[i].id == id){
              delete_polygon = false;
              break;
            }
          }
          if(delete_polygon) this.mapWaterFloodingDraw.delete(id)
        }
        this.mapWaterFloodingDraw.changeMode('draw_polygon');
      }
    },
    addPolygon(){
      let data = this.mapWaterFloodingDraw.getAll();
      let features = data.features
      let well_points = []
      for (let i = 0; i < this.wellList.length; i++) {
        well_points.push(
            [
              this.wellList[i].coordinate[0],
              this.wellList[i].coordinate[1]
            ]
        )
      }
      data.features = [features[features.length - 1]]
      let polygon_push = true;
      for (let i=0;i<this.polygon.length;i++){
        if(data.features[0].id == this.polygon[i].id){
          polygon_push = false;
          break;
        }
      }
      if(polygon_push) {
        let points = turf.points(well_points);
        let ptsWithin = turf.pointsWithinPolygon(points, data);
        let inj = 0
        let prod = 0
        for (let i = 0; i < ptsWithin.features.length; i++) {
          for (let j = 0; j < this.wellList.length; j++) {
            if (this.wellList[j].coordinate[0] == ptsWithin.features[i].geometry.coordinates[0]
                && this.wellList[j].coordinate[1] == ptsWithin.features[i].geometry.coordinates[1]) {
              if (this.wellList[j].type === 'inj') {
                inj += 1
              } else {
                prod += 1
              }
            }
          }
        }
        this.polygon.push({inj: inj, prod: prod, id: data.features[0].id, isChoose: false})
      }
    },
    updateArea(e) {

    },
    getRatingObject(){
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/rating-object/'
      axios.get(url)
          .then((response) =>{
            this.ratingObject = response.data
          }).catch((error) => {
        console.log(error)
      })
    },
    getChooseObject(dzo, field, field_object, object_date){
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/prod-list/?dzo='+ dzo
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
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/dzo/'
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
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/field/' + dzoId + '/'
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
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/field-object/' + fieldId + '/'
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
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/graphic/?dzo='+ dzo
          + '&field=' + field
          + '&field_object=' + field_object
          + '&start_date=' + object_start_date
          + '&end_date=' + object_end_date;
      axios.get(url)
          .then((response) =>{
            this.series = [
              {name:"Закачка, м3/сут.", type: 'line', data:[]},
              {name:"Q нефти, т/сут.", type: 'area', data:[]},
              {name:"Q жидкости, т/сут.", type: 'area', data:[]},
              {name:"Обводненность", type: 'line', data:[]}
            ]
            for(let i = 0; i < response.data.labels.length; i++){
              this.series[0].data.push({
                x: response.data.labels[i],
                y: response.data.sum_inj_water_vol[i]
              })
              this.series[1].data.push({
                x: response.data.labels[i],
                y: response.data.sum_oil_mass[i]
              })
              this.series[2].data.push({
                x: response.data.labels[i],
                y: response.data.data_set[i]
              })
              this.series[3].data.push({
                x: response.data.labels[i],
                y: response.data.sum_water_cut_vol[i]
              })
            }
          }).catch((error) => {
        console.log(error)
      })
    },
    getDate: function () {
      let dateString = moment(this.chooseObjectDate).format('DD.MM.YYYY')
      this.getChooseObject(this.defaultDzo.id, this.defaultOccurrence.id, this.defaultObject.id, dateString )
    },
    dateRangeChanged: function(){
      let dateStart = moment(this.graphicStartDate).format('DD.MM.YYYY');
      let dateEnd = moment(this.graphicEndDate).format('DD.MM.YYYY');
      if (this.defaultObject != null)
        this.getGraphic(this.defaultDzo.id, this.defaultOccurrence.id, this.defaultObject.id, dateStart, dateEnd);
    },
    menuClick (childComponent) {
      this.$emit('menuClick', childComponent);
    },
    modalClose() {
      this.modal_show = false;
    },
    openModal(modal_name, r){
      this.getKin(r.id)
      this.modal_show = true;
      this.modal_name = modal_name;
      this.r_object = r
    },
    width(s){
      width: s+'%';
    }
  },
}
</script>
<style scoped>
#map { position: absolute; top: 0; bottom: 0; width: 100%; }
.map{
  margin: 0;
}
.tr__click{
  background-color: #2ab31c;
}
.polygon__head{
  display: flex;
  border: 1px solid #454D7D;
  border-left: none;
  height: 43px;
  background-color: #333975;
}
.polygon__head .t__head__element{
  display: flex;
  justify-content: flex-start;
  align-items: center;
  border-left: 1px solid #454D7D;
  height: 100%;
  padding: 3px;
}
.t_polygon__body::-webkit-scrollbar {
  width: 7px;
}
.t_polygon__body::-webkit-scrollbar-thumb {
  border: 3px solid transparent;
  background: #656A8A;
  border-radius: 10px;
  box-shadow: inset 0 3px 3px rgba(0,0,0,0);
}
.t_polygon__body::-webkit-scrollbar-thumb {
  background-color: #20274F;
  border-radius: 10px;
}
.polygon__body__element{
  display: flex;
  align-items: center;
  height: 33px;
  border: 1px solid #454D7D;
  border-top: none;
  border-left: none;


}
.t_polygon_elemnt{
  display: flex;
  justify-content: flex-start;
  padding: 5px;
  border-left: 1px solid #454D7D;
  height: 100%;
}
.polygon__delete__btn{
  padding: 3px;
  outline: none;
  border: none;
  border-radius: 5px;
  background: #3366ff;
}
.polygon__delete__btn img{
  height: 20px;
}

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
.map-tool .add__polygon{
  background-color: #3366FF;
}
.v-select{
  margin: 4px 0;
  min-width: 0!important;
}
#mySelect   .v-select {
  background-color: red!important;
}
.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle,
.style-chooser .vs__dropdown-menu {
  background: #dfe5fb;
  border: none;
  color: #394066;
  text-transform: lowercase;
  font-variant: small-caps;
}
.vs__selected{
  font-size: 12px!important;
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
.t_deleted__btn{
  width: 66px;
  display: flex;
  justify-content: center;
  padding: 3px;
}
.t__polygon{
  width: 120px;
}
.t_well__count{
  width: 165px;
}
</style>