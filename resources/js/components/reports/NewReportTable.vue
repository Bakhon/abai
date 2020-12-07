<template>
 <div>
   <div class="container">
     <div class="row">
       <div class="underHeader">
         <div class="col-sm1">
           <div class="form-group1">
                <!--<label class="text-wrap" style="color:white; width:438px;" for="companySelect">Компания</label>-->
                <!--<select
                  style="background-color:#20274e;border-color:#20274e;color:white;"
                  class="form-control"
                  id="companySelect"
                  @change="onChange($event)"
                >-->
                  <select
                    style="background-color:#333975; border-color:#20274e; color:white;"
                    class="form-control"
                    id="companySelect"
                     @change="onChange($event)"
                    >
                    <option value="">Компания</option>
                    <option value="АО ОМГ">АО «ОзенМунайГаз»</option>
                    <option value="КБМ">АО «Каражанбасмунай»</option>
                    <option value="КазГерМунай">ТОО «КазГерМунай»</option>
                    <option value="АО ЭМГ">АО «ЭмбаМунайГаз»</option>
                    <option value="ММГ">АО «Мангистаумунайгаз»</option>
                  </select>
                 </div>
                </div>

        <div class="col-sm2">
          <div class="form-group2">
            <!--<label class="text-wrap" style="color:white;" for="companySelect">Выберите месяц</label>-->
            <!-- https://developer.snapappointments.com/bootstrap-select/examples/#basic-examples -->
            <!-- multiple data-selected-text-format="count > 3" title="Выберите месяц" lang="ru" class="selectpicker"-->
            <select data-live-search="true"
              style="background-color:#333975; border-color:#20274e; color:white;"
              multiple data-selected-text-format="count > 3" title="Выбрать месяц" lang="ru" class="selectpicker"
              id="companySelect"
              @change="onChangeMonth($event)"
              >
             <option value="" >Выбрать месяц</option>
              <option value="1">январь</option>
              <option value="2">февраль</option>
              <option value="3">март</option>
              <option value="4">апрель</option>
              <option value="5">май</option>
              <option value="6">июнь</option>
              <option value="7">июль</option>
              <option value="8">август</option>
              <option value="9">сентябрь</option>
              <option value="10">октябрь</option>
              <option :disabled='year==2020' value="11">ноябрь</option>
              <option :disabled='year==2020' value="12">декабрь</option>
            </select>
         </div>
        </div>

        <div class="col-sm3">
          <div class="form-group3">
            <!--<label class="text-wrap" style="color:white;" for="companySelect">Выберите год</label>-->
            <select
              style="background-color:#333975; border-color:#20274e; color:white;"
              class="form-control"
              id="companySelect"
              @change="onChangeYear($event)"
            >
            <option value=''> Выберите год </option>
              <option value="2020">2020</option>
              <option value="2019">2019</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
            </select>
          </div>
        </div>
        <div class="col-sm4">
          <div class="form-group4">
            <button :disabled='org=="" || month=="" || year=="" || year==2020 && month>10' @click="updateData" class="btn report-btn">Сформировать отчет</button>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div :hidden='data==""'>
      <BootstrapTable
      :columns="columns"
      :data="data"
      :options="options"
      :height="100"
       />
    
  </div>
  </div>

</template>

<script>
import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.esm.js'
import 'tableexport.jquery.plugin'
import 'bootstrap-select/dist/css/bootstrap-select.min.css';
import 'bootstrap-table/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.css'
import 'bootstrap-table/dist/bootstrap-table.min.css'


