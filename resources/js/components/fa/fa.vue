<template>
    <div class="container-fluid">
        <div class="row justify-content-between">
                <a href="tr" class="but-nav__link but">Технологический режим</a>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Введите дату:</label>
                        <input type="date" class="form-control" v-model="dt">
                </form>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Выбор даты 2:</label>
                        <input type="date" class="form-control" v-model="dt2">
                </form>
                <a href="#" class="but-nav__link but" @click.prevent="chooseDt">Сформировать</a>
                <a href="#" class="but-nav__link but">Редактировать</a>
                <a href="#" class="but-nav__link but">Экспорт</a>

        </div>
        <div>
            <select name="Company" class="from-control" id="companySelect"
                v-model="filter" @change="chooseField">
                <option value="Акшабулак Центральный">Акшабулак Центральный</option>
                <option value="Акшабулак Южный">Акшабулак Южный</option>
                <option value="Акшабулак Восточный">Акшабулак Восточный</option>
                <option value="Нуралы">Нуралы</option>
                <option value="Аксай">Аксай</option>
                <option value="Аксай Южный">Аксай Южный</option>
            </select>
        </div>
        <div>
            <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
                <tr class="headerColumn">
                    <td rowspan="3" @click="sortBy('well')"><span>Скважина</span></td>
                    <td rowspan="3" @click="sortBy('field')"><span>Месторождение</span></td>
                    <td rowspan="3" @click="sortBy('horizon')"><span>Пласт</span></td>
                    <td rowspan="3" @click="sortBy('exp_meth')"><span>Способ Эксплуатации</span></td>
                    <td class="colspan" colspan="6">ТР на {{dt}}</td>
                    <td class="colspan" colspan="6">ТР на {{dt2}}</td>
                    <td class="colspan" colspan="1">Отклон. Qн</td>
                    <td class="colspan" colspan="1">Технологические</td>
                    <td class="colspan" colspan="3">Геологические</td>
                    <td rowspan="3" @click="sortBy('Main_problem')"><span>Основное отклонение в ТР</span></td>
                </tr>
                <tr class="headerColumn">
                    <td rowspan="2" @click="sortBy('q_l_1')"><span>Qж, м3/сут</span></td>
                    <td rowspan="2" @click="sortBy('q_o_1')"><span>Qн, м3/сут</span></td>
                    <td rowspan="2" @click="sortBy('wct_1')"><span>Обводненность</span></td>
                    <td rowspan="2" @click="sortBy('bhp_1')"><span>Pзаб, ат</span></td>
                    <td rowspan="2" @click="sortBy('p_res_1')"><span>Pпл,ат</span></td>
                    <td rowspan="2" @click="sortBy('pi_1')"><span>Кпр,м3/сут/ат</span></td>
                    <td rowspan="2" @click="sortBy('q_l_2')"><span>Qж, м3/сут</span></td>
                    <td rowspan="2" @click="sortBy('q_o_2')"><span>Qн, м3/сут</span></td>
                    <td rowspan="2" @click="sortBy('wct_2')"><span>Обводненность</span></td>
                    <td rowspan="2" @click="sortBy('bhp_2')"><span>Pзаб, ат</span></td>
                    <td rowspan="2" @click="sortBy('p_res_2')"><span>Pпл,ат</span></td>
                    <td rowspan="2" @click="sortBy('pi_2')"><span>Кпр,м3/сут/ат</span></td>
                    <td rowspan="2" @click="sortBy('dqo')"><span>dQн, т/сут</span></td>
                    <td rowspan="2" @click="sortBy('Pbh')"><span>Недостижение режимного Pзаб</span></td>
                    <td rowspan="2" @click="sortBy('wct')"><span>Рост обводненности</span></td>
                    <td rowspan="2" @click="sortBy('p_res')"><span>Снижение Pпл</span></td>
                    <td rowspan="2" @click="sortBy('PI')"><span>Снижение Kпрод</span></td>
                </tr>
                <tr></tr>
                <tr v-for="(row, row_index) in wells" :key="row_index">
                    <td> {{row.well}}</td>
                    <td>{{row.field}}</td>
                    <td>{{row.horizon}}</td>
                    <td>{{row.exp_meth}}</td>
                    <td>{{Math.round(row.q_l_1*10)/10}}</td>
                    <td>{{Math.round(row.q_o_1*10)/10}}</td>
                    <td>{{Math.round(row.wct_1*10)/10}}</td>
                    <td>{{Math.round(row.bhp_1*10)/10}}</td>
                    <td>{{Math.round(row.p_res_1*10)/10}}</td>
                    <td>{{Math.round(row.pi_1*10)/10}}</td>
                    <td>{{Math.round(row.q_l_2*10)/10}}</td>
                    <td>{{Math.round(row.q_o_2*10)/10}}</td>
                    <td>{{Math.round(row.wct_2*10)/10}}</td>
                    <td>{{Math.round(row.bhp_2*10)/10}}</td>
                    <td>{{Math.round(row.p_res_2*10)/10}}</td>
                    <td>{{Math.round(row.pi_2*10)/10}}</td>
                    <td>{{Math.round(row.dqo*10)/10}}</td>
                    <td>{{Math.round(row.Pbh*10)/10}}</td>
                    <td>{{Math.round(row.wct*10)/10}}</td>
                    <td>{{Math.round(row.p_res*10)/10}}</td>
                    <td>{{Math.round(row.PI*10)/10}}</td>
                    <td>{{row.Main_problem}}</td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
export default {
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
        }
        else {
            console.log('No data');
        }
    });
  },
  data: function () {
    return {
        wells: [],
        sortType: 'asc',
        dt: null,
        dt2: null,
        fullWells: []
    }
  },
  methods: {
      sortBy(type) {
          let { wells, sortType } = this;
          console.log(type, sortType);
          if(sortType === 'asc') {
            wells.sort((a, b) => a[type].localeCompare(b[type]))
            this.sortType = 'desc';
          } else {
            wells.sort((a, b) => b[type].localeCompare(a[type]))
            this.sortType = 'asc';
          }

      },
      chooseDt() {
          const { dt, dt2 } = this;
          console.log('dt1-', dt, ' dt2-', dt2);
          var choosenDt = dt.split("-");
          var choosenSecDt = dt2.split("-");
          this.axios.get("http://172.20.103.51:7576/api/techregime/factor/"+choosenDt[0]+"/"+choosenDt[1]+"/"+choosenSecDt[0]+"/"+choosenSecDt[1]+"/").then((response) => {
                let data = response.data;
                if(data) {
                    console.log(data);
                    this.wells = data.data;
                }
                else {
                    console.log('No data');
                }
            });
      },
      chooseField() {
          const { filter, fullWells } = this;
          console.log(filter, fullWells);

          this.wells = fullWells.filter(e => e.field === filter);
      },
  }
}

</script>
<style>
body {
  color: white !important;
}
</style>
