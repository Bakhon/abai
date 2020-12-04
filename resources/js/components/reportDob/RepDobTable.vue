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
            @change="onChangeDzo($event)"
          >
           <option>Выберите компанию</option>
            <option value="АО ОМГ">АО 'Озенмунайгаз'</option>
            <option value="КБМ">АО 'Каражанбасмунай'</option>
            <option value="АО ЭМГ">АО 'Эмбамунайгаз'</option>
            <option value="ММГ">МАНГИСТАУМУНАЙГАЗ</option>
          </select>
        </div>
    </div>

 <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Месторождение</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeField($event)"
          >
           <option>Месторождение</option>
            <option value="Узень">Узень</option>
            <option value="Восточный Молдабек">Восточный Молдабек</option>
            <option value="Каламкас">Каламкас</option>
            <option value="Жетыбай">Жетыбай</option>
            <option value="Терен-Узек">Терен-Узек</option>
            <option value="Ю.Жетыбай">Ю.Жетыбай</option>
          </select>
        </div>
    </div>
<!-- 
      <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">НГДУ</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeNgdu($event)"
          >
           <option>НГДУ</option>
            <option value="НГДУ-1">НГДУ-1 </option>
            <option value="НГДУ-2">НГДУ-2 </option>
            <option value="НГДУ-3">НГДУ-3 </option>
            <option value="НГДУ-4">НГДУ-4 </option>
            <option value="НГДУ-Жылыоймунайгаз">НГДУ-Жылыоймунайгаз	</option>
            <option value="НГДУ-Жайкмунайгаз">НГДУ-Жайкмунайгаз	</option>
            <option value="НГДУ-Доссормунайгаз">НГДУ-Доссормунайгаз	</option>
            <option value="ПУ-ЖЕТЫБАЙМУНАЙГАЗ">ПУ-ЖЕТЫБАЙМУНАЙГАЗ	</option>
            <option value="НГДУ-Кайнармунайгаз">НГДУ-Кайнармунайгаз	</option>
            <option value="Цех-1">Цех-1	</option>
            <option value="Цех-2">Цех-2	</option>
          </select>
        </div>
    </div>

     <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">БЛОК</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeBlock($event)"
          >
           <option>Блок</option>
            <option value="HUM">HUM</option>
            <option value="PARS">PARS</option>
            <option value="SZ">SZ</option>
            <option value="Восточный Парсмурун">Восточный Парсмурун</option>
            <option value="Восточный кар">Восточный кар</option>
            <option value="Западная переклиналь">Западная переклиналь</option>
            <option value="Западный Кар">Западный Кар</option>
          </select>
        </div>
    </div>

    <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Горизонт</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeHorizon($event)"
          >
           <option value=''> Горизонт </option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
                
          </select>
        </div>
    </div>

<div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">ЦДНГ</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeCGDN($event)"
          >
           <option value=''> ЦДНГ </option>
            <option value="ЦДНГ-1">ЦДНГ-1</option>
            <option value="ЦДНГ-2">ЦДНГ-2</option>
            <option value="ЦДНГ-3">ЦДНГ-3</option>
            <option value="ЦДНГ-4">ЦДНГ-4</option>
            <option value="ЦДНГ-5">ЦДНГ-5</option>
            <option value="ЦДНГ-6">ЦДНГ-6</option>
            <option value="ЦДНГ-7">ЦДНГ-7</option>
            <option value="ЦДНГ-8">ЦДНГ-8</option>
            <option value="ЦДНГ-9">ЦДНГ-9</option>
            <option value="ЦДНГ-10">ЦДНГ-10</option>
            <option value="ЦДНГ-11">ЦДНГ-11</option>
            <option value="ЦДНГ-12">ЦДНГ-12</option>
            <option value="ЦДНГ-13">ЦДНГ-13</option>
            <option value="НГДУ-Жылыоймунайгаз	">НГДУ-Жылыоймунайгаз</option>
                
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
           <option> Выберите год </option>
            <option value="2020">2020</option>
          </select>
        </div>
    </div>

    <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Вид мероприятия</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeVM($event)"
          >
           <option value=''> Вид мероприятия </option>
            <option value="Гидроразрыв пласта">Гидроразрыв пласта</option>
           <option value="Перфорация (дострел)">Перфорация (дострел)</option> -->
            <!-- <option value="Возврат (переход) на вышележащие/нижележащие горизонты">Возврат (переход) на вышележащие/нижележащие горизонты</option>
            <option value="Переход на другие горизонты">Переход на другие горизонты</option>
            <option value="Дополнительный прострел">Дополнительный прострел</option>
            <option value="Переход на вышележащий горизонт">Переход на вышележащий горизонт</option>
          </select>
        </div>
    </div> --> 



    </div>

    <button :disabled='field==null'   @click="updateData" class="btn report-btn">Сформировать отчет</button>
