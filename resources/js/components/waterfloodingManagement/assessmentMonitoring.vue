<template>
  <div class="row m-0 p-0">
    <div class="wft__right__side m-0 p-0">
      <div class="row m-0 p-0">
        <div class="col-md-12 col-lg-12 col-xl-12 m-0 p-0">
          <div class="card-block" style="height: 500px">
            <div class="card-title justify-content-between">
              <p class="p-0 m-0 ">{{ trans('waterflooding_management.map_selection_object') }}</p>
              <a href="">
                <img src="/img/waterfloodingManagement/transition.svg" alt="">
              </a>
            </div>
            <div class="block" style="height: 92%">
              <MglMap v-if="injWellList"
                      ref="mgl-map"
                      :accessToken="accessToken"
                      :mapStyle ="mapStyle"
                      :center="center"
                      :boxZoom="true"
                      @load="onMapLoaded"
                      :zoom=11>
                <mgl-navigation-control position="bottom-right" />
                <MglMarker  v-for="c in getWells"
                            ref="mgl-marker"
                            :key="c[0]"
                            :coordinates="c.coordinate">
                  <div slot="marker">
                    <map-pie-chart :data_value="c.value"
                                   :wellName="c.well"
                                   :type="c.type"
                                   :radiusWidth="c.radius" />
                  </div>
                </MglMarker>
              </MglMap>
            </div>
          </div>
        </div>
        <div class="w-100 row m-0 p-0">
          <div class="col-md-6  m-0 p-0">
            <div class="card-block w-100 mr-5">
              <div class="card-title justify-content-between ">
                <p class="p-0 m-0 ">{{ trans('waterflooding_management.production_forecast') }}</p>
                <a href="">
                  <img src="/img/waterfloodingManagement/transition.svg" alt="">
                </a>
              </div>
              <div class="block block-graphic">
                <div>
                  <apexchart
                      type="line"
                      height="260"
                      :options="chartOptions"
                      :series="series"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6  m-0 p-0">
            <div class="card-block">
              <div class="card-title justify-content-between" style="margin-top: 0.75rem">
                <p class="p-0 m-0 ">{{ trans('waterflooding_management.recommendation')}}</p>
                <a href="">
                  <img src="/img/waterfloodingManagement/transition.svg" alt="">
                </a>
              </div>
              <div class="block">
                <table class="recomendation-table w-100">
                  <thead>
                  <tr>
                    <th>№ {{ trans('waterflooding_management.recommendation')}}</th>
                    <th>{{ trans('waterflooding_management.injection_wells')}}</th>
                    <th>{{ trans('waterflooding_management.current_injective_wells')}}</th>
                    <th>{{ trans('waterflooding_management.target_injective_wells')}}</th>
                    <th>{{ trans('waterflooding_management.difference')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="n in 4" :class="n==2? 'recomendation-table-green' : ''">
                    <td v-for="k in 5">10</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="wft__left__side p-0">
      <div class="card-block mt-0">
        <div class="card-title justify-content-between">
          <p class="p-0 m-0">{{ trans('waterflooding_management.selected_forecast_option')}}</p>
        </div>
        <div class="block d-flex justify-content-between">
          <button class="period-btn variant__btn w-100 d-flex justify-content-between align-items-center">
            <span>Вариант 1</span>
          </button>
        </div>
        <div class="block d-flex justify-content-between">
          <listTable
              v-bind:data="[
                        {title: this.trans('waterflooding_management.selected_object')},
                        {title: this.trans('waterflooding_management.first_object')},
                        {title: this.trans('waterflooding_management.selected_polygon')},
                        {title: this.trans('waterflooding_management.polygon_1')}
                        ]">
          </listTable>
        </div>
      </div>
      <div class="card-block">
        <listTable
            v-bind:data="[
                        {title: this.trans('waterflooding_management.selected_forecast_model')},
                        {title: this.trans('waterflooding_management.hybrid')},
                        {title: this.trans('waterflooding_management.optimization_task')},
                        {title: this.trans('waterflooding_management.maximizing_oil_production')}
                        ]">
        </listTable>
      </div>
      <div class="card-block">
        <div class="card-title">
          <p class="p-0 m-0">{{ trans('waterflooding_management.motiring_period')}}</p>
        </div>
        <div class="block d-flex ">
          <WFM-button-data-picker class="w-100" style="margin-right: 10px;"></WFM-button-data-picker>
          <WFM-button-data-picker class="w-100"></WFM-button-data-picker>
        </div>
      </div>
      <div class="card-block">
        <div class="card-title justify-content-between">
          <p class="p-0 m-0 ">{{ trans('waterflooding_management.plan_fact') }}</p>
          <a href="">
            <img src="/img/waterfloodingManagement/transition.svg" alt="">
          </a>
        </div>
        <div class="block">
          <table class="plan-fact-table w-100">
            <thead class="">
            <tr>
              <th></th>
              <th>План</th>
              <th>Факт</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in ['Количество', 'Закачка', 'Добыча жидкости', 'Добыча нефти']">
              <td> {{ item }}</td>
              <td>{{ index + 3}}</td>
              <td>{{ index * 2 }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <button class="prediction-btn">Выгрузить результаты</button>
    </div>
  </div>
</template>
<script>
import listTable from './list-table'
import {MglMap, MglNavigationControl, MglMarker} from 'vue-mapbox'
import {waterfloodingManagementMapGetters} from '@store/helpers';
import MapPieChart from "./mapPieChart";
import VueApexCharts from 'vue-apexcharts'
import axios from "axios";

export default {
  components: {
    listTable,
    "apexchart": VueApexCharts,
    MglMap,
    MglNavigationControl,
    MglMarker,
    MapPieChart
  },
  name: "assessmentMonitoring",
  data: function () {
    return {
      series: [{
        name: "Desktops",
        data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
      }],
      chartOptions: {
        chart: {
          height: 260,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Product Trends by Month',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'],
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
      },
      center: [65.72577732, 45.96753508],
      accessToken: process.env.MIX_MAPBOX_TOKEN,
      mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
      injWellList: null,
    }
  },
  computed: {
    ...waterfloodingManagementMapGetters([
      'wellList'
    ]),
    getWells(){ return this.wellList }
  },
  created() {
    this.map = null;
    this.drawLineList();
  },
  methods:{
    onMapLoaded(event){
      this.map = event.map
      for(let i=0;i<this.injWellList.length;i++){
        let prod = this.injWellList[i].prod
        for(let j=0;j<prod.length;j++){
          let lineColor = '';
          if (prod[j].coef >= 0.4) lineColor = 'green'
          else if (prod[j].coef < 0.4 &&
              prod[j].coef > 0.1 ) lineColor = 'yellow'
          else if (prod[j].coef <= 0.1) lineColor = 'red'
          let routeId = 'route' + i + j
          this.map.addSource(routeId, {
            'type': 'geojson',
            'data': {
              'type': 'Feature',
              'properties': {},
              'geometry': {
                'type': 'LineString',
                'coordinates': [
                  this.injWellList[i].coordinate,
                  prod[j].coordinate
                ]
              }
            }
          });
          this.map.addLayer({
            'id': routeId,
            'type': 'line',
            'source': routeId,
            'layout': {
              'line-join': 'round',
              'line-cap': 'round'
            },
            'paint': {
              'line-color': lineColor,
              'line-width': 3
            }
          });
        }
      }
    },
    drawLineList(){
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/draw-line/'
      axios.get(url)
          .then((response) =>{
            this.injWellList = response.data
          }).catch((error) => {
        console.log(error)
      });
    }
  }
}
</script>
<style scoped>
.variant__btn{
  margin-bottom: 15px;
  padding: 15px;
}
.prediction-btn {
  margin: 5px;
  width: calc(100% - 10px);
}
.table-cell,
table th,
table td,
table{
  border:1px solid #454D7D;
}
.plan-fact-table{
  border: 1px solid #454D7D;
}
.plan-fact-table td,
.plan-fact-table th{
  width: 33%;
  height: 32px;
  text-align: center;
  vertical-align: middle;
  font-weight: bold;
  font-size: 12px;
  line-height: 13px;
  border: 1px solid #454D7D;
}
.plan-fact-table thead{
  background-color: #333975;
}
.recomendation-table{
  border: 1px solid #454D7D;
  text-align: center;
  vertical-align: middle;
}
.recomendation-table th{
  width: 20%;
  height: 60px;
  background: #333975;
  border: 1px solid #454D7D;
  padding: 10px;
  font-weight: bold;
  font-size: 12px;
  line-height: 100%;
}
.recomendation-table td{
  height: 49px;
  background-color: #EFBD74;
  border: 1px solid #454D7D;
  font-weight: bold;
  font-size: 18px;
  line-height: 22px;
}
.recomendation-table-green td{
  background-color: #6EBB71;
}
</style>