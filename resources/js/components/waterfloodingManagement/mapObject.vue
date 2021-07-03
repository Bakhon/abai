<template>
  <div class="row m-0 p-0">
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
                  :options="dzosForFilter"
                  label="name"
                  :placeholder="placeholder"
              ></v-select>
            </div>
            <div class="col-4 d-flex align-items-center choose-object-select-title">{{ trans('waterflooding_management.field') }}</div>
            <div class="col-8">
              <v-select
                  :options="dzosForFilter"
                  label="name"
                  :placeholder="placeholder"
              ></v-select>
            </div>
            <div class="col-4 d-flex align-items-center choose-object-select-title">{{ trans('waterflooding_management.object') }}</div>
            <div class="col-8">
              <v-select
                  :options="dzosForFilter"
                  label="name"
                  :placeholder="placeholder"
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
                <th scope="col">ОИЗ,м3</th>
                <th scope="col">HCPVinj</th>
                <th scope="col">КИН,%</th>
                <th scope="col">VRRнакоп.</th>
                <th scope="col">Score</th>
                <th scope="col">
                  <br>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="n in 5">
              <th scope="row">1</th>
              <td>3 483</td>
              <td>0,10</td>
              <td>20%</td>
              <td>29%</td>
              <td>
                <button class="choose-object-score-btn">
                  0,241
                </button>
              </td>
              <td><img src="/img/waterfloodingManagement/water-flooding-managment-choose-object-table.svg" alt=""></td>
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
      <button class="w-100 choose-object prediction-btn">
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
          <WFM-data-picker></WFM-data-picker>
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
          <p>
            {{ trans('waterflooding_management.config_graphic') }}
          </p>
          <div class="d-flex justify-content-between">
            <div class="calendar-date">
              <WFM-data-picker></WFM-data-picker>
            </div>
            <div class="calendar-date">
              <WFM-data-picker></WFM-data-picker>
            </div>
          </div>
        </div>
        <div class="choose-object-into2">
          <div class="row  m-0 p-0">
            <img class="w-100" src="/img/waterfloodingManagement/Group 1506.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import vSelect from 'vue-select'
export default {
  components: {
    vSelect
  },
  data: function () {
    return {
      dzosForFilter: [
        { name: 'АО "Озенмунайгаз"', code: 'omg'},
        { name: 'АО "ЭмбаМунайГаз"',code: 'emba'},
        { name: 'АО "Мангистаумунайгаз"',code: 'mmg'},
        { name: 'АО "Каражанбасмунай"',code: 'krm'},
        { name: 'ТОО "СП "Казгермунай"',code: 'kazger'},
        { name: 'ТОО "Казтуркмунай"',code: 'ktm'},
        { name: 'ТОО "Казахойл Актобе"',code: 'koa'},
      ],
      show_choose_object:[
        {title:'Добыча жидкости', count: 1658, measure: 'м3'},
        {title:'Добыча нефти', count: 546, measure: 'т.'},
        {title:'Закачка', count: 497, measure: 'м3'},
        {title:'Фонд добывающих', count: 52, measure: 'скв.'},
        {title:'Фонд нагнетательных', count: 12, measure: 'скв.'},
        {title:'Компенсация', count: 30, measure: '%'}
      ]
    }
  },
  computed: {
    placeholder: function(){
      return this.dzosForFilter[0].name
    }
  },
}
</script>
<style scoped>
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
  height: 600px;
  width: 100%;
  padding: 5px;
  background-color: #272953;
}
.map-images{
  height: 100%;
  width: 100%;
  background-color: #fff;
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
  border-radius: 5px;
  background: #1A1D46;
  color: #fff;
  position: relative;
  outline: none;
  border: none;
  z-index: 2;
}
.choose-object-score-btn:before {
  content: '\A';
  position: absolute;
  background: #2E50E9;
  top: 0;
  bottom: 0;
  left: 0;
  width: 50%;
  z-index: -1;
}

.info-for-object{
  height: 120px;
  background: #2B2E5E;
  border: 1px solid #454D7D;
  /*box-sizing: border-box;*/
  border-radius: 1px;
  color: #fff;
  text-align: center;
  /*padding: 14px;*/
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