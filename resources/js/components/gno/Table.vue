<template>
  <div style="position: relative">
    <div>
      <div class="row">
        <div class="second-column col-lg-3 order-md-2">
          <div class=" col-md-12">
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
                <input v-model="wellNumber" type="text" @change="getWellNumber(wellNumber)" class="square2"/>
              </div>
              <div class="choosing-well-data table-border-gno-top  col-7">
                Новая скважина
                <input :checked="age === true" v-model="age" class="checkbox0" type="checkbox"/>
              </div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">
                с ГРП
                <input class="checkbox0" v-model="grp_skin" :disabled="!age" type="checkbox"/>
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
              <div class="construction-data no-gutter col-7">Наружн. ØЭК</div>
              <div class="construction-data table-border-gno cell4-gno-second no-gutter col-5">
                {{ casOD }} мм
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                Внутрен. ØЭК
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
              <div class="box">
                <div class="select-well no-gutter col-12">
                  <div class="devices-title"><b>Оборудование</b></div>
                </div>
                <span class="closer">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M11.8083 6.4147L11.4156 6.80558C11.2917 6.92697 11.1271 6.99486 10.951 6.99486C10.775 6.99486 10.6104 6.92697 10.4864 6.80558L6.003 2.37722L1.51331 6.81073C1.38935 6.93211 1.22477 7 1.04872 7C0.873717 7 0.708088 6.93211 0.585169 6.81073L0.19141 6.4219C-0.0638035 6.16885 -0.0638035 5.75738 0.19141 5.50536L5.53632 0.207788C5.66028 0.0853782 5.82487 0 6.00195 0H6.00404C6.18008 0 6.34467 0.0853782 6.46863 0.207788L11.8083 5.49096C11.9323 5.61234 12 5.78001 12 5.95386C12 6.1277 11.9323 6.29229 11.8083 6.4147Z"
                    fill="#FEFEFE"/>
                  </svg>
                </span>
                <span class="open">
                      <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.8083 0.585305L11.4156 0.194416C11.2917 0.0730345 11.1271 0.00514328 10.951 0.00514328C10.775 0.00514328 10.6104 0.0730345 10.4864 0.194416L6.003 4.62278L1.51331 0.189273C1.38935 0.0678913 1.22477 0 1.04872 0C0.873717 0 0.708088 0.0678913 0.585169 0.189273L0.19141 0.578104C-0.0638035 0.831154 -0.0638035 1.24262 0.19141 1.49464L5.53632 6.79221C5.66028 6.91462 5.82487 7 6.00195 7H6.00404C6.18008 7 6.34467 6.91462 6.46863 6.79221L11.8083 1.50904C11.9323 1.38766 12 1.21999 12 1.04614C12 0.8723 11.9323 0.707715 11.8083 0.585305Z"
                        fill="#FEFEFE"/>
                      </svg>
                </span>


                <blockquote class="right-block-details">
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
                    {{spmDev}} м-1
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Диаметр насоса
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ pumpType }} м
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">Нсп</div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ hPumpSet }} м
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Наружн. ØНКТ
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ tubOD }} мм
                  </div>
                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    Внутр. ØНКТ
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
                </blockquote>
              </div>
            </div>

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'pvt' }">
              <input style="width: 845px; height: 45px;"
                     type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'pvt'"
                     @change="setActiveRightTabName($event, 'pvt')"/>
              <div class="box">
                <div class="select-well no-gutter col-12">
                  <div class="pvt-title">PVT</div>
                </div>
                <span class="closer">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M11.8083 6.4147L11.4156 6.80558C11.2917 6.92697 11.1271 6.99486 10.951 6.99486C10.775 6.99486 10.6104 6.92697 10.4864 6.80558L6.003 2.37722L1.51331 6.81073C1.38935 6.93211 1.22477 7 1.04872 7C0.873717 7 0.708088 6.93211 0.585169 6.81073L0.19141 6.4219C-0.0638035 6.16885 -0.0638035 5.75738 0.19141 5.50536L5.53632 0.207788C5.66028 0.0853782 5.82487 0 6.00195 0H6.00404C6.18008 0 6.34467 0.0853782 6.46863 0.207788L11.8083 5.49096C11.9323 5.61234 12 5.78001 12 5.95386C12 6.1277 11.9323 6.29229 11.8083 6.4147Z"
                    fill="#FEFEFE"/>
                  </svg>
                </span>

                <span class="open">
                      <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.8083 0.585305L11.4156 0.194416C11.2917 0.0730345 11.1271 0.00514328 10.951 0.00514328C10.775 0.00514328 10.6104 0.0730345 10.4864 0.194416L6.003 4.62278L1.51331 0.189273C1.38935 0.0678913 1.22477 0 1.04872 0C0.873717 0 0.708088 0.0678913 0.585169 0.189273L0.19141 0.578104C-0.0638035 0.831154 -0.0638035 1.24262 0.19141 1.49464L5.53632 6.79221C5.66028 6.91462 5.82487 7 6.00195 7H6.00404C6.18008 7 6.34467 6.91462 6.46863 6.79221L11.8083 1.50904C11.9323 1.38766 12 1.21999 12 1.04614C12 0.8723 11.9323 0.707715 11.8083 0.585305Z"
                        fill="#FEFEFE"/>
                      </svg>
                </span>

                <blockquote class="right-block-details">
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
                </blockquote>
              </div>
            </div>

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'technological-mode' }">
              <input style="width: 845px; height: 45px;"
                     type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'technological-mode'"
                     @change="setActiveRightTabName($event, 'technological-mode')"/>
              <div class="box">
                <div class="select-well no-gutter col-12">
                  <div class="technological-mode-title">Технологический режим</div>
                </div>

                <span class="closer">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.8083 6.4147L11.4156 6.80558C11.2917 6.92697 11.1271 6.99486 10.951 6.99486C10.775 6.99486 10.6104 6.92697 10.4864 6.80558L6.003 2.37722L1.51331 6.81073C1.38935 6.93211 1.22477 7 1.04872 7C0.873717 7 0.708088 6.93211 0.585169 6.81073L0.19141 6.4219C-0.0638035 6.16885 -0.0638035 5.75738 0.19141 5.50536L5.53632 0.207788C5.66028 0.0853782 5.82487 0 6.00195 0H6.00404C6.18008 0 6.34467 0.0853782 6.46863 0.207788L11.8083 5.49096C11.9323 5.61234 12 5.78001 12 5.95386C12 6.1277 11.9323 6.29229 11.8083 6.4147Z"
                        fill="#FEFEFE"/>
                  </svg>
                </span>

                <span class="open">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.8083 0.585305L11.4156 0.194416C11.2917 0.0730345 11.1271 0.00514328 10.951 0.00514328C10.775 0.00514328 10.6104 0.0730345 10.4864 0.194416L6.003 4.62278L1.51331 0.189273C1.38935 0.0678913 1.22477 0 1.04872 0C0.873717 0 0.708088 0.0678913 0.585169 0.189273L0.19141 0.578104C-0.0638035 0.831154 -0.0638035 1.24262 0.19141 1.49464L5.53632 6.79221C5.66028 6.91462 5.82487 7 6.00195 7H6.00404C6.18008 7 6.34467 6.91462 6.46863 6.79221L11.8083 1.50904C11.9323 1.38766 12 1.21999 12 1.04614C12 0.8723 11.9323 0.707715 11.8083 0.585305Z"
                        fill="#FEFEFE"/>
                  </svg>
                </span>

                <blockquote class="right-block-details">
