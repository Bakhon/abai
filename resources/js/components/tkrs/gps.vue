<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        <div class="data-analysis-left-block">
          <div class="left-block-collapse-holder">
            <div>
              <img
                src="/img/PlastFluids/chooseParameters.svg"
                alt="choose parameters icon"
              />
              <span>Параметры</span>
            </div>
          </div>
          <div class="dropdown-holder">
      
            <b-form-select class="custom-dropdown-block"  @change="onChangeWell" :options="wellList"></b-form-select>
            <div class="line-block"></div>

            <b-form-select  class="custom-dropdown-block" :options="wellDate" @change="onChangeWellDate"></b-form-select>
            <b-button class="online-block" variant="success">{{trans('tr.online')}}</b-button>
            
          </div>
          
        </div>

        <div class="tkrs-content">
            <div>
              <div class="table-div">
            <div>
              <table>
                
                <tbody>
                    <tr>
                      <td><svg width="268" height="79" viewBox="0 0 268 79" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="268" height="78.8806" fill="url(#pattern0)"/>
<defs>
<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_1443:85818" transform="translate(0 -0.000756598) scale(0.00373134 0.0126774)"/>
</pattern>
<image id="image0_1443:85818" width="268" height="79" xlink:href="data:image/png;base64,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"/>
</defs>
</svg></td>
                      <td class="header_name">Служба бурение и ремонт скважин (СБ и РС)</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td class="header_name">Ежедневный отчет по освоению, капитальному и подземному ремонту скважин </td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td class="header_name">Дата отчета</td>
                      <td class="input-form-auto header_name">29.05.2020 г.</td>
                      <td class="input-form-auto header_name_red">{{well_name}}</td>
                      <td class="input-form-auto header_name_red">{{field_name}}</td>
                      <td class="header_name">Начало бурения:</td>
                      <td class="input-form-auto header_name_red">{{start_drill}}</td>
                      <td class="header_name">Конец бурения:</td>
                      <td class="input-form-auto header_name_red">{{end_drill}}</td>
                    </tr>
                    <tr>
                      <td class="header_name"> № отчета:</td>
                      <td class="input-form-auto header_name">{{report_number}}</td>
                      <td class="header_name">Задание по программе:</td>
                      <td class="input-form-auto header_name" colspan="2">{{programmes_target_name}}</td>
                      <td class="header_name">Тип скважины:</td>
                      <td class="input-form-auto header_name_red" colspan="2">{{well_type}}</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">Тип станка:</td>
                      <td class="input-form-auto header_name">{{machine_type}}</td>
                      <td colspan="2" class="header_name">Подрядчик:</td>
                      <td colspan="3" class="input-form-auto header_name_red">{{contractor_name}}</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td colspan="6" class="header_name">Параметры (давления) по скважине </td>
                    </tr>
                    <tr>
                      <td class="header_name">Трубное давление:</td>
                      <td class="input-form-auto header_name_red"> 0 атм</td>
                      <td class="header_name">Затрубное давление:</td>
                      <td class="input-form-auto header_name_red">0 атм</td>
                      <td class="header_name">Межколонное давление:</td>
                      <td class="input-form-auto header_name_red">0 атм</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td class="header_name">Начало</td>
                      <td class="header_name">Конец</td>
                      <td class="header_name">Часы</td>
                      <td rowspan="2" class="header_name">Сводка по работам (описание проделаных работ)</td>
                    </tr>
                    <tr>
                      <td colspan="3" class="header_name">Дневное время</td>
                    </tr>
                    <tr v-for="(item, item_index) in test.dbeg_day" :key="item_index">
                      <td    class="header_name manual-edit">{{item}}</td>
                      <td class="header_name manual-edit">{{test.dend_day[item_index]}}</td>
                      <td class="header_name input-form-auto"></td>
                      <td class="manual-edit">{{test.day_works[item_index]}}<input class="manual-input"/></td>
                    </tr>
                    
                    <tr>
                      <td colspan="3" class="header_name">Ночное время</td>
                      <td></td>
                    </tr>
                    <tr v-for="(item, item_index) in test.dbeg_night" :key="item_index">
                      <td class="header_name manual-edit">{{item}}</td>
                      <td class="header_name manual-edit">{{test.dend_night[item_index]}}</td>
                      <td class="header_name input-form-auto"></td>
                      <td class="manual-edit">{{test.night_works[item_index]}}<input class="manual-input"/></td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td class="header_name">Всего за сутки:</td>
                      <td class="input-form-auto header_name">24</td>
                      <td class="header_name">Сегодня</td>
                      <td class="header_name">Предыдущее</td>
                      <td class="header_name">Итого</td>
                      <td colspan="6" class="header_name">Данные по скважине</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">Всего часов, в т.ч:</td>
                      <td class="input-form-auto header_name" >24,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">24,0</td>
                      <td class="header_name">Превышение стола ротора, м</td>
                      <td class="input-form-auto"></td>
                      <td class="header_name">наружный диаметр, мм</td>
                      <td class="header_name">толщина стенки, мм</td>
                      <td class="header_name">глубина спуска, м</td>
                      <td class="header_name">объем, литр на 1-метр</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">Производительное время:</td>
                      <td class="header_name manual-edit">23,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">23,0</td>
                      <td colspan="2" class="header_name"> Эксплуатационная колонна</td>
                      <td class="input-form-auto header_name">168,3</td>
                      <td class="input-form-auto header_name">8,94</td>
                      <td class="input-form-auto header_name">0-1869м</td>
                      <td class="input-form-auto">17,76</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">прочее (ОЗЦ и т.д)</td>
                      <td class="header_name manual-edit">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td colspan="6" class="header_name">Примечание</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">Непроизводительное время в т.ч:</td>
                      <td class="input-form-auto header_name">1,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">1,0</td>
                      <td colspan="2" class="header_name">Искусственный забой, м</td>
                      <td class="input-form-auto header_name">1856</td>
                      <td colspan="2" class="header_name">Текущий забой, м</td>
                      <td class="input-form-auto header_name">1851м</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">обеденный перерыв</td>
                      <td class="header_name manual-edit">1,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">1,0</td>
                      <td colspan="2" class="header_name">Интервал перфорации</td>
                      <td colspan="4" class="input-form-auto header_name">1700-1710м.</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">ремонт оборудования</td>
                      <td class="header_name manual-edit">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td colspan="6" rowspan="4" class="input-form-auto">{{all_works}}</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">метеоусловия</td>
                      <td class="header_name manual-edit">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name"> ожидание по вине Подрядчика</td>
                      <td class="header_name manual-edit">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">ожидание по вине третьей стороны</td>
                      <td class="header_name manual-edit">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                      <td class="input-form-auto header_name">0,0</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td rowspan="3" class="header_name">Начальник Б и РС ТОО СП "КГМ"</td>
                      <td rowspan="3" class="header_name">{{chief}}</td>
                      <td class="header_name">подпись</td>
                      <td class="header_name">Мастер КПРС</td>
                      <td class="header_name">ФИО</td>
                      <td class="header_name">подпись</td>
                      <td class="header_name">номер телефона</td>
                    </tr>
                    <tr>
                      
                      <td></td>
                      <td class="header_name">дневная смена</td>
                      <td class="manual-edit header_name"><input class="manual-input"/>{{master_day_shift}}</td>
                      <td></td>
                      <td class="manual-edit header_name"><input class="manual-input"/>{{master_day_shift_number}}</td>
                    </tr>
                    <tr>
                      
                      <td></td>
                      <td class="header_name">ночная смена</td>
                      <td class="manual-edit header_name"><input class="manual-input"/>{{master_night_shift}}</td>
                      <td></td>
                      <td class="manual-edit header_name"><input class="manual-input"/>{{master_night_shift_number}}</td>
                    </tr>
                </tbody>
              </table>
            </div>
            
      </div>
      <div class="daily-report">
        <div class="daily-report-buttons">
          <button class="daily-report-button">{{trans('tr.form')}}</button>
          <button class="daily-report-button">{{trans('tr.save')}}</button>
          <button class="daily-report-button">{{trans('tr.cancel')}}</button> 
        </div>
      </div>      
              

            </div>

        </div>
    </div>
    
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import baseBlock from './baseBlock.vue';
import BaseTable from './BaseTable.vue';
import {globalloadingMutations} from '@store/helpers'


