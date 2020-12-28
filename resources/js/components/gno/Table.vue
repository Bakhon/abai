<template>
  <div class="gno-page-wrapper">
    <div>
      <div class="row gno-page-container">
        <div class="second-column col-lg-3 order-md-2">
          <div class="col-md-12 second-column-container">
            <!-- Выбор скважины start -->
            <div class="tables-string-gno col-12">
              <div class="choosing-well-title col-12">Выбор скважины</div>
              <div class="choosing-well-data  col-7">Месторождение</div>
              <div class="choosing-well-data table-border-gno cell4-gno-second  col-5">
                <select class="select-gno2" v-model="field">
                  <option value="UZN">Узень</option>
                  <option value="KMB">Карамандыбас</option>
                </select>
              </div>
              <div class="choosing-well-data table-border-gno-top  col-7">
                Скважина №
              </div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">
                <input v-model="wellNumber" onfocus="this.value=''" type="text"  @change="getWellNumber(wellNumber)" class="square2" />
              </div>
              <div class="choosing-well-data table-border-gno-top  col-7">
                Новая скважина
                <input :checked="age === true" v-model="age" class="checkbox0" type="checkbox" />
              </div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">
                с ГРП
                <input class="checkbox0" v-model="grp_skin" :disabled="!age" type="checkbox" />
              </div>

              <div class="choosing-well-data table-border-gno-top  col-7">Горизонт</div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">
                {{ horizon }}
              </div>

              <div class="choosing-well-data table-border-gno-top  col-7">
                Способ эксплуатации
              </div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">

                {{ expMeth }}

              </div>

              <div class="choosing-well-data table-border-gno-top  col-7">
                {{ tseh }}
              </div>
              <div class="choosing-well-data table-border-gno-top cell4-gno-second  col-5">
                {{ gu }}
              </div>

              <div class="choosing-well-data col-7">
                {{ ngdu }}
              </div>
              <div class="choosing-well-data cell4-gno-second  col-5">
                АО "ОМГ"
              </div>
            </div>
            <!-- Выбор скважины end -->

            <!-- Конструкция start-->
            <div class="tables-string-gno1-1">
              <div class="construction no-gutter col-12"><b>Конструкция</b></div>
              <div class="construction-data no-gutter col-7">Наружный ØЭК</div>
              <div class="construction-data table-border-gno cell4-gno-second no-gutter col-5">
                {{ casOD }} мм
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                Внутренний ØЭК
              </div>
              <div class="construction-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                {{ casID }} мм
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                Нперф.(ВДП м)
              </div>
              <div class="construction-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                {{ hPerf }} м
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                Удл. на Нперф.
              </div>
              <div class="construction-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                {{ udl }} м
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                Текущий забой
              </div>
              <div class="construction-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                {{ curr }} м
              </div>
            </div>
            <!-- Конструкция end -->

            <!-- Кнопка инклонометрии start -->
            <div class="inclinom-button" @click="InclMenu()">Инклинометрия</div>
            <!-- Кнопка инклонометрии end-->

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'devices' }">
              <input style="width: 845px; height: 45px;" type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'devices'"
                     @change="setActiveRightTabName($event, 'devices')"/>
              <div class="right-side-box">
                <div class="select-well no-gutter col-12">
                  <div class="devices-title"><b>Оборудование</b></div>
                </div>
                <span class="closer">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.8083 6.4147L11.4156 6.80558C11.2917 6.92697 11.1271 6.99486 10.951 6.99486C10.775 6.99486 10.6104 6.92697 10.4864 6.80558L6.003 2.37722L1.51331 6.81073C1.38935 6.93211 1.22477 7 1.04872 7C0.873717 7 0.708088 6.93211 0.585169 6.81073L0.19141 6.4219C-0.0638035 6.16885 -0.0638035 5.75738 0.19141 5.50536L5.53632 0.207788C5.66028 0.0853782 5.82487 0 6.00195 0H6.00404C6.18008 0 6.34467 0.0853782 6.46863 0.207788L11.8083 5.49096C11.9323 5.61234 12 5.78001 12 5.95386C12 6.1277 11.9323 6.29229 11.8083 6.4147Z"
                      fill="#FEFEFE" />
                  </svg>
                </span>
                <span class="open">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.8083 0.585305L11.4156 0.194416C11.2917 0.0730345 11.1271 0.00514328 10.951 0.00514328C10.775 0.00514328 10.6104 0.0730345 10.4864 0.194416L6.003 4.62278L1.51331 0.189273C1.38935 0.0678913 1.22477 0 1.04872 0C0.873717 0 0.708088 0.0678913 0.585169 0.189273L0.19141 0.578104C-0.0638035 0.831154 -0.0638035 1.24262 0.19141 1.49464L5.53632 6.79221C5.66028 6.91462 5.82487 7 6.00195 7H6.00404C6.18008 7 6.34467 6.91462 6.46863 6.79221L11.8083 1.50904C11.9323 1.38766 12 1.21999 12 1.04614C12 0.8723 11.9323 0.707715 11.8083 0.585305Z"
                      fill="#FEFEFE" />
                  </svg>
                </span>

                <div class="right-block-details" v-show="activeRightTabName === 'devices'">
                  <div class="devices-data no-gutter col-7">
                    Станок-качалка
                  </div>
                  <div class="devices-data table-border-gno cell4-gno-second no-gutter col-5">
                    {{ sk }}
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Длина хода
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{strokeLenDev}} м
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Число качаний
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{spmDev}} 1/мин
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Диаметр насоса
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ pumpType }} мм
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">Нсп</div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ hPumpSet }} м
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Наружный ØНКТ
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ tubOD }} мм
                  </div>
                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Внутренний ØНКТ
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ tubID }} мм
                  </div>
                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Дата запуска
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ stopDate }}
                  </div>
                  <div class="prs-button" @click="onPrsButtonClick()">Информация о выполненных ремонтах</div>
                </div>
              </div>
            </div>

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'pvt' }">
              <input style="width: 845px; height: 45px;"
                     type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'pvt'"
                     @change="setActiveRightTabName($event, 'pvt')"/>
              <div class="right-side-box">
                <div class="select-well no-gutter col-12">
                  <div class="pvt-title">PVT</div>
                </div>
                <span class="closer">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.8083 6.4147L11.4156 6.80558C11.2917 6.92697 11.1271 6.99486 10.951 6.99486C10.775 6.99486 10.6104 6.92697 10.4864 6.80558L6.003 2.37722L1.51331 6.81073C1.38935 6.93211 1.22477 7 1.04872 7C0.873717 7 0.708088 6.93211 0.585169 6.81073L0.19141 6.4219C-0.0638035 6.16885 -0.0638035 5.75738 0.19141 5.50536L5.53632 0.207788C5.66028 0.0853782 5.82487 0 6.00195 0H6.00404C6.18008 0 6.34467 0.0853782 6.46863 0.207788L11.8083 5.49096C11.9323 5.61234 12 5.78001 12 5.95386C12 6.1277 11.9323 6.29229 11.8083 6.4147Z"
                      fill="#FEFEFE" />
                  </svg>
                </span>

                <span class="open">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.8083 0.585305L11.4156 0.194416C11.2917 0.0730345 11.1271 0.00514328 10.951 0.00514328C10.775 0.00514328 10.6104 0.0730345 10.4864 0.194416L6.003 4.62278L1.51331 0.189273C1.38935 0.0678913 1.22477 0 1.04872 0C0.873717 0 0.708088 0.0678913 0.585169 0.189273L0.19141 0.578104C-0.0638035 0.831154 -0.0638035 1.24262 0.19141 1.49464L5.53632 6.79221C5.66028 6.91462 5.82487 7 6.00195 7H6.00404C6.18008 7 6.34467 6.91462 6.46863 6.79221L11.8083 1.50904C11.9323 1.38766 12 1.21999 12 1.04614C12 0.8723 11.9323 0.707715 11.8083 0.585305Z"
                      fill="#FEFEFE" />
                  </svg>
                </span>

                <div class="right-block-details" v-show="activeRightTabName === 'pvt'">
                  <div class="pvt-data no-gutter col-7">Рнас</div>
                  <div class="pvt-data table-border-gno cell4-gno-second no-gutter col-5">
                    {{ PBubblePoint }} атм
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">ГФ</div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ gor }} м³/т
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">Т пл</div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ tRes }} ℃
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">
                    Вязкость нефти (пл.усл.)
                  </div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ viscOilRc }} сПз
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">
                    Вязкость воды (пл.усл.)
                  </div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ viscWaterRc }} сПз
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">
                    Плотность нефти
                  </div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ densOil }} г/cм³
                  </div>
                  <div class="pvt-data table-border-gno-top no-gutter col-7">
                    Плотность воды
                  </div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ densWater }} г/cм³
                  </div>
                </div>
              </div>
            </div>

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'technological-mode' || (windowWidth <= 1300 && windowWidth > 991) }">
              <input style="width: 845px; height: 45px;"
                     type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'technological-mode'"
                     @click="setActiveRightTabName($event, 'technological-mode')"/>
              <div class="right-side-box">
                <div class="select-well no-gutter col-12">

                  <div class="technological-mode-title">Технологический режим</div>
                </div>

                <div class="right-block-details"
                  v-show="activeRightTabName === 'technological-mode' || (windowWidth <= 1300 && windowWidth > 991)">
                  <div class="tech-data no-gutter col-7">Qж</div>
                  <div class="tech-data table-border-gno cell4-gno-second no-gutter col-5">
                    {{ qL }} м³/сут
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Qн</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ qO }} т/сут
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Обвод</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ wct }} %
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Рзаб</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ bhp }} атм
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Рпл</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ pRes }} ат
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Ндин</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ hDyn }} м
                  </div>
                  <div class="tech-data table-border-gno-top no-gutter col-7">Рзат</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ pAnnular }} атм
                  </div>
                  <div class="tech-data table-border-gno-top no-gutter col-7">Рбуф</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ whp }} атм
                  </div>
                  <div class="tech-data table-border-gno-top no-gutter col-7">Рлин</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ lineP }} атм
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="no-gutter col-lg-9 order-md-1 first-column container-fluid no-gutter">
          <div class="no-gutter col-md-12 first-column-curve-block">
            <div class="background">
              <modal class="modal-bign-wrapper" name="modalIncl" :width="1150" :height="600"
                style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">Инклинометрия</div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalIncl')">
                      Закрыть
                    </button>
                  </div>

                  <div class="Table" align="center" x:publishsource="Excel">
                    <gno-incl-table :wellNumber="wellNumber" :wellIncl="wellIncl" :is-loading.sync="isLoading">
                    </gno-incl-table>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="modalOldWell" :width="1080" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      Анализ потенциала
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalOldWell')">
                      Закрыть
                    </button>
                  </div>

                  <div class="modal-old-well-content-container">
                    <div class="modal-old-well-plotly-container">
                      <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
                    </div>

                    <div class="modal-analysis-menu">
                      <div class="form-check">
                        <input v-model="analysisBox1" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                          type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Рпл = Рнач</label>
                      </div>
                      <div class="form-check">
                        <input v-model="analysisBox2" class="checkbox-modal-analysnauryzbekis-menu"
                          @change="postAnalysisOld()" type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Н дин = Ндин мин</label>
                      </div>
                      <div class="form-check">
                        <input v-model="analysisBox3" class="checkbox-modal-analysnauryzbekis-menu"
                          @change="postAnalysisOld()" type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Рзаб пот >= 0,75 *
                          Рнас</label>
                      </div>
                      <div class="form-check">
                        <input v-model="analysisBox4" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                          type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Qж = Qж АСМА</label>
                      </div>
                      <div class="form-check">
                        <input v-model="analysisBox5" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                          type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Обв = Обв АСМА</label>
                      </div>
                      <button type="button" class="old_well_button" @click="setGraphOld()">
                        Применить&nbsp;выполненные корректировки
                      </button>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="modalNewWell" :width="1150" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      Анализ потенциала
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalNewWell')">
                      Закрыть
                    </button>
                  </div>

                  <div class="modal-old-well-content-container">
                    <div class="modal-old-well-plotly-container">
                      <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
                    </div>
                    <div class="modal-analysis-menu">
                      <div class="form-check-new">
                        <input v-model="analysisBox6" class="new-checkbox-modal-analysis-menu"
                          @change="postAnalysisNew()" type="checkbox" />
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Pпл = Р изобар</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="analysisBox7" class="new-checkbox-modal-analysis-menu"
                          @change="postAnalysisNew()" type="checkbox" />
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">К пр = К по окр.</label>
                      </div>
                      <div class="form-check-new">
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Обв по окр. =
                        </label>
                        <label for="checkbox1">{{ wctOkr }}%</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="analysisBox8" class="new-checkbox-modal-analysis-menu"
                          @change="postAnalysisNew()" type="checkbox" />
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Рзаб пот = 0.75 *
                          Рнас</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="grp_skin" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()"
                          type="checkbox" />
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">с ГРП</label>
                      </div>
                      <div class="icon-for-table" @click="onOpenTable()">
                        <svg width="31" height="35" viewBox="0 0 31 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.8654 0.56543C7.5741 0.56543 0.851562 7.05353 0.851562 15.0557C0.851562 19.2903 2.73469 23.1007 5.73609 25.7508L4.40373 34.6378L11.9882 29.0583C13.2252 29.3767 14.5247 29.5473 15.8654 29.5473C24.1566 29.5473 30.8807 23.0578 30.8807 15.0557C30.8807 7.05353 24.1566 0.56543 15.8654 0.56543ZM18.9912 23.0236C18.2183 23.3179 17.6029 23.541 17.1415 23.6956C16.6815 23.8503 16.1462 23.9274 15.5377 23.9274C14.6019 23.9274 13.8735 23.7069 13.3551 23.2663C12.8364 22.826 12.5786 22.2678 12.5786 21.5896C12.5786 21.3258 12.5974 21.0558 12.6359 20.7811C12.6751 20.506 12.7373 20.1971 12.8225 19.8499L13.7899 16.5522C13.8747 16.236 13.9487 15.9355 14.0071 15.6557C14.0655 15.3733 14.0937 15.1146 14.0937 14.8792C14.0937 14.4596 14.0033 14.1653 13.8242 13.9997C13.6421 13.8338 13.3005 13.753 12.7908 13.753C12.5416 13.753 12.2849 13.7887 12.0218 13.8633C11.7612 13.9408 11.535 14.0106 11.3495 14.0794L11.6047 13.0635C12.2377 12.8146 12.844 12.601 13.4223 12.4245C14.0006 12.2451 14.5473 12.1571 15.0623 12.1571C15.9913 12.1571 16.7079 12.3754 17.2128 12.8069C17.7149 13.2403 17.968 13.8032 17.968 14.4953C17.968 14.6387 17.9499 14.8915 17.916 15.2521C17.8813 15.6138 17.8163 15.9438 17.7225 16.2469L16.7603 19.5348C16.6815 19.7983 16.6115 20.1003 16.5481 20.4376C16.4855 20.7749 16.4553 21.0325 16.4553 21.2053C16.4553 21.642 16.5557 21.9403 16.7593 22.0986C16.9599 22.2569 17.3119 22.3366 17.8099 22.3366C18.0452 22.3366 18.3085 22.2959 18.6059 22.2176C18.9008 22.139 19.1145 22.0692 19.2491 22.0091L18.9912 23.0236ZM18.8208 9.6788C18.3722 10.0812 17.8318 10.2825 17.1999 10.2825C16.5696 10.2825 16.0256 10.0812 15.5732 9.6788C15.123 9.27673 14.8957 8.78698 14.8957 8.21535C14.8957 7.64517 15.1245 7.1543 15.5732 6.74823C16.0256 6.34106 16.5696 6.13876 17.1999 6.13876C17.8318 6.13876 18.3733 6.34106 18.8208 6.74823C19.2694 7.1543 19.4944 7.64517 19.4944 8.21535C19.4944 8.78843 19.2694 9.27673 18.8208 9.6788Z"
                            fill="#FEFEFE" /></svg>
                      </div>
                      <button type="button" class="old_well_button" @click="setGraphNew()">
                        Применить&nbsp;выполненные корректировки
                      </button>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="" name="modalNearWells" :width="1150" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      Анализ потенциала
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalNearWells')">
                      Закрыть
                    </button>

                  </div>
                  <div class="tablePgno no-gutter">
                    <perfect-scrollbar>
                      <table class="gno-table-with-header pgno" style="height: inherit;">
                        <thead>
                          <tr height="10" style="height: 10pt;">
                            <td>
                              № п/п
                            </td>
                            <td>
                              Номер скважины
                            </td>
                            <td>
                              Расстояние, м
                            </td>
                            <td>
                              Коэффициент влияния
                            </td>
                            <td>
                              Кпрод, (м³/сут)/атм
                            </td>
                            <td>
                              kh
                            </td>
                            <td>
                              Скин-фактор
                            </td>
                            <td>
                              Рпл, атм
                            </td>
                            <td>
                              Рзаб, атм
                            </td>
                            <td>
                              Qж, м³/сут
                            </td>
                            <td>
                              WC, %
                            </td>
                            <td>
                              Qн, т/сут
                            </td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style="font-weight: bold;">
                            <td></td>
                            <td>{{this.wellOkr}}</td>
                            <td></td>
                            <td></td>
                            <td>{{this.piOkr}}</td>
                            <td>{{this.khOkr}}</td>
                            <td>{{this.skinOkr}}</td>
                            <td>{{this.presOkr}}</td>
                            <td></td>
                            <td></td>
                            <td>{{this.wctOkr}}</td>
                            <td></td>

                          </tr>
                          <tr v-for="(row, row_index) in this.nearWells" :key="row_index">
                            <td>{{row.index + 1}}</td>
                            <td>{{row.well}}</td>
                            <td>{{row.dist.toFixed(0)}}</td>
                            <td>{{row.k_v.toFixed(3)}}</td>
                            <td>{{row.pi.toFixed(2)}}</td>
                            <td>{{row.kh.toFixed(1)}}</td>
                            <td>{{row.tp_idn_skin.toFixed(1)}}</td>
                            <td>{{row.p_res.toFixed(0)}}</td>
                            <td>{{row.bhp.toFixed(0)}}</td>
                            <td>{{row.q_l.toFixed(0)}}</td>
                            <td>{{row.wct.toFixed(0)}}</td>
                            <td>{{row.q_o.toFixed(1)}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </perfect-scrollbar>
                  </div>
                </div>
              </modal>

              <modal class="" name="modal-prs" :width="1150" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      Выполненные ремонты
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalNearWells')">
                      Закрыть
                    </button>

                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper chart" name="modalExpAnalysis" :width="1300" :height="550"
                :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      Сравнение технико-экономических показателей за 1 год эксплуатации
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalExpAnalysis')">
                      Закрыть
                    </button>
                  </div>

                  <div>
                    <div class="nno-graph">
                      <gno-chart-bar :data="expAnalysisData"></gno-chart-bar>
                    </div>

                    <div class="nno-modal-button-wrapper">
                      <div class="nno-modal-buttons-container">
                        <div class="nno-icon" @click="onShowTable()">
                          <svg width="31" height="35" viewBox="0 0 31 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M15.131 0.290039C6.83973 0.290039 0.117188 6.77814 0.117188 14.7803C0.117188 19.0149 2.00031 22.8253 5.00172 25.4754L3.66936 34.3624L11.2537 28.7829C12.4906 29.1013 13.7903 29.2719 15.131 29.2719C23.4223 29.2719 30.1463 22.7824 30.1463 14.7803C30.1463 6.77814 23.4223 0.290039 15.131 0.290039ZM18.2567 22.7482C17.4838 23.0426 16.8686 23.2656 16.4071 23.4202C15.9471 23.5749 15.4118 23.6521 14.8033 23.6521C13.8676 23.6521 13.1392 23.4316 12.6208 22.9909C12.102 22.5506 11.8441 21.9925 11.8441 21.3142C11.8441 21.0504 11.863 20.7804 11.9015 20.5057C11.9407 20.2306 12.0029 19.9217 12.0881 19.5746L13.0555 16.2768C13.1403 15.9606 13.2141 15.6601 13.2726 15.3803C13.331 15.0979 13.3593 14.8392 13.3593 14.6038C13.3593 14.1843 13.2689 13.8899 13.0898 13.7244C12.9077 13.5584 12.5661 13.4776 12.0564 13.4776C11.8072 13.4776 11.5504 13.5133 11.2872 13.5879C11.0267 13.6654 10.8006 13.7352 10.6151 13.804L10.8703 12.7881C11.5033 12.5392 12.1096 12.3256 12.6879 12.1491C13.2663 11.9698 13.8129 11.8817 14.3279 11.8817C15.2569 11.8817 15.9736 12.1 16.4784 12.5316C16.9806 12.9649 17.2336 13.5278 17.2336 14.2199C17.2336 14.3633 17.2154 14.6162 17.1814 14.9768C17.1468 15.3385 17.082 15.6685 16.9881 15.9716L16.026 19.2594C15.9472 19.5229 15.8771 19.8249 15.8137 20.1622C15.7512 20.4995 15.721 20.7571 15.721 20.93C15.721 21.3666 15.8212 21.665 16.0248 21.8233C16.2254 21.9816 16.5775 22.0612 17.0756 22.0612C17.3108 22.0612 17.5739 22.0205 17.8714 21.9422C18.1662 21.8636 18.3801 21.7938 18.5147 21.7337L18.2567 22.7482ZM18.0863 9.40345C17.6376 9.80588 17.0974 10.0071 16.4656 10.0071C15.8352 10.0071 15.2912 9.80588 14.8388 9.40345C14.3887 9.00138 14.1612 8.51159 14.1612 7.93996C14.1612 7.36978 14.3902 6.87891 14.8388 6.47284C15.2912 6.06567 15.8352 5.86336 16.4656 5.86336C17.0974 5.86336 17.6388 6.06567 18.0863 6.47284C18.5349 6.87891 18.76 7.36978 18.76 7.93996C18.76 8.51304 18.5349 9.00138 18.0863 9.40345Z"
                              fill="#FEFEFE" />
                          </svg>
                        </div>

                        <button class="button-nno" @click="onCompareNpv()">
                          Выбрать способ эксплуатации с более высоким NPV
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper chart" name="tablePGNO" :width="500" :height="550" :adaptive="true">
                <div class="modal-bign modal-bign-container no-padding">
                  <div class="modal-bign-header with-padding">
                    <div class="modal-bign-title">
                      Информация
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeEconomicModal()">
                      Закрыть
                    </button>
                  </div>

                  <div class="tablePgno no-gutter">
                    <perfect-scrollbar>
                      <table class="gno-table-with-header pgno">
                        <thead>
                          <tr height="60" style="height: 60pt;">
                            <td>
                              Наименование
                            </td>
                            <td>
                              ШГН (покупка)
                            </td>
                            <td>
                              ЭЦН (аренда)
                            </td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Доп. добыча жидкости, тыс.т</td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable1.liquid) }}
                            </td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable2.liquid) }}
                            </td>
                          </tr>
                          <tr>
                            <td>Доп. добыча нефти, тыс.т</td>
                            <td>{{ Math.round(expAnalysisData.npvTable1.oil) }}</td>
                            <td>{{ Math.round(expAnalysisData.npvTable2.oil) }}</td>
                          </tr>
                          <tr>
                            <td>Количество отработанных дней, сут</td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable1.workday) }}
                            </td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable2.workday) }}
                            </td>
                          </tr>
                          <tr>
                            <td>Количество ПРС</td>
                            <td>
                              {{
                              Math.round(expAnalysisData.npvTable1.kolichestvoPrs)
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(expAnalysisData.npvTable2.kolichestvoPrs)
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Среднее продолжительность 1 ПРС, сут</td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable1.sredniiPrs) }}
                            </td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable2.sredniiPrs) }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Распределение по направлениям реализации НДО, тыс.тг
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiNdo / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiNdo / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Определение доходной части, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiDohod / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiDohod / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Расчет НДПИ, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiNdpi / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiNdpi / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Расчет Рентного налога, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiRent / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiRent / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Расчет ЭТП, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiEtp / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiEtp / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Расчет Расходов по транспортировке нефти, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiTrans / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiTrans / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Затраты на электроэнергию, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiZatrElectShgn /
                                1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiZatrElectEcn / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Затраты на подготовку, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiZatrPrep / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiZatrPrep / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Затраты на ПРС, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiZatrPrs / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiZatrPrs / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Затраты за суточное обслуживание, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiZatrSutObs / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiZatrSutObs / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Стоимость аренды оборудования, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiArenda / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiArenda / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Амортизация, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiAmortizacia / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiAmortizacia / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Операционная прибыль, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiOperPryb / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiOperPryb / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>КПН, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiKpn / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiKpn / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Чистая прибыль, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiChistPryb / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiChistPryb / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>КВЛ, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiKvl / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiKvl / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>Свободный денежный поток, тыс.тг</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiSvobPot / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiSvobPot / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>NPV, млн.тг</td>
                            <td>
                              {{
                              Math.round(expAnalysisData.npvTable1.npv / 1000000)
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(expAnalysisData.npvTable2.npv / 1000000)
                            }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </perfect-scrollbar>
                  </div>
                </div>
              </modal>

              <modal name="modalPGNO" :width="1150" :height="400" :adaptive="true">
                <div class="modal-bign3"></div>
              </modal>

              <div class="gno-line-chart" v-if="visibleChart">
                <gno-line-points-chart></gno-line-points-chart>
              </div>

              <div class="gno-shgn-wrapper" v-if="!visibleChart">
                <div class="gno-shgn-block-title">
                  Компоновка ШГН
                </div>

                <div class="podbor-gno">
                  <div class="image-data col-3">
                    <div class="shgn-image-text image-text-1">Экс.колонна {{ this.casID }}мм</div>
                    <div class="shgn-image-text image-text-2">НКТ {{ this.tubOD }}мм</div>
                    <div class="shgn-image-text image-text-3">Штанги {{ this.shgnS1D }}мм 0-{{ this.shgnS1L }}м</div>
                    <div class="shgn-image-text image-text-4">
                      Штанги {{ this.shgnS2D }}мм {{ this.shgnS1L }}-{{
                        this.shgnS1L * 1 + this.shgnS2L * 1
                      }}м
                    </div>
                    <div class="shgn-image-text image-text-5">
                      Штанги {{ this.shgnS1D }}мм
                      {{ this.shgnS1L * 1 + this.shgnS2L * 1 }}-{{
                        this.shgnS1L * 1 + this.shgnS2L * 1 + this.shgnTNL * 1
                      }}м
                    </div>
                    <div class="shgn-image-text image-text-6">Насос {{ this.shgnPumpType }}мм</div>
                    <div class="shgn-image-text image-text-7">
                      Интервал перфорации <br> {{ this.hPerf }}-{{
                        this.hPerf * 1 + this.hPerfND * 1
                      }}м
                    </div>
                    <div class="shgn-image-text image-text-8">Текущий забой {{ this.curr }}м</div>

                    <img class="podborgnoimg"
                         src="./images/shgn.png"
                         alt="podbor-gno"/>
                  </div>

                  <div class="table-pgno-button gno-shgn-table-section col-9">
                    <div class="shgn-tables-wrapper">
                      <div class="table-pgno-one">
                        <table class="table-pgno shgn-table">
                          <thead>
                            <tr class="tr-pgno" height="10" style="height: 30pt;">
                              <td class="td-pgno" rowspan="1" no-gutter colspan="2">
                                Расчетный режим:
                              </td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="td-pgno" rowspan="1">Qж</td>
                              <td class="td-pgno" rowspan="1">
                                {{ qlCelValue }}
                              </td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Qн</td>
                              <td class="td-pgno" rowspan="1">{{ qOil }} т/сут</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Обв</td>
                              <td class="td-pgno" rowspan="1">{{ wctInput }}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Рзаб</td>
                              <td class="td-pgno" rowspan="1">
                                {{ bhpCelValue }}
                              </td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Рпр</td>
                              <td class="td-pgno" rowspan="1">{{ piCelValue }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="table-pgno-two">
                        <table class="table-pgno shgn-table">
                          <thead>
                            <tr class="tr-pgno" height="5px" style="height: 30pt;">
                              <td class="td-pgno" rowspan="1" no-gutter colspan="2">
                                Компоновка:
                              </td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="td-pgno" rowspan="1">Ø насоса</td>
                              <td class="td-pgno" rowspan="1">
                                {{ shgnPumpType }} мм
                              </td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Число качаний</td>
                              <td class="td-pgno" rowspan="1">{{ shgnSPM }} мин-1</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Длина хода</td>
                              <td class="td-pgno" rowspan="1">{{ shgnLen }} м</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Тип СК</td>
                              <td class="td-pgno" rowspan="1">{{ sk }}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Ø НКТ</td>
                              <td class="td-pgno" rowspan="1">{{ shgnTubOD }} мм</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Нсп насоса</td>
                              <td class="td-pgno" rowspan="1">{{ hPumpValue }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="table-pgno-four">
                        <table class="table-pgno shgn-table">
                          <thead>
                            <tr class="tr-pgno" height="5px" style="height: 30pt;">
                              <td class="td-pgno" rowspan="1">
                                Штанги
                              </td>
                              <td class="td-pgno" rowspan="1">
                                Ø, мм
                              </td>

                              <td class="td-pgno" rowspan="1">
                                Длина, м
                              </td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="td-pgno" rowspan="1">Секция 1</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS1D }}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS1L }}</td>
                            </tr>
                            <tr class="tr-pgno">
                              <td class="td-pgno" rowspan="1">Секция 2</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS2D }}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS2L }}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">ТН</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS1D }}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnTNL }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <button class="button-pdf col-12" @click="createPDF()">
                      Создание отчета
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <modal name="table" :width="1150" :height="385" :adaptive="true"></modal>

          <div class="no-gutter col-md-12 first-column-params-block">
            <div class="container-fluid d-sm-block">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row bottom-configuration">
                        <div class="col-6 px-2 curve-settings inflow-configuration-min-width">
                          <div class="bottom-configuration-header">
                            Настройки кривой притока
                          </div>
                          <div class="inflow-configuration">
                            <div class="row pl-3">
                              <div class="col-7">
                                <div class="row">
                                  <div class="col-2 px-0 pt-1 ic-min-block1">
                                    <div class="table-border-gno-right py-1 ml-3">
                                      Pпл
                                    </div>
                                  </div>
                                  <div class="col-5  px-1">
                                    <div class="py-1">
                                      <input v-model="pResInput" @change="postCurveData()" onfocus="this.value=''"
                                        type="text" class="square3" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-2 px-0 pt-2 pb-0">
                                <div class="table-border-gno-right ic-ar pt-1">
                                  Обв.
                                </div>
                              </div>
                              <div class="col-2 pt-1 pl-2 pr-0">
                                <div class="py-1">
                                  <input v-model="wctInput" @change="postCurveData()" type="text"
                                    onfocus="this.value=''" class="square3" />
                                </div>
                              </div>

                            </div>
                            <div class="table-border-gno-top">
                              <div class="row pl-3">
                                <div class="col-7">
                                  <div class="row">
                                    <div class="col-2 px-0 ic-min-block1">
                                      <div class="table-border-gno-right">
                                        <label for="">
                                          <input v-model="curveSelect" class="checkbox-k-prod" value="pi" type="radio"
                                            name="set" @change="postCurveData()" />
                                          Кпрод
                                        </label>

                                      </div>
                                    </div>

                                    <div class="col-5 py-1 px-1">
                                      <input v-model="piInput" :disabled="curveSelect != 'pi'" @change="postCurveData()"
                                        onfocus="this.value=''" type="text" class="square3" />

                                    </div>
                                  </div>
                                </div>
                                <div class="col-2 px-0">
                                  <div class="table-border-gno-right ic-ar pt-1">
                                    ГФ.
                                  </div>
                                </div>
                                <div class="col-2  py-1 pl-2 pr-0">
                                  <input v-model="gorInput" @change="postCurveData()" type="text"
                                    onfocus="this.value=''" class="square3" />
                                </div>

                              </div>

                            </div>
                            <div class="table-border-gno-top">
                              <div class="row ic-bottom-row  pl-3">
                                <div class="col-7">
                                  <div class="row">
                                    <div class="col-2 px-0 ic-min-block1">
                                      <div class="table-border-gno-right">
                                        <label for="">
                                          <input v-model="QhydCurveSelect" class="checkbox-q-liquid" value="hdyn"
                                            type="radio" @change="postCurveData()" name="set" /> Qж</label>
                                      </div>
                                    </div>
                                    <div class="col-5 py-1 px-1">
                                      <input :disabled="curveSelect == 'pi'" v-model="qLInput" @change="postCurveData()"
                                        onfocus="this.value=''" type="text" class="square3" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-5"></div>
                              </div>
                            </div>

                            <div class="table-border-gno-top no-margin row">
                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right gno-curve-radio-cell pt-1 pb-1">
                                  <label for="" class="text-ellipsis">
                                    <input v-model="curveSelect" value="bhp" :disabled="curveSelect == 'pi'"
                                      class="checkbox-k-prod" type="radio" @change="postCurveData()" name="set2" />
                                    Рзаб</label>
                                </div>
                                <div class="col-6 pt-1 pb-1">
                                  <input :disabled="curveSelect != 'bhp'" v-model="bhpInput" @change="postCurveData()"
                                    onfocus="this.value=''" type="text" class="square3" />
                                </div>
                              </div>
                            </div>

                            <div class="table-border-gno-top no-margin row">
                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right gno-curve-radio-cell pt-1 pb-1">
                                  <label for="" class="text-ellipsis">
                                    <input v-model="curveSelect" value="hdyn" :disabled="curveSelect == 'pi'"
                                      class="checkbox-k-prod" type="radio" @change="postCurveData()" name="set2" />
                                    Ндин</label>
                                </div>
                                <div class="col-6 table-border-gno-right table-border-gno-right-second pt-1 pb-1">
                                  <input :disabled="curveSelect != 'hdyn'" v-model="hDynInput" @change="postCurveData()"
                                    type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>

                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right pt-1 pb-1">
                                  <div class="tech-data curve text-ellipsis">
                                    Рзат
                                  </div>
                                </div>
                                <div class="col-6 pt-1 pb-1">
                                  <input :disabled="curveSelect != 'hdyn'" v-model="pAnnularInput"
                                    @change="postCurveData()" type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>
                            </div>

                            <div class="table-border-gno-top no-margin row">
                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right gno-curve-radio-cell pt-1 pb-1">
                                  <label for="" class="text-ellipsis">
                                    <input v-model="curveSelect" value="pmanom" :disabled="curveSelect == 'pi'"
                                      class="checkbox-k-prod" type="radio" @change="postCurveData()" name="set2" />
                                    Рманом</label>
                                </div>
                                <div class="col-6 table-border-gno-right table-border-gno-right-second pt-1 pb-1">
                                  <input :disabled="curveSelect != 'pmanom'" v-model="pManomInput"
                                    @change="postCurveData()" type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>

                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right pt-1 pb-1">
                                  <div class="tech-data curve text-ellipsis">
                                    Нсп маном
                                  </div>
                                </div>
                                <div class="col-6 pt-1 pb-1">
                                  <input :disabled="curveSelect != 'pmanom'" v-model="hPumpManomInput"
                                    @change="postCurveData()" type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>
                            </div>

                            <div class="table-border-gno-top no-margin row">
                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right gno-curve-radio-cell pt-1 pb-1">
                                  <label for="" class="text-ellipsis">
                                    <input v-model="curveSelect" value="whp" :disabled="curveSelect == 'pi'"
                                      class="checkbox-k-prod" type="radio" @change="postCurveData()" name="set2" />
                                    Рбуф(ФЭ)</label>
                                </div>
                                <div class="col-6 pt-1 pb-1">
                                  <input :disabled="curveSelect != 'whp'" v-model="whpInput" @change="postCurveData()"
                                    type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="tables-string-gno5 col-12" @click="PotAnalysisMenu()">
                            Анализ потенциала скважины
                          </div>
                        </div>
                        <div class="col-6 px-2 choice-params">
                          <div class="bottom-configuration-header">
                            Параметры подбора
                          </div>
                          <div class="select-params">
                            <div class="row">
                              <div class="col-11 pt-3 pb-3">ГНО</div>
                            </div>
                            <div class="row pt-2">
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right">
                                  <label class="label-for-celevoi">
                                    <input class="checkbox3" value="ШГН" v-model="expChoose" @change="postCurveData()"
                                      :checked="expChoose === 'ШГН'" type="radio" name="gno10" />ШГН</label>
                                </div>
                              </div>

                              <div class="col-4  pr-0">
                                <div class="table-border-gno-right">
                                  <label class="label-for-celevoi"><input class="checkbox3" value="ЭЦН"
                                      v-model="expChoose" @change="postCurveData()" :checked="expChoose === 'ЭЦН'"
                                      type="radio" name="gno10" />ЭЦН</label>
                                </div>
                              </div>
                              <div class="col-4">
                                <label class="label-for-celevoi pl-3">Нсп</label>
                                <input v-model="hPumpValue" @change="postCurveData()" type="text" onfocus="this.value=''" 
                                  class="square3 podbor" />
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right pt-3">
                                  &nbsp;
                                </div>
                              </div>
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right pt-3">
                                  &nbsp;
                                </div>
                              </div>
                            </div>
                            <div class="table-border-gno-top">
                              <div class="row">
                                <div class="col-4 pr-0">
                                  <div class="table-border-gno-right pt-2 pb-3 podbor-bottom-title-line text-ellipsis">
                                    Целевой параметр
                                  </div>
                                </div>
                                <div class="col-4 pr-0">
                                  <div class="table-border-gno-right  pt-2 pb-3 podbor-bottom-title-line">
                                    &nbsp;
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right pdo-bottom-cell">
                                  <label class="label-for-celevoi">
                                    <input v-model="CelButton" class="checkbox3" value="ql" type="radio"
                                      name="gno11" />Qж</label>
                                  <input v-model="qlCelValue" @change="postCurveData()" :disabled="CelButton != 'ql'"
                                    onfocus="this.value=''" type="text" class="square3 podbor" />
                                </div>
                              </div>
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right pdo-bottom-cell">
                                  <label class="label-for-celevoi"><input v-model="CelButton" class="checkbox3"
                                      value="bhp" type="radio" name="gno11" />Рзаб</label>

                                  <input v-model="bhpCelValue" @change="postCurveData()" :disabled="CelButton != 'bhp'"
                                    type="text" onfocus="this.value=''" class="square3 podbor" />
                                </div>
                              </div>
                              <div class="col-4 pdo-bottom-cell">
                                <label class="label-for-celevoi">
                                  <input v-model="CelButton" class="checkbox3" value="pin" type="radio"
                                    name="gno11" />Pnp
                                </label>
                                <input v-model="piCelValue" @change="postCurveData()" :disabled="CelButton != 'pin'"
                                  type="text" onfocus="this.value=''" class="square3 podbor" />
                              </div>
                            </div>
                          </div>

                          <div class="tables-string-gno55 col-12" @click="ExpAnalysisMenu()">
                            Анализ эффективности способа эксплуатации
                          </div>
                        </div>
                        <div class="col-12 px-2 gno-main-green-button">
                          <div class="tables-string-gno6 col-12" @click="onPgnoClick()">
                            {{ getOnPgnoButtonTitle }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Конец блока -->
        </div>
      </div>

      
      <div style="position: absolute; left: -9999px; height: 0; overflow: hidden;">
        <div class="report" ref="gno-page">
        <div class="title-report col-12">
          <h1>ИС ABAI. Модуль Подбор ГНО.</h1>
        </div>

        <div class="first-report-block row">
          <div class="report-block-title col-5">
            Отчет по подбору ГНО
          </div>
          <div class="report-block-title col-5">
            СКВАЖИНА {{wellNumber}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data col-5">
            Дата формирования: {{new Date().toJSON().slice(0,10).replace(/-/g,'/')}}
          </div>
          <div class="report-block-data col-5">
            Месторождение: {{field}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data col-5">
            Выполнил технолог: КМГИ
          </div>
          <div class="report-block-data col-5">
            Горизонт: {{horizon}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data col-5">

          </div>
          <div class="report-block-data col-5">
            Способ эксплуатации: {{ expMeth }}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-bottom col-5">

          </div>
          <div class="report-block-data-second-bottom col-5">
            Орг.структура: {{ ngdu }}
          </div>
        </div>

        <div class="second-report-block row">
          <div class="second-report-block-title-main col-10" style="border-bottom: 2px solid #8c8caf">
            ДАННЫЕ ДЛЯ РАСЧЕТА
          </div>
        </div>

        <div class="first-report-block row">
          <div class="second-report-block-title col-5">
            Конструкция
          </div>
          <div class="second-report-block-title col-5">
            PVT
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            Наружный Ø ЭК: {{casOD + ' мм'}}
          </div>
          <div class="report-block-data-second-top col-5">
            Рнас: {{PBubblePoint + ' атм'}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            Внутренний Ø ЭК: {{casID}}
          </div>
          <div class="report-block-data-second-top col-5">
            Газовый фактор: {{gorInput}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            Нперф (ВДП): {{hPerf + ' м'}}
          </div>
          <div class="report-block-data-second-top col-5">
            Температура пласта: {{tRes + ' ℃'}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            Удл.на Нперф: {{udl + ' м'}}
          </div>
          <div class="report-block-data-second-top col-5">
            Вязкость нефти (пл.усл.): {{viscOilRc + ' сПз'}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            Текущий забой: {{curr + ' м'}}
          </div>
          <div class="report-block-data-second-top col-5">
            Вязкость воды (пл.усл.): {{viscWaterRc + ' г/cм³'}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">

          </div>
          <div class="report-block-data-second-top col-5">
            Плотность нефти: {{densOil + ' г/cм³'}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-bottom-2 col-5">

          </div>
          <div class="report-block-data-second-bottom-2 col-5">
            Плотность воды: {{densWater + ' г/cм³'}}
          </div>
        </div>

        <div class="second-report-block row">
          <div class="second-report-block-title-main-2 col-10" style="border-bottom: 2px solid #8c8caf">
            Технологический режим:
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            Qж: {{qL + ' м³/сут'}}
          </div>
          <div class="report-block-data-second-top col-5">
            Pзаб: {{bhp + ' атм'}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            Обв: {{wct + ' %'}}
          </div>
          <div class="report-block-data-second-top col-5">
            Qн: {{qO + ' т/сут '}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            Ндин: {{hDyn + ' м'}}
          </div>
          <div class="report-block-data-second-top col-5">
            Рзатр: {{pAnnular + ' атм'}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-third-bottom col-5">
            Гф: {{gor + ' м³/т'}}
          </div>
          <div class="report-block-data-third-bottom col-5">
            Рпл: {{pRes + ' атм'}}
          </div>
        </div>

        <div class="gno-chart-clone col-10">
          <gno-line-points-chart></gno-line-points-chart>
        </div>

        <div class="title-page-2 col-10">
          <h2>РЕЗУЛЬТАТЫ ПОДБОРА ГНО</h2>
        </div>

        <div class="block-results row">
          <div class="col-12">
            <div class="block-results row">
              <div class="image-data-clone col-4">
                <svg width="273" height="395" viewBox="0 0 273 395" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<path fill-rule="evenodd" clip-rule="evenodd" d="M199 36.7561H273C273 36.7561 273 364.499 273 373.999C273 383.5 259 394 236 394C213 394 199 383 199 373.999C199 364.999 199 36.7561 199 36.7561Z" fill="url(#paint0_linear)"/>
<path d="M272.85 374C272.85 379.721 268.763 384.931 262.089 388.719C255.42 392.504 246.196 394.85 236 394.85C225.804 394.85 216.58 392.504 209.911 388.719C203.237 384.931 199.15 379.721 199.15 374C199.15 368.279 203.237 363.069 209.911 359.281C216.58 355.496 225.804 353.15 236 353.15C246.196 353.15 255.42 355.496 262.089 359.281C268.763 363.069 272.85 368.279 272.85 374Z" fill="#913400"/>
<path d="M272.85 374C272.85 379.721 268.763 384.931 262.089 388.719C255.42 392.504 246.196 394.85 236 394.85C225.804 394.85 216.58 392.504 209.911 388.719C203.237 384.931 199.15 379.721 199.15 374C199.15 368.279 203.237 363.069 209.911 359.281C216.58 355.496 225.804 353.15 236 353.15C246.196 353.15 255.42 355.496 262.089 359.281C268.763 363.069 272.85 368.279 272.85 374Z" fill="#782B00"/>
<path d="M272.85 374C272.85 379.721 268.763 384.931 262.089 388.719C255.42 392.504 246.196 394.85 236 394.85C225.804 394.85 216.58 392.504 209.911 388.719C203.237 384.931 199.15 379.721 199.15 374C199.15 368.279 203.237 363.069 209.911 359.281C216.58 355.496 225.804 353.15 236 353.15C246.196 353.15 255.42 355.496 262.089 359.281C268.763 363.069 272.85 368.279 272.85 374Z" stroke="#451900" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M221.999 21.3149H250C250 21.3149 250.027 343.84 250 345.67C249.973 347.5 243.499 352 235.499 352C227.499 352 222 347.5 221.999 345.67C221.997 343.84 221.999 21.3149 221.999 21.3149Z" fill="white" stroke="#2B2B2A" stroke-width="0.3"/>
<path d="M222 346C222 341.25 230.514 339 236 339C241.486 339 250 341.25 250 346" stroke="#333333" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M233.867 20.7568H238.356V258.943H233.867V20.7568Z" fill="url(#paint1_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M229 252L236.5 249.5L243 252C243 252 242.997 291.229 243 291.865C242.975 297.175 229 297.175 229 291.865C229 291.229 229 252 229 252Z" fill="url(#paint2_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M229.5 262.957C229.5 262 232 260 236 260C240 260 242.5 262 242.5 262.957C242.5 263.914 242.5 278.696 242.5 278.696C238.687 280.771 234.109 280.894 230.191 279.025L229.5 278.696C229.5 278.696 229.5 263.914 229.5 262.957Z" fill="url(#paint3_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M229.004 15.5059H243C243 15.5059 243 257 243 256C243 255 241 253 236 253C231 253 229 255 229 256C229 257 229.004 15.5059 229.004 15.5059Z" fill="url(#paint4_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M233 222H239C239 222 239 214.5 239 214C239 213.5 238 212.5 236 212.5C234 212.5 233 213.5 233 214C233 214.5 233 222 233 222Z" fill="url(#paint5_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M234 111H238V214C238 214 237.5 214.66 236 214.66C234.5 214.66 234 214 234 214V111Z" fill="url(#paint6_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M233 214C233 214.5 234 215.5 236 215.5C238 215.5 239 214.5 239 214C239 213.5 239 263 239 263C239 263 238.5 264 236 264C233.5 264 233 263 233 263C233 263 233 213.5 233 214Z" fill="url(#paint7_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M233 21H239V117C239 117 238 118 236 118C234 118 233 117 233 117V21Z" fill="url(#paint8_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M233 214C233 214.5 234 215.5 236 215.5C238 215.5 239 214.5 239 214C239 213.5 239 263.5 239 263.5C239 263.5 238 264.2 236 264.2C234 264.2 233 263.5 233 263.5C233 263.5 233 213.5 233 214Z" fill="url(#paint9_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M229.5 263C229.5 265 233.5 266 236 266C238.5 266 242.5 265 242.5 263C242.5 263 242.5 286.332 242.5 287.166C242.5 288 239.5 290 235.942 290C232.384 290 229.5 288 229.5 287.166C229.5 286.332 229.5 263 229.5 263Z" fill="url(#paint10_linear)" stroke="#2B2B2A" stroke-width="0.3"/>
<path d="M229 256C229 257.5 232 259 236 259C240 259 243 257.5 243 256" stroke="#2B2B2A" stroke-width="0.3"/>
<path d="M215.783 23.9377L219.894 21.3149" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.52 22.364L217.02 21.3364" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.58 22.3642L253.295 21.3367" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.543 23.9377L255.574 21.3149" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 320.849L220.105 318.188" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 318.701L220.105 316.041" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 316.523L220.105 313.863" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 314.375L220.105 311.714" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 312.435L220.105 309.774" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 310.287L220.105 307.627" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 308.11L220.105 305.449" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 305.962L220.105 303.301" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M217.773 321.935L220.104 320.521" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M253.613 321.935L255.944 320.521" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 304.055L220.105 301.395" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 301.908L220.105 299.247" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 299.73L220.105 297.069" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 297.582L220.105 294.922" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 295.641L220.105 292.981" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 293.494L220.105 290.833" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 291.316L220.105 288.655" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 289.168L220.105 286.508" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 287.335L220.105 284.675" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 285.188L220.105 282.527" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 283.01L220.105 280.349" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 280.862L220.105 278.201" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 278.921L220.105 276.261" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 276.773L220.105 274.113" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 274.597L220.105 271.936" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 272.449L220.105 269.788" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 270.683L220.105 268.022" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 268.534L220.105 265.874" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 266.358L220.105 263.697" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 264.21L220.105 261.549" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 262.269L220.105 259.608" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 260.121L220.105 257.461" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 257.943L220.105 255.283" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 255.796L220.105 253.135" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 253.754L220.105 251.094" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 251.607L220.105 248.946" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 249.43L220.105 246.769" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 247.281L220.105 244.621" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 245.341L220.105 242.681" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 243.194L220.105 240.533" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 241.016L220.105 238.355" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 238.868L220.105 236.207" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 237.102L220.105 234.442" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 234.954L220.105 232.294" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 232.777L220.105 230.116" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 230.629L220.105 227.969" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 228.689L220.105 226.028" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 226.541L220.105 223.881" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 224.363L220.105 221.702" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 222.216L220.105 219.555" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 220.146L220.105 217.485" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 217.999L220.105 215.338" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 215.821L220.105 213.16" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 213.673L220.105 211.012" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 211.733L220.105 209.072" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 209.585L220.105 206.924" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 207.407L220.105 204.746" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 205.259L220.105 202.599" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 203.493L220.105 200.832" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 201.346L220.105 198.685" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 199.168L220.105 196.507" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 197.021L220.105 194.36" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 195.08L220.105 192.42" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 192.932L220.105 190.271" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 190.754L220.105 188.094" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 188.607L220.105 185.947" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 186.508L220.105 183.848" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 184.361L220.105 181.7" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 182.183L220.105 179.522" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 180.035L220.105 177.374" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 178.095L220.105 175.435" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 175.948L220.105 173.287" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 173.77L220.105 171.109" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 171.622L220.105 168.961" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 169.552L220.105 166.891" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 167.405L220.105 164.744" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 165.227L220.105 162.566" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 163.079L220.105 160.418" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 161.139L220.105 158.478" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 158.991L220.105 156.33" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 156.813L220.105 154.153" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 154.666L220.105 152.005" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 152.899L220.105 150.239" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 150.752L220.105 148.091" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 148.575L220.105 145.914" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 146.426L220.105 143.766" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 144.486L220.105 141.826" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 142.338L220.105 139.677" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 140.16L220.105 137.5" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 138.013L220.105 135.353" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 136.137L220.105 133.476" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 133.99L220.105 131.329" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 131.811L220.105 129.151" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 129.664L220.105 127.003" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 127.723L220.105 125.063" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 125.576L220.105 122.916" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 123.398L220.105 120.737" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 121.251L220.105 118.59" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 119.181L220.105 116.521" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 117.033L220.105 114.372" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 114.856L220.105 112.195" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 112.707L220.105 110.047" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 110.767L220.105 108.106" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 108.62L220.105 105.959" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 106.441L220.105 103.781" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 104.294L220.105 101.634" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 102.528L220.105 99.7336" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 100.272L220.105 97.4775" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 97.9849L220.105 95.1899" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 95.7288L220.105 92.9338" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 93.6912L220.105 90.8962" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 91.4356L220.105 88.6406" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 89.1475L220.105 86.3525" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 86.8919L220.105 84.0969" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 84.6639L220.105 82.0029" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 82.5159L220.105 79.8557" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 80.3374L220.105 77.6772" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 78.1905L220.105 75.5295" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 76.2498L220.105 73.5889" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 74.1026L220.105 71.4417" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 71.9244L220.105 69.2642" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 69.7769L220.105 67.116" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 67.7073L220.105 65.0464" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 65.5596L220.105 62.8987" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 63.3821L220.105 60.7212" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 61.2344L220.105 58.5735" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 59.2935L220.105 56.6333" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 57.1465L220.105 54.4856" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 54.9686L220.105 52.3076" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 52.8204L220.105 50.1594" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 51.0547L220.105 48.3938" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 48.9068L220.105 46.2466" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 46.7295L220.105 44.0686" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 44.5814L220.105 41.9204" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 42.6412L220.105 39.9802" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 40.4932L220.105 37.833" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 38.3157L220.105 35.6555" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 36.1678L220.105 33.5068" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 34.1276L220.105 31.5049" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 32.0107L220.105 29.3879" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 29.8642L220.105 27.2415" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 27.748L220.105 25.1252" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 25.8354L220.105 23.2134" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 320.849L255.898 318.188" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 318.701L255.898 316.041" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 316.523L255.898 313.863" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 314.375L255.898 311.714" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 312.435L255.898 309.774" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 310.287L255.898 307.627" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 308.11L255.898 305.449" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 305.962L255.898 303.301" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 304.055L255.898 301.395" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 301.908L255.898 299.247" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 299.73L255.898 297.069" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 297.582L255.898 294.922" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 295.641L255.898 292.981" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 293.494L255.898 290.833" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 291.316L255.898 288.655" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 289.168L255.898 286.508" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 287.335L255.898 284.675" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 285.188L255.898 282.527" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 283.01L255.898 280.349" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 280.862L255.898 278.201" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 278.921L255.898 276.261" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 276.773L255.898 274.113" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 274.597L255.898 271.936" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 272.449L255.898 269.788" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 270.683L255.898 268.022" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 268.534L255.898 265.874" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 266.358L255.898 263.697" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 264.21L255.898 261.549" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 262.269L255.898 259.608" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 260.121L255.898 257.461" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 257.943L255.898 255.283" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 255.796L255.898 253.135" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 253.754L255.898 251.094" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 251.607L255.898 248.946" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 249.43L255.898 246.769" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 247.281L255.898 244.621" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 245.341L255.898 242.681" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 243.194L255.898 240.533" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 241.016L255.898 238.355" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 238.868L255.898 236.207" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 237.102L255.898 234.442" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 234.954L255.898 232.294" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 232.777L255.898 230.116" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 230.629L255.898 227.969" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 228.689L255.898 226.028" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 226.541L255.898 223.881" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 224.363L255.898 221.702" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 222.216L255.898 219.555" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 220.146L255.898 217.485" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 217.999L255.898 215.338" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 215.821L255.898 213.16" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 213.673L255.898 211.012" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 211.733L255.898 209.072" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 209.585L255.898 206.924" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 207.407L255.898 204.746" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 205.259L255.898 202.599" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 203.493L255.898 200.832" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 201.346L255.898 198.685" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 199.168L255.898 196.507" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 197.021L255.898 194.36" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 195.08L255.898 192.42" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 192.932L255.898 190.271" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 190.754L255.898 188.094" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 188.607L255.898 185.947" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 186.508L255.898 183.848" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 184.361L255.898 181.7" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 182.183L255.898 179.522" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 180.035L255.898 177.374" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 178.095L255.898 175.435" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 175.948L255.898 173.287" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 173.77L255.898 171.109" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 171.622L255.898 168.961" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 169.552L255.898 166.891" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 167.405L255.898 164.744" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 165.227L255.898 162.566" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 163.079L255.898 160.418" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 161.139L255.898 158.478" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 158.991L255.898 156.33" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 156.813L255.898 154.153" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 154.666L255.898 152.005" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 152.899L255.898 150.239" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 150.752L255.898 148.091" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 148.575L255.898 145.914" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 146.426L255.898 143.766" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 144.486L255.898 141.826" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 142.338L255.898 139.677" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 140.16L255.898 137.5" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 138.013L255.898 135.353" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 136.137L255.898 133.476" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 133.99L255.898 131.329" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 131.811L255.898 129.151" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 129.664L255.898 127.003" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 127.723L255.898 125.063" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 125.576L255.898 122.916" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 123.398L255.898 120.737" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 121.251L255.898 118.59" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 119.181L255.898 116.521" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 117.033L255.898 114.372" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 114.856L255.898 112.195" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 112.707L255.898 110.047" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 110.767L255.898 108.106" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 108.62L255.898 105.959" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 106.441L255.898 103.781" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 104.294L255.898 101.634" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 102.528L255.898 99.8677" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 100.381L255.898 97.72" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 98.2027L255.898 95.5417" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 96.0555L255.898 93.3945" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 94.115L255.898 91.4541" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 91.9668L255.898 89.3059" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 89.7891L255.898 87.1289" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 87.6411L255.898 84.981" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 85.4935L255.898 82.7075" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 83.2443L255.898 80.4575" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 80.9638L255.898 78.177" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 78.714L255.898 75.928" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 76.682L255.898 73.8953" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 74.4325L255.898 71.6465" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 72.1522L255.898 69.3655" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 69.9027L255.898 67.116" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 67.7073L255.898 65.0464" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 65.5596L255.898 62.8987" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 63.3821L255.898 60.7212" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 61.2344L255.898 58.5735" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 59.2935L255.898 56.6333" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 57.1465L255.898 54.4856" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 54.9686L255.898 52.3076" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 52.8204L255.898 50.1594" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 51.0547L255.898 48.3938" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 48.9068L255.898 46.2466" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 46.7295L255.898 44.0686" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 44.5814L255.898 41.9204" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 42.6412L255.898 39.9802" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 40.4932L255.898 37.833" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 38.3157L255.898 35.6555" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 36.1678L255.898 33.5068" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 34.1276L255.898 31.5049" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 32.0107L255.898 29.3879" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 29.8642L255.898 27.2415" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 27.748L255.898 25.1252" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.514 25.8354L255.898 23.2134" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.377 345.5L217.707 344.085" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 349.735L220.105 347.074" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 351.735L220.105 349.074" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M217.5 353.161L221.884 350.5" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M215.721 347.588L220.105 344.927" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.665 349.957L255.747 346.853" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.665 347.81L255.747 344.705" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M251.678 345.847L253.719 344.294" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M219.682 354.291L224.066 351.63" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M221.682 355.291L226.066 352.63" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M223.682 356.291L228.066 353.63" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M245 357L255 349.3" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M249.501 355.5L255.001 351.2" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M252.5 355L255 353" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M226 357.161L230.384 354.5" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M229.048 357.737L233.337 354.924" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M232.151 357.883L236.234 354.778" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M235.151 357.883L239.234 354.778" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M238.178 357.918L242.205 354.743" stroke="#2B2B2A" stroke-width="0.4"/>
<path d="M241.206 357.453L245.178 354.208" stroke="#2B2B2A" stroke-width="0.4"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M215.709 310.134L222.217 309.826V342.405L215.857 342.03L215.709 310.134Z" fill="#B7B7B7"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M250 309.826L256.334 310.134L256.36 342.03L250 342.405V309.826Z" fill="#B7B7B7"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M222.2 338.088V342.354L215.5 341.5L199 338.532V335.866L215.5 337.5L222.2 338.088ZM250 338.088L256.5 337.5L273 335.866V338.532L256.5 341.5L250 342.354V338.088ZM222.2 331.57V335.836L215.5 335L199 331.792V329.125L215.5 331L222.2 331.57ZM250 331.57L256.5 331L273 329.125V331.792L256.5 335L250 335.836V331.57ZM222.2 325.053V329.319L215.5 328.5L199 325.426V322.76L215.5 324.5L222.2 325.053ZM250 325.053L256.5 324.5L273 322.76V325.426L256.5 328.5L250 329.319V325.053ZM222.2 318.299V322.565L215.5 322L199 318.685V316.019L215.5 318L222.2 318.299ZM250 318.299L256.5 318L273 316.019V318.685L256.5 322L250 322.565V318.299ZM250 311.803L256.5 311.5L273 309.654V312.319L256.5 315.5L250 316.068V311.803ZM222.2 311.781V316.047L215.5 315.5L199 312.319V309.654L215.5 311.5L222.2 311.781Z" fill="url(#paint11_linear)"/>
<path d="M220.173 65.2456H114.959" stroke="#237DEB" stroke-width="0.755867"/>
<path d="M230.382 90.7451H64.8281" stroke="#237DEB" stroke-width="0.755867"/>
<path d="M234.169 112.198H107.477" stroke="#237DEB" stroke-width="0.755867"/>
<path d="M234.169 172.386H125.434" stroke="#237DEB" stroke-width="0.755867"/>
<path d="M234.17 231.591H130.672" stroke="#237DEB" stroke-width="0.755867"/>
<path d="M230.384 272.355H139.65" stroke="#237DEB" stroke-width="0.755867"/>
<path d="M207.653 338.165H179.305" stroke="#237DEB" stroke-width="0.755867"/>
<path d="M220.079 368.975H111.967" stroke="#237DEB" stroke-width="0.755867"/>
<path d="M0.990623 63.3453C1.08639 63.9616 1.28018 64.3953 1.57048 64.6447C1.86528 64.8918 2.28577 65.0146 2.83345 65.0146C3.42528 65.0146 3.89216 64.784 4.23409 64.3211C4.57976 63.859 4.75634 63.2172 4.76307 62.3949H1.82188V61.583H4.76307C4.76307 60.7712 4.585 60.1294 4.2296 59.6568C3.87645 59.1842 3.38263 58.9476 2.74591 58.9476C2.23264 58.9476 1.83235 59.0816 1.54504 59.3482C1.26147 59.6156 1.07667 60.047 0.990623 60.6431H0C0.0793097 59.859 0.357642 59.2456 0.836493 58.8038C1.31609 58.3589 1.95207 58.1365 2.74591 58.1365C3.34822 58.1365 3.87645 58.2803 4.33211 58.5679C4.79001 58.8517 5.14092 59.2599 5.38408 59.7901C5.63024 60.3181 5.7537 60.9255 5.7537 61.6138V62.3589C5.7537 63.0472 5.63174 63.6553 5.38932 64.1826C5.14615 64.7098 4.80198 65.1157 4.35755 65.4003C3.91611 65.6812 3.40807 65.8212 2.83345 65.8212C2.01866 65.8212 1.36547 65.607 0.872407 65.1794C0.383829 64.748 0.0927774 64.1361 0 63.3453H0.990623ZM8.77644 63.3505H8.08361V65.7186H7.1289V60.1601H8.08361V62.5132H8.70462L10.5729 60.1601H11.7221L9.5254 62.8315L11.9069 65.7186H10.7008L8.77644 63.3505ZM14.8683 65.0453C15.2073 65.0453 15.5028 64.9427 15.7564 64.7375C16.0093 64.5323 16.15 64.2754 16.1769 63.9669H17.0755C17.0583 64.2852 16.9483 64.5885 16.7471 64.8761C16.5451 65.1637 16.2742 65.3936 15.936 65.5643C15.6008 65.7359 15.2447 65.8212 14.8683 65.8212C14.1119 65.8212 13.5103 65.5696 13.0614 65.0663C12.617 64.5593 12.3948 63.8673 12.3948 62.991V62.8315C12.3948 62.2908 12.4935 61.8092 12.6926 61.3883C12.8908 60.9667 13.1744 60.6394 13.544 60.4065C13.9174 60.1743 14.3566 60.0575 14.8631 60.0575C15.4856 60.0575 16.0026 60.244 16.4134 60.6177C16.8271 60.9906 17.0479 61.4752 17.0755 62.0713H16.1769C16.15 61.7119 16.0131 61.4168 15.7662 61.1876C15.5238 60.9547 15.2222 60.8386 14.8631 60.8386C14.3805 60.8386 14.0064 61.0131 13.7393 61.3621C13.4759 61.7081 13.3442 62.2099 13.3442 62.8675V63.0472C13.3442 63.6875 13.4759 64.1811 13.7393 64.5271C14.0027 64.8731 14.379 65.0453 14.8683 65.0453ZM18.1634 65.2206C18.1634 65.0558 18.2113 64.9188 18.3071 64.8094C18.4058 64.7001 18.5532 64.6447 18.7485 64.6447C18.9431 64.6447 19.0905 64.7001 19.19 64.8094C19.2925 64.9188 19.3433 65.0558 19.3433 65.2206C19.3433 65.3779 19.2925 65.5097 19.19 65.616C19.0905 65.7224 18.9431 65.7755 18.7485 65.7755C18.5532 65.7755 18.4058 65.7224 18.3071 65.616C18.2113 65.5097 18.1634 65.3779 18.1634 65.2206ZM22.6437 63.3505H21.9508V65.7186H20.9961V60.1601H21.9508V62.5132H22.5718L24.4401 60.1601H25.5894L23.3926 62.8315L25.7742 65.7186H24.5681L22.6437 63.3505ZM26.2261 62.8884C26.2261 62.3432 26.3323 61.8542 26.5441 61.419C26.7596 60.9839 27.0573 60.6484 27.4374 60.4117C27.8205 60.1758 28.2567 60.0575 28.746 60.0575C29.5017 60.0575 30.113 60.3196 30.5784 60.8439C31.0468 61.3674 31.281 62.0646 31.281 62.9341V63.0008C31.281 63.5422 31.177 64.0283 30.9682 64.4604C30.7624 64.8881 30.4669 65.2221 30.0801 65.4617C29.697 65.7014 29.2556 65.8212 28.7558 65.8212C28.0031 65.8212 27.3925 65.5591 26.9242 65.0356C26.4588 64.5114 26.2261 63.8178 26.2261 62.9551V62.8884ZM27.1808 63.0008C27.1808 63.6179 27.3222 64.1122 27.6065 64.4859C27.8938 64.8589 28.2769 65.0453 28.7558 65.0453C29.2384 65.0453 29.6214 64.8574 29.9058 64.4806C30.1901 64.1002 30.3315 63.57 30.3315 62.8884C30.3315 62.2788 30.1863 61.7853 29.8953 61.4085C29.608 61.0281 29.2249 60.8386 28.746 60.8386C28.2769 60.8386 27.8991 61.0251 27.6118 61.3981C27.3244 61.7718 27.1808 62.3058 27.1808 63.0008ZM36.9419 60.1601V65.7186H35.9872V60.9465H34.0987L33.9857 63.027C33.9244 63.9826 33.7635 64.6656 33.5031 65.0768C33.2465 65.4872 32.838 65.7014 32.2768 65.7186H31.8967V64.8813L32.1691 64.8611C32.4773 64.8267 32.6973 64.6484 32.8312 64.3264C32.9644 64.0043 33.0497 63.4089 33.0879 62.5387L33.1904 60.1601H36.9419ZM38.2146 62.8884C38.2146 62.3432 38.3208 61.8542 38.5333 61.419C38.7488 60.9839 39.0466 60.6484 39.4259 60.4117C39.809 60.1758 40.2452 60.0575 40.7345 60.0575C41.491 60.0575 42.1015 60.3196 42.5669 60.8439C43.036 61.3674 43.2702 62.0646 43.2702 62.9341V63.0008C43.2702 63.5422 43.1654 64.0283 42.9567 64.4604C42.7517 64.8881 42.4554 65.2221 42.0693 65.4617C41.6862 65.7014 41.2448 65.8212 40.745 65.8212C39.9923 65.8212 39.3818 65.5591 38.9126 65.0356C38.4473 64.5114 38.2146 63.8178 38.2146 62.9551V62.8884ZM39.1693 63.0008C39.1693 63.6179 39.3114 64.1122 39.595 64.4859C39.8831 64.8589 40.2661 65.0453 40.745 65.0453C41.2276 65.0453 41.6107 64.8574 41.8942 64.4806C42.1786 64.1002 42.3207 63.57 42.3207 62.8884C42.3207 62.2788 42.1748 61.7853 41.8845 61.4085C41.5972 61.0281 41.2134 60.8386 40.7345 60.8386C40.2661 60.8386 39.8876 61.0251 39.6002 61.3981C39.3129 61.7718 39.1693 62.3058 39.1693 63.0008ZM48.9977 65.7186H48.0482V63.3453H45.4976V65.7186H44.5429V60.1601H45.4976V62.5694H48.0482V60.1601H48.9977V65.7186ZM52.2569 63.3505H51.564V65.7186H50.6093V60.1601H51.564V62.5132H52.1851L54.0526 60.1601H55.2026L53.0058 62.8315L55.3874 65.7186H54.1813L52.2569 63.3505ZM59.6312 65.7186C59.5766 65.6093 59.5324 65.4138 59.498 65.133C59.0566 65.5921 58.5298 65.8212 57.917 65.8212C57.3701 65.8212 56.9197 65.667 56.5673 65.3591C56.2186 65.0476 56.0443 64.6537 56.0443 64.1773C56.0443 63.5984 56.2628 63.1498 56.7012 62.8315C57.1427 62.5095 57.7614 62.3484 58.559 62.3484H59.483V61.9118C59.483 61.58 59.3835 61.3164 59.1853 61.121C58.9862 60.9225 58.6937 60.8229 58.3076 60.8229C57.9687 60.8229 57.6844 60.9083 57.4554 61.0798C57.2265 61.2513 57.112 61.458 57.112 61.7014H56.1573C56.1573 61.4243 56.2545 61.1569 56.4498 60.9C56.6481 60.6394 56.9152 60.4342 57.2504 60.2837C57.5886 60.1331 57.9604 60.0575 58.3637 60.0575C59.0034 60.0575 59.5047 60.2185 59.8676 60.5405C60.2305 60.8588 60.4183 61.2992 60.4325 61.8609V64.4192C60.4325 64.9293 60.4969 65.3352 60.6271 65.6362V65.7186H59.6312ZM58.0562 64.9944C58.3533 64.9944 58.6361 64.9173 58.9024 64.763C59.1695 64.6087 59.3626 64.4088 59.483 64.1624V63.0217H58.7386C57.5751 63.0217 56.9938 63.3625 56.9938 64.044C56.9938 64.3421 57.0925 64.575 57.2916 64.7428C57.4898 64.9105 57.7442 64.9944 58.0562 64.9944Z" fill="white"/>
<path d="M68.7846 56.079C69.461 56.079 70.0798 56.2325 70.6402 56.5396C70.8152 56.6399 70.9791 56.7515 71.1325 56.8728L71.9967 56.0078L72.5279 56.5396L71.6637 57.4053C71.7692 57.5424 71.8672 57.6884 71.957 57.8419C72.2742 58.4029 72.4329 59.035 72.4329 59.739C72.4329 60.4272 72.2772 61.0518 71.9652 61.6128C71.6585 62.1685 71.2223 62.6051 70.6566 62.9227C70.0962 63.2402 69.4722 63.399 68.7846 63.399C68.1075 63.399 67.4895 63.2425 66.9283 62.9302C66.7592 62.835 66.6006 62.7294 66.4525 62.6126L65.5883 63.4784L65.0488 62.9459L65.9212 62.0809C65.8105 61.9378 65.7102 61.7843 65.6197 61.6203C65.3077 61.0541 65.1521 60.4272 65.1521 59.739C65.1521 59.0455 65.3107 58.4186 65.6279 57.8577C65.9452 57.2915 66.3814 56.8549 66.9365 56.5478C67.497 56.2355 68.1127 56.079 68.7846 56.079ZM68.7764 56.8414C68.2691 56.8414 67.7955 56.9627 67.357 57.2068C66.9231 57.4502 66.5826 57.794 66.3335 58.2389C66.0903 58.683 65.9691 59.1833 65.9691 59.739C65.9691 60.2842 66.0881 60.7792 66.326 61.2234C66.3791 61.3185 66.4368 61.4113 66.5003 61.5012L70.5691 57.4285C70.4636 57.3491 70.3499 57.275 70.2279 57.2068C69.7947 56.9627 69.3106 56.8414 68.7764 56.8414ZM67.3488 62.2636C67.7932 62.5123 68.2691 62.6366 68.7764 62.6366C69.3211 62.6366 69.8104 62.5123 70.2436 62.2636C70.6828 62.0097 71.021 61.66 71.2589 61.2159C71.4969 60.771 71.6158 60.279 71.6158 59.739C71.6158 59.178 71.4916 58.6755 71.2432 58.2306C71.1953 58.146 71.1452 58.0614 71.0928 57.9767L67.0241 62.0494C67.1243 62.1236 67.2328 62.1947 67.3488 62.2636Z" fill="white"/>
<path d="M80.4546 65.7186H79.4998V59.3842L77.5859 60.0882V59.2254L80.3057 58.2031H80.4546V65.7186ZM86.9624 58.2338V59.0404H86.7881C86.0489 59.0539 85.46 59.2733 85.0223 59.698C84.5846 60.1226 84.331 60.7203 84.2629 61.4909C84.6565 61.0386 85.1937 60.8124 85.8746 60.8124C86.5247 60.8124 87.0425 61.0423 87.4293 61.5014C87.8191 61.9598 88.0144 62.5522 88.0144 63.2786C88.0144 64.0493 87.8042 64.6656 87.3829 65.1277C86.9662 65.5906 86.405 65.8212 85.7002 65.8212C84.9849 65.8212 84.4051 65.5471 83.9599 64.9997C83.5155 64.4484 83.2925 63.7392 83.2925 62.8727V62.508C83.2925 61.1314 83.585 60.0799 84.1701 59.3535C84.759 58.624 85.6329 58.2511 86.7933 58.2338H86.9624ZM85.7152 61.604C85.3905 61.604 85.0912 61.7014 84.8173 61.8968C84.5435 62.0916 84.3535 62.3365 84.2472 62.6315V62.9805C84.2472 63.5969 84.3864 64.0935 84.6632 64.4702C84.94 64.8469 85.2857 65.0356 85.7002 65.0356C86.1274 65.0356 86.4626 64.8776 86.7058 64.563C86.952 64.2477 87.0754 63.8351 87.0754 63.3251C87.0754 62.8113 86.9505 62.3964 86.7006 62.0818C86.4544 61.7628 86.126 61.604 85.7152 61.604ZM93.6701 60.1908C93.6701 60.5645 93.5713 60.8963 93.3723 61.1876C93.1778 61.4789 92.9122 61.7066 92.577 61.8706C92.9668 62.0384 93.2751 62.2833 93.501 62.6053C93.73 62.9274 93.8444 63.2921 93.8444 63.6995C93.8444 64.3473 93.626 64.8626 93.1875 65.2461C92.7536 65.6295 92.1804 65.8212 91.4681 65.8212C90.7499 65.8212 90.1737 65.6295 89.739 65.2461C89.3081 64.8589 89.0926 64.3436 89.0926 63.6995C89.0926 63.2958 89.2018 62.9311 89.421 62.6053C89.6433 62.2803 89.9493 62.0339 90.3391 61.8661C90.0076 61.7014 89.7458 61.4737 89.5542 61.1824C89.3627 60.8918 89.2669 60.5608 89.2669 60.1908C89.2669 59.5609 89.4689 59.0607 89.8722 58.6907C90.2762 58.3215 90.8082 58.1365 91.4681 58.1365C92.1251 58.1365 92.6555 58.3215 93.0596 58.6907C93.4666 59.0607 93.6701 59.5609 93.6701 60.1908ZM92.895 63.6793C92.895 63.2614 92.7618 62.9206 92.4947 62.657C92.2313 62.3934 91.8856 62.2616 91.4584 62.2616C91.0304 62.2616 90.687 62.3911 90.4266 62.6518C90.17 62.9124 90.0421 63.2547 90.0421 63.6793C90.0421 64.1039 90.1663 64.438 90.4162 64.6806C90.6698 64.924 91.02 65.0453 91.4681 65.0453C91.9133 65.0453 92.262 64.924 92.5156 64.6806C92.7685 64.4342 92.895 64.1002 92.895 63.6793ZM91.4681 58.9169C91.0955 58.9169 90.7925 59.0337 90.5598 59.2666C90.3309 59.4958 90.2164 59.8096 90.2164 60.2065C90.2164 60.587 90.3294 60.8948 90.5553 61.1314C90.7843 61.3644 91.0888 61.4804 91.4681 61.4804C91.8482 61.4804 92.1512 61.3644 92.3772 61.1314C92.6062 60.8948 92.7206 60.587 92.7206 60.2065C92.7206 59.8261 92.6024 59.5167 92.3667 59.2763C92.1303 59.0367 91.831 58.9169 91.4681 58.9169ZM100.943 64.4604L102.831 60.1601H104.017V65.7186H103.068V61.6759L101.271 65.7186H100.614L98.7818 61.5883V65.7186H97.8324V60.1601H99.0639L100.943 64.4604ZM108.743 64.4604L110.632 60.1601H111.818V65.7186H110.868V61.6759L109.072 65.7186H108.415L106.583 61.5883V65.7186H105.633V60.1601H106.865L108.743 64.4604Z" fill="white"/>
<path d="M5.74322 91.1824H4.7526V87.7254H0.985386V91.1824H0V83.7029H0.985386V86.9188H4.7526V83.7029H5.74322V91.1824ZM9.43262 87.8227H8.5243V91.1824H7.53891V83.7029H8.5243V87.0012H9.2942L11.9069 83.7029H13.1332L10.2796 87.3299L13.3435 91.1824H12.1374L9.43262 87.8227ZM19.4099 84.5147H17.0082V91.1824H16.028V84.5147H13.6308V83.7029H19.4099V84.5147Z" fill="white"/>
<path d="M25.0944 81.5423C25.7715 81.5423 26.3903 81.6959 26.9507 82.0029C27.125 82.1033 27.2889 82.2149 27.4423 82.3362L28.3072 81.4712L28.8384 82.0029L27.9735 82.8679C28.0798 83.0057 28.177 83.151 28.2675 83.3046C28.5848 83.8655 28.7434 84.4984 28.7434 85.2024C28.7434 85.8906 28.587 86.5145 28.275 87.0754C27.9683 87.6319 27.5321 88.0685 26.9664 88.386C26.406 88.7036 25.782 88.8624 25.0944 88.8624C24.418 88.8624 23.7993 88.7058 23.2389 88.3935C23.0698 88.2984 22.9112 88.1928 22.763 88.076L21.8988 88.9418L21.3594 88.4093L22.2318 87.5443C22.1203 87.4012 22.02 87.2477 21.9303 87.0837C21.6183 86.5175 21.4619 85.8906 21.4619 85.2024C21.4619 84.5088 21.6205 83.882 21.9385 83.321C22.2557 82.7541 22.6919 82.3175 23.2471 82.0112C23.8075 81.6989 24.4233 81.5423 25.0944 81.5423ZM25.0869 82.3047C24.5789 82.3047 24.106 82.4261 23.6668 82.6695C23.2336 82.9129 22.8924 83.2574 22.644 83.7015C22.4009 84.1464 22.2789 84.6466 22.2789 85.2024C22.2789 85.7476 22.3979 86.2419 22.6358 86.6867C22.6889 86.7818 22.7473 86.8747 22.8109 86.9646L26.8789 82.8919C26.7734 82.8125 26.6597 82.7384 26.5385 82.6695C26.1045 82.4261 25.6211 82.3047 25.0869 82.3047ZM23.6594 87.727C24.103 87.9756 24.5789 88.1 25.0869 88.1C25.6316 88.1 26.1202 87.9756 26.5542 87.727C26.9926 87.4731 27.3315 87.1234 27.5695 86.6785C27.8074 86.2344 27.9264 85.7423 27.9264 85.2024C27.9264 84.6414 27.8022 84.1381 27.553 83.694C27.5059 83.6094 27.4557 83.5248 27.4026 83.4401L23.3339 87.5128C23.4341 87.5862 23.5426 87.6581 23.6594 87.727Z" fill="white"/>
<path d="M38.273 84.2369L35.1785 91.1825H34.1826L37.2667 84.4833H33.2227V83.7029H38.273V84.2369ZM40.7309 86.9803H41.4447C41.8929 86.9735 42.2453 86.8552 42.5019 86.626C42.7585 86.3961 42.8865 86.0868 42.8865 85.6958C42.8865 84.8196 42.4503 84.3807 41.5779 84.3807C41.1671 84.3807 40.8386 84.4991 40.5925 84.7357C40.3501 84.9679 40.2281 85.2779 40.2281 85.6651H39.2786C39.2786 85.0727 39.4941 84.5814 39.9258 84.1905C40.3598 83.7973 40.9112 83.6003 41.5779 83.6003C42.2827 83.6003 42.8356 83.7868 43.2359 84.1598C43.6362 84.5335 43.8359 85.0525 43.8359 85.7168C43.8359 86.0418 43.7304 86.3571 43.518 86.662C43.3092 86.9668 43.0234 87.1945 42.6613 87.345C43.0713 87.4753 43.3878 87.691 43.6107 87.9921C43.8359 88.2939 43.9489 88.6616 43.9489 89.0967C43.9489 89.7678 43.7304 90.301 43.292 90.6942C42.8543 91.0881 42.2849 91.2851 41.5831 91.2851C40.882 91.2851 40.3104 91.0949 39.869 90.7152C39.4313 90.3347 39.212 89.8329 39.212 89.2098H40.1667C40.1667 89.6038 40.2947 89.9191 40.5513 90.155C40.808 90.3916 41.1521 90.5092 41.5831 90.5092C42.0417 90.5092 42.3927 90.3894 42.6351 90.1497C42.8782 89.9101 42.9995 89.5663 42.9995 89.1177C42.9995 88.6826 42.8663 88.3485 42.5992 88.1156C42.3328 87.8827 41.9475 87.7629 41.4447 87.7561H40.7309V86.9803ZM51.1549 89.9235L53.0434 85.6239H54.2293V91.1825H53.2798V87.1398L51.4833 91.1825H50.8264L48.9941 87.0522V91.1825H48.0446V85.6239H49.2761L51.1549 89.9235ZM58.9557 89.9235L60.8441 85.6239H62.03V91.1825H61.0806V87.1398L59.2841 91.1825H58.6272L56.7949 87.0522V91.1825H55.8454V85.6239H57.0777L58.9557 89.9235Z" fill="white"/>
<path d="M0.990623 105.54V112.213H3.5622V105.54H4.54235V112.213H7.09822V105.54H8.08361V113.019H0V105.54H0.990623ZM13.8366 108.232H11.9735V113.019H11.0241V108.232H9.19693V107.461H13.8366V108.232ZM18.1066 113.019C18.0519 112.909 18.0078 112.715 17.9734 112.434C17.5319 112.893 17.0052 113.122 16.3924 113.122C15.8447 113.122 15.3951 112.968 15.0427 112.66C14.694 112.348 14.5189 111.954 14.5189 111.478C14.5189 110.899 14.7381 110.451 15.1758 110.132C15.6173 109.81 16.2368 109.649 17.0344 109.649H17.9577V109.213C17.9577 108.88 17.8589 108.616 17.6599 108.422C17.4616 108.223 17.1691 108.124 16.7822 108.124C16.444 108.124 16.1597 108.209 15.9308 108.381C15.7011 108.551 15.5866 108.759 15.5866 109.002H14.6319C14.6319 108.724 14.7299 108.458 14.9244 108.201C15.1235 107.94 15.3898 107.735 15.725 107.584C16.064 107.433 16.4351 107.358 16.8391 107.358C17.4788 107.358 17.9801 107.519 18.343 107.841C18.7051 108.16 18.8937 108.599 18.9071 109.161V111.719C18.9071 112.23 18.9722 112.636 19.1024 112.937V113.019H18.1066ZM16.5308 112.295C16.8286 112.295 17.1107 112.218 17.3778 112.064C17.6449 111.91 17.838 111.71 17.9577 111.462V110.323H17.214C16.0505 110.323 15.4684 110.663 15.4684 111.345C15.4684 111.642 15.5679 111.875 15.7662 112.044C15.9652 112.211 16.2196 112.295 16.5308 112.295ZM24.9324 113.019H23.983V110.646H21.4323V113.019H20.4776V107.461H21.4323V109.87H23.983V107.461H24.9324V113.019ZM30.0494 108.247H27.4883V113.019H26.5336V107.461H30.0494V108.247ZM34.4683 107.461H35.4178V113.019H34.4683V108.966L31.9072 113.019H30.9577V107.461H31.9072V111.519L34.4683 107.461ZM44.3476 113.019H39.4514V112.336L42.0379 109.459C42.4217 109.024 42.6851 108.671 42.8287 108.401C42.9754 108.127 43.0495 107.844 43.0495 107.553C43.0495 107.163 42.9313 106.843 42.6948 106.593C42.4591 106.343 42.1441 106.218 41.7506 106.218C41.2785 106.218 40.9111 106.353 40.6477 106.624C40.3874 106.891 40.2572 107.264 40.2572 107.743H39.3077C39.3077 107.055 39.5284 106.499 39.9699 106.074C40.415 105.649 41.0084 105.437 41.7506 105.437C42.4457 105.437 42.9948 105.62 43.3981 105.986C43.8022 106.349 44.0042 106.834 44.0042 107.441C44.0042 108.177 43.5351 109.053 42.5975 110.071L40.5961 112.244H44.3476V113.019ZM50.2494 113.019H45.3539V112.336L47.9405 109.459C48.3236 109.024 48.5869 108.671 48.7306 108.401C48.878 108.127 48.9513 107.844 48.9513 107.553C48.9513 107.163 48.8331 106.843 48.5974 106.593C48.361 106.343 48.046 106.218 47.6532 106.218C47.1811 106.218 46.8129 106.353 46.5496 106.624C46.2892 106.891 46.1598 107.264 46.1598 107.743H45.2103C45.2103 107.055 45.4303 106.499 45.8717 106.074C46.3169 105.649 46.9102 105.437 47.6532 105.437C48.3475 105.437 48.8967 105.62 49.3 105.986C49.704 106.349 49.906 106.834 49.906 107.441C49.906 108.177 49.4369 109.053 48.4994 110.071L46.4979 112.244H50.2494V113.019ZM57.1576 111.76L59.0461 107.461H60.232V113.019H59.2825V108.976L57.4861 113.019H56.8292L54.9968 108.889V113.019H54.0473V107.461H55.2796L57.1576 111.76ZM64.9584 111.76L66.8476 107.461H68.0328V113.019H67.0833V108.976L65.2869 113.019H64.6299L62.7983 108.889V113.019H61.8489V107.461H63.0804L64.9584 111.76ZM76.7576 109.829C76.7576 110.942 76.5676 111.769 76.1882 112.31C75.8081 112.852 75.2148 113.122 74.4067 113.122C73.6099 113.122 73.0196 112.858 72.6365 112.331C72.2534 111.8 72.0551 111.009 72.0409 109.958V108.688C72.0409 107.589 72.231 106.773 72.611 106.238C72.9904 105.704 73.586 105.437 74.397 105.437C75.2006 105.437 75.7932 105.696 76.1725 106.212C76.5526 106.726 76.7471 107.521 76.7576 108.596V109.829ZM75.8081 108.53C75.8081 107.725 75.6951 107.139 75.4692 106.773C75.244 106.403 74.8863 106.218 74.397 106.218C73.9107 106.218 73.5568 106.401 73.3346 106.767C73.1123 107.134 72.9971 107.697 72.9904 108.458V109.978C72.9904 110.786 73.1071 111.384 73.3398 111.771C73.5755 112.154 73.9316 112.346 74.4067 112.346C74.8759 112.346 75.223 112.165 75.449 111.802C75.6779 111.438 75.7977 110.867 75.8081 110.086V108.53ZM80.0475 110.23H77.5432V109.454H80.0475V110.23ZM81.3149 109.269L81.695 105.54H85.5236V106.418H82.5008L82.2749 108.458C82.6407 108.242 83.0567 108.134 83.5221 108.134C84.203 108.134 84.7432 108.36 85.1435 108.812C85.5438 109.261 85.7443 109.869 85.7443 110.636C85.7443 111.406 85.5355 112.014 85.118 112.459C84.7043 112.901 84.1244 113.122 83.3785 113.122C82.7178 113.122 82.1791 112.939 81.7616 112.572C81.3441 112.206 81.1062 111.699 81.0486 111.052H81.9464C82.0048 111.48 82.1566 111.803 82.4028 112.023C82.6497 112.238 82.9744 112.346 83.3785 112.346C83.8199 112.346 84.1648 112.196 84.4147 111.895C84.6684 111.593 84.7948 111.177 84.7948 110.646C84.7948 110.146 84.6579 109.745 84.384 109.444C84.1139 109.139 83.7526 108.986 83.3014 108.986C82.8869 108.986 82.5622 109.077 82.3265 109.259L82.0743 109.464L81.3149 109.269ZM88.1617 108.817H88.8748C89.323 108.81 89.6754 108.692 89.932 108.463C90.1886 108.233 90.3173 107.923 90.3173 107.533C90.3173 106.656 89.8811 106.218 89.008 106.218C88.5979 106.218 88.2695 106.336 88.0226 106.572C87.7802 106.805 87.6582 107.115 87.6582 107.502H86.7087C86.7087 106.91 86.9249 106.418 87.3559 106.027C87.7899 105.633 88.3413 105.437 89.008 105.437C89.7128 105.437 90.2657 105.624 90.666 105.997C91.0663 106.37 91.2668 106.889 91.2668 107.553C91.2668 107.879 91.1605 108.194 90.9481 108.499C90.7393 108.804 90.4535 109.031 90.0914 109.182C90.5014 109.312 90.8179 109.528 91.0408 109.829C91.2668 110.131 91.379 110.499 91.379 110.934C91.379 111.605 91.1605 112.137 90.7221 112.531C90.2844 112.925 89.715 113.122 89.0132 113.122C88.3121 113.122 87.7405 112.932 87.2991 112.552C86.8614 112.172 86.6421 111.67 86.6421 111.047H87.5968C87.5968 111.441 87.7255 111.755 87.9822 111.992C88.2388 112.228 88.5822 112.346 89.0132 112.346C89.4718 112.346 89.8228 112.226 90.0652 111.987C90.3083 111.747 90.4295 111.402 90.4295 110.954C90.4295 110.52 90.2964 110.185 90.0293 109.953C89.7629 109.72 89.3776 109.6 88.8748 109.593H88.1617V108.817ZM97.3684 109.829C97.3684 110.942 97.1791 111.769 96.799 112.31C96.4189 112.852 95.8256 113.122 95.0183 113.122C94.2207 113.122 93.6304 112.858 93.2473 112.331C92.8642 111.8 92.6659 111.009 92.6525 109.958V108.688C92.6525 107.589 92.8418 106.773 93.2218 106.238C93.6019 105.704 94.1968 105.437 95.0078 105.437C95.8121 105.437 96.404 105.696 96.7833 106.212C97.1634 106.726 97.3587 107.521 97.3684 108.596V109.829ZM96.4189 108.53C96.4189 107.725 96.3059 107.139 96.0807 106.773C95.8548 106.403 95.4971 106.218 95.0078 106.218C94.5222 106.218 94.1676 106.401 93.9454 106.767C93.7231 107.134 93.6087 107.697 93.6019 108.458V109.978C93.6019 110.786 93.7179 111.384 93.9506 111.771C94.187 112.154 94.5424 112.346 95.0183 112.346C95.4867 112.346 95.8338 112.165 96.0598 111.802C96.2895 111.438 96.4092 110.867 96.4189 110.086V108.53ZM101.88 111.76L103.769 107.461H104.954V113.019H104.005V108.976L102.209 113.019H101.552L99.7193 108.889V113.019H98.7698V107.461H100.001L101.88 111.76Z" fill="white"/>
<path d="M0.990623 165.675V172.349H3.5622V165.675H4.54235V172.349H7.09822V165.675H8.08361V173.156H0V165.675H0.990623ZM13.8366 168.368H11.9735V173.156H11.0241V168.368H9.19694V167.597H13.8366V168.368ZM18.1066 173.156C18.0519 173.046 18.0078 172.851 17.9734 172.57C17.5319 173.029 17.0052 173.258 16.3924 173.258C15.8455 173.258 15.3951 173.104 15.0427 172.796C14.694 172.484 14.5197 172.091 14.5197 171.614C14.5197 171.035 14.7381 170.587 15.1766 170.269C15.618 169.946 16.2368 169.785 17.0344 169.785H17.9577V169.349C17.9577 169.016 17.8589 168.753 17.6606 168.558C17.4616 168.359 17.1691 168.26 16.783 168.26C16.444 168.26 16.1597 168.345 15.9308 168.517C15.7018 168.688 15.5866 168.895 15.5866 169.138H14.6326C14.6326 168.861 14.7299 168.594 14.9252 168.337C15.1235 168.076 15.3898 167.871 15.7258 167.721C16.064 167.569 16.4351 167.495 16.8391 167.495C17.4788 167.495 17.9801 167.656 18.343 167.977C18.7059 168.296 18.8937 168.735 18.9071 169.297V171.856C18.9071 172.366 18.9722 172.772 19.1024 173.073V173.156H18.1066ZM16.5316 172.431C16.8286 172.431 17.1114 172.354 17.3778 172.2C17.6449 172.046 17.838 171.846 17.9577 171.599V170.459H17.214C16.0505 170.459 15.4691 170.8 15.4691 171.481C15.4691 171.778 15.5679 172.011 15.7662 172.179C15.9652 172.348 16.2196 172.431 16.5316 172.431ZM24.9324 173.156H23.983V170.782H21.4323V173.156H20.4776V167.597H21.4323V170.006H23.983V167.597H24.9324V173.156ZM30.0494 168.383H27.4883V173.156H26.5336V167.597H30.0494V168.383ZM34.4683 167.597H35.4178V173.156H34.4683V169.102L31.9072 173.156H30.9577V167.597H31.9072V171.656L34.4683 167.597ZM42.5721 173.156H41.6174V166.821L39.7035 167.525V166.662L42.4232 165.639H42.5721V173.156ZM48.9925 169.868C48.7942 170.104 48.5563 170.294 48.2794 170.438C48.0056 170.582 47.7041 170.653 47.3756 170.653C46.9446 170.653 46.5683 170.547 46.2466 170.335C45.9286 170.122 45.6824 169.825 45.5081 169.441C45.333 169.055 45.2462 168.628 45.2462 168.162C45.2462 167.662 45.3397 167.211 45.5283 166.811C45.7198 166.41 45.9899 166.104 46.3393 165.892C46.688 165.679 47.095 165.573 47.5604 165.573C48.2996 165.573 48.881 165.851 49.3052 166.406C49.7332 166.957 49.9472 167.71 49.9472 168.666V168.943C49.9472 170.399 49.6599 171.462 49.0852 172.133C48.5099 172.801 47.6427 173.144 46.483 173.161H46.2982V172.36H46.4979C47.2821 172.345 47.8836 172.142 48.3049 171.748C48.7254 171.351 48.9551 170.724 48.9925 169.868ZM47.5297 169.868C47.8477 169.868 48.1403 169.77 48.4074 169.575C48.6775 169.38 48.8742 169.138 48.9977 168.851V168.47C48.9977 167.847 48.8623 167.34 48.5922 166.95C48.3221 166.559 47.9794 166.364 47.5656 166.364C47.1481 166.364 46.8129 166.525 46.5601 166.847C46.3064 167.166 46.18 167.587 46.18 168.111C46.18 168.621 46.3012 169.043 46.5443 169.374C46.7905 169.703 47.119 169.868 47.5297 169.868ZM57.1576 171.897L59.0468 167.597H60.232V173.156H59.2825V169.112L57.4861 173.156H56.8292L54.9976 169.025V173.156H54.0481V167.597H55.2796L57.1576 171.897ZM64.9592 171.897L66.8476 167.597H68.0328V173.156H67.0833V169.112L65.2876 173.156H64.6307L62.7983 169.025V173.156H61.8489V167.597H63.0804L64.9592 171.897ZM72.5086 169.405L72.8879 165.675H76.7164V166.554H73.6937L73.4678 168.594C73.8344 168.378 74.2496 168.27 74.715 168.27C75.3959 168.27 75.9368 168.496 76.3371 168.948C76.7374 169.397 76.9372 170.005 76.9372 170.772C76.9372 171.542 76.7284 172.151 76.3117 172.595C75.8972 173.037 75.3173 173.258 74.5714 173.258C73.9114 173.258 73.372 173.075 72.9545 172.709C72.5377 172.342 72.2998 171.835 72.2414 171.188H73.1393C73.1976 171.616 73.3503 171.939 73.5964 172.159C73.8426 172.375 74.1681 172.482 74.5714 172.482C75.0128 172.482 75.3585 172.332 75.6084 172.031C75.8613 171.729 75.9877 171.313 75.9877 170.782C75.9877 170.282 75.8508 169.881 75.5777 169.58C75.3068 169.275 74.9462 169.123 74.4943 169.123C74.0805 169.123 73.7558 169.213 73.5194 169.395L73.268 169.6L72.5086 169.405ZM79.3546 168.953H80.0684C80.5166 168.947 80.869 168.828 81.1256 168.598C81.3823 168.369 81.5102 168.059 81.5102 167.669C81.5102 166.792 81.074 166.354 80.2016 166.354C79.7908 166.354 79.4624 166.472 79.2162 166.708C78.973 166.941 78.8518 167.251 78.8518 167.638H77.9024C77.9024 167.046 78.1178 166.554 78.5488 166.164C78.9835 165.77 79.5342 165.573 80.2016 165.573C80.9064 165.573 81.4586 165.76 81.8596 166.133C82.2599 166.506 82.4597 167.025 82.4597 167.689C82.4597 168.015 82.3534 168.33 82.1417 168.634C81.9329 168.939 81.6471 169.168 81.2842 169.318C81.695 169.448 82.0115 169.664 82.2337 169.965C82.4597 170.266 82.5727 170.635 82.5727 171.07C82.5727 171.741 82.3534 172.273 81.9157 172.667C81.478 173.061 80.9079 173.258 80.2068 173.258C79.505 173.258 78.9341 173.068 78.4927 172.688C78.0542 172.308 77.8358 171.806 77.8358 171.183H78.7905C78.7905 171.577 78.9184 171.891 79.1751 172.128C79.4317 172.364 79.7759 172.482 80.2068 172.482C80.6655 172.482 81.0156 172.363 81.2588 172.123C81.502 171.883 81.6232 171.539 81.6232 171.09C81.6232 170.655 81.49 170.322 81.2229 170.089C80.9558 169.856 80.5712 169.736 80.0684 169.729H79.3546V168.953ZM88.562 169.965C88.562 171.078 88.372 171.906 87.9919 172.446C87.6126 172.988 87.0185 173.258 86.2112 173.258C85.4143 173.258 84.824 172.995 84.4409 172.467C84.0578 171.936 83.8588 171.145 83.8453 170.094V168.825C83.8453 167.725 84.0354 166.909 84.4147 166.374C84.7948 165.84 85.3904 165.573 86.2014 165.573C87.005 165.573 87.5968 165.832 87.9769 166.349C88.3563 166.862 88.5516 167.657 88.562 168.732V169.965ZM87.6126 168.666C87.6126 167.861 87.4996 167.275 87.2736 166.909C87.0477 166.539 86.69 166.354 86.2014 166.354C85.7151 166.354 85.3612 166.537 85.139 166.904C84.916 167.27 84.8016 167.833 84.7948 168.594V170.114C84.7948 170.922 84.9115 171.52 85.1442 171.907C85.3799 172.291 85.7361 172.482 86.2112 172.482C86.6803 172.482 87.0275 172.301 87.2534 171.938C87.4824 171.575 87.6021 171.003 87.6126 170.222V168.666ZM91.8519 170.366H89.3469V169.59H91.8519V170.366ZM95.8032 173.156H94.8492V166.821L92.9345 167.525V166.662L95.6543 165.639H95.8032V173.156ZM103.481 173.156H98.585V172.472L101.172 169.595C101.555 169.16 101.819 168.807 101.962 168.537C102.109 168.263 102.183 167.981 102.183 167.689C102.183 167.299 102.065 166.978 101.828 166.729C101.593 166.479 101.278 166.354 100.884 166.354C100.412 166.354 100.045 166.489 99.7806 166.76C99.521 167.026 99.3908 167.4 99.3908 167.879H98.4413C98.4413 167.191 98.6621 166.635 99.1035 166.21C99.5479 165.785 100.142 165.573 100.884 165.573C101.579 165.573 102.128 165.756 102.532 166.122C102.936 166.486 103.137 166.97 103.137 167.576C103.137 168.313 102.669 169.189 101.731 170.206L99.7297 172.38H103.481V173.156ZM109.173 169.965C109.173 171.078 108.983 171.906 108.603 172.446C108.223 172.988 107.63 173.258 106.822 173.258C106.025 173.258 105.435 172.995 105.052 172.467C104.669 171.936 104.47 171.145 104.456 170.094V168.825C104.456 167.725 104.646 166.909 105.026 166.374C105.406 165.84 106.001 165.573 106.812 165.573C107.616 165.573 108.208 165.832 108.588 166.349C108.968 166.862 109.162 167.657 109.173 168.732V169.965ZM108.223 168.666C108.223 167.861 108.11 167.275 107.884 166.909C107.659 166.539 107.302 166.354 106.812 166.354C106.326 166.354 105.972 166.537 105.75 166.904C105.528 167.27 105.412 167.833 105.406 168.594V170.114C105.406 170.922 105.522 171.52 105.755 171.907C105.991 172.291 106.347 172.482 106.822 172.482C107.291 172.482 107.638 172.301 107.864 171.938C108.093 171.575 108.213 171.003 108.223 170.222V168.666ZM115.075 169.965C115.075 171.078 114.885 171.906 114.505 172.446C114.125 172.988 113.532 173.258 112.725 173.258C111.927 173.258 111.337 172.995 110.954 172.467C110.57 171.936 110.372 171.145 110.359 170.094V168.825C110.359 167.725 110.548 166.909 110.928 166.374C111.308 165.84 111.903 165.573 112.714 165.573C113.518 165.573 114.11 165.832 114.49 166.349C114.87 166.862 115.065 167.657 115.075 168.732V169.965ZM114.125 168.666C114.125 167.861 114.012 167.275 113.787 166.909C113.561 166.539 113.203 166.354 112.714 166.354C112.229 166.354 111.874 166.537 111.652 166.904C111.429 167.27 111.315 167.833 111.308 168.594V170.114C111.308 170.922 111.424 171.52 111.657 171.907C111.893 172.291 112.249 172.482 112.725 172.482C113.193 172.482 113.54 172.301 113.766 171.938C113.996 171.575 114.115 171.003 114.125 170.222V168.666ZM119.586 171.897L121.475 167.597H122.661V173.156H121.711V169.112L119.915 173.156H119.258L117.426 169.025V173.156H116.476V167.597H117.708L119.586 171.897Z" fill="white"/>
<path d="M0.990623 224.567V231.24H3.5622V224.567H4.54235V231.24H7.09822V224.567H8.08361V232.047H0V224.567H0.990623ZM13.8366 227.259H11.9735V232.047H11.0241V227.259H9.19693V226.489H13.8366V227.259ZM18.1066 232.047C18.0519 231.938 18.007 231.742 17.9734 231.461C17.5319 231.92 17.0052 232.15 16.3924 232.15C15.8447 232.15 15.3951 231.996 15.0427 231.688C14.694 231.376 14.5189 230.982 14.5189 230.506C14.5189 229.928 14.7381 229.479 15.1758 229.16C15.6173 228.839 16.2368 228.678 17.0336 228.678H17.9577V228.241C17.9577 227.908 17.8582 227.645 17.6599 227.449C17.4616 227.251 17.1691 227.151 16.7822 227.151C16.444 227.151 16.1597 227.237 15.9308 227.408C15.7011 227.58 15.5866 227.787 15.5866 228.03H14.6319C14.6319 227.753 14.7299 227.485 14.9244 227.228C15.1227 226.969 15.3898 226.763 15.725 226.612C16.064 226.461 16.4351 226.386 16.8391 226.386C17.4788 226.386 17.9801 226.547 18.343 226.869C18.7051 227.187 18.8937 227.628 18.9071 228.189V230.748C18.9071 231.258 18.9722 231.664 19.1024 231.965V232.047H18.1066ZM16.5308 231.323C16.8286 231.323 17.1107 231.246 17.3778 231.092C17.6449 230.938 17.838 230.737 17.9577 230.491V229.35H17.214C16.0505 229.35 15.4684 229.691 15.4684 230.372C15.4684 230.67 15.5679 230.903 15.7662 231.071C15.9644 231.239 16.2196 231.323 16.5308 231.323ZM24.9324 232.047H23.983V229.674H21.4323V232.047H20.4776V226.489H21.4323V228.899H23.983V226.489H24.9324V232.047ZM30.0494 227.275H27.4883V232.047H26.5336V226.489H30.0494V227.275ZM34.4683 226.489H35.4178V232.047H34.4683V227.994L31.9072 232.047H30.9577V226.489H31.9072V230.547L34.4683 226.489ZM44.3476 232.047H39.4514V231.364L42.0379 228.487C42.421 228.052 42.6851 227.699 42.8287 227.429C42.9754 227.155 43.0495 226.873 43.0495 226.581C43.0495 226.191 42.9313 225.871 42.6948 225.62C42.4591 225.37 42.1441 225.246 41.7506 225.246C41.2785 225.246 40.9111 225.381 40.647 225.651C40.3874 225.919 40.2572 226.292 40.2572 226.772H39.3077C39.3077 226.083 39.5284 225.527 39.9699 225.101C40.4143 224.677 41.0084 224.465 41.7506 224.465C42.4449 224.465 42.9941 224.648 43.3981 225.015C43.8022 225.378 44.0034 225.862 44.0034 226.468C44.0034 227.204 43.5351 228.081 42.5975 229.098L40.5961 231.272H44.3476V232.047ZM50.2494 232.047H45.3532V231.364L47.9405 228.487C48.3236 228.052 48.5869 227.699 48.7306 227.429C48.878 227.155 48.9513 226.873 48.9513 226.581C48.9513 226.191 48.8331 225.871 48.5974 225.62C48.361 225.37 48.046 225.246 47.6524 225.246C47.1803 225.246 46.8129 225.381 46.5496 225.651C46.2892 225.919 46.159 226.292 46.159 226.772H45.2095C45.2095 226.083 45.4303 225.527 45.8717 225.101C46.3169 224.677 46.9102 224.465 47.6524 224.465C48.3475 224.465 48.8967 224.648 49.3 225.015C49.704 225.378 49.906 225.862 49.906 226.468C49.906 227.204 49.4369 228.081 48.4994 229.098L46.4979 231.272H50.2494V232.047ZM57.1576 230.789L59.0461 226.489H60.232V232.047H59.2825V228.004L57.4861 232.047H56.8292L54.9968 227.917V232.047H54.0473V226.489H55.2789L57.1576 230.789ZM64.9584 230.789L66.8476 226.489H68.0328V232.047H67.0833V228.004L65.2869 232.047H64.6299L62.7976 227.917V232.047H61.8481V226.489H63.0804L64.9584 230.789ZM75.1924 232.047H74.2376V225.713L72.323 226.417V225.554L75.0435 224.531H75.1924V232.047ZM82.8697 232.047H77.9742V231.364L80.5607 228.487C80.9438 228.052 81.2072 227.699 81.3508 227.429C81.4982 227.155 81.5715 226.873 81.5715 226.581C81.5715 226.191 81.4533 225.871 81.2177 225.62C80.9812 225.37 80.667 225.246 80.2734 225.246C79.8013 225.246 79.4332 225.381 79.1698 225.651C78.9094 225.919 78.78 226.292 78.78 226.772H77.8305C77.8305 226.083 78.0512 225.527 78.4919 225.101C78.9371 224.677 79.5304 224.465 80.2734 224.465C80.9678 224.465 81.5169 224.648 81.9202 225.015C82.3242 225.378 82.5263 225.862 82.5263 226.468C82.5263 227.204 82.0571 228.081 81.1196 229.098L79.1182 231.272H82.8697V232.047ZM88.562 228.857C88.562 229.97 88.372 230.797 87.9919 231.339C87.6125 231.879 87.0185 232.15 86.2112 232.15C85.4136 232.15 84.824 231.886 84.4402 231.359C84.0571 230.828 83.8588 230.037 83.8453 228.985V227.717C83.8453 226.617 84.0354 225.8 84.4147 225.266C84.7948 224.732 85.3896 224.465 86.2007 224.465C87.005 224.465 87.5968 224.723 87.9769 225.241C88.3563 225.754 88.5516 226.549 88.562 227.624V228.857ZM87.6126 227.557C87.6126 226.753 87.4996 226.167 87.2736 225.8C87.0477 225.43 86.69 225.246 86.2007 225.246C85.7151 225.246 85.3612 225.429 85.1382 225.795C84.916 226.162 84.8016 226.725 84.7948 227.485V229.006C84.7948 229.814 84.9108 230.412 85.1435 230.799C85.3799 231.183 85.7353 231.374 86.2112 231.374C86.6795 231.374 87.0275 231.192 87.2527 230.83C87.4824 230.467 87.6021 229.895 87.6126 229.114V227.557ZM94.4639 228.857C94.4639 229.97 94.2738 230.797 93.8937 231.339C93.5144 231.879 92.9203 232.15 92.113 232.15C91.3162 232.15 90.7258 231.886 90.3428 231.359C89.9597 230.828 89.7607 230.037 89.7472 228.985V227.717C89.7472 226.617 89.9372 225.8 90.3166 225.266C90.6967 224.732 91.2922 224.465 92.1033 224.465C92.9069 224.465 93.4987 224.723 93.8788 225.241C94.2581 225.754 94.4534 226.549 94.4639 227.624V228.857ZM93.5144 227.557C93.5144 226.753 93.4014 226.167 93.1755 225.8C92.9495 225.43 92.5919 225.246 92.1033 225.246C91.6169 225.246 91.263 225.429 91.0408 225.795C90.8179 226.162 90.7034 226.725 90.6967 227.485V229.006C90.6967 229.814 90.8134 230.412 91.0453 230.799C91.2818 231.183 91.6379 231.374 92.113 231.374C92.5821 231.374 92.9293 231.192 93.1553 230.83C93.3842 230.467 93.5039 229.895 93.5144 229.114V227.557ZM97.7537 229.258H95.2487V228.482H97.7537V229.258ZM101.705 232.047H100.751V225.713L98.8364 226.417V225.554L101.556 224.531H101.705V232.047ZM109.383 232.047H104.487V231.364L107.073 228.487C107.456 228.052 107.721 227.699 107.864 227.429C108.011 227.155 108.085 226.873 108.085 226.581C108.085 226.191 107.967 225.871 107.73 225.62C107.495 225.37 107.18 225.246 106.786 225.246C106.314 225.246 105.947 225.381 105.682 225.651C105.423 225.919 105.293 226.292 105.293 226.772H104.343C104.343 226.083 104.564 225.527 105.005 225.101C105.45 224.677 106.044 224.465 106.786 224.465C107.48 224.465 108.03 224.648 108.434 225.015C108.838 225.378 109.039 225.862 109.039 226.468C109.039 227.204 108.571 228.081 107.633 229.098L105.632 231.272H109.383V232.047ZM114.921 226.52C114.921 226.893 114.822 227.225 114.623 227.516C114.428 227.807 114.163 228.035 113.827 228.2C114.218 228.368 114.525 228.612 114.751 228.934C114.98 229.256 115.095 229.62 115.095 230.029C115.095 230.676 114.876 231.191 114.438 231.574C114.004 231.958 113.431 232.15 112.719 232.15C112 232.15 111.424 231.958 110.989 231.574C110.559 231.188 110.343 230.672 110.343 230.029C110.343 229.624 110.452 229.259 110.671 228.934C110.894 228.609 111.2 228.362 111.59 228.195C111.258 228.03 110.996 227.802 110.805 227.511C110.613 227.22 110.517 226.89 110.517 226.52C110.517 225.889 110.719 225.39 111.123 225.02C111.527 224.65 112.059 224.465 112.719 224.465C113.376 224.465 113.906 224.65 114.31 225.02C114.717 225.39 114.921 225.889 114.921 226.52ZM114.146 230.008C114.146 229.59 114.012 229.249 113.745 228.985C113.482 228.722 113.137 228.59 112.709 228.59C112.281 228.59 111.937 228.72 111.677 228.98C111.42 229.241 111.292 229.583 111.292 230.008C111.292 230.432 111.417 230.766 111.667 231.01C111.92 231.252 112.271 231.374 112.719 231.374C113.164 231.374 113.513 231.252 113.766 231.01C114.019 230.763 114.146 230.429 114.146 230.008ZM112.719 225.246C112.346 225.246 112.043 225.362 111.81 225.595C111.581 225.824 111.467 226.138 111.467 226.535C111.467 226.915 111.58 227.223 111.806 227.46C112.035 227.693 112.339 227.809 112.719 227.809C113.099 227.809 113.402 227.693 113.628 227.46C113.857 227.223 113.971 226.915 113.971 226.535C113.971 226.155 113.854 225.845 113.617 225.605C113.381 225.366 113.081 225.246 112.719 225.246ZM120.977 228.857C120.977 229.97 120.787 230.797 120.407 231.339C120.027 231.879 119.434 232.15 118.626 232.15C117.829 232.15 117.238 231.886 116.855 231.359C116.472 230.828 116.274 230.037 116.261 228.985V227.717C116.261 226.617 116.45 225.8 116.83 225.266C117.21 224.732 117.805 224.465 118.616 224.465C119.42 224.465 120.012 224.723 120.391 225.241C120.771 225.754 120.967 226.549 120.977 227.624V228.857ZM120.027 227.557C120.027 226.753 119.914 226.167 119.689 225.8C119.463 225.43 119.105 225.246 118.616 225.246C118.13 225.246 117.776 225.429 117.553 225.795C117.331 226.162 117.217 226.725 117.21 227.485V229.006C117.21 229.814 117.326 230.412 117.559 230.799C117.795 231.183 118.151 231.374 118.626 231.374C119.095 231.374 119.442 231.192 119.668 230.83C119.898 230.467 120.017 229.895 120.027 229.114V227.557ZM125.488 230.789L127.377 226.489H128.563V232.047H127.613V228.004L125.817 232.047H125.16L123.327 227.917V232.047H122.378V226.489H123.609L125.488 230.789Z" fill="white"/>
<path d="M5.74322 273.121H4.7526V269.664H0.985386V273.121H0V265.642H0.985386V268.858H4.7526V265.642H5.74322V273.121ZM10.7727 273.121C10.718 273.012 10.6731 272.817 10.6395 272.536C10.198 272.995 9.6713 273.224 9.05852 273.224C8.51083 273.224 8.06116 273.07 7.70876 272.762C7.36009 272.45 7.18501 272.056 7.18501 271.58C7.18501 271.002 7.40424 270.553 7.84194 270.234C8.28338 269.912 8.90289 269.751 9.69973 269.751H10.6238V269.315C10.6238 268.983 10.525 268.719 10.326 268.524C10.1277 268.325 9.83516 268.226 9.44833 268.226C9.11014 268.226 8.82583 268.311 8.59688 268.483C8.36718 268.654 8.2527 268.861 8.2527 269.104H7.29799C7.29799 268.827 7.39601 268.56 7.59054 268.303C7.78881 268.043 8.05592 267.837 8.39112 267.686C8.73006 267.536 9.10117 267.46 9.5052 267.46C10.1449 267.46 10.6462 267.621 11.0091 267.943C11.3712 268.262 11.5598 268.702 11.5732 269.264V271.822C11.5732 272.332 11.6383 272.738 11.7685 273.039V273.121H10.7727ZM9.19694 272.397C9.49472 272.397 9.77679 272.32 10.0439 272.166C10.311 272.012 10.5041 271.812 10.6238 271.565V270.425H9.88005C8.71659 270.425 8.13448 270.765 8.13448 271.447C8.13448 271.745 8.234 271.978 8.43227 272.146C8.63054 272.313 8.88568 272.397 9.19694 272.397ZM15.2888 272.449C15.6278 272.449 15.924 272.346 16.1769 272.14C16.4298 271.935 16.5705 271.678 16.5974 271.37H17.496C17.4788 271.688 17.3696 271.991 17.1676 272.279C16.9655 272.566 16.6954 272.796 16.3565 272.967C16.0213 273.139 15.6652 273.224 15.2888 273.224C14.5331 273.224 13.9308 272.972 13.4827 272.469C13.0375 271.962 12.8153 271.27 12.8153 270.394V270.234C12.8153 269.694 12.9148 269.212 13.113 268.791C13.3113 268.369 13.5956 268.043 13.9652 267.81C14.3379 267.577 14.7778 267.46 15.2836 267.46C15.9068 267.46 16.4231 267.647 16.8339 268.02C17.2476 268.393 17.4683 268.878 17.496 269.474H16.5974C16.5705 269.115 16.4336 268.82 16.1874 268.59C15.9442 268.357 15.6435 268.241 15.2836 268.241C14.8017 268.241 14.4269 268.416 14.1598 268.765C13.8964 269.111 13.7647 269.613 13.7647 270.27V270.45C13.7647 271.09 13.8964 271.584 14.1598 271.93C14.4231 272.276 14.7995 272.449 15.2888 272.449ZM18.3116 270.291C18.3116 269.747 18.4178 269.257 18.6303 268.822C18.8458 268.387 19.1436 268.051 19.5229 267.814C19.906 267.579 20.3429 267.46 20.8315 267.46C21.588 267.46 22.1985 267.722 22.6639 268.247C23.133 268.77 23.3672 269.467 23.3672 270.337V270.404C23.3672 270.945 23.2624 271.431 23.0544 271.863C22.8487 272.291 22.5531 272.625 22.1663 272.865C21.7832 273.104 21.3418 273.224 20.842 273.224C20.0893 273.224 19.4788 272.963 19.0096 272.438C18.5443 271.914 18.3116 271.221 18.3116 270.358V270.291ZM19.2663 270.404C19.2663 271.021 19.4084 271.515 19.6928 271.889C19.9801 272.262 20.3631 272.449 20.842 272.449C21.3246 272.449 21.7077 272.26 21.992 271.883C22.2756 271.503 22.4177 270.973 22.4177 270.291C22.4177 269.682 22.2726 269.188 21.9815 268.811C21.6942 268.432 21.3111 268.241 20.8315 268.241C20.3631 268.241 19.9853 268.428 19.698 268.801C19.4099 269.175 19.2663 269.709 19.2663 270.404ZM26.785 272.449C27.1239 272.449 27.4202 272.346 27.6731 272.14C27.926 271.935 28.0667 271.678 28.0936 271.37H28.9922C28.975 271.688 28.8657 271.991 28.6637 272.279C28.4617 272.566 28.1916 272.796 27.8527 272.967C27.5175 273.139 27.1613 273.224 26.785 273.224C26.0293 273.224 25.427 272.972 24.9788 272.469C24.5336 271.962 24.3114 271.27 24.3114 270.394V270.234C24.3114 269.694 24.4109 269.212 24.6092 268.791C24.8075 268.369 25.0918 268.043 25.4614 267.81C25.834 267.577 26.274 267.46 26.7798 267.46C27.403 267.46 27.9193 267.647 28.33 268.02C28.7438 268.393 28.9645 268.878 28.9922 269.474H28.0936C28.0667 269.115 27.9297 268.82 27.6836 268.59C27.4404 268.357 27.1396 268.241 26.7798 268.241C26.2979 268.241 25.9231 268.416 25.656 268.765C25.3926 269.111 25.2609 269.613 25.2609 270.27V270.45C25.2609 271.09 25.3926 271.584 25.656 271.93C25.9193 272.276 26.2957 272.449 26.785 272.449Z" fill="white"/>
<path d="M37.8139 263.481C38.4903 263.481 39.1091 263.635 39.6695 263.942C39.8438 264.043 40.0076 264.154 40.161 264.275L41.026 263.41L41.5572 263.942L40.693 264.808C40.7985 264.945 40.8965 265.091 40.9863 265.244C41.3035 265.805 41.4622 266.437 41.4622 267.141C41.4622 267.83 41.3058 268.454 40.9938 269.015C40.6878 269.571 40.2516 270.007 39.6852 270.325C39.1248 270.643 38.5008 270.801 37.8139 270.801C37.1368 270.801 36.518 270.645 35.9576 270.333C35.7885 270.237 35.6299 270.132 35.4818 270.015L34.6176 270.881L34.0781 270.349L34.9505 269.483C34.8398 269.34 34.7388 269.187 34.649 269.023C34.337 268.456 34.1814 267.83 34.1814 267.141C34.1814 266.448 34.34 265.821 34.6572 265.26C34.9745 264.694 35.4107 264.257 35.9658 263.95C36.5263 263.638 37.142 263.481 37.8139 263.481ZM37.8057 264.244C37.2984 264.244 36.8248 264.366 36.3863 264.609C35.9524 264.853 35.6112 265.196 35.3628 265.641C35.1196 266.085 34.9984 266.586 34.9984 267.141C34.9984 267.687 35.1174 268.182 35.3553 268.626C35.4077 268.722 35.466 268.814 35.5296 268.904L39.5984 264.832C39.4921 264.752 39.3792 264.678 39.2572 264.609C38.824 264.366 38.3399 264.244 37.8057 264.244ZM36.3781 269.666C36.8225 269.915 37.2984 270.039 37.8057 270.039C38.3504 270.039 38.8397 269.915 39.2729 269.666C39.7121 269.412 40.0503 269.062 40.2882 268.618C40.5262 268.173 40.6451 267.681 40.6451 267.141C40.6451 266.58 40.5209 266.078 40.2725 265.633C40.2246 265.548 40.1745 265.464 40.1214 265.379L36.0526 269.452C36.1536 269.526 36.2621 269.597 36.3781 269.666Z" fill="white"/>
<path d="M48.6167 269.372L48.9961 265.642H52.8246V266.52H49.8019L49.5759 268.56C49.9425 268.344 50.3578 268.236 50.8232 268.236C51.504 268.236 52.045 268.462 52.4453 268.914C52.8456 269.363 53.0453 269.971 53.0453 270.738C53.0453 271.508 52.8366 272.116 52.4191 272.561C52.0053 273.003 51.4255 273.224 50.6795 273.224C50.0189 273.224 49.4801 273.041 49.0626 272.674C48.6451 272.308 48.408 271.801 48.3496 271.154H49.2475C49.3058 271.582 49.4577 271.906 49.7046 272.125C49.9508 272.341 50.2755 272.449 50.6795 272.449C51.121 272.449 51.4666 272.298 51.7165 271.997C51.9694 271.695 52.0959 271.279 52.0959 270.748C52.0959 270.248 51.959 269.847 51.6851 269.546C51.415 269.241 51.0544 269.089 50.6025 269.089C50.1887 269.089 49.8632 269.18 49.6275 269.361L49.3761 269.566L48.6167 269.372ZM58.9068 266.176L55.8115 273.121H54.8163L57.9004 266.423H53.8564V265.642H58.9068V266.176ZM65.886 271.863L67.7753 267.563H68.9604V273.121H68.0109V269.079L66.2145 273.121H65.5576L63.726 268.991V273.121H62.7765V267.563H64.008L65.886 271.863ZM73.6876 271.863L75.576 267.563H76.7612V273.121H75.8117V269.079L74.016 273.121H73.3591L71.5268 268.991V273.121H70.5773V267.563H71.8088L73.6876 271.863ZM86.7901 273.121H85.7995V269.664H82.0323V273.121H81.0469V265.642H82.0323V268.858H85.7995V265.642H86.7901V273.121ZM90.6187 272.449C90.9569 272.449 91.2532 272.346 91.5061 272.14C91.7597 271.935 91.8996 271.678 91.9273 271.37H92.8252C92.808 271.688 92.6987 271.991 92.4967 272.279C92.2947 272.567 92.0246 272.796 91.6856 272.967C91.3504 273.139 90.995 273.224 90.6187 273.224C89.8623 273.224 89.26 272.972 88.8118 272.469C88.3674 271.962 88.1444 271.27 88.1444 270.394V270.234C88.1444 269.694 88.2439 269.212 88.4422 268.791C88.6412 268.37 88.9248 268.043 89.2944 267.81C89.667 267.577 90.1069 267.46 90.6135 267.46C91.236 267.46 91.753 267.647 92.163 268.021C92.5775 268.393 92.7982 268.878 92.8252 269.474H91.9273C91.8996 269.115 91.7627 268.82 91.5165 268.59C91.2734 268.358 90.9726 268.241 90.6135 268.241C90.1309 268.241 89.756 268.416 89.4897 268.765C89.2263 269.111 89.0939 269.613 89.0939 270.27V270.45C89.0939 271.09 89.2263 271.584 89.4897 271.93C89.753 272.276 90.1294 272.449 90.6187 272.449ZM98.4352 273.121H97.4857V268.349H94.9299V273.121H93.9751V267.563H98.4352V273.121ZM104.542 270.332H102.038V269.557H104.542V270.332ZM111.101 273.121H110.147V266.788L108.232 267.491V266.628L110.953 265.606H111.101V273.121ZM118.779 273.121H113.883V272.438L116.469 269.562C116.853 269.127 117.116 268.774 117.26 268.504C117.407 268.229 117.481 267.946 117.481 267.656C117.481 267.265 117.363 266.945 117.126 266.695C116.89 266.445 116.575 266.32 116.182 266.32C115.71 266.32 115.342 266.455 115.078 266.726C114.819 266.993 114.688 267.366 114.688 267.846H113.739C113.739 267.157 113.96 266.601 114.401 266.176C114.846 265.751 115.44 265.539 116.182 265.539C116.877 265.539 117.425 265.722 117.829 266.089C118.233 266.452 118.435 266.936 118.435 267.543C118.435 268.279 117.966 269.156 117.029 270.173L115.027 272.346H118.779V273.121ZM124.316 267.594C124.316 267.967 124.218 268.299 124.019 268.59C123.824 268.882 123.558 269.109 123.223 269.273C123.614 269.442 123.921 269.687 124.147 270.008C124.376 270.33 124.491 270.695 124.491 271.102C124.491 271.75 124.272 272.265 123.835 272.649C123.4 273.032 122.827 273.224 122.115 273.224C121.396 273.224 120.82 273.032 120.385 272.649C119.954 272.262 119.739 271.746 119.739 271.102C119.739 270.699 119.848 270.334 120.067 270.008C120.29 269.683 120.596 269.437 120.986 269.269C120.654 269.104 120.392 268.877 120.2 268.585C120.009 268.295 119.913 267.964 119.913 267.594C119.913 266.964 120.115 266.463 120.518 266.094C120.923 265.724 121.454 265.539 122.115 265.539C122.772 265.539 123.302 265.724 123.706 266.094C124.113 266.463 124.316 266.964 124.316 267.594ZM123.542 271.082C123.542 270.664 123.408 270.323 123.142 270.06C122.878 269.796 122.533 269.664 122.105 269.664C121.677 269.664 121.333 269.795 121.073 270.055C120.816 270.315 120.688 270.657 120.688 271.082C120.688 271.507 120.813 271.841 121.062 272.084C121.316 272.327 121.667 272.449 122.115 272.449C122.56 272.449 122.909 272.327 123.162 272.084C123.415 271.837 123.542 271.503 123.542 271.082ZM122.115 266.32C121.742 266.32 121.44 266.437 121.207 266.669C120.977 266.899 120.863 267.212 120.863 267.609C120.863 267.99 120.976 268.298 121.202 268.534C121.431 268.767 121.735 268.883 122.115 268.883C122.494 268.883 122.798 268.767 123.023 268.534C123.252 268.298 123.367 267.99 123.367 267.609C123.367 267.229 123.249 266.92 123.013 266.679C122.777 266.44 122.477 266.32 122.115 266.32ZM130.372 269.931C130.372 271.045 130.183 271.871 129.803 272.413C129.423 272.954 128.83 273.224 128.022 273.224C127.225 273.224 126.634 272.96 126.251 272.433C125.868 271.902 125.67 271.111 125.656 270.06V268.791C125.656 267.692 125.846 266.875 126.226 266.341C126.606 265.806 127.201 265.539 128.012 265.539C128.816 265.539 129.408 265.798 129.787 266.314C130.167 266.828 130.363 267.623 130.372 268.698V269.931ZM129.423 268.632C129.423 267.827 129.311 267.241 129.085 266.875C128.859 266.505 128.501 266.32 128.012 266.32C127.526 266.32 127.172 266.503 126.949 266.869C126.727 267.236 126.613 267.8 126.606 268.56V270.08C126.606 270.889 126.722 271.487 126.955 271.873C127.191 272.256 127.546 272.449 128.022 272.449C128.491 272.449 128.838 272.267 129.064 271.904C129.293 271.541 129.413 270.969 129.423 270.188V268.632ZM134.884 271.863L136.772 267.563H137.958V273.121H137.009V269.079L135.212 273.121H134.556L132.723 268.991V273.121H131.774V267.563H133.005L134.884 271.863Z" fill="white"/>
<path d="M4.67037 331.224H5.65576V338.704H4.67037V332.94L0.990549 338.704H0V331.224H0.990549V336.988L4.67037 331.224ZM11.84 338.704H10.8906V336.33H8.33987V338.704H7.38531V333.145H8.33987V335.554H10.8906V333.145H11.84V338.704ZM17.4957 333.916H15.6328V338.704H14.6833V333.916H12.8563V333.145H17.4957V333.916ZM20.3133 338.806C19.5606 338.806 18.9481 338.56 18.476 338.067C18.0038 337.571 17.7678 336.908 17.7678 336.079V335.904C17.7678 335.353 17.8721 334.861 18.0808 334.43C18.2929 333.994 18.5872 333.656 18.9636 333.413C19.3433 333.166 19.754 333.043 20.1953 333.043C20.9172 333.043 21.4783 333.281 21.8786 333.757C22.279 334.233 22.4791 334.914 22.4791 335.802V336.197H18.7172C18.7309 336.745 18.89 337.189 19.1945 337.527C19.5024 337.863 19.8925 338.031 20.3646 338.031C20.7 338.031 20.9839 337.962 21.2166 337.825C21.4492 337.688 21.6528 337.507 21.8273 337.281L22.4073 337.733C21.9419 338.448 21.244 338.806 20.3133 338.806ZM20.1953 333.824C19.8121 333.824 19.4904 333.964 19.2304 334.245C18.9704 334.522 18.8096 334.913 18.748 335.416H21.5297V335.344C21.5023 334.861 21.3723 334.488 21.1396 334.224C20.9069 333.957 20.5922 333.824 20.1953 333.824ZM28.2734 335.987C28.2734 336.832 28.0801 337.514 27.6935 338.031C27.3069 338.548 26.7833 338.806 26.123 338.806C25.449 338.806 24.9187 338.593 24.532 338.164V340.841H23.5825V333.145H24.4499L24.4961 333.762C24.8828 333.282 25.4199 333.043 26.1076 333.043C26.7748 333.043 27.3017 333.294 27.6883 333.797C28.0784 334.301 28.2734 335.002 28.2734 335.899V335.987ZM27.3239 335.879C27.3239 335.252 27.1905 334.757 26.9236 334.394C26.6567 334.03 26.2907 333.849 25.8253 333.849C25.2505 333.849 24.8195 334.105 24.532 334.615V337.27C24.816 337.777 25.2505 338.031 25.8356 338.031C26.2907 338.031 26.6517 337.851 26.9185 337.491C27.1888 337.129 27.3239 336.591 27.3239 335.879ZM29.5718 338.704V333.145H31.7377C32.4767 333.145 33.043 333.275 33.4364 333.536C33.8333 333.793 34.0317 334.171 34.0317 334.671C34.0317 334.928 33.9547 335.161 33.8008 335.369C33.6469 335.575 33.4193 335.733 33.1182 335.842C33.4535 335.921 33.7221 336.075 33.924 336.305C34.1293 336.534 34.232 336.808 34.232 337.126C34.232 337.637 34.0437 338.027 33.6674 338.298C33.2944 338.569 32.7658 338.704 32.0815 338.704H29.5718ZM30.5213 336.264V337.938H32.0918C32.4886 337.938 32.7846 337.865 32.9797 337.717C33.1781 337.571 33.2773 337.363 33.2773 337.096C33.2773 336.541 32.8701 336.264 32.0559 336.264H30.5213ZM30.5213 335.504H31.7479C32.6375 335.504 33.0823 335.243 33.0823 334.722C33.0823 334.202 32.6615 333.933 31.8197 333.916H30.5213V335.504ZM38.9173 338.704C38.8627 338.594 38.8185 338.399 38.7841 338.118C38.3427 338.577 37.8159 338.806 37.2031 338.806C36.6562 338.806 36.2058 338.653 35.8534 338.344C35.5047 338.033 35.3304 337.639 35.3304 337.162C35.3304 336.584 35.5489 336.135 35.9873 335.817C36.4288 335.495 37.0475 335.334 37.8451 335.334H38.7691V334.897C38.7691 334.565 38.6696 334.301 38.4714 334.106C38.2723 333.908 37.9798 333.808 37.5937 333.808C37.2548 333.808 36.9705 333.894 36.7415 334.065C36.5126 334.236 36.3981 334.443 36.3981 334.686H35.4434C35.4434 334.409 35.5406 334.142 35.7359 333.885C35.9342 333.625 36.2013 333.419 36.5365 333.269C36.8747 333.118 37.2465 333.043 37.6498 333.043C38.2895 333.043 38.7908 333.204 39.1537 333.526C39.5166 333.844 39.7044 334.284 39.7186 334.846V337.404C39.7186 337.914 39.783 338.32 39.9131 338.621V338.704H38.9173ZM37.3423 337.979C37.6394 337.979 37.9222 337.902 38.1885 337.748C38.4556 337.595 38.6487 337.394 38.7691 337.147V336.007H38.0247C36.8612 336.007 36.2799 336.348 36.2799 337.029C36.2799 337.327 36.3786 337.56 36.5776 337.728C36.7759 337.896 37.0303 337.979 37.3423 337.979ZM45.7589 333.145V338.704H44.8042V333.932H42.9157L42.8027 336.012C42.7414 336.968 42.5805 337.651 42.3201 338.062C42.0635 338.472 41.655 338.686 41.0938 338.704H40.7137V337.866L40.9861 337.846C41.2936 337.812 41.5143 337.633 41.6482 337.311C41.7814 336.989 41.8667 336.394 41.9049 335.524L42.0074 333.145H45.7589ZM48.32 335.062H49.7618C50.3918 335.068 50.8893 335.233 51.2552 335.554C51.6218 335.876 51.8044 336.313 51.8044 336.865C51.8044 337.419 51.6166 337.865 51.2402 338.2C50.8639 338.536 50.3573 338.704 49.7206 338.704H47.3705V333.145H48.32V335.062ZM53.7856 338.704H52.8309V333.145H53.7856V338.704ZM48.32 335.838V337.928H49.7311C50.0872 337.928 50.3626 337.837 50.5579 337.656C50.7524 337.471 50.8504 337.219 50.8504 336.901C50.8504 336.592 50.7539 336.341 50.5623 336.145C50.3745 335.947 50.1089 335.844 49.767 335.838H48.32ZM62.5927 338.704H61.6433V333.932H59.0874V338.704H58.1327V333.145H62.5927V338.704ZM66.4213 338.806C65.6686 338.806 65.0558 338.56 64.5837 338.067C64.1116 337.571 63.8759 336.908 63.8759 336.079V335.904C63.8759 335.353 63.9799 334.861 64.1887 334.43C64.4011 333.994 64.6952 333.656 65.0715 333.413C65.4509 333.166 65.8616 333.043 66.3031 333.043C67.0251 333.043 67.5863 333.281 67.9865 333.757C68.3868 334.233 68.5873 334.914 68.5873 335.802V336.197H64.8254C64.8388 336.745 64.9982 337.189 65.3027 337.527C65.6102 337.863 66.0001 338.031 66.4722 338.031C66.8081 338.031 67.0917 337.962 67.3244 337.825C67.5571 337.688 67.7606 337.507 67.9349 337.281L68.5148 337.733C68.0501 338.448 67.3521 338.806 66.4213 338.806ZM66.3031 333.824C65.92 333.824 65.5983 333.964 65.3386 334.245C65.0783 334.522 64.9174 334.913 64.8561 335.416H67.6379V335.344C67.6102 334.861 67.48 334.488 67.2473 334.224C67.0146 333.957 66.7004 333.824 66.3031 333.824ZM74.3815 335.987C74.3815 336.832 74.1877 337.514 73.8016 338.031C73.4148 338.548 72.891 338.806 72.2311 338.806C71.557 338.806 71.0265 338.593 70.6397 338.164V340.841H69.6902V333.145H70.5581L70.6038 333.762C70.9906 333.282 71.5278 333.043 72.2154 333.043C72.8828 333.043 73.4095 333.294 73.7964 333.797C74.1862 334.301 74.3815 335.002 74.3815 335.899V335.987ZM73.432 335.879C73.432 335.252 73.298 334.757 73.0317 334.394C72.7646 334.03 72.3987 333.849 71.9333 333.849C71.3587 333.849 70.927 334.105 70.6397 334.615V337.27C70.924 337.777 71.3587 338.031 71.9438 338.031C72.3987 338.031 72.7593 337.851 73.0265 337.491C73.2966 337.129 73.432 336.591 73.432 335.879ZM75.387 336.027C75.387 335.099 75.5666 334.37 75.9258 333.839C76.2856 333.308 76.778 333.043 77.4042 333.043C77.6953 333.043 77.9496 333.092 78.1689 333.192V330.813H79.1183V333.222C79.3578 333.102 79.6383 333.043 79.9601 333.043C80.5893 333.043 81.0839 333.308 81.443 333.839C81.8021 334.37 81.9817 335.135 81.9817 336.135C81.9817 336.953 81.8021 337.604 81.443 338.087C81.0876 338.57 80.596 338.812 79.9705 338.812C79.6383 338.812 79.354 338.757 79.1183 338.648V340.841H78.1689V338.663C77.9429 338.762 77.6848 338.812 77.3937 338.812C76.7712 338.812 76.2804 338.57 75.9213 338.087C75.5651 337.604 75.387 336.944 75.387 336.104V336.027ZM81.0322 336.027C81.0322 335.329 80.9125 334.788 80.6731 334.404C80.4337 334.017 80.1037 333.824 79.6825 333.824C79.467 333.824 79.2792 333.857 79.1183 333.926V337.949C79.2725 338.007 79.464 338.036 79.693 338.036C80.1172 338.036 80.4457 337.872 80.6783 337.543C80.9148 337.214 81.0322 336.709 81.0322 336.027ZM76.3365 336.135C76.3365 336.759 76.448 337.231 76.6702 337.553C76.8924 337.875 77.2127 338.036 77.6302 338.036C77.8284 338.036 78.008 338.005 78.1689 337.944V333.911C78.0252 333.853 77.8486 333.824 77.6399 333.824C77.2231 333.824 76.9014 334.01 76.6755 334.383C76.4495 334.757 76.3365 335.341 76.3365 336.135ZM82.9671 335.873C82.9671 335.329 83.0733 334.839 83.2858 334.404C83.5013 333.969 83.7991 333.633 84.1785 333.397C84.5615 333.161 84.9977 333.043 85.4871 333.043C86.2435 333.043 86.854 333.305 87.3194 333.829C87.7885 334.352 88.0227 335.05 88.0227 335.919V335.987C88.0227 336.527 87.918 337.013 87.71 337.446C87.5042 337.873 87.2087 338.207 86.8219 338.447C86.4388 338.686 85.9973 338.806 85.4975 338.806C84.7448 338.806 84.1343 338.545 83.6652 338.021C83.1998 337.496 82.9671 336.803 82.9671 335.94V335.873ZM83.9218 335.987C83.9218 336.603 84.064 337.097 84.3483 337.471C84.6356 337.844 85.0187 338.031 85.4975 338.031C85.9801 338.031 86.3632 337.842 86.6475 337.466C86.9311 337.085 87.0733 336.555 87.0733 335.873C87.0733 335.264 86.9281 334.77 86.637 334.394C86.3497 334.014 85.9667 333.824 85.4871 333.824C85.0187 333.824 84.6408 334.01 84.3535 334.383C84.0655 334.757 83.9218 335.291 83.9218 335.987ZM93.9044 335.987C93.9044 336.832 93.7106 337.514 93.3245 338.031C92.9377 338.548 92.4139 338.806 91.754 338.806C91.0799 338.806 90.5494 338.593 90.1626 338.164V340.841H89.2131V333.145H90.081L90.1267 333.762C90.5135 333.282 91.0507 333.043 91.7383 333.043C92.4057 333.043 92.9324 333.294 93.3193 333.797C93.7091 334.301 93.9044 335.002 93.9044 335.899V335.987ZM92.9549 335.879C92.9549 335.252 92.821 334.757 92.5546 334.394C92.2875 334.03 91.9216 333.849 91.4562 333.849C90.8816 333.849 90.4499 334.105 90.1626 334.615V337.27C90.4469 337.777 90.8816 338.031 91.4667 338.031C91.9216 338.031 92.2823 337.851 92.5494 337.491C92.8195 337.129 92.9549 336.591 92.9549 335.879ZM98.544 338.704C98.4894 338.594 98.4445 338.399 98.4101 338.118C97.9686 338.577 97.4419 338.806 96.8298 338.806C96.2822 338.806 95.8325 338.653 95.4801 338.344C95.1307 338.033 94.9563 337.639 94.9563 337.162C94.9563 336.584 95.1756 336.135 95.6133 335.817C96.0547 335.495 96.6742 335.334 97.4711 335.334H98.3951V334.897C98.3951 334.565 98.2956 334.301 98.0973 334.106C97.899 333.908 97.6065 333.808 97.2197 333.808C96.8807 333.808 96.5972 333.894 96.3675 334.065C96.1385 334.236 96.024 334.443 96.024 334.686H95.0693C95.0693 334.409 95.1666 334.142 95.3619 333.885C95.5601 333.625 95.8273 333.419 96.1625 333.269C96.5014 333.118 96.8725 333.043 97.2758 333.043C97.9162 333.043 98.4168 333.204 98.7797 333.526C99.1426 333.844 99.3304 334.284 99.3446 334.846V337.404C99.3446 337.914 99.4097 338.32 99.5391 338.621V338.704H98.544ZM96.9683 337.979C97.2661 337.979 97.5481 337.902 97.8152 337.748C98.0816 337.595 98.2754 337.394 98.3951 337.147V336.007H97.6506C96.4872 336.007 95.9058 336.348 95.9058 337.029C95.9058 337.327 96.0053 337.56 96.2036 337.728C96.4019 337.896 96.657 337.979 96.9683 337.979ZM100.915 333.145H101.87V337.928H104.426V333.145H105.374V337.928H106.037L105.944 340.353H105.092V338.704H100.915V333.145ZM110.656 333.145H111.605V338.704H110.656V334.65L108.095 338.704H107.145V333.145H108.095V337.204L110.656 333.145ZM116.722 333.145H117.672V338.704H116.722V334.65L114.161 338.704H113.212V333.145H114.161V337.204L116.722 333.145ZM119.165 338.206C119.165 338.041 119.213 337.904 119.309 337.795C119.408 337.685 119.555 337.63 119.75 337.63C119.945 337.63 120.092 337.685 120.192 337.795C120.294 337.904 120.345 338.041 120.345 338.206C120.345 338.363 120.294 338.495 120.192 338.601C120.092 338.707 119.945 338.761 119.75 338.761C119.555 338.761 119.408 338.707 119.309 338.601C119.213 338.495 119.165 338.363 119.165 338.206ZM119.171 333.669C119.171 333.505 119.218 333.368 119.314 333.258C119.413 333.149 119.56 333.094 119.755 333.094C119.95 333.094 120.098 333.149 120.196 333.258C120.3 333.368 120.35 333.505 120.35 333.669C120.35 333.827 120.3 333.958 120.196 334.065C120.098 334.171 119.95 334.224 119.755 334.224C119.56 334.224 119.413 334.171 119.314 334.065C119.218 333.958 119.171 333.827 119.171 333.669ZM124.764 338.704H123.809V332.37L121.895 333.073V332.21L124.615 331.188H124.764V338.704ZM128.926 334.501H129.64C130.088 334.495 130.441 334.376 130.697 334.147C130.954 333.918 131.082 333.608 131.082 333.217C131.082 332.341 130.646 331.902 129.773 331.902C129.363 331.902 129.034 332.02 128.788 332.257C128.545 332.49 128.424 332.799 128.424 333.186H127.474C127.474 332.594 127.69 332.103 128.121 331.712C128.555 331.319 129.106 331.122 129.773 331.122C130.478 331.122 131.031 331.308 131.431 331.681C131.832 332.055 132.031 332.574 132.031 333.238C132.031 333.563 131.925 333.878 131.713 334.183C131.505 334.488 131.219 334.716 130.856 334.866C131.267 334.997 131.583 335.212 131.805 335.513C132.031 335.815 132.144 336.183 132.144 336.618C132.144 337.29 131.925 337.822 131.487 338.216C131.05 338.609 130.48 338.806 129.779 338.806C129.077 338.806 128.506 338.617 128.064 338.236C127.626 337.856 127.407 337.354 127.407 336.731H128.362C128.362 337.125 128.49 337.44 128.747 337.676C129.003 337.913 129.348 338.031 129.779 338.031C130.237 338.031 130.587 337.911 130.831 337.671C131.074 337.431 131.195 337.088 131.195 336.639C131.195 336.204 131.062 335.87 130.795 335.637C130.528 335.404 130.143 335.284 129.64 335.277H128.926V334.501ZM137.456 336.192H138.493V336.968H137.456V338.704H136.502V336.968H133.099V336.407L136.445 331.224H137.456V336.192ZM134.177 336.192H136.502V332.524L136.389 332.729L134.177 336.192ZM139.787 334.954L140.166 331.224H143.994V332.103H140.972L140.746 334.142C141.112 333.926 141.528 333.818 141.993 333.818C142.674 333.818 143.215 334.045 143.615 334.496C144.015 334.945 144.215 335.553 144.215 336.32C144.215 337.091 144.006 337.699 143.589 338.144C143.175 338.585 142.595 338.806 141.849 338.806C141.189 338.806 140.65 338.624 140.232 338.257C139.815 337.89 139.578 337.383 139.519 336.736H140.417C140.476 337.165 140.628 337.488 140.874 337.707C141.121 337.923 141.445 338.031 141.849 338.031C142.291 338.031 142.636 337.88 142.886 337.579C143.139 337.278 143.266 336.861 143.266 336.33C143.266 335.83 143.129 335.429 142.856 335.128C142.585 334.824 142.224 334.671 141.772 334.671C141.359 334.671 141.033 334.762 140.797 334.943L140.546 335.149L139.787 334.954ZM147.325 335.915H144.821V335.139H147.325V335.915ZM151.277 338.704H150.323V332.37L148.408 333.073V332.21L151.129 331.188H151.277V338.704ZM155.44 334.501H156.153C156.601 334.495 156.953 334.376 157.21 334.147C157.467 333.918 157.595 333.608 157.595 333.217C157.595 332.341 157.159 331.902 156.286 331.902C155.876 331.902 155.547 332.02 155.301 332.257C155.058 332.49 154.936 332.799 154.936 333.186H153.987C153.987 332.594 154.203 332.103 154.634 331.712C155.069 331.319 155.619 331.122 156.286 331.122C156.992 331.122 157.544 331.308 157.944 331.681C158.344 332.055 158.545 332.574 158.545 333.238C158.545 333.563 158.439 333.878 158.226 334.183C158.017 334.488 157.732 334.716 157.369 334.866C157.78 334.997 158.097 335.212 158.319 335.513C158.545 335.815 158.658 336.183 158.658 336.618C158.658 337.29 158.439 337.822 158.001 338.216C157.562 338.609 156.993 338.806 156.291 338.806C155.59 338.806 155.018 338.617 154.577 338.236C154.139 337.856 153.92 337.354 153.92 336.731H154.875C154.875 337.125 155.004 337.44 155.26 337.676C155.517 337.913 155.86 338.031 156.291 338.031C156.75 338.031 157.101 337.911 157.344 337.671C157.586 337.431 157.708 337.088 157.708 336.639C157.708 336.204 157.574 335.87 157.308 335.637C157.041 335.404 156.656 335.284 156.153 335.277H155.44V334.501ZM160.397 334.954L160.777 331.224H164.606V332.103H161.583L161.357 334.142C161.723 333.926 162.138 333.818 162.604 333.818C163.285 333.818 163.826 334.045 164.226 334.496C164.626 334.945 164.826 335.553 164.826 336.32C164.826 337.091 164.618 337.699 164.2 338.144C163.786 338.585 163.206 338.806 162.46 338.806C161.8 338.806 161.262 338.624 160.844 338.257C160.427 337.89 160.189 337.383 160.13 336.736H161.029C161.086 337.165 161.239 337.488 161.485 337.707C161.731 337.923 162.057 338.031 162.46 338.031C162.902 338.031 163.247 337.88 163.497 337.579C163.75 337.278 163.877 336.861 163.877 336.33C163.877 335.83 163.74 335.429 163.466 335.128C163.196 334.824 162.835 334.671 162.383 334.671C161.969 334.671 161.645 334.762 161.408 334.943L161.157 335.149L160.397 334.954ZM170.759 338.704H165.863V338.021L168.45 335.144C168.833 334.709 169.097 334.356 169.24 334.086C169.387 333.812 169.461 333.529 169.461 333.238C169.461 332.847 169.343 332.527 169.106 332.277C168.871 332.027 168.556 331.902 168.162 331.902C167.69 331.902 167.322 332.037 167.059 332.308C166.799 332.575 166.669 332.948 166.669 333.428H165.719C165.719 332.739 165.94 332.183 166.382 331.758C166.826 331.333 167.42 331.122 168.162 331.122C168.857 331.122 169.406 331.304 169.81 331.671C170.214 332.034 170.415 332.518 170.415 333.125C170.415 333.861 169.947 334.738 169.009 335.755L167.008 337.928H170.759V338.704ZM175.06 337.446L176.948 333.145H178.134V338.704H177.185V334.661L175.388 338.704H174.731L172.899 334.573V338.704H171.95V333.145H173.182L175.06 337.446Z" fill="white"/>
<path d="M5.77839 362.83H3.37665V369.498H2.3965V362.83H0V362.018H5.77839V362.83ZM8.52954 369.6C7.77684 369.6 7.16406 369.354 6.69195 368.861C6.21983 368.364 5.98414 367.702 5.98414 366.873V366.698C5.98414 366.146 6.08814 365.655 6.29689 365.224C6.50938 364.789 6.80343 364.45 7.17978 364.207C7.55986 363.96 7.96988 363.837 8.41132 363.837C9.13334 363.837 9.69449 364.075 10.0948 364.55C10.4951 365.027 10.6956 365.708 10.6956 366.595V366.991H6.93362C6.94708 367.539 7.10645 367.982 7.41097 368.321C7.71848 368.657 8.1083 368.825 8.58116 368.825C8.91636 368.825 9.19993 368.756 9.43262 368.619C9.66531 368.482 9.86882 368.301 10.0432 368.075L10.6238 368.527C10.1584 369.242 9.4603 369.6 8.52954 369.6ZM8.41132 364.618C8.02824 364.618 7.70651 364.758 7.44688 365.039C7.18651 365.316 7.02564 365.707 6.96429 366.21H9.74612V366.138C9.71844 365.655 9.58825 365.282 9.35556 365.019C9.12286 364.751 8.80862 364.618 8.41132 364.618ZM13.5283 367.13H12.8355V369.498H11.8807V363.939H12.8355V366.292H13.4565L15.3247 363.939H16.474L14.2772 366.611L16.6588 369.498H15.4527L13.5283 367.13ZM19.2917 368.106L20.5854 363.939H21.6014L19.3688 370.356C19.0231 371.28 18.4739 371.743 17.7212 371.743L17.5417 371.727L17.1878 371.661V370.89L17.4444 370.91C17.7661 370.91 18.0153 370.845 18.1934 370.716C18.3752 370.585 18.5233 370.347 18.64 370.001L18.8503 369.436L16.869 363.939H17.906L19.2917 368.106ZM23.4338 363.939V368.722H25.4659V363.939H26.4154V368.722H28.4423V363.939H29.397V368.722H30.1774L30.0846 371.147H29.2331V369.498H22.4791V363.939H23.4338ZM34.7399 363.939H35.6894V369.498H34.7399V365.445L32.1788 369.498H31.2293V363.939H32.1788V367.998L34.7399 363.939ZM40.8064 363.939H41.7558V369.498H40.8064V365.445L38.2452 369.498H37.2958V363.939H38.2452V367.998L40.8064 363.939ZM41.063 361.916C41.063 362.33 40.9208 362.664 40.6365 362.917C40.3559 363.167 39.9863 363.292 39.5284 363.292C39.0698 363.292 38.6987 363.166 38.4143 362.912C38.1308 362.659 37.9886 362.326 37.9886 361.916H38.7638C38.7638 362.155 38.8281 362.343 38.9583 362.48C39.0885 362.614 39.2785 362.681 39.5284 362.681C39.7678 362.681 39.9541 362.614 40.0873 362.48C40.2242 362.347 40.2931 362.158 40.2931 361.916H41.063ZM48.9408 365.46C48.9408 365.2 48.8413 364.995 48.6431 364.843C48.4448 364.69 48.1724 364.613 47.8268 364.613C47.4916 364.613 47.211 364.699 46.985 364.875C46.7628 365.049 46.6513 365.254 46.6513 365.491H45.7071C45.7071 365.008 45.9091 364.613 46.3131 364.304C46.7164 363.996 47.2215 363.842 47.8268 363.842C48.477 363.842 48.9835 363.982 49.3464 364.263C49.7085 364.541 49.8903 364.938 49.8903 365.455C49.8903 365.705 49.8147 365.934 49.6644 366.143C49.514 366.352 49.3 366.519 49.0224 366.641C49.6696 366.861 49.9928 367.292 49.9928 367.936C49.9928 368.446 49.796 368.851 49.4025 369.149C49.0089 369.446 48.4837 369.595 47.8268 369.595C47.187 369.595 46.6588 369.439 46.2413 369.128C45.8268 368.813 45.6203 368.388 45.6203 367.854H46.5645C46.5645 368.124 46.6842 368.357 46.9237 368.553C47.1668 368.744 47.4676 368.84 47.8268 368.84C48.1896 368.84 48.4822 368.756 48.7044 368.589C48.9266 368.421 49.0381 368.203 49.0381 367.936C49.0381 367.625 48.9438 367.402 48.756 367.268C48.5712 367.131 48.2817 367.063 47.8889 367.063H46.9394V366.262H47.9704C48.6176 366.245 48.9408 365.977 48.9408 365.46ZM54.6526 369.498C54.598 369.389 54.5539 369.193 54.5195 368.912C54.078 369.371 53.5513 369.6 52.9385 369.6C52.3908 369.6 51.9411 369.446 51.5887 369.138C51.2401 368.827 51.065 368.433 51.065 367.957C51.065 367.378 51.2842 366.929 51.7219 366.611C52.1634 366.289 52.7829 366.128 53.5805 366.128H54.5037V365.691C54.5037 365.359 54.405 365.096 54.206 364.9C54.0077 364.702 53.7151 364.602 53.3283 364.602C52.9901 364.602 52.7058 364.687 52.4769 364.859C52.2472 365.031 52.1327 365.237 52.1327 365.481H51.178C51.178 365.204 51.276 364.936 51.4705 364.679C51.6695 364.419 51.9359 364.213 52.2711 364.063C52.61 363.912 52.9811 363.837 53.3852 363.837C54.0249 363.837 54.5262 363.998 54.8891 364.32C55.2512 364.638 55.4397 365.078 55.4532 365.64V368.198C55.4532 368.708 55.5183 369.114 55.6485 369.415V369.498H54.6526ZM53.0769 368.774C53.3747 368.774 53.6568 368.697 53.9239 368.542C54.191 368.388 54.384 368.188 54.5037 367.942V366.801H53.76C52.5966 366.801 52.0145 367.142 52.0145 367.823C52.0145 368.121 52.114 368.354 52.3122 368.522C52.5113 368.69 52.7657 368.774 53.0769 368.774ZM59.3798 364.258C60.0779 364.258 60.6353 364.493 61.0528 364.962C61.4733 365.427 61.6843 366.042 61.6843 366.806V366.893C61.6843 367.417 61.5833 367.886 61.3812 368.301C61.1792 368.712 60.8882 369.032 60.5088 369.261C60.1325 369.487 59.6978 369.6 59.2047 369.6C58.4595 369.6 57.8587 369.353 57.4038 368.856C56.9489 368.356 56.7207 367.686 56.7207 366.847V366.385C56.7207 365.217 56.9369 364.289 57.3679 363.6C57.8026 362.912 58.4423 362.492 59.287 362.342C59.7659 362.256 60.0898 362.152 60.2574 362.028C60.425 361.905 60.5088 361.735 60.5088 361.52H61.2885C61.2885 361.948 61.1912 362.282 60.9959 362.522C60.8044 362.761 60.4969 362.931 60.0726 363.03L59.3641 363.19C58.7999 363.323 58.3757 363.549 58.0914 363.867C57.8108 364.183 57.6275 364.604 57.5422 365.132C58.045 364.549 58.6578 364.258 59.3798 364.258ZM59.195 365.039C58.7296 365.039 58.36 365.196 58.0862 365.511C57.8123 365.823 57.6754 366.257 57.6754 366.811V366.893C57.6754 367.489 57.8123 367.962 58.0862 368.311C58.363 368.657 58.7363 368.83 59.2047 368.83C59.6768 368.83 60.0502 368.655 60.324 368.306C60.5979 367.957 60.7348 367.447 60.7348 366.776C60.7348 366.251 60.5956 365.832 60.3188 365.517C60.0449 365.198 59.6701 365.039 59.195 365.039ZM62.4998 366.667C62.4998 366.122 62.6061 365.633 62.8178 365.198C63.034 364.763 63.3311 364.428 63.7112 364.191C64.0942 363.955 64.5304 363.837 65.0198 363.837C65.7762 363.837 66.3867 364.099 66.8521 364.622C67.3205 365.147 67.5554 365.844 67.5554 366.713V366.78C67.5554 367.321 67.4507 367.808 67.2419 368.239C67.0369 368.667 66.7406 369.001 66.3546 369.241C65.9707 369.481 65.5293 369.6 65.0302 369.6C64.2775 369.6 63.667 369.338 63.1979 368.815C62.7325 368.291 62.4998 367.597 62.4998 366.734V366.667ZM63.4545 366.78C63.4545 367.397 63.5967 367.891 63.8802 368.265C64.1676 368.638 64.5514 368.825 65.0302 368.825C65.5128 368.825 65.8959 368.637 66.1795 368.26C66.4638 367.879 66.606 367.348 66.606 366.667C66.606 366.058 66.4601 365.564 66.1698 365.188C65.8817 364.807 65.4986 364.618 65.0198 364.618C64.5514 364.618 64.1728 364.804 63.8855 365.177C63.5982 365.551 63.4545 366.085 63.4545 366.78ZM72.3387 363.939H73.2882V369.498H72.3387V365.445L69.7776 369.498H68.8281V363.939H69.7776V367.998L72.3387 363.939ZM72.5953 361.916C72.5953 362.33 72.4532 362.664 72.1689 362.917C71.8883 363.167 71.5187 363.292 71.0608 363.292C70.6021 363.292 70.231 363.166 69.9467 362.912C69.6631 362.659 69.521 362.326 69.521 361.916H70.2961C70.2961 362.155 70.3605 362.343 70.4906 362.48C70.6208 362.614 70.8109 362.681 71.0608 362.681C71.3002 362.681 71.4865 362.614 71.6197 362.48C71.7566 362.347 71.8254 362.158 71.8254 361.916H72.5953ZM74.7816 369C74.7816 368.835 74.8295 368.698 74.9252 368.589C75.024 368.479 75.1714 368.424 75.3667 368.424C75.5612 368.424 75.7086 368.479 75.8081 368.589C75.9106 368.698 75.9615 368.835 75.9615 369C75.9615 369.157 75.9106 369.289 75.8081 369.395C75.7086 369.502 75.5612 369.554 75.3667 369.554C75.1714 369.554 75.024 369.502 74.9252 369.395C74.8295 369.289 74.7816 369.157 74.7816 369ZM74.7861 364.464C74.7861 364.299 74.8347 364.162 74.9305 364.052C75.0293 363.943 75.1766 363.888 75.3712 363.888C75.5665 363.888 75.7139 363.943 75.8126 364.052C75.9159 364.162 75.9668 364.299 75.9668 364.464C75.9668 364.621 75.9159 364.753 75.8126 364.859C75.7139 364.965 75.5665 365.019 75.3712 365.019C75.1766 365.019 75.0293 364.965 74.9305 364.859C74.8347 364.753 74.7861 364.621 74.7861 364.464ZM82.9879 369.498H82.0332V363.163L80.1185 363.867V363.005L82.839 361.982H82.9879V369.498ZM87.1502 365.296H87.8632C88.3114 365.289 88.6638 365.171 88.9204 364.941C89.1771 364.711 89.3057 364.402 89.3057 364.011C89.3057 363.135 88.8695 362.696 87.9971 362.696C87.5864 362.696 87.2579 362.814 87.0117 363.05C86.7686 363.283 86.6474 363.593 86.6474 363.981H85.6979C85.6979 363.388 85.9134 362.897 86.3444 362.506C86.7791 362.113 87.3297 361.916 87.9971 361.916C88.702 361.916 89.2541 362.102 89.6544 362.475C90.0547 362.849 90.2552 363.367 90.2552 364.032C90.2552 364.357 90.149 364.673 89.9365 364.977C89.7277 365.282 89.4427 365.51 89.0798 365.66C89.4906 365.791 89.8071 366.006 90.0293 366.307C90.2552 366.609 90.3682 366.977 90.3682 367.412C90.3682 368.083 90.149 368.616 89.7113 369.01C89.2728 369.404 88.7034 369.6 88.0016 369.6C87.3006 369.6 86.7289 369.41 86.2875 369.031C85.8498 368.65 85.6306 368.148 85.6306 367.525H86.5853C86.5853 367.919 86.714 368.234 86.9706 368.47C87.2272 368.707 87.5707 368.825 88.0016 368.825C88.4603 368.825 88.8112 368.705 89.0544 368.465C89.2968 368.225 89.4187 367.882 89.4187 367.433C89.4187 366.998 89.2848 366.664 89.0184 366.431C88.7513 366.198 88.366 366.078 87.8632 366.072H87.1502V365.296ZM95.3976 362.013V362.82H95.2233C94.4841 362.833 93.8952 363.053 93.4575 363.477C93.0198 363.902 92.7662 364.5 92.6981 365.27C93.0917 364.818 93.6289 364.592 94.3097 364.592C94.9592 364.592 95.4777 364.822 95.8645 365.28C96.2543 365.739 96.4496 366.331 96.4496 367.058C96.4496 367.829 96.2394 368.445 95.8181 368.907C95.4006 369.37 94.8395 369.6 94.1347 369.6C93.4201 369.6 92.8395 369.326 92.3951 368.779C91.9507 368.227 91.7277 367.518 91.7277 366.652V366.287C91.7277 364.911 92.0202 363.859 92.6053 363.133C93.1942 362.403 94.0681 362.03 95.2278 362.013H95.3976ZM94.1504 365.383C93.8249 365.383 93.5256 365.481 93.2525 365.676C92.9787 365.871 92.7886 366.116 92.6824 366.411V366.76C92.6824 367.376 92.8208 367.873 93.0984 368.249C93.3752 368.626 93.7209 368.815 94.1347 368.815C94.5626 368.815 94.8978 368.657 95.141 368.342C95.3872 368.027 95.5106 367.614 95.5106 367.104C95.5106 366.591 95.3857 366.176 95.1358 365.861C94.8896 365.542 94.5611 365.383 94.1504 365.383ZM101.212 366.21C101.014 366.447 100.776 366.636 100.499 366.78C100.225 366.924 99.9243 366.996 99.5958 366.996C99.1648 366.996 98.7878 366.89 98.4668 366.677C98.148 366.465 97.9019 366.167 97.7275 365.784C97.5532 365.397 97.4657 364.971 97.4657 364.505C97.4657 364.004 97.56 363.554 97.7477 363.154C97.9393 362.753 98.2101 362.446 98.5588 362.234C98.9082 362.021 99.3152 361.916 99.7806 361.916C100.519 361.916 101.101 362.193 101.525 362.748C101.953 363.299 102.167 364.052 102.167 365.008V365.285C102.167 366.741 101.879 367.805 101.305 368.476C100.73 369.144 99.8622 369.486 98.7025 369.503H98.5176V368.702H98.7182C99.5015 368.688 100.104 368.484 100.524 368.091C100.946 367.693 101.175 367.066 101.212 366.21ZM99.7492 366.21C100.068 366.21 100.36 366.113 100.627 365.917C100.898 365.722 101.094 365.481 101.217 365.193V364.813C101.217 364.189 101.083 363.682 100.812 363.292C100.542 362.902 100.2 362.707 99.7859 362.707C99.3684 362.707 99.0324 362.868 98.7795 363.19C98.5266 363.508 98.3994 363.929 98.3994 364.453C98.3994 364.963 98.5214 365.385 98.7638 365.717C99.0107 366.046 99.3392 366.21 99.7492 366.21ZM106.77 368.239L108.659 363.939H109.845V369.498H108.895V365.455L107.099 369.498H106.442L104.61 365.368V369.498H103.66V363.939H104.892L106.77 368.239Z" fill="white"/>
<ellipse cx="236" cy="36" rx="37" ry="21" fill="#913400"/>
<ellipse cx="236" cy="36" rx="37" ry="21" fill="#782B00"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M205.035 30.8553L230.465 30.7528C230.469 30.7528 230.472 30.7563 230.472 30.7607C230.472 30.7607 230.472 30.7607 230.472 30.7607V35.4741C230.472 35.4784 230.469 35.482 230.465 35.482H201.18C201.175 35.482 201.172 35.4784 201.172 35.4741V13.4205C201.172 13.4161 201.175 13.4126 201.18 13.4126H205.019C205.024 13.4126 205.027 13.4161 205.027 13.4205V30.8474C205.027 30.8518 205.031 30.8553 205.035 30.8553C205.035 30.8553 205.035 30.8553 205.035 30.8553Z" fill="url(#pattern0)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M205.035 30.856L230.471 30.7535C230.472 30.7535 230.473 30.7533 230.474 30.7531L231.584 30.3747C231.588 30.3734 231.59 30.3689 231.589 30.3648C231.588 30.3616 231.585 30.3594 231.582 30.3594H206.192C206.187 30.3594 206.184 30.3559 206.184 30.3515V13.0301C206.184 13.0257 206.18 13.0222 206.176 13.0222C206.175 13.0222 206.175 13.0224 206.174 13.0226L205.033 13.4115C205.029 13.4125 205.027 13.4155 205.027 13.4189V30.8481C205.027 30.8525 205.031 30.856 205.035 30.856C205.035 30.856 205.035 30.856 205.035 30.856Z" fill="url(#pattern1)" stroke="#2B2B2A" stroke-width="0.3"/>
<path d="M205.027 30.7531L206.184 30.3594" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M205.03 13.4126L206.14 13.0346C206.144 13.0333 206.146 13.0288 206.145 13.0247C206.144 13.0215 206.141 13.0193 206.137 13.0193H202.331C202.33 13.0193 202.329 13.0194 202.328 13.0197L201.218 13.3977C201.214 13.399 201.212 13.4035 201.213 13.4076C201.214 13.4108 201.217 13.413 201.221 13.413H205.027C205.028 13.413 205.029 13.4129 205.03 13.4126Z" fill="url(#pattern2)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M235.473 12.629L195.008 12.6218C195.003 12.6218 195 12.6254 195 12.6297L194.999 15.7667C194.999 15.7711 195.003 15.7746 195.007 15.7746L235.473 15.7818C235.477 15.7818 235.48 15.7783 235.48 15.7739L235.481 12.6369C235.481 12.6326 235.477 12.629 235.473 12.629Z" fill="#CECECE" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M235.488 12.6236L236.629 12.235C236.633 12.2336 236.637 12.2358 236.639 12.24C236.639 12.2408 236.639 12.2416 236.639 12.2425L236.638 15.3786C236.638 15.382 236.636 15.385 236.633 15.3861L235.492 15.7747C235.488 15.7761 235.484 15.7739 235.482 15.7697C235.482 15.7689 235.482 15.7681 235.482 15.7673L235.482 12.6311C235.482 12.6277 235.484 12.6247 235.488 12.6236Z" fill="#CECECE" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M235.483 12.6252H195.051C195.046 12.6252 195.043 12.6216 195.043 12.6173C195.043 12.6139 195.045 12.6109 195.048 12.6098L196.159 12.2318C196.159 12.2316 196.16 12.2314 196.161 12.2314H236.593C236.597 12.2314 236.601 12.235 236.601 12.2393C236.601 12.2427 236.599 12.2457 236.596 12.2468L235.485 12.6248C235.484 12.625 235.484 12.6252 235.483 12.6252Z" fill="#CECECE" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M240.989 40.9562L244.69 39.4428C244.719 39.4309 244.738 39.4019 244.738 39.3697V36.3867C244.738 36.3431 244.704 36.3079 244.661 36.3079C244.651 36.3079 244.641 36.3098 244.632 36.3135L240.931 37.8268C240.902 37.8388 240.883 37.8678 240.883 37.9V40.883C240.883 40.9265 240.917 40.9618 240.96 40.9618C240.97 40.9618 240.979 40.9599 240.989 40.9562Z" fill="#D8D8D8" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M226.24 37.8477H240.875C240.879 37.8477 240.883 37.8512 240.883 37.8555V40.9925C240.883 40.9969 240.879 41.0004 240.875 41.0004H226.24C226.236 41.0004 226.232 40.9969 226.232 40.9925V37.8555C226.232 37.8512 226.236 37.8477 226.24 37.8477Z" fill="#B5B5B5" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M226.417 37.7716L230.079 36.2741C230.084 36.2722 230.089 36.2712 230.094 36.2712H244.536C244.558 36.2712 244.575 36.2889 244.575 36.3106C244.575 36.3268 244.565 36.3413 244.551 36.3472L240.888 37.8448C240.883 37.8467 240.879 37.8476 240.874 37.8476H226.431C226.41 37.8476 226.393 37.83 226.393 37.8082C226.393 37.7921 226.402 37.7776 226.417 37.7716Z" fill="#D8D8D8" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M229.448 26.8177L239.303 26.8123C239.325 26.8122 239.342 26.8299 239.342 26.8516C239.342 26.8516 239.342 26.8516 239.342 26.8516V37.4134C239.342 37.4352 239.325 37.4528 239.303 37.4528H229.357C229.336 37.4528 229.318 37.4352 229.318 37.4134C229.318 37.4133 229.318 37.4132 229.318 37.4131L229.409 26.8568C229.41 26.8352 229.427 26.8177 229.448 26.8177Z" fill="url(#pattern3)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M229.482 26.8181L239.34 26.8127C239.341 26.8127 239.341 26.8126 239.342 26.8125L241.192 26.4345C241.196 26.4337 241.199 26.4295 241.198 26.4253C241.198 26.4216 241.194 26.4189 241.191 26.4189H231.246C231.245 26.4189 231.245 26.419 231.244 26.4191L229.481 26.8026C229.477 26.8035 229.474 26.8076 229.475 26.8119C229.476 26.8155 229.479 26.8181 229.482 26.8181Z" fill="url(#pattern4)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M241.223 26.4287L239.373 26.8071C239.355 26.8108 239.342 26.8269 239.342 26.8457V37.3958C239.342 37.4176 239.359 37.4352 239.38 37.4352C239.385 37.4352 239.39 37.4342 239.395 37.4324L241.245 36.6757C241.26 36.6697 241.269 36.6552 241.269 36.6391V26.4674C241.269 26.4456 241.252 26.428 241.231 26.428C241.228 26.428 241.226 26.4282 241.223 26.4287Z" fill="url(#pattern5)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M240.989 29.922L244.69 28.4087C244.719 28.3967 244.738 28.3677 244.738 28.3355V25.3525C244.738 25.309 244.704 25.2737 244.661 25.2737C244.651 25.2737 244.641 25.2756 244.632 25.2793L240.931 26.7926C240.902 26.8046 240.883 26.8336 240.883 26.8658V29.8488C240.883 29.8923 240.917 29.9276 240.96 29.9276C240.97 29.9276 240.979 29.9257 240.989 29.922Z" fill="#D8D8D8" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M226.232 26.8132H240.883V29.966H226.232V26.8132Z" fill="#B5B5B5" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M226.417 26.737L230.079 25.2394C230.084 25.2375 230.089 25.2366 230.094 25.2366H244.536C244.558 25.2366 244.575 25.2542 244.575 25.276C244.575 25.2921 244.565 25.3066 244.551 25.3126L240.888 26.8101C240.883 26.812 240.879 26.813 240.874 26.813H226.431C226.41 26.813 226.393 26.7953 226.393 26.7735C226.393 26.7574 226.402 26.7429 226.417 26.737Z" fill="#D8D8D8" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.281 10.2605H233.181C233.177 10.2605 233.173 10.264 233.173 10.2684L233.143 26.4105C233.143 26.4149 233.146 26.4184 233.15 26.4184C233.15 26.4184 233.15 26.4184 233.15 26.4184H236.25C236.254 26.4184 236.258 26.4149 236.258 26.4106L236.288 10.2684C236.288 10.264 236.285 10.2605 236.281 10.2605C236.281 10.2605 236.281 10.2605 236.281 10.2605Z" fill="url(#pattern6)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.291 10.2585L237.209 9.87096C237.213 9.8693 237.217 9.87121 237.219 9.87524C237.219 9.87619 237.22 9.87721 237.22 9.87825V26.0191C237.22 26.0223 237.218 26.0252 237.215 26.0264L236.266 26.4142C236.262 26.4158 236.258 26.4138 236.256 26.4098C236.256 26.4088 236.256 26.4078 236.256 26.4068L236.287 10.2658C236.287 10.2626 236.289 10.2598 236.291 10.2585Z" fill="url(#pattern7)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.26 10.2601L237.186 9.88213C237.19 9.88051 237.191 9.87593 237.19 9.87189C237.189 9.8689 237.186 9.86694 237.183 9.86694H234.14C234.139 9.86694 234.138 9.86713 234.137 9.86751L233.212 10.2455C233.208 10.2471 233.206 10.2517 233.208 10.2557C233.209 10.2587 233.212 10.2607 233.215 10.2607H236.257C236.258 10.2607 236.259 10.2605 236.26 10.2601Z" fill="url(#pattern8)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.547 5.53282L230.484 5.53227C230.48 5.53227 230.477 5.5358 230.477 5.54015L230.475 11.8299C230.475 11.8343 230.479 11.8378 230.483 11.8378C230.483 11.8378 230.483 11.8378 230.483 11.8378L236.546 11.8384C236.55 11.8384 236.553 11.8348 236.553 11.8305L236.554 5.5407C236.554 5.53635 236.551 5.53282 236.547 5.53282C236.547 5.53282 236.547 5.53282 236.547 5.53282Z" fill="url(#pattern9)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.555 5.53032L239.714 4.2755C239.718 4.27393 239.722 4.27594 239.724 4.28C239.724 4.28091 239.725 4.28187 239.725 4.28285L239.723 10.5715C239.723 10.5747 239.721 10.5776 239.719 10.5788L236.56 11.8336C236.556 11.8352 236.552 11.8332 236.55 11.8291C236.55 11.8282 236.549 11.8273 236.549 11.8263L236.551 5.53766C236.551 5.53441 236.553 5.53149 236.555 5.53032Z" fill="url(#pattern10)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.547 5.53157L239.682 4.28622C239.686 4.28465 239.688 4.28008 239.687 4.27602C239.685 4.27299 239.682 4.271 239.679 4.271H233.553C233.552 4.271 233.551 4.27119 233.551 4.27156L230.505 5.5169C230.501 5.51852 230.499 5.52311 230.501 5.52715C230.502 5.53014 230.505 5.5321 230.508 5.5321H236.545C236.545 5.5321 236.546 5.53192 236.547 5.53157Z" fill="url(#pattern11)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.281 1.39233H233.181C233.177 1.39233 233.173 1.39582 233.173 1.40015L233.143 4.93124C233.143 4.9356 233.146 4.93916 233.15 4.9392C233.15 4.9392 233.15 4.9392 233.15 4.9392H236.25C236.254 4.9392 236.258 4.93571 236.258 4.93139L236.288 1.40029C236.288 1.39593 236.285 1.39237 236.281 1.39233C236.281 1.39233 236.281 1.39233 236.281 1.39233Z" fill="url(#pattern12)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.293 1.39162L237.211 1.00402C237.215 1.00236 237.219 1.00427 237.221 1.00829C237.221 1.00925 237.222 1.01027 237.222 1.0113V4.54104C237.222 4.54427 237.22 4.54716 237.217 4.54836L236.268 4.93611C236.264 4.93773 236.26 4.93576 236.258 4.93172C236.258 4.93077 236.258 4.92975 236.258 4.92872L236.289 1.39883C236.289 1.39567 236.29 1.39283 236.293 1.39162Z" fill="url(#pattern13)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M236.256 1.39315L237.182 1.01519C237.186 1.01357 237.188 1.00899 237.186 1.00495C237.185 1.00196 237.182 1 237.179 1H234.136C234.135 1 234.134 1.00019 234.133 1.00056L233.208 1.37853C233.204 1.38014 233.202 1.38473 233.204 1.38877C233.205 1.39175 233.208 1.39372 233.211 1.39372H236.254C236.255 1.39372 236.256 1.39352 236.256 1.39315Z" fill="url(#pattern14)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M257.837 30.7529H240.889C240.884 30.7529 240.881 30.7565 240.881 30.7608V35.4742C240.881 35.4786 240.884 35.4821 240.889 35.4821H257.837C257.841 35.4821 257.844 35.4786 257.844 35.4742V30.7608C257.844 30.7565 257.841 30.7529 257.837 30.7529Z" fill="url(#pattern15)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M257.837 30.7529H240.889C240.884 30.7529 240.881 30.7565 240.881 30.7608V35.4742C240.881 35.4786 240.884 35.4821 240.889 35.4821H257.837C257.841 35.4821 257.844 35.4786 257.844 35.4742V30.7608C257.844 30.7565 257.841 30.7529 257.837 30.7529Z" fill="black" fill-opacity="0.28" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M257.849 30.7518L258.99 30.363C258.994 30.3616 258.999 30.3638 259 30.3679C259 30.3687 259 30.3696 259 30.3704V35.083C259 35.0864 258.998 35.0894 258.995 35.0904L257.854 35.4793C257.85 35.4807 257.845 35.4784 257.844 35.4743C257.844 35.4735 257.844 35.4727 257.844 35.4718V30.7593C257.844 30.7559 257.846 30.7529 257.849 30.7518Z" fill="url(#pattern16)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M257.846 30.7529L258.956 30.375C258.96 30.3736 258.962 30.3691 258.961 30.365C258.96 30.3618 258.957 30.3596 258.954 30.3596H241.654C241.653 30.3596 241.652 30.3599 241.651 30.3605L240.911 30.7384C240.907 30.7404 240.905 30.7451 240.907 30.749C240.908 30.7516 240.911 30.7533 240.914 30.7533H257.843C257.844 30.7533 257.845 30.7532 257.846 30.7529Z" fill="url(#pattern17)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M248.198 26.0247H245.129C245.125 26.0247 245.121 26.0282 245.121 26.0325V30.7459C245.121 30.7503 245.125 30.7538 245.129 30.7538H248.198C248.202 30.7538 248.205 30.7503 248.205 30.7459V26.0325C248.205 26.0282 248.202 26.0247 248.198 26.0247Z" fill="url(#pattern18)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M248.21 26.0235L249.352 25.6347C249.356 25.6333 249.36 25.6355 249.361 25.6397C249.362 25.6405 249.362 25.6413 249.362 25.6422V30.3547C249.362 30.3581 249.36 30.3611 249.356 30.3622L248.215 30.751C248.211 30.7524 248.207 30.7502 248.205 30.746C248.205 30.7452 248.205 30.7444 248.205 30.7435V26.031C248.205 26.0276 248.207 26.0246 248.21 26.0235Z" fill="url(#pattern19)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M248.204 26.0239L249.314 25.646C249.318 25.6446 249.32 25.6401 249.319 25.636C249.318 25.6328 249.315 25.6306 249.312 25.6306H246.276C246.275 25.6306 246.275 25.6308 246.274 25.631L245.163 26.009C245.159 26.0104 245.157 26.0148 245.159 26.0189C245.16 26.0222 245.163 26.0243 245.166 26.0243H248.201C248.202 26.0243 248.203 26.0242 248.204 26.0239Z" fill="url(#pattern20)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M247.588 20.5068H246.048C246.047 20.5068 246.047 20.5072 246.047 20.5076V25.7869C246.047 25.7874 246.047 25.7877 246.048 25.7877H247.588C247.589 25.7877 247.589 25.7874 247.589 25.7869V20.5076C247.589 20.5072 247.589 20.5068 247.588 20.5068Z" fill="url(#pattern21)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M247.593 20.5054L247.963 20.3541C247.967 20.3525 247.971 20.3544 247.973 20.3585C247.973 20.3594 247.973 20.3604 247.973 20.3614V25.6253C247.973 25.6285 247.972 25.6314 247.969 25.6326L247.588 25.7883V20.5127C247.588 20.5095 247.59 20.5066 247.593 20.5054Z" fill="url(#pattern22)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M247.591 20.5063L247.938 20.3646C247.942 20.3629 247.944 20.3584 247.943 20.3543C247.941 20.3513 247.939 20.3494 247.935 20.3494H246.435C246.434 20.3494 246.433 20.3496 246.432 20.3499L246.085 20.4917C246.081 20.4933 246.079 20.4979 246.081 20.5019C246.082 20.5049 246.085 20.5069 246.088 20.5069H247.588C247.589 20.5069 247.59 20.5067 247.591 20.5063Z" fill="url(#pattern23)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M252.07 29.1763H252.834V30.595H252.062V29.1842C252.062 29.1798 252.066 29.1763 252.07 29.1763Z" fill="url(#pattern24)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M252.065 29.1777H252.832C252.832 29.1777 252.832 29.1777 252.832 29.1777L253.214 29.0218C253.214 29.0216 253.215 29.0212 253.215 29.0208C253.214 29.0205 253.214 29.0203 253.214 29.0203H252.447C252.447 29.0203 252.447 29.0203 252.447 29.0203L252.065 29.1762C252.065 29.1764 252.064 29.1769 252.065 29.1773C252.065 29.1776 252.065 29.1777 252.065 29.1777Z" fill="url(#pattern25)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M253.218 29.0208L252.834 29.1778C252.834 29.1779 252.834 29.1782 252.834 29.1785V30.5956C252.834 30.596 252.834 30.5964 252.835 30.5964C252.835 30.5964 252.835 30.5964 252.835 30.5963L253.219 30.4393C253.219 30.4392 253.22 30.4389 253.22 30.4386V29.0215C253.22 29.0211 253.219 29.0208 253.219 29.0208C253.219 29.0208 253.219 29.0208 253.218 29.0208Z" fill="url(#pattern26)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M252.07 28.3887H256.681C256.685 28.3887 256.689 28.3922 256.689 28.3965V29.1682C256.689 29.1726 256.685 29.1761 256.681 29.1761H252.07C252.066 29.1761 252.062 29.1726 252.062 29.1682V28.3965C252.062 28.3922 252.066 28.3887 252.07 28.3887Z" fill="url(#pattern27)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M252.067 28.3889H256.689C256.69 28.3889 256.69 28.3889 256.69 28.3889L257.071 28.233C257.072 28.2328 257.072 28.2323 257.072 28.2319C257.072 28.2316 257.071 28.2314 257.071 28.2314H252.449C252.449 28.2314 252.449 28.2315 252.449 28.2315L252.067 28.3874C252.066 28.3876 252.066 28.388 252.066 28.3884C252.067 28.3887 252.067 28.3889 252.067 28.3889Z" fill="url(#pattern28)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M257.072 28.232L256.688 28.3888C256.688 28.389 256.688 28.3893 256.688 28.3896V29.1753C256.688 29.1757 256.688 29.1761 256.688 29.1761C256.688 29.1761 256.688 29.1761 256.689 29.176L257.073 29.0192C257.073 29.0191 257.073 29.0188 257.073 29.0185V28.2327C257.073 28.2323 257.073 28.2319 257.072 28.2319C257.072 28.2319 257.072 28.232 257.072 28.232Z" fill="url(#pattern29)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M223.539 29.1772H224.302V30.596H223.531V29.1851C223.531 29.1808 223.535 29.1772 223.539 29.1772Z" fill="url(#pattern30)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M223.536 29.1777H224.303C224.303 29.1777 224.303 29.1777 224.303 29.1777L224.685 29.0218C224.685 29.0216 224.685 29.0212 224.685 29.0208C224.685 29.0205 224.685 29.0203 224.685 29.0203H223.918C223.918 29.0203 223.917 29.0203 223.917 29.0203L223.536 29.1762C223.535 29.1764 223.535 29.1769 223.535 29.1773C223.535 29.1776 223.536 29.1777 223.536 29.1777Z" fill="url(#pattern31)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M224.687 29.0208L224.303 29.1778C224.303 29.1779 224.303 29.1782 224.303 29.1785V30.5956C224.303 30.596 224.303 30.5964 224.304 30.5964C224.304 30.5964 224.304 30.5964 224.304 30.5963L224.688 30.4393C224.688 30.4392 224.688 30.4389 224.688 30.4386V29.0215C224.688 29.0211 224.688 29.0208 224.687 29.0208C224.687 29.0208 224.687 29.0208 224.687 29.0208Z" fill="url(#pattern32)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M219.682 28.3892H224.293C224.297 28.3892 224.3 28.3927 224.3 28.397V29.1687C224.3 29.1731 224.297 29.1766 224.293 29.1766H219.682C219.677 29.1766 219.674 29.1731 219.674 29.1687V28.397C219.674 28.3927 219.677 28.3892 219.682 28.3892Z" fill="url(#pattern33)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M219.679 28.3889H224.301C224.301 28.3889 224.301 28.3889 224.301 28.3889L224.683 28.233C224.683 28.2328 224.683 28.2323 224.683 28.2319C224.683 28.2316 224.683 28.2314 224.682 28.2314H220.06C220.06 28.2314 220.06 28.2315 220.06 28.2315L219.678 28.3874C219.678 28.3876 219.678 28.388 219.678 28.3884C219.678 28.3887 219.678 28.3889 219.679 28.3889Z" fill="url(#pattern34)" stroke="#2B2B2A" stroke-width="0.3"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M224.685 28.232L224.301 28.3888C224.301 28.389 224.301 28.3893 224.301 28.3896V29.1753C224.301 29.1757 224.301 29.1761 224.302 29.1761C224.302 29.1761 224.302 29.1761 224.302 29.176L224.686 29.0192C224.686 29.0191 224.686 29.0188 224.686 29.0185V28.2327C224.686 28.2323 224.686 28.2319 224.686 28.2319C224.685 28.2319 224.685 28.232 224.685 28.232Z" fill="url(#pattern35)" stroke="#2B2B2A" stroke-width="0.3"/>
<defs>
<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern1" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern2" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern3" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern4" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern5" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern6" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern7" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern8" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern9" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern10" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern11" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern12" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern13" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern14" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern15" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern16" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern17" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern18" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern19" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern20" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern21" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern22" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern23" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern24" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern25" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern26" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern27" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern28" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern29" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern30" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern31" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern32" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern33" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern34" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<pattern id="pattern35" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0" transform="scale(0.00159744 0.00239808)"/>
</pattern>
<linearGradient id="paint0_linear" x1="199.771" y1="263.622" x2="272.347" y2="263.622" gradientUnits="userSpaceOnUse">
<stop stop-color="#903400"/>
<stop offset="0.173015" stop-color="#C14600"/>
<stop offset="1" stop-color="#903400"/>
</linearGradient>
<linearGradient id="paint1_linear" x1="233.405" y1="219.409" x2="238.808" y2="219.409" gradientUnits="userSpaceOnUse">
<stop stop-color="#B5B5B5"/>
<stop offset="0.392862" stop-color="#F7F7F7"/>
<stop offset="1" stop-color="#B5B5B5"/>
</linearGradient>
<linearGradient id="paint2_linear" x1="243.223" y1="287.756" x2="229.039" y2="287.756" gradientUnits="userSpaceOnUse">
<stop stop-color="#016C36"/>
<stop offset="0.63431" stop-color="#349B67"/>
<stop offset="0.99961" stop-color="#016C36"/>
</linearGradient>
<linearGradient id="paint3_linear" x1="229.018" y1="271.792" x2="242.982" y2="271.792" gradientUnits="userSpaceOnUse">
<stop stop-color="#F5B500"/>
<stop offset="0.34963" stop-color="#FFD768"/>
<stop offset="1" stop-color="#F7B500"/>
</linearGradient>
<linearGradient id="paint4_linear" x1="229.004" y1="191.985" x2="243.22" y2="191.985" gradientUnits="userSpaceOnUse">
<stop stop-color="#0089D4"/>
<stop offset="0.350564" stop-color="#00BDEC"/>
<stop offset="1" stop-color="#0088D4"/>
</linearGradient>
<linearGradient id="paint5_linear" x1="232.383" y1="215.328" x2="239.604" y2="215.328" gradientUnits="userSpaceOnUse">
<stop stop-color="#B5B5B5"/>
<stop offset="0.335473" stop-color="#F7F7F7"/>
<stop offset="1" stop-color="#B5B5B5"/>
</linearGradient>
<linearGradient id="paint6_linear" x1="233.589" y1="206.078" x2="238.403" y2="206.078" gradientUnits="userSpaceOnUse">
<stop stop-color="#B5B5B5"/>
<stop offset="0.335473" stop-color="#F7F7F7"/>
<stop offset="1" stop-color="#B5B5B5"/>
</linearGradient>
<linearGradient id="paint7_linear" x1="232.383" y1="260.705" x2="239.604" y2="260.705" gradientUnits="userSpaceOnUse">
<stop stop-color="#B5B5B5"/>
<stop offset="0.335473" stop-color="#F7F7F7"/>
<stop offset="1" stop-color="#B5B5B5"/>
</linearGradient>
<linearGradient id="paint8_linear" x1="232.383" y1="101.066" x2="239.604" y2="101.066" gradientUnits="userSpaceOnUse">
<stop stop-color="#B5B5B5"/>
<stop offset="0.335473" stop-color="#F7F7F7"/>
<stop offset="1" stop-color="#B5B5B5"/>
</linearGradient>
<linearGradient id="paint9_linear" x1="232.383" y1="257.705" x2="239.604" y2="257.705" gradientUnits="userSpaceOnUse">
<stop stop-color="#B5B5B5"/>
<stop offset="0.335473" stop-color="#F7F7F7"/>
<stop offset="1" stop-color="#B5B5B5"/>
</linearGradient>
<linearGradient id="paint10_linear" x1="229.022" y1="272.17" x2="242.986" y2="272.17" gradientUnits="userSpaceOnUse">
<stop stop-color="#F5B500"/>
<stop offset="0.34963" stop-color="#FFD768"/>
<stop offset="1" stop-color="#F7B500"/>
</linearGradient>
<linearGradient id="paint11_linear" x1="199" y1="324" x2="273" y2="324" gradientUnits="userSpaceOnUse">
<stop/>
<stop offset="0.307292" stop-color="#5B5B5B"/>
<stop offset="1"/>
</linearGradient>
<image id="image0" width="626" height="417" xlink:href="data:image/png;base64,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"/>
</defs>
</svg>


              </div>

              <div class="block-gno-data col-6">
                <div class="row">
                  <div class="col-12">
                    <div class="col-12"
                      style="margin-left: -15px; background-color: #656a8a; width: 513px; max-width: 1000px; font-size: 20px; color: white; height: 50px; padding-top: 10px; font-weight: bold;">
                      Расчетный режим:
                    </div>

                    <div class="row">
                      <div class="col-6"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        Qж: {{qLInput}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                        Qн: {{qO}}
                      </div>

                      <div class="col-6"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        %обв: {{wctInput}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                        Рзаб: {{bhpInput}}
                      </div>

                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        Рпр: {{piCelValue}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">

                      </div>

                    </div>
                  </div>

                  <div class="col-12">

                    <!-- <h3 style="background-color: #656a8a; padding: 0; margin: 0; height: 50px; font-size: 20px; padding-top: 10px;">Компоновка ШГН</h3> -->
                    <div class="col-12"
                      style="margin-left: -15px; background-color: #656a8a; width: 513px; max-width: 1000px; font-size: 20px; color: white; height: 50px; padding-top: 10px; font-weight: bold;">
                      Компоновка ШГН
                    </div>
                    <div class="col-12"
                      style="margin-left: -15px; background-color: #c1c3d0; width: 513px; max-width: 1000px; font-size: 20px; color: black; height: 50px; padding-top: 10px;">
                      Диаметр насоса:
                    </div>
                    <div class="row">
                      <div class="col-6"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        Нсп: {{hPumpManomInput}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                        Тип СК: {{sk}}
                      </div>

                      <div class="col-6"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        Длина хода: {{strokeLenDev + ' м'}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                        Число качаний: {{spmDev + ' 1/мин'}}
                      </div>

                    </div>

                    <div class="col-12"
                      style="margin-left: -15px; background-color: #c1c3d0; width: 513px; max-width: 1000px; font-size: 20px; color: black; height: 50px; padding-top: 10px; font-weight: bold;">
                      Колонна штанг:
                    </div>
                    <div class="row">
                      <div class="col-4"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        Секция 1
                      </div>
                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        диаметр: {{shgnS1D + ' мм'}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                        длина: {{shgnS1L + ' м'}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black;  border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        Секция 2
                      </div>
                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        диаметр: {{shgnS2D + ' мм'}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                        длина: {{shgnS2L + ' м'}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        ТН
                      </div>
                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        диаметр: {{shgnS1D + ' мм'}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                        длина: {{shgnTNL + ' м'}}
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      
    </div>
    <notifications position="top"></notifications>
    <full-page-loader v-show="isLoading" />
  </div>
</template>

<script>
import { Plotly } from "vue-plotly";
import { eventBus } from "../../event-bus.js";
import NotifyPlugin from "vue-easy-notify";
import 'vue-easy-notify/dist/vue-easy-notify.css';
import { VueMomentLib }from "vue-moment-lib";
import moment from "moment";
import {PerfectScrollbar} from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
import Vue from 'vue';
import FullPageLoader from '../ui-kit/FullPageLoader';
import * as htmlToImage from 'html-to-image';
import { toPng, toJpeg, toBlob, toPixelData, toSvg } from 'html-to-image';
import jsPDF from 'jspdf';

Vue.prototype.$eventBus = new Vue();


Vue.use(NotifyPlugin,VueMomentLib);
Vue.component("Plotly", Plotly);


export default {
  components: { PerfectScrollbar, FullPageLoader },
  data: function () {
    return {
      isLoading: false,
      activeRightTabName: 'technological-mode',
      layout: {
        shapes: [{
          type: 'line',
          yref: 'paper',
          x0: 20,
          y0: 0,
          x1: 20,
          y1: 1,
          line: {
            color: 'orange',
            width: 1,
            dash: 'dot'
          }
        }],
        // width: 800,
        height: 360,
        showlegend: true,
        margin: {
          l: 50,
          r: 50,
          b: 80,
          t: 30
        },
        xaxis: {
          title: "Дебит жидкости, м³/сут.",
          hoverformat: ".1f",
          //  showline: true,
          zeroline: false,
          // showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          //tickfont: {size: 10},
        },
        yaxis: {
          title: "Давление, Pзаб, атм.",
          hoverformat: ".1f",
          showlegend: true,
          // showline: true,
          zeroline: false,
          //showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          //tickfont: {size: 10},
        },

        //   scene:{ gridcolor: '#ffffff',},
        paper_bgcolor: "#2B2E5E",
        plot_bgcolor: "#2B2E5E",
        font: { color: "#fff" },

        legend: {
          orientation: "h",
          y: -0.3,
          font: {
            size: 9.3,
            color: "#fff",
          },
        },
      },

      data: [
        {
          name: "IPR (кривая притока)",
          x: [0,1,3],
          y: [0,1,3],

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },
      ],
      bhpPot: null,
      qlPot: null,
      pinPot: null,
      visibleChart: true,
      stroke_len: null,
      qOil: null,
      shgnPumpType: null,
      shgnSPM: null,
      shgnLen: null,
      shgnS1D: null,
      shgnS2D: null,
      shgnS1L: null,
      shgnS2L: null,
      shgnTNL: null,
      hPerfND: null,
      type: String,
      required: true,
      wellNumber: null,
      age: false,
      horizon: null,
      x: null,
      y: null,
      wctOkr: null,
      expMeth: null,
      tseh: null,
      gu: null,
      casOD: null,
      casID: null,
      hPerf: null,
      udl: null,
      pumpType: null,
      hPumpSet: null,
      tubOD: null,
      tubID: null,
      stopDate: null,
      PBubblePoint: null,
      gor:null,
      tRes: null,
      viscOilRc: null,
      viscWaterRc: null,
      densOil: null,
      densWater: null,
      qO: null,
      wct: null,
      bhp: null,
      pRes: null,
      hDyn: null,
      pAnnular: null,
      whp: null,
      lineP: null,
      piInput: null,
      pplInput: null,
      pResInput: null,
      qLInput: null,
      wctInput: null,
      gorInput: null,
      bhpInput: null,
      hDynInput: null,
      pAnnularInput: null,
      pManomInput: null,
      hPumpManomInput: null,
      whpInput: null,
      hPumpValue: null,
      curveSelect: 'pi',
      curveValue: '',
      QhydCurveSelect: null,
      curr: null,
      expChoose: null,
      CelButton: 'ql',
      bhpCurveButton: '',
      qL: null,
      qlCelValue: null,
      bhpCelValue: null,
      piCelValue: null,
      expID: null,
      CelValue: null,
      analysisBox1: true,
      analysisBox2: true,
      analysisBox3: true,
      analysisBox4: true,
      analysisBox5: true,
      analysisBox6: true,
      analysisBox7: true,

      analysisBox8: true,
      shgnTubOD: null,
      menu: "MainMenu",
      ngdu: null,
      sk: null,
      grp_skin: false,
      newData: null,
      strokeLenDev: null,
      spmDev: null,
      expAnalysisData:{
        NNO1:null,
        NNO2:null,
        prs1:null,
        prs2:null,
        qoilEcn:null,
        qoilShgn:null,
        shgnParam:null,
        ecnParam:null,
        ecnNpv:null,
        shgnNpv:null,
        npvTable1:{},
        npvTable2:{},
        nno1:null,
        nno2:null,
      },

      qZhExpEcn:null,
      qOilExpEcn:null,
      qZhExpShgn:null,
      qOilExpShgn:null,
      param_eco:null,
      potMenu: false,

      field: "UZN",
      wellIncl: null,
      dataNNO:"2020-11-01",
      nearWells: [],
      windowWidth: null,

      wellOkr: null,
      piOkr: null,
      khOkr: null,
      skinOkr: null,
      presOkr: null,

    };

  },

  watch: {
    curveSelect(newVal) {
      if (newVal === 'pi') {
        this.QhydCurveSelect = null;
      } else {
        this.QhydCurveSelect = 'hdyn';
      }
    },
    QhydCurveSelect(newVal) {
      if (newVal === 'hdyn') {
        this.curveSelect = 'hdyn';
      }
    },
  },

  computed: {
    getOnPgnoButtonTitle() {
      if (this.visibleChart) {
        return 'Подбор ГНО'
      } else {
        return 'Кривая притока'
      }
    }
  },
  created() {
    window.addEventListener("resize", () => {
      this.windowWidth = window.innerWidth;
    });
  },
  mounted() {
    this.windowWidth = window.innerWidth;

    if (this.windowWidth <= 1300 && this.windowWidth > 991) {
      this.activeRightTabName = 'devices';
    }
  },
  methods: {
    closeModal(modalName) {
      this.$modal.hide(modalName)
    },
    closeEconomicModal() {
      this.$modal.hide('tablePGNO')
      this.$modal.show('modalExpAnalysis')
    },
    setData: function(data) {
      if (this.method == "CurveSetting") {
        this.pResInput = data["Well Data"]["p_res"][0] + ' атм'
        this.piInput = data["Well Data"]["pi"][0].toFixed(2) + ' м³/сут/ат'
        this.qLInput = data["Well Data"]["q_l"][0].toFixed(0) + ' м³/сут'
        this.wctInput = data["Well Data"]["wct"][0] + ' %'
        this.hPumpValue = data["Well Data"]["h_pump_set"][0].toFixed(0) + ' м'
        this.gorInput = data["Well Data"]["gor"][0] + ' м³/т'
        this.bhpInput = data["Well Data"]["bhp"][0].toFixed(0) + ' атм'
        this.hDynInput = data["Well Data"]["h_dyn"][0].toFixed(0) + ' м'
        this.pAnnularInput = data["Well Data"]["p_annular"][0].toFixed(0) + ' атм'
        this.qlCelValue = JSON.parse(data.PointsData)["data"][2]["q_l"].toFixed(0) + ' м³/сут'
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][2]["p"].toFixed(0) + ' атм'
        this.piCelValue = JSON.parse(data.PointsData)["data"][2]["pin"].toFixed(0) + ' атм'
        this.whpInput = data["Well Data"]["whp"][0].toFixed(0) + ' атм'
        this.pManomInput = data["Well Data"]["p_intake"][0] + ' атм'
        if(this.curveSelect == 'pmanom') {
          this.hPumpManomInput = data["Well Data"]["h_pump_point"][0] + ' м'
        }
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.qOil = this.curvePointsData[2]["q_oil"].toFixed(0)
        this.bhpPot = this.curvePointsData[1]["p"].toFixed(0)
        this.qlPot = this.curvePointsData[1]["q_l"].toFixed(0)
        this.pinPot = this.curvePointsData[1]["pin"].toFixed(0)
      } else {
        this.ngdu = data["Well Data"]["ngdu"][0]
        this.sk = data["Well Data"]["sk_type"][0]
        this.wellNumber = data["Well Data"]["well"][0].split("_")[1]
        this.age = data["Age"]
        this.horizon = data["Well Data"]["horizon"][0]
        this.expMeth = data["Well Data"]["exp_meth"][0]
        this.tseh = data["Well Data"]["tseh"][0]
        this.gu = data["Well Data"]["gu"][0]
        this.stroke_len = data["Well Data"]["stroke_len"][0]
        this.casOD = data["Well Data"]["cas_OD"][0]
        this.casID = data["Well Data"]["cas_ID"][0]
        this.hPerf = data["Well Data"]["h_up_perf_vd"][0]
        this.udl = data["udl"].toFixed(1)
        this.hPumpSet = data["Well Data"]["h_pump_set"][0]
        this.tubOD = data["Well Data"]["tub_OD"][0]
        this.tubID = data["Well Data"]["tub_ID"][0]
        this.stopDate = data["Well Data"]["stop_date"][0]
        this.pumpType = data["Well Data"]["pump_type"][0]
        this.PBubblePoint = data["Well Data"]["P_bubble_point"][0].toFixed(2)
        this.gor = data["Well Data"]["gor"][0].toFixed(0)
        this.tRes = data["Well Data"]["t_res"][0].toFixed(2)
        this.viscOilRc = data["Well Data"]["visc_oil_rc"][0].toFixed(2)
        this.viscWaterRc = data["Well Data"]["visc_wat_rc"][0].toFixed(2)
        this.densOil = data["Well Data"]["dens_oil"][0].toFixed(2)
        this.densWater = data["Well Data"]["dens_liq"][0].toFixed(2)
        this.qL = data["Well Data"]["q_l"][0].toFixed(0)
        this.qO = data["Well Data"]["q_o"][0].toFixed(0)
        this.wct = data["Well Data"]["wct"][0].toFixed(0)
        this.bhp = data["Well Data"]["bhp"][0].toFixed(0)
        this.pRes = data["Well Data"]["p_res"][0].toFixed(0)
        this.hDyn = data["Well Data"]["h_dyn"][0].toFixed(0)
        this.pAnnular = data["Well Data"]["p_annular"][0].toFixed(0)
        this.whp = data["Well Data"]["whp"][0].toFixed(0)
        this.lineP = data["Well Data"]["line_p"][0].toFixed(0)
        this.piInput = data["Well Data"]["pi"][0].toFixed(2) + ' м³/сут/ат'
        this.curr = data["Well Data"]["curr_bh"][0].toFixed(0)
        this.piCelValue = JSON.parse(data.PointsData)["data"][0]["pin"].toFixed(0) + ' атм'
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][0]["p"].toFixed(0) + ' атм'
        this.wellIncl = data["Well Data"]["well"][0]
        this.hPerfND = data["Well Data"]["h_perf"][0]
        this.strokeLenDev = data["Well Data"]["stroke_len"][0]
        this.spmDev = data["Well Data"]["spm"][0]


        this.stopDate = this.stopDate.substring(0, 10)
        this.pResInput = this.pRes + ' атм'
        this.qLInput = this.qL  + ' м³/сут'
        this.wctInput = this.wct + ' %'
        this.gorInput = this.gor + ' м³/т'
        this.bhpInput = this.bhp + ' атм'
        this.hDynInput = this.hDyn + ' м'
        this.pAnnularInput = this.pAnnular + ' атм'
        this.pManomInput = data["Well Data"]["p_intake"][0] + ' атм'
        this.hPumpManomInput = data["Well Data"]["h_pump_set"][0] + ' м'
        this.whpInput = this.whp + ' атм'
        this.qlCelButton = true
        this.qlCelValue = this.qLInput
        this.hPumpValue = this.hPumpSet + ' м'


        if (this.expMeth == "ШГН") {
          this.expChoose = "ШГН"
        } else {
          this.expChoose = "ЭЦН"
        }
        if (this.age === true) {
          this.curveSelect = 'pi'
        } else {
          this.curveSelect = 'hdyn'
        }

        this.piButton = true
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.qOil = this.curvePointsData[2]["q_oil"].toFixed(0)
        this.bhpPot = this.curvePointsData[1]["p"].toFixed(0)
        this.qlPot = this.curvePointsData[1]["q_l"].toFixed(0)
        this.pinPot = this.curvePointsData[1]["pin"].toFixed(0)
      }
    },
    setLine: function (value) {
      var ipr_points = [];
      var qo_points = [];
      var value2 = [];
      var ipr_points2 = [];
      var qo_points2 = [];
      var q_oil = [];
      var q_oil2 = [];


      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;
        q_oil = values.q_oil
        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
        q_oil2.push(q_oil);
      });

      this.data = [
        {
          name: "Кривая притока (пользователь)",
          legendgroup: 1,
          x: qo_points2,
          y: ipr_points2,
          text: q_oil2,
          hovertemplate:  "<b>Кривая притока (пользователь)</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },
        {
          name: "Текущий режим",
          legendgroup: 2,
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate:  "<b>Текущий режим</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "15",
            color: "#00A0E3",
          },
        },

        {
          name: "Потенциальный режим",
          legendgroup: 3,
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate:  "<b>Потенциальный режим</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "8",
            color: "#FBA409",
          },
        },
        {
          name: "Кривая притока (анализ)",
          legendgroup: 4,
          x: [],
          y: [],
          text: [],
          hovertemplate:  "<b>Кривая притока (анализ)</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",

          marker: {
            size: "15",
            color: "#237DEB",
          },
        },
      ];
      this.chartOptions = {
        labels: qo_points2,
      };
    },
    updateLine:  function (value) {
      var ipr_points = [];
      var qo_points = [];
      var ipr_points2 = [];
      var qo_points2 = [];
      var q_oil = [];
      var q_oil2 = [];

      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;
        q_oil = values.q_oil
        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
        q_oil2.push(q_oil)
      });
      this.data[3]['x'] = qo_points2
      this.data[3]['y'] = ipr_points2
      this.data[3]['text'] = q_oil2
      if (JSON.stringify(this.data[0]['x']) == JSON.stringify(this.data[3]['x']) && JSON.stringify(this.data[0]['y']) == JSON.stringify(this.data[3]['y'])) {
        this.data[3]['x'] = []
        this.data[3]['y'] = []
        this.data[3]['text'] = []
      }
    },
    setPoints: function (value) {
      this.data[1]['x'][0] = value[0]["q_l"]
      this.data[1]['y'][0] = value[0]["p"]
      this.data[1]['text'][0] = value[0]["q_oil"]
      this.data[2]['x'][0] = value[1]["q_l"]
      this.data[2]['y'][0] = value[1]["p"]
      this.data[2]['text'][0] = value[1]["q_oil"]
      this.layout['shapes'][0]['x0'] = value[1]['q_l']
      this.layout['shapes'][0]['x1'] = value[1]['q_l']

    },
    PotAnalysisMenu() {
      this.postCurveData()
      this.setLine(this.curveLineData)
      this.setPoints(this.curvePointsData)
      if (this.age) {
        this.postAnalysisNew();
        this.$modal.show('modalNewWell');
      } else {
        this.postAnalysisOld();
        this.$modal.show('modalOldWell');
      }
    },

    async ExpAnalysisMenu(){
      await this.NnoCalc()

      if(this.casOD < 127) {
        Vue.prototype.$notifyError('В ЭК Ø127 мм и ниже, применение УЭЦН с габаритами 5 и 5А невозможно')
      }

      if (this.qlCelValue.split(' ')[0] < 28) {
        Vue.prototype.$notifyWarning("Применение УЭЦН не рекомендуется на низкодебитных скважинах");
      }
      if (this.qlCelValue.split(' ')[0] > 106) {
        Vue.prototype.$notifyWarning("Применение ШГН на высокодебитных скважинах ограничивает потенциал добычи");
      }
      this.qZhExpEcn=this.qlCelValue.split(' ')[0]
      this.qOilExpEcn=this.qlCelValue.split(' ')[0]*(1-(this.wctInput.split(' ')[0]/100))*this.densOil

      if (this.qlCelValue.split(' ')[0] < 106){
        this.qZhExpShgn=this.qlCelValue.split(' ')[0]
        this.qOilExpShgn=this.qlCelValue.split(' ')[0]*(1-(this.wctInput.split(' ')[0]/100))*this.densOil

      } else {
        this.qZhExpShgn=106
        this.qOilExpShgn=106*(1-(this.wctInput.split(' ')[0]/100))*this.densOil
      }

      this.expAnalysisData.qoilShgn=this.qOilExpShgn
      this.expAnalysisData.qoilEcn=this.qOilExpEcn

      if(this.expAnalysisData.NNO1!=null) {
        await this.EconomParam();
      }


    },
    async EconomParam(){
      var prs1 = this.expAnalysisData.prs1;
      var prs2 = this.expAnalysisData.prs2;

      var nnoDayUp=moment(this.dataNNO, 'YYYY-MM-DD').toDate();
      var nnoDayFrom=moment(this.stopDate, 'YYYY-MM-DD').toDate();

      var date_diff=(nnoDayUp-nnoDayFrom)/(1000*3600*24);

      if (date_diff<365){
        date_diff=365;
      }



      if (prs1!=0 && prs2!=0){
        this.param_eco=1;
        await this.EconomCalc();
      } else if (prs1==0 && prs2==0){
        if(this.age){
          this.param_eco=1;
          await this.EconomCalc();
        } else {
          if(this.expMeth=="ШГН"){
            this.expAnalysisData.NNO1=date_diff;
            this.param_eco=1;
            await this.EconomCalc();
          }else{
            this.expAnalysisData.NNO2=date_diff;
            this.param_eco=1;
            await this.EconomCalc();
          }
        }
      } else if (prs1==0 && prs2!=0){
        this.param_eco=2;
        await this.EconomCalc();
      } else {
        this.param_eco=3;
        await this.EconomCalc();
      }
    },
    async EconomCalc(){



      let uri2=this.localeUrl("/nnoeco?equip=1&org=5&param=")+this.param_eco+"&qo="+this.qOilExpShgn+"&qzh="+this.qZhExpShgn+"&reqd="+this.expAnalysisData.NNO1+"&reqecn="+this.expAnalysisData.prs1+"&scfa=%D0%A4%D0%B0%D0%BA%D1%82&start=2021-01-21";
      let uri3=this.localeUrl("/nnoeco?equip=2&org=5&param=")+this.param_eco+"&qo="+this.qOilExpEcn+"&qzh="+this.qZhExpEcn+"&reqd="+this.expAnalysisData.NNO2+"&reqecn="+this.expAnalysisData.prs2+"&scfa=%D0%A4%D0%B0%D0%BA%D1%82&start=2021-01-21";

      this.isLoading = true;

      const responses = await Promise.all([ this.axios.get(uri2), this.axios.get(uri3) ]).finally(() => {
        this.isLoading = false;
      });


      let data = responses[0].data;
      if(data) {

        this.expAnalysisData.shgnParam=data[12].godovoiShgnParam;
        this.expAnalysisData.shgnNpv=data[12].npv;
        this.expAnalysisData.npvTable1=data[12];
      }
      else {
        console.log('No data');
      }



      let data2 = responses[1].data;
      if (data2) {

        this.expAnalysisData.ecnParam=data2[12].godovoiEcnParam;
        this.expAnalysisData.ecnNpv=data2[12].npv;
        this.expAnalysisData.npvTable2=data2[12];

        if(this.qOilExpShgn!=null && this.qOilExpEcn!=null && this.expAnalysisData.NNO1!=null && this.expAnalysisData.NNO2!=null && this.expAnalysisData.shgnParam!=null && this.expAnalysisData.shgnNpv!=null && this.expAnalysisData.ecnParam!=null && this.expAnalysisData.ecnNpv!=null ){
          this.$modal.show("modalExpAnalysis");
        }

      }
      else {
        console.log('No data');
      }
    },
    async NnoCalc(){
      let uri = "http://172.20.103.187:7575/api/nno/";

      this.eco_param=null;

      this.qZhExpEcn=this.qlCelValue.split(' ')[0]
      this.qOilExpEcn=this.qlCelValue.split(' ')[0]*(1-(this.wctInput.split(' ')[0]/100))*this.densOil

      if (this.qlCelValue.split(' ')[0]<106){
        this.qZhExpShgn=this.qlCelValue.split(' ')[0]
        this.qOilExpShgn=this.qlCelValue.split(' ')[0]*(1-(this.wctInput.split(' ')[0]/100))*this.densOil

      } else {
        this.qZhExpShgn=106
        this.qOilExpShgn=106*(1-(this.wctInput.split(' ')[0]/100))*this.densOil
      }

      if(this.wellNumber!=null){
        let jsonData = JSON.stringify(
          {"well_number": this.wellNumber,
            "exp_meth": "ШГН",
          }
        )

        let jsonData2 = JSON.stringify(
          {"well_number": this.wellNumber,
            "exp_meth": "ЭЦН",
          }
        )

        this.isLoading = true;

        const responses = await Promise.all([ this.axios.post(uri, jsonData), this.axios.post(uri, jsonData2) ])
            .finally(() => {
              this.isLoading = false;
            });
        //microservise na SHGN NNO


        var data = JSON.parse(responses[0].data.Result)
        if (data) {
          this.expAnalysisData.NNO1=data.NNO
          this.expAnalysisData.qoilShgn=this.qOilExpShgn
          this.expAnalysisData.prs1=data.prs
        } else {
          console.log("No data");
        }

        var data2 = JSON.parse(responses[1].data.Result)
        if (data2) {
          this.expAnalysisData.NNO2=data2.NNO
          this.expAnalysisData.qoilEcn=this.qOilExpEcn
          this.expAnalysisData.prs2=data2.prs
        } else {
          console.log("No data");
        }



      }
    },

    onOpenTable() {
      this.$modal.show("modalNearWells");
    },

    InclMenu() {
      if (this.age === true) {
        Vue.prototype.$notifyWarning("Данные инклинометрии новой скважины отсутствуют");

      } else {
        this.$modal.show('modalIncl')
      }
    },

    getWellNumber(wellnumber) {
      this.visibleChart = true;
      let uri = "http://172.20.103.187:7575/api/pgno/"+ this.field + "/" + wellnumber + "/";
      this.isLoading = true;

      this.axios.get(uri).then((response) => {
          var data = response.data;
          this.method = 'MainMenu'
          if (data["Error"] == "NoData" || data["Error"] == 'data_error'){
            if(data["Error"] == "NoData") {
              Vue.prototype.$notifyError("Указанная скважина отсутствует");
            } else if(data["Error"] == 'data_error') {
              Vue.prototype.$notifyError("Данные тех режима по скважине некорректны");
            }

            this.curveLineData = JSON.parse(data.LineData)["data"]
            this.curvePointsData = JSON.parse(data.PointsData)["data"]
            this.ngdu = 0
            this.sk = 0

            //Выбор скважины
            this.horizon = 0;
            this.expMeth = 0;
            this.tseh = 0;
            this.gu = 0;
            this.curr = 0;

            // Конструкция
            this.casOD = 0;
            this.casID = 0;
            this.hPerf = 0;
            this.udl = 0;

            //PVT
            this.PBubblePoint = 0;
            this.gor = 0;
            this.tRes = 0;
            this.densOil = 0;
            this.viscOilRc = 0;
            this.viscWaterRc = 0;
            this.densWater = 0;
            this.hdynValue = [this.hDynInput = 0, this.pAnnularInput = 0];

            //Оборудование
            this.pumpType = 0;
            this.hPumpSet = 0;
            this.tubOD = 0;
            this.tubID = 0;
            this.stopDate = 0;

            //Технологический  режим
            this.qL = 0;
            this.qO = 0;
            this.wct = 0;
            this.bhp = 0;
            this.pRes = 0;
            this.hDyn = 0;
            this.pAnnular = 0;
            this.whp = 0;
            this.lineP = 0;

            //Настройка кривой притока
            this.pResInput = 0;
            this.piInput = 0;
            this.qLInput = 0;
            this.bhpInput = 0;
            this.wctInput = 0;
            this.gorInput = 0;
            this.hDynInput = 0;
            this.pAnnularInput = 0;
            this.hPumpManomInput = 0;
            this.whpInput = 0;

            //Параметры подбора
            this.hPumpValue = 0;
            this.qlCelValue = 0;
            this.bhpCelValue = 0;
            this.piCelValue = 0;


          } else if(data["Age"] === true) {


            this.curveLineData = JSON.parse(data.LineData)["data"]
            this.curvePointsData = JSON.parse(data.PointsData)["data"]
            this.horizon = data["Well Data"]["horizon"][0]
            this.curveSelect = 'pi'
            this.age = data["Age"]


            this.PBubblePoint = data["Well Data"]["P_bubble_point"][0].toFixed(1)
            this.gor = data["Well Data"]["gor"][0].toFixed(1)
            this.tRes = data["Well Data"]["t_res"][0].toFixed(1)
            this.viscOilRc = data["Well Data"]["visc_oil_rc"][0].toFixed(1)
            this.viscWaterRc = data["Well Data"]["visc_wat_rc"][0].toFixed(1)
            this.densOil = data["Well Data"]["dens_oil"][0].toFixed(1)
            this.densWater = data["Well Data"]["dens_liq"][0].toFixed(1)
            this.hPumpValue = data["Well Data"]["h_pump_set"][0].toFixed(0) + ' м'

            Vue.prototype.$notifyWarning("Нсп установлено на 150м выше ВДП по умолчанию")




            Vue.prototype.$notifyWarning("Новая скважина");

            this.ngdu = 0
            this.sk = 0

            //Выбор скважины
            this.expMeth = 0;
            this.tseh = 0;
            this.gu = 0;
            this.curr = 0;

            // Конструкция
            this.casOD = 168;
            this.casID = 150;
            this.hPerf = data["Well Data"]["h_up_perf_vd"][0].toFixed(0);
            this.udl = 0;

            //Оборудование
            this.pumpType = 0;
            this.hPumpSet = 0
            this.tubOD = 73;
            this.tubID = 62;
            this.stopDate = 0;
            this.stroke_len = 0;
            this.spmDev = 0;

            //Технологический  режим
            this.qL = 0;
            this.qO = 0;
            this.wct = 0;
            this.bhp = 0;
            this.pRes = 0;
            this.hDyn = 0;
            this.pAnnular = 0;
            this.whp = 0;
            this.lineP = 0;

            //Настройка кривой притока
            this.pResInput = 0 + ' атм';
            this.piInput = 0 + ' м³/сут/ат';
            this.qLInput = 0 + ' м³/сут';
            this.bhpInput = 0 + ' атм';
            this.wctInput = 0 + ' %';
            this.gorInput = this.gor + ' м³/т';
            this.hDynInput = 0 + ' м';
            this.pAnnularInput = 0 + ' атм';
            this.hPumpManomInput = 0 + ' атм';
            this.whpInput = 0 + ' атм';
            this.pManomInput = 0 + ' атм'
            this.expChoose = 'ШГН'

            //Параметры подбора
            this.qlCelValue = 0 + ' м³/сут';
            this.bhpCelValue = 0 + ' атм';
            this.piCelValue = 0 + ' атм';

          } else if (data["Age"] === false){
            this.setData(data)
            if(data["error_len"] == "error_len") {
              Vue.prototype.$notifyWarning("Тип СК на скважине не соответствует текущей длине хода")
            }
            if(data["error_spm"] == "error_spm") {
              Vue.prototype.$notifyWarning("Тип СК на скважине не соответствует текущему числу качании")
            }
          }
          this.$emit('LineData', this.curveLineData)
          this.$emit('PointsData', this.curvePointsData)
          //this.NnoCalc();
        }
      ).finally((response) => {
        this.isLoading = false;
      });



    },

    postCurveData() {
      this.visibleChart = true;
      let uri = "http://172.20.103.187:7575/api/pgno/"+ this.field + "/" + this.wellNumber + "/";
      // api/pgno/UZN/
      // KMB
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }



      let jsonData = JSON.stringify(
        {
          "curveSelect": this.curveSelect,
          "presValue": this.pResInput.split(' ')[0],
          "piValue": this.piInput.split(' ')[0],
          "qlValue": this.qLInput.split(' ')[0],
          "bhpValue": this.bhpInput.split(' ')[0],
          "hdynValue": [this.hDynInput.split(' ')[0], this.pAnnularInput.split(' ')[0]],
          "pmanomValue": [this.pManomInput.split(' ')[0], this.hPumpManomInput.split(' ')[0]],
          "whpValue": this.whpInput.split(' ')[0],
          "wctValue": this.wctInput.split(' ')[0],
          "gorValue": this.gorInput.split(' ')[0],
          "expSelect": this.expChoose,
          "hPumpValue": this.hPumpValue.split(' ')[0],
          "celSelect": this.CelButton,
          "celValue": this.CelValue.split(' ')[0],
          "menu": "MainMenu",
          "well_age": this.age,
          "grp_skin": this.grp_skin,
          "analysisBox1": this.analysisBox1,
          "analysisBox2": this.analysisBox2,
          "analysisBox3": this.analysisBox3,
          "analysisBox4": this.analysisBox4,
          "analysisBox5": this.analysisBox5,
          "analysisBox6": this.analysisBox6,
          "analysisBox7": this.analysisBox7,
          "analysisBox8": this.analysisBox8
        }
      )

      if(this.pResInput.split(' ')[0] * 1 <= this.bhpInput.split(' ')[0] * 1 || this.pResInput.split(' ')[0] * 1 <= this.bhpCelValue.split(' ')[0] * 1) {
        Vue.prototype.$notifyError("Pзаб не должно быть больше чем Рпл");
      } else {
        this.isLoading = true;

      if(this.casOD < 127) {
        Vue.prototype.$notifyError('В ЭК Ø127 мм и ниже, применение УЭЦН с габаритами 5 и 5А невозможно')
      }

      if (this.qlCelValue.split(' ')[0] < 28) {
        Vue.prototype.$notifyWarning("Применение УЭЦН не рекомендуется на низкодебитных скважинах");
      }
      if (this.qlCelValue.split(' ')[0] > 106) {
        Vue.prototype.$notifyWarning("Применение ШГН на высокодебитных скважинах ограничивает потенциал добычи");
      }

        this.axios.post(uri, jsonData).then((response) => {
          var data = response.data;
          if (data) {
            this.method = "CurveSetting"
            if(data["Well Data"]["pi"][0] * 1 < 0) {
              Vue.prototype.$notifyWarning("Pзаб не должно быть больше чем Рпл")
            } else {
              if(this.hPumpValue.split(' ')[0] * 1 > this.hPerf * 1){
                Vue.prototype.$notifyWarning("Насос установлен ниже перфорации")
              }
              this.setData(data)
              this.$emit('LineData', this.curveLineData)
              this.$emit('PointsData', this.curvePointsData)
              if(this.qlPot * 1 < this.qlCelValue.split(' ')[0] * 1 && this.CelButton == 'ql'){
                Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
              } else if(this.bhpPot * 1  > this.bhpCelValue.split(' ')[0] * 1  && this.CelButton == 'bhp'){
                Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
              } else if(this.pinPot * 1  > this.piCelValue.split(' ')[0] * 1  && this.CelButton == 'pin'){
                Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
              }
            }

          } else {
          }
        }).finally(() => {
          this.isLoading = false;
        });
      }

    },

    postAnalysisOld() {
      this.visibleChart = true;
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }

      let jsonData = JSON.stringify(
        {
          "curveSelect": this.curveSelect,
          "presValue": this.pResInput.split(' ')[0],
          "piValue": this.piInput.split(' ')[0],
          "qlValue": this.qLInput.split(' ')[0],
          "bhpValue": this.bhpInput.split(' ')[0],
          "hdynValue": [this.hDynInput.split(' ')[0], this.pAnnularInput.split(' ')[0]],
          "pmanomValue": [this.pManomInput.split(' ')[0], this.hPumpManomInput.split(' ')[0]],
          "whpValue": this.whpInput.split(' ')[0],
          "wctValue": this.wctInput.split(' ')[0],
          "gorValue": this.gorInput.split(' ')[0],
          "expSelect": this.expChoose,
          "hPumpValue": this.hPumpValue.split(' ')[0],
          "celSelect": this.CelButton,
          "celValue": this.CelValue.split(' ')[0],
          "menu": "PotencialAnalysis",
          "well_age": this.age,
          "grp_skin": this.grp_skin,
          "analysisBox1": this.analysisBox1,
          "analysisBox2": this.analysisBox2,
          "analysisBox3": this.analysisBox3,
          "analysisBox4": this.analysisBox4,
          "analysisBox5": this.analysisBox5,
          "analysisBox6": this.analysisBox6,
          "analysisBox7": this.analysisBox7,
          "analysisBox8": this.analysisBox8
        }
      )

      this.isLoading = true;

      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          this.method = "CurveSetting"
          this.newData = data["Well Data"]
          // this.setData(data)
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
          // this.$emit('LineData', this.curveLineData)
          // this.$emit('PointsData', this.curvePointsData)
        } else {
        }
      }).finally(() => {
        this.isLoading = false;
      });
    },

    postAnalysisNew() {
      this.visibleChart = true;
      let uri = "http://172.20.103.187:7575/api/pgno/"+ this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }

      let jsonData = JSON.stringify(
        {
          "curveSelect": this.curveSelect,
          "presValue": this.pResInput.split(' ')[0],
          "piValue": this.piInput.split(' ')[0],
          "qlValue": this.qLInput.split(' ')[0],
          "bhpValue": this.bhpInput.split(' ')[0],
          "hdynValue": [this.hDynInput.split(' ')[0], this.pAnnularInput.split(' ')[0]],
          "pmanomValue": [this.pManomInput.split(' ')[0], this.hPumpManomInput.split(' ')[0]],
          "whpValue": this.whpInput.split(' ')[0],
          "wctValue": this.wctInput.split(' ')[0],
          "gorValue": this.gorInput.split(' ')[0],
          "expSelect": this.expChoose,
          "hPumpValue": this.hPumpValue.split(' ')[0],
          "celSelect": this.CelButton,
          "celValue": this.CelValue.split(' ')[0],
          "menu": "PotencialAnalysis",
          "well_age": this.age,
          "grp_skin": this.grp_skin,
          "analysisBox1": this.analysisBox1,
          "analysisBox2": this.analysisBox2,
          "analysisBox3": this.analysisBox3,
          "analysisBox4": this.analysisBox4,
          "analysisBox5": this.analysisBox5,
          "analysisBox6": this.analysisBox6,
          "analysisBox7": this.analysisBox7,
          "analysisBox8": this.analysisBox8
        }
      )

      this.isLoading = true;

      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          this.newData = data["Well Data"]
          this.method = "CurveSetting"
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.nearWells = JSON.parse(data.NearWells)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
          this.wellOkr = data["Well Data"]["well"][0]
          this.piOkr = data["Well Data"]["pi"][0].toFixed(2)
          this.khOkr = data["Well Data"]["kh"][0].toFixed(1)
          this.skinOkr = data["Well Data"]["skin"][0].toFixed(1)
          this.presOkr = data["Well Data"]["p_res"][0].toFixed(0)
          this.wctOkr = data["Well Data"]["wct"][0].toFixed(0)
          // this.$emit('LineData', this.curveLineData)
          // this.$emit('PointsData', this.curvePointsData)
        } else {
        }
      }).finally(() => {
        this.isLoading = false;
      });
    },
    setGraphOld() {
      this.updateLine(this.newCurveLineData)
      this.setPoints(this.newPointsData)
      this.$modal.hide('modalOldWell');
      this.$eventBus.$emit('newCurveLineData', this.newCurveLineData)
      this.$eventBus.$emit('newPointsData', this.newPointsData)
      this.pResInput = this.newData["p_res"][0].toFixed(0) + ' атм'
      this.piInput = this.newData["pi"][0].toFixed(2) + ' м³/сут/ат'
      this.qLInput = this.newData["q_l"][0].toFixed(0) + ' м³/сут'
      this.bhpInput = this.newData["bhp"][0].toFixed(0) + ' атм'
      this.hDynInput = this.newData["h_dyn"][0].toFixed(0) + ' м'
      this.pAnnularInput = this.newData["p_annular"][0].toFixed(0) + ' атм'
      this.pManomInput = this.newData["p_intake"][0].toFixed(0) + ' атм'
      this.hPumpManomInput = this.newData["h_pump_set"][0].toFixed(0) + ' м'
      this.whpInput = this.newData["whp"][0].toFixed(0) + ' атм'
      this.wctInput = this.newData["wct"][0].toFixed(0) + ' %'
      this.qlCelValue = this.newPointsData[0]["q_l"].toFixed(0) + ' м³/сут'
      this.bhpCelValue = this.newPointsData[0]["p"].toFixed(0) + ' атм'
      this.piCelValue = this.newPointsData[0]["pin"].toFixed(0) + ' атм'
    },

    setGraphNew() {
      Vue.prototype.$notifyWarning("Нсп установлено на 150м выше ВДП по умолчанию")
      this.updateLine(this.newCurveLineData)
      this.setPoints(this.newPointsData)
      this.$modal.hide('modalNewWell');
      this.$eventBus.$emit('newCurveLineData', this.newCurveLineData)
      this.$eventBus.$emit('newPointsData', this.newPointsData)
      this.pResInput = this.newData["p_res"][0].toFixed(0) + ' атм'
      this.piInput = this.newData["pi"][0].toFixed(2) + ' м³/сут/ат'
      this.wctInput = this.newData["wct"][0].toFixed(0) + ' %'
      this.hPumpValue = this.newData["h_pump_set"][0].toFixed(0) + ' м'
    },

    onCompareNpv() {
      if(this.expAnalysisData.ecnNpv > this.expAnalysisData.shgnNpv) {
        this.expChoose = "ЭЦН"
      } else {
        this.expChoose = "ШГН"
      }
      this.$modal.hide("modalExpAnalysis");
      this.postCurveData();
    },

    onShowTable() {
      this.$modal.hide("modalExpAnalysis");
      this.$modal.show("tablePGNO")
    },

    onPgnoClick() {
      if(this.qlPot * 1 < this.qlCelValue.split(' ')[0] * 1 && this.CelButton == 'ql'){
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
      } else if(this.bhpPot * 1  > this.bhpCelValue.split(' ')[0] * 1  && this.CelButton == 'bhp'){
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
      } else if(this.pinPot * 1  > this.piCelValue.split(' ')[0] * 1  && this.CelButton == 'pin'){
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
      } else {
        if(this.expChoose == 'ШГН'){
          if(this.visibleChart) {
            let uri = "http://172.20.103.187:7575/api/pgno/shgn";
            let jsonData = JSON.stringify(
              {
                "ql_cel": this.qlCelValue.split(' ')[0],
                "h_pump_set": this.hPumpValue.split(' ')[0],
                "sk_type": this.sk,
                "dens_oil": this.densOil,
                "dens_water": this.densWater,
                "wct": this.wctInput.split(' ')[0],
                "stroke_len": this.stroke_len,
                "pin_cel_value": this.piCelValue.split(' ')[0]
              }
            )

            this.isLoading = true;

            this.axios.post(uri, jsonData).then((response) => {
              var data = JSON.parse(response.data);
              if(data) {
                if (data["error"] == "NoIntersection") {
                  Vue.prototype.$notifyWarning("По выбранным параметрам насос подобрать не удалось, попробуйте изменить глубину спуска или ожидаемый дебит");
                } else {
                  if(this.sk == "ПШГН" || this.sk == "0") {
                    Vue.prototype.$notifyWarning("Тип СК на скважине не определен")
                  }
                  this.shgnPumpType = data["pump_type"]
                  if(this.shgnPumpType == 70) {
                    this.shgnTubOD = 89
                  } else {
                    this.shgnTubOD = this.tubOD
                  }
                  if(this.shgnPumpType == 70 && this.casOD * 1 < 115) {
                    Vue.prototype.$notifyWarning('Применение НСН-70 на НКТ 89 мм ограничено в ЭК 114мм')
                    Vue.prototype.$notifyWarning("По выбранным параметрам насос подобрать не удалось, попробуйте изменить глубину спуска или ожидаемый дебит");
                  } else {
                    Vue.prototype.$notifyWarning("Раздел 'Подбор ШГН' находится в разработке")
                    this.shgnSPM = data["spm"].toFixed(0)
                    this.shgnLen = data["stroke_len"]
                    this.shgnS1D = data["s1d"].toFixed(0)
                    this.shgnS2D = data["s2d"].toFixed(0)
                    this.shgnS1L = data["s1l"].toFixed(0)
                    this.shgnS2L = data["s2l"].toFixed(0)
                    this.shgnTN = data["tn"]
                    this.shgnTNL = data["tn_l"]
                    this.visibleChart = !this.visibleChart
                  }

                }
              } else {
              }
            }).finally(() => {
              this.isLoading = false;
            })
          } else {
            this.visibleChart = !this.visibleChart
            this.postCurveData()

          }
        } else {
          Vue.prototype.$notifyWarning("Раздел 'Подбор УЭЦН' не разработан")
        }

      }
    },
    setActiveRightTabName: function (e, val) {
      if (val === this.activeRightTabName && (this.windowWidth > 1300 || this.windowWidth <= 991)) {
        this.activeRightTabName = 'technological-mode';
        return;
      }

      if (val === this.activeRightTabName && this.windowWidth <= 1300 && this.windowWidth > 991) {
        this.activeRightTabName = 'devices';
        return;
      }

      if (val === 'technological-mode' && this.windowWidth <= 1300 && this.windowWidth > 991) {
        return;
      }

      this.activeRightTabName = val;
    },

    onPrsButtonClick() {
      this.$modal.show('modal-prs')
    },

    createPDF() {

      this.isLoading = true;

      htmlToImage.toPng(this.$refs['gno-page'])
        .then(function (dataUrl) {
          let img = new Image();
          let pdf = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: 'a4'
          })
          img.src = dataUrl;

          // let link = document.createElement('a');
          // link.setAttribute('href', dataUrl);
          // link.setAttribute('download','download');
          // link.click();
          // link.remove();

          pdf.addImage(dataUrl, 'png', 10, 1, 180, 300);
          pdf.save('test.pdf')
          // document.body.appendChild(img);
        })
        .catch(function (error) {
          console.error('oops, something went wrong!', error);
        }).finally(() => {
            this.isLoading = false;
      });
    },

    downloadImg() {
      $('#btnExport').click(function(){
        //var title = $("<p>Image Here</p>");
        //$("#content").append(title);
        var divGraph = $('#graph');
        Plotly.toImage('graph', { format: 'png', width: 800, height: 600 }).then(function (dataURL) {
          img_png.attr("src", dataURL);
        });
      });
    },
  },
};
</script>

<style scoped></style>
