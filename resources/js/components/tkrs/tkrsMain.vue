<template>
  <div class="tkrs-main">
    <mainHeader />
    <indicator />
    <search />
    <div class="tkrs-content">

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
                      <td><a class="a-link" href="hookWeightSensor">1</a></td>
                      <td><a class="a-link" href="hookWeightSensor"><img class="cursor-pointer" src="/img/tkrs/active.svg" alt=""></a></td>
                      <td><a class="a-link" href="hookWeightSensor"><img class="cursor-pointer" src="/img/tkrs/connection.svg" alt=""></a></td>
                      <td><img class="cursor-pointer" @click="brigada_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/brigada_table.svg" alt="">Бригада №11 ТОО "Жанрос Дриллинг</td>
                      <td><a class="a-link" href="hookWeightSensor">Акшабулак Восточный</a></td>
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
                      <td><a class="a-link" href="hookWeightSensor">КРС/ПРС</a></td>
                      <td><a class="a-link" href="hookWeightSensor">Ремонтно-изоляционные работы (РИР)</a></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/notification_good.svg" alt=""></td>
                      <td><a class="a-link" href="gpsPositioning"><img class="cursor-pointer" src="/img/tkrs/gps.svg" alt=""></a></td>
                      <td><a class="a-link" href="videoSurveillance"><img class="cursor-pointer" src="/img/tkrs/video.svg" alt=""></a></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/force_sensor.svg" alt=""></td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td><img class="cursor-pointer" src="/img/tkrs/active.svg" alt=""></td>
                      <td><img class="cursor-pointer" src="/img/tkrs/connection.svg" alt=""></td>
                      <td><img class="cursor-pointer" @click="brigada_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/brigada_table.svg" alt="">Бригада №11 ТОО "Жанрос Дриллинг</td>
                      <td>Акшабулак Восточный</td>
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                      <td><img class="cursor-pointer" @click="well_modal()" data-toggle="modal" 
                data-target="#exampleModalCenter"  src="/img/tkrs/well.svg" alt="">Акш 40</td>
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
                    <div class="modal-header">
                      <a class="header-text-modal">{{trans('tkrs.info_brigada')}}</a>
                      <div class="exit-div">
                        <button type="button" class="modal-bign-button" @click="closeModal('brigada_modal')">
                          {{ trans('pgno.zakrit') }}
                        </button>
                      </div>
                    </div>
                    <div>
                      <b-container fluid>
                        <b-row class="my-1">
                          <b-col sm="2" >
                            <label for="input-small">Дата:</label>
                          </b-col>
                          <b-col style="display:flex">
                            <b-form-input id="input-small" size="sm" style="width: 20%; height: 24px; background: #1A1D46;"></b-form-input>
                            <img class="cursor-pointer calendar-modal" src="/img/tkrs/calendar.svg" 
                            alt="">
                          </b-col>
                        </b-row>

                      </b-container>
                    </div>
                    <a class="machine-name">Название станка: УП-60</a>
                    <a class="tech-nkt"><img class="cursor-pointer calendar-modal" src="/img/tkrs/tech_nkt.svg" 
                            alt="">{{trans('tkrs.tech_nkt')}}</a>
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
    <modal name="add_well" :width="1600" :height="850"  :adaptive="true" style="z-index:9900000; ">
      <div class="main_modals" style="background: #272953;  height:100%; border: 3px solid #656A8A;">
                <div class="header-well-modal">Месторождение: Акшабулак, № скважины: 0453</div>
                <div class="header-well-modal-down"></div>
                <div>
                    <ul class="nav nav-tabs all-tabs">
                        <li class="nav-item test">
                            <a class="nav-link active" @click="selectTab(1)" href="#"><svg width="11" height="15" viewBox="0 0 11 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M10.4348 14.0625H10.0921L7.3311 2.85936H7.6167C7.85474 2.85936 8.09273 2.62497 8.09273 2.39065V1.40624C8.09273 1.12502 7.85474 0.937517 7.6167 0.937517H5.71251V-9.53674e-07H4.76041V0.937517H2.85621C2.61825 0.937517 2.38021 1.17192 2.38021 1.40624V2.39065C2.38021 2.67187 2.61825 2.85936 2.85621 2.85936H3.14188L0.380804 14.0625H0V15H10.4348V14.0625ZM8.42595 11.2969L6.14096 9.7969L7.8071 8.71874L8.42595 11.2969ZM7.04543 5.62498L6.14096 5.01561L6.80744 4.59373L7.04543 5.62498ZM5.71251 2.85936H6.37899L6.5694 3.56249L5.71251 4.12502V2.85936ZM5.71251 5.90623L7.37867 6.98438L7.4263 7.17187H5.71251V5.90623ZM5.71251 7.64065H7.5215V7.68748L5.71251 8.85939V7.64065ZM4.09399 2.85936H4.76041V4.07809L3.95115 3.56249L4.09399 2.85936ZM3.71311 4.59373L4.37962 5.01561L3.42751 5.62498L3.71311 4.59373ZM3.09426 6.98438L4.76041 5.90623V7.17187H3.04671L3.09426 6.98438ZM2.95148 7.64065H4.76041V8.90622L2.95143 7.73442L2.95148 7.64065ZM2.71345 8.6719L4.37962 9.75L2.04696 11.25L2.71345 8.6719ZM1.38056 14.0625L1.71373 12.6563L4.76041 10.6407V11.7187C4.52237 11.7187 4.28441 11.9531 4.28441 12.1875V13.125C4.28441 13.3594 4.52237 13.5938 4.76041 13.5938H5.71251C5.95055 13.5938 6.18851 13.3594 6.18851 13.125V12.1875C6.18851 11.9531 5.95055 11.7187 5.71251 11.7187V10.6407L8.75921 12.6563L9.09246 14.0625H1.38056Z" fill="white"/>
