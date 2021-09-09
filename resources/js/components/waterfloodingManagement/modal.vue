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
            <tbody
            <tr v-for="items in window_limitation.body">
              <td v-for="item in items">{{ item }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "modal",
  props :[
    'modal_name'
  ],
  data(){
    return {
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
  methods:{
    modalClose() {
      this.$emit('modalClose')
      // this.modal_show = false;
    }
  }
}
</script>
<style scoped>
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
  /*padding: 10px;*/
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
}
.wft__modal__table{
  border-collapse: collapse;
  border: 1px solid #454D7D;
  margin-top: 14px;
}
.wft__modal__table td,
.wft__modal__table th{
  /*width: 33%;*/
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
</style>