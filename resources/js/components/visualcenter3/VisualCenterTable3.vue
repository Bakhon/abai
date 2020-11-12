<template>
  <div>
    <div class="col-10 left-side">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1">
            <tr>
              <td>
                <div class="nu">
                  <div class="number">430</div>
                  <div class="unit-vc">тонн</div>
                </div>
                <div class="txt1">Добыча нефти</div>
                <br />
                <div class="progress">
                  <br />
                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{
                      width: widthProgress + '%',
                    }"
                    style="width: 25%"
                    aria-valuenow="25"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <br />
                <div class="arrow"></div>
                <div class="txt2">5,2%</div>
                <div class="txt3">vs сентябрь</div>
              </td>
              <td>
                <div class="nu">
                  <div class="number">430</div>
                  <div class="unit-vc">тн</div>
                </div>
                <div class="txt1">Сдача нефти</div>
                <br />
                <div class="progress">
                  <br />
                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{
                      width: widthProgress + '%',
                    }"
                    style="width: 25%"
                    aria-valuenow="25"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <br />
                <div class="arrow"></div>
                <div class="txt2">5,2%</div>
                <div class="txt3">vs сентябрь</div>
              </td>
              <td>
                <div class="nu">
                  <div class="number">430</div>
                  <div class="unit-vc">млрд. м³</div>
                </div>
                <div class="txt1">Добыча газа</div>
                <br />
                <div class="progress">
                  <br />

                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{
                      width: widthProgress + '%',
                    }"
                    style="width: 25%"
                    aria-valuenow="25"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <br />
                <div class="arrow"></div>
                <div class="txt2">5,2%</div>
                <div class="txt3">vs сентябрь</div>
              </td>
              <td
                style="width: 200px; border-left: 10px solid #0f1430"
                @click="changeTable('2')"
                :style="`${tableHover2}`"
              >
                <div class="nu">
                  <div class="number">{{ oilNow }}</div>
                  <div class="unit-vc">$ / bbl</div>
                </div>
                <div class="txt1">Цена на нефть</div>
                <br /><br />
                <div class="arrow"></div>
                <div class="txt2">5,2%</div>
                <div class="txt3">vs сентябрь</div>
              </td>
              <td
                style="width: 200px; border-left: 10px solid #0f1430"
                @click="changeTable('3')"
                :style="`${tableHover3}`"
              >
                <div class="nu">
                  <div class="number">{{ currencyNow }}</div>
                  <div class="unit-vc">kzt / $</div>
                </div>
                <div class="txt1">Курс доллара</div>

                <br /><br />
                <div class="arrow"></div>
                <div class="txt2">5,2%</div>
                <div class="txt3">vs сентябрь</div>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="first-table" :style="`${Table1}`">
        <div class="first-string first-string2">
          <div class="container-fluid">
            <!--class="table-responsive"-->
            <table class="table table2">
              <tr>
                <td class="dropdown3">
                  <input type="checkbox" id="menu" />

                  <div
                    class="button1"
                    :style="`${buttonHover1}`"
                    @click="
                      getProduction(
                        'oil_plan',
                        'oil_fact',
                        ' Добыча нефти',
                        'тн'
                      )
                    "
                  >
                    <!-- <label for="menu">-->
                    <div class="icon-all icons1"></div>
                    <div class="txt5">Добыча нефти</div>
                    <div class="txt6">тыс. тн</div>
                    <!--   </label>-->
                  </div>

                  <!-- <div class="dropdown">-->

                  <ul>
                    <li class="center-li" @click="changeMenu('101')">
                      <a>С учётом доли участия КМГ</a>

                      <div
                        class="square-small2"
                        :style="`${changeMenuButton1}`"
                      >
                        &#10003;
                      </div>
                    </li>
                  </ul>
                </td>
                <td class="dropdown3">
                  <div
                    class="button1"
                    :style="`${buttonHover2}`"
                    @click="
                      getProduction(
                        'oil_dlv_plan',
                        'oil_dlv_fact',
                        'Сдача нефти',
                        'тн'
                      )
                    "
                  >
                    <div class="icon-all icons2"></div>
                    <div class="txt5">Сдача нефти</div>
                    <div class="txt6">тыс. тонн</div>
                  </div>

                  <ul>
                    <li class="center-li" @click="changeMenu('102')">
                      <a>Сдача нефти по узлам учёта</a>
                      <div
                        class="square-small2"
                        :style="`${changeMenuButton2}`"
                      >
                        &#10003;
                      </div>
                    </li>

                    <li class="center-li" @click="changeMenu('103')">
                      <a>Товарный остаток нефти</a>
                      <div
                        class="square-small2"
                        :style="`${changeMenuButton3}`"
                      >
                        &#10003;
                      </div>
                    </li>
                  </ul>
                </td>
                <td class="dropdown3">
                  <div
                    class="button1"
                    :style="`${buttonHover3}`"
                    @click="
                      getProduction(
                        'gas_plan',
                        'gas_fact',
                        'Добыча газа',
                        'тыс м³'
                      )
                    "
                  >
                    <div class="icon-all icons3"></div>
                    <div class="txt5">Добыча газа</div>
                    <div class="txt6">млрд. м³</div>
                  </div>
                  <ul>
                    <li class="center-li">
                      <a href> Сдача природного газа</a>
                    </li>
                    <li class="center-li">
                      <a href>Расход природного газа на собственные нужды </a>
                    </li>
                    <li class="center-li">
                      <a href>Переработка природного газа</a>
                    </li>
                    <li class="center-li"><a href>Сдача попутного газа </a></li>
                    <li class="center-li">
                      <a href>Расход попутного газа на собственные нужды </a>
                    </li>
                    <li class="center-li">
                      <a href> Переработка попутного газа </a>
                    </li>
                  </ul>
                </td>
                <td class="dropdown3">
                  <div
                    class="button1"
                    :style="`${buttonHover5}`"
                    @click="
                      getProduction(
                        'gk_plan',
                        'gk_fact',
                        'Добыча конденсата',
                        'тн'
                      )
                    "
                  >
                    <div class="icon-all icons4"></div>
                    <div class="txt5">Добыча конденсата</div>
                    <div class="txt6">тыс. тонн</div>
                  </div>
                  <ul>
                    <li class="center-li">
                      <a href>С учётом доли участия КМГ</a>
                    </li>
                  </ul>
                </td>
                <td class="dropdown3">
                  <div
                    class="button1"
                    :style="`${buttonHover6}`"
                    @click="
                      getProduction(
                        'inj_plan',
                        'inj_fact',
                        'Объём закачки',
                        'м³'
                      )
                    "
                  >
                    <div class="icon-all icons5"></div>
                    <div class="txt5">Объём закачки воды</div>
                    <div class="txt6">тыс. м³</div>
                  </div>
                  <ul>
                    <li class="center-li"><a href> Закачка морской воды</a></li>
                    <li class="center-li"><a href>Закачка сточной воды</a></li>
                    <li class="center-li"><a href>Закачка альбсен. воды</a></li>
                  </ul>
                </td>
              </tr>
            </table>
          </div>

          <div class="container-fluid">
            <table class="table table2">
              <tr>
                <td>
                  <div class="button2">Суточная</div>
                </td>
                <td>
                  <div class="button2">С начала месяца</div>
                </td>
                <td>
                  <div class="button2">С начала года</div>
                </td>
                <td class="dropdown3">
                  <div class="button2" @click="pushBign('bign1')">
                    Календарь
                  </div>
                  <ul class="center-menu2">
                    <li class="center-li">                
                      <div
                        class="calendar-tab"
                        v-for="(menuDMY, index) in menuDMY()"
                        @click="selectedDMY = menuDMY.id"
                        :style="{
                          'background-color': menuDMY.current,
                        }"
                      >
                        {{ menuDMY.DMY }}
                      </div>