</svg>
Паспорт скважины</a>
                        </li>
                        <li class="nav-item test">
                            <a class="nav-link " @click="selectTab(2)" href="#"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M7.5 0C7.28171 0 7.10526 0.176447 7.10526 0.394737V2.28592C6.46184 2.1525 5.9175 2.04711 5.52632 1.97368L4.34211 2.76316L3.55263 3.55263H2.36842L1.97368 5.13158L1.18421 5.92105V7.10526H0.394737C0.176447 7.10526 0 7.28171 0 7.5C0 11.6357 3.36434 15 7.5 15C11.6357 15 15 11.6357 15 7.5C15 3.36434 11.6357 0 7.5 0ZM14.0913 8.7375C13.5083 11.848 10.7771 14.2105 7.5 14.2105C6.81316 14.2105 6.15079 14.1047 5.52632 13.9121V12.6316C5.52632 12.4137 5.70316 12.2368 5.92105 12.2368H6.71053L8.28947 13.0263L9.47368 12.2368V11.0526L10.6579 10.6579L9.86842 9.47368H8.68421L7.10526 9.07895L5.52632 9.86842H3.94737L2.76316 11.0526H1.81579C1.23434 10.1258 0.868421 9.05053 0.801316 7.89474H7.5C7.71829 7.89474 7.89474 7.71829 7.89474 7.5V0.800921C8.81132 0.854211 9.67697 1.09618 10.4589 1.48224L9.86842 2.36842L9.07895 3.15789L9.86842 4.73684H11.4474L12.2368 5.52632V6.71053L11.8421 7.5L12.6316 8.68421C12.992 8.74303 13.5 8.78368 14.0913 8.7375Z" fill="white"/>
