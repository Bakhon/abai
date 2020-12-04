<template>
<div>
  <div class="container">  
    <div class="row">

 <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Компания</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeDzo($event)"
          >
           <option>Компания</option>
            <option value="АО ОМГ">АО 'Озенмунайгаз'</option>
            <option value="КБМ">АО 'Каражанбасмунай'</option>
            <option value="АО ЭМГ">АО 'Эмбамунайгаз'</option>
            <option value="ММГ">МАНГИСТАУМУНАЙГАЗ</option>
          </select>
        </div>
    </div>

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
            <option value="Возврат (переход) на вышележащие/нижележащие горизонты">Возврат (переход) на вышележащие/нижележащие горизонты</option>
            <option value="Переход на другие горизонты">Переход на другие горизонты</option>
            <option value="Дополнительный прострел">Дополнительный прострел</option>
            <option value="Переход на вышележащий горизонт">Переход на вышележащий горизонт</option>
          </select>
        </div>
    </div> 



    </div>

    <button :disabled='dzo==null'   @click="updateData" class="btn report-btn">Сформировать отчет</button>
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
          title: 'Номер скважины',
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
          title: 'ЗУ/ГЗУ',
          rowspan: 2,
         sortable: true,
          align: 'center',
        },
        {
          title: 'Горизонт',
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
          title: 'Дата проведения мероприятия',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'Дата запуска',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'Вид мероприятия',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'Подрядчик',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'Жидкость после ГТМ, т/сут',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
        {
          title: 'Нефть после ГТМ, т/сут',
          rowspan: 2,
          sortable: true,
          align: 'center',
        },
            {
          title: 'Январь 2020',
          colspan: 9,
          align: 'left',
        },
        {
          title: 'Февраль 2020',
          colspan: 9,
          align: 'left',
        },
         {
          title: 'Март 2020',
          colspan: 9,
          align: 'left',
        },
         {
          title: 'Апрель 2020',
          colspan: 9,
          align: 'left',
        },
        {
          title: 'Май 2020',
          colspan: 9,
          align: 'left',
        },
            {
          title: 'Июнь 2020',
          colspan: 9,
          align: 'left',
        },
         {
          title: 'Июль 2020',
          colspan: 9,
          align: 'left',
        },
        {
          title: 'Август 2020',
          colspan: 9,
          align: 'left',
        },
         {
          title: 'Сентябрь 2020',
          colspan: 9,
          align: 'left',
        },
        {
          title: 'Total',
          colspan: 9,
          align: 'left',
        }
        ],
        [
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин, м',
        },
        {
          align: 'center',
          title: 'Pзаб, атм',
        },
        {
          align: 'center',
          title: 'Жидкость, т/сут',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть, т/сут',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
           {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин, м',
        },
        {
          align: 'center',
          title: 'Pзаб, атм',
        },
        {
          align: 'center',
          title: 'Жидкость, т/сут',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть, т/сут',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин, м',
        },
        {
          align: 'center',
          title: 'Pзаб, атм',
        },
        {
          align: 'center',
          title: 'Жидкость, т/сут',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть, т/сут',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин, м',
        },
        {
          align: 'center',
          title: 'Pзаб, атм',
        },
        {
          align: 'center',
          title: 'Жидкость, т/сут',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть, т/сут',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
          {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин, м',
        },
        {
          align: 'center',
          title: 'Pзаб, атм',
        },
        {
          align: 'center',
          title: 'Жидкость, т/сут',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть, т/сут',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин, м',
        },
        {
          align: 'center',
          title: 'Pзаб, атм',
        },
        {
          align: 'center',
          title: 'Жидкость, т/сут',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть, т/сут',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
          {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин, м',
        },
        {
          align: 'center',
          title: 'Pзаб, атм',
        },
        {
          align: 'center',
          title: 'Жидкость, т/сут',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть, т/сут',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
          {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин, м',
        },
        {
          align: 'center',
          title: 'Pзаб, атм',
        },
        {
          align: 'center',
          title: 'Жидкость, т/сут',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть, т/сут',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
     {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        }
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
        fixedNumber: 8,
        showMultiSort: true,


      },
      dzo: '',
      ngdu: '',
      block: '',
      horizon: '',
      tseh: '',
      year: '',
      long_name: '',
    }
  },
  methods: {
    // dayClicked(day) {
    //   this.date = day.id;
    //   var dt = this.date.split('-');
     

    // },
    updateData(){
      let uri = '/ru/gtm1';
      this.axios.post("/ru/gtm1", {
        dzo: this.dzo,
         ngdu: this.ngdu,
         block: this.block,
         horizon: this.horizon,
         tseh: this.tseh,
         year: this.year,
         long_name: this.long_name,          
        })
        .then((response) => {
          let data = response.data;
          if (data) {
            this.data = data.wellsList1;
            // this.data = test1; 
          } else {
            console.log("No data");
          }
        }); 
         },
     onChangeDzo(event) {
        this.dzo = event.target.value;

    },
     onChangeNgdu(event) {
        this.ngdu = event.target.value;

    },
     onChangeBlock(event) {
        this.block = event.target.value;

    },
    onChangeHorizon(event) {
        this.horizon = event.target.value;

    },
    onChangeCGDN(event) {
        this.tseh = event.target.value;

    },
     onChangeYear(event) {
        this.year = event.target.value;
        },
    onChangeVM(event) {
        this.long_name = event.target.value;
        
    
    },
    // beforeCreate: function(){
    //   this.updateData()
    //   console.log('data'); 

    // },
  }, 
}
</script>