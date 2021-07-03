<template>
<div class="row m-0 p-0">
  <div class="col-md-12 col-xl-9 m-0 p-0  ">
    <div class="card-block">
      <div class="card-title justify-content-between ">
        <p>{{ trans('waterflooding_management.total_selection') }}</p>
        <div class="total-selection d-flex ">
          <div class="total-selection-blue d-flex align-items-center">
            <span v-for="n in 5">299,</span>
          </div>
          <div class="total-selection-red">
            <span v-for="n in 5">299,</span>
          </div>
        </div>
      </div>
      <div class="block block-graphic">
        <div>
          <img src="/img/waterfloodingManagement/Group 1199.png" class="w-100" alt="" style="padding:20px" >
        </div>
        <div class="row graphic-prompt">
          <div class="col-md-4 col-xl-3 m-0 p-0" v-for="n in 4">
            <div class="graphic-text w-100 d-flex align-items-center" v-for="n in 3">
              <img src="/img/waterfloodingManagement/lines/green_line.svg" alt=""  >
              <p class="p-0 " style="">Оптимизированный прогноз дебита жидкости</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex">
      <div class="card-block percent-card" v-for="total in total_selection_card">
        <div class="card-title justify-content-center ">
          <p>{{ total.title }}</p>
        </div>
        <div class="h-100 block percent-block d-flex justify-content-center align-items-center">
          <div class="d-flex">
            <p>{{ total.count }}</p>
            <img :src="total.img" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-xl-3 p-0">
    <div class="card-block">
      <WFM-list-table
          v-bind:data="[
                        {title: this.trans('waterflooding_management.selected_object')},
                        {title: this.trans('waterflooding_management.first_object')},
                        {title: this.trans('waterflooding_management.selected_polygon')},
                        {title: this.trans('waterflooding_management.polygon_1')}
                        ]">

      </WFM-list-table>
    </div>
    <div class="card-block">
      <div class="card-title justify-content-between">
        <p class="p-0 m-0">{{ trans('waterflooding_management.forecast_period')}}</p>
      </div>
      <div class="block d-flex justify-content-between">
        <button class="period-btn" v-for="item in [7, 30, 90]">
          {{ item }} дней
        </button>
      </div>
    </div>
    <div class="card-block">
      <div class="card-title justify-content-between m-0">
        <p class="p-0 m-0 ">{{ trans('waterflooding_management.setting_restrictions')}}</p>
        <a href="">
          <img src="/img/waterfloodingManagement/transition.svg" alt="">
        </a>
      </div>
    </div>
    <div class="card-block">
      <div class="card-title justify-content-between">
        <p>{{ trans('') }}</p>
      </div>
      <div class="block">
        <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/physical_model.svg" alt="">{{ trans('waterflooding_management.physical_model')}}</button>
        <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/machine_learn.svg" alt="">{{ trans('waterflooding_management.machine_learn')}}</button>
        <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/physical_model.svg" alt="">{{ trans('waterflooding_management.hybird') }}</button>
      </div>
    </div>
    <div class="card-block">
      <div class="card-title justify-content-between">
        <p>Выбор оптимизационной задачи</p>
      </div>
      <div class="block">
        <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/physical_model.svg" alt="">{{ trans('waterflooding_management.rpl_recovery')}}</button>
        <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/machine_learn.svg" alt="">{{ trans('waterflooding_management.maximizing_oil_production')}}</button>
        <button class="task-btn"><img src="/img/waterfloodingManagement/buttons/physical_model.svg" alt="">{{ trans('waterflooding_management.reduced_water_production') }}</button>
      </div>
    </div>
      <button class="prediction-btn action-btn" @click="openModal('recommendation')">{{ trans('waterflooding_management.optimize')}} </button>
      <button class="prediction-btn action-btn" @click="openModal('fact')">{{ trans('waterflooding_management.edit')}}</button>
      <button class="prediction-btn action-btn" @click="openModal('recommendation_implementation')">{{ trans('waterflooding_management.save')}}</button>
      <button class="prediction-btn action-btn" @click="openModal('window_limitation')">{{ trans('waterflooding_management.monitoring')}}</button>
  </div>
  <WFM-modal
    :modal_name="modal_name"
    v-if="modal_show"
    @modalClose="modalClose"
  ></WFM-modal>
</div>
</template>
<script>
export default {
  name: "forecastingOptimization",
  data: function () {
    return {
      modal_show: false,
      modal_name: '',
      total_selection_card: [
        {title: this.trans('waterflooding_management.fluid_change'), count: 100, img: '/img/waterfloodingManagement/triangle.svg'},
        {title: this.trans('waterflooding_management.oil_change'), count: 10, img: '/img/waterfloodingManagement/triangle-green.svg'},
        {title: this.trans('waterflooding_management.change_water_cut'), count: '10%', img: '/img/waterfloodingManagement/triangle-red.svg'},
        {title: this.trans('waterflooding_management.change_upload'), count: 100, img: '/img/waterfloodingManagement/triangle.svg'},
        {title: this.trans('waterflooding_management.reservoir_pressure'), count: 140, img: '/img/waterfloodingManagement/triangle.svg'},
      ]
    };
  },
  methods:{
    modalClose() {
      this.modal_show = false;
    },
    openModal(modal_name){
      this.modal_show = true;
      this.modal_name = modal_name;
    }
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
</style>