</svg>
ГИС в открытом стволе</a>
                        </li>
                        <li class="nav-item test">
                            <a class="nav-link" @click="selectTab(3)" href="#"><svg width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M11.4777 -0.000243187H6.85479V1.96714H9.24485L5.92998 5.49336L3.81053 3.23836C3.63711 3.05387 3.4016 2.94985 3.15637 2.94985C2.91111 2.94985 2.67531 3.05413 2.50213 3.23836L0 5.90165V8.44141L3.15637 5.32617L5.27604 7.58118C5.44916 7.76567 5.68472 7.86968 5.92998 7.86968C6.17546 7.86968 6.41102 7.76567 6.58422 7.58118L10.5532 3.35882V5.90165H12.4023V0.98337C12.4023 0.440311 11.9882 -0.000243187 11.4777 -0.000243187Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M6.85547 15H8.70471V11.0656H6.85547V15Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5547 15H12.4039V8.11467H10.5547V15Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M3.24609 15H5.09528V9.66182H3.24609V15Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M0 14.793H1.84919V9.45478H0V14.793Z" fill="white"/>
</svg>
Инклинометрия</a>
                        </li>
                        <li class="nav-item test">
                            <a class="nav-link" @click="selectTab(4)" href="#"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M0.8329 3.9103H1.37469V6.53418C1.43842 6.53418 1.53404 6.50288 1.59763 6.50288C1.69326 6.50288 1.82078 6.53418 1.91641 6.53418V3.87908H5.03907V3.84774C5.03907 3.12923 5.64466 2.567 6.34559 2.567C7.0785 2.567 7.65205 3.16063 7.65205 3.84774V3.87908H10.9023C10.8386 3.72287 10.9341 2.34845 10.9341 2.31711H0.8329C0.705512 2.31711 0.578125 2.41079 0.578125 2.567V3.66033C0.578125 3.78541 0.67375 3.9103 0.8329 3.9103Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M12.5586 6.84725V15H13.2915V6.94098C13.1004 6.97211 12.9092 6.90979 12.5586 6.84725Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M13.6769 0.193022C13.6131 0.0681458 13.4538 -0.0255923 13.2946 0.00560999L12.7211 0.130672C12.6252 0.161808 12.5297 0.224344 12.4661 0.318084L11.3188 2.28589C11.287 2.31709 11.2552 2.37959 11.2552 2.44212L11.1914 3.69145C11.1914 3.75399 11.1914 3.78539 11.2232 3.84773L12.2111 6.31542C12.2429 6.44029 12.3705 6.50283 12.4979 6.53417L13.1352 6.65907C13.2946 6.69027 13.4857 6.59653 13.5494 6.44032C15.0152 2.66072 13.7406 0.286695 13.6769 0.193022ZM13.0078 0.817808L13.1352 0.786593C13.199 0.974006 13.3264 1.31769 13.3902 1.72365L11.9881 2.56698L13.0078 0.817808ZM12.944 5.87808L12.8485 5.84687L12.1473 4.09769L13.2626 4.84734C13.167 5.19096 13.0714 5.50326 12.944 5.87808ZM13.3902 4.28511L11.9881 3.41036V3.09808L13.4857 2.34844C13.5176 2.87947 13.5176 3.53545 13.3902 4.28511Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M7.33501 3.87938C7.33501 3.34457 6.89269 2.91099 6.34712 2.91099C5.80155 2.91099 5.35938 3.34457 5.35938 3.87938C5.35938 4.414 5.80155 4.84766 6.34712 4.84766C6.89269 4.84766 7.33501 4.414 7.33501 3.87938Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9028 13.5008H8.95899L7.42952 5.12921C7.39776 4.973 7.27017 4.87925 7.11081 4.87925H5.54951C5.39016 4.87925 5.26277 5.00433 5.23074 5.12921L3.98808 13.4694H1.91689V8.78392C1.82127 8.81505 1.72571 8.81505 1.59812 8.81505C1.50256 8.81505 1.4389 8.81505 1.37517 8.78392V13.4694H0.291663C0.132445 13.4694 0.00485353 13.5944 0.00485353 13.7505V14.6564C-0.026909 14.8751 0.100479 15 0.291663 15H10.9028C11.0622 15 11.1896 14.8751 11.1896 14.7189V13.8131C11.1896 13.6256 11.0622 13.5008 10.9028 13.5008ZM5.6769 6.72239L6.0913 7.09721L5.51755 7.69062L5.6769 6.72239ZM7.97131 11.5639L8.25805 13.1883L6.91963 12.2823L7.97131 11.5639ZM6.47367 12.0013L5.10335 11.0954L6.37804 9.90839L7.81189 11.1267L6.47367 12.0013ZM6.72845 9.5649L7.49331 8.84647L7.78012 10.4394L6.72845 9.5649ZM7.2384 7.56576L6.76041 7.12839L7.11081 6.7847L7.2384 7.56576ZM7.33396 8.31533L6.34608 9.25243L5.45396 8.50278L6.44164 7.47204L7.33396 8.31533ZM5.32636 9.00246L5.99568 9.5649L5.13518 10.3769L5.32636 9.00246ZM4.944 11.5953L6.02751 12.3138L4.72098 13.2196L4.944 11.5953ZM6.47367 12.5948L7.84372 13.5008H5.16715L6.47367 12.5948ZM6.8878 5.47282L7.01519 6.12878L6.44164 6.75356L5.77253 6.12878L5.86809 5.47282H6.8878Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M0.738281 7.6596C0.738281 8.1281 1.12065 8.50293 1.59857 8.50293C2.0767 8.50293 2.45907 8.1281 2.45907 7.6596C2.45907 7.1911 2.0767 6.81627 1.59857 6.81627C1.12065 6.81627 0.738281 7.1911 0.738281 7.6596ZM2.0767 7.6596C2.0767 7.90955 1.85355 8.12807 1.59857 8.12807C1.3438 8.12807 1.12065 7.90955 1.12065 7.6596C1.12065 7.40965 1.3438 7.19109 1.59857 7.19109C1.85355 7.19109 2.0767 7.40965 2.0767 7.6596Z" fill="white"/>
