<template>
  <div>
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
                      <td><img class="cursor-pointer" @click="brigada_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/brigada_table.svg" alt="">Бригада №11 ТОО "Жанрос Дриллинг</td>
                      <td>Акшабулак Восточный</td>
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/brigada_table.svg" alt="">Акш 40</td>
                      <td>КРС/ПРС</td>
                      <td>Ремонтно-изоляционные работы (РИР)</td>
                      <td><img class="cursor-pointer" src="/img/tkrs/notification_good.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/gps.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/video.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/force_sensor.svg" alt=""></td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td><img class="cursor-pointer" src="/img/tkrs/active.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/connection.svg" alt=""></td>
                      <td><img class="cursor-pointer" @click="brigada_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/brigada_table.svg" alt="">Бригада №11 ТОО "Жанрос Дриллинг</td>
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
</template>

<script>
export default {

}
</script>
<style lang="scss" scoped src="../BaseTableStyles.scss"></style>
<style>

</style>