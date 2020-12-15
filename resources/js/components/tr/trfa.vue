<template>
    <div class="container-fluid">
        <div class="col-md-12 row">
            <div class="col-md-9 row justify-content-between">
                <a href="fa" class="col but-nav__link but trfacolbutnavlinkbut"><i style=" margin-right: 10px; "><svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z" fill="white"/>
                    </svg></i>Факторный анализ отклонений ТР</a>
                <a href="tr" class="col but-nav__link but trfabuttech"><i style=" margin-right: 10px; "><svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z" fill="white"/>
                    </svg></i>Технологический режим</a>
            </div>
        <!-- <div class="row justify-content-between">
                <form class="form-group but-nav__link">
                        <label for="inputDate">Введите дату:</label>
                        <input type="date" class="form-control" v-model="date1">
                </form>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Выбор даты 2:</label>
                        <input type="date" class="form-control" v-model="date2">
                </form>
                <a href="#" class="but-nav__link but" @click.prevent="chooseDt">Сформировать</a>
        </div> -->
        </div>
        <div class="col-md-9 row sec_nav trfacolmdrowsecnav">
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle trfabtgraph" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Выберите график
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item"
                        href="#"
                        @click=" chartShow ='pie' "
                    >PieChart</a>
                    <a
                        class="dropdown-item"
                        href="#"
                        @click=" chartShow ='bar' "
                    >BarChart</a>
                </div>
            </div>
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle trfabtdata" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Выберите дату
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                           <label for="inputDate">Введите опорную дату:</label>
                            <input type="date" class="form-control" v-model="date1">
                            <label for="inputDate">Введите дату для сравнения:</label>
                            <input type="date" class="form-control" v-model="date2">
                            <a href="#" class="but-nav__link but" @click.prevent="chooseDt">Сформировать</a> 
                </div>
            </div>
        </div>
        <div class="col-md-9 sec_nav">
            <div class="namefilter" style="color:white; margin-left: 556px;">
                <h3> Фильтр по </h3>
            </div>
            <div class="filter_chart row">
                <div class="filterplaceone" style="margin-left: 211px; width: 300px;">
                    <select
                        class="form-control"
                        v-model="chartFilter_field"
                        value="Месторождение"
                    >
                        <option
                            v-for="(f, k) in fieldFilters"
                            :key="k"
                            :value="f">{{f === undefined ? 'Выберите месторождение' : f}}</option>
                    </select>
                </div>
                <div class="filterplacetwo" style=" width: 300; margin-left: 7px;">
                    <select
                        class="form-control"
                        v-model="chartFilter_horizon"
                    >
                        <option
                            v-for="(f, k) in horizonFilters"
                            :key="k"
                            :value="f">{{f === undefined ? 'Выберите горизонт' : f}}</option>
                    </select>
                </div>
                <div class="filterplacethree" style="margin-left: 7;width: 300;">
                    <select
                        v-if="exp_methFilters"
                        class="form-control"
                        v-model="chartFilter_exp_meth"
                    >
                        <option
                            v-for="(f, k) in exp_methFilters"
                            :key="k"
                            :value="f">{{f === undefined ? 'Выберите способ эксплуатации' : f}}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm" v-if="chartShow === 'bar'">
                <div class="second_block">
                    <apexchart
                        v-if="barChartData && pieChartRerender"
                        type="bar"
                        :options="chartBarOptions"
                        :series="[{ name:'', data: barChartData}]"
                    ></apexchart>
                </div>
            </div>
            <div class="col-sm" v-if="chartShow === 'pie'">
                <div class="first_block">
                    <apexchart
                        v-if="pieChartData && pieChartRerender"
                        type="pie"
                        :options="chartOptions"
                        :series="pieChartData"
                    ></apexchart>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