<br><br>
                        <date-picker
                        mode="range"
                        v-model="range"
                        is-range
                        class="m-auto"
                        :model-config="modelConfig"
                        @input="changeDate"
                      />

                     <!-- <div class="month-day">
                        <div
                          class="navigation-table"
                          v-bind:style="{ display: display }"
                        >
                          <div class="navigation">
                            <div v-on:click="decrease"><</div>
                          </div>
                          <div class="navigation-month navigation" colspan="5">
                            {{ monthes[month] }} {{ year }}
                          </div>
                          <div class="navigation">
                            <div v-on:click="increase">></div>
                          </div>
                        </div>
                        <div style="clear: both"></div>
                        <div
                          class="calendar-days"
                          v-bind:style="{ display: display }"
                        >
                          <div class="day" v-for="d in day">{{ d }}</div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="calendar-day">
                          <div v-for="week in calendar()">
                            <div
                              @click="selectedDay = day.index"
                              class="week"
                              v-for="(day, index) in week"
                              :style="{
                                color: day.weekend,
                                'background-color': day.current,
                              }"
                              v-on:click="displaynumbers"
                            >
                              <div class="day-begin">{{ day.index }}</div>
                            </div>
                          </div>
                          <div
                            class="week"
                            v-for="(month, index) in getMonths()"
                            :key="index.id"
                            :style="{
                              'background-color': month.current,
                            }"
                            @click="selectedMonth = month.index"
                            v-on:click="displaynumbers"
                          >
                            {{ month.index }}
                          </div>

                          <div
                            class="week"
                            v-for="(year, index) in getYears()"
                            :key="year.id"
                            :style="{
                              'background-color': year.current,
                            }"
                            @click="selectedYear = year.index"
                            v-on:click="displaynumbers"
                          >
                            {{ year.index }}
                          </div>
                        </div>
                      </div>-->
                    </li>
                  </ul>
                </td>
              </tr>
            </table>
          </div>

          <div class="container-fluid" :style="`${displayTable}`">
            <table class="table table4">
              <tbody>
                <tr>
                  <td class="big-table-hidtd small-td"></td>
                  <td class="big-table-hidtd small-td"></td>

                  <td class="small-td">
                    <div class="center">план</div>
                  </td>
                  <td class="small-td">
                    <div class="center">факт</div>
                  </td>
                  <td class="small-td">
                    <div class="center">+/-</div>
                  </td>
                  <td class="small-td"><div class="center">%</div></td>
                </tr>

                <tr v-for="(item, index) in tables">
                  <td
                    @click="saveCompany(item.dzoBriefly)"
                    :class="
                      index % 2 === 0 ? 'tdStyle first-td' : 'tdNone first-td'
                    "
                  >
                    {{ item.dzo }}
                  </td>
                  <td class="w-50"></td>

                  <td
                    :class="index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'"
                  >
                    <div>
                      {{ new Intl.NumberFormat("ru-RU").format(item.pla) }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                    <div>
                      {{ new Intl.NumberFormat("ru-RU").format(item.fact) }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td
                    :class="index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'"
                  >
                    <div
                      v-if="item.fact"
                      class="triangle"
                      :style="`border-top: 10px solid ${getColor(
                        item.fact - item.plan
                      )}`"
                    ></div>
                    <div class="percent">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          item.fact - item.plan
                        )
                      }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                    <div
                      v-if="item.fact"
                      class="triangle"
                      :style="`border-top: 10px solid ${getColor(
                        item.fact - item.plan
                      )}`"
                    ></div>
                    <div class="percent">5,2%</div>
                  </td>
                </tr>

                <!--  <tr>
                <td colspan="13">1</td>
              </tr>

              <tr>
                <td>2</td>
              </tr>

              <tr>
                <td colspan="13">3</td>
              </tr>-->

                <tr>
                  <td
                    :class="
                      index % 2 === 0
                        ? 'tdStyle3-total first-td'
                        : 'tdNone first-td'
                    "
                  >
                    Итого по операционным активам:
                  </td>
                  <td>
                    <div class="vc-chart"><vc-chart> </vc-chart></div>
                  </td>

                  <td
                    :class="index % 2 === 0 ? 'tdStyleLight3' : 'tdStyleLight2'"
                  >
                    <div>
                      {{ new Intl.NumberFormat("ru-RU").format(planDaySumm) }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                    <div>
                      {{ new Intl.NumberFormat("ru-RU").format(factDaySumm) }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td
                    :class="index % 2 === 0 ? 'tdStyleLight3' : 'tdStyleLight2'"
                  >
                    <div
                      v-if="factDaySumm"
                      class="triangle"
                      :style="`border-top: 10px solid ${getColor(
                        factDaySumm - planDaySumm
                      )}`"
                    ></div>
                    <div class="percent">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          factDaySumm - planDaySumm
                        )
                      }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                    <div
                      v-if="factDaySumm"
                      class="triangle"
                      :style="`border-top: 10px solid ${getColor(
                        factDaySumm - planDaySumm
                      )}`"
                    ></div>
                    <div class="percent">5,2%</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="container-fluid" :style="`${displayHeadTables}`">
            <table class="table table4">
              <tbody>
                <tr>
                  <td class="big-table-hidtd small-td"></td>
                  <td class="big-table-hidtd small-td"></td>

                  <td class="small-td">
                    <div class="center">план</div>
                  </td>
                  <td class="small-td">
                    <div class="center">факт</div>
                  </td>
                  <td class="small-td">
                    <div class="center">+/-</div>
                  </td>
                  <td class="small-td"><div class="center">%</div></td>
                </tr>

                <tr v-for="(item, index) in bigTable">
                  <td
                    @click="saveCompany(item.dzoBriefly)"
                    :class="
                      index % 2 === 0 ? 'tdStyle first-td' : 'tdNone first-td'
                    "
                  >
                    {{ item.dzoDay }}
                  </td>
                  <td class="w-50"></td>

                  <td
                    :class="index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'"
                  >
                    <div>
                      {{ new Intl.NumberFormat("ru-RU").format(item.planDay) }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                    <div>
                      {{ new Intl.NumberFormat("ru-RU").format(item.factDay) }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td
                    :class="index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'"
                  >
                    <div
                      v-if="item.factDay"
                      class="triangle"
                      :style="`border-top: 10px solid ${getColor(
                        item.factDay - item.planDay
                      )}`"
                    ></div>
                    <div class="percent">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          item.factDay - item.planDay
                        )
                      }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                    <div
                      v-if="item.factDay"
                      class="triangle"
                      :style="`border-top: 10px solid ${getColor(
                        item.factDay - item.planDay
                      )}`"
                    ></div>
                    <div class="percent">5,2%</div>
                  </td>
                </tr>

                <!--  <tr>
                <td colspan="13">1</td>
              </tr>

              <tr>
                <td>2</td>
              </tr>

              <tr>
                <td colspan="13">3</td>
              </tr>-->

                <tr>
                  <td
                    :class="
                      index % 2 === 0
                        ? 'tdStyle3-total first-td'
                        : 'tdNone first-td'
                    "
                  >
                    Итого по операционным активам:
                  </td>
                  <td>
                    <div class="vc-chart"><vc-chart> </vc-chart></div>
                  </td>

                  <td
                    :class="index % 2 === 0 ? 'tdStyleLight3' : 'tdStyleLight2'"
                  >
                    <div>
                      {{ new Intl.NumberFormat("ru-RU").format(planDaySumm) }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                    <div>
                      {{ new Intl.NumberFormat("ru-RU").format(factDaySumm) }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td
                    :class="index % 2 === 0 ? 'tdStyleLight3' : 'tdStyleLight2'"
                  >
                    <div
                      v-if="factDaySumm"
                      class="triangle"
                      :style="`border-top: 10px solid ${getColor(
                        factDaySumm - planDaySumm
                      )}`"
                    ></div>
                    <div class="percent">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          factDaySumm - planDaySumm
                        )
                      }}
                      <div class="right">{{ item4 }}</div>
                    </div>
                  </td>
                  <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                    <div
                      v-if="factDaySumm"
                      class="triangle"
                      :style="`border-top: 10px solid ${getColor(
                        factDaySumm - planDaySumm
                      )}`"
                    ></div>
                    <div class="percent">5,2%</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="second-table" :style="`${Table2}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">x</div>
          <div class="big-area">
            <br />

            <div
              @click="selectedDMY = menuDMY.id"
              class="period"
              v-for="(menuDMY, index) in periodSelectFunc()"
              :style="{
                color: menuDMY.current,
              }"
              v-on:click="periodSelect"
            >
              <div>{{ menuDMY.DMY }}</div>
            </div>
            <visual-center-chart-area-oil3></visual-center-chart-area-oil3>
          </div>
        </div>
      </div>

      <div class="third-table" :style="`${Table3}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">x</div>
          <div class="big-area">
            <br />

            <div
              @click="selectedDMY2 = menuDMY.id"
              class="period"
              v-for="(menuDMY, index) in periodSelectFunc()"
              :style="{
                color: menuDMY.current2,
              }"
              v-on:click="periodSelectUSD"
            >
              <div>{{ menuDMY.DMY }}</div>
            </div>
            <visual-center-chart-area-usd3></visual-center-chart-area-usd3>
          </div>
        </div>
      </div>

      <div class="third-table" :style="`${Table4}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">x</div>
          <div class="big-area">Фонд добывающих скважин</div>
        </div>
      </div>

      <div class="third-table" :style="`${Table5}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">x</div>
          <div class="big-area">Фонд нагнетательных скважин</div>
        </div>
      </div>

      <div class="third-table" :style="`${Table6}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">x</div>
          <div class="big-area">ОТМ</div>
        </div>
      </div>

      <div class="third-table" :style="`${Table7}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">x</div>
          <div class="big-area">Химизация</div>
        </div>
      </div>
    </div>
    <div class="col-2 right-side2">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1-2">
            <tr>
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt4">{{ wells2[0].prod_wells_work }}</div>
                <div class="in-work">В работе</div>
                <div class="arrow"></div>
                <div class="txt2">48</div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt4">{{ wells2[0].prod_wells_idle }}</div>
                <div class="in-idle">В простое</div>
                <div class="arrow"></div>
                <div class="txt2">200</div>
                <br />
              </td>
            </tr>
            <tr>
              <td
                colspan="2"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt2">Фонд добывающих скважин</div>
              </td>
            </tr>
          </table>
          <!-- <div class="line-bottom"></div>-->
        </div>
        <div class="first-string first-string2">
          <div class="table-responsive">
            <table class="table table1-2">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt4">{{ wells[0].inj_wells_work }}</div>
                  <div class="in-work">В работе</div>
                  <div class="arrow"></div>
                  <div class="txt2">48</div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt4">{{ wells[0].inj_wells_work }}</div>
                  <div class="in-idle">В простое</div>
                  <div class="arrow"></div>
                  <div class="txt2">200</div>
                  <br />
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt2">Фонд нагнетательных скважин</div>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="first-string first-string2">
          <div class="table-responsive">
            <table class="table table5">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('6')"
                  :style="`${tableHover6}`"
                >
                  <div class="otm"></div>
                  <div class="txt2">ОТМ</div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('7')"
                  :style="`${tableHover7}`"
                >
                  <div class="him"></div>
                  <div class="txt2">Химизация</div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">908</div>
              </td>

              <td class="w-65">
                <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">7</div>
                </div>
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Численность персонала</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">24</div>
              </td>

              <td class="w-65">
                <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">11</div>
                </div>
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">COVID-19</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="w-50">
                <div class="number">11</div>
                <div class="near-number">
                  <div class="column-1">
                    <div class="arrow"></div>
                    <div class="txt2">7</div>
                  </div>
                  <div class="column-1">
                    <div class="in-idle">Прирост</div>
                    <div class="in-idle">с начала</div>
                    <div class="in-idle">месяца</div>
                  </div>
                </div>
              </td>

              <td class="w-50">
                <div class="number">11</div>
                <div class="near-number">
                  <div class="column-1">
                    <div class="arrow"></div>
                    <div class="txt2">7</div>
                  </div>
                  <div class="column-1">
                    <div class="in-idle">Прирост</div>
                    <div class="in-idle">с начала</div>
                    <div class="in-idle">месяца</div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Несчастные случаи</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">2</div>
              </td>

              <td class="w-65">
                <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">1</div>
                </div>
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Смертельные случаи</div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script src="./VisualCenterTable3.js"></script>