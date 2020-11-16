<template>
    <div class="container-fluid">
        <div class="row justify-content-between">
            <a href="fa" class="but-nav__link but">Факторный анализ отклонений ТР</a>
            <form class="form-group but-nav__link">
                    <label for="inputDate">Введите дату:</label>
                    <input type="date" class="form-control" v-model="dt">
            </form>
            <a href="#" class="but-nav__link but">Выбор даты 2</a>
            <a href="#" @click.prevent="chooseDt" class="but-nav__link but">Сформировать</a>
            <a href="#" class="but-nav__link but">Редактировать</a>
            <a href="http://172.20.103.51:7576/api/techregime/factor/download" download="Factor_Analysis.xlsx" class="but-nav__link but">Экспорт</a>
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
        <button id="bt1"  @click="swap">Версия для отображения</button>
        <div >
            <TrTable :wells="wells" @onSort="sortBy" v-show="show_first"/>
            <TrFullTable :wells="wells" @onSort="sortBy" v-show="show_second"/>
        </div>
    </div>
</template>
<script>
import TrTable from './table'
import TrFullTable from './tablefull'

export default {
  name: "TrPage",
  components: {
      TrTable, TrFullTable,
  },
  beforeCreate: function () {
        this.axios.get("http://172.20.103.51:7576/api/techregime/2020/6/").then((response) => {
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
        filter: null,
        dt: null,
        fullWells: [],
        show_first: true,
        show_second: false,
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
          const { dt } = this;
          console.log(dt)
          var choosenDt = dt.split("-");
          this.axios.get("http://172.20.103.51:7576/api/techregime/"+choosenDt[0]+"/"+choosenDt[1]+"/").then((response) => {
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
      chooseField() {
          const { filter, fullWells } = this;
          console.log(filter, fullWells);

          this.wells = fullWells.filter(e => e.field === filter);
      },
      swap() {
          this.show_first = !this.show_first;
          this.show_second = !this.show_second;
      }
  }
}

</script>
<style>
body {
  color: white !important;
}
</style>
