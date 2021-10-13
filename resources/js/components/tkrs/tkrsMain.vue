<template>
  <div class="tkrs-main">
    <mainHeader />
    <indicator />
    <search />
    <div class="tkrs-content">
      <!-- <BaseTable :fields="fields" :items="items" :filter="true"/> -->
      <div class="table-div">
            <div>
              <table>
                <thead>
                  <tr>
                    <th>№</th>
                    <th>Активность</th>
                    <th>Связь</th>
                    <th>Бригада</th>
                    <th>Месторождение</th>
                    <th>Скважина</th>
                    <th>Тип ремонта</th>
                    <th>Вид ремонта</th>
                    <th>Оповощение</th>
                    <th>GPS</th>
                    <th>Видео</th>
                    <th>Датчик силы</th>
                  </tr>
                </thead>
                <tbody>
                  
                    <tr>
                      <td>1</td>
                      <td><img class="cursor-pointer" src="/img/tkrs/active.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/connection.svg" alt=""></td>
                      <td>Бригада №11 ТОО "Жанрос Дриллинг</td>
                      <td>Акшабулак Восточный</td>
                      <td>Акш 40</td>
                      <td>КРС/ПРС</td>
                      <td>Ремонтно-изоляционные работы (РИР)</td>
                      <td><img class="cursor-pointer" src="/img/tkrs/notification_good.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/gps.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/video.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/force_sensor.svg" alt=""></td>
                    </tr>
                  
                  
                </tbody>
              </table>
            </div>
      </div>
    </div>
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import indicator from "./indicator.vue";
import search from "./search.vue";


export default {
  name: "tkrsMain",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    indicator,
    search,

  },
  data(){
    return {
      fields: ['№', 'Активность', 'Свзяь', 'Бригада', 'Месторождение', 'Скважина', 'Тип ремонта', 'Вид ремонта', 'Оповощение', 'GPS', 'Видео', 'Датчик силы'],
      items: [['1', '/img/tkrs/active.svg', '/img/tkrs/connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', "Акшабулак Восточный", 'Акш 40', 
      'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_good.svg', '/img/tkrs/gps.svg', '/img/tkrs/video.svg', 
      '/img/tkrs/force_sensor.svg',],
      ['2', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['3', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['4', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['5', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['6', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['7', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['8', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['9', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['10', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',],
      ['11', '/img/tkrs/active.svg', '/img/tkrs/no_connection.svg', 'Бригада №11 ТОО "Жанрос Дриллинг"', 
      "Акшабулак Восточный", 'Акш 40', 'КРС/ПРС', 'Ремонтно-изоляционные работы (РИР)', '/img/tkrs/notification_error.svg', 
      '/img/tkrs/gps.svg', '/img/tkrs/video_no.svg', '/img/tkrs/force_sensor.svg',]]
    }
  }
};
</script>
<style lang="scss" scoped src="./BaseTableStyles.scss"></style>
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
  border:1px solid #454D7D;
}

</style>