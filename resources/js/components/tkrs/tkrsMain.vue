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
    <modal name="brigada_modal" :width="552" :height="757"  :adaptive="true" style="z-index:9900000; ">
                <div class="main_modals" style="background: #272953;  height:100%; border: 3px solid #656A8A;">
                    <a class="header-text-modal">Информация о бригаде</a>
                    <div>
                      <b-container fluid>
                        <b-row class="my-1">
                          <b-col sm="2" >
                            <label for="input-small">Дата:</label>
                          </b-col>
                          <b-col style="display:flex">
                            <b-form-input id="input-small" size="sm" style="width: 20%; height: 24px; background: #1A1D46;"></b-form-input><svg width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0L24.0001 0.0003553C26.2092 0.000388004 28 1.79124 28 4.00036V20.9999C28 23.209 26.2091 24.9999 24 24.9999H0V0Z" fill="#545580"/>
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M7.09091 5.35742C6.4909 5.35742 6 5.79572 6 6.33144V8.27948H22V6.33144C22 5.79572 21.5091 5.35742 20.9091 5.35742H19.8182H16.1818H12.1818H8.54545H7.09091ZM10.5 6.83089C10.5 7.20072 10.1642 7.50053 9.75 7.50053C9.33579 7.50053 9 7.20072 9 6.83089C9 6.46106 9.33579 6.16125 9.75 6.16125C10.1642 6.16125 10.5 6.46106 10.5 6.83089ZM17.9502 7.50006C18.3644 7.50006 18.7002 7.20025 18.7002 6.83042C18.7002 6.46059 18.3644 6.16078 17.9502 6.16078C17.536 6.16078 17.2002 6.46059 17.2002 6.83042C17.2002 7.20025 17.536 7.50006 17.9502 7.50006Z" fill="white"/>
                          <path d="M6 18.6689C6 19.2046 6.4909 19.6429 7.09091 19.6429H20.9091C21.5091 19.6429 22 19.2046 22 18.6689V8.92871H6V18.6689ZM18 10.5521C18 10.3735 18.1636 10.2274 18.3636 10.2274H19.8182C20.0182 10.2274 20.1818 10.3735 20.1818 10.5521V11.8508C20.1818 12.0293 20.0182 12.1754 19.8182 12.1754H18.3636C18.1636 12.1754 18 12.0293 18 11.8508V10.5521ZM18 13.4741C18 13.2956 18.1636 13.1495 18.3636 13.1495H19.8182C20.0182 13.1495 20.1818 13.2956 20.1818 13.4741V14.7728C20.1818 14.9514 20.0182 15.0975 19.8182 15.0975H18.3636C18.1636 15.0975 18 14.9514 18 14.7728V13.4741ZM18 16.3962C18 16.2176 18.1636 16.0715 18.3636 16.0715H19.8182C20.0182 16.0715 20.1818 16.2176 20.1818 16.3962V17.6949C20.1818 17.8734 20.0182 18.0195 19.8182 18.0195H18.3636C18.1636 18.0195 18 17.8734 18 17.6949V16.3962ZM14.3636 10.5521C14.3636 10.3735 14.5273 10.2274 14.7273 10.2274H16.1818C16.3818 10.2274 16.5455 10.3735 16.5455 10.5521V11.8508C16.5455 12.0293 16.3818 12.1754 16.1818 12.1754H14.7273C14.5273 12.1754 14.3636 12.0293 14.3636 11.8508V10.5521ZM14.3636 13.4741C14.3636 13.2956 14.5273 13.1495 14.7273 13.1495H16.1818C16.3818 13.1495 16.5455 13.2956 16.5455 13.4741V14.7728C16.5455 14.9514 16.3818 15.0975 16.1818 15.0975H14.7273C14.5273 15.0975 14.3636 14.9514 14.3636 14.7728V13.4741ZM14.3636 16.3962C14.3636 16.2176 14.5273 16.0715 14.7273 16.0715H16.1818C16.3818 16.0715 16.5455 16.2176 16.5455 16.3962V17.6949C16.5455 17.8734 16.3818 18.0195 16.1818 18.0195H14.7273C14.5273 18.0195 14.3636 17.8734 14.3636 17.6949V16.3962ZM11.0909 10.5521C11.0909 10.3735 11.2545 10.2274 11.4545 10.2274H12.9091C13.1091 10.2274 13.2727 10.3735 13.2727 10.5521V11.8508C13.2727 12.0293 13.1091 12.1754 12.9091 12.1754H11.4545C11.2545 12.1754 11.0909 12.0293 11.0909 11.8508V10.5521ZM11.0909 13.4741C11.0909 13.2956 11.2545 13.1495 11.4545 13.1495H12.9091C13.1091 13.1495 13.2727 13.2956 13.2727 13.4741V14.7728C13.2727 14.9514 13.1091 15.0975 12.9091 15.0975H11.4545C11.2545 15.0975 11.0909 14.9514 11.0909 14.7728V13.4741ZM11.0909 16.3962C11.0909 16.2176 11.2545 16.0715 11.4545 16.0715H12.9091C13.1091 16.0715 13.2727 16.2176 13.2727 16.3962V17.6949C13.2727 17.8734 13.1091 18.0195 12.9091 18.0195H11.4545C11.2545 18.0195 11.0909 17.8734 11.0909 17.6949V16.3962ZM7.81818 10.5521C7.81818 10.3735 7.98182 10.2274 8.18182 10.2274H9.63636C9.83636 10.2274 10 10.3735 10 10.5521V11.8508C10 12.0293 9.83636 12.1754 9.63636 12.1754H8.18182C7.98182 12.1754 7.81818 12.0293 7.81818 11.8508V10.5521ZM7.81818 13.4741C7.81818 13.2956 7.98182 13.1495 8.18182 13.1495H9.63636C9.83636 13.1495 10 13.2956 10 13.4741V14.7728C10 14.9514 9.83636 15.0975 9.63636 15.0975H8.18182C7.98182 15.0975 7.81818 14.9514 7.81818 14.7728V13.4741ZM7.81818 16.3962C7.81818 16.2176 7.98182 16.0715 8.18182 16.0715H9.63636C9.83636 16.0715 10 16.2176 10 16.3962V17.6949C10 17.8734 9.83636 18.0195 9.63636 18.0195H8.18182C7.98182 18.0195 7.81818 17.8734 7.81818 17.6949V16.3962Z" fill="white"/>
                          </svg>

                          </b-col>
                        </b-row>

                      </b-container>
                    </div>
                    <a style="color: white; padding-left: 13px;">Название станка: УП-60</a>
                    <div style="text-align: center; color: white;">Смена 1</div>
                    <div class="table-div">
                          <div>
                            <table>
                              <thead>
                                <tr>
                                  <th>Номер</th>
                                  <th>Должность</th>
                                  <th>ФИО</th>
                                </tr>
                              </thead>
                              <tbody>
                                
                                  <tr>
                                    <td>1</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>
                                  <tr>
                                    <td>4</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>
                                  <tr>
                                    <td>5</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>

                                
                                
                              </tbody>
                            </table>
                            <div style="text-align: center; color: white; padding-top: 5%;">Смена 2</div>
                            <table>
                              <thead>
                                <tr>
                                  <th>Номер</th>
                                  <th>Должность</th>
                                  <th>ФИО</th>
                                </tr>
                              </thead>
                              <tbody>
                                
                                  <tr>
                                    <td>1</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>
                                  <tr>
                                    <td>4</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>
                                  <tr>
                                    <td>5</td>
                                    <td>Бригадир</td>
                                    <td>Фамилия Имя Отчество</td>
                                  </tr>

                                
                                
                              </tbody>
                            </table>
                          </div>
                    </div>
                    

                  
                </div>
    </modal>
    <modal name="add_well" :width="552" :height="757"  :adaptive="true" style="z-index:9900000; ">
                <div class="main_modals" style="background: #272953;  height:100%; border: 3px solid #656A8A;">
                                          

                  
                </div>
    </modal>
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
  methods: {
    brigada_modal() {
        this.$modal.show('brigada_modal')
    },
    well_modal() {
        this.$modal.show('add_well')
    },
  },
  data(){
    return {
  
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
.cursor-pointer {
  padding-right: 8px;
}
.header-text-modal{
  font-size: 16px;
  font-family: Harmonia Sans Pro Cyr;
  color: white;
  padding-left: 13px;
}
.container-fluid {
  padding-top: 4%;
}
tr:hover {
  background: #454D7D;
}
</style>