<template>
  <div>
    <export-excel
    class   = "btn btn-default"
    :data   = "json_data"
    worksheet = "My Worksheet"
    name    = "filename.xls">
 
    Download Excel (you can customize this with html code!)
 
  </export-excel>
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

    <div>

      <vue-table-dynamic  ref="table" :params="params"> </vue-table-dynamic>
    </div>
  </div>
  </div>
</template>

<script>
import VueTableDynamic from "vue-table-dynamic";

export default {
  components: {
    VueTableDynamic,
     },
  data: function () {
    return {
        json_data: [
            {
                'name': 'Tony Peña',
                'city': 'New York',
                'country': 'United States',
                'birthdate': '1978-03-15',
                'phone': {
                    'mobile': '1-541-754-3010',
                    'landline': '(541) 754-3010'
                }
            },
            {
                'name': 'Thessaloniki',
                'city': 'Athens',
                'country': 'Greece',
                'birthdate': '1987-11-23',
                'phone': {
                    'mobile': '+1 855 275 5071',
                    'landline': '(2741) 2621-244'
                }
            }
        ],
        json_meta: [
            [
                {
                    'key': 'charset',
                    'value': 'utf-8'
                }
            ]
        ],
  


      params: {
        data: [
          ["..."],
        ],
      enableSearch: true,
      whiteSpace: 'normal',
      wordWrap: 'break-word',
      header: 'row',
      sort: [10, 11, 12],
      filter: [
        {
        column: 10, 
          content: [{text: '> 50', value: 50}, {text: '> 80', value: 80}], 
          method: (value, tableCell) => { return tableCell.data > value }
        }, 
        
        ],
            border: true,
            stripe: true,
            showTotal: true,
            pagination: true,
            pageSize: 10,
            pageSizes: [10, 20, 50],
            height: 400,
            headerHeight: 60,
            rowHeight: 60,
            maxWidth:1500,
        columnWidth:[
          {column: 0, width: 160},
          {column: 1, width: 100},
          {column: 2, width: 100},
          {column: 6, width: 100},
          {column: 7, width: 100},
          {column: 8, width: 150},
          {column: 9, width: 400},
          {column: 10, width: 160},
          {column: 11, width: 160},
          {column: 12, width: 160},
          {column: 13, width: 160},
          {column: 16, width: 160},
          {column: 17, width: 160},
          {column: 27, width: 400},
          ],
        },
      org: null,
      month: null,
      year: null,
    };
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
            this.params.data = data.wellsList,
            this.json_data = data.excel
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
};
</script>