</div>
<!-- <div :hidden='data==""'> -->
  <BootstrapTable
    :columns="columns"
    :data="data"
    :options="options"
  />
    
</div>
</template>
<script>
import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.esm.js'
import 'tableexport.jquery.plugin'
// import 'bootstrap-table/dist/extensions/export/bootstrap-table-export.js';
// import 'bootstrap-table/dist/themes/materialize/bootstrap-table-materialize.min.css';
import 'bootstrap-table/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css'
import 'bootstrap-table/dist/bootstrap-table.min.css'
// import 'bootstrap-table/dist/bootstrap-table-fixed-columns.min.js';

export default {
  components: {
    BootstrapTable
  },
  data () {
    return {

      // exportTypes: ['json', 'excel'],
      columns: [
          [
            {
          title: 'Месторождение',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'ДЗО',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'Скважина',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'НГДУ',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'ЦДНГ',
          rowspan: 2,
         sortable: true,
          align: 'center',
        },
        {
          title: 'Блок',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'ГЗУ/ЗУ',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'Гу',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Горизонт',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Состояние',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Тех.режим',
          colspan: 3,
          align: 'center',
        },
         {
          title: '01.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '02.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '03.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '04.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '05.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '06.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '07.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '08.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '09.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '10.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '11.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '12.08.2020',
          colspan: 3,
          align: 'center',
        }, 
        {
          title: '13.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '14.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '15.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '16.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '17.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '18.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '19.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '20.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '21.08.2020',
          colspan: 3,
          align: 'center',
        },
         {
          title: '22.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '23.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: '24.08.2020',
          colspan: 3,
          align: 'center',
        },
        {
          title: 'Средние за месяц',
          colspan: 3,
          align: 'center',
        },
              
        ],
        [
         {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
       {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
    {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
    {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
    {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
    {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
    {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
    {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
    {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
       {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
       {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
       {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
       {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
         {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
       {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        {
          align: 'center',
          title: 'Qж,м3',
        },
        {
          align: 'center',
          title: 'Обв.,%',
        },
        {
          align: 'center',
          title: 'Qн,т/сут',
        },
        
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
        locale: 'ru-RU',
        fixedColumns: true,
        fixedNumber: 10,
        fixedRightNumber: 3,
        showMultiSort: true,


      },
      dzo: '',
      field: ''
      
     
    }
  },
  methods: {
    // dayClicked(day) {
    //   this.date = day.id;
    //   var dt = this.date.split('-');
     

    // },
    updateData(){
      let uri = '/ru/dob1';
      this.axios.post("/ru/dob1", {
        dzo: this.dzo,
        field: this.field
        //  ngdu: this.ngdu,
        //  block: this.block,
        //  horizon: this.horizon,
        //  tseh: this.tseh,
        //  year: this.year,
        //  long_name: this.long_name,          
        })
        .then((response) => {
          let data = response.data;
          if (data) {
            this.data = data.wellsList3;
            // this.data = test1; 
          } else {
            console.log("No data");
          }
        }); 
         },
     onChangeField(event) {
        this.field = event.target.value;

    },
     onChangeDzo(event) {
        this.dzo = event.target.value;

    }
    //  onChangeBlock(event) {
    //     this.block = event.target.value;

    // },
    // onChangeHorizon(event) {
    //     this.horizon = event.target.value;

    // },
    // onChangeCGDN(event) {
    //     this.tseh = event.target.value;

    // },
    //  onChangeYear(event) {
    //     this.year = event.target.value;
    //     },
    // onChangeVM(event) {
    //     this.long_name = event.target.value;
        
    
    // },
    // beforeCreate: function(){
    //   this.updateData()
    //   console.log('data'); 

    // },
  }, 
}
</script>