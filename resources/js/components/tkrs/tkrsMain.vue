<template>
  <div class="tkrs-main">
    <mainHeader />
    <indicator />
    <search />
    <div class="tkrs-content">
      <BaseTable :fields="fields" :items="items" :filter="true"/>
    </div>
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import indicator from "./indicator.vue";
import search from "./search.vue";
import BaseTable from './BaseTable.vue'


export default {
  name: "tkrsMain",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    indicator,
    search,
    BaseTable,
  },
  data(){
    return {
      fields: ['№', 'Активность', 'Свзяь', 'Бригада', 'Месторождение', 'Скважина', 'Тип ремонта', 'Вид ремонта', 'Оповощение', 'GPS', 'Видео', 'Датчик силы'],
      items: [['1', '/img/tkrs/active.svg', '/img/tkrs/connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_good.svg', '/img/tkrs/gps.svg', '/img/tkrs/video.svg', '/img/tkrs/force_sensor.svg',],['2', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',]]
    }
  }
};
</script>
'/img/tkrs/eyes.svg'
<style scoped>
.tkrs-main {
  width: 100%;
  height: 100%;
}

.tkrs-content {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
}
table {
  color: white;
  background: #333975;
}
table, th, td {
  border:1px solid black;
}
</style>