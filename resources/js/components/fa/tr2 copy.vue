<template>
    <div class="sizing">
        <div class="but-nav navig nav">
                <a href="#" class="but-nav__link">Факторный анализ отклонений ТР</a>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Введите дату:</label>
                        <input type="date" class="form-control" v-model="dt" @change="chooseDt(dt)">
                </form>
                <a href="#" class="but-nav__link">Выбор даты 2</a>
                <a href="#" class="but-nav__link">Сформировать</a>
                <a href="#" class="but-nav__link">Редактировать</a>
                <a href="#" class="but-nav__link">Экспорт</a>

        </div>
        <div>
            <p><select name="Company" @change="chooseField($event)">
                <optgroup label="">
                    <option value="Акшабулак Центральный">Акшабулак Центральный</option>
                    <option value="Нуралы">Нуралы</option>
                </optgroup>
                </select></p>
            <p><input type="submit" value="Отправить"></p>
        </div>
        <div>
            <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
                <tr class="headerColumn">
                    <td rowspan="4" @click="sortBy('well')"><span>№ скв</span></td>
                    <td rowspan="4" @click="sortBy('well_type')"><span>Тип скважины</span></td>
                    <td rowspan="4" @click="sortBy('horizon')"><span>Горизонт</span></td>
                    <td rowspan="4" @click="sortBy('cas_OD')"><span>Наружный диаметр э/к</span></td>
                    <td rowspan="4" @click="sortBy('tub_OD')"><span>Наружный диаметр НТК</span></td>
                    <td rowspan="4" @click="sortBy('choke_d')"><span>Диаметр штуцера</span></td>
                    <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>Н вд</span></td>
                    <td rowspan="4" @click="sortBy('exp_meth')"><span>СЭ</span></td>
                    <td rowspan="4" @click="sortBy('pump_type')"><span>Тип Насоса</span></td>
                    <td rowspan="4" @click="sortBy('freq')"><span>Частота работы насоса или число оборотов</span></td>
                    <td rowspan="4" @click="sortBy('h_pump_set')"><span>Н сп насоса</span></td>
                    <td rowspan="4" @click="sortBy('p_res')"><span>Р насоса</span></td>
                    <td rowspan="4" @click="sortBy('h_dyn')"><span>Н д</span></td>
                    <td rowspan="4" @click="sortBy('p_annular')"><span>Р затр</span></td>
                    <td class="colspan" colspan="4">Фактический режим</td>
                    <td rowspan="4" @click="sortBy('well_status_last_day')"><span>Состояние на конец месяца</span></td>
                    <td rowspan="4" @click="sortBy('')"><span>ГФ</span></td>
                    <td rowspan="4" @click="sortBy('')"><span>К пр</span></td>
                    <td class="colspan" colspan="6">Расчет технологического потенциала от ИДН</td>
                </tr>
                <tr class="headerColumn">
                    <td rowspan="3"><span>P заб</span></td>
                    <td rowspan="3"><span>Q нефти</span></td>
                    <td rowspan="3"><span>Q жидкости</span></td>
                    <td rowspan="3"><span>Обводненность</span></td>
                    <td rowspan="3"><span>P заб</span></td>
                    <td class="colspan" colspan="2">ИДН</td>
                    <td rowspan="3"><span>К пр от стимуляции</span></td>
                    <td class="colspan" colspan="2">ГРП</td>
                </tr>
                <tr class="headerColumn">
                    <td rowspan="2"><span>Q ж</span></td>
                    <td rowspan="2"><span>Прирост Q н</span></td>
                    <td rowspan="2"><span>Q ж</span></td>
                    <td rowspan="2"><span>Прирост Q н</span></td>
                </tr>
                <tr></tr>
                <tr class="subHeaderColumn">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>мм</td>
                    <td>мм</td>
                    <td>м</td>
                    <td>м</td>
                    <td></td>
                    <td></td>
                    <td>Гц, об/мин</td>
                    <td>м</td>
                    <td>атм</td>
                    <td>м</td>
                    <td>атм</td>
                    <td>атм</td>
                    <td>т/сут</td>
                    <td>м3/сут</td>
                    <td>%</td>
                    <td></td>
                    <td>м3/т</td>
                    <td>м3/сут/атм</td>
                    <td>атм</td>
                    <td>м3/сут</td>
                    <td>т/сут</td>
                    <td>м3/сут/атм</td>
                    <td>м3/сут</td>
                    <td>т/сут</td>
                </tr>
                <tr v-for="(row, row_index) in wells" :key="row_index">
                    <td> {{row.well}}</td>
                    <td>{{row.well_type}}</td>
                    <td>{{row.horizon}}</td>
                    <td>{{row.cas_OD}}</td>
                    <td>{{row.tub_OD}}</td>
                    <td>{{row.choke_d}}</td>
                    <td>{{row.h_up_perf_vd}}</td>
                    <td>{{row.exp_meth}}</td>
                    <td>{{row.pump_type}}</td>
                    <td>{{row.freq}}</td>
                    <td>{{row.h_pump_set}}</td>
                    <td>{{row.p_res}}</td>
                    <td>{{row.h_dyn}}</td>
                    <td>{{row.p_annular}}</td>
                    <td>{{row.bhp}}</td>
                    <td>{{row.q_o}}</td>
                    <td>{{row.q_l}}</td>
                    <td>{{row.wct}}</td>
                    <td>{{row.well_status_last_day}}</td>
                    <td>{{row.gor}}</td>
                    <td>{{row.pi}}</td>
                    <td>{{row.tp_idn_bhp}}</td>
                    <td>{{row.tp_idn_liq}}</td>
                    <td>{{row.tp_idn_oil_inc}}</td>
                    <td>{{row.tp_idn_pi_after}}</td>
                    <td>{{row.tp_idn_grp_q_liq}}</td>
                    <td>{{row.tp_idn_grp_q_oil_inc}}</td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
export default {
  beforeCreate: function () {
        this.axios.get("http://172.20.103.51:7576/api/techregime/2020/6/").then((response) => {
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
  data: function () {
    return {
        wells: {},
        sortType: 'asc',
        dt: null
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
      chooseDt(dt) {
          console.log(dt)
          var choosenDt = dt.split("-");
          this.axios.get("http://172.20.103.51:7576/api/techregime/"+choosenDt[0]+"/"+choosenDt[1]+"/").then((response) => {
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
      chooseField(event) {
          var filterWells = _.findIndex(this.wells, function(chr) {
            return chr.field == event.target.value;
        });
        this.wells = filterWells;
      }
  }
}

</script>
<style>
body {
  color: white !important;
}
</style>