</svg>
Конструкция скважины</a>
                        </li>
                    </ul>

                  <div v-if="currentTab == 1">
                      <passport></passport>
                  </div>

                  <div v-if="currentTab == 2">
                      <gis></gis>5
                  </div>

                  <div v-if="currentTab == 3">
                      <incl></incl>
                  </div>

                  <div v-if="currentTab == 4">
                      <construction></construction>
                  </div>

                  

                </div>
      </div>
    </modal>
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import indicator from "./indicator.vue";
import search from "./search.vue";
import passport from './tabs/passport.vue';
import gis from './tabs/gis.vue';
import construction from './tabs/construction.vue';
import incl from './tabs/incl.vue';


export default {
  name: "tkrsMain",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    indicator,
    search,
    passport,
    gis,
    construction,
    incl,


  },
  methods: {
    brigada_modal() {
        this.$modal.show('brigada_modal')
    },
    well_modal() {
        this.$modal.show('add_well')
    },
    selectTab(selectedTab) {
        this.currentTab = selectedTab
    },
    closeModal(modalName) {
      this.$modal.hide(modalName);
    },
  },
  data(){
    return {
      currentTab: 1,
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
  height: calc(100vh - 300px);
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
  font-family: Harmonia Sans Pro Cyr;
  font-style: normal;
  font-weight: bold;
  font-size: 16px;
  line-height: 19px;
  color: white;
  padding-left: 13px;
}
.container-fluid {
  padding-top: 4%;
}
tr:hover {
  background: #454D7D;
}
.test {
  color: #fff;
  background: #333975;
}
.test:hover {
  background: #2E50E9;
}
.nav-link {
  color: white;
  outline: none !important;
}

.tab__content {
  color: white;
}

.nav-link.active {
  color: white;
  background-color: transparent;
  border-color: #dee2e6 #dee2e6 white;
}
.header-well-modal {
  color: white;
  font-size: 16px;
  padding-left: 37%;
  background: #323370;
}
.header-well-modal-down {
  height: 9px;
}
.all-tabs {
  justify-content: center;
  border: solid;
}
.a-link {
  color: #fff;
}
.a-link:hover {
  color: #fff;
}
.calendar-modal {
  padding-bottom: 5px;
}
.machine-name {
  color: white; 
  padding-left: 13px;
}
.tech-nkt {
  text-decoration-line: underline;
  color: #D6D6E2;
  font-family: Harmonia Sans Pro Cyr;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 19px;
  padding-left: 34%;
}
</style>