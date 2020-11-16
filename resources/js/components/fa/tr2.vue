<template>
    <body>
        <header class ="header">
            <div class="container">
                <nav class="nav">
                    <div class="navig">
                    </div>
                    <div class="but-nav">
                        <a href="#" class="but-nav__link">Факторный анализ отклонений ТР</a>
                        <a href="#" class="but-nav__link">Выбор даты</a>
                        <a href="#" class="but-nav__link">Выбор даты 2</a>
                        <a href="#" class="but-nav__link">Сформировать</a>
                        <a href="#" class="but-nav__link">Редактировать</a>
                        <a href="#" class="but-nav__link">Экспорт</a>
                    </div>
                </nav>
            </div>
        </header>
        <table class="table table-bordered table-dark" border="1" style="position: sticky; top: 54.7901% !important; bottom: 66.58%; background: rgb(13, 30, 99) none repeat scroll 0% 0%; left: 14px !important; right: 20px; border-right-style: solid;display: inline;/*! flex-wrap: wrap-reverse; */">
            <tr>
                <td rowspan="3" class="verticalTableHeader"><p>№ скв</p></td>
                <td rowspan="3" class="verticalTableHeader"><p>Тип скважины</p></td>
                <td rowspan="3" class="verticalTableHeader"><p>Горизонт</p></td>
                <td rowspan="3" class="verticalTableHeader"><p>Наружный диаметр э/к</p></td>
                <td rowspan="3" class="verticalTableHeader">Наружный диаметр НТК</td>
                <td rowspan="3" class="verticalTableHeader">Диаметр штуцера</td>
                <td rowspan="3" class="verticalTableHeader">Н вд</td>
                <td rowspan="3" class="verticalTableHeader">СЭ</td>
                <td rowspan="3" class="verticalTableHeader">Тип Насоса</td>
                <td rowspan="3" class="verticalTableHeader">Частота работы насоса или число оборотов</td>
                <td rowspan="3" class="verticalTableHeader">Н сп насоса</td>
                <td rowspan="3" class="verticalTableHeader">Р насоса</td>
                <td rowspan="3" class="verticalTableHeader">Н д</td>
                <td rowspan="3" class="verticalTableHeader">Р затр</td>
                <td colspan="4">Фатический режим</td>
                <td rowspan="3" class="verticalTableHeader">Состояние на конец месяца</td>
                <td rowspan="3" class="verticalTableHeader">ГФ</td>
                <td rowspan="3" class="verticalTableHeader">К пр</td>
                <td colspan="6">Расчет технологического потенциала от ИДН</td>
            </tr>
            <tr>
                <td rowspan="2" class="verticalTableHeader">P заб</td>
                <td rowspan="2" class="verticalTableHeader">Q нефти</td>
                <td rowspan="2" class="verticalTableHeader">Q жидкости</td>
                <td rowspan="2" class="verticalTableHeader">Обводненность</td>
                <td rowspan="2" class="verticalTableHeader">P заб</td>
                <td colspan="2">ИДН</td>
                <td rowspan="2" class="verticalTableHeader">К пр от стимуляции</td>
                <td colspan="2">ГРП</td>
            </tr>
            <tr>
                <td class="verticalTableHeader">Q ж</td>
                <td class="verticalTableHeader">Прирост Q н</td>
                <td class="verticalTableHeader">Q ж</td>
                <td class="verticalTableHeader">Прирост Q н</td>
            </tr>
            <tr>
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
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </body>

</template>
<link href="{{ asset('css/tr.css')}}" rel="stylesheet">
<script>

</script>
<style>
body {
  color: white !important;
}
</style>


<template>
    <div class="sizing">
        <nav class="nav">
            <div class="navig">
            </div>
            <div class="but-nav">
                <a href="#" class="but-nav__link">Факторный анализ отклонений ТР</a>
                <a href="#" class="but-nav__link">Выбор даты</a>
                <a href="#" class="but-nav__link">Выбор даты 2</a>
                <a href="#" class="but-nav__link">Сформировать</a>
                <a href="#" class="but-nav__link">Редактировать</a>
                <a href="#" class="but-nav__link">Экспорт</a>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Введите дату:</label>
                        <input type="date" class="form-control" >
                </form>
            </div>
        </nav>
        <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
            <tr class="headerColumn">
                <td rowspan="4" @click="sort('well')"><span>№ скв</span></td>
                <td rowspan="4" @click="sort('well_type')"><span>Тип скважины</span></td>
                <td rowspan="4" @click="sort('horizon')"><span>Горизонт</span></td>
                <td rowspan="4" @click="sort('cas_OD')"><span>Наружный диаметр э/к</span></td>
                <td rowspan="4" @click="sort('tub_OD')"><span>Наружный диаметр НТК</span></td>
                <td rowspan="4" @click="sort('choke_d')"><span>Диаметр штуцера</span></td>
                <td rowspan="4" @click="sort('h_up_perf_vd')"><span>Н вд</span></td>
                <td rowspan="4" @click="sort('exp_meth')"><span>СЭ</span></td>
                <td rowspan="4" @click="sort('pump_type')"><span>Тип Насоса</span></td>
                <td rowspan="4" @click="sort('freq')"><span>Частота работы насоса или число оборотов</span></td>
                <td rowspan="4" @click="sort('h_pump_set')"><span>Н сп насоса</span></td>
                <td rowspan="4" @click="sort('p_res')"><span>Р насоса</span></td>
                <td rowspan="4" @click="sort('h_dyn')"><span>Н д</span></td>
                <td rowspan="4" @click="sort('p_annular')"><span>Р затр</span></td>
                <td class="colspan" colspan="4">Фактический режим</td>
                <td rowspan="4" @click="sort('well_status_last_day')"><span>Состояние на конец месяца</span></td>
                <td rowspan="4" @click="sort('')"><span>ГФ</span></td>
                <td rowspan="4" @click="sort('')"><span>К пр</span></td>
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
        <div>
            <p><select name="Company">
                <optgroup label="Kazger">
                    <option value="r1">Akshabulak</option>
                </optgroup>
                <optgroup label="">
                    <option value="u1"></option>
                    <option value="u2"></option>
                    <option value="u3"></option>
                </optgroup>
                </select></p>
            <p><input type="submit" value="Отправить"></p>
        </div>
        <div>

        </div>
    </div>
</template>
<script>
const app = new Vue({
  el:'#app',
  data:{
    wells:[],
    currentSort:'name',
    currentSortDir:'asc'
  },
  created:function() {
    fetch("http://172.20.103.51:7575/api/techregime/2020/4/")
    .then(res => res.json())
    .then(res => {
      this.wells = res;
    })
  },
  methods:{
    sort:function(s) {
      //if s == current sort, reverse
      if(s === this.currentSort) {
        this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
      }
      this.currentSort = s;
    }
  },
  computed:{
    sortedWells:function() {
      return this.wells.sort((a,b) => {
        let modifier = 1;
        if(this.currentSortDir === 'desc') modifier = -1;
        if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
        if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
        return 0;
      });
    }
  }
})
</script>
<style>
body {
  color: white !important;
}
</style>
