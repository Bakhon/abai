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