export default {
  name: "gps",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    BaseTable,
    baseBlock,
  },
  computed: {
  },
  data(){
    return {
      currentTab: 1,
      calendarDate: '2020-06-17',
      Date1: null,
      areaChartData: [],
      

      isChart: true,
      wellList: [],
      wellDate: [],
      wellNumber: null,
      wellFile: null,
      maximum: null,
      minimum: null,
      chartData: null,
      contractor_name: null,
      report_number:  null,
      machine_type:  null,
      well_name:  null,
      programmes_target_name:  null,
      chief:  null,
      master_day_shift:  null,
      master_day_shift_number:  null,
      master_night_shift:  null,
      master_night_shift_number:  null,
      programmes_target_name:  null,
      test: [],
      start_drill:  null,
      end_drill:  null,
      all_works:  null,
      postApiUrl: process.env.MIX_TKRS_POST_API_URL,
      linkWell: "drWellName/",
      linkWellDate: "drWellDates/",
      linkWellReport: "drHeaderWorkReport/",
      
    }
  },
  created: async function () {
    this.SET_LOADING(true);
    await this.axios
      .get(
        this.postApiUrl + this.linkWell,
        )
      .then((response) => {
        this.SET_LOADING(false);
        let data = response.data;
        if (data) {
          this.areaChartData = data.data;
        } else {
          console.log("No data");
        }
        return Promise
      })
      .catch((error) => {
        console.log(error.data);
        this.SET_LOADING(false);
      });
      this.getListWell();
    },
  
  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
    ]),

    comparison_graphs() {
        this.$modal.show('comparison_graphs')
    },
    onChangeWell(number) {
      this.wellNumber = number;
      this.postSelectedtWell();        
    },
    onChangeWellDate(number) {
      this.wellFile = number;
      this.postSelectedtWellFile();
    },
    getListWell() {
      
        this.axios
            .get(
                this.postApiUrl + this.linkWell,
            )
            .then((response) => {
              
                let data = response.data;
                if (data) {
                    this.wellList = data.data.wells;
                    
                } else {
                    console.log("No data");
                }
            });
    },
    postSelectedtWell() {
        this.axios
            .get(
                this.postApiUrl + this.linkWellDate + `${this.wellNumber}/`,
            )
            .then((response) => {
                let data = response.data;
                if (data) {
                    this.wellDate = data.data.dates;
                    
                    
                } else {
                    console.log("No data");
                }
            });
    },
    postSelectedtWellFile() {
      this.SET_LOADING(false);
        this.axios
            .get(
                this.postApiUrl + this.linkWellReport + `${this.wellNumber}/${this.wellFile}/`,
            )
            .then((response) => {
              
                let data = response.data;
                if (data) {
                    this.wellFile = data;
                    this.areaChartData = data.data;
                    this.contractor_name = data.data.header.contractor_name;
                    this.report_number = data.data.header.report_number;
                    this.machine_type = data.data.header.machine_type;
                    this.well_name = data.data.header.well_name;
                    this.programmes_target_name = data.data.header.programmes_target_name;
                    this.chief = data.data.works_report.chief;
                    this.master_day_shift = data.data.works_report.master_day_shift;
                    this.master_day_shift_number = data.data.works_report.master_day_shift_number;
                    this.master_night_shift = data.data.works_report.master_night_shift;
                    this.master_night_shift_number = data.data.works_report.master_night_shift_number;
                    this.test = data.data.works_report_range;
                    this.start_drill = data.data.header.start_drill;
                    this.end_drill = data.data.header.start_drill;
                    this.all_works = data.data.works_report_range.all_works;
                  console.info(this.test)
                } else {
                    console.log("No data");
                }
            });
    },
    cancelChat() {
        this.isChart = false;
    },
    returnChat() {
      this.isChart = true;
    },
    
    selectTab(selectedTab) {
            this.currentTab = selectedTab
    },

  },
};
</script>
<style lang="scss" scoped src="./InputFormTableStyles.scss"></style>
<style scoped>
.tkrs-main {
  width: 100%;
  height: 100%;
}

