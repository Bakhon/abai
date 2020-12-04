<template>
    <div class="container-fluid">
        <div class="col-md-12 row">
            <div class="col-md-9 row justify-content-between">
                <a href="fa" class="col but-nav__link but"><i style=" margin-right: 10px; "><svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z" fill="white"/>
                    </svg></i>Факторный анализ отклонений ТР</a>
                <a href="tr" class="col but-nav__link but"><i style=" margin-right: 10px; "><svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z" fill="white"/>
                    </svg></i>Технологический режим</a>
            </div>
        </div>
        <div class="col-md-9 row sec_nav">
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown link
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" >PieChart</a>
                    <a class="dropdown-item" >BarChart</a>
                </div>
            </div>
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown link
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <div class="col-md-9 sec_nav">
            <div>
                <h1> Фильтр по </h1>
            </div>
            <div class="filter_chart row">
                <div>
                    <select
                        class="form-control"
                        v-model="chartFilter_field"
                        value="Месторождение"
                    >
                        <option
                            v-for="(f, k) in fieldFilters"
                            :key="k"
                            :value="f">{{f}}</option>
                    </select>
                </div>
                <div>
                    <select
                        class="form-control"
                        v-model="chartFilter_horizon"
                    >
                        <option
                            v-for="(f, k) in horizonFilters"
                            :key="k"
                            :value="f">{{f}}</option>
                    </select>
                </div>
                <div>
                    <select
                        v-if="exp_methFilters"
                        class="form-control"
                        v-model="chartFilter_exp_meth"
                    >
                        <option
                            v-for="(f, k) in exp_methFilters"
                            :key="k"
                            :value="f">{{f}}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm">
                <div class="second_block">
                    <apexchart
                        v-if="barChartData && pieChartRerender"
                        type="bar"
                        :options="chartBarOptions"
                        :series="[{ name:'', data: barChartData}]"
                    ></apexchart>
                </div>
            </div>
            <div class="col-sm">
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
                        //acc = {
                        //    'Pbh': acc['Pbh'] + res['Pbh'],
                        //    'wct': acc['wct'] + res['wct'],
                        //    'p_res': acc['p_res'] + res['p_res'],
                        //    'PI': acc['PI'] + res['PI'],
                        //}
                        if (acc.hasOwnProperty(res['Main_problem'])) {
                            acc[res['Main_problem']]+=1;
                        } else {
                            acc[res['Main_problem']]=1;
                        }
                        return acc;
                    }, {})
                    console.log('Pie chart filtered data:',filteredData)
                    return [
                        filteredData['Pbh'] || 0,
                        filteredData['wct'] || 0,
                        // filteredData['p_res'],
                        filteredData['No problem'] || 0,
                        filteredData['PI'] || 0,
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
                    if (filters.indexOf(el.field) === -1){
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
                    if (filters.indexOf(el.horizon) === -1){
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
                    if (filters.indexOf(el.exp_meth) === -1){
                        filters = [ ...filters, el.exp_meth]
                    }
                })
                return [ undefined, ...filters]
            } else return []
        },
  },
  data: function () {
    return {
        pieChartRerender: true,
        wells: [],
        chartWells: [],
        sortType: 'asc',
        dt: null,
        dt2: null,
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
          const { dt, dt2 } = this;
          console.log('dt1-', dt, ' dt2-', dt2);
          var choosenDt = dt.split("-");
          var choosenSecDt = dt2.split("-");
          this.axios.get("http://172.20.103.51:7576/api/techregime/factor/"+choosenDt[0]+"/"+choosenDt[1]+"/"+choosenSecDt[0]+"/"+choosenSecDt[1]+"/").then((response) => {
                let data = response.data;
                this.editdtm = choosenDt[1];
                this.editdty = choosenDt[0];
                this.editdtprevm = choosenSecDt[1];
                this.editdtprevy = choosenSecDt[0];
                if(data) {
                    console.log(data);
                    this.wells = data.data;
                }
                else {
                    console.log('No data');
                }

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
        var prMm = mm-2;
        var prPrMm = mm-3;
        this.axios.get("http://172.20.103.51:7576/api/techregime/factor/"+yyyy+"/"+prMm+"/"+yyyy+"/"+prPrMm+"/").then((response) => {
        let data = response.data;
        if(data) {
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
            this.chartWells = data.data;
        }
    });
   },

}
</script>
<style>
body {
  color: white !important;
}
</style>



