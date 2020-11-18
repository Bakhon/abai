<template>
<div>
    <div class="container">  
    <div class="row">
 <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Выберите компанию</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChange($event)"
          >
           <option>Выберите компанию</option>
            <option value="АО ОМГ">АО «ОзенМунайГаз»</option>
            <option value="КБМ">АО «Каражанбасмунай»</option>
            <option value="КазГерМунай">ТОО «КазГерМунай»</option>
            <option value="АО ЭМГ">АО «ЭмбаМунайГаз»</option>
            <option value="ММГ">АО «Мангистаумунайгаз»</option>
          </select>
        </div>
    </div>

     <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Выберите месяц</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeMonth($event)"
          >
           <option>Выберите месяц</option>
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
            <option :hidden='year==2020' value="11">ноябрь</option>
            <option :hidden='year==2020' value="12">декабрь</option>
          </select>
        </div>
    </div>

    <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Выберите год</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
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
    </div>
<button :disabled='org==null || month==null || year==null || year==2020 && month>10' @click="updateData">Сформировать отчет</button>

  </div>
 <div>
 <BootstrapTable
    :columns="columns"
    :data="data"
    :options="options"
    
  />
</div>
</div>

</template>

<script>
import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.esm.js'
import 'tableexport.jquery.plugin'
import 'bootstrap-table/dist/extensions/export/bootstrap-table-export.js'
import 'bootstrap-table/dist/bootstrap-table.min.css'


export default {
  components: {
    BootstrapTable
  },
  data () {
    var xmay = "ssss"
    return {
      
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
        title: 'org: this.org',
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
          title: 'Qж, м3',
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
        title: 'Qж, м3',
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
        title: 'Qж, м3',
   
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
        [
   [
{
        title: 'Qж, м3',
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
    }
        ]

        ]
     
  
      ],
      
      data: [
        {
          id: 1,
          name: 'Item 1',
          price: '$1'
        }
      ],
      options: {
        search: true,
        pagination: true,
        showColumns: true,
        showExport: true,      
        exportTypes: ['excel', 'csv', 'doc'],
        exportDataType: 'all',

      },

      org: null,
      month: null,
      year: null,
      
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
            this.data = data.wellsList
            xmay = month
            
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