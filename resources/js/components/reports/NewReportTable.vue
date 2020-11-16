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
            <option value="11">ноябрь</option>
            <option value="12">декабрь</option>
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
<button :disabled='org==null || month==null || year==null' @click="updateData">Сформировать отчет</button>

  </div>
  <BootstrapTable
    :columns="columns"
    :data="data"
    :options="options"
    
  />
</div>
</template>

<script>
import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.esm.js'
import 'bootstrap-table/dist/bootstrap-table.min.css'
// import theme
import 'bootstrap-table/dist/themes/materialize/bootstrap-table-materialize.min.css'

// import extension
import 'bootstrap-table/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css'

export default {
  components: {
    BootstrapTable
  },
  data () {
    return {
      columns: [
          [{
          title: 'Item Detail',
          colspan: 2,
          align: 'center'
        },
        {
        title: 'Item Detail2',
          
          align: 'center'
    },
        ],
        [
        {
          title: 'МР',
          field: '0'
        },
        {
          field: '1',
          title: 'НГДУ'
        },
        {
          field: '2',
          title: 'ЦДНГ'
        }]
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
        showColumns: true,
        toolbar: true,
        pagination: true
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