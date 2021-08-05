<template>
  <div class="row m-0 p-0">
    <div class="wft__right__side m-0 p-0">
      <div class="row m-0 p-0">
        <div class="col-md-12 col-lg-12 col-xl-6 m-0 p-0">
          <div class="card-block">
            <div class="card-title justify-content-between">
              <p class="p-0 m-0 ">{{ trans('waterflooding_management.map_selection_object') }}</p>
              <a href="">
                <img src="/img/waterfloodingManagement/transition.svg" alt="">
              </a>
            </div>
            <div class="block">
              <div>
                <img src="/img/waterfloodingManagement/map_selection_object.png" class="w-100" alt="" >
              </div>
            </div>
            <div class="block">
              <table class="map-table">
                <thead>
                  <tr>
                    <th class="map-table-first"></th>
                    <th v-for="n in 30" class="map-table-first-split"> {{ n }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in map_tables_data">
                    <td class="map-table-first">{{ item.title }}</td>
                    <td v-for="n in 30" :class="index%2==1 ? 'map-table-first-split': ''"> {{ n + 1}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="block d-flex" style="">
              <div class="d-flex align-items-end histogram__rotate__text">
                <span>
                  {{ trans('waterflooding_management.number_of_elements') }}
                </span>
              </div>
              <div class="histogram__number">
                <div v-for="n in 8" >{{n}}</div>
              </div>
              <div class="w-100">
                <div class="table-cell">
                  <div v-for="n in 8" class="cell-row"></div>
                  <div class="w-100 d-flex table-cell__histogram">
                    <div class="d-flex align-items-end histogram__scale" v-for="n in 30" style="">
                      <div class='w-100' style="height: calc(100%/8*4); "></div>
                    </div>
                  </div>
                </div>
                <div class="w-100 d-flex histogram__scale__number">
                  <div class="d-flex justify-content-center align-items-center" v-for="n in 30">{{n}}</div>
                </div>
              </div>
            </div>
            <div class="block d-flex justify-content-center">
              <div class="graphic-text w-100 d-flex align-items-center justify-content-center">
                <img src="/img/waterfloodingManagement/lines/green_line.svg" alt=""  >
                <p class="p-0 " style="">{{ trans('waterflooding_management.optimized') }}</p>
              </div>
              <div class="graphic-text w-100 d-flex align-items-center justify-content-center">
                <img src="/img/waterfloodingManagement/lines/green_line.svg" alt=""  >
                <p class="p-0 " style="">{{ trans('waterflooding_management.promising') }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 m-0 p-0">
          <div class="card-block">
            <div class="card-title justify-content-between ">
              <p class="p-0 m-0 ">{{ trans('waterflooding_management.production_forecast') }}</p>
              <a href="">
                <img src="/img/waterfloodingManagement/transition.svg" alt="">
              </a>
            </div>
            <div class="block block-graphic">
              <div>
                <img src="/img/waterfloodingManagement/Group 1199 (1).png" class="w-100" alt="" style="padding:20px" >
              </div>
              <div class="row graphic-prompt">
                <div class="col-md-6 col-xl-6 m-0 p-0 " v-for="items in prediction">
                  <div class="graphic-text w-100 d-flex align-items-center" v-for="item in items">
                    <img src="/img/waterfloodingManagement/lines/green_line.svg" alt="" style="width:40px" >
                    <p class="p-0 " style=""> {{ item }}</p>
                  </div>
                </div>
              </div>
            </div>
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
    <div class="wft__left__side p-0">
      <div class="card-block">
        <div class="card-title justify-content-between">
          <p class="p-0 m-0">{{ trans('waterflooding_management.option_name')}}</p>
        </div>
        <div class="block">
          <v-select
              :options="dzosForFilter"
              label="name"
              :placeholder="placeholder"
          ></v-select>
        </div>
        <div class="block d-flex justify-content-between">
          <list_table
              v-bind:data="[
                        {title: this.trans('waterflooding_management.selected_object')},
                        {title: this.trans('waterflooding_management.first_object')},
                        {title: this.trans('waterflooding_management.selected_polygon')},
                        {title: this.trans('waterflooding_management.polygon_1')}
                        ]">

          </list_table>
        </div>
      </div>

      <div class="card-block">
        <list_table
            v-bind:data="[
                        {title: this.trans('waterflooding_management.selected_forecast_model')},
                        {title: this.trans('waterflooding_management.hybrid')},
                        {title: this.trans('waterflooding_management.optimization_task')},
                        {title: this.trans('waterflooding_management.maximizing_oil_production')}
                        ]">

        </list_table>
      </div>

      <div class="card-block">
        <div class="card-title">
          <p class="p-0 m-0">{{ trans('waterflooding_management.motiring_period')}}</p>
        </div>
        <div class="block d-flex ">
            <buttonDataPicker class="w-100" style="margin-right: 10px;"></buttonDataPicker>
            <buttonDataPicker class="w-100"></buttonDataPicker>
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
                <th>{{ trans('waterflooding_management.plan')}}</th>
                <th>{{ trans('waterflooding_management.fact') }}</th>
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
      <button class="prediction-btn">{{ trans('waterflooding_management.upload_results')}}</button>
    </div>
  </div>
</template>
<script>
import vSelect from 'vue-select'
import buttonDataPicker from "./buttonDataPicker";
import list_table from './list-table'
export default {
  components: {
    vSelect,
    buttonDataPicker,
    list_table
  },
  name: "assessmentMonitoring",
  data: function () {
    return {
      dzosForFilter: [
        { name: 'Вариант 1'},
        { name: 'Вариант 2'},
        { name: 'Вариант 3'},
        { name: 'Вариант 4'},
        { name: 'Вариант 5'},
        { name: 'Вариант 6'},
        { name: 'Вариант 7'}
      ],
      map_tables_data: [
        {title: this.trans('waterflooding_management.daily_oil_production_t')},
        {title: this.trans('waterflooding_management.daily_oil_production')},
        {title: this.trans('waterflooding_management.optimization_evolution')}
      ],
      prediction: [
          ['Базовый прогноз дебита жидкости', 'Фактический дебит жидкости', 'Оптимизированный прогноз дебита жидкости'],
          ['Базовый прогноз дебита нефти', 'Фактический дебит нефти', 'Оптимизированный прогноз дебита нефти']
      ]
    }
  },
  computed: {
    placeholder: function(){
      return 'Загрузите вариант'
    }
  },
}
</script>
<style scoped>
.prediction-btn {
  margin: 5px;
  width: calc(100% - 10px);
}
.cell-row{
  height: 14px;
  border-top: 1px solid #454D7D;
}
.table-cell{
  position: relative;
}
.table-cell__histogram{
  position: absolute;
  top:0;
  left:0;
  height: 100%;
}
.histogram__rotate__text{
  width: 14px;
}
.histogram__rotate__text span{
  display: inline-block;
  white-space:nowrap;
  transform: rotate(-90deg);
  transform-origin: left center;
}
.histogram__number{
  width: 5px;
  margin:5px;
}
.histogram__number div{
  font-size: 12px;
  line-height: 14px;
}
.table-cell__histogram .histogram__scale{
  width:calc( 100% / 30 - 5px );
  height: 100%;
  background-color: #EFBD74;
  margin: 0 2.5px
}
.table-cell__histogram .histogram__scale div{
  background-color: #6EBB71;
}
.histogram__scale__number div{
  width:calc( 100% / 30 - 5px );
  height: 10px;
  font-size: 12px;
  line-height: 14px;
  margin:2.5px;
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

.map-table{
  margin: 20px 0px;
}
.map-table th,
.map-table td{
  font-weight: normal;
  font-size: 10px;
  line-height: 10px;
  vertical-align: center;
  text-align: center;
  height: 31px;
}
.map-table th{
  height: 19px;
}
.map-table .map-table-first{
  width: 13%;
  font-weight: bold;
  line-height: 12px;
  background: #333975;
}
.map-table-first-split{
  background: rgba(69, 77, 125, 0.32);
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

.v-select{
  margin: 4px 0;
  border-radius: 1px;
  border: 1px solid #454D7D;
  background: transparent;
}
</style>