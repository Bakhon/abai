<template>
  <div>
    <div>
      <div class="row">
        <div class="second-column  col-sm-3 order-sm-2">
          <div class=" col-md-12">
            <div class="tables-string-gno  col-12">
              <div class="select-well  col-12"><b>Выбор скважины</b></div>
              <div class="cell4-gno  col-7">Месторождение</div>
              <div class="cell4-gno table-border-gno cell4-gno-second  col-5">
                <select class="select-gno2" v-model="field">
                  <option value="UZN">Узень</option>
                  <option value="KMB">Карамандыбас</option>
                </select>
              </div>
              <div class="cell4-gno table-border-gno-top  col-7">
                Скважина №
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second  col-5"
              >
                <input
                  v-model="wellNumber"
                  type="text"
                  @change="getWellNumber(wellNumber)"
                  class="square2"
                />
              </div>
              <div class="cell4-gno table-border-gno-top  col-7">
                Новая скважина
                <input
                  :checked="age === true"
                  v-model="age"
                  class="checkbox0"
                  type="checkbox"
                />
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second  col-5"
              >
                с ГРП
                <input
                  class="checkbox0"
                  v-model="grp_skin"
                  :disabled="!age"
                  type="checkbox"
                />
              </div>

              <div class="cell4-gno table-border-gno-top  col-7">Горизонт</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second  col-5"
              >
                {{ horizon }}
              </div>

              <div class="cell4-gno table-border-gno-top  col-7">
                Способ эксплуатации
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second  col-5"
              >
                <div class="center">
                  {{ expMeth }}
                </div>
              </div>

              <div class="cell4-gno table-border-gno-top  col-7">
                {{ tseh }}
              </div>
              <div
                class="cell4-gno table-border-gno-top cell4-gno-second  col-5"
              >
                {{ gu }}
              </div>

              <div class="cell4-gno  col-7">
                {{ ngdu }}
              </div>
              <div class="cell4-gno cell4-gno-second  col-5">
                АО "ОМГ"
              </div>
            </div>
            <div class="tables-string-gno1-1">
              <div class="select-well no-gutter col-12"><b>Конструкция</b></div>
              <div class="cell4-gno no-gutter col-7">Наружн. ØЭК</div>
              <div class="cell4-gno table-border-gno cell4-gno-second no-gutter col-5">
                {{ casOD }} мм
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">
                Внутрен. ØЭК
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ casID }} мм
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">
                Нперф.(ВДП м)
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ hPerf }} м
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">
                Удл. на Нперф.
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ udl }} м
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">
                Текущий забой
              </div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ curr }} м
              </div>
            </div>

            <div class="inclinom" @click="InclMenu()">Инклинометрия</div>

            <div class="spoiler">
              <input
                style="width: 845px; height: 35px;"
                type="checkbox"
                tabindex="-1"
              />
              <div class="box">
                <div class="select-well no-gutter col-12">
                  <div class="select-gno-title"><b>Оборудование</b></div>
                </div>
                <span class="closer"
                  ><svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.6569 16.2427L19.0711 14.8285L12.0001 7.75739L4.92896 14.8285L6.34317 16.2427L12.0001 10.5858L17.6569 16.2427Z"
                      fill="currentno-gutter color"
                    /></svg></span
                ><span class="open"
                  ><svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M6.34317 7.75732L4.92896 9.17154L12 16.2426L19.0711 9.17157L17.6569 7.75735L12 13.4142L6.34317 7.75732Z"
                      fill="currentno-gutter color"
                    /></svg
                ></span>

                <blockquote>
                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Станок-качалка
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ sk }}
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Диаметр насоса
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ pumpType }} м
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-7">Нсп</div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ hPumpSet }} м
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Наружн. ØНКТ
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ tubOD }} мм
                  </div>
                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Внутр. ØНКТ
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ tubID }} мм
                  </div>
                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Дата запуска
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ stopDate }}
                  </div>
                </blockquote>
              </div>
            </div>

            <div class="spoiler">
              <input
                style="width: 845px; height: 45px;"
                type="checkbox"
                tabindex="-1"
              />
              <div class="box">
                <div class="select-well no-gutter col-12">
                  <div class="select-gno">PVT</div>
                </div>
                <span class="closer"
                  ><svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.6569 16.2427L19.0711 14.8285L12.0001 7.75739L4.92896 14.8285L6.34317 16.2427L12.0001 10.5858L17.6569 16.2427Z"
                      fill="currentno-gutter color"
                    /></svg></span
                ><span class="open"
                  ><svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M6.34317 7.75732L4.92896 9.17154L12 16.2426L19.0711 9.17157L17.6569 7.75735L12 13.4142L6.34317 7.75732Z"
                      fill="currentno-gutter color"
                    /></svg
                ></span>

                <blockquote>
                  <div class="cell4-gno no-gutter col-7">Рнас</div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-5"
                  >
                    {{ PBubblePoint }} атм
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-7">ГФ</div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ gor }} м³/т
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-7">Т пл</div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ tRes }} ℃
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Вязкость нефти (пл.усл.)
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ viscOilRc }} сПз
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Вязкость воды (пл.усл.)
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ viscWaterRc }} сПз
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Плотность нефти
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ densOil }} г/cм³
                  </div>
                  <div class="cell4-gno table-border-gno-top no-gutter col-7">
                    Плотность воды
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    {{ densWater }} г/cм³
                  </div>
                </blockquote>
              </div>
            </div>

            <div class="tables-string-gno2">
              <div class="select-well no-gutter col-12">Технологический режим</div>
              <div class="cell4-gno no-gutter col-7">Qж</div>
              <div class="cell4-gno table-border-gno cell4-gno-second no-gutter col-5">
                {{ qL }} м3/сут
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">Qн</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ qO }} т/сут
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">Обвод</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ wct }} %
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">Рзаб</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ bhp }} атм
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">Рпл</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ pRes }} ат
              </div>

              <div class="cell4-gno table-border-gno-top no-gutter col-7">Ндин</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ hDyn }} м
              </div>
              <div class="cell4-gno table-border-gno-top no-gutter col-7">Рзат</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ pAnnular }} атм
              </div>
              <div class="cell4-gno table-border-gno-top no-gutter col-7">Рбуф</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ whp }} атм
              </div>
              <div class="cell4-gno table-border-gno-top no-gutter col-7">Рлин</div>
              <div
                class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
              >
                {{ lineP }} атм
              </div>
            </div>
          </div>
        </div>

        <div class="no-gutter col-sm-9 order-sm-1 first-column container-fluid no-gutter">
          <div class="no-gutter col-md-12 background">
            <modal
              name="modalIncl"
              :width="1150"
              :height="500"
              style="background: transparent;"
            >
              <div class="modal-bign">
                <div class="Table" align="center" x:publishsource="Excel">
                  <gno-incl-table
                    :wellNumber="wellNumber"
                    :wellIncl="wellIncl"
                  ></gno-incl-table>
                </div>
              </div>
            </modal>

            <modal
              name="modalOldWell"
              :width="1150"
              :height="450"
              :adaptive="true"
            >
              <div class="modal-bign">
                <Plotly
                  :data="data"
                  :layout="layout"
                  :display-mode-bar="false"
                ></Plotly>
              </div>
              <div class="modal-analysis-menu">
                <div class="form-check">
                  <input
                    v-model="analysisBox1"
                    class="checkbox-modal-analysis-menu"
                    @change="postAnalysisOld()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="checkbox-modal-analysis-menu-label"
                    >Рпл = Рнач</label
                  >
                </div>
                <div class="form-check">
                  <input
                    v-model="analysisBox2"
                    class="checkbox-modal-analysnauryzbekis-menu"
                    @change="postAnalysisOld()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="checkbox-modal-analysis-menu-label"
                    >Н дин = Ндин мин</label
                  >
                </div>
                <div class="form-check">
                  <input
                    v-model="analysisBox3"
                    class="checkbox-modal-analysnauryzbekis-menu"
                    @change="postAnalysisOld()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="checkbox-modal-analysis-menu-label"
                    >Рзаб пот >= 0,75 * Рнас</label
                  >
                </div>
                <div class="form-check">
                  <input
                    v-model="analysisBox4"
                    class="checkbox-modal-analysis-menu"
                    @change="postAnalysisOld()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="checkbox-modal-analysis-menu-label"
                    >Qж = Qж АСМА</label
                  >
                </div>
                <div class="form-check">
                  <input
                    v-model="analysisBox5"
                    class="checkbox-modal-analysis-menu"
                    @change="postAnalysisOld()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="checkbox-modal-analysis-menu-label"
                    >Обв = Обв АСМА</label
                  >
                </div>
                <button
                  type="button"
                  class="old_well_button"
                  @click="setGraphOld()"
                >
                  Применить&nbsp;выполненные корректировки
                </button>
              </div>
            </modal>

            <modal
              name="modalNewWell"
              :width="1150"
              :height="450"
              :adaptive="true"
            >
              <div class="modal-bign">
                <Plotly
                  :data="data"
                  :layout="layout"
                  :display-mode-bar="false"
                ></Plotly>
              </div>
              <div class="modal-analysis-menu">
                <div class="form-check-new">
                  <input
                    v-model="analysisBox6"
                    class="new-checkbox-modal-analysis-menu"
                    @change="postAnalysisNew()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="new-checkbox-modal-analysis-menu-label"
                    >Pпл = P по окр.</label
                  >
                </div>
                <div class="form-check-new">
                  <input
                    v-model="analysisBox7"
                    class="new-checkbox-modal-analysis-menu"
                    @change="postAnalysisNew()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="new-checkbox-modal-analysis-menu-label"
                    >К пр = К по окр.</label
                  >
                </div>
                <div class="form-check-new">
                  <label
                    for="checkbox1"
                    class="new-checkbox-modal-analysis-menu-label"
                    >Обв по окр. =
                  </label>
                  <label for="checkbox1">{{ wctOkr }}%</label>
                </div>
                <div class="form-check-new">
                  <input
                    v-model="analysisBox8"
                    class="new-checkbox-modal-analysis-menu"
                    @change="postAnalysisNew()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="new-checkbox-modal-analysis-menu-label"
                    >Рзаб пот = 0.75 * Рнас</label
                  >
                </div>
                <div class="form-check-new">
                  <input
                    v-model="grp_skin"
                    class="new-checkbox-modal-analysis-menu"
                    @change="postAnalysisNew()"
                    type="checkbox"
                  />
                  <label
                    for="checkbox1"
                    class="new-checkbox-modal-analysis-menu-label"
                    >с ГРП</label
                  >
                </div>
                <button
                  type="button"
                  class="old_well_button"
                  @click="setGraphNew()"
                >
                  Применить&nbsp;выполненные корректировки
                </button>
              </div>
            </modal>

            <modal
              name="modalExpAnalysis"
              :width="1300"
              :height="550"
              :adaptive="true"
              class="chart"
            >
              <div class="nno-modal">
                <h4 class="nno-title">
                  Сравнение технико-экономических показателей за 1 год
                  эксплуатации
                </h4>
                <div class="nno-graph">
                  <gno-chart-bar :data="expAnalysisData"></gno-chart-bar>
                </div>
                <div class="nno-info-button">
                  <div class="nno-icon" @click="onShowTable()">
                    <svg
                      width="31"
                      height="35"
                      viewBox="0 0 31 35"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M15.131 0.290039C6.83973 0.290039 0.117188 6.77814 0.117188 14.7803C0.117188 19.0149 2.00031 22.8253 5.00172 25.4754L3.66936 34.3624L11.2537 28.7829C12.4906 29.1013 13.7903 29.2719 15.131 29.2719C23.4223 29.2719 30.1463 22.7824 30.1463 14.7803C30.1463 6.77814 23.4223 0.290039 15.131 0.290039ZM18.2567 22.7482C17.4838 23.0426 16.8686 23.2656 16.4071 23.4202C15.9471 23.5749 15.4118 23.6521 14.8033 23.6521C13.8676 23.6521 13.1392 23.4316 12.6208 22.9909C12.102 22.5506 11.8441 21.9925 11.8441 21.3142C11.8441 21.0504 11.863 20.7804 11.9015 20.5057C11.9407 20.2306 12.0029 19.9217 12.0881 19.5746L13.0555 16.2768C13.1403 15.9606 13.2141 15.6601 13.2726 15.3803C13.331 15.0979 13.3593 14.8392 13.3593 14.6038C13.3593 14.1843 13.2689 13.8899 13.0898 13.7244C12.9077 13.5584 12.5661 13.4776 12.0564 13.4776C11.8072 13.4776 11.5504 13.5133 11.2872 13.5879C11.0267 13.6654 10.8006 13.7352 10.6151 13.804L10.8703 12.7881C11.5033 12.5392 12.1096 12.3256 12.6879 12.1491C13.2663 11.9698 13.8129 11.8817 14.3279 11.8817C15.2569 11.8817 15.9736 12.1 16.4784 12.5316C16.9806 12.9649 17.2336 13.5278 17.2336 14.2199C17.2336 14.3633 17.2154 14.6162 17.1814 14.9768C17.1468 15.3385 17.082 15.6685 16.9881 15.9716L16.026 19.2594C15.9472 19.5229 15.8771 19.8249 15.8137 20.1622C15.7512 20.4995 15.721 20.7571 15.721 20.93C15.721 21.3666 15.8212 21.665 16.0248 21.8233C16.2254 21.9816 16.5775 22.0612 17.0756 22.0612C17.3108 22.0612 17.5739 22.0205 17.8714 21.9422C18.1662 21.8636 18.3801 21.7938 18.5147 21.7337L18.2567 22.7482ZM18.0863 9.40345C17.6376 9.80588 17.0974 10.0071 16.4656 10.0071C15.8352 10.0071 15.2912 9.80588 14.8388 9.40345C14.3887 9.00138 14.1612 8.51159 14.1612 7.93996C14.1612 7.36978 14.3902 6.87891 14.8388 6.47284C15.2912 6.06567 15.8352 5.86336 16.4656 5.86336C17.0974 5.86336 17.6388 6.06567 18.0863 6.47284C18.5349 6.87891 18.76 7.36978 18.76 7.93996C18.76 8.51304 18.5349 9.00138 18.0863 9.40345Z"
                        fill="#FEFEFE"
                      />
                    </svg>
                  </div>
                </div>

                <button class="button-nno btn-primary" @click="onCompareNpv()">
                  Выбрать способ эксплуатации с более высоким NPV
                </button>
              </div>
            </modal>

            <modal
              name="tablePGNO"
              :width="500"
              :height="550"
              :adaptive="true"
              class="chart"
            >
              <div
                class="tablePgno no-gutter col-13"
                style="width: 100%; height: 100%; overflow-y: auto;"
              >
                <table class="table">
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
              </div>
            </modal>

            <modal
              name="modalPGNO"
              :width="1150"
              :height="400"
              :adaptive="true"
            >
              <div class="modal-bign3"></div>
            </modal>
            <div class="gno-line-chart" v-if="visibleChart">
              <gno-line-points-chart></gno-line-points-chart>
            </div>

            <div class="podbor-gno" v-if="!visibleChart">
              <div class="img-text">
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
              <div class="image-data">
                <img
                  class="podborgnoimg"
                  src="./images/podbor-gno.png"
                  alt="podbor-gno"
                  width="150px"
                  height="435px"
                />
              </div>

              <div class="table-pgno-button">
                <div class="table-pgno-one">
                  <table class="table-pgno">
                    <tr class="tr-pgno" height="10" style="height: 10pt;">
                      <td class="td-pgno" rowspan="1" no-gutter colspan="2">
                        Расчетный режим:
                      </td>
                    </tr>
                    <tbody>
                      <tr>
                        <td class="td-pgno" rowspan="1">Qж</td>
                        <td class="td-pgno" rowspan="1">
                          {{ qlCelValue }} м³/сут
                        </td>
                      </tr>
                      <tr>
                        <td class="td-pgno" rowspan="1">Qн</td>
                        <td class="td-pgno" rowspan="1">{{ qOil }} т/сут</td>
                      </tr>
                      <tr>
                        <td class="td-pgno" rowspan="1">Обв</td>
                        <td class="td-pgno" rowspan="1">{{ wctInput }} %</td>
                      </tr>
                      <tr>
                        <td class="td-pgno" rowspan="1">Рзаб</td>
                        <td class="td-pgno" rowspan="1">
                          {{ bhpCelValue }} ат
                        </td>
                      </tr>
                      <tr>
                        <td class="td-pgno" rowspan="1">Рпр</td>
                        <td class="td-pgno" rowspan="1">{{ piCelValue }} ат</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="table-pgno-two">
                  <table class="table-pgno">
                    <tr class="tr-pgno" height="5px" style="height: 10pt;">
                      <td class="td-pgno" rowspan="1" no-gutter colspan="2">
                        Компоновка:
                      </td>
                    </tr>
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
                        <td class="td-pgno" rowspan="1">{{ hPumpValue }} м</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="table-pgno-four">
                  <table class="table-pgno">
                    <tr class="tr-pgno" height="5px" style="height: 10pt;">
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

          <modal
            name="table"
            :width="1150"
            :height="385"
            :adaptive="true"
          ></modal>
          <br />

            <!--<div class="row">
           <div class="no-gutter col-4">1</div>
           <div class="no-gutter col-4">2</div>
               <div class="no-gutter col-4">3</div>
           </div>-->

          <div class="no-gutter col-md-12 no-gutter col-lg-12 row container-fluid">
            <div class="no-gutter col-md-12 no-gutter col-lg-6 no-gutter container-fluid test1 no-gutter">
              <div class="tables-string-gno4-inner">
                <div class="select-well no-gutter col-12">Настройка кривой притока</div>
                       <div class="no-gutter col-8 relative">
                  <div class="no-gutter col-6">
                    <div class="cell4-gno no-gutter col-4">
                      <span>Рпл</span>
                    </div>
                    <div
                      class="cell4-gno table-border-gno cell4-gno-second no-gutter col-5"
                    >
                      <!-- <input v-model="pResInput" type="text" class="square2" /> -->
                      <input
                        v-model="pResInput"
                        @change="postCurveData()"
                        type="text"
                        class="square2"
                      />
                    </div>

                    <div class="cell4-gno table-border-gno-top no-gutter col-4">
                      <input
                        v-model="curveSelect"
                        class="checkbox"
                        value="pi"
                        type="radio"
                        name="set"
                      />
                      <span>Кпрод</span>
                    </div>
                    <div
                      class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                    >
                      <!-- <input :disabled="curveSelect != 'pi'" v-model="piInput" @ type="string" class="square1" /> -->
                      <input
                        v-model="piInput"
                        :disabled="curveSelect != 'pi'"
                        @change="postCurveData()"
                        type="text"
                        class="square2"
                      />
                    </div>

                    <div class="cell4-gno table-border-gno-top no-gutter col-4">
                      <input
                        v-model="curveSelect"
                        class="checkbox"
                        value="ql"
                        type="radio"
                        name="set"
                      />
                      <span>Qж</span>
                    </div>
                    <div
                      class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                    >
                      <input
                        :disabled="curveSelect == 'pi'"
                        v-model="qLInput"
                        @change="postCurveData()"
                        type="text"
                        class="square2"
                      />
                    </div>
                  </div>
                </div>

                <div class="no-gutter col-4 relative">
                  <div class="cell4-gno no-gutter col-4">
                    <span>Обв.</span>
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-5"
                  >
                    <input
                      v-model="wctInput"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>

                  <div class="cell4-gno table-border-gno-top no-gutter col-4">
                    <span>ГФ.</span>
                  </div>
                  <div
                    class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5"
                  >
                    <input
                      v-model="gorInput"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>
                </div>

                <br />
                <br />

                <div class="no-gutter col-12 relative left-center">
                  <div class="cell4-gno no-gutter col-4 table-border-gno-top">
                    <input
                      v-model="curveSelect"
                      value="bhp"
                      :disabled="curveSelect == 'pi'"
                      class="checkbox2"
                      type="radio"
                      name="set2"
                    />
                    <div class="text2">Рзаб</div>
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  >
                    <input
                      :disabled="curveSelect != 'bhp'"
                      v-model="bhpInput"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  ></div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  ></div>
                </div>

                <div class="no-gutter col-12 relative left-center">
                  <div class="cell4-gno no-gutter col-4 table-border-gno-top">
                    <input
                      v-model="curveSelect"
                      value="hdyn"
                      :disabled="curveSelect == 'pi'"
                      class="checkbox2"
                      type="radio"
                      name="set2"
                    />
                    <div class="text2">Ндин</div>
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  >
                    <input
                      :disabled="curveSelect != 'hdyn'"
                      v-model="hDynInput"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  >
                    Рзат
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  >
                    <input
                      :disabled="curveSelect != 'hdyn'"
                      v-model="pAnnularInput"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>
                </div>

                <div class="no-gutter col-12 relative left-center">
                  <div class="cell4-gno no-gutter col-4 table-border-gno-top">
                    <input
                      v-model="curveSelect"
                      value="pmanom"
                      :disabled="curveSelect == 'pi'"
                      class="checkbox2"
                      type="radio"
                      name="set2"
                    />
                    <div class="text2">Рманом</div>
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  >
                    <input
                      :disabled="curveSelect != 'pmanom'"
                      v-model="pManomInput"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  >
                    Нсп маном
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  >
                    <input
                      :disabled="curveSelect != 'pmanom'"
                      v-model="hPumpManomInput"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>
                </div>

                <div class="no-gutter col-12 relative left-center">
                  <div class="cell4-gno no-gutter col-4 table-border-gno-top">
                    <input
                      v-model="curveSelect"
                      value="whp"
                      :disabled="curveSelect == 'pi'"
                      class="checkbox2"
                      type="radio"
                      name="set2"
                    />
                    <div class="text2">Рбуф (ФЭ)</div>
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  >
                    <input
                      :disabled="curveSelect != 'whp'"
                      v-model="whpInput"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  ></div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2 table-border-gno-top"
                  ></div>
                </div>
              </div>
            </div>
            <div class="no-gutter no-gutter col-md-12 no-gutter col-lg-6 container-fluid test2">
              <div class="tables-string-gno44-inner">
                <div class="select-well no-gutter col-12">Параметры подбора</div>
                <div class="select-well no-gutter col-12">ГНО</div>
                <div class="no-gutter col-12 relative left-center">
                  <div class="cell4-gno no-gutter col-3">
                    <div class="text3">ШГН</div>
                    <input
                      class="checkbox3"
                      value="ШГН"
                      v-model="expChoose"
                      @change="postCurveData()"
                      :checked="expChoose === 'ШГН'"
                      type="radio"
                      name="gno10"
                    />
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2"
                  >
                    <div class="text3">ЭЦН</div>
                    <input
                      class="checkbox3"
                      value="ЭЦН"
                      v-model="expChoose"
                      @change="postCurveData()"
                      :checked="expChoose === 'ЭЦН'"
                      type="radio"
                      name="gno10"
                    />
                  </div>

                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-3"
                  >
                    <div class="text3">Нсп</div>
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2"
                  >
                    <input
                      v-model="hPumpValue"
                      @change="postCurveData()"
                      type="text"
                      class="square2"
                    />
                  </div>
                </div>

                <div class="select-well no-gutter col-12">Целевой параметр</div>
                <div class="no-gutter col-12 relative left-center">
                  <div class="cell4-gno no-gutter col-3">
                    <div class="text3">Qж</div>
                    <input
                      v-model="CelButton"
                      class="checkbox3"
                      value="ql"
                      type="radio"
                      name="gno11"
                    />
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-3"
                  >
                    <div class="target">
                      <input
                        v-model="qlCelValue"
                        @change="postCurveData()"
                        :disabled="CelButton != 'ql'"
                        type="text"
                        class="square2"
                      />
                    </div>
                    <div class="text3">Рзаб</div>
                    <input
                      v-model="CelButton"
                      class="checkbox3"
                      value="bhp"
                      type="radio"
                      name="gno11"
                    />
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-3"
                  >
                    <div class="target">
                      <input
                        v-model="bhpCelValue"
                        @change="postCurveData()"
                        :disabled="CelButton != 'bhp'"
                        type="text"
                        class="square2"
                      />
                    </div>
                    <div class="text3">Pnp</div>
                    <input
                      v-model="CelButton"
                      class="checkbox3"
                      value="pin"
                      type="radio"
                      name="gno11"
                    />
                  </div>
                  <div
                    class="cell4-gno table-border-gno cell4-gno-second no-gutter col-2"
                  >
                    <input
                      v-model="piCelValue"
                      @change="postCurveData()"
                      :disabled="CelButton != 'pin'"
                      type="text"
                      class="square2"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="margin-top no-gutter col-md-12 no-gutter col-lg-12 row">
            <div class="no-gutter no-gutter col-md-12 no-gutter col-lg-6 container-fluid test2">
              <div class="tables-string-gno5 no-gutter col-12" @click="PotAnalysisMenu()">
                Анализ потенциала скважины
              </div>
            </div>
            <div class="no-gutter no-gutter col-md-12 no-gutter col-lg-6 container-fluid test2">
              <div
                class="tables-string-gno55 no-gutter col-12"
                @click="ExpAnalysisMenu()"
              >
                Анализ эффективности способа эксплуатации
              </div>
            </div>

           
              <div
                class="no-gutter col-xs-12 no-gutter col-sm-12 no-gutter col-md-12 no-gutter col-lg-12 no-gutter col-xl-6"
              ></div>

              <div class="tables-string-gno6 no-gutter col-12" @click="onPgnoClick()">
                {{ visibleChart ? "Подбор ГНО" : "Кривая притока" }}
              </div>
            
            <!-- <div class="tables-string-gno6 no-gutter col-12" @click="visibleChart=!visibleChart"> -->

            <notifications position="top"></notifications>
          </div>
        </div>
      </div>
      <br />
      <br />
    </div>
  </div>
</template>
<script src="./Table.js"></script>
<style scoped></style>