.tkrs-content {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
  padding-left: 6px;
}
table {
  color: white;
  background: #333975;
}
table, th, td {
  border:1px solid black;
}
.input-form-auto{
background: #eaf3fa
}
.input-form-dropdown {
background: #eaf3fa !important; 
color: black !important; 
border: none !important;
}
.manual-edit {
  background: #ffff;
}
.manual-input {
  width: 100%; 
  height: 22px;
  border: none;
}
.manual-input:hover {
  border: none;
}
.daily-report-buttons {
  background: #323370;
  height: 4%;
  float: right;
}
.daily-report {
  background: #323370;
  height: 4%;
}
.sidebar_graph {
  height: calc(100% - 36px);
}
.tkrs-content-down {
      height: 100%;
}
.custom-dropdown-block {
  background: #1F2142;
  border: none;
  color: #fff;
}
.line-block {
  height: 4px;
}
.online-block {
  width: 100%;
}
.comparison-graphs {
  color: #fff;
  font-size: 16px;
}
.data-analysis-left-block {
  width: 249px;
  flex-shrink: 0;
  display: flex;
  flex-flow: column;
  height: 100%;
  background: #272953;
  color: #fff;
}

.left-block-collapse-holder {
  display: flex;
  width: 100%;
  height: 42px;
  background-color: #323370;
}

.left-block-collapse-holder > div {
  display: flex;
  height: 100%;
  width: calc(100% - 29px);
  align-items: center;
  background-color: #323370;
}

.left-block-collapse-holder > div > img {
  margin: 0 8px 0 10px;
}

.collapse-left__sidebar {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 29px;
  background: var(--a-accent);
  padding: 14px 6px;
  border-radius: 10px 0 0 10px;
  border: none;
  border-left: 5px solid #272953;
}
.daily-report-button {
  background: #3C4280;
    color: white;
    border: none;
}
.header_name {
  font-size: 14px;
  font-weight: bold;
}
.header_name_red {
  font-size: 14px;
  font-weight: bold;
  color: #E31F25;
}
</style>