export default {
  components: {
    BootstrapTable
  },
  data () {

    return {
       xmay: [{
      '1': "январь",
      '2': "февраль",
      '3': "март",
      '4': "апрель",
      '5': "май",
      '6': "июнь",
      '7': "июль",
      '8': "август",
      '9': "сентябрь",
      '10': "октябрь",
      '11': "ноябрь",
      '12': "декабрь"
    },],
       columns: [
          [
        {
        title: 'Месторождение',
        rowspan: 3,
          align: 'center'
    },
  {
        title: 'НГДУ',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'ЦДНГ',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'ГУ',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'Отвод',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'ЗУ/ГЗУ',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'Номер скважины',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'Год бурения',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'Горизонт',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'Блок',
        rowspan: 3,
          align: 'center'
    },
     {
        title: 'Действующие интервалы перфорации',
        rowspan: 3,
          align: 'center'
    },
      {
        title: '',
          colspan: 19,
          align: 'center'
    },
{
        title: 'Факт с начала года',
          colspan: 6,
          align: 'center'
    }
        ],
        [{
         title: 'Техрежим',
          colspan: 3,
          align: 'center'
},
          {
          title: 'Qж, м3/сут',
          rowspan: 2,
          align: 'center'
},
{
          title: 'Qн, т/сут',
          rowspan: 2,
          align: 'center'
},{
          title: 'Обв, %',
          rowspan: 2,
          align: 'center'
},{
          title: 'Дата исследования',
          rowspan: 2,
          align: 'center'
},{
          title: 'Заключение',
          rowspan: 2,
          align: 'center'
},{
          title: 'Hдин, м',
          rowspan: 2,
          align: 'center'
},{
          title: 'Pзатр, атм',
          rowspan: 2,
          align: 'center'
},{
          title: 'Pзаб, атм',
          rowspan: 2,
          align: 'center'
},{
          title: 'Pбуф, атм',
          rowspan: 2,
          align: 'center'
},{
          title: 'Pмакс.нагрузки, кг',
          rowspan: 2,
          align: 'center'
},{
          title: 'Отработанные дни',
          rowspan: 2,
          align: 'center'
},{
          title: 'Qн, т',
          rowspan: 2,
          align: 'center'
},{
          title: 'Qж, м3',
          rowspan: 2,
          align: 'center'
},
{
        title: 'Примечание',
          colspan: 2,
          align: 'center'
    },
{
        title: 'Кол-во ПРС',
          rowspan: 2,
          align: 'center'
    },
{
        title: 'Qж, м3/сут',
          rowspan: 2,
          align: 'center'
    },
    {
        title: 'Qн, т/сут',
          rowspan: 2,
          align: 'center'
    },
    {
        title: 'Обв, %',
          rowspan: 2,
          align: 'center'
    },
    {
        title: 'Отработанные дни',
          rowspan: 2,
          align: 'center'
    },
    {
        title: 'Qн, т',
          rowspan: 2,
          align: 'center'
    },
    {
        title: 'Qж, м3',
          rowspan: 2,
          align: 'center'
    }
        ],
        [
 {
        title: 'Qж, м3/сут',

          align: 'center'
    },
     {
        title: 'Обв, %',

          align: 'center'
    },
     {
        title: 'Qн, т/сут',

          align: 'center'
    },
     {
        title: 'Пробы',

          align: 'center'
    },
     {
        title: 'Простои',

          align: 'center'
    },
        ],

      ],

      data: [],
      options: {
        search: true,
        pagination: true,
        showColumns: true,
        showExport: true,
        locale: 'ru-RU',
        exportTypes: ['excel', 'csv'],
        exportDataType: 'all',
        // fixedColumns: true,
        // fixedNumber: 2,

      },

      org: '',
      month: '',
      year: '',

    }

  },
  methods: {
    // dayClicked(day) {
    //   this.date = day.id;
    //   var dt = this.date.split('-');


    // },
    updateData(){
      let uri = '/ru/protodata';
      this.axios.post("/ru/protodata", {
          org: this.org,
          month: this.month,
          year: this.year,
        })
        .then((response) => {
          let data = response.data;
          if (data) {
            this.data = data.wellsList;
            this.columns[0][11]['title'] = this.xmay[0][this.month] + " " + this.year;
            this.columns[0].push({title: this.xmay[0][this.month] + " " + this.year}); 
          } else {
            console.log("No data");
          }
        });
    },
     onChange(event) {
        this.org = event.target.value;
    },
     onChangeMonth(event) {
        this.month = event.target.value;
    },
    onChangeYear(event) {
        this.year = event.target.value;
    },
  },
}

</script>