export default {
    computed: {
      // field horizon exp_meth
      // Pbh wct p_res PI
        pieChartData(){
            if (this.chartWells && this.chartWells.length > 0){
                let field = this.chartFilter_field;
                let horizon = this.chartFilter_horizon;
                let exp_meth = this.chartFilter_exp_meth;
                try {
                    let filteredResult = this.chartWells.filter((row) => (
                        (!field || row.field === field)
                        && (!horizon || row.horizon === horizon)
                        && (!exp_meth || row.exp_meth === exp_meth)
                    ));
                    console.log(filteredResult);
                    let filteredData = filteredResult.reduce((acc, res) => {
                        if (acc.hasOwnProperty(res['Main_problem'])) {
                            acc[res['Main_problem']]+=1;
                        } else {
                            acc[res['Main_problem']]=1;
                        }
                        return acc;
                    }, {})
                    console.log('Pie chart filtered data:',filteredData)
                    return [
                        filteredData['Недостижение режимного P забойного'] || 0,
                        filteredData['Рост обводненности'] || 0,
                        // filteredData['p_res'],
                        filteredData['Снижение P пластового'] || 0,
                        filteredData['Снижение Кпрод'] || 0,
                    ]
                } catch(err) {
                    console.error(err);
                    return false
                }
                return false;
            } else return false
        },
        barChartData(){
            if (this.chartWells && this.chartWells.length > 0){
                let field = this.chartFilter_field;
                let horizon = this.chartFilter_horizon;
                let exp_meth = this.chartFilter_exp_meth;
                try {
                    let filteredResult = this.chartWells.filter((row) => (
                        (!field || row.field === field)
                        && (!horizon || row.horizon === horizon)
                        && (!exp_meth || row.exp_meth === exp_meth)
                    ));
                    console.log(filteredResult);
                    let filteredData = filteredResult.reduce((acc, res) => {
                        acc = {
                            'Pbh': acc['Pbh'] + res['Pbh'],
                            'wct': acc['wct'] + res['wct'],
                            'p_res': acc['p_res'] + res['p_res'],
                            'PI': acc['PI'] + res['PI'],
                        }
                        return acc;
                    }, {
                        Pbh: 0,
                        wct: 0,
                        p_res:0,
                        PI: 0,
                    })
                    return [filteredData['Pbh'],
                        filteredData['wct'],
                        filteredData['p_res'],
                        filteredData['PI']
                    ]
                } catch(err) {
                    console.error(err);
                    return false
                }
                //return false;
            } else return false
        },

        fieldFilters(){
            if (this.chartWells && this.chartWells.length > 0){
                let filters = []
                this.chartWells.forEach((el) => {
                    if (
                        (filters.indexOf(el.field) === -1)
                        && (!this.chartFilter_horizon || (el.horizon === this.chartFilter_horizon))
                        && (!this.chartFilter_exp_meth || (el.exp_meth === this.chartFilter_exp_meth))
                    ){
                        filters = [ ...filters, el.field]
                    }
                })
                return [ undefined, ...filters]
            } else return []
        },
        horizonFilters(){
            if (this.chartWells && this.chartWells.length > 0){
                let filters = []
                this.chartWells.forEach((el) => {
                    if (
                        (filters.indexOf(el.horizon) === -1)
                        && (!this.chartFilter_field || (el.field === this.chartFilter_field))
                        && (!this.chartFilter_exp_meth || (el.exp_meth === this.chartFilter_exp_meth))
                    ){
                        filters= [ ...filters, el.horizon]
                    }
                })
                return [ undefined, ...filters]
            } else return []
        },
        exp_methFilters(){
            if (this.chartWells && this.chartWells.length > 0){
                let filters = []
                this.chartWells.forEach((el) => {
                    if (
                        (filters.indexOf(el.exp_meth) === -1)
                        && (!this.chartFilter_field || (el.field === this.chartFilter_field))
                        && (!this.chartFilter_horizon || (el.horizon === this.chartFilter_horizon))
                    ){
                        filters = [ ...filters, el.exp_meth]
                    }
                })
                return [ undefined, ...filters]
            } else return []
        },
  },
  data: function () {
    return {
        chartShow: 'bar',
        pieChartRerender: true,
        wells: [],
        chartWells: [],
        sortType: 'asc',
        dt: null,
        dt2: null,
        date1: null,
        date2: null,
        fullWells: [],
        filter: null,
        editdtm: null,
        editdty: null,
        editdtprevm: null,
        editdtprevy: null,
        chartFilter_field: undefined,
        chartFilter_horizon: undefined,
        chartFilter_exp_meth: undefined,
        chartBarOptions: {
            chart: {
              height: 350,
              type: 'bar',
            },
            plotOptions: {
              bar: {
                dataLabels: {
                  position: 'bottom', // top, center, bottom
                },
              }
            },
            dataLabels: {
              enabled: true,
              formatter: function (val) {
                return val;
              },
              offsetY: -20,
              style: {
                fontSize: '12px',
                colors: ["#304758"]
              }
            },

            xaxis: {
              categories: ["Недостижение режимного Pзаб", "Рост обводненности", "Снижение Pпл", "Снижение Kпрод"],
              position: 'bottom',
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false
              },
              crosshairs: {
                fill: {
                  type: 'gradient',
                  gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                  }
                }
              },
              tooltip: {
                enabled: true,
              }
            },
            yaxis: {
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false,
              },
              labels: {
                show: true,
                formatter: function (val) {
                  return val;
                }
              }

            },
        },
        chartOptions: {
            labels: ["Недостижение режимного Pзаб", "Рост обводненности","Снижение Pпл","Снижение Kпрод"],
            chart: {
            type: "pie",
            },
            dataLabels: {
            enabled: false,
            } /*убирается подсветка процентов на круге*/,
            /*tooltip: {
        enabled: false},*/
            legend: {
            show: false,
            } /*убирается навигация рядом с кругом*/,
            colors: ["#330000", "#804d00", "#00004d", "#999900"],
            plotOptions: {
                pie: {
                    expandOnClick: true,
                },
            },
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200,
                        },
                        legend: {
                            position: "bottom",
                        },
                    },
                },
            ],
        },
    }
  },
  watch: {
      pieChartData(){
          this.pieChartRerender = false;
          this.$nextTick(() => {
              this.pieChartRerender = true;
          })
      },
      barChartData(){
          this.pieChartRerender = false;
          this.$nextTick(() => {
              this.pieChartRerender = true;
          })
      }
  },
  methods: {
      chooseDt() {
          const { date1, date2 } = this;
          console.log('dt1-', date1, ' dt2-', date2);
          var choosenDt = date1.split("-");
          var choosenSecDt = date2.split("-");
          if(choosenDt[1]==1){
              var prMm = 12;
              var prPrMm = 11;
              var yyyy = choosenDt[0] - 1;
              var pryyyy = choosenSecDt[0];
          }
          else if(choosenSecDt[1] == 1){
              var prMm = choosenDt[1] - 1;
              var prPrMm = 12;
              var yyyy = choosenDt[0];
              var pryyyy = choosenSecDt[0] - 1;
          }
          else{
              var prMm = choosenDt[1] - 1;
              var prPrMm = choosenSecDt[1] - 1;
              var yyyy = choosenDt[0];
              var pryyyy = choosenSecDt[0];
          }
          console.log('date1', prMm, yyyy, 'date2', prPrMm, pryyyy)
          this.axios.get("http://172.20.103.51:7576/api/techregime/factor/graph1/"+yyyy+"/"+prMm+"/"+pryyyy+"/"+prPrMm+"/").then((response) => {
                let data = response.data;
                this.editdtm = choosenDt[1];
                this.editdty = choosenDt[0];
                this.editdtprevm = choosenSecDt[1];
                this.editdtprevy = choosenSecDt[0];
                if(data) {
                    console.log(data);
                    this.wells = data.data;
                    this.fullWells = data.data;
                    this.chartWells = data.data;

                }
                else {
                    console.log('No data');
                }
                this.dt = '01' + '.' + this.editdtm + '.' + this.editdty;
                this.dt2 = '01' + '.' + this.editdtprevm + '.' + this.editdtprevy ;

            });
      },
      pushBign(bign){
          switch (bign) {
              case 'bign1':
                  this.params.data = this.wellsList;
                  break;
          }
          this.$modal.show(bign);
      },
      getColor(status) {
          if (status < "0") return "#ac3939";
      },
    },
    beforeCreate: function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        var pryyyy = today.getFullYear();
        var prMm = mm;
        var prPrMm = mm;
        if(mm==0){
            var prMm = 12;
            var prPrMm = 11;
            var yyyy = yyyy - 1;
            var pryyyy = pryyyy - 1;
        }
        else{
            var prMm = prMm - 1;
            var prPrMm = prPrMm -2;
            var yyyy = yyyy;
            var pryyyy = pryyyy;
        }
        this.axios.get("http://172.20.103.51:7576/api/techregime/factor/graph1/"+yyyy+"/"+prMm+"/"+pryyyy+"/"+prPrMm+"/").then((response) => {
        let data = response.data;
        this.editdtm = prMm;
        console.log(this.editdtm);
        this.editdty = yyyy;
        console.log(this.editdty);
        this.editdtprevm = prPrMm;
        console.log(this.editdtprevm);
        this.editdtprevy = yyyy;
        console.log(this.editdtprevy);
        if(data) {
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
            this.chartWells = data.data;
        }
        else {
            console.log('No data');
        }
        if(this.editdtm < 10 && this.editdtprevm < 10) {
            this.dt = '01' + '.0' + this.editdtm + '.' + this.editdty;
            this.dt2 = '01' + '.0' + this.editdtprevm + '.' + this.editdtprevy ;
        }
        else if(this.editdtm <= 10 && this.editdtprevm <=10) {
            this.dt = '01'+ '.' + this.editdtm + '.' + this.editdty;
            this.dt2 = '01' + '.' + this.editdtprevm + '.' + this.editdtprevy;
        }
        else if(editdtm >= 10 && editdtprevm < 10) {
            this.dt = '01' + '.0' + this.editdtm + '.' + this.editdty;
            this.dt2 = '01' + '.0' + this.editdtprevm + '.' + this.editdtprevy;
        }
        if(this.editdtm < 10) {
            this.dt = '01' + '.0' + this.editdtm + '.' + this.editdty;
        }
        else {
            this.dt = '01' + '.' + this.editdtm + '.' + this.editdty;
        }
        if(this.editdtprevm < 10) {
            this.dt2 = '01' + '.0' + this.editdtprevm + '.' + this.editdtprevy;
        }
        else {
            this.dt2 = '01' + '.' + this.editdtprevm + '.' + this.editdtprevy;
        }
    });
   },

}
</script>
<style  scoped>


body {
  color: white !important;
}
.trfabuttech {
    margin-left: 57px;
}
.trfacolmdrowsecnav {
    margin-bottom: 7px;
    margin-top: 7px;
    margin-left: 1px;
}
.trfacolbutnavlinkbut {
    margin-left: 28px;
}
.trfabtdata {
    margin-left: 864px;
    background: #5973CC !important;
}
.trfabtgraph {
    margin-left: 45px;
    background: #5973CC !important;
}
</style>