<!--                            v-if="activeRightTabName === 'technological-mode'">-->
                  <div class="tech-data no-gutter col-7">Qж</div>
                  <div class="tech-data table-border-gno no-gutter col-5">
                    {{ qL }} м3/сут
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Qн</div>
                  <div class="tech-data table-border-gno table-border-gno-top no-gutter col-5">
                    {{ qO }} т/сут
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Обвод</div>
                  <div class="tech-data table-border-gno table-border-gno-top no-gutter col-5">
                    {{ wct }} %
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Рзаб</div>
                  <div class="tech-data table-border-gno table-border-gno-top no-gutter col-5">
                    {{ bhp }} атм
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Рпл</div>
                  <div class="tech-data table-border-gno table-border-gno-top no-gutter col-5">
                    {{ pRes }} ат
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">Ндин</div>
                  <div class="tech-data table-border-gno table-border-gno-top no-gutter col-5">
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
                </blockquote>
              </div>
            </div>
          </div>
        </div>

        <div class="no-gutter col-lg-9 order-md-1 first-column container-fluid no-gutter">
          <div class="no-gutter col-md-12 first-column-curve-block">
            <div class="background">
              <modal class="modal-bign-wrapper" name="modalIncl" :width="1150" :height="600" style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">Инклинометрия</div>

                    <button type="button"
                            class="modal-bign-button"
                            @click="closeModal('modalIncl')">
                      Закрыть
                    </button>
                  </div>

                  <div class="Table" align="center" x:publishsource="Excel">
                    <gno-incl-table :wellNumber="wellNumber" :wellIncl="wellIncl"></gno-incl-table>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="modalOldWell" :width="1080" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      Анализ потенциала
                    </div>

                    <button type="button"
                            class="modal-bign-button"
                            @click="closeModal('modalOldWell')">
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
                               type="checkbox"/>
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Рпл = Рнач</label>
                      </div>
                      <div class="form-check">
                        <input v-model="analysisBox2" class="checkbox-modal-analysnauryzbekis-menu"
                               @change="postAnalysisOld()" type="checkbox"/>
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Н дин = Ндин мин</label>
                      </div>
                      <div class="form-check">
                        <input v-model="analysisBox3" class="checkbox-modal-analysnauryzbekis-menu"
                               @change="postAnalysisOld()" type="checkbox"/>
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Рзаб пот >= 0,75 * Рнас</label>
                      </div>
                      <div class="form-check">
                        <input v-model="analysisBox4" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                               type="checkbox"/>
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Qж = Qж АСМА</label>
                      </div>
                      <div class="form-check">
                        <input v-model="analysisBox5" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                               type="checkbox"/>
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">Обв = Обв АСМА</label>
                      </div>
                      <button type="button"
                              class="old_well_button"
                              @click="setGraphOld()">
                        Применить&nbsp;выполненные корректировки
                      </button>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper"  name="modalNewWell" :width="1150" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      Анализ потенциала
                    </div>

                    <button type="button"
                            class="modal-bign-button"
                            @click="closeModal('modalNewWell')">
                      Закрыть
                    </button>
                  </div>

                  <div class="modal-old-well-content-container">
                    <div class="modal-old-well-plotly-container">
                      <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
                    </div>
                    <div class="modal-analysis-menu">
                      <div class="form-check-new">
                        <input v-model="analysisBox6" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()"
                               type="checkbox"/>
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Pпл = P по окр.</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="analysisBox7" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()"
                               type="checkbox"/>
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">К пр = К по окр.</label>
                      </div>
                      <div class="form-check-new">
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Обв по окр. =
                        </label>
                        <label for="checkbox1">{{ wctOkr }}%</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="analysisBox8" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()"
                               type="checkbox"/>
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">Рзаб пот = 0.75 * Рнас</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="grp_skin" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()"
                               type="checkbox"/>
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">с ГРП</label>
                      </div>
                      <button type="button"
                              class="old_well_button"
                              @click="setGraphNew()">
                        Применить&nbsp;выполненные корректировки
                      </button>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper chart" name="modalExpAnalysis" :width="1300" :height="550" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      Сравнение технико-экономических показателей за 1 год эксплуатации
                    </div>

                    <button type="button"
                            class="modal-bign-button"
                            @click="closeModal('modalExpAnalysis')">
                      Закрыть
                    </button>
                  </div>

                  <div>
                    <div class="nno-graph">
                      <gno-chart-bar :data="expAnalysisData"></gno-chart-bar>
                    </div>

                    <div class="nno-info-button">
                      <div class="nno-icon" @click="onShowTable()">
                        <svg width="31" height="35"
                             viewBox="0 0 31 35"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.131 0.290039C6.83973 0.290039 0.117188 6.77814 0.117188 14.7803C0.117188 19.0149 2.00031 22.8253 5.00172 25.4754L3.66936 34.3624L11.2537 28.7829C12.4906 29.1013 13.7903 29.2719 15.131 29.2719C23.4223 29.2719 30.1463 22.7824 30.1463 14.7803C30.1463 6.77814 23.4223 0.290039 15.131 0.290039ZM18.2567 22.7482C17.4838 23.0426 16.8686 23.2656 16.4071 23.4202C15.9471 23.5749 15.4118 23.6521 14.8033 23.6521C13.8676 23.6521 13.1392 23.4316 12.6208 22.9909C12.102 22.5506 11.8441 21.9925 11.8441 21.3142C11.8441 21.0504 11.863 20.7804 11.9015 20.5057C11.9407 20.2306 12.0029 19.9217 12.0881 19.5746L13.0555 16.2768C13.1403 15.9606 13.2141 15.6601 13.2726 15.3803C13.331 15.0979 13.3593 14.8392 13.3593 14.6038C13.3593 14.1843 13.2689 13.8899 13.0898 13.7244C12.9077 13.5584 12.5661 13.4776 12.0564 13.4776C11.8072 13.4776 11.5504 13.5133 11.2872 13.5879C11.0267 13.6654 10.8006 13.7352 10.6151 13.804L10.8703 12.7881C11.5033 12.5392 12.1096 12.3256 12.6879 12.1491C13.2663 11.9698 13.8129 11.8817 14.3279 11.8817C15.2569 11.8817 15.9736 12.1 16.4784 12.5316C16.9806 12.9649 17.2336 13.5278 17.2336 14.2199C17.2336 14.3633 17.2154 14.6162 17.1814 14.9768C17.1468 15.3385 17.082 15.6685 16.9881 15.9716L16.026 19.2594C15.9472 19.5229 15.8771 19.8249 15.8137 20.1622C15.7512 20.4995 15.721 20.7571 15.721 20.93C15.721 21.3666 15.8212 21.665 16.0248 21.8233C16.2254 21.9816 16.5775 22.0612 17.0756 22.0612C17.3108 22.0612 17.5739 22.0205 17.8714 21.9422C18.1662 21.8636 18.3801 21.7938 18.5147 21.7337L18.2567 22.7482ZM18.0863 9.40345C17.6376 9.80588 17.0974 10.0071 16.4656 10.0071C15.8352 10.0071 15.2912 9.80588 14.8388 9.40345C14.3887 9.00138 14.1612 8.51159 14.1612 7.93996C14.1612 7.36978 14.3902 6.87891 14.8388 6.47284C15.2912 6.06567 15.8352 5.86336 16.4656 5.86336C17.0974 5.86336 17.6388 6.06567 18.0863 6.47284C18.5349 6.87891 18.76 7.36978 18.76 7.93996C18.76 8.51304 18.5349 9.00138 18.0863 9.40345Z"
                                fill="#FEFEFE"/>
                        </svg>
                      </div>
                    </div>

                    <div class="nno-modal-button-wrapper">
                      <button class="button-nno" @click="onCompareNpv()">
                        Выбрать способ эксплуатации с более высоким NPV
                      </button>
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

                    <button type="button"
                            class="modal-bign-button"
                            @click="closeEconomicModal()">
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

              <div class="gno-shgn-wrapper"
                   v-if="!visibleChart">
                <div class="gno-shgn-block-title">
                  Компоновка ШГН
                </div>

                <div class="podbor-gno">
                  <div class="img-text col-2">
                    <div class="text_img_1">Экс.колонна {{ this.casID }}мм</div>
                    <div class="text_img_2">НКТ {{ this.tubOD }}мм</div>
                    <div class="text_img_3">
                      Штанги {{ this.shgnS1D }}мм 0-{{ this.shgnS1L }}м
                    </div>
                    <div class="text_img_4">
                      Штанги {{ this.shgnS2D }}мм {{ this.shgnS1L }}-{{
                        this.shgnS1L * 1 + this.shgnS2L * 1
                      }}м
                    </div>
                    <div class="text_img_5">
                      Штанги {{ this.shgnS1D }}мм
                      {{ this.shgnS1L * 1 + this.shgnS2L * 1 }}-{{
                        this.shgnS1L * 1 + this.shgnS2L * 1 + this.shgnTNL * 1
                      }}м
                    </div>
                    <div class="text_img_6">Насос {{ this.shgnPumpType }}мм</div>
                    <div class="text_img_7">
                      Интервал перфорации {{ this.hPerf }}-{{
                        this.hPerf * 1 + this.hPerfND * 1
                      }}м
                    </div>
                    <div class="text_img_8">Текущий забой {{ this.curr }}м</div>
                  </div>

                  <div class="image-data col-2">
                    <img class="podborgnoimg"
                         src="./images/podbor-gno.png"
                         alt="podbor-gno"/>
                  </div>

                  <div class="table-pgno-button col-8">
                    <div class="table-pgno-one">
                      <table class="table-pgno gno-table-with-header">
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
                      <table class="table-pgno gno-table-with-header">
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
                          <td class="td-pgno" rowspan="1">{{ tubOD }} мм</td>
                        </tr>
                        <tr>
                          <td class="td-pgno" rowspan="1">Нсп насоса</td>
                          <td class="td-pgno" rowspan="1">{{ hPumpValue }}</td>
                        </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="table-pgno-four">
                      <table class="table-pgno gno-table-with-header">
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
                </div>
              </div>
            </div>
          </div>

          <modal name="table" :width="1150" :height="385" :adaptive="true"></modal>

          <div class="no-gutter col-md-12">
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
                                      <input v-model="pResInput" @change="postCurveData()" onfocus="this.value=''" type="text" class="square3"/>
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
                                  <input v-model="wctInput" @change="postCurveData()" type="text" onfocus="this.value=''" class="square3"/>
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
                                          <input v-model="curveSelect"
                                                 class="checkbox-k-prod"
                                                 value="pi"
                                                 type="radio"
                                                 name="set"
                                                 @change="postCurveData()"/>
                                          Кпрод
                                        </label>


                                      </div>
                                    </div>

                                    <div class="col-5 py-1 px-1">
                                      <input v-model="piInput" :disabled="curveSelect != 'pi'" @change="postCurveData()" onfocus="this.value=''"
                                             type="text" class="square3"/>

                                    </div>
                                  </div>
                                </div>
                                <div class="col-2 px-0">
                                  <div class="table-border-gno-right ic-ar pt-1">
                                    ГФ.
                                  </div>
                                </div>
                                <div class="col-2  py-1 pl-2 pr-0">
                                  <input v-model="gorInput"
                                         @change="postCurveData()"
                                         type="text"
                                         onfocus="this.value=''"
                                         class="square3"/>
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
                                          <input v-model="QhydCurveSelect"
                                                 class="checkbox-q-liquid"
                                                 value="hdyn"
                                                 type="radio"
                                                 @change="postCurveData()"
                                                 name="set"/> Qж</label>
                                      </div>
                                    </div>
                                    <div class="col-5 py-1 px-1">
                                      <input :disabled="curveSelect == 'pi'"
                                             v-model="qLInput"
                                             @change="postCurveData()"
                                             onfocus="this.value=''"
                                             type="text"
                                             class="square3"/>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-5"></div>
                              </div>
                            </div>
                            <div class="table-border-gno-top">
                              <div class="row">

                                <div class="col-1"></div>
                                <div class="col-2 ml-3 pl-4 pr-3 ic-min-block2 pt-1">
                                  <div class="table-border-gno-right pt-1">
                                    <label for="">
                                      <input v-model="curveSelect" value="bhp" :disabled="curveSelect == 'pi'" class="checkbox-k-prod" type="radio"
                                             @change="postCurveData()"
                                             name="set2"/> Рзаб</label>
                                  </div>
                                </div>
                                <div class="col-7 px-0 pt-2">
                                  <input :disabled="curveSelect != 'bhp'" v-model="bhpInput" @change="postCurveData()" onfocus="this.value=''"
                                         type="text"
                                         class="square3"/>
                                </div>


                              </div>
                            </div>
                            <div class="table-border-gno-top">
                              <div class="row">

                                <div class="col-1">
                                </div>

                                <div class="tech-data ml-3 pl-4 pr-3  col-2  ic-min-block2">
                                  <div class="table-border-gno-right">
                                    <label for="">
                                      <input v-model="curveSelect"
                                             value="hdyn"
                                             :disabled="curveSelect == 'pi'"
                                             class="checkbox-k-prod"
                                             type="radio"
                                             @change="postCurveData()"
                                             name="set2"/> Ндин</label>
                                  </div>
                                </div>

                                <div class="col-2 px-0 pt-1 mr-2">
                                  <input :disabled="curveSelect != 'hdyn'"
                                         v-model="hDynInput"
                                         @change="postCurveData()"
                                         type="text"
                                         onfocus="this.value=''"
                                         class="square3"/>
                                </div>

                                <div class="pt-1">
                                  <div class="tech-data col-2 table-border-gno-left-right ic-min-block3">
                                    Рзат
                                  </div>
                                </div>
                                <div class="col-2 pt-1">
                                  <input :disabled="curveSelect != 'hdyn'" v-model="pAnnularInput" @change="postCurveData()" type="text"
                                         onfocus="this.value=''"
                                         class="square3"/>
                                </div>

                                <div class="col-1">
                                </div>

                              </div>
                            </div>
                            <div class="table-border-gno-top">
                              <div class="row">

                                <div class="col-1">
                                </div>

                                <div class="tech-data  ml-3 pl-4 pr-3 col-2 ic-min-block2">

                                  <div class="table-border-gno-right">
                                    <label for="">
                                      <input v-model="curveSelect" value="pmanom" :disabled="curveSelect == 'pi'" class="checkbox-k-prod" type="radio"
                                      @change="postCurveData()"
                                      name="set2" /> Рманом</label>
                                  </div>
                                </div>

                                <div class="col-2 px-0 pt-1 mr-2">

                                  <input :disabled="curveSelect != 'pmanom'" v-model="pManomInput" @change="postCurveData()" type="text"
                                         onfocus="this.value=''"
                                         class="square3"/>
                                </div>

                                <div class="pb-1">
                                  <div class="tech-data col-2 table-border-gno-left-right ic-min-block3">
                                    Нсп маном
                                  </div>
                                </div>

                                <div class="col-2 pt-1">
                                  <input :disabled="curveSelect != 'pmanom'" v-model="hPumpManomInput" @change="postCurveData()" type="text"
                                         onfocus="this.value=''"
                                         class="square3"/>
                                </div>

                                <div class="col-2">
                                </div>

                              </div>
                            </div>
                            <div class="table-border-gno-top">
                              <div class="row">

                                <div class="col-1">
                                </div>

                                <div class="tech-data ml-3 pl-4 pr-3 col-2 ic-min-block2 mb-2">

                                  <div class="table-border-gno-right">
                                    <label for="">
                                      <input v-model="curveSelect" value="whp" :disabled="curveSelect == 'pi'" class="checkbox-k-prod" type="radio"
                                             @change="postCurveData()"
                                             name="set2"/> Рбуф(ФЭ)</label>
                                  </div>
                                </div>
                                <div class="col-7 px-0 pt-1">
                                  <input :disabled="curveSelect != 'whp'" v-model="whpInput" @change="postCurveData()" type="text"
                                         onfocus="this.value=''"
                                         class="square3"/>
                                </div>

                              </div>
                            </div>
                          </div>

                          <div class="tables-string-gno5 col-12"
                               @click="PotAnalysisMenu()">
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
                                    <input class="checkbox3" value="ШГН" v-model="expChoose"
                                           @change="postCurveData()"
                                           :checked="expChoose === 'ШГН'" type="radio"
                                           name="gno10"/>ШГН</label>
                                </div>
                              </div>

                              <div class="col-4  pr-0">
                                <div class="table-border-gno-right">
                                  <label class="label-for-celevoi"><input class="checkbox3" value="ЭЦН"
                                                                          v-model="expChoose"
                                                                          @change="postCurveData()"
                                                                          :checked="expChoose === 'ЭЦН'" type="radio"
                                                                          name="gno10"/>ЭЦН</label>
                                </div>
                              </div>
                              <div class="col-4">
                                <label class="label-for-celevoi pl-3">Нсп</label>
                                <input v-model="hPumpValue" @change="postCurveData()" type="text" class="square3 podbor"/>
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
                                  <div class="table-border-gno-right pt-2 pb-3">
                                    Целевой параметр
                                  </div>
                                </div>
                                <div class="col-4 pr-0">
                                  <div class="table-border-gno-right  pt-2 pb-3">
                                    &nbsp;
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right pdo-bottom-cell">
                                  <label class="label-for-celevoi">
                                    <input v-model="CelButton" class="checkbox3" value="ql" type="radio" name="gno11" />Qж</label>
                                  <input v-model="qlCelValue" @change="postCurveData()" :disabled="CelButton != 'ql'" onfocus="this.value=''"
                                         type="text"
                                         class="square3 podbor"/>
                                </div>
                              </div>
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right pdo-bottom-cell">
                                  <label class="label-for-celevoi"><input v-model="CelButton" class="checkbox3" value="bhp" type="radio" name="gno11"/>Рзаб</label>

                                  <input v-model="bhpCelValue" @change="postCurveData()" :disabled="CelButton != 'bhp'" type="text"
                                         onfocus="this.value=''"
                                         class="square3 podbor"/>
                                </div>
                              </div>
                              <div class="col-4 pdo-bottom-cell">
                                <label class="label-for-celevoi">
                                  <input v-model="CelButton" class="checkbox3" value="pin" type="radio" name="gno11"/>Pnp
                                </label>
                                <input v-model="piCelValue" @change="postCurveData()" :disabled="CelButton != 'pin'" type="text" onfocus="this.value=''"
                                       class="square3 podbor"/>
                              </div>
                            </div>
                          </div>

                          <div class="tables-string-gno55 col-12"
                               @click="ExpAnalysisMenu()">
                            Анализ эффективности способа эксплуатации
                          </div>
                        </div>
                        <div class="col-12 px-2 gno-main-green-button">
                          <div class="tables-string-gno6 col-12"
                               @click="onPgnoClick()">
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
    </div>

    <notifications position="top"></notifications>
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

Vue.prototype.$eventBus = new Vue();


Vue.use(NotifyPlugin,VueMomentLib);
Vue.component("Plotly", Plotly);


export default {
  components: { PerfectScrollbar },
  data: function () {
    return {
      activeRightTabName: 'technological-mode',
      layout: {
        width: 800,
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
            size: 12,
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

      field: "UZN",
      wellIncl: null,
      dataNNO:"2020-11-01",

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
        this.qLInput = data["Well Data"]["q_l"][0].toFixed(0)
        this.wctInput = data["Well Data"]["wct"][0] + ' %'
        this.hPumpValue = data["Well Data"]["h_pump_set"][0].toFixed(0) + ' м'
        this.gorInput = data["Well Data"]["gor"][0] + ' м³/т'
        this.bhpInput = data["Well Data"]["bhp"][0].toFixed(0) + ' атм'
        this.hDynInput = data["Well Data"]["h_dyn"][0].toFixed(0) + ' м'
        this.pAnnularInput = data["Well Data"]["p_annular"][0].toFixed(0) + ' атм'
        this.qlCelValue = JSON.parse(data.PointsData)["data"][2]["q_l"].toFixed(0)
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
        this.piInput = data["Well Data"]["pi"][0].toFixed(2) + ' атм'
        this.curr = data["Well Data"]["curr_bh"][0].toFixed(0)
        this.piCelValue = JSON.parse(data.PointsData)["data"][0]["pin"].toFixed(0) + ' атм'
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][0]["p"].toFixed(0) + ' атм'
        this.wellIncl = data["Well Data"]["well"][0]
        this.hPerfND = data["Well Data"]["h_perf"][0]
        this.strokeLenDev = data["Well Data"]["stroke_len"][0]
        this.spmDev = data["Well Data"]["spm"][0]


        this.stopDate = this.stopDate.substring(0, 10)
        this.pResInput = this.pRes + ' атм'
        this.qLInput = this.qL
        this.wctInput = this.wct + ' %'
        this.gorInput = this.gor + ' м³/т'
        this.bhpInput = this.bhp + ' атм'
        this.hDynInput = this.hDyn + ' м'
        this.pAnnularInput = this.pAnnular + ' атм'
        this.pManomInput = data["Well Data"]["p_intake"][0] + ' атм'
        this.hPumpManomInput = data["Well Data"]["h_pump_set"][0] + ' м'
        this.whpInput = this.whp + ' атм'
        this.qlCelButton = true
        this.qlCelValue = this.qLInput + ' м³/сут'
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
      console.log(value)
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
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate:  "<b>Потенциальный режим</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "15",
            color: "#FBA409",
          },
        },
        {
          name: "Кривая притока (анализ)",
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
      console.log(JSON.stringify(this.data[0]['x']) == JSON.stringify(this.data[3]['x']))
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
      console.log('Nno',typeof this.expAnalysisData.NNO1,typeof this.expAnalysisData.NNO2);



      let uri2="/ru/nnoeco?equip=1&org=5&param="+this.param_eco+"&qo="+this.qOilExpShgn+"&qzh="+this.qZhExpShgn+"&reqd="+this.expAnalysisData.NNO1+"&reqecn="+this.expAnalysisData.prs1+"&scfa=%D0%A4%D0%B0%D0%BA%D1%82&start=2021-01-21";
      let uri3="/ru/nnoeco?equip=2&org=5&param="+this.param_eco+"&qo="+this.qOilExpEcn+"&qzh="+this.qZhExpEcn+"&reqd="+this.expAnalysisData.NNO2+"&reqecn="+this.expAnalysisData.prs2+"&scfa=%D0%A4%D0%B0%D0%BA%D1%82&start=2021-01-21";

      const responses = await Promise.all([ this.axios.get(uri2), this.axios.get(uri3) ]);


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
      if(data2) {

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


        const responses = await Promise.all([ this.axios.post(uri, jsonData), this.axios.post(uri, jsonData2) ]);
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
      this.axios.get(uri).then((response) => {
          var data = response.data;
          this.method = 'MainMenu'
          if (data["Error"] === "NoData"){
            Vue.prototype.$notifyError("Указанная скважина отсутствует");

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
      );



    },

    postCurveData() {
      this.visibleChart = true;
      console.log()
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
        this.axios.post(uri, jsonData).then((response) => {
          var data = response.data;
          if (data) {
            this.method = "CurveSetting"
            if(data["Well Data"]["pi"][0] * 1 < 0) {
              Vue.prototype.$notifyWarning("Pзаб не должно быть больше чем Рпл")
            } else {
              if(this.hPumpValue.split(' ')[0] > this.hPerf){
                Vue.prototype.$notifyWarning("Насос установлен ниже перфорации")
              }
              this.setData(data)
              this.$emit('LineData', this.curveLineData)
              this.$emit('PointsData', this.curvePointsData)

              console.log(this.qlPot, this.qlCelValue.split(' ')[0], this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);

              if(this.qlPot * 1 < this.qlCelValue.split(' ')[0] * 1 && this.CelButton == 'ql'){
                Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
              } else if(this.bhpPot * 1  > this.bhpCelValue.split(' ')[0] * 1  && this.CelButton == 'bhp'){
                Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
                // console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
              } else if(this.pinPot * 1  > this.piCelValue.split(' ')[0] * 1  && this.CelButton == 'pin'){
                Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
                // console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
              }
            }

          } else {
          }
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
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data)
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
      });
    },

    postAnalysisNew() {
      this.visibleChart = true;
      console.log("POST NEW WELL")
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
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data)
          this.newData = data["Well Data"]
          this.method = "CurveSetting"
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
          this.wctOkr = data["Well Data"]["wct"][0].toFixed(0)
          // this.$emit('LineData', this.curveLineData)
          // this.$emit('PointsData', this.curvePointsData)
        } else {
        }
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
      this.qLInput = this.newData["q_l"][0].toFixed(0)
      this.bhpInput = this.newData["bhp"][0].toFixed(0) + ' атм'
      this.hDynInput = this.newData["h_dyn"][0].toFixed(0) + ' м'
      this.pAnnularInput = this.newData["p_annular"][0].toFixed(0) + ' атм'
      this.pManomInput = this.newData["p_intake"][0].toFixed(0) + ' атм'
      this.hPumpManomInput = this.newData["h_pump_set"][0].toFixed(0) + ' м'
      this.whpInput = this.newData["whp"][0].toFixed(0) + ' атм'
      this.wctInput = this.newData["wct"][0].toFixed(0) + ' %'
      this.qlCelValue = this.newPointsData[0]["q_l"].toFixed(0)
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
      console.log(this.newData)
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
      console.log('mytable');
      this.$modal.hide("modalExpAnalysis");
      this.$modal.show("tablePGNO")
    },

    onPgnoClick() {
      if(this.qlPot * 1 < this.qlCelValue.split(' ')[0] * 1 && this.CelButton == 'ql'){
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
      } else if(this.bhpPot * 1  > this.bhpCelValue.split(' ')[0] * 1  && this.CelButton == 'bhp'){
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
        // console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
      } else if(this.pinPot * 1  > this.piCelValue.split(' ')[0] * 1  && this.CelButton == 'pin'){
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
        // console.log(this.qlPot, this.qlCelValue, this.bhpPot, this.bhpCelValue, this.pinPot, this.piCelValue);
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
      if (val === this.activeRightTabName) {
        this.activeRightTabName = 'technological-mode';
      } else {
        this.activeRightTabName = val;
      }
    },

    downloadImg() {
      $('#btnExport').click(function(){
        //var title = $("<p>Image Here</p>");
        //$("#content").append(title);
        var divGraph = $('#graph');
        Plotly.toImage('graph', { format: 'png', width: 800, height: 600 }).then(function (dataURL) {
          console.log(dataURL);
          img_png.attr("src", dataURL);
        });
      });
    }
  },
};
</script>
<style scoped></